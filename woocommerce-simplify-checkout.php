<?php

/*
	Plugin Name:       Woocommerce Simplify Checkout
	Plugin URI:        https://github.com/tanzoor/woocommerce-simplify-checkout
	Description:       Short plugin for Woocommerce, which simplifies the ordering process.
	Version:           0.1.0
	Author:            Alexander Pavlyukov
	License:           GNU General Public License v2
	License URI:       http://www.gnu.org/licenses/gpl-2.0.html
	GitHub Plugin URI: https://github.com/tanzoor/woocommerce-simplify-checkout
	GitHub Branch:     master
*/

// Отключаем выбор типа оплаты в чекауте
add_filter('woocommerce_cart_needs_payment', '__return_false');

// Делаем отстутствующие обязательные поля необязательными
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {

	$fields['billing']['billing_last_name'] = array(
      'required' => false
   	);

   	$fields['billing']['billing_address_1'] = array(
      'required' => false
   	);

   	$fields['billing']['billing_city'] = array(
      'required' => false
   	);

    return $fields;
}

// Убираем из корзины переход в чекаут
add_action( 'woocommerce_cart_collaterals', 'fila_edit_collaterals_block', 1 );
function fila_edit_collaterals_block() {

	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
	remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );

	load_template( plugin_dir_path( __FILE__ ) . 'templates/form-checkout.php', true );

}