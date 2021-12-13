<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Functionality that is required for the plugin
 */
if ( !class_exists( 'SPC_Main' ) ) {
	class SPC_Main
	{
		/**
		 * Load the plugin
		 */
		public function load() {
			$this->register_hooks();
		}

		/**
		 * Register the actions and filters for the plugin
		 */
		private function register_hooks() {
			add_shortcode( 'spc_posts', array( $this, 'spc_shortcode' ) );
		}

		/**
		 * Shortcode to get posts by Selected Primary Category
		 */
		public function spc_shortcode( $atts ) {
			// Define default shortcode values
			$atts = shortcode_atts( array(
				'type' 	   => 'any',
				'category' => 'uncategorized',
				'ppp'      => -1,
				'orderby'  => 'date',
				'order'    => ''
			), $atts );

			// Prepare the values for query
			$spc_query_args = array(
				'post_type'      => $atts['type'],
				'meta_key'       => 'spc_primary_cat',
				'meta_value'     => $atts['category'],
				'posts_per_page' => $atts['ppp'],
				'post_status'    => 'publish',
				'orderby'        => $atts['orderby']
			);

			// Set the order clause for query
			if ( isset( $atts['order'] ) && !empty( $atts['order'] ) ) {
				$spc_query_args['order'] = $atts['order'];
			}

			// Set the query
			$spc_html  = '';
			$spc_query = new WP_Query( $spc_query_args );

			// Loop the query
			if ( $spc_query -> have_posts() ) {
				$spc_html .= '<div class="spc-posts"><ul>';

				while ( $spc_query -> have_posts() ) {
					$spc_query -> the_post();

					$spc_html .= '<li><h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3></li>';
				}

				$spc_html .= '</ul></div>';

				// Reset the query & postdata
				wp_reset_query(); wp_reset_postdata();
			} else {
				// Empty Message
				$spc_html .= '<div class="spc-msg"><p>' . esc_html__( 'No post(s) found.', 'spc' ) . '</p></div>';
			}

			// Output
			echo $spc_html;
		}
	}
}
