<?php

function rbsvgi_get_grouped_types() {
	return array('group', 'media', 'taxonomy', 'fields');
}

function rbsvgi_fillMbAttributes($meta, &$attr, $prefix = '') {
	foreach ($meta as $k => $v) {
			$entry = !empty($prefix) ? $prefix . "[$k]" : $k;
		$attr_k = &$attr[$k];
			if ($attr_k) {
				switch ($attr_k['type']) {
					case 'text':
					case 'number':
					case 'textarea':
					case 'datetime':
					case 'gallery':
						$attr_k['value'] = htmlentities(stripslashes($v));
						break;
					case 'media':
						if (isset($attr_k['layout'])) {
						rbsvgi_fillMbAttributes($v, $attr_k['layout'], $k);
						}
						$attr_k['value'] = $v;
						break;
					case 'radio':
						if (is_array($attr_k['value'])) {
							foreach ($attr_k['value'] as $key => $val) {
								if ($key == $v) {
									$attr_k['value'][$key][1] = true;
								} else {
									$attr_k['value'][$key][1] = false;
								}
							}
						}
						break;
					case 'checkbox':
						$atts = '';
						if (isset($attr_k['atts'])) {
							$atts = $attr_k['atts'];
						}
						if ('on' === $v || '1' === $v) {
							$atts .= ' checked';
							$attr_k['atts'] = $atts;
						} else {
							$attr_k['atts'] = str_replace('checked', '', $atts);
						}
						break;
					case 'group':
						if (!empty($v)) {
							$attr_k['value'] = $v;
						}
						break;
					case 'dimensions':
					case 'margins':
						foreach ($v as $key => $value) {
							if (isset($attr_k['value'][$key])) {
								$attr_k['value'][$key]['value'] = $value;
							}
						}
						break;
					case 'font':
						foreach ($v as $key => $value) {
							$attr_k['value'][$key] = $value;
						}
						break;
					case 'select':
					case 'taxonomy':
						if (is_array($attr_k['source']) && !empty($v)) {
							foreach ($attr_k['source'] as $key => $value) {
								$attr_k['source'][$key][1] = false; // reset all
							}
							if (is_array($v)) {
								foreach ($v as $key => $value) {
									$attr_k['source'][$value][1] = true;
								}
							} else {
								$attr_k['source'][$v][1] = true;
							}
						} else {
							$attr_k['source'] .= ' ' . $v;
						}
						break;
					case 'fields':
						rbsvgi_fillMbAttributes($v, $attr_k['layout'], $prefix);
						break;
					default:
						break;
				}
			}
		}
	}

function &rbsvgi_find_array_keys(&$attr, $key) {
	$ret = null;
	$non_grouped = rbsvgi_get_grouped_types();
	if (isset($attr[$key]) && !in_array($attr[$key]['type'], $non_grouped)) {
		$ret = &$attr[$key];
	} else {
		foreach ($attr as $k=>&$value) {
			if (isset($value['layout'][$key])) {
				$ret = &$value['layout'][$key];
				break;
			}
		}
	}
	return $ret;
}

/* straighten up our array, filling the references */
function rbsvgi_build_array_keys(&$attr) {
	$ret = array();
	foreach ($attr as $section => &$value) {
		$first_element = reset($value['layout']);
		if ('tab' === $first_element['type']) {
			foreach ($value['layout'] as $tabs => &$val) {
				foreach ($val['layout'] as $k => &$v) {
					$ret[$k] = &$v;
				}
			}
		} else {
			foreach ($value['layout'] as $k => &$v) {
				$ret[$k] = &$v;
			}
		}
	}
	return $ret;
}

function rbsvgi_print_layout ($layout, $prefix, &$values = null) {
	$out = '';
	$isTabs = false;
	$isCustomizer = is_customize_preview();
	$tabs = array();
	$bIsWidget = '[' === substr($prefix, -1);
	$tabs_idx = 0;

	foreach ($layout as $key => $v) {
		if (isset($v['customizer']) && !$v['customizer']['show'] && $isCustomizer) continue;
		if ($bIsWidget && empty($v)) continue;
		$row_classes = isset($v['rowclasses']) ? $v['rowclasses'] : 'row row_options ' . $key;
		$row_classes = isset($v['addrowclasses']) ? $row_classes . ' ' . $v['addrowclasses'] : $row_classes;

		$row_atts = isset($v['row_atts']) ? ' ' . $v['row_atts'] : '';

		$row_atts = $v['type'] === 'media' ? $row_atts . ' data-role="media"' : $row_atts;

		if ($values && !empty($v['value']) ) {
			$values[$key] = $v['value'];
		}

		if ($bIsWidget) {
			$a = strpos($key, '[');
			if (false !== $a) {
				$name = substr($key, 0, $a) . ']' . substr($key, $a, -1) . ']';
			} else {
				$name = $key . ']';
			}
		} else {
			$name = $key;
		}
		if ('module' !== $v['type'] && 'tab' !== $v['type']) {
			$out .= '<div class="' . $row_classes . '"' . $row_atts . '>';
			if (isset($v['title'])) {
				$out .= '<label for="' . $prefix . $name . '">' . $v['title'] . '</label>';
				if (isset($v['tooltip']) && is_array($v['tooltip']) ) {
					$out .= '<div class="rbfw-qtip dashicons-before" title="' . $v['tooltip']['title'] . '" qt-content="'.$v['tooltip']['content'].'">';
					$out .= '</div>';
				}
			}
			$out .= "<div>";
		}

		$value = isset($v['value']) && !is_array($v['value']) ? ' value="' . $v['value'] . '"' : '';
		$atts = isset($v['atts']) ? ' ' . $v['atts'] : '';
		switch ($v['type']) {
			case 'text':
			case 'number':
				$ph = isset($value['placeholder']) ? ' placeholder="' . $value['placeholder'] . '"' : '';
				$out .= '<input type="'. $v['type'] .'" name="'. $prefix . $name .'"' . $value . $atts . $ph . '>';
				break;
			case 'info':
				$subtype = isset($v['subtype']) ? $v['subtype'] : 'info';
				$out .= '<div class="'. $subtype .'">';
				if (isset($v['icon']) && is_array($v['icon'])) {
					$out .= '<div class="info_icon">';
					switch ($v['icon'][0]) {
						case 'fa':
							$out .= "<i class='fa fa-2x fa-{$v['icon'][1]}'></i>";
							break;
					}
					$out .= '</div>';
				}
				$out .= '<div class="info_desc">';
				$out .= $v['value'];
				$out .= '</div>';
				$out .= '<div class="clear"></div>';
				$out .= '</div>';
				break;
			case 'checkbox':
				$value = ' value="1"';
				if (!empty($atts) && false !== strpos($atts, 'checked')) {
					$values[$key] = '1';
				} else {
					$values[$key] = '0';
				}
				$out .= '<input type="hidden" name="'. $prefix . $name .'" value="0">';
				$out .= '<input type="'. $v['type'] .'" name="'. $prefix . $name .'" id="' . $prefix . $name . '"' . $value . $atts . '>';
				$out .= '<label for="' . $prefix . $name . '"></label>';
				break;
			case 'radio':
				$radio_cols = isset($v['cols']) ? (int)$v['cols'] : 0;
				if (isset($v['subtype']) && 'images' === $v['subtype']) {
					$out .= '<ul class="rb_image_select">';
					foreach ($v['value'] as $k => $value) {
						$selected = '';
						if (isset($value[1]) && true === $value[1]) {
							$selected = ' checked';
							$values[$key] = $k;
						}
						$out .= '<li class="image_select' . $selected . '">';
						$out .= '<div class="rb_img_select_wrap">';
						$out .= '<img src="' . $value[3] . '" alt="image"/>';
						$data_options = !empty($value[2]) ? ' data-options="' . $value[2] . '"' : '';
						$out .= '<input type="'. $v['type'] .'" name="'. $prefix. $name . '" value="' . $k . '" title="' . $k . '"' .  $data_options . $selected . '>' . $value[0] . '<br/>';
						$out .= '</div>';
						$out .= '</li>';
					}
					$out .= '<div class="clear"></div>';
					$out .= '</ul>';
				} else {
					$i = 0;
					foreach ($v['value'] as $k => $value) {
						$selected = '';
						if (isset($value[1]) && true === $value[1]) {
							$selected = ' checked';
							$values[$key] = $k;
						}
						$data_options = !empty($value[2]) ? ' data-options="' . $value[2] . '"' : '';
						$out .= '<input type="'. $v['type'] .'" name="'. $prefix. $name . '" value="' . $k . '" title="' . $k . '"' .  $data_options . $selected . '>' . $value[0];
						$i++;
						if ($radio_cols && $i === $radio_cols) {
							$out .= '<br/>';
							$i = 0;
						}
					}
				}
				break;
			case 'insertmedia':
				$out .= '<div class="rb_tmce_buttons">';
				$out .= 	'<a href="#" id="insert-media-button" class="button insert-media add_media" title="Add Media"><span class="wp-media-buttons-icon"></span> Add Media</a>';
				$out .= 	'<div class="rb_tmce_controls">';
				$out .= 	'<a href="#" id="rb-switch-text" class="button" data-editor="content" data-mode="tmce" title="Switch to Text">Switch to Text</a>';
				$out .= '</div></div>';
				break;
			case 'fields':
				$out .= '<div class="rbsvgi_fields">';
				$values[$key] = array();
				$out .= rbsvgi_print_layout( $v['layout'], $prefix . $name . '[', $values[$key] ); // here would be a template stored
				$out .= '</div>';
				break;
			case 'group':
				if (isset($v['value'])) {
					$out .= '<script type="text/javascript">';
					$out .= 'if(undefined===window[\'rb_groups\']){window[\'rb_groups\']={};}';
					$out .= 'window[\'rb_groups\'][\'' . $key .'\']=\'' . json_encode($v['value']) . '\';';
					$out .= '</script>';
				}
				$out .= '<textarea class="rbsvgi_group" style="display:none" data-key="'.$key.'" data-templ="group_template">';
				$out .= rbsvgi_print_layout( $v['layout'], $prefix . $name . '[%d][', $values ); // here would be a template stored
				$out .= '</textarea>';
				$out .= '<ul class="groups"></ul>';
				if (isset($v['button_title'])) {
					$out .= '<button type="button" name="'.$key.'">'. $v['button_title'] .'</button>';
				}
				break;
			case 'dimensions':
			case 'margins':
				$out .= '<fieldset class="rbsvgi_'. $v['type'] .'">';
				foreach ($v['value'] as $k => $value) {
					$out .= '<input type="text" name="'. $prefix . $name .'['.$k.']" value="' . $value['value'] .'" placeholder="' . $value['placeholder'] . '"' . $atts . '>';
					$values[$key][$k] = $value['value'];
				}
				$out .= '</fieldset>';
				break;
			case 'tab':
				$isTabs = true;
				$tabs[$tabs_idx] = array(
					'tab' => $key,
					'title' => $v['title'],
					'active' => (isset($v['init']) && $v['init'] === 'open'),
					'icon' => isset($v['icon']) ? $v['icon'] : '');
				$tabs_idx++;
				$out .= '<div class="rb_form_tab' . (isset($v['init']) ?  ' ' . $v['init'] : ' closed' ). '" data-tabkey="'.$key.'">';
				$out .= rbsvgi_print_layout( $v['layout'], $prefix, $values );
				$out .= '</div>';
				break;
			case 'textarea':
				$out .= '<textarea name="'. $prefix . $name .'"' . $atts . '>' . (isset($v['value']) ? $v['value'] : '') . '</textarea>';
				break;
			case 'button':
				$out .= '<button type="button" name="'. $prefix . $name .'"' . $atts . '>' . (isset($v['btitle']) ? $v['btitle'] : '') . '</button>';
				break;
			case 'buttons':
				if (!empty($v['source'])) {
					$out .= isset($v['header']) ? $v['header'] : '';
					foreach ($v['source'] as $key => $value) {
						$b_atts = !empty($value['atts']) ? ' ' . $value['atts'] : '';
						$out .= '<button type="button" name="'. $prefix . $name . '-' . $key . '"  id="'. $prefix . $name . '-' . $key . '"' . $b_atts . '>' . (isset($value['title']) ? $value['title'] : '') . '</button>&nbsp;';
					}
				}
				break;
			case 'taxonomy':
				$taxonomy = isset($v['taxonomy']) ? $v['taxonomy'] : '';
				$ismul = (false !== strpos($atts, 'multiple'));
				$out .= '<select name="'. $prefix . $name . ($ismul ? '[]':''). '"' . $atts . '>';
				$out .= rbsvgi_print_taxonomy($taxonomy, $v['source']);
				$out .= '</select>';
				break;
			case 'input_group':
				$out .= '<fieldset class="' . $key . '">';
				$source = $v['source'];
				foreach ($source as $key => $value) {
					$out .= sprintf('<input type="%s" id="%s" name="%s" placeholder="%s" value="%s">', $value[0], $prefix.$name.'-'.$key, $prefix.$name.'-'.$key, $value[1], $value[2]);
					if (!empty($value[3])) {
						$out .= $value[3];
					}
				}
				$out .= '</fieldset>';
				break;
			case 'select':
				if (false !== strpos($atts, 'multiple') ) {
					$name .= '[]';
				}
				$is_select_editable = isset($v['subtype']) && $v['subtype'] === 'editable';
				if ($is_select_editable) {
					$out .= '<select ' . $atts . ' data-options="select:options">';
				} else {
					$out .= '<select name="'. $prefix . $name .'"' . $atts . ' data-options="select:options">';
				}
				if (!empty($v['source'])) {
					$source = $v['source'];
					if ( is_string($source) ) {
						if (strpos($source, ' ') !== false) {
							list($func, $arg0) = explode(' ', $source);
						} else {
							$arg0 = '';
							$func = $source;
						}
						$out .= call_user_func_array('rbsvgi_print_' . $func, array($arg0) );
					}
					else {
						foreach ($source as $k => $value) {
							$selected = '';
							if (isset($value[1]) && true === $value[1]) {
								$selected = ' selected';
								$values[$key] = $k;
							}
							$data_options = !empty($value[2]) ? ' data-options="' . $value[2] . '"' : '';
							$out .= '<option value="' . $k . '"' . $data_options . $selected .'>' . $value[0] . '</option>';
						}
					}
				}
				$out .= '</select>';
				if ($is_select_editable) {
					$out .= '<input type="text" name="'. $prefix . $name .'">';
				}
				break;
			case 'media':
				$isValueSet = !empty($v['value']['src']);
				$display_none = ' style="display:none"';
				$out .= '<div class="img-wrapper">';
				$out .= '<img src'. ($isValueSet ? '="'.$v['value']['src'] . '"' : '') .'/>';
				$url_atts = !empty($v['url-atts']) ? ' ' . $v['url-atts'] : ' readonly type="hidden"';
				$out .= '<input class="widefat" data-key="img"' . $url_atts . ' id="' . $prefix . $name . '" name="' . $prefix . $name . '[src]" value="' . ($isValueSet ? $v['value']['src']:'') . '" />';
				$out .= '<a class="pb-media-rb-pb"'. ($isValueSet ? $display_none : '') .'>'. esc_html__('Select', 'rb-svgi') . '</a>';
				$out .= '<a class="pb-remov-rb-pb"'. ($isValueSet ? '' : $display_none) .'>' . esc_html__('Remove', 'rb-svgi') . '</a>';
				$out .= '<input class="widefat" data-key="img-id" readonly id="' . $prefix . $name . '[id]" name="' . $prefix . $name . '[id]" type="hidden" value="'.($isValueSet ? $v['value']['id']:'').'" />';
				if (isset($v['layout'])) {
					$out .= '<div class="media_supplements">';
					$out .=	rbsvgi_print_layout( $v['layout'], $prefix . $name . '[' );
					$out .= '</div>';
				}
				$out .= '</div>';
				break;
			case 'gallery':
				$isValueSet = !empty($v['value']);
				$out .= '<div class="img-wrapper">';
				$out .= '<a class="pb-gmedia-rb-pb">'. esc_html__('Select', 'rb-svgi') . '</a>';
				$out .= '<input class="widefat" data-key="gallery" readonly id="' . $prefix . $name . '" name="' . $prefix . $name . '" type="hidden" value="' . ($isValueSet ? esc_attr($v['value']):'') . '" />';
				if ($isValueSet) {
					$g_value = htmlspecialchars_decode($v['value']); // shortcodes should be un-escaped
					$ids = shortcode_parse_atts($g_value);
					if (strpos($ids[1], 'ids=') === 0) {
						preg_match_all('/\d+/', $ids[1], $match);
						if (!empty($match)) {
							$out .= '<div class="rb_gallery">';
							foreach ($match[0] as $k => $val) {
								$out .= '<img src="' . wp_get_attachment_url($val) . '">';
							}
							$out .= '<div class="clear"></div></div>';
						}
					}
				}
				$out .= '</div>';
				break;
		}
		if (isset($v['description'])) {
			$out .= '<div class="description">' . $v['description'] . '</div>';
		}
		if ('module' !== $v['type'] && 'tab' !== $v['type'] ) {
			$out .= "</div>";
			$out .= '</div>';
		}
	}
	if ($isTabs) {
		$out .= '<div class="clear"></div>';
		$tabs_out = '<div class="rb_pb_ftabs">';
		foreach ($tabs as $key => $v) {
			if (is_array($v['icon'])) {
				$icon = sprintf('<i class="%s %s-%s"></i>', $v['icon'][0], $v['icon'][0], $v['icon'][1]);
			} else {
				// direct link
				$icon = '<span></span>';
			}
			$tabs_out .= '<a href=# data-tab="'. $v['tab'] .'" class="' . ($v['active'] ? 'active' : '') .'">' . $icon . $v['title'] . '</a>';
		}
		$tabs_out .= '<div class="clear"></div></div>';
		$out = $tabs_out . $out;
	}
	return $out;
}

function rbsvgi_print_sidebars($sel) {
	global $wp_registered_sidebars;
	$output = '<option value=""></option>';
	foreach ( (array) $wp_registered_sidebars as $k=>$v) {
		$selected = (!empty($sel) && $k === $sel) ? ' selected' : '';
		$output .= '<option value="' . $k . '"' . $selected . '>' . $v['name'] . '</option>';
	}
	return $output;
}

function rbsvgi_print_taxonomy($name, $src) {
	$source = rbsvgi_get_taxonomy_array($name);
	$output = '<option value=""></option>';
	foreach($source as $k=>$v) {
		$selected = (!empty($src[$k]) && true === $src[$k][1]) ? ' selected' : '';
		$output .= '<option value="' . $k . '"'.$selected.'>' . $v . '</option>';
	}
	return $output;
}

function rbsvgi_get_taxonomy_array($tax, $args = '') {
	$terms = get_terms($tax, $args);
	$ret = array();
	if (!is_wp_error($terms)) {
		foreach ($terms as $k=>$v) {
			$slug = str_replace('%', '|', $v->slug);
			$ret[$slug] = $v->name;
		}
	}
	return $ret;
}

function rbsvgi_print_fa ($sel) {
	$rbfi = get_option('rbfi');
	$isFlatIcons = !empty($rbfi) && !empty($rbfi['entries']);
	$output = '<option value=""></option>';
	if (function_exists( 'rb-svgi')) {
		if ($isFlatIcons) {
			$output .= '<optgroup label="Font Awesome">';
		}
		$icons = call_user_func( 'rb-svgi');
		foreach ($icons as $icon) {
			$selected = ($sel === 'fa fa-' . $icon) ? ' selected' : '';
			$output .= '<option value="fa fa-' . $icon . '" '.$selected.'>' . $icon . '</option>';
		}
		if ($isFlatIcons) {
			$output .= '</optgroup>';
		}
	}
	if ($isFlatIcons) {
		if (function_exists( 'rb-svgi')) {
			$output .= '<optgroup label="Flaticon">';
			$icons = call_user_func( 'rb-svgi');
			foreach ($icons as $icon) {
				$selected = ($sel === 'flaticon-' . $icon) ? ' selected' : '';
				$output .= '<option value="flaticon-' . $icon . '" '.$selected.'>' . $icon . '</option>';
			}
			$output .= '</optgroup>';
		}
	}
	return $output;
}

function rbsvgi_print_titles ( $ptype ) {
	global $post;
	$output = '';
	$post_bc = $post;
	$r = new WP_Query( array( 'posts_per_page' => '-1', 'post_type' => $ptype, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) );
	while ( $r->have_posts() ) {
		$r->the_post();
		$output .= '<option value="' . $r->post->ID . '">' . esc_attr( get_the_title() ) . "</option>\n";
	}
	wp_reset_postdata();
	$post = $post_bc;
	return $output;
}
?>
