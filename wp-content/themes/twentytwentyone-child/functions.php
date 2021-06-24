<?php

require_once( __DIR__ . '/widgets/register-widgets.php');

add_action( 'wp_enqueue_scripts', 'add_theme_style' );
function add_theme_style() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'sale_events', get_stylesheet_directory_uri() . '/widgets/elementor-sale-events/assets/sale-events.css' );
}

// add_action( 'woocommerce_order_status_changed', function($id, $status_transition_from, $status_transition_to, $that) {
// 	error_log($status_transition_to . 'qwerty');
// }, 10, 4);