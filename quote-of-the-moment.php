<?php
/**
 * Plugin Name: Quote Of The Moment
 * Plugin URI: http://spoffle.com/plugins/quote-of-the-moment/
 * Description: A widgetized and themeable inspirational quote plugin.
 * Version: 1.0.0
 * Author: Neil Porter
 * Author URI: http://spoffle.com/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

// disallow direct access to this PHP file
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// set default option values
$qotm_options_default_array = array("poll_interval" => "10000","url" => "http://spoffle.com/qotm/getqotm.php");
add_option('qotm_options', $qotm_options_default_array);

// Include our admin panel
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/quote-of-the-moment/admin.php');

// Include our widget code
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/quote-of-the-moment/qotm_widget.php');

// Include our css file
add_action( 'wp_enqueue_scripts', 'add_qotm_stylesheet' );
	function add_qotm_stylesheet() {
	wp_enqueue_style( 'qotm-plugin-style', plugins_url('style.css', __FILE__) );
}

// enable script access to Wordpress variables, example $plugin_url = jQueryOptionValues.plugin_url
add_action( 'template_redirect', 'prefix_enqueue_vars' );
function prefix_enqueue_vars() {
	$script_vars = array(
		'qotm_options' => get_option( 'qotm_options' ),
	);

	wp_localize_script( 'qotm_plugin_script', 'jQueryOptionValues', $script_vars );
}

// Include our jquery script
wp_register_script( 'qotm_plugin_script', plugins_url('script.js', __FILE__), array('jquery'));
wp_enqueue_script( 'qotm_plugin_script' );

?>