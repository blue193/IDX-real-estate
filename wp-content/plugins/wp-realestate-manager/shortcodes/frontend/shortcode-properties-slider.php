<?php
/**
 * File Type: Properties Slider Shortcode Frontend
 */
if (!class_exists('Wp_rem_Shortcode_Properties_Slider_Frontend')) {

    class Wp_rem_Shortcode_Properties_Slider_Frontend {

        /**
         * Constant variables
         */
        var $PREFIX = 'wp_rem_properties_slider';

        public function __construct() {
            add_shortcode($this->PREFIX, array($this, 'wp_rem_properties_slider_shortcode_callback'));
        }

        public function wp_rem_properties_slider_shortcode_callback($atts, $content = "") {
            $property_short_counter = isset($atts['property_counter']) && $atts['property_counter'] != '' ? ( $atts['property_counter'] ) : rand(123, 9999);
            ob_start();
            $page_element_size = isset($atts['wp_rem_properties_slider_element_size']) ? $atts['wp_rem_properties_slider_element_size'] : 100;
            if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
                echo '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
            }
            wp_enqueue_script('wp-rem-property-functions');
            wp_enqueue_script('wp-rem-matchHeight-script');
            ?>
            <div class="row">
                <div class="wp-rem-property-content" id="wp-rem-property-content-<?php echo esc_html($property_short_counter); ?>">
                    <div id="Property-content-<?php echo esc_html($property_short_counter); ?>">
                        <?php
                        $property_arg = array(
                            'property_short_counter' => $property_short_counter,
                            'atts' => $atts,
                            'content' => $content,
                        );
                        $this->wp_rem_properties_content($property_arg);
                        ?>
                    </div>
                </div>   
            </div>
            <?php
            if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
                echo '</div>';
            }
            $html = ob_get_clean();
            return $html;
        }

        public function wp_rem_properties_content($property_arg = '') {
            global $wpdb, $wp_rem_form_fields_frontend;

            if (isset($_REQUEST['property_arg']) && $_REQUEST['property_arg']) {
                $property_arg = $_REQUEST['property_arg'];
                $property_arg = json_decode(str_replace('\"', '"', $property_arg));
                $property_arg = $this->toArray($property_arg);
            }
            if (isset($property_arg) && $property_arg != '' && !empty($property_arg)) {
                extract($property_arg);
            }

            $default_date_time_formate = 'd-m-Y H:i:s';
            $property_view = 'slider';
            $property_sort_by = 'recent'; // default value
            $property_sort_order = 'desc';   // default value

            $property_type = isset($atts['property_type']) ? $atts['property_type'] : '';
            $property_property_featured = isset($atts['property_featured']) ? $atts['property_featured'] : 'all';
            $property_sort_by = isset($atts['property_sort_by']) ? $atts['property_sort_by'] : 'recent';
            $posts_per_page = isset($atts['posts_per_page']) ? $atts['posts_per_page'] : '10';
            $content_columns = 'page-content col-lg-12 col-md-12 col-sm-12 col-xs-12'; // if filteration not true

            $element_filter_arr = '';
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
            // if property type
            if ($property_type != '') {
                $element_filter_arr[] = array(
                    'key' => 'wp_rem_property_type',
                    'value' => $property_type,
                    'compare' => '=',
                );
            }
            // if featured property
            if ($property_property_featured == 'only-featured') {
                $element_filter_arr[] = array(
                    'key' => 'wp_rem_property_is_featured',
                    'value' => 'on',
                    'compare' => '=',
                );
            }
            // if property sort by
            if ($property_sort_by == 'recent') {
                $qryvar_property_sort_type = 'DESC';
                $qryvar_sort_by_column = 'post_date';
            } elseif ($property_sort_by == 'alphabetical') {
                $qryvar_property_sort_type = 'ASC';
                $qryvar_sort_by_column = 'title';
            }

            $args = array(
                'posts_per_page' => $posts_per_page,
                'post_type' => 'properties',
                'post_status' => 'publish',
                'orderby' => $qryvar_sort_by_column,
                'order' => $qryvar_property_sort_type,
                'fields' => 'ids', // only load ids
                'meta_query' => array(
                    $element_filter_arr,
                ),
            );

            $property_loop_obj = new WP_Query($args);
            ?>
            <div class="<?php echo esc_html($content_columns); ?>">
				<div class="real-estate-property">
					<?php
					set_query_var('property_loop_obj', $property_loop_obj);
					set_query_var('property_view', $property_view);
					set_query_var('property_short_counter', $property_short_counter);
					set_query_var('atts', $atts);
					wp_rem_get_template_part('property', 'slider', 'properties');
					?>
				</div>
            </div>
                <?php
                wp_reset_postdata();
            }

        }

        global $wp_rem_shortcode_properties_slider_frontend;
        $wp_rem_shortcode_properties_slider_frontend = new Wp_rem_Shortcode_Properties_Slider_Frontend();
    }