<?php

add_action( 'plugins_loaded', function() {
    if( function_exists( '\boxnow_order_completed' ) ) {
        add_action( 'woocommerce_order_status_on-hold', '\boxnow_order_completed' );
    }
} );

add_action( 'woocommerce_after_checkout_validation', 'boxnow_automat_checkout_validation', 10, 2 );

function boxnow_automat_checkout_validation( $data, $errors ) {
    $chosen_shipping_method = WC()->session->get( 'chosen_shipping_methods' );
    $chosen_method = ! empty( $chosen_shipping_method ) ? $chosen_shipping_method[0] : null;

    if( empty( $chosen_method ) || $chosen_method !== 'box_now_delivery' ) {
        return;
    }

    if( empty( $data['_boxnow_locker_id'] ) ) {
        $errors->add( 'shipping', 'Не е избран BOX NOW автомат.' );
    }
}