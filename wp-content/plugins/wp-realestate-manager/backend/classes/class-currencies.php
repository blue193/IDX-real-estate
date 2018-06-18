<?php
/**
 * File Type: Currencies Settings
 */
if ( ! class_exists('Wp_rem_Currencies') ) {

    class Wp_rem_Currencies {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_filter('wp_rem_currency_settings', array( $this, 'wp_rem_currency_settings_callback' ), 10, 1);
            add_filter('wp_rem_plugin_options_fields', array( $this, 'wp_rem_plugin_options_fields_callback' ), 10, 1);
            add_action('wp_ajax_add_currencies_opt', array( $this, 'add_currencies_opt_callback' ), 10);
        }

        public function wp_rem_currency_settings_callback($wp_rem_setting_options = array()) {
            global $wp_rem_plugin_options;
            
            $on_off_option = array( "show" => "on", "hide" => "off" );
            $wp_rem_setting_options[] = array(
                "name" => wp_rem_plugin_text_srt('wp_rem_plugin_options_currency_settings'),
                "id" => "tab-currencies-settings",
                "extra" => 'class="wp_rem_tab_block" data-title="' . wp_rem_plugin_text_srt('wp_rem_plugin_options_currency_settings') . '"',
                "type" => "sub-heading"
            );

            $wp_rem_setting_options[] = array( "name" => wp_rem_plugin_text_srt('wp_rem_plugin_options_currency_settings'),
                "id" => "tab-currencies-settings",
                "std" => wp_rem_plugin_text_srt('wp_rem_plugin_options_currency_settings'),
                "type" => "section",
                "options" => ""
            );
            $currencies = array();
            $wp_rem_currencuies = wp_rem_get_currencies();
            if ( is_array($wp_rem_currencuies) ) {
                foreach ( $wp_rem_currencuies as $key => $value ) {
                    $currencies[$key] = $value['name'] . '-' . $value['code'];
                }
            }
            
            $wp_rem_setting_options[] = array( "name" => wp_rem_plugin_text_srt('wp_rem_payment_currency_switch'),
                "desc" => "",
                "label_desc" => wp_rem_plugin_text_srt('wp_rem_payment_currency_switch_hint'),
                "id" => "currency_switch",
                "std" => "on",
                "type" => "checkbox",
                "options" => $on_off_option
            );
            
            if( isset( $wp_rem_plugin_options['wp_rem_use_woocommerce_gateway'] ) && $wp_rem_plugin_options['wp_rem_use_woocommerce_gateway'] == 'on' ){
                
                $wp_rem_setting_options[] = array( "name" => wp_rem_plugin_text_srt('wp_rem_payment_bace_currency'),
                    "label_desc" => wp_rem_plugin_text_srt('wp_rem_payment_base_currency_hint'),
                    "std" => wp_rem_plugin_text_srt('wp_rem_payment_woocommerce_enable'),
                    "type" => "paragraph",
                );
            } else  {
                $wp_rem_setting_options[] = array( "name" => wp_rem_plugin_text_srt('wp_rem_payment_bace_currency'),
                    "desc" => "",
                    "label_desc" => wp_rem_plugin_text_srt('wp_rem_payment_base_currency_hint'),
                    "hint_text" => '',
                    "id" => "currency_type",
                    "std" => "USD",
                    'classes' => 'dropdown chosen-select-no-single ',
                    "type" => "select_values",
                    "options" => $currencies
                );
                $currency_sign = $default_currency = wp_rem_get_currency_sign();
                $wp_rem_setting_options[] = array( "name" => wp_rem_plugin_text_srt('wp_rem_plugin_options_currency_position'),
                    "desc" => "",
                    "hint_text" => '',
                    "label_desc" => wp_rem_plugin_text_srt('wp_rem_plugin_options_currency_position_hint'),
                    "id" => "currency_position",
                    "std" => "on",
                    "classes" => "chosen-select",
                    "type" => "select_values",
                    "options" => array(
                        'left' => wp_rem_plugin_text_srt('wp_rem_plugin_options_currency_position_left') . '(' . $currency_sign . '99.99)',
                        'right' => wp_rem_plugin_text_srt('wp_rem_plugin_options_currency_position_right') . '(99.99' . $currency_sign . ')',
                        'left_space' => wp_rem_plugin_text_srt('wp_rem_plugin_options_currency_position_left_space') . '(' . $currency_sign . ' 99.99)',
                        'right_space' => wp_rem_plugin_text_srt('wp_rem_plugin_options_currency_position_right_space') . '(99.99 ' . $currency_sign . ')',
                    ),
                );
            }
            $wp_rem_setting_options[] = array( "name" => "",
                "desc" => "",
                "id" => "currency-settings",
                "type" => "currency_settings",
            );


            $wp_rem_setting_options[] = array( "col_heading" => wp_rem_plugin_text_srt('wp_rem_plugin_options_currency_settings'),
                "type" => "col-right-text",
                "hint_text" => "",
                "help_text" => ""
            );

            return $wp_rem_setting_options;
        }

        /*
         * Plugin Options Field 
         */

        public function wp_rem_plugin_options_fields_callback($field_obj = array()) {
            global $wp_rem_plugin_options, $wp_rem_form_fields;
            $output = '';
            if ( isset($field_obj['type']) && $field_obj['type'] == 'currency_settings' ) {
                $currencies_opt = isset($wp_rem_plugin_options['wp_rem_currencies']) ? $wp_rem_plugin_options['wp_rem_currencies'] : '';
                ob_start();
                ?>
                <div class="wp-rem-list-wrap">
                    <ul class="wp-rem-list-layout">
                        <li class="wp-rem-list-label">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="element-label">
                                    <label><?php echo wp_rem_plugin_text_srt('wp_rem_options_currency_name'); ?></label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="element-label">
                                    <label><?php echo wp_rem_plugin_text_srt('wp_rem_options_currency_symbol'); ?> </label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="element-label">
                                    <label><?php echo wp_rem_plugin_text_srt('wp_rem_options_conversion_rate'); ?> </label>
                                </div>
                            </div>
                        </li>
                        <?php
                        $counter = 0;
                        if ( is_array($currencies_opt) && sizeof($currencies_opt) > 0 ) {
                            foreach ( $currencies_opt as $key => $currency_obj ) {
                                ?>
                                <li class="wp-rem-list-item">
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <!--For Simple Input Element-->
                                        <div class="input-element">
                                            <div class="input-holder">
                                                <?php
                                                $wp_rem_opt_array = array(
                                                    'std' => isset($currency_obj['currency_name']) ? esc_html($currency_obj['currency_name']) : '',
                                                    'cust_name' => 'wp_rem_currencies[' . $counter . '][currency_name]',
                                                    'extra_atr' => 'placeholder="' . wp_rem_plugin_text_srt('wp_rem_options_currency_name') . '"',
                                                    'classes' => 'input-field',
                                                );
                                                $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <!--For Simple Input Element-->
                                        <div class="input-element">
                                            <div class="input-holder">
                                                <?php
                                                $wp_rem_opt_array = array(
                                                    'std' => isset($currency_obj['currency_symbol']) ? esc_html($currency_obj['currency_symbol']) : '',
                                                    'cust_name' => 'wp_rem_currencies[' . $counter . '][currency_symbol]',
                                                    'extra_atr' => 'placeholder="' . wp_rem_plugin_text_srt('wp_rem_options_currency_symbol') . '"',
                                                    'classes' => 'input-field',
                                                );
                                                $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <!--For Simple Input Element-->
                                        <div class="input-element">
                                            <div class="input-holder">
                                                <?php
                                                $wp_rem_opt_array = array(
                                                    'std' => isset($currency_obj['conversion_rate']) ? esc_html($currency_obj['conversion_rate']) : '',
                                                    'cust_name' => 'wp_rem_currencies[' . $counter . '][conversion_rate]',
                                                    'extra_atr' => 'placeholder="' . wp_rem_plugin_text_srt('wp_rem_options_conversion_rate') . '"',
                                                    'classes' => 'input-field',
                                                );
                                                $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="javascript:void(0);" class="wp-rem-remove wp-rem-parent-li-remove"><i class="icon-close2"></i></a>
                                </li>
                                <?php
                                $counter ++;
                            }
                        }
                        ?>
                    </ul>
                    <ul class="wp-rem-list-button-ul">
                        <li class="wp-rem-list-button">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <!--For Simple Input Element-->
                                <div class="input-element">
                                    <a href="javascript:void(0);" id="click-more" class="wp-rem-add-more cntrl-add-new-row add-currencies-opt"><?php echo wp_rem_plugin_text_srt('wp_rem_options_add_more'); ?></a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <?php
                $output = ob_get_clean();
            }
            return $output;
        }

        /*
         * Add More Fields for Currencies
         */

        public function add_currencies_opt_callback() {
            global $post, $wp_rem_form_fields, $wp_rem_html_fields, $wp_rem_plugin_static_text, $wp_rem_plugin_options;
            $counter = isset($_REQUEST['currency_counter']) ? $_REQUEST['currency_counter'] + 1 : 0;
            ?>
            <li class="wp-rem-list-item">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <!--For Simple Input Element-->
                    <div class="input-element">
                        <div class="input-holder">
                            <?php
                            $wp_rem_opt_array = array(
                                'std' => '',
                                'cust_name' => 'wp_rem_currencies[' . $counter . '][currency_name]',
                                'extra_atr' => 'placeholder="' . wp_rem_plugin_text_srt('wp_rem_options_currency_name') . '"',
                                'classes' => 'input-field',
                            );
                            $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <!--For Simple Input Element-->
                    <div class="input-element">
                        <div class="input-holder">
                            <?php
                            $wp_rem_opt_array = array(
                                'std' => '',
                                'cust_name' => 'wp_rem_currencies[' . $counter . '][currency_symbol]',
                                'extra_atr' => 'placeholder="' . wp_rem_plugin_text_srt('wp_rem_options_currency_symbol') . '"',
                                'classes' => 'input-field',
                            );
                            $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <!--For Simple Input Element-->
                    <div class="input-element">
                        <div class="input-holder">
                            <?php
                            $wp_rem_opt_array = array(
                                'std' => '',
                                'cust_name' => 'wp_rem_currencies[' . $counter . '][conversion_rate]',
                                'extra_atr' => 'placeholder="' . wp_rem_plugin_text_srt('wp_rem_options_conversion_rate') . '"',
                                'classes' => 'input-field',
                            );
                            $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                            ?>
                        </div>
                    </div>
                </div>
                <a href="javascript:void(0);" class="wp-rem-remove wp-rem-parent-li-remove"><i class="icon-close2"></i></a>
            </li>
            <?php
            wp_die();
        }

    }

    global $wp_rem_currencies;
    $wp_rem_currencies = new Wp_rem_Currencies();
}