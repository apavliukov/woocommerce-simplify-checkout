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

// Убираем из корзины переход в чекаут
add_action( 'woocommerce_after_cart_table', 'fila_edit_collaterals_block' );
function fila_edit_collaterals_block() {

	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
	remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );

	// Убираем ненужный блок "Additional information"
	remove_all_actions( 'woocommerce_after_checkout_billing_form' );

	add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );

	echo '<h2 class="entry-title">Оформление заказа</h2>';	

	echo do_shortcode('[woocommerce_checkout]');

}