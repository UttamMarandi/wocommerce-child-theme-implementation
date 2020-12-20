<!-- Using hooks to add a div -->
add_action( 'woocommerce_before_shop_loop', function(){
    echo '<div class="imagewrapper-ut">';
}, 9 );


add_action( 'woocommerce_after_shop_loop', function(){
    echo '</div>';
}, 11 );