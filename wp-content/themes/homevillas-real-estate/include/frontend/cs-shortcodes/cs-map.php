<?php

/*
 *
 * @Shortcode Name : Start function for Map shortcode/element front end view
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_var_map_shortcode') ) {

    function wp_rem_cs_var_map_shortcode($atts, $content = "") {
        global $header_map, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_options;

        $html = '';
        $page_element_size = isset($atts['map_element_size']) ? $atts['map_element_size'] : 100;
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $html .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }

        $defaults = array(
            'wp_rem_cs_var_column_size' => '1/1',
            'wp_rem_cs_var_map_title' => '',
            'wp_rem_cs_var_map_subtitle' => '',
            'wp_rem_var_map_align' => '',
            'wp_rem_cs_var_map_height' => '',
            'wp_rem_cs_var_map_lat' => '40.7143528',
            'wp_rem_cs_var_map_lon' => '-74.0059731',
            'wp_rem_cs_var_map_zoom' => '11',
            'wp_rem_cs_var_map_info' => '',
            'wp_rem_cs_var_map_api_key' => '',
            'wp_rem_cs_var_map_style_code' => '',
            'wp_rem_cs_var_map_info_width' => '200',
            'wp_rem_cs_var_map_info_height' => '200',
            'wp_rem_cs_var_map_marker_icon' => '',
            'wp_rem_cs_var_map_show_marker' => 'true',
            'wp_rem_cs_var_map_controls' => '',
            'wp_rem_cs_var_map_draggable' => 'true',
            'wp_rem_cs_var_map_scrollwheel' => 'true',
            'wp_rem_cs_var_map_border' => '',
            'wp_rem_cs_var_map_border_color' => '',
            'wp_rem_cs_map_directions' => 'off'
        );
        extract(shortcode_atts($defaults, $atts));
        $wp_rem_cs_var_column_size = isset($wp_rem_cs_var_column_size) ? $wp_rem_cs_var_column_size : '';
        $wp_rem_cs_var_map_title = isset($wp_rem_cs_var_map_title) ? $wp_rem_cs_var_map_title : '';
        $wp_rem_cs_var_map_height = isset($wp_rem_cs_var_map_height) ? $wp_rem_cs_var_map_height : '';
        $wp_rem_cs_var_map_lat = isset($wp_rem_cs_var_map_lat) ? $wp_rem_cs_var_map_lat : '';
        $wp_rem_cs_var_map_lon = isset($wp_rem_cs_var_map_lon) ? $wp_rem_cs_var_map_lon : '';
        $wp_rem_cs_var_map_zoom = isset($wp_rem_cs_var_map_zoom) ? $wp_rem_cs_var_map_zoom : '';
        $wp_rem_cs_var_map_info = isset($wp_rem_cs_var_map_info) ? $wp_rem_cs_var_map_info : '';
        $wp_rem_cs_var_map_info_width = isset($wp_rem_cs_var_map_info_width) ? $wp_rem_cs_var_map_info_width : '';
        $wp_rem_cs_var_map_info_height = isset($wp_rem_cs_var_map_info_height) ? $wp_rem_cs_var_map_info_height : '';
        $wp_rem_cs_var_map_marker_icon = isset($wp_rem_cs_var_map_marker_icon) ? $wp_rem_cs_var_map_marker_icon : '';
        $wp_rem_cs_var_map_show_marker = isset($wp_rem_cs_var_map_show_marker) ? $wp_rem_cs_var_map_show_marker : '';
        $wp_rem_cs_var_map_controls = isset($wp_rem_cs_var_map_controls) ? $wp_rem_cs_var_map_controls : '';
        $wp_rem_cs_var_map_draggable = isset($wp_rem_cs_var_map_draggable) ? $wp_rem_cs_var_map_draggable : '';
        $wp_rem_cs_var_map_scrollwheel = isset($wp_rem_cs_var_map_scrollwheel) ? $wp_rem_cs_var_map_scrollwheel : '';
        $wp_rem_cs_var_map_border = isset($wp_rem_cs_var_map_border) ? $wp_rem_cs_var_map_border : '';
        $wp_rem_cs_var_map_border_color = isset($wp_rem_cs_var_map_border_color) ? $wp_rem_cs_var_map_border_color : '';
        $wp_rem_cs_var_map_api_key = isset($wp_rem_cs_var_map_api_key) ? $wp_rem_cs_var_map_api_key : '';
        $wp_rem_cs_var_map_style = isset($content) ? rem_custom_shortcode_decode($content) : '';
        
        
        if(empty($wp_rem_cs_var_map_style)){
            $wp_rem_cs_var_map_style = '"'.'"';
        }else{
           $wp_rem_cs_var_map_style = html_entity_decode($wp_rem_cs_var_map_style);
        }
        
        
        
        
        
        if ( isset($wp_rem_cs_var_map_height) && $wp_rem_cs_var_map_height == '' ) {
            $wp_rem_cs_var_map_height = '500';
        }
        wp_rem_cs_enqueue_google_map($wp_rem_cs_var_map_api_key);
        $column_class = '';
        if ( $header_map ) {
            $header_map = false;
        } else {
            if ( isset($wp_rem_cs_var_column_size) && $wp_rem_cs_var_column_size != '' ) {
                if ( function_exists('wp_rem_cs_custom_column_class') ) {
                    $column_class = wp_rem_cs_custom_column_class($wp_rem_cs_var_column_size);
                }
            }
        }
        $section_title = '';
        $section_title .= wp_rem_title_sub_align($wp_rem_cs_var_map_title, $wp_rem_cs_var_map_subtitle, $wp_rem_var_map_align);
        if ( $wp_rem_cs_var_map_show_marker == "true" ) {
            $wp_rem_cs_var_map_show_marker = " var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        title: '',
                        icon: '" . esc_html($wp_rem_cs_var_map_marker_icon) . "',
                        shadow: ''
                    });
            ";
        } else {
            $wp_rem_cs_var_map_show_marker = "var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        title: '',
                        icon: '',
                        shadow: ''
                    });";
        }
        $border = '';
        if ( isset($wp_rem_cs_var_map_border) && $wp_rem_cs_var_map_border == 'yes' && $wp_rem_cs_var_map_border_color != '' ) {
            $border = 'border:1px solid ' . esc_attr($wp_rem_cs_var_map_border_color) . '; ';
        }



        $map_dynmaic_no = wp_rem_cs_generate_random_string('10');
        $html .= $section_title;
        $html .= '<div class="cs-map-section">';
        $html .='<div class="maps" style="' . esc_html($border) . '">';
        $html .= '<div class="cs-map">';
        $html .= '<div class="cs-map-content">';

        $html .= '<div class="mapcode iframe mapsection gmapwrapp" id="map_canvas' . esc_html($map_dynmaic_no) . '" style="height:' . esc_html($wp_rem_cs_var_map_height) . 'px;"> </div>';
        $zoomControl = '';
        if ( isset($wp_rem_cs_var_map_controls) && $wp_rem_cs_var_map_controls == false ) {
            $zoomControl = ' zoomControl:true,';
        }
        $wp_rem_cs_inline_script = "
		jQuery(document).ready(function() {
                    var panorama;
                    function initialize() {
                    var myLatlng = new google.maps.LatLng(" . esc_html($wp_rem_cs_var_map_lat) . ", " . esc_html($wp_rem_cs_var_map_lon) . ");
                    var mapOptions = {
                        " . esc_html($zoomControl) . "
                        zoom: " . esc_html($wp_rem_cs_var_map_zoom) . ",
                        scrollwheel: " . esc_html($wp_rem_cs_var_map_scrollwheel) . ",
                        draggable: " . esc_html($wp_rem_cs_var_map_draggable) . ",
                        streetViewControl: false,
                        center: myLatlng,
                        disableDefaultUI:" . esc_html($wp_rem_cs_var_map_controls) . "
                    };";

        if ( $wp_rem_cs_map_directions == 'on' ) {
            $wp_rem_cs_inline_script .= "var directionsDisplay;
                      var directionsService = new google.maps.DirectionsService();
                      directionsDisplay = new google.maps.DirectionsRenderer();";
        }

        $wp_rem_cs_inline_script .= "var map = new google.maps.Map(document.getElementById('map_canvas" . ($map_dynmaic_no) . "'), mapOptions);";

        if ( $wp_rem_cs_map_directions == 'on' ) {
            $wp_rem_cs_inline_script .= "directionsDisplay.setMap(map);
                        directionsDisplay.setPanel(document.getElementById('cs-directions-panel'));

                        function wp_rem_cs_calc_route() {
                                var myLatlng = new google.maps.LatLng(" . esc_html($wp_rem_cs_var_map_lat) . ", " . esc_html($wp_rem_cs_var_map_lon) . ");
                                var start = myLatlng;
                                var end = document.getElementById('wp_rem_cs_end_direction').value;
                                var mode = document.getElementById('wp_rem_cs_chng_dir_mode').value;
                                var request = {
                                        origin:start,
                                        destination:end,
                                        travelMode: google.maps.TravelMode[mode]
                                };
                                directionsService.route(request, function(response, status) {
                                        if (status == google.maps.DirectionsStatus.OK) {
                                                directionsDisplay.setDirections(response);
                                        }
                                });
                        }
                        document.getElementById('wp_rem_cs_search_direction').addEventListener('click', function() {
                                wp_rem_cs_calc_route();
                        });";
        }

        $map_custom_style = isset($wp_rem_cs_var_options['wp_rem_cs_var_map_custom_style']) ? $wp_rem_cs_var_options['wp_rem_cs_var_map_custom_style'] : '';

        if ( $map_custom_style != '' ) {
            $map_custom_style = str_replace('&quot;', '"', $map_custom_style);
            $wp_rem_cs_inline_script .= "var style = " . $map_custom_style . ";
			if (style != '') {
				var styledMap = new google.maps.StyledMapType(style,
						{name: 'Styled Map'});
				map.mapTypes.set('map_style', styledMap);
				map.setMapTypeId('map_style');
			}";
        } else {
            $wp_rem_cs_inline_script .= "
			var style = " . ($wp_rem_cs_var_map_style) . ";
			if (style != '') {
                               var styles = (style);
				if (styles != '') {
					var styledMap = new google.maps.StyledMapType(styles,
							{name: 'Styled Map'});
					map.mapTypes.set('map_style', styledMap);
					map.setMapTypeId('map_style');
				}
			}";
        }

        $wp_rem_cs_inline_script .= "
				var infowindow = new google.maps.InfoWindow({
					content: '" . esc_html($wp_rem_cs_var_map_info) . "',
					maxWidth: " . esc_html($wp_rem_cs_var_map_info_width) . ",
					maxHeight: " . esc_html($wp_rem_cs_var_map_info_height) . ",
					
				});
				" . $wp_rem_cs_var_map_show_marker . "
					if (infowindow.content != ''){
					  infowindow.open(map, marker);
					   map.panBy(1,-60);
					   google.maps.event.addListener(marker, 'click', function(event) {
						infowindow.open(map, marker);
					   });
					}
					panorama = map.getStreetView();
					panorama.setPosition(myLatlng);
					panorama.setPov(({
					  heading: 265,
					  pitch: 0
					}));
			}			
				function wp_rem_cs_toggle_street_view(btn) {
				  var toggle = panorama.getVisible();
				  if (toggle == false) {
						if(btn == 'streetview'){
						  panorama.setVisible(true);
						}
				  } else {
						if(btn == 'mapview'){
						  panorama.setVisible(false);
						}
				  }
				}
		google.maps.event.addDomListener(window, 'load', initialize);
		});";
        $html .= '</div>';
        $html .= '</div></div></div>';
        $html .= '<script> ' . ($wp_rem_cs_inline_script) . ' </script>';
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $html .= '</div>';
        }

        return $html;
    }

}

if ( function_exists('wp_rem_cs_var_short_code') ) {
    wp_rem_cs_var_short_code('wp_rem_cs_map', 'wp_rem_cs_var_map_shortcode');
}