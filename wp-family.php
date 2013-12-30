<?php
/*
Plugin Name: WP-Family
Plugin URI: http://mattmcquillan.com
Description: Wordpress Plugin for Family Genealogy Records using the Native Wordpress Structure
Version: 1.0
Author: Matt McQuillan
Author URI: http://mattmcquillan.com
License: Apache v2
*/

require_once(sprintf("%s/functions_family.php", dirname(__FILE__)));
require_once(sprintf("%s/post_type_family.php", dirname(__FILE__)));
require_once(sprintf("%s/meta_box_family.php", dirname(__FILE__)));
require_once(sprintf("%s/save_post_family.php", dirname(__FILE__)));
require_once(sprintf("%s/template_include_family.php", dirname(__FILE__)));
require_once(sprintf("%s/enqueue_scripts_family.php", dirname(__FILE__)));

?>