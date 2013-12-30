<?php
/*
Plugin Name: WP-Family
Plugin URI: https://github.com/mmcquillan/wp-family
Description: Wordpress Plugin for Family Genealogy Records using the Native Wordpress Structure
Version: 1.0
Author: Matt McQuillan
Author URI: http://mattmcquillan.com
License: Apache v2
*/

require_once(plugin_dir_path( __FILE__ ) . 'functions_family.php');
require_once(plugin_dir_path( __FILE__ ) . 'post_type_family.php');
require_once(plugin_dir_path( __FILE__ ) . 'meta_box_family.php');
require_once(plugin_dir_path( __FILE__ ) . 'save_post_family.php');
require_once(plugin_dir_path( __FILE__ ) . 'template_include_family.php');
require_once(plugin_dir_path( __FILE__ ) . 'enqueue_scripts_family.php');

?>