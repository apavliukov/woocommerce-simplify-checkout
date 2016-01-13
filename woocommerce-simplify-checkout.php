<?php

/*
	Plugin Name:       Woocommerce Simplify Checkout
	Plugin URI:        https://github.com/tanzoor/woocommerce-simplify-checkout
	Description:       Short plugin for Woocommerce, which simplifies the ordering process.
	Version:           1.0.0
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

	$field_names = array(
		'billing_last_name',
		'billing_address_1',
		'billing_address_2',
		'billing_city',
		'billing_postcode',
		'billing_country',
		'billing_state',
		'billing_company'
	);

	foreach ($field_names as $field_name) {
		$fields['billing'][$field_name] = array(
	      'required' => false
	   	);
	}

    return $fields;
}

// Функция для получения значения опред. поля адреса клиента
// Чтобы не нагружать шаблон лишним кодом, вынес в отдельную функцию
if ( ! function_exists( 'get_address_field_value' ) ) {
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

// Убираем из корзины переход в чекаут
add_action( 'woocommerce_cart_collaterals', 'custom_checkout_form', 1 );
function custom_checkout_form() {

	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
	remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );

	load_template( plugin_dir_path( __FILE__ ) . 'templates/form-checkout.php', true );

}