<?php
/**
 * RB About Widget Class
 */

class RB_About extends WP_Widget {
	public function __construct() {
		$widget_options = array( 
		  'classname' => 'rb_about',
		  'description' => esc_html_x('Displays custom "RB About" widget', 'Widget RB-About', 'setech'),
		);

		parent::__construct( 'rb_about', 'RB About', $widget_options );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$needle = array( '">', "'>" );
		$args['before_widget'] = str_replace($needle, ' rb-about">', $args['before_widget']);

		echo $args['before_widget'];
		if ( !empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		if( !empty( $instance['image_1'] ) ){
			echo '<div class="avatar-wrapper">';
				echo '<img class="avatar" src="'.esc_url($instance["image_1"]).'" alt="" />';
			echo '</div>';
		}
		if ( !empty( $instance['name'] ) ) {
			echo '<h5 class="name">'.esc_html($instance["name"]).'</h5>';
		}
		if ( !empty( $instance['description'] ) ) {
			echo '<p class="description">'.esc_html($instance['description']).'</p>';
		}
		if( !empty( $instance['image_2'] ) ){
			echo '<div class="signature-wrapper">';
				echo '<img class="signature" src="'.esc_url($instance["image_2"]).'" alt="" />';
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
		$title = !empty( $instance['title'] ) ? $instance['title'] : esc_html_x( 'New widget', 'Widget RB-About', 'setech' ); 
		$name = !empty( $instance['name'] ) ? $instance['name'] : esc_html_x( 'John Doe', 'Widget RB-About', 'setech' );
		$description = !empty( $instance['description'] ) ? $instance['description'] : esc_html_x( 'Lorem ipsum dolor sit amet', 'Widget RB-About', 'setech' );
		?>
		
		<div class='widget-row'>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php echo esc_html_x( 'Title:', 'Widget RB-About', 'setech' ); ?>
			</label>
			<div class="widget-inner-content">
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</div>
		</div>

		<div class='widget-row'>
	        <label for="<?php echo $this->get_field_id( 'image_1' ); ?>">
	        	<?php echo esc_html_x( 'Image:', 'Widget RB-About', 'setech' ); ?>
	        </label>
	        <div class="widget-inner-content img-inside">
		        <img class="<?php echo $this->get_field_id( 'image_1' ) ?>_img" src="<?php echo (!empty($instance['image_1'])) ? $instance['image_1'] : ''; ?>" />
		        <input hidden type="text" class="widefat <?php echo $this->get_field_id( 'image_1' ) ?>_url" name="<?php echo esc_attr( $this->get_field_name( 'image_1' ) ); ?>" value="<?php echo !empty($instance['image_1']) ? $instance['image_1'] : ''; ?>" />
		        <button type="button" id="<?php echo $this->get_field_id( 'image_1' ) ?>" class="button js_custom_upload_media<?php echo empty($instance['image_1']) ? ' empty' : ''; ?>"><?php echo esc_html_x('No file selected', 'Widget RB-About', 'setech') ?></button>
		        <button id="<?php echo $this->get_field_id( 'image_1' ).'_remove' ?>" type="button" class="button js_custom_remove_media"></button>
	        </div>
	    </div>

	    <div class='widget-row'>
			<label for="<?php echo $this->get_field_id( 'name' ) ?>">
				<?php echo esc_html_x( 'Name:', 'Widget RB-About', 'setech' ); ?>
			</label>
			<div class="widget-inner-content">
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('name') ); ?>" name="<?php echo esc_attr( $this->get_field_name('name') ); ?>" type="text" value="<?php echo esc_attr($name); ?>" />
			</div>
		</div>

	    <div class='widget-row'>
	    	<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ) ?>">
				<?php echo esc_html_x( 'Description:', 'Widget RB-About', 'setech' ); ?>
			</label>
			<div class="widget-inner-content">
				<input type="text" hidden class="widefat hidden textarea" name="<?php echo $this->get_field_name( 'description' ); ?>" id="<?php echo esc_attr( $this->get_field_id('description') ) ?>" value="<?php echo esc_attr($description); ?>" />
		    	<textarea rows="3" class="widget_textarea_control"><?php echo esc_html($description) ?></textarea>
	    	</div>
	    </div>

	    <div class='widget-row'>
	        <label for="<?php echo $this->get_field_id( 'image_2' ); ?>">
	        	<?php echo esc_html_x( 'Signature:', 'Widget RB-About', 'setech' ); ?>
	        </label>
	        <div class="widget-inner-content img-inside">
		        <img class="<?php echo $this->get_field_id( 'image_2' ) ?>_img" src="<?php echo !empty($instance['image_2']) ? $instance['image_2'] : ''; ?>" />
		        <input hidden type="text" class="widefat <?php echo $this->get_field_id( 'image_2' ) ?>_url" name="<?php echo esc_attr( $this->get_field_name( 'image_2' ) ); ?>" value="<?php echo !empty($instance['image_2']) ? $instance['image_2'] : ''; ?>" />
		        <button type="button" id="<?php echo $this->get_field_id( 'image_2' ) ?>" class="button js_custom_upload_media<?php echo empty($instance['image_2']) ? ' empty' : ''; ?>"><?php echo esc_html_x('No file selected', 'Widget RB-About', 'setech') ?></button>
		        <button id="<?php echo $this->get_field_id( 'image_2' ).'_remove' ?>" type="button" class="button js_custom_remove_media"></button>
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

		$instance['title'] = ( !empty($new_instance['title']) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['image_1'] = strip_tags( $new_instance['image_1'] );
		$instance['name'] = ( !empty($new_instance['name']) ) ? sanitize_text_field( $new_instance['name'] ) : '';
		$instance['description'] = ( !empty($new_instance['description']) ) ? sanitize_text_field( $new_instance['description'] ) : '';
		$instance['image_2'] = strip_tags( $new_instance['image_2'] );

		return $instance;
	}
}

?>