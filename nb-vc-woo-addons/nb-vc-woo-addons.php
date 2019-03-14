<?php
/*
Plugin Name: NextBridge Visual Composer WooCommerce Addons
Plugin URI: https://nextbridge.com.pk/
Description: An extension for Visual Composer that displays Woocommerce product's grid
Author: Waqas Hassan
Version: 1.0.0
Author URI: https://nextbridge.com.pk/
*/

// Before VC Init

add_action( 'vc_before_init', 'nextbridge_vc_before_init_actions' );

function nextbridge_vc_before_init_actions() {
// Require new custom Element
	include( plugin_dir_path( __FILE__ ) . 'vc-woo-grid-element.php');
  include( plugin_dir_path( __FILE__ ) . 'vc-plain-section-element.php');
  include( plugin_dir_path( __FILE__ ) . 'vc-image-strip-element.php');
}

// Link directory stylesheet
function nextbridge_vc_scripts() {
    wp_enqueue_style( 'nextbridge_vc_stylesheet',  plugin_dir_url( __FILE__ ) . 'styling/nb-vc-woo-styling.css' );
}
add_action( 'wp_enqueue_scripts', 'nextbridge_vc_scripts' );


//Add Multi Select Shortcode
vc_add_shortcode_param( 'dropdown_multi', 'dropdown_multi_settings_field' );
function dropdown_multi_settings_field( $param, $value ) {
   $param_line = '';
   $param_line .= '<select multiple name="'. esc_attr( $param['param_name'] ).'" class="wpb_vc_param_value wpb-input wpb-select '. esc_attr( $param['param_name'] ).' '. esc_attr($param['type']).'">';

   foreach ( $param['value'] as $text_val => $val ) {
       if ( is_numeric($text_val) && (is_string($val) || is_numeric($val)) ) {
                    $text_val = $val;
                }
                $text_val = __($text_val, "js_composer");
                $selected = '';

                if(!is_array($value)) {
                    $param_value_arr = explode(',',$value);
                } else {
                    $param_value_arr = $value;
                }

                if ($value!=='' && in_array($val, $param_value_arr)) {
                    $selected = ' selected="selected"';
                }
                $param_line .= '<option class="'.$val.'" value="'.$val.'"'.$selected.'>'.$text_val.'</option>';
            }
   $param_line .= '</select>';

   return  $param_line;
}


/**
 * Create Custom Members Price Field for Woocommerce Product
 * @since 1.0.0
 */
function nb_create_member_price_field() {
	$args = array(
		'id' => 'member_price',
		'label' => __( 'Members Price', 'cfwc' ),
		'class' => 'nb-custom-field',
		'desc_tip' => true,
		'description' => __( 'The price for members.', 'rider-ways' ),
	);
	woocommerce_wp_text_input( $args );
}
add_action( 'woocommerce_product_options_general_product_data', 'nb_create_member_price_field' );


/**
 * Save Custom Members Price Field for Woocommerce Product
 * @since 1.0.0
 */
function nb_save_custom_field( $post_id ) {
  $product = wc_get_product( $post_id );
  $title = isset( $_POST['member_price'] ) ? $_POST['member_price'] : '';
  $product->update_meta_data( 'member_price', sanitize_text_field( $title ) );
  $product->save();
}
add_action( 'woocommerce_process_product_meta', 'nb_save_custom_field' );
