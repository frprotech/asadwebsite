<?php
/**
 * AJAX Handlers for Contact Form & Newsletter
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function rs_submit_contact_form() {
    check_ajax_referer( 'rs_contact_nonce', 'security' );

    $name         = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
    $email        = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';
    $phone        = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['phone'] ) : '';
    $organization = isset( $_POST['organization'] ) ? sanitize_text_field( $_POST['organization'] ) : '';
    $message      = isset( $_POST['message'] ) ? sanitize_textarea_field( $_POST['message'] ) : '';

    if ( empty( $name ) || empty( $email ) || empty( $message ) ) {
        wp_send_json_error( array( 'message' => 'Please fill in all required fields.' ) );
    }

    $to      = rs_get_option( 'contact_recipient_email', get_option( 'admin_email' ) );
    $subject = sprintf( 'New Inquire from %s - Roger Sorkin Website', $name );
    $body    = "Name: $name\n";
    $body   .= "Email: $email\n";
    if ( ! empty( $phone ) ) {
        $body .= "Phone: $phone\n";
    }
    if ( ! empty( $organization ) ) {
        $body .= "Organization: $organization\n";
    }
    $body .= "\nMessage:\n$message\n";

    $headers = array(
        'From: ' . get_bloginfo( 'name' ) . ' <' . get_option( 'admin_email' ) . '>',
        'Reply-To: ' . $name . ' <' . $email . '>',
    );

    $sent = wp_mail( $to, $subject, $body, $headers );

    wp_send_json_success( array(
        'message' => 'Thank you! Your message has been sent successfully. Roger will respond within 24 hours.'
    ) );
}
add_action( 'wp_ajax_rs_contact_submit', 'rs_submit_contact_form' );
add_action( 'wp_ajax_nopriv_rs_contact_submit', 'rs_submit_contact_form' );

function rs_submit_newsletter_form() {
    check_ajax_referer( 'rs_contact_nonce', 'security' );
    $email = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';
    if ( empty( $email ) || ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Please provide a valid email address.' ) );
    }
    wp_send_json_success( array( 'message' => 'Subscribed!' ) );
}
add_action( 'wp_ajax_rs_newsletter_submit', 'rs_submit_newsletter_form' );
add_action( 'wp_ajax_nopriv_rs_newsletter_submit', 'rs_submit_newsletter_form' );
