<?php
/**
 * File Type: Search Fields
 */
if ( ! class_exists('Wp_rem_Search_Fields') ) {

    class Wp_rem_Search_Fields {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action('wp_rem_property_type_fields', array( $this, 'wp_rem_property_type_fields_callback' ));
            add_action('wp_rem_property_type_features', array( $this, 'wp_rem_property_type_features' ), 10, 2);
            add_action('wp_ajax_wp_rem_property_type_search_fields', array( $this, 'wp_rem_property_type_search_fields_callback' ));
            add_action('wp_ajax_nopriv_wp_rem_property_type_search_fields', array( $this, 'wp_rem_property_type_search_fields_callback' ));
            add_action('wp_ajax_wp_rem_property_type_cate_fields', array( $this, 'wp_rem_property_type_cate_fields_callback' ));
            add_action('wp_ajax_nopriv_wp_rem_property_type_cate_fields', array( $this, 'wp_rem_property_type_cate_fields_callback' ));
			
			add_action('wp_ajax_wp_rem_property_type_price_type_field', array( $this, 'wp_rem_property_type_price_type_field_callback' ));
            add_action('wp_ajax_nopriv_wp_rem_property_type_price_type_field', array( $this, 'wp_rem_property_type_price_type_field_callback' ));
        }
		
		public function wp_rem_property_type_price_type_field_callback() {
            global $wp_rem_form_fields_frontend, $wp_rem_plugin_options;
            $property_short_counter = wp_rem_get_input('property_short_counter', 0);
            $property_type_slug = wp_rem_get_input('property_type_slug', NULL, 'STRING');
            $price_type_switch = wp_rem_get_input('price_type_switch', NULL, 'STRING');
            $search_view = wp_rem_get_input('view', NULL, 'STRING');
            $search_view = isset($search_view) ? $search_view : '';
			
			$property_type_id = $this->wp_rem_property_type_id_by_slug($property_type_slug);
			$property_type_price_type = get_post_meta($property_type_id, 'wp_rem_property_type_price_type', true);
			
			$price_type_options = array(
                'variant_week' => wp_rem_plugin_text_srt('wp_rem_list_meta_per_week'),
                'variant_month' => wp_rem_plugin_text_srt('wp_rem_list_meta_per_cm'),
            );
			if ( $property_type_price_type == 'fixed' ) {
                $price_type_options = isset($wp_rem_plugin_options['fixed_price_opt']) ? $wp_rem_plugin_options['fixed_price_opt'] : '';
            }
			$price_types = array( '' => wp_rem_plugin_text_srt('wp_rem_advance_search_select_price_types_all') );
			$price_types = array_merge($price_types, $price_type_options);
			
            $json = array();
            $json['type'] = "error";
            if ( $property_type_slug != '' ) {
                ob_start();
				if ( isset($price_type_switch) && $price_type_switch == 'yes' && !empty($price_type_options) ) { ?> 
					<strong class="search_title"><?php echo wp_rem_plugin_text_srt('wp_rem_advance_search_select_price_type_label'); ?></strong>
                    <label>
						<?php
                        $wp_rem_opt_array = array(
							'std' => '',
							'cust_id' => 'price_type',
							'cust_name' => 'price_type',
							'classes' => 'chosen-select',
							'options' => $price_types,
						);
						if ( count($price_types) <= 6 ) {
							$wp_rem_opt_array['classes'] = 'chosen-select-no-single';
						}
						$wp_rem_form_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array);
                        ?>
                    </label>
                <?php } ?>

                <?php
                ?>
                <script type="text/javascript">
                    chosen_selectionbox();
                </script>
                <?php
                $content = ob_get_clean();
                $json['type'] = "success";
                $json['html'] = $content;
            }
            echo json_encode($json);
            wp_die();
        }

        public function wp_rem_property_type_features($list_type_slug = '', $property_short_counter) {
            global $wp_rem_form_fields_frontend;
            $property_type_id = $this->wp_rem_property_type_id_by_slug($list_type_slug);
            $property_type_features = get_post_meta($property_type_id, 'feature_lables', true);
            $feature_icons = get_post_meta($property_type_id, 'wp_rem_feature_icon', true);

            if ( is_array($property_type_features) && sizeof($property_type_features) > 0 ) {
                ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 features-list">
                    <strong class="advance-trigger"><?php echo wp_rem_plugin_text_srt('wp_rem_search_fields_other_features'); ?></strong>
                    <div class="clearfix"></div>
                    <div class="features-field-expand">
                        <ul id="search-features-list" class="search-features-list">
                            <?php
                            $feature_counter = 1;
                            $html = '';
                            foreach ( $property_type_features as $feat_key => $feature ) {
                                if ( isset($feature) && ! empty($feature) ) {
                                    $feature_name = isset($feature) ? $feature : '';
                                    $feature_icon = isset($feature_icons[$feat_key]) ? $feature_icons[$feat_key] : '';
                                    $count_feature_properties = $this->property_search_features_properties($list_type_slug, $feature_name);
                                    $html .= '<li class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="checkbox">';
                                    $html .=$wp_rem_form_fields_frontend->wp_rem_form_text_render(
                                            array(
                                                'std' => esc_attr($feature_name),
                                                'cust_id' => 'check-' . $feature_counter . '',
                                                'return' => true,
                                                'classes' => 'search-feature-' . $property_short_counter . '',
                                                'cust_type' => 'checkbox',
                                                'prefix_on' => false,
                                            )
                                    );
                                    $html .= '    <label for="check-' . $feature_counter . '">' . $feature_name . ' (' . $count_feature_properties . ')</label>
                                                        </div>
                                                </li>';
                                    $feature_counter ++;
                                }
                            }
                            $html .= '<li class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="display:none;">';
                            $html .= $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                                    array(
                                        'return' => true,
                                        'cust_name' => 'features',
                                        'cust_id' => 'search-property-features-' . $property_short_counter . '',
                                        'std' => '',
                                    )
                            );
                            $html .= '</li>';
                            echo wp_rem_allow_special_char($html);
                            ?>
                            <script type="text/javascript">
                                jQuery(document).ready(function () {
                                    'use strict'
                                    var $checkboxes = jQuery("input[type=checkbox].search-feature-<?php echo esc_html($property_short_counter); ?>");
                                    var features = $checkboxes.filter(':checked').map(function () {
                                        return this.value;
                                    }).get().join(',');
                                    jQuery('#search-property-features-<?php echo esc_html($property_short_counter); ?>').val(features);
                                });
                                //jQuery(function () {
                                //'use strict'
                                var $checkboxes = jQuery("input[type=checkbox].search-feature-<?php echo esc_html($property_short_counter); ?>");
                                $checkboxes.on('change', function () {
                                    var features = $checkboxes.filter(':checked').map(function () {
                                        return this.value;
                                    }).get().join(',');
                                    jQuery('#search-property-features-<?php echo esc_html($property_short_counter); ?>').val(features);
                                });

                                //});
                            </script>
                        </ul>
                    </div>
                </div>
                <?php
            }
        }

        function property_search_features_properties($property_type_slug = '', $feature_name) {

            if ( $property_type_slug != '' && $feature_name != '' ) {
                $args['post_type'] = 'properties';
                $args['posts_per_page'] = 1;
                $args['fields'] = 'ids'; // only load ids
                $args['meta_query']['relation'] = 'AND';
                $args['meta_query'][] = array(
                    'key' => 'wp_rem_property_type',
                    'value' => $property_type_slug,
                    'compare' => '=',
                );
                $args['meta_query'][] = array(
                    'key' => 'wp_rem_property_feature_list',
                    'value' => $feature_name,
                    'compare' => 'LIKE',
                    'type' => 'CHAR'
                );

                $feature_query = new WP_Query($args);
                return $feature_query->found_posts;
                wp_reset_postdata();
            }
        }

        public function wp_rem_property_type_search_fields_callback() {
            global $wp_rem_form_fields_frontend;

            $property_short_counter = wp_rem_get_input('property_short_counter', 0);
            $property_type_slug = wp_rem_get_input('property_type_slug', NULL, 'STRING');
            //$cats_switch           = wp_rem_get_input( 'cats_switch', NULL, 'STRING' );
            $price_switch = wp_rem_get_input('price_switch', NULL, 'STRING');
            $json = array();
            $json['type'] = "error";
            if ( $property_type_slug != '' ) {
                ob_start();
                if ( isset($price_switch) && $price_switch == 'yes' ) {
                    ?>
                    <?php
                    $args = array(
                        'name' => $property_type_slug,
                        'post_type' => 'property-type',
                        'post_status' => 'publish',
                        'numberposts' => 1,
                    );
                    $my_posts = get_posts($args);
                    if ( $my_posts ) {
                        $property_type_id = $my_posts[0]->ID;
                    }
                    // print '<pre>';
                    // var_dump(get_post_meta( $property_type_id));
                    // print '</pre>';
                    $price_type = get_post_meta($property_type_id, 'wp_rem_property_type_price_type', true);
                    // $wp_rem_price_minimum_options = get_post_meta($property_type_id, 'wp_rem_price_minimum_options', true);
                    // $wp_rem_price_minimum_options = ( ! empty($wp_rem_price_minimum_options) ) ? $wp_rem_price_minimum_options : 1;
                    // $wp_rem_price_max_options = get_post_meta($property_type_id, 'wp_rem_price_max_options', true);
                    // $wp_rem_price_max_options = ( ! empty($wp_rem_price_max_options) ) ? $wp_rem_price_max_options : 50; //50000;
                    // $wp_rem_price_interval = get_post_meta($property_type_id, 'wp_rem_price_interval', true);
                    // $wp_rem_price_interval = ( ! empty($wp_rem_price_interval) ) ? $wp_rem_price_interval : 50;
                    $price_type_options = array();
                    // $wp_rem_price_interval = (int) $wp_rem_price_interval;
                    // $price_counter = $wp_rem_price_minimum_options;
                    $price_min = array();
                    $price_max = array();
                    // $price_min[''] = wp_rem_plugin_text_srt('wp_rem_search_filter_min_price');
                    // $price_max[''] = wp_rem_plugin_text_srt('wp_rem_search_filter_max_price');
                    // CALCULATING VALUES FOR PRICE FILTERS

                    // default theme way
                    // while ( $price_counter <= $wp_rem_price_max_options ) {

                    //     $price_min[$price_counter] = $price_counter;
                    //     $price_max[$price_counter] = $price_counter;
                    //     $price_counter = $price_counter + $wp_rem_price_interval;
                    // }

                    // custom way - doesn't loaded
                    // $max_price = $wp_rem_price_max_options;
                    // $next_price = $wp_rem_price_minimum_options;
                    // $price_min[$next_price] = $next_price;
                    // $price_max[$next_price] = $next_price;
                    // while( $next_price < $max_price ){
                    //     if( $next_price < 10000 ){
                    //         $next_price += $wp_rem_price_interval * 100;
                    //     } else if( $next_price < 100000) {
                    //         $next_price += $wp_rem_price_interval * 1000;
                    //     } else if( $next_price < 1000000 ){
                    //         $next_price += $wp_rem_price_interval * 10000;
                    //     } else if( $next_price < 10000000 ){
                    //         $next_price += $wp_rem_price_interval * 100000;
                    //     } else if( $next_price < 100000000 ){
                    //         $next_price += $wp_rem_price_interval * 1000000;
                    //     }else if( $next_price < 1000000000 ){
                    //         $next_price += $wp_rem_price_interval * 10000000;
                    //     } else {
                    //         $next_price += $wp_rem_price_interval * 10000000;
                    //     }
                    //     $price_min[$next_price] = $next_price;
                    //     $price_max[$next_price] = $next_price;
                    // }
                    // $price_min['>'.$max_price] = $max_price;
                    // $price_max['>'.$max_price] = $max_price;

                    // hardcore way - for speed reason
                    $price_min = kk_get_price_filter_values( $property_type_id, wp_rem_plugin_text_srt('wp_rem_search_filter_min_price') );
                    $price_max = kk_get_price_filter_values( $property_type_id, wp_rem_plugin_text_srt('wp_rem_search_filter_max_price') );
                    ?>

                    <?php
                    if ( $price_type == 'variant' ) {
                        $price_type_options = array(
                            '' => wp_rem_plugin_text_srt('wp_rem_search_fields_price_type_all'),
                            'variant_week' => wp_rem_plugin_text_srt('wp_rem_search_fields_price_type_per_week'),
                            'variant_month' => wp_rem_plugin_text_srt('wp_rem_search_fields_price_type_per_month'),
                        );
                        ?>
                        <div class="field-holder select-dropdown price-type">
                            <div class="select-categories">
                                <ul>
                                    <li>
                                        <?php
                                        $price_type_checked = ( isset($_REQUEST['price_type']) && $_REQUEST['price_type'] ) ? $_REQUEST['price_type'] : '';
                                        $wp_rem_form_fields_frontend->wp_rem_form_select_render(
                                                array(
                                                    'simple' => true,
                                                    'cust_name' => 'price_type',
                                                    'std' => $price_type_checked,
                                                    'classes' => 'chosen-select-no-single',
                                                    'options' => $price_type_options,
                                                    'extra_atr' => 'onchange="wp_rem_property_content(\'' . $property_short_counter . '\');"',
                                                )
                                        );
                                        ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="field-holder select-dropdown">
                        <div class="wp-rem-min-max-price">
                            <div class="select-categories"> 
                                <ul>
                                    <li>
                                        <?php
                                        $price_min_checked = ( isset($_REQUEST['price_minimum']) && $_REQUEST['price_minimum'] ) ? $_REQUEST['price_minimum'] : '';
                                        $wp_rem_form_fields_frontend->wp_rem_form_select_render(
                                                array(
                                                    'simple' => true,
                                                    'cust_name' => 'price_minimum',
                                                    'std' => $price_min_checked,
                                                    'classes' => 'chosen-select-no-single',
                                                    'options' => $price_min,
                                                    'extra_atr' => 'onchange="wp_rem_property_content(\'' . $property_short_counter . '\');"',
                                                    'price' => true
                                                )
                                        );
                                        ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="select-categories"> 

                                <ul>
                                    <li>
                                        <?php
                                        $price_max_checked = ( isset($_REQUEST['price_maximum']) && $_REQUEST['price_maximum'] ) ? $_REQUEST['price_maximum'] : '';
                                        $wp_rem_form_fields_frontend->wp_rem_form_select_render(
                                                array(
                                                    'simple' => true,
                                                    'cust_name' => 'price_maximum',
                                                    'std' => $price_max_checked,
                                                    'classes' => 'chosen-select-no-single',
                                                    'options' => $price_max,
                                                    'extra_atr' => 'onchange="wp_rem_property_content(\'' . $property_short_counter . '\');"',
                                                    'price' => true
                                                )
                                        );
                                        ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php
                $this->wp_rem_property_type_fields_callback($property_type_slug);
                $this->wp_rem_property_type_features($property_type_slug, $property_short_counter);
                ?>
                <script type="text/javascript">
                    chosen_selectionbox();
                   // kk_price_filter_handler('select[name=price_minimum]', 'select[name=price_maximum]');
                </script>
                <?php
                $content = ob_get_clean();
                $json['type'] = "success";
                $json['html'] = $content;
            }
            echo json_encode($json);
            wp_die();
        }

        public function wp_rem_property_type_cate_fields_callback() {
            global $wp_rem_form_fields_frontend;
            $property_short_counter = wp_rem_get_input('property_short_counter', 0);
            $property_type_slug = wp_rem_get_input('property_type_slug', NULL, 'STRING');
            $cats_switch = wp_rem_get_input('cats_switch', NULL, 'STRING');
            $search_view = wp_rem_get_input('view', NULL, 'STRING');
            $search_view = isset($search_view) ? $search_view : '';

            $wp_rem_search_label_color = wp_rem_get_input('color', NULL, 'STRING');
            $wp_rem_search_label_color = isset($wp_rem_search_label_color) ? $wp_rem_search_label_color : '';


            if ( isset($wp_rem_search_label_color) && $wp_rem_search_label_color != '' && $wp_rem_search_label_color != 'none' ) {
                $label_style_colr = 'style="color:' . $wp_rem_search_label_color . ' !important"';
            }

            $json = array();
            $json['type'] = "error";
            if ( $property_type_slug != '' ) {
                ob_start();

                $property_cats_array = $this->wp_rem_property_type_categories_options($property_type_slug);

                if ( isset($cats_switch) && $cats_switch == 'yes' && ! empty($property_cats_array) ) {

                    if ( ! empty($search_view) && $search_view == 'modern' ) {
                        ?>
                        <strong class="search-title" <?php echo wp_rem_allow_special_char($label_style_colr); ?>><?php echo wp_rem_plugin_text_srt('wp_rem_property_search_view_enter_property_type_label'); ?></strong>
                    <?php } ?>    
                    <label>
						<?php if ( ! empty($search_view) && $search_view != 'modern-v2' && $search_view != 'fancy-v3' ) { ?>
							<i class="icon-home"></i>
						<?php } ?>
                        <?php
                        $wp_rem_opt_array = array(
                            'std' => (isset($_REQUEST['property_category']) && $_REQUEST['property_category'] != '') ? $_REQUEST['property_category'] : '',
                            'id' => 'wp_rem_property_category',
                            'classes' => 'chosen-select',
                            'cust_name' => 'property_category',
                            'options' => $property_cats_array,
                        );
                        if ( count($property_cats_array) <= 6 ) {
                            $wp_rem_opt_array['classes'] = 'chosen-select-no-single';
                        }
                        $wp_rem_form_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array);
                        ?>
                    </label>
                <?php } ?>

                <?php
                ?>
                <script type="text/javascript">
                    chosen_selectionbox();
                </script>
                <?php
                $content = ob_get_clean();
                $json['type'] = "success";
                $json['html'] = $content;
            }
            echo json_encode($json);
            wp_die();
        }

        public function wp_rem_property_type_fields_callback($list_type_slug = '') {
            global $wp_rem_form_fields;
            $advanced_filter = false;
            if ( $list_type_slug != '' ) {

                $property_type_id = $this->wp_rem_property_type_id_by_slug($list_type_slug);
                if ( $property_type_id != 0 ) {
                    $property_type_fields = get_post_meta($property_type_id, 'wp_rem_property_type_cus_fields', true);
                    if ( isset($property_type_fields) && is_array($property_type_fields) && ! empty($property_type_fields) ) {
                        foreach ( $property_type_fields as $property_type_field ) {
                            $field_type = isset($property_type_field['type']) ? $property_type_field['type'] : '';
                            $field_enable_srch = isset($property_type_field['enable_srch']) ? $property_type_field['enable_srch'] : '';
                            if ( $field_enable_srch == 'yes' ) {
                                if ( $field_type == 'date' ) {
                                    $this->wp_rem_date_field($property_type_field);
                                } else if ( $field_type == 'range' ) {
                                    $this->wp_rem_range_field($property_type_field);
                                } else {
                                    echo force_balance_tags($this->wp_rem_common_field($property_type_field));
                                }
                                $advanced_filter = true;
                            }
                        }
                    }
                }
            }
        }

        public function wp_rem_property_type_id_by_slug($list_type_slug = '') {
            if ( $post = get_page_by_path($list_type_slug, OBJECT, 'property-type') ) {
                return $property_type_id = $post->ID;
            } else {
                return $property_type_id = 0;
            }
        }

        public function wp_rem_common_field($custom_field = '') {
            global $wp_rem_form_fields;
            $field_counter = rand(12345, 54321);
            $field_type = isset($custom_field['type']) ? $custom_field['type'] : '';
            $field_label = isset($custom_field['label']) ? $custom_field['label'] : '';
            $field_meta_key = isset($custom_field['meta_key']) ? $custom_field['meta_key'] : '';
            $field_placeholder = isset($custom_field['placeholder']) ? $custom_field['placeholder'] : '';
            $field_default_value = isset($custom_field['default_value']) ? $custom_field['default_value'] : '';
            $field_size = isset($custom_field['field_size']) ? $custom_field['field_size'] : '';
            $field_fontawsome_icon = isset($custom_field['fontawsome_icon']) ? $custom_field['fontawsome_icon'] : '';
            $field_required = isset($custom_field['required']) ? $custom_field['required'] : '';

            $output = '';

            if ( $field_meta_key != '' ) {

                // Field Options
                $wp_rem_opt_array = array();
                $wp_rem_opt_array['std'] = esc_attr($field_default_value);
                $wp_rem_opt_array['label'] = $field_label;
                $wp_rem_opt_array['cust_id'] = $field_meta_key;
                $wp_rem_opt_array['cust_name'] = $field_meta_key;
                $wp_rem_opt_array['extra_atr'] = $this->wp_rem_field_placeholder($field_placeholder);
                $wp_rem_opt_array['classes'] = 'input-field';
                $wp_rem_opt_array['return'] = true;
                // End Field Options

                $field_size = $this->wp_rem_field_size($field_size);
                $field_icon = $this->wp_rem_field_icon($field_fontawsome_icon);
                $has_icon = '';
                if ( $field_icon != '' ) {
                    $has_icon = 'has-icon';
                }

                // Making Field with defined options
                if ( $field_type == 'text' || $field_type == 'url' || $field_type == 'email' ) {
                    $output .= '<div class="field-holder search-input ' . esc_html($has_icon) . '">';
                    //$output .= '<h6>'. esc_html($field_label) .'</h6>';
                    $output .= '<label>';
                    $output .= $field_icon;
                    $output .= $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                    $output .= '</label>';
                    $output .= '</div>' . "\n";
                } elseif ( $field_type == 'number' ) {//return '';
                    if ( isset($_GET[$field_meta_key]) ) {
                        $field_default_value = $_GET[$field_meta_key];
                    }

                    $wp_rem_form_fields->wp_rem_form_hidden_render(
                            array(
                                'simple' => true,
                                'cust_id' => "number-hidden1-" . $field_meta_key,
                                'cust_name' => wp_rem_allow_special_char($field_meta_key),
                                'std' => isset($field_default_value) && $field_default_value != '' ? $field_default_value : 0,
                            )
                    );
                    ?>
                    <div class="field-holder search-input select-categories <?php echo esc_html($has_icon); ?>">
                            <!--<h6><?php //echo esc_html($field_label);          ?></h6>-->
                        <ul class="minimum-loading-list">
                            <li>
                                <div class="spinner-btn input-group spinner">
                                    <span><?php echo $field_icon; ?></span>
                                    <?php
                                    $wp_rem_form_fields->wp_rem_form_text_render(
                                            array(
                                                'id' => 'wp_rem_' . $field_meta_key,
                                                'cust_name' => '',
                                                'classes' => "num-input1" . esc_html($field_meta_key) . " form-control",
                                                'std' => isset($field_default_value) && $field_default_value != '' ? $field_default_value : 0,
                                                'force_std' => true,
                                            )
                                    );
                                    ?>
                                    <span class="list-text"><?php echo esc_html($field_label); ?></span>
                                    <div class="input-group-btn-vertical">
                                        <button class="btn-decrement1<?php echo esc_html($field_meta_key); ?> caret-btn btn-default " type="button"><i class="icon-minus-circle"></i></button>
                                        <button class="btn-increment1<?php echo esc_html($field_meta_key); ?> caret-btn btn-default" type="button"><i class="icon-plus-circle"></i></button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <script type="text/javascript">
                            jQuery(document).ready(function ($) {
                                $(".num-input1<?php echo esc_html($field_meta_key); ?>").keypress(function (e) {
                                    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                        return false;
                                    }
                                });
                                $('.spinner .btn-increment1<?php echo esc_html($field_meta_key); ?>').on('click', function () {

                                    var field_value = $('.spinner .num-input1<?php echo esc_html($field_meta_key); ?>').val();

                                    field_value = field_value || 0;

                                    $('.spinner .num-input1<?php echo esc_html($field_meta_key); ?>').val(parseInt(field_value, 10) + 1);
                                    var selected_num = parseInt(field_value, 10) + 1;
                                    $('#number-hidden1-<?php echo esc_html($field_meta_key); ?>').val(selected_num);
                                });
                                $('.spinner .btn-decrement1<?php echo esc_html($field_meta_key); ?>').on('click', function () {
                                    var field_value = $('.spinner .num-input1<?php echo esc_html($field_meta_key); ?>').val();
                                    field_value = field_value || 0;
                                    var val = parseInt(field_value, 10);
                                    if (val < 1) {
                                        //return;
                                    }
                                    var minus_val = val - 1;
                                    if (minus_val < 0) {
                                        minus_val = 0;
                                    }
                                    $('.spinner .num-input1<?php echo esc_html($field_meta_key); ?>').val(minus_val);
                                    var selected_num = minus_val;
                                    $('#number-hidden1-<?php echo esc_html($field_meta_key); ?>').val(selected_num);
                                });
                                $(".num-input1<?php echo esc_html($field_meta_key); ?>").on('change keydown', function () {
                                    var field_value = $('.spinner .num-input1<?php echo esc_html($field_meta_key); ?>').val();
                                    field_value = field_value || 0;
                                    var selected_num = field_value;
                                    $('#number-hidden1-<?php echo esc_html($field_meta_key); ?>').val(selected_num);
                                });
                            });
                        </script>
                        <?php ?>
                    </div>
                    <?php
                } elseif ( $field_type == 'dropdown' ) {
                    $output .= '<div class="field-holder select-dropdown ' . esc_html($has_icon) . '">';
                    //$output .= '<h6>'. esc_html($field_label) .'</h6>';
                    $output .= '<label>';
                    $output .= $field_icon;
                    $output .= $this->wp_rem_dropdown_field($custom_field, $wp_rem_opt_array, $field_counter);
                    $output .= '</label>';
                    $output .= '</div>' . "\n";
                }
            }
            return $output;
        }

        public function wp_rem_dropdown_field($custom_field = '', $wp_rem_opt_array = '', $field_counter = '') {
            global $wp_rem_form_fields;

            $field_meta_key = isset($custom_field['meta_key']) ? $custom_field['meta_key'] : '';
            $output = '';
            if ( ! empty($wp_rem_opt_array) ) {
                $drop_down_options = array();
                if ( isset($custom_field['options']) && ! empty($custom_field['options']) ) {
                    $first_value = isset($custom_field['label']) ? $custom_field['label'] : '';
                    if ( $first_value != '' ) {
                        $drop_down_options[''] = esc_html($first_value);
                    }
                    foreach ( $custom_field['options']['label'] as $key => $value ) {
                        $drop_down_options[esc_html($custom_field['options']['value'][$key])] = esc_html($value);
                    }
                }
                $wp_rem_opt_array['options'] = $drop_down_options;

                if ( isset($custom_field['chosen_srch']) && $custom_field['chosen_srch'] == 'yes' && count($drop_down_options) > 5 ) {
                    $wp_rem_opt_array['classes'] = 'chosen-select';
                } else {
                    $wp_rem_opt_array['classes'] = 'chosen-select-no-single';
                }
                if ( isset($custom_field['multi']) && $custom_field['multi'] == 'yes' ) {
                    ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function () {
                            jQuery('#<?php echo $field_meta_key; ?>_<?php echo $field_counter; ?>').on('change', function () {
                                var selected_val = jQuery(this).val();
                                console.log(selected_val);
                                jQuery('#wp_rem_<?php echo $field_meta_key; ?>_<?php echo $field_counter; ?>').val(selected_val);
                            });
                        });
                    </script>
                    <?php
                    $wp_rem_hidden_opt_array = array(
                        'id' => $field_meta_key . '_' . $field_counter,
                        'cust_name' => $field_meta_key,
                        'std' => '',
                        'return' => true,
                        'force_std' => true,
                    );
                    $output .= $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_hidden_opt_array);
                    $wp_rem_opt_array['cust_id'] = $field_meta_key . '_' . $field_counter;
                    $wp_rem_opt_array['cust_name'] = '';
                    $output .= $wp_rem_form_fields->wp_rem_form_multiselect_render($wp_rem_opt_array);
                } else {
                    $output .= $wp_rem_form_fields->wp_rem_form_select_render($wp_rem_opt_array);
                }
            }
            return $output;
        }

        public function wp_rem_date_field($custom_field = '') {
            global $wp_rem_form_fields;
            $field_counter = rand(12345, 54321);

            $query_str_var_name = isset($custom_field['meta_key']) ? $custom_field['meta_key'] : '';
            $field_label = isset($custom_field['label']) ? $custom_field['label'] : '';
            $field_fontawsome_icon = isset($custom_field['fontawsome_icon']) ? $custom_field['fontawsome_icon'] : '';
            $field_icon = $this->wp_rem_field_icon($field_fontawsome_icon);
            wp_enqueue_script('bootstrap-datepicker');
            wp_enqueue_style('datetimepicker');
            wp_enqueue_style('datepicker');
            wp_enqueue_script('datetimepicker');
            ?>

            <div class="cs-datepicker field-datepicker field-holder search-input">

                <label id="Deadline" class="cs-calendar-from-<?php echo $field_counter; ?>">
                    <?php echo wp_rem_allow_special_char($field_icon); ?>
                    <?php
                    $wp_rem_form_fields->wp_rem_form_text_render(
                            array(
                                'id' => $query_str_var_name,
                                'cust_name' => 'from' . $query_str_var_name,
                                'classes' => '',
                                'std' => isset($_REQUEST['from' . $query_str_var_name]) ? $_REQUEST['from' . $query_str_var_name] : '',
                                'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_search_fields_date_from') . ' ' . $field_label . '");"',
                            )
                    );
                    ?>

                </label>
            </div>
            <div class="cs-datepicker field-datepicker field-holder search-input">
                <label id="Deadline" class="cs-calendar-to-<?php echo $field_counter; ?>">
                    <?php echo wp_rem_allow_special_char($field_icon); ?>
                    <?php
                    $wp_rem_form_fields->wp_rem_form_text_render(
                            array(
                                'id' => $query_str_var_name,
                                'cust_name' => 'to' . $query_str_var_name,
                                'classes' => '',
                                'std' => isset($_REQUEST['to' . $query_str_var_name]) ? $_REQUEST['to' . $query_str_var_name] : '',
                                'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_search_fields_date_to') . ' ' . $field_label . '");"',
                            )
                    );
                    ?>

                </label>
            </div>
            <?php
            if ( ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
                echo '<script type="text/javascript">
						if (jQuery(".cs-calendar-from-' . $field_counter . ' input").length != "") {
							jQuery(".cs-calendar-from-' . $field_counter . ' input").datetimepicker({
                                minDate: new Date(),
								timepicker:false,
								format:	"Y/m/d",
								scrollInput: false
							});
						}
						if (jQuery(".cs-calendar-to-' . $field_counter . ' input").length != "") {
							jQuery(".cs-calendar-to-' . $field_counter . ' input").datetimepicker({
                                minDate: new Date(),
								timepicker:false,
								format:	"Y/m/d",
								scrollInput: false
							});
						}
					</script>';
            } else {
                echo '<script type="text/javascript">
						jQuery(window).load(function(){
								if (jQuery(".cs-calendar-from-' . $field_counter . ' input").length != "") {
								jQuery(".cs-calendar-from-' . $field_counter . ' input").datetimepicker({
                                    minDate: new Date(),
									timepicker:false,
									format:	"Y/m/d",
									scrollInput: false
								});
							}
							if (jQuery(".cs-calendar-to-' . $field_counter . ' input").length != "") {
								jQuery(".cs-calendar-to-' . $field_counter . ' input").datetimepicker({
                                    minDate: new Date(),
									timepicker:false,
									format:	"Y/m/d",
									scrollInput: false
								});
							}
						});
					</script>';
            }
            ?>

            <?php
        }

        public function wp_rem_range_field($custom_field = '') {
            global $wp_rem_form_fields, $wp_rem_form_fields_frontend;
            $range_min = $custom_field['min'];
            $field_label = isset($custom_field['label']) ? $custom_field['label'] : '';
            $range_max = $custom_field['max'];
            $range_increment = $custom_field['increment'];
            $query_str_var_name = $custom_field['meta_key'];
            $filed_type = $custom_field['srch_style']; //input, slider, input_slider
            if ( strpos($filed_type, '-') !== FALSE ) {
                $filed_type_arr = explode("_", $filed_type);
            } else {
                $filed_type_arr[0] = $filed_type;
            }
            $range_flag = 0;
            $rand_id = rand(12345, 54321);
            ?>
            <div class="field-holder <?php
            if ( $filed_type_arr[$range_flag] == 'slider' ) {
                echo 'field-range';
            } else {
                echo 'select-dropdown has-icon';
            }
            ?>">
                     <?php
                     while ( count($filed_type_arr) > $range_flag ) {
                         if ( $filed_type_arr[$range_flag] == 'slider' ) { // if slider style
                             if ( (isset($custom_field['min']) && $custom_field['min'] != '') && (isset($custom_field['max']) && $custom_field['max'] != '' ) ) {
                                 $range_complete_str_first = "";
                                 $range_complete_str_second = "";
                                 $range_complete_str = '';
                                 if ( isset($_REQUEST[$query_str_var_name]) ) {
                                     $range_complete_str = $_REQUEST[$query_str_var_name];
                                     $range_complete_str_arr = explode(",", $range_complete_str);
                                     $range_complete_str_first = isset($range_complete_str_arr[0]) ? $range_complete_str_arr[0] : '';
                                     $range_complete_str_second = isset($range_complete_str_arr[1]) ? $range_complete_str_arr[1] : '';
                                 } else {
                                     $range_complete_str = $custom_field['min'] . ',' . $custom_field['max'];
                                     $range_complete_str_first = $custom_field['min'];
                                     $range_complete_str_second = $custom_field['max'];
                                 }

                                 $wp_rem_form_fields->wp_rem_form_hidden_render(
                                         array(
                                             'simple' => true,
                                             'cust_id' => "range-hidden-" . $query_str_var_name,
                                             'cust_name' => $query_str_var_name,
                                             'std' => esc_html($range_complete_str),
                                             'classes' => $query_str_var_name,
                                         )
                                 );
                                 ?>
                            <div class="price-per-person kk_slider">
                                <span class="rang-text"><?php echo wp_rem_allow_special_char($field_label); ?>&nbsp;<span class="kk_slider_from"><?php echo esc_html($range_complete_str_first); ?></span> &nbsp; - &nbsp; <span class="kk_slider_to"><?php echo esc_html($range_complete_str_second); ?></span></span>
                                <?php
                                $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                                        array(
                                            'cust_name' => '',
                                            'cust_id' => 'ex16b1' . esc_html($rand_id . $query_str_var_name),
                                            'std' => '',
                                        )
                                );
                                ?>  
                            </div>
                            <?php
                            $increment_step = isset($custom_field['increment']) ? $custom_field['increment'] : 1;
                            if ( ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
                                echo '<script type="text/javascript">
									if (jQuery("#ex16b1' . $rand_id . $query_str_var_name . '").length > 0) {
										jQuery("#ex16b1' . $rand_id . $query_str_var_name . '").slider({
											step : ' . esc_html($increment_step) . ',
											min: ' . esc_html($custom_field['min']) . ',
											max: ' . esc_html($custom_field['max']) . ',
											value: [ ' . esc_html($range_complete_str) . '],
										});
										jQuery("#ex16b1' . $rand_id . $query_str_var_name . '").on("slideStop", function () {
											var rang_slider_val = jQuery("#ex16b1' . $rand_id . $query_str_var_name . '").val();
											jQuery("#range-hidden-' . $query_str_var_name . '").val(rang_slider_val);    
										});
                                        kk_update_slider_params_onchange("#ex16b1' . $rand_id . $query_str_var_name . '");
									}
								</script>';
                            } else {
                                echo '<script type="text/javascript">
									jQuery(window).load(function(){
										if (jQuery("#ex16b1' . $rand_id . $query_str_var_name . '").length > 0) {
											jQuery("#ex16b1' . $rand_id . $query_str_var_name . '").slider({
												step : ' . esc_html($increment_step) . ',
												min: ' . esc_html($custom_field['min']) . ',
												max: ' . esc_html($custom_field['max']) . ',
												value: [ ' . esc_html($range_complete_str) . '],
											});
											jQuery("#ex16b1' . $rand_id . $query_str_var_name . '").on("slideStop", function () {
												var rang_slider_val = jQuery("#ex16b1' . $rand_id . $query_str_var_name . '").val();
												jQuery("#range-hidden-' . $query_str_var_name . '").val(rang_slider_val);    
											});
                                            kk_update_slider_params_onchange("#ex16b1' . $rand_id . $query_str_var_name . '");
										}
									});
								</script>';
                            }
                        }
                    } else {
                        ?>
                        <label>
                            <em class="currency-sign"><?php echo wp_rem_get_currency_sign(); ?></em>
                            <?php
                            $options = array();
                            $options[''] = wp_rem_allow_special_char($field_label);
                            $range_min = $custom_field['min'];
                            $range_max = $custom_field['max'];

                            $counter = 0;
                            while ( $counter < $range_max ) {
                                $options[$counter . ',' . ($counter + $range_increment)] = ($counter . ' - ' . ($counter + $range_increment));
                                $counter += $range_increment;
                            }

                            ksort($options);
                            $options = array_filter($options);
                            $wp_rem_opt_array = array(
                                'std' => '',
                                'id' => $query_str_var_name,
                                'classes' => 'chosen-select',
                                'cust_name' => $query_str_var_name,
                                'options' => $options,
                            );
                            $wp_rem_form_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array);
                            ?>
                        </label>
                        <?php
                    }
                    $range_flag ++;
                }
                ?>
            </div>
            <?php
        }

        public function wp_rem_field_size($field_size) {
            switch ( $field_size ) {
                case "small":
                    $col_size = '4';
                    break;
                case "medium":
                    $col_size = '6';
                    break;
                case "large":
                    $col_size = '12';
                    break;
                default :
                    $col_size = '12';
                    break;
            }
            return $col_size;
        }

        public function wp_rem_field_label($field_label) {
            $output = '';
            if ( $field_label != '' ) {
                $output .= '<label>' . $field_label . '</label>';
            }
            return $output;
        }

        public function wp_rem_field_icon($field_fontawsome_icon) {
            $output = '';
            if ( $field_fontawsome_icon != '' ) {
                $output .= '<i class="' . $field_fontawsome_icon . '"></i>';
            }
            return $output;
        }

        public function wp_rem_field_placeholder($field_placeholder) {
            $placeholder = '';
            if ( $field_placeholder != '' ) {
                $placeholder .= 'placeholder="' . $field_placeholder . '"';
            }
            return $placeholder;
        }

        public function wp_rem_property_type_categories_options($property_type_slug = '') {
            $property_cats_options = array();
            if ( $property_type_slug != '' ) {
                $property_type_id = $this->wp_rem_property_type_id_by_slug($property_type_slug);
                $property_type_cats = get_post_meta($property_type_id, 'wp_rem_property_type_cats', true);
                if ( isset($property_type_cats) && is_array($property_type_cats) && ! empty($property_type_cats) ) {
                    $property_cats_options[''] = wp_rem_plugin_text_srt('wp_rem_search_filter_property_type');
                    foreach ( $property_type_cats as $property_type_cat_slug ) {
                        if ( $property_type_cat_slug != '' ) {
                            $term = get_term_by('slug', $property_type_cat_slug, 'property-category');
                            if ( isset($term->name) && ! empty($term->name) ) {
                                $property_cats_options[$property_type_cat_slug] = $term->name;
                            }
                        }
                    }
                }
            }
            return $property_cats_options;
        }

    }

    global $wp_rem_search_fields;
    $wp_rem_search_fields = new Wp_rem_Search_Fields();
}