<?php
/**
 * @Spacer html form for page builder
 */
if (!function_exists('wp_rem_cs_var_page_builder_spacer')) {

    function wp_rem_cs_var_page_builder_spacer($die = 0) {
	global $wp_rem_cs_node, $count_node, $post, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;
	$shortcode_element = '';
	$filter_element = 'filterdrag';
	$shortcode_view = '';
	$output = array();
	$wp_rem_cs_counter = $_POST['counter'];
	if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
	    $POSTID = '';
	    $shortcode_element_id = '';
	} else {
	    $POSTID = $_POST['POSTID'];
	    $shortcode_element_id = $_POST['shortcode_element_id'];
	    $shortcode_str = stripslashes($shortcode_element_id);
	    $PREFIX = 'spacer';
	    $parseObject = new ShortcodeParse();
	    $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
	}
	$defaults = array(
	    'wp_rem_cs_var_spacer_height' => '25'
	);
	if (isset($output['0']['atts'])) {
	    $atts = $output['0']['atts'];
	} else {
	    $atts = array();
	}
	$spacer_element_size = '25';
	foreach ($defaults as $key => $values) {
	    if (isset($atts[$key])) {
		$$key = $atts[$key];
	    } else {
		$$key = $values;
	    }
	}
	$name = 'wp_rem_cs_var_page_builder_spacer';
	$coloumn_class = 'column_' . $spacer_element_size;
	$wp_rem_cs_var_spacer_height = isset($wp_rem_cs_var_spacer_height) ? $wp_rem_cs_var_spacer_height : '';
	if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
	    $shortcode_element = 'shortcode_element_class';
	    $shortcode_view = 'cs-pbwp-shortcode';
	    $filter_element = 'ajax-drag';
	    $coloumn_class = '';
	}
	$strings = new wp_rem_cs_theme_all_strings;
	$strings->wp_rem_cs_short_code_strings();
	?>
	<div id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?>
	     <?php echo esc_attr($shortcode_view); ?>" item="spacer" data="<?php echo wp_rem_cs_element_size_data_array_index($spacer_element_size) ?>" >
		 <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $spacer_element_size) ?>
	    <div class="cs-wrapp-class-<?php echo esc_attr($wp_rem_cs_counter); ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[spacer {{attributes}}]{{content}}[/spacer]" style="display: none;"">
		<div class="cs-heading-area">
		    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_edit_spacer_options')); ?></h5>
		    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_js($name . $wp_rem_cs_counter) ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a> </div>
		<div class="cs-pbwp-content">
		    <div class="cs-wrapp-clone cs-shortcode-wrapp">
			<?php
			$wp_rem_cs_opt_array = array(
			    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_spacer_height'),
			    'desc' => '',
			    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_spacer_height_hint'),
			    'echo' => true,
			    'field_params' => array(
				'std' => esc_html($wp_rem_cs_var_spacer_height),
				'id' => 'spacer_height',
				'cust_name' => 'wp_rem_cs_var_spacer_height[]',
				'return' => true,
				'cs-range-input' => 'cs-range-input',
			    ),
			);
			$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
			?>
		    </div>
		    <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
	    	    <ul class="form-elements insert-bg">
	    		<li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo esc_js(str_replace('wp_rem_cs_var_page_builder_', '', $name)); ?>', '<?php echo esc_js($name . $wp_rem_cs_counter); ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a> </li>
	    	    </ul>
	    	    <div id="results-shortocde"></div>
			<?php
		    } else {
			$wp_rem_cs_opt_array = array(
			    'std' => 'spacer',
			    'id' => '',
			    'before' => '',
			    'after' => '',
			    'classes' => '',
			    'extra_atr' => '',
			    'cust_id' => '',
			    'cust_name' => 'wp_rem_cs_orderby[]',
			    'return' => false,
			    'required' => false
			);
			$wp_rem_cs_var_html_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
			$wp_rem_cs_opt_array = array(
			    'name' => '',
			    'desc' => '',
			    'hint_text' => '',
			    'echo' => true,
			    'field_params' => array(
				'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_save'),
				'cust_id' => '',
				'cust_type' => 'button',
				'classes' => 'cs-wp_rem_cs-admin-btn',
				'cust_name' => '',
				'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
				'return' => true,
			    ),
			);
			$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
		    }
		    ?>
		</div>
	    </div>
	</div>
	
	<?php
	if ($die <> 1) {
	    die();
	}
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_spacer', 'wp_rem_cs_var_page_builder_spacer');
}

if (!function_exists('wp_rem_cs_save_page_builder_data_spacer_callback')) {

    /**
     * Save data for spacer shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_spacer_callback($args) {

	$data = $args['data'];
	$counters = $args['counters'];
	$widget_type = $args['widget_type'];
	$column = $args['column'];
	$shortcode_data = '';
	if ($widget_type == "spacer" || $widget_type == "cs_spacer") {
	    $shortcode = '';
            $page_element_size  =  $data['spacer_element_size'][$counters['wp_rem_cs_global_counter_spacer']];
            $current_element_size  =  $data['spacer_element_size'][$counters['wp_rem_cs_global_counter_spacer']];
                        
	    if (isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
		$shortcode_str = stripslashes(( $data['shortcode']['spacer'][$counters['wp_rem_cs_shortcode_counter_spacer']]));
                $element_settings   = 'spacer_element_size="'.$current_element_size.'"';
                $reg = '/spacer_element_size="(\d+)"/s';
                $shortcode_str  = preg_replace( $reg, $element_settings, $shortcode_str );
                $shortcode_data = $shortcode_str;
		$counters['wp_rem_cs_shortcode_counter_spacer'] ++;
	    } else {
                $shortcode = '[spacer spacer_element_size="'.htmlspecialchars( $data['spacer_element_size'][$counters['wp_rem_cs_global_counter_spacer']] ).'" ';
		if (isset($data['wp_rem_cs_var_spacer_height'][$counters['wp_rem_cs_counter_spacer']]) && $data['wp_rem_cs_var_spacer_height'][$counters['wp_rem_cs_counter_spacer']] != '') {
		    $shortcode .= 'wp_rem_cs_var_spacer_height="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_spacer_height'][$counters['wp_rem_cs_counter_spacer']]), ENT_QUOTES)) . '" ';
		}
		$shortcode .= ']';
		$shortcode .= '[/spacer]';
		$shortcode_data .= $shortcode;
		$counters['wp_rem_cs_counter_spacer'] ++;
	    }
	    $counters['wp_rem_cs_global_counter_spacer'] ++;
	}
	return array(
	    'data' => $data,
	    'counters' => $counters,
	    'widget_type' => $widget_type,
	    'column' => $shortcode_data,
	);
    }

    add_filter('wp_rem_cs_save_page_builder_data_spacer', 'wp_rem_cs_save_page_builder_data_spacer_callback');
}

if (!function_exists('wp_rem_cs_load_shortcode_counters_spacer_callback')) {

    /**
     * Populate spacer shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_spacer_callback($counters) {
	$counters['wp_rem_cs_counter_spacer'] = 0;
	$counters['wp_rem_cs_shortcode_counter_spacer'] = 0;
	$counters['wp_rem_cs_global_counter_spacer'] = 0;
	return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_spacer_callback');
}
if (!function_exists('wp_rem_cs_shortcode_names_list_populate_spacer_callback')) {

    /**
     * Populate spacer shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_spacer_callback($shortcode_array) {
	$shortcode_array['spacer'] = array(
	    'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_spacer'),
	    'name' => 'spacer',
	    'icon' => 'icon-ellipsis-h',
	    'categories' => 'contentblocks',
	);
	return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_spacer_callback');
}

if (!function_exists('wp_rem_cs_element_list_populate_spacer_callback')) {

    /**
     * Populate spacer shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_spacer_callback($element_list) {
	$element_list['spacer'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_spacer');
	return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_spacer_callback');
}