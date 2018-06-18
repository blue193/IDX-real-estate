<?php

/**
 *  File Type: Settings Class
 */
if (!class_exists('wp_rem_plugin_options')) {

    class wp_rem_plugin_options {

        /**
         * Start Contructer Function
         */
        public function __construct() {
            add_action('wp_ajax_wp_rem_add_extra_feature_to_list', array(&$this, 'wp_rem_add_extra_feature_to_list'));
            add_action('wp_ajax_wp_rem_add_feats_to_list', array(&$this, 'wp_rem_add_feats_to_list'));
            add_action('wp_ajax_wp_rem_add_package_to_list', array(&$this, 'wp_rem_add_package_to_list'));
        }

        /**
         * End Contructer Function
         */

        /**
         * Start Function how to register setting in admin submenu page
         */
        public function wp_rem_register_plugin_settings() {
            //add submenu page
            add_menu_page( wp_rem_plugin_text_srt('wp_rem_plugin_seetings_rem_settings'), wp_rem_plugin_text_srt('wp_rem_plugin_seetings_rem_settings'), 'manage_options', 'wp_rem_settings', array(&$this, 'wp_rem_settings'), wp_rem::plugin_url() . 'assets/backend/images/settings.png', 34);
        }

        /**
         * End Function how to register setting in admin submenu page
         */

        /**
         * Start Function how to call setting function
         */
        public function wp_rem_settings() {
            // initialize settings array 
            wp_rem_settings_option();

            wp_rem_settings_options_page();
        }

        /**
         * end Function how to call setting function
         */

        /**
         * Start Function how to create package section
         */
        public function wp_rem_packages_section() {
            global $post, $wp_rem_form_fields, $package_id, $counter_package, $package_title, $package_price, $package_duration, $package_no_ads, $package_description, $wp_rem_package_type, $package_properties, $package_cvs, $package_submission_limit, $package_duration_period, $package_featured_ads, $wp_rem_list_dur, $package_feature, $wp_rem_html_fields, $wp_rem_plugin_options;
            $wp_rem_plugin_options = get_option('wp_rem_plugin_options');
            $wp_rem_packages_options = $wp_rem_plugin_options['wp_rem_packages_options'];
            $currency_sign = wp_rem_get_currency_sign();
            $wp_rem_free_package_switch = get_option('wp_rem_free_package_switch');
            $cd_checked = '';
            if (isset($wp_rem_free_package_switch) && $wp_rem_free_package_switch == 'on') {
                $cd_checked = 'checked';
            }
            $wp_rem_opt_array = array(
                'id' => '',
                'std' => '1',
                'cust_id' => "",
                'cust_name' => "dynamic_wp_rem_package",
                'return' => true,
            );


            $wp_rem_html = $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_array) . '
                
                <script>
                    jQuery(document).ready(function($) {
                        jQuery("#total_packages").sortable({
                            cancel : \'td div.table-form-elem\'
                        });
                    });
                </script>';
            $wp_rem_html .= '<div class="form-elements" id="safetysafe_switch_add_package">
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<a href="javascript:wp_rem_createpop(\'add_package_title\',\'filter\')" class="button button_style">' .  wp_rem_plugin_text_srt('wp_rem_plugin_seetings_add_package'). '</a>
					</div>
				</div>';
            $wp_rem_html .= '<div class="cs-list-table">
              <table class="to-table" border="0" cellspacing="0">
                <thead>
                  <tr>
                    <th style="width:80%;">' . wp_rem_plugin_text_srt('wp_rem_plugin_seetings_title') . '</th>
                    <th style="width:80%;" class="centr">' . wp_rem_plugin_text_srt('wp_rem_plugin_seetings_action'). '</th>
                    <th style="width:0%;" class="centr"></th>
                  </tr>
                </thead>
                <tbody id="total_packages">';
            if (isset($wp_rem_packages_options) && is_array($wp_rem_packages_options) && count($wp_rem_packages_options) > 0) {
                foreach ($wp_rem_packages_options as $package_key => $package) {
                    if (isset($package_key) && $package_key <> '') {
                        $counter_package = $package_id = isset($package['package_id']) ? $package['package_id'] : '';
                        $package_title = isset($package['package_title']) ? $package['package_title'] : '';
                        $package_price = isset($package['package_price']) ? $package['package_price'] : '';
                        $package_duration = isset($package['package_duration']) ? $package['package_duration'] : '';
                        $package_description = isset($package['package_description']) ? $package['package_description'] : '';
                        $wp_rem_package_type = isset($package['package_type']) ? $package['package_type'] : '';
                        $package_properties = isset($package['package_properties']) ? $package['package_properties'] : '';
                        $package_cvs = isset($package['package_cvs']) ? $package['package_cvs'] : '';
                        $package_submission_limit = isset($package['package_submission_limit']) ? $package['package_submission_limit'] : '';
                        $package_duration_period = isset($package['package_duration_period']) ? $package['package_duration_period'] : '';
                        $wp_rem_list_dur = isset($package['wp_rem_list_dur']) ? $package['wp_rem_list_dur'] : '';
                        $package_feature = isset($package['package_feature']) ? $package['package_feature'] : '';
                        $package_featured_ads = isset($package['package_featured_ads']) ? $package['package_featured_ads'] : '';
                        $wp_rem_html .= $this->wp_rem_add_package_to_list();
                    }
                }
            }
            $wp_rem_html .= '</tbody>
              </table>
              </div>
              </form>
              <div id="add_package_title" style="display: none;">
                <div class="cs-heading-area">
                  <h5> <i class="icon-plus-circle"></i> ' . wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_settings') . ' </h5>
                  <span class="cs-btnclose" onClick="javascript:wp_rem_remove_overlay(\'add_package_title\',\'append\')"> <i class="icon-times"></i></span> </div>';

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_title'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'package_title',
                    'cust_name' => 'package_title',
                    'return' => true,
                ),
            );

            $wp_rem_html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);


            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_price') . WP_REM_FUNCTIONS()->special_chars($currency_sign),
                'desc' => '',
                'hint_text' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_price_hint'),
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'package_price',
                    'cust_name' => 'package_price',
                    'return' => true,
                ),
            );

            $wp_rem_html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);



            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_type'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'id' => 'package_type',
                    'cust_name' => 'package_type',
                    'options' => array(
                        'single' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_type_single'),
                        'subscription' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_type_subcription'),
                    ),
                    'return' => true,
                    'onclick' => 'wp_rem_package_type_toogle(this.value, \'\')',
                    'classes' => 'chosen-select-no-single'
                ),
            );


            $wp_rem_html .= $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_num_of_properties'),
                'desc' => '',
                'id' => 'package_properties_con',
                'hint_text' => '',
                'extra_atr' => 'style="display:none;"',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'id' => '',
                    'cust_id' => 'package_properties',
                    'cust_name' => 'package_properties',
                    'return' => true,
                ),
            );

            $wp_rem_html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);


            // hide attribute		
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_num_of_cvs'),
                'desc' => '',
                'id' => '',
                'hint_text' => '',
                'styles' => 'display:none',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'id' => '',
                    'cust_id' => 'package_cvs',
                    'cust_name' => 'package_cvs',
                    'return' => true,
                ),
            );

            $wp_rem_html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_expiray'),
                'id' => '',
                'desc' => '',
                'fields_list' => array(
                    array('type' => 'text', 'field_params' => array(
                            'std' => '',
                            'id' => '',
                            'cust_id' => 'package_duration',
                            'cust_name' => 'package_duration',
                            'cust_type' => '',
                            'classes' => 'input-large',
                            'return' => true,
                        ),
                    ),
                    array('type' => 'select', 'field_params' => array(
                            'std' => '',
                            'id' => '',
                            'cust_type' => '',
                            'cust_id' => 'package_duration_period',
                            'cust_name' => 'package_duration_period',
                            'classes' => 'chosen-select-no-single',
                            'div_classes' => 'select-small',
                            'return' => true,
                            'options' => array(
                                'days' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_day'),
                                'months' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_months'),
                                'years' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_years'),
                            ),
                        ),
                    ),
                ),
            );
            $wp_rem_html .= $wp_rem_html_fields->wp_rem_multi_fields($wp_rem_opt_array);
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_property_expiray'),
                'id' => '',
                'desc' => '',
                'fields_list' => array(
                    array('type' => 'text', 'field_params' => array(
                            'std' => '',
                            'id' => '',
                            'cust_id' => 'package_submission_limit',
                            'cust_name' => 'package_submission_limit',
                            'cust_type' => '',
                            'classes' => 'input-large',
                            'return' => true,
                        ),
                    ),
                    array('type' => 'select', 'field_params' => array(
                            'std' => '',
                            'id' => '',
                            'cust_type' => '',
                            'cust_id' => 'wp_rem_list_dur',
                            'cust_name' => 'wp_rem_list_dur',
                            'classes' => 'chosen-select-no-single',
                            'return' => true,
                            'div_classes' => 'select-small',
                            'options' => array(
                                'days' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_property_days'),
                                'months' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_property_months'),
                                'years' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_property_years'),
                            ),
                        ),
                    ),
                ),
            );
            $wp_rem_html .= $wp_rem_html_fields->wp_rem_multi_fields($wp_rem_opt_array);
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_feature'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'package_feature',
                    'cust_name' => 'package_feature',
                    'options' => array(
                        'no' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_feature_no'),
                        'yes' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_feature_yes'),
                    ),
                    'return' => true,
                    'classes' => 'chosen-select-no-single'
                ),
            );
            $wp_rem_html .= $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_desc'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'package_description',
                    'cust_name' => 'package_description',
                    'return' => true,
                ),
            );
            $wp_rem_html .= $wp_rem_html_fields->wp_rem_textarea_field($wp_rem_opt_array);
            $wp_rem_opt_array = array(
                'name' => '',
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_add_package_to_list'),
                    'cust_id' => '',
                    'cust_name' => '',
                    'return' => true,
                    'after' => '<div class="package-loader"></div>',
                    'cust_type' => 'button',
                    'extra_atr' => 'onClick="add_package_to_list(\'' . esc_js(admin_url('admin-ajax.php')) . '\', \'' . esc_js(wp_rem::plugin_url()) . '\')" ',
                ),
            );
            $wp_rem_html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
            $wp_rem_html .= '</div>';
            return $wp_rem_html;
        }

        /**
         * end Function how to create package section
         */

        /**
         * Start Function how to add package in list section
         */
        public function wp_rem_add_package_to_list() {
            global $counter_package, $wp_rem_form_fields, $package_id, $package_title, $package_price, $package_duration, $package_description, $wp_rem_package_type, $package_properties, $package_cvs, $package_submission_limit, $wp_rem_list_dur, $package_duration_period, $package_featured_ads, $package_feature, $wp_rem_html_fields, $wp_rem_plugin_options;
            foreach ($_POST as $keys => $values) {
                $$keys = $values;
            }
            if (isset($_POST['package_title']) && $_POST['package_title'] <> '') {
                $package_id = time();
            }
            if (empty($package_id)) {
                $package_id = $counter_package;
            }
            $currency_sign = wp_rem_get_currency_sign();

            $wp_rem_opt_array = array(
                'id' => '',
                'std' => absint($package_id),
                'cust_id' => "",
                'cust_name' => "package_id_array[]",
                'return' => true,
            );
            $wp_rem_html = '
            <tr class="parentdelete" id="edit_track' . esc_attr($counter_package) . '">
              <td id="subject-title' . esc_attr($counter_package) . '" style="width:100%;">' . esc_attr($package_title) . '</td>
              <td class="centr" style="width:20%;"><a href="javascript:wp_rem_createpop(\'edit_track_form' . esc_js($counter_package) . '\',\'filter\')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
              <td style="width:0"><div id="edit_track_form' . esc_attr($counter_package) . '" style="display: none;" class="table-form-elem">
                  ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_array) . '
                  <div class="cs-heading-area">
                    <h5 style="text-align: left;"> ' . wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_settings') . '</h5>
                    <span onclick="javascript:wp_rem_remove_overlay(\'edit_track_form' . esc_js($counter_package) . '\',\'append\')" class="cs-btnclose"> <i class="icon-times"></i></span>
                    <div class="clear"></div>
                  </div>';
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_title'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => htmlspecialchars($package_title),
                    'cust_id' => 'package_title' . esc_attr($counter_package),
                    'cust_name' => 'package_title_array[]',
                    'return' => true,
                    'array' => true,
                    'force_std' => true,
                ),
            );

            $wp_rem_html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);


            $wp_rem_opt_array = array(
                'name' =>  wp_rem_plugin_text_srt('wp_rem_plugin_seetings_price_edit'). WP_REM_FUNCTIONS()->special_chars($currency_sign),
                'desc' => '',
                'hint_text' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_price_edit_hint'),
                'echo' => false,
                'field_params' => array(
                    'std' => esc_attr($package_price),
                    'cust_id' => 'package_price' . esc_attr($counter_package),
                    'cust_name' => 'package_price_array[]',
                    'return' => true,
                    'array' => true,
                    'force_std' => true,
                ),
            );

            $wp_rem_html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);



            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_type'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => $wp_rem_package_type,
                    'id' => 'wp_rem_package_type' . esc_attr($counter_package),
                    'cust_name' => 'package_type_array[]',
                    'options' => array(
                        'single' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_type_single'),
                        'subscription' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_type_subcription'),
                    ),
                    'return' => true,
                    'onclick' => 'wp_rem_package_type_toogle(this.value, \'' . esc_attr($counter_package) . '\')',
                    'classes' => 'chosen-select-no-single',
                    'array' => true,
                    'force_std' => true,
                ),
            );
            $wp_rem_html .= $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);



            $wp_rem_opt_array = array(
                'name' =>wp_rem_plugin_text_srt('wp_rem_plugin_seetings_num_of_properties'),
                'desc' => '',
                'id' => 'package_properties_con' . esc_attr($counter_package),
                'hint_text' => '',
                'extra_atr' => 'style="display:' . esc_attr($wp_rem_package_type == 'subscription' ? 'block' : 'none') . '"',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_attr($package_properties),
                    'id' => '',
                    'cust_id' => 'package_properties' . esc_attr($counter_package),
                    'cust_name' => 'package_properties_array[]',
                    'return' => true,
                    'array' => true,
                    'force_std' => true,
                ),
            );
            $wp_rem_html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_num_of_cvs'),
                'desc' => '',
                'id' => '',
                'hint_text' => '',
                'styles' => 'display:none',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_attr($package_cvs),
                    'id' => '',
                    'cust_id' => 'package_cvs' . esc_attr($counter_package),
                    'cust_name' => 'package_cvs_array[]',
                    'return' => true,
                    'array' => true,
                    'force_std' => true,
                ),
            );

            $wp_rem_html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_expiray'),
                'id' => '',
                'desc' => '',
                'fields_list' => array(
                    array('type' => 'text', 'field_params' => array(
                            'std' => esc_attr($package_duration),
                            'id' => '',
                            'cust_id' => 'package_duration' . esc_attr($counter_package),
                            'cust_name' => 'package_duration_array[]',
                            'cust_type' => '',
                            'classes' => 'input-large',
                            'return' => true,
                            'array' => true,
                            'force_std' => true,
                        ),
                    ),
                    array('type' => 'select', 'field_params' => array(
                            'std' => esc_attr($package_duration_period),
                            'id' => '',
                            'cust_type' => '',
                            'cust_id' => 'package_duration_period' . esc_attr($counter_package),
                            'cust_name' => 'package_duration_period_array[]',
                            'classes' => 'chosen-select-no-single',
                            'div_classes' => 'select-small',
                            'options' => array(
                                'days' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_day'),
                                'months' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_months'),
                                'years' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_years'),
                            ),
                            'return' => true,
                            'array' => true,
                            'force_std' => true,
                        ),
                    ),
                ),
            );
            $wp_rem_html .= $wp_rem_html_fields->wp_rem_multi_fields($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_property_expiray'),
                'id' => '',
                'desc' => '',
                'fields_list' => array(
                    array('type' => 'text', 'field_params' => array(
                            'std' => esc_attr($package_submission_limit),
                            'id' => '',
                            'cust_id' => 'package_submission_limit' . esc_attr($counter_package),
                            'cust_name' => 'package_submission_limit_array[]',
                            'cust_type' => '',
                            'classes' => 'input-large',
                            'return' => true,
                            'array' => true,
                            'force_std' => true,
                        ),
                    ),
                    array('type' => 'select', 'field_params' => array(
                            'std' => esc_attr($wp_rem_list_dur),
                            'id' => '',
                            'cust_type' => '',
                            'cust_id' => 'wp_rem_list_dur' . esc_attr($counter_package),
                            'cust_name' => 'wp_rem_list_dur_array[]',
                            'classes' => 'chosen-select-no-single',
                            'div_classes' => 'select-small',
                            'options' => array(
                                'days' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_property_days'),
                                'months' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_property_months'),
                                'years' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_property_years'),
                            ),
                            'return' => true,
                            'array' => true,
                            'force_std' => true,
                        ),
                    ),
                ),
            );


            $wp_rem_html .= $wp_rem_html_fields->wp_rem_multi_fields($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_feature'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => $package_feature,
                    'cust_id' => 'package_feature' . esc_attr($counter_package),
                    'cust_name' => 'package_feature_array[]',
                    'options' => array(
                        'no' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_feature_no'),
                        'yes' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_feature_yes'),
                    ),
                    'classes' => 'chosen-select-no-single',
                    'return' => true,
                    'array' => true,
                    'force_std' => true,
                ),
            );
            $wp_rem_html .= $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);



            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_desc'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_attr($package_description),
                    'cust_id' => 'package_description' . esc_attr($counter_package),
                    'cust_name' => 'package_description_array[]',
                    'return' => true,
                    'array' => true,
                    'force_std' => true,
                ),
            );
            $wp_rem_html .= $wp_rem_html_fields->wp_rem_textarea_field($wp_rem_opt_array);
            $wp_rem_opt_array = array(
                'name' => '',
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_update_package'),
                    'cust_id' => '',
                    'cust_name' => '',
                    'return' => true,
                    'cust_type' => 'button',
                    'extra_atr' => 'onclick="update_title(' . esc_js($counter_package) . '); wp_rem_remove_overlay(\'edit_track_form' . esc_js($counter_package) . '\',\'append\')"',
                ),
            );
            $wp_rem_html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
            $wp_rem_html .= '
                </div></td>
            </tr>';
            if (isset($_POST['package_title'])) {
                echo force_balance_tags($wp_rem_html);
                die();
            } else {
                return $wp_rem_html;
            }
        }

        /**
         * end Function how to add package in list section
         */

        /**
         * Start Function how to show extra features in feature list
         */
        public function wp_rem_add_extra_feature_to_list() {
            global $counter_extra_feature, $wp_rem_form_fields, $extra_feature_id, $extra_feature_title, $extra_feature_price, $extra_feature_type, $extra_feature_guests, $extra_feature_fchange, $extra_feature_desc, $wp_rem_form_fields;
            foreach ($_POST as $keys => $values) {
                $$keys = $values;
            }
            $wp_rem_plugin_options = get_option("wp_rem_plugin_options");
            $currency_sign = wp_rem_get_currency_sign();
            $wp_rem_extra_features_options = $wp_rem_plugin_options['wp_rem_extra_features_options'];
            if (isset($_POST['wp_rem_extra_feature_title']) && $_POST['wp_rem_extra_feature_title'] <> '') {
                $extra_feature_id = time();
                $extra_feature_title = $_POST['wp_rem_extra_feature_title'];
            }
            if (isset($_POST['wp_rem_extra_feature_price']) && $_POST['wp_rem_extra_feature_price'] <> '') {
                $extra_feature_price = $_POST['wp_rem_extra_feature_price'];
            }
            if (isset($_POST['wp_rem_extra_feature_type']) && $_POST['wp_rem_extra_feature_type'] <> '') {
                $extra_feature_type = $_POST['wp_rem_extra_feature_type'];
            }
            if (isset($_POST['wp_rem_extra_feature_guests']) && $_POST['wp_rem_extra_feature_guests'] <> '') {
                $extra_feature_guests = $_POST['wp_rem_extra_feature_guests'];
            }
            if (isset($_POST['wp_rem_extra_feature_fchange']) && $_POST['wp_rem_extra_feature_fchange'] <> '') {
                $extra_feature_fchange = $_POST['wp_rem_extra_feature_fchange'];
            }
            if (isset($_POST['wp_rem_extra_feature_desc']) && $_POST['wp_rem_extra_feature_desc'] <> '') {
                $extra_feature_desc = $_POST['wp_rem_extra_feature_desc'];
            }
            if (empty($extra_feature_id)) {
                $extra_feature_id = $counter_extra_feature;
            }
            if (isset($_POST['wp_rem_extra_feature_title']) && is_array($wp_rem_extra_features_options) && ($this->wp_rem_in_array_field($extra_feature_title, 'wp_rem_extra_feature_title', $wp_rem_extra_features_options))) {
                $wp_rem_error_message = sprintf(wp_rem_plugin_text_srt('wp_rem_plugin_seetings_alrady_exists_error'), $extra_feature_title);
                $html = '
                <tr class="parentdelete" id="edit_track' . esc_attr($counter_extra_feature) . '">
					<td style="width:100%;">' . $wp_rem_error_message . '</td>
                </tr>';
                echo force_balance_tags($html);
                die();
            } else {
                $extra_feature_price = isset($extra_feature_price) ? esc_attr($extra_feature_price) : '';
                $wp_rem_opt_array = array(
                    'id' => '',
                    'std' => absint($extra_feature_id),
                    'cust_id' => "",
                    'cust_name' => "extra_feature_id_array[]",
                    'return' => true,
                );
                $html = '
                <tr class="parentdelete" id="edit_track' . esc_attr($counter_extra_feature) . '">
                  <td id="subject-title' . esc_attr($counter_extra_feature) . '" style="width:80%;">' . esc_attr($extra_feature_title) . '</td>
                  <td class="centr" style="width:20%;"><a href="javascript:wp_rem_createpop(\'edit_track_form' . esc_js($counter_extra_feature) . '\',\'filter\')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
                  <td style="width:0"><div id="edit_track_form' . esc_attr($counter_extra_feature) . '" style="display: none;" class="table-form-elem">
                      ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_array) . '
                      <div class="cs-heading-area">
                        <h5 style="text-align: left;">' .  wp_rem_plugin_text_srt('wp_rem_plugin_seetings_extrs_feature_setting'). '</h5>
                        <span onclick="javascript:wp_rem_remove_overlay(\'edit_track_form' . esc_js($counter_extra_feature) . '\',\'append\')" class="cs-btnclose"> <i class="icon-times"></i></span>
                        <div class="clear"></div>
                      </div>';
                $html .= $wp_rem_form_fields->wp_rem_form_text_render(
                        array('name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_extra_feature_title'),
                            'id' => 'extra_feature_title',
                            'classes' => '',
                            'std' => $extra_feature_title,
                            'description' => '',
                            'return' => true,
                            'array' => true,
                            'hint' => ''
                        )
                );
                $html .= $wp_rem_form_fields->wp_rem_form_text_render(
                        array('name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_extra_feature_price'),
                            'id' => 'extra_feature_price',
                            'classes' => '',
                            'std' => $extra_feature_price,
                            'description' => '',
                            'return' => true,
                            'array' => true,
                            'hint' => ''
                        )
                );
                $html .= $wp_rem_form_fields->wp_rem_form_select_render(
                        array('name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_extra_feature_type'),
                            'id' => 'extra_feature_type',
                            'classes' => '',
                            'std' => $extra_feature_type,
                            'description' => '',
                            'return' => true,
                            'array' => true,
                            'hint' => '',
                            'options' => array('none' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_extra_feature_type_none'), 'one-time' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_extra_feature_type_one_time'), 'daily' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_extra_feature_type_daily')),
                        )
                );
                $html .= $wp_rem_form_fields->wp_rem_form_select_render(
                        array('name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_extra_feature_guests'),
                            'id' => 'extra_feature_guests',
                            'classes' => '',
                            'std' => $extra_feature_guests,
                            'description' => '',
                            'return' => true,
                            'array' => true,
                            'hint' => '',
                            'options' => array('none' => wp_rem_plugin_text_srt('wp_rem_save_post_property_status'), 'per-head' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_extra_feature_guests_none'), 'group' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_extra_feature_guests_group')),
                        )
                );
                $html .= $wp_rem_form_fields->wp_rem_form_checkbox_render(
                        array('name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_frontend_changeable'),
                            'id' => 'extra_feature_fchange',
                            'classes' => '',
                            'std' => $extra_feature_fchange,
                            'description' => '',
                            'return' => true,
                            'array' => true,
                            'hint' => '',
                        )
                );
                $html .= $wp_rem_form_fields->wp_rem_form_textarea_render(
                        array('name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_extra_feature_description'),
                            'id' => 'extra_feature_desc',
                            'classes' => '',
                            'std' => $extra_feature_desc,
                            'description' => '',
                            'return' => true,
                            'array' => true,
                            'hint' => '',
                        )
                );

                $wp_rem_opt_array = array(
                    'name' => '',
                    'desc' => '',
                    'hint_text' => '',
                    'echo' => false,
                    'field_params' => array(
                        'std' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_extra_feature_update'),
                        'cust_id' => '',
                        'cust_name' => '',
                        'return' => true,
                        'cust_type' => 'button',
                        'extra_atr' => 'onclick="wp_rem_remove_overlay(\'edit_track_form' . esc_js($counter_extra_feature) . '\',\'append\')" ',
                    ),
                );
                $wp_rem_html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                $html .= '
                    </div></td>
                </tr>';
                if (isset($_POST['wp_rem_extra_feature_title']) && isset($_POST['wp_rem_extra_feature_price'])) {
                    echo force_balance_tags($html);
                } else {
                    return $html;
                }
            }
            if (isset($_POST['wp_rem_extra_feature_title']) && isset($_POST['wp_rem_extra_feature_price']))
                die();
        }

        /**
         * Start Function how to show extra features in feature list
         */

        /**
         * Start Function how to add data in  feature list
         */
        public function wp_rem_add_feats_to_list() {
            global $counter_feats, $feats_id, $feats_title, $feats_image, $feats_desc, $wp_rem_form_fields, $wp_rem_form_fields;
            foreach ($_POST as $keys => $values) {
                $$keys = $values;
            }
            $wp_rem_plugin_options = get_option("wp_rem_plugin_options");
            $currency_sign = wp_rem_get_currency_sign();
            if (isset($_POST['wp_rem_feats_title']) && $_POST['wp_rem_feats_title'] <> '') {
                $feats_id = time();
                $feats_title = $_POST['wp_rem_feats_title'];
            }
            if (isset($_POST['wp_rem_feats_image']) && $_POST['wp_rem_feats_image'] <> '') {
                $feats_image = $_POST['wp_rem_feats_image'];
            }

            if (isset($_POST['wp_rem_feats_desc']) && $_POST['wp_rem_feats_desc'] <> '') {
                $feats_desc = $_POST['wp_rem_feats_desc'];
            }
            if (empty($feats_id)) {
                $feats_id = $counter_feats;
            }
            $feats_desc = isset($feats_desc) ? esc_attr($feats_desc) : '';
            $wp_rem_opt_array = array(
                'id' => '',
                'std' => absint($feats_id),
                'cust_id' => '',
                'cust_name' => "feats_id_array[]",
                'return' => true,
            );
            $html = '
                <tr class="parentdelete" id="edit_track' . esc_attr($counter_feats) . '">
                  <td id="subject-title' . esc_attr($counter_feats) . '" style="width:80%;">' . esc_attr($feats_title) . '</td>
                  <td class="centr" style="width:20%;"><a href="javascript:wp_rem_createpop(\'edit_track_form' . esc_js($counter_feats) . '\',\'filter\')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
                  <td style="width:0"><div id="edit_track_form' . esc_attr($counter_feats) . '" style="display: none;" class="table-form-elem">
                      ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_array) . '
                      <div class="cs-heading-area">
                        <h5 style="text-align: left;">' .  wp_rem_plugin_text_srt('wp_rem_plugin_seetings_feature_stng'). '</h5>
                        <span onclick="javascript:wp_rem_remove_overlay(\'edit_track_form' . esc_js($counter_feats) . '\',\'append\')" class="cs-btnclose"> <i class="icon-times"></i></span>
                        <div class="clear"></div>
                      </div>';
            $html .= $wp_rem_form_fields->wp_rem_form_text_render(
                    array('name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_feature_titl'),
                        'id' => 'feats_title',
                        'classes' => '',
                        'std' => $feats_title,
                        'description' => '',
                        'return' => true,
                        'array' => true,
                        'hint' => ''
                    )
            );
            $html .= $wp_rem_form_fields->wp_rem_form_fileupload_render(
                    array('name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_feature_image'),
                        'id' => 'feats_image',
                        'classes' => '',
                        'std' => $feats_image,
                        'description' => '',
                        'return' => true,
                        'array' => true,
                        'hint' => ''
                    )
            );
            $html .= $wp_rem_form_fields->wp_rem_form_textarea_render(
                    array('name' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_package_desc'),
                        'id' => 'feats_desc',
                        'classes' => '',
                        'std' => $feats_desc,
                        'description' => '',
                        'return' => true,
                        'array' => true,
                        'hint' => ''
                    )
            );

            $wp_rem_opt_array = array(
                'name' => '',
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => wp_rem_plugin_text_srt('wp_rem_plugin_seetings_upd_feature'),
                    'cust_id' => '',
                    'cust_name' => '',
                    'return' => true,
                    'cust_type' => 'button',
                    'extra_atr' => ' onclick="wp_rem_remove_overlay(\'edit_track_form' . esc_js($counter_feats) . '\',\'append\')" ',
                ),
            );
            $wp_rem_html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

            $html .= '</div></td></tr>';
            if (isset($_POST['wp_rem_feats_title']) && isset($_POST['wp_rem_feats_desc'])) {
                echo force_balance_tags($html);
            } else {
                return $html;
            }
            if (isset($_POST['wp_rem_feats_title']) && isset($_POST['wp_rem_feats_desc']))
                die();
        }

        /**
         * end Function how to add data in  feature list
         */

        /**
         *
         * Array Fields
         */
        function wp_rem_in_array_field($array_val, $array_field, $array, $strict = false) {
            if ($strict) {
                foreach ($array as $item)
                    if (isset($item[$array_field]) && $item[$array_field] === $array_val)
                        return true;
            }
            else {
                foreach ($array as $item)
                    if (isset($item[$array_field]) && $item[$array_field] == $array_val)
                        return true;
            }
            return false;
        }

        /**
         * Start Function that how to check duplicate values
         */
        function wp_rem_check_duplicate_value($array_val, $array_field, $array) {
            $wp_rem_val_counter = 0;
            foreach ($array as $item) {
                if (isset($item[$array_field]) && $item[$array_field] == $array_val) {
                    $wp_rem_val_counter++;
                }
            }
            if ($wp_rem_val_counter > 1)
                return true;
            return false;
        }

        /**
         * End Function of how to check duplicate values
         */

        /**
         * Start Function that how to remove  duplicate values
         */
        function wp_rem_remove_duplicate_extra_value() {
            $wp_rem_plugin_options = get_option('wp_rem_plugin_options');
            $wp_rem_extra_features_options = $wp_rem_plugin_options['wp_rem_extra_features_options'];
            $extrasdata = array();
            $extra_feature_array = $extra_features = '';
            if (isset($wp_rem_extra_features_options) && is_array($wp_rem_extra_features_options) && count($wp_rem_extra_features_options) > 0) {
                $extra_feature_array = $extra_features = $extrasdata = array();
                foreach ($wp_rem_extra_features_options as $extra_feature_key => $extra_feature) {
                    if (isset($extra_feature_key) && $extra_feature_key <> '') {
                        $extra_feature_id = isset($extra_feature['extra_feature_id']) ? $extra_feature['extra_feature_id'] : '';
                        $extra_feature_title = isset($extra_feature['wp_rem_extra_feature_title']) ? $extra_feature['wp_rem_extra_feature_title'] : '';
                        $extra_feature_price = isset($extra_feature['wp_rem_extra_feature_price']) ? $extra_feature['wp_rem_extra_feature_price'] : '';
                        $extra_feature_type = isset($extra_feature['wp_rem_extra_feature_type']) ? $extra_feature['wp_rem_extra_feature_type'] : '';
                        $extra_feature_guests = isset($extra_feature['wp_rem_extra_feature_guests']) ? $extra_feature['wp_rem_extra_feature_guests'] : '';
                        $extra_feature_fchange = isset($extra_feature['wp_rem_extra_feature_fchange']) ? $extra_feature['wp_rem_extra_feature_fchange'] : '';
                        $extra_feature_desc = isset($extra_feature['wp_rem_extra_feature_desc']) ? $extra_feature['wp_rem_extra_feature_desc'] : '';
                        if (!$this->wp_rem_check_duplicate_value($extra_feature_title, 'wp_rem_extra_feature_title', $wp_rem_extra_features_options)) {
                            $extra_feature_array['extra_feature_id'] = $extra_feature_id;
                            $extra_feature_array['wp_rem_extra_feature_title'] = $extra_feature_title;
                            $extra_feature_array['wp_rem_extra_feature_price'] = $extra_feature_price;
                            $extra_feature_array['wp_rem_extra_feature_type'] = $extra_feature_type;
                            $extra_feature_array['wp_rem_extra_feature_guests'] = $extra_feature_guests;
                            $extra_feature_array['wp_rem_extra_feature_fchange'] = $extra_feature_fchange;
                            $extra_feature_array['wp_rem_extra_feature_desc'] = $extra_feature_desc;
                            $extra_features[$extra_feature_id] = $extra_feature_array;
                        }
                    }
                }
                $extrasdata['wp_rem_extra_features_options'] = $extra_features;
                $wp_rem_options = array_merge($wp_rem_plugin_options, $extrasdata);
                update_option("wp_rem_plugin_options", $wp_rem_options);
            }
            //End if
        }

        /**
         * end Function of how to remove  duplicate values
         */
    }

    //End Class
}
if (!function_exists('wp_rem_settings_fields')) {

    /**
     * Start Function that set value in setting fields
     */
    function wp_rem_settings_fields($key, $param) {
        global $post, $wp_rem_html_fields;
        $wp_rem_gateway_options = get_option('wp_rem_gateway_options');
        $wp_rem_value = $param['std'];
        $html = '';
        switch ($param['type']) {
            case 'text':
                if (isset($wp_rem_gateway_options)) {
                    if (isset($wp_rem_gateway_options[$param['id']])) {
                        $val = $wp_rem_gateway_options[$param['id']];
                    } else {
                        $val = $param['std'];
                    }
                } else {
                    $val = $param['std'];
                }
                $wp_rem_opt_array = array(
                    'name' => esc_attr($param["name"]),
                    'desc' => '',
                    'hint_text' => esc_attr($param['desc']),
                    'echo' => false,
                    'field_params' => array(
                        'std' => $val,
                        'cust_id' => $param['id'],
                        'cust_name' => $param['id'],
                        'return' => true,
                        'cust_type' => $param['type'],
                        'classes' => 'vsmall',
                    ),
                );
                $output = $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

                $html .= $output;
                break;
            case 'textarea':
                $val = $param['std'];
                $std = get_option($param['id']);
                if (isset($wp_rem_gateway_options)) {
                    if (isset($wp_rem_gateway_options[$param['id']])) {
                        $val = $wp_rem_gateway_options[$param['id']];
                    } else {
                        $val = $param['std'];
                    }
                } else {
                    $val = $param['std'];
                }


                $wp_rem_opt_array = array(
                    'name' => esc_attr($param["name"]),
                    'desc' => '',
                    'hint_text' => esc_attr($param['desc']),
                    'echo' => false,
                    'field_params' => array(
                        'std' => $val,
                        'cust_id' => $param['id'],
                        'cust_name' => $param['id'],
                        'return' => true,
                        'extra_atr' => 'rows="10" cols="60"',
                        'classes' => '',
                    ),
                );
                $output = $wp_rem_html_fields->wp_rem_textarea_field($wp_rem_opt_array);

                $html .= $output;
                break;
            case "checkbox":
                $saved_std = '';
                $std = '';
                if (isset($wp_rem_gateway_options)) {
                    if (isset($wp_rem_gateway_options[$param['id']])) {
                        $saved_std = $wp_rem_gateway_options[$param['id']];
                    }
                } else {
                    $std = $param['std'];
                }
                $checked = '';
                if (!empty($saved_std)) {
                    if ($saved_std == 'on') {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }
                } elseif ($std == 'on') {
                    $checked = 'checked="checked"';
                } else {
                    $checked = '';
                }

                $wp_rem_opt_array = array(
                    'name' => esc_attr($param["name"]),
                    'desc' => '',
                    'hint_text' => esc_attr($param['desc']),
                    'echo' => false,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => $param['id'],
                        'cust_name' => $param['id'],
                        'return' => true,
                        'classes' => 'myClass',
                    ),
                );
                $output = $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);
                $html .= $output;
                break;
            case "logo":
                if (isset($wp_rem_gateway_options) and $wp_rem_gateway_options <> '' && isset($wp_rem_gateway_options[$param['id']])) {
                    $val = $wp_rem_gateway_options[$param['id']];
                } else {
                    $val = $param['std'];
                }
                $output = '';
                $display = ($val <> '' ? 'display' : 'none');
                if (isset($value['tab'])) {
                    $output .='<div class="main_tab"><div class="horizontal_tab" style="display:' . $param['display'] . '" id="' . $param['tab'] . '">';
                }

                $wp_rem_opt_array = array(
                    'name' => esc_attr($param["name"]),
                    'desc' => '',
                    'hint_text' => esc_attr($param['desc']),
                    'echo' => false,
                    'field_params' => array(
                        'std' => $val,
                        'cust_id' => $param['id'],
                        'cust_name' => $param['id'],
                        'return' => true,
                        'classes' => '',
                    ),
                );
                $output = $wp_rem_html_fields->wp_rem_upload_file_field($wp_rem_opt_array);
                $html .= $output;
                break;
            case 'select' :

                $options = '';
                if (isset($param['options']) && is_array($param['options'])) {
                    foreach ($param['options'] as $value => $option) {
                        $options[$value] = $option;
                    }
                }

                $wp_rem_opt_array = array(
                    'name' => esc_attr($param["title"]),
                    'desc' => '',
                    'hint_text' => esc_attr($param['description']),
                    'echo' => false,
                    'field_params' => array(
                        'std' => $wp_rem_value,
                        'cust_id' => $param['id'],
                        'cust_name' => $param['id'],
                        'return' => true,
                        'classes' => 'cs-form-select cs-input chosen-select-no-single',
                        'options' => $options,
                    ),
                );
                $output = $wp_rem_html_fields->wp_rem_upload_file_field($wp_rem_opt_array);
                // append
                $html .= $output;
                break;
            default :
                break;
        }
        return $html;
    }

    /**
     * end Function of set value in setting fields
     */
}
/**
 * Start Function that how to Checkt load satus
 */
if (class_exists('wp_rem_plugin_options')) {
    $settings_object = new wp_rem_plugin_options();
    add_action('admin_menu', array(&$settings_object, 'wp_rem_register_plugin_settings'));
}



if (!function_exists('icons_fields_callback')) {

    function icons_fields_callback($icon_value = '', $id = '', $name = '', $group_name = '', $group_value = '') {
        global $wp_rem_form_fields, $wp_rem_plugin_static_text, $wp_rem_, $wp_rem_Class;
        $wp_rem_icomoon = '
        <script>
            jQuery(document).ready(function ($) {

                var e9_element = $(\'#e9_element_' . esc_html($id) . '\').fontIconPicker({
                    theme: \'fip-bootstrap\'
                });
                // Add the event on the button
                $(\'#e9_buttons_' . esc_html($id) . ' button\').on(\'click\', function (e) {
                    e.preventDefault();
                    // Show processing message
                    $(this).prop(\'disabled\', true).html(\'<i class="icon-cog demo-animate-spin"></i> ' .  wp_rem_plugin_text_srt('wp_rem_plugin_seetings_extra_feature_please_wait'). '\');
                    $.ajax({
                        url: "' . $wp_rem_Class->plugin_url() . 'assets/icomoon/js/selection.json",
                        type: \'GET\',
                        dataType: \'json\'
                    }).done(function (response) {
                            // Get the class prefix
                            var classPrefix = response.preferences.fontPref.prefix,
                                    icomoon_json_icons = [],
                                    icomoon_json_search = [];
                            $.each(response.icons, function (i, v) {
                                    icomoon_json_icons.push(classPrefix + v.properties.name);
                                    if (v.icon && v.icon.tags && v.icon.tags.length) {
                                            icomoon_json_search.push(v.properties.name + \' \' + v.icon.tags.join(\' \'));
                                    } else {
                                            icomoon_json_search.push(v.properties.name);
                                    }
                            });
                            // Set new fonts on fontIconPicker
                            e9_element.setIcons(icomoon_json_icons, icomoon_json_search);
                            // Show success message and disable
                            $(\'#e9_buttons_' . esc_html($id) . ' button\').removeClass(\'btn-primary\').addClass(\'btn-success\').text(\'' .  wp_rem_plugin_text_srt('wp_rem_plugin_seetings_extra_feature_load_icon'). '\').prop(\'disabled\', true);
                    })
                    .fail(function () {
                            // Show error message and enable
                            $(\'#e9_buttons_' . esc_html($id) . ' button\').removeClass(\'btn-primary\').addClass(\'btn-danger\').text(\'' .  wp_rem_plugin_text_srt('wp_rem_plugin_seetings_extra_feature_try_again'). '\').prop(\'disabled\', false);
                    });
                    e.stopPropagation();
                });
                jQuery("#e9_buttons_' . esc_html($id) . ' button").click();
            });
        </script>';
        $wp_rem_opt_array = array(
            'std' => esc_html($icon_value),
            'cust_id' => 'e9_element_' . esc_html($id),
            'cust_name' => esc_html($name) . '[]',
            'return' => true,
        );
        $wp_rem_icomoon .= $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
        $wp_rem_icomoon .= '
        <span id="e9_buttons_' . esc_html($id) . '" style="display:none">
            <button autocomplete="off" type="button" class="btn btn-primary">' . wp_rem_plugin_text_srt('wp_rem_plugin_seetings_extra_feature_load_json') . '</button>
        </span>';

        return $wp_rem_icomoon;
    }
    add_filter('cs_icons_fields', 'icons_fields_callback', 10, 5 );
}


