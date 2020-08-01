<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
	return NULL;


class RB_Customizer extends WP_Customize_Control {

	/**
	 * @access public
	 * @var    string
	 */
	public $type = 'rb_customizer';

	/**
	 * Add support for divider to be passed in.
	 */
    public $separator;

    /**
	 * Add support for repeater buttons to be passed in.
	 */
    public $add_label;
    public $save_label;

    /**
	 * Add support for control dependencies.
	 */
    public $dependency;

	/**
	 * Add support for palettes to be passed in.
	 *
	 * Supported palette values are true, false, or an array of RGBa and Hex colors.
	 */
	public $palette;

	/**
	 * Add support for showing the opacity value on the slider handle.
	 */
	public $show_opacity;

	/**
	 * Enqueue scripts and styles.
	 *
	 * Ideally these would get registered and given proper paths before this control object
	 * gets initialized, then we could simply enqueue them here, but for completeness as a
	 * stand alone class we'll register and enqueue them here.
	 */

	public function enqueue() {
		wp_enqueue_script(
			'alpha-color-picker',
			SETECH__URI . 'admin/customize/inc/alpha-color-picker.js',
			array( 'jquery', 'wp-color-picker' ),
			SETECH__VERSION,
			true
		);
		wp_enqueue_style(
			'alpha-color-picker',
			SETECH__URI . 'admin/customize/inc/alpha-color-picker.css',
			array( 'wp-color-picker' ),
			SETECH__VERSION
		);
	}

	/**
	 * @access public
	 * @var    array
	 */
	public $args = array();
	/**
	 * Constructor.
	 *
	 * If $args['settings'] is not defined, use the $id as the setting ID.
	 *
	 * @since   11/14/2012
	 * @uses    WP_Customize_Control::__construct()
	 * @param   WP_Customize_Manager $manager
	 * @param   string $id
	 * @param   array $args
	 * @return  void
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Check state of control with dependency.
	 *
	 * @return  string
	 */
	public function dependency_state( $control, $operator, $value ){
		switch ($operator){
			case '==':
			case '===':
				if( $value != 'empty' && $value != '!empty' ){
					echo get_theme_mod($control) == $value ? '' : ' hidden';
				} else if( $value == 'empty' ){
					echo empty(get_theme_mod($control)) ? '' : ' hidden';
				} else if( $value == '!empty' ){
					echo !empty(get_theme_mod($control)) ? '' : ' hidden';
				}
				break;
			case '!=':
			case '!==':
				if( $value != 'empty' && $value != '!empty' ){
					echo get_theme_mod($control) != $value ? '' : ' hidden';
				} else if( $value == 'empty' ){
					echo !empty(get_theme_mod($control)) ? '' : ' hidden';
				} else if( $value == '!empty' ){
					echo empty(get_theme_mod($control)) ? '' : ' hidden';
				}
				break;
			case '>':
				echo (int)get_theme_mod($control) > (int)$value ? '' : ' hidden';
				break;
			case '<':
				echo (int)get_theme_mod($control) < (int)$value ? '' : ' hidden';
				break;
			case '>=':
				echo (int)get_theme_mod($control) >= (int)$value ? '' : ' hidden';
				break;
			case '<=':
				echo (int)get_theme_mod($control) <= (int)$value ? '' : ' hidden';
				break;
			default:
				break;
		}
	}

	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overriden without having to rewrite the wrapper.
	 *
	 * @since   11/14/2012
	 * @return  void
	 */
	public function render_content() {
		$input_id = '_customize-input-' . $this->id;
		$description_id = '_customize-description-' . $this->id;
		$describedby_attr = ( !empty( $this->description ) ) ? ' aria-describedby="' . esc_attr( $description_id ) . '" ' : '';
		$dep_by = $dep_operator = $dep_value = $dep_def = '';

		if( !empty($this->dependency) ){
			$dep_by = ' data-depend-by="'.$this->dependency['control'].'"';
			$dep_operator = ' data-depend-operator="'.$this->dependency['operator'].'"';
			$dep_value = ' data-depend-value="'.$this->dependency['value'].'"';
			$dep_def = ' data-depend-default="'.$this->settings['default']->default.'"';
		}

		switch ( $this->type ) {
			case 'alpha-color':
				// Process the palette
				if ( is_array( $this->palette ) ) {
					$palette = implode( '|', $this->palette );
				} else {
					// Default to true.
					$palette = ( false === $this->palette || 'false' === $this->palette ) ? 'false' : 'true';
				}

				// Support passing show_opacity as string or boolean. Default to true.
				$show_opacity = ( false === $this->show_opacity || 'false' === $this->show_opacity ) ? 'false' : 'true';

				// Begin the output. ?>
				<div class="control-wrapper alpha-color<?php $this->dependency_state($this->dependency['control'], $this->dependency['operator'], $this->dependency['value']) ?>"<?php echo sprintf('%s', $dep_by); echo sprintf('%s', $dep_operator); echo sprintf('%s', $dep_value); echo sprintf('%s', $dep_def); ?>>
					<?php // Output the label and description if they were passed in.
					if ( isset( $this->label ) && '' !== $this->label ) {
						echo '<h3>' . sanitize_text_field( $this->label ) . '</h3>';
					} ?>

					<?php if( $this->separator == 'line-top' ) echo '<hr class="top"/>'; ?>

					<label>
						<?php
						if ( isset( $this->description ) && '' !== $this->description ) {
							echo '<span class="description customize-control-description">' . sanitize_text_field( $this->description ) . '</span>';
						} ?>
						<input class="alpha-color-control" type="text" data-show-opacity="<?php echo sprintf('%s', $show_opacity); ?>" data-palette="<?php echo esc_attr( $palette ); ?>" data-default-color="<?php echo esc_attr( $this->settings['default']->default ); ?>" <?php $this->link(); ?>  />
					</label>

					<?php if( $this->separator == 'line' ) echo '<hr/>'; ?>
				</div>

				<?php
				break;
			case 'multiple_input':
				$custom_value = $placeholder = '';

				?>
				<div class="control-wrapper multiple-input<?php $this->dependency_state($this->dependency['control'], $this->dependency['operator'], $this->dependency['value']) ?>"<?php echo sprintf('%s', $dep_by); echo sprintf('%s', $dep_operator); echo sprintf('%s', $dep_value); echo sprintf('%s', $dep_def); ?>>

					<?php if( $this->separator == 'line-top' ) echo '<hr class="top"/>'; ?>

					<h3><?php echo sanitize_text_field( $this->label ) ?></h3>

					<div class='multiple_inputs_wrapper'>
						<?php foreach ($this->choices as $key => $value) : 
							$input_value = $placeholder = '';
							$id = $input_id.'_'.$key;
							$name = uniqid('multiple_');

							foreach ($value as $attr_k => $attr_v) {
								if( $attr_k == 'placeholder' ){
									$placeholder = $attr_v;
								} else if( $attr_k == 'value' ){
									$input_value = $attr_v;
								}
							}

							if( !empty($this->value()) ){
								foreach ($this->value() as $k => $v) {
									if( $key == $k ){
										$input_value = $v;
									}
								}
							} ?>
							
							<input
								id="<?php echo esc_attr($id) ?>"
								name="<?php echo esc_attr($name) ?>"
								data-name="<?php echo esc_attr($key) ?>"
								value="<?php echo esc_attr($input_value) ?>"
								placeholder="<?php echo esc_attr($placeholder) ?>"
								type="text"
							/>
						<?php endforeach; ?>
					</div>

					<input
						id="<?php echo esc_attr($input_id); ?>"
						type="text"
						hidden
						<?php echo sprintf('%s', $describedby_attr); ?>
						<?php $this->link(); ?>
					/>

					<?php if( $this->separator == 'line' ) echo '<hr/>'; ?>
				</div>
				
				<?php 
				break;
			case 'repeater':
				?>
				<div class="control-wrapper repeater<?php $this->dependency_state($this->dependency['control'], $this->dependency['operator'], $this->dependency['value']) ?>"<?php echo sprintf('%s', $dep_by); echo sprintf('%s', $dep_operator); echo sprintf('%s', $dep_value); echo sprintf('%s', $dep_def); ?>>

					<?php if( $this->separator == 'line-top' ) echo '<hr class="top"/>'; ?>

					<h3><?php echo sanitize_text_field( $this->label ) ?></h3>
				
					<div class="repeater-items-wrapper">

						<?php if( !empty($this->value()) ){
							foreach ($this->value() as $key => $value) :
								$name = uniqid('repeater_');
								$id = $input_id.'_'.$key;
							?>
								<div class="repeater-item">
									<input 
										id="customize-input-<?php echo esc_attr($key) ?>"
										name="<?php echo esc_attr($name) ?>"
										data-name="<?php echo esc_attr($key) ?>"
										value="<?php echo esc_attr($value) ?>"
										type="text"
									>
									<i class="remove"></i>
								</div>
							<?php endforeach;
						} else {
							foreach ($this->settings['default']->default as $key => $value) :
								$name = uniqid('repeater_');
								$id = $input_id.'_'.$key;
							?>

								<div class="repeater-item">
									<input 
										id="customize-input-<?php echo esc_attr($key) ?>"
										name="<?php echo esc_attr($name) ?>"
										data-name="<?php echo esc_attr($key) ?>"
										value="<?php echo esc_attr($value) ?>"
										type="text"
									>
									<i class="remove"></i>
								</div>

							<?php endforeach;
						} ?>

					</div>
				
					<button type="button" class="repeater-button add"><?php echo esc_html($this->add_label) ?></button>
					<button type="button" class="repeater-button save"><?php echo esc_html($this->save_label) ?></button>

					<input
						id="<?php echo esc_attr($input_id); ?>"
						type="text"
						hidden
						<?php echo sprintf('%s', $describedby_attr); ?>
						<?php $this->link(); ?>
					/>

					<?php if( $this->separator == 'line' ) echo '<hr/>'; ?>
				</div>

				<?php
				break;
			case 'checkbox':
				?>
				<div class="control-wrapper checkbox<?php $this->dependency_state($this->dependency['control'], $this->dependency['operator'], $this->dependency['value']) ?>"<?php echo sprintf('%s', $dep_by); echo sprintf('%s', $dep_operator); echo sprintf('%s', $dep_value); echo sprintf('%s', $dep_def); ?>>

					<?php if( $this->separator == 'line-top' ) echo '<hr class="top"/>'; ?>

					<span class="customize-inside-control-row">
						<input
							id="<?php echo esc_attr( $input_id ); ?>"
							<?php echo sprintf('%s', $describedby_attr); ?>
							type="checkbox"
							value="<?php echo esc_attr( $this->value() ); ?>"
							<?php $this->link(); ?>
							<?php checked( $this->value() ); ?>
						/>
						<label for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_html( $this->label ); ?></label>
						<?php if ( ! empty( $this->description ) ) : ?>
							<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo sprintf('%s', $this->description); ?></span>
						<?php endif; ?>
					</span>
					
					<?php if( $this->separator == 'line' ) echo '<hr/>'; ?>
				</div>

				<?php
				break;
			case 'radio':
				if ( empty( $this->choices ) ) {
					return;
				}

				$name = '_customize-radio-' . $this->id;
				?>

				<div class="control-wrapper radio<?php $this->dependency_state($this->dependency['control'], $this->dependency['operator'], $this->dependency['value']) ?>"<?php echo sprintf('%s', $dep_by); echo sprintf('%s', $dep_operator); echo sprintf('%s', $dep_value); echo sprintf('%s', $dep_def); ?>>

					<?php if( $this->separator == 'line-top' ) echo '<hr class="top"/>'; ?>

					<?php if ( ! empty( $this->label ) ) : ?>
						<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<?php endif; ?>

					<?php foreach ( $this->choices as $value => $label ) : ?>
						<span class="customize-inside-control-row">
							<input
								id="<?php echo esc_attr( $input_id . '-radio-' . $value ); ?>"
								type="radio"
								<?php echo sprintf('%s', $describedby_attr); ?>
								value="<?php echo esc_attr( $value ); ?>"
								name="<?php echo esc_attr( $name ); ?>"
								<?php $this->link(); ?>
								<?php checked( $this->value(), $value ); ?>
								/>
							<label for="<?php echo esc_attr( $input_id . '-radio-' . $value ); ?>"><?php echo esc_html( $label ); ?></label>
						</span>
					<?php endforeach; ?>

					<?php if ( ! empty( $this->description ) ) : ?>
						<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo sprintf('%s', $this->description) ; ?></span>
					<?php endif; ?>

					<?php if( $this->separator == 'line' ) echo '<hr/>'; ?>
				</div>

				<?php
				break;
			case 'select':
				if ( empty( $this->choices ) ) {
					return;
				}
				?>

				<div class="control-wrapper select<?php $this->dependency_state($this->dependency['control'], $this->dependency['operator'], $this->dependency['value']) ?>"<?php echo sprintf('%s', $dep_by); echo sprintf('%s', $dep_operator); echo sprintf('%s', $dep_value); echo sprintf('%s', $dep_def); ?>>

					<?php if( $this->separator == 'line-top' ) echo '<hr class="top"/>'; ?>

					<?php if ( ! empty( $this->label ) ) : ?>
						<label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
					<?php endif; ?>

					<select 
						id="<?php echo esc_attr( $input_id ); ?>" 
						<?php echo sprintf('%s', $describedby_attr); ?> 
						<?php $this->link(); ?>
						<?php $this->input_attrs(); ?>
					>
						<?php
						foreach ( $this->choices as $value => $label ) {
							echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . $label . '</option>';
						}
						?>
					</select>

					<?php if ( ! empty( $this->description ) ) : ?>
						<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo sprintf('%s', $this->description); ?></span>
					<?php endif; ?>

					<?php if( $this->separator == 'line' ) echo '<hr/>'; ?>
				</div>


				<?php
				break;
			case 'textarea':
				?>
				<div class="control-wrapper textarea<?php $this->dependency_state($this->dependency['control'], $this->dependency['operator'], $this->dependency['value']) ?>"<?php echo sprintf('%s', $dep_by); echo sprintf('%s', $dep_operator); echo sprintf('%s', $dep_value); echo sprintf('%s', $dep_def); ?>>

					<?php if( $this->separator == 'line-top' ) echo '<hr class="top"/>'; ?>

					<?php if ( ! empty( $this->label ) ) : ?>
						<label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
					<?php endif; ?>
					
					<textarea
						id="<?php echo esc_attr( $input_id ); ?>"
						rows="5"
						<?php echo sprintf('%s', $describedby_attr); ?>
						<?php $this->input_attrs(); ?>
						<?php $this->link(); ?>>
						<?php echo esc_textarea( $this->value() ); ?>
					</textarea>

					<?php if ( ! empty( $this->description ) ) : ?>
						<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo sprintf('%s', $this->description); ?></span>
					<?php endif; ?>

					<?php if( $this->separator == 'line' ) echo '<hr/>'; ?>
				</div>

				<?php
				break;
			case 'dropdown-pages':
				?>
				<div class="control-wrapper dropdown-pages<?php $this->dependency_state($this->dependency['control'], $this->dependency['operator'], $this->dependency['value']) ?>"<?php echo sprintf('%s', $dep_by); echo sprintf('%s', $dep_operator); echo sprintf('%s', $dep_value); echo sprintf('%s', $dep_def); ?>>

					<?php if( $this->separator == 'line-top' ) echo '<hr class="top"/>'; ?>

					<?php if ( ! empty( $this->label ) ) : ?>
						<label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
					<?php endif; ?>

					<?php
					$dropdown_name = '_customize-dropdown-pages-' . $this->id;
					$show_option_none = __( '&mdash; Select &mdash;', 'setech' );
					$option_none_value = '0';
					$dropdown = wp_dropdown_pages(
						array(
							'name'              => $dropdown_name,
							'echo'              => 0,
							'show_option_none'  => $show_option_none,
							'option_none_value' => $option_none_value,
							'selected'          => $this->value(),
						)
					);
					if ( empty( $dropdown ) ) {
						$dropdown = sprintf( '<select id="%1$s" name="%1$s">', esc_attr( $dropdown_name ) );
						$dropdown .= sprintf( '<option value="%1$s">%2$s</option>', esc_attr( $option_none_value ), esc_html( $show_option_none ) );
						$dropdown .= '</select>';
					}

					// Hackily add in the data link parameter.
					$dropdown = str_replace( '<select', '<select ' . $this->get_link() . ' id="' . esc_attr( $input_id ) . '" ' . $describedby_attr, $dropdown );

					// Even more hacikly add auto-draft page stubs.
					// @todo Eventually this should be removed in favor of the pages being injected into the underlying get_pages() call. See <https://github.com/xwp/wp-customize-posts/pull/250>.
					$nav_menus_created_posts_setting = $this->manager->get_setting( 'nav_menus_created_posts' );
					if ( $nav_menus_created_posts_setting && current_user_can( 'publish_pages' ) ) {
						$auto_draft_page_options = '';
						foreach ( $nav_menus_created_posts_setting->value() as $auto_draft_page_id ) {
							$post = get_post( $auto_draft_page_id );
							if ( $post && 'page' === $post->post_type ) {
								$auto_draft_page_options .= sprintf( '<option value="%1$s">%2$s</option>', esc_attr( $post->ID ), esc_html( $post->post_title ) );
							}
						}
						if ( $auto_draft_page_options ) {
							$dropdown = str_replace( '</select>', $auto_draft_page_options . '</select>', $dropdown );
						}
					}

					echo sprintf('%s', $dropdown);
					?>
					<?php if ( $this->allow_addition && current_user_can( 'publish_pages' ) && current_user_can( 'edit_theme_options' ) ) : // Currently tied to menus functionality. ?>
						<button type="button" class="button-link add-new-toggle">
							<?php
							/* translators: %s: add new page label */
							printf( __( '+ %s', 'setech' ), get_post_type_object( 'page' )->labels->add_new_item );
							?>
						</button>
						<div class="new-content-item">
							<label for="create-input-<?php echo sprintf('%s', $this->id); ?>"><span class="screen-reader-text"><?php _e( 'New page title', 'setech' ); ?></span></label>
							<input type="text" id="create-input-<?php echo sprintf('%s', $this->id); ?>" class="create-item-input" placeholder="<?php esc_attr_e( 'New page title&hellip;', 'setech' ); ?>">
							<button type="button" class="button add-content"><?php _e( 'Add', 'setech' ); ?></button>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $this->description ) ) : ?>
						<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo sprintf('%s', $this->description); ?></span>
					<?php endif; ?>

					<?php if( $this->separator == 'line' ) echo '<hr/>'; ?>
				</div>

				<?php
				break;
			case 'custom-text':
				?>
				<div class="control-wrapper custom-text<?php $this->dependency_state($this->dependency['control'], $this->dependency['operator'], $this->dependency['value']) ?>"<?php echo sprintf('%s', $dep_by); echo sprintf('%s', $dep_operator); echo sprintf('%s', $dep_value); echo sprintf('%s', $dep_def); ?>>

					<?php if( $this->separator == 'line-top' ) echo '<hr class="top"/>'; ?>

					<?php if ( ! empty( $this->label ) ) : ?>
						<label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
					<?php endif; ?>

					<input
						id="<?php echo esc_attr( $input_id ); ?>"
						type="<?php echo esc_attr( $this->type ); ?>"
						<?php echo sprintf('%s', $describedby_attr); ?>
						<?php $this->input_attrs(); ?>
						<?php if ( ! isset( $this->input_attrs['value'] ) ) : ?>
							value="<?php echo esc_attr( $this->value() ); ?>"
						<?php endif; ?>
						<?php $this->link(); ?>
					/>

					<?php if ( ! empty( $this->description ) ) : ?>
						<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo sprintf('%s', $this->description); ?></span>
					<?php endif; ?>
					
					<div class="ajax_message">
						<span class="success" style="display: none;"></span>
						<span class="error" style="display: none;"></span>
					</div>

					<?php if( $this->separator == 'line' ) echo '<hr/>'; ?>
				</div>

				<?php
				break;
			case 'link':
				?>
				<div class="control-wrapper link">
					<?php if ( !empty( $this->input_attrs['icon'] ) ) : ?>
						<i class="icon <?php echo esc_attr($this->input_attrs['icon']); ?>"></i>
					<?php endif; ?>

					<?php if ( !empty( $this->value() ) ) : ?>
						<a target="_blank" href="<?php echo esc_url($this->value()); ?>"><?php echo !empty($this->label) ? esc_html($this->label) : esc_html_x('Link', 'customizer', 'setech'); ?></a>
					<?php endif; ?>

					<?php if ( !empty( $this->description ) ) : ?>
						<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo sprintf('%s', $this->description); ?></span>
					<?php endif; ?>
				</div>
				<?php
				break;
			default:
				?>
				<div class="control-wrapper default<?php $this->dependency_state($this->dependency['control'], $this->dependency['operator'], $this->dependency['value']) ?>"<?php echo sprintf('%s', $dep_by); echo sprintf('%s', $dep_operator); echo sprintf('%s', $dep_value); echo sprintf('%s', $dep_def); ?>>

					<?php if( $this->separator == 'line-top' ) echo '<hr class="top"/>'; ?>
					
					<?php if ( ! empty( $this->label ) ) : ?>
						<label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
					<?php endif; ?>

					<input
						id="<?php echo esc_attr( $input_id ); ?>"
						type="<?php echo esc_attr( $this->type ); ?>"
						<?php echo sprintf('%s', $describedby_attr); ?>
						<?php $this->input_attrs(); ?>
						<?php if ( ! isset( $this->input_attrs['value'] ) ) : ?>
							value="<?php echo esc_attr( $this->value() ); ?>"
						<?php endif; ?>
						<?php $this->link(); ?>
					/>

					<?php if ( ! empty( $this->description ) ) : ?>
						<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo sprintf('%s', $this->description); ?></span>
					<?php endif; ?>

					<?php if( $this->separator == 'line' ) echo '<hr/>'; ?>
				</div>
				
				<?php
				break;
		}
	}
}
