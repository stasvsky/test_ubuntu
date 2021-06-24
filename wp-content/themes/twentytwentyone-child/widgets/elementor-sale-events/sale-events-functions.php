<?php

add_action( 'save_post', 'create_new_cron', 10, 3 );
function create_new_cron( $post_ID, $post, $update ) {
	if( $post->post_type == 'sale_events' ) {
		wp_unschedule_hook( 'start_sale_event_' . $post_ID );
		//wp_unschedule_hook( 'end_sale_event' );

		while ( have_rows( 'start_end_date', $post_ID ) ) : the_row();
			$event_start_date = strtotime( get_sub_field( 'start_date' ) );
			$event_end_date = strtotime( get_sub_field( 'end_date' ) );
		endwhile;

		wp_schedule_single_event( $event_start_date, 'start_sale_event_' . $post_ID, array( $post_ID ) );
		//wp_schedule_single_event( $event_end_date - 10800, 'end_sale_event', array( $post_ID ) );
	}
}

add_action( 'start_sale_event_' . $post_ID, function ( $post_ID ) {
	update_field( 'event_status', 'on', $post_ID );
}, 10, 1 );

// add_action( 'end_sale_event', function ( $post_ID ){
// 	update_field( 'event_status', 'off', $post_ID );
// }, 10, 1 );


function set_product_price( $event ) {
	$prods_id_event = get_field( 'included_products', $event->ID );
	$purchases = get_field( 'purchases', $event->ID );

	while ( have_rows( 'starting_stats', $event->ID ) ) : the_row();
		$starting_price = get_sub_field( 'starting_price' );
		$starting_orders = get_sub_field( 'starting_orders' );
	endwhile;

	while ( have_rows( 'goal_a', $event->ID ) ) : the_row();
		$goal_a_price = get_sub_field( 'goal_a_price' );
		$goal_a_min_orders = get_sub_field( 'goal_a_min_orders' );
	endwhile;

	while ( have_rows( 'goal_b', $event->ID ) ) : the_row();
		$goal_b_price = get_sub_field( 'goal_b_price' );
		$goal_b_min_orders = get_sub_field( 'goal_b_min_orders' );
	endwhile;

	foreach ( $prods_id_event as $prod_id_event ) {
		$edited_product = wc_get_product( $prod_id_event );

		if (get_field( 'event_status', $event->ID ) == 'on' && $purchases >= $starting_orders && $purchases < $goal_a_min_orders) {
			$edited_product->set_sale_price( $starting_price );
		} elseif (get_field( 'event_status', $event->ID ) == 'on' && $purchases >= $goal_a_min_orders && $purchases < $goal_b_min_orders) {
			$edited_product->set_sale_price( $goal_a_price );
		} elseif (get_field( 'event_status', $event->ID ) == 'on' && $purchases >= $goal_b_min_orders) {
			$edited_product->set_sale_price( $goal_b_price );
		} elseif (get_field( 'event_status', $event->ID ) == 'off') {
			$edited_product->set_sale_price( $edited_product->get_regular_price() );
		}

		$edited_product->save();
	}
}

add_action( 'woocommerce_order_status_changed', 'event_purchases' , 10, 4 );
function event_purchases($id, $status_transition_from, $status_transition_to, $that) {
	if ($status_transition_to == 'completed') {

		$items = wc_get_order( $id )->get_items();
		foreach ( $items as $item ) {
			$prods_id_item[] = $item->get_product_id();
			$quantity[$item->get_product_id()] = $item->get_quantity();
		}

		$events = get_posts( array(
			'meta_key'		=> 'event_status',
			'meta_value'	=> 'on',
			'post_type'		=> 'sale_events',
		) );

		foreach ( $events as $event ) {
			$prods_id_event = get_field( 'included_products', $event->ID );

			if ($intersect = array_intersect($prods_id_event, $prods_id_item)) {
				$purchases = get_field( 'purchases', $event->ID );

				foreach ( $intersect as $id) {
					$purchases += $quantity[$id];
				}

				update_field( 'purchases', $purchases, $event->ID );
				set_product_price($event);
			}
		}
	}
}

add_action( 'save_post', 'event_prices', 10, 3 );
function event_prices( $post_ID, $post, $update ) {
	if ($post->post_type == 'sale_events') {
		set_product_price($post);
	}
}