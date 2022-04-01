<?php
/**
 * Plugin Name: Bigup Web: Table of Contents
 * Plugin URI: https://jeffersonreal.uk
 * Description: Dynamically build a table of contents from article headings.
 * Version: 0.13
 * Author: Jefferson Real
 * Author URI: https://jeffersonreal.uk
 * License: GPL2
 *
 * @package bigup_toc
 * @version 0.13
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2021, Jefferson Real
 * @license GPL2+
 * @link https://jeffersonreal.uk
 */


/**
 * Init the plugin (enqueue scripts and styles)
 */
function bigup_toc_scripts_and_styles() {
    wp_register_script ('bigup_toc_generator_js', plugins_url ( 'js/generator.js', __FILE__ ), array( 'jquery' ), '0.5', false);
    wp_register_style( 'bigup_toc_widget_css', plugins_url ( 'css/widget.css', __FILE__ ), array(), '0.1', 'all' );
}
add_action( 'wp_enqueue_scripts', 'bigup_toc_scripts_and_styles' );

/**
* Init the widget
*/
include( plugin_dir_path( __FILE__ ) . 'parts/widget.php');


/**
 * Register the shortcode.
 */
function shortcode_bigup_toc($atts) {

    if (empty($atts)) {
        $atts = array();
    }
    if (empty($atts['stopat'])) {
        $atts['stopat'] = 'h4';
    }
    if (empty($atts['offset'])) {
        $atts['offset'] = '20';
    }
    return '<div class="bigup_toc" data-stopat="' . $atts['stopat'] . '" data-offset="' . $atts['offset'] . '"></div>';
}
add_shortcode( 'bigup_toc', 'shortcode_bigup_toc' );
