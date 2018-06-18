<?php

if ( ! class_exists('cs_mega_custom_menu') ) {

	class cs_mega_custom_menu {
		/* 
		 * Constructor
		 * 

		/**
		 * Initializes the plugin by setting localization, 
		 * filters, and administration functions.
		 */
		function __construct() {
			// add custom menu fields to menu
			add_filter('wp_setup_nav_menu_item', array( $this, 'cs_mega_add_custom_nav_fields' ));
			// save menu custom fields
			add_action('wp_update_nav_menu_item', array( $this, 'cs_mega_update_custom_nav_fields' ), 10, 3);
			// edit menu walker
            add_filter('wp_edit_nav_menu_walker', array($this, 'cs_mega_edit_walker'), 10, 2);
		}

		/**
		 * Add custom fields to $item nav object
		 * in order to be used in custom Walker
		 * @access      public
		 * @return      void
		 */
		function cs_mega_add_custom_nav_fields($menu_item) {
			$menu_item->megamenu = get_post_meta($menu_item->ID, '_menu_item_megamenu', true);
			$menu_item->view = get_post_meta($menu_item->ID, '_menu_item_view', true);
			$menu_item->categories = get_post_meta($menu_item->ID, '_menu_item_categories', true);
			$menu_item->cat_title = get_post_meta($menu_item->ID, '_menu_item_cat_title', true);
			$menu_item->view_all_link = get_post_meta($menu_item->ID, '_menu_item_view_all_link', true);
			return $menu_item;
		}

		/**
		 * Save menu custom fields
		 * @access      public
		 * @return      void
		 */
		function cs_mega_update_custom_nav_fields($menu_id, $menu_item_db_id, $args) {
			// Check if element is properly sent
			$megamenu_value = 'off';
			$view_value = 'simple';

			if ( isset($_REQUEST['menu-item-megamenu'][$menu_item_db_id]) ) {
				$megamenu_value = $_REQUEST['menu-item-megamenu'][$menu_item_db_id];
			} else {
				$megamenu_value = 'off';
			}

			if ( isset($_REQUEST['menu-item-view'][$menu_item_db_id]) ) {
				$view_value = $_REQUEST['menu-item-view'][$menu_item_db_id];
			} else {
				$view_value = 'simple';
			}
			
			if ( isset($_REQUEST['menu-item-categories'][$menu_item_db_id]) ) {
				$categories_value = $_REQUEST['menu-item-categories'][$menu_item_db_id];
			} else {
				$categories_value = '';
			}
			
			if ( isset($_REQUEST['menu-item-cat-title'][$menu_item_db_id]) ) {
				$cat_title_value = $_REQUEST['menu-item-cat-title'][$menu_item_db_id];
			} else {
				$cat_title_value = '';
			}
			
			if ( isset($_REQUEST['menu-item-view-all'][$menu_item_db_id]) ) {
				$view_all_link_value = $_REQUEST['menu-item-view-all'][$menu_item_db_id];
			} else {
				$view_all_link_value = '';
			}

			update_post_meta($menu_item_db_id, '_menu_item_megamenu', sanitize_text_field($megamenu_value));
			update_post_meta($menu_item_db_id, '_menu_item_view', sanitize_text_field($view_value));
			update_post_meta($menu_item_db_id, '_menu_item_categories', $categories_value);
			update_post_meta($menu_item_db_id, '_menu_item_cat_title', $cat_title_value);
			update_post_meta($menu_item_db_id, '_menu_item_view_all_link', $view_all_link_value);
		}
		
		/**
         * Define new Walker edit
         * @access      public
         * @return      void
         */
        function cs_mega_edit_walker($walker, $menu_id) {
            return 'Walker_Nav_Menu_Edit_Custom';
        }

	}

}

// instantiate plugin's class
$cs_mega_custom_menu = new cs_mega_custom_menu();
