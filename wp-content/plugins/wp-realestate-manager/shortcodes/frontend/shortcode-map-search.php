<?php
/**
 * File Type: Searchs Shortcode Frontend
 */
if (!class_exists('Wp_rem_Shortcode_Map_Search_front')) {

    class Wp_rem_Shortcode_Map_Search_front {

        /**
         * Constant variables
         */
        var $PREFIX = 'map_search';

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_shortcode($this->PREFIX, array($this, 'wp_rem_map_search_shortcode_callback'));
            add_action('wp_ajax_wp_rem_top_map_search', array($this, 'map_search_query'));
            add_action('wp_ajax_nopriv_wp_rem_top_map_search', array($this, 'map_search_query'));
        }

        /*
         * Shortcode View on Frontend
         */

		public function wp_rem_map_search_shortcode_callback($atts, $content = "") {
			global $column_container, $wp_rem_form_fields_frontend, $wp_rem_plugin_options, $wp_rem_search_fields;
            wp_enqueue_script('wp_rem_location_autocomplete_js');
            wp_enqueue_script('wp-rem-google-map-api');
            $html = '';
            $main_sections_columns = json_encode($column_container);
            $main_sections_columns = json_decode($main_sections_columns, true);
            $main_sections_column = isset($main_sections_columns['@attributes']['wp_rem_cs_section_view']) ? $main_sections_columns['@attributes']['wp_rem_cs_section_view'] : 'wide';

            $map_search_title = isset($atts['map_search_title']) ? $atts['map_search_title'] : '';
            $map_search_subtitle = isset($atts['map_search_subtitle']) ? $atts['map_search_subtitle'] : '';
            $map_map_search_switch = isset($atts['map_map_search_switch']) ? $atts['map_map_search_switch'] : '';
            $map_map_search_height = isset($atts['map_map_search_height']) ? $atts['map_map_search_height'] : '400';
            $map_search_box_switch = isset($atts['map_search_box_switch']) ? $atts['map_search_box_switch'] : '';
            $map_search_result_page = isset($atts['map_search_result_page']) ? $atts['map_search_result_page'] : '';

            $propertysearch_title_switch = isset($atts['map_search_title_field_switch']) ? $atts['map_search_title_field_switch'] : '';
            $propertysearch_property_type_switch = isset($atts['map_search_property_type_field_switch']) ? $atts['map_search_property_type_field_switch'] : '';
            $propertysearch_location_switch = isset($atts['map_search_location_field_switch']) ? $atts['map_search_location_field_switch'] : '';
            $propertysearch_categories_switch = isset($atts['map_search_categories_field_switch']) ? $atts['map_search_categories_field_switch'] : '';
            $propertysearch_price_switch = isset($atts['map_search_price_field_switch']) ? $atts['map_search_price_field_switch'] : '';
            $split_map = isset($atts['split_map']) ? $atts['split_map'] : false;
            $propertysearch_advance_filter_switch = isset($atts['map_search_advance_filter_switch']) ? $atts['map_search_advance_filter_switch'] : '';
            $property_types_array = array();
            $property_type_slug = '';

            $to_result_page = $map_search_result_page != '' ? get_permalink($map_search_result_page) : '';

            wp_enqueue_script('map-infobox');
            wp_enqueue_script('map-clusterer');

            $wp_rem_property_strings = array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'plugin_url' => wp_rem::plugin_url(),
                'alert_name' => wp_rem_plugin_text_srt('wp_rem_alerts_alert_name_title'),
                'alert_email' => wp_rem_plugin_text_srt('wp_rem_alerts_email_address'),
            );
            wp_localize_script('wp-rem-property-top-map', 'wp_rem_top_gmap_strings', $wp_rem_property_strings);
            wp_enqueue_script('wp-rem-property-top-map');
            ob_start();
            $rand_numb = rand(999, 999999);
            $atts['rand_numb'] = $rand_numb;
            $loc_polygon = '';
            if (isset($_REQUEST['loc_polygon']) && $_REQUEST['loc_polygon'] != '') {
                $loc_polygon = $_REQUEST['loc_polygon'];
            }
            $wp_rem_search_result_page = isset($wp_rem_plugin_options['wp_rem_search_result_page']) ? $wp_rem_plugin_options['wp_rem_search_result_page'] : '';
            $wp_rem_search_result_page = ( $wp_rem_search_result_page != '' ) ? get_permalink($wp_rem_search_result_page) : '';
            $map_div_classes = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
            if ($split_map == true) {
                $map_div_classes = 'col-lg-6 col-md-6 col-sm-12 col-xs-12 split-map-holder';
            }
            ?>
            <div class="<?php echo esc_attr($map_div_classes); ?>">
                <script>
                    var map = '';
                    var infoMarker = '';
                    var info_open_info_window = '';
                    var reset_top_map_marker = [];
                    var markerClusterers;
                </script>
                <form name="wp-rem-top-map-form" id="frm_property_arg<?php echo $rand_numb; ?>" action="<?php echo $wp_rem_search_result_page; ?>" data-id="<?php echo $rand_numb; ?>" >
                    <div style="display:none" id='atts'><?php
                        echo json_encode($atts);
                        ?>
                    </div>
                    <div id="wp-rem-top-map-holder" class="wp-rem-top-map-holder">
                        <?php
                        $search_box_class = '';
                        $has_map_box_class = '';
                        if ($map_map_search_switch == 'yes') {
                            $search_box_class = ' map-margin-top has-bg-color';
                            $has_map_box_class = ' has-map-search';

                            $draw_on_map_disable = '';
                            $draw_on_map_display = '';
                            $delete_on_map_display = 'display:none;';
                            if (( isset($_REQUEST['loc_polygon']) && $_REQUEST['loc_polygon'] != '' ) || ( isset($_REQUEST['location']) && $_REQUEST['location'] != '' )) {
                                $draw_on_map_disable = ' is-disabled';
                                $draw_on_map_display = 'display:none;';
                                $delete_on_map_display = '';
                            }
                            ?> 
                            <!-- start draw on map -->
                            <ul class="map-actions">

                                <?php
                                if (wp_is_mobile()) {
                                    ?>
                                    <li data-placement="bottom" data-toggle="tooltip" title="<?php echo wp_rem_plugin_text_srt('wp_rem_map_search_map_unlock'); ?>" id="top-gmap-lock-btn" class="top-gmap-lock-btn map-loked"><i class="icon-lock_outline"></i><!--<img src="<?php echo wp_rem::plugin_url() ?>assets/frontend/images/lock_on.svg" alt="">--></li>
                                    <?php
                                } else {
                                    ?>
                                    <li data-placement="bottom" data-toggle="tooltip" title="<?php echo wp_rem_plugin_text_srt('wp_rem_map_search_map_lock'); ?>" id="top-gmap-lock-btn" class="top-gmap-lock-btn map-unloked"><i class="icon-lock_open"></i><!--<img src="<?php echo wp_rem::plugin_url() ?>assets/frontend/images/lock.svg" alt="">--></li>
                                    <?php
                                }

                                $draw_visibility = '';
                                if (wp_is_mobile()) {
                                    $draw_visibility = ' style="visibility:hidden;"';
                                }
                                ?>
                                <li <?php echo ($draw_visibility) ?> class="map-draw-tools">
									<a data-placement="bottom" data-toggle="tooltip" style="<?php echo esc_html($draw_on_map_display) ?>" title="<?php echo wp_rem_plugin_text_srt('wp_rem_map_search_draw_on_map'); ?>" id="draw-map-<?php echo absint($rand_numb) ?>" class="act-btn draw-pencil-btn <?php echo esc_html($draw_on_map_disable) ?>"><i class="icon-pencil5"></i><span><?php echo wp_rem_plugin_text_srt('wp_rem_top_map_draw_btn'); ?></span><!--<img src="<?php echo wp_rem::plugin_url() ?>assets/frontend/images/draw.svg" alt="">--></a>
									<a data-placement="bottom" data-toggle="tooltip" style="<?php echo esc_html($delete_on_map_display) ?>" title="<?php echo wp_rem_plugin_text_srt('wp_rem_map_search_delete_area'); ?>" id="delete-button-<?php echo absint($rand_numb) ?>" class="act-btn delete-draw-area"><i class="icon-eraser"></i><span><?php echo wp_rem_plugin_text_srt('wp_rem_top_map_clear_btn'); ?></span><!--<img src="<?php echo wp_rem::plugin_url() ?>assets/frontend/images/delete_draw.svg" alt="">--></a>
									<a data-placement="bottom" data-toggle="tooltip" style="display: none;" title="<?php echo wp_rem_plugin_text_srt('wp_rem_map_search_cancel_drawing'); ?>" id="cancel-button-<?php echo absint($rand_numb) ?>" class="act-btn delete-draw-area"><i class="icon-eraser"></i><span><?php echo wp_rem_plugin_text_srt('wp_rem_top_map_clear_btn'); ?></span></a>
                                </li>
                            </ul>
                            <div id="property-records-<?php echo absint($rand_numb) ?>" class="property-records-sec" style="display: none;">
                                <p><span id="total-records-<?php echo absint($rand_numb) ?>">0</span>&nbsp;<?php echo wp_rem_plugin_text_srt('wp_rem_map_search_records_found'); ?></p>
                            </div>
                            <!-- end draw on map -->
                            <div class="wp-rem-top-gmap-holder">
                                <div class="slide-loader"></div>
                                <div class="wp-rem-ontop-gmap" id="wp-rem-ontop-gmap-<?php echo absint($rand_numb) ?>" style="height: <?php echo absint($map_map_search_height) ?>px; width:100%;"></div>
                                <div class="top-map-action-scr"><?php echo $this->map_search_query($atts) ?></div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="wp-rem-top-map-search<?php echo esc_html($has_map_box_class) ?>">
                            <?php
                            if ($map_search_box_switch == 'yes') {
                                // ONLY FOR RANGE SLIDER
                                wp_enqueue_style('wp_rem_bootstrap_slider_css');
                                wp_enqueue_script('wp-rem-bootstrap-slider');
                                if ($main_sections_column == 'wide') {
                                    echo '<div class="container">
									<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
                                }
                                $property_type = isset($_GET['property_type']) ? $_GET['property_type'] : '';
                                $search_title = isset($_GET['search_title']) ? $_GET['search_title'] : '';
                                $search_location = isset($_GET['location']) ? $_GET['location'] : '';
                                ?>
                                <div class="top-map-search-inner<?php echo esc_html($search_box_class) ?>"> 
                                    <div class="row">
                                        <div class="main-search modern">
                                            <div class="search-default-fields">
                                                <?php if ($propertysearch_title_switch == 'yes') { ?>
                                                    <div class="field-holder search-input">
                                                        <label>
                                                            <i class="icon-search4"></i>
                                                            <?php
                                                            $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                                                                    array(
                                                                        'cust_name' => 'search_title',
                                                                        'classes' => 'input-field',
                                                                        'extra_atr' => 'placeholder="' . wp_rem_plugin_text_srt('wp_rem_map_search_what_looking') . '"',
                                                                        'std' => ( isset($_REQUEST['search_title']) ? $_REQUEST['search_title'] : '' ),
                                                                    )
                                                            );
                                                            ?>   
                                                        </label>
                                                    </div>
                                                    <?php
                                                }
                                                if ($propertysearch_property_type_switch == 'yes') {
                                                    ?>
                                                    <div class="field-holder select-dropdown property-type checkbox"> 
                                                        <?php
                                                        $wp_rem_post_property_types = new Wp_rem_Post_Property_Types();
                                                        $property_types_array = $wp_rem_post_property_types->wp_rem_types_array_callback('NULL');
                                                        if (is_array($property_types_array) && !empty($property_types_array)) {
                                                            foreach ($property_types_array as $key => $value) {
                                                                $property_type_slug = $key;
                                                                break;
                                                            }
                                                        }
                                                        ?>
                                                        <ul>
                                                            <?php
                                                            $number_option_flag = 1;
                                                            foreach ($property_types_array as $key => $value) {
                                                                ?>
                                                                <li>
                                                                    <?php
                                                                    $checked = '';
                                                                    if (( (isset($_REQUEST['property_type']) && $_REQUEST['property_type'] != '') && $_REQUEST['property_type'] == $key ) || $property_type_slug == $key) {
                                                                        $checked = 'checked="checked"';
                                                                    }
                                                                    $wp_rem_form_fields_frontend->wp_rem_form_radio_render(
                                                                            array(
                                                                                'simple' => true,
                                                                                'cust_id' => 'search_form_property_type' . $number_option_flag,
                                                                                'cust_name' => 'property_type',
                                                                                'std' => $key,
                                                                                'extra_atr' => $checked . ' onchange="wp_rem_property_type_search_fields(this,\'' . $rand_numb . '\',\'' . $propertysearch_price_switch . '\'); wp_rem_property_type_cate_fields(this,\'' . $rand_numb . '\',\'' . $propertysearch_categories_switch . '\'); "',
                                                                            )
                                                                    );
                                                                    ?>
                                                                    <label for="<?php echo force_balance_tags('search_form_property_type' . $number_option_flag) ?>"><?php echo force_balance_tags($value); ?></label>
                                                                    <?php ?>
                                                                </li>
                                                                <?php
                                                                $number_option_flag ++;
                                                            }
                                                            ?>
                                                        </ul>  
                                                    </div>
                                                <?php } ?>
                                                <?php if ($propertysearch_location_switch == 'yes') { ?>
                                                    <div class="field-holder search-input">
                                                        <?php
                                                        $wp_rem_select_display = 1;
                                                        wp_rem_get_custom_locations_property_filter('<div id="wp-rem-top-select-holder" class="search-country" style="display:' . wp_rem_allow_special_char($wp_rem_select_display) . '"><div class="select-holder">', '</div></div>', false, $rand_numb, 'filter', 'maps', 'wp_rem_top_serach_trigger();');
                                                        ?>
                                                    </div>
                                                    <?php
                                                }
                                                $property_cats_array = $wp_rem_search_fields->wp_rem_property_type_categories_options($property_type_slug);

                                                if ($propertysearch_categories_switch == 'yes' && !empty($property_cats_array)) {
                                                    ?>
                                                    <div id="property_type_cate_fields_<?php echo wp_rem_allow_special_char($rand_numb); ?>" class="property-category-fields field-holder select-dropdown has-icon">
                                                        <label>
                                                            <i class="icon-home"></i>
                                                            <?php
                                                            $property_category = ( isset($_REQUEST['property_category']) ? $_REQUEST['property_category'] : '' );
                                                            $property_category = explode(',', $property_category);
                                                            $wp_rem_opt_array = array(
                                                                'std' => $property_category[0],
                                                                'id' => 'property_category',
                                                                'classes' => 'chosen-select',
                                                                'cust_name' => 'property_category',
                                                                'options' => $property_cats_array,
                                                            );
                                                            $wp_rem_form_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array);
                                                            ?>
                                                        </label>
                                                    </div>
                                                <?php } ?>
                                                <div class="field-holder search-btn">
                                                    <div class="search-btn-loader-<?php echo wp_rem_allow_special_char($rand_numb); ?> input-button-loader">
                                                        <?php
                                                        $zoom_level = 9;
                                                        if (isset($_REQUEST['zoom_level']) && $_REQUEST['zoom_level'] != '') {
                                                            $zoom_level = $_REQUEST['zoom_level'];
                                                        } else if (isset($wp_rem_plugin_options['wp_rem_map_zoom_level']) && $wp_rem_plugin_options['wp_rem_map_zoom_level'] != '') {
                                                            $zoom_level = $wp_rem_plugin_options['wp_rem_map_zoom_level'];
                                                        }
                                                        $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                                                                array(
                                                                    'simple' => true,
                                                                    'cust_id' => '',
                                                                    'cust_name' => 'zoom_level',
                                                                    'std' => absint($zoom_level),
                                                                )
                                                        );
                                                        $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                                                                array(
                                                                    'cust_name' => '',
                                                                    'classes' => 'bgcolor',
                                                                    'std' => wp_rem_plugin_text_srt('wp_rem_property_search'),
                                                                    'cust_type' => "submit",
                                                                )
                                                        );
                                                        ?>  
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            if ($property_type_slug != '' && $propertysearch_advance_filter_switch == 'yes') { 

                                                $args = array(
                                                    'name' => $property_type_slug,
                                                    'post_type' => 'property-type',
                                                    'post_status' => 'publish',
                                                    'numberposts' => 1,
                                                );
                                                $my_posts = get_posts($args);
                                                if ($my_posts) {
                                                    $property_type_id = $my_posts[0]->ID;
                                                }

                                                // $wp_rem_price_minimum_options = get_post_meta($property_type_id, 'wp_rem_price_minimum_options', true);
                                                // $wp_rem_price_minimum_options = (!empty($wp_rem_price_minimum_options) ) ? $wp_rem_price_minimum_options : 1;
                                                // $wp_rem_price_max_options = get_post_meta($property_type_id, 'wp_rem_price_max_options', true);
                                                // $wp_rem_price_max_options = (!empty($wp_rem_price_max_options) ) ? $wp_rem_price_max_options : 50; //50000;
                                                // $wp_rem_price_interval = get_post_meta($property_type_id, 'wp_rem_price_interval', true);
                                                // $wp_rem_price_interval = (!empty($wp_rem_price_interval) ) ? $wp_rem_price_interval : 50;
                                                $price_type_options = array();
                                                // $wp_rem_price_interval = (int) $wp_rem_price_interval;
                                                // $price_counter = $wp_rem_price_minimum_options;
                                                $property_price_array = array();
                                                // $property_price_array[''] = wp_rem_plugin_text_srt('wp_rem_search_filter_min_price'); 
                                                // while ($price_counter <= $wp_rem_price_max_options) {
                                                //     $property_price_array[$price_counter] = $price_counter; 
                                                //     $price_counter = $price_counter + $wp_rem_price_interval;
                                                // }
                                                $property_price_array = kk_get_price_filter_values( $property_type_id, wp_rem_plugin_text_srt('wp_rem_search_filter_min_price') );
                                                ?>
                                                <?php if (($propertysearch_categories_switch == 'yes' ) || ($propertysearch_price_switch == 'yes' && !empty($property_price_array)) || $propertysearch_advance_filter_switch == 'yes') { ?>
                                                    <div id="property_type_fields_<?php echo wp_rem_allow_special_char($rand_numb); ?>" class="search-advanced-fields" style="display:none;">

                                                        <?php if ($propertysearch_price_switch == 'yes' && !empty($property_price_array)) { ?>
                                                            <div class="field-holder select-dropdown">
                                                                <label>
                                                                    <i class="icon-dollar"></i>
                                                                    <?php
                                                                    $wp_rem_opt_array = array(
                                                                        'std' => '',
                                                                        'id' => 'property_price',
                                                                        'classes' => 'chosen-select',
                                                                        'cust_name' => 'property_price',
                                                                        'options' => $property_price_array,
                                                                        'price' => true
                                                                    );
                                                                    $wp_rem_form_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array);
                                                                    ?>
                                                                </label>
                                                            </div>
                                                        <?php } ?>
                                                        <?php do_action('wp_rem_property_type_fields', $property_type_slug); ?>
                                                        <?php do_action('wp_rem_property_type_features', $property_type_slug, $rand_numb); ?>
                                                        <?php
                                                        $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                                                                array(
                                                                    'simple' => true,
                                                                    'cust_id' => 'advanced_search',
                                                                    'cust_name' => 'advanced_search',
                                                                    'std' => 'true',
                                                                    'classes' => '',
                                                                )
                                                        );
                                                        ?>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <script type="text/javascript">
                                                (function ($) {
                                                    $(function () {
                                                        $("#search_form_property_type1").change(function () {
                                                            if ($(this).is(":checked")) {
                                                                wp_rem_top_serach_trigger();
                                                            }
                                                        });
                                                        $("#search_form_property_type2").change(function () {
                                                            if ($(this).is(":checked")) {
                                                                wp_rem_top_serach_trigger();
                                                            }
                                                        });
                                                        $("#wp_rem_property_category").change(function () {
                                                            wp_rem_top_serach_trigger();
                                                        });
                                                        var search_title_old = '';
                                                        $("input[name='search_title']").blur(function () {
                                                            var search_title_new = $(this).val();
                                                            if (search_title_old != search_title_new) {
                                                                $("input[type='hidden'][name='search_title']").val(search_title_new);
                                                                wp_rem_top_serach_trigger();
                                                                search_title_old = search_title_new;
                                                            }
                                                        });
                                                        $("input[name='search_title']").keypress(function (e) {
                                                            var key = e.keyCode || e.which;
                                                            if (key == 13) {
                                                                $(this).parents("form").find("input[type='submit']").trigger('click');
                                                            }
                                                        });
                                                    });
                                                })(jQuery);
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ($main_sections_column == 'wide') {
                                    echo '
									</div>
									</div>
									</div>';
                                }
                                ?>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    if ($loc_polygon != '') {
                        $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                                array(
                                    'simple' => true,
                                    'cust_id' => "loc_polygon",
                                    'cust_name' => 'loc_polygon',
                                    'std' => $loc_polygon,
                                )
                        );
                    }
                    $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                            array(
                                'simple' => true,
                                'cust_id' => "",
                                'cust_name' => 'ajax_filter',
                                'std' => 'true',
                            )
                    );
                    ?>
                </form>
            </div>
            <?php
            $html .= ob_get_clean();
            return $html;
        }

        function get_custom_locations() {
            global $wp_rem_plugin_options;
            $output = '<ul class="top-search-locations" style="display: none;">';
            $selected_location = '';
            $selected_item = '';
            $output .= $selected_item;
            $output .= '</ul>';
            if (false === ( $wp_rem_location_data = wp_rem_get_transient_obj('wp_rem_location_data') )) {
                
            } else {
                if (!empty($wp_rem_location_data)) {
                    $output .= '
					<script>
					jQuery(document).ready(function () {
						var location_data_json = \'' . str_replace("'", "", $wp_rem_location_data) . '\';
						var location_data_json_obj = JSON.parse(location_data_json);
						jQuery(".top-search-locations").html(\'\');
						jQuery.each(location_data_json_obj, function() {
							jQuery(".top-search-locations").append("<li data-val=\'"+this.value+"\'>"+this.caption+"</li>");
						});
					});
					</script>';
                }
            }
            echo $output;
        }

        public function toArray($obj) {
            if (is_object($obj)) {
                $obj = (array) $obj;
            }
            if (is_array($obj)) {
                $new = array();
                foreach ($obj as $key => $val) {
                    $new[$key] = $this->toArray($val);
                }
            } else {
                $new = $obj;
            }

            return $new;
        }

        public function pointInPolygon($point, $polygon) {
            $return = false;
            foreach ($polygon as $k => $p) {
                if (!$k)
                    $k_prev = count($polygon) - 1;
                else
                    $k_prev = $k - 1;

                if (($p[1] < $point[1] && $polygon[$k_prev][1] >= $point[1] || $polygon[$k_prev][1] < $point[1] && $p[1] >= $point[1]) && ($p[0] <= $point[0] || $polygon[$k_prev][0] <= $point[0])) {
                    if ($p[0] + ($point[1] - $p[1]) / ($polygon[$k_prev][1] - $p[1]) * ($polygon[$k_prev][0] - $p[0]) < $point[0]) {
                        $return = !$return;
                    }
                }
            }
            return $return;
        }

        public function map_search_query($atts = '') {
            global $wpdb, $wp_rem_plugin_options, $wp_rem_shortcode_properties_frontend;

			$property_type = '';
            // getting arg array from ajax
            if (isset($_REQUEST['atts']) && $_REQUEST['atts']) {
                $atts = $_REQUEST['atts'];
                $atts = json_decode(str_replace('\"', '"', $atts));
                $atts = $this->toArray($atts);
            }
            if (isset($atts) && $atts != '' && !empty($atts)) {
                extract($atts);
            }

            $property_type = isset($_REQUEST['property_type']) ? $_REQUEST['property_type'] : $property_type;
            $search_title = isset($_REQUEST['search_title']) ? $_REQUEST['search_title'] : '';
            $search_location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

            $element_filter_arr = array();
            $post_ids = array();
            $default_date_time_formate = 'd-m-Y H:i:s';
            $wp_rem_map_style = isset($wp_rem_plugin_options['wp_rem_def_map_style']) && $wp_rem_plugin_options['wp_rem_def_map_style'] != '' ? $wp_rem_plugin_options['wp_rem_def_map_style'] : '';
            $wp_rem_map_lat = isset($wp_rem_plugin_options['wp_rem_post_loc_latitude']) && $wp_rem_plugin_options['wp_rem_post_loc_latitude'] != '' ? $wp_rem_plugin_options['wp_rem_post_loc_latitude'] : '51.5';
            $wp_rem_map_long = isset($wp_rem_plugin_options['wp_rem_post_loc_longitude']) && $wp_rem_plugin_options['wp_rem_post_loc_longitude'] != '' ? $wp_rem_plugin_options['wp_rem_post_loc_longitude'] : '-0.2';
            $wp_rem_map_marker_icon = isset($wp_rem_plugin_options['wp_rem_map_marker_icon']) && $wp_rem_plugin_options['wp_rem_map_marker_icon'] != '' ? $wp_rem_plugin_options['wp_rem_map_marker_icon'] : wp_rem::plugin_url() . '/assets/frontend/images/map-marker.png';
            $wp_rem_map_cluster_icon = isset($wp_rem_plugin_options['wp_rem_map_cluster_icon']) && $wp_rem_plugin_options['wp_rem_map_cluster_icon'] != '' ? $wp_rem_plugin_options['wp_rem_map_cluster_icon'] : wp_rem::plugin_url() . '/assets/frontend/images/map-cluster.png';
            if ($wp_rem_map_marker_icon != '') {
                $wp_rem_map_marker_icon = wp_get_attachment_url($wp_rem_map_marker_icon);
            } else {
                $wp_rem_map_marker_icon = esc_url(wp_rem::plugin_url() . 'assets/frontend/images/map-marker.png');
            }
            if ($wp_rem_map_cluster_icon != '') {
                $wp_rem_map_cluster_icon = wp_get_attachment_url($wp_rem_map_cluster_icon);
            } else {
                $wp_rem_map_cluster_icon = esc_url(wp_rem::plugin_url() . 'assets/frontend/images/map-cluster.png');
            }
            $map_search_elem_lat = isset($atts['map_search_lat']) ? $atts['map_search_lat'] : '';
            $map_search_elem_long = isset($atts['map_search_long']) ? $atts['map_search_long'] : '';
            $map_latitude = $wp_rem_map_lat;
            $map_longitude = $wp_rem_map_long;

            if ($map_search_elem_lat != '') {
                $map_latitude = $map_search_elem_lat;
            }

            if ($map_search_elem_long != '') {
                $map_longitude = $map_search_elem_long;
            }
            // search location late long
            if (isset($_REQUEST['location']) && $_REQUEST['location'] != '' && !isset($_REQUEST['loc_polygon_path'])) {
                $Wp_rem_Locations = new Wp_rem_Locations();
                $location_response = $Wp_rem_Locations->wp_rem_get_geolocation_latlng_callback(trim(strtolower($_REQUEST['location'])));

                $map_latitude = isset($location_response->lat) ? $location_response->lat : '';
                $map_longitude = isset($location_response->lng) ? $location_response->lng : '';
            }

            // property shortcode logic start
            $filter_arr = array();
            $element_filter_arr = array();
            $default_date_time_formate = 'd-m-Y H:i:s';
            if (isset($_REQUEST['property_type']) && $_REQUEST['property_type']) {
                $property_type = $_REQUEST['property_type'];
            }
            $element_filter_arr[] = array(
                'key' => 'wp_rem_property_posted',
                'value' => strtotime(date($default_date_time_formate)),
                'compare' => '<=',
            );

            $element_filter_arr[] = array(
                'key' => 'wp_rem_property_expired',
                'value' => strtotime(date($default_date_time_formate)),
                'compare' => '>=',
            );

            $element_filter_arr[] = array(
                'key' => 'wp_rem_property_status',
                'value' => 'active',
                'compare' => '=',
            );

            if ($property_type != '' && $property_type != 'all') {
                $element_filter_arr[] = array(
                    'key' => 'wp_rem_property_type',
                    'value' => $property_type,
                    'compare' => '=',
                );
            }

            if (isset($_REQUEST['property_category']) && $_REQUEST['property_category'] != '') {
                $element_filter_arr['tax_query'] = array(
                    array(
                        'taxonomy' => 'property-category',
                        'field' => 'slug',
                        'terms' => $_REQUEST['property_category']
                    )
                );
            }

            // get all arguments from getting flters
            $left_filter_arr = $wp_rem_shortcode_properties_frontend->get_filter_arg($property_type);
            $post_ids = '';
            if (!empty($left_filter_arr)) {

                $meta_post_ids_arr = '';
                $property_id_condition = '';
                if (isset($left_filter_arr) && !empty($left_filter_arr)) {
                    $meta_post_ids_arr = wp_rem_get_query_whereclase_by_array($left_filter_arr);
                    // if no result found in filtration 
                    if (empty($meta_post_ids_arr)) {
                        $meta_post_ids_arr = array(0);
                    }
                    $ids = $meta_post_ids_arr != '' ? implode(",", $meta_post_ids_arr) : '0';
                    $property_id_condition = " ID in (" . $ids . ") AND ";
                }
                $post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE " . $property_id_condition . " post_type='properties' AND post_status='publish'");
                if (empty($post_ids)) {
                    $post_ids = array(0);
                }
                $filter_arr[] = $left_filter_arr;
            }

            $all_post_ids = array();
            if (!empty($post_ids)) {
                $all_post_ids[] = $post_ids;
            }


            if (isset($_REQUEST['location']) && $_REQUEST['location'] != '' && !isset($_REQUEST['loc_polygon_path'])) {
                $post_ids = $wp_rem_shortcode_properties_frontend->property_location_filter($_REQUEST['location'], $post_ids);
                if (empty($post_ids)) {
                    $post_ids = array(0);
                }
            }

            $all_post_ids = $post_ids;

            $property_sort_by = 'recent'; // default value
            $property_sort_order = 'desc';   // default value

            if (isset($_REQUEST['sort-by']) && $_REQUEST['sort-by'] != '') {
                $property_sort_by = $_REQUEST['sort-by'];
            }
            if ($property_sort_by == 'recent') {
                $qryvar_property_sort_type = 'DESC';
                $qryvar_sort_by_column = 'post_date';
            } elseif ($property_sort_by == 'alphabetical') {
                $qryvar_property_sort_type = 'ASC';
                $qryvar_sort_by_column = 'post_title';
            } elseif ($property_sort_by == 'price') {
                $qryvar_property_sort_type = 'DESC';
                $qryvar_sort_by_column = 'meta_value_num';
            }
            $args = array(
                'posts_per_page' => '-1',
                'post_type' => 'properties',
                'post_status' => 'publish',
                'order' => $qryvar_property_sort_type,
                'orderby' => $qryvar_sort_by_column,
                'fields' => 'ids', // only load ids
                'meta_query' => array(
                    $element_filter_arr,
                )
            );
            if ($property_sort_by == 'price') {
                $args['meta_key'] = 'wp_rem_property_price';
            }

            if (isset($_REQUEST['search_title']) && $_REQUEST['search_title'] != '') {
                $args['s'] = $_REQUEST['search_title'];
            }

            if (!empty($all_post_ids)) {
                $args['post__in'] = $all_post_ids;
            }

            $points_in_polygon = false;
            $polygon_path = array();
            if (isset($_REQUEST['loc_polygon_path'])) {
                $points_in_polygon = true;
                $polygon_path = explode('||', $_REQUEST['loc_polygon_path']);
                if (count($polygon_path) > 0) {
                    array_walk($polygon_path, function(&$val) {
                        $val = explode(',', $val);
                    });
                }
            }

            // property shortcode logic end
            $property_loop_count = wp_rem_get_cached_obj('property_result_cached_loop_count', $args, 12, false, 'wp_query');
            $tota_property_count = 0;

            $map_cords = array();
            if ($property_loop_count->have_posts()):
                while ($property_loop_count->have_posts()) : $property_loop_count->the_post();
                    global $post, $wp_rem_member_profile;

                    $property_id = $post;

                    $property_latitude = get_post_meta($property_id, 'wp_rem_post_loc_latitude_property', true);
                    $property_longitude = get_post_meta($property_id, 'wp_rem_post_loc_longitude_property', true);

                    if ($points_in_polygon) {
                        if (!$this->pointInPolygon(array($property_latitude, $property_longitude), $polygon_path)) {
                            continue;
                        }
                    }

                    $Wp_rem_Locations = new Wp_rem_Locations();
                    $property_type = get_post_meta($property_id, 'wp_rem_property_type', true);
                    $property_type_obj = get_page_by_path($property_type, OBJECT, 'property-type');
                    $property_type_id = isset($property_type_obj->ID) ? $property_type_obj->ID : '';
                    $property_location = $Wp_rem_Locations->get_location_by_property_id($property_id);
                    $wp_rem_property_username = get_post_meta($property_id, 'wp_rem_property_username', true);
                    $wp_rem_profile_image = $wp_rem_member_profile->member_get_profile_image($wp_rem_property_username);

                    $property_marker = get_post_meta($property_type_id, 'wp_rem_property_type_marker_image', true);

                    if ($property_marker != '') {
                        $property_marker = wp_get_attachment_url($property_marker);
                    } else {
                        $property_marker = esc_url(wp_rem::plugin_url() . 'assets/frontend/images/map-marker.png');
                    }

                    $wp_rem_property_is_featured = get_post_meta($property_id, 'wp_rem_property_is_featured', true);

                    $wp_rem_property_price_options = get_post_meta($property_id, 'wp_rem_property_price_options', true);
                    $wp_rem_property_type = get_post_meta($property_id, 'wp_rem_property_type', true);
                    $wp_rem_transaction_property_reviews = get_post_meta($property_id, 'wp_rem_transaction_property_reviews', true);

                    $wp_rem_property_type_price_switch = get_post_meta($property_type_id, 'wp_rem_property_type_price', true);
                    $wp_rem_user_reviews = get_post_meta($property_type_id, 'wp_rem_user_reviews', true);

					$tota_property_count++;
					
                    // end checking review on in property type

                    $wp_rem_property_price = '';
                    if ($wp_rem_property_price_options == 'price') {
                        $wp_rem_property_price = get_post_meta($property_id, 'wp_rem_property_price', true);
                    } else if ($wp_rem_property_price_options == 'on-call') {
                        $wp_rem_property_price = wp_rem_plugin_text_srt('wp_rem_nearby_properties_price_on_request');
                    }

                    $property_info_img = '';
                    if (function_exists('property_gallery_first_image')) {
                        $gallery_image_args = array(
                            'property_id' => get_the_ID(),
                            'size' => 'wp_rem_cs_media_5',
                            'class' => 'img-map-info',
                            'default_image_src' => esc_url(wp_rem::plugin_url() . 'assets/frontend/images/no-image4x3.jpg')
                        );
                        $property_info_img = property_gallery_first_image($gallery_image_args);
                    }

                    $property_info_price = '';
                    if ($wp_rem_property_type_price_switch == 'on' && $wp_rem_property_price != '') {
                        $property_info_price .= '
						<span class="property-price">
							<span class="new-price text-color">';
                        if ($wp_rem_property_price_options == 'on-call') {
                            $property_info_price .= $wp_rem_property_price;
                        } else {
                            $property_info_price .= wp_rem_property_price($property_id, $wp_rem_property_price, '<span class="guid-price">', '</span>');
                        }
                        $property_info_price .= '	
							</span>
						</span>';
                    }
                    $property_info_address = '';
                    if ($property_location != '') {
                        $property_info_address = '<span class="info-address">' . $property_location . '</span>';
                    }

                    ob_start();
                    $favourite_label = '';
                    $favourite_label = '';
                    $figcaption_div = true;
                    $book_mark_args = array(
                        'before_label' => $favourite_label,
                        'after_label' => $favourite_label,
                        'before_icon' => '<i class="icon-heart-o"></i>',
                        'after_icon' => '<i class="icon-heart5"></i>',
                    );

                    do_action('wp_rem_favourites_frontend_button', $property_id, $book_mark_args, $figcaption_div);
                    $list_favourite = ob_get_clean();

                    $property_featured = '';

                    $property_member = $wp_rem_property_username != '' && get_the_title($wp_rem_property_username) != '' ? '<span class="info-member">' . sprintf(wp_rem_plugin_text_srt('wp_rem_member_members_with_colan'), get_the_title($wp_rem_property_username)) . '</span>' : '';

                    $ratings_data = array(
                        'overall_rating' => 0.0,
                        'count' => 0,
                    );

                    $ratings_data = apply_filters('reviews_ratings_data', $ratings_data, $property_id);

                    $property_reviews = '';
                    if ($wp_rem_transaction_property_reviews == 'on' && $wp_rem_user_reviews == 'on' && $ratings_data['count'] > 0) {
                        $property_reviews .= '
						<div class="post-rating">
							<div class="rating-holder">
								<div class="rating-star">
									<span class="rating-box" style="width: ' . $ratings_data['overall_rating'] . '%;"></span>
								</div>
								<span class="ratings"><span class="rating-text">(' . $ratings_data['count'] . ') ' . wp_rem_plugin_text_srt('wp_rem_list_meta_reviews') . '</span></span>
							</div>
						</div>';
                    }

                    if ($property_latitude != '' && $property_longitude != '') {
                        $map_cords[] = array(
                            'lat' => $property_latitude,
                            'long' => $property_longitude,
                            'id' => $property_id,
                            'title' => get_the_title($property_id),
                            'link' => get_permalink($property_id),
                            'img' => $property_info_img,
                            'price' => $property_info_price,
                            'address' => $property_info_address,
                            'favourite' => $list_favourite,
                            'featured' => $property_featured,
                            'reviews' => $property_reviews,
                            'member' => $property_member,
                            'marker' => $property_marker,
                        );
                    }

                endwhile;
                wp_reset_postdata();

            endif;

            /*
             *  draw on map
             */
            $wp_rem_property_strings = array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'plugin_url' => wp_rem::plugin_url(),
                'draw_area' => wp_rem_plugin_text_srt('wp_rem_top_map_draw_btn'),
                'alert_name' => wp_rem_plugin_text_srt('wp_rem_alerts_alert_name_title'),
                'alert_email' => wp_rem_plugin_text_srt('wp_rem_alerts_email_address'),
                'alert_save_search' => wp_rem_plugin_text_srt('wp_rem_alerts_save_search'),
                'alert_or' => wp_rem_plugin_text_srt('wp_rem_alerts_map_or'),
                'alert_submit' => wp_rem_plugin_text_srt('wp_rem_alerts_map_submit'),
                'alert_view_prop' => wp_rem_plugin_text_srt('wp_rem_alerts_map_view_properties'),
                'map_locked' => wp_rem_plugin_text_srt('wp_rem_map_search_map_lock'),
                'map_unlocked' => wp_rem_plugin_text_srt('wp_rem_map_search_map_unlock'),
                'geoloc_timeout' => wp_rem_plugin_text_srt('wp_rem_map_geoloc_timeout'),
                'geoloc_not_support' => wp_rem_plugin_text_srt('wp_rem_map_geoloc_not_support'),
                'geoloc_unavailable' => wp_rem_plugin_text_srt('wp_rem_map_geoloc_unavailable'),
            );
            wp_localize_script('wp-rem-property-top-map', 'wp_rem_top_gmap_strings', $wp_rem_property_strings);
            $del_btn_class = ' is-disabled';
            $draw_btn_class = '';

            if (isset($_REQUEST['location']) && $_REQUEST['location'] != '' && !isset($_REQUEST['loc_polygon_path'])) {
                $get_loc_term = get_term_by('slug', $_REQUEST['location'], 'wp_rem_locations');
                if (isset($get_loc_term->term_id)) {
                    $location_coordinates = get_term_meta($get_loc_term->term_id, 'location_coordinates', true);
                }
            }
            if (isset($_REQUEST['zoom_level']) && $_REQUEST['zoom_level'] != '') {
                $map_zoom = $_REQUEST['zoom_level'];
            } else {
                $map_zoom = isset($wp_rem_plugin_options['wp_rem_map_zoom_level']) && $wp_rem_plugin_options['wp_rem_map_zoom_level'] != '' ? $wp_rem_plugin_options['wp_rem_map_zoom_level'] : '9';
            }
            $wp_rem_map_style = isset($wp_rem_plugin_options['wp_rem_def_map_style']) && $wp_rem_plugin_options['wp_rem_def_map_style'] != '' ? $wp_rem_plugin_options['wp_rem_def_map_style'] : '';
            $map_custom_style = isset($wp_rem_plugin_options['wp_rem_map_custom_style']) && $wp_rem_plugin_options['wp_rem_map_custom_style'] != '' ? $wp_rem_plugin_options['wp_rem_map_custom_style'] : '';
            $wp_rem_map_lat = isset($wp_rem_plugin_options['wp_rem_post_loc_latitude']) && $wp_rem_plugin_options['wp_rem_post_loc_latitude'] != '' ? $wp_rem_plugin_options['wp_rem_post_loc_latitude'] : '51.5';
            $wp_rem_map_long = isset($wp_rem_plugin_options['wp_rem_post_loc_longitude']) && $wp_rem_plugin_options['wp_rem_post_loc_longitude'] != '' ? $wp_rem_plugin_options['wp_rem_post_loc_longitude'] : '-0.2';
            $wp_rem_map_marker_icon = isset($wp_rem_plugin_options['wp_rem_map_marker_icon']) && $wp_rem_plugin_options['wp_rem_map_marker_icon'] != '' ? $wp_rem_plugin_options['wp_rem_map_marker_icon'] : wp_rem::plugin_url() . '/assets/frontend/images/map-marker.png';
            $wp_rem_map_cluster_icon = isset($wp_rem_plugin_options['wp_rem_map_cluster_icon']) && $wp_rem_plugin_options['wp_rem_map_cluster_icon'] != '' ? $wp_rem_plugin_options['wp_rem_map_cluster_icon'] : wp_rem::plugin_url() . '/assets/frontend/images/map-cluster.png';
            if ($wp_rem_map_marker_icon != '') {
                $wp_rem_map_marker_icon = wp_get_attachment_url($wp_rem_map_marker_icon);
            } else {
                $wp_rem_map_marker_icon = esc_url(wp_rem::plugin_url() . 'assets/frontend/images/map-marker.png');
            }
            if ($wp_rem_map_cluster_icon != '') {
                $wp_rem_map_cluster_icon = wp_get_attachment_url($wp_rem_map_cluster_icon);
            } else {
                $wp_rem_map_cluster_icon = esc_url(wp_rem::plugin_url() . 'assets/frontend/images/map-cluster.png');
            }

            $map_custom_style = str_replace('&quot;', '"', $map_custom_style);

            if (isset($location_coordinates) && !empty($location_coordinates)) {
                $location_coordinates_arr = json_decode($location_coordinates, true);

                if (isset($location_coordinates_arr[0]['lat']) && isset($location_coordinates_arr[0]['lng'])) {
                    $wp_rem_map_lat = $location_coordinates_arr[0]['lat'];
                    $wp_rem_map_long = $location_coordinates_arr[0]['lng'];
                }
            }
            if (isset($polygon_path)) {
                $loc_poly_cords_bounds = $polygon_path;
            }

            // add geo location lat long
            $rand_numb = $map_search_result_page = isset($atts['rand_numb']) ? $atts['rand_numb'] : '';
            $map_params = array(
                'map_id' => $rand_numb,
                'map_zoom' => $map_zoom,
                'latitude' => $map_latitude,
                'longitude' => $map_longitude,
                'map_style' => $wp_rem_map_style,
                'map_custom_style' => $map_custom_style,
                'map_cords' => $map_cords,
                'marker_icon' => $wp_rem_map_marker_icon,
                'cluster_icon' => $wp_rem_map_cluster_icon,
            );
            if (isset($location_coordinates) && !empty($location_coordinates)) {
                $map_params['location_cords'] = $location_coordinates;
                $del_btn_class = '';
                $draw_btn_class = ' is-disabled';
            }
            if (isset($loc_poly_cords_bounds) && !empty($loc_poly_cords_bounds)) {
                $map_params['location_cords'] = $loc_poly_cords_bounds;
                $del_btn_class = '';
                $draw_btn_class = ' is-disabled';
            }

            $map_json = json_encode($map_params);


            ob_start();
            ?>
            <script type="text/javascript">
                var $tota_property_count = '<?php echo esc_html($tota_property_count); ?>';
                var tota_property_countActualLimit = 1000;
                // change tot record in lable
                if ($tota_property_count >= 0) {
                    if ($tota_property_count >= (tota_property_countActualLimit - 1)) {
                        jQuery('#total-records-<?php echo esc_html($rand_numb); ?>').html(tota_property_countActualLimit + '+');
                    } else {
                        jQuery('#total-records-<?php echo esc_html($rand_numb); ?>').html($tota_property_count);
                    }
                    jQuery('#property-records-<?php echo esc_html($rand_numb); ?>').show();
                }

                var top_dataobj = jQuery.parseJSON('<?php echo addslashes($map_json) ?>');
            <?php
            if (isset($_POST['action'])) {
                ?>
                    all_marker = [];
                    if (reset_top_map_marker) {
                        for (var i = 0; i < reset_top_map_marker.length; i++) {
                            reset_top_map_marker[i].setMap(null);
                        }
                    }
                    if (markerClusterers) {
                        markerClusterers.clearMarkers();
                    }
                    wp_rem_property_top_map(top_dataobj, 'true');
                <?php
            } else {
                ?>
                    jQuery(window).load(function () {
                        wp_rem_property_top_map(top_dataobj, 'false');
                        jQuery('.top-gmap-loader').html('');
                    });
                <?php
            }
            ?>
            </script>
            <?php
            $html = ob_get_clean();

            if (isset($_POST['action'])) {
                $property_type = isset($_POST['property_type']) ? $_POST['property_type'] : '';
                $property_type_obj = get_page_by_path($property_type, OBJECT, 'property-type');
                $property_type_id = isset($property_type_obj->ID) ? $property_type_obj->ID : '';
                $wp_rem_search_result_page = get_post_meta($property_type_id, 'wp_rem_search_result_page', true);
                $wp_rem_search_result_page = ( $wp_rem_search_result_page != '' ) ? get_permalink($wp_rem_search_result_page) : '';
                if ($wp_rem_search_result_page == '' || $property_type == '') {
                    $wp_rem_search_result_page = isset($wp_rem_plugin_options['wp_rem_search_result_page']) ? $wp_rem_plugin_options['wp_rem_search_result_page'] : '';
                    $wp_rem_search_result_page = ( $wp_rem_search_result_page != '' ) ? get_permalink($wp_rem_search_result_page) : '';
                }
                echo json_encode(array('html' => $html, 'search_page' => $wp_rem_search_result_page));
                die;
            } else {
                return $html;
            }
        }

    }

    global $wp_rem_shortcode_map_search_front;
    $wp_rem_shortcode_map_search_front = new Wp_rem_Shortcode_Map_Search_front();
}
