<?php
/**
 * Property search box
 * default variable which is getting from ajax request or shotcode
 * $property_short_counter, $property_arg
 */
global $wp_rem_plugin_options, $wp_rem_form_fields_frontend, $wp_rem_post_property_types, $wp_rem_shortcode_properties_frontend, $wp_rem_search_fields;

$propertysearch_title_switch = isset($atts['propertysearch_title_field_switch']) ? $atts['propertysearch_title_field_switch'] : '';
$wp_rem_search_label_color = isset($atts['wp_rem_search_label_color']) ? $atts['wp_rem_search_label_color'] : '';
$propertysearch_property_type_switch = isset($atts['propertysearch_property_type_field_switch']) ? $atts['propertysearch_property_type_field_switch'] : '';
$propertysearch_location_switch = isset($atts['propertysearch_location_field_switch']) ? $atts['propertysearch_location_field_switch'] : '';
$propertysearch_categories_switch = isset($atts['propertysearch_categories_field_switch']) ? $atts['propertysearch_categories_field_switch'] : '';
$propertysearch_price_switch = isset($atts['propertysearch_price_field_switch']) ? $atts['propertysearch_price_field_switch'] : '';
$propertysearch_advance_filter_switch = isset($atts['propertysearch_advance_filter_switch']) ? $atts['propertysearch_advance_filter_switch'] : '';
$propertysearch_price_type_switch = isset($atts['propertysearch_price_type_switch']) ? $atts['propertysearch_price_type_switch'] : '';

$property_types_array = array();
wp_enqueue_script('bootstrap-datepicker');
wp_enqueue_style('datetimepicker');
wp_enqueue_style('datepicker');
wp_enqueue_script('datetimepicker');

$label_style_colr = '';
if ( isset($wp_rem_search_label_color) && $wp_rem_search_label_color != '' ) {
    $label_style_colr = 'style="color:' . $wp_rem_search_label_color . ' !important"';
}
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
                    <?php
                    $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                            array(
                                'cust_name' => 'search_title',
                                'classes' => 'input-field',
                                'extra_atr' => 'placeholder="' . wp_rem_plugin_text_srt('wp_rem_property_search_view_enter_kywrd') . '"',
                            )
                    );
                    ?> 
                </label>
            </div>
            <?php
        }
        if ( $propertysearch_property_type_switch == 'yes' ) {
            $number_option_flag = 1;
            ?>
            <div id="property_type_select_fields_<?php echo wp_rem_allow_special_char($property_short_counter); ?>" class="property-type-cate-fields field-holder select-dropdown">
                <label>
                    <?php
                    $wp_rem_post_property_types = new Wp_rem_Post_Property_Types();
                    $property_types_array = $wp_rem_post_property_types->wp_rem_types_array_callback('NULL');

                    if ( is_array($property_types_array) && ! empty($property_types_array) ) {
                        foreach ( $property_types_array as $key => $value ) {
                            $property_type_slug = $key;
                            break;
                        }
                    }
                    foreach ( $property_types_array as $key => $value ) {
                        $types_array[$key] = $value;
                    }
                    $wp_rem_opt_array = array(
                        'std' => $property_type_slug,
                        'cust_id' => 'search_form_property_type' . $number_option_flag,
                        'cust_name' => 'property_type',
                        'classes' => 'chosen-select',
                        'options' => $types_array,
                        'extra_atr' => ' onchange="wp_rem_property_type_price_type_field(this,\'' . $property_short_counter . '\',\'' . $propertysearch_price_type_switch . '\',\'modern-v2\'); wp_rem_property_type_cate_fields(this,\'' . $property_short_counter . '\',\'' . $propertysearch_categories_switch . '\',\'modern-v2\'); "',
                    );
                    if ( count($types_array) <= 6 ) {
                        $wp_rem_opt_array['classes'] = 'chosen-select-no-single';
                    }
                    $wp_rem_form_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array);
                    ?>
                </label>
            </div>
            <?php
        }

        $property_cats_array = $wp_rem_search_fields->wp_rem_property_type_categories_options($property_type_slug);
        if ( $propertysearch_categories_switch == 'yes' && ! empty($property_cats_array) ) {
            ?>
            <div id="property_type_cate_fields_<?php echo wp_rem_allow_special_char($property_short_counter); ?>" class="property-category-fields field-holder select-dropdown">

                <label>
                    <?php
                    $wp_rem_opt_array = array(
                        'std' => '',
                        'id' => 'property_category',
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
            </div>
            <?php
        }
        if ( $propertysearch_location_switch == 'yes' ) {
            $wp_rem_select_display = 1;
            wp_rem_get_custom_locations_property_filter('', '', false, $property_short_counter, 'modern-v2');
        }
        ?>
        <div class="field-holder-has-label">
            <?php
            $property_type_id = $wp_rem_search_fields->wp_rem_property_type_id_by_slug($property_type_slug);
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
            if ( $propertysearch_price_type_switch == 'yes' ) {
                $price_types = array( '' => wp_rem_plugin_text_srt('wp_rem_advance_search_select_price_types_all') );
                $price_types = array_merge($price_types, $price_type_options);
                $number_option_flag = 1;
                ?>
                <div id="property_type_price_type_field_<?php echo wp_rem_allow_special_char($property_short_counter); ?>" class="property-price-type-field field-holder select-dropdown">
                    <strong class="search_title"><?php echo wp_rem_plugin_text_srt('wp_rem_advance_search_select_price_type_label'); ?></strong>
                    <label>
                        <?php
                        $wp_rem_opt_array = array(
                            'std' => '',
                            'cust_id' => 'price_type' . $number_option_flag,
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
                </div>
            <?php } ?>
            <?php if ( $propertysearch_price_switch == 'yes' ) { ?>
                <div class="field-holder search-input">
                    <strong class="search_title"><?php echo wp_rem_plugin_text_srt('wp_rem_advance_search_select_price_range'); ?></strong>
                    <div class="field-holder search-input">
                        <label>
                            <?php
                            $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                                    array(
                                        'cust_name' => 'min_price',
                                        'classes' => 'input-field',
                                        'extra_atr' => 'placeholder="' . wp_rem_plugin_text_srt('wp_rem_advance_search_min_price_range') . '"',
                                    )
                            );
                            ?> 
                        </label>
                    </div>
                    <div class="field-holder search-input">
                        <label>
                            <?php
                            $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                                    array(
                                        'cust_name' => 'max_price',
                                        'classes' => 'input-field',
                                        'extra_atr' => 'placeholder="' . wp_rem_plugin_text_srt('wp_rem_advance_search_max_price_range') . '"',
                                    )
                            );
                            ?> 
                        </label>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="field-holder search-btn">
            <strong class="search-title"></strong>
            <div class="search-btn-loader-<?php echo wp_rem_allow_special_char($property_short_counter); ?> input-button-loader">
                <button type="submit" class="bgcolor"><i class="icon-search5"></i> <?php echo wp_rem_plugin_text_srt('wp_rem_property_search_flter_saerch'); ?></button>
            </div>
        </div>
    </div>
</form>