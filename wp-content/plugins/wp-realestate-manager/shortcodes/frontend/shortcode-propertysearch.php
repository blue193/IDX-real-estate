<?php
/**
 * File Type: Properties Shortcode Frontend
 */
if ( ! class_exists('Wp_rem_Shortcode_Propertiesearch_Frontend') ) {

    class Wp_rem_Shortcode_Propertiesearch_Frontend {

        /**
         * Constant variables
         */
        var $PREFIX = 'wp_rem_propertysearch';

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_shortcode($this->PREFIX, array( $this, 'wp_rem_propertysearch_shortcode_callback' ));
            add_action('wp_ajax_wp_rem_propertysearch_content', array( $this, 'wp_rem_propertysearch_content' ));
            add_action('wp_ajax_nopriv_wp_rem_propertysearch_content', array( $this, 'wp_rem_propertysearch_content' ));
        }

        /*
         * Shortcode View on Frontend
         */

        public function wp_rem_propertysearch_shortcode_callback($atts, $content = "") {
            $property_short_counter = isset($atts['property_counter']) && $atts['property_counter'] != '' ? ( $atts['property_counter'] ) : rand(123, 9999); // for shortcode counter
            ob_start();
            $page_element_size = isset($atts['wp_rem_propertysearch_element_size']) ? $atts['wp_rem_propertysearch_element_size'] : 100;
            $advance_link = isset($atts['advance_link']) ? $atts['advance_link'] : '';
            $propertysearch_advance_filter_switch = isset($atts['propertysearch_advance_filter_switch']) ? $atts['propertysearch_advance_filter_switch'] : '';
            $propertysearch_title = isset($atts['propertysearch_title']) ? $atts['propertysearch_title'] : '';
            $propertysearch_subtitle = isset($atts['propertysearch_subtitle']) ? $atts['propertysearch_subtitle'] : '';
            $propertysearch_alignment = isset($atts['propertysearch_alignment']) ? $atts['propertysearch_alignment'] : '';
            $element_title_color = isset($atts['element_title_color']) ? $atts['element_title_color'] : '';
            $element_color_title = '';
            if ( isset($element_title_color) && $element_title_color != '' ) {
                $element_color_title = ' style="color:' . $element_title_color . ' ! important;"';
            }
            $propertysearch_view = isset($atts['propertysearch_view']) ? $atts['propertysearch_view'] : '';
            $search_background_color = isset($atts['search_background_color']) ? $atts['search_background_color'] : '';
            $search_backg_color_style = '';
            if ( isset($search_background_color) && ! empty($search_background_color) ) {
                $search_backg_color_style = ' style="background-color:' . $search_background_color . ' !important;"';
            }
            $medern_v2_search_backg_color_style = '';
            if ( isset($search_background_color) && ! empty($search_background_color) && ($propertysearch_view == 'modern_v2' || $propertysearch_view == 'fancy_v3') ) {
                $medern_v2_search_backg_color_style = ' style="background-color:' . wp_rem_hex2rgba($search_background_color, '0.7') . ' !important;"';
            }
            if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
                echo '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
            }
            wp_enqueue_script('wp-rem-property-functions');
            wp_enqueue_script('wp_rem_location_autocomplete_js');
            $wp_rem_loc_strings = array(
                'plugin_url' => wp_rem::plugin_url(),
                'ajax_url' => admin_url('admin-ajax.php'),
            );
            if ( $propertysearch_view == 'list' ) {
                ?>
                <div class="main-search" id="wp-rem-property-content-<?php echo esc_html($property_short_counter); ?>">
                    <?php
                    $wp_rem_element_structure = '';
                    $wp_rem_element_structure .= wp_rem_plugin_title_sub_align($propertysearch_title, $propertysearch_subtitle, $propertysearch_alignment);
                    echo force_balance_tags($wp_rem_element_structure);
                    $property_arg = array(
                        'property_short_counter' => $property_short_counter,
                        'atts' => $atts,
                        'content' => $content,
                    );
                    $this->wp_rem_propertysearch_content($property_arg);
                    ?>
                </div>
            <?php } else if ( $propertysearch_view == 'classic' ) {
                ?>
                <div class="main-search classic" id="wp-rem-property-content-<?php echo esc_html($property_short_counter); ?>">
                    <?php
                    $wp_rem_element_structure = '';
                    $wp_rem_element_structure .= wp_rem_plugin_title_sub_align($propertysearch_title, $propertysearch_subtitle, $propertysearch_alignment);
                    echo force_balance_tags($wp_rem_element_structure);
                    $property_arg = array(
                        'property_short_counter' => $property_short_counter,
                        'atts' => $atts,
                        'content' => $content,
                    );
                    $this->wp_rem_propertysearch_content($property_arg);
                    ?>
                </div>
            <?php } elseif ( $propertysearch_view == 'modern' ) {
                ?>
                <div class="main-search modern v2" id="wp-rem-property-content-<?php echo esc_html($property_short_counter); ?>">
                    <?php
                    $wp_rem_element_structure = '';
                    $wp_rem_element_structure .= wp_rem_plugin_title_sub_align($propertysearch_title, $propertysearch_subtitle, $propertysearch_alignment);
                    echo force_balance_tags($wp_rem_element_structure);
                    $property_arg = array(
                        'property_short_counter' => $property_short_counter,
                        'atts' => $atts,
                        'content' => $content,
                    );
                    $this->wp_rem_propertysearch_content($property_arg);
                    ?>
                </div>
            <?php } elseif ( $propertysearch_view == 'modern_v2' ) {
                ?>
                <div class="main-search modern v3" id="wp-rem-property-content-<?php echo esc_html($property_short_counter); ?>" <?php echo wp_rem_allow_special_char($medern_v2_search_backg_color_style); ?>>

                    <?php if ( ! empty($propertysearch_title) ) { ?>
                        <p class="search-heading" <?php echo wp_rem_allow_special_char($element_color_title); ?>>
                            <?php echo esc_html($propertysearch_title); ?>
                        </p>
                    <?php } ?>
                    <?php
                    $property_arg = array(
                        'property_short_counter' => $property_short_counter,
                        'atts' => $atts,
                        'content' => $content,
                    );
                    $this->wp_rem_propertysearch_content($property_arg);
                    ?>
                </div>
            <?php } elseif ( $propertysearch_view == 'modern_v3' ) {
                ?>
                <div class="main-search modern v3 small-search" id="wp-rem-property-content-<?php echo esc_html($property_short_counter); ?>" <?php echo wp_rem_allow_special_char($search_backg_color_style); ?>>
                    <?php if ( ! empty($propertysearch_title) ) { ?>
                    <p class="search-heading" <?php echo wp_rem_allow_special_char($element_color_title); ?>>
                        <?php echo esc_html($propertysearch_title); ?>
                    </p>
                     <?php } ?>
                    <?php
                    $property_arg = array(
                        'property_short_counter' => $property_short_counter,
                        'atts' => $atts,
                        'content' => $content,
                    );
                    $this->wp_rem_propertysearch_content($property_arg);
                    ?>
                </div>
            <?php } elseif ( $propertysearch_view == 'simple' ) {
                ?>
                <div class="main-search simple v2" id="wp-rem-property-content-<?php echo esc_html($property_short_counter); ?>">
                    <?php
                    $wp_rem_element_structure = '';
                    $wp_rem_element_structure .= wp_rem_plugin_title_sub_align($propertysearch_title, $propertysearch_subtitle, $propertysearch_alignment);
                    echo force_balance_tags($wp_rem_element_structure);
                    $property_arg = array(
                        'property_short_counter' => $property_short_counter,
                        'atts' => $atts,
                        'content' => $content,
                    );
                    $this->wp_rem_propertysearch_content($property_arg);
                    ?>
                </div>
            <?php } elseif ( $propertysearch_view == 'advance' ) {
                ?>
                <div class="main-search advance" id="wp-rem-property-content-<?php echo esc_html($property_short_counter); ?>">
                    <?php
                    $wp_rem_element_structure = '';
                    $wp_rem_element_structure .= wp_rem_plugin_title_sub_align($propertysearch_title, $propertysearch_subtitle, $propertysearch_alignment);
                    echo force_balance_tags($wp_rem_element_structure);
                    $property_arg = array(
                        'property_short_counter' => $property_short_counter,
                        'atts' => $atts,
                        'content' => $content,
                    );
                    $this->wp_rem_propertysearch_content($property_arg);
                    ?>
                </div>
                <?php
            } elseif ( $propertysearch_view == 'fancy_v2' ) {
                $wp_rem_element_structure = '';
                $wp_rem_element_structure .= wp_rem_plugin_title_sub_align($propertysearch_title, $propertysearch_subtitle, $propertysearch_alignment);
                echo force_balance_tags($wp_rem_element_structure);
                ?>
                <div class="wp-rem-property-content main-search fancy v2" id="wp-rem-property-content-<?php echo esc_html($property_short_counter); ?>">
                    <ul id="nav-tabs-<?php echo esc_attr($property_short_counter); ?>" class="nav nav-tabs" role="tablist">
                        <li <?php echo wp_rem_allow_special_char($search_backg_color_style); ?> class="active"><a href="javascript:void(0);" onclick="wp_rem_advanced_search_field('<?php echo esc_attr($property_short_counter); ?>', 'simple', this);"><?php echo wp_rem_plugin_text_srt('wp_rem_listsearch_best_home'); ?></a></li>
                        <?php if ( $propertysearch_advance_filter_switch == 'yes' ) { ?>
                            <li <?php echo wp_rem_allow_special_char($search_backg_color_style); ?> class=""><a href="javascript:void(0);" onclick="wp_rem_advanced_search_field('<?php echo esc_attr($property_short_counter); ?>', 'advance', this);"><?php echo wp_rem_plugin_text_srt('wp_rem_listsearch_advanced'); ?></a></li>
                        <?php } ?>
                    </ul> 
                    <div <?php echo wp_rem_allow_special_char($search_backg_color_style); ?> id="Property-content-<?php echo esc_html($property_short_counter); ?>" class="tab-content">
                        <?php
                        $property_arg = array(
                            'property_short_counter' => $property_short_counter,
                            'atts' => $atts,
                            'content' => $content,
                        );
                        $this->wp_rem_propertysearch_content($property_arg);
                        ?>
                    </div>
                </div>
            <?php } elseif ( $propertysearch_view == 'fancy_v3' ) { ?>
                <div class="wp-rem-property-content main-search fancy v3" id="wp-rem-property-content-<?php echo esc_html($property_short_counter); ?>" <?php echo wp_rem_allow_special_char($medern_v2_search_backg_color_style); ?>>
                    <?php
                    $wp_rem_element_structure = '';
                    $wp_rem_element_structure .= wp_rem_plugin_title_sub_align($propertysearch_title, $propertysearch_subtitle, $propertysearch_alignment);
                    echo force_balance_tags($wp_rem_element_structure);
                    ?>
                    <?php
                    $property_arg = array(
                        'property_short_counter' => $property_short_counter,
                        'atts' => $atts,
                        'content' => $content,
                    );
                    $this->wp_rem_propertysearch_content($property_arg);
                    ?>
                </div>
            <?php } else { ?>
                <div class="wp-rem-property-content main-search fancy" id="wp-rem-property-content-<?php echo esc_html($property_short_counter); ?>">
                    <?php
                    $wp_rem_element_structure = '';
                    $wp_rem_element_structure .= wp_rem_plugin_title_sub_align($propertysearch_title, $propertysearch_subtitle, $propertysearch_alignment);
                    echo force_balance_tags($wp_rem_element_structure);
                    ?>
                    <ul id="nav-tabs-<?php echo esc_attr($property_short_counter); ?>" class="nav nav-tabs" role="tablist">
                        <li class="active"><a href="javascript:void(0);" onclick="wp_rem_advanced_search_field('<?php echo esc_attr($property_short_counter); ?>', 'simple', this);"><?php echo wp_rem_plugin_text_srt('wp_rem_listsearch_best_home'); ?></a></li>
                        <?php if ( $propertysearch_advance_filter_switch == 'yes' ) { ?>
                            <li class=""><a href="javascript:void(0);" onclick="wp_rem_advanced_search_field('<?php echo esc_attr($property_short_counter); ?>', 'advance', this);"><?php echo wp_rem_plugin_text_srt('wp_rem_listsearch_advanced'); ?></a></li>
                        <?php } ?>
                    </ul> 
                    <div id="Property-content-<?php echo esc_html($property_short_counter); ?>" class="tab-content">
                        <?php
                        $property_arg = array(
                            'property_short_counter' => $property_short_counter,
                            'atts' => $atts,
                            'content' => $content,
                        );
                        $this->wp_rem_propertysearch_content($property_arg);
                        ?>
                    </div>
                </div>
                <?php
            }
            if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
                echo '</div>';
            }
            $html = ob_get_clean();
            return $html;
        }

        public function wp_rem_propertysearch_content($property_arg = '') {
            global $wpdb, $wp_rem_form_fields_frontend, $wp_rem_plugin_options;
            // getting arg array from ajax

            if ( isset($property_arg) && $property_arg != '' && ! empty($property_arg) ) {
                extract($property_arg);
            }

            $default_date_time_formate = 'd-m-Y H:i:s';

            $element_property_sort_by = isset($atts['property_sort_by']) ? $atts['property_sort_by'] : 'no';
            $element_property_topmap = isset($atts['property_topmap']) ? $atts['property_topmap'] : 'no';
            $element_property_topmap_position = isset($atts['property_topmap_position']) ? $atts['property_topmap_position'] : 'full';
            $element_property_layout_switcher = isset($atts['property_layout_switcher']) ? $atts['property_layout_switcher'] : 'no';
            $element_property_layout_switcher_view = isset($atts['property_layout_switcher_view']) ? $atts['property_layout_switcher_view'] : 'grid';

            $element_property_search_keyword = isset($atts['property_search_keyword']) ? $atts['property_search_keyword'] : 'no';
            $property_property_featured = isset($atts['property_featured']) ? $atts['property_featured'] : 'all';

            $property_type = isset($atts['property_type']) ? $atts['property_type'] : '';
            $search_box = isset($atts['search_box']) ? $atts['search_box'] : 'no';
            $popup_link_text = isset($atts['popup_link_text']) ? $atts['popup_link_text'] : '';
            $wp_rem_search_result_page = isset($wp_rem_plugin_options['wp_rem_search_result_page']) ? $wp_rem_plugin_options['wp_rem_search_result_page'] : '';
            $wp_rem_search_result_page = ( $wp_rem_search_result_page != '' ) ? get_permalink($wp_rem_search_result_page) : '';
            $wp_rem_search_result_page_url = $wp_rem_search_result_page;
            $wp_rem_search_result_page_button_text = 'Default search';

            // defualt view
            if (get_the_ID() == '1180') {
                $wp_rem_search_result_page_button_text = 'Map view';
                $wp_rem_search_result_page_url = get_permalink('1985');
            } 
            // split view
            if (get_the_ID() == '1985') {
                $wp_rem_search_result_page = get_permalink('1985');
            } 

            // Property Search View
            $propertysearch_view = isset($atts['propertysearch_view']) ? $atts['propertysearch_view'] : 'fancy';

            set_query_var('property_arg', $property_arg);
            set_query_var('popup_link_text', $popup_link_text);
            set_query_var('content', $content);
            set_query_var('atts', $atts);
            set_query_var('wp_rem_search_result_page_url', $wp_rem_search_result_page_url);
            set_query_var('wp_rem_search_result_page', $wp_rem_search_result_page);
            set_query_var('wp_rem_search_result_page_button_text', $wp_rem_search_result_page_button_text);
            set_query_var('property_short_counter', $property_short_counter);
            if ( $propertysearch_view == 'list' ) {
                wp_rem_get_template_part('propertysearch', 'list-filters', 'propertysearch');
            } else if ( $propertysearch_view == 'classic' ) {
                wp_rem_get_template_part('propertysearch', 'classic-filters', 'propertysearch');
            } else if ( $propertysearch_view == 'modern' ) {
                wp_rem_get_template_part('propertysearch', 'modern-filters', 'propertysearch');
            } else if ( $propertysearch_view == 'modern_v2' ) {
                wp_rem_get_template_part('propertysearch', 'modern-v2-filters', 'propertysearch');
            } else if ( $propertysearch_view == 'modern_v3' ) {
                wp_rem_get_template_part('propertysearch', 'modern-v3-filters', 'propertysearch');
            } else if ( $propertysearch_view == 'simple' ) {
                wp_rem_get_template_part('propertysearch', 'simple-filters', 'propertysearch');
            } else if ( $propertysearch_view == 'advance' ) {
                wp_rem_get_template_part('propertysearch', 'advance-filters', 'propertysearch');
            } else if ( $propertysearch_view == 'fancy_v2' ) {
                wp_rem_get_template_part('propertysearch', 'fance-v2-filters', 'propertysearch');
            } else if ( $propertysearch_view == 'fancy_v3' ) {
                wp_rem_get_template_part('propertysearch', 'fance-v3-filters', 'propertysearch');
            } else {
                wp_rem_get_template_part('propertysearch', 'filters', 'propertysearch');
            }
            ?>
            <script>
                if (jQuery('.chosen-select, .chosen-select-deselect, .chosen-select-no-single, .chosen-select-no-results, .chosen-select-width').length != '') {
                    var config = {
                        '.chosen-select': {width: "100%"},
                        '.chosen-select-deselect': {allow_single_deselect: true},
                        '.chosen-select-no-single': {disable_search_threshold: 10, width: "100%", search_contains: true},
                        '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                        '.chosen-select-width': {width: "95%"}
                    };
                    for (var selector in config) {
                        jQuery(selector).chosen(config[selector]);
                    }
                }
            </script>
            <?php
            // only for ajax request
            if ( isset($_REQUEST['action']) ) {
                die();
            }
        }

    }

    global $wp_rem_shortcode_propertysearch_frontend;
    $wp_rem_shortcode_propertysearch_frontend = new Wp_rem_Shortcode_Propertiesearch_Frontend();
}

