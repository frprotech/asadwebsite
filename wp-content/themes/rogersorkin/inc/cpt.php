<?php
/**
 * Register Custom Post Types & Taxonomies
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function rs_register_post_types() {
    // 1. Projects CPT
    $project_labels = array(
        'name'               => 'Projects',
        'singular_name'      => 'Project',
        'menu_name'          => 'Projects',
        'name_admin_bar'     => 'Project',
        'add_new'            => 'Add New Project',
        'add_new_item'       => 'Add New Case Study / Project',
        'edit_item'          => 'Edit Project',
        'new_item'           => 'New Project',
        'view_item'          => 'View Project',
        'all_items'          => 'All Projects',
        'search_items'       => 'Search Projects',
        'not_found'          => 'No projects found.',
    );

    register_post_type( 'project', array(
        'labels'             => $project_labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array( 'slug' => 'projects', 'with_front' => false ),
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array( 'title', 'thumbnail', 'page-attributes' ),
        'show_in_rest'       => false,
        'hierarchical'       => false,
    ) );

    // Project Categories Taxonomy
    $cat_labels = array(
        'name'              => 'Project Categories',
        'singular_name'     => 'Project Category',
        'search_items'      => 'Search Project Categories',
        'all_items'         => 'All Project Categories',
        'edit_item'         => 'Edit Project Category',
        'update_item'       => 'Update Project Category',
        'add_new_item'      => 'Add New Project Category',
        'new_item_name'     => 'New Project Category Name',
        'menu_name'         => 'Project Categories',
    );

    register_taxonomy( 'project_category', array( 'project' ), array(
        'hierarchical'      => true,
        'labels'            => $cat_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'project-category' ),
        'show_in_rest'      => false,
    ) );

    // 2. Services CPT
    $service_labels = array(
        'name'               => 'Services',
        'singular_name'      => 'Service',
        'menu_name'          => 'Services',
        'name_admin_bar'     => 'Service',
        'add_new'            => 'Add New Service',
        'add_new_item'       => 'Add New Service',
        'edit_item'          => 'Edit Service',
        'new_item'           => 'New Service',
        'view_item'          => 'View Service',
        'all_items'          => 'All Services',
        'search_items'       => 'Search Services',
    );

    register_post_type( 'service', array(
        'labels'             => $service_labels,
        'public'             => true,
        'publicly_queryable' => false,
        'has_archive'        => false,
        'menu_icon'          => 'dashicons-briefcase',
        'supports'           => array( 'title', 'thumbnail', 'page-attributes' ),
        'show_in_rest'       => false,
    ) );

    // 3. Testimonials CPT
    $testimonial_labels = array(
        'name'               => 'Testimonials',
        'singular_name'      => 'Testimonial',
        'menu_name'          => 'Testimonials',
        'name_admin_bar'     => 'Testimonial',
        'add_new'            => 'Add New Testimonial',
        'add_new_item'       => 'Add New Testimonial',
        'edit_item'          => 'Edit Testimonial',
        'new_item'           => 'New Testimonial',
        'all_items'          => 'All Testimonials',
    );

    register_post_type( 'testimonial', array(
        'labels'             => $testimonial_labels,
        'public'             => true,
        'publicly_queryable' => false,
        'has_archive'        => false,
        'menu_icon'          => 'dashicons-format-quote',
        'supports'           => array( 'title', 'editor', 'page-attributes' ),
        'show_in_rest'       => false,
    ) );
}
add_action( 'init', 'rs_register_post_types' );
