<?php
/*
 * 	Custom Checkout Form
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

$checkout = WC()->checkout();

$customer_id = get_current_user_id();

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

?>

<h2 class="entry-title">Оформление заказа</h2>

<form name="checkout" method="post" class="checkout woocommerce-checkout form-horizontal" action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" enctype="multipart/form-data">

	<div class="row">
		<div class="col-md-4">

			<div class="form-group">
				<label for="billing_first_name" class="control-label col-md-3"><?php _e( 'First name', 'woocommerce' ); ?></label>
				<div class="col-md-9">
					<input type="text" class="input-text form-control" name="billing_first_name" id="billing_firts_name" required="required" placeholder="" value="<?php esc_attr_e( get_user_meta( $customer_id, 'billing_first_name', true ) ); ?>">
				</div>
			</div>

			<div class="form-group">
				<label for="billing_phone" class="control-label col-md-3"><?php _e( 'Phone', 'woocommerce' ); ?></label>
				<div class="col-md-9">
					<input type="text" class="input-text form-control" name="billing_phone" id="billing_phone" required="required" placeholder="" value="<?php esc_attr_e( get_user_meta( $customer_id, 'billing_phone', true ) ); ?>">
				</div>
			</div>

			<div class="form-group">
				<label for="account_email" class="control-label col-md-3"><?php _e( 'Email address', 'woocommerce' ); ?></label>
				<div class="col-md-9">
					<input type="email" class="input-text form-control" name="billing_email" id="billing_email" required="required" placeholder="" value="<?php esc_attr_e( get_user_meta( $customer_id, 'billing_email', true ) ); ?>" />
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-9 col-md-offset-3 checkout-submit">
					<?php wp_nonce_field( 'woocommerce-process_checkout' ); ?>
					<input type="submit" class="btn btn-submit" name="woocommerce_checkout_place_order" id="place_order" value="Оформить заказ" data-value="Оформить заказ" />
				</div>
			</div>

		</div>
	</div>

</form>