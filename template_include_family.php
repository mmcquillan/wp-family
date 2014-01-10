<?php


add_filter( 'template_include', 'template_include_family', 1 );

function template_include_family( $template_path ) {
    if ( get_post_type() == 'family' ) {
        if ( is_single() ) {
            $template_path = plugin_dir_path( __FILE__ ) . 'single-family.php';
        }
        else {
            $template_path = plugin_dir_path( __FILE__ ) . 'list-family.php';
        }
    }
    return $template_path;
}


?>
