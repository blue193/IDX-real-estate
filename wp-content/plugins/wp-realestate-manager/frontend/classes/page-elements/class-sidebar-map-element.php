<?php
/**
 * File Type: Property Sidebar Map Page Element
 */
if ( ! class_exists( 'wp_rem_sidebar_map_element' ) ) {

	class wp_rem_sidebar_map_element {

		/**
		 * Start construct Functions
		 */
		public function __construct() {
			add_action( 'wp_rem_sidebar_map_html', array( $this, 'wp_rem_sidebar_map_html_callback' ), 11, 1 );
		}

		public function wp_rem_sidebar_map_html_callback( $property_id = '' ) {
			global $post, $wp_rem_plugin_options;
			
			$sidebar_map = isset($wp_rem_plugin_options['wp_rem_property_detail_page_sidebar_map']) ? $wp_rem_plugin_options['wp_rem_property_detail_page_sidebar_map'] : '';
			if( $sidebar_map != 'on' ){
				//return;
			}
			
			if( $property_id == '' ){
				$property_id = $post->ID;
			}
			if( $property_id != '' ){ 
				$default_zoom_level = ( isset( $wp_rem_plugin_options['wp_rem_map_zoom_level'] ) && $wp_rem_plugin_options['wp_rem_map_zoom_level'] != '' ) ? $wp_rem_plugin_options['wp_rem_map_zoom_level'] : 10;
				$wp_rem_post_loc_latitude = get_post_meta( $property_id, 'wp_rem_post_loc_latitude_property', true );
				$wp_rem_post_loc_longitude = get_post_meta( $property_id, 'wp_rem_post_loc_longitude_property', true );
				$wp_rem_post_loc_address_property = get_post_meta( $property_id, 'wp_rem_post_loc_address_property', true );
				$wp_rem_property_zoom = get_post_meta( $property_id, 'wp_rem_post_loc_zoom_property', true );
				if( $wp_rem_property_zoom == '' || $wp_rem_property_zoom == 0){
					$wp_rem_property_zoom = $default_zoom_level;
				}
				
				$property_type_id = '';
				$property_type = get_post_meta($property_id, 'wp_rem_property_type', true);
				if ($property_type != '') {
					$property_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type", 'post_status' => 'publish'));
					$property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
				}
				$map_marker_icon = get_post_meta($property_type_id, 'wp_rem_property_type_marker_image', true);
                $map_marker_icon = wp_get_attachment_url($map_marker_icon);
				?>
				<div class="widget widget-map-sec">
					<?php
					$map_atts = array(
						'map_height' => '380',
						'map_lat' => $wp_rem_post_loc_latitude,
						'map_lon' => $wp_rem_post_loc_longitude,
						'map_zoom' => $wp_rem_property_zoom,
						'map_type' => '',
						'map_info' => '', //$wp_rem_post_comp_address,
						'map_info_width' => '200',
						'map_info_height' => '350',
						'map_marker_icon' => '', //$map_marker_icon,
						'map_show_marker' => 'true',
						'map_controls' => 'true',
						'map_draggable' => 'true',
						'map_scrollwheel' => 'false',
						'map_border' => '',
						'map_border_color' => '',
						'wp_rem_map_style' => '',
						'wp_rem_map_class' => '',
						'wp_rem_map_directions' => 'off',
						'wp_rem_map_circle' => '',
						'wp_rem_nearby_places' => true,
					);
					if ( function_exists( 'wp_rem_map_content' ) ) {
						wp_rem_map_content( $map_atts );
					}
					?>
				</div>
			<?php }
		}

	}

	global $wp_rem_sidebar_map;
	$wp_rem_sidebar_map = new wp_rem_sidebar_map_element();
}