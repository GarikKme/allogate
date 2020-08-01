<?php
defined( 'ABSPATH' ) or die();

// We will hide comments for password protected posts
if ( post_password_required() ) return;
?>

<?php
	function rb_comments( $comment, $args, $depth ) {
		$tag       = 'div';
		$add_below = 'comment';

		$classes = ' ' . comment_class( empty( $args['has_children'] ) ? '' : 'parent', null, null, false );
		?>

		<<?php echo sprintf('%s', $tag); echo sprintf('%s', $classes); ?> id="comment-<?php comment_ID() ?>">

		<div id="comment-<?php comment_ID() ?>" class="comment-body">
			<div class="comment-author">
				<?php echo get_avatar($comment, $args['avatar_size']); ?>
			</div>

			<div class="comment-meta">
				<span class="comment-admin"><?php echo get_comment_author_link(); ?></span>
				<span class="comment-date"><?php echo get_comment_date(); ?></span>
			</div>

			<div class="comment-buttons">
				<div class="edit"><?php edit_comment_link( esc_html_x( 'Edit', 'frontend', 'setech' ), '  ', '' ); ?></div>
				<?php
					comment_reply_link(
						array_merge(
							$args,
							array(
								'add_below' => $add_below,
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
								'before'	=> '<div class="reply">',
								'after'		=> '</div>',
							)
						)
					); 
				?>
			</div>

			<?php if ( $comment->comment_approved == '0' ) { ?>
				<em class="comment-awaiting-moderation">
					<?php echo esc_html_x( 'Your comment is awaiting moderation.', 'comments', 'setech' ); ?>
				</em><br/>
			<?php } ?>

			<div class="comment-content">
				<?php comment_text(); ?>
			</div>
		</div>
<?php
	}
?>

<?php
	function rb_comment_form( $args = array(), $post_id = null ) {
		if ( null === $post_id )
			$post_id = get_the_ID();

		// Exit the function when comments for the post are closed.
		if ( ! comments_open( $post_id ) ) {
			/**
			 * Fires after the comment form if comments are closed.
			 *
			 * @since 3.0.0
			 */
			do_action( 'comment_form_comments_closed' );

			return;
		}

		$commenter = wp_get_current_commenter();
		$user = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';

		$args = wp_parse_args( $args );
		if ( ! isset( $args['format'] ) )
			$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';

		$req      = get_option( 'require_name_email' );
		$html_req = ( $req ? " required" : '' );
		$html5    = 'html5' === $args['format'];
		$fields   =  array(
			'author'  => '<p class="comment-form-author">' . '<label for="author">' . esc_html__( 'Name', 'setech' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
						 '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" placeholder="'.esc_attr__( 'Your Name', 'setech' ).'" maxlength="245"' . $html_req . ' /></p>',
			'email'   => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'setech' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
						 '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" maxlength="100" placeholder="'.esc_attr__( 'Your Email', 'setech' ).'" aria-describedby="email-notes"' . $html_req . ' /></p>',
		);

		/**
		 * Filters the default comment form fields.
		 *
		 * @since 3.0.0
		 *
		 * @param array $fields The default comment fields.
		 */
		$fields = apply_filters( 'comment_form_default_fields', $fields );
		$defaults = array(
			'fields'               => $fields,
			'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . esc_html_x( 'Comment', 'frontend', 'setech' ) . '<span class="required"> *</span></label> <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" placeholder="'.esc_attr__( 'Your Comment', 'setech' ).'" required="required"></textarea></p>',
			/** This filter is documented in wp-includes/link-template.php */
			'must_log_in'          => '<p class="must-log-in">' . sprintf(
			                              /* translators: %s: login URL */
			                              __( 'You must be <a href="%s">logged in</a> to post a comment.', 'setech' ),
			                              wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ), $post_id ) )
			                          ) . '</p>',
			/** This filter is documented in wp-includes/link-template.php */
			'logged_in_as'         => '<p class="logged-in-as">' . sprintf(
			                              /* translators: 1: edit user link, 2: accessibility text, 3: user name, 4: logout URL */
			                              __( '<a href="%1$s" aria-label="%2$s">Logged in as %3$s</a>. <a href="%4$s">Log out?</a>', 'setech' ),
			                              get_edit_user_link(),
			                              /* translators: %s: user name */
			                              esc_attr( sprintf( __( 'Logged in as %s. Edit your profile.', 'setech' ), $user_identity ) ),
			                              $user_identity,
			                              wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ), $post_id ) )
			                          ) . '</p>',
			'comment_notes_before' => '',
			'comment_notes_after'  => '',
			'action'               => site_url( '/wp-comments-post.php' ),
			'id_form'              => 'commentform',
			'id_submit'            => 'submit',
			'class_form'           => 'comment-form',
			'class_submit'         => 'submit rb_button medium',
			'name_submit'          => 'submit',
			'title_reply'          => esc_html_x( 'Write A Comment', 'frontend', 'setech' ),
			'title_reply_to'       => esc_html_x( 'Leave a Reply to %s', 'frontend', 'setech' ),
			'title_reply_before'   => '<h3 id="reply-title" class="single-content-title comment-reply-title h2">',
			'title_reply_after'    => '</h3>',
			'cancel_reply_before'  => ' <span class="cancel-reply">',
			'cancel_reply_after'   => '</span>',
			'cancel_reply_link'    => esc_html_x( 'Cancel Reply', 'frontend', 'setech' ),
			'label_submit'         => esc_html_x( 'Post Comment', 'frontend', 'setech' ),
			'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
			'submit_field'         => '<p class="form-submit">%1$s %2$s</p>',
			'format'               => 'xhtml',
		);

		/**
		 * Filters the comment form default arguments.
		 *
		 * Use {@see 'comment_form_default_fields'} to filter the comment fields.
		 *
		 * @since 3.0.0
		 *
		 * @param array $defaults The default comment form arguments.
		 */
		$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

		// Ensure that the filtered args contain all required default values.
		$args = array_merge( $defaults, $args );

		/**
		 * Fires before the comment form.
		 *
		 * @since 3.0.0
		 */
		do_action( 'comment_form_before' );
		?>
		<div id="respond" class="comment-respond">
			<?php
			echo sprintf('%s', $args['title_reply_before']);

			comment_form_title( $args['title_reply'], $args['title_reply_to'] );

			echo sprintf('%s', $args['cancel_reply_before']);

			cancel_comment_reply_link( $args['cancel_reply_link'] );

			echo sprintf('%s', $args['cancel_reply_after']);

			echo sprintf('%s', $args['title_reply_after']);

			if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) :
				echo sprintf('%s', $args['must_log_in']);
				/**
				 * Fires after the HTML-formatted 'must log in after' message in the comment form.
				 *
				 * @since 3.0.0
				 */
				do_action( 'comment_form_must_log_in_after' );
			else : ?>
				<form action="<?php echo esc_url( $args['action'] ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" class="<?php echo esc_attr( $args['class_form'] ); ?>">
					<?php
					/**
					 * Fires at the top of the comment form, inside the form tag.
					 *
					 * @since 3.0.0
					 */
					do_action( 'comment_form_top' );

					if ( is_user_logged_in() ) :
						/**
						 * Filters the 'logged in' message for the comment form for display.
						 *
						 * @since 3.0.0
						 *
						 * @param string $args_logged_in The logged-in-as HTML-formatted message.
						 * @param array  $commenter      An array containing the comment author's
						 *                               username, email, and URL.
						 * @param string $user_identity  If the commenter is a registered user,
						 *                               the display name, blank otherwise.
						 */
						echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity );

						/**
						 * Fires after the is_user_logged_in() check in the comment form.
						 *
						 * @since 3.0.0
						 *
						 * @param array  $commenter     An array containing the comment author's
						 *                              username, email, and URL.
						 * @param string $user_identity If the commenter is a registered user,
						 *                              the display name, blank otherwise.
						 */
						do_action( 'comment_form_logged_in_after', $commenter, $user_identity );

					else :

						echo sprintf('%s', $args['comment_notes_before']);

					endif;

					// Prepare an array of all fields, including the textarea
					$comment_fields = (array) $args['fields'] + array( 'comment' => $args['comment_field'] );

					/**
					 * Filters the comment form fields, including the textarea.
					 *
					 * @since 4.4.0
					 *
					 * @param array $comment_fields The comment fields.
					 */
					$comment_fields = apply_filters( 'comment_form_fields', $comment_fields );

					// Get an array of field names, excluding the textarea
					$comment_field_keys = array_diff( array_keys( $comment_fields ), array( 'comment' ) );

					// Get the first and the last field name, excluding the textarea
					$first_field = reset( $comment_field_keys );
					$last_field  = end( $comment_field_keys );

					foreach ( $comment_fields as $name => $field ) {

						if ( 'comment' === $name ) {

							/**
							 * Filters the content of the comment textarea field for display.
							 *
							 * @since 3.0.0
							 *
							 * @param string $args_comment_field The content of the comment textarea field.
							 */
							echo apply_filters( 'comment_form_field_comment', $field );

							echo sprintf('%s', $args['comment_notes_after']);

						} elseif ( ! is_user_logged_in() ) {

							if ( $first_field === $name ) {
								/**
								 * Fires before the comment fields in the comment form, excluding the textarea.
								 *
								 * @since 3.0.0
								 */
								do_action( 'comment_form_before_fields' );
							}

							/**
							 * Filters a comment form field for display.
							 *
							 * The dynamic portion of the filter hook, `$name`, refers to the name
							 * of the comment form field. Such as 'author', 'email', or 'url'.
							 *
							 * @since 3.0.0
							 *
							 * @param string $field The HTML-formatted output of the comment form field.
							 */
							echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";

							if ( $last_field === $name ) {
								/**
								 * Fires after the comment fields in the comment form, excluding the textarea.
								 *
								 * @since 3.0.0
								 */
								do_action( 'comment_form_after_fields' );
							}
						}
					}

					$submit_button = sprintf(
						$args['submit_button'],
						esc_attr( $args['name_submit'] ),
						esc_attr( $args['id_submit'] ),
						esc_attr( $args['class_submit'] ),
						esc_attr( $args['label_submit'] )
					);

					/**
					 * Filters the submit button for the comment form to display.
					 *
					 * @since 4.2.0
					 *
					 * @param string $submit_button HTML markup for the submit button.
					 * @param array  $args          Arguments passed to `comment_form()`.
					 */
					$submit_button = apply_filters( 'comment_form_submit_button', $submit_button, $args );

					$submit_field = sprintf(
						$args['submit_field'],
						$submit_button,
						get_comment_id_fields( $post_id )
					);

					/**
					 * Filters the submit field for the comment form to display.
					 *
					 * The submit field includes the submit button, hidden fields for the
					 * comment form, and any wrapper markup.
					 *
					 * @since 4.2.0
					 *
					 * @param string $submit_field HTML markup for the submit field.
					 * @param array  $args         Arguments passed to comment_form().
					 */
					echo apply_filters( 'comment_form_submit_field', $submit_field, $args );

					/**
					 * Fires at the bottom of the comment form, inside the closing </form> tag.
					 *
					 * @since 1.5.0
					 *
					 * @param int $post_id The post ID.
					 */
					do_action( 'comment_form', $post_id );
					?>
				</form>
			<?php endif; ?>
		</div><!-- #respond -->
		<?php

		/**
		 * Fires after the comment form.
		 *
		 * @since 3.0.0
		 */
		do_action( 'comment_form_after' );
	}

	// add_filter('comment_post_redirect', function($location, $comment) {
	//   return str_replace("#comment-{$comment->comment_ID}", '', $location );
	// }, 10, 2 );
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

	<h2 class="comments-title single-content-title">
		<?php echo esc_html_x('Comments', 'frontend', 'setech'); ?>
	</h2>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'setech' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'setech' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'setech' ) ); ?></div>
	</nav><!-- #comment-nav-above -->
	<?php endif; // Check for comment navigation. ?>

	<div class="comment-list">
		<?php
			wp_list_comments( array(
				'style'      	=> 'div',
				'avatar_size'	=> 70,
				'callback'		=> 'rb_comments',
			) );
		?>
	</div><!-- .comment-list -->

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'setech' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'setech' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'setech' ) ); ?></div>
	</nav><!-- #comment-nav-below -->
	<?php endif; // Check for comment navigation. ?>

	<?php if ( ! comments_open() ) : ?>
	<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'setech' ); ?></p>
	<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php rb_comment_form(); ?>
	
</div><!-- #comments -->
