<?php
namespace Elementor;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'elementor/widgets/widgets_registered', function() {
	//require_once( __DIR__ . '/widgets/custom.php' );
	require_once( __DIR__ . '/elementor-sale-events/sale-events.php' );
	require_once( __DIR__ . '/elementor-sale-events/sale-events-functions.php');

	//Plugin::instance()->widgets_manager->register_widget_type( new Widget_Custom() );
	Plugin::instance()->widgets_manager->register_widget_type( new Widget_Sale_Events() );
});