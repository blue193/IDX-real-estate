<?php
/**
 * Property search box
 * default variable which is getting from ajax request or shotcode
 * $property_short_counter, $property_arg
 */
global $wp_rem_plugin_options, $wp_rem_form_fields_frontend, $wp_rem_post_property_types, $wp_rem_shortcode_properties_frontend, $wp_rem_search_fields;
$propertysearch_title_switch = isset($atts['propertysearch_title_field_switch']) ? $atts['propertysearch_title_field_switch'] : '';
$propertysearch_property_type_switch = isset($atts['propertysearch_property_type_field_switch']) ? $atts['propertysearch_property_type_field_switch'] : '';
$propertysearch_location_switch = isset($atts['propertysearch_location_field_switch']) ? $atts['propertysearch_location_field_switch'] : '';
$propertysearch_categories_switch = isset($atts['propertysearch_categories_field_switch']) ? $atts['propertysearch_categories_field_switch'] : '';
$propertysearch_price_switch = isset($atts['propertysearch_price_field_switch']) ? $atts['propertysearch_price_field_switch'] : '';
$propertysearch_advance_filter_switch = isset($atts['propertysearch_advance_filter_switch']) ? $atts['propertysearch_advance_filter_switch'] : '';
$property_types_array = array();
wp_enqueue_script('bootstrap-datepicker');
wp_enqueue_style('datetimepicker');
wp_enqueue_style('datepicker');
wp_enqueue_script('datetimepicker');
$property_type_slug = '';
$property_search_fieled_class = '';
if ( ($propertysearch_title_switch != 'yes') || ($propertysearch_location_switch != 'yes') ) {
    $property_search_fieled_class = ' one-field-hidden';
}
$wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
        array(
            'simple' => true,
            'cust_id' => '',
            'cust_name' => '',
            'classes' => "property-counter",
            'std' => absint($property_short_counter),
        )
);
?> 
<div style="display:none" id='property_arg<?php echo absint($property_short_counter); ?>'>
    <?php
    echo json_encode($property_arg);
    ?>
</div>
<form method="GET" id="top-search-form-<?php echo wp_rem_allow_special_char($property_short_counter); ?>" class="search-form-element" action="<?php echo esc_html($wp_rem_search_result_page); ?>" onsubmit="wp_rem_top_search('<?php echo wp_rem_allow_special_char($property_short_counter); ?>');" data-locationadminurl="<?php echo esc_url(admin_url("admin-ajax.php")); ?>">
    <div class="search-default-fields <?php echo esc_html($property_search_fieled_class); ?>">
        <?php if ( $propertysearch_title_switch == 'yes' ) { ?>
            <div class="field-holder search-input">
                <label>
                    <i class="icon-search4"></i>
                    <?php
                    $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                            array(
                                'cust_name' => 'search_title',
                                'classes' => 'input-field',
                                'extra_atr' => 'placeholder="' . wp_rem_plugin_text_srt('wp_rem_property_search_flter_wt_looking_for') . '"',
                            )
                    );
                    ?> 
                </label>
            </div>
            <?php
        }
        if ( $propertysearch_property_type_switch == 'yes' ) {
            ?>
            <div class="field-holder select-dropdown property-type checkbox"> 
                <?php
                $wp_rem_post_property_types = new Wp_rem_Post_Property_Types();
                $property_types_array = $wp_rem_post_property_types->wp_rem_types_array_callback('NULL');
                if ( is_array($property_types_array) && ! empty($property_types_array) ) {
                    foreach ( $property_types_array as $key => $value ) {
                        $property_type_slug = $key;
                        break;
                    }
                }
                ?>
                <ul>
                    <?php
                    $number_option_flag = 1;
                    foreach ( $property_types_array as $key => $value ) {
                        ?>
                        <li>
                            <?php
                            $checked = '';
                            if ( ( (isset($_REQUEST['property_type']) && $_REQUEST['property_type'] != '') && $_REQUEST['property_type'] == $key ) || $property_type_slug == $key ) {
                                $checked = 'checked="checked"';
                            }
                            $wp_rem_form_fields_frontend->wp_rem_form_radio_render(
                                    array(
                                        'simple' => true,
                                        'cust_id' => 'search_form_property_type' . $number_option_flag,
                                        'cust_name' => 'property_type',
                                        'std' => $key,
                                        'extra_atr' => $checked . ' onchange="wp_rem_property_type_search_fields(this,\'' . $property_short_counter . '\',\'' . $propertysearch_price_switch . '\'); wp_rem_property_type_cate_fields(this,\'' . $property_short_counter . '\',\'' . $propertysearch_categories_switch . '\'); "',
                                    )
                            );
                            ?>
                            <label for="<?php echo force_balance_tags('search_form_property_type' . $number_option_flag) ?>"><?php echo force_balance_tags($value); ?></label>
                        </li>
                        <?php
                        $number_option_flag ++;
                    }
                    ?>
                </ul>
            </div>
            <?php
        }
        ?>
        <div class="field-holder search-btn">
            <div class="search-btn-loader-<?php echo wp_rem_allow_special_char($property_short_counter); ?> input-button-loader">
                <?php
                $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                        array(
                            'cust_name' => '',
                            'classes' => 'bgcolor',
                            'std' => wp_rem_plugin_text_srt('wp_rem_property_search_flter_saerch'),
                            'cust_type' => "submit",
                        )
                );
                ?>  
            </div>
        </div>
    </div>    
</form>