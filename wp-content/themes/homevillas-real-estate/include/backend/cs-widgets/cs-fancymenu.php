<?php

if ( ! class_exists('wp_rem_fancy_menu') ) {

	class wp_rem_fancy_menu extends WP_Widget {
		/**
		 * Outputs the content of the widget
		 *
		 * @param array $args
		 * @param array $instance
		 */

		/**
		 * @init Fancy Menu Module
		 *
		 *
		 */
		public function __construct() {

			parent::__construct(
					'wp_rem_fancy_menu', // Base ID
					wp_rem_cs_var_theme_text_srt('wp_rem_fancymenu_widget_heading'), // Name
					array( 'classname' => 'wp-rem-fancy-menu', 'description' => wp_rem_cs_var_theme_text_srt('wp_rem_fancymenu_widget_desc'), ) // Args
			);
		}

		/**
		 * @Fancy Menu html form
		 *
		 *
		 */
		function form($instance) {
			 global $wp_rem_cs_var_form_fields, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_static_text;
			$instance = wp_parse_args((array) $instance, array( 'title' => '' ));
			$widget_title = $instance['title'];
			$menu_name = isset($instance['menu_name']) ? esc_attr($instance['menu_name']) : '';
			$menus = get_terms('nav_menu', array( 'hide_empty' => false ));

			// If no menus exists, direct the user to go and create some.
			if ( ! $menus ) {
				echo '<p> ' . wp_rem_cs_var_theme_text_srt('wp_rem_fancymenu_widget_no_menu_created') . ' <a href="%s">' . wp_rem_cs_var_theme_text_srt('wp_rem_fancymenu_widget_create_some') . '</a>', admin_url('nav-menus.php') . ' </p>';
				return;
			}

			$menu_html = '';
			foreach ( $menus as $menu ) {
				$selected = $menu_name == $menu->term_id ? ' selected="selected"' : '';
				$menu_html .= '<option' . $selected . ' value="' . $menu->term_id . '">' . $menu->name . '</option>';
			}

			$wp_rem_opt_array = array(
				'name' => wp_rem_cs_var_theme_text_srt('wp_rem_fancymenu_widget_title'),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
					'std' => esc_attr($widget_title),
					'id' => ($this->get_field_id('title')),
					'classes' => '',
					'cust_id' => ($this->get_field_name('title')),
					'cust_name' => ($this->get_field_name('title')),
					'return' => true,
					'required' => false
				),
			);
			 $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_opt_array);

			$wp_rem_opt_array = array(
				'name' => wp_rem_cs_var_theme_text_srt('wp_rem_fancymenu_widget_menu'),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
					'std' => $menu_name,
					'id' => ($this->get_field_id('menu_name')),
					'classes' => '',
					'cust_id' => ($this->get_field_name('menu_name')),
					'cust_name' => ($this->get_field_name('menu_name')),
					'options_markup' => true,
					'options' => $menu_html,
					'return' => true,
					'required' => false
				),
			);
			$wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_opt_array);
		}

		/**
		 * @Fancy menu update form data
		 *
		 *
		 */
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = $new_instance['title'];
			$instance['menu_name'] = $new_instance['menu_name'];
			return $instance;
		}

		function widget($args, $instance) {
			global $wp_rem_node, $wpdb, $post;
			extract($args, EXTR_SKIP);
			$wp_rem_widget_title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			$wp_rem_widget_title = htmlspecialchars_decode(stripslashes($wp_rem_widget_title));
			$wp_rem_menu_name = empty($instance['menu_name']) ? '' : $instance['menu_name'];
			$widget_html = $before_widget;
			if ( ! empty($wp_rem_widget_title) && $wp_rem_widget_title <> ' ' ) {
				$widget_html .= $before_title . $wp_rem_widget_title . $after_title;
			}
			
			ob_start();
			$wp_rem_menu_class = 'shortcode-nav';
			$wp_rem_menu_arg = array(
				'theme_location' => '',
				'menu' => $wp_rem_menu_name,
				'container' => 'nav',
				'container_class' => $wp_rem_menu_class,
				'container_id' => '',
				'menu_class' => 'menu',
				'menu_id' => '',
				'echo' => true,
				'fallback_cb' => 'wp_page_menu',
				'before' => '',
				'after' => '',
				'link_before' => '',
				'link_after' => '',
				'items_wrap' => '<ul class="%2$s">%3$s</ul>',
				'depth' => 0,
				'walker' => ''
			);
			wp_nav_menu($wp_rem_menu_arg);
			$widget_html .= ob_get_clean();
			$widget_html .= $after_widget;
			
			echo force_balance_tags($widget_html);
		}

	}

}
add_action('widgets_init', create_function('', 'return register_widget("wp_rem_fancy_menu");'));
