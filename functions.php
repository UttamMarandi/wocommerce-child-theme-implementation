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


