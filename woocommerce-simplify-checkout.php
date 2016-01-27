<?php

/*
	Plugin Name:       Woocommerce Simplify Checkout
	Plugin URI:        https://github.com/tanzoor/woocommerce-simplify-checkout
	Description:       Уменьшает кол-во полей чекаута и переносит в корзину
	Version:           1.0.0
	Author:            Александр Павлюков
	License:           GNU General Public License v2
	License URI:       http://www.gnu.org/licenses/gpl-2.0.html
	GitHub Plugin URI: https://github.com/tanzoor/woocommerce-simplify-checkout
	GitHub Branch:     master
*/

// Отключаем выбор типа оплаты
add_filter('woocommerce_cart_needs_payment', '__return_false');

// Отключаем выбор способа доставки
add_filter('woocommerce_cart_needs_shipping', '__return_false');

// Убираем ненужные поля
add_filter( 'woocommerce_checkout_fields' , 'remove_extra_checkout_fields' );
function remove_extra_checkout_fields( $fields ) {

	unset( $fields['billing']['billing_last_name'] );
	unset( $fields['billing']['billing_company'] );
	unset( $fields['billing']['billing_address_1'] );
	unset( $fields['billing']['billing_address_2'] );
	unset( $fields['billing']['billing_city'] );
	unset( $fields['billing']['billing_postcode'] );
	unset( $fields['billing']['billing_country'] );
	unset( $fields['billing']['billing_state'] );

	unset( $fields['shipping']['shipping_first_name'] );
	unset( $fields['shipping']['shipping_last_name'] );
	unset( $fields['shipping']['shipping_company'] );
	unset( $fields['shipping']['shipping_address_1'] );
	unset( $fields['shipping']['shipping_address_2'] );
	unset( $fields['shipping']['shipping_city'] );
	unset( $fields['shipping']['shipping_postcode'] );
	unset( $fields['shipping']['shipping_country'] );
	unset( $fields['shipping']['shipping_state'] );

	unset( $fields['account']['account_username'] );
	unset( $fields['account']['account_password'] );
	unset( $fields['account']['account_password-2'] );
	
	unset( $fields['order']['order_comments'] );

    return $fields;
}

// Убираем из корзины переход в чекаут и ставим свою форму
add_action( 'woocommerce_cart_collaterals', 'custom_checkout_form', 1 );
function custom_checkout_form() {

	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );

	load_template( plugin_dir_path( __FILE__ ) . 'templates/form-checkout.php', true );

}