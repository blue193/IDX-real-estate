<?php

/**
 * File Type: Opening Hours Page Element
 */
if (!class_exists('wp_rem_opening_hours_element')) {

    class wp_rem_opening_hours_element {

	/**
	 * Start construct Functions
	 */
	public function __construct() {
	    add_action('wp_rem_opening_hours_element_html', array($this, 'wp_rem_opening_hours_element_html_callback'), 11, 1);
	    add_action('wp_rem_opening_hours_element_opened_html', array($this, 'wp_rem_opening_hours_element_opened_html_callback'), 11, 1);
	}

	/*
	 * Output features html for frontend on property detail page.
	 */

	public function wp_rem_opening_hours_element_html_callback($post_id) {
	    $property_type_slug = get_post_meta($post_id, 'wp_rem_property_type', true);
	    $property_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish'));
	    $property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
	    $wp_rem_full_data = get_post_meta($property_type_id, 'wp_rem_full_data', true);

	    $html = '';

	    $opening_hours_list = get_post_meta($post_id, 'wp_rem_opening_hour', true);
            
            if (isset($opening_hours_list) && !empty($opening_hours_list) && is_array($opening_hours_list)) {
                    $current_day = strtolower(date('l'));
                    $current_close = false;
                    $current_day_text = wp_rem_plugin_text_srt('wp_rem_opening_hours_open');
                    $closed_flag = false;
                    $current_time = date('H:i a');
                    $date1 = DateTime::createFromFormat('H:i a', $current_time);
                    $date2 = DateTime::createFromFormat('H:i a', $opening_hours_list[$current_day]['opening_time']);
                    $date3 = DateTime::createFromFormat('H:i a', $opening_hours_list[$current_day]['closing_time']);

                    if ($opening_hours_list[$current_day]['day_status'] != 'on') {
                        $current_close = true;
                        $current_day_text = wp_rem_plugin_text_srt('wp_rem_opening_hours_today_closed');
                        $closed_flag = true;
                    } else if ($date1 >= $date2 && $date1 <= $date3) {
                        $current_day_text = wp_rem_plugin_text_srt('wp_rem_opening_hours_today').' :';
                    } else {
                        $current_day_text = wp_rem_plugin_text_srt('wp_rem_opening_hours_today').' :';
                        $closed_flag = true;
                    }
                    ?>
                    <ul>
                        <li>
                            <a href="javascript:;" class="reviews-sortby-active active">
                                <i class = "icon-clock3"></i>
                                <span><?php echo esc_html($current_day_text); ?></span>
                                <?php if ($current_close != true) { ?>
                                    <?php wp_rem_plugin_text_srt( 'wp_rem_opening_hours_at_opens_at' ); ?> <?php echo date_i18n( 'g:i a', strtotime($opening_hours_list[$current_day]['opening_time'])); ?> - <?php echo date_i18n( 'g:i a', strtotime($opening_hours_list[$current_day]['closing_time'])); ?>
                                <?php } ?>
                            </a>
                            <ul class="delivery-dropdown" style="display: none;">
                                <?php
								$days_name = array(
									'monday' => wp_rem_plugin_text_srt('wp_rem_member_monday'),
									'tuesday' => wp_rem_plugin_text_srt('wp_rem_member_tuesday'),
									'wednesday' => wp_rem_plugin_text_srt('wp_rem_member_wednesday'),
									'thursday' => wp_rem_plugin_text_srt('wp_rem_member_thursday'),
									'friday' => wp_rem_plugin_text_srt('wp_rem_member_friday'),
									'saturday' => wp_rem_plugin_text_srt('wp_rem_member_saturday'),
									'sunday' => wp_rem_plugin_text_srt('wp_rem_member_sunday'),
								);
                                foreach ($opening_hours_list as $opening_hours_single_day_var => $opening_hours_single_day_val) {
									$opening_hours_single_day_var = isset($days_name[$opening_hours_single_day_var]) ? $days_name[$opening_hours_single_day_var] : $opening_hours_single_day_var;
                                    if ($opening_hours_single_day_val['day_status'] == 'on') {
                                        ?><li><a href="#"><span class="opend-day"><?php echo strtoupper(esc_html($opening_hours_single_day_var)) ?></span> <span class="opend-time"><small>:</small> <?php wp_rem_plugin_text_srt( 'wp_rem_opening_hours_opens_at' ); ?> <?php echo date_i18n( 'g:i a', strtotime($opening_hours_single_day_val['opening_time'])); ?> - <?php echo date_i18n( 'g:i a', strtotime($opening_hours_single_day_val['closing_time'])); ?></span></a></li><?php
                                    } else {
                                        ?>
                                        <li><a href="javascript:void(0)"><span class="opend-day"><?php echo strtoupper(esc_html($opening_hours_single_day_var)) ?></span> <span class="close-day"><small>:</small><?php echo wp_rem_plugin_text_srt( 'wp_rem_opening_hours_closed' ); ?></span></a></li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
                <?php }
            
	    echo force_balance_tags($html);
	}
	
	/*
	 * Output features html for frontend on member detail page.
	 */

	public function wp_rem_opening_hours_element_opened_html_callback($post_id) {
	    $property_type_slug = get_post_meta($post_id, 'wp_rem_property_type', true);
	    $property_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish'));
	    $property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
	    $wp_rem_full_data = get_post_meta($property_type_id, 'wp_rem_full_data', true);

	    $html = '';

	    $opening_hours_list = get_post_meta($post_id, 'wp_rem_opening_hour', true);
            
            if (isset($opening_hours_list) && !empty($opening_hours_list) && is_array($opening_hours_list)) {
                    $current_day = strtolower(date('l'));
                    $current_close = false;
                    $current_day_text = wp_rem_plugin_text_srt('wp_rem_opening_hours_open');
                    $closed_flag = false;
                    $current_time = date('H:i a');
                    $date1 = DateTime::createFromFormat('H:i a', $current_time);
                    $date2 = DateTime::createFromFormat('H:i a', $opening_hours_list[$current_day]['opening_time']);
                    $date3 = DateTime::createFromFormat('H:i a', $opening_hours_list[$current_day]['closing_time']);

                    if ($opening_hours_list[$current_day]['day_status'] != 'on') {
                        $current_close = true;
                        $current_day_text = wp_rem_plugin_text_srt('wp_rem_opening_hours_today_closed');
                        $closed_flag = true;
                    } else if ($date1 >= $date2 && $date1 <= $date3) {
                        $current_day_text = wp_rem_plugin_text_srt('wp_rem_opening_hours_today').' :';
                    } else {
                        $current_day_text = wp_rem_plugin_text_srt('wp_rem_opening_hours_today').' :';
                        $closed_flag = true;
                    }
                    ?>
					<div class="field-select-holder member-opening-hours">
					<h5><?php echo wp_rem_plugin_text_srt( 'wp_rem_opening_hours_opening_timings' ); ?></h5>
                    <ul>
                        <li>
                            <ul class="delivery-dropdown">
                                <?php
								$days_name = array(
									'monday' => wp_rem_plugin_text_srt('wp_rem_member_monday'),
									'tuesday' => wp_rem_plugin_text_srt('wp_rem_member_tuesday'),
									'wednesday' => wp_rem_plugin_text_srt('wp_rem_member_wednesday'),
									'thursday' => wp_rem_plugin_text_srt('wp_rem_member_thursday'),
									'friday' => wp_rem_plugin_text_srt('wp_rem_member_friday'),
									'saturday' => wp_rem_plugin_text_srt('wp_rem_member_saturday'),
									'sunday' => wp_rem_plugin_text_srt('wp_rem_member_sunday'),
								);
                                foreach ($opening_hours_list as $opening_hours_single_day_var => $opening_hours_single_day_val) {
									$opening_hours_single_day_var = isset($days_name[$opening_hours_single_day_var]) ? $days_name[$opening_hours_single_day_var] : $opening_hours_single_day_var;
                                    if ($opening_hours_single_day_val['day_status'] == 'on') {
                                        ?><li class="<?php echo (strtoupper(date('l', current_time('timestamp'))) == strtoupper($opening_hours_single_day_var) ? 'today': ''); ?>"><a href="#"><span class="opend-day"><?php echo strtoupper(esc_html($opening_hours_single_day_var)) ?></span> <span class="opend-time"><small>:</small> <?php wp_rem_plugin_text_srt( 'wp_rem_opening_hours_opens_at' ); ?> <?php echo date_i18n( 'g:i a', strtotime($opening_hours_single_day_val['opening_time'])); ?> - <?php echo date_i18n( 'g:i a', strtotime($opening_hours_single_day_val['closing_time'])); ?></span></a></li><?php
                                    } else {
                                        ?>
                                        <li class="<?php echo (strtoupper(date('l', current_time('timestamp'))) == strtoupper($opening_hours_single_day_var) ? 'today': ''); ?>"><a href="javascript:void(0)"><span class="opend-day"><?php echo strtoupper(esc_html($opening_hours_single_day_var)) ?></span> <span class="close-day"><small>:</small><?php echo wp_rem_plugin_text_srt( 'wp_rem_opening_hours_closed' ); ?></span></a></li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
					</div>
                <?php }
            
	    echo force_balance_tags($html);
	}

    }

    global $wp_rem_opening_hours_element;
    $wp_rem_opening_hours_element = new wp_rem_opening_hours_element();
}