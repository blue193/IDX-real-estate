<?php
/*
 *
 * @Shortcode Name :  faqs_fancy front end view
 * @retrun
 *
 */

if (!function_exists('wp_rsm_cs_var_faqs_fancy_shortcode')) {

    function wp_rsm_cs_var_faqs_fancy_shortcode($atts, $content = "") {
        global $post, $wp_rsm_cs_var_faqs_fancy_column, $wp_rsm_cs_var_faqs_fancy_parent_titles;
        global $faqs_fancy_content;
        $html = '';
        $page_element_size  = isset( $atts['faqs_fancy_element_size'] )? $atts['faqs_fancy_element_size'] : 100;
        if (function_exists('wp_rsm_cs_var_page_builder_element_sizes')) {
            $html   .= '<div class="' . wp_rsm_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }
        $faqs_fancy_content = '';
        $defaults = array(
            'wp_rsm_cs_var_faqs_fancy_title' => '',
            'wp_rsm_cs_var_faqs_fancy_subtitle' => '',
            'wp_rsm_cs_var_faqs_title' => '',
            'wp_rsm_var_fancy_faq_align' => '',
        );

        extract(shortcode_atts($defaults, $atts));
        $wp_rsm_cs_var_faqs_fancy_title = isset($wp_rsm_cs_var_faqs_fancy_title) ? $wp_rsm_cs_var_faqs_fancy_title : '';
        $wp_rsm_cs_var_faqs_fancy_parent_titles = isset($wp_rsm_cs_var_faqs_title) ? $wp_rsm_cs_var_faqs_title : '';

        $wp_rsm_cs_section_title = '';
        $wp_rsm_cs_section_sub_title = '';
        $exploded_titles = explode(",", $wp_rsm_cs_var_faqs_fancy_parent_titles);
        $html .= '<div class="wp_rsm_cs-faqs fancy">';


        $faqs_nav = '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 section-sidebar">
            <div class="widget widget-related-article">
         
                            <ul class="nav nav-list">';
        ?>
        <?php
        $counter = 1;
        $exploded_titles_width = count($exploded_titles) - 1;
        $width_percentage = 100 / $exploded_titles_width;
        foreach ($exploded_titles as $exploded_title) {
            if ($exploded_title != '') {
                ?>
                <?php $faqs_nav .='<li ><a class="fancyfaq" href="javascript:void(0)" data-toggle="faq"  data-common="' . esc_attr($exploded_title) . '" data-step="' . esc_attr($counter) . '"><strong>' . wp_rsm_cs_allow_special_char($exploded_title) . '</strong></a></li> ';
                ?>
                <?php
                $counter++;
            }
        }
        ?>
        <?php
        $faqs_nav .=' <div class="progress-data" data-totlasteps="'.($counter - 1).'"></div></ul>
                         </div></div>';
        $wp_rsm_cs_faq_title_str = '';
        $wp_rsm_cs_faq_title_str .= wp_rsm_title_sub_align($wp_rsm_cs_var_faqs_fancy_title, $wp_rsm_cs_var_faqs_fancy_subtitle, $wp_rsm_var_fancy_faq_align);
        
        $wp_rsm_cs_faqs_fancy_style = "vertical";
        $html .= $faqs_nav;
        $html .= do_shortcode($content);
        $html .= '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="faq-section"> '.wp_rsm_cs_allow_special_char($wp_rsm_cs_faq_title_str).' <div class="panel-group" id="fancy_faq">';
        $html .= wp_rsm_cs_allow_special_char($faqs_fancy_content);
        $html .= '</div></div></div></div></div>';
        $html .= '</div>';
        if (function_exists('wp_rsm_cs_var_page_builder_element_sizes')) {
           $html    .=  '</div>';
        }
        return do_shortcode($html);
    }

    if (function_exists('wp_rsm_cs_var_short_code')) {
        wp_rsm_cs_var_short_code('wp_rsm_cs_faqs_fancy', 'wp_rsm_cs_var_faqs_fancy_shortcode');
    }
}


/*
 *
 * @List  Item  shortcode/element front end view
 * @retrun
 *
 */

if (!function_exists('wp_rsm_cs_var_faqs_fancy_item_shortcode')) {

    function wp_rsm_cs_var_faqs_fancy_item_shortcode($atts, $content = "") {
        global $post, $wp_rsm_cs_var_faqs_fancy_column, $faqs_fancy_content, $wp_rsm_cs_var_faqs_fancy_parent_titles;
        $output = '';
        global $faqs_fancy_content;
        $defaults = array(
            'wp_rsm_cs_var_faqs_fancy_item_text' => '',
            'wp_rsm_cs_var_faqs_image_array' => '',
            'wp_rsm_cs_var_faqs_fancy_active' => '',
            'wp_rsm_cs_var_faqs_fancy_desc' => '',
        );
        extract(shortcode_atts($defaults, $atts));

        $wp_rsm_cs_var_faqs_fancy_column_str = '';
        if ($wp_rsm_cs_var_faqs_fancy_column != 12) {
            $wp_rsm_cs_var_faqs_fancy_column_str = 'class = "col-md-' . esc_html($wp_rsm_cs_var_faqs_fancy_column) . '"';
        }
        $wp_rsm_cs_var_faqs_fancy_item_text = isset($wp_rsm_cs_var_faqs_fancy_item_text) ? $wp_rsm_cs_var_faqs_fancy_item_text : '';
        $wp_rsm_cs_var_faqs_image_array = isset($wp_rsm_cs_var_faqs_image_array) ? $wp_rsm_cs_var_faqs_image_array : '';
        $wp_rsm_cs_var_faqs_fancy_desc = isset($wp_rsm_cs_var_faqs_fancy_desc) ? $wp_rsm_cs_var_faqs_fancy_desc : '';
        $wp_rsm_cs_var_faqs_fancy_active = isset($wp_rsm_cs_var_faqs_fancy_active) ? $wp_rsm_cs_var_faqs_fancy_active : '';
        ?>

        <?php
        $activeClass = "";
        if ($wp_rsm_cs_var_faqs_fancy_active == 'Yes') {
            $activeClass = 'active in';
        }


        $randid = rand(877, 9999);

        $new_str = preg_replace("/[^A-Z]+/", "", $wp_rsm_cs_var_faqs_fancy_item_text);

        $faqs_fancy_content .= '<div class="faq-pane panel" data-common="' . $wp_rsm_cs_var_faqs_fancy_active . '" id="step' . $wp_rsm_cs_var_faqs_fancy_active . '"><div class="panel-heading"> <a data-toggle="collapse" data-parent="#fancy_faq" class="collapsed" href="#' . $randid . '" aria-expanded="false"> ' . $wp_rsm_cs_var_faqs_fancy_item_text . ' </a> </div><div id="' . $randid . '" class="panel-collapse collapse"><div class="panel-body">
                          ' . do_shortcode($content) . '
                      </div>
                      </div></div>';
    return do_shortcode($output);
    }

    if (function_exists('wp_rsm_cs_var_short_code')) {
        wp_rsm_cs_var_short_code('wp_rsm_cs_faqs_fancy_item', 'wp_rsm_cs_var_faqs_fancy_item_shortcode');
    }
}