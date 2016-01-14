<?php

/*
	Plugin Name:       Simplify checkout for Woocommerce
	Plugin URI:        https://github.com/tanzoor/woocommerce-simplify-checkout
	Description:       Уменьшает кол-во полей чекаута и переносит в корзину
	Version:           0.9.1
	Author:            Александр Павлюков
	License:           GNU General Public License v2
	License URI:       http://www.gnu.org/licenses/gpl-2.0.html
	GitHub Plugin URI: https://github.com/tanzoor/woocommerce-simplify-checkout
	GitHub Branch:     master
*/

// Отключаем выбор типа оплаты в чекауте
add_filter('woocommerce_cart_needs_payment', '__return_false');

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

// Функция для получения значения опред. поля адреса клиента
if ( !function_exists( 'get_address_field_value' ) ) {
	function get_address_field_value($customer_id, $field_name) {
		$load_address = 'billing';
		$address = WC()->countries->get_address_fields( get_user_meta( $customer_id, $load_address . '_country', true ), $load_address . '_' );

			foreach ( $address as $key => $field ) {
				$value = get_user_meta( get_current_user_id(), $key, true );
				if ( ! $value ) {
					switch( $key ) {
						case 'billing_email' :
							$value = $current_user->user_email;
						break;
					}
				}
				$address[ $key ]['value'] = apply_filters( 'woocommerce_my_account_edit_address_field_value', $value, $key, $load_address );
			}

		return ( !empty( $address[$field_name]['value'] ) ) ? $address[$field_name]['value'] : '' ;
	}
}

// Убираем из корзины переход в чекаут и ставим свою форму
add_action( 'woocommerce_cart_collaterals', 'custom_checkout_form', 1 );
function custom_checkout_form() {

	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );

	load_template( plugin_dir_path( __FILE__ ) . 'templates/form-checkout.php', true );

}