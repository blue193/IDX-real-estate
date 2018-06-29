<?php

/**
 * @  Blog html form for page builder Frontend side
 *
 *
 */
if ( ! function_exists('wp_rem_cs_locations_shortcode') ) {

    function wp_rem_cs_locations_shortcode($atts) {
        global $wp_rem_plugin_options, $post, $wp_rem_cs_locations_element_title, $wpdb, $locations_pagination, $wp_rem_cs_locations_num_post, $wp_rem_cs_counter_node, $wp_rem_cs_column_atts, $wp_rem_cs_locations_description, $wp_rem_cs_locations_excerpt, $post_thumb_view, $wp_rem_cs_locations_section_title, $args, $wp_rem_cs_locations_orderby, $orderby;
        $html = '';
        ob_start();
        $defaults = array(
            'locations_element_size' => '',
            'wp_rem_cs_locations_element_title' => '',
            'wp_rem_cs_locations_element_subtitle' => '',
            'wp_rem_var_locations_align' => '',
            'wp_rem_var_locations_style' => '',
            'wp_rem_all_locations_names' => '',
            'wp_rem_all_locations_url' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        $page_element_size = isset($atts['locations_element_size']) ? $atts['locations_element_size'] : 100;
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $html .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }
        $wp_rem_search_result_page = isset($wp_rem_plugin_options['wp_rem_search_result_page']) ? $wp_rem_plugin_options['wp_rem_search_result_page'] : '';
        $wp_rem_all_locations_names = isset($wp_rem_all_locations_names) ? $wp_rem_all_locations_names : '';

        $wp_rem_cs_locations_element_title = isset($wp_rem_cs_locations_element_title) ? $wp_rem_cs_locations_element_title : '';
        $wp_rem_cs_locations_element_subtitle = isset($wp_rem_cs_locations_element_subtitle) ? $wp_rem_cs_locations_element_subtitle : '';
        $wp_rem_var_locations_align = isset($wp_rem_var_locations_align) ? $wp_rem_var_locations_align : '';
        $wp_rem_var_locations_style = isset($wp_rem_var_locations_style) ? $wp_rem_var_locations_style : '';
        $wp_rem_all_locations_url = isset($wp_rem_all_locations_url) ? $wp_rem_all_locations_url : '';
        $all_locations = explode(",", $wp_rem_all_locations_names);
        $html .= wp_rem_plugin_title_sub_align($wp_rem_cs_locations_element_title, $wp_rem_cs_locations_element_subtitle, $wp_rem_var_locations_align);
        $page_url = isset($wp_rem_search_result_page) ? get_permalink($wp_rem_search_result_page) : '';
        $view_class = '';
        if ( $wp_rem_var_locations_style == 'simple' ) {
            $view_class = ' v2';
        }
        
        if ( $wp_rem_var_locations_style == 'classic' ) {
            $view_class = ' classic';
        }

        $html .= '<div class="top-locations' . $view_class . '"><ul>';
        if ( isset($all_locations) && ! empty($all_locations) && is_array($all_locations) ) {
            foreach ( $all_locations as $value ) {
                $term_id = $value;
                $wp_rem_location_img_field = get_term_meta($value, 'wp_rem_location_img_field', true);
                $location_name = get_term_by('id', $term_id, 'wp_rem_locations');
                $location_slug = isset($location_name->slug) ? $location_name->slug : '';
                $location_name = isset($location_name->name) ? $location_name->name : '';
                $wp_rem_location_img_field = isset($wp_rem_location_img_field) ? $wp_rem_location_img_field : '';
                $num_of_properties = '';
                $list_args = array(
                    'posts_per_page' => "1",
                    'post_type' => 'properties',
                    'post_status' => 'publish',
                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'key' => 'wp_rem_property_expired',
                            'value' => strtotime(date("d-m-Y")),
                            'compare' => '>=',
                        ),
                        array(
                            'key' => 'wp_rem_property_status',
                            'value' => 'delete',
                            'compare' => '!=',
                        ),
                        array(
                            'relation' => 'OR',
                            array(
                                'key' => 'wp_rem_post_loc_country_property',
                                'value' => $location_slug,
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'wp_rem_post_loc_state_property',
                                'value' => $location_slug,
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'wp_rem_post_loc_city_property',
                                'value' => $location_slug,
                                'compare' => '=',
                            ),
                        )
                    ),
                );
                $custom_query = new WP_Query($list_args);
                $num_of_properties = $custom_query->found_posts;
                $location_search_link = 'javascript:void(0)';
                if ( ! empty($location_slug) && ! empty($page_url) ) {
                    $location_search_link = $page_url . '/?location=' . $location_slug . '';
                }
                $location_url = '';
                if ( ! empty($wp_rem_location_img_field) ) {
                    $location_url = wp_get_attachment_url($wp_rem_location_img_field);
                }
                $no_img = '';
                if ( empty($location_url) ) {
                    $no_img = ' no-img';
                }
                if ( $wp_rem_var_locations_style == 'simple' ) {

                    $html .='<li><a href="' . ($location_search_link) . '">' . esc_html($location_name) . '</a></li>';
                }elseif ( $wp_rem_var_locations_style == 'classic' ) {

                    $html .=' <li> ';
                    $html .='<div class="text-holder">
                                <a href="' . ($location_search_link) . '">' . esc_html($location_name) . '</a>
                                <span class="properties-count">'.$num_of_properties.'</span>
                                <span class="properties-listed">'.wp_rem_plugin_text_srt('wp_rem_location_element_properties_listed').'</span>
                              </div>';
                    $html .=' </li> ';
                }  else {
                    $html .=' <li> ';
                    $html .=' <div class="image-holder' . $no_img . '"><figure>';
                    if ( ! empty($location_url) ) {
                        $html .=' <img src="' . esc_url($location_url) . '" alt="">';
                    }
                    if ( ! empty($location_name) ) {
                        $html .='  <figcaption> <a href="' . ($location_search_link) . '">' . esc_html($location_name) . '</a> </figcaption>';
                    }
                    $html .='</figure>
                        </div> ';
                    $html .='<div class="text-holder">
                                <span class="properties-count">'.$num_of_properties.'</span>
                                <span class="properties-listed">'.wp_rem_plugin_text_srt('wp_rem_location_element_properties_listed').'</span>
                              </div>';
                    $html .=' </li> ';
                }
            }
        }

        $html .='</ul>';
        if ( ! empty($wp_rem_all_locations_url) && $wp_rem_var_locations_style == 'modern' ) {
            $html .='<a href="' . esc_url($wp_rem_all_locations_url) . '" class="view-loc-btn">view all locations</a>';
        }
        $html .= '</div>';
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $html .= '</div>';
        }
        return $html;
    }

    if ( function_exists('wp_rem_cs_var_short_code') ) {
        wp_rem_cs_var_short_code('wp_rem_cs_locations', 'wp_rem_cs_locations_shortcode');
    }
}
