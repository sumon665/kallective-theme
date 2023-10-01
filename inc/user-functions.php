<?php

add_action( 'wp_loaded', 'update_user_data');
add_action( 'wp_loaded', 'update_user_address');

function update_user_data(){
    if ( empty($_POST['update_user_data_nonce']) || ! wp_verify_nonce( $_POST['update_user_data_nonce'], 'update_user_data' ) ) {
        return;
    }

    if ( empty( $_POST['action'] ) || 'update_user_data' !== $_POST['action'] ) {
        return;
    }

    wc_nocache_headers();

    $user_id = get_current_user_id();

    if ( $user_id <= 0 ) {
        return;
    }

    $account_first_name   = ! empty( $_POST['account_first_name'] ) ? wc_clean( wp_unslash( $_POST['account_first_name'] ) ) : '';
    $account_last_name    = ! empty( $_POST['account_last_name'] ) ? wc_clean( wp_unslash( $_POST['account_last_name'] ) ) : '';
    $account_email        = ! empty( $_POST['account_email'] ) ? wc_clean( wp_unslash( $_POST['account_email'] ) ) : '';
    $pass_cur             = ! empty( $_POST['password_current'] ) ? $_POST['password_current'] : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.ValidatedSanitizedInput.MissingUnslash
    $pass1                = ! empty( $_POST['password_1'] ) ? $_POST['password_1'] : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.ValidatedSanitizedInput.MissingUnslash
    $pass2                = ! empty( $_POST['password_2'] ) ? $_POST['password_2'] : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.ValidatedSanitizedInput.MissingUnslash
    $save_pass            = true;

    $billing_phone        = ! empty( $_POST['billing_phone'] ) ? wc_clean( wp_unslash( $_POST['billing_phone'] ) ) : '';
    $birthday              = ! empty( $_POST['birthday'] ) ? wc_clean( wp_unslash( $_POST['birthday'] ) ) : '';

    // Current user data.
    $current_user       = get_user_by( 'id', $user_id );
    $current_first_name = $current_user->first_name;
    $current_last_name  = $current_user->last_name;
    $current_email      = $current_user->user_email;

    // New user data.
    $user               = new stdClass();
    $user->ID           = $user_id;
    $user->first_name   = $account_first_name;
    $user->last_name    = $account_last_name;

    if ( $account_email ) {
        $account_email = sanitize_email( $account_email );
        if ( ! is_email( $account_email ) ) {
            wc_add_notice( __( 'Please provide a valid email address.', 'woocommerce' ), 'error' );
        } elseif ( email_exists( $account_email ) && $account_email !== $current_user->user_email ) {
            wc_add_notice( __( 'This email address is already registered.', 'woocommerce' ), 'error' );
        }
        $user->user_email = $account_email;
    }

    if ( ! empty( $pass_cur ) && empty( $pass1 ) && empty( $pass2 ) ) {
        wc_add_notice( __( 'Please fill out all password fields.', 'woocommerce' ), 'error' );
        $save_pass = false;
    } elseif ( ! empty( $pass1 ) && empty( $pass_cur ) ) {
        wc_add_notice( __( 'Please enter your current password.', 'woocommerce' ), 'error' );
        $save_pass = false;
    } elseif ( ! empty( $pass1 ) && empty( $pass2 ) ) {
        wc_add_notice( __( 'Please re-enter your password.', 'woocommerce' ), 'error' );
        $save_pass = false;
    } elseif ( ( ! empty( $pass1 ) || ! empty( $pass2 ) ) && $pass1 !== $pass2 ) {
        wc_add_notice( __( 'New passwords do not match.', 'woocommerce' ), 'error' );
        $save_pass = false;
    } elseif ( ! empty( $pass1 ) && ! wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID ) ) {
        wc_add_notice( __( 'Your current password is incorrect.', 'woocommerce' ), 'error' );
        $save_pass = false;
    }

    if ( $pass1 && $save_pass ) {
        $user->user_pass = $pass1;
    }

    wp_update_user( $user );

    // Update customer object to keep data in sync.
    $customer = new WC_Customer( $user->ID );

    if ( $customer ) {
        // Keep billing data in sync if data changed.
        if ( is_email( $user->user_email ) && $current_email !== $user->user_email ) {
            $customer->set_billing_email( $user->user_email );
        }

        $customer->set_billing_first_name( $user->first_name . " " . $user->last_name);

        $customer->set_billing_phone( $billing_phone );

        $customer->save();
    }

    update_field( 'birthday', $birthday, $user->ID );

    wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
    exit;
}

function update_user_address(){
    if ( empty($_POST['update_user_address_nonce']) || ! wp_verify_nonce( $_POST['update_user_address_nonce'], 'update_user_address' ) ) {
        return;
    }

    if ( empty( $_POST['action'] ) || 'update_user_address' !== $_POST['action'] ) {
        return;
    }

    wc_nocache_headers();

    $user_id = get_current_user_id();

    if ( $user_id <= 0 ) {
        return;
    }

    $shipping_country     = ! empty( $_POST['shipping_country'] ) ? wc_clean( wp_unslash( $_POST['shipping_country'] ) ) : '';
    $shipping_city        = ! empty( $_POST['shipping_city'] ) ? wc_clean( wp_unslash( $_POST['shipping_city'] ) ) : '';
    $shipping_state       = ! empty( $_POST['shipping_state'] ) ? wc_clean( wp_unslash( $_POST['shipping_state'] ) ) : '';
    $shipping_postcode    = ! empty( $_POST['shipping_postcode'] ) ? $_POST['shipping_postcode'] : ''; 
    $address              = ! empty( $_POST['address'] ) ? $_POST['address'] : ''; 

    $customer = new WC_Customer( $user_id );

    if ( $customer ) {

        $customer->set_shipping_country( $shipping_country);
        $customer->set_shipping_city( $shipping_city );
        $customer->set_shipping_state( $shipping_state );
        $customer->set_shipping_postcode( $shipping_postcode );
        if($address){
            $address = explode(" ", $address);
            if(count($address) > 1)
                $customer->set_shipping_address_2(array_pop($address));
            $customer->set_shipping_address_1(implode(" ", $address));
        }
        $customer->save();
    }
}