<?php

add_action( 'init', 'post_type_family' );

function post_type_family() {
    register_post_type( 'family',
        array(
            'labels' => array(
                'name' => 'Family',
                'singular_name' => 'Family Member',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Family Member',
                'edit' => 'Edit',
                'edit_item' => 'Edit Family Member',
                'new_item' => 'New Family Member',
                'view' => 'View',
                'view_item' => 'View Family Member',
                'search_items' => 'Search Family Member',
                'not_found' => 'No Family Member found',
                'not_found_in_trash' => 'No Family Member found in Trash',
                'parent' => 'Parent Family Member'
            ),
            'public' => true,
            'menu_position' => 20,
            'supports' => array( 'thumbnail' ),
            'menu_icon' => plugins_url( 'image.png', __FILE__ ),
            'has_archive' => true
        )
    );
}

?>