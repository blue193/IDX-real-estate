<?php
/**
 * Define hooks (wp content, theme options, menus & locations, set up pages, revolution slider, widgets) for importer
 *
 * @since	1.2
 * @package	WordPress
 */

add_action( 'wp_rem_cs_import_wp_data', 'wp_rem_cs_import_wp_data_handle' );
if ( ! function_exists( 'wp_rem_cs_import_wp_data_handle' ) ) {
	/**
	 * Import WP content using WP importer
	 *
	 * @param CS_Data_Importer $obj An instance of CS_Data_Importer class which contains different configurations.
	 */
	function wp_rem_cs_import_wp_data_handle( $obj ) {
		if ( ! class_exists( 'WP_Importer' ) ) {
			$wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			require_once $wp_importer;
		}

		if ( ! class_exists( 'WP_Import' ) ) {
			require_once $obj->wp_rem_cs_importer_class_path;
		}

		if ( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) {
			$importer = new WP_Import();
			$importer->fetch_attachments = true;
			ob_start();
			$importer->import( $obj->wp_data_path );
			ob_end_clean();
			$obj->action_return = true;
		} else {
			$obj->action_return = false;
		}
	}
}

add_action( 'wp_rem_cs_import_theme_options', 'wp_rem_cs_import_wp_options_handle' );
if ( ! function_exists( 'wp_rem_cs_import_wp_options_handle' ) ) {
	/**
	 * Import Theme Options
	 *
	 * @param CS_Data_Importer $obj An instance of CS_Data_Importer class which contains different configurations.
	 */
	function wp_rem_cs_import_wp_options_handle( $obj ) {
		global $wp_filesystem;
		$theme_options = $wp_filesystem->get_contents( $obj->theme_options_data_path );
		$wp_rem_cs_theme_skin = json_decode( $theme_options, true );
		update_option( 'wp_rem_cs_var_options', $wp_rem_cs_theme_skin );

		// Create css file when theme option call.
		if ( function_exists( 'wp_rem_cs_write_stylesheet_content' ) ) {
			wp_rem_cs_write_stylesheet_content();
		}

		$obj->action_return = true;
	}
}

add_action( 'wp_rem_cs_import_menus_and_locations', 'wp_rem_cs_import_menus_and_locations_handle' );
if ( ! function_exists( 'wp_rem_cs_import_menus_and_locations_handle' ) ) {
	/**
	 * Set Menu's locations
	 *
	 * @param CS_Data_Importer $obj An instance of CS_Data_Importer class which contains different configurations.
	 */
	function wp_rem_cs_import_menus_and_locations_handle( $obj ) {
		global $wp_filesystem, $wpdb;
		$locations = get_theme_mod( 'nav_menu_locations' );
		$menus_str = $wp_filesystem->get_contents( $obj->menus_data_path );
		$menus = json_decode( $menus_str, true );
		foreach ( $menus as $item ) {
			$term_exists = term_exists( $item['menu_slug'], 'nav_menu' );
			if ( ! $term_exists ) {
				$wpdb->insert(
					$wpdb->terms, array(
						'name' => $item['menu_title'],
						'slug' => $item['menu_slug'],
						'term_group' => 0,
					), array(
						'%s',
						'%s',
						'%d',
					)
				);
				$insert_id = $wpdb->insert_id;
				$locations[ $item['location'] ] = $insert_id;
				$wpdb->insert(
					$wpdb->term_taxonomy, array(
						'term_id' => $insert_id,
						'taxonomy' => 'nav_menu',
						'description' => '',
						'parent' => 0,
						'count' => 0,
					), array(
						'%d',
						'%s',
						'%s',
						'%d',
						'%d',
					)
				);
			} else {
				$locations[ $item['location'] ] = $term_exists['term_id'];
			}
		}
		set_theme_mod( 'nav_menu_locations', $locations );
		$obj->action_return = true;
	}
}

add_action( 'wp_rem_cs_import_setup_pages', 'wp_rem_cs_import_setup_pages_handle' );
if ( ! function_exists( 'wp_rem_cs_import_setup_pages_handle' ) ) {
	/**
	 * Set homepage for site
	 *
	 * @param CS_Data_Importer $obj An instance of CS_Data_Importer class which contains different configurations.
	 */
	function wp_rem_cs_import_setup_pages_handle( $obj ) {
		$homepage = get_page_by_path( $obj->homepage_slug );

		if ( ! empty( $homepage->ID ) ) {
			update_option( 'page_on_front', $homepage->ID );
			update_option( 'show_on_front', 'page' );
			$obj->action_return = true;
		} else {
			$obj->action_return = false;
		}
	}
}

add_action( 'wp_rem_cs_import_rev_sliders', 'wp_rem_cs_import_rev_slider_handle' );
if ( ! function_exists( 'wp_rem_cs_import_rev_slider_handle' ) ) {
	/**
	 * Import Revolution Slider content using Revolution slider's importer
	 *
	 * @param CS_Data_Importer $obj An instance of CS_Data_Importer class which contains different configurations.
	 */
	function wp_rem_cs_import_rev_slider_handle( $obj ) {
		if ( class_exists( 'RevSlider' ) ) {
			global $wp_filesystem;
			$slider_data = $wp_filesystem->get_contents( $obj->sliders_data_path );
			$wp_rem_cs_upload_dir = wp_upload_dir();
			$slider_file = $wp_rem_cs_upload_dir['path'] . '/slider_data_' . time() . '.zip';
			$wp_filesystem->put_contents( $slider_file, $slider_data );

			if ( file_exists( $slider_file ) ) {
				$slider = new RevSlider();
				$update_anim = isset( $obj->sliders_options[0] ) ? $obj->sliders_options[0] : false;
				$update_static = isset( $obj->sliders_options[1] ) ? $obj->sliders_options[1] : false;
				$update_navigation = isset( $obj->sliders_options[2] ) ? $obj->sliders_options[2] : false;
				$slider->importSliderFromPost( $update_anim, $update_static, $slider_file, false, false, $update_navigation );
			}

			// Delete slider conetnt file after import.
			unlink( $slider_file );

			$obj->action_return = true;
		} else {
			$obj->action_return = false;
		}
	}
}

add_action( 'wp_rem_cs_import_widgets', 'wp_rem_cs_import_widgets_handle' );
if ( ! function_exists( 'wp_rem_cs_import_widgets_handle' ) ) {
	/**
	 * Import Widgets
	 *
	 * @param CS_Data_Importer $obj An instance of CS_Data_Importer class which contains different configurations.
	 */
	function wp_rem_cs_import_widgets_handle( $obj ) {
		if ( class_exists( 'wp_rem_cs_var_widget_data' ) ) {
			wp_rem_cs_var_widget_data::wp_rem_cs_import_widget_data( $obj->widget_data_path );
			$obj->action_return = true;
		} else {
			$obj->action_return = false;
		}
	}
}