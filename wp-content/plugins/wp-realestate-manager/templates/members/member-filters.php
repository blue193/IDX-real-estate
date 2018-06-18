<?php
/**
 * Property search box
 * default variable which is getting from ajax request or shotcode
 * $member_short_counter, $property_arg
 */
global $wp_rem_plugin_options, $wp_rem_form_fields_frontend, $wp_rem_post_property_types, $wp_rem_shortcode_properties_frontend, $wp_rem_search_fields;



wp_enqueue_script('bootstrap-datepicker');
wp_enqueue_style('datetimepicker');
wp_enqueue_style('datepicker');
wp_enqueue_script('datetimepicker');
$property_type_slug = '';
$search_title = isset($_REQUEST['search_title']) ? $_REQUEST['search_title'] : '';
$member_type = isset($_REQUEST['member_type']) ? $_REQUEST['member_type'] : '';

$wp_rem_opt_array = array(
	'id' => 'property_counter',
	'classes' => 'property-counter',
	'std' => absint($member_short_counter),
);
$wp_rem_form_fields_frontend->wp_rem_form_hidden_render($wp_rem_opt_array);
?>
<div class="main-search member-search">
    <h5><?php echo wp_rem_plugin_text_srt('wp_rem_member_find_real_members'); ?></h5>    
    <form method="GET" id="top-search-form-<?php echo wp_rem_allow_special_char($member_short_counter); ?>"  onsubmit="wp_rem_top_search('<?php echo wp_rem_allow_special_char($member_short_counter); ?>');">
        <div role="tabpanel" class="tab-pane" id="home">
            <div class="search-default-fields">
                <div class="field-holder search-input has-icon">
                    <label>
                        <i class="icon-search4"></i>
                        <?php
                        $wp_rem_opt_array = array(
                            'cust_name' => 'search_title',
                            'return' => false,
                            'std' => esc_html($search_title),
                            'classes' => 'input-field',
                            'extra_atr' => ' placeholder=" ' . wp_rem_plugin_text_srt('wp_rem_member_search_enter_name') . '"',
                        );
                        $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                        ?>
                    </label>
                </div>

                <?php
                $member_title = isset($wp_rem_plugin_options['member_title']) ? $wp_rem_plugin_options['member_title'] : '';
                $member_value = isset($wp_rem_plugin_options['member_value']) ? $wp_rem_plugin_options['member_value'] : '';
                $member_type_array = array('' => wp_rem_plugin_text_srt('wp_rem_property_member_type'));
                $checked = '';
                $total_count = count($member_value);
                if ($total_count > 0 && !empty($member_value)) {
                    for ($a = 0; $a < $total_count; $a ++) {
                        if ($member_type == $member_value[$a]) {
                            $checked = ' selected="selected" ';
                        }
                        $member_type_array[$member_value[$a]] = $member_title[$a];
                    }
					?>
					<div id="property_type_cate_fields_<?php echo wp_rem_allow_special_char($member_short_counter); ?>" class="property-category-fields field-holder select-dropdown has-icon">
						<label>
							<i class="icon-user-tie-fancy"></i>
							<?php
							$wp_rem_opt_array = array(
								'std' => $member_type,
								'id' => 'member_type',
								'classes' => 'chosen-select-no-single',
								'cust_name' => 'member_type',
								'options' => $member_type_array,
								'extra_atr' => $checked
							);
							$wp_rem_form_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array);
							?>
						</label>
					</div>
				<?php } ?>
                <div class="field-holder search-input">
                    <?php
                    $wp_rem_select_display = 1;
                    wp_rem_get_custom_locations_property_filter('<div id="wp-rem-top-select-holder" class="search-country" style="display:' . wp_rem_allow_special_char($wp_rem_select_display) . '"><div class="select-holder">', '</div></div>', false, $member_short_counter);
                    ?>
                </div>
                <div class="field-holder search-btn">
                    <div class="search-btn-loader-<?php echo wp_rem_allow_special_char($member_short_counter); ?> input-button-loader">
						<?php
						$wp_rem_form_fields_frontend->wp_rem_form_text_render(
								array(
									'cust_name' => '',
									'classes' => 'bgcolor',
									'std' => wp_rem_plugin_text_srt('wp_rem_property_search').'',
									'cust_type' => "submit",
								)
						);
						?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>