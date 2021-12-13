<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Functionality that is required for the admin of the plugin
 */
if ( !class_exists( 'SPC_Admin' ) ) {
	class SPC_Admin
	{
		/**
		 * Load the admin functions
		 */
		public function load() {
			$this->spc_register_hooks();
		}

		/**
		 * Register the actions and filters for the Admin
		 */
		private function spc_register_hooks() {
			add_action( 'admin_enqueue_scripts', array( $this, 'spc_register_scripts' ) );
			add_action( 'add_meta_boxes',        array( $this, 'spc_create_meta_box') );
			add_action( 'save_post',             array( $this, 'spc_save_meta_fields' ) );
		}

		/**
		 * Enqueue scripts and styles for the Admin
		 */
		public function spc_register_scripts() {
			// Register admin styles and scripts
			wp_register_style( 'spc-styles', SPC_URL . 'src/css/spc-admin.css', array(), '1.0' );
			wp_register_script( 'spc-js', SPC_URL . 'src/js/spc-admin.js', array( 'jquery' ), '1.0', true );

			// Enqueue admin styles and scripts
			wp_enqueue_style( 'spc-styles' );
			wp_enqueue_script( 'spc-js' );
		}

		/**
		 * Create metabox
		 */
		public function spc_create_meta_box() {
			// Add metabox across all the registered post types including default post
			$args               = array( '_builtin' => false );
			$post_types         = get_post_types( $args );
			$post_types['post'] = 'post';

			foreach ( $post_types as $value ) {
				add_meta_box (
					'spc_primary_cat',
					'Primary Category',
					array( $this, 'spc_create_meta_fields' ),
					$value,
					'side',
					'core'
				);
			}
		}

		/**
		 * Create metabox fields
		 */
		public function spc_create_meta_fields() {
			global $post;

			// Get the selected primary category of post
			$primary_cat = get_post_meta( $post->ID, 'spc_primary_cat', true );

			// Nonce for verification
			wp_nonce_field( basename( __FILE__ ), 'spc_meta_box_nonce' );

			// Get all the selected categories of post
			$post_cats = get_the_category();

			if ( !empty( $post_cats ) ) {
				// Create a dropdown with a list from the selected categories
				$html = '<select name="spc_primary_cat" id="primary_cat">';
					$html .= '<option value="">' . esc_html__( 'Select', 'spc' ) . '</option>';
				foreach( $post_cats as $value ) {
					$html .= '<option value="' . esc_attr__( $value->slug, 'spc' ) . '" ' . selected( $primary_cat, $value->slug, false) . '>' . esc_html__( $value->name, 'spc' ) . '</option>';
				}

				$html .= '</select>';
			} else {
				// Display message
				$html = '<div class="spc-msg"><p>' . esc_html__( 'Assign at least one category and update the post to Select Primary Category', 'spc' ) . '</p></div>';
			}

			// Output
			echo $html;
		}

		/**
		 * Update/Save metabox fields
		 */
		public function spc_save_meta_fields( $post_id ) {
			// verify nonce
			if ( !isset( $_POST[ 'spc_meta_box_nonce' ] ) || !wp_verify_nonce( $_POST[ 'spc_meta_box_nonce' ], basename( __FILE__ ) ) )
				return $post_id;

			// Get current primary category
			$old = get_post_meta( $post_id, 'spc_primary_cat', true );

			// Set New primary category
			$new = $_POST[ 'spc_primary_cat' ];

			// Update/Delete primary category
			if ( ! empty( $new ) && $new != $old ) {
				update_post_meta( $post_id, 'spc_primary_cat', sanitize_text_field( $new ) );
			} elseif ( '' == $new && $old ) {
				delete_post_meta( $post_id, 'spc_primary_cat', $old );
			}
		}
	}
}