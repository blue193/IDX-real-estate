<?php

/*
 *
 * @Shortcode Name :  tabs_fancy front end view
 * @retrun
 *
 */

if (!function_exists('wp_rsm_cs_var_tabs_fancy_shortcode')) {

    function wp_rsm_cs_var_tabs_fancy_shortcode($atts, $content = "") {
	global $post, $wp_rsm_cs_var_tabs_fancy_column, $wp_rsm_cs_var_tabs_fancy_parent_titles;
	global $tabs_fancy_content;
	$html = '';
	$page_element_size = isset($atts['tabs_fancy_element_size']) ? $atts['tabs_fancy_element_size'] : 100;
	if (function_exists('wp_rsm_cs_var_page_builder_element_sizes')) {
	    $html .= '<div class="' . wp_rsm_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
	}
	$rand_fancy_id = rand(377, 5555);
	$tabs_fancy_content = '';
	$defaults = array(
	    'wp_rsm_cs_var_tabs_fancy_title' => '',
            'wp_rsm_cs_var_tabs_fancy_subtitle' => '',
            'wp_rsm_cs_var_tabs_fancy_title_align' => '',
	    'wp_rsm_cs_var_tabs_title' => '',
	);

	extract(shortcode_atts($defaults, $atts));
	$wp_rsm_cs_var_tabs_fancy_title = isset($wp_rsm_cs_var_tabs_fancy_title) ? $wp_rsm_cs_var_tabs_fancy_title : '';
	$wp_rsm_cs_var_tabs_fancy_parent_titles = isset($wp_rsm_cs_var_tabs_title) ? $wp_rsm_cs_var_tabs_title : '';

	$wp_rsm_cs_section_title = '';
	$wp_rsm_cs_section_sub_title = '';
	$exploded_titles = explode(",", $wp_rsm_cs_var_tabs_fancy_parent_titles);
        $element_title_structure = '';
        $element_title_structure =  wp_rsm_title_sub_align($wp_rsm_cs_var_tabs_fancy_title, $wp_rsm_cs_var_tabs_fancy_subtitle, $wp_rsm_cs_var_tabs_fancy_title_align);
        
	$html .= '<div class="wp_rsm_cs-tabs fancy">
              <div class="container">
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div id="fancy-tabs' . esc_html($rand_fancy_id) . '" class="wp_rsm_cs-holder">' . wp_rsm_cs_allow_special_char($element_title_structure);
	$tabs_nav = '<div class="wp_rsm_cs-nav navbar">
            <div class="progress">
                           <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="4" style="width: 0%;">
                           </div>
                         </div>
                            <ul class="nav nav-list">';
	?>
	<?php

	$counter = 1;
	$exploded_titles_width = count($exploded_titles) - 1;
	if ($exploded_titles_width > 0) {
	    $width_percentage = 100 / $exploded_titles_width;
	}
	foreach ($exploded_titles as $exploded_title) {
	    if ($exploded_title != '') {

		$exploded_titlee = str_replace(" ", "-", $exploded_title);
		$randid = rand(877, 9999);
		$tabs_nav .='<li class="" style="width:' . esc_html($width_percentage) . '%">';
		
		$tabs_nav .= '<a id="link-' . wp_rsm_cs_allow_special_char($exploded_titlee) . wp_rsm_cs_allow_special_char($randid) . '" class="fancytab" href="#step' . wp_rsm_cs_allow_special_char($exploded_titlee) . wp_rsm_cs_allow_special_char($randid) . '" data-toggle="tab" data-common="' . wp_rsm_cs_allow_special_char($exploded_titlee) . wp_rsm_cs_allow_special_char($randid) . '" data-step="' . esc_attr($counter) . '"><span>' . wp_rsm_cs_allow_special_char($counter) . ' </span><strong>' . wp_rsm_cs_allow_special_char($exploded_title) . '</strong></a>';


		$tabs_nav .= '<script>'
			. 'jQuery(document).ready(function () {'
			. 'if (!(jQuery("#link-' . wp_rsm_cs_allow_special_char($exploded_titlee) . wp_rsm_cs_allow_special_char($randid) . '").length !="")) {'
			. ''
			. 'jQuery("#link-' . wp_rsm_cs_allow_special_char($exploded_titlee) . wp_rsm_cs_allow_special_char($randid) . '").parent("li").addClass("disabled");'
			
			. '}'
			. ''
			. '});'
			. '</script> ';
		$tabs_nav .= '</li> ';
		?>
		<?php

		$counter ++;
	    }
	}
	?>

	<?php

	$tabs_nav .=' <li class="progress-data" data-totlasteps="' . ($counter - 1) . '"></li></ul>
                         </div>';

	$wp_rsm_cs_tabs_fancy_style = "vertical";
	
	$html .= wp_rsm_cs_allow_special_char($tabs_nav);
	$html .= do_shortcode($content);
	$html .= '<div class="tab-content">';
	$html .= wp_rsm_cs_allow_special_char($tabs_fancy_content);
	$html .= '</div>';
	$html .= '</div></div></div></div></div>';
	if (function_exists('wp_rsm_cs_var_page_builder_element_sizes')) {
	    $html .= '</div>';
	}

	return do_shortcode($html);
    }

    if (function_exists('wp_rsm_cs_var_short_code')) {
	wp_rsm_cs_var_short_code('wp_rsm_cs_tabs_fancy', 'wp_rsm_cs_var_tabs_fancy_shortcode');
    }
}


/*
 *
 * @List  Item  shortcode/element front end view
 * @retrun
 *
 */

if (!function_exists('wp_rsm_cs_var_tabs_fancy_item_shortcode')) {

    function wp_rsm_cs_var_tabs_fancy_item_shortcode($atts, $content = "") {
	global $post, $wp_rsm_cs_var_tabs_fancy_column, $tabs_fancy_content, $wp_rsm_cs_var_tabs_fancy_parent_titles;
	$output = '';
	global $tabs_fancy_content;
	$defaults = array(
	    'wp_rsm_cs_var_tabs_fancy_item_text' => '',
	    'wp_rsm_cs_var_tabs_image_array' => '',
	    'wp_rsm_cs_var_tabs_fancy_active' => '',
	    'wp_rsm_cs_var_tabs_fancy_desc' => '',
	);
	extract(shortcode_atts($defaults, $atts));

	$wp_rsm_cs_var_tabs_fancy_column_str = '';
	if ($wp_rsm_cs_var_tabs_fancy_column != 12) {
	    $wp_rsm_cs_var_tabs_fancy_column_str = 'class = "col-md-' . esc_html($wp_rsm_cs_var_tabs_fancy_column) . '"';
	}
	$wp_rsm_cs_var_tabs_fancy_item_text = isset($wp_rsm_cs_var_tabs_fancy_item_text) ? $wp_rsm_cs_var_tabs_fancy_item_text : '';
	$wp_rsm_cs_var_tabs_image_array = isset($wp_rsm_cs_var_tabs_image_array) ? $wp_rsm_cs_var_tabs_image_array : '';
	$wp_rsm_cs_var_tabs_fancy_desc = isset($wp_rsm_cs_var_tabs_fancy_desc) ? $wp_rsm_cs_var_tabs_fancy_desc : '';
	$wp_rsm_cs_var_tabs_fancy_active = isset($wp_rsm_cs_var_tabs_fancy_active) ? $wp_rsm_cs_var_tabs_fancy_active : '';

	$activeClass = "";
	if ($wp_rsm_cs_var_tabs_fancy_active == 'Yes') {
	    $activeClass = 'active in';
	}

	$wp_rsm_cs_var_tabs_fancy_activee = str_replace(" ", "-", $wp_rsm_cs_var_tabs_fancy_active);

	$randid = rand(877, 9999);

	$tabs_fancy_content_inner = '  <div class="wp_rsm_cs-tab-content">';
	if (isset($wp_rsm_cs_var_tabs_image_array) && !empty($wp_rsm_cs_var_tabs_image_array)) {
	    $tabs_fancy_content_inner .= '<div class="img-holder">
					 <figure><img src="' . $wp_rsm_cs_var_tabs_image_array . '" alt="" /></figure>
				    </div>';
	}
	$tabs_fancy_content_inner .='
 <div class="text-holder">
  <strong class="heading">' . $wp_rsm_cs_var_tabs_fancy_item_text . '</strong>
  <span class="description">' . do_shortcode($content) . '</span>
 </div>
</div><a class="next" href="#"></a></div>';

	$tabs_fancy_content .= '<div class="tab-pane" data-common="' . $wp_rsm_cs_var_tabs_fancy_activee . '" id="step' . $wp_rsm_cs_var_tabs_fancy_activee . '">';

	$tabs_fancy_content .= $tabs_fancy_content_inner;


	return do_shortcode($output);
    }

    if (function_exists('wp_rsm_cs_var_short_code')) {
	wp_rsm_cs_var_short_code('wp_rsm_cs_tabs_fancy_item', 'wp_rsm_cs_var_tabs_fancy_item_shortcode');
    }
}