<?php
/**
 * ACF Integration & Complete Dynamic Field Group Registration
 *
 * 100% Free ACF Compatible (uses text, textarea, wysiwyg, true_false, image, url).
 * No ACF PRO repeater dependency so all fields render properly in wp-admin.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Custom save/load points for ACF JSON
add_filter( 'acf/settings/save_json', function( $path ) {
    return get_template_directory() . '/acf-json';
} );

add_filter( 'acf/settings/load_json', function( $paths ) {
    unset( $paths[0] );
    $paths[] = get_template_directory() . '/acf-json';
    return $paths;
} );

// Register custom ACF location rule: page_slug safely via ACF_Location class
add_action( 'acf/init', function() {
    if ( class_exists( 'ACF_Location' ) && function_exists( 'acf_register_location_type' ) ) {
        class RS_ACF_Location_Page_Slug extends ACF_Location {
            public function initialize() {
                $this->name     = 'page_slug';
                $this->label    = __( 'Page Slug', 'rogersorkin' );
                $this->category = 'page';
            }

            public function get_values( $rule ) {
                return array(
                    'home'     => 'Home (slug: home)',
                    'about'    => 'About (slug: about)',
                    'services' => 'Services (slug: services)',
                    'projects' => 'Projects (slug: projects)',
                    'contact'  => 'Contact (slug: contact)',
                );
            }

            public function match( $rule, $screen, $field_group ) {
                if ( ! isset( $screen['post_id'] ) || ! is_numeric( $screen['post_id'] ) ) {
                    return false;
                }
                $post = get_post( $screen['post_id'] );
                if ( ! $post || $post->post_type !== 'page' ) {
                    return false;
                }
                $slug = $post->post_name;
                if ( isset( $rule['operator'] ) && $rule['operator'] === '==' ) {
                    return ( $slug === $rule['value'] );
                } elseif ( isset( $rule['operator'] ) && $rule['operator'] === '!=' ) {
                    return ( $slug !== $rule['value'] );
                }
                return false;
            }
        }
        acf_register_location_type( 'RS_ACF_Location_Page_Slug' );
    }
}, 5 );


/**
 * Helper to generate 4-stat fields with globally unique field keys.
 */
function rs_get_stat_subfields( $prefix ) {
    return array(
        array(
            'key'   => 'tab_' . $prefix . '_stats_bar',
            'label' => 'Trust Bar / Key Stats',
            'type'  => 'tab',
        ),
        array(
            'key'     => 'field_' . $prefix . '_stat_1_num',
            'label'   => 'Stat 1 Number / Heading',
            'name'    => 'stat_1_num',
            'type'    => 'text',
            'wrapper' => array( 'width' => '50' ),
        ),
        array(
            'key'     => 'field_' . $prefix . '_stat_1_label',
            'label'   => 'Stat 1 Description / Label',
            'name'    => 'stat_1_label',
            'type'    => 'text',
            'wrapper' => array( 'width' => '50' ),
        ),
        array(
            'key'     => 'field_' . $prefix . '_stat_2_num',
            'label'   => 'Stat 2 Number / Heading',
            'name'    => 'stat_2_num',
            'type'    => 'text',
            'wrapper' => array( 'width' => '50' ),
        ),
        array(
            'key'     => 'field_' . $prefix . '_stat_2_label',
            'label'   => 'Stat 2 Description / Label',
            'name'    => 'stat_2_label',
            'type'    => 'text',
            'wrapper' => array( 'width' => '50' ),
        ),
        array(
            'key'     => 'field_' . $prefix . '_stat_3_num',
            'label'   => 'Stat 3 Number / Heading',
            'name'    => 'stat_3_num',
            'type'    => 'text',
            'wrapper' => array( 'width' => '50' ),
        ),
        array(
            'key'     => 'field_' . $prefix . '_stat_3_label',
            'label'   => 'Stat 3 Description / Label',
            'name'    => 'stat_3_label',
            'type'    => 'text',
            'wrapper' => array( 'width' => '50' ),
        ),
        array(
            'key'     => 'field_' . $prefix . '_stat_4_num',
            'label'   => 'Stat 4 Number / Heading',
            'name'    => 'stat_4_num',
            'type'    => 'text',
            'wrapper' => array( 'width' => '50' ),
        ),
        array(
            'key'     => 'field_' . $prefix . '_stat_4_label',
            'label'   => 'Stat 4 Description / Label',
            'name'    => 'stat_4_label',
            'type'    => 'text',
            'wrapper' => array( 'width' => '50' ),
        ),
    );
}

// Register All Field Groups Programmatically
function rs_register_acf_field_groups() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    // Dynamically resolve page IDs so rules match regardless of server or database
    $home_page     = get_page_by_path( 'home' );
    $home_id       = $home_page ? $home_page->ID : ( (int) get_option( 'page_on_front' ) );
    $about_page    = get_page_by_path( 'about' );
    $about_id      = $about_page ? $about_page->ID : 0;
    $services_page = get_page_by_path( 'services' );
    $services_id   = $services_page ? $services_page->ID : 0;
    $projects_page = get_page_by_path( 'projects' );
    $projects_id   = $projects_page ? $projects_page->ID : 0;
    $contact_page  = get_page_by_path( 'contact' );
    $contact_id    = $contact_page ? $contact_page->ID : 0;

    // =========================================================================
    // 1. Homepage Field Group
    // =========================================================================
    $home_fields = array_merge( array(
        array( 'key' => 'tab_hp_hero', 'label' => 'Hero Banner', 'type' => 'tab' ),
        array( 'key' => 'field_hp_badge_text', 'label' => 'Hero Pill Badge Text', 'name' => 'hero_badge_text', 'type' => 'text', 'default_value' => 'STRATEGIC COMMUNICATIONS & DOCUMENTARY FILM' ),
        array( 'key' => 'field_hp_title_line1', 'label' => 'Hero Title Line 1', 'name' => 'hero_title_line1', 'type' => 'text', 'default_value' => 'Turning narrative risk' ),
        array( 'key' => 'field_hp_title_line2', 'label' => 'Hero Title Line 2 (Gradient Text)', 'name' => 'hero_title_line2', 'type' => 'text', 'default_value' => 'into strategic advantage.' ),
        array( 'key' => 'field_hp_subtitle', 'label' => 'Hero Subtitle', 'name' => 'hero_subtitle', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Translating complex environmental, economic, and security challenges into compelling, bipartisan strategic narratives and attainable calls-to-action.' ),
        array( 'key' => 'field_hp_cta_primary_label', 'label' => 'Primary Button Label', 'name' => 'hero_cta_primary_label', 'type' => 'text', 'default_value' => 'Book Strategy Session', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_hp_cta_primary_url', 'label' => 'Primary Button URL', 'name' => 'hero_cta_primary_url', 'type' => 'text', 'default_value' => '/contact/', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_hp_cta_reel_label', 'label' => 'Showreel Button Label', 'name' => 'hero_cta_reel_label', 'type' => 'text', 'default_value' => 'Watch Showreel' ),
    ), rs_get_stat_subfields( 'hp' ), array(
        array( 'key' => 'tab_hp_services', 'label' => 'Services Hub Section', 'type' => 'tab' ),
        array( 'key' => 'field_hp_services_tag', 'label' => 'Services Hub Tag', 'name' => 'services_hub_tag', 'type' => 'text', 'default_value' => 'STRATEGIC COMMUNICATIONS SUITE' ),
        array( 'key' => 'field_hp_services_title', 'label' => 'Services Hub Title', 'name' => 'services_hub_title', 'type' => 'text', 'default_value' => 'A Range of Services to Meet Your Communications Needs' ),
        array( 'key' => 'field_hp_services_subtitle', 'label' => 'Services Hub Subtitle', 'name' => 'services_hub_subtitle', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Connecting seasoned executive counsel, custom simulations, and impact storytelling to convert narrative risk into enduring advantage.' ),

        array( 'key' => 'tab_hp_projects', 'label' => 'Selected Projects Slider', 'type' => 'tab' ),
        array( 'key' => 'field_hp_projects_tag', 'label' => 'Projects Section Tag', 'name' => 'projects_section_tag', 'type' => 'text', 'default_value' => 'SELECTED CASE STUDIES' ),
        array( 'key' => 'field_hp_projects_title', 'label' => 'Projects Section Title', 'name' => 'projects_section_title', 'type' => 'text', 'default_value' => 'Strategic Narratives in Action' ),
        array( 'key' => 'field_hp_projects_subtitle', 'label' => 'Projects Section Subtitle', 'name' => 'projects_section_subtitle', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'From reframing national security and agriculture to guiding executive leadership transitions, explore case studies that accomplished what facts alone could not.' ),
        array( 'key' => 'field_hp_projects_view_all_label', 'label' => 'View All Projects Button Label', 'name' => 'projects_view_all_label', 'type' => 'text', 'default_value' => 'View All Projects →', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_hp_projects_view_all_url', 'label' => 'View All Projects Button URL', 'name' => 'projects_view_all_url', 'type' => 'text', 'default_value' => '/projects/', 'wrapper' => array( 'width' => '50' ) ),

        array( 'key' => 'tab_hp_about', 'label' => 'About Roger Sorkin Section', 'type' => 'tab' ),
        array( 'key' => 'field_hp_about_tag', 'label' => 'Section Tag', 'name' => 'hp_about_tag', 'type' => 'text', 'default_value' => 'ABOUT ROGER SORKIN' ),
        array( 'key' => 'field_hp_about_title', 'label' => 'Section Title', 'name' => 'hp_about_title', 'type' => 'text', 'default_value' => '30 Years of Finding Common Ground Through Storytelling' ),
        array( 'key' => 'field_hp_about_lead', 'label' => 'Lead Paragraph', 'name' => 'hp_about_lead', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Spanning three decades across documentary filmmaking, investigative journalism, and non-partisan advocacy, Roger Sorkin transforms complex national challenges into unified human narratives.' ),
        array( 'key' => 'field_hp_about_body', 'label' => 'Story Body Paragraph', 'name' => 'hp_about_body', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'My background in anthropology and journalism taught me how to read room dynamics, cultivate authentic constituent voices, and uncover the shared values that bypass partisan skepticism. From producing daily public affairs broadcasts to screening original documentaries before Congressional committees, I help leaders build trust where traditional public relations fail.' ),
        array( 'key' => 'field_hp_about_feat1_title', 'label' => 'Feature 1 Title', 'name' => 'hp_about_feat1_title', 'type' => 'text', 'default_value' => 'Journalistic Rigor & Research', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_hp_about_feat1_text', 'label' => 'Feature 1 Text', 'name' => 'hp_about_feat1_text', 'type' => 'text', 'default_value' => 'In-depth investigation yielding constituent narratives that command authority.', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_hp_about_feat2_title', 'label' => 'Feature 2 Title', 'name' => 'hp_about_feat2_title', 'type' => 'text', 'default_value' => 'Bipartisan Coalition Building', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_hp_about_feat2_text', 'label' => 'Feature 2 Text', 'name' => 'hp_about_feat2_text', 'type' => 'text', 'default_value' => 'Uniting business leaders, military veterans, lawmakers, and advocates.', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_hp_about_cred1_text', 'label' => 'Credential 1 Text', 'name' => 'hp_about_cred1_text', 'type' => 'text', 'default_value' => 'M.A. Communication (Stanford)', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_hp_about_cred2_text', 'label' => 'Credential 2 Text', 'name' => 'hp_about_cred2_text', 'type' => 'text', 'default_value' => 'Founder, American Resilience Project', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_hp_about_quote_text', 'label' => 'Callout Quote Text', 'name' => 'hp_about_quote_text', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'A white paper disguised as a film: perhaps the greatest compliment possible for my approach.' ),
        array( 'key' => 'field_hp_about_quote_cite', 'label' => 'Callout Quote Citation', 'name' => 'hp_about_quote_cite', 'type' => 'text', 'default_value' => 'Senior Congressional Energy Policy Advisor • Roger Sorkin' ),
        array( 'key' => 'field_hp_about_cta1_label', 'label' => 'Primary Button Label', 'name' => 'hp_about_cta1_label', 'type' => 'text', 'default_value' => 'Schedule Strategy Call →', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_hp_about_cta1_url', 'label' => 'Primary Button URL', 'name' => 'hp_about_cta1_url', 'type' => 'text', 'default_value' => '/contact/', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_hp_about_cta2_label', 'label' => 'Secondary Button Label', 'name' => 'hp_about_cta2_label', 'type' => 'text', 'default_value' => 'Read Full Bio & Story →', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_hp_about_cta2_url', 'label' => 'Secondary Button URL', 'name' => 'hp_about_cta2_url', 'type' => 'text', 'default_value' => '/about/', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_hp_about_photo', 'label' => 'Portrait Photo (Upload custom or leave empty for default)', 'name' => 'hp_about_photo', 'type' => 'image', 'return_format' => 'array' ),
    ) );

    $home_loc = array(
        array( array( 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ) ),
        array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'front-page.php' ) ),
        array( array( 'param' => 'post_template', 'operator' => '==', 'value' => 'front-page.php' ) ),
        array( array( 'param' => 'page_slug', 'operator' => '==', 'value' => 'home' ) ),
    );
    if ( $home_id ) {
        $home_loc[] = array( array( 'param' => 'page', 'operator' => '==', 'value' => (string) $home_id ) );
    }

    acf_add_local_field_group( array(
        'key'                   => 'group_page_home',
        'title'                 => 'Homepage Configuration',
        'fields'                => $home_fields,
        'location'              => $home_loc,
        'menu_order'            => 0,
        'position'              => 'acf_after_title',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => array( 'the_content' ),
    ) );

    // =========================================================================
    // 2. About Page Field Group
    // =========================================================================
    $about_fields = array_merge( array(
        array( 'key' => 'tab_ab_hero', 'label' => 'Hero Banner', 'type' => 'tab' ),
        array( 'key' => 'field_ab_badge', 'label' => 'Hero Pill Badge', 'name' => 'hero_badge_text', 'type' => 'text', 'default_value' => 'STRATEGIC COMMUNICATIONS & DOCUMENTARY FILM' ),
        array( 'key' => 'field_ab_title_line1', 'label' => 'Hero Title Line 1', 'name' => 'hero_title_line1', 'type' => 'text', 'default_value' => "Solutions to humanity's greatest challenges" ),
        array( 'key' => 'field_ab_title_line2', 'label' => 'Hero Title Line 2 (Gradient)', 'name' => 'hero_title_line2', 'type' => 'text', 'default_value' => 'start with strong narrative foundations.' ),
        array( 'key' => 'field_ab_subtitle', 'label' => 'Hero Subtitle', 'name' => 'hero_subtitle', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Strategic communications advisor and award-winning documentary filmmaker helping organizations build durable narrative infrastructure, unite diverse stakeholders, and accelerate systemic change.' ),
    ), rs_get_stat_subfields( 'ab' ), array(
        // Chapter 01
        array( 'key' => 'tab_ab_chapter1', 'label' => 'Chapter 01 (The Mission)', 'type' => 'tab' ),
        array( 'key' => 'field_ab_c1_tag', 'label' => 'Chapter 01 Tag', 'name' => 'chapter1_tag', 'type' => 'text', 'default_value' => 'CHAPTER 01 • THE MISSION' ),
        array( 'key' => 'field_ab_c1_line1', 'label' => 'Heading Line 1', 'name' => 'chapter1_line1', 'type' => 'text', 'default_value' => 'Three Decades of Uniting Stakeholders' ),
        array( 'key' => 'field_ab_c1_line2', 'label' => 'Heading Line 2', 'name' => 'chapter1_line2', 'type' => 'text', 'default_value' => 'Around High-Stakes Initiatives' ),
        array( 'key' => 'field_ab_c1_lead', 'label' => 'Lead Paragraph', 'name' => 'chapter1_lead', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'From executive boardrooms to Capitol Hill hearing rooms, the difference between an initiative that stalls and one that succeeds is almost never the data. It is the story.' ),
        array( 'key' => 'field_ab_c1_story1', 'label' => 'Story Paragraph 1', 'name' => 'chapter1_story1', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Throughout my career as an investigative journalist, filmmaker, and strategic communications advisor, I have seen brilliant initiatives fail because their message failed to resonate beyond the people who already agreed with them.' ),
        array( 'key' => 'field_ab_c1_story2', 'label' => 'Story Paragraph 2', 'name' => 'chapter1_story2', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Moving beyond conventional public relations, Roger equips leadership teams with the narrative cornerstones needed to navigate regulatory friction and convert critical initiatives into measurable, long-term impact.' ),
        array( 'key' => 'field_ab_c1_btn1_label', 'label' => 'Primary Button Label', 'name' => 'chapter1_btn1_label', 'type' => 'text', 'default_value' => 'Schedule Strategy Session →', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_ab_c1_btn1_url', 'label' => 'Primary Button URL', 'name' => 'chapter1_btn1_url', 'type' => 'text', 'default_value' => '/contact/', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_ab_c1_btn2_label', 'label' => 'Secondary Button Label', 'name' => 'chapter1_btn2_label', 'type' => 'text', 'default_value' => 'View Case Studies', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_ab_c1_btn2_url', 'label' => 'Secondary Button URL', 'name' => 'chapter1_btn2_url', 'type' => 'text', 'default_value' => '/projects/', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_ab_c1_photo', 'label' => 'Chapter 1 Photo (Upload custom or leave empty for default)', 'name' => 'chapter1_photo', 'type' => 'image', 'return_format' => 'array' ),

        // Chapter 02
        array( 'key' => 'tab_ab_chapter2', 'label' => 'Chapter 02 (Sectors & Advocacy)', 'type' => 'tab' ),
        array( 'key' => 'field_ab_c2_tag', 'label' => 'Chapter 02 Tag', 'name' => 'chapter2_tag', 'type' => 'text', 'default_value' => 'CHAPTER 02 • SECTORS & ADVOCACY' ),
        array( 'key' => 'field_ab_c2_line1', 'label' => 'Heading Line 1', 'name' => 'chapter2_line1', 'type' => 'text', 'default_value' => "From America's Heartland to West Point:" ),
        array( 'key' => 'field_ab_c2_line2', 'label' => 'Heading Line 2', 'name' => 'chapter2_line2', 'type' => 'text', 'default_value' => 'Overcoming Message Friction' ),
        array( 'key' => 'field_ab_c2_lead', 'label' => 'Lead Paragraph', 'name' => 'chapter2_lead', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Through his strategic communications advisory, Roger brings this narrative expertise directly to organizations navigating complex challenges across defense, infrastructure, agriculture, clean energy, and public health.' ),
        array( 'key' => 'field_ab_c2_card1_title', 'label' => 'Sector Card 1 Title', 'name' => 'chapter2_card1_title', 'type' => 'text', 'default_value' => 'Airport Enterprise Alignment' ),
        array( 'key' => 'field_ab_c2_card1_text', 'label' => 'Sector Card 1 Text', 'name' => 'chapter2_card1_text', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'When leadership pushed back on "another corporate video," Roger engineered an enterprise-wide narrative architecture unifying sustainability and operational pride across 10,000 employees.' ),
        array( 'key' => 'field_ab_c2_card2_title', 'label' => 'Sector Card 2 Title', 'name' => 'chapter2_card2_title', 'type' => 'text', 'default_value' => 'Heartland Agriculture Coalitions' ),
        array( 'key' => 'field_ab_c2_card2_text', 'label' => 'Sector Card 2 Text', 'name' => 'chapter2_card2_text', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Bridged deep partisan divides by centering authentic farmer voices, transforming regulatory friction into bipartisan legislative support for resilient agricultural policy.' ),
        array( 'key' => 'field_ab_c2_card3_title', 'label' => 'Sector Card 3 Title', 'name' => 'chapter2_card3_title', 'type' => 'text', 'default_value' => 'National Security & Defense' ),
        array( 'key' => 'field_ab_c2_card3_text', 'label' => 'Sector Card 3 Text', 'name' => 'chapter2_card3_text', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Reframed clean energy and grid resilience as vital operational vulnerabilities for military leadership at West Point and the Pentagon, directly helping secure key defense appropriations.' ),
        array( 'key' => 'field_ab_c2_photo', 'label' => 'Chapter 2 Photo (Upload custom or leave empty for default)', 'name' => 'chapter2_photo', 'type' => 'image', 'return_format' => 'array' ),

        // Chapter 03
        array( 'key' => 'tab_ab_chapter3', 'label' => 'Chapter 03 (Methodology & Roots)', 'type' => 'tab' ),
        array( 'key' => 'field_ab_c3_tag', 'label' => 'Chapter 03 Tag', 'name' => 'chapter3_tag', 'type' => 'text', 'default_value' => 'CHAPTER 03 • METHODOLOGY & ROOTS' ),
        array( 'key' => 'field_ab_c3_line1', 'label' => 'Heading Line 1', 'name' => 'chapter3_line1', 'type' => 'text', 'default_value' => 'Anthropological Fieldwork' ),
        array( 'key' => 'field_ab_c3_line2', 'label' => 'Heading Line 2', 'name' => 'chapter3_line2', 'type' => 'text', 'default_value' => 'Meets Documentary Craft' ),
        array( 'key' => 'field_ab_c3_lead', 'label' => 'Lead Paragraph', 'name' => 'chapter3_lead', 'type' => 'textarea', 'rows' => 3, 'default_value' => "Roger's methodology draws from ethnographic research and documentary filmmaking, shaped by his studies in Anthropology at Johns Hopkins University and Communication at Stanford." ),
        array( 'key' => 'field_ab_c3_story1', 'label' => 'Story Paragraph 1', 'name' => 'chapter3_story1', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Before founding ARP, Roger produced award-winning content for National Geographic and PBS: foundational experiences that taught him how to uncover stories that resonate on deeper human levels. He has taught at business schools, led immersive simulations for executives at Fordham University, and moderated high-level forums with government and industry leaders.' ),
        array( 'key' => 'field_ab_c3_story2', 'label' => 'Story Paragraph 2', 'name' => 'chapter3_story2', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'When not working with clients, Roger coaches youth baseball in Western Massachusetts, finding that building team cohesion on the field offers surprising, practical insights that translate directly to executive communications strategy.' ),
        array( 'key' => 'field_ab_c3_btn1_label', 'label' => 'Primary Button Label', 'name' => 'chapter3_btn1_label', 'type' => 'text', 'default_value' => 'Work With Roger →', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_ab_c3_btn1_url', 'label' => 'Primary Button URL', 'name' => 'chapter3_btn1_url', 'type' => 'text', 'default_value' => '/contact/', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_ab_c3_btn2_label', 'label' => 'Secondary Button Label', 'name' => 'chapter3_btn2_label', 'type' => 'text', 'default_value' => 'Explore Services Suite', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_ab_c3_btn2_url', 'label' => 'Secondary Button URL', 'name' => 'chapter3_btn2_url', 'type' => 'text', 'default_value' => '/services/', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_ab_c3_photo', 'label' => 'Chapter 3 Photo (Upload custom or leave empty for default)', 'name' => 'chapter3_photo', 'type' => 'image', 'return_format' => 'array' ),

        // Core Philosophy / 3 Principles
        array( 'key' => 'tab_ab_principles', 'label' => 'Core Philosophy (3 Principles)', 'type' => 'tab' ),
        array( 'key' => 'field_ab_pr_tag', 'label' => 'Principles Section Tag', 'name' => 'principles_tag', 'type' => 'text', 'default_value' => 'CORE PHILOSOPHY' ),
        array( 'key' => 'field_ab_pr_title', 'label' => 'Principles Section Title', 'name' => 'principles_title', 'type' => 'text', 'default_value' => 'Three Principles That Guide My Work' ),
        array( 'key' => 'field_ab_pr_subtitle', 'label' => 'Principles Section Subtitle', 'name' => 'principles_subtitle', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'My approach to communication challenges is guided by three core principles developed across three decades of filmmaking and executive strategy:' ),
        array( 'key' => 'field_ab_p1_title', 'label' => 'Principle 1 Title', 'name' => 'principle_1_title', 'type' => 'text', 'default_value' => 'The Same Solution, Different Reasons' ),
        array( 'key' => 'field_ab_p1_text', 'label' => 'Principle 1 Text', 'name' => 'principle_1_text', 'type' => 'textarea', 'rows' => 3, 'default_value' => "People don't need to share identical values to support the same initiative. By identifying where different interests naturally converge, we can build support from stakeholders who might otherwise remain divided." ),
        array( 'key' => 'field_ab_p1_tag', 'label' => 'Principle 1 Tag', 'name' => 'principle_1_tag', 'type' => 'text', 'default_value' => 'Bipartisan Coalition Building' ),
        array( 'key' => 'field_ab_p2_title', 'label' => 'Principle 2 Title', 'name' => 'principle_2_title', 'type' => 'text', 'default_value' => 'Emotion Matters as Much as Data' ),
        array( 'key' => 'field_ab_p2_text', 'label' => 'Principle 2 Text', 'name' => 'principle_2_text', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'While facts are important, emotional connections create more meaningful relationships with audiences. Authentic storytelling that connects on human levels drives action more effectively than statistics alone.' ),
        array( 'key' => 'field_ab_p2_tag', 'label' => 'Principle 2 Tag', 'name' => 'principle_2_tag', 'type' => 'text', 'default_value' => 'Human-Centered Engagement' ),
        array( 'key' => 'field_ab_p3_title', 'label' => 'Principle 3 Title', 'name' => 'principle_3_title', 'type' => 'text', 'default_value' => 'Narratives Are a Strategic Asset' ),
        array( 'key' => 'field_ab_p3_text', 'label' => 'Principle 3 Text', 'name' => 'principle_3_text', 'type' => 'textarea', 'rows' => 3, 'default_value' => "Communication isn't just what you say: it's the connection between what you do with why you do it. When organizations develop coherent narratives, both internal alignment and external engagement improve dramatically." ),
        array( 'key' => 'field_ab_p3_tag', 'label' => 'Principle 3 Tag', 'name' => 'principle_3_tag', 'type' => 'text', 'default_value' => 'Narrative Architecture' ),

        // Systemic Methodology (3 Steps)
        array( 'key' => 'tab_ab_methodology', 'label' => 'Systemic Methodology (3 Steps)', 'type' => 'tab' ),
        array( 'key' => 'field_ab_app_tag', 'label' => 'Methodology Tag', 'name' => 'approach_tag', 'type' => 'text', 'default_value' => 'SYSTEMIC METHODOLOGY' ),
        array( 'key' => 'field_ab_app_title', 'label' => 'Methodology Title', 'name' => 'approach_title', 'type' => 'text', 'default_value' => 'My Approach to Communications Challenges' ),
        array( 'key' => 'field_ab_app_subtitle', 'label' => 'Methodology Subtitle', 'name' => 'approach_subtitle', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Every engagement follows a structured, ethnographic methodology ensuring that strategy is deeply grounded in human reality and client mission.' ),
        array( 'key' => 'field_ab_app_s1_title', 'label' => 'Step 1 Title', 'name' => 'approach_step_1_title', 'type' => 'text', 'default_value' => 'Ecosystem Assessment' ),
        array( 'key' => 'field_ab_app_s1_text', 'label' => 'Step 1 Description', 'name' => 'approach_step_1_text', 'type' => 'textarea', 'rows' => 3, 'default_value' => "I begin each engagement with a thorough assessment of your communication ecosystem: who you're trying to reach, what you're saying, and where you're getting stuck. This ethnographic process helps me understand your organization's unique culture and challenges before developing any strategic recommendations." ),
        array( 'key' => 'field_ab_app_s2_title', 'label' => 'Step 2 Title', 'name' => 'approach_step_2_title', 'type' => 'text', 'default_value' => 'Filmmaking Meets Strategy' ),
        array( 'key' => 'field_ab_app_s2_text', 'label' => 'Step 2 Description', 'name' => 'approach_step_2_text', 'type' => 'textarea', 'rows' => 3, 'default_value' => "My style combines filmmaking expertise with strategic communications knowledge. Whether I'm directing a documentary that captures your mission or designing a comprehensive communications plan, I focus on finding authentic stories that connect with your stakeholders on both emotional and intellectual levels." ),
        array( 'key' => 'field_ab_app_s3_title', 'label' => 'Step 3 Title', 'name' => 'approach_step_3_title', 'type' => 'text', 'default_value' => 'Direct, Senior-Level Partnership' ),
        array( 'key' => 'field_ab_app_s3_text', 'label' => 'Step 3 Description', 'name' => 'approach_step_3_text', 'type' => 'textarea', 'rows' => 3, 'default_value' => "I work directly with clients throughout the entire process, from initial concept development through final delivery. This hands-on approach ensures consistency of vision and allows me to adapt quickly as projects evolve. You'll always work with me personally, not a rotating team of associates who might lose sight of your objectives." ),

        // Credentials & Affiliations (6 Cards)
        array( 'key' => 'tab_ab_credentials', 'label' => 'Credentials & Affiliations (6 Cards)', 'type' => 'tab' ),
        array( 'key' => 'field_ab_cred_tag', 'label' => 'Credentials Tag', 'name' => 'credentials_tag', 'type' => 'text', 'default_value' => 'CREDENTIALS & AFFILIATIONS' ),
        array( 'key' => 'field_ab_cred_title', 'label' => 'Credentials Title', 'name' => 'credentials_title', 'type' => 'text', 'default_value' => "Educational Pedigree & Institutional Milestones" ),
        array( 'key' => 'field_ab_cred_subtitle', 'label' => 'Credentials Subtitle', 'name' => 'credentials_subtitle', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'A career shaped by top-tier academic institutions, national broadcast networks, and mission-driven leadership.' ),
        array( 'key' => 'field_ab_c1_t', 'label' => 'Card 1 Title', 'name' => 'cred_1_title', 'type' => 'text', 'default_value' => 'Stanford University', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_ab_c1_d', 'label' => 'Card 1 Description', 'name' => 'cred_1_desc', 'type' => 'text', 'default_value' => 'M.A. in Communication (Documentary Film & Video)', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_ab_c2_t', 'label' => 'Card 2 Title', 'name' => 'cred_2_title', 'type' => 'text', 'default_value' => 'Johns Hopkins University', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_ab_c2_d', 'label' => 'Card 2 Description', 'name' => 'cred_2_desc', 'type' => 'text', 'default_value' => 'B.A. in Anthropology with focus on ethnographic research', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_ab_c3_t', 'label' => 'Card 3 Title', 'name' => 'cred_3_title', 'type' => 'text', 'default_value' => 'American Resilience Project', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_ab_c3_d', 'label' => 'Card 3 Description', 'name' => 'cred_3_desc', 'type' => 'text', 'default_value' => 'Founder & Executive Director driving national narrative policy', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_ab_c4_t', 'label' => 'Card 4 Title', 'name' => 'cred_4_title', 'type' => 'text', 'default_value' => 'National Geographic & PBS', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_ab_c4_d', 'label' => 'Card 4 Description', 'name' => 'cred_4_desc', 'type' => 'text', 'default_value' => 'Documentary Producer alumnus crafting high-impact human stories', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_ab_c5_t', 'label' => 'Card 5 Title', 'name' => 'cred_5_title', 'type' => 'text', 'default_value' => 'Fordham University', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_ab_c5_d', 'label' => 'Card 5 Description', 'name' => 'cred_5_desc', 'type' => 'text', 'default_value' => 'Guest Lecturer & Simulation Facilitator, Gabelli School of Business', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_ab_c6_t', 'label' => 'Card 6 Title', 'name' => 'cred_6_title', 'type' => 'text', 'default_value' => 'Cross-Sector Advisory', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_ab_c6_d', 'label' => 'Card 6 Description', 'name' => 'cred_6_desc', 'type' => 'text', 'default_value' => 'Defense, clean energy, infrastructure, food security & public health', 'wrapper' => array( 'width' => '50' ) ),
    ) );

    $about_loc = array(
        array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-about.php' ) ),
        array( array( 'param' => 'post_template', 'operator' => '==', 'value' => 'page-about.php' ) ),
        array( array( 'param' => 'page_slug', 'operator' => '==', 'value' => 'about' ) ),
    );
    if ( $about_id ) {
        $about_loc[] = array( array( 'param' => 'page', 'operator' => '==', 'value' => (string) $about_id ) );
    }

    acf_add_local_field_group( array(
        'key'                   => 'group_page_about',
        'title'                 => 'About Page Configuration',
        'fields'                => $about_fields,
        'location'              => $about_loc,
        'menu_order'            => 0,
        'position'              => 'acf_after_title',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => array( 'the_content' ),
    ) );

    // =========================================================================
    // 3. Services Page Field Group
    // =========================================================================
    $services_page_fields = array_merge( array(
        array( 'key' => 'tab_sp_hero', 'label' => 'Hero Banner', 'type' => 'tab' ),
        array( 'key' => 'field_sp_badge', 'label' => 'Hero Pill Badge', 'name' => 'hero_badge_text', 'type' => 'text', 'default_value' => 'STRATEGIC COMMUNICATIONS & DOCUMENTARY FILM' ),
        array( 'key' => 'field_sp_title_line1', 'label' => 'Hero Title Line 1', 'name' => 'hero_title_line1', 'type' => 'text', 'default_value' => 'A Range of Services to Meet' ),
        array( 'key' => 'field_sp_title_line2', 'label' => 'Hero Title Line 2 (Gradient)', 'name' => 'hero_title_line2', 'type' => 'text', 'default_value' => 'Your Communications Needs.' ),
        array( 'key' => 'field_sp_subtitle', 'label' => 'Hero Subtitle', 'name' => 'hero_subtitle', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Organizations face more communications demands than ever: internal alignment, public storytelling, executive visibility, media engagement, and high-impact content. Few teams can take all of it on alone. Here is how Roger Sorkin delivers strategic advantage.' ),
    ), rs_get_stat_subfields( 'sp' ), array(
        array( 'key' => 'tab_sp_models', 'label' => 'Engagement Models Section', 'type' => 'tab' ),
        array( 'key' => 'field_sp_models_tag', 'label' => 'Models Section Tag', 'name' => 'models_tag', 'type' => 'text', 'default_value' => 'COLLABORATION ARCHITECTURE' ),
        array( 'key' => 'field_sp_models_title', 'label' => 'Models Section Title', 'name' => 'models_title', 'type' => 'text', 'default_value' => 'How Organizations Engage Roger Sorkin' ),
        array( 'key' => 'field_sp_models_subtitle', 'label' => 'Models Subtitle', 'name' => 'models_subtitle', 'type' => 'textarea', 'rows' => 2, 'default_value' => "Three flexible, high-impact engagement models structured to fit your organization's timeline, governance requirements, and strategic stakes." ),

        // Model 1
        array( 'key' => 'field_sp_m1_badge', 'label' => 'Model 1 Tier Badge', 'name' => 'model_1_badge', 'type' => 'text', 'default_value' => 'MODEL 01 • ONGOING' ),
        array( 'key' => 'field_sp_m1_title', 'label' => 'Model 1 Title', 'name' => 'model_1_title', 'type' => 'text', 'default_value' => 'Advisory Retainer' ),
        array( 'key' => 'field_sp_m1_desc', 'label' => 'Model 1 Description', 'name' => 'model_1_desc', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Ongoing fractional C-suite leadership and trusted counsel embedded directly alongside your executive team.' ),
        array( 'key' => 'field_sp_m1_features', 'label' => 'Model 1 Features (One per line)', 'name' => 'model_1_features', 'type' => 'textarea', 'rows' => 4, 'default_value' => "Fractional Communications Officer role
Weekly senior strategy & review calls
Crisis preparedness & response standby
Direct CEO & board advisory access" ),
        array( 'key' => 'field_sp_m1_btn_label', 'label' => 'Model 1 Button Label', 'name' => 'model_1_btn_label', 'type' => 'text', 'default_value' => 'Inquire About Retainer', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_sp_m1_btn_url', 'label' => 'Model 1 Button URL', 'name' => 'model_1_btn_url', 'type' => 'text', 'default_value' => '/contact/', 'wrapper' => array( 'width' => '50' ) ),

        // Model 2
        array( 'key' => 'field_sp_m2_badge', 'label' => 'Model 2 Tier Badge', 'name' => 'model_2_badge', 'type' => 'text', 'default_value' => 'MODEL 02 • DIAGNOSTIC' ),
        array( 'key' => 'field_sp_m2_title', 'label' => 'Model 2 Title', 'name' => 'model_2_title', 'type' => 'text', 'default_value' => 'Focused Intensives' ),
        array( 'key' => 'field_sp_m2_desc', 'label' => 'Model 2 Description', 'name' => 'model_2_desc', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Concentrated, time-boxed engagements that diagnose narrative friction or prepare teams for critical public events.' ),
        array( 'key' => 'field_sp_m2_features', 'label' => 'Model 2 Features (One per line)', 'name' => 'model_2_features', 'type' => 'textarea', 'rows' => 4, 'default_value' => "Comprehensive Communications Audit
Custom role-playing simulations (1-3 days)
Executive coaching prior to major hearings
Detailed actionable findings report" ),
        array( 'key' => 'field_sp_m2_btn_label', 'label' => 'Model 2 Button Label', 'name' => 'model_2_btn_label', 'type' => 'text', 'default_value' => 'Schedule an Intensive', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_sp_m2_btn_url', 'label' => 'Model 2 Button URL', 'name' => 'model_2_btn_url', 'type' => 'text', 'default_value' => '/contact/', 'wrapper' => array( 'width' => '50' ) ),

        // Model 3
        array( 'key' => 'field_sp_m3_badge', 'label' => 'Model 3 Tier Badge', 'name' => 'model_3_badge', 'type' => 'text', 'default_value' => 'MODEL 03 • PRODUCTION' ),
        array( 'key' => 'field_sp_m3_title', 'label' => 'Model 3 Title', 'name' => 'model_3_title', 'type' => 'text', 'default_value' => 'Creative Systems' ),
        array( 'key' => 'field_sp_m3_desc', 'label' => 'Model 3 Description', 'name' => 'model_3_desc', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Full-cycle content infrastructure that convenes key decision-makers and establishes in-house production capability.' ),
        array( 'key' => 'field_sp_m3_features', 'label' => 'Model 3 Features (One per line)', 'name' => 'model_3_features', 'type' => 'textarea', 'rows' => 4, 'default_value' => "Documentary film production & distribution
Content Roadmap systems for in-house teams
End-to-end podcast series production
Screening tour convening policymakers" ),
        array( 'key' => 'field_sp_m3_btn_label', 'label' => 'Model 3 Button Label', 'name' => 'model_3_btn_label', 'type' => 'text', 'default_value' => 'Commission Creative', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_sp_m3_btn_url', 'label' => 'Model 3 Button URL', 'name' => 'model_3_btn_url', 'type' => 'text', 'default_value' => '/contact/', 'wrapper' => array( 'width' => '50' ) ),
    ) );

    $services_loc = array(
        array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-services.php' ) ),
        array( array( 'param' => 'post_template', 'operator' => '==', 'value' => 'page-services.php' ) ),
        array( array( 'param' => 'page_slug', 'operator' => '==', 'value' => 'services' ) ),
    );
    if ( $services_id ) {
        $services_loc[] = array( array( 'param' => 'page', 'operator' => '==', 'value' => (string) $services_id ) );
    }

    acf_add_local_field_group( array(
        'key'                   => 'group_page_services',
        'title'                 => 'Services Page Configuration',
        'fields'                => $services_page_fields,
        'location'              => $services_loc,
        'menu_order'            => 0,
        'position'              => 'acf_after_title',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => array( 'the_content' ),
    ) );

    // =========================================================================
    // 4. Projects Page Field Group
    // =========================================================================
    $projects_page_fields = array_merge( array(
        array( 'key' => 'tab_pp_hero', 'label' => 'Hero Banner', 'type' => 'tab' ),
        array( 'key' => 'field_pp_badge', 'label' => 'Hero Pill Badge', 'name' => 'hero_badge_text', 'type' => 'text', 'default_value' => 'STRATEGIC COMMUNICATIONS & DOCUMENTARY FILM' ),
        array( 'key' => 'field_pp_title_line1', 'label' => 'Hero Title Line 1', 'name' => 'hero_title_line1', 'type' => 'text', 'default_value' => 'Strategic Narratives in Action:' ),
        array( 'key' => 'field_pp_title_line2', 'label' => 'Hero Title Line 2 (Gradient)', 'name' => 'hero_title_line2', 'type' => 'text', 'default_value' => 'Films, Campaigns & Case Studies' ),
        array( 'key' => 'field_pp_subtitle', 'label' => 'Hero Subtitle', 'name' => 'hero_subtitle', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Explore how Roger Sorkin uses ethnographic storytelling, trusted messengers, and cinematic production to reframe contentious issues, unite polarized audiences, and accelerate policy solutions.' ),
    ), rs_get_stat_subfields( 'pp' ), array(
        array( 'key' => 'tab_pp_approach', 'label' => 'Systemic Methodology Section', 'type' => 'tab' ),
        array( 'key' => 'field_pp_app_tag', 'label' => 'Section Tag', 'name' => 'approach_tag', 'type' => 'text', 'default_value' => 'SYSTEMIC METHODOLOGY' ),
        array( 'key' => 'field_pp_app_title', 'label' => 'Section Title', 'name' => 'approach_title', 'type' => 'text', 'default_value' => 'My Creative Approach' ),
        array( 'key' => 'field_pp_app_story1', 'label' => 'Story Paragraph 1', 'name' => 'approach_story1', 'type' => 'textarea', 'rows' => 3, 'default_value' => "When I heard a combat veteran describe losing his friend to a fuel convoy attack in Iraq, I recognized a powerful untold story: how our military's dependence on fossil fuels was costing lives and undermining national security." ),
        array( 'key' => 'field_pp_app_story2', 'label' => 'Story Paragraph 2', 'name' => 'approach_story2', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'This insight became The Burden, a groundbreaking documentary that bridged unlikely allies: environmental advocates, defense conservatives, and military commanders: through a shared solution with different motivations. One policy wonk called it "a white paper disguised as a film": perhaps the greatest compliment possible for my approach.' ),
        array( 'key' => 'field_pp_step1_title', 'label' => 'Step 1 Title', 'name' => 'step_1_title', 'type' => 'text', 'default_value' => 'Identify Communication Gaps' ),
        array( 'key' => 'field_pp_step1_text', 'label' => 'Step 1 Text', 'name' => 'step_1_text', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Pinpoint precisely where public discourse and policy negotiations have stalled due to polarization or narrative fatigue.' ),
        array( 'key' => 'field_pp_step2_title', 'label' => 'Step 2 Title', 'name' => 'step_2_title', 'type' => 'text', 'default_value' => 'Deploy Trusted Messengers' ),
        array( 'key' => 'field_pp_step2_text', 'label' => 'Step 2 Text', 'name' => 'step_2_text', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Center authentic voices: veterans, farmers, engineers, and executives: who command respect from skeptical audiences.' ),
        array( 'key' => 'field_pp_step3_title', 'label' => 'Step 3 Title', 'name' => 'step_3_title', 'type' => 'text', 'default_value' => 'Provide Clear Calls to Action' ),
        array( 'key' => 'field_pp_step3_text', 'label' => 'Step 3 Text', 'name' => 'step_3_text', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Deliver attainable pathways that convert emotional resonance into durable legislative and institutional change.' ),
        array( 'key' => 'field_pp_app_photo', 'label' => 'Methodology Photo (defaults to about/roger-directing.webp)', 'name' => 'approach_photo', 'type' => 'image', 'return_format' => 'array' ),
        array( 'key' => 'field_pp_app_badge', 'label' => 'Photo Badge Text', 'name' => 'approach_badge_text', 'type' => 'text', 'default_value' => 'ON LOCATION • DOCUMENTARY DIRECTING' ),
        array( 'key' => 'field_pp_app_quote', 'label' => 'Callout Quote Text', 'name' => 'approach_quote_text', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Each project is designed with specific outcomes in mind: a signal cutting through the noise to create measurable change.' ),
        array( 'key' => 'field_pp_app_author', 'label' => 'Callout Quote Author', 'name' => 'approach_quote_author', 'type' => 'text', 'default_value' => 'Roger Sorkin • Founder & Director' ),
    ) );

    $projects_loc = array(
        array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-projects.php' ) ),
        array( array( 'param' => 'post_template', 'operator' => '==', 'value' => 'page-projects.php' ) ),
        array( array( 'param' => 'page_slug', 'operator' => '==', 'value' => 'projects' ) ),
    );
    if ( $projects_id ) {
        $projects_loc[] = array( array( 'param' => 'page', 'operator' => '==', 'value' => (string) $projects_id ) );
    }

    acf_add_local_field_group( array(
        'key'                   => 'group_page_projects',
        'title'                 => 'Projects Page Configuration',
        'fields'                => $projects_page_fields,
        'location'              => $projects_loc,
        'menu_order'            => 0,
        'position'              => 'acf_after_title',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => array( 'the_content' ),
    ) );

    // =========================================================================
    // 5. Contact Page Field Group
    // =========================================================================
    $contact_page_fields = array_merge( array(
        array( 'key' => 'tab_cp_hero', 'label' => 'Hero Banner', 'type' => 'tab' ),
        array( 'key' => 'field_cp_badge', 'label' => 'Hero Pill Badge', 'name' => 'hero_badge_text', 'type' => 'text', 'default_value' => 'STRATEGIC ADVISORY • CONSULTATION INQUIRIES' ),
        array( 'key' => 'field_cp_title_line1', 'label' => 'Hero Title Line 1', 'name' => 'hero_title_line1', 'type' => 'text', 'default_value' => "Let's Build Common Ground" ),
        array( 'key' => 'field_cp_title_line2', 'label' => 'Hero Title Line 2 (Gradient)', 'name' => 'hero_title_line2', 'type' => 'text', 'default_value' => 'Through High-Impact Storytelling' ),
        array( 'key' => 'field_cp_subtitle', 'label' => 'Hero Subtitle', 'name' => 'hero_subtitle', 'type' => 'textarea', 'rows' => 3, 'default_value' => "Whether you are navigating executive communication hurdles, preparing a high-stakes legislative campaign, or commissioning an impact documentary, let's discuss how strategic narratives can turn your challenge into an advantage." ),
    ), rs_get_stat_subfields( 'cp' ), array(
        array( 'key' => 'tab_cp_inquiries', 'label' => 'Inquiry Information Box', 'type' => 'tab' ),
        array( 'key' => 'field_cp_inq_title', 'label' => 'Inquiry Box Title', 'name' => 'inquiry_box_title', 'type' => 'text', 'default_value' => 'Direct Consultation & Advisory' ),
        array( 'key' => 'field_cp_inq_desc', 'label' => 'Inquiry Box Description', 'name' => 'inquiry_box_desc', 'type' => 'textarea', 'rows' => 3, 'default_value' => "Roger Sorkin works with a limited number of organizations, coalitions, and production partners each year to ensure uncompromising depth, senior-level attention, and narrative impact." ),
    ) );

    $contact_loc = array(
        array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-contact.php' ) ),
        array( array( 'param' => 'post_template', 'operator' => '==', 'value' => 'page-contact.php' ) ),
        array( array( 'param' => 'page_slug', 'operator' => '==', 'value' => 'contact' ) ),
    );
    if ( $contact_id ) {
        $contact_loc[] = array( array( 'param' => 'page', 'operator' => '==', 'value' => (string) $contact_id ) );
    }

    acf_add_local_field_group( array(
        'key'                   => 'group_page_contact',
        'title'                 => 'Contact Page Configuration',
        'fields'                => $contact_page_fields,
        'location'              => $contact_loc,
        'menu_order'            => 0,
        'position'              => 'acf_after_title',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => array( 'the_content' ),
    ) );

    // =========================================================================
    // 6. Project CPT Field Group
    // =========================================================================
    $project_cpt_fields = array_merge( array(
        array( 'key' => 'tab_prj_meta', 'label' => 'Hero & Card Settings', 'type' => 'tab' ),
        array( 'key' => 'field_proj_category_pill', 'label' => 'Hero Category Pill Text', 'name' => 'category_pill', 'type' => 'text', 'instructions' => 'e.g. DEFENSE & ENERGY • FEATURE DOCUMENTARY (2015)' ),
        array( 'key' => 'field_proj_hero_subtitle', 'label' => 'Hero Subtitle', 'name' => 'hero_subtitle', 'type' => 'textarea', 'rows' => 2 ),
        array( 'key' => 'field_proj_featured_homepage', 'label' => 'Featured on Homepage Slider?', 'name' => 'featured_homepage', 'type' => 'true_false', 'default_value' => 1 ),
        array( 'key' => 'field_proj_hover_tag', 'label' => 'Card Hover Tag Pill', 'name' => 'hover_tag', 'type' => 'text', 'instructions' => 'e.g. National Security', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_proj_card_accent', 'label' => 'Card Footer Accent Tag', 'name' => 'card_accent', 'type' => 'text', 'instructions' => 'e.g. Defense & Energy • Feature Film', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_proj_card_cta_label', 'label' => 'Card Button Label', 'name' => 'card_cta_label', 'type' => 'text', 'default_value' => 'Case Study Details →' ),
        array( 'key' => 'field_proj_poster_image', 'label' => 'Poster Artwork (Upload custom image or leave empty for default)', 'name' => 'poster_image', 'type' => 'image', 'return_format' => 'array' ),
    ), rs_get_stat_subfields( 'prj' ), array(
        array( 'key' => 'tab_prj_snapshot', 'label' => 'Strategic Snapshot', 'type' => 'tab' ),
        array( 'key' => 'field_snap_entity', 'label' => 'Entity', 'name' => 'snapshot_entity', 'type' => 'text', 'default_value' => 'American Resilience Project' ),
        array( 'key' => 'field_snap_director', 'label' => 'Director / Lead', 'name' => 'snapshot_director', 'type' => 'text', 'default_value' => 'Roger Sorkin' ),
        array( 'key' => 'field_snap_format', 'label' => 'Format / Length', 'name' => 'snapshot_format', 'type' => 'text' ),
        array( 'key' => 'field_snap_release', 'label' => 'Release Year / Status', 'name' => 'snapshot_release', 'type' => 'text' ),
        array( 'key' => 'field_snap_messengers', 'label' => 'Messengers / Focus', 'name' => 'snapshot_messengers', 'type' => 'text' ),
        array( 'key' => 'field_snap_link_url', 'label' => 'External Film / Project URL', 'name' => 'snapshot_link_url', 'type' => 'url', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_snap_link_label', 'label' => 'External Link Button Label', 'name' => 'snapshot_link_label', 'type' => 'text', 'default_value' => 'Watch the Full Film →', 'wrapper' => array( 'width' => '50' ) ),

        array( 'key' => 'tab_prj_narrative', 'label' => 'Purpose & Impact', 'type' => 'tab' ),
        array( 'key' => 'field_proj_purpose_heading', 'label' => 'Strategic Purpose Heading', 'name' => 'purpose_heading', 'type' => 'text' ),
        array( 'key' => 'field_proj_purpose_content', 'label' => 'Strategic Purpose Content', 'name' => 'purpose_content', 'type' => 'wysiwyg', 'media_upload' => 0 ),
        array( 'key' => 'field_proj_impact_heading', 'label' => 'Documented Impact Heading', 'name' => 'impact_heading', 'type' => 'text' ),
        array( 'key' => 'field_proj_impact_intro', 'label' => 'Documented Impact Intro Text', 'name' => 'impact_intro', 'type' => 'textarea', 'rows' => 2 ),
        // Discrete Impact Bullets (Free ACF compatible)
        array( 'key' => 'field_bullet_1_lead', 'label' => 'Impact Bullet 1 Lead', 'name' => 'bullet_1_lead', 'type' => 'text', 'wrapper' => array( 'width' => '30' ) ),
        array( 'key' => 'field_bullet_1_text', 'label' => 'Impact Bullet 1 Text', 'name' => 'bullet_1_text', 'type' => 'textarea', 'rows' => 2, 'wrapper' => array( 'width' => '70' ) ),
        array( 'key' => 'field_bullet_2_lead', 'label' => 'Impact Bullet 2 Lead', 'name' => 'bullet_2_lead', 'type' => 'text', 'wrapper' => array( 'width' => '30' ) ),
        array( 'key' => 'field_bullet_2_text', 'label' => 'Impact Bullet 2 Text', 'name' => 'bullet_2_text', 'type' => 'textarea', 'rows' => 2, 'wrapper' => array( 'width' => '70' ) ),
        array( 'key' => 'field_bullet_3_lead', 'label' => 'Impact Bullet 3 Lead', 'name' => 'bullet_3_lead', 'type' => 'text', 'wrapper' => array( 'width' => '30' ) ),
        array( 'key' => 'field_bullet_3_text', 'label' => 'Impact Bullet 3 Text', 'name' => 'bullet_3_text', 'type' => 'textarea', 'rows' => 2, 'wrapper' => array( 'width' => '70' ) ),

        array( 'key' => 'tab_prj_awards_media', 'label' => 'Awards & Video', 'type' => 'tab' ),
        array( 'key' => 'field_award_1_title', 'label' => 'Award 1 Title', 'name' => 'award_1_title', 'type' => 'text', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_award_1_event', 'label' => 'Award 1 Event / Organization', 'name' => 'award_1_event', 'type' => 'text', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_award_2_title', 'label' => 'Award 2 Title', 'name' => 'award_2_title', 'type' => 'text', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_award_2_event', 'label' => 'Award 2 Event / Organization', 'name' => 'award_2_event', 'type' => 'text', 'wrapper' => array( 'width' => '50' ) ),
        array( 'key' => 'field_proj_quote_text', 'label' => 'Callout Quote Text', 'name' => 'quote_text', 'type' => 'textarea', 'rows' => 2 ),
        array( 'key' => 'field_proj_quote_cite', 'label' => 'Callout Quote Citation', 'name' => 'quote_cite', 'type' => 'text' ),
        array( 'key' => 'field_proj_video_url', 'label' => 'Video Embed URL (Vimeo / YouTube)', 'name' => 'video_url', 'type' => 'url' ),
        array( 'key' => 'field_proj_video_title', 'label' => 'Video Section Title', 'name' => 'video_title', 'type' => 'text' ),
        array( 'key' => 'field_proj_video_desc', 'label' => 'Video Section Subtitle / Description', 'name' => 'video_desc', 'type' => 'textarea', 'rows' => 2 ),
    ) );

    acf_add_local_field_group( array(
        'key'                   => 'group_project_details',
        'title'                 => 'Project Case Study Information',
        'fields'                => $project_cpt_fields,
        'location'              => array(
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'project' ) ),
        ),
        'menu_order'            => 0,
        'position'              => 'acf_after_title',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
    ) );

    // =========================================================================
    // 7. Service CPT Field Group
    // =========================================================================
    acf_add_local_field_group( array(
        'key'                   => 'group_service_details',
        'title'                 => 'Service Configuration & Deliverables',
        'fields'                => array(
            array( 'key' => 'tab_srv_overview', 'label' => 'Service Overview', 'type' => 'tab' ),
            array( 'key' => 'field_srv_anchor_id', 'label' => 'Anchor ID (slug on services page)', 'name' => 'anchor_id', 'type' => 'text', 'instructions' => 'e.g. fractional-cco, audit, simulations, media-training, coaching, content-roadmap, podcast, filmmaking' ),
            array( 'key' => 'field_srv_tagline', 'label' => 'Short Tagline (Used on Homepage Interactive Node Network)', 'name' => 'tagline', 'type' => 'text' ),
            array( 'key' => 'field_srv_capability_tag', 'label' => 'Capability Tag', 'name' => 'capability_tag', 'type' => 'text', 'instructions' => 'e.g. CAPABILITY 01 • STRATEGIC LEADERSHIP' ),
            array( 'key' => 'field_srv_title_line1', 'label' => 'Heading Line 1', 'name' => 'title_line1', 'type' => 'text', 'wrapper' => array( 'width' => '50' ) ),
            array( 'key' => 'field_srv_title_line2', 'label' => 'Heading Line 2', 'name' => 'title_line2', 'type' => 'text', 'wrapper' => array( 'width' => '50' ) ),
            array( 'key' => 'field_srv_lead_text', 'label' => 'Lead Paragraph', 'name' => 'lead_text', 'type' => 'textarea', 'rows' => 3 ),
            array( 'key' => 'field_srv_body_text', 'label' => 'Body Paragraph', 'name' => 'body_text', 'type' => 'textarea', 'rows' => 3 ),
            array( 'key' => 'tab_srv_deliverables', 'label' => 'Deliverables & Media', 'type' => 'tab' ),
            array( 'key' => 'field_srv_deliverables_title', 'label' => 'Deliverables Box Title', 'name' => 'deliverables_title', 'type' => 'text', 'default_value' => 'Core Capabilities & Deliverables' ),
            array( 'key' => 'field_srv_deliverables_text', 'label' => 'Deliverables List (One per line)', 'name' => 'deliverables_text', 'type' => 'textarea', 'rows' => 5, 'instructions' => 'Enter one deliverable bullet per line. Press Enter for each new item.' ),
            array( 'key' => 'field_srv_photo', 'label' => 'Service Section Photo (Upload custom image or leave empty for default)', 'name' => 'photo', 'type' => 'image', 'return_format' => 'array' ),
            array( 'key' => 'field_srv_cta_label', 'label' => 'Action Button Label', 'name' => 'cta_label', 'type' => 'text', 'default_value' => 'Engage Service →', 'wrapper' => array( 'width' => '50' ) ),
            array( 'key' => 'field_srv_cta_url', 'label' => 'Action Button URL', 'name' => 'cta_url', 'type' => 'text', 'default_value' => '/contact/', 'wrapper' => array( 'width' => '50' ) ),
        ),
        'location'              => array(
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ) ),
        ),
        'menu_order'            => 0,
        'position'              => 'acf_after_title',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
    ) );

    // =========================================================================
    // 8. Testimonial CPT Field Group
    // =========================================================================
    acf_add_local_field_group( array(
        'key'                   => 'group_testimonial_details',
        'title'                 => 'Testimonial Details',
        'fields'                => array(
            array( 'key' => 'field_test_author_title', 'label' => 'Author Title & Organization', 'name' => 'author_title', 'type' => 'text', 'instructions' => 'e.g. USN (RET.) or FOUNDER & CEO, TILT GLOBAL DECISIONS' ),
            array( 'key' => 'field_test_featured_home', 'label' => 'Featured on Homepage Slider?', 'name' => 'featured_home', 'type' => 'true_false', 'default_value' => 1 ),
        ),
        'location'              => array(
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'testimonial' ) ),
        ),
        'menu_order'            => 0,
        'position'              => 'acf_after_title',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
    ) );
}
add_action( 'acf/init', 'rs_register_acf_field_groups' );
