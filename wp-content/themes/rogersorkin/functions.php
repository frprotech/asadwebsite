<?php
/**
 * Roger Sorkin Theme Functions & Definitions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Theme Setup
function rs_theme_setup() {
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );

    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    register_nav_menus( array(
        'primary' => __( 'Primary Navigation', 'rogersorkin' ),
        'footer'  => __( 'Footer Quick Links', 'rogersorkin' ),
    ) );
}
add_action( 'after_setup_theme', 'rs_theme_setup' );

// 2. Enqueue Styles & Scripts
function rs_enqueue_scripts() {
    wp_enqueue_style(
        'rs-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&family=Space+Mono:wght@400;700&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'rs-main-styles',
        get_template_directory_uri() . '/css/styles.css',
        array( 'rs-google-fonts' ),
        '1.2.0'
    );

    wp_enqueue_script(
        'rs-main-js',
        get_template_directory_uri() . '/js/main.js',
        array(),
        '1.2.0',
        true
    );

    wp_localize_script( 'rs-main-js', 'rsData', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'rs_contact_nonce' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'rs_enqueue_scripts' );

// 3. Load Modules
require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/theme-settings.php';
require_once get_template_directory() . '/inc/cpt.php';
require_once get_template_directory() . '/inc/acf.php';
require_once get_template_directory() . '/inc/ajax-handlers.php';
require_once get_template_directory() . '/inc/seeder.php';

// 4. Disable Block Editor for Pages & CPTs (Ensures ACF fields are front-and-center, not hidden under Gutenberg)
add_filter( 'use_block_editor_for_post_type', function( $use_block_editor, $post_type ) {
    if ( in_array( $post_type, array( 'page', 'service', 'project', 'testimonial' ), true ) ) {
        return false;
    }
    return $use_block_editor;
}, 10, 2 );

// 5. Admin Styling for ACF and Post Edit Screens
add_action( 'admin_head', function() {
    echo '<style>
        /* Modern styling for ACF postboxes */
        .postbox.acf-postbox {
            border-radius: 8px !important;
            border: 1px solid #cbd5e1 !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05) !important;
            margin-top: 20px !important;
            overflow: hidden !important;
        }
        .postbox.acf-postbox .postbox-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
            padding: 14px 18px !important;
            border-bottom: 1px solid #334155 !important;
        }
        .postbox.acf-postbox .postbox-header h2 {
            color: #f8fafc !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            letter-spacing: 0.02em !important;
        }
        .postbox.acf-postbox .toggle-indicator {
            color: #94a3b8 !important;
        }
        .acf-tab-group {
            background: #f1f5f9 !important;
            padding: 8px 12px 0 !important;
            border-bottom: 2px solid #e2e8f0 !important;
            margin: 0 !important;
        }
        .acf-tab-group li {
            margin-right: 6px !important;
        }
        .acf-tab-group li a {
            font-weight: 600 !important;
            font-size: 13px !important;
            padding: 10px 18px !important;
            background: #e2e8f0 !important;
            color: #475569 !important;
            border: 1px solid #cbd5e1 !important;
            border-bottom: none !important;
            border-radius: 6px 6px 0 0 !important;
            transition: all 0.15s ease !important;
        }
        .acf-tab-group li.active a {
            background: #ffffff !important;
            color: #0284c7 !important;
            border-color: #cbd5e1 !important;
            border-bottom: 2px solid #ffffff !important;
            margin-bottom: -2px !important;
            font-weight: 700 !important;
        }
        .acf-field .acf-label label {
            font-weight: 700 !important;
            color: #0f172a !important;
            font-size: 13px !important;
            margin-bottom: 6px !important;
        }
        .acf-field .acf-input input[type="text"],
        .acf-field .acf-input input[type="url"],
        .acf-field .acf-input textarea,
        .acf-field .acf-input select {
            border-radius: 6px !important;
            border: 1px solid #cbd5e1 !important;
            padding: 8px 12px !important;
            font-size: 14px !important;
            line-height: 1.5 !important;
            width: 100% !important;
            background: #ffffff !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        }
        .acf-field .acf-input input[type="text"]:focus,
        .acf-field .acf-input textarea:focus {
            border-color: #0284c7 !important;
            outline: none !important;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15) !important;
        }
        .acf-field .description {
            color: #64748b !important;
            font-size: 12px !important;
            font-style: italic !important;
            margin-top: 4px !important;
        }
    </style>';
} );

// 6. Admin Notice with Quick Access Links
add_action( 'admin_notices', function() {
    $screen = get_current_screen();
    if ( $screen && $screen->id === 'toplevel_page_theme-settings' ) {
        return; // Don't clutter on the settings page itself
    }
    if ( current_user_can( 'manage_options' ) ) {
        $front_id = get_option( 'page_on_front' );
        echo '<div class="notice notice-info is-dismissible" style="padding: 12px 16px;">';
        echo '<p style="margin: 0 0 8px 0;"><strong>Roger Sorkin Theme:</strong> Everything is ready to manage!</p>';
        echo '<div style="display: flex; gap: 8px; flex-wrap: wrap;">';
        echo '<a href="' . esc_url( admin_url( 'admin.php?page=theme-settings' ) ) . '" class="button button-primary button-small">⚙️ Theme Settings</a>';
        if ( $front_id ) {
            echo '<a href="' . esc_url( admin_url( 'post.php?post=' . $front_id . '&action=edit' ) ) . '" class="button button-secondary button-small">🏠 Edit Homepage</a>';
        }
        echo '<a href="' . esc_url( admin_url( 'edit.php?post_type=service' ) ) . '" class="button button-secondary button-small">💼 Edit Services</a>';
        echo '<a href="' . esc_url( admin_url( 'edit.php?post_type=project' ) ) . '" class="button button-secondary button-small">🎬 Edit Projects</a>';
        echo '<a href="' . esc_url( admin_url( 'edit.php?post_type=testimonial' ) ) . '" class="button button-secondary button-small">💬 Edit Testimonials</a>';
        echo '<a href="' . esc_url( admin_url( 'edit.php?post_type=page' ) ) . '" class="button button-secondary button-small">📄 All Pages</a>';
        echo '</div>';
        echo '</div>';
    }
} );
