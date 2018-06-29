<?php
/**
 * Property search box
 * default variable which is getting from ajax request or shotcode
 * $property_short_counter, $property_arg
 */
global $wp_rem_plugin_options, $wp_rem_form_fields_frontend, $wp_rem_post_property_types, $wp_rem_shortcode_properties_frontend;
wp_enqueue_script('bootstrap-datepicker');
wp_enqueue_style('datetimepicker');
wp_enqueue_script('datetimepicker');
// passing from shortcode main function
//$property_type;
$property_open_house_filter = isset($atts['property_open_house_filter']) ? $atts['property_open_house_filter'] : 'yes';
$property_price_filter = isset($atts['property_price_filter']) ? $atts['property_price_filter'] : 'yes';
$save_search_box = isset($atts['save_search_box']) ? $atts['save_search_box'] : '';
$notifications_box = isset($atts['notifications_box']) ? $atts['notifications_box'] : '';
$draw_on_map_url = isset($atts['draw_on_map_url']) ? $atts['draw_on_map_url'] : '';
//echo $property_type = isset($atts['property_type']) ? $atts['property_type'] : 'all';
$element_property_search_keyword = isset($atts['property_search_keyword']) ? $atts['property_search_keyword'] : 'no';
$left_filter_count_switch = isset($atts['left_filter_count']) ? $atts['left_filter_count'] : '';
$wp_rem_property_sidebar = isset($atts['wp_rem_property_sidebar']) ? $atts['wp_rem_property_sidebar'] : '';
?>
<aside class="filters-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">

    <div class="wp-rem-filters">
        <?php
        $search_title = isset($_REQUEST['search_title']) ? $_REQUEST['search_title'] : '';
        //echo $property_type = isset($_REQUEST['property_type']) ? $_REQUEST['property_type'] : $property_type;
        $location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
        $radius = isset($_REQUEST['radius']) ? $_REQUEST['radius'] : '';
        $property_price = isset($_REQUEST['property_price']) ? $_REQUEST['property_price'] : '';
        $features = isset($_REQUEST['features']) ? $_REQUEST['features'] : '';

        $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                array(
                    'simple' => true,
                    'cust_id' => "",
                    'cust_name' => 'search_title',
                    'std' => esc_html($search_title),
                )
        );

        $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                array(
                    'simple' => true,
                    'cust_id' => "",
                    'cust_name' => 'location',
                    'std' => wp_rem_allow_special_char($location),
                )
        );
        $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                array(
                    'simple' => true,
                    'cust_id' => "",
                    'cust_name' => 'radius',
                    'std' => esc_html($radius),
                )
        );
        $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                array(
                    'simple' => true,
                    'cust_id' => "",
                    'cust_name' => 'property_price',
                    'std' => esc_html($property_price),
                )
        );
        $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                array(
                    'simple' => true,
                    'cust_id' => "",
                    'cust_name' => 'features',
                    'std' => esc_html($features),
                )
        );
        $reset_var = 0;
        if (isset($_REQUEST)) {
            foreach ($_REQUEST as $qry_var => $qry_val) {
                if ('ajax_filter' == $qry_var || 'advanced_search' == $qry_var || 'property_arg' == $qry_var || 'action' == $qry_var || 'alert-frequency' == $qry_var || 'alerts-name' == $qry_var || 'loc_polygon' == $qry_var || 'alerts-email' == $qry_var)
                    continue;
                if ($qry_val != '') {
                    $reset_var ++;
                }
            }
        }
        if (isset($reset_var) && $reset_var > 0) {
            property_search_keywords($property_totnum, $element_property_search_keyword, $_REQUEST, $atts, $page_url);
        }


        if ($notifications_box == 'yes') {

            //if ( isset( $reset_var ) && $reset_var > 0 ) {
            ?>    
            <div class="search-options">
                <div class="reset-holder">
                    <?php
                    do_action('pre_wp_rem_properties_property');
                    do_action('wp_rem_save_search_element');
                    do_action('wp_rem_draw_search_element', $draw_on_map_url);
                    ?>
                </div>
            </div>
            <?php
            //}
        }
        ?>
        <div class="filters-options">
            <?php
            $property_type_name = 'property_type';
            $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                    array(
                        'simple' => true,
                        'cust_id' => "hidden_input-" . $property_type_name,
                        'cust_name' => $property_type_name,
                        'std' => $property_type,
                        'classes' => $property_type_name,
                        'extra_atr' => 'onchange="wp_rem_property_content(\'' . $property_short_counter . '\');"',
                    )
            );

            $property_type_category_name = 'wp_rem_property_category';
            $property_category = isset($_REQUEST['property_category']) ? $_REQUEST['property_category'] : '';
            $wp_rem_post_property_types = new Wp_rem_Post_Property_Types();
            $property_types_array = $wp_rem_post_property_types->wp_rem_types_array_callback('NULL');
            $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                    array(
                        'simple' => true,
                        'cust_id' => "hidden_input-" . $property_type_category_name,
                        'cust_name' => 'property_category',
                        'std' => $property_category,
                        'classes' => $property_type_category_name,
                        'extra_atr' => 'onchange="wp_rem_property_content(\'' . $property_short_counter . '\');"',
                    )
            );
            ?>
            <script>
                jQuery(function () {
                    'use strict'

                    var $type_checkboxes = jQuery("input[type=checkbox].<?php echo esc_html($property_type_name); ?>");
                    $type_checkboxes.on('change', function () {
                        var val = this.value;
                        jQuery('#frm_property_arg<?php echo esc_html($property_short_counter); ?>').find("input[type=hidden]").val("");
                        jQuery('#frm_property_arg<?php echo esc_html($property_short_counter); ?>').find("input[name=open_house]").val("");
                        jQuery('#hidden_input-<?php echo esc_html($property_type_category_name); ?>').val('');
                        jQuery('#hidden_input-<?php echo esc_html($property_type_name); ?>').val(val);
                        wp_rem_property_content('<?php echo esc_html($property_short_counter); ?>');
                    });

                    var $checkboxes = jQuery("input[type=checkbox].<?php echo esc_html($property_type_category_name); ?>");
                    $checkboxes.on('change', function () {
                        var ids = $checkboxes.filter(':checked').map(function () {
                            return this.value;
                        }).get().join(',');
                        jQuery('#hidden_input-<?php echo esc_html($property_type_category_name); ?>').val(ids);
                        wp_rem_property_content('<?php echo esc_html($property_short_counter); ?>');
                    });

                    var $parent_checkboxes = jQuery("input[type=checkbox].parent_checked_cat");
                    $parent_checkboxes.on('change', function () {
                        var current_val = this.value;
                        var ids = $checkboxes.filter(':checked').map(function () {
                            return this.value;
                        }).get().join(',');
                        var res = ids.split(",");
                        var new_res = new Array();
                        var flag = false;
                        for (var i = 0; i < res.length; ++i) {
                            if (flag == false) {
                                new_res.push(res[i]);
                            }
                            if (res[i] == current_val) {
                                flag = true;
                            }
                        }
                        var new_val = new_res.join(",");
                        jQuery('#hidden_input-<?php echo esc_html($property_type_category_name); ?>').val(new_val);
                        wp_rem_property_content('<?php echo esc_html($property_short_counter); ?>');
                    });
                });
            </script>

            <div class="select-categories">
                <h6><?php echo wp_rem_plugin_text_srt('wp_rem_property_leftflter_property_type'); ?></h6>
                <ul class="cs-parent-checkbox-list">
                    <?php
                    if ($property_type != '' && $property_type != 'all') {
                        if ($post = get_page_by_path($property_type, OBJECT, 'property-type')) {
                            $property_type_id = $post->ID;
                        } else {
                            $property_type_id = 0;
                        }
                        ?>
                        <li>
                            <div class="checkbox">
                                <?php
                                $wp_rem_form_fields_frontend->wp_rem_form_checkbox_render(
                                        array(
                                            'simple' => true,
                                            'cust_id' => 'all_property_type',
                                            'cust_name' => '',
                                            'std' => 'all',
                                            'classes' => $property_type_name,
                                            'extra_atr' => 'onchange="wp_rem_property_content(\'' . $property_short_counter . '\');"',
                                        )
                                );
                                ?>
                                <label for="<?php echo force_balance_tags('all_property_type') ?>"><?php echo wp_rem_plugin_text_srt('wp_rem_property_leftflter_all_properties'); ?></label>
                            </div>
                        </li>
                        <?php
                        if ($property_category == '') {
                            $type_checkbox_display = 'none';
                            $type_label_display = 'block';
                        } else {
                            $type_checkbox_display = 'block';
                            $type_label_display = 'none';
                        }
                        ?>
                        <li style="display:none;">
                            <div class="checkbox">
                                <?php
                                $checked = 'checked="checked"';
                                $wp_rem_form_fields_frontend->wp_rem_form_checkbox_render(
                                        array(
                                            'simple' => true,
                                            'cust_id' => 'check_property_type_' . $property_type_id,
                                            'cust_name' => '',
                                            'std' => $property_type,
                                            'classes' => $property_type_name,
                                            'extra_atr' => $checked,
                                        )
                                );
                                ?>
                                <label for="<?php echo force_balance_tags('check_property_type_' . $property_type_id) ?>"><?php echo esc_html(get_the_title($property_type_id)); ?></label>
                            </div>
                        </li>
                        <li style="display:<?php echo esc_html($type_checkbox_display); ?>;">
                            <div class="checkbox">
                                <?php
                                $checked = 'checked="checked"';
                                $wp_rem_form_fields_frontend->wp_rem_form_checkbox_render(
                                        array(
                                            'simple' => true,
                                            'cust_id' => 'parent_check_property_type_' . $property_type_id,
                                            'cust_name' => '',
                                            'std' => $property_type,
                                            'classes' => $property_type_name,
                                        )
                                );
                                ?>
                                <label for="<?php echo force_balance_tags('parent_check_property_type_' . $property_type_id) ?>"><?php echo esc_html(get_the_title($property_type_id)); ?></label>
                            </div>
                        </li>
                        <li style="display:<?php echo esc_html($type_label_display); ?>;">
                            <strong><?php echo esc_html(get_the_title($property_type_id)); ?><span class="checked"><i class="icon-check"></i></span></strong>
                        </li>
                    <?php } ?>
                    <?php
                    if ($property_category != '') {
                        $property_type_cats = explode(",", $property_category);
                        $category_list_flag = 1;
                        $checked_cats_counts = count($property_type_cats);
                        foreach ($property_type_cats as $property_type_cat) {
                            $term = get_term_by('slug', $property_type_cat, 'property-category');
                            if ($checked_cats_counts == $category_list_flag) {
                                $cat_checkbox_display = 'none';
                                $cat_label_display = 'block';
                            } else {
                                $cat_checkbox_display = 'block';
                                $cat_label_display = 'none';
                            }
                            ?>
                            <li style="display:none;">
                                <div class="checkbox">
                                    <?php
                                    $checked = 'checked="checked"';
                                    $wp_rem_form_fields_frontend->wp_rem_form_checkbox_render(
                                            array(
                                                'simple' => true,
                                                'cust_id' => 'check_' . $property_type_category_name . '_' . $category_list_flag,
                                                'cust_name' => '',
                                                'std' => $property_type_cat,
                                                'classes' => $property_type_category_name,
                                                'extra_atr' => $checked,
                                            )
                                    );
                                    ?>
                                    <label for="<?php echo force_balance_tags('check_' . $property_type_category_name . '_' . $category_list_flag); ?>"><?php echo esc_html($term->name); ?></label>
                                </div>
                            </li>
                            <li style="display:<?php echo esc_html($cat_checkbox_display); ?>;">
                                <div class="checkbox">
                                    <?php
                                    $wp_rem_form_fields_frontend->wp_rem_form_checkbox_render(
                                            array(
                                                'simple' => true,
                                                'cust_id' => 'parent_check_' . $property_type_category_name . '_' . $category_list_flag,
                                                'cust_name' => '',
                                                'std' => $property_type_cat,
                                                'classes' => 'parent_checked_cat',
                                            )
                                    );
                                    ?>
                                    <label for="<?php echo force_balance_tags('parent_check_' . $property_type_category_name . '_' . $category_list_flag); ?>"><?php echo esc_html($term->name); ?></label>
                                </div>
                            </li>
                            <li style="display:<?php echo esc_html($cat_label_display); ?>;">
                                <strong><?php echo esc_html($term->name); ?><span class="checked"><i class="icon-check"></i></span></strong>
                            </li>
                            <?php
                            $category_list_flag ++;
                        }
                    }
                    ?>
                </ul>



                <?php if ($property_type == '' || $property_type == 'all') { ?>
                    <ul class="cs-checkbox-list">
                        <?php
                        $property_type_flag = 1;
                        foreach ($property_types_array as $key => $value) {
                            $type_totnum = wp_rem_get_property_type_item_count($left_filter_count_switch, $key, 'wp_rem_property_type', $args_count);
                            ?>
                            <li>
                                <div class="checkbox">
                                    <?php
                                    $wp_rem_form_fields_frontend->wp_rem_form_checkbox_render(
                                            array(
                                                'simple' => true,
                                                'cust_id' => 'property_type_' . $property_type_flag,
                                                'cust_name' => '',
                                                'std' => $key,
                                                'classes' => $property_type_name,
                                            )
                                    );
                                    ?>
                                    <label for="<?php echo force_balance_tags('property_type_' . $property_type_flag) ?>"><?php echo force_balance_tags($value); ?></label>
                                    <?php if ($left_filter_count_switch == 'yes') { ?><span>(<?php echo esc_html($type_totnum); ?>)</span><?php } ?>
                                </div>
                            </li>
                            <?php $property_type_flag ++; ?>
                        <?php } ?>
                    </ul>
                    <?php
                }

                $property_type_cats = array();
                if ($property_type != '' && $property_type != 'all' && $property_category == '') {
                    if ($post = get_page_by_path($property_type, OBJECT, 'property-type')) {
                        $property_type_id = $post->ID;
                    } else {
                        $property_type_id = 0;
                    }
                    $property_type_cats = get_post_meta($property_type_id, 'wp_rem_property_type_cats', true);
                } else if ($property_type != '' && $property_type != 'all' && $property_category != '') {
                    $category_request_val_arr = explode(",", $property_category);
                    $last_checked_cat = end($category_request_val_arr);
                    $term = get_term_by('slug', $last_checked_cat, 'property-category');
                    $term_childrens = get_term_children($term->term_id, 'property-category');
                    if (!empty($term_childrens)) {
                        foreach ($term_childrens as $term_children_id) {
                            $child_term = get_term_by('id', $term_children_id, 'property-category');
                            $property_type_cats[] = $child_term->slug;
                        }
                    }
                }

                if (!empty($property_type_cats)) {
                    ?>
                    <ul class="cs-checkbox-list">
                        <?php
                        $category_list_flag = 1;
                        foreach ($property_type_cats as $property_type_cat) {
                            $term = get_term_by('slug', $property_type_cat, 'property-category');

                            // extra condidation
                            $cate_count_arr = array(
                                'key' => $property_type_category_name,
                                'value' => serialize($term->slug),
                                'compare' => 'LIKE',
                            );
                            // main query array $args_count
                            $cate_totnum = wp_rem_get_item_count($left_filter_count_switch, $args_count, $cate_count_arr, $property_type, $property_short_counter, $atts, $property_type_category_name);
                            ?>
                            <li>
                                <div class="checkbox">
                                    <?php
                                    $wp_rem_form_fields_frontend->wp_rem_form_checkbox_render(
                                            array(
                                                'simple' => true,
                                                'cust_id' => $property_type_category_name . '_' . $category_list_flag,
                                                'cust_name' => '',
                                                'std' => $property_type_cat,
                                                'classes' => $property_type_category_name,
                                            )
                                    );
                                    ?>
                                    <label for="<?php echo force_balance_tags($property_type_category_name . '_' . $category_list_flag); ?>"><?php echo esc_html($term->name); ?></label>
                                    <?php if ($left_filter_count_switch == 'yes') { ?><span>(<?php echo esc_html($cate_totnum); ?>)</span><?php } ?>
                                </div>
                            </li>
                            <?php $category_list_flag ++; ?>
                            <?php
                        }
                        ?>
                    </ul>
                <?php } ?>
            </div>
            <?php /* if ($property_open_house_filter == 'yes') { ?>
                <div class="select-categories">
                    <h6><?php echo wp_rem_plugin_text_srt('wp_rem_property_leftflter_open_house'); ?></h6>
                    <?php wp_rem_property_search_reset_field($_REQUEST, $page_url, 'open_house'); ?>
                    <ul class="cs-checkbox-list">
                        <li>
                            <div class="checkbox">
                                <?php
                                // extra condidation
                                // main query array $args_count
                                $open_house_count = wp_rem_get_item_count($left_filter_count_switch, $args_count, '', $property_type, $property_short_counter, $atts, 'open_house_start', 'today');
                                //$open_house_count   = wp_rem_get_property_open_house_count($left_filter_count_switch, 'today', $args_count);
                                $open_house_checked = ( isset($_REQUEST['open_house']) && $_REQUEST['open_house'] == 'today' ) ? ' checked' : '';
                                $wp_rem_form_fields_frontend->wp_rem_form_radio_render(
                                        array(
                                            'simple' => true,
                                            'cust_id' => 'today_time',
                                            'cust_name' => 'open_house',
                                            'std' => 'today',
                                            'classes' => '',
                                            'extra_atr' => 'onchange="wp_rem_property_content(\'' . $property_short_counter . '\');"' . $open_house_checked,
                                        )
                                );
                                ?>
                                <label for="today_time"><?php echo wp_rem_plugin_text_srt('wp_rem_property_leftflter_open_house_today_only'); ?></label>
                                <?php if ($left_filter_count_switch == 'yes') { ?><span>(<?php echo esc_html($open_house_count); ?>)</span><?php } ?>
                            </div>
                        </li>                        
                        <li>
                            <div class="checkbox">
                                <?php
                                $open_house_count = wp_rem_get_item_count($left_filter_count_switch, $args_count, '', $property_type, $property_short_counter, $atts, 'open_house_start', 'tomorrow');
                                $open_house_checked = ( isset($_REQUEST['open_house']) && $_REQUEST['open_house'] == 'tomorrow' ) ? ' checked' : '';
                                $wp_rem_form_fields_frontend->wp_rem_form_radio_render(
                                        array(
                                            'simple' => true,
                                            'cust_id' => 'tomorrow_time',
                                            'cust_name' => 'open_house',
                                            'std' => 'tomorrow',
                                            'classes' => '',
                                            'extra_atr' => 'onchange="wp_rem_property_content(\'' . $property_short_counter . '\');"' . $open_house_checked,
                                        )
                                );
                                ?>
                                <label for="tomorrow_time"><?php echo wp_rem_plugin_text_srt('wp_rem_property_leftflter_open_house_tomorrow_only'); ?></label>
                                <?php if ($left_filter_count_switch == 'yes') { ?><span>(<?php echo esc_html($open_house_count); ?>)</span><?php } ?>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <?php
                                $open_house_count = wp_rem_get_item_count($left_filter_count_switch, $args_count, '', $property_type, $property_short_counter, $atts, 'open_house_start', 'through_weekend');
                                $open_house_checked = ( isset($_REQUEST['open_house']) && $_REQUEST['open_house'] == 'through_weekend' ) ? ' checked' : '';
                                $wp_rem_form_fields_frontend->wp_rem_form_radio_render(
                                        array(
                                            'simple' => true,
                                            'cust_id' => 'through_weekend_time',
                                            'cust_name' => 'open_house',
                                            'std' => 'through_weekend',
                                            'classes' => '',
                                            'extra_atr' => 'onchange="wp_rem_property_content(\'' . $property_short_counter . '\');"' . $open_house_checked,
                                        )
                                );
                                ?>
                                <label for="through_weekend_time"><?php echo wp_rem_plugin_text_srt('wp_rem_property_leftflter_open_house_till_weekends'); ?></label>
                                <?php if ($left_filter_count_switch == 'yes') { ?><span>(<?php echo esc_html($open_house_count); ?>)</span><?php } ?>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <?php
                                $open_house_count = wp_rem_get_item_count($left_filter_count_switch, $args_count, '', $property_type, $property_short_counter, $atts, 'open_house_start', 'weekend_only');
                                $open_house_checked = ( isset($_REQUEST['open_house']) && $_REQUEST['open_house'] == 'weekend_only' ) ? ' checked' : '';
                                $wp_rem_form_fields_frontend->wp_rem_form_radio_render(
                                    array(
                                        'simple' => true,
                                        'cust_id' => 'this_weekend_time',
                                        'cust_name' => 'open_house',
                                        'std' => 'weekend_only',
                                        'classes' => '',
                                        'extra_atr' => 'onchange="wp_rem_property_content(\'' . $property_short_counter . '\');"' . $open_house_checked,
                                    )
                                );
                                ?>
                                <label for="this_weekend_time"><?php echo wp_rem_plugin_text_srt('wp_rem_property_leftflter_open_house_upcoming_weekends'); ?></label>
                                <?php if ($left_filter_count_switch == 'yes') { ?><span>(<?php echo esc_html($open_house_count); ?>)</span><?php } ?>
                            </div>
                        </li>
                    </ul>

                </div>
                <?php
            }
//echo 'in filters 444'; exit;

            if ($property_open_house_filter == 'yes') {

                $property_type_obj = get_page_by_path($property_type, OBJECT, 'property-type');
                $property_type_id = isset($property_type_obj->ID) ? $property_type_obj->ID : '';
                $price_switch = get_post_meta($property_type_id, 'wp_rem_property_type_price', true);
                if ($price_switch != 'off' && $property_type_id != '') {
                    $price_type = get_post_meta($property_type_id, 'wp_rem_property_type_price_type', true);
                    $wp_rem_price_minimum_options = get_post_meta($property_type_id, 'wp_rem_price_minimum_options', true);
                    $wp_rem_price_minimum_options = (!empty($wp_rem_price_minimum_options) ) ? $wp_rem_price_minimum_options : 1;
                    $wp_rem_price_max_options = get_post_meta($property_type_id, 'wp_rem_price_max_options', true);
                    $wp_rem_price_max_options = (!empty($wp_rem_price_max_options) ) ? $wp_rem_price_max_options : 50; //50000;
                    $wp_rem_price_interval = get_post_meta($property_type_id, 'wp_rem_price_interval', true);
                    $wp_rem_price_interval = (!empty($wp_rem_price_interval) ) ? $wp_rem_price_interval : 50;
                    $price_type_options = array();
                    $wp_rem_price_interval = (int) $wp_rem_price_interval;
                    $price_counter = $wp_rem_price_minimum_options;
                    $price_min = '';
                    $price_max = '';
                    $price_min[''] = wp_rem_plugin_text_srt('wp_rem_property_leftflter_min');
                    $price_max[''] = wp_rem_plugin_text_srt('wp_rem_property_leftflter_max');
                    while ($price_counter <= $wp_rem_price_max_options) {
                        $price_min[$price_counter] = $price_counter;
                        $price_max[$price_counter] = $price_counter;
                        $price_counter = $price_counter + $wp_rem_price_interval;
                    }
                    if ($price_type == 'variant') {
                        $price_type_options = array(
                            '' => wp_rem_plugin_text_srt('wp_rem_property_leftflter_all'),
                            'variant_week' => wp_rem_plugin_text_srt('wp_rem_property_leftflter_per_weak'),
                            'variant_month' => wp_rem_plugin_text_srt('wp_rem_property_leftflter_per_calender_month'),
                        );
                        ?>
                        <div class="select-categories">
                            <h6><?php echo wp_rem_plugin_text_srt('wp_rem_property_leftflter_price_options'); ?></h6>
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
                    <?php } ?>
                    <div class="wp-rem-min-max-price">
                        <div class="select-categories">
                            <h6><?php echo wp_rem_plugin_text_srt('wp_rem_property_leftflter_price'); ?></h6>
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
                                            )
                                    );
                                    ?>
                                </li>
                            </ul>
                        </div>
                        <div class="select-categories">
                            <h6>&nbsp;</h6>
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
                                            )
                                    );
                                    ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php
                }
            }
            */ ?>

            <?php
            // $property_type getting from shortcode backend element
            if (isset($property_type) && $property_type != '') {
                $wp_rem_property_type_cus_fields = $wp_rem_post_property_types->wp_rem_types_custom_fields_array($property_type);
                $wp_rem_fields_output = '';
                if (is_array($wp_rem_property_type_cus_fields) && sizeof($wp_rem_property_type_cus_fields) > 0) {
                    $custom_field_flag = 1;
                    foreach ($wp_rem_property_type_cus_fields as $cus_fieldvar => $cus_field) {

                        $all_item_empty = 0;
                        $query_str_var_name = '';
                        if (isset($cus_field['options']['value']) && is_array($cus_field['options']['value'])) {

                            foreach ($cus_field['options']['value'] as $cus_field_options_value) {

                                if ($cus_field_options_value != '') {
                                    $all_item_empty = 0;
                                    break;
                                } else {
                                    $all_item_empty = 1;
                                }
                            }
                        }
                        if (isset($cus_field['enable_srch']) && $cus_field['enable_srch'] == 'yes' && ($all_item_empty == 0)) {
                            $query_str_var_name = $cus_field['meta_key'];
                            ?> 
                            <div class="select-categories">
                                <h6><?php echo esc_html($cus_field['label']); ?></h6>
                                <?php if ($cus_field['type'] == 'dropdown' && $cus_field['multi'] != 'yes') { ?>
                                    <?php wp_rem_property_search_reset_field($_REQUEST, $page_url, $query_str_var_name); ?>
                                <?php } ?>
                                <?php
                                if ($cus_field['type'] == 'dropdown') {
                                    $number_option_flag = 1;
                                    $cut_field_flag = 0;
                                    $request_val = isset($_REQUEST[$query_str_var_name]) ? $_REQUEST[$query_str_var_name] : '';
                                    $request_val_arr = explode(",", $request_val);
                                    if ($cus_field['multi'] == 'yes') { // if multi select then use hidden for submittion
                                        $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                                                array(
                                                    'simple' => true,
                                                    'cust_id' => "hidden_input-" . $query_str_var_name,
                                                    'cust_name' => $query_str_var_name,
                                                    'std' => $request_val,
                                                    'classes' => $query_str_var_name,
                                                    'extra_atr' => 'onchange="wp_rem_property_content(\'' . $property_short_counter . '\');"',
                                                )
                                        );
                                        ?>

                                        <script>
                                            jQuery(function () {
                                                'use strict'
                                                var $checkboxes = jQuery("input[type=checkbox].<?php echo esc_html($query_str_var_name); ?>");
                                                $checkboxes.on('change', function () {
                                                    var ids = $checkboxes.filter(':checked').map(function () {
                                                        return this.value;
                                                    }).get().join(',');
                                                    jQuery('#hidden_input-<?php echo esc_html($query_str_var_name); ?>').val(ids);
                                                    wp_rem_property_content('<?php echo esc_html($property_short_counter); ?>');
                                                });

                                            });
                                        </script>
                                        <?php
                                    }
                                    ?>
                                    <ul class="cs-checkbox-list"><?php
                                        foreach ($cus_field['options']['value'] as $cus_field_options_value) {
                                            if ($cus_field['options']['value'][$cut_field_flag] == '' || $cus_field['options']['label'][$cut_field_flag] == '') {
                                                $cut_field_flag ++;
                                                continue;
                                            }

                                            // get count of each item
                                            // extra condidation
                                            if ($cus_field['post_multi'] == 'yes') {

                                                $dropdown_count_arr = array(
                                                    'key' => $query_str_var_name,
                                                    'value' => serialize($cus_field_options_value),
                                                    'compare' => 'Like',
                                                );
                                            } else {
                                                $dropdown_count_arr = array(
                                                    'key' => $query_str_var_name,
                                                    'value' => $cus_field_options_value,
                                                    'compare' => '=',
                                                );
                                            }
                                            // main query array $args_count 
                                            $dropdown_totnum = wp_rem_get_item_count($left_filter_count_switch, $args_count, $dropdown_count_arr, $property_type, $property_short_counter, $atts, $query_str_var_name);
                                            if ($cus_field_options_value != '') {
                                                if ($cus_field['multi'] == 'yes') {
                                                    ?>
                                                    <li>
                                                        <div class="checkbox">
                                                            <?php
                                                            $checked = '';
                                                            if (!empty($request_val_arr) && in_array($cus_field_options_value, $request_val_arr)) {
                                                                $checked = 'checked="checked"';
                                                            }
                                                            $wp_rem_form_fields_frontend->wp_rem_form_checkbox_render(
                                                                    array(
                                                                        'simple' => true,
                                                                        'cust_id' => $query_str_var_name . '_' . $number_option_flag,
                                                                        'cust_name' => '',
                                                                        'std' => $cus_field_options_value,
                                                                        'classes' => $query_str_var_name,
                                                                        'extra_atr' => $checked . 'onchange=""',
                                                                    )
                                                            );
                                                            ?>

                                                            <label for="<?php echo force_balance_tags($query_str_var_name . '_' . $number_option_flag) ?>"><?php echo force_balance_tags($cus_field['options']['label'][$cut_field_flag]); ?></label>
                                                            <?php if ($left_filter_count_switch == 'yes') { ?><span>(<?php echo esc_html($dropdown_totnum); ?>)</span><?php } ?>
                                                        </div>
                                                    </li>

                                                    <?php
                                                } else {
                                                    ?>
                                                    <li style="">
                                                        <div class="checkbox">
                                                            <?php
                                                            $checked = '';
                                                            if (!empty($request_val) && $cus_field_options_value == $request_val) {
                                                                $checked = 'checked="checked"';
                                                            }
                                                            $wp_rem_form_fields_frontend->wp_rem_form_radio_render(
                                                                    array(
                                                                        'simple' => true,
                                                                        'cust_id' => $query_str_var_name . '_' . $number_option_flag,
                                                                        'cust_name' => $query_str_var_name,
                                                                        'std' => $cus_field_options_value,
                                                                        'extra_atr' => $checked . ' onchange="wp_rem_property_content(\'' . esc_html($property_short_counter) . '\');"',
                                                                    )
                                                            );
                                                            ?>
                                                            <label for="<?php echo force_balance_tags($query_str_var_name . '_' . $number_option_flag) ?>"><?php echo force_balance_tags($cus_field['options']['label'][$cut_field_flag]); ?></label>
                                                            <?php if ($left_filter_count_switch == 'yes') { ?><span>(<?php echo esc_html($dropdown_totnum); ?>)</span><?php } ?>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            $number_option_flag ++;
                                            $cut_field_flag ++;
                                        }
                                        ?>
                                    </ul>
                                    <?php
                                } else if ($cus_field['type'] == 'text' || $cus_field['type'] == 'email' || $cus_field['type'] == 'url') {
                                    ?>
                                    <div class="select-categories">
                                        <?php
                                        $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                                                array(
                                                    'id' => $query_str_var_name,
                                                    'cust_name' => $query_str_var_name,
                                                    'classes' => 'form-control',
                                                    'std' => isset($_REQUEST[$query_str_var_name]) ? $_REQUEST[$query_str_var_name] : '',
                                                    'extra_atr' => 'onchange="wp_rem_property_content(\'' . $property_short_counter . '\');"',
                                                )
                                        );
                                        ?>
                                    </div>   
                                    <?php
                                } else if ($cus_field['type'] == 'number') {

                                    $value = isset($_REQUEST[$query_str_var_name]) ? $_REQUEST[$query_str_var_name] : '';
                                    $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                                            array(
                                                'simple' => true,
                                                'cust_id' => "number-hidden-" . $query_str_var_name,
                                                'cust_name' => wp_rem_allow_special_char($query_str_var_name),
                                                'std' => esc_html($value),
                                            )
                                    );
                                    ?>
                                    <div class="select-categories">
                                        <ul class="minimum-loading-list">
                                            <li>
                                                <div class="spinner-btn input-group spinner">
                                                    <span><i class="icon-bed2"></i></span>
                                                    <?php
                                                    $value = isset($_REQUEST[$query_str_var_name]) ? $_REQUEST[$query_str_var_name] : $cus_field['default_value'];

                                                    $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                                                            array(
                                                                'id' => 'wp_rem_' . wp_rem_allow_special_char($query_str_var_name),
                                                                'cust_name' => '',
                                                                'classes' => "num-input" . esc_html($query_str_var_name) . " form-control",
                                                                'std' => isset($value) && $value != '' ? $value : 0,
                                                            )
                                                    );
                                                    ?>
                                                    <span class="list-text"><?php echo esc_html($cus_field['label']); ?></span>
                                                    <div class="input-group-btn-vertical">
                                                        <button class="btn-decrement<?php echo esc_html($query_str_var_name); ?> caret-btn btn-default " type="button"><i class="icon-minus-circle"></i></button>
                                                        <button class="btn-increment<?php echo esc_html($query_str_var_name); ?> caret-btn btn-default" type="button"><i class="icon-plus-circle"></i></button>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <script type="text/javascript">
                                            jQuery(document).ready(function ($) {
                                                $(".num-input<?php echo esc_html($query_str_var_name); ?>").keypress(function (e) {
                                                    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                                        return false;
                                                    }
                                                });
                                                $('.select-categories .spinner .btn-increment<?php echo esc_html($query_str_var_name); ?>').on('click', function () {
                                                    var field_value = $('.select-categories .spinner .num-input<?php echo esc_html($query_str_var_name); ?>').val();

                                                    field_value = field_value || 0;

                                                    $('.select-categories .spinner .num-input<?php echo esc_html($query_str_var_name); ?>').val(parseInt(field_value, 10) + 1);
                                                    var selected_num = parseInt(field_value, 10) + 1;
                                                    $('.select-categories #number-hidden-<?php echo esc_html($query_str_var_name); ?>').val(selected_num);

                                                    submit_left_sidebar_form();
                                                });
                                                $('.select-categories .spinner .btn-decrement<?php echo esc_html($query_str_var_name); ?>').on('click', function () {
                                                    var field_value = $('.select-categories .spinner .num-input<?php echo esc_html($query_str_var_name); ?>').val();
                                                    field_value = field_value || 0;
                                                    var val = parseInt(field_value, 10);
                                                    if (val < 1) {
                                                        //return;
                                                    }
                                                    var minus_val = val - 1;
                                                    if (minus_val < 0) {
                                                        minus_val = 0;
                                                    }
                                                    $('.select-categories .spinner .num-input<?php echo esc_html($query_str_var_name); ?>').val(minus_val);
                                                    var selected_num = minus_val;
                                                    $('.select-categories #number-hidden-<?php echo esc_html($query_str_var_name); ?>').val(selected_num);
                                                    submit_left_sidebar_form();
                                                });
                                                $(".select-categories .num-input<?php echo esc_html($query_str_var_name); ?>").on('change keydown', function () {
                                                    var field_value = $('.spinner .num-input<?php echo esc_html($query_str_var_name); ?>').val();
                                                    field_value = field_value || 0;
                                                    var selected_num = field_value;
                                                    $('.select-categories #number-hidden-<?php echo esc_html($query_str_var_name); ?>').val(selected_num);
                                                    submit_left_sidebar_form();
                                                });
                                                var timer = 0;
                                                function submit_left_sidebar_form() {
                                                    clearTimeout(timer);
                                                    timer = setTimeout(function () {
                                                        wp_rem_property_content('<?php echo wp_rem_allow_special_char($property_short_counter); ?>');
                                                    }, 1000);
                                                }
                                            });
                                        </script>
                                        <?php ?>
                                    </div>
                                    <?php
                                } else if ($cus_field['type'] == 'date') {
                                    wp_enqueue_script('bootstrap-datepicker');
                                    wp_enqueue_style('datetimepicker');
                                    wp_enqueue_style('datepicker');
                                    wp_enqueue_script('datetimepicker');
                                    ?>
                                    <div class="select-categories">
                                        <div class="cs-datepicker">
                                            <div class="datepicker-text-bottom"><i class="<?php echo $cus_field['fontawsome_icon']; ?>"></i> </div>
                                            <label id="Deadline" class="cs-calendar-from">
                                                <?php
                                                $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                                                        array(
                                                            'id' => 'from' . $query_str_var_name,
                                                            'cust_name' => 'from' . $query_str_var_name,
                                                            'classes' => 'form-control',
                                                            'std' => isset($_REQUEST['from' . $query_str_var_name]) ? $_REQUEST['from' . $query_str_var_name] : '',
                                                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_property_leftflter_fron_date') . '" onchange="wp_rem_property_content(\'' . $property_short_counter . '\');"',
                                                        )
                                                );
                                                ?>

                                            </label>
                                        </div>
                                        <div class="cs-datepicker">
                                            <div class="datepicker-text-bottom"><i class="<?php echo $cus_field['fontawsome_icon']; ?>"></i> </div>
                                            <label id="Deadline" class="cs-calendar-to">
                                                <?php
                                                $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                                                        array(
                                                            'id' => 'to' . $query_str_var_name,
                                                            'cust_name' => 'to' . $query_str_var_name,
                                                            'classes' => 'form-control',
                                                            'std' => isset($_REQUEST['to' . $query_str_var_name]) ? $_REQUEST['to' . $query_str_var_name] : '',
                                                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_property_leftflter_to_date') . '" onchange="wp_rem_property_content(\'' . $property_short_counter . '\');"',
                                                        )
                                                );
                                                ?>

                                            </label>
                                        </div>
                                    </div>
                                    <?php
                                    echo '<script>
                                        jQuery( document ).ready(function() {
                                                if (jQuery(".cs-calendar-from input").length != "") {
                                                jQuery(".cs-calendar-from input").datetimepicker({
                                                    minDate: new Date(),
                                                    timepicker:false,
                                                    format:	"Y/m/d",
													scrollInput: false
                                                });
                                            }
                                            if (jQuery(".cs-calendar-to input").length != "") {
                                                jQuery(".cs-calendar-to input").datetimepicker({
                                                    minDate: new Date(),
                                                    timepicker:false,
                                                    format:	"Y/m/d",
													scrollInput: false
                                                });
                                            }
                                        });
                                        </script>';
                                } elseif ($cus_field['type'] == 'range') {
                                    $range_random_id = rand(123, 32);
                                    $range_min = $cus_field['min'];
                                    $range_max = $cus_field['max'];
                                    $range_increment = $cus_field['increment'];
                                    $filed_type = $cus_field['srch_style']; //input, slider, input_slider
                                    if (strpos($filed_type, '-') !== FALSE) {
                                        $filed_type_arr = explode("_", $filed_type);
                                    } else {
                                        $filed_type_arr[0] = $filed_type;
                                    }
                                    $range_flag = 0;
                                    while (count($filed_type_arr) > $range_flag) {
                                        if ($filed_type_arr[$range_flag] == 'input') {
//                                                            }
                                        } elseif ($filed_type_arr[$range_flag] == 'slider') { // if slider style
                                            if ((isset($cus_field['min']) && $cus_field['min'] != '') && (isset($cus_field['max']) && $cus_field['max'] != '' )) {
                                                $range_complete_str_first = "";
                                                $range_complete_str_second = "";
                                                $range_complete_str = '';
                                                if (isset($_REQUEST[$query_str_var_name])) {
                                                    $range_complete_str = $_REQUEST[$query_str_var_name];
                                                    $range_complete_str_val = $cus_field['min'] . ',' . $cus_field['max'];
                                                    $range_complete_str_arr = explode(",", $range_complete_str);
                                                    $range_complete_str_first = isset($range_complete_str_arr[0]) ? $range_complete_str_arr[0] : '';
                                                    $range_complete_str_second = isset($range_complete_str_arr[1]) ? $range_complete_str_arr[1] : '';
                                                } else {
                                                    $range_complete_str = $cus_field['min'] . ',' . $cus_field['max'];
                                                    $range_complete_str_val = '';
                                                    $range_complete_str_first = $cus_field['min'];
                                                    $range_complete_str_second = $cus_field['max'];
                                                }

                                                $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                                                        array(
                                                            'simple' => true,
                                                            'cust_id' => "range-hidden-" . $query_str_var_name . $range_random_id,
                                                            'cust_name' => $query_str_var_name,
                                                            'std' => esc_html($range_complete_str_val),
                                                            'classes' => $query_str_var_name,
                                                            'extra_atr' => 'onchange="wp_rem_property_content(\'' . $property_short_counter . '\');"',
                                                        )
                                                );
                                                ?>
                                                <div class="price-per-person kk_slider"> 
                                                    <?php
                                                    $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                                                            array(
                                                                'cust_id' => 'ex16b2' . esc_html($query_str_var_name . $range_random_id),
                                                                'cust_name' => '',
                                                                'classes' => '',
                                                                'std' => '',
                                                            )
                                                    );
                                                    ?>
                                                    <span class="rang-text"><span class="kk_slider_from"><?php echo esc_html($range_complete_str_first); ?></span>&nbsp; - &nbsp;<span class="kk_slider_to"><?php echo esc_html($range_complete_str_second); ?></span></span>
                                                </div>
                                                <?php
                                                $increment_step = isset($cus_field['increment']) ? $cus_field['increment'] : 1;
                                                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                                                    echo '<script>
														if (jQuery("#ex16b2' . $query_str_var_name . $range_random_id . '").length > 0) {
															jQuery("#ex16b2' . $query_str_var_name . $range_random_id . '").slider({
																step : ' . esc_html($increment_step) . ',
																min: ' . esc_html($cus_field['min']) . ',
																max: ' . esc_html($cus_field['max']) . ',
																value: [ ' . esc_html($range_complete_str) . '],


															});
															jQuery("#ex16b2' . $query_str_var_name . $range_random_id . '").on("slideStop", function () {
																var rang_slider_val = jQuery("#ex16b2' . $query_str_var_name . $range_random_id . '").val();
																jQuery("#range-hidden-' . $query_str_var_name . $range_random_id . '").val(rang_slider_val); 
																wp_rem_property_content("' . esc_html($property_short_counter) . '");
															});
                                                            kk_update_slider_params_onchange("#ex16b2' . $query_str_var_name . $range_random_id . '");
														}
													</script>';
                                                } else {
                                                    echo '<script>
														jQuery( document ).ready(function() {
															if (jQuery("#ex16b2' . $query_str_var_name . $range_random_id . '").length > 0) {
																jQuery("#ex16b2' . $query_str_var_name . $range_random_id . '").slider({
																	step : ' . esc_html($increment_step) . ',
																	min: ' . esc_html($cus_field['min']) . ',
																	max: ' . esc_html($cus_field['max']) . ',
																	value: [ ' . esc_html($range_complete_str) . '],


																});
																jQuery("#ex16b2' . $query_str_var_name . $range_random_id . '").on("slideStop", function () {
																	var rang_slider_val = jQuery("#ex16b2' . $query_str_var_name . $range_random_id . '").val();
																	jQuery("#range-hidden-' . $query_str_var_name . $range_random_id . '").val(rang_slider_val); 
																	wp_rem_property_content("' . esc_html($property_short_counter) . '");
																});
                                                                kk_update_slider_params_onchange("#ex16b2' . $query_str_var_name . $range_random_id . '");
															}
														});
													</script>';
                                                }
                                            }
                                        }
                                        $range_flag ++;
                                    }
                                } else {
                                    echo esc_html($cus_field['type']);
                                }
                                ?>

                            </div>
                            <?php
                        }
                        $custom_field_flag ++;
                    }
                    echo force_balance_tags($wp_rem_fields_output);
                }
            }
            ?>


            <!--</div>-->
            <!--</div>-->
        </div>
    </div><!-- end of filters-->
    <div class="property-filters-ads">
        <?php do_action('wp_rem_random_ads', 'property_banner_leftfilter');
        ?>
    </div>
    <?php
    if (is_active_sidebar($wp_rem_property_sidebar)) {
        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($wp_rem_property_sidebar)) :
            echo '';
        endif;
    }
    ?>



</aside>