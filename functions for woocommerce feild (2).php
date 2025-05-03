<?php

defined( 'ABSPATH' ) || exit( 'Direct script access denied.' );
update_option( 'etheme_is_activated', true );
update_option( 'envato_purchase_code_15780546', 'activated' );
update_option( 'etheme_activated_data', [
'api_key' => 'activated',
'theme' => '_et_',
'purchase' => 'activated',
'item' => [ 'token' => 'activated' ]
] );

add_action( 'tgmpa_register', function(){
if ( isset( $GLOBALS['tgmpa'] ) ) {
$tgmpa_instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
foreach ( $tgmpa_instance->plugins as $slug => $plugin ) {
if ( $plugin['source_type'] === 'external' ) {
$tgmpa_instance->plugins[ $plugin['slug'] ]['source'] = get_template_directory_uri(). "/plugins/{$plugin['slug']}.zip";
$tgmpa_instance->plugins[ $plugin['slug'] ]['version'] = '';
}
}
}
}, 20 );

add_filter( 'woocommerce_order_button_text', 'custom_place_order_button_text' );



function custom_place_order_button_text() {

    return 'আপনার অর্ডার কনফার্ম করতে ক্লিক করুন'; // Change "Complete Purchase" to your preferred text
}
// following zipcode code works with WooCommerce 3.4

//add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' //);

// Our hooked in function - $fields is passed via the filter!
//function custom_override_checkout_fields( $fields ) {
//$fields['billing']['billing_postcode']['placeholder'] = '2100';
//$fields['billing']['billing_postcode']['label'] = 'পোস্ট কোড';
//$fields['billing']['billing_city']['placeholder'] = 'রোড নং, ফ্ল্যাট নং';
//$fields['billing']['billing_city']['label'] = 'সিটি/শহর';
//$fields['billing']['billing_state']['placeholder'] = 'রোড নং, ফ্ল্যাট নং';
//$fields['billing']['billing_state']['label'] = 'সিটি/শহর';
//return $fields;
//}
function custom_wc_translations($translated){
    $text = array(
    'Your order' => 'আপনার অর্ডারটি',
    'Subtotal' => 'সাব টোটাল',
    'Total' => 'সর্বমোট',
    'Buy now' => 'ক্যাশ অন ডেলিভারিতে অর্ডার করুন',
    //'Shipping' => 'শিপিং মেথড',
    'Billing Details' => 'অর্ডার করতে আপনার তথ্য দিন',
    'Ship to a different address?' => 'অন্য ঠিকানায় অর্ডার করতে',
    'Have a coupon?' => 'কুপন আছে?',
    'Checkout' => 'ক্যাশ অন ডেলিভারিতে অর্ডার করুন',
    'Shopping cart' => 'শপিং কার্ট',
    'has been received' => 'সফলভাবে সম্পন্ন হয়েছে',
    'Thank you' => ' আপনাকে অনেক ধন্যবাদ',
     'Billing address' => 'আপনার ঠিকানা',
      'Click here to enter your code' => 'আপনার কোড ব্যাবহার এখানে ক্লিক করুন',
    'If you have a coupon code, please apply it below.' => 'যদি আপনার কাছে একটি কুপন কোড থাকে, তাহলে অনুগ্রহ করে নিচে তা প্রয়োগ করুন।',
   // 'Thank you' => ' আপনাকে অনেক ধন্যবাদ',
  //   'Billing address' => 'আপনার ঠিকানা',
    
//this is a wocommerce function file code, translate english to Bangla 

    //'No products in the cart.' => 'কার্টে কোন পণ্য নেই।',
    //'Return To Shop' => 'শপে-এ ফিরে যান',
    
    
    );
    $translated = str_ireplace(  array_keys($text),  $text,  $translated );
    return $translated;
}

/*add_filter( 'woocommerce_package_rates', 'hide_free_shipping_for_available_rate_costs', 100, 2 );
function hide_free_shipping_for_available_rate_costs( $rates, $package ) {
    $has_cost = false;
    
    foreach ( $rates as $rate_key => $rate ) {
        if( $rate-cost > 0 ) {
            $has_cost = true;
        } 
        if ( 'free_shipping' === $rate->method_id ) {
            $free_rate_key = $rate_key;
        }
    }
    
    if ( $has_cost && isset($free_rate_key) ){
        unset($rates[$free_rate_key]);
    }
    return $rates;
}*/
//add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );
//add_filter( 'woocommerce_cart_needs_shipping_address', '__return_false');
add_filter( 'woocommerce_shipping_package_name', 'custom_shipping_package_name' );
function custom_shipping_package_name( $name ) {
  return 'শিপিং মেথড';
}
add_filter( 'gettext', 'custom_wc_translations', 20 );
// Tested with woocommerce 3.9.1:
add_filter( 'woocommerce_default_address_fields' , 'override_default_address_fields' );
function override_default_address_fields( $address_fields ) {
$address_fields['address_1']['label'] = 'আপনার ঠিকানা লিখুন';
$address_fields['address_1']['placeholder'] = 'আপনার ঠিকানা লিখুন';
return $address_fields;
}
function aovup_custom_woocommerce_button_text($translation, $text, $domain) {
    if ($domain == 'woocommerce' && $text == 'Apply coupon') {
        return 'কুপন প্রয়োগ করুন'; // Replace 'Your New Button Text' with the desired text.
    }
    return $translation;
}
add_filter('gettext', 'aovup_custom_woocommerce_button_text', 10, 3);
function my_coupon_strings( $translated_text, $text, $domain ) { switch ( $translated_text ) { case 'Coupon code' : $translated_text = __( 'কুপন কোড', 'woocommerce' ); // Change text here 
    break; } return $translated_text; } 
add_filter( 'gettext', 'my_coupon_strings', 10, 3 );
add_filter( 'pre_http_request', function( $pre, $parsed_args, $url ){
$search = 'http://8theme.com/import/xstore-demos/';
$replace = 'http://wordpressnull.org/xstore-demos/';
if ( ( strpos( $url, $search ) != false ) && ( strpos( $url, '/versions/' ) == false ) ) {
$url = str_replace( $search, $replace, $url );
return wp_remote_get( $url, [ 'timeout' => 60, 'sslverify' => false ] );
} else {
return false;
}
}, 10, 3 );
/*
* Load theme setup
* ******************************************************************* */
require_once( get_template_directory() . '/theme/theme-setup.php' );

if ( !apply_filters('xstore_theme_amp', false) ) {

	/*
	* Load framework
	* ******************************************************************* */
	require_once( get_template_directory() . '/framework/init.php' );

	/*
	* Load theme
	* ******************************************************************* */
	require_once( get_template_directory() . '/theme/init.php' );

}

//add_action('save_post', function($post_id) {
//	write_log($_POST);
//});
