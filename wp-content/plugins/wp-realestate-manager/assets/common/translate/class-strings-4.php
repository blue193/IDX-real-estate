<?php

/**
 * Static string 4
 */
if ( ! class_exists('wp_rem_plugin_all_strings_4') ) {

    class wp_rem_plugin_all_strings_4 {

        public function __construct() {

            add_filter('wp_rem_plugin_text_strings', array( $this, 'wp_rem_plugin_text_strings_callback' ), 1);
        }

        public function wp_rem_plugin_text_strings_callback($wp_rem_static_text) {
            global $wp_rem_static_text;

            // New strings 1
            $wp_rem_static_text['wp_rem_list_meta_property_video'] = esc_html__('Property Video', 'wp-rem');
            $wp_rem_static_text['wp_rem_class_noti_post_type_email_frequemcies'] = esc_html__('Email Frequencies', 'wp-rem');
            $wp_rem_static_text['wp_rem_class_noti_post_type_keywords_search'] = esc_html__('Search Keywords', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_video_url'] = esc_html__('Video URL', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_page_style'] = esc_html__('Page Style', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_default_view'] = esc_html__('Default View', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_view_1'] = esc_html__('View 1', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_view_2'] = esc_html__('View 2', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_view_3'] = esc_html__('View 3', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_view_4'] = esc_html__('View 4', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_default_header'] = esc_html__('Default Sub Header Option', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_default_header_hint'] = esc_html__('The selected value will be the default option for subheader while the view 3 is selected.', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_default'] = esc_html__('Default', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_map'] = esc_html__('Map', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_banner'] = esc_html__('Banner', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_sticky'] = esc_html__('Sticky Navigation', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_featured'] = esc_html__('Featured', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_top_category'] = esc_html__('Top Category', 'wp-rem');
			$wp_rem_static_text['wp_rem_list_meta_property_recent_switch'] = esc_html__('Recent Properties', 'wp-rem');
			$wp_rem_static_text['wp_rem_list_meta_property_recent_numbers'] = esc_html__('Number of Recent Properties', 'wp-rem');
			$wp_rem_static_text['wp_rem_list_meta_property_recent_hint'] = esc_html__('Recent Properties shows in listing page when user set any search criteria and find no result then recent properties will be show after result.', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_no_of_pictures'] = esc_html__('Number of Pictures', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_no_of_documents'] = esc_html__('Number of Documents', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_no_of_tags'] = esc_html__('Number of Tags', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_reviews'] = esc_html__('Reviews', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_phone_number'] = esc_html__('Phone Number', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_open_house'] = esc_html__('Open House', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_website_link'] = esc_html__('Website Link', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_social_reach'] = esc_html__('Social Impressions Reach', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_respond'] = esc_html__('Respond to Reviews', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_features_element'] = esc_html__('Features Element', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_video_element'] = esc_html__('Video Element', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_yelp_element'] = esc_html__('Yelp Places Element', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_appartment_element'] = esc_html__('Appartment For Sale Element', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_file_element'] = esc_html__('File Attachments Element', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_floor_plan_element'] = esc_html__('Floor Plan Element', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_property_summary'] = esc_html__('Property Summary', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_per_week'] = esc_html__('Per Week', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_per_cm'] = esc_html__('Per Month', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_per_month'] = esc_html__('Per Month', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_price_option'] = esc_html__('Ad Price Option', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_none'] = esc_html__('None', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_on_call'] = esc_html__('On Call', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_price'] = esc_html__('Price', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_ad_price'] = esc_html__('USD Price', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_ad_price_ttd'] = esc_html__('TTD Price', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_price_type'] = esc_html__('Price Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_step_2'] = esc_html__('Step 2: What type of property are you marketing?', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_date'] = esc_html__('Date', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_time_fom'] = esc_html__('Time From', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_time_to'] = esc_html__('Time To', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_no_of_days'] = esc_html__('No off days added.', 'wp-rem');
            $wp_rem_static_text['wp_rem_list_meta_off_days'] = esc_html__('Off Days', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_access_token'] = esc_html__('Get Access Token', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_page_sharing'] = esc_html__('Select Page for Sharing', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_yelp_places'] = esc_html__('Yelp Places', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_select_a_page'] = esc_html__('Please select a page', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_unchecked_show'] = esc_html__('Single Page Unchecked show', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_select_image'] = esc_html__('Select Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_select_map_image'] = esc_html__('Select Map Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_address'] = esc_html__('Address', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_latitude'] = esc_html__('Latitude', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_longitude'] = esc_html__('Longitude', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_location_on_map'] = esc_html__('Search This Location on Map', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_add_banner'] = esc_html__('Add Banner', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_import_options'] = esc_html__('Import Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_file_url'] = esc_html__('File URL', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_file_url_hint'] = esc_html__('Input the Url from another location and hit Import Button to apply settings.', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_import'] = esc_html__('Import', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_export_options'] = esc_html__('Export Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_generated_files'] = esc_html__('Generated Files', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_generated_files_hint'] = esc_html__('Here you can Generate/Download Backups. Also you can use these Backups to Restore settings.', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_restore'] = esc_html__('Restore', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_delete'] = esc_html__('Delete', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_generated_backup'] = esc_html__('Generate Backup', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_imp_exp_locations'] = esc_html__('Import/Export Locations', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_imp_exp_hint'] = esc_html__('Input the Url from another location and hit Import Button to import locations.', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_import_locations'] = esc_html__('Import Locations', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_browse_file'] = esc_html__('Browse file', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_imp_exp_categories'] = esc_html__('Import/Export Property Type Categories', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_imp_exp_cat_hint'] = esc_html__('Input the URL from another location and hit Import Button to import property type categories.', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_import_categories'] = esc_html__('Import Property Type Categories', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_backup_hint'] = esc_html__('Here you can Generate/Download Backups. Also you can use these Backups to Restore Property type categories.', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_download'] = esc_html__('Download', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_warning'] = esc_html__('Warning!!!', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_modfiying_warning'] = esc_html__('By modifying location levels your existing locations data may get useless as you change levels. So, it is recommended to backup and delete existing locations.', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_locations_levels'] = esc_html__('Locations Levels', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_country'] = esc_html__('Country', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_state'] = esc_html__('City', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_city'] = esc_html__('City', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_town'] = esc_html__('Town', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_town_complete_address'] = esc_html__('Complete Address', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_edit_levels'] = esc_html__('Edit Levels', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_locations_selector'] = esc_html__("Location's Fields Selector", 'wp-rem');
            $wp_rem_static_text['wp_rem_options_selector_hint'] = esc_html__('Select which location parts(Country, State, City, Town) you want to use on frontend. You can select only from location parts those you have selected on backend.', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_location_parts'] = esc_html__('Frontend Location Parts', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_location_parts_hint'] = esc_html__('Select which location parts(Country, State, City, Town) you want to use on frontend. You can select only from location parts those you have selected on backend.', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_country_hint'] = esc_html__('Select a Country which you want to use in locations or select "All".', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_state_hint'] = esc_html__('Select a State which you want to use in locations or select "All".', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_city_hint'] = esc_html__('Select a City which you want to use in locations or select "All".', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_town_hint'] = esc_html__('Select a Town which you want to use in locations or select "All".', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_choose'] = esc_html__('Choose...', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_all'] = esc_html__('All', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_import_users'] = esc_html__('Import Users', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_label'] = esc_html__('Label', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_add_more'] = esc_html__('Add More', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_member_title'] = esc_html__('Member Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_member_value'] = esc_html__('Member Value', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_member_type'] = esc_html__('Add Member Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_opt_func_option_saved'] = esc_html__('Plugin Options Saved.', 'wp-rem');
            $wp_rem_static_text['wp_rem_opt_func_error_saving'] = esc_html__('Error saving file!', 'wp-rem');
            $wp_rem_static_text['wp_rem_opt_func_backup_generated'] = esc_html__('Backup Generated.', 'wp-rem');
            $wp_rem_static_text['wp_rem_opt_func_file_delete'] = esc_html__("File '%s' Deleted Successfully", 'wp-rem');
            $wp_rem_static_text['wp_rem_opt_func_error_delete'] = esc_html__('Error Deleting file!', 'wp-rem');
            $wp_rem_static_text['wp_rem_opt_func_restore_file'] = esc_html__("File '%s' Restore Successfully", 'wp-rem');
            $wp_rem_static_text['wp_rem_register_disable'] = esc_html__('User Registration is disabled', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_alreaady_logged'] = esc_html__('Already Loggedin', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_login_here'] = esc_html__('Login Here', 'wp-rem');

            $wp_rem_static_text['wp_rem_register_signin_here'] = esc_html__('Sign In', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_text_register'] = esc_html__('register', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_need_more_help'] = esc_html__('Need more Help?', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_login_with_social_string'] = esc_html__('You Can Login using your facebook, twitter Profile or Google account', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_contact_us_string'] = esc_html__('contact us', 'wp-rem');


            $wp_rem_static_text['wp_rem_register_logout_first'] = esc_html__('Please logout first then try to login again', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_login_demo'] = esc_html__('Click to login with Demo User', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_login_buyer_rent'] = esc_html__('Buy Or Rent', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_login_sell_let_out'] = esc_html__('Sell Or Let out', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_member'] = esc_html__('Member', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_agency'] = esc_html__('Agency', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_username'] = esc_html__('Username', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_password'] = esc_html__('Password', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_login'] = esc_html__('Log in', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_forgot_password'] = esc_html__('Forgot Password?', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_company_name'] = esc_html__('Company Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_display_name'] = esc_html__('Display Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_member_type'] = esc_html__('Member Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_email'] = esc_html__('Email', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_signup'] = esc_html__('Sign Up', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_register'] = esc_html__('Register', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_sorry'] = esc_html__('Sorry! ', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_sorry_text'] = esc_html__(' does not shared your email, please provide a valid email address.', 'wp-rem');
            $wp_rem_static_text['wp_rem_packages_type'] = esc_html__('Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_packages_purchase_button'] = esc_html__('Package Purchase Buton', 'wp-rem');
            $wp_rem_static_text['wp_rem_packages_buy_now'] = esc_html__('Buy Now', 'wp-rem');
            $wp_rem_static_text['wp_rem_packages_recommended'] = esc_html__('Recommended', 'wp-rem');
            $wp_rem_static_text['wp_rem_packages_login_first'] = esc_html__('You have to login for purchase property.', 'wp-rem');
            $wp_rem_static_text['wp_rem_packages_become_member'] = esc_html__('Become a member to subscribe a Package.', 'wp-rem');
            $wp_rem_static_text['wp_rem_price_subscribe'] = esc_html__('Package Subscribe Action', 'wp-rem');
            $wp_rem_static_text['wp_rem_price_order_detail'] = esc_html__('Order Detail', 'wp-rem');
            $wp_rem_static_text['wp_rem_price_add_property'] = esc_html__('Add Property', 'wp-rem');
            $wp_rem_static_text['wp_rem_price_name'] = esc_html__('Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_price_price'] = esc_html__('Price', 'wp-rem');
            $wp_rem_static_text['wp_rem_price_color'] = esc_html__('Color', 'wp-rem');
            $wp_rem_static_text['wp_rem_price_description'] = esc_html__('Description', 'wp-rem');
            $wp_rem_static_text['wp_rem_price_button_text'] = esc_html__('Button Text', 'wp-rem');
            $wp_rem_static_text['wp_rem_price_duration'] = esc_html__('Duration', 'wp-rem');
            $wp_rem_static_text['wp_rem_price_featured'] = esc_html__('Featured', 'wp-rem');
            $wp_rem_static_text['wp_rem_price_package'] = esc_html__('Package', 'wp-rem');
            $wp_rem_static_text['wp_rem_price_select_package'] = esc_html__('Select Package', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_username_error'] = esc_html__('Username should not be empty.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_password_error'] = esc_html__('Password should not be empty.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_not_activated'] = esc_html__('Your account is not activated yet.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_removed_from_company'] = esc_html__('Your profile has been removed from company', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_check_password'] = esc_html__('Please check your password.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_wrong_user_pass'] = esc_html__('Wrong username or password.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_login_successfully'] = esc_html__('Login successfully...', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_enter_valid_username'] = esc_html__('Please enter a valid username. You can only enter alphanumeric value and only ( _ ) longer than or equals 5 chars', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_select_type'] = esc_html__('Please select member type.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_email_error'] = esc_html__('Email Field should not be empty.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_valid_email'] = esc_html__('Please enter a valid email.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_type_error'] = esc_html__('Profile Type should not be empty.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_display_name_error'] = esc_html__('Display Name should not be empty.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_company_name_error'] = esc_html__('Company Name should not be empty.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_email_already_exists'] = esc_html__('Sorry! Email already exists.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_user_already_exists'] = esc_html__('User already exists. Please try another one.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_check_email'] = esc_html__('Please check your email for login details.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_went_wrong'] = esc_html__('Something went wrong, Email could not be processed.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_an_issue'] = esc_html__('Currently there is an issue', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_success'] = esc_html__('Your account has been registered successfully, Please contact to site admin for password.', 'wp-rem');

            $wp_rem_static_text['wp_rem_member_add_members'] = esc_html__('Add Members', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_add_team_member'] = esc_html__('Add Team Member', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_send'] = esc_html__('Send', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_cancel'] = esc_html__('Cancel', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_no_any_member'] = esc_html__("You don't have any team member", 'wp-rem');
            $wp_rem_static_text['wp_rem_member_valid_email'] = esc_html__('Please provide valid email address', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_email_exists'] = esc_html__('Email address already exists', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_valid_file'] = esc_html__('Please provide valid file for an image', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_member_added'] = esc_html__('Team member successfully added!', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branch_updated'] = esc_html__('Branch successfully updated!', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_super_admin_removed'] = esc_html__('Super Admin Successfully Removed', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branch_removed'] = esc_html__('Branch Successfully Removed', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_upload'] = esc_html__('Upload', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_loc_branch'] = esc_html__('Locations/Branches', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_save'] = esc_html__('Save', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_change_pass'] = esc_html__('Change Password', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_my_profile'] = esc_html__('My Profile', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_closed'] = esc_html__('Closed', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_dashboard'] = esc_html__('Member Dashboard', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_package_detail'] = esc_html__('Package Detail', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_no_of_suggestions'] = esc_html__('Please provide number of suggestions.', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_atleast_category'] = esc_html__('Please select at least one category.', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_setting_saved'] = esc_html__('Your settings successfully saved.', 'wp-rem');
            $wp_rem_static_text['wp_rem_properties_properties'] = esc_html__('My Properties', 'wp-rem');
            $wp_rem_static_text['wp_rem_properties_date_range'] = esc_html__('Select Date Range', 'wp-rem');
            $wp_rem_static_text['wp_rem_properties_submit_ad'] = esc_html__('Submit Ad', 'wp-rem');
            $wp_rem_static_text['wp_rem_properties_ads'] = esc_html__('Ads', 'wp-rem');
            $wp_rem_static_text['wp_rem_properties_posted'] = esc_html__('Posted', 'wp-rem');
            $wp_rem_static_text['wp_rem_properties_expires'] = esc_html__('Expires', 'wp-rem');
            $wp_rem_static_text['wp_rem_slider_image'] = esc_html__('slider image', 'wp-rem');
            $wp_rem_static_text['wp_rem_slider_view_all_photos'] = esc_html__('View all photos', 'wp-rem');
            $wp_rem_static_text['wp_rem_services_element'] = esc_html__('Service & Rates', 'wp-rem');
            $wp_rem_static_text['wp_rem_opening_hours_at_opens_at'] = esc_html__(': Opens at', 'wp-rem');
            $wp_rem_static_text['wp_rem_opening_hours_opens_at'] = esc_html__('Opens at', 'wp-rem');
            $wp_rem_static_text['wp_rem_opening_hours_closed'] = esc_html__('Closed', 'wp-rem');
            $wp_rem_static_text['wp_rem_opening_hours_opening_timings'] = esc_html__('Opening Timings', 'wp-rem');

            // Start Locations Manager.
            $wp_rem_static_text['wp_rem_locations_taxonomy_label'] = esc_html__('Locations', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_not_found'] = esc_html__('No locations found.', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_search'] = esc_html__('Search Locations', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_popular'] = esc_html__('Popular Locations', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_all'] = esc_html__('All Locations', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_parent'] = esc_html__('Parent Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_edit'] = esc_html__('Edit Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_update'] = esc_html__('Update Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_add_new'] = esc_html__('Add New Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_new_name'] = esc_html__('New Location Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_with_commas'] = esc_html__('Separate Locations with commas', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_add_remove'] = esc_html__('Add or Remove Locations', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_choose_from_most_used'] = esc_html__('Choose from the most used Locations', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_add'] = esc_html__('Add Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_select_area'] = esc_html__('Use me to select an area for a location.', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_draw_polygon'] = esc_html__('Draw Polygon', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_search_placeholder'] = esc_html__('Search...', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_returned_place'] = esc_html__('Returned place contains no geometry', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_geocode_success'] = esc_html__('Geocode was not successful for the following reason', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_name'] = esc_html__('Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_type'] = esc_html__('Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_slug'] = esc_html__('Slug', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_posts'] = esc_html__('Posts', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_iso_code'] = esc_html__('ISO Code', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_coordinates'] = esc_html__('Location Coordinates', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_authentication_failed'] = esc_html__('Authentication Failed.', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_invalid_data'] = esc_html__('Invalid Data.', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_error_saving'] = esc_html__('Error saving file!', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_backup_generated'] = esc_html__('Backup Generated.', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_file_deleted'] = esc_html__("File '%s' Deleted Successfully", 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_error_deleting_file'] = esc_html__('Error Deleting file!', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_file_import'] = esc_html__("File '%s' Restored Successfully", 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_error_restoring'] = esc_html__('Error Restoring file!', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_no_location_found'] = esc_html__('No location found', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_taxonomy_imported_successfully'] = esc_html__('File Imported Successfully', 'wp-rem');

            // End Locations Manager.
            // Start Google Captcha.
            $wp_rem_static_text['wp_rem_google_captcha_reload'] = esc_html__('Reload', 'wp-rem');
            $wp_rem_static_text['wp_rem_google_captcha_provide_captcha_api_key'] = esc_html__('Please provide google captcha API keys', 'wp-rem');
            $wp_rem_static_text['wp_rem_google_captcha_select_field'] = esc_html__('Please Select Captcha Field', 'wp-rem');

            // End Google Captcha.
            // Start Image Cropper.
            $wp_rem_static_text['wp_rem_image_cropper_error_return_code'] = esc_html__('ERROR Return Code', 'wp-rem');
            $wp_rem_static_text['wp_rem_image_cropper_type_not_supported'] = esc_html__('image type not supported', 'wp-rem');
            $wp_rem_static_text['wp_rem_image_cropper_can_not_write_file'] = esc_html__('Can`t write cropped File', 'wp-rem');

            // End Image Cropper.
            // Start Pagination.
            $wp_rem_static_text['wp_rem_pagination_prev'] = esc_html__('Prev', 'wp-rem');
            $wp_rem_static_text['wp_rem_pagination_next'] = esc_html__('Next', 'wp-rem');

            // End Pagination.
            // Start Search Fields.
            $wp_rem_static_text['wp_rem_search_fields_other_features'] = esc_html__('Other Features', 'wp-rem');
            $wp_rem_static_text['wp_rem_search_fields_price_type_all'] = esc_html__('All Price Types', 'wp-rem');
            $wp_rem_static_text['wp_rem_search_fields_price_type_per_week'] = esc_html__('Per Week', 'wp-rem');
            $wp_rem_static_text['wp_rem_search_fields_price_type_per_month'] = esc_html__('Per Month', 'wp-rem');
            $wp_rem_static_text['wp_rem_search_fields_date_from'] = esc_html__('From', 'wp-rem');
            $wp_rem_static_text['wp_rem_search_fields_date_to'] = esc_html__('To', 'wp-rem');

            // End Search Fields.
            // Start Social Sharing.
            $wp_rem_static_text['wp_rem_social_sharing_facebook'] = esc_html__('facebook', 'wp-rem');
            $wp_rem_static_text['wp_rem_social_sharing_twitter'] = esc_html__('twitter', 'wp-rem');
            $wp_rem_static_text['wp_rem_social_sharing_google_plus'] = esc_html__('google+', 'wp-rem');
            $wp_rem_static_text['wp_rem_social_sharing_tumbler'] = esc_html__('tumbler', 'wp-rem');
            $wp_rem_static_text['wp_rem_social_sharing_dribble'] = esc_html__('dribble', 'wp-rem');
            $wp_rem_static_text['wp_rem_social_sharing_stumbleupon'] = esc_html__('stumbleupon', 'wp-rem');

            // End Social Sharing.
            // Start Frontend Attachments Elements.
            $wp_rem_static_text['wp_rem_attachments_files'] = esc_html__('Files attachments', 'wp-rem');
            $wp_rem_static_text['wp_rem_attachments_downloads'] = esc_html__('Download', 'wp-rem');

            // End Frontend Attachments Elements.
            // Start Frontend Author Info Elements.
            $wp_rem_static_text['wp_rem_author_info_request_details'] = esc_html__('Request Details', 'wp-rem');
            $wp_rem_static_text['wp_rem_author_info_close'] = esc_html__('Close', 'wp-rem');
            $wp_rem_static_text['wp_rem_author_info_send_msg'] = esc_html__('Send Message', 'wp-rem');
            $wp_rem_static_text['wp_rem_author_info_sender_name'] = esc_html__('Name *', 'wp-rem');
            $wp_rem_static_text['wp_rem_author_info_sender_email'] = esc_html__('Email *', 'wp-rem');
            $wp_rem_static_text['wp_rem_author_info_sender_message'] = esc_html__('Message *', 'wp-rem');
            $wp_rem_static_text['wp_rem_author_info_member_message_received'] = esc_html__('Member Message Received', 'wp-rem');
            $wp_rem_static_text['wp_rem_author_info_member_email_invalid_empty'] = esc_html__('Member Email is invalid or empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_author_info_sender_name_empty'] = esc_html__('Name should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_author_info_sender_email_empty'] = esc_html__('Email should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_author_info_sender_email_invalid'] = esc_html__('Please enter a valid email address', 'wp-rem');
            $wp_rem_static_text['wp_rem_author_info_sender_message_empty'] = esc_html__('Message should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_author_info_sender_email_name'] = esc_html__('Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_author_info_sender_email_email'] = esc_html__('Email', 'wp-rem');
            $wp_rem_static_text['wp_rem_author_info_sender_email_msg'] = esc_html__('Message', 'wp-rem');
            $wp_rem_static_text['wp_rem_author_info_sender_email_ip_address'] = esc_html__('IP Address', 'wp-rem');
            $wp_rem_static_text['wp_rem_author_info_sender_email_sent_success'] = esc_html__('Email sent successfully.', 'wp-rem');
            $wp_rem_static_text['wp_rem_author_info_sender_email_not_sent'] = esc_html__('Message Not sent.', 'wp-rem');

            // End Frontend Author Info Elements.
            // Start Frontend Contact Elements.
            $wp_rem_static_text['wp_rem_contact_heading'] = esc_html__('Contact', 'wp-rem');
            $wp_rem_static_text['wp_rem_contact_details'] = esc_html__('Contact Details', 'wp-rem');
            $wp_rem_static_text['wp_rem_contact_send_enquiry'] = esc_html__('Send Enquiry By Email', 'wp-rem');
            $wp_rem_static_text['wp_rem_contact_close'] = esc_html__('Close', 'wp-rem');
            $wp_rem_static_text['wp_rem_contact_enter_name'] = esc_html__('Enter Your Name *', 'wp-rem');
            $wp_rem_static_text['wp_rem_contact_enter_email'] = esc_html__('Enter Your Email Address *', 'wp-rem');
            $wp_rem_static_text['wp_rem_contact_enter_message'] = esc_html__('Message *', 'wp-rem');
            $wp_rem_static_text['wp_rem_contact_send_message'] = esc_html__('Send message', 'wp-rem');

            // End Frontend Contact Elements.
            // Start Frontend Discussion Elements.
            $wp_rem_static_text['wp_rem_discussion_login_post_comment'] = esc_html__('You must be login to post comment.', 'wp-rem');
            $wp_rem_static_text['wp_rem_discussion_order'] = esc_html__('order', 'wp-rem');
            $wp_rem_static_text['wp_rem_discussion_enquiry'] = esc_html__('enquiry', 'wp-rem');
            $wp_rem_static_text['wp_rem_discussion_enter_message'] = esc_html__('Please enter message.', 'wp-rem');
            $wp_rem_static_text['wp_rem_discussion_not_send_discussion_closed'] = esc_html__("You can't send message because your enquiry has been closed.", 'wp-rem');
            $wp_rem_static_text['wp_rem_discussion_not_send_discussion_permission'] = esc_html__("You can't send message due to member permission.", 'wp-rem');
            $wp_rem_static_text['wp_rem_discussion_sent_you_message'] = esc_html__('sent you a message on enquiry', 'wp-rem');
            $wp_rem_static_text['wp_rem_discussion_sent_successfully'] = esc_html__('Your message has been sent successfully.', 'wp-rem');
            $wp_rem_static_text['wp_rem_discussion_not_send_discussion_against'] = esc_html__("You can't send message against this enquiry.", 'wp-rem');
            $wp_rem_static_text['wp_rem_discussion_duplicate_message'] = esc_html__('Duplicate message detected; it looks as though you&#8217;ve already said that!', 'wp-rem');
            $wp_rem_static_text['wp_rem_discussion_message'] = esc_html__('%s Message', 'wp-rem');
            $wp_rem_static_text['wp_rem_discussion_messages'] = esc_html__('%s Messages', 'wp-rem');
            $wp_rem_static_text['wp_rem_discussion_message_me'] = esc_html__('Me', 'wp-rem');
            $wp_rem_static_text['wp_rem_discussion_message_ago'] = esc_html__('ago', 'wp-rem');
            $wp_rem_static_text['wp_rem_discussion_message_unread'] = esc_html__('The enquiry has been marked as unread.', 'wp-rem');
            $wp_rem_static_text['wp_rem_discussion_message_read'] = esc_html__('The enquiry has been marked as read.', 'wp-rem');
            $wp_rem_static_text['wp_rem_discussion_message_status_changed'] = esc_html__('Enquiry status has been changed.', 'wp-rem');
            $wp_rem_static_text['wp_rem_discussion_message_status_not_changed'] = esc_html__('%s status not changed.', 'wp-rem');
            $wp_rem_static_text['wp_rem_discussion_message_status_closed'] = esc_html__('Your enquiry has been closed.', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_name_empty'] = esc_html__('Name should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_phone_empty'] = esc_html__('Phone number should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_email_empty'] = esc_html__('Email address should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_email_not_valid'] = esc_html__('Email address is not valid', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_msg_empty'] = esc_html__('Message should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_own_property_error'] = esc_html__("You can't sent enquiry on your own property.", 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_sent_successfully'] = esc_html__('Your enquiry has been sent successfully.', 'wp-rem');
// End Frontend Discussion Elements.
// Start Frontend Enquires Arrange Buttons Elements.
            $wp_rem_static_text['wp_rem_enquire_arrange_login'] = esc_html__('You should be login for submit inquery,please login first then try again', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_full_name_empty'] = esc_html__('Full name should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_phone_empty'] = esc_html__('Phone number should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_phone_not_valid'] = esc_html__('Please enter a valid phone number.', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_email_empty'] = esc_html__('Email address should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_email_not_valid'] = esc_html__('Please enter a valid  email address.', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_message_sent_successfully'] = esc_html__('Your message has been sent successfully.', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_enquiry_now'] = esc_html__('Enquire Now', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_arrange_viewing'] = esc_html__('Arrange viewing', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_request_inquiry'] = esc_html__('Enquire Now', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_send_copy'] = esc_html__('Send a copy to my email address', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_viewing_times'] = esc_html__('Preferred Viewing Times', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_viewing_times_optional'] = esc_html__('(Optional)', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_viewing_schedule'] = esc_html__('Date', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_calendar_month_jan'] = esc_html__('Jan', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_calendar_month_feb'] = esc_html__('Feb', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_calendar_month_mar'] = esc_html__('Mar', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_calendar_month_apr'] = esc_html__('Apr', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_calendar_month_may'] = esc_html__('May', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_calendar_month_jun'] = esc_html__('Jun', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_calendar_month_jul'] = esc_html__('Jul', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_calendar_month_aug'] = esc_html__('Aug', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_calendar_month_sep'] = esc_html__('Sep', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_calendar_month_oct'] = esc_html__('Oct', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_calendar_month_nov'] = esc_html__('Nov', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_calendar_month_dec'] = esc_html__('Dec', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_viewing_full_name'] = esc_html__('Full Name *', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_viewing_phone_number'] = esc_html__('Phone Number *', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_viewing_email_address'] = esc_html__('Email Address *', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_viewing_message'] = esc_html__('Message', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_viewing_receive_information'] = esc_html__('I wish to receive information from WP Real Estate Manager or selected partners', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_viewing_accept_term'] = esc_html__('By submitting this form, you accept our', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_viewing_accept_term_of_use'] = esc_html__('Terms of Use', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_viewing_accept_term_and'] = esc_html__('and', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquire_arrange_viewing_privacy_policy'] = esc_html__('Privacy Policy.', 'wp-rem');
// End Frontend Enquires Arrange Buttons Elements.
// Start Frontend Features Elements.
            $wp_rem_static_text['wp_rem_features_apartment_for_sale'] = esc_html__('Apartment for Sale', 'wp-rem');
            $wp_rem_static_text['wp_rem_features_plot'] = esc_html__('Plot', 'wp-rem');
            $wp_rem_static_text['wp_rem_features_beds'] = esc_html__('Beds', 'wp-rem');
            $wp_rem_static_text['wp_rem_features_price_from'] = esc_html__('Price From', 'wp-rem');
            $wp_rem_static_text['wp_rem_features_floor'] = esc_html__('Floor', 'wp-rem');
            $wp_rem_static_text['wp_rem_features_building_address'] = esc_html__('Building / Address', 'wp-rem');
            $wp_rem_static_text['wp_rem_features_availability'] = esc_html__('Availability', 'wp-rem');
            $wp_rem_static_text['wp_rem_features_available'] = esc_html__('Available', 'wp-rem');
            $wp_rem_static_text['wp_rem_features_not_available'] = esc_html__('Not Available', 'wp-rem');
            $wp_rem_static_text['wp_rem_features_view'] = esc_html__('view', 'wp-rem');
            $wp_rem_static_text['wp_rem_features_property_video'] = esc_html__('Property Video', 'wp-rem');
            $wp_rem_static_text['wp_rem_features_property_features'] = esc_html__('Property Features', 'wp-rem');
            $wp_rem_static_text['wp_rem_features_what_near_by'] = esc_html__('What is Near by', 'wp-rem');
            $wp_rem_static_text['wp_rem_features_unable_find_distance'] = esc_html__('Unable to find the distance', 'wp-rem');
            $wp_rem_static_text['wp_rem_features_miles_away'] = esc_html__('miles away', 'wp-rem');
// End Frontend Features Elements.
// Start Frontend Gallery Elements.
            $wp_rem_static_text['wp_rem_gallery_all_photos'] = esc_html__('View all photos', 'wp-rem');
// Start Frontend Nearby Properties Elements.
            $wp_rem_static_text['wp_rem_nearby_properties_heading'] = esc_html__('Properties in the Market Nearby', 'wp-rem');
            $wp_rem_static_text['wp_rem_nearby_properties_price_on_request'] = esc_html__('Call for Price', 'wp-rem');
// Start Frontend Opening Hours Elements.
            $wp_rem_static_text['wp_rem_opening_hours_open'] = esc_html__('Open', 'wp-rem');
            $wp_rem_static_text['wp_rem_opening_hours_today_closed'] = esc_html__('Today : Closed', 'wp-rem');
            $wp_rem_static_text['wp_rem_opening_hours_today'] = esc_html__('Today', 'wp-rem');
// Start Frontend Payment Calculator Elements.
            $wp_rem_static_text['wp_rem_payment_calculator_heading'] = esc_html__('Mortgage Payment Calculator', 'wp-rem');
            $wp_rem_static_text['wp_rem_payment_calculator_your_payment'] = esc_html__('Your payment', 'wp-rem');
            $wp_rem_static_text['wp_rem_payment_calculator_your_price'] = esc_html__('Your price', 'wp-rem');
            $wp_rem_static_text['wp_rem_payment_calculator_your_deposit'] = esc_html__('Your deposit', 'wp-rem');
            $wp_rem_static_text['wp_rem_payment_calculator_your_interest'] = esc_html__('Your interest', 'wp-rem');
            $wp_rem_static_text['wp_rem_payment_calculator_mo'] = esc_html__('MO', 'wp-rem');
            $wp_rem_static_text['wp_rem_payment_calculator_property_price'] = esc_html__('Property price:', 'wp-rem');
            $wp_rem_static_text['wp_rem_payment_calculator_deposit'] = esc_html__('Deposit:', 'wp-rem');
            $wp_rem_static_text['wp_rem_payment_calculator_annual_interest'] = esc_html__('Annual Interest:', 'wp-rem');
            $wp_rem_static_text['wp_rem_payment_calculator_year'] = esc_html__('Year:', 'wp-rem');
            $wp_rem_static_text['wp_rem_payment_calculator_get_loan_btn'] = esc_html__('Get your loan Quote', 'wp-rem');
            $wp_rem_static_text['wp_rem_payment_calculator_description'] = esc_html__('Description', 'wp-rem');
            $wp_rem_static_text['wp_rem_payment_calculator_description_hint'] = esc_html__('Please add text shows at bottom of the mortgage calculator.', 'wp-rem');
            
// Start Frontend Reservation Elements.
            $wp_rem_static_text['wp_rem_reservaion_reserve_btn_label'] = esc_html__('Reserve My Spot', 'wp-rem');
            $wp_rem_static_text['wp_rem_reservaion_select_servoces'] = esc_html__('- Select Services -', 'wp-rem');
            $wp_rem_static_text['wp_rem_reservaion_choose_file'] = esc_html__('Choose file', 'wp-rem');
            $wp_rem_static_text['wp_rem_reservaion_file_validation'] = esc_html__('Suitable files are .doc, docx, rft, pdf & .pdf', 'wp-rem');
            $wp_rem_static_text['wp_rem_reservaion_available'] = esc_html__('Available', 'wp-rem');
            $wp_rem_static_text['wp_rem_reservaion_unavailable'] = esc_html__('Unavailable', 'wp-rem');
            $wp_rem_static_text['wp_rem_reservaion_booked'] = esc_html__('Booked', 'wp-rem');
            $wp_rem_static_text['wp_rem_reservaion_am'] = esc_html__('AM', 'wp-rem');
            $wp_rem_static_text['wp_rem_reservaion_pm'] = esc_html__('PM', 'wp-rem');
            $wp_rem_static_text['wp_rem_reservaion_per_night'] = esc_html__(' / Per Night', 'wp-rem');
            $wp_rem_static_text['wp_rem_reservaion_service_validation'] = esc_html__('Please Selecct a service.', 'wp-rem');
            $wp_rem_static_text['wp_rem_reservaion_all_fields_validation'] = esc_html__('Please fill all required fields.', 'wp-rem');
            $wp_rem_static_text['wp_rem_reservaion_email_validation'] = esc_html__('Please enter a valid email address.', 'wp-rem');
            $wp_rem_static_text['wp_rem_reservaion_not_send_own_property'] = esc_html__(" Sorry! You can't send %s on your own property.", 'wp-rem');
            $wp_rem_static_text['wp_rem_reservaion_submitted_reservation_on_ad'] = esc_html__('submitted a reservation form on your Ad', 'wp-rem');
            $wp_rem_static_text['wp_rem_reservaion_sent_successfully'] = esc_html__('Your %s has been sent successfully.', 'wp-rem');
            $wp_rem_static_text['wp_rem_reservaion_smoething_went_wrong'] = esc_html__('Something went wrong, %s could not be processed.', 'wp-rem');
// End Frontend Reservation Elements.
// Start Frontend Sub Navbar Elements.
            $wp_rem_static_text['wp_rem_subnav_item_1'] = esc_html__('Property Detail', 'wp-rem');
            $wp_rem_static_text['wp_rem_subnav_item_2'] = esc_html__('Features', 'wp-rem');
            $wp_rem_static_text['wp_rem_subnav_item_3'] = esc_html__('Video', 'wp-rem');
            $wp_rem_static_text['wp_rem_subnav_item_4'] = esc_html__('Yelp Places', 'wp-rem');
            $wp_rem_static_text['wp_rem_subnav_item_5'] = esc_html__('Apartments', 'wp-rem');
            $wp_rem_static_text['wp_rem_subnav_item_6'] = esc_html__('Attachments', 'wp-rem');
            $wp_rem_static_text['wp_rem_subnav_item_7'] = esc_html__('Floor Plan', 'wp-rem');
// End Frontend Sub Navbar Elements.
// Start Frontend Yelp Places Elements.
            $wp_rem_static_text['wp_rem_yelp_places_food'] = esc_html__('Food', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_nightlife'] = esc_html__('Nightlife', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_restaurants'] = esc_html__('Restaurants', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_shopping'] = esc_html__('Shopping', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_active_life'] = esc_html__('Active Life', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_arts_entertainment'] = esc_html__('Arts & Entertainment', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_automotive'] = esc_html__('Automotive', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_beauty_spas'] = esc_html__('Beauty & Spas', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_education'] = esc_html__('Education', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_event_planning_services'] = esc_html__('Event Planning & Services', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_health_medical'] = esc_html__('Health & Medical', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_home_services'] = esc_html__('Home Services', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_local_services'] = esc_html__('Local Services', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_financial_services'] = esc_html__('Financial Services', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_hotels_travel'] = esc_html__('Hotels & Travel', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_local_flavor'] = esc_html__('Local Flavor', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_mass_media'] = esc_html__('Mass Media', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_pets'] = esc_html__('Pets', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_professional_services'] = esc_html__('Professional Services', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_public_services_govt'] = esc_html__('Public Services & Government', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_real_estate'] = esc_html__('Real Estate', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_religious_organizations'] = esc_html__('Religious Organizations', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_nearby'] = esc_html__('Yelp Places Nearby', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_category'] = esc_html__('Category:', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_reviews'] = esc_html__('%s Reviews', 'wp-rem');
            $wp_rem_static_text['wp_rem_yelp_places_'] = esc_html__('Company', 'wp-rem');
// End Frontend Yelp Places Elements.
// Start Frontend Members.
            $wp_rem_static_text['wp_rem_member_overview'] = esc_html__('Overview', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_office_branches'] = esc_html__('Office/Branches', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_staff'] = esc_html__('Staff', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_find_on_map'] = esc_html__('Find on Map', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_contact_email'] = esc_html__('Contact Email', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_properties'] = esc_html__('Properties', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_listed_on'] = esc_html__('Listed on %uth %s %u by ', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_contact_your_name'] = esc_html__('Your Name *', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_contact_your_email'] = esc_html__('Your Email Address *', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_contact_your_message'] = esc_html__('Message *', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_featured_property'] = esc_html__('Featured Property', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_sorry'] = esc_html__('Sorry !', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_no_results'] = esc_html__('No member match your search criteria.', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_find_real_members'] = esc_html__('Find Real Estate Members', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_search_enter_name'] = esc_html__('Member name e.g. Martin', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_properties2'] = esc_html__('Property(s)', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branchs'] = esc_html__('Branch(s)', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_members_found'] = esc_html__('Member(s) Found', 'wp-rem');
            $wp_rem_static_text['wp_rem_oops_nothing_found'] = esc_html__('Oops, nothing found!', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_members_default_order'] = esc_html__('Default Order', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_members_recent'] = esc_html__('Recent', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_members_alphabetical'] = esc_html__('Alphabetical', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_members_no_of_properties'] = esc_html__('No of Properties', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_members_featured'] = esc_html__('Featured', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_members_trusted_agencies'] = esc_html__('Trusted Agencies', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_members_with_colan'] = esc_html__('Member: %s', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_member_type'] = esc_html__('Member type', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_members_'] = esc_html__('Default', 'wp-rem');

// End Frontend Members.
// Start Frontend Shortcode Map Search.
            $wp_rem_static_text['wp_rem_map_search_draw_on_map'] = esc_html__('Draw on Map', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_delete_area'] = esc_html__('Clear Area', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_cancel_drawing'] = esc_html__('Cancel', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_geo_location'] = esc_html__('Geo Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_map_unlock'] = esc_html__('Map UnLock', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_map_lock'] = esc_html__('Map Lock', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_records_found'] = esc_html__('properties found', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_showing'] = esc_html__('Showing', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_results'] = esc_html__('results', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_what_looking'] = esc_html__('What are you looking for?', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_'] = esc_html__('Company', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_geoloc_timeout'] = esc_html__('Browser geolocation error. Timeout.', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_geoloc_not_support'] = esc_html__('Geolocation is not supported by this browser.', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_geoloc_unavailable'] = esc_html__('Browser geolocation error. Position unavailable.', 'wp-rem');
// End Frontend Shortcode Map Search.
// Start Login Form.
            $wp_rem_static_text['wp_rem_element_title'] = esc_html__('Element Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_title_hint'] = esc_html__('Enter element title here', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_sub_title'] = esc_html__('Element Sub Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_sub_title_hint'] = esc_html__('Enter element sub title here', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_view'] = esc_html__('View', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_view_hint'] = esc_html__('Please select element view from this dropdown', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_view_simple'] = esc_html__('Simple', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_view_classic'] = esc_html__('Classic', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_view_advance'] = esc_html__('Advance', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_view_fancy'] = esc_html__('Fancy', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_view_fancy_v2'] = esc_html__('Fancy v2', 'wp-rem');
			$wp_rem_static_text['wp_rem_element_view_fancy_v3'] = esc_html__('Fancy v3', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_view_list'] = esc_html__('List', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_view_list_modern'] = esc_html__('List Modern', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_view_list_classic'] = esc_html__('List Classic', 'wp-rem');
            
            $wp_rem_static_text['wp_rem_element_view_modernnn'] = esc_html__('Modern', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_view_gid_modern'] = esc_html__('Grid Modern', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_view_gid_classic'] = esc_html__('Grid Classic', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_view_gid_default'] = esc_html__('Grid Default', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_view_gid_masnory'] = esc_html__('Masnory', 'wp-rem');
            
            $wp_rem_static_text['wp_rem_element_view_grid'] = esc_html__('Grid', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_view_single_property'] = esc_html__('Single Property Slider', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_view_multiple_properties'] = esc_html__('Multiple Properties Slider', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_view_grid'] = esc_html__('Grid', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_see_more'] = esc_html__('See more', 'wp-rem');
            $wp_rem_static_text['wp_rem_register'] = esc_html__('Register', 'wp-rem');
            $wp_rem_static_text['wp_rem_insert'] = esc_html__('Insert', 'wp-rem');
            $wp_rem_static_text['wp_rem_save'] = esc_html__('Save', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_form_facebook_credentials'] = esc_html__('Contact site admin to provide a valid Facebook connect credentials.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_form_twitter_credentials'] = esc_html__('Contact site admin to provide a valid Twitter credentials.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_form_google_credentials'] = esc_html__('Contact site admin to provide a valid Google credentials.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_form_login_facebook_or_google'] = esc_html__('You Can Login using your facebook Profile or Google account', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_form_set_api_key'] = esc_html__('Please set API key', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_form_connect_with_facebook'] = esc_html__('Connect with facebook', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_form_connect_with_twitter'] = esc_html__('Connect with twitter', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_form_connect_with_google'] = esc_html__('Connect with google', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_form_enter_email_address'] = esc_html__('Enter Email address.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_form_invalid_email_address'] = esc_html__('Invalid e-mail address.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_form_no_user_registered_with_email'] = esc_html__('There is no user registered with that email address.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_form_check_email_for_new_pass'] = esc_html__('Check your email address for you new password.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_form_wrong_updating_account'] = esc_html__('Oops something went wrong updating your account.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_form_forgot_pass'] = esc_html__('Forgot Password', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_form_login_your_account'] = esc_html__('Login To Your Account', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_form_send_email'] = esc_html__('Send Email', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_form_register_options'] = esc_html__('REM: Register Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_form_'] = esc_html__('Save', 'wp-rem');
// End Login Form.
// Start Shortcode Login Form.
            $wp_rem_static_text['wp_rem_login_register_disabled'] = esc_html__('User Registration is disabled', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_register_sign_in'] = esc_html__('Sign in', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_register_already_have_account'] = esc_html__('Already have an account?', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_register_need_more_help'] = esc_html__('Need more Help?', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_register_can_login'] = esc_html__('You Can Login using your facebook, twitter Profile or Google account', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_register_remember_me'] = esc_html__('Remember me', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_register_confirm_below_info_for_register'] = esc_html__('Please confirm the below information on form and submit for the registration.', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_register_want_to'] = esc_html__('I want to', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_register_user_role_type'] = esc_html__('user role type', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_register_add_new_add'] = esc_html__('Add New Ad', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_register_dashboard'] = esc_html__('Dashboard', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_register_orders'] = esc_html__('Orders', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_register_enquiries'] = esc_html__('Enquiries', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_register_alerts_searches'] = esc_html__('Alerts & searches', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_register_favourite_properties'] = esc_html__('Favourite Properties', 'wp-rem');
            $wp_rem_static_text['wp_rem_login_register_sign_out'] = esc_html__('Sign out', 'wp-rem');
// End Shortcode Login Form.
// Start Shortcodes.
            $wp_rem_static_text['wp_rem_shortcodes_typography'] = esc_html__('Typography', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcodes_common_elements'] = esc_html__('Common Elements', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcodes_media_element'] = esc_html__('Media Element', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcodes_content_blocks'] = esc_html__('Content Blocks', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcodes_loops'] = esc_html__('Loops', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcodes_add_element'] = esc_html__('Add Element', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcodes_filter_by'] = esc_html__('Filter by', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcodes_show_all'] = esc_html__('Show all', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcodes_insert_shortcode'] = esc_html__('WP Real Estate Manager: Insert shortcode', 'wp-rem');
// End Shortcodes.
// Start Shortcodes Add Property.
            $wp_rem_static_text['wp_rem_title_align'] = esc_html__('Title Align', 'wp-rem');
            $wp_rem_static_text['wp_rem_title_align_hint'] = esc_html__('Select Title Alignment.', 'wp-rem');
            $wp_rem_static_text['wp_rem_align_left'] = esc_html__('Left', 'wp-rem');
            $wp_rem_static_text['wp_rem_align_right'] = esc_html__('Right', 'wp-rem');
            $wp_rem_static_text['wp_rem_align_center'] = esc_html__('Center', 'wp-rem');
            $wp_rem_static_text['wp_rem_add_properties'] = esc_html__('Add Properties', 'wp-rem');
            $wp_rem_static_text['wp_rem_add_property_options'] = esc_html__('Add Properties Options', 'wp-rem');
// End Shortcodes Add Property.
// Start Shortcode Register.
            $wp_rem_static_text['wp_rem_shortcode_register_options'] = esc_html__('REM: Register Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_register_heading'] = esc_html__('REM: Register', 'wp-rem');
// End Shortcodes Register.
// Start Shortcode Members.
            $wp_rem_static_text['wp_rem_shortcode_members_options'] = esc_html__('REM: Members Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_members_heading'] = esc_html__('REM: Members', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_members_title'] = esc_html__('Members Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_members_sub_title'] = esc_html__('Members Sub Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_members_agencies'] = esc_html__('Agencies', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_members_view'] = esc_html__('View', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_members_alphabatic'] = esc_html__('Alphabatic', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_members_grid'] = esc_html__('Grid', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_members_list'] = esc_html__('List', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_members_top_filters'] = esc_html__('Top Filters', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_members_featured_only'] = esc_html__('Featured Only', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_members_sort_by'] = esc_html__('Sort By', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_members_excerpt_length'] = esc_html__('Excerpt length', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_members_pagination'] = esc_html__('Pagination', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_members_posts_per_page'] = esc_html__('Posts Per Page', 'wp-rem');

            // End Shortcode Members.
            // Start Shortcode Pricing Table.
            $wp_rem_static_text['wp_rem_pricing_table_options'] = esc_html__('REM: Pricing Plan Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_pricing_table_heading'] = esc_html__('REM: Pricing Plan', 'wp-rem');
            $wp_rem_static_text['wp_rem_pricing_table_tables'] = esc_html__('Pricing Tables', 'wp-rem');
            $wp_rem_static_text['wp_rem_pricing_table_tables_hint'] = esc_html__('Select pricing tables from this dropdown', 'wp-rem');
            $wp_rem_static_text['wp_rem_pricing_table_'] = esc_html__('Save', 'wp-rem');

            // End Shortcode Pricing Table.
            // Start Shortcode Map Search.
            $wp_rem_static_text['wp_rem_map_search_heading'] = esc_html__('REM: Map Search', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_options'] = esc_html__('REM: Map Search Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_property_type'] = esc_html__('Property Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_map_on'] = esc_html__('Please select map on/off', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_map_height'] = esc_html__('Map Height (px)', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_map_height_hint'] = esc_html__('Enter map height here in (px)', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_map_latitude'] = esc_html__('Map Latitude', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_map_latitude_hint'] = esc_html__('Enter map latitude here', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_map_longitude'] = esc_html__('Map Longitude', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_map_longitude_hint'] = esc_html__('Enter map longitude here', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_map_zoom'] = esc_html__('Map Zoom', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_map_zoom_hint'] = esc_html__('Enter map zoom here', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_box'] = esc_html__('Search Box', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_box_hint'] = esc_html__('Search box on/off', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_keyword'] = esc_html__('Search Keyword Field', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_keyword_hint'] = esc_html__('Show/hide search by keyword field', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_property_type_hint'] = esc_html__('Select property type field enable/disable', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_location'] = esc_html__('Property Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_location_hint'] = esc_html__('Select property location field enable/disable', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_categories'] = esc_html__('Property Categories', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_search_categories_hint'] = esc_html__('Select property categories field enable/disable', 'wp-rem');

            // End Shortcode Map Search.
            // Start Shortcode Property Search.
            $wp_rem_static_text['wp_rem_property_search_heading'] = esc_html__('REM: Property Search', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_options'] = esc_html__('REM: Property Search Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_property_price_type'] = esc_html__('Property Price Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_property_price_type_hint'] = esc_html__('Select property price type field enable/disable', 'wp-rem');
			$wp_rem_static_text['wp_rem_property_search_property_price'] = esc_html__('Property Price', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_property_price_hint'] = esc_html__('Select property price field enable/disable', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_advance_filter'] = esc_html__('Property Advance Filters Switch', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_advance_filter_hint'] = esc_html__('Select property advance filters enable/disable', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_poup_link_text'] = esc_html__('Popup Link Text', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_poup_help_text'] = esc_html__('Popup Help Text', 'wp-rem');

            // End Shortcode Property Search.
            // Start Shortcode Properties.
            $wp_rem_static_text['wp_rem_shortcode_properties_heading'] = esc_html__('REM: Properties', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_options'] = esc_html__('REM: Properties Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_featured_properties_options'] = esc_html__('REM: Featured Properties Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_all_types'] = esc_html__('All Types', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_title_length'] = esc_html__('Property Title Length (in words)', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_content_length'] = esc_html__('Property Content Length', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_layout_switcher'] = esc_html__('Layout Switcher', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_layout_switcher_views'] = esc_html__('Layout Switcher Views', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_map_position'] = esc_html__('Map Position', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_footer_disable'] = esc_html__('Footer Disable', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_footer_disable_desc'] = esc_html__('That will work on only map view', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_left_filters'] = esc_html__('Left Filters', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_left_filters_count'] = esc_html__('Left Filters Counts', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_notifications_box'] = esc_html__('Notifications Box', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_draw_on_map'] = esc_html__('Draw On Map (URL)', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_top_category_count'] = esc_html__('Top Category Count', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_only_featured'] = esc_html__('Only Featured', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_number_of_custom_fields'] = esc_html__('No. of Custom Fields', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_ads_switch'] = esc_html__('Ads Switch', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_price_filters'] = esc_html__('Price Filters', 'wp-rem');
			$wp_rem_static_text['wp_rem_shortcode_properties_hide_option'] = esc_html__('Hide Property Option', 'wp-rem');
			$wp_rem_static_text['wp_rem_shortcode_properties_hide_option_desc'] = esc_html__('You will turn off/on hide option in property element', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_open_house_filters'] = esc_html__('Open House Filters', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_location_filter'] = esc_html__('Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_count'] = esc_html__('Property Count', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_count_hint'] = esc_html__('Number of series for add ad after every number like: 0, 7, 4, 2, 5', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_show_more_switch'] = esc_html__('Show More Property Button Switch', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_show_more_url'] = esc_html__('Show More Property Button URL', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_show_more_url_hint'] = esc_html__('exp: http://abc.com', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_no_sidebar'] = esc_html__('No sidebar', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_sidebar'] = esc_html__('Sidebar', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_properties_'] = esc_html__('REM', 'wp-rem');

            // End Shortcode Properties.
            // Start Shortcode Featured Properties.
            $wp_rem_static_text['wp_rem_shortcode_featured_properties_heading'] = esc_html__('REM: Featured Properties', 'wp-rem');
            // End Shortcode Featured Properties.
            // Start Shortcode Properties Slider.
            $wp_rem_static_text['wp_rem_property_slider_heading'] = esc_html__('REM: Properties Slider', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_slider_options'] = esc_html__('REM: Properties Slider Options', 'wp-rem');

            // End Shortcode Properties Slider.
            // Start Shortcode Properties Categories.
            $wp_rem_static_text['wp_rem_property_categories_heading'] = esc_html__('REM: Property Categories', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_categories_options'] = esc_html__('REM: Property Categories Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_categories_categories'] = esc_html__('Categories', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_categories_categories_hint'] = esc_html__('Select categories here', 'wp-rem');

            // End Shortcode Properties Categories.
            // Start Shortcode Properties with Filters.
            $wp_rem_static_text['wp_rem_properties_with_filters_heading'] = esc_html__('REM: Properties with Filters', 'wp-rem');
            $wp_rem_static_text['wp_rem_properties_with_categories_heading'] = esc_html__('REM: Properties with Categories', 'wp-rem');
            $wp_rem_static_text['wp_rem_properties_with_filters_options'] = esc_html__('REM: Properties with Filters Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_properties_with_categories_options'] = esc_html__('REM: Properties with Categories Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_properties_with_filters_'] = esc_html__('Categories', 'wp-rem');

            // End Shortcode Properties with Filters.
            // Start Shortcode Register User and Listung.
            $wp_rem_static_text['wp_rem_register_user_and_property_heading'] = esc_html__('REM: Register User and Add Property', 'wp-rem');
            $wp_rem_static_text['wp_rem_register_user_and_property_options'] = esc_html__('REM: Register User and Add Property Options', 'wp-rem');

            // End Shortcode Register User and Listung.
            $wp_rem_static_text['wp_rem_google_service_error'] = esc_html__('A service error occurred:', 'wp-rem');
            $wp_rem_static_text['wp_rem_google_client_error'] = esc_html__('A client error occurred:', 'wp-rem');
            $wp_rem_static_text['wp_rem_google_error_code'] = esc_html__('Error Code', 'wp-rem');
            $wp_rem_static_text['wp_rem_google_authencitcation_failed'] = esc_html__('Authentication failed due to Invalid Credentials', 'wp-rem');

            // Start Shortcode About.
            $wp_rem_static_text['wp_rem_shortcode_about_heading'] = esc_html__('REM: About Us', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_about_options'] = esc_html__('REM: About Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_about_button_url'] = esc_html__('Button Url', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_about_button_text'] = esc_html__('Button Text', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_about_button_color'] = esc_html__('Color', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_about_button_color_hint'] = esc_html__('Set the button Text color', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_about_bg_color'] = esc_html__('BG Color', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_about_bg_color_hint'] = esc_html__('Set the BG color for your about us', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_about_content'] = esc_html__('Content', 'wp-rem');

            // End Shortcode About.
            // Start Custom Woocommerce Hooks.
            $wp_rem_static_text['wp_rem_wooc_hooks_order_received'] = esc_html__('Thank you. Your order has been received.', 'wp-rem');
            $wp_rem_static_text['wp_rem_wooc_hooks_vat'] = esc_html__('VAT', 'wp-rem');

            // End Custom Woocommerce Hooks.
            // Start Notifications Modules Options.
            $wp_rem_static_text['wp_rem_yes'] = esc_html__('Yes', 'wp-rem');
            $wp_rem_static_text['wp_rem_no'] = esc_html__('NO', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_property_alerts'] = esc_html__('Property Alerts', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_alert_frequencies'] = esc_html__('Set Alert Frequencies', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_frequency'] = esc_html__('Frequency', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_announcements'] = esc_html__('For all email alert notification of user, whenever a new similar property is posted, the alert is sent to relevant users. You can set frequency of sending alerts from option given below. Make sure email server / smtp is rightly configured for sending emails.', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_annually'] = esc_html__('Annually', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_annually_hint'] = esc_html__('Do you want to allow user to set alert frequency to annually?', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_biannually'] = esc_html__('Biannually', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_biannually_hint'] = esc_html__('Do you want to allow user to set alert frequency to biannually?', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_monthly'] = esc_html__('Monthly', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_monthly_hint'] = esc_html__('Do you want to allow user to set alert frequency to monthly?', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_fortnightly'] = esc_html__('Fortnightly', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_fortnightly_hint'] = esc_html__('Do you want to allow user to set alert frequency to fortnight?', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_weekly'] = esc_html__('Weekly', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_weekly_hint'] = esc_html__('Do you want to allow user to set alert frequency to weekly?', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_daily'] = esc_html__('Daily', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_daily_hint'] = esc_html__('Do you want to allow user to set alert frequency to daily?', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_property_alert_shortcode'] = esc_html__('Property Alert Shortcode', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_property_alert_shortcode_hint'] = esc_html__('Do you want to show "Get email notifications with any updates" button on this properties property page to set property alerts.', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_property_alert_shortcode_enable'] = esc_html__('Enable', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_property_alert_shortcode_disable'] = esc_html__('Disable', 'wp-rem');

            // Start Activity Notifications Modules Options.
            $wp_rem_static_text['wp_rem_post_type_notification_name'] = esc_html__('Notifications', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_notification_singular_name'] = esc_html__('Notification', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_notification_not_found'] = esc_html__('Notification not found', 'wp-rem');
            $wp_rem_static_text['wp_rem_post_type_notification_not_found_in_trash'] = esc_html__('Notification not found', 'wp-rem');
            $wp_rem_static_text['wp_rem_activity_notifications'] = esc_html__('Notifications', 'wp-rem');
            $wp_rem_static_text['wp_rem_activity_notifications_settings'] = esc_html__('Activity Notifications Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_activity_notifications_heading'] = esc_html__('Activity Notifications', 'wp-rem');
            $wp_rem_static_text['wp_rem_activity_notifications_notifications'] = esc_html__('Notifications', 'wp-rem');
            $wp_rem_static_text['wp_rem_activity_notifications_notification'] = esc_html__('Notification', 'wp-rem');
            $wp_rem_static_text['wp_rem_activity_notifications_add_notification'] = esc_html__('Add Notification', 'wp-rem');
            $wp_rem_static_text['wp_rem_activity_notifications_edit_notification'] = esc_html__('Edit Notification', 'wp-rem');
            $wp_rem_static_text['wp_rem_activity_notifications_turn_on'] = esc_html__('Trun on this switch to show notifications for each user on member dashboard.', 'wp-rem');
            $wp_rem_static_text['wp_rem_activity_notification_message'] = esc_html__('Notification Message', 'wp-rem');

            // Start Helper Generals.
            $wp_rem_static_text['wp_rem_helper_currency'] = esc_html__('Currency', 'wp-rem');
            $wp_rem_static_text['wp_rem_helper_select_currency'] = esc_html__('Select Currency', 'wp-rem');
            $wp_rem_static_text['wp_rem_helper_member_msg_received'] = esc_html__('Member Contact Message Received', 'wp-rem');
            $wp_rem_static_text['wp_rem_helper_member_email_not_valid'] = esc_html__('Member email is invalid or empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_helper_name_empty'] = esc_html__('Name should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_helper_email_empty'] = esc_html__('Email should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_helper_email_not_valid'] = esc_html__('Not a valid email address', 'wp-rem');
            $wp_rem_static_text['wp_rem_helper_msg_empty'] = esc_html__('Message should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_helper_name'] = esc_html__('Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_helper_email'] = esc_html__('Email', 'wp-rem');
            $wp_rem_static_text['wp_rem_helper_message'] = esc_html__('Message', 'wp-rem');
            $wp_rem_static_text['wp_rem_helper_ip_address'] = esc_html__('IP Address', 'wp-rem');
            $wp_rem_static_text['wp_rem_helper_sent_msg_successfully'] = esc_html__('Sent message successfully', 'wp-rem');
            $wp_rem_static_text['wp_rem_helper_msg_not_sent'] = esc_html__('Message not sent', 'wp-rem');
            $wp_rem_static_text['wp_rem_helper_read_terms_conditions'] = esc_html__('Please indicate that you have read and agree to the Terms and Conditions and Privacy Policy', 'wp-rem');

            // Start Price Table Meta.
            $wp_rem_static_text['wp_rem_price_table_add_package'] = esc_html__('Add Package', 'wp-rem');
            $wp_rem_static_text['wp_rem_price_table_add_row'] = esc_html__('Add Row', 'wp-rem');
            $wp_rem_static_text['wp_rem_price_table_add_section'] = esc_html__('Add Section', 'wp-rem');
            $wp_rem_static_text['wp_rem_price_table_reset_all'] = esc_html__('Reset All', 'wp-rem');
            $wp_rem_static_text['wp_rem_price_table_buy_now'] = esc_html__('Buy Now', 'wp-rem');

            // End Price Table Meta.
            // Start Social Login.
            $wp_rem_static_text['wp_rem_social_login_check_fb_account'] = esc_html__('Please check facebook account developers settings.', 'wp-rem');
            $wp_rem_static_text['wp_rem_social_login_profile_already_linked'] = esc_html__('This profile is already linked with other account. Linking process failed!', 'wp-rem');
            $wp_rem_static_text['wp_rem_social_login_contact_site_admin'] = esc_html__('Contact site admin to provide a valid Twitter connect credentials.', 'wp-rem');

            // End Social Login.
            // Start Arrange Viewing.
            $wp_rem_static_text['wp_rem_viewing_name_empty'] = esc_html__('Name should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_viewing_phone_empty'] = esc_html__('Phone number should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_viewing_email_empty'] = esc_html__('Email address should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_viewing_email_not_valid'] = esc_html__('Email address is not valid', 'wp-rem');
            $wp_rem_static_text['wp_rem_viewing_msg_empty'] = esc_html__('Message should not be empty', 'wp-rem');
            $wp_rem_static_text['wp_rem_viewing_own_property_error'] = esc_html__("You can't sent message on your own property.", 'wp-rem');
            $wp_rem_static_text['wp_rem_member_viewings_recent_viewings'] = esc_html__('Recent Arrange Viewings', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_viewings_my_viewings'] = esc_html__('My Arrange Viewings', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_viewings_received_viewings'] = esc_html__('Received Arrange Viewings', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_viewings_not_received_viewing'] = esc_html__('You don\'t have any received arrange viewing', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_viewings_not_viewing'] = esc_html__('You don\'t have any arrange viewing', 'wp-rem');
            $wp_rem_static_text['wwp_rem_member_viewings_title'] = esc_html__('Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_viewings_date'] = esc_html__('Date', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_viewings_buyer'] = esc_html__('Buyer', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_viewings_member'] = esc_html__('Member', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_viewings_status'] = esc_html__('Status', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_register_arrange_viewings'] = esc_html__('Arrange Viewings', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_arrange_viewing'] = esc_html__('Arrange Viewing', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_arrange_viewing_detail'] = esc_html__('Arrange Viewing Detail', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewing_detail_status'] = esc_html__('Arrange Viewing Status', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewing_detail_arrange_viewing_completed'] = esc_html__('Your arrange viewing is completed.', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewing_detail_closed_arrange_viewing'] = esc_html__('Close Arrange Viewing', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewing_detail_arrange_viewing_is'] = esc_html__('Your arrange viewing is ', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewing_detail_mark_read'] = esc_html__('Mark arrange viewing Read', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewing_detail_mark_unread'] = esc_html__('Mark arrange viewing Unread', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewing_unread'] = esc_html__('The arrange viewing has been marked as unread.', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewing_read'] = esc_html__('The arrange viewing has been marked as read.', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewing_detail_date'] = esc_html__('Date', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewing_detail_name'] = esc_html__('Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewing_detail_phone'] = esc_html__('Phone Number', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewing_detail_email'] = esc_html__('Email', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewing_detail_msg'] = esc_html__('Message', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewing_detail_'] = esc_html__('Please', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewing_status_changed'] = esc_html__('Arrange viewing status has been changed.', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewing_status_closed'] = esc_html__('Your arrange viewing has been closed.', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewing_detail_procceing'] = esc_html__('Processing', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewing_detail_completed'] = esc_html__('Completed', 'wp-rem');
            $wp_rem_static_text['wp_rem_arrange_viewing_detail_closed'] = esc_html__('Closed', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_delete_selected_backup_file'] = esc_html__('This action will delete your selected Backup File. Do you still want to continue?', 'wp-rem');

            // End Arrange Viewing.
            /*
             * search Modern
             */

            $wp_rem_static_text['wp_rem_property_search_view_enter_kywrd'] = esc_html__('Enter Your Keyword', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_view_enter_kywrd_label'] = esc_html__('Keyword', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_view_enter_location_label'] = esc_html__('Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_view_enter_type_label'] = esc_html__('Select Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_view_enter_property_type_label'] = esc_html__('Property Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_view_label_color'] = esc_html__('Label Color', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_view_label_color_hint'] = esc_html__('Select a color for search fields labels(modern view only).', 'wp-rem');
            
            $wp_rem_static_text['wp_rem_property_view_element_seperator'] = esc_html__('Element Seperator', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_view_element_seperator_hint'] = esc_html__('Select yes/no for element title/subtitle seperator.', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_view_simplee'] = esc_html__('Simple', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_view_advancee'] = esc_html__('Advance', 'wp-rem');
            
            $wp_rem_static_text['wp_rem_texonomy_location_location_img'] = esc_html__('Location Image', 'wp-rem');
            
            $wp_rem_static_text['wp_rem_element_location_shortcode_name'] = esc_html__('REM: Locations', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_location_shortcode_options'] = esc_html__('Locations Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_location_shortcode_locations'] = esc_html__('Locations', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_location_shortcode_locations_hint'] = esc_html__('Select locations from this dropdown.', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_location_shortcode_all_locations_url'] = esc_html__('All Location URL', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_location_shortcode_all_locations_url_hint'] = esc_html__('Enter a page url to show all locations', 'wp-rem');
            
            $wp_rem_static_text['wp_rem_element_location_shortcode_styles'] = esc_html__('Styles', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_location_shortcode_styles_hint'] = esc_html__('Select a location style from this dropdown.', 'wp-rem');
            
            $wp_rem_static_text['wp_rem_element_location_shortcode_styles_simple'] = esc_html__('Simple', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_location_shortcode_styles_modern'] = esc_html__('Modern', 'wp-rem');
            
            $wp_rem_static_text['wp_rem_element_search_advance_view_placeholder_enter_word'] = esc_html__('Enter Keyword ');
            $wp_rem_static_text['wp_rem_element_search_advance_view_placeholder_ie'] = esc_html__(' i.e   Modern Apartment', 'wp-rem');
            $wp_rem_static_text['wp_rem_element_tooltip_icon_camera'] = esc_html__('Photos', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_members_slider'] = esc_html__('Grid Slider', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_places_found'] = esc_html__('found', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_places_radius'] = esc_html__('Radius', 'wp-rem');
            $wp_rem_static_text['wp_rem_map_places_put_radius_value'] = esc_html__('Put Radius value (in meters)', 'wp-rem');
			$wp_rem_static_text['wp_rem_hidden_properties'] = esc_html__('Hidden Properties', 'wp-rem');
			
            $wp_rem_static_text['wp_rem_prop_notes_notes'] = esc_html__('Notes', 'wp-rem');
            $wp_rem_static_text['wp_rem_prop_notes_add_notes'] = esc_html__('Add Notes', 'wp-rem');
            $wp_rem_static_text['wp_rem_prop_notes_notes_added'] = esc_html__('Notes added', 'wp-rem');
            $wp_rem_static_text['wp_rem_prop_notes_prop_notes_deleted'] = esc_html__('Property notes deleted.', 'wp-rem');
            $wp_rem_static_text['wp_rem_prop_notes_properties_notes'] = esc_html__('Properties Notes', 'wp-rem');
            $wp_rem_static_text['wp_rem_prop_notes_no_result_notes'] = esc_html__('No result found.', 'wp-rem');
            $wp_rem_static_text['wp_rem_prop_notes_no_500_words_allow'] = esc_html__('Text more then 500 characters not allowed.', 'wp-rem');
            $wp_rem_static_text['wp_rem_prop_notes_saved_msg'] = esc_html__('Property notes saved.', 'wp-rem');
            $wp_rem_static_text['wp_rem_prop_notes_add_notes_for'] = esc_html__('Add Notes for "%s"', 'wp-rem');
            $wp_rem_static_text['wp_rem_prop_notes_type_here'] = esc_html__('Type here...', 'wp-rem');
            $wp_rem_static_text['wp_rem_prop_notes_submit'] = esc_html__('Submit', 'wp-rem');
            $wp_rem_static_text['wp_rem_prop_notes_max_chars_allowed'] = esc_html__('Max characters allowed 500.', 'wp-rem');
            $wp_rem_static_text['wp_rem_prop_notes_some_txt_error'] = esc_html__('Please type some text first.', 'wp-rem');
            $wp_rem_static_text['wp_rem_prop_notes_show_more'] = esc_html__('Show more', 'wp-rem');
            $wp_rem_static_text['wp_rem_prop_notes_show_less'] = esc_html__('Show less', 'wp-rem');
			
            $wp_rem_static_text['wp_rem_select_pkg_img_num_more_than'] = esc_html__('You cannot upload more than', 'wp-rem');
            $wp_rem_static_text['wp_rem_select_pkg_img_num_change_pkg'] = esc_html__('images. Please change your package to upload more.', 'wp-rem');
            $wp_rem_static_text['wp_rem_select_pkg_doc_num_change_pkg'] = esc_html__('documents. Please change your package to upload more.', 'wp-rem');
            $wp_rem_static_text['wp_rem_search_element_background_colorrr'] = esc_html__('Search Background Color', 'wp-rem');
            $wp_rem_static_text['wp_rem_search_element_style_modern_v2'] = esc_html__('Modern V2', 'wp-rem');
            $wp_rem_static_text['wp_rem_search_element_style_modern_v3'] = esc_html__('Modern V3', 'wp-rem');
            
            $wp_rem_static_text['wp_rem_location_element_properties_listed'] = esc_html__('Properties Listed', 'wp-rem');
            $wp_rem_static_text['wp_rem_search_element_title_colorrr'] = esc_html__('Element Title Color', 'wp-rem');
            $wp_rem_static_text['wp_rem_location_element_style_classic'] = esc_html__('Classic', 'wp-rem');
            
            
			
			
            return $wp_rem_static_text;
        }

    }

    new wp_rem_plugin_all_strings_4;
}
