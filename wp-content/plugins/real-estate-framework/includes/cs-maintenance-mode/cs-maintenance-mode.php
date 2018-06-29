<?php

add_action('admin_menu', 'foodbakery_maintenance_mode_menu');
if (!function_exists('foodbakery_maintenance_mode_menu')) {

    function foodbakery_maintenance_mode_menu() {
        add_theme_page("Maintenance Mode", foodbakery_var_frame_text_srt('foodbakery_var_maintenance_field_name'), 'read', 'foodbakery_maintenance_mode', 'foodbakery_maintenance_mode');
    }

}

if (!function_exists('foodbakery_maintenance_mode')) {

    function foodbakery_maintenance_mode() {
        global $foodbakery_frame_settings, $foodbakery_var_frame_options, $foodbakery_var_form_fields,$foodbakery_var_frame_static_text;
        
        $foodbakery_html = '';
        $foodbakery_html .= '
        <div class="theme-wrap fullwidth">
        <div class="inner">
        <div class="outerwrapp-layer">
            <div class="loading_div"> 
                <i class="icon-circle-o-notch icon-spin"></i> <br>
                ' . foodbakery_var_frame_text_srt('foodbakery_var_saving_changes') . '
            </div>
            <div class="form-msg"> 
                <i class="icon-check-circle-o"></i>
                <div class="innermsg"></div>
            </div>
        </div>
        <div class="row">
        <form id="frm" method="post">
        <div class="col2">';
        $foodbakery_frame_fields = new foodbakery_maintenance_fields();
        $return_fields = $foodbakery_frame_fields->foodbakery_fields($foodbakery_frame_settings);
        $foodbakery_html .= $return_fields;
        $foodbakery_html .= '
        </div>
        <div class="footer">';
        $foodbakery_opt_array = array(
            'std' => foodbakery_var_frame_text_srt('foodbakery_var_maintenance_save_settings'),
            'cust_id' => 'submit_btn',
            'cust_name' => 'submit_btn',
            'cust_type' => 'button',
            'extra_atr' => 'onclick="javascript:foodbakery_frame_option_save(\'' . esc_js(admin_url('admin-ajax.php')) . '\');"',
            'classes' => 'bottom_btn_save',
            'return' => true,
        );
        $foodbakery_html .= $foodbakery_var_form_fields->foodbakery_var_form_text_render($foodbakery_opt_array);
        $foodbakery_opt_array = array(
            'std' => 'foodbakery_frame_option_save',
            'cust_id' => 'action',
            'cust_name' => 'action',
            'classes' => '',
            'return' => true,
        );
        $foodbakery_html .= $foodbakery_var_form_fields->foodbakery_var_form_hidden_render($foodbakery_opt_array);
        $foodbakery_opt_array = array(
            'std' => '1',
            'cust_id' => 'foodbakery_frame_option_saving',
            'cust_name' => 'foodbakery_frame_option_saving',
            'classes' => '',
            'return' => true,
        );
        $foodbakery_html .= $foodbakery_var_form_fields->foodbakery_var_form_hidden_render($foodbakery_opt_array);
        $foodbakery_html .= '
        </div>
        </form>
        </div>
        </div>
        </div>';

        echo force_balance_tags($foodbakery_html);
    }

}

if (!function_exists('foodbakery_maintenance_options_array')) {
    add_action('init', 'foodbakery_maintenance_options_array');

    function foodbakery_maintenance_options_array() {
        global $foodbakery_frame_settings, $foodbakery_var_frame_options,$foodbakery_var_frame_static_text;

        $on_off_option = array(
            "show" => "on",
            "hide" => "off",
        );
        
        $foodbakery_frame_settings[] = array("name" => foodbakery_var_frame_text_srt('foodbakery_var_maintenance_field_name'),
            "std" => foodbakery_var_frame_text_srt('foodbakery_var_maintenance_field_name'),
            "type" => "section"
        );
        $foodbakery_frame_settings[] = array("name" => foodbakery_var_frame_text_srt('foodbakery_var_maintenance_field_name'),
            "desc" => "",
            "hint_text" => foodbakery_var_frame_text_srt('foodbakery_var_maintenance_field_mode_hint'),
            "id" => "coming_soon_switch",
            "std" => "off",
            "type" => "checkbox",
            "options" => $on_off_option
        );

        $foodbakery_frame_settings[] = array("name" => foodbakery_var_frame_text_srt('foodbakery_var_maintenance_field_logo'),
            "desc" => "",
            "hint_text" => foodbakery_var_frame_text_srt('foodbakery_var_maintenance_field_logo_hint'),
            "id" => "coming_logo_switch",
            "std" => "off",
            "type" => "checkbox",
            "options" => $on_off_option
        );
        $foodbakery_frame_settings[] = array("name" => foodbakery_var_frame_text_srt('foodbakery_var_maintenance_field_social'),
            "desc" => "",
            "hint_text" => foodbakery_var_frame_text_srt('foodbakery_var_maintenance_field_social_hint'),
            "id" => "coming_social_switch",
            "std" => "off",
            "type" => "checkbox",
            "options" => $on_off_option
        );

        $foodbakery_frame_settings[] = array("name" => foodbakery_var_frame_text_srt('foodbakery_var_maintenance_field_newsletter'),
            "desc" => "",
            "hint_text" => foodbakery_var_frame_text_srt('foodbakery_var_maintenance_field_newsletter_hint'),
            "id" => "coming_newsletter_switch",
            "std" => "off",
            "type" => "checkbox",
            "options" => $on_off_option
        );


        $foodbakery_frame_settings[] = array("name" => foodbakery_var_frame_text_srt('foodbakery_var_maintenance_field_header'),
            "desc" => "",
            "hint_text" => foodbakery_var_frame_text_srt('foodbakery_var_maintenance_field_header_hint'),
            "id" => "header_switch",
            "std" => "off",
            "type" => "checkbox",
            "options" => $on_off_option
        );

        $foodbakery_frame_settings[] = array("name" => foodbakery_var_frame_text_srt('foodbakery_var_maintenance_field_footer'),
            "desc" => "",
            "hint_text" => foodbakery_var_frame_text_srt('foodbakery_var_maintenance_field_footer_hint'),
            "id" => "footer_setting",
            "std" => "off",
            "type" => "checkbox",
            "options" => $on_off_option
        );
        $args = array(
            'sort_order' => 'asc',
            'sort_column' => 'post_title',
            'hierarchical' => 1,
            'exclude' => '',
            'include' => '',
            'meta_key' => '',
            'meta_value' => '',
            'authors' => '',
            'child_of' => 0,
            'parent' => -1,
            'exclude_tree' => '',
            'number' => '',
            'offset' => 0,
            'post_type' => 'page',
            'post_status' => 'publish'
        );

        $foodbakery_var_pages = get_pages($args);

        $foodbakery_var_options_array = array();
        $foodbakery_var_options_array[] = foodbakery_var_frame_text_srt('foodbakery_var_maintenance_field_select_page');
        foreach ($foodbakery_var_pages as $foodbakery_var_page) {

            $foodbakery_var_options_array[$foodbakery_var_page->ID] = isset($foodbakery_var_page->post_title) && ($foodbakery_var_page->post_title != '') ? $foodbakery_var_page->post_title : foodbakery_var_frame_text_srt('foodbakery_var_no_title');
        }


        $foodbakery_frame_settings[] = array("name" => foodbakery_var_frame_text_srt('foodbakery_var_maintenance_field_mode_page'),
            "desc" => "",
            "hint_text" => foodbakery_var_frame_text_srt('foodbakery_var_maintenance_field_mode_page_hint'),
            "id" => "maintinance_mode_page",
            "std" => foodbakery_var_frame_text_srt('foodbakery_var_maintenance_select_page'),
            "type" => "select",
            'classes' => 'chosen-select',
            "options" => $foodbakery_var_options_array
        );
    }

}