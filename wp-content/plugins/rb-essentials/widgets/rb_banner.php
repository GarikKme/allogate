<?php
/**
 * RB Banner Widget Class
 */

class RB_Banner extends WP_Widget{
	public function __construct() {
		$widget_options = array( 
		  'classname' => 'rb_banner',
		  'description' => esc_html_x('Displays custom "RB Banner" widget', 'Widget RB-Banner', 'setech'),
		);

		parent::__construct( 'rb_banner', 'RB Banner', $widget_options );
	}	

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$needle = array( '">', "'>" );
		$args['before_widget'] = str_replace($needle, ' rb-banner">', $args['before_widget']);

		echo $args['before_widget'];
		if( !empty( $instance['bg'] ) ){
			echo '<div class="bg_wrapper">';
				echo '<img src="'.esc_url($instance["bg"]).'" alt="" />';
				echo '<a href="'.esc_url($instance["url"]).'" class="hover_img" style="background-image: url('.esc_url($instance["bg"]).');"></a>';
				
				if( !empty($instance['description']) || !empty($instance['content_title']) ){
					echo '<div class="banner-content-wrapper">';
						if( !empty($instance['content_title']) ) {
							echo '<h5 class="title">'.esc_html($instance["content_title"]).'</h5>';
						}
						if( !empty($instance['description']) ) {
							echo '<p class="description">'.esc_html($instance['description']).'</p>';
						}
					echo '</div>';
				}
			echo '</div>';

		}
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$content_title = !empty( $instance['content_title'] ) ? $instance['content_title'] : '';
		$description = !empty( $instance['description'] ) ? $instance['description'] : '';
		$url = !empty( $instance['url'] ) ? $instance['url'] : '#';
		?>

		<div class='widget-row'>
	        <label for="<?php echo $this->get_field_id( 'bg' ); ?>">
	        	<?php echo esc_html_x( 'Background:', 'Widget RB-Banner', 'setech' ); ?>
	        </label>
	        <div class="widget-inner-content img-inside">
		        <img class="<?php echo $this->get_field_id( 'bg' ) ?>_img" src="<?php echo (!empty($instance['bg'])) ? $instance['bg'] : ''; ?>" />
		        <input hidden type="text" class="widefat <?php echo $this->get_field_id( 'bg' ) ?>_url" name="<?php echo esc_attr( $this->get_field_name( 'bg' ) ); ?>" value="<?php echo !empty($instance['bg']) ? $instance['bg'] : ''; ?>" />
		        <button type="button" id="<?php echo $this->get_field_id( 'bg' ) ?>" class="button js_custom_upload_media<?php echo empty($instance['bg']) ? ' empty' : ''; ?>"><?php echo esc_html_x('No file selected', 'Widget RB-Banner', 'setech') ?></button>
		        <button id="<?php echo $this->get_field_id( 'bg' ).'_remove' ?>" type="button" class="button js_custom_remove_media"></button>
	        </div>
	    </div>

	    <div class='widget-row'>
			<label for="<?php echo $this->get_field_id( 'content_title' ) ?>">
				<?php echo esc_html_x( 'Content Title:', 'Widget RB-Banner', 'setech' ); ?>
			</label>
			<div class="widget-inner-content">
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('content_title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('content_title') ); ?>" type="text" value="<?php echo esc_attr($content_title); ?>" />
			</div>
		</div>

	    <div class='widget-row'>
	    	<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ) ?>">
				<?php echo esc_html_x( 'Description:', 'Widget RB-Banner', 'setech' ); ?>
			</label>
			<div class="widget-inner-content">
				<input type="text" hidden class="widefat hidden textarea" name="<?php echo $this->get_field_name( 'description' ); ?>" id="<?php echo esc_attr( $this->get_field_id('description') ) ?>" value="<?php echo esc_attr($description); ?>" />
		    	<textarea rows="3" class="widget_textarea_control"><?php echo esc_html($description) ?></textarea>
	    	</div>
	    </div>

	    <div class='widget-row'>
			<label for="<?php echo $this->get_field_id( 'url' ) ?>">
				<?php echo esc_html_x( 'URL:', 'Widget RB-Banner', 'setech' ); ?>
			</label>
			<div class="widget-inner-content">
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('url') ); ?>" name="<?php echo esc_attr( $this->get_field_name('url') ); ?>" type="text" value="<?php echo esc_attr($url); ?>" />
			</div>
		</div>

		<?php 
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['bg'] = strip_tags( $new_instance['bg'] );
		$instance['content_title'] = ( !empty($new_instance['content_title']) ) ? sanitize_text_field( $new_instance['content_title'] ) : '';
		$instance['description'] = ( !empty($new_instance['description']) ) ? sanitize_text_field( $new_instance['description'] ) : '';
		$instance['url'] = ( !empty($new_instance['url']) ) ? sanitize_text_field( $new_instance['url'] ) : '';

		return $instance;
	}
}

?>