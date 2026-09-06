<?php
/**
 * Native Theme Settings Page for Roger Sorkin Theme
 *
 * Works 100% reliably with or without ACF PRO.
 * Saves values directly to WordPress options (options_{$key} and rs_{$key})
 * so both native get_option() and ACF get_field('key', 'option') work seamlessly.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register top-level admin menu
add_action( 'admin_menu', 'rs_register_theme_settings_menu' );
function rs_register_theme_settings_menu() {
    add_menu_page(
        'Theme Settings',
        'Theme Settings',
        'manage_options',
        'theme-settings',
        'rs_render_theme_settings_page',
        'dashicons-admin-generic',
        59
    );
}

// Handle Form Submission
add_action( 'admin_init', 'rs_handle_theme_settings_save' );
function rs_handle_theme_settings_save() {
    if ( ! isset( $_POST['rs_settings_nonce'] ) || ! wp_verify_nonce( $_POST['rs_settings_nonce'], 'rs_save_settings' ) ) {
        return;
    }

    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $fields = array(
        'brand_name',
        'brand_tagline',
        'header_cta_label',
        'header_cta_url',
        'contact_location',
        'contact_recipient_email',
        'linkedin_url',
        'amres_url',
        'footer_desc',
        'copyright_text',
        'showreel_video_url',
        'showreel_poster_url',
    );

    foreach ( $fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            $val = wp_unslash( $_POST[ $field ] );
            if ( in_array( $field, array( 'header_cta_url', 'linkedin_url', 'amres_url' ) ) ) {
                $val = esc_url_raw( $val );
            } elseif ( $field === 'contact_recipient_email' ) {
                $val = sanitize_email( $val );
            } elseif ( $field === 'footer_desc' ) {
                $val = sanitize_textarea_field( $val );
            } else {
                $val = sanitize_text_field( $val );
            }

            // Save under both prefixes for 100% compatibility
            update_option( 'options_' . $field, $val );
            update_option( 'rs_' . $field, $val );

            // Also sync to ACF if available
            if ( function_exists( 'update_field' ) ) {
                update_field( $field, $val, 'option' );
            }
        }
    }

    // Redirect with success flag
    wp_safe_redirect( admin_url( 'admin.php?page=theme-settings&updated=1' ) );
    exit;
}

// Render Settings Page
function rs_render_theme_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $brand_name     = rs_get_option( 'brand_name', 'ROGER SORKIN' );
    $brand_tagline  = rs_get_option( 'brand_tagline', 'STRATEGIC NARRATIVES' );
    $cta_label      = rs_get_option( 'header_cta_label', 'Work With Me' );
    $cta_url        = rs_get_option( 'header_cta_url', '/contact/' );
    $location       = rs_get_option( 'contact_location', 'Washington, D.C. & Worldwide Projects' );
    $email          = rs_get_option( 'contact_recipient_email', get_option( 'admin_email' ) );
    $linkedin       = rs_get_option( 'linkedin_url', 'https://www.linkedin.com/in/rogersorkin/' );
    $amres          = rs_get_option( 'amres_url', 'https://www.amresproject.org/' );
    $footer_desc    = rs_get_option( 'footer_desc', 'Translating complex environmental, economic, and security challenges into bipartisan strategic narratives and attainable calls-to-action.' );
    $copyright      = rs_get_option( 'copyright_text', 'Copyright Roger Sorkin. All Rights Reserved.' );
    $showreel_vid   = rs_get_option( 'showreel_video_url', 'hero/RS-website-banner-4.mp4' );
    $showreel_post  = rs_get_option( 'showreel_poster_url', 'hero/hp-bg.webp' );

    $active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'general';
    ?>
    <div class="wrap" style="max-width: 1000px;">
        <h1 style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
            <span class="dashicons dashicons-admin-generic" style="font-size: 32px; width: 32px; height: 32px;"></span>
            Roger Sorkin Theme Settings
        </h1>

        <?php if ( isset( $_GET['updated'] ) ) : ?>
            <div class="notice notice-success is-dismissible">
                <p><strong>Settings saved successfully!</strong></p>
            </div>
        <?php endif; ?>

        <?php if ( isset( $_GET['seeded'] ) ) : ?>
            <div class="notice notice-success is-dismissible">
                <p><strong>Demo content and default settings have been seeded successfully!</strong></p>
            </div>
        <?php endif; ?>

        <nav class="nav-tab-wrapper" style="margin-bottom: 24px;">
            <a href="?page=theme-settings&tab=general" class="nav-tab <?php echo $active_tab === 'general' ? 'nav-tab-active' : ''; ?>">Brand &amp; Header</a>
            <a href="?page=theme-settings&tab=contact" class="nav-tab <?php echo $active_tab === 'contact' ? 'nav-tab-active' : ''; ?>">Contact &amp; Social</a>
            <a href="?page=theme-settings&tab=footer" class="nav-tab <?php echo $active_tab === 'footer' ? 'nav-tab-active' : ''; ?>">Footer</a>
            <a href="?page=theme-settings&tab=media" class="nav-tab <?php echo $active_tab === 'media' ? 'nav-tab-active' : ''; ?>">Showreel Video</a>
            <a href="?page=theme-settings&tab=tools" class="nav-tab <?php echo $active_tab === 'tools' ? 'nav-tab-active' : ''; ?>">Tools &amp; Seeder</a>
        </nav>

        <form method="post" action="">
            <?php wp_nonce_field( 'rs_save_settings', 'rs_settings_nonce' ); ?>

            <?php if ( $active_tab === 'general' ) : ?>
                <div class="card" style="padding: 20px 24px; max-width: 100%;">
                    <h2>Brand Identity &amp; Header Navigation</h2>
                    <p class="description">Manage the brand name, tagline, and primary call-to-action button in the header.</p>
                    
                    <table class="form-table" role="presentation">
                        <tr>
                            <th scope="row"><label for="brand_name">Brand Name</label></th>
                            <td>
                                <input name="brand_name" type="text" id="brand_name" value="<?php echo esc_attr( $brand_name ); ?>" class="regular-text" />
                                <p class="description">Default: ROGER SORKIN</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="brand_tagline">Brand Tagline</label></th>
                            <td>
                                <input name="brand_tagline" type="text" id="brand_tagline" value="<?php echo esc_attr( $brand_tagline ); ?>" class="regular-text" />
                                <p class="description">Default: STRATEGIC NARRATIVES</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="header_cta_label">Header Button Label</label></th>
                            <td>
                                <input name="header_cta_label" type="text" id="header_cta_label" value="<?php echo esc_attr( $cta_label ); ?>" class="regular-text" />
                                <p class="description">Default: Work With Me</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="header_cta_url">Header Button URL</label></th>
                            <td>
                                <input name="header_cta_url" type="text" id="header_cta_url" value="<?php echo esc_attr( $cta_url ); ?>" class="regular-text" />
                                <p class="description">Default: /contact/</p>
                            </td>
                        </tr>
                    </table>
                </div>

            <?php elseif ( $active_tab === 'contact' ) : ?>
                <div class="card" style="padding: 20px 24px; max-width: 100%;">
                    <h2>Contact Information &amp; Social Links</h2>
                    <p class="description">Global contact details and organizational profile links.</p>

                    <table class="form-table" role="presentation">
                        <tr>
                            <th scope="row"><label for="contact_location">Office Location / Region</label></th>
                            <td>
                                <input name="contact_location" type="text" id="contact_location" value="<?php echo esc_attr( $location ); ?>" class="large-text" />
                                <p class="description">e.g. Washington, D.C. &amp; Worldwide Projects</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="contact_recipient_email">Form Inquiries Email</label></th>
                            <td>
                                <input name="contact_recipient_email" type="email" id="contact_recipient_email" value="<?php echo esc_attr( $email ); ?>" class="regular-text" />
                                <p class="description">Contact form submissions are forwarded here.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="linkedin_url">LinkedIn Profile URL</label></th>
                            <td>
                                <input name="linkedin_url" type="url" id="linkedin_url" value="<?php echo esc_attr( $linkedin ); ?>" class="large-text" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="amres_url">American Resilience Project URL</label></th>
                            <td>
                                <input name="amres_url" type="url" id="amres_url" value="<?php echo esc_attr( $amres ); ?>" class="large-text" />
                            </td>
                        </tr>
                    </table>
                </div>

            <?php elseif ( $active_tab === 'footer' ) : ?>
                <div class="card" style="padding: 20px 24px; max-width: 100%;">
                    <h2>Footer Content</h2>
                    <p class="description">Content displayed at the bottom of every page.</p>

                    <table class="form-table" role="presentation">
                        <tr>
                            <th scope="row"><label for="footer_desc">Footer Mission Statement</label></th>
                            <td>
                                <textarea name="footer_desc" id="footer_desc" rows="4" class="large-text"><?php echo esc_textarea( $footer_desc ); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="copyright_text">Copyright Text</label></th>
                            <td>
                                <input name="copyright_text" type="text" id="copyright_text" value="<?php echo esc_attr( $copyright ); ?>" class="large-text" />
                            </td>
                        </tr>
                    </table>
                </div>

            <?php elseif ( $active_tab === 'media' ) : ?>
                <div class="card" style="padding: 20px 24px; max-width: 100%;">
                    <h2>Showreel &amp; Media Banner</h2>
                    <p class="description">Video showreel opened via the "Watch Showreel" modal.</p>

                    <table class="form-table" role="presentation">
                        <tr>
                            <th scope="row"><label for="showreel_video_url">Video MP4 URL or Path</label></th>
                            <td>
                                <input name="showreel_video_url" type="text" id="showreel_video_url" value="<?php echo esc_attr( $showreel_vid ); ?>" class="large-text" />
                                <p class="description">Relative to theme assets/ or full https:// URL. Default: <code>hero/RS-website-banner-4.mp4</code></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="showreel_poster_url">Video Poster Image</label></th>
                            <td>
                                <input name="showreel_poster_url" type="text" id="showreel_poster_url" value="<?php echo esc_attr( $showreel_post ); ?>" class="large-text" />
                                <p class="description">Default: <code>hero/hp-bg.webp</code></p>
                            </td>
                        </tr>
                    </table>
                </div>

            <?php elseif ( $active_tab === 'tools' ) : ?>
                <div class="card" style="padding: 20px 24px; max-width: 100%;">
                    <h2>Demo Content &amp; Setup Tools</h2>
                    <p class="description">Use these utilities to populate or reset the website with all demo case studies, services, testimonials, and page structures.</p>

                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-top: 16px;">
                        <h3 style="margin-top: 0;">Restore / Seed All Demo Content</h3>
                        <p>This automatically creates/populates:
                            <ul style="list-style: disc; padding-left: 20px;">
                                <li>All 6 Core Pages (Home, About, Services, Projects, Blog, Contact)</li>
                                <li>All 8 Services CPT entries with full deliverables and tags</li>
                                <li>All 11 Case Study Projects with full strategic snapshots, metrics, purpose &amp; impact</li>
                                <li>All 4 Testimonials</li>
                                <li>Primary Navigation Menu</li>
                                <li>Global Theme Settings</li>
                            </ul>
                        </p>
                        <p>
                            <a href="<?php echo esc_url( admin_url( 'admin.php?page=theme-settings&action=reseed&_wpnonce=' . wp_create_nonce('rs_reseed_nonce') ) ); ?>" class="button button-primary button-hero" onclick="return confirm('Are you sure you want to seed/reset all demo content? Existing matching posts will be updated.');">
                                🚀 Seed / Reset All Demo Content Now
                            </a>
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ( $active_tab !== 'tools' ) : ?>
                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-primary button-large" value="Save Changes" />
                </p>
            <?php endif; ?>
        </form>
    </div>
    <?php
}

// Handle 1-click reseed from tools tab
add_action( 'admin_init', 'rs_handle_reseed_action' );
function rs_handle_reseed_action() {
    if ( isset( $_GET['page'] ) && $_GET['page'] === 'theme-settings' && isset( $_GET['action'] ) && $_GET['action'] === 'reseed' ) {
        if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'rs_reseed_nonce' ) ) {
            wp_die( 'Security check failed.' );
        }
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Unauthorized.' );
        }

        if ( function_exists( 'rs_seed_initial_content' ) ) {
            rs_seed_initial_content( true );
        }

        wp_safe_redirect( admin_url( 'admin.php?page=theme-settings&tab=tools&seeded=1' ) );
        exit;
    }
}
