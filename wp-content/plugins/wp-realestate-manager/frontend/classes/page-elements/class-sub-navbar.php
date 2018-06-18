<?php
/**
 * File Type: Property Sidebar Map Page Element
 */
if ( ! class_exists('wp_rem_navbar_element') ) {

	class wp_rem_navbar_element {

		/**
		 * Start construct Functions
		 */
		public function __construct() {
			add_filter('wp_rem_navbar_html', array( $this, 'wp_rem_navbar_html_callback' ), 11, 2);
		}

		public function wp_rem_navbar_html_callback($menu_content, $property_id = '') {
			global $post, $wp_rem_plugin_options, $wp_rem_yelp_list_results;
			
			$sticky_navigation = isset($wp_rem_plugin_options['wp_rem_property_detail_page_sticky_navigation']) ? $wp_rem_plugin_options['wp_rem_property_detail_page_sticky_navigation'] : '';
			if( $sticky_navigation != 'on' ){
				return;
			}
			
			if ( $property_id == '' ) {
				$property_id = $post->ID;
			}
			$wp_rem_property_type_slug = get_post_meta($property_id, 'wp_rem_property_type', true);
			$property_type_id = 0;
			if ( $get_post = get_page_by_path($wp_rem_property_type_slug, OBJECT, 'property-type') ) {
				$property_type_id = $get_post->ID;
			}

			$content_post = get_post($property_id);
			$property_content = $content_post->post_content;
			$property_content = apply_filters('the_content', $property_content);
			$property_content = str_replace(']]>', ']]&gt;', $property_content);
			$floor_plans = get_post_meta($property_id, 'wp_rem_floor_plans', true);
			$floor_plans = empty($floor_plans) ? array() : $floor_plans;
			$wp_rem_attachments = get_post_meta($property_id, 'wp_rem_attachments', true);
			$wp_rem_attachments_options = get_post_meta($property_type_id, 'wp_rem_attachments_options_element', true);
			$wp_rem_property_video = get_post_meta($property_id, 'wp_rem_property_video', true);
			$wp_rem_apartments = get_post_meta($property_id, 'wp_rem_apartment', true);
			$features_list = get_post_meta($property_id, 'wp_rem_property_feature_list', true);
			$type_features_not_selected = get_post_meta($property_type_id, 'wp_rem_enable_not_selected', true);
			$access_token = isset($wp_rem_plugin_options['wp_rem_yelp_access_token']) ? $wp_rem_plugin_options['wp_rem_yelp_access_token'] : '';
			$terms = get_post_meta($property_id, 'wp_rem_property_places', true);
			$lat = get_post_meta($property_id, 'wp_rem_post_loc_latitude_property', true);
			$long = get_post_meta($property_id, 'wp_rem_post_loc_longitude_property', true);


			/*
			 * Property Elements Settings
			 */
			$wp_rem_enable_features_element = get_post_meta($property_id, 'wp_rem_enable_features_element', true);
			$wp_rem_enable_video_element = get_post_meta($property_id, 'wp_rem_enable_video_element', true);
			$wp_rem_enable_yelp_places_element = get_post_meta($property_id, 'wp_rem_enable_yelp_places_element', true);
			$wp_rem_enable_appartment_for_sale_element = get_post_meta($property_id, 'wp_rem_enable_appartment_for_sale_element', true);
			$wp_rem_enable_file_attachments_element = get_post_meta($property_id, 'wp_rem_enable_file_attachments_element', true);
			$wp_rem_enable_floot_plan_element = get_post_meta($property_id, 'wp_rem_enable_floot_plan_element', true);



			ob_start();
			?>
			<ul>
				<?php if ( $property_content != '' ) { ?>
					<li><a href="#property-detail"><?php echo wp_rem_plugin_text_srt('wp_rem_property_property_key_detail'); ?></a></li>
				<?php } ?>
				<?php if ( ( ! empty($features_list) || $type_features_not_selected == 'on') && $wp_rem_enable_features_element != 'off' ) { ?>
					<li><a href="#features"><?php echo wp_rem_plugin_text_srt('wp_rem_property_property_amenities'); ?></a></li>
				<?php } ?>
				<?php if ( (isset($wp_rem_property_video) && $wp_rem_property_video != '') && $wp_rem_enable_video_element != 'off' ) { ?>
					<li><a href="#video"><?php echo wp_rem_plugin_text_srt('wp_rem_subnav_item_3'); ?></a></li>
				<?php } ?>
				<?php if ( is_array($terms) && $access_token != '' && $lat != '' && $long != '' && $wp_rem_enable_yelp_places_element != 'off' ) { ?>
					<li><a href="#best-of-yelp-module"><?php echo wp_rem_plugin_text_srt('wp_rem_subnav_item_4'); ?></a></li>
				<?php } ?>
				<?php if ( (is_array($wp_rem_apartments) && $wp_rem_apartments != '') && $wp_rem_enable_appartment_for_sale_element != 'off' ) { ?>
					<li><a href="#apartments"><?php echo wp_rem_plugin_text_srt('wp_rem_subnav_item_5'); ?></a></li>
				<?php } ?>
				<?php if ( (isset($wp_rem_attachments) && ! empty($wp_rem_attachments) && $wp_rem_attachments_options == 'on') && $wp_rem_enable_file_attachments_element != 'off' ) { ?>
					<li><a href="#attachments"><?php echo wp_rem_plugin_text_srt('wp_rem_subnav_item_6'); ?></a></li>
				<?php } ?>
				<?php if ( count($floor_plans) > 0 && $wp_rem_enable_floot_plan_element != 'off' ) { ?>
					<li><a href="#floor-plans"><?php echo wp_rem_plugin_text_srt('wp_rem_subnav_item_7'); ?></a></li>
						<?php } ?>
			</ul>
			<?php
			$content = ob_get_clean();
			$menu_content['content'] = $content;
			return $menu_content;
		}

	}

	global $wp_rem_navbar;
	$wp_rem_navbar = new wp_rem_navbar_element();
}