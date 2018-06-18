<?php

if (!function_exists('foodbakery_frame_option_save')) {

    function foodbakery_frame_option_save() {
		global $foodbakery_var_frame_static_text,$foodbakery_var_frame_options;
        if (isset($_REQUEST['foodbakery_frame_option_saving'])) {
            
            $_POST = foodbakery_var_stripslashes_htmlspecialchars($_POST);
            update_option("foodbakery_var_frame_options", $_POST);
            echo foodbakery_var_frame_text_srt('foodbakery_var_maintenance_save_message');
        }
        die();
    }

    add_action('wp_ajax_foodbakery_frame_option_save', 'foodbakery_frame_option_save');
}