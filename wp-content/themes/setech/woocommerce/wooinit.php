<?php

class Setech_WooExt{

	public function __construct( $args = array() ){

		$this->def_args = array(
			'shop_catalog_image_size' 		=> array(),
			'shop_single_image_size'		=> array(),
			'shop_thumbnail_image_size'		=> array(),
			'shop_thumbnail_image_spacings'	=> array(),
			'shop_single_image_spacings'	=> array()
		);

		$this->args = wp_parse_args( $args, $this->def_args );

		add_theme_support( 'woocommerce' );

		add_theme_support( 'woocommerce', $this->custom_image_sizes() );

		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_action( 'woocommerce_init', array( $this, 'woo_init' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_style' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_ajax_rb_ajax_add_to_cart', array( $this, 'ajax_add_to_cart' ) );
		add_action( 'wp_ajax_nopriv_rb_ajax_add_to_cart', array( $this, 'ajax_add_to_cart' ) );

		add_filter('loop_shop_per_page', array( $this, 'products_per_page'), 20 );
		add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
		add_filter( 'woocommerce_output_related_products_args', array( $this, 'rb_related_products' ), 40 );
		add_filter( 'wc_add_to_cart_message_html', '__return_false' );
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'header_add_to_cart_fragment' ), 30, 1 );
		add_filter( 'woocommerce_paypal_icon', array( $this, 'my_new_paypal_icon' ) );

		// Fix paypal broken button
		if( class_exists('WC_Gateway_PPEC_Plugin') ){
			add_filter( 'woocommerce_paypal_express_checkout_button_img_url' , array( $this, 'custom_paypal_image') );
		}

	}
	public function woo_init(){

		/* -----> Products loop hooks <----- */

		// Add wrapper to archive sort & results & grid-list
		add_action( 'woocommerce_before_shop_loop', array( $this, 'archive_info_open' ), 5 );
		add_action( 'woocommerce_before_shop_loop', array( $this, 'archive_info_close' ), 90 );

		// Customize product tags
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'rb_tags_wrapper_open' ), 1 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'rb_new_tags' ), 3 );
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'rb_tags_wrapper_close' ), 4 );

		// Replace opening <a> to <div> tag
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		add_action( 'woocommerce_before_shop_loop_item', array( $this, 'rb_template_loop_product_link_open' ), 10 );

		// Replace closing </a> to </div> tag
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'rb_template_loop_product_link_close' ), 20 );

		// Create Information Wrapper
		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'rb_template_loop_product_info_open' ), 25 );
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'rb_template_loop_product_info_close' ), 25 );

		// Transfer Title under image wrapper
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 30 );

		// Add self <a> tag to the title
		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'product_link_open' ), 29 );
		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 31 );

		// Add self <a> tag to the image
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'product_link_open' ), 9 );
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 11 );

		// Move and add wrapper to rating
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'woocommerce_template_loop_rating_open' ), 26 );
		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 27 );
		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'woocommerce_template_loop_rating_close' ), 28 );

		/* -----> Single product hooks <----- */

		// Add wrapper for gallery & summary
		add_action( 'woocommerce_before_single_product_summary', array( $this, 'rb_product_gallery_summary_wrapper_open' ), 5 );
		add_action( 'woocommerce_after_single_product_summary', array( $this, 'rb_product_gallery_summary_wrapper_close' ), 5 );

		// Customize product tags
		add_action( 'woocommerce_single_product_summary', array( $this, 'rb_tags_wrapper_open' ), 1 );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_loop_sale_flash', 10 );
		add_action( 'woocommerce_single_product_summary', array( $this, 'rb_new_tags' ), 3 );
		add_action( 'woocommerce_single_product_summary', array( $this, 'rb_tags_wrapper_close' ), 4 );
		
		/* -----> Ajax hooks <----- */
		add_action( 'wp_ajax_rb_woo_load_more', array( $this, 'rb_woo_load_more_ajax' ) );
		add_action( 'wp_ajax_nopriv_rb_woo_load_more', array( $this, 'rb_woo_load_more_ajax' ) );


		/* -----> Mini Cart hooks <----- */

		// Add wrapper to minicart
		add_action( 'woocommerce_before_mini_cart', array( $this, 'minicart_wrapper_open' ) );
		add_action( 'woocommerce_after_mini_cart', array( $this, 'minicart_wrapper_close' ) );


		/* -----> Cart hooks <----- */

		// Move cart totals from collaterals into woocommerce_after_cart_contents
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
		add_action( 'woocommerce_after_cart_table', 'woocommerce_cart_totals', 10 );
	}

	/* -----> Construct functions <----- */
	public function custom_paypal_image(){
		return 'https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-small.png';
	}
	public function custom_image_sizes(){
		return array(
			'thumbnail_image_width' => 570,
		);
	}
	public function enqueue_style(){
		wp_enqueue_style( 'woo-styles', get_template_directory_uri() . '/woocommerce/assets/css/woocommerce.css', array(), SETECH__VERSION, 'all' );
		if( is_rtl() ){
			wp_enqueue_style( 'woo-rtl-styles', get_template_directory_uri() . '/woocommerce/assets/css/woocommerce-rtl.css', array(), SETECH__VERSION, 'all' );
		}
	}
	public function enqueue_scripts(){
		global $wp_query;

		wp_enqueue_script( 'woo-scripts', get_template_directory_uri() . '/woocommerce/assets/js/woo.js', array( 'rb-magnific-popup', 'rb-waypoints', 'rb-counterup' ), SETECH__VERSION, 'all' );

		wp_localize_script( 'woo-scripts', 'woo_script_load_more_params', array(
			'posts' => json_encode( $wp_query->query_vars ),
			'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
			'max_page' => $wp_query->max_num_pages
		) );
	}
	public function theme_supports(){
		add_theme_support( 'wc-product-gallery-zoom' );
	    add_theme_support( 'wc-product-gallery-lightbox' );
	    add_theme_support( 'wc-product-gallery-slider' );
	}
	public function ajax_add_to_cart() {
		WC_AJAX::get_refreshed_fragments();
		wp_die();
    }
    public function header_add_to_cart_fragment( $fragments ) {
		ob_start();
			?>
				<i class='woo_mini-count'><?php echo '<span>'. WC()->cart->cart_contents_count .'</span>' ?></i>
			<?php
		$fragments['.woo_mini-count'] = ob_get_clean();

		ob_start();
			woocommerce_mini_cart();
		$fragments['div.woo_mini_cart'] = ob_get_clean();
		return $fragments;
	}
    public function products_per_page(){
		if( get_theme_mod('woo_archive_count') ){
			$cols = (int)get_theme_mod('woo_archive_count');
		} else {
			$cols = 9;
		}
	  return $cols;
	}
	public function rb_related_products( $args ) {
		$args['posts_per_page'] = get_theme_mod('woo_related_count') ? get_theme_mod('woo_related_count') : 3;

		return $args;
	}
	public function my_new_paypal_icon() {
		return get_template_directory_uri() . '/woocommerce/assets/img/paypal-logo.png';
	}

	/* -----> Products loop functions <----- */
	public function archive_info_open(){
		echo '<div class="shop_top_info_wrapper">';
	}
	public function archive_info_close(){
		echo '</div>';
	}
	public function rb_tags_wrapper_open(){
		echo '<div class="rb_tags_wrapper">';
	}
	public function rb_tags_wrapper_close(){
		echo '</div>';
	}
	public function woocommerce_template_loop_rating_open(){
		echo '<div class="rb_rating_wrapper">';
	}
	public function woocommerce_template_loop_rating_close(){
		echo '</div>';
	}
	public function rb_new_tags(){
		global $product;

		// Sale tag
		if( $product->is_on_sale() ){

			$default = esc_html_x('Sale!', 'Product tag', 'setech');
			$regular = get_post_meta( $product->get_id(), '_regular_price', true);
			$sale = get_post_meta( $product->get_id(), '_sale_price', true);

			if( !empty($regular) && !empty($sale) ){
				$percent = 100 - ($sale * 100 / $regular);
				$text = '-'.(int)$percent.'%';
			} else {
				$text = $default;
			}

			echo '<span class="onsale" data-default="'.$default.'">'.$text.'</span>';
		}

		// HOT tag
		if( $product->is_featured() ){
			echo '<span class="rb_featured_product">'.esc_html_x("Hot", "Product tag", "setech").'</span>';
		}

		// NEW tag
		$postdate      = get_the_time( 'Y-m-d' );
		$postdatestamp = strtotime( $postdate );
		$newness       = get_theme_mod( 'woo_tag_lifetime' ) ? get_theme_mod( 'woo_tag_lifetime' ) : 14;
		if( ( time() - ( 60 * 60 * 24 * $newness ) ) < $postdatestamp ){
			echo '<span class="rb_new_product">' . esc_html_x( 'New', 'Product tag', 'setech' ) . '</span>';
		}
	}
	public function product_link_open(){
		global $product;
		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

		echo '<a href="' . esc_url( $link ) . '" class="product_link">';
	}
	public function rb_template_loop_product_link_open() {
		global $product;
		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

		echo '<div class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
	}
	public function rb_template_loop_product_link_close() {
		global $product;
		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

		echo '</div>';
	}
	public function rb_template_loop_product_info_open() {
		global $product;

		echo '<div class="woocommerce-information-wrapper">';
	}
	public function rb_template_loop_product_info_close() {
		global $product;

		echo '</div>';
	}

	/* -----> Single product functions <----- */
	public function rb_product_gallery_summary_wrapper_open(){
		echo '<div class="rb_gallery_summary_wrapper">';
	}
	public function rb_product_gallery_summary_wrapper_close(){
		echo '</div>';
	}

	/* -----> Load More function <----- */
	public function rb_woo_load_more_ajax(){
		$args = json_decode( stripslashes( $_POST['query'] ), true );
		$args['paged'] = $_POST['page'] + 1;
		$args['post_status'] = 'publish';

		$woo_posts = get_posts( $args );

		foreach($woo_posts as $post) : setup_postdata($post);
	 		wc_get_template_part( 'content', 'product' );
		endforeach;

		wp_die();
	}

	/* -----> Mini Cart functions <----- */
	public function minicart_wrapper_open (){
		echo "<div class='woo_mini_cart'>";

		if( get_theme_mod('woocommerce_mini_cart') == 'sidebar-view' ){
			$bag_text = WC()->cart->cart_contents_count;
			echo "<div class='woo_items_count'>" . sprintf( esc_html_x('MY BAG (%s)', 'frontend', 'setech'), $bag_text ) . "</div>";
			echo "<i class='close_mini_cart'></i>";
		}
	}
	public function minicart_wrapper_close (){
		echo "</div>";
	}
	public function rb_woocommerce_get_mini_cart_icon(){ 
		ob_start(); ?>
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="mini_cart_trigger">
			<i class='woo_mini-count'>
				<?php 
					echo '<span>'. WC()->cart->cart_contents_count .'</span>';
				?>
			</i>
		</a>
		<?php return ob_get_clean();
	}
	public function rb_woocommerce_get_mini_cart(){
		ob_start(); ?>
		<div class="mini-cart <?php echo get_theme_mod('woocommerce_mini_cart');?> ">
			<?php
				echo sprintf('%s', $this->rb_woocommerce_get_mini_cart_icon());
				woocommerce_mini_cart();
			?>
		</div>
		<?php 
		return ob_get_clean();
	}

}

global $seoes_woo_ext;
$seoes_woo_ext = new Setech_WooExt();

?>