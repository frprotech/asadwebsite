<?php
/**
 * Theme Helper Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get ACF Field with graceful fallback to post meta or option
 */
function rs_get_field( $selector, $post_id = false, $default = '' ) {
    $pid = $post_id ? $post_id : get_the_ID();

    if ( function_exists( 'get_field' ) ) {
        // Direct field lookup
        $val = get_field( $selector, $pid );
        if ( $val !== null && $val !== '' && $val !== false ) {
            return $val;
        }

        // Support group field lookup if selector contains dot or underscore
        if ( strpos( $selector, '_' ) !== false ) {
            $parts = explode( '_', $selector, 2 );
            $group_val = get_field( $parts[0], $pid );
            if ( is_array( $group_val ) && isset( $group_val[ $parts[1] ] ) && $group_val[ $parts[1] ] !== '' ) {
                return $group_val[ $parts[1] ];
            }
        }
    }

    // Fallback to options if post_id is 'option' or 'options'
    if ( $pid === 'options' || $pid === 'option' ) {
        $opt = get_option( 'options_' . $selector, get_option( 'rs_' . $selector, get_option( $selector, $default ) ) );
        return ( $opt !== '' && $opt !== false && $opt !== null ) ? $opt : $default;
    }

    // Fallback to post meta
    if ( $pid && is_numeric( $pid ) ) {
        $meta = get_post_meta( $pid, $selector, true );
        if ( $meta !== '' && $meta !== false && $meta !== null ) {
            return $meta;
        }
    }

    return $default;
}

/**
 * Get ACF Option with graceful fallback
 */
function rs_get_option( $selector, $default = '' ) {
    if ( function_exists( 'get_field' ) ) {
        $val = get_field( $selector, 'option' );
        if ( $val !== null && $val !== '' && $val !== false ) {
            return $val;
        }
    }

    $val = get_option( 'options_' . $selector );
    if ( $val !== false && $val !== '' && $val !== null ) {
        return $val;
    }

    $val = get_option( 'rs_' . $selector );
    if ( $val !== false && $val !== '' && $val !== null ) {
        return $val;
    }

    $val = get_option( $selector );
    if ( $val !== false && $val !== '' && $val !== null ) {
        return $val;
    }

    return $default;
}

/**
 * Get Trust Bar / Key Stats (4 items) formatted as array of ['number' => ..., 'label' => ...]
 */
function rs_get_stats( $post_id = false, $default_stats = array() ) {
    $pid = $post_id ? $post_id : get_the_ID();
    $stats = array();

    // 1. Check numbered fields (Free ACF & clean UI)
    for ( $i = 1; $i <= 4; $i++ ) {
        $num = rs_get_field( "stat_{$i}_num", $pid );
        $lbl = rs_get_field( "stat_{$i}_label", $pid );
        if ( ! empty( $num ) ) {
            $stats[] = array( 'number' => $num, 'label' => $lbl );
        }
    }

    if ( ! empty( $stats ) ) {
        return $stats;
    }

    // 2. Check repeater field if active (Pro ACF fallback)
    $repeater = rs_get_field( 'trust_bar', $pid );
    if ( is_array( $repeater ) && ! empty( $repeater ) ) {
        foreach ( $repeater as $row ) {
            if ( ! empty( $row['number'] ) ) {
                $stats[] = array( 'number' => $row['number'], 'label' => isset($row['label']) ? $row['label'] : '' );
            }
        }
        if ( ! empty( $stats ) ) {
            return $stats;
        }
    }

    // 3. Check raw post meta count
    $count = get_post_meta( $pid, 'trust_bar', true );
    if ( $count && is_numeric( $count ) ) {
        for ( $i = 0; $i < $count; $i++ ) {
            $num = get_post_meta( $pid, "trust_bar_{$i}_number", true );
            $lbl = get_post_meta( $pid, "trust_bar_{$i}_label", true );
            if ( $num ) {
                $stats[] = array( 'number' => $num, 'label' => $lbl );
            }
        }
        if ( ! empty( $stats ) ) {
            return $stats;
        }
    }

    return $default_stats;
}

/**
 * Get Deliverables list as array of strings
 */
function rs_get_deliverables( $post_id = false, $default_items = array() ) {
    $pid = $post_id ? $post_id : get_the_ID();

    // 1. Check textarea field (one per line)
    $text = rs_get_field( 'deliverables_text', $pid );
    if ( ! empty( $text ) ) {
        $lines = preg_split( '/\r\n|\r|\n/', $text );
        $items = array();
        foreach ( $lines as $l ) {
            $trimmed = trim( $l );
            if ( ! empty( $trimmed ) ) {
                $items[] = ltrim( $trimmed, "-*• \t" );
            }
        }
        if ( ! empty( $items ) ) {
            return $items;
        }
    }

    // 2. Check repeater
    $repeater = rs_get_field( 'deliverables', $pid );
    if ( is_array( $repeater ) && ! empty( $repeater ) ) {
        $items = array();
        foreach ( $repeater as $row ) {
            if ( is_array( $row ) && ! empty( $row['item'] ) ) {
                $items[] = $row['item'];
            } elseif ( is_string( $row ) ) {
                $items[] = $row;
            }
        }
        if ( ! empty( $items ) ) {
            return $items;
        }
    }

    // 3. Check post meta loop
    $count = get_post_meta( $pid, 'deliverables', true );
    if ( $count && is_numeric( $count ) ) {
        $items = array();
        for ( $i = 0; $i < $count; $i++ ) {
            $item = get_post_meta( $pid, "deliverables_{$i}_item", true );
            if ( $item ) {
                $items[] = $item;
            }
        }
        if ( ! empty( $items ) ) {
            return $items;
        }
    }

    return $default_items;
}

/**
 * Get Impact Bullets as array of ['lead' => ..., 'text' => ...]
 */
function rs_get_bullets( $post_id = false, $default_bullets = array() ) {
    $pid = $post_id ? $post_id : get_the_ID();
    $bullets = array();

    // 1. Check numbered fields
    for ( $i = 1; $i <= 4; $i++ ) {
        $lead = rs_get_field( "bullet_{$i}_lead", $pid );
        $text = rs_get_field( "bullet_{$i}_text", $pid );
        if ( ! empty( $lead ) || ! empty( $text ) ) {
            $bullets[] = array( 'lead' => $lead, 'text' => $text );
        }
    }
    if ( ! empty( $bullets ) ) {
        return $bullets;
    }

    // 2. Check repeater
    $repeater = rs_get_field( 'impact_bullets', $pid );
    if ( is_array( $repeater ) && ! empty( $repeater ) ) {
        foreach ( $repeater as $row ) {
            if ( ! empty( $row['lead'] ) || ! empty( $row['text'] ) ) {
                $bullets[] = array( 'lead' => $row['lead'], 'text' => $row['text'] );
            }
        }
        if ( ! empty( $bullets ) ) {
            return $bullets;
        }
    }

    // 3. Check post meta
    $count = get_post_meta( $pid, 'impact_bullets', true );
    if ( $count && is_numeric( $count ) ) {
        for ( $i = 0; $i < $count; $i++ ) {
            $lead = get_post_meta( $pid, "impact_bullets_{$i}_lead", true );
            $text = get_post_meta( $pid, "impact_bullets_{$i}_text", true );
            if ( $lead || $text ) {
                $bullets[] = array( 'lead' => $lead, 'text' => $text );
            }
        }
        if ( ! empty( $bullets ) ) {
            return $bullets;
        }
    }

    return $default_bullets;
}

/**
 * Get Awards as array of ['title' => ..., 'event' => ...]
 */
function rs_get_awards( $post_id = false, $default_awards = array() ) {
    $pid = $post_id ? $post_id : get_the_ID();
    $awards = array();

    for ( $i = 1; $i <= 3; $i++ ) {
        $title = rs_get_field( "award_{$i}_title", $pid );
        $event = rs_get_field( "award_{$i}_event", $pid );
        if ( ! empty( $title ) ) {
            $awards[] = array( 'title' => $title, 'event' => $event );
        }
    }
    if ( ! empty( $awards ) ) {
        return $awards;
    }

    $count = get_post_meta( $pid, 'awards', true );
    if ( $count && is_numeric( $count ) ) {
        for ( $i = 0; $i < $count; $i++ ) {
            $t = get_post_meta( $pid, "awards_{$i}_title", true );
            $e = get_post_meta( $pid, "awards_{$i}_event", true );
            if ( $t ) {
                $awards[] = array( 'title' => $t, 'event' => $e );
            }
        }
        if ( ! empty( $awards ) ) {
            return $awards;
        }
    }

    return $default_awards;
}

/**
 * Asset URL helper pointing to theme assets/ directory
 */
function rs_asset( $path ) {
    if ( empty( $path ) ) {
        return '';
    }
    if ( strpos( $path, 'http://' ) === 0 || strpos( $path, 'https://' ) === 0 || strpos( $path, '//' ) === 0 ) {
        return $path;
    }
    $clean = ltrim( preg_replace( '#^/?(assets/)?#', '', $path ), '/' );
    // Handle unencoded space in asset paths like 'logo icon.svg'
    $encoded = str_replace( ' ', '%20', $clean );
    return get_template_directory_uri() . '/assets/' . $encoded;
}

/**
 * Image helper: handles ACF image array, image ID, attachment URL, or fallback string
 */
function rs_image_url( $image_data, $fallback_path = '' ) {
    if ( is_array( $image_data ) && ! empty( $image_data['url'] ) ) {
        return esc_url( $image_data['url'] );
    }
    if ( is_numeric( $image_data ) && $image_data > 0 ) {
        $src = wp_get_attachment_image_url( $image_data, 'full' );
        if ( $src ) {
            return esc_url( $src );
        }
    }
    if ( is_string( $image_data ) && ! empty( $image_data ) ) {
        if ( strpos( $image_data, 'http://' ) === 0 || strpos( $image_data, 'https://' ) === 0 || strpos( $image_data, '//' ) === 0 ) {
            return esc_url( $image_data );
        }
        if ( strpos( $image_data, '/wp-content' ) === 0 || strpos( $image_data, '/wp-includes' ) === 0 ) {
            return esc_url( $image_data );
        }
        return esc_url( rs_asset( $image_data ) );
    }
    if ( ! empty( $fallback_path ) ) {
        return esc_url( rs_asset( $fallback_path ) );
    }
    return '';
}

/**
 * Service Fallback Image Mapping
 */
function rs_get_service_fallback_image( $slug ) {
    $map = array(
        'fractional-cco' => 'services/roger-sorkin-senator-angus-king.webp',
        'audit'          => 'services/speaking-1.webp',
        'simulations'    => 'services/roger-hawaii.webp',
        'media-training' => 'services/roger-state-leg.webp',
        'coaching'       => 'services/roger-interview.webp',
        'framing'        => 'services/roger-state-leg.webp',
        'content-roadmap'=> 'services/rancher-solar-panels.webp',
        'podcast'        => 'services/roger-profile-3.webp',
        'filmmaking'     => 'services/woman-interview-creation.webp',
        'screening-tours'=> 'services/woman-interview-creation.webp',
    );

    foreach ( $map as $k => $img ) {
        if ( strpos( $slug, $k ) !== false ) {
            return $img;
        }
    }

    return 'services/roger-sorkin-senator-angus-king.webp';
}

/**
 * Project Fallback Poster Mapping
 */
function rs_get_project_fallback_poster( $slug ) {
    $map = array(
        'burden'              => 'projects/the-burden.webp',
        'tidewater'           => 'projects/Tidewater-Poster-25.webp',
        'fordham'             => 'projects/roger-sorkin-case-study.webp',
        'clean-economy'       => 'projects/clean-economy-now-cover.webp',
        'farm-free'           => 'projects/Farm-Free-Poster-18.webp',
        'current-revolution-series' => 'projects/current-revolution.webp',
        'current-rev'         => 'projects/current-revolution.webp',
        'nation-in-transition'=> 'projects/Current-Rev-NIT-Poster-15.webp',
        'resilient-on-the-ground' => 'projects/resilient-on-the-ground-poster-1.webp',
        'resilient-ground'    => 'projects/resilient-on-the-ground-poster-1.webp',
        'renewable-energy'    => 'projects/renewable-energy-poster.webp',
        'rural-america'       => 'projects/renewable-energy-poster.webp',
        'tedx'                => 'projects/planet-action-ted-x.webp',
        '10-rules'            => 'projects/10-rules.webp',
    );

    foreach ( $map as $k => $poster ) {
        if ( strpos( $slug, $k ) !== false ) {
            return $poster;
        }
    }

    return 'projects/the-burden.webp';
}
