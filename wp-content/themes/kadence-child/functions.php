<?php 
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}
function disable_search( $query, $error = true ) {
  if ( is_search() ) {
    $query->is_search = false;
    $query->query_vars[s] = false;
    $query->query[s] = false;
    // to error
    if ( $error == true )
    $query->is_404 = true;
  }
}

add_action( 'parse_query', 'disable_search' );
add_filter( 'get_search_form', create_function( '$a', "return null;" ) );

// add_action('woocommerce_add_to_cart1', 'custom_add_to_cart');
// add_action('woocommerce_order_status_completed', 'completed_payment');
// add_action('woocommerce_payment_complete', 'completed_payment');
function completed_payment(){}
function custom_add_to_cart() {}
// add_action( 'template_redirect', 'cacas' );
add_action( 'woocommerce_add_to_cart', 'my_add_product_to_cart' );
    function my_add_product_to_cart($data) {
    	$page = get_page_by_title('cart');
    	echo "<pre>";
    	// print_r($data);
    	// print_r($page);
    	echo "</pre>";
      // header("Location: http://localhost/wp-cli-01/cart/");

  		// wp_redirect("http://localhost/wp-cli-01/");
      // wp_safe_redirect("/wp-cli-01/cart/");
    	$page->post_content .= "<a href='cacas'>vavasv</a>";

		wp_redirect(get_permalink($page->ID));
		exit;
      // if ( ! is_admin() ) {
      //   $product_id = 32; //your predeterminate product id
      //   $found = false;
      //   //check if product is not already in cart
      //   if ( sizeof( WC()->cart->get_cart() ) > 0 ) {
      //     foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
      //       $_product = $values['data'];
      //       if ( $_product->get_id() == $product_id )
      //         $found = true;
      //     }
      //     // if product not found, add it
      //     if ( ! $found )
      //       WC()->cart->add_to_cart( $product_id );
      //   } else {
      //     // if no products in cart, add it
      //     WC()->cart->add_to_cart( $product_id );
      //   }
      // }
    }




function custom_override_checkout_fields( $address_fields ) {
    // echo "address_fields:<pre>";
    // // var_dump($address_fields);
    // print_r($address_fields);
    // die;
    unset($address_fields['billing']['billing_state']);
    unset($address_fields['billing']['billing_postcode']);
    unset($address_fields['billing']['shipping_city']);
    unset($address_fields['billing']['billing_country']);
    unset($address_fields['billing']['billing_address_1']);
    unset($address_fields['billing']['billing_address_2']);
    unset($address_fields['billing']['billing_city']);
    unset($address_fields['billing']['billing_company']);
    unset($address_fields['shipping']['shipping_company']);
    return $address_fields;
}
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );




add_action( 'woocommerce_thankyou', 'themefars_redirectcustom');

function themefars_redirectcustom( $order_id ){
$order = wc_get_order( $order_id );
$url = 'https://yoursite.com/custom-url';
if ( ! $order->has_status( 'failed' ) ) {
	wp_safe_redirect( $url );
exit;
}
}


add_action( 'woocommerce_loaded', 'my_front_end_function');
function my_front_end_function($data) {

	// wp_safe_redirect( "http://localhost/wp-cli-01/cart/" );
	// header("Location: http://localhost/wp-cli-01/cart/");
	// exit;
	print_r($data);
	echo "wp loaded";
    if ( !is_admin() ) { 
        // Only target the front end
        // Do what you need to do
    }
}
?>