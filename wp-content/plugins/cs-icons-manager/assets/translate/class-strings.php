<?php
/**
 * Static string Return
 */
global $cs_icons_managerstatic_text;

if ( ! function_exists('cs_icons_manager_text_srt') ) {

    function cs_icons_manager_text_srt($str = '') {
        global $cs_icons_managerstatic_text;
        if ( isset($cs_icons_managerstatic_text[$str]) ) {
            return $cs_icons_managerstatic_text[$str];
        }
        return '';
    }

}
if ( ! class_exists('cs_icons_manager_all_strings_1') ) {

    class cs_icons_manager_all_strings {

        public function __construct() {
            /*
             * Triggering function for strings.
             */
            add_action('init', array( $this, 'cs_icons_manager_strings' ), 0);
        }

        public function cs_icons_manager_strings() {
            global $cs_icons_managerstatic_text;

            $cs_icons_managerstatic_text['cs_icons_icons_manager'] = esc_html__('CS Icons Manager', 'cs-icons-manager');
            $cs_icons_managerstatic_text['cs_icons_manager_icon_library'] = esc_html__('Icons Library', 'cs-icons-manager');
            $cs_icons_managerstatic_text['cs_icons_manager_zip_error'] = esc_html__('Zip must contain the selection.json, SVG, and style.css files.', 'cs-icons-manager');
            $cs_icons_managerstatic_text['cs_icons_manager_removed_success'] = esc_html__('Group Successfully Removed', 'cs-icons-manager');
            $cs_icons_managerstatic_text['cs_icons_form_fields_browse'] = esc_html__('Browse', 'cs-icons-manager');
            $cs_icons_managerstatic_text['cs_icons_upload_new_icon'] = esc_html__('Upload New Icons', 'cs-icons-manager');
            $cs_icons_managerstatic_text['cs_icons_manager_status_success'] = esc_html__('Group Status Changed Successfully', 'cs-icons-manager');
            $cs_icons_managerstatic_text['cs_icons_already_exists'] = esc_html__('Group name already exists', 'cs-icons-manager');
            $cs_icons_managerstatic_text['cs_icons_delete'] = esc_html__('Delete', 'cs-icons-manager');
            $cs_icons_managerstatic_text['cs_icons_manager_not_zip_error'] = esc_html__('Only Zip Files are Supported', 'cs-icons-manager');
            $cs_icons_managerstatic_text['cs_icons_successfully_updated'] = esc_html__('Icons are uploaded Successfully', 'cs-icons-manager');
            $cs_icons_managerstatic_text['cs_icons_select_group'] = esc_html__('Select Group', 'cs-icons-manager');
            
            /*
             * Use this filter to add more strings from Add on.
             */
            $cs_icons_managerstatic_text = apply_filters('cs_icons_manager_text_strings', $cs_icons_managerstatic_text);
            return $cs_icons_managerstatic_text;
        }

    }

    new cs_icons_manager_all_strings;
}
