<?php
/**
 * Plugin Name: My Classic Widgets
 * Description: Adds a custom classic widget.
 * Version: 0.3
 * Author: Rabia Gull
 * Text Domain: my-classic-widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Include widget class
require_once plugin_dir_path( __FILE__ ) . 'My_Custom_Widget.php';

// Register widget
add_action( 'widgets_init', 'mcw_register_widget' );

function mcw_register_widget() {
    register_widget( 'My_Custom_Widget' );
}


add_action( 'admin_enqueue_scripts', 'mcw_add_admin_script' );


function mcw_add_admin_script() {

    wp_enqueue_style("mcw_stlye", plugin_dir_url(__FILE__) . "style.css");
    
    wp_enqueue_script("admin-script", plugin_dir_url(__FILE__) . "/script.js", array("jquery"));



    
}