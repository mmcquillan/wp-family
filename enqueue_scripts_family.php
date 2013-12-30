<?php

add_action('wp_enqueue_scripts','enqueue_scripts_family');

function enqueue_scripts_family() {
    wp_register_style( 'family-style', plugins_url('family.css', __FILE__) );
    wp_enqueue_style( 'family-style' );
}

?>