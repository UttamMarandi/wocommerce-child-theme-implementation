<!-- Using hooks to add a div -->
add_action( 'woocommerce_before_shop_loop', function(){
    echo '<div class="imagewrapper-ut">';
}, 9 );


add_action( 'woocommerce_after_shop_loop', function(){
    echo '</div>';
}, 11 );

/**
 * Change number or products per row to 3
 */
add_filter('loop_shop_columns', 'loop_columns', 999);
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}

// Display product tile on top

function product_change_title_position() {
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	add_action( 'woocommerce_before_single_product', 'woocommerce_template_single_title', 5 );
}

add_action( 'init', 'product_change_title_position' );

// Related Products
add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args', 20 );
  function jk_related_products_args( $args ) {
	$args['posts_per_page'] = 3; // 4 related products
	$args['columns'] = 3; // arranged in 2 columns
	return $args;
}

// Checkout redirect
add_filter( 'woocommerce_add_to_cart_redirect', 'skip_woo_cart' );
 
function skip_woo_cart() {
   return wc_get_checkout_url();
}

//Change add to cart text in product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Buy Now', 'woocommerce' ); 
}

//Add to cart redirect to product page
function my_custom_add_to_cart_redirect( $url ) {
if ( ! isset( $_REQUEST[‘add-to-cart’] ) || ! is_numeric( $_REQUEST[‘add-to-cart’] ) ) {
return $url;
}
$product_id = apply_filters( ‘woocommerce_add_to_cart_product_id’, absint( $_REQUEST[‘add-to-cart’] ) );
// Only redirect products with the ‘small-item’ shipping class
$url = get_permalink( $product_id );
return $url;
}
add_filter( ‘woocommerce_add_to_cart_redirect’, ‘my_custom_add_to_cart_redirect’ );

//Add to redirect to product page


add_filter( 'woocommerce_loop_add_to_cart_link', 'ts_replace_add_to_cart_button', 10, 2 );
function ts_replace_add_to_cart_button( $button, $product ) {
if (is_product_category() || is_shop()) {
$button_text = __("View Product", "woocommerce");
$button_link = $product->get_permalink();
$button = '<a href="' . $button_link . '">' . $button_text . '</a>';
return $button;
}
}
add_action( 'woocommerce_before_cart', function(){
    echo '<div class="cart-loop-ut">';
}, 9 );
add_action( 'woocommerce_after_cart', function(){
    echo '</div>';
}, 11 );


//Cart update on menu
/**
 * Ensure cart contents update when products are added to the cart via AJAX
 */
function my_header_add_to_cart_fragment( $fragments ) {
 
    ob_start();
    $count = WC()->cart->cart_contents_count;
    ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php
    if ( $count > 0 ) {
        ?>
        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
        <?php            
    }
        ?></a><?php
 
    $fragments['a.cart-contents'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );

