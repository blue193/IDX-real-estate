<?php
/**
 * Core Helper Functions of Framework
 *
 * @return
 * @package wp-rem-framework
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
if (!function_exists('wp_rem_heartbeat_frequency')) {

    function wp_rem_heartbeat_frequency($settings) {
        global $heartbeat_frequency;
        $settings['interval'] = 60;
        return $settings;
    }

    add_filter('heartbeat_settings', 'wp_rem_heartbeat_frequency');
}
if (!function_exists('wp_rem_server_protocol')) {

    /**
     * Return whether request is on SSL or not. Return protocol.
     *
     * @return string
     */
    function wp_rem_server_protocol() {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            return 'https://';
        }
        return 'http://';
    }

}
if (!function_exists('wp_rem_get_input')) {

    /**
     * Return an input variable from $_REQUEST if exists else default.
     *
     * @param	string $name name of the variable.
     * @param string $default default value.
     * @param string $filter
     * @return string
     */
    function wp_rem_get_input($name, $default = null, $filter = 'cmd') {
        if (isset($_REQUEST[$name])) {
            return wp_rem_input_clean($_REQUEST[$name], $filter);
        }
        return $default;
    }

}
if (!function_exists('wp_rem_get_server')) {

    /**
     * Return an input variable from $_SERVER if exists else default.
     *
     * @param	string $name name of the variable.
     * @param string $default default value.
     * @return string
     */
    function wp_rem_get_server($name, $default = null) {
        return isset($_SERVER[$name]) ? $_SERVER[$name] : $default;
    }

}

if (!function_exists('wp_rem_get_all_server')) {

    /**
     * Return an input variable from $_SERVER
     *
     * @return string
     */
    function wp_rem_get_all_server() {
        return $_SERVER;
    }

}

if (!function_exists('wp_rem_get_cookie')) {

    /**
     * Return an input variable from $_COOKIE if exists else default.
     *
     * @param	string $name name of the variable.
     * @param string $default default value.
     * @return string
     */
    function wp_rem_get_cookie($name, $default = null) {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : $default;
    }

}

if (!function_exists('wp_rem_get_all_request')) {

    /**
     * Return an input variable from $_REQUEST
     *
     * @return string
     */
    function wp_rem_get_all_request() {
        return $_REQUEST;
    }

}

if (!function_exists('wp_rem_get_all_cookie')) {

    /**
     * Return an input variable from $_COOKIE
     *
     * @return string
     */
    function wp_rem_get_all_cookie() {
        return $_COOKIE;
    }

}

if (!function_exists('wp_rem_input_clean')) {

    /**
     * Clean given string by applying requested filter.
     *
     * @param   mixed   $source  Input string/array-of-string to be 'cleaned'
     * @param   string  $type    Return type for the variable (INT, UINT, FLOAT, BOOLEAN, WORD, ALNUM, CMD, BASE64, STRING, ARRAY, PATH, NONE)
     *
     * @return  mixed  'Cleaned' version of input parameter
     */
    function wp_rem_input_clean($source, $type = 'string') {
        // Handle the type constraint
        switch (strtoupper($type)) {
            case 'INT':
            case 'INTEGER':
                // Only use the first integer value.
                preg_match('/-?[0-9]+/', (string) $source, $matches);
                $result = @ (int) $matches[0];
                break;

            case 'UINT':
                // Only use the first integer value.
                preg_match('/-?[0-9]+/', (string) $source, $matches);
                $result = @ abs((int) $matches[0]);
                break;

            case 'FLOAT':
            case 'DOUBLE':
                // Only use the first floating point value.
                preg_match('/-?[0-9]+(\.[0-9]+)?/', (string) $source, $matches);
                $result = @ (float) $matches[0];
                break;

            case 'BOOL':
            case 'BOOLEAN':
                $result = (bool) $source;
                break;

            case 'WORD':
                $result = (string) preg_replace_callback('/[^A-Z_]/i', function($m) {
                            return '';
                        }, $source);
                break;

            case 'ALNUM':
                $result = (string) preg_replace_callback('/[^A-Z0-9]/i', function($m) {
                            return '';
                        }, $source);
                break;

            case 'CMD':
                $result = (string) preg_replace_callback('/[^A-Z0-9_\.-]/i', function($m) {
                            return '';
                        }, $source);
                $result = ltrim($result, '.');
                break;

            case 'BASE64':
                $result = (string) preg_replace_callback('/[^A-Z0-9\/+=]/i', function($m) {
                            return '';
                        }, $source);
                break;

            case 'STRING':
                $result = (string) esc_html(wp_rem_decode_str((string) $source));
                break;

            case 'HTML':
                $result = (string) $source;
                break;

            case 'ARRAY':
                $result = (array) $source;
                break;

            case 'PATH':
                $pattern = '/^[A-Za-z0-9_-]+[A-Za-z0-9_\.-]*([\\\\\/][A-Za-z0-9_-]+[A-Za-z0-9_\.-]*)*$/';
                preg_match($pattern, (string) $source, $matches);
                $result = @ (string) $matches[0];
                break;

            case 'USERNAME':
                $result = (string) preg_replace_callback('/[\x00-\x1F\x7F<>"\'%&]/', function($m) {
                            return '';
                        }, $source);
                break;

            default:
                // Are we dealing with an array?
                if (is_array($source)) {
                    foreach ($source as $key => $value) {
                        // filter element for XSS and other 'bad' code etc.
                        if (is_string($value)) {
                            $source[$key] = esc_html(wp_rem_decode_str($value));
                        }
                    }
                    $result = $source;
                } else {
                    // Or a string?
                    if (is_string($source) && !empty($source)) {
                        // filter source for XSS and other 'bad' code etc.
                        $result = esc_html(wp_rem_decode_str($source));
                    } else {
                        // Not an array or string.. return the passed parameter.
                        $result = $source;
                    }
                }
                break;
        }

        return $result;
    }

}

if (!function_exists('wp_rem_decode_str')) {

    /**
     * Try to convert to plaintext
     *
     * @param   string  $source  The source string.
     * @return  string  Plaintext string
     */
    function wp_rem_decode_str($source) {
        static $ttr;

        if (!is_array($ttr)) {
            // Entity decode.
            $trans_tbl = get_html_translation_table(HTML_ENTITIES);
            foreach ($trans_tbl as $k => $v) {
                $ttr[$v] = utf8_encode($k);
            }
        }
        $source = strtr($source, $ttr);
        // Convert decimal.
        $source = preg_replace_callback('/&#x(\d+);/mi', function($m) {
            return utf8_encode(chr('0x' . $m[1]));
        }, $source); // Decimal notation.
        // Convert hex.
        $source = preg_replace_callback('/&#x([a-f0-9]+);/mi', function($m) {
            return utf8_encode(chr('0x' . $m[1]));
        }, $source); // Hex notation.
        return $source;
    }

}

if (!function_exists('wp_rem_dbg')) {

    /**
     * Used for debugging, output given data to browser console.
     *
     * @param  mixed  $data		The data to be debugged.
     * @param  string $label	The label to shown with debugged data.
     */
    function wp_rem_dbg($data, $label = '') {
        if ('' === $label) {
            $key = array_search(__FUNCTION__, array_column(debug_backtrace(), 'wp_rem_dbg'));
            $label = 'Debuged from \'' . basename(debug_backtrace()[$key]['file']) . '\'';
        }
        $data = var_export($data, true);
        $data = explode("\n", $data); // Plz don't remove double quotes arround newline character.
        $output = '';
        foreach ($data as $line) {
            if (trim($line)) {
                $line = addslashes($line);
                $output .= 'console.log( " ' . $line . '" );';
            }
        }
        echo '<script>console.log( "' . $label . ': "); ' . $output . ' </script>';
    }

}

if (!function_exists('wp_rem_shortcode_files')) {

    /**
     * Include Backend shortcodes pages function 
     */
    function wp_rem_shortcode_files($path) {

        $shortcode_wp_rem = wp_rem::plugin_dir() . 'shortcodes/' . $path . '/';
        $aAdmin = array();
        $aFront = array();
        $aResult = array();
        $file_counter = 0;
        if (is_dir($shortcode_wp_rem)) {
            if ($dh = opendir($shortcode_wp_rem)) {
                while (($file = readdir($dh)) !== false) {
                    $aAdmin[] = $file;
                    $file_counter ++;
                }

                $aResult['admin'] = $aAdmin;
                closedir($dh);
            }
        }
        if (is_array($aResult) && count($aResult) > 0) {
            return $aResult;
        }
    }

}

if (!function_exists('wp_rem_include_shortcode_files')) {

    /**
     * Include Backend shortcodes pages function 
     */
    function wp_rem_include_shortcode_files() {

        $aFiles = wp_rem_shortcode_files('backend');

        $admin = '/';
        $shortcode_wp_rem = wp_rem::plugin_dir() . 'shortcodes/backend/';
        foreach ($aFiles as $file) {
            for ($i = 0; $i < sizeof($file); $i ++) {
                if ($file[$i] != '' && $file[$i] != "." && $file[$i] != "..." && $file[$i] != "..") {
                    require_once $shortcode_wp_rem . $admin . $file[$i];
                }
            }
        }
    }

}


if (!function_exists('wp_rem_include_frontend_shortcode_files')) {

    /**
     * Include Backend shortcodes pages function 
     */
    function wp_rem_include_frontend_shortcode_files() {

        $aFiles = wp_rem_shortcode_files('frontend');

        $admin = '/';
        $shortcode_wp_rem = wp_rem::plugin_dir() . 'shortcodes/frontend/';
        foreach ($aFiles as $file) {
            for ($i = 0; $i < sizeof($file); $i ++) {
                if ($file[$i] != '' && $file[$i] != "." && $file[$i] != "..." && $file[$i] != "..") {
                    require_once $shortcode_wp_rem . $admin . $file[$i];
                }
            }
        }
    }

}

/**
 * Start dashboard page link if user login
 */
if (!function_exists('wp_rem_user_dashboard_page_url')) {

    function wp_rem_user_dashboard_page_url($page = 'url') {
        global $wp_rem_plugin_options, $current_user;
        $wp_rem_page_id = '';
        $wp_rem_user_dashboard_page_url = '';
        if (is_user_logged_in()) {

            $user_roles = isset($current_user->roles) ? $current_user->roles : '';
            if (($user_roles != '' && in_array("wp_rem_member", $user_roles))) {
                $wp_rem_page_id = isset($wp_rem_plugin_options['wp_rem_member_dashboard']) ? $wp_rem_plugin_options['wp_rem_member_dashboard'] : $default_url;
                if ($page == 'url') {
                    if ($wp_rem_page_id != '') {
                        $wp_rem_user_dashboard_page_url = get_permalink($wp_rem_page_id);
                    }
                } else if ($page == 'id') {
                    $wp_rem_user_dashboard_page_url = ( $wp_rem_page_id );
                }
            }
        }
        return $wp_rem_user_dashboard_page_url;
    }

}



/*
 * @Shortcode Name: Start function for Map shortcode/element front end view
 * @retrun
 *
 */
if (!function_exists('wp_rem_map_content')) {

    function wp_rem_map_content($atts) {

        global $wp_rem_plugin_options, $wp_rem_form_fields_frontend;
        $defaults = array(
            'map_height' => '',
            'map_lat' => '51.507351',
            'map_lon' => '-0.127758',
            'map_zoom' => '10',
            'map_type' => '',
            'map_info' => '',
            'map_info_width' => '200',
            'map_info_height' => '200',
            'map_marker_icon' => '',
            'map_show_marker' => 'true',
            'map_controls' => 'true',
            'map_draggable' => 'true',
            'map_scrollwheel' => 'false',
            'map_border' => '',
            'map_border_color' => '',
            'wp_rem_map_style' => '',
            'wp_rem_map_class' => '',
            'wp_rem_map_directions' => 'off',
            'wp_rem_map_circle' => 'off',
            'wp_rem_nearby_places' => false,
            'wp_rem_branches_map' => false,
            'wp_rem_branches_markers' => array(),
        );
        extract(shortcode_atts($defaults, $atts));
        if ($map_info_width == '' || $map_info_height == '') {
            $map_info_width = '300';
            $map_info_height = '150';
        }
        if (isset($map_height) && $map_height == '') {
            $map_height = '500';
        }

        $map_dynmaic_no = rand(6548, 9999999);

        $border = '';
        if (isset($map_border) && $map_border == 'yes' && $map_border_color != '') {
            $border = 'border:1px solid ' . $map_border_color . '; ';
        }

        $map_type = isset($map_type) ? $map_type : '';
        $radius_circle = isset($wp_rem_plugin_options['wp_rem_default_radius_circle']) ? $wp_rem_plugin_options['wp_rem_default_radius_circle'] : '10';
        $radius_circle = ($radius_circle * 1000);
        $map_dynmaic_no = wp_rem_generate_random_string('10');

        $map_col_class = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
        ob_start();
        echo '<div class="row">';
        if (isset($wp_rem_nearby_places) && $wp_rem_nearby_places == true) {
            $wp_rem_map_markers_data = isset($wp_rem_plugin_options['wp_rem_map_markers_data']) ? $wp_rem_plugin_options['wp_rem_map_markers_data'] : array();
            if (isset($wp_rem_map_markers_data['image']) && is_array($wp_rem_map_markers_data['image']) && sizeof($wp_rem_map_markers_data['image']) > 0) :
                $map_col_class = 'col-lg-8 col-md-8 col-sm-6 col-xs-12';
                ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="map-places-radius-box">
                        <h5>POINTS OF INTEREST (M)</h5>
                        <div class="kk_adjust_radius_container">
                            <div class="kk_row">
                                <div class='kk_col_1'>
                                    ADJUST RADIUS:
                                </div>
                                <div class="kk_col_2">
                                    <input type="text" id="map-radius-input-<?php echo esc_html($map_dynmaic_no) ?>" value="2000">
                                </div>
                            </div>
                            <div class="kk_info">
                                <span><?php echo wp_rem_plugin_text_srt('wp_rem_map_places_put_radius_value') ?></span>
                            </div>
                        </div>
                    </div>
                    <div id="map-places-detail-<?php echo esc_html($map_dynmaic_no) ?>" class="map-places-detail-boxes"></div>
                    <div>
                        <div id="map-direction-detail-<?php echo esc_html($map_dynmaic_no) ?>" style="display:none;"></div>
                    </div>
                </div>
                <?php
            endif;
        }
        echo '<div class="' . $map_col_class . '">';
        if (isset($wp_rem_nearby_places) && $wp_rem_nearby_places == true) {
            $wp_rem_map_markers_data = isset($wp_rem_plugin_options['wp_rem_map_markers_data']) ? $wp_rem_plugin_options['wp_rem_map_markers_data'] : array();
            if (isset($wp_rem_map_markers_data['image']) && is_array($wp_rem_map_markers_data['image']) && sizeof($wp_rem_map_markers_data['image']) > 0) :
                ?>
                <div class="map-checkboxes"> 
                    <?php
                    foreach ($wp_rem_map_markers_data['image'] as $key => $row) :
                        $image = isset($wp_rem_map_markers_data['image'][$key]) ? $wp_rem_map_markers_data['image'][$key] : '';
                        $map_image = isset($wp_rem_map_markers_data['map_image'][$key]) ? $wp_rem_map_markers_data['map_image'][$key] : '';
                        $title = isset($wp_rem_map_markers_data['label'][$key]) ? $wp_rem_map_markers_data['label'][$key] : '';
                        $type = isset($wp_rem_map_markers_data['type'][$key]) ? $wp_rem_map_markers_data['type'][$key] : '';

                        $image_map = isset($image) ? wp_get_attachment_url($image) : '';
                        ?>
                        <div class="checkbox">
                            <?php
                            $wp_rem_opt_array = array(
                                'std' => '',
                                'simple' => true,
                                'cust_id' => esc_html($type),
                                'cust_name' => esc_html($type),
                                'classes' => 'show-poi-checkbox wp_rem_show_nearby',
                                'extra_atr' => ' data-label="' . esc_html($title) . '" data-image="' . wp_get_attachment_url($map_image) . '"',
                            );
                            $wp_rem_form_fields_frontend->wp_rem_form_checkbox_render($wp_rem_opt_array);
                            ?>
                            <label data-toggle="tooltip" title="<?php echo esc_html($title); ?>" class="show-nearby-point-label" for="<?php echo esc_html($type); ?>"><img src="<?php echo esc_url($image_map); ?>" alt="" /> </label>
                        </div>
                        <?php
                    endforeach;
                    ?>
                </div>
                <?php
            endif;
        }
        ?>

        <?php
        if ($map_marker_icon == '') {
            $map_marker_icon = isset($wp_rem_plugin_options['wp_rem_map_marker_icon']) ? $wp_rem_plugin_options['wp_rem_map_marker_icon'] : '';
            $map_marker_icon = wp_get_attachment_url($map_marker_icon);
        }

        $html = ob_get_clean();
        $html .= '<div ' . $wp_rem_map_class . ' style="animation-duration:">';
        $html .= '<div class="clear"></div>';
        $html .= '<div class="cs-map-section" style="' . $border . ';">';
        $html .= '<div class="cs-map">';
        $html .= '<div class="cs-map-content">';

        $html .= '<div class="mapcode iframe mapsection gmapwrapp" id="map_canvas' . $map_dynmaic_no . '" style="height:' . $map_height . 'px;"> </div>';

        if ($wp_rem_map_directions == 'off') {
            $html .= '<div id="cs-directions-panel"></div>';
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= "<script type='text/javascript'>
                    jQuery(document).ready(function() {
						var center = new google.maps.LatLng(" . $map_lat . ", " . $map_lon . ");  
						var panorama;
						function initialize() {
							var myLatlng = new google.maps.LatLng(" . $map_lat . ", " . $map_lon . ");
							var mapOptions = {
								zoom: " . /* $map_zoom */ 15 . ",
								scrollwheel: " . $map_scrollwheel . ",
								draggable: " . $map_draggable . ",
								streetViewControl: false,
								center: center,
								disableDefaultUI: true,
								zoomControl: true,
                                mapTypeId: 'terrain',
								mapTypeControl: false
							};
                                                   
                                                    ";
        $html .= "var directionsDisplay;
		var directionsService = new google.maps.DirectionsService();
		directionsDisplay = new google.maps.DirectionsRenderer();";

        $html .= "map = new google.maps.Map(document.getElementById('map_canvas" . $map_dynmaic_no . "'), mapOptions);";

        // if ($wp_rem_map_circle == 'on') {
            
            $html .= "var circle = new google.maps.Circle({
									center: center,
									map: map,
									radius: " . $radius_circle . ",          // IN METERS.
									fillColor: '#FF6600',
									fillOpacity: 0.3,
									strokeColor: '#FF6600',
									strokeWeight: 1         // CIRCLE BORDER.     
								});";
        // }

        $html .= "
		directionsDisplay.setMap(map);
        directionsDisplay.setPanel(document.getElementById('map-direction-detail-" . $map_dynmaic_no . "'));
		directionsDisplay.setOptions( { suppressMarkers: true } );";

        $wp_rem_map_style = isset($wp_rem_plugin_options['wp_rem_def_map_style']) ? $wp_rem_plugin_options['wp_rem_def_map_style'] : '';
        $map_custom_style = isset($wp_rem_plugin_options['wp_rem_map_custom_style']) ? $wp_rem_plugin_options['wp_rem_map_custom_style'] : '';

        if ($map_custom_style != '') {
            $map_custom_style = str_replace('&quot;', '"', $map_custom_style);
            $html .= "var style = " . $map_custom_style . ";
					if (style != '') {
						var styledMap = new google.maps.StyledMapType(style,
								{name: 'Styled Map'});
						map.mapTypes.set('map_style', styledMap);
						map.setMapTypeId('map_style');
					}";
        } else {
            $html .= "var style = '" . $wp_rem_map_style . "';
					if (style != '') { 
						var styles = wp_rem_map_select_style(style);
						if (styles != '') {
							var styledMap = new google.maps.StyledMapType(styles, {name: 'Styled Map'});
							map.mapTypes.set('map_style', styledMap);
							map.setMapTypeId('map_style');
						}
					}";
        }
        //if ( $wp_rem_map_circle != 'on' ) {

        if ($wp_rem_branches_map) {
            $wp_rem_map_cluster_icon = isset($wp_rem_plugin_options['wp_rem_map_cluster_icon']) && $wp_rem_plugin_options['wp_rem_map_cluster_icon'] != '' ? wp_get_attachment_url($wp_rem_plugin_options['wp_rem_map_cluster_icon']) : wp_rem::plugin_url() . '/assets/frontend/images/map-cluster.png';
            $html .= "
				var open_info_window;
				var all_branches_markers = [];
				// var infowindow = new google.maps.InfoWindow({
					// boxClass: 'liting_map_info',
					// content: '" . $map_info . "',
					// maxWidth: " . $map_info_width . ",
					// //pixelOffset: new google.maps.Size(-108, -72),
					// zIndex: null,
					// closeBoxMargin: '2px',
                    // closeBoxURL: 'close',
                    // infoBoxClearance: new google.maps.Size(1, 1),
                    // pane: 'floatPane',
					// enableEventPropagation: false,
					// //disableAutoPan: true,
					// isHidden: false,
				// });
				
				var infowindow = new InfoBox({
					boxClass: 'liting_map_info',							
					content: '" . $map_info . "',
					maxWidth: 0,
					alignBottom: true,
					pixelOffset: new google.maps.Size(-108, -72),
					zIndex: null,
					closeBoxMargin: '2px',
					closeBoxURL: 'close',
					infoBoxClearance: new google.maps.Size(1, 1),
					isHidden: false,
					pane: 'floatPane',
					enableEventPropagation: false,
				});
                    
				var marker = new google.maps.Marker({
					position: myLatlng,
					map: map,
					title: '',
					icon: '" . $map_marker_icon . "',
					shadow: ''
				});

				marker.addListener('drag', function(event) {                     
					circle.setOptions({center:{lat:event.latLng.lat(),lng:event.latLng.lng()}});        
				});
				
				all_branches_markers.push( marker );
				
				if (infowindow.content != ''){
					google.maps.event.addListener(marker, 'click', function(event) {
						if (open_info_window) {
                            open_info_window.close();
						}
						map.panTo(marker.getPosition());
						infowindow.open(map, marker);
						open_info_window = infowindow;
					});
				}
				
				google.maps.event.addListener(map, 'click', function (event) {
					if (infowindow) {
						infowindow.close();
					}
				});";
            if (isset($wp_rem_branches_markers)) {
                $html .= "
					var markers = " . json_encode($wp_rem_branches_markers) . ";
					var LatLngList = [];
					
					$.each(markers, function( key, marker ) {
						myLatlng = new google.maps.LatLng( marker.lat, marker.lng );
						
						LatLngList.push(myLatlng);
						
						var infowindow1 = new InfoBox({
							boxClass: 'liting_map_info',							
							content: marker.content,
							maxWidth: 0,
							alignBottom: true,
							pixelOffset: new google.maps.Size(-108, -72),
							zIndex: null,
							closeBoxMargin: '2px',
							closeBoxURL: 'close',
							infoBoxClearance: new google.maps.Size(1, 1),
							isHidden: false,
							pane: 'floatPane',
							enableEventPropagation: false,
						});
						marker = new google.maps.Marker({
							position: myLatlng,
							map: map,
							title: '',
							icon: '" . $map_marker_icon . "',
							shadow: ''
						});
						
						all_branches_markers.push( marker );
						add_infowindow_event( marker, infowindow1 );
						
					});
					
					function add_infowindow_event( marker2, infowindow2 ) {
						if (infowindow2.content != ''){
							google.maps.event.addListener(marker2, 'click', function(event) {
								if (open_info_window) {
									open_info_window.close();
								}
								map.panTo(marker2.getPosition());
								infowindow2.open(map, marker2);
								open_info_window = infowindow2;
							});
						}
					}
					
					if (all_branches_markers) {
						var mcOptions;
						var clusterStyles = [
							{
								textColor: '#222222',
								opt_textColor: '#222222',
								url: '" . $wp_rem_map_cluster_icon . "',
								height: 40,
								width: 40,
								textSize: 12
							}
						];
						mcOptions = {
							gridSize: 15,
							ignoreHidden: true,
							maxZoom: 12,
							styles: clusterStyles
						};
						//markerClusterers = new MarkerClusterer(map, all_branches_markers, mcOptions);
					}
					
					window.all_branches_markers = all_branches_markers;
					
					if ( LatLngList.length > 0 ) {
						var latlngbounds = new google.maps.LatLngBounds();
						for (var i = 0; i < LatLngList.length; i++) {
							latlngbounds.extend(LatLngList[i]);
						}
						map.setCenter(latlngbounds.getCenter(), map.fitBounds(latlngbounds));

						map.setZoom(map.getZoom());
					}";
            }
        } else {
            $html .= "var infowindow = new google.maps.InfoWindow({
								content: '" . $map_info . "',
								maxWidth: " . $map_info_width . ",
								maxHeight: " . $map_info_height . ",
							});
							var marker = new google.maps.Marker({
								position: myLatlng,
								map: map,
								title: '',
								icon: '" . $map_marker_icon . "',
								shadow: ''
							});
							if (infowindow.content != ''){
							  infowindow.open(map, marker);
							   map.panBy(1,-60);
							   google.maps.event.addListener(marker, 'click', function(event) {
								infowindow.open(map, marker);
							   });
							};";
        }
        //  }
        $html .= "panorama = map.getStreetView();
							panorama.setPosition(myLatlng);
							panorama.setPov(({
							  heading: 265,
							  pitch: 0
							}));
						";
        ob_start();
        ?>
        var markersArray = [];

        jQuery(document).ready(function(){
        $('input.wp_rem_show_nearby:first').trigger('click');
        });

        jQuery(document).on('change', '#map-radius-input-<?php echo esc_html($map_dynmaic_no) ?>', function(){

        if ($('input.wp_rem_show_nearby:checked').length !== 0) {
        var datType = $('input.wp_rem_show_nearby:checked').attr('id');
        var map_center = map.getCenter();
        var datImage = $('input.wp_rem_show_nearby:checked').attr('data-image');
        var datLabel = $('input.wp_rem_show_nearby:checked').attr('data-label');
        search_types(datType, map_center, datImage, datLabel);
        }
        });
        $('.wp_rem_show_nearby').click(function () {

        $(this).parent('li').toggleClass('active');
        var map_center = map.getCenter()
        if ( $(this).is(":checked") ) {
        search_types( $(this).attr('id'), map_center, $(this).data('image'), $(this).data('label') );
        } else {
        clearOverlays();
        $('.wp_rem_show_nearby:checked').each(function(key, elem) {
        search_types( $(this).attr('id'), map_center, $(this).data('image'), $(this).data('label') );
        });
        }
        });

        clearOverlays();
        $('.wp_rem_show_nearby:checked').each(function(key, elem) {
        search_types( $(this).attr('id'), map.getCenter(), $(this).data('image'), $(this).data('label') );
        });

        function search_types(type, latLng, image, label) {

        if (!latLng) {
        var latLng = pyrmont;
        }
        var icon = image;

        var inpRadius = jQuery('#map-radius-input-<?php echo esc_html($map_dynmaic_no) ?>').val();
        if (inpRadius < 1) {
        inpRadius = 2000;
        }

        var request = {
        location: latLng,
        radius: inpRadius,
        types: [type] //e.g. school, restaurant,bank,bar,city_hall,gym,night_club,park,zoo
        };

        var service = new google.maps.places.PlacesService(map);
        service.search(request, function (results, status) {

        map.setZoom(14);
        if (status == google.maps.places.PlacesServiceStatus.OK) {

        var totalResHTML = '';

        if (type != '') {
        totalResHTML = '\
        <div class="places-found-box">\
            <span>'+results.length+ ' ' +(type.replace("_", " "))+' <?php echo wp_rem_plugin_text_srt('wp_rem_map_places_found') ?></span>\
        </div>';
        }

        for (var i = 0; i < results.length; i++) {

        var place = results[i];
        var placeLocation = place.geometry.location;
        var placeLat = placeLocation.lat();
        var placeLng = placeLocation.lng();

        var placeDist = calcDistanceBtwPlaces('<?php echo floatval($map_lat) ?>', '<?php echo floatval($map_lon) ?>', placeLat, placeLng);

        totalResHTML += '\
        <div class="places-detail-box">\
            <span class="place-name"><a id="place-point-<?php echo esc_html($map_dynmaic_no) ?>' + String(i) + '" href="javascript:void(0)">'+place.name+'</a></span>\
            <span class="place-distance">'+meterToKmConvert(placeDist)+'</span>\
        </div>';
        }

        jQuery('#map-places-detail-<?php echo esc_html($map_dynmaic_no) ?>').html(totalResHTML);

        for (var i = 0; i < results.length; i++) {
        results[i].html_attributions = '';

        var markerCountr = '<?php echo esc_html($map_dynmaic_no) ?>' + String(i);

        createMarker(results[i], icon, markerCountr);
        }
        }
        });
        }
        function createMarker(place, icon, countr) {
        var placeLoc = place.geometry.location;
        var marker = new google.maps.Marker({
        map: map,
        position: place.geometry.location,
        icon: icon,
        visible: true,
        pointr: 'place-point-' + countr
        });

        markersArray.push(marker);
        google.maps.event.addListener(marker, 'click', function () {
        infowindow.setContent("<b>" + place.name + "</b><br>" + place.vicinity);
        infowindow.open(map, this);
        });

        google.maps.event.addDomListener(document.getElementById('place-point-' + countr), "click", (function (marker) {
        return function () {
        var placeLat = placeLoc.lat();
        var placeLng = placeLoc.lng();

        var start = new google.maps.LatLng(<?php echo floatval($map_lat) ?>, <?php echo floatval($map_lon) ?>);
        var end = new google.maps.LatLng(placeLat, placeLng);
        var request = {
        origin:start,
        destination:end,
        travelMode: 'DRIVING'
        };
        directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
        }
        });

        new google.maps.event.trigger( marker, 'click' );
        }
        })(marker));
        }

        function calcDistanceBtwPlaces(fromLat, fromLng, toLat, toLng) {
        return google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(fromLat, fromLng), new google.maps.LatLng(toLat, toLng));
        }

        function meterToKmConvert(numbr) {
        numbr = parseFloat(numbr);
        var dist = numbr;
        var unit = 'm';
        if (numbr > 999) {
        dist = numbr/1000;
        unit = 'km';
        }
        var roundDist = parseFloat(Math.round(dist * 100) / 100).toFixed(2);

        return String(roundDist) + ' ' + unit;
        }

        // Deletes all markers in the array by removing references to them
        function clearOverlays() {
        if (markersArray) {
        for (i in markersArray) {
        markersArray[i].setVisible(false)
        }
        }
        }
        <?php
        $html .= ob_get_clean();

        $html .= "}
					function wp_rem_toggle_street_view(btn) {
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
					google.maps.event.addDomListener(window, 'load', initialize);";
        $html .= "});</script>";
        $html .= '</div>';
        $html .= '</div>';

        // col class end
        $html .= '</div>';
        // row end
        $html .= '</div>';
        echo $html;
    }

}

/**
 * Include any template file 
 * with wordpress standards
 */
if (!function_exists('wp_rem_get_template_part')) {

    function wp_rem_get_template_part($slug, $name = '', $ext_template = '') {
        $template = '';

        if ($ext_template != '') {
            $ext_template = trailingslashit($ext_template);
        }
        if ($name) {
            $template = locate_template(array("{$slug}-{$name}.php", wp_rem::template_path() . "{$ext_template}{$slug}-{$name}.php"));
        }
        if (!$template && $name && file_exists(wp_rem::plugin_path() . "/templates/{$ext_template}{$slug}-{$name}.php")) {

            $template = wp_rem::plugin_path() . "/templates/{$ext_template}{$slug}-{$name}.php";
        }
        if (!$template) {

            $template = locate_template(array("{$slug}.php", wp_rem::template_path() . "{$ext_template}{$slug}.php"));
        }
        if ($template) {
            load_template($template, false);
        }
    }

}


if (!function_exists('wp_rem_tooltip_text')) {

    /**
     * Tool tip text for backend usage.
     *
     * @param type $popover_text
     * @param type $return_html
     * @return type
     */
    function wp_rem_tooltip_text($popover_text = '', $return_html = true) {
        $popover_link = '';
        if (isset($popover_text) && $popover_text != '') {
            $popover_link = '<a class="cs-help" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="' . $popover_text . '"><i class="icon-help"></i></a>';
        }
        if ($return_html == true) {
            return $popover_link;
        } else {
            echo force_balance_tags($popover_link);
        }
    }

}



if (!function_exists('wp_rem_get_currency')) {

    /**
     * Return an input variable from $_SERVER if exists else default.
     *
     * @param	string $name name of the variable.
     * @param string $default default value.
     * @return string
     */
    function wp_rem_get_currency($price = '', $currency_symbol = false, $before_currency = '', $after_currency = '', $currency_converter = true) {
        global $wp_rem_plugin_options;
        $price = number_format( (int) $price );
        $price_str = '';
        $default_currency = isset($wp_rem_plugin_options['wp_rem_currency_sign']) ? $wp_rem_plugin_options['wp_rem_currency_sign'] : '$';
        $currency_pos = isset($wp_rem_plugin_options['wp_rem_currency_position']) ? $wp_rem_plugin_options['wp_rem_currency_position'] : 'left';
        $plugin_currency_id = isset($wp_rem_plugin_options['wp_rem_currency_id']) ? $wp_rem_plugin_options['wp_rem_currency_id'] : '';
        $current_currency_id = wp_rem_get_transient_obj('wp_rem_user_currency');
        $current_currency_id = ( $current_currency_id == '' ) ? $plugin_currency_id : $current_currency_id;
        if ($current_currency_id != '') {
            $all_currencies = isset($wp_rem_plugin_options['wp_rem_currencies']) ? $wp_rem_plugin_options['wp_rem_currencies'] : array();
            $currency_obj = isset($all_currencies[$current_currency_id]) ? $all_currencies[$current_currency_id] : array();
            $conversion_rate = isset($currency_obj['conversion_rate']) ? $currency_obj['conversion_rate'] : 1;
            $default_currency = isset($currency_obj['currency_symbol']) ? $currency_obj['currency_symbol'] : '$';
            if ($currency_converter === true) {
                $price = $price * $conversion_rate;
            }
        }

        if ($current_currency_id == '') {
            $base_currency = wp_rem_get_base_currency();
            $base_currency = wp_rem_base_currency_data($base_currency);
            $default_currency = $base_currency['symbol'];
        }

        if (class_exists('WooCommerce')) {
            $woocommerce_enabled = isset($wp_rem_plugin_options['wp_rem_use_woocommerce_gateway']) ? $wp_rem_plugin_options['wp_rem_use_woocommerce_gateway'] : '';
            if ($woocommerce_enabled == 'on') {
                $default_currency = get_woocommerce_currency_symbol();
                $currency_pos = get_option('woocommerce_currency_pos');
            }
        }

        // $price = WP_REM_FUNCTIONS()->num_format($price);

        $currency_symbols = ['$', '€', '£'];
        foreach($currency_symbols as $symbol) {
            if (substr($price, 0, 1) === $symbol) {
                $default_currency = '';
                break;
            }
        }
        
        $price = $default_currency . $price;
        if ($currency_symbol == true && is_numeric($price)) {
            $currency_sign = $before_currency . $default_currency . $after_currency;
            $price_str = $currency_sign . $price;
            switch ($currency_pos) {
                case 'left' :
                    $price_str = $currency_sign . $price;
                    break;
                case 'right' :
                    $price_str = $price . $currency_sign;
                    break;
                case 'left_space' :
                    $price_str = $currency_sign . ' ' . $price;
                    break;
                case 'right_space' :
                    $price_str = $price . ' ' . $currency_sign;
                    break;
            }
        } else {
            $price_str = $price;
        }
        return $price_str;
    }

}

if (!function_exists('wp_rem_get_order_currency')) {

    function wp_rem_get_order_currency($price, $currency_sign = '', $currency_position = '') {
        global $wp_rem_plugin_options;
        $default_currency = isset($wp_rem_plugin_options['wp_rem_currency_sign']) ? $wp_rem_plugin_options['wp_rem_currency_sign'] : '$';
        $currency_pos = isset($wp_rem_plugin_options['wp_rem_currency_position']) ? $wp_rem_plugin_options['wp_rem_currency_position'] : 'left';
        $currency_sign = ( $currency_sign != '' ) ? $currency_sign : $default_currency;
        $currency_position = ( $currency_position != '' ) ? $currency_position : $currency_pos;

        // $price = WP_REM_FUNCTIONS()->num_format($price);
        $price = '$' . $price;
        $price_str = $currency_sign . $price;
        switch ($currency_position) {
            case 'left' :
                $price_str = $currency_sign . $price;
                break;
            case 'right' :
                $price_str = $price . $currency_sign;
                break;
            case 'left_space' :
                $price_str = $currency_sign . ' ' . $price;
                break;
            case 'right_space' :
                $price_str = $price . ' ' . $currency_sign;
                break;
        }

        return $price_str;
    }

}

if (!function_exists('wp_rem_get_base_currency')) {

    function wp_rem_get_base_currency() {
        global $wp_rem_plugin_options;
        $base_currency = isset($wp_rem_plugin_options['wp_rem_currency_type']) ? $wp_rem_plugin_options['wp_rem_currency_type'] : 'USD';
        if (class_exists('WooCommerce')) {
            $woocommerce_enabled = isset($wp_rem_plugin_options['wp_rem_use_woocommerce_gateway']) ? $wp_rem_plugin_options['wp_rem_use_woocommerce_gateway'] : '';
            if ($woocommerce_enabled == 'on') {
                $base_currency = get_woocommerce_currency();
            }
        }
        return $base_currency;
    }

}

if (!function_exists('wp_rem_base_currency_sign')) {

    function wp_rem_base_currency_sign() {
        global $wp_rem_plugin_options;
        $base_currency = wp_rem_get_base_currency();
        $base_currency = wp_rem_base_currency_data($base_currency);
        $default_currency = $base_currency['symbol'];
        if (class_exists('WooCommerce')) {
            $woocommerce_enabled = isset($wp_rem_plugin_options['wp_rem_use_woocommerce_gateway']) ? $wp_rem_plugin_options['wp_rem_use_woocommerce_gateway'] : '';
            if ($woocommerce_enabled == 'on') {
                $default_currency = get_woocommerce_currency_symbol();
            }
        }
        return $default_currency;
    }

}

if (!function_exists('wp_rem_get_currency_position')) {

    /**
     *
     * @return position for currency sign
     */
    function wp_rem_get_currency_position() {
        global $wp_rem_plugin_options;
        $currency_position = isset($wp_rem_plugin_options['wp_rem_currency_position']) ? $wp_rem_plugin_options['wp_rem_currency_position'] : 'left';

        if (class_exists('WooCommerce')) {
            $woocommerce_enabled = isset($wp_rem_plugin_options['wp_rem_use_woocommerce_gateway']) ? $wp_rem_plugin_options['wp_rem_use_woocommerce_gateway'] : '';
            if ($woocommerce_enabled == 'on') {
                $currency_position = get_option('woocommerce_currency_pos');
            }
        }
        return $currency_position;
    }

}

if (!function_exists('wp_rem_base_currency_data')) {

    function wp_rem_base_currency_data($base_currency = 'USD') {
        global $wp_rem_plugin_options;
        $currencies = wp_rem_get_currencies();
        if (isset($currencies[$base_currency]['symbol'])) {
            $base_currency = $currencies[$base_currency];
        }
        return $base_currency;
    }

}

if (!function_exists('wp_rem_get_currency_sign')) {

    /**
     *
     * @return string for currency sign
     */
    function wp_rem_get_currency_sign() {
        global $wp_rem_plugin_options;
        $price_str = '';
        $default_currency = isset($wp_rem_plugin_options['wp_rem_currency_sign']) ? $wp_rem_plugin_options['wp_rem_currency_sign'] : '$';
        $plugin_currency_id = isset($wp_rem_plugin_options['wp_rem_currency_id']) ? $wp_rem_plugin_options['wp_rem_currency_id'] : '';
        $current_currency_id = wp_rem_get_transient_obj('wp_rem_user_currency');

        $current_currency_id = ( $current_currency_id == '' ) ? $plugin_currency_id : $current_currency_id;



        if ($current_currency_id != '') {
            $all_currencies = isset($wp_rem_plugin_options['wp_rem_currencies']) ? $wp_rem_plugin_options['wp_rem_currencies'] : array();
            $currency_obj = isset($all_currencies[$current_currency_id]) ? $all_currencies[$current_currency_id] : array();
            $default_currency = isset($currency_obj['currency_symbol']) ? $currency_obj['currency_symbol'] : '$';
        }

        if ($current_currency_id == '') {
            $base_currency = wp_rem_get_base_currency();
            $base_currency = wp_rem_base_currency_data($base_currency);
            $default_currency = $base_currency['symbol'];
        }

        if (class_exists('WooCommerce')) {
            $woocommerce_enabled = isset($wp_rem_plugin_options['wp_rem_use_woocommerce_gateway']) ? $wp_rem_plugin_options['wp_rem_use_woocommerce_gateway'] : '';
            if ($woocommerce_enabled == 'on') {
                $default_currency = get_woocommerce_currency_symbol();
            }
        }

        return $default_currency;
    }

}


add_filter('icl_ls_languages', 'wpml_ls_filter');

if (!function_exists('wpml_ls_filter')) {

    function wpml_ls_filter($languages) {
        global $sitepress;
        if (strpos(basename($_SERVER['REQUEST_URI']), 'dashboard') !== false || strpos(basename($_SERVER['REQUEST_URI']), 'tab') !== false) {

            $cs_request_query = str_replace('?', '', basename($_SERVER['REQUEST_URI']));

            $cs_request_query = explode('&', $cs_request_query);

            $cs_request_quer = '';

            $query_count = 1;

            if (is_array($cs_request_query)) {
                foreach ($cs_request_query as $quer) {
                    if (strpos($quer, 'page_id') !== false || strpos($quer, 'lang') !== false) {
                        continue;
                    }
                    if ($query_count == 1) {
                        $cs_request_quer .= $quer;
                    } else {
                        $cs_request_quer .= '&' . $quer;
                    }
                    $query_count ++;
                }
            }

            if (is_array($languages) && sizeof($languages) > 0) {
                foreach ($languages as $lang_code => $language) {
                    if (strpos($languages[$lang_code]['url'], '?') !== false) {
                        $languages[$lang_code]['url'] = $languages[$lang_code]['url'] . '&' . $cs_request_quer;
                    } else {
                        $languages[$lang_code]['url'] = $languages[$lang_code]['url'] . '?' . $cs_request_quer;
                    }
                }
            }
        }
        return $languages;
    }

}

/*
 * footer hook curriencies and languages
 */

if (!function_exists('wp_rem_wpml_languages_footer_callback')) {

    function wp_rem_wpml_languages_footer_callback() {
        if (function_exists('icl_object_id')) {
            global $wp_rem_cs_var_options;
            $wp_rem_wpml_switch = isset($wp_rem_cs_var_options['wp_rem_cs_var_footer_lang_switch']) ? $wp_rem_cs_var_options['wp_rem_cs_var_footer_lang_switch'] : '';
            if (function_exists('icl_object_id') && isset($wp_rem_wpml_switch) && $wp_rem_wpml_switch == 'on') {
                echo '<div class="field-holder wp-rem-wpml-languages">';
                do_action('wpml_add_language_selector');
                echo '</div>';
            }
        }
    }

    add_action('wp_rem_before_app_in_footer', 'wp_rem_wpml_languages_footer_callback', 9);
}
if (!function_exists('wp_rem_before_app_in_footer_callback')) {

    add_action('wp_rem_before_app_in_footer', 'wp_rem_before_app_in_footer_callback', 10);

    function wp_rem_before_app_in_footer_callback($currency = '') {
        ?>
        <div class="field-holder">
            <?php do_action('wp_rem_all_currencies_field'); ?>
        </div>
        <?php
    }

}

/*
 * end footer currency and language 
 */

if (!function_exists('wp_rem_wpml_languages_callback')) {

    function wp_rem_wpml_languages_callback() {
        if (function_exists('icl_object_id')) {
            global $wp_rem_cs_var_options;
            $wp_rem_wpml_switch = isset($wp_rem_cs_var_options['wp_rem_cs_var_footer_lang_switch']) ? $wp_rem_cs_var_options['wp_rem_cs_var_footer_lang_switch'] : '';
            if (function_exists('icl_object_id') && isset($wp_rem_wpml_switch) && $wp_rem_wpml_switch == 'on') {

                echo '<div class="field-holder wp-rem-wpml-languages">';
                do_action('wpml_add_language_selector');
                echo '</div>';
            }
        }
    }

    add_action('wp_rem_before_contact_in_header', 'wp_rem_wpml_languages_callback', 9);
}
if (!function_exists('wp_rem_before_contact_in_header_callback')) {

    add_action('wp_rem_before_contact_in_header', 'wp_rem_before_contact_in_header_callback', 10);

    function wp_rem_before_contact_in_header_callback($currency = '') {
        global $wp_rem_plugin_options;
        $wp_rem_currency_switch = isset($wp_rem_plugin_options['wp_rem_currency_switch']) ? $wp_rem_plugin_options['wp_rem_currency_switch'] : '';
        if (isset($wp_rem_currency_switch) && $wp_rem_currency_switch != 'on') {
            return;
        }
        ?>
        <div class="field-holder">
            <?php do_action('wp_rem_all_currencies_field'); ?>
        </div>
        <?php
    }

}
if (!function_exists('wp_rem_all_currencies_calback')) {

    add_action('wp_rem_all_currencies_field', 'wp_rem_all_currencies_calback');

    function wp_rem_all_currencies_calback($currency = '') {
        global $wp_rem_html_fields_frontend, $wp_rem_plugin_options;
        $all_currencies = isset($wp_rem_plugin_options['wp_rem_currencies']) ? $wp_rem_plugin_options['wp_rem_currencies'] : array();
        $wp_rem_default_currency = isset($wp_rem_plugin_options['wp_rem_currency_type']) ? $wp_rem_plugin_options['wp_rem_currency_type'] : 'USD';
        $wp_rem_currencuies = wp_rem_get_currencies();
        $base_currency = $wp_rem_currencuies[$wp_rem_default_currency];
        $currencies_array = array('' => $base_currency['code'] . '(' . $base_currency['symbol'] . ')');
        //  print_r($currencies_array);
        if (!empty($all_currencies)) {
            foreach ($all_currencies as $currency_key => $currencyObj) {
                $currencies_array[$currency_key] = $currencyObj['currency_name'] . '(' . $currencyObj['currency_symbol'] . ')';
            }
        }

        $current_currency_id = wp_rem_get_transient_obj('wp_rem_user_currency');
        echo '<span class="rem-currency-field-label">' . wp_rem_plugin_text_srt('wp_rem_helper_currency') . ' :</span>';
        $wp_rem_opt_array = array(
            'name' => wp_rem_plugin_text_srt('wp_rem_helper_currency'),
            'desc' => '',
            'echo' => true,
            'field_params' => array(
                'std' => $current_currency_id,
                'id' => 'currency-id',
                'classes' => 'rem-currency-field chosen-select-no-single',
                'options' => $currencies_array,
                'extra_atr' => ''
            ),
        );
        $wp_rem_html_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array);

        $wp_rem_cs_inline_script = '
        jQuery(document).ready(function () {
            chosen_selectionbox();
            jQuery(document).on("change", "#wp_rem_currency-id", function() {
                "use strict";
                var field_value = jQuery(this).val();
                jQuery.ajax({
                    type: "POST",
                    url: wp_rem_globals.ajax_url,
                    data: "currency_id=" + field_value + "&action=wp_rem_change_user_currency",
                    dataType: "html",
                    success: function(response) {
                        location.reload(true);
                    }
                });
            });
        });';
        wp_rem_cs_inline_enqueue_script($wp_rem_cs_inline_script, 'wp-rem-custom-inline');
    }

}
if (!function_exists('wp_rem_all_currencies_array')) {

    function wp_rem_all_currencies_array($currency = '') {
        global $wp_rem_plugin_options;
        $currencies_array = array('' => wp_rem_plugin_text_srt('wp_rem_helper_select_currency'));
        $all_currencies = isset($wp_rem_plugin_options['wp_rem_currencies']) ? $wp_rem_plugin_options['wp_rem_currencies'] : array();

        if (!empty($all_currencies)) {
            foreach ($all_currencies as $currency_key => $currencyObj) {
                $currencies_array[$currency_key] = $currencyObj['currency_name'];
            }
        }
        return $currencies_array;
    }

}
if (!function_exists('wp_rem_change_user_currency_callback')) {

    function wp_rem_change_user_currency_callback() {
        global $wp_rem_plugin_options;
        $currency_id = wp_rem_get_input('currency_id');
        if ($currency_id != '') {
            wp_rem_set_transient_obj('wp_rem_user_currency', $currency_id);
        } else {
            wp_rem_remove_transient_obj('wp_rem_user_currency');
        }
        wp_die();
    }

}
add_action('wp_ajax_wp_rem_change_user_currency', 'wp_rem_change_user_currency_callback', 1);
add_action('wp_ajax_nopriv_wp_rem_change_user_currency', 'wp_rem_change_user_currency_callback', 1);

if (!function_exists('wp_rem_current_page_url')) {

    /**
     * Return an input variable from $_SERVER if exists else default.
     *
     * @param	string $name name of the variable.
     * @param string $default default value.
     * @return string
     */
    function wp_rem_current_page_url($request_var = true) {
        $pageURL = 'http';
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $request_str = '';
        if ($request_var == true) {
            if (isset($_SERVER["REQUEST_URI"]) && $_SERVER["REQUEST_URI"] != '') {
                $request_str = $_SERVER["REQUEST_URI"];
            }
        }
        $pageURL .= "://";
        if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $request_str;
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $request_str;
        }
        echo esc_url($pageURL);
        return $pageURL;
    }

}

if (!function_exists('wp_rem_company_id_form_user_id')) {

    function wp_rem_company_id_form_user_id($user_id = '') {
        $company_id = '';
        if ($user_id == '') {
            $user_id = get_current_user_id();
        }
        if ($user_id != '') {
            $company_id = get_user_meta($user_id, 'wp_rem_company', true);
        }
        return $company_id;
    }

}

if (!function_exists('wp_rem_user_id_form_company_id')) {

    function wp_rem_user_id_form_company_id($company_id = '') {
        $user_id = '';

        if ($company_id != '') {
            $args = array(
                'meta_query' =>
                array(
                    array(
                        'relation' => 'AND',
                        array(
                            'key' => 'wp_rem_company',
                            'value' => $company_id,
                            'compare' => '=',
                            'type' => 'numeric'
                        ),
                    )
                )
            );

            $users = get_users($args);
            if (!empty($users) && is_array($users))
                foreach ($users as $user) {
                    foreach ($user as $user_data) {
                        $user_id = isset($user_data->ID) ? $user_data->ID : '';
                        break;
                    }
                }
        }
        return $user_id;
    }

}

if (!function_exists('wp_rem_get_property_type_item_count')) {

    function wp_rem_get_property_type_item_count($left_filter_count_switch, $property_type, $field_meta_key, $args_filters) {
        if ($left_filter_count_switch == 'yes') {
            $args_filters['meta_query'][] = array(
                'key' => $field_meta_key,
                'value' => $property_type,
                'compare' => '=',
            );
            $property_qry = new WP_Query($args_filters);
            return $property_qry->found_posts;
            wp_reset_postdata();
        }
    }

}

if (!function_exists('wp_rem_get_property_open_house_count')) {

    function wp_rem_get_property_open_house_count($left_filter_count_switch, $field_value, $args_filters) {

        if ($left_filter_count_switch == 'yes') {
            $time = $field_value;
            if ($time == 'today') {
                $start_date = strtotime(date("Y/m/d") . " 00:00");
                $end_date = strtotime(date("Y/m/d") . " 23:59");
            }
            if ($time == 'tomorrow') {
                $date = date("Y/m/d");
                $date1 = str_replace('-', '/', $date);
                $tomorrow = date('Y/m/d', strtotime($date1 . "+1 days"));
                $start_date = strtotime($tomorrow . " 00:00");
                $end_date = strtotime($tomorrow . " 23:59");
            }
            if ($time == 'through_weekend') {
                $date = date("Y/m/d");
                $date1 = str_replace('-', '/', $date);
                $weekend = date('Y/m/d', strtotime($date1 . "next Sunday"));
                $end_date = strtotime($weekend . " 23:59");
            }
            if ($time == 'weekend_only') {
                $date = date("Y/m/d");
                $date1 = str_replace('-', '/', $date);
                $saturday = date('Y/m/d', strtotime($date1 . "next Saturday"));
                $sunday = date('Y/m/d', strtotime($date1 . "next Sunday"));
                $start_date = strtotime($saturday . " 00:00");
                $end_date = strtotime($sunday . " 23:59");
            }
            $args_filters['meta_query'][] = array(
                'relation' => 'OR',
                array(
                    'relation' => 'OR',
                    array(
                        'key' => 'open_house_start',
                        'value' => array($start_date, $end_date),
                        'compare' => 'BETWEEN',
                        'type' => 'NUMERIC',
                    ),
                    array(
                        'key' => 'open_house_end',
                        'value' => array($start_date, $end_date),
                        'compare' => 'BETWEEN',
                        'type' => 'NUMERIC',
                    ),
                ),
                array(
                    'relation' => 'AND',
                    array(
                        'key' => 'open_house_start',
                        'value' => $start_date,
                        'compare' => '<=',
                        'type' => 'NUMERIC',
                    ),
                    array(
                        'key' => 'open_house_end',
                        'value' => $end_date,
                        'compare' => '>=',
                        'type' => 'NUMERIC',
                    ),
                ),
            );

            $property_qry = new WP_Query($args_filters);
            return $property_qry->found_posts;
            wp_reset_postdata();
        }
    }

}


if (!function_exists('wp_rem_get_item_count')) {

    function wp_rem_get_item_count($left_filter_count_switch, $args, $count_arr, $property_type, $property_short_counter, $atts, $field_meta_key, $open_house = '') {
        if ($left_filter_count_switch == 'yes') {
            global $wp_rem_shortcode_properties_frontend;


            // get all arguments from getting flters
            $left_filter_arr = $wp_rem_shortcode_properties_frontend->get_filter_arg($property_type, $property_short_counter, $field_meta_key);
            if ($count_arr != '') {
                $left_filter_arr[] = $count_arr;
            }

            $search_features_filter = $wp_rem_shortcode_properties_frontend->property_search_features_filter();
            if (!empty($search_features_filter)) {
                $left_filter_arr[] = $search_features_filter;
            }

            $post_ids = '';
            if (!empty($left_filter_arr)) {
                // apply all filters and get ids
                $post_ids = $wp_rem_shortcode_properties_frontend->get_property_id_by_filter($left_filter_arr);
            }

            if (isset($_REQUEST['location']) && $_REQUEST['location'] != '' && !isset($_REQUEST['loc_polygon_path'])) {
                $radius = isset($_REQUEST['radius']) ? $_REQUEST['radius'] : '';
                $post_ids = $wp_rem_shortcode_properties_frontend->property_location_filter($_REQUEST['location'], $post_ids);
                if (empty($post_ids)) {
                    $post_ids = array(0);
                }
            }

            $post_ids = $wp_rem_shortcode_properties_frontend->property_open_house_filter($open_house, $post_ids);
            $all_post_ids = $post_ids;
            if (!empty($all_post_ids)) {
                $args['post__in'] = $all_post_ids;
            }

            $restaurant_loop_obj = wp_rem_get_cached_obj('property_result_cached_loop_count_obj', $args, 12, false, 'wp_query');
            $restaurant_totnum = $restaurant_loop_obj->found_posts;
            return $restaurant_totnum;
        }
    }

}

if (!function_exists('wp_rem_get_cached_obj')) {

    function wp_rem_get_cached_obj($cache_variable, $args, $time = 12, $cache = true, $type = 'wp_query', $taxanomy_name = '') {
        $property_loop_obj = '';
        if ($cache == true) {
            $time_string = $time * HOUR_IN_SECONDS;
            if ($cache_variable != '') {
                if (false === ( $property_loop_obj = wp_cache_get($cache_variable) )) {
                    if ($type == 'wp_query') {
                        $property_loop_obj = new WP_Query($args);
                    } else if ($type == 'get_term') {
                        $property_loop_obj = array();
                        $terms = get_terms($taxanomy_name, $args);
                        if (sizeof($terms) > 0) {
                            foreach ($terms as $term_data) {
                                $property_loop_obj[] = $term_data->name;
                            }
                        }
                    }
                    wp_cache_set($cache_variable, $property_loop_obj, $time_string);
                }
            }
        } else {
            if ($type == 'wp_query') {
            	if (@$GLOBALS['wp_rem_split_map_shortcode_atts']['filter_by_categories']) {
            	    $property_categories = $GLOBALS['wp_rem_split_map_shortcode_atts']['filter_by_categories'];
            	    $property_categories = str_replace(['&#8221;', '&#8243;', '”', '″'], '', $property_categories);
            	    $property_categories = explode(',', $property_categories);

            	    $args['tax_query'] = array(
            	        'relation' => 'AND',
            	        array(
            	          'taxonomy' => 'property-category',
            	          'field'    => 'term_id',
            	          'terms'    => $property_categories
            	        )
            	    );
            	}
                $property_loop_obj = new WP_Query($args);
            } else if ($type == 'get_term') {
                $property_loop_obj = array();
                $terms = get_terms($taxanomy_name, $args);
                if (sizeof($terms) > 0) {
                    foreach ($terms as $term_data) {
                        $property_loop_obj[] = $term_data->name;
                    }
                }
            }
        }



        return $property_loop_obj;
    }

}
if (!function_exists('wp_rem_remove_transient_obj')) {

    function wp_rem_remove_transient_obj($transient_variable) {
        $identifier = uniqid();
        if (isset($_COOKIE['identifier'])) {
            $identifier = $_COOKIE['identifier'];
        }
        delete_transient($identifier . $transient_variable);
    }

}
if (!function_exists('wp_rem_set_transient_obj')) {

    function wp_rem_set_transient_obj($transient_variable, $data_string, $time = 12) {
        if (!isset($_COOKIE['identifier']) || $_COOKIE['identifier'] == '') {
            setcookie('identifier', uniqid(), time() + (86400 * 30), "/"); // 86400 = 1 day
        }
        $result = '';
        $identifier = isset($_COOKIE['identifier']) ? $_COOKIE['identifier'] : '';
        $time_string = $time * HOUR_IN_SECONDS;
        if ($data_string != '') {
            $result = set_transient($identifier . $transient_variable, $data_string, $time_string);
        }
        return $result;
    }

}

if (!function_exists('wp_rem_get_transient_obj')) {

    function wp_rem_get_transient_obj($transient_variable) {
        $identifier = uniqid();
        if (isset($_COOKIE['identifier'])) {
            $identifier = $_COOKIE['identifier'];
        }
        if (false === ( $data_string = get_transient($identifier . $transient_variable) )) {
            return false;
        } else {
            return $data_string;
        }
    }

}

if (!function_exists('wp_rem_random_ads_callback')) {

    function wp_rem_random_ads_callback($banner_style) {
        global $wpdb, $post, $wp_rem_plugin_options;
        $cs_total_banners = 1;
        if (isset($wp_rem_plugin_options['wp_rem_banner_title'])) {
            $i = 0;
            $d = 0;
            $cs_banner_array = array();
            foreach ($wp_rem_plugin_options['wp_rem_banner_title'] as $banner) :

                if ($wp_rem_plugin_options['wp_rem_banner_style'][$i] == $banner_style) {

                    $cs_banner_array[] = $i;
                    $d ++;
                }
                $i ++;
            endforeach;
            if (sizeof($cs_banner_array) > 0) {
                if (sizeof($cs_banner_array) > 1) {
                    $cs_act_size = sizeof($cs_banner_array) - 1;
                    $cs_rand_banner = rand(0, $cs_act_size);
                } else {
                    $cs_rand_banner = 0;
                }

                $rand_banner = $cs_banner_array[$cs_rand_banner];

                echo do_shortcode('[wp_rem_ads id="' . $wp_rem_plugin_options['wp_rem_banner_field_code_no'][$rand_banner] . '"]');
            }
        }
    }

    add_action('wp_rem_random_ads', 'wp_rem_random_ads_callback', 1);
}


if (!function_exists('wp_rem_contact_message_send')) {

    function wp_rem_contact_message_send() {

        define('WP_USE_THEMES', false);
        global $abc, $wp_rem_plugin_options;
        $check_box = '';
        $json = array();
        $subject_name = '';
        wp_rem_verify_term_condition_form_field('member_detail_term_policy');
        foreach ($_REQUEST as $keys => $values) {
            $$keys = $values;
        }
        $wp_rem_cs_danger_html = '<div class="error">';
        $wp_rem_cs_success_html = '<div class="success">';
        $wp_rem_cs_msg_html = '</div>';
        $bloginfo = get_bloginfo();
        $wp_rem_cs_contactus_send = '';
        $subjecteEmail = "(" . $bloginfo . ") " . wp_rem_plugin_text_srt('wp_rem_helper_member_msg_received');
        if ('' == $wp_rem_member_email || !preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/', $wp_rem_member_email)) {
            $json['type'] = "error";
            $json['msg'] = $wp_rem_cs_danger_html . wp_rem_plugin_text_srt('wp_rem_helper_member_email_not_valid') . $wp_rem_cs_msg_html;
        } else {
            if ($contact_full_name == '') {
                $json['type'] = 'error';
                $json['msg'] = $wp_rem_cs_danger_html . wp_rem_plugin_text_srt('wp_rem_helper_name_empty') . $wp_rem_cs_msg_html;
            } else if ($contact_email_add == '') {
                $json['type'] = 'error';
                $json['msg'] = $wp_rem_cs_danger_html . wp_rem_plugin_text_srt('wp_rem_helper_email_empty') . $wp_rem_cs_msg_html;
            } else if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/', $contact_email_add)) {
                $json['type'] = "error";
                $json['msg'] = $wp_rem_cs_danger_html . wp_rem_plugin_text_srt('wp_rem_helper_email_not_valid') . $wp_rem_cs_msg_html;
            } else if ($contact_message_field == '') {
                $json['type'] = "error";
                $json['msg'] = $wp_rem_cs_danger_html . wp_rem_plugin_text_srt('wp_rem_helper_msg_empty') . $wp_rem_cs_msg_html;
            } else {
                $message = '
			    <table width="100%" border="1">
				<tr>
				    <td width="100"><strong>' . wp_rem_plugin_text_srt('wp_rem_helper_name') . '</strong></td>
				    <td>' . esc_html($contact_full_name) . '</td>
				</tr>
				<tr>
				    <td><strong>' . wp_rem_plugin_text_srt('wp_rem_helper_email') . '</strong></td>
				    <td>' . esc_html($contact_email_add) . '</td>
				</tr>';

                if ($message_field != '') {
                    $message .= '<tr>
					<td><strong>' . wp_rem_plugin_text_srt('wp_rem_helper_message') . '</strong></td>
					<td>' . esc_html($contact_message_field) . '</td>
				  </tr>';
                }
                $wp_rem_captcha_switch = isset($wp_rem_plugin_options['wp_rem_captcha_switch']) ? $wp_rem_plugin_options['wp_rem_captcha_switch'] : '';

                if ($wp_rem_captcha_switch == 'on') {
                    do_action('wp_rem_verify_captcha_form');
                }
                $message .= ' <tr><td><strong>' . wp_rem_plugin_text_srt('wp_rem_helper_ip_address') . '</strong></td>
					<td>' . $_SERVER["REMOTE_ADDR"] . '</td>
				  </tr>
				</table>';
                $headers = "From: " . $contact_full_name . "\r\n";
                $headers .= "Reply-To: " . $contact_email_add . "\r\n";
                $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $attachments = '';
                $respose = wp_mail($wp_rem_member_email, $subjecteEmail, $message, $headers);
                if ($respose) {
                    $json['type'] = "success";
                    $json['msg'] = $wp_rem_cs_success_html . wp_rem_plugin_text_srt('wp_rem_helper_sent_msg_successfully') . $wp_rem_cs_msg_html;
                } else {
                    $json['type'] = "error";
                    $json['msg'] = $wp_rem_cs_danger_html . wp_rem_plugin_text_srt('wp_rem_helper_msg_not_sent') . $wp_rem_cs_msg_html;
                };
            }
        }
        echo json_encode($json);
        die();
    }

    //Submit member  Form Hooks
    add_action('wp_ajax_nopriv_wp_rem_contact_message_send', 'wp_rem_contact_message_send');
    add_action('wp_ajax_wp_rem_contact_message_send', 'wp_rem_contact_message_send');
}

/*
 * Map Nearby icons with markers
 */

if (!function_exists('wp_rem_map_markers_nearby')) {

    function wp_rem_map_markers_nearby() {
        global $wp_rem_plugin_options, $wp_rem_form_fields_frontend;
        $wp_rem_map_markers_data = isset($wp_rem_plugin_options['wp_rem_map_markers_data']) ? $wp_rem_plugin_options['wp_rem_map_markers_data'] : array();
        if (isset($wp_rem_map_markers_data['image'])) :
            ?>
            <ul class="dominant-places">
                <?php
                foreach ($wp_rem_map_markers_data['image'] as $key => $row) :
                    $image = isset($wp_rem_map_markers_data['image'][$key]) ? $wp_rem_map_markers_data['image'][$key] : '';
                    $map_image = isset($wp_rem_map_markers_data['map_image'][$key]) ? $wp_rem_map_markers_data['map_image'][$key] : '';
                    $title = isset($wp_rem_map_markers_data['label'][$key]) ? $wp_rem_map_markers_data['label'][$key] : '';
                    $type = isset($wp_rem_map_markers_data['type'][$key]) ? $wp_rem_map_markers_data['type'][$key] : '';
                    ?>
                    <li data-placement="bottom" data-toggle="tooltip" title="<?php echo esc_html($title); ?>" >
                        <?php
                        $wp_rem_opt_array = array(
                            'std' => '',
                            'simple' => true,
                            'cust_id' => esc_html($type),
                            'cust_name' => esc_html($type),
                            'classes' => 'hidden show-poi-checkbox wp_rem_show_nearby',
                            'extra_atr' => ' data-label="' . esc_html($title) . '" data-image="' . wp_get_attachment_url($map_image) . '"',
                        );
                        $wp_rem_form_fields_frontend->wp_rem_form_checkbox_render($wp_rem_opt_array);
                        ?>
                        <label class="show-nearby-point-label" for="<?php echo esc_html($type); ?>"><img src="<?php echo wp_get_attachment_url($image); ?>" alt=""></label>
                    </li>
                    <?php
                endforeach;
                ?>
            </ul>
            <?php
        endif;
    }

}

if (!function_exists('get_user_info_array')) {

    function get_user_info_array($user_id = '') {
        $first_name = '';
        $last_name = '';
        $email = '';
        $phone_number = '';
        $address = '';
        if ($user_id == '') {
            $user_data = wp_get_current_user();
            $user_id = $user_data->ID;
        }
        if (is_user_logged_in()) {
            $member_id = get_user_meta($user_id, 'wp_rem_company', true);
            $display_name = get_the_title($member_id);
            $user_names = explode(" ", $display_name);
            $first_name = isset($user_names[0]) ? $user_names[0] : '';
            $last_name = isset($user_names[1]) ? $user_names[1] : '';
            $phone_number = get_post_meta($member_id, 'wp_rem_phone_number', true);
            $email = get_post_meta($member_id, 'wp_rem_email_address', true);
            $address = get_post_meta($member_id, 'wp_rem_post_loc_address_member', true);
        }

        $user_info = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone_number' => $phone_number,
            'email' => $email,
            'display_name' => $display_name,
            'address' => $address,
        );

        return $user_info;
    }

}

/*
 * Property counter
 */
if (!function_exists('wp_rem_property_category_link')) {

    function wp_rem_property_category_link($property_type_id, $cat_slug) {
        global $wp_rem_plugin_options;
        $wp_rem_search_result_page = get_post_meta($property_type_id, 'wp_rem_search_result_page', true);
        if ($wp_rem_search_result_page != '') {
            $wp_rem_search_result_page = get_permalink($wp_rem_search_result_page);
        } else {
            $wp_rem_search_result_page = isset($wp_rem_plugin_options['wp_rem_search_result_page']) ? $wp_rem_plugin_options['wp_rem_search_result_page'] : '';
            $wp_rem_search_result_page = get_permalink($wp_rem_search_result_page);
        }

        $cate_link = '';
        if ($wp_rem_search_result_page != '') {
            $property_type_slug = wp_rem_post_slug($property_type_id);
            $cate_link = $wp_rem_search_result_page != '' ? add_query_arg(array('property_type' => $property_type_slug, 'property_category' => $cat_slug, 'ajax_filter' => 'true',), $wp_rem_search_result_page) : 'javascript:void(0);';
        } else {
            $cate_link = 'javascript:void(0);';
        }
        return $cate_link;
    }

}

if (!function_exists('wp_rem_property_type_link')) {

    function wp_rem_property_type_link($property_type_id) {
        global $wp_rem_plugin_options;
        $wp_rem_search_result_page = get_post_meta($property_type_id, 'wp_rem_search_result_page', true);
        if ($wp_rem_search_result_page != '') {
            $wp_rem_search_result_page = get_permalink($wp_rem_search_result_page);
        } else {
            $wp_rem_search_result_page = isset($wp_rem_plugin_options['wp_rem_search_result_page']) ? $wp_rem_plugin_options['wp_rem_search_result_page'] : '';
            $wp_rem_search_result_page = get_permalink($wp_rem_search_result_page);
        }

        $type_link = '';
        if ($wp_rem_search_result_page != '') {
            $property_type_slug = wp_rem_post_slug($property_type_id);
            $type_link = $wp_rem_search_result_page != '' ? add_query_arg(array('property_type' => $property_type_slug, 'ajax_filter' => 'true',), $wp_rem_search_result_page) : 'javascript:void(0);';
        } else {
            $type_link = 'javascript:void(0);';
        }

        $type_link = '<a href="' . $type_link . '">' . get_the_title($property_type_id) . '</a>';
        return $type_link;
    }

}

if (!function_exists('wp_rem_post_slug')) {

    function wp_rem_post_slug($post_id = '') {
        $post_slug = false;
        if ($post_id != '') {
            $post = get_post($post_id);
            if (isset($post->post_name) && $post->post_name != '') {
                $post_slug = $post->post_name;
            }
        }
        return $post_slug;
    }

}

if (!function_exists('property_gallery_first_image')) {

    function property_gallery_first_image($args) {

        $property_id = '';
        $size = 'thumnail';
        $class = '';
        $return_type = '';
        $default_image_src = esc_url(wp_rem::plugin_url() . 'assets/frontend/images/no-image9x6.jpg');
        extract($args);

        $gallery_image = $gallery_image_id = $gallery_image_url = '';
        if ($property_id != '') {
            $list_type_slug = get_post_meta($property_id, 'wp_rem_property_type', true);
            if ($post = get_page_by_path($list_type_slug, OBJECT, 'property-type')) {
                $property_type_id = $post->ID;
            } else {
                $property_type_id = 0;
            }
            $wp_rem_image_gallery_element = get_post_meta($property_type_id, 'wp_rem_image_gallery_element', true);

            if ($wp_rem_image_gallery_element == 'on') {
                $property_pic_num = get_post_meta($property_id, 'wp_rem_transaction_property_pic_num', true);
                if ($property_pic_num != '' && $property_pic_num > 0 && is_numeric($property_pic_num)) {
                    $gallery_ids = get_post_meta($property_id, 'wp_rem_detail_page_gallery_ids', true);
                    if (is_array($gallery_ids) && sizeof($gallery_ids) > 0) {
                        foreach ($gallery_ids as $gallery_id) {
                            if ($gallery_id != '' && is_numeric($gallery_id) && wp_get_attachment_image_src($gallery_id)) {
                                $gallery_image_src = wp_get_attachment_image_src($gallery_id, $size, '', array('class' => $class));
                                if (!empty($gallery_image_src)) {
                                    $gallery_image = $gallery_image_src[0];
                                    $gallery_image_url = $gallery_image_src[0];
                                    $gallery_image_id = $gallery_id;
                                }
                                break;
                            }
                        }
                    }
                }
            }
        }
        if ($gallery_image == '') {
            $gallery_image = $default_image_src;
        }
        if ($gallery_image != '') {
            $image_class = '';
            if ($class != '') {
                $image_class = ' class="' . $class . '" ';
            }
            $alt_text = 'no-image';
            if ($gallery_image_id != '') {
                $alt_text = get_post_meta($gallery_image_id, '_wp_attachment_image_alt', true);
            }
            $gallery_image = '<img ' . $image_class . 'src="' . $gallery_image . '" alt="' . $alt_text . '"/>';
        }
        if ($return_type == 'url') {
            return $gallery_image_url;
        } else {
            return $gallery_image;
        }
    }

}

if (!function_exists('wp_rem_plugin_title_sub_align')) {
    /*
     * Element structure
     * Element title 
     * Element sub title
     * Element Title Alignment
     */

    function wp_rem_plugin_title_sub_align($title, $subtitle, $align, $title_style = '') {

        $element_title = isset($title) ? $title : '';
        $element_subtitle = isset($subtitle) ? $subtitle : '';
        $element_align = isset($align) ? $align : '';

        if (!empty($title_style)) {
            $title_style = ' ' . $title_style;
        }
        $element_html = '';
        if (!empty($element_title) || !empty($element_subtitle)) {
            $element_html .= '<div class="element-title ' . $align . ' ">';
            if (!empty($element_title)) {
                $element_html .= '<h2' . $title_style . '>' . $element_title . '</h2>';
            }
            if (!empty($element_subtitle)) {
                $element_html .= '<p>' . $element_subtitle . '</p>';
            }
            $element_html .= '</div>';
        }
        return $element_html;
    }

}

if (!function_exists('wp_rem_allow_large_joins')) {

    function wp_rem_allow_large_joins() {
        global $wpdb;
        $wpdb->query('SET SQL_BIG_SELECTS=1');
    }

    add_action('init', 'wp_rem_allow_large_joins');
}
if (!function_exists('wp_rem_cs_inline_enqueue_script')) {

    function wp_rem_cs_inline_enqueue_script($script = '', $script_handler = 'wp-rem-custom-inline') {
        wp_register_script('wp-rem-custom-inline', trailingslashit(get_template_directory_uri()) . 'assets/common/js/custom-inline.js', '', '', true);
        wp_enqueue_script('wp-rem-custom-inline');
        wp_add_inline_script('wp-rem-custom-inline', $script);
    }

}

function kk_if_show_price( $property_id ){
    $price = get_post_meta($property_id, 'wp_rem_property_price', true);
    $price_ttd = get_post_meta($property_id, 'wp_rem_property_price_ttd', true);
    return $price != '' || $price_ttd != '';
}

function wp_rem_property_price($property_id, $wp_rem_property_price = '', $guidprice_before = '', $guidprice_after = '', $price_type_before = '<span class="price-type">', $price_type_after = '</span>', $price_type_position = 'right') {
    global $wp_rem_plugin_options;

    $property_info_price = '';
    $price_line_1 = '';
    $price_line_2 = '';
    $price_type = get_post_meta($property_id, 'wp_rem_price_type', true);
    $price = get_post_meta($property_id, 'wp_rem_property_price', true);
    $price_ttd = get_post_meta($property_id, 'wp_rem_property_price_ttd', true);

    if ($price_type == 'variant_month' || $price_type == 'variant_week') {

        // RENT PRICE
       
        $price_label = ( $price_type == 'variant_week') ? 'per week' : 'per month';

        // Rent - USD
        if ($price) {
            $price_line_1 = '<div>Rental Price USD ' . wp_rem_get_currency( $price, true );
            $price_line_1 .= ' (' . $price_label . ')</div>';
        }
        
        // Rent - TTD
        if ($price_ttd) {
            $price_line_2 = '<div>Rental Price TTD ' . wp_rem_get_currency($price_ttd, true);
            $price_line_2 .= ' (' . $price_label . ')</div>';
        }

        $property_info_price = $price_line_1 . $price_line_2;

    } else {

        // SALE PRICE

        // get fixed price type
        if (isset($wp_rem_plugin_options['fixed_price_opt'][$price_type])) {
            $_price_type = ' ' . $price_type_before . $wp_rem_plugin_options['fixed_price_opt'][$price_type] . $price_type_after;
        }
        
        // Sale - USD
        if ($price) {
            $price_line_1 = '<div>Sale Price USD ' . wp_rem_get_currency($price, true) . '</div>';
        }

        // Sale - TTD
        if ($price_ttd) {
            $price_line_2 = '<div>Sale Price TTD ' . wp_rem_get_currency($price_ttd, true) . '</div>';
        }

        if ($price || $price_ttd) {
            $property_info_price = $price_line_1 . $price_line_2;
            $property_info_price .= '<span>' . $_price_type . '</span>';
        }

    }

    return $property_info_price;
}

// kinolanka - backup 
function wp_rem_property_price_old($property_id, $wp_rem_property_price, $guidprice_before = '', $guidprice_after = '', $price_type_before = '<span class="price-type">', $price_type_after = '</span>', $price_type_position = 'right') {
    global $wp_rem_plugin_options;

    $price_type = get_post_meta($property_id, 'wp_rem_price_type', true);
    $price_monthy = get_post_meta($property_id, 'wp_rem_month_price', true);
    $price_monthy_ttd = get_post_meta($property_id, 'wp_rem_month_price_ttd', true);
    $price_weekly = get_post_meta($property_id, 'wp_rem_week_price', true);
    $price_weekly_ttd = get_post_meta($property_id, 'wp_rem_week_price_ttd', true);
    if ($price_type == 'variant_month' || $price_type == 'variant_week') {
        $price_type_ = ' ' . wp_rem_plugin_text_srt('wp_rem_price_type_pcm');
        $price_type_ttd = $price_type_;
        $price_type_ttd .= $guidprice_before . ' (' . wp_rem_get_currency($price_weekly_ttd, true) . ' ' . wp_rem_plugin_text_srt('wp_rem_price_type_pw') . ')' . $guidprice_after;
        $price_type_ .= $guidprice_before . ' (' . wp_rem_get_currency($price_weekly, true) . ' ' . wp_rem_plugin_text_srt('wp_rem_price_type_pw') . ')' . $guidprice_after;
        $wp_rem_property_price = $price_monthy;
        $wp_rem_property_price_ttd = $price_monthy_ttd;
    } else {
        if (isset($wp_rem_plugin_options['fixed_price_opt'][$price_type])) {
            $price_type_ = ' ' . $price_type_before . $wp_rem_plugin_options['fixed_price_opt'][$price_type] . $price_type_after;
        }
    }
    if ($price_type_position == 'left') {
        $property_info_price = $price_type_;
        $property_info_price .= wp_rem_get_currency($wp_rem_property_price, true);
        $property_info_price .= ' ' . wp_rem_get_currency($wp_rem_property_price_ttd, true);
    } else {
        if ($price_type == 'variant_month' || $price_type == 'variant_week') {
            if ($wp_rem_property_price) {
                $property_info_price = '<div>Rental Price USD ' . wp_rem_get_currency($wp_rem_property_price, true);
                $property_info_price .= $price_type_ . '</div>';
            }
            if ($wp_rem_property_price_ttd) {
                $property_info_price .= '<div>Rental Price TTD ' . wp_rem_get_currency($wp_rem_property_price_ttd, true);
                $property_info_price .= $price_type_ttd . '</div>';
            }
        } else {
            $wp_rem_property_price = '';
            $property_info_price = '';
            $wp_rem_property_price = get_post_meta($property_id, 'wp_rem_property_price', true);
            $wp_rem_property_price_ttd = get_post_meta($property_id, 'wp_rem_property_price_ttd', true);

            if ($wp_rem_property_price) {
                $property_info_price = '<div>Sale Price USD ' . wp_rem_get_currency($wp_rem_property_price, true) . '</div>';
            }
            if ($wp_rem_property_price_ttd) {
                $property_info_price .= '<div>Sale Price TTD ' . wp_rem_get_currency($wp_rem_property_price_ttd, true) . '</div>';
            }
            if ($wp_rem_property_price || $wp_rem_property_price_ttd) {
                $property_info_price .= '<span>' . $price_type_ . '</span>';
            }
        }
    }

    return $property_info_price;
}

if (!function_exists('wp_rem_set_user_type_cookie_callback')) {

    function wp_rem_set_user_type_cookie_callback() {
        $member_user_type = isset($_POST['member_user_type']) ? $_POST['member_user_type'] : 'reseller';
        wp_rem_set_transient_obj('member_user_type', $member_user_type);
        echo $member_user_type;
        wp_die();
    }

}

add_action('wp_ajax_wp_rem_set_user_type_cookie', 'wp_rem_set_user_type_cookie_callback');
add_action('wp_ajax_nopriv_wp_rem_set_user_type_cookie', 'wp_rem_set_user_type_cookie_callback');


if (!function_exists('wp_rem_set_user_tab_cookie_callback')) {

    function wp_rem_set_user_tab_cookie_callback() {
        $member_user_tab = isset($_POST['member_user_tab']) ? $_POST['member_user_tab'] : 'login';
        wp_rem_set_transient_obj('member_user_tab', $member_user_tab);
        echo $member_user_tab;
        wp_die();
    }

}

add_action('wp_ajax_wp_rem_set_user_tab_cookie', 'wp_rem_set_user_tab_cookie_callback');
add_action('wp_ajax_nopriv_wp_rem_set_user_tab_cookie', 'wp_rem_set_user_tab_cookie_callback');

if (!function_exists('wp_rem_term_condition_form_field')) {

    function wp_rem_term_condition_form_field($field_id = 'term_policy', $field_name = 'term_policy') {
        global $wp_rem_plugin_options, $wp_rem_form_fields_frontend;

        $wp_rem_term_policy_switch = isset($wp_rem_plugin_options['wp_rem_term_policy_switch']) ? $wp_rem_plugin_options['wp_rem_term_policy_switch'] : '';
        $wp_rem_term_policy_description = isset($wp_rem_plugin_options['wp_rem_term_policy_description']) ? $wp_rem_plugin_options['wp_rem_term_policy_description'] : '';
        if ($wp_rem_term_policy_switch == 'on') {
            ?>
            <div class="check-box-remind">
                <?php
                $wp_rem_opt_array = array(
                    'std' => '',
                    'simple' => true,
                    'cust_id' => esc_html($field_id),
                    'cust_name' => esc_html($field_name),
                    'classes' => 'input-field',
                );
                $wp_rem_form_fields_frontend->wp_rem_form_checkbox_render($wp_rem_opt_array);
                ?>
                <label for="<?php echo esc_html($field_id); ?>"><?php echo htmlspecialchars_decode($wp_rem_term_policy_description); ?></label>
            </div> 
            <?php
        }
    }

}
if (!function_exists('wp_rem_verify_term_condition_form_field')) {

    function wp_rem_verify_term_condition_form_field($field_name = 'term_policy') {

        global $wp_rem_plugin_options;
        $wp_rem_term_policy_switch = isset($wp_rem_plugin_options['wp_rem_term_policy_switch']) ? $wp_rem_plugin_options['wp_rem_term_policy_switch'] : '';
        if ($wp_rem_term_policy_switch == 'on') {
            $term_policy_checkbox = wp_rem_get_input($field_name, '', 'STRING');
            if (empty($term_policy_checkbox) || $term_policy_checkbox != 'on') {
                $response_array = array(
                    'type' => 'error',
                    'msg' => wp_rem_plugin_text_srt('wp_rem_helper_read_terms_conditions')
                );
                echo json_encode($response_array);
                exit();
            }
        }
    }

}


if (!function_exists('wp_rem_plublisher_properties_increment_callback')) {

    function wp_rem_plublisher_properties_increment_callback($member_id = '') {

        if ($member_id == '') {
            $user_id = get_current_user_id();
            $member_id = get_user_meta($user_id, 'wp_rem_company', true);
        }

        $wp_rem_num_of_properties = get_post_meta($member_id, 'wp_rem_num_of_properties', true);
        $wp_rem_num_of_properties ++;
        update_post_meta($member_id, 'wp_rem_num_of_properties', $wp_rem_num_of_properties);
    }

    add_action('wp_rem_plublisher_properties_increment', 'wp_rem_plublisher_properties_increment_callback', 10, 1);
}

if (!function_exists('wp_rem_plublisher_properties_decrement_callback')) {

    function wp_rem_plublisher_properties_decrement_callback($member_id = '') {

        if ($member_id == '') {
            $user_id = get_current_user_id();
            $member_id = get_user_meta($user_id, 'wp_rem_company', true);
        }

        $wp_rem_num_of_properties = get_post_meta($member_id, 'wp_rem_num_of_properties', true);
        if ($wp_rem_num_of_properties > 0) {
            $wp_rem_num_of_properties --;
        }
        update_post_meta($member_id, 'wp_rem_num_of_properties', $wp_rem_num_of_properties);
    }

    add_action('wp_rem_plublisher_properties_decrement', 'wp_rem_plublisher_properties_decrement_callback', 10, 1);
}

if (!function_exists('wp_rem_calculate_price')) {

    function wp_rem_calculate_price($price, $calculate_by) {
        $return_price = $price;
        if ($calculate_by == 'monthly') {
            $return_price = $price * 52 / 12;
        }
        if ($calculate_by == 'weekly') {
            $return_price = $price * 12 / 52;
        }
        return $return_price;
    }

}

function kk_get_price_filter_values( $property_type_id, $placeholder ){
    $use_default = false;
    $price_numbers = get_post_meta( $property_type_id, 'wp_rem_price_filter_interval', true );
    if( !empty( $price_numbers ) ){
        $price_numbers = kk_format_user_price_numbers( $price_numbers );
        if( !empty( $price_numbers ) ){
            $price_first = array( '' => $placeholder );
            end($price_numbers);
            $last_key = key($price_numbers);
            reset($price_numbers);
            $last = $price_numbers[$last_key];
            $price_last = array( '>'.$last => $last );
            $price_arr = $price_first + $price_numbers + $price_last;
        } else $use_default = true;
    } else $use_default = true;

    if( $use_default) {
        // some random array
        $price_arr = array(
            '' => $placeholder,
            '500' => 500,
            '1000' => 1000,
            '1500' => 1500,
            '2500' => 2500,
            '3500' => 3500,
            '4500' => 4500,
            '5500' => 5500,
            '6500' => 6500,
            '7500' => 7500,
            '8500' => 8500,
            '9500' => 9500,
            '>9500' => 9500
        );
    }
    return $price_arr;    
}

function kk_format_user_price_numbers ( $price_numbers ){
    $raw = explode(',', $price_numbers);
    $result = array();
    foreach( $raw as $value ) {
       if( is_integer( (int) trim($value) ) ){
            $result[$value] = $value;
       }
    }
    return $result;
}
    


if (!function_exists('wp_rem_property_detail_page_view')) {

    function wp_rem_property_detail_page_view($property_id = '') {
        global $wp_rem_plugin_options;
        $default_property_detail_view = isset($wp_rem_plugin_options['wp_rem_property_detail_page_view']) ? $wp_rem_plugin_options['wp_rem_property_detail_page_view'] : '';

        $wp_rem_property_type = get_post_meta($property_id, 'wp_rem_property_type', true);
        if ($post = get_page_by_path($wp_rem_property_type, OBJECT, 'property-type')) {
            $property_type_id = $post->ID;
        } else {
            $property_type_id = 0;
        }
        $property_detail_view = get_post_meta($property_id, 'wp_rem_property_detail_page', true);
        $property_type_detail_view = get_post_meta($property_type_id, 'wp_rem_property_detail_page', true);

        if ($property_detail_view != '') {
            $view = $property_detail_view;
        } elseif ($property_type_detail_view) {
            $view = $property_type_detail_view;
        } else {
            $view = $default_property_detail_view;
        }
        return $view;
    }

}

if (!function_exists('wp_rem_create_property_button_callback')) {
    add_action('wp_rem_create_property_button', 'wp_rem_create_property_button_callback', 10, 1);

    function wp_rem_create_property_button_callback($text_show = 'true') {
        global $wp_rem_plugin_options;
        $create_property_label = wp_rem_plugin_text_srt('wp_rem_rem_create_list_text');
        if ($text_show == 'false') {
            $create_property_label = '';
        }
        $wp_rem_create_listing_button = isset($wp_rem_plugin_options['wp_rem_create_listing_button']) ? $wp_rem_plugin_options['wp_rem_create_listing_button'] : '';
        $wp_rem_create_property_page = isset($wp_rem_plugin_options['wp_rem_create_property_page']) ? $wp_rem_plugin_options['wp_rem_create_property_page'] : '';
        if ($wp_rem_create_listing_button == 'on' && $wp_rem_create_property_page) {
            echo '<div class="header-add-property input-button-loader"> ';
            echo '<a href="' . esc_url(get_permalink($wp_rem_create_property_page)) . '" class="property-btn">' . $create_property_label . '</a>';
            echo '</div>';
        }
        $wp_rem_cs_inline_script = '
        jQuery(document).ready(function () {
            jQuery(document).on("click", ".header-add-property .property-btn", function() {
                var thisObj = jQuery(".header-add-property");
                wp_rem_show_loader(".header-add-property", "", "button_loader", thisObj);
            });
        });';
        wp_rem_cs_inline_enqueue_script($wp_rem_cs_inline_script, 'wp-rem-custom-inline');
    }

}

if (!function_exists('wp_rem_property_search_reset_field')) {

    function wp_rem_property_search_reset_field($qrystr = '', $page_url = '', $exclude_field_key = '', $exclude_field_val = '') {
        //get all query string
        $select_exclude_field_val = (isset($qrystr[$exclude_field_key]) && $qrystr[$exclude_field_key] != '') ? $qrystr[$exclude_field_key] : '';
        if (isset($qrystr) && $select_exclude_field_val != '') {
            $flag = 1;
            $qrystr = array_filter($qrystr);
            $concat = '?';
            $url = '';
            foreach ($qrystr as $qry_var => $qry_val) {
                if ($qry_val != '' && $exclude_field_key != $qry_var && $qry_var != 'view_type' && $qry_var != 'property_arg' && $qry_var != 'property_page' && $qry_var != 'action') {
                    $url .= $concat . $qry_var . '=' . $qry_val;
                    $concat = '&amp;';
                }
            }
            if ($url != '') {
                echo '<a class="reset-field" data-toggle="tooltip" title="' . wp_rem_plugin_text_srt('wp_rem_properties_reset') . '" href="' . esc_url($page_url . $url) . '"><i class="icon icon-refresh3"></i></a>';
            } else {
                echo '<a class="reset-field" data-toggle="tooltip" title="' . wp_rem_plugin_text_srt('wp_rem_properties_reset') . '" href="' . esc_url($page_url) . '"><i class="icon icon-refresh3"></i></a>';
            }
        }
    }

}



if (!function_exists('wp_rem_gallery_photo_render')) {

    function wp_rem_gallery_photo_render() {

        $property_id = wp_rem_get_input('property_id');
        $number_of_gallery_items = get_post_meta($property_id, 'wp_rem_detail_page_gallery_ids', true);
        $gallery_pics_allowed = get_post_meta($property_id, 'wp_rem_transaction_property_pic_num', true);
        $count_all = ( isset($number_of_gallery_items) && is_array($number_of_gallery_items) && sizeof($number_of_gallery_items) > 0 ) ? count($number_of_gallery_items) : 0;
        if ($count_all > $gallery_pics_allowed) {
            $count_all = $gallery_pics_allowed;
        }
        // galley prettyphotp start
        $all_img = '';
        $display_none = true;
        if (isset($number_of_gallery_items) && !empty($number_of_gallery_items)) {
            foreach ($number_of_gallery_items as $key => $value) {
                $url_imge = wp_get_attachment_url($value);
                $style = '';
                $tooltip = '';
                $trigger_class = '';
                if ($display_none) {
                    $trigger_class = ' class="btnnn' . $property_id . '" ';
                    $tooltip = '<div class="info-content"><span>' . wp_rem_plugin_text_srt('wp_rem_element_tooltip_icon_camera') . '</span></div>';
                }
                if (!$display_none) {
                    $style = ' style="display:none;"';
                }



                $display_none = false;
                $all_img .= '<li><a  ' . $trigger_class . $style . ' href="' . esc_url($url_imge) . '" rel="prettyPhoto[gal' . absint($property_id) . ']" ><span class="capture-count"><i class="icon-camera6"></i>' . absint($count_all) . '</span>' . $tooltip . '</a> </li>';
            }
        }

        echo json_encode($all_img);
        // End galley prettyphotp start
        wp_die();
    }

    add_action('wp_ajax_wp_rem_gallery_photo_render', 'wp_rem_gallery_photo_render', 1);
    add_action('wp_ajax_nopriv_wp_rem_gallery_photo_render', 'wp_rem_gallery_photo_render', 1);
}

if (!function_exists('wp_rem_find_in_multiarray')) {

    function wp_rem_find_in_multiarray($elem, $array, $field) {

        $top = sizeof($array);
        $k = 0;
        $new_array = array();
        for ($i = 0; $i <= $top; $i ++) {
            if (isset($array[$i])) {
                $new_array[$k] = $array[$i];
                $k ++;
            }
        }
        $array = $new_array;
        $top = sizeof($array) - 1;
        $bottom = 0;

        $finded_index = '';
        if (is_array($array)) {
            while ($bottom <= $top) {
                if (isset($array[$bottom][$field]) && $array[$bottom][$field] == $elem)
                    $finded_index[] = $bottom;
                else
                if (isset($array[$bottom][$field]) && is_array($array[$bottom][$field]))
                    if (wp_rem_find_in_multiarray($elem, ($array[$bottom][$field])))
                        $finded_index[] = $bottom;
                $bottom ++;
            }
        }
        return $finded_index;
    }

}
if (!function_exists('wp_rem_property_hide_submit_callback')) {
    add_action('wp_ajax_wp_rem_property_hide_submit', 'wp_rem_property_hide_submit_callback', 11);

    /**
     * Member Favourites
     * @ added member favourites based on property id
     */
    function wp_rem_property_hide_submit_callback() {

        $property_id = wp_rem_get_input('property_id');
        $member_id = wp_rem_get_input('member_id');
        $property_short_counter = wp_rem_get_input('property_short_counter');
        $current_user = wp_get_current_user();
        $response = $member_hide_property_list = array();

        if ('' != $member_id) {
            $user_company = get_user_meta($member_id, 'wp_rem_company', true);
            $member_hide_property_list = get_post_meta($user_company, 'wp_rem_property_hide_list', true);
            if (!empty($member_hide_property_list) && wp_rem_find_in_multiarray($property_id, $member_hide_property_list, 'property_id')) {
                $response['status'] = false;
            } else {
                $member_hide_property_list[] = array(
                    'property_id' => $property_id,
                    'date' => strtotime(date('d-m-Y')),
                );
                $response['status'] = true;
                $hide_list_html = '';
                $hide_list_html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
                $hide_list_html .= '<div class="text-holder">
                                            <strong class="post-title"> 
                                                <span class="hidden-result-label">'.wp_rem_plugin_text_srt('wp_rem_properties_hidden_text').'</span>
                                                <a href="' . esc_url(get_permalink($property_id)) . '">' . esc_html(get_the_title($property_id)) . '</a>                  
                                            </strong> 
                                            </div>';
                $hide_list_html .= '</div>';
                $response['new_element'] = $hide_list_html;
            }
            if (!empty($member_hide_property_list)) {
                $member_hide_property_list = array_values($member_hide_property_list);
            }
            update_post_meta($user_company, 'wp_rem_property_hide_list', $member_hide_property_list);
        } else {
            $response['status'] = false;
        }
        echo json_encode($response);

        wp_die();
    }

}

if (!function_exists('wp_rem_removed_hidden_properties')) {
    add_action('wp_ajax_wp_rem_removed_hidden_properties', 'wp_rem_removed_hidden_properties_callback', 11);

    function wp_rem_removed_hidden_properties_callback() {

        $property_id = wp_rem_get_input('property_id');
        $current_user = wp_get_current_user();
        $member_id = get_current_user_id();
        $user_data = get_user_info_array();
        $response = array();
        $response['status'] = false;
        if ('' != $property_id && '' != $member_id) {
            $user_company = get_user_meta($member_id, 'wp_rem_company', true);
            $member_favourites = get_post_meta($user_company, 'wp_rem_property_hide_list', true);
            foreach ($member_favourites as $key => $sub_array) {
                if ($sub_array['property_id'] == $property_id) {
                    unset($member_favourites[$key]);
                    $response['status'] = true;
                    $response['message'] = wp_rem_plugin_text_srt('wp_rem_favourite_delete_successfully');
                }
            }
            if (!empty($member_favourites)) {
                $member_favourites = array_values($member_favourites);
            }
            update_post_meta($user_company, 'wp_rem_property_hide_list', $member_favourites);
            $response['property_count'] = $property_favourites;

        }
        echo json_encode($response);
        wp_die();
    }

}

if (!function_exists('wp_rem_hex2rgba')) {

    function wp_rem_hex2rgba($color, $opacity = false) {

        $default = 'rgb(0,0,0)';
        //Return default if no color provided
        if (empty($color))
            return $default;

        //Sanitize $color if "#" is provided 
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
            $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
        } elseif (strlen($color) == 3) {
            $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
        } else {
            return $default;
        }

        //Convert hexadec to rgb
        $rgb = array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if ($opacity) {
            if (abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
        } else {
            $output = 'rgb(' . implode(",", $rgb) . ')';
        }

        //Return rgb(a) color string
        return $output;
    }

}