<?php

/**
 * Static string Return
 */
global $wp_rem_static_text;

if ( ! function_exists('wp_rem_plugin_text_srt') ) {

    function wp_rem_plugin_text_srt($str = '') {
        global $wp_rem_static_text;
        if ( isset($wp_rem_static_text[$str]) ) {
            return $wp_rem_static_text[$str];
        }
        return '';
    }

}
if ( ! class_exists('wp_rem_plugin_all_strings_1') ) {

    class wp_rem_plugin_all_strings_1 {

        public function __construct() {
            /*
             * Triggering function for strings.
             */
            add_action('init', array( $this, 'wp_rem_plugin_strings' ), 0);
        }

        public function wp_rem_plugin_strings() {
            global $wp_rem_static_text;

            $wp_rem_static_text['wp_rem_create_property_back'] = esc_html__('Back', 'wp-rem');
            $wp_rem_static_text['wp_rem_create_property_back_to'] = esc_html__('Back to %s', 'wp-rem');
            /*
             * Properties Post Type Strings
             */
            $wp_rem_static_text['id_number'] = esc_html__('ID Number', 'wp-rem');
            $wp_rem_static_text['transaction_id'] = esc_html__('Transaction Id', 'wp-rem');
            $wp_rem_static_text['property_contact_email'] = esc_html__('Email', 'wp-rem');
            $wp_rem_static_text['property_contact_phone'] = esc_html__('Phone Number', 'wp-rem');
            $wp_rem_static_text['property_contact_web'] = esc_html__('Web', 'wp-rem');
            $wp_rem_static_text['property_contact_heading'] = esc_html__('Contact Information', 'wp-rem');
			$wp_rem_static_text['wp_rem_deals'] = esc_html__('Deals', 'wp-rem');

            $wp_rem_static_text['wp_rem_save_settings'] = esc_html__('Save All Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_reset_options'] = esc_html__('Reset All Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_please_wait'] = esc_html__('Please Wait...', 'wp-rem');
            $wp_rem_static_text['wp_rem_general_options'] = esc_html__('General Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_page_settings'] = esc_html__('Page Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_default_location'] = esc_html__('Default Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_others'] = esc_html__('Others', 'wp-rem');
            $wp_rem_static_text['wp_rem_smtp_settings'] = esc_html__('SMTP Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_gateways'] = esc_html__('Gateways', 'wp-rem');
            $wp_rem_static_text['wp_rem_packages'] = esc_html__('Packages', 'wp-rem');
            $wp_rem_static_text['wp_rem_featured_properties'] = esc_html__('Featured Properties', 'wp-rem');
            $wp_rem_static_text['wp_rem_custom_fields'] = esc_html__('Custom Fields', 'wp-rem');
            $wp_rem_static_text['wp_rem_properties_fields'] = esc_html__('Properties Fields', 'wp-rem');
            $wp_rem_static_text['wp_rem_recruiters'] = esc_html__('Recruiters', 'wp-rem');
            $wp_rem_static_text['wp_rem_api_settings'] = esc_html__('Api Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_search_options'] = esc_html__('Search Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_social_icon'] = esc_html__('Social Icon', 'wp-rem');
            $wp_rem_static_text['wp_rem_user_settings'] = esc_html__('User Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_user_header_login'] = esc_html__('User Header Login', 'wp-rem');
            $wp_rem_static_text['wp_rem_user_header_login_hint'] = esc_html__('Dashboard and Front-End login/register option can be hide by turning off this switch.', 'wp-rem');
            $wp_rem_static_text['wp_rem_menu_location'] = esc_html__('Menu Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_menu_location_hint'] = esc_html__('Show login section in Menu', 'wp-rem');
            $wp_rem_static_text['wp_rem_general_info'] = esc_html__('General Info', 'wp-rem');
            $wp_rem_static_text['wp_rem_package_info'] = esc_html__('Package Info', 'wp-rem');

// Property Enquiries Strings
            $wp_rem_static_text['wp_rem_property_enquiries'] = esc_html__('Enquiries', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_enquiries_name'] = esc_html__('Enquiries', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_enquiries_singular_name'] = esc_html__('Enquiry', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_enquiries_menu_name'] = esc_html__('Enquiries', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_enquiries_name_admin_bar'] = esc_html__('Enquiries', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_enquiries_add_new'] = esc_html__('Add Enquiry', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_enquiries_add_new_item'] = esc_html__('Add Enquiry', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_enquiries_new_item'] = esc_html__('Add Enquiry', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_enquiries_edit_item'] = esc_html__('Edit Enquiry', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_enquiries_view_item'] = esc_html__('Enquiry', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_enquiries_all_items'] = esc_html__('Enquiries', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_enquiries_search_items'] = esc_html__('Enquiry', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_enquiries_not_found'] = esc_html__('Enquiries', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_enquiries_not_found_in_trash'] = esc_html__('Enquiries', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_enquiries_description'] = esc_html__('Edit Enquiry', 'wp-rem');

// Arrange Viewings Strings
            $wp_rem_static_text['wp_rem_arrange_viewings'] = esc_html__('Viewings', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_name'] = esc_html__('Viewings', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_singular_name'] = esc_html__('Viewing', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_menu_name'] = esc_html__('Viewings', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_name_admin_bar'] = esc_html__('Viewings', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_add_new'] = esc_html__('Add Viewing', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_add_new_item'] = esc_html__('Add Viewing', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_new_item'] = esc_html__('Add Viewing', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_edit_item'] = esc_html__('Edit Viewing', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_view_item'] = esc_html__('Viewing', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_all_items'] = esc_html__('Viewings', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_search_items'] = esc_html__('Viewing', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_not_found'] = esc_html__('Viewings', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_not_found_in_trash'] = esc_html__('Viewings', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_description'] = esc_html__('Edit Viewing', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_column_id'] = esc_html__('Viewing ID', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_column_date'] = esc_html__('Date', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_column_property_member'] = esc_html__('Property Owner', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_column_property'] = esc_html__('Property Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_column_viewing_member'] = esc_html__('Viewing Member', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_column_status'] = esc_html__('Status', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_total'] = esc_html__('Total Viewings', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_completed'] = esc_html__('Completed Viewings', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_processing'] = esc_html__('Processing Viewings', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_closed'] = esc_html__('Closed Viewings', 'wp-rem');
// Property Types
            $wp_rem_static_text['wp_rem_property_types'] = esc_html__('Property Types', 'wp-rem');
            $wp_rem_static_text['wp_rem_category_description'] = esc_html__('Category Description', 'wp-rem');
            $wp_rem_static_text['wp_rem_add_property_type'] = esc_html__('Add Property Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_edit_property_type'] = esc_html__('Edit Property Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_submit'] = esc_html__('Submit', 'wp-rem');
            $wp_rem_static_text['wp_rem_preview'] = esc_html__('Preview', 'wp-rem');
            $wp_rem_static_text['wp_rem_delete_permanently'] = esc_html__('Delete permanently', 'wp-rem');
            $wp_rem_static_text['wp_rem_move_to_trash'] = esc_html__('Move to trash', 'wp-rem');
            $wp_rem_static_text['wp_rem_publish'] = esc_html__('Publish', 'wp-rem');
            $wp_rem_static_text['wp_rem_submit_for_review'] = esc_html__('Submit for review', 'wp-rem');
            $wp_rem_static_text['wp_rem_update'] = esc_html__('Update', 'wp-rem');
            $wp_rem_static_text['wp_rem_add_category'] = esc_html__('Add Category', 'wp-rem');
            $wp_rem_static_text['wp_rem_name'] = esc_html__('Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_actions'] = esc_html__('Actions', 'wp-rem');
            $wp_rem_static_text['wp_rem_update_category'] = esc_html__('Update Category', 'wp-rem');
            $wp_rem_static_text['wp_rem_click_to_add_item'] = esc_html__('Click to Add Item', 'wp-rem');
            $wp_rem_static_text['wp_rem_text'] = esc_html__('TEXT', 'wp-rem');
            $wp_rem_static_text['wp_rem_services'] = esc_html__('Services', 'wp-rem');
            $wp_rem_static_text['wp_rem_availability'] = esc_html__('Availability', 'wp-rem');
            $wp_rem_static_text['wp_rem_availability_string'] = esc_html__('Availability: %s', 'wp-rem');
            $wp_rem_static_text['wp_rem_number'] = esc_html__('NUMBER', 'wp-rem');
            $wp_rem_static_text['wp_rem_textarea'] = esc_html__('TEXTAREA', 'wp-rem');
            $wp_rem_static_text['wp_rem_dropdown'] = esc_html__('DROPDOWN', 'wp-rem');
            $wp_rem_static_text['wp_rem_date'] = esc_html__('DATE', 'wp-rem');
            $wp_rem_static_text['wp_rem_email'] = esc_html__('EMAIL', 'wp-rem');
            $wp_rem_static_text['wp_rem_url'] = esc_html__('URL', 'wp-rem');
            $wp_rem_static_text['wp_rem_url_string'] = esc_html__('URL: %s', 'wp-rem');
            $wp_rem_static_text['wp_rem_range'] = esc_html__('RANGE', 'wp-rem');
            $wp_rem_static_text['wp_rem_quantity'] = esc_html__('Quantity', 'wp-rem');
            $wp_rem_static_text['wp_rem_net'] = esc_html__('Net', 'wp-rem');
            $wp_rem_static_text['wp_rem_section'] = esc_html__('SECTION', 'wp-rem');
            $wp_rem_static_text['wp_rem_time'] = esc_html__('Time', 'wp-rem');
            $wp_rem_static_text['wp_rem_form_title'] = esc_html__('Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_reservation_form_title'] = esc_html__('Form Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_paid_inquiry_form'] = esc_html__('Reservation Paid', 'wp-rem');
            $wp_rem_static_text['wp_rem_form_button_label'] = esc_html__('Form Button Label', 'wp-rem');
            $wp_rem_static_text['wp_rem_form_terms_label'] = esc_html__('Form Terms Label', 'wp-rem');
            $wp_rem_static_text['wp_rem_form_terms_link'] = esc_html__('Form Terms Link', 'wp-rem');
            $wp_rem_static_text['wp_rem_time_small'] = esc_html__('Time', 'wp-rem');
            $wp_rem_static_text['wp_rem_time_string'] = esc_html__('Time: %s', 'wp-rem');
            $wp_rem_static_text['wp_rem_file_upload'] = esc_html__('File Upload', 'wp-rem');
            $wp_rem_static_text['wp_rem_file'] = esc_html__('File', 'wp-rem');
            $wp_rem_static_text['wp_rem_file_hint'] = esc_html__('Upload Image / File here.', 'wp-rem');
            $wp_rem_static_text['wp_rem_file_upload_string'] = esc_html__('File Upload: %s', 'wp-rem');
            $wp_rem_static_text['wp_rem_please_insert_item'] = esc_html__('Please Insert Item', 'wp-rem');
            $wp_rem_static_text['wp_rem_section_small'] = esc_html__('Section', 'wp-rem');
            $wp_rem_static_text['wp_rem_section_string'] = esc_html__('Section: %s', 'wp-rem');
            $wp_rem_static_text['wp_rem_text_string'] = esc_html__('Text: %s', 'wp-rem');
            $wp_rem_static_text['wp_rem_text_small'] = esc_html__('Text', 'wp-rem');
            $wp_rem_static_text['wp_rem_custom_field_title'] = esc_html__('Field Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_services_small'] = esc_html__('Services', 'wp-rem');
            $wp_rem_static_text['wp_rem_services_string'] = esc_html__('Services: %s', 'wp-rem');
            $wp_rem_static_text['wp_rem_field_title'] = esc_html__('Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_field_time_lapse'] = esc_html__('Time Lapse', 'wp-rem');
            $wp_rem_static_text['wp_rem_field_time_lapse_hint'] = esc_html__('Add time lapse here in minutes ( 1 to 59 )', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_type_icon_image'] = esc_html__('Property Type Icon / Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_menu_type_icon_image'] = esc_html__('Property Type Menu Icon / Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_icon'] = esc_html__('Icon', 'wp-rem');
            $wp_rem_static_text['wp_rem_image'] = esc_html__('Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_icon'] = esc_html__('Property Icon', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_image'] = esc_html__('Property Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_menu_icon'] = esc_html__('Property Menu Icon', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_menu_image'] = esc_html__('Property Menu Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_marker_image'] = esc_html__('Map Marker Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_select_a_page'] = esc_html__('Please select a page', 'wp-rem');
            $wp_rem_static_text['wp_rem_select_result_page'] = esc_html__('Result Page', 'wp-rem');
            $wp_rem_static_text['wp_rem_select_result_page_hint'] = esc_html__('Select Result Page', 'wp-rem');
            $wp_rem_static_text['wp_rem_search_result_page'] = esc_html__('Search Result Page', 'wp-rem');
            $wp_rem_static_text['wp_rem_single_page_layout'] = esc_html__('Single Page Layout', 'wp-rem');
            $wp_rem_static_text['wp_rem_view1'] = esc_html__('View 1', 'wp-rem');
            $wp_rem_static_text['wp_rem_view2'] = esc_html__('View 2', 'wp-rem');
            $wp_rem_static_text['wp_rem_view3'] = esc_html__('View 3', 'wp-rem');
			$wp_rem_static_text['wp_rem_view4'] = esc_html__('View 4', 'wp-rem');
            $wp_rem_static_text['wp_rem_required'] = esc_html__('Required', 'wp-rem');
            $wp_rem_static_text['wp_rem_meta_key'] = esc_html__('Meta Key', 'wp-rem');
            $wp_rem_static_text['wp_rem_meta_key_hint'] = esc_html__('Please enter Meta Key without special characters and spaces', 'wp-rem');
            $wp_rem_static_text['wp_rem_place_holder'] = esc_html__('Place Holder', 'wp-rem');
            $wp_rem_static_text['wp_rem_chosen_search'] = esc_html__('Chosen Search', 'wp-rem');
            $wp_rem_static_text['wp_rem_chosen_search_hint'] = esc_html__('If Set to "Yes" user can filter the results from dropdown selection.', 'wp-rem');
            $wp_rem_static_text['wp_rem_enable_search'] = esc_html__('Enable In Search', 'wp-rem');
            $wp_rem_static_text['wp_rem_enable_search_hint'] = esc_html__('If Set to "Yes" user can filter the properties from search based on this field.', 'wp-rem');
            $wp_rem_static_text['wp_rem_default_value'] = esc_html__('Default Value', 'wp-rem');
            $wp_rem_static_text['wp_rem_collapse_in_search'] = esc_html__('Collapse in Search', 'wp-rem');
            $wp_rem_static_text['wp_rem_field_size'] = esc_html__('Field Size', 'wp-rem');
            $wp_rem_static_text['wp_rem_services_dropdown'] = esc_html__('Services Dropdown', 'wp-rem');
            $wp_rem_static_text['wp_rem_services_dropdown_hint'] = esc_html__('Do you want to show services dropdown in form.', 'wp-rem');
            $wp_rem_static_text['wp_rem_small'] = esc_html__('Small', 'wp-rem');
            $wp_rem_static_text['wp_rem_medium'] = esc_html__('Medium', 'wp-rem');
            $wp_rem_static_text['wp_rem_large'] = esc_html__('Large', 'wp-rem');
            $wp_rem_static_text['wp_rem_number_small'] = esc_html__('Number', 'wp-rem');
            $wp_rem_static_text['wp_rem_number_string'] = esc_html__('Number: %s', 'wp-rem');
            $wp_rem_static_text['wp_rem_textarea_small'] = esc_html__('TextArea', 'wp-rem');
            $wp_rem_static_text['wp_rem_textarea_string'] = esc_html__('TextArea: %s', 'wp-rem');
            $wp_rem_static_text['wp_rem_title'] = esc_html__('Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_help_text'] = esc_html__('Help Text', 'wp-rem');
            $wp_rem_static_text['wp_rem_rows'] = esc_html__('Rows', 'wp-rem');
            $wp_rem_static_text['wp_rem_columns'] = esc_html__('Columns', 'wp-rem');
            $wp_rem_static_text['wp_rem_search_style'] = esc_html__('Search Style', 'wp-rem');
            $wp_rem_static_text['wp_rem_view_style'] = esc_html__('View Style', 'wp-rem');
            $wp_rem_static_text['wp_rem_simple'] = esc_html__('Simple', 'wp-rem');
            $wp_rem_static_text['wp_rem_with_background_image'] = esc_html__('With Background Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_multi_select'] = esc_html__('Multi Select', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_multi_select'] = esc_html__('Post Multi Select', 'wp-rem');
            $wp_rem_static_text['wp_rem_first_value'] = esc_html__('First Value', 'wp-rem');
            $wp_rem_static_text['wp_rem_options'] = esc_html__('Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_add_another'] = esc_html__('Add Another', 'wp-rem');
            $wp_rem_static_text['wp_rem_remove_this'] = esc_html__('Remove This', 'wp-rem');
            $wp_rem_static_text['wp_rem_date_small'] = esc_html__('Date', 'wp-rem');
            $wp_rem_static_text['wp_rem_date_string'] = esc_html__('Date: %s', 'wp-rem');
            $wp_rem_static_text['wp_rem_date_format'] = esc_html__('Date Format', 'wp-rem');
            $wp_rem_static_text['wp_rem_range_small'] = esc_html__('Range', 'wp-rem');
            $wp_rem_static_text['wp_rem_range_string'] = esc_html__('Range: %s', 'wp-rem');
            $wp_rem_static_text['wp_rem_quantity_small'] = esc_html__('Quantity', 'wp-rem');
            $wp_rem_static_text['wp_rem_quantity_string'] = esc_html__('Quantity: %s', 'wp-rem');
            $wp_rem_static_text['wp_rem_minimum_value'] = esc_html__('Minimum Value', 'wp-rem');
            $wp_rem_static_text['wp_rem_maximum_value'] = esc_html__('Maximum Value', 'wp-rem');
            $wp_rem_static_text['wp_rem_increment_step'] = esc_html__('Increment Step', 'wp-rem');
            $wp_rem_static_text['wp_rem_slider'] = esc_html__('Slider', 'wp-rem');
            $wp_rem_static_text['wp_rem_dropdown_small'] = esc_html__('Dropdown', 'wp-rem');
            $wp_rem_static_text['wp_rem_dropdown_string'] = esc_html__('Dropdown: %s', 'wp-rem');
            $wp_rem_static_text['wp_rem_field_name_required'] = esc_html__('Field Name is Required', 'wp-rem');
            $wp_rem_static_text['wp_rem_whitespaces_not_allowed'] = esc_html__('Whitespaces not allowed', 'wp-rem');
            $wp_rem_static_text['wp_rem_special_characters_not_allowed'] = esc_html__('Special Characters are not allowed', 'wp-rem');
            $wp_rem_static_text['wp_rem_name_already_exists'] = esc_html__('Name already exists', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_options'] = esc_html__('Property Type Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_add_feature'] = esc_html__('Add Feature', 'wp-rem');
            $wp_rem_static_text['wp_rem_update_feature'] = esc_html__('Update Feature', 'wp-rem');
            $wp_rem_static_text['wp_rem_image_gallery'] = esc_html__('Image Gallery', 'wp-rem');
            $wp_rem_static_text['wp_rem_opening_hours'] = esc_html__('Opening Hours', 'wp-rem');
            $wp_rem_static_text['wp_rem_off_days'] = esc_html__('Off Days', 'wp-rem');
            $wp_rem_static_text['wp_rem_inquiry_form_choice'] = esc_html__('Inquiry Form', 'wp-rem');
            $wp_rem_static_text['wp_rem_report_spams'] = esc_html__('Flag property', 'wp-rem');
            $wp_rem_static_text['wp_rem_similar_posts'] = esc_html__('Similar Posts', 'wp-rem');
            $wp_rem_static_text['wp_rem_featured_property_image'] = esc_html__('Featured Property Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_claim_property'] = esc_html__('Claim Ads', 'wp-rem');
            $wp_rem_static_text['wp_rem_social_share'] = esc_html__('Social Share', 'wp-rem');
            $wp_rem_static_text['wp_rem_location_map'] = esc_html__('Location / Map', 'wp-rem');
            $wp_rem_static_text['wp_rem_review_ratings'] = esc_html__('Review & Ratings', 'wp-rem');
            $wp_rem_static_text['wp_rem_services_options'] = esc_html__('Services Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_files_attchments_options'] = esc_html__('Files Attachments Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_floor_plans_options'] = esc_html__('Floor Plans Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_near_by_options'] = esc_html__('Near By Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_env_res_options'] = esc_html__('Environmental Responsibility Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_financing_calculator_choice'] = esc_html__('Financing Calculator', 'wp-rem');
            $wp_rem_static_text['wp_rem_uncheck_features'] = esc_html__('Uncheck Features', 'wp-rem');
            $wp_rem_static_text['wp_rem_review_options'] = esc_html__('Reviews Detail', 'wp-rem');

/////// Property Type Suggested Tags
            $wp_rem_static_text['wp_rem_select_cats'] = esc_html__('Select Categories', 'wp-rem');
            $wp_rem_static_text['wp_rem_select_cats_hint'] = esc_html__('Select property type categories from this dropdown.', 'wp-rem');
            $wp_rem_static_text['wp_rem_add_new_cats_link'] = esc_html__('Add new Categories', 'wp-rem');

            $wp_rem_static_text['wp_rem_select_suggested_tags'] = esc_html__('Select Tags', 'wp-rem');
            $wp_rem_static_text['wp_rem_select_suggested_tags_hint'] = esc_html__('Select property type suggested tags from this dropdown.', 'wp-rem');
            $wp_rem_static_text['wp_rem_add_tag'] = esc_html__('Add Tag', 'wp-rem');
            $wp_rem_static_text['wp_rem_add_tag_name'] = esc_html__('Tag Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_tags'] = esc_html__('Suggested Tags', 'wp-rem');
            $wp_rem_static_text['wp_rem_update_tag'] = esc_html__('Update Tag', 'wp-rem');
            $wp_rem_static_text['wp_rem_add_new_tag_link'] = esc_html__('Add new tags', 'wp-rem');

/////// Property Type Features
            $wp_rem_static_text['wp_rem_property_type_features_label'] = esc_html__('Enter Label', 'wp-rem');
/////// Property Type Packages
            $wp_rem_static_text['wp_rem_select_packages'] = esc_html__('Select Packages', 'wp-rem');
            $wp_rem_static_text['wp_rem_select_packages_hint'] = esc_html__('Select property type packages from this dropdown.', 'wp-rem');

///////
            $wp_rem_static_text['wp_rem_property_options'] = esc_html__('Properties Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_select'] = esc_html__('Select', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_posted_on'] = esc_html__('Posted on:', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_expired_on'] = esc_html__('Expired on:', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_yes'] = esc_html__('Yes', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_no'] = esc_html__('No', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_package'] = esc_html__('Package', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_status'] = esc_html__('Status', 'wp-rem');
			$wp_rem_static_text['wp_rem_select_property_status'] = esc_html__('Property Status', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_awaiting_activation'] = esc_html__('Awaiting Activation', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_active'] = esc_html__('Active', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_inactive'] = esc_html__('Inactive', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_delete'] = esc_html__('Delete', 'wp-rem');
			$wp_rem_static_text['wp_rem_property_deleted'] = esc_html__('Deleted', 'wp-rem');
			$wp_rem_static_text['wp_rem_property_expire'] = esc_html__('Expire', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_property_old_status'] = esc_html__('Property Old Status', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_style'] = esc_html__('Style', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_default'] = esc_html__('Default - Selected From Plugin Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_2_columns'] = esc_html__('2 Columns', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_3_columns'] = esc_html__('3 Columns', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_classic'] = esc_html__('Classic', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_fancy'] = esc_html__('Fancy', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_map_view'] = esc_html__('Map View', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type'] = esc_html__('Property Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_calendar_demo'] = esc_html__('Calendar Demo', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_hint'] = esc_html__('Select Property Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_fields'] = esc_html__('Custom Fields', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_organization'] = esc_html__('Organization', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_mailing_information'] = esc_html__('Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_env_res'] = esc_html__('ENVIRONMENTAL RESPONSIBILITY', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_select_categories'] = esc_html__('Select Categories', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_categories'] = esc_html__('How would you describe the property?', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_no_custom_field_found'] = esc_html__('No Custom Field Found', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_off_days'] = esc_html__('Off Days', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_opening_hours'] = esc_html__('Opening Hours', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_features'] = esc_html__('Features', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_favourite'] = esc_html__('Favourite', 'wp-rem');
			$wp_rem_static_text['wp_rem_property_save_to_favourite'] = esc_html__('Save to Favourite', 'wp-rem');
			$wp_rem_static_text['wp_rem_property_remove_to_favourite'] = esc_html__('Removed from Favorites', 'wp-rem');
			$wp_rem_static_text['wp_rem_property_social_share_text'] = esc_html__('Share', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_featured'] = esc_html__('Featured', 'wp-rem');
			$wp_rem_static_text['wp_rem_property_price_start_from'] = esc_html__('Start from', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_locations'] = esc_html__('Locations', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_add_location'] = esc_html__('Add Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_new_location'] = esc_html__('New Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_add_new_location'] = esc_html__('Add New Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_edit_location'] = esc_html__('Edit Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_no_locations_found.'] = esc_html__('No locations found.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_name'] = esc_html__('Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_slug'] = esc_html__('Slug', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_posts'] = esc_html__('Posts', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_properties'] = esc_html__('Properties', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_add_new_property'] = esc_html__('Add New Property', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_edit_property'] = esc_html__('Edit Property', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_new_property_item'] = esc_html__('New Property Item', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_view_property_item'] = esc_html__('View Property Item', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search'] = esc_html__('Search', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_nothing_found'] = esc_html__('Nothing found', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_nothing_found_in_trash'] = esc_html__('Nothing found in Trash', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_company'] = esc_html__('Member', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_property_type'] = esc_html__('Property Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_property_posted'] = esc_html__('Posted', 'wp-rem');
			$wp_rem_static_text['wp_rem_property_filter_search_for_member'] = esc_html__('Search for a member...', 'wp-rem');
			$wp_rem_static_text['wp_rem_property_filter_search_for_member'] = esc_html__('Search for a member...', 'wp-rem');
			$wp_rem_static_text['wp_rem_property_property_image'] = esc_html__('Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_property_expired'] = esc_html__('Expired', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_property_status'] = esc_html__('Status', 'wp-rem');
			$wp_rem_static_text['wp_rem_property_column_property_image'] = esc_html__('Property Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_property_categories'] = esc_html__('Categories', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_property_category'] = esc_html__('Category', 'wp-rem');
			$wp_rem_static_text['wp_rem_property_property_sub_category'] = esc_html__('Sub Category', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_property_all_categories'] = esc_html__('All Categories', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_property_parent_category'] = esc_html__('Parent Category', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_property_parent_category_clone'] = esc_html__('Parent Category Clone', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_property_edit_category'] = esc_html__('Edit Category', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_property_update_category'] = esc_html__('Update Category', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_property_add_new_category'] = esc_html__('Add New Category', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_no_locations_found'] = esc_html__('No locations found.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_column_name'] = esc_html__('Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_column_slug'] = esc_html__('Slug', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_column_posts'] = esc_html__('Posts', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_property_features'] = esc_html__('PROPERTY FEATURES', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_property_desc'] = esc_html__('PROPERTY DESCRIPTION', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_walk_scores'] = esc_html__('Walk Scores', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_walk_scores_more_detail'] = esc_html__('More Details Here', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_transit_score'] = esc_html__('Transit Score', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_bike_score'] = esc_html__('Bike Score', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_score_error_occured'] = esc_html__('An error occurred while fetching walk scores.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_contact_member'] = esc_html__('Contact Member', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_contact_details'] = esc_html__('Contact Details', 'wp-rem');
// Property Custom Fields
            $wp_rem_static_text['wp_rem_property_custom_text'] = esc_html__('Text', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_required'] = esc_html__('Required', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_title'] = esc_html__('Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_meta_key'] = esc_html__('Meta Key', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_meta_key_hint'] = esc_html__('Please enter Meta Key without special character and space.', 'wp-rem');
            $wp_rem_static_text['dwp_rem_property_custom_place_holder'] = esc_html__('Place Holder', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_enable_search'] = esc_html__('Enable Search', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_default_value'] = esc_html__('Default Value', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_collapse_search'] = esc_html__('Collapse in Search', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_icon'] = esc_html__('Icon', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_text_area'] = esc_html__('Text Area', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_help_text'] = esc_html__('Help Text', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_rows'] = esc_html__('Rows', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_columns'] = esc_html__('Columns', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_dropdown'] = esc_html__('Dropdown', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_enable_multi_select'] = esc_html__('Enable Multi Select', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_post_multi_select'] = esc_html__('Post Multi Select', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_first_value'] = esc_html__('First Value', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_options'] = esc_html__('Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_date'] = esc_html__('Date', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_date_format'] = esc_html__('Date Format', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_email'] = esc_html__('Email', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_url'] = esc_html__('Url', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_range'] = esc_html__('Range', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_minimum_value'] = esc_html__('Minimum Value', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_maximum_value'] = esc_html__('Maximum Value', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_increment_step'] = esc_html__('Increment Step', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_enable_inputs'] = esc_html__('Enable Inputs', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_search_style'] = esc_html__('Search Style', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_input'] = esc_html__('Input', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_slider'] = esc_html__('Slider', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_Input_Slider'] = esc_html__('Input + Slider', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_please_select_atleast_one_option'] = esc_html__('Please select atleast one option for', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_field'] = esc_html__('field', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_all_settings_saved'] = esc_html__('All Settings Saved', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_field_name_required'] = esc_html__('Field name is required.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_whitespaces_not_allowed'] = esc_html__('Whitespaces not allowed', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_special_characters_not_allowed'] = esc_html__('Special character not allowed but only (_,-).', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_name_already_exist'] = esc_html__('Name already exist.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_custom_name_available'] = esc_html__('Name Available.', 'wp-rem');
// Property Images Gallery/opening hours.
            $wp_rem_static_text['wp_rem_property_image_gallery'] = esc_html__('Images Gallery', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_gallery_image'] = esc_html__('Gallery Images', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_schedule_with_time'] = esc_html__('Schedule With Time', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_opening_time'] = esc_html__('Opening Time', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_closing_time'] = esc_html__('Closing Time', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_monday_on'] = esc_html__('Monday On?', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_monday'] = esc_html__('Monday', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_tuesday'] = esc_html__('Tuesday', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_tuesday_on'] = esc_html__('Tuesday On?', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_wednesday'] = esc_html__('Wednesday', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_wednesday_on'] = esc_html__('Wednesday On?', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_thursday'] = esc_html__('Thursday', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_thursday_on'] = esc_html__('Thursday On?', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_friday'] = esc_html__('Friday', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_friday_on'] = esc_html__('Friday On?', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_saturday'] = esc_html__('Saturday', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_saturday_on'] = esc_html__('Saturday On?', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_sunday'] = esc_html__('Sunday', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_sunday_on'] = esc_html__('Sunday On?', 'wp-rem');
//Property Page element
            $wp_rem_static_text['wp_rem_property_page_elements'] = esc_html__('Page Elements', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_page_inquire_form'] = esc_html__('Inquire Form ON / OFF', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_page_financing_calculator'] = esc_html__('Financing calculator ON / OFF', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_page_report_spams'] = esc_html__('Flag property', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_page_similar_posts'] = esc_html__('Similar Posts', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_page_featured_property_image'] = esc_html__('Featured Property Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_page_claim_property'] = esc_html__('Claim Ads', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_page_social_share'] = esc_html__('Social Share', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_page_review_ratings'] = esc_html__('Review & Ratings', 'wp-rem');
//Property Posted by
            $wp_rem_static_text['wp_rem_property_posted_by'] = esc_html__('Posted by', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_user_profile_data'] = esc_html__('User Profile Data', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_posted_logo'] = esc_html__('Logo', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_posted_full_name_business_name'] = esc_html__('Full Name / Business Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_posted_email'] = esc_html__('Email', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_posted_website'] = esc_html__('Website', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_posted_facebook'] = esc_html__('Facebook', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_posted_twitter'] = esc_html__('Twitter', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_posted_linkedIn'] = esc_html__('LinkedIn', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_posted_google_plus'] = esc_html__('Google Plus', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_posted_phone_no'] = esc_html__('Phone No', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_posted_select_a_user'] = esc_html__('Select a user', 'wp-rem');
//Property Services
            $wp_rem_static_text['wp_rem_property_services'] = esc_html__('Services', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_services_title'] = esc_html__('Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_services_description'] = esc_html__('Description', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_services_icon'] = esc_html__('Icon', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_services_price'] = esc_html__('Price', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_services_capacity'] = esc_html__('Capacity', 'wp-rem');
//Property save post options
            $wp_rem_static_text['wp_rem_property_save_post_browse'] = esc_html__('Browse', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_load_icomoon'] = esc_html__('Load from IcoMoon selection.json', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_country'] = esc_html__('Country', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_select_country'] = esc_html__('Select Country', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_city'] = esc_html__('City', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_select_city'] = esc_html__('Select City', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_complete_address'] = esc_html__('Complete Address', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_complete_address_hint'] = esc_html__('Enter you complete address with city, state or country.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_find_on_map'] = esc_html__('Find on Map', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_address'] = esc_html__('Address', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_latitude'] = esc_html__('Latitude', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_longitude'] = esc_html__('Longitude', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_search_location_on_map'] = esc_html__('Search This Location on Map', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_search_location'] = esc_html__('Search Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_update_map'] = esc_html__('update map', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_please_wait'] = esc_html__('Please wait...', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_loaded_icons'] = esc_html__('Successfully loaded icons', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_error_try_again'] = esc_html__('Error: Try Again?', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_image'] = esc_html__('Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_choose_icon'] = esc_html__('Choose Icon', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_ISO_code'] = esc_html__('ISO Code', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_member'] = esc_html__('Member', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_properties'] = esc_html__('Properties', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_save_post_register'] = esc_html__('Register', 'wp-rem');


// post type price tables
            $wp_rem_static_text['wp_rem_post_type_price_table_name'] = esc_html__('Price Tables', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_price_table_singular_name'] = esc_html__('Price Table', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_price_table_menu_name'] = esc_html__('Price Tables', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_price_table_name_admin_bar'] = esc_html__('Price Tables', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_price_table_add_new'] = esc_html__('Add Price Table', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_price_table_add_new_item'] = esc_html__('Add Price Table', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_price_table_new_item'] = esc_html__('Add Price Table', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_price_table_edit_item'] = esc_html__('Edit Price Table', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_price_table_view_item'] = esc_html__('Price Table', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_price_table_all_items'] = esc_html__('Price Tables', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_price_table_search_items'] = esc_html__('Price Table', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_price_table_not_found'] = esc_html__('Price Tables', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_price_table_not_found_in_trash'] = esc_html__('Price Tables', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_price_table_description'] = esc_html__('Edit Price Table', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_price_table_meta_number_of_services'] = esc_html__('Price Table', 'wp-rem');
// price tables meta
            $wp_rem_static_text['wp_rem_property_price_tables_options'] = esc_html__('Price Table Options', 'wp-rem');

// post type packages
            $wp_rem_static_text['wp_rem_post_type_package_name'] = esc_html__('Packages', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_package_singular_name'] = esc_html__('Package', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_package_menu_name'] = esc_html__('Packages', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_package_name_admin_bar'] = esc_html__('Packages', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_package_add_new'] = esc_html__('Add Package', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_package_add_new_item'] = esc_html__('Add Package', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_package_new_item'] = esc_html__('Add Package', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_package_edit_item'] = esc_html__('Edit Package', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_package_view_item'] = esc_html__('Package', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_package_all_items'] = esc_html__('Packages', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_package_search_items'] = esc_html__('Package', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_package_not_found'] = esc_html__('Packages', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_package_not_found_in_trash'] = esc_html__('Packages', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_package_description'] = esc_html__('Edit Package', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_package_meta_number_of_services'] = esc_html__('Package', 'wp-rem');
// post type Branches
            $wp_rem_static_text['wp_rem_branches'] = esc_html__('Branches', 'wp-rem');
            $wp_rem_static_text['wp_rem_branch_options'] = esc_html__('Branch Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_branch_name'] = esc_html__('Branches', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_branch_singular_name'] = esc_html__('Branch', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_branch_menu_name'] = esc_html__('Branches', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_branch_name_admin_bar'] = esc_html__('Branches', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_branch_add_new'] = esc_html__('Add Branch', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_branch_add_new_item'] = esc_html__('Add Branch', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_branch_new_item'] = esc_html__('Add Branch', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_branch_edit_item'] = esc_html__('Edit Branch', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_branch_view_item'] = esc_html__('Branch', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_branch_all_items'] = esc_html__('Branches', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_branch_search_items'] = esc_html__('Branche', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_branch_not_found'] = esc_html__('Branches', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_branch_not_found_in_trash'] = esc_html__('Branches', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_branch_description'] = esc_html__('Edit Branch', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_branch_meta_number_of_services'] = esc_html__('Branch', 'wp-rem');
// Arrange Viewing Post Type Meta
            $wp_rem_static_text['wp_rem_property_arrange_viewings_options'] = esc_html__('Property Arrange Viewing Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_order_id'] = esc_html__('Arrange Viewing ID', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_property_member'] = esc_html__('Property Member', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_Viewing_member'] = esc_html__('Viewing Member', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewings_'] = esc_html__('Service', 'wp-rem');
// Property Enquiries Post Type Meta
            $wp_rem_static_text['wp_rem_property_enquiries_options'] = esc_html__('Property Enquiry Options', 'wp-rem');
// Packages meta
            $wp_rem_static_text['wp_rem_property_packages_options'] = esc_html__('Package Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_num_property_allowed'] = esc_html__('Number of Property Ads ', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_num_property_allowed_hint'] = esc_html__('Add no of property allowed in this package.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_duration'] = esc_html__('Package Duration ( Days )', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_duration_hint'] = esc_html__('Add duration of package.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_days'] = esc_html__('Days', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_property_duration'] = esc_html__('Property Ads Duration ( Days )', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_property_duration_hint'] = esc_html__('Add duration of property ads.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_month'] = esc_html__('Month', 'wp-rem'); 
            $wp_rem_static_text['wp_rem_property_packages_num_pictures'] = esc_html__('No of Pictures Allowed', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_num_pictures_hint'] = esc_html__('Add no of pictures allowed in this package.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_num_documents'] = esc_html__('Number of Attachments', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_num_documents_hint'] = esc_html__('Add no of attachment allowed in this package.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_num_tags'] = esc_html__('Search Tags', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_num_tags_hint'] = esc_html__('Add no of tags allowed in this package.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_reviews'] = esc_html__('Reviews Allowed', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_reviews_hint'] = esc_html__('Reviews On/Off', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_home_featured_property'] = esc_html__('Home Featured Property', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_greater_val_error'] = esc_html__('Please enter a value less than number of property Allowed', 'wp-rem');
            $wp_rem_static_text['wp_rem_number_of_top_cat_properties'] = esc_html__('Top Categories Properties', 'wp-rem');
            $wp_rem_static_text['wp_rem_number_of_top_cat_properties_hint'] = esc_html__('Add no of top categories properties.', 'wp-rem');
            $wp_rem_static_text['wp_rem_package_tile'] = esc_html__('Package Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_package_type'] = esc_html__('Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_package_type_hint'] = esc_html__('Select package type from this dropdown.', 'wp-rem');
            $wp_rem_static_text['wp_rem_package_type_free'] = esc_html__('Free', 'wp-rem');
            $wp_rem_static_text['wp_rem_package_type_paid'] = esc_html__('Paid', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_top_categories'] = esc_html__('Top of Categories', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_phone_num'] = esc_html__('Allow Phone Number', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_open_house'] = esc_html__('Open House', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_website_link'] = esc_html__('Website Link', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_cover_image'] = esc_html__('Cover Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_social_impressions'] = esc_html__('Social Networks Auto-Poster', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_social_impressions_hint_text'] = esc_html__('Auto property sharing for %s', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_social_impressions_hint_social_network'] = esc_html__('Social Networks', 'wp-rem');
			
            $wp_rem_static_text['wp_rem_property_packages_respond_reviews'] = esc_html__('Can respond to reviews', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_24support'] = esc_html__('24 Support', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_analytics_tracking'] = esc_html__('Analytics and Tracking', 'wp-rem');
            $wp_rem_static_text['wp_rem_number_of_feature_properties'] = esc_html__('Featured Properties', 'wp-rem');
            $wp_rem_static_text['wp_rem_number_of_feature_properties_hint'] = esc_html__('Add no of featured properties.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_packages_seo'] = esc_html__('Search Engine Optimization', 'wp-rem');
            $wp_rem_static_text['wp_rem_package_price'] = esc_html__('Price', 'wp-rem');
            $wp_rem_static_text['wp_rem_package_price_hint'] = esc_html__('Add package price in this field.', 'wp-rem');
            $wp_rem_static_text['wp_rem_package_icon'] = esc_html__('Icon', 'wp-rem');
            $wp_rem_static_text['wp_rem_package_best_offer'] = esc_html__('Best offer', 'wp-rem');

            // Import/Export users
            $wp_rem_static_text['wp_rem_property_users_zip_file'] = esc_html__('Zip file', 'wp-rem');
            $wp_rem_static_text['wp_rem_import_may_want_to_see'] = esc_html__('You may want to see', 'wp-rem');
			$wp_rem_static_text['wp_rem_import_the_demo_file'] = esc_html__('the demo file', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_zip_notification'] = esc_html__('Notification', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_zip_send_new_users'] = esc_html__('Send to new users', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_password_nag'] = esc_html__('Password nag', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_password_nag_hint'] = esc_html__('Show password nag on new users signon', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_update'] = esc_html__('Users update', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_update_hint'] = esc_html__('Update user when a username or email exists', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_import_users'] = esc_html__('Import Users', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_export_all_users'] = esc_html__('Export All Users', 'wp-rem');

            // Import/Export users errors/Notices
            $wp_rem_static_text['wp_rem_property_users_update'] = esc_html__('Import / Export Users', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_export'] = esc_html__('Export Users', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_data_import_error'] = esc_html__('There is an error in your users data import, please try later', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_import_notice'] = esc_html__('Notice: please make the wp_rem %s writable so that you can see the error log.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_error_file_upload'] = esc_html__('Error during file upload.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_cannot_extract_data'] = esc_html__('Cannot extract data from uploaded file or no file was uploaded.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_not_imported'] = esc_html__('No user was successfully imported%s.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_imported_some_success'] = esc_html__('Some users were successfully imported but some were not%s.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_import_successful'] = esc_html__('Users import was successful.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_invalid_file_type'] = esc_html__('You have selected invalid file type, Please try again.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_export_successful'] = esc_html__('Users has been done export successful.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_import_user_data'] = esc_html__('Import User Data', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_users_sufficient_permissions'] = esc_html__('You do not have sufficient permissions to access this page.', 'wp-rem');

            // user meta 
            $wp_rem_static_text['wp_rem_user_meta_profile_approved'] = esc_html__('Profile Approved', 'wp-rem');
            $wp_rem_static_text['wp_rem_user_meta_extra_profile_information'] = esc_html__('Extra profile information', 'wp-rem');
            $wp_rem_static_text['wp_rem_user_meta_my_profile'] = esc_html__('Account Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_user_meta_profile_settings'] = esc_html__('Profile Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_user_meta_logo'] = esc_html__('Logo', 'wp-rem');
            $wp_rem_static_text['wp_rem_user_meta_gallery'] = esc_html__('Gallery', 'wp-rem');
            $wp_rem_static_text['wp_rem_user_meta_full_name_or_business_nme'] = esc_html__('Full Name / Business Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_user_meta_email'] = esc_html__('Email', 'wp-rem');
            $wp_rem_static_text['wp_rem_email_string'] = esc_html__('Email: %s', 'wp-rem');
            $wp_rem_static_text['wp_rem_user_meta_website'] = esc_html__('Website', 'wp-rem');
            $wp_rem_static_text['wp_rem_user_meta_social_networks'] = esc_html__('Social Networks', 'wp-rem');
            $wp_rem_static_text['wp_rem_user_meta_facebook'] = esc_html__('Facebook', 'wp-rem');
            $wp_rem_static_text['wp_rem_user_meta_twitter'] = esc_html__('Twitter', 'wp-rem');
            $wp_rem_static_text['wp_rem_user_meta_linkedIn'] = esc_html__('LinkedIn', 'wp-rem');
            $wp_rem_static_text['wp_rem_user_meta_google_plus'] = esc_html__('Google Plus', 'wp-rem');
            $wp_rem_static_text['wp_rem_user_meta_phone_no'] = esc_html__('Phone No', 'wp-rem');
            $wp_rem_static_text['wp_rem_user_meta_mailing_information'] = esc_html__('Mailing Information', 'wp-rem');

            // property type meta
            $wp_rem_static_text['wp_rem_property_type_meta_custom_fields'] = esc_html__('Custom Fields', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_form_builders'] = esc_html__('Form Builders', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_features'] = esc_html__('Features', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_suggested_tags'] = esc_html__('Suggested Tags', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_packages'] = esc_html__('Packages', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_categories'] = esc_html__('Categories', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_page_elements'] = esc_html__('Page Elements', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_required_elements'] = esc_html__('Single Page Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_settings'] = esc_html__('Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_general_settings'] = esc_html__('General Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_enable_upload'] = esc_html__('Enable Upload', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_image_per_ad'] = esc_html__('Image per Ad', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_price'] = esc_html__('Price', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_price_switch'] = esc_html__('Price', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_price_field_label'] = esc_html__('Price Field Label', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_enable_price_search'] = esc_html__('Enable Price Search', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_min_range'] = esc_html__('Min Range', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_max_range'] = esc_html__('Max Range', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_increament'] = esc_html__('Increament', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_price_search_style'] = esc_html__('Price Search Style', 'wp-rem');

            $wp_rem_static_text['wp_rem_no_of_pictures_allowed'] = esc_html__('Number of Pictures Allowed', 'wp-rem');
            $wp_rem_static_text['wp_rem_no_of_tags_allowed'] = esc_html__('Number of Tags Allowed', 'wp-rem');
            $wp_rem_static_text['wp_rem_auto_reviews_approval'] = esc_html__('Auto Reviews Approval', 'wp-rem');
            $wp_rem_static_text['wp_rem_ads_images_videos_limit'] = esc_html__('Ads Images / Videos Limit', 'wp-rem');
            $wp_rem_static_text['wp_rem_opening_hour_time_lapse'] = esc_html__('Opening Hour Time Laps ( In Minutes )', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_feature_add_row'] = esc_html__('Add New Feature', 'wp-rem');
            $wp_rem_static_text['wp_rem_orders_inquiries_status'] = esc_html__('Enquiries/Arrange Viewings Statuses', 'wp-rem');
            $wp_rem_static_text['wp_rem_orders_inquiries_add_status'] = esc_html__('Add New Status', 'wp-rem');
            $wp_rem_static_text['wp_rem_orders_inquiries_enter_status'] = esc_html__('Enter Status', 'wp-rem');

            // member profile tab
            $wp_rem_static_text['wp_rem_member_profile_settings'] = esc_html__('Profile Setting', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_first_name'] = esc_html__('First name', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_last_name'] = esc_html__('Last Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_display_name'] = esc_html__('Display Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_company_name'] = esc_html__('Member Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_email_address'] = esc_html__('Email Address', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_profile_type'] = esc_html__('Profile Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_profile_individual'] = esc_html__('Individual', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_profile_company'] = esc_html__('Company', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_change_password'] = esc_html__('Password Change', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_current_password'] = esc_html__('Current Password', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_new_password'] = esc_html__('New Password', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_new_password_em'] = esc_html__('leave blank to leave unchanged', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_confirm_new_password'] = esc_html__('Confirm New Password', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_address'] = esc_html__('Address', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_country'] = esc_html__('Country', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_city_town'] = esc_html__('Town / City', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_upload_profile_picture'] = esc_html__('Upload a profile picture or choose one of the following', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_upload_featured_image'] = esc_html__('Upload a featured image', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_upload_profile_picture_button'] = esc_html__('Upload Picture', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_first_name_empty_error'] = esc_html__('first name should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_last_name_empty_error'] = esc_html__('last name should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_display_name_empty_error'] = esc_html__('display name should not be empty', 'wp-rem');

            $wp_rem_static_text['wp_rem_member_company_name_exist_error'] = esc_html__('Profile Url already taken', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_biography_empty_error'] = esc_html__('Biography should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_phone_empty_error'] = esc_html__('Phone number should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_email_empty_error'] = esc_html__('email should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_company_name_empty_error'] = esc_html__('Company name should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_email_valid_error'] = esc_html__('email address is not valid', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_email_exists_error'] = esc_html__('email already exists!', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_invalid_current_pass'] = esc_html__('Invalid current password', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_pass_and_confirmpass_not_mached'] = esc_html__('Password and confirm password did not matched', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_updated_success_mesage'] = esc_html__('Updated successfully', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_no_permissions_to_upload'] = esc_html__('No permissions to upload file', 'wp-rem');
            $wp_rem_static_text['wp_rem_cropping_file_error'] = esc_html__('something went wrong, most likely file is to large for upload. check upload_max_filesize, post_max_size and memory_limit in you php.ini', 'wp-rem');
            $wp_rem_static_text['wp_rem_uploading_avatar_error'] = esc_html__('Image size too large max image size is 1 MB', 'wp-rem');

            // Members Post Type
            $wp_rem_static_text['wp_rem_members'] = esc_html__('Members', 'wp-rem');
            $wp_rem_static_text['wp_rem_company'] = esc_html__('Member', 'wp-rem');
			$wp_rem_static_text['wp_rem_search_members'] = esc_html__('Search Members', 'wp-rem');
            $wp_rem_static_text['wp_rem_add_company'] = esc_html__('Add New Member', 'wp-rem');
            $wp_rem_static_text['wp_rem_edit_company'] = esc_html__('Edit Member', 'wp-rem');
            $wp_rem_static_text['wp_rem_no_member'] = esc_html__('No Member', 'wp-rem');

            // Member Permissions
            $wp_rem_static_text['profile_manage'] = esc_html__('Profile Manage', 'wp-rem');
            $wp_rem_static_text['properties_manage'] = esc_html__('Properties Manage', 'wp-rem');
            $wp_rem_static_text['orders_manage'] = esc_html__('Orders Manage', 'wp-rem');
            $wp_rem_static_text['enquiries_manage'] = esc_html__('Enquiries Manage', 'wp-rem');
            $wp_rem_static_text['arrange_viewings_manage'] = esc_html__('Arrange Viewings Manage', 'wp-rem');
            $wp_rem_static_text['reviews_manage'] = esc_html__('Reviews Manage', 'wp-rem');
            $wp_rem_static_text['packages_manage'] = esc_html__('Packages Manage', 'wp-rem');
            $wp_rem_static_text['favourites_manage'] = esc_html__('Favourite Manage', 'wp-rem');

            // Packages add fields
            $wp_rem_static_text['wp_rem_add_field'] = esc_html__('Add Package Field', 'wp-rem');
            $wp_rem_static_text['wp_rem_package_field'] = esc_html__('Package Field', 'wp-rem');
            $wp_rem_static_text['wp_rem_add_field_label'] = esc_html__('Label', 'wp-rem');
            $wp_rem_static_text['wp_rem_add_field_type'] = esc_html__('Field Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_add_field_type_hint'] = esc_html__('Select field type from this dropdown.', 'wp-rem');
            $wp_rem_static_text['wp_rem_add_field_single_choice'] = esc_html__('Single Choice', 'wp-rem');
            $wp_rem_static_text['wp_rem_add_field_single_line'] = esc_html__('Single Line', 'wp-rem');
            $wp_rem_static_text['wp_rem_package_additional_fields'] = esc_html__('Package Additional Fields', 'wp-rem');
            $wp_rem_static_text['wp_rem_company_details'] = esc_html__('Member Data', 'wp-rem');
            $wp_rem_static_text['wp_rem_phone'] = esc_html__('Phone Number', 'wp-rem');
            $wp_rem_static_text['wp_rem_email_address'] = esc_html__('Email', 'wp-rem');
            $wp_rem_static_text['wp_rem_website'] = esc_html__('Website', 'wp-rem');


            $wp_rem_static_text['wp_rem_member_company_settings'] = esc_html__('Member Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_company_name'] = esc_html__('Display Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_company_slug'] = esc_html__('Profile Url', 'wp-rem');
            $wp_rem_static_text['wp_rem_add'] = esc_html__('Add', 'wp-rem');


            $wp_rem_static_text['wp_rem_member_company_website'] = esc_html__('Member Website', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_company_phone'] = esc_html__('Member Phone', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_company_description'] = esc_html__('Member Description', 'wp-rem');
            $wp_rem_static_text['company_profile_manage'] = esc_html__('Member Profile Manage', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_account_display_name'] = esc_html__('Account Display Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_company_name'] = esc_html__('Company Name', 'wp-rem');

            // widgets
            $wp_rem_static_text['wp_rem_var_locations'] = esc_html__('Cs:Locations', 'wp-rem');
            $wp_rem_static_text['wp_rem_var_locations_description'] = esc_html__('WP Real Estate Manager Locations widget');
            $wp_rem_static_text['wp_rem_widget_title'] = esc_html__('Title');
            $wp_rem_static_text['wp_rem_widget_title_desc'] = esc_html__('Enter Descreption');
            $wp_rem_static_text['choose_location_fields'] = esc_html__('Locations');
            $wp_rem_static_text['choose_location_fields_desc'] = esc_html__('Select Locations');


            // Banners
            $wp_rem_static_text['wp_rem_banner_single_banner'] = esc_html__(' Single Banner', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_random_banner'] = esc_html__('Random Banners', 'wp-rem');
            $wp_rem_static_text['wp_rem_select_category'] = esc_html__('Select Category', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_view'] = esc_html__('Banner View ', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_view_hint'] = esc_html__('Select Banner View ', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_search_pagination'] = esc_html__('Show Pagination', 'wp-rem');

            $wp_rem_static_text['wp_rem_banner_no_of_banner'] = esc_html__('Number of Banners', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_no_of_banner_hint'] = esc_html__('Please Number of Banners here', 'wp-rem');

            $wp_rem_static_text['wp_rem_banner_code'] = esc_html__('Banner Code', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_code_hint'] = esc_html__('Please Banner Code here', 'wp-rem');

            $wp_rem_static_text['wp_rem_banner_title_field'] = esc_html__('Banner Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_title_field_hint'] = esc_html__('Please enter Banner Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_style'] = esc_html__('Banner Style', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_style_hint'] = esc_html__('Please Select  Banner Style', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_type'] = esc_html__('Banner Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_type_hint'] = esc_html__('Please enter  Banner Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_type_top'] = esc_html__('Top Banner', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_type_bottom'] = esc_html__('Bottom Banner', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_type_property_detail'] = esc_html__('Property Detail Banner', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_type_property'] = esc_html__('Property Banner', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_type_property_leftfilter'] = esc_html__('Property Left Filter Banner', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_type_sidebar'] = esc_html__('Sidebar Banner', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_url_field'] = esc_html__('Banner Url', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_type_member'] = esc_html__('Member Banner', 'wp-rem');

            $wp_rem_static_text['wp_rem_banner_type_vertical'] = esc_html__('Vertical Banner', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_image'] = esc_html__('Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_code'] = esc_html__('Code', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_adsense_code'] = esc_html__('Adsense Code', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_adsense_code_hint'] = esc_html__('Please enter Adsense Code for Ad', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_image_hint'] = esc_html__('Please Select Banner Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_target'] = esc_html__('Target', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_target_hint'] = esc_html__('Please select Banner Link Target', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_target_self'] = esc_html__('Self', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_target_blank'] = esc_html__('Blank', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_already_added'] = esc_html__('Already Added Banners', 'wp-rem');

            $wp_rem_static_text['wp_rem_banner_table_title'] = esc_html__('Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_table_style'] = esc_html__('Style', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_table_image'] = esc_html__('Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_table_clicks'] = esc_html__('Clicks', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_table_shortcode'] = esc_html__('Shortcode', 'wp-rem');
            $wp_rem_static_text['wp_rem_open_house'] = esc_html__('Open House', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_user_buyer'] = esc_html__('Buyer', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_user_reseller'] = esc_html__('Reseller', 'wp-rem');
			$wp_rem_static_text['wp_rem_member_user_seller'] = esc_html__('Seller', 'wp-rem');
			$wp_rem_static_text['wp_rem_top_member_status_filter'] = esc_html__('Member Status', 'wp-rem');
            $wp_rem_static_text['wp_rem_top_member_title_field'] = esc_html__('Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_top_member_num_post'] = esc_html__('No of Record', 'wp-rem');

            $wp_rem_static_text['wp_rem_top_properties_title_field'] = esc_html__('Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_top_properties_num_post'] = esc_html__('No of Record', 'wp-rem');
            
            // Class Save Posts
            $wp_rem_static_text['wp_rem_save_post_display_name_table'] = esc_html__('Display Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_property_status_awaiting_activation'] = esc_html__('Awaiting Activation', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_property_status_inactive'] = esc_html__('Inactive', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_property_status_delete'] = esc_html__('Delete', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_property_status_pending'] = esc_html__('Pending', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_property_status_active'] = esc_html__('Active', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_location_country'] = esc_html__('Country', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_location_select_country'] = esc_html__('Select Country', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_location_state'] = esc_html__('City', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_location_select_state'] = esc_html__('Select City', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_location_city'] = esc_html__('City', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_location_select_city'] = esc_html__('Select City', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_location_town'] = esc_html__('Town', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_location_select_town'] = esc_html__('Select Town', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_location_find_on_map'] = esc_html__('Find on Map', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_location_address'] = esc_html__('Address', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_location_latitude'] = esc_html__('Latitude', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_location_longitude'] = esc_html__('Longitude', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_location_exact_location_radius'] = esc_html__('Exact Location/Radius', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_location_search_on_map'] = esc_html__('Search This Location on Map', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_location_address_location'] = esc_html__('Address/Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_location_type_address'] = esc_html__('Type Your Address', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_location_hide_location'] = esc_html__('Hide Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_location_radius_exact_location'] = esc_html__('Radius/Exact Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_save_post_location_precise_drag_drop'] = esc_html__('For the precise location, you can drag and drop the pin.', 'wp-rem');

			$wp_rem_static_text['wp_rem_marker_opions_image'] = esc_html__('Image', 'wp-rem');
			$wp_rem_static_text['wp_rem_marker_opions_map_iamge'] = esc_html__('Map Image', 'wp-rem');
			$wp_rem_static_text['wp_rem_marker_opions_title'] = esc_html__('Title', 'wp-rem');
			$wp_rem_static_text['wp_rem_marker_opions_marker_type'] = esc_html__('Marker Type', 'wp-rem');
			$wp_rem_static_text['wp_rem_price_type_pcm'] = esc_html__('pcm', 'wp-rem');
			$wp_rem_static_text['wp_rem_price_type_pw'] = esc_html__('pw', 'wp-rem');
            $wp_rem_static_text['wp_rem_submit_button_save_changes'] = esc_html__('Save Changes', 'wp-rem');
			
            $wp_rem_static_text['wp_rem_plugin_option_map_custom_style'] = esc_html__('Map Custom Style', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_option_map_custom_style_desc'] = __('Add Map Custom Style code. You can find all styles from here %s', 'wp-rem');
                        
            $wp_rem_static_text['wp_rem_plugin_options_demo_user_modification_allowed'] = esc_html__('Demo User Modification Allowed', 'wp-rem');
			
            $wp_rem_static_text['wp_rem_enquiry_post_filter_for_member'] = esc_html__('Search for a Owner...', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_post_filter_for_Property'] = esc_html__('Search for a Property...', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_post_status_change'] = esc_html__('Status Changed.', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_post_there_is_error'] = esc_html__('There is some error.', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_post_status_txt'] = esc_html__('Status', 'wp-rem');
            
            
            $wp_rem_static_text['wp_rem_options_status_color'] = esc_html__('Status Color', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_status_label'] = esc_html__('Status Label', 'wp-rem');
            
            
            $wp_rem_static_text['wp_rem_options_banner_image_error'] = esc_html__('Please provide image for banner', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_banner_code_error'] = esc_html__('Please provide adsense code', 'wp-rem');
            
            $wp_rem_static_text['wp_rem_shortcode_split_map_heading'] = esc_html__('Split Map', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_classic'] = esc_html__('Classic', 'wp-rem');
            
            $wp_rem_static_text['wp_rem_shortcode_map_position'] = esc_html__('Map Position', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_map_left'] = esc_html__('Left', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_map_right'] = esc_html__('Right', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_map_top'] = esc_html__('Top', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_map_bottom'] = esc_html__('Bottom', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_split_map_options'] = esc_html__('SPLIT MAP OPTIONS', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_fixed_map'] = esc_html__('Fixed Map', 'wp-rem');
			
			$wp_rem_static_text['wp_rem_property_type_in'] = esc_html__('in', 'wp-rem');
            $wp_rem_static_text['wp_rem_top_map_draw_btn'] = esc_html__('Draw', 'wp-rem');
            $wp_rem_static_text['wp_rem_top_map_clear_btn'] = esc_html__('Clear', 'wp-rem');
			$wp_rem_static_text['wp_rem_mortgage_calculator_month'] = esc_html__('MONTH', 'wp-rem');
			
			$wp_rem_static_text['wp_rem_advance_search_select_price_type_label'] = esc_html__('Price Type', 'wp-rem');
			$wp_rem_static_text['wp_rem_advance_search_select_price_types_all'] = esc_html__('All', 'wp-rem');
			$wp_rem_static_text['wp_rem_advance_search_select_price_range'] = esc_html__('Price Range', 'wp-rem');
			$wp_rem_static_text['wp_rem_advance_search_min_price_range'] = esc_html__('Min. Price', 'wp-rem');
			$wp_rem_static_text['wp_rem_advance_search_max_price_range'] = esc_html__('Max. Price', 'wp-rem');
            /*
             * Use this filter to add more strings from Add on.
             */
            $wp_rem_static_text = apply_filters('wp_rem_plugin_text_strings', $wp_rem_static_text);
            return $wp_rem_static_text;
        }

    }

    new wp_rem_plugin_all_strings_1;
}
