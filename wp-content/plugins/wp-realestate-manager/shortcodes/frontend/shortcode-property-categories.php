<?php

/**
 * File Type: Searchs Shortcode Frontend
 */
if ( ! class_exists('Wp_rem_Shortcode_Property_Categories_front') ) {

    class Wp_rem_Shortcode_Property_Categories_front {

        /**
         * Constant variables
         */
        var $PREFIX = 'property_categories';

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_shortcode($this->PREFIX, array( $this, 'wp_rem_property_categories_shortcode_callback' ));
        }

        /*
         * Shortcode View on Frontend
         */

        function combine_pt_section($keys, $values) {
            $result = array();
            foreach ( $keys as $i => $k ) {
                $result[$k][] = $values[$i];
            }
            array_walk($result, create_function('&$v', '$v = (count($v) == 1)? array_pop($v): $v;'));
            return $result;
        }

        public function wp_rem_property_categories_shortcode_callback($atts, $content = "") {
            global $current_user, $wp_rem_plugin_options;
            wp_enqueue_script('wp-rem-bootstrap-slider');
            wp_enqueue_script('wp-rem-matchHeight-script');
            $property_categories_title = isset($atts['property_categories_title']) ? $atts['property_categories_title'] : '';
            $property_categories_styles = isset($atts['property_categories_styles']) ? $atts['property_categories_styles'] : '';
            $property_categories_title_align = isset($atts['property_categories_title_align']) ? $atts['property_categories_title_align'] : '';
            $pricing_tabl_subtitle = isset($atts['property_categories_subtitle']) ? $atts['property_categories_subtitle'] : '';
            $property_categories = isset($atts['property_categories']) ? $atts['property_categories'] : '';
            ob_start();
            $page_element_size = isset($atts['property_categories_element_size']) ? $atts['property_categories_element_size'] : 100;
            if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
                echo '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
            }
            $category_class_name = '';
            if ( isset($property_categories_styles) && $property_categories_styles == 'classic' ) {
                $category_class_name = ' classic';
            }


            $wp_rem_element_structure = '';
            $wp_rem_element_structure = wp_rem_plugin_title_sub_align($property_categories_title, $pricing_tabl_subtitle, $property_categories_title_align);
            echo force_balance_tags($wp_rem_element_structure);
            echo '<div class="categories-list' . $category_class_name . '">';
            echo '<ul>';
            $all_categories = explode(",", $property_categories);
            $fields_array = array();
            $counter = 0;
            foreach ( $all_categories as $category ) {

                $element_filter_arr = '';
                $default_date_time_formate = 'd-m-Y H:i:s';
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
                $args = array(
                    'post_status' => 'publish',
                    'post_type' => 'properties',
                    'posts_per_page' => "1",
                    'fields' => 'ids', // only load ids
                    'meta_query' => array(
                        array(
                            'key' => 'wp_rem_property_category',
                            'value' => $category,
                            'compare' => 'LIKE',
                        ),
                        $element_filter_arr,
                    )
                );
                $the_query = new WP_Query($args);
                $post_count = $the_query->found_posts;
                $term_data = get_term_by('slug', $category, 'property-category');

                if ( isset($term_data->name) ) {
                    $fields_array[$counter]['category'] = $term_data->name;
                    $fields_array[$counter]['id'] = $term_data->term_id;
                    $fields_array[$counter]['slug'] = $term_data->slug;
                    $fields_array[$counter]['post_count'] = $post_count;
                }
                $counter ++;
                wp_reset_postdata();
            }
            
            $wp_rem_search = '';
			$wp_rem_search_result_page = isset($wp_rem_plugin_options['wp_rem_search_result_page']) ? $wp_rem_plugin_options['wp_rem_search_result_page'] : '';
			if( $wp_rem_search_result_page != ''  && is_numeric($wp_rem_search_result_page)){
				$wp_rem_search = get_permalink($wp_rem_search_result_page);
			}
			
            foreach ( $fields_array as $field_data ) {
                if ( isset($field_data['id']) ) {
                    $cat_link = isset($wp_rem_search) && $wp_rem_search != '' ? $wp_rem_search . '?property_category=' . $field_data['slug'] . '&ajax_filter=true' : '&ajax_filter=true';
                }
                echo '<li>';
                echo '<a href = "' . ( $cat_link ) . '">' . $field_data['category'] . '</a>';
                echo '<small>(' . $field_data['post_count'] . ' '.  wp_rem_plugin_text_srt('wp_rem_deals') .')</small>';
                echo '</li>';
            }

            echo '</ul>';
            echo '</div>';

            if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
                echo '</div>';
            }
            $html = ob_get_clean();
            return $html;
        }

    }

    global $wp_rem_shortcode_property_categories_front;
    $wp_rem_shortcode_property_categories_front = new Wp_rem_Shortcode_Property_Categories_front();
}