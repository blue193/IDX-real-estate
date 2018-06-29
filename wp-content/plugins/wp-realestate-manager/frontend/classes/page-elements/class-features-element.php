<?php
/**
 * File Type: Features Element
 */
if ( ! class_exists('wp_rem_features_element') ) {

    class wp_rem_features_element {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action('wp_rem_features_element_html', array( $this, 'wp_rem_features_element_html_callback' ), 11, 1);
            add_action('wp_rem_nearby_element_html', array( $this, 'wp_rem_nearby_element_html_callback' ), 11, 1);
            add_action('wp_rem_property_video_html', array( $this, 'wp_rem_property_video_html_callback' ), 11, 1);
            add_action('wp_rem_property_apartment_html', array( $this, 'wp_rem_property_apartment_html_callback' ), 11, 1);
        }

        public function wp_rem_property_apartment_html_callback($post_id) {


            $wp_rem_apartments = get_post_meta($post_id, 'wp_rem_apartment', true);

            if ( is_array($wp_rem_apartments) && $wp_rem_apartments != '' ) {
                ?>
                <div id="apartments" class="apartment-list">
                    <div class="element-title">
                        <h3><?php echo wp_rem_plugin_text_srt('wp_rem_features_apartment_for_sale'); ?></h3>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead style="background:#e7e7e7; color:#fff;">
                                <tr>
                                    <th><?php echo wp_rem_plugin_text_srt('wp_rem_features_plot'); ?></th>
                                    <th><?php echo wp_rem_plugin_text_srt('wp_rem_features_beds'); ?></th>
                                    <th><?php echo wp_rem_plugin_text_srt('wp_rem_features_price_from'); ?></th>
                                    <th><?php echo wp_rem_plugin_text_srt('wp_rem_features_floor'); ?></th>
                                    <th><?php echo wp_rem_plugin_text_srt('wp_rem_features_building_address'); ?></th>
                                    <th><?php echo wp_rem_plugin_text_srt('wp_rem_features_availability'); ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ( isset($wp_rem_apartments) && is_array($wp_rem_apartments) ) {
                                    foreach ( $wp_rem_apartments as $apartment_key => $apartment_value ) {
                                        $apartment_plot = isset($apartment_value['apartment_plot']) ? $apartment_value['apartment_plot'] : '';
                                        $apartment_beds = isset($apartment_value['apartment_beds']) ? $apartment_value['apartment_beds'] : '';
                                        $apartment_price_from = isset($apartment_value['apartment_price_from']) ? $apartment_value['apartment_price_from'] : '';
                                        $apartment_floor = isset($apartment_value['apartment_floor']) ? $apartment_value['apartment_floor'] : '';
                                        $apartment_address = isset($apartment_value['apartment_address']) ? $apartment_value['apartment_address'] : '';
                                        $apartment_availability = isset($apartment_value['apartment_availability']) ? $apartment_value['apartment_availability'] : '';
                                        $apartment_link = isset($apartment_value['apartment_link']) ? $apartment_value['apartment_link'] : '';
                                        if ( $apartment_availability == 'available' ) {
                                            $apartment_availability = wp_rem_plugin_text_srt('wp_rem_features_available');
                                        } elseif ( $apartment_availability == 'unavailable' ) {
                                            $apartment_availability = wp_rem_plugin_text_srt('wp_rem_features_not_available');
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo esc_html($apartment_plot); ?></td>
                                            <td><?php echo esc_html($apartment_beds); ?></td>
                                            <td><?php echo esc_html(wp_rem_get_currency_sign() . $apartment_price_from); ?></td>
                                            <td><?php echo esc_html($apartment_floor); ?></td>
                                            <td><?php echo esc_html($apartment_address); ?></td>
                                            <td><?php echo ucfirst($apartment_availability); ?></td>
                                            <td><a class="view-btn" href="<?php echo esc_url($apartment_link); ?>"><?php echo wp_rem_plugin_text_srt('wp_rem_features_view'); ?></a></td>
                                        </tr>
                                    <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
            }
        }

        public function wp_rem_property_video_html_callback($post_id) {
            wp_enqueue_script('fitvids');
            $wp_rem_property_video = get_post_meta($post_id, 'wp_rem_property_video', true);
            $wp_rem_property_image = get_post_meta($post_id, 'wp_rem_property_image', true);
            $img_url = wp_get_attachment_url($wp_rem_property_image);
            $img_url = isset($img_url) ? $img_url : '';
            $video_id = $wp_rem_property_video;
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $wp_rem_property_video, $match)) {
                $video_id = $match[1];
            }

            if ( isset($wp_rem_property_video) && $wp_rem_property_video != '' ) {
                ?>
                <div id="video" class="video-holder">
                    <div class="element-title">
                        <h3><?php echo wp_rem_plugin_text_srt('wp_rem_features_property_video'); ?></h3>
                    </div>
                    <div class="video-fit-holder">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $video_id ?>" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>		
                <?php
                $wp_rem_cs_inline_script = '
                        jQuery(document).ready(function () {
                            if (jQuery(".video-holder").length != "") {
                                jQuery(".video-holder").fitVids();
                            }
                        });';
                wp_rem_cs_inline_enqueue_script($wp_rem_cs_inline_script, 'wp-rem-custom-inline');
            }
        }

        /*
         * Output features html for frontend on property detail page.
         */

        public function wp_rem_features_element_html_callback($post_id) {
            $features_list = get_post_meta($post_id, 'wp_rem_property_feature_list', true);

            $property_type_slug = get_post_meta($post_id, 'wp_rem_property_type', true);
            $property_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish' ));

            $property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
            $type_features_not_selected = get_post_meta($property_type_id, 'wp_rem_enable_not_selected', true);
            $type_features = get_post_meta($property_type_id, 'feature_lables', true);

            if ( ! empty($features_list) || $type_features_not_selected == 'on' ) {
                ?>
                <div id="features" class="category-holder">
                    <div class="element-title">
                        <h3><?php echo wp_rem_plugin_text_srt('wp_rem_property_property_amenities'); ?></h3>
                    </div>
                    <?php
                }

                $wp_rem_feature_icon = get_post_meta($property_type_id, 'wp_rem_feature_icon', true);
                $wp_rem_feature_icon_group = get_post_meta($property_type_id, 'wp_rem_feature_icon_group', true);
                $type_features_not_selected = get_post_meta($property_type_id, 'wp_rem_enable_not_selected', true);
                if ( $type_features_not_selected != 'on' ) {
                    if ( isset($features_list) && ! empty($features_list) ) {
                        $html = '';
                        $html .= '<ul class="category-list">';
                        foreach ( $features_list as $feature_data ) {
                           
                            $icon = '';
                            $feature_exploded = explode("_icon", $feature_data);
                            $features_data_name = isset($feature_exploded[0]) ? $feature_exploded[0] : '';
                            $feature_icon       = isset($feature_exploded[1]) ? $feature_exploded[1] : '';
                            $feature_icon_group = isset($feature_exploded[2]) ? $feature_exploded[2] : 'default';
                            if ( $feature_icon != '' && $feature_icon != ' ' ) {
                                wp_enqueue_style('cs_icons_data_css_'.$feature_icon_group );
                                $feature_icon = ' <i class="' . $feature_icon . '"></i>';
                            }
                            $html .= '<li class="col-lg-4 col-md-4 col-sm-6 col-xs-12">' . $feature_icon . $features_data_name . '</li>';
                        }
                        $html .= '</ul>';
                        echo force_balance_tags($html);
                    }
                } else {
                    $html = '';
                    if ( isset($type_features) && ! empty($type_features) ) {
                        $html .= '<ul class="category-list">';
                        foreach ( $type_features as $key => $label ) {
                            $feature_icon = isset($wp_rem_feature_icon[$key]) ? $wp_rem_feature_icon[$key] : '';
                            $feature_icon_group = isset($wp_rem_feature_icon_group[$key]) ? $wp_rem_feature_icon_group[$key] : 'default';
                            if ( $feature_icon != '' && $feature_icon != ' ' ) {
                                wp_enqueue_style('cs_icons_data_css_'.$feature_icon_group );
                                $feature_icon = ' <i class="' . $feature_icon . '"></i>';
                            }
                            $icon = '';
                            if ( isset($features_list) && !empty($features_list) ) {
                                foreach ( $features_list as $feature_data ) {
                                    $feature_exploded = explode("_icon", $feature_data);

                                    $features_data_name = isset($feature_exploded[0]) ? $feature_exploded[0] : '';

                                    if ( $features_data_name == $label ) {
                                        $icon = 'icon-check';
                                        break;
                                    } else {
                                        $icon = 'icon-cross';
                                    }
                                }
                            } else {
                                $icon = 'icon-cross';
                            }
                            $html .= '<li class="col-lg-4 col-md-4 col-sm-6 col-xs-12">' . $feature_icon . '<i class="' . $icon . '"></i></i>' . $label . '</li>';
                        }
                        $html .= '</ul>';
                        echo force_balance_tags($html);
                    }
                }
                if ( ! empty($features_list) || $type_features_not_selected == 'on' ) {
                    ?>
                </div>
                <?php
            }
        }

        public function wp_rem_nearby_element_html_callback($post_id) {

            $near_by_array = get_post_meta($post_id, 'wp_rem_near_by', true);
            $wp_rem_post_loc_address_property = get_post_meta($post_id, 'wp_rem_post_loc_address_property', true);
            $html = '';

            if ( isset($near_by_array) && $near_by_array != '' && is_array($near_by_array) ) {
                $html .= '<div id="maps-nearby" class="location-holder">';
                $html .= '<div class="element-title">
			<h3>' . wp_rem_plugin_text_srt('wp_rem_features_what_near_by') . '</h3>
		</div>';
                $html .= '<ul class="location-list">';
                $count = 1;
                foreach ( $near_by_array as $key => $near_by ) {
                    $nearby_image_url = wp_get_attachment_url($near_by['near_by_image']);

                    $html .=' <script type="text/javascript">
			var source = 0;
		    	var destination = 0;
		    	source = "' . $wp_rem_post_loc_address_property . '";
		    	destination = "' . $near_by["near_by_description"] . '";
		    	var service = new google.maps.DistanceMatrixService();
		    	service.getDistanceMatrix({
		    	    origins: [source],
		    	    destinations: [destination],
		    	    travelMode: google.maps.TravelMode.DRIVING,
		    	    unitSystem: google.maps.UnitSystem.METRIC,
		    	    avoidHighways: false,
		    	    avoidTolls: false
		    	}, function (response, status) {
		    	    console.log(response);
		    	    if (status == google.maps.DistanceMatrixStatus.OK && response.rows[0].elements[0].status != "ZERO_RESULTS") {
		    		var distance = response.rows[0].elements[0].distance.text;
		    		var duration = response.rows[0].elements[0].duration.text;
				 total = distance.replace("km" ," ");
				 total = total.replace("," ,"");
				 totald = total*.621371;
				jQuery("#add-miles' . $count . '").html((totald.toFixed(2)) + " ' . wp_rem_plugin_text_srt('wp_rem_features_miles_away') . '");
				} else {
		    		jQuery("#add-miles' . $count . '").html("' . wp_rem_plugin_text_srt('wp_rem_features_unable_find_distance') . '");
		    	    }
		    	});
		    </script>';

                    $html.='<li class="col-lg-6 col-md-6 col-sm-6 col-xs-12">';
                    if ( isset($nearby_image_url) && $nearby_image_url != '' ) {
                        $html.='<img src="' . esc_url($nearby_image_url) . '" alt="" />';
                    }
                    if ( isset($near_by['near_by_title']) && $near_by['near_by_title'] != '' ) {
                        $html .=$near_by['near_by_title'];
                    }
                    if ( isset($near_by['near_by_description']) && $near_by['near_by_description'] != '' ) {
                        $html .='<span id="add-miles' . $count . '"></span>';
                    }
                    $html .='</li>';
                    $count ++;
                }
                $html .='</ul>';
                $html .='</div>';
                echo force_balance_tags($html);
            }
        }

    }

    global $wp_rem_features_element;
    $wp_rem_features_element = new wp_rem_features_element();
}