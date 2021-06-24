<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Sale events Widget.
 *
 * Elementor widget with a progress bar that can be embedded in every WooCommerce product page using Elementor.
 *
 * @since 1.0.0
 */
class Widget_Sale_Events extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Sale events widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'sale_events';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Sale events widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Sale events', 'elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Sale events widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-usd';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Sale events widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 * 
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'sale_events' ];
	}

	/**
	 * Get all Sale events.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function get_events() {
		$array = [];
		query_posts('post_type=sale_events');

		if( have_posts() ) : while( have_posts() ) : the_post();
			$array[get_the_ID()] = get_the_title();
		endwhile; endif;

		wp_reset_query();
		return $array;
	}

	/**
	 * Register Sale events widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_progress_bar',
			[
				'label' => __( 'Progress bar', 'elementor' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $this->get_events(),
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render Sale events widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$event_id = $settings['title'];
		$event = get_post( $event_id );

		if (get_field( 'event_status', $event_id ) == 'on') {

			$purchases = (int) get_field( 'purchases', $event_id );

			while ( have_rows( 'starting_stats', $event_id ) ) : the_row();
				$starting_price = get_sub_field( 'starting_price' );
				$starting_orders = get_sub_field( 'starting_orders' );
			endwhile;

			while ( have_rows( 'goal_a', $event_id ) ) : the_row();
				$goal_a_price = get_sub_field( 'goal_a_price' );
				$goal_a_min_orders = get_sub_field( 'goal_a_min_orders' );
			endwhile;

			while ( have_rows( 'goal_b', $event_id ) ) : the_row();
				$goal_b_price = get_sub_field( 'goal_b_price' );
				$goal_b_min_orders = get_sub_field( 'goal_b_min_orders' );
			endwhile;

			$event_dot = ($purchases*100)/$goal_b_min_orders;

			$prods_id_event = get_field( 'included_products', $event_id );

			foreach ( $prods_id_event as $prod_id_event ) {
				$edited_product = wc_get_product( $prod_id_event );
				$product_price = $edited_product->get_sale_price();
			}

			while ( have_rows( 'start_end_date', $post_ID ) ) : the_row();
				$event_start_date = strtotime( get_sub_field( 'start_date' ) );
				$event_end_date = strtotime( get_sub_field( 'end_date' ) );
			endwhile;

			$this->add_render_attribute(
				'wrapper',
				[
					'class' => 'custom-widget-wrapper-class',
				]
			); ?>

			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<div>
					<?php echo $event -> { 'post_title' }; ?>
				</div>
				<div>
					<?php the_field( 'sale_event_name', $event_id ); ?>
				</div>
				<div class="event">
					<div class="goal">
						<div>
							<?php the_field( 'currency', $event_id ); ?>
							<?php echo $starting_price; ?>
						</div>
							<span class="goal_dot"></span>
						<div>
							<?php echo $starting_orders; ?>
						</div>
					</div>

					<div class="goal">
						<div>
							<?php the_field( 'currency', $event_id ); ?>
							<?php echo $goal_a_price; ?>
						</div>
							<span class="goal_dot"></span>
						<div>
							<?php echo $goal_a_min_orders; ?>
						</div>
					</div>

					<div class="goal">
						<div>
							<?php the_field( 'currency', $event_id ); ?>
							<?php echo $goal_b_price; ?>
						</div>
							<span class="goal_dot"></span>
						<div>
							<?php echo $goal_b_min_orders; ?>
						</div>
					</div>
				</div>
				<div class="progress">
					<div class="progress_line" style="width: <?php echo $event_dot; ?>%"></div>
				</div>
				<div>
					Purchases: <?php echo $purchases; ?>
				</div>
				<div>
					Product price: <?php echo $product_price; ?>
				</div>
			</div>
			<div>
				<pre> <?php
					//print_r( _get_cron_array() );
					//echo strtotime( $event_start_date );
					var_dump( $event_start_date );
					//date_default_timezone_set('Europe/Minsk');
					//echo current_time( 'mysql' );
				?> </pre>
			</div>

		<?php } elseif (get_field( 'event_status', $event_id ) == 'off') { ?>
			<div>
				Sale event: <?php the_field( 'sale_event_name', $event_id ); ?> closed.
				<pre> <?php
					//print_r( _get_cron_array() );
				?> </pre>
			</div>
		<?php }
	}
}