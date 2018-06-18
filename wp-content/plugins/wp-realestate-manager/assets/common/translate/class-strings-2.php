<?php

/**
 * Static string 2
 */
if ( ! class_exists('wp_rem_plugin_all_strings_2') ) {

    class wp_rem_plugin_all_strings_2 {

        public function __construct() {

            add_filter('wp_rem_plugin_text_strings', array( $this, 'wp_rem_plugin_text_strings_callback' ), 1);
        }

        public function wp_rem_plugin_text_strings_callback($wp_rem_static_text) {
            global $wp_rem_static_text;

            /*
             * property type meta
             */
            $wp_rem_static_text['wp_rem_reservation_inquires_form'] = esc_html__('Reservation / Inquiries From', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_sbmit'] = esc_html__('Submit', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_cancelaion_policy'] = esc_html__('* Cancellation Policy:', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_check_here'] = esc_html__('Check here', 'wp-rem');
            $wp_rem_static_text['wp_rem_show_all_feature_item'] = esc_html__('Show all Feature Options', 'wp-rem');
			$wp_rem_static_text['wp_rem_show_only_checked_features'] = esc_html__('Show only checked Features', 'wp-rem');
            $wp_rem_static_text['wp_rem_show_all_feature_item_desc'] = esc_html__('If you turn on this option then all feature option will be show on property detail page with checked / un-checked value, but if you turned off this option then only checked feature options will be show at property detail page.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_delete_row'] = esc_html__('Delate Row', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_parent'] = esc_html__('Parent', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_property_price'] = esc_html__('Property Price', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_property_price_options'] = esc_html__('Price options', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_property_price_type'] = esc_html__('Price Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_property_price_type_fixed'] = esc_html__('Fixed', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_property_price_type_varient'] = esc_html__('Varient', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_minimum_options_filter'] = esc_html__('Minimum', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_minimum_options_filter_desc'] = esc_html__('This will be the minimum option on the search filters for price.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_maximum_options_filter'] = esc_html__('Maximum', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_maximum_options_filter_desc'] = esc_html__('This will be the maximum option on the search filters for price', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_man_max_interval'] = esc_html__('Min - Max Interval', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_man_max_interval_desc'] = esc_html__('This will be the interval for the minimum and maximum options on search filters. e.g( if you have entered the interval as "50" the options will be like 1-50-100-150 .... ).', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_others'] = esc_html__('Others', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_open_house'] = esc_html__('Open House', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_allowed_extension'] = esc_html__('Allowed Types/Extensions', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_allowed_extension_desc'] = esc_html__('Select attachments files allowed types/extensions', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_walk_score'] = esc_html__('Walk Scores', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_show_more_less_desc'] = esc_html__('Show More/Less Description', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_description_length'] = esc_html__('Description Length', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_description_length_in_words'] = esc_html__('Description Length in words.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_detail_page'] = esc_html__('Views', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_detail_page_select'] = esc_html__('Select a property detail page view from this dropdown.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_detail_page_select1'] = esc_html__('View 1', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_detail_page_select2'] = esc_html__('View 2', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_detail_page_select3'] = esc_html__('View 3', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_detail_page_select4'] = esc_html__('View 4', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_df_sbheader_opt'] = esc_html__('Default Sub Header Option', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_df_sbheader_opt_desc'] = esc_html__('The selected value will be the default option for subheader while the view 3 is selected.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_sbheader_opt_map'] = esc_html__('Map', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_sbheader_opt_banner'] = esc_html__('Banner', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_sticky_navigation'] = esc_html__('Sticky Navigation', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_small_image'] = esc_html__('Small Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_big_iamge'] = esc_html__('Big Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_only_num_allwd'] = esc_html__('Only numbers are allowed', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_type_meta_frm_bldr_flds'] = esc_html__('Form Builder Fields', 'wp-rem');

            /*
             * transaction
             */
            $wp_rem_static_text['wp_rem_transaction_column_transaction_id'] = esc_html__('Transaction Id', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_column_date'] = esc_html__('Date', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_column_property_owner'] = esc_html__('Property Owner', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_column_order_type'] = esc_html__('Order Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_column_gateway'] = esc_html__('Payment Gateway', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_column_amount'] = esc_html__('Amount', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_gateway_nill'] = esc_html__('Nill', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_gateway_deatil_order'] = esc_html__('Order Detail', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_post_type_name'] = esc_html__('Transactions', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_post_type_menu_name'] = esc_html__('Transactions', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_post_type_add_new_item'] = esc_html__('Add New Transaction', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_post_type_edit_item'] = esc_html__('Edit Transaction', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_post_type_new_item'] = esc_html__('New Transaction Item', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_post_type_add_new'] = esc_html__('Add New Transaction', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_post_type_view_item'] = esc_html__('View Transaction Item', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_post_type_search_item'] = esc_html__('Search', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_post_type_not_found'] = esc_html__('Nothing found', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_post_type_not_found_trash'] = esc_html__('Nothing found in Trash', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_post_type_trans_options'] = esc_html__('Transaction Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_post_type_slct_pblisher'] = esc_html__('Select Member', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_post_type_slct_pay_gateway'] = esc_html__('Select Payment Gateway', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_slct_paymnt_gateway'] = esc_html__('Select Payment Gateway', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_meta_trans_id'] = esc_html__('Transaction Id', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_meta_order_id'] = esc_html__('Order Id', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_meta_summary'] = esc_html__('Summary', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_meta_order_type'] = esc_html__('Order Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_meta_slct_order_type'] = esc_html__('Select Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_meta_packages_order'] = esc_html__('Packages Order', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_meta_reservation_order'] = esc_html__('Reservation Order', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_meta_user'] = esc_html__('User', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_meta_amount'] = esc_html__('Amount', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_meta_payment_gateway'] = esc_html__('Payment Gateway', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_meta_status'] = esc_html__('Status', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_meta_status_pending'] = esc_html__('Pending', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_meta_status_in_process'] = esc_html__('In Process', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_meta_status_approved'] = esc_html__('Approved', 'wp-rem');
            $wp_rem_static_text['wp_rem_transaction_meta_status_cancelled'] = esc_html__('Cancelled', 'wp-rem');
            /*
             * Plugin options
             */
            $wp_rem_static_text['wp_rem_plugin_options_save_all_settings'] = esc_html__('Save All Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_reset_all_options'] = esc_html__('Reset All Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_please_wait'] = esc_html__('Please Wait...', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_general_options'] = esc_html__('General Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_member_settings'] = esc_html__('Account Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_single_property_settings'] = esc_html__('Single Property Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_property_submission'] = esc_html__('Property Submission', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_gateways'] = esc_html__('Payment Setting', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_api_settings'] = esc_html__('Api Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_settings'] = esc_html__('Map Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_nearby_place'] = esc_html__('Map Nearby Places', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_location_settings'] = esc_html__('Locations Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_auto_post'] = esc_html__('Social Networks Auto-Poster', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_icon'] = esc_html__('Social Icon', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_login'] = esc_html__('Social Login', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_login_announcement'] = __('Our free Social Login tool makes it easy for website and mobile users to easily register and log in on your site with their social network identities.[<a onclick="toggleDiv(this.hash);return false;" href="#tab-api-setting">Configure your social network account</a>]', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_ads_management'] = esc_html__('Ads Management', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_generl_options'] = esc_html__('General Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_user_hdr_lgn'] = esc_html__('User Header Login', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_user_hdr_lgn_hint'] = esc_html__('Dashboard and Front-End login/register option can be hide by turning off this switch.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_member_dashboard'] = esc_html__('Account Page', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_member_dashboard_hint'] = esc_html__('Select page for member dashboard here. This page is set in page template drop down. To create member dashboard page, go to Pages > Add new page, set the page template to "member" in the right menu.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_create_property_btn_switch'] = esc_html__('Create Property Button Switch', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_create_property_btn_switch_hint'] = esc_html__('Turn this switch "ON" to show create property button in header otherwise switch it off ', 'wp-rem');
			$wp_rem_static_text['wp_rem_plugin_options_create_property_pge'] = esc_html__('Property Submission Page ', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_create_property_pge_hint'] = esc_html__('Select property submission page.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_dashboard_pagination'] = esc_html__('User Account Pagination', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_dashboard_paginationsz'] = esc_html__('Pagination', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_pkgs_detail_page'] = esc_html__('Price Plan Checkout Page', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_pkgs_detail_page_hint'] = esc_html__('Please select a page for package details. This page is set in page template drop down. To create member dashboard page, go to Pages > Add new page, set the page template to "member" in the right menu.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_property_settings'] = esc_html__('Page Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_free_property_posting'] = esc_html__('Free Properties Posting', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_property_expiray_duration'] = esc_html__('Properties Expiry Duration ( Days )', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_property_expiray_duration_hint'] = esc_html__('', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_single_property_gall_cntct'] = esc_html__('Single Property Gallery & Contact', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_single_property_gall_cntct_hint'] = esc_html__('Choose single property gallery & contact display option.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_single_listng_bread_crum'] = esc_html__('Single Property Breadcrumbs', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_single_listng_bread_crum_hint'] = esc_html__('Choose whether to show breadcrumbs on property detail page or not.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_submissions'] = esc_html__('Submissions', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_search_result'] = esc_html__('Advance Search Result Page', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_search_result_hint'] = esc_html__('Set the specific page where you want to show search results. The slected page must have properties page element on it. (Add properties page element while creating the property search result page).', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_property_publish_pend'] = esc_html__('Property Default Status', 'wp-rem');
			$wp_rem_static_text['wp_rem_plugin_options_select_compare_page'] = esc_html__('Compare Result Page', 'wp-rem');
			$wp_rem_static_text['wp_rem_plugin_options_select_compare_page_hint'] = esc_html__('Select compare page. All properties added in compare will list here. This page must have compare shortcode in it.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_property_publish_pend_hint'] = esc_html__('Turn this switcher OFF to allow direct publishing of submitted properties by member without review / moderation. If this switch is ON, properties will be published after admin review / moderation.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_announcments'] = esc_html__('Announcements', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_announcement_title_dshbrd'] = esc_html__('Announcement Heading', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_announcement_title_dshbrd_hint'] = esc_html__('Please add text for announcement title that shows at user dashboard ', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_announcement_desc_dashboard'] = esc_html__('Announcement', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_announcement_desc_dashboard_hint'] = esc_html__('Please add text for announcement description that shows at user dashboard .', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_announcement_title_property'] = esc_html__('Announcement Title For Property', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_announcement_title_property_hint'] = esc_html__('Please add text for announcement title that shows at property page .', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_announcement_desc_property'] = esc_html__('Announcement Description For Property', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_announcement_desc_property_hint'] = esc_html__('Please add text for announcement description that shows at property page .', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_announcement_bg_color'] = esc_html__('Announcement Background Color', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_environmental_text'] = esc_html__(' Instructions Heading', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_environmental_text_hint'] = esc_html__('Please add text shows at property page .', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_environmental_desc'] = esc_html__('Instructions', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_environmental_desc_hint'] = esc_html__('Please add text shows at property page ', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_yelp_places_cats'] = esc_html__('Yelp Places Categories', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_yelp_places'] = esc_html__('Yelp Places', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_default_mortgage'] = esc_html__('Default Mortgage', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_mortgage_std'] = esc_html__('Mortgage Calculator', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_min_lease_yr'] = esc_html__('Minimum Lease Year', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_max_lease_yr'] = esc_html__('Maximim Lease Year', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_dflt_lstng_cs_field'] = esc_html__('Default Properties Custom Fields', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_property_cs_field'] = esc_html__('Property Property Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_no_cus_fiels'] = esc_html__(' No of Property Features for Property Medium', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_terms_policy'] = esc_html__('Terms & Policy', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_terms_plicy_onoff'] = esc_html__('Term & Policy On/Off', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_terms_plicy_onoff_hint'] = esc_html__('Turn on if you need to add term & policy check in all forms.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_term_policy_descr'] = esc_html__('Term & Policy Description', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_term_policy_descr_hint'] = esc_html__('Please add text for term & policy with link', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_auto_apporal'] = esc_html__('User Auto Approval', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_auto_apporal_hint'] = esc_html__('If this switch set to ON new user will be auto approved. If switch is set to OFF admin will have to approve the new user.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_profile_image'] = esc_html__('User Default Avatars', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_profile_image_desc'] = esc_html__('Add New Avatar', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_dflt_plac_hldr'] = esc_html__('Default Avatar Placeholder', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_member_type'] = esc_html__('Member Types', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_fixed_price_option'] = esc_html__('Fixed Price Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_price_option'] = esc_html__('Price Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_gateway_settings'] = esc_html__('Payment Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_vat_onoff'] = esc_html__('VAT On/Off', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_vat_onoff_hint'] = esc_html__('This switch will control VAT calculation and its payment along with package price. If this switch will be ON, user must have to pay VAT percentage separately. Turn OFF the switch to exclude VAT from payment.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_vat_in_percent'] = esc_html__('VAT in %', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_vat_in_percent_hint'] = esc_html__('Here you can add VAT percentage according to your country laws & regulations.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_woocommerece_pat_gateway'] = esc_html__('Woocommerce Payment Gateways', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_woocommerece_pat_gateway_hint'] = esc_html__('Make it on to use the woocommerce payment gateways instead of builtin ones', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_currency_position'] = esc_html__('Currency Position', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_currency_position_hint'] = esc_html__('You can control the position of the currency sign.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_currency_position_left'] = esc_html__('Left', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_currency_position_right'] = esc_html__('Right', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_currency_position_left_space'] = esc_html__('Left with space', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_currency_position_right_space'] = esc_html__('Right with space', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_payment_text'] = esc_html__('Payment Text', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_default_location'] = esc_html__('Default Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_default_location_hint'] = esc_html__('Default Location Set default location for your site. This location can be set from Properties > Locations in back end admin area. This will show location of admin only. It is not linked with Geo-location.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_marker_icon'] = esc_html__('Map Marker Icon', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_cluster_icon'] = esc_html__('Map Cluster Icon', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_slider_view_icon'] = esc_html__('Map Slider View Icon', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_view_icon'] = esc_html__('Map View Icon', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_street_view_icon'] = esc_html__('Map Street View Icon', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_zoom_level'] = esc_html__('Zoom Level', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_zoom_level_hint'] = esc_html__('Set zoom level 1 to 15 only.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style'] = esc_html__('Map Style', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style_hint'] = esc_html__('Set Map Style.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style_map_box'] = esc_html__('Map Box', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style_blue_water'] = esc_html__('Blue Water', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style_icy_blue'] = esc_html__('Icy Blue', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style_bluish'] = esc_html__('Bluish', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style_light_blue_water'] = esc_html__('Light Blue Water', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style_clad_me'] = esc_html__('Clad Me', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style_chilled'] = esc_html__('Chilled', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style_two_tone'] = esc_html__('Two Tone', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style_light_and_dark'] = esc_html__('Light and Dark', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style_illusttracioa'] = esc_html__('Ilustracao', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style_flat_pale'] = esc_html__('Flat Pale', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style_title'] = esc_html__('Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style_moret'] = esc_html__('Moret', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style_semisel'] = esc_html__('Samisel', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style_herbert_map'] = esc_html__('Herbert Map', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style_light_dream'] = esc_html__('Light Dream', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style_blue_essence'] = esc_html__('Blue Essence', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_style_rpn_map'] = esc_html__('RPN Map', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_street_address'] = esc_html__('Address', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_street_address_hint'] = esc_html__('Set default street address here.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_col_hdng_dflt_location_hint'] = esc_html__('Set default location for your site (Country, City & Address). This location can be set from Properties > Locations in back end admin area. This will show location of admin only and willl fetch results from the given location first. It is not linked with Geo-location', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_backend_loc_map_stng'] = esc_html__('Backend Locations & Maps Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_backend_locations'] = esc_html__('Locations', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_backend_loc_and_level'] = esc_html__('Location\'s Levels', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_backend_geo_loc'] = esc_html__('Geo Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_backend_geo_loc_share'] = esc_html__('Ask user to share his location.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_backend_auto_country_detection'] = esc_html__('Auto Country Detection', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_backend_auto_country_detection_hint'] = esc_html__('Do you want to detect country automatically using user\'s IP?', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_backend_max_adrs_lmt'] = esc_html__('Address Maximum Text Limit', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_backend_max_adrs_lmt_hint'] = esc_html__('Allowed address maximum text limit.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_backend_drawing_tools'] = esc_html__('Drawing Tools', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_backend_drawing_tools_hint'] = esc_html__('Do you want drawing tools on map?', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_drawing_tool_line_clr'] = esc_html__('Drawing Tools Line Color', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_drawing_tool_line_clr_hint'] = esc_html__('Color used while drawing line or polygon on map', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_drawing_tool_fill_clr'] = esc_html__('Drawing Tools Fill Color', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_drawing_tool_fill_clr_hint'] = esc_html__('Color used to fill polygon on map.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_drawing_tool_auto_cmplte'] = esc_html__('Auto Complete', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_drawing_tool_auto_cmplte_hint'] = esc_html__('Do you want google to give suggestions to auto complete?', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_circle_radius'] = esc_html__('Circle Radius', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_loc_frm_fields'] = esc_html__('Location Form Fields', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_loc_fields'] = esc_html__('Location\'s Fields', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_map_nearby_place_hint'] = esc_html__('Define labels and images to show nearby places on Google Maps.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_auto_post_stng'] = esc_html__('Social Auto Post Settings', 'wp-rem');

            $wp_rem_static_text['wp_rem_plugin_options_autopost_twitter'] = esc_html__('Twitter', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_autopost_announcement'] = __('Social Network Auto Poster lets you automatically post all new Submitted properties  to social networks such as Facebook, Twitter, LinkedIn. The whole process is completely automated. Just add new property from front-end and it will be published to your configured social network account. You can reach the most audience and tell all your  readers and followers about Property. [<a onclick="toggleDiv(this.hash);return false;" href="#tab-api-setting">Configure your social network account</a>]', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_autopost_facebook'] = esc_html__('Facebook', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_autopost_linkedin'] = esc_html__('LinkedIn', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_login_twitter'] = esc_html__('Show Twitter', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_login_twitter_hint'] = esc_html__('Manage user registration via Twitter here. If this switch is set ON, users will be able to sign up / sign in with Twitter. If it will be OFF, users will not be able to register / sign in through Twitter.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_login_facebook'] = esc_html__('Facebook Login On/Off', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_login_facebook_hint'] = esc_html__('Manage user registration via Facebook here. If this switch is set ON, users will be able to sign up / sign in with Facebook. If it will be OFF, users will not be able to register / sign in through Facebook.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_login_google'] = esc_html__('Google+ Login On/Off', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_login_google_hint'] = esc_html__('Manage user registration via Google+ here. If this switch is set ON, users will be able to sign up / sign in with Google+. If it will be OFF, users will not be able to register / sign in through Google+.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_api_setting'] = esc_html__('Api Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_api_setting_twitter'] = esc_html__('Twitter', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_twitter_cons_key'] = esc_html__('Consumer Key', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_twitter_cons_key_hint'] = esc_html__('Insert Twitter Consumer Key here. When you create your Twitter App, you will get this key.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_twitter_cons_secret'] = esc_html__('Consumer Secret', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_twitter_cons_secret_hint'] = esc_html__('Insert Twitter Consumer secret here. When you create your Twitter App, you will get this key', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_twitter_access_token'] = esc_html__('Access Token', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_twitter_access_token_hint'] = esc_html__('Insert Twitter Access Token for permissions. When you create your Twitter App, you will get this Token', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_twitter_access_token_secret'] = esc_html__('Access Token Secret', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_twitter_access_token_secret_hint'] = esc_html__('Insert Twitter Access Token Secret here. When you create your Twitter App, you will get this Token', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_api_settings_facebook'] = esc_html__('Facebook', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_facebook_app_id'] = esc_html__('Facebook Application ID', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_facebook_app_id_hint'] = esc_html__('Here you have to add your Facebook application ID. You will get this ID when you create Facebook App', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_facebook_secret'] = esc_html__('Facebook Secret', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_facebook_secret_hint'] = esc_html__('Put your Facebook Secret here. You can find it in your Facebook Application Dashboard', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_facebook_access_token'] = esc_html__('Facebook Access Token', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_facebook_access_token_hint'] = esc_html__('Click on the button bellow to get access token', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_api_settings_google'] = esc_html__('Google', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_google_client_id'] = esc_html__('Google+ Client ID', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_google_client_id_hint'] = esc_html__('Put your Google+ client ID here.  To get this ID, go to your Google+ account Dashboard', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_google_client_secret'] = esc_html__('Google+ Client Secret', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_google_client_secret_hint'] = esc_html__('Put your google+ client secret here.  To get client secret, go to your Google+ account', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_google_api_key'] = esc_html__('Google+ API key', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_google_api_key_hint'] = esc_html__('Put your Google+ API key here.  To get API, go to your Google+ account', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_google_redirect'] = esc_html__('Fixed redirect url for login', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_google_redirect_hint'] = esc_html__('Put your google+ redirect url here', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_api_setting_captcha'] = esc_html__('reCaptcha', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_api_setting_captcha_hint'] = esc_html__('Manage your captcha code for secured Signup here. If this switch will be ON, user can register after entering Captcha code. It helps to avoid robotic / spam sign-up', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_captcha_site_key'] = esc_html__('Site Key', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_captcha_site_key_hint'] = esc_html__('Put your site key for captcha. You can get this site key after registering your site on Google', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_captcha_secret_key'] = esc_html__('Secret Key', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_captcha_secret_key_hint'] = esc_html__('Put your site Secret key for captcha. You can get this Secret Key after registering your site on Google.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_api_setting_linkedin'] = esc_html__('LinkedIn', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_linkedin_app_id'] = esc_html__('LinkedIn Application Id', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_linkedin_app_id_hint'] = esc_html__('Add LinkedIn application ID. To get your Linked-in Application ID, go to your LinkedIn Dashboard', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_linkedin_secret'] = esc_html__('Linkedin Secret', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_linkedin_secret_hint'] = esc_html__('Put your LinkedIn Secret here. You can find it in your LinkedIn Application Dashboard', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_linkedin_access_token'] = esc_html__('Linkedin Access Token', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_linkedin_access_token_hint'] = esc_html__('Click on the button bellow to get access token', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_api_setting_yelp'] = esc_html__('Yelp', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_yelp_app_id'] = esc_html__('Yelp App ID', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_yelp_app_id_hint'] = esc_html__('Add Yelp application ID. To get your Yelp Application ID, go to your Yelp Account.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_yelp_app_secret'] = esc_html__('Yelp App Secret', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_yelp_app_secret_hint'] = esc_html__('Put your Yelp App Secret here. You can find it in your Yelp Application Dashboard', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_yelp_access_token'] = esc_html__('Yelp Access Token', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_yelp_access_token_hint'] = esc_html__('Click on the button bellow to get access token.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_api_setting_walk_score'] = esc_html__('Walk Score', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_walk_score_app_id'] = esc_html__('Walk Score API Key', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_walk_score_app_id_hint'] = esc_html__('Add Walk Score API key. To get your Walk Score API key, go to your Walk Score Account.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_ads_management_settings'] = esc_html__('Ads Management Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_sharing'] = esc_html__('Social Sharing', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_sharing_facebook'] = esc_html__('Facebook', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_sharing_twitter'] = esc_html__('Twitter', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_sharing_google_plus'] = esc_html__('Google Plus', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_sharing_pinterest'] = esc_html__('Pinterest', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_sharing_tumbler'] = esc_html__('Tumblr', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_sharing_dribble'] = esc_html__('Dribbble', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_sharing_instagram'] = esc_html__('Instagram', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_sharing_stumble_upon'] = esc_html__('StumbleUpon', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_sharing_youtube'] = esc_html__('youtube', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_social_sharing_share_more'] = esc_html__('share more', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_import_export'] = esc_html__('import & export', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_backup'] = esc_html__('Backup', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_user_import_export'] = esc_html__('Users Import / Export', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_import_user_data'] = esc_html__('Import Users Data', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_backup_locations'] = esc_html__('Backup Locations', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_backup_property_type_cats'] = esc_html__('Backup Property Type Categories', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_adv_settings'] = esc_html__('Advance Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_demo_user_login'] = esc_html__('Demo User Login', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_slct_agency'] = esc_html__('Please Select Agency', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_slct_member'] = esc_html__('Please Select Member', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_demo_member'] = esc_html__('Member', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_demo_member_hint'] = esc_html__('Please select a user for member login', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_demo_agency'] = esc_html__('Agency', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_demo_agency_hint'] = esc_html__('Please select a user for agency login', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_enquires_arrange_viewings'] = esc_html__('Enquiries/Arrange Viewings', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_enquires_arrange_viewings_status'] = esc_html__('Enquiries/Arrange Viewings Status', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_enquires_arrange_viewings_status_desc'] = esc_html__('Add Enquiries/Arrange Viewings Status', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_fields_download'] = esc_html__('Download', 'wp-rem');

            /*
             * Plugin Settings
             */
            $wp_rem_static_text['wp_rem_plugin_seetings_rem_settings'] = esc_html__('WP REM Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_add_package'] = esc_html__('Add Package', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_title'] = esc_html__('Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_action'] = esc_html__('Actions', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_package_settings'] = esc_html__('Package Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_package_title'] = esc_html__('Package Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_package_price'] = esc_html__('Price', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_package_price_hint'] = esc_html__('Enter price here.', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_package_type'] = esc_html__('Package Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_package_type_single'] = esc_html__('Single Submission', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_package_type_subcription'] = esc_html__('Subscription', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_num_of_properties'] = esc_html__('No of Properties in Package', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_num_of_cvs'] = esc_html__('No of CV\'s', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_package_expiray'] = esc_html__('Package Expiry', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_package_day'] = esc_html__('Days', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_package_months'] = esc_html__('Months', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_package_years'] = esc_html__('Years', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_property_expiray'] = esc_html__('Properties Expiry', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_property_days'] = esc_html__('Days', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_property_months'] = esc_html__('Months', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_property_years'] = esc_html__('Years', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_package_feature'] = esc_html__('Package Featured', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_package_feature_no'] = esc_html__('No', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_package_feature_yes'] = esc_html__('Yes', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_package_desc'] = esc_html__('Description', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_add_package_to_list'] = esc_html__('Add Package to List', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_price_edit'] = esc_html__('Price edit', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_price_edit_hint'] = esc_html__('Enter price here', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_update_package'] = esc_html__('Update Package', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_alrady_exists_error'] = esc_html__('This feature "%s" is already exist. Please create with another Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_extrs_feature_setting'] = esc_html__('Extra Feature Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_extra_feature_title'] = esc_html__('Extra Feature Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_extra_feature_price'] = esc_html__('Price', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_extra_feature_type'] = esc_html__('Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_extra_feature_type_none'] = esc_html__('None', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_extra_feature_type_one_time'] = esc_html__('One Time', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_extra_feature_type_daily'] = esc_html__('Daily', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_extra_feature_guests'] = esc_html__('Guests', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_extra_feature_guests_none'] = esc_html__('None', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_extra_feature_guests_per_head'] = esc_html__('Per head', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_extra_feature_guests_group'] = esc_html__('Group', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_frontend_changeable'] = esc_html__('Frontend Changeable', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_extra_feature_description'] = esc_html__('Description', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_extra_feature_update'] = esc_html__('Update Extra Feature', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_feature_stng'] = esc_html__('Feature Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_feature_titl'] = esc_html__('Feature Title', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_feature_image'] = esc_html__('Image', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_upd_feature'] = esc_html__('Update Feature', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_extra_feature_please_wait'] = esc_html__('Please wait...', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_extra_feature_load_icon'] = esc_html__('Load Icon', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_extra_feature_try_again'] = esc_html__('Try Again', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_seetings_extra_feature_load_json'] = esc_html__('Load Json', 'wp-rem');

            /*
             * clasas ordere detail
             */
            $wp_rem_static_text['wp_rem_enquiry_detail_mark_enquiry_read'] = esc_html__('Mark Enquiry Read', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_mark_enquiry_unread'] = esc_html__('Mark Enquiry Unread', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_procceing'] = esc_html__('Processing', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_completed'] = esc_html__('Completed', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_closed'] = esc_html__('Closed', 'wp-rem');
            $wp_rem_static_text['wp_rem_order_detail_orders'] = esc_html__('Orders', 'wp-rem');
            $wp_rem_static_text['wp_rem_order_detail_order'] = esc_html__('Order', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_enquires'] = esc_html__('Enquiries', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_enquiry'] = esc_html__('Enquiry', 'wp-rem');
            $wp_rem_static_text['wp_rem_order_detail_req_delievery'] = esc_html__('Req. Delivery:', 'wp-rem');
            $wp_rem_static_text['wp_rem_order_detail_created'] = esc_html__('Created:', 'wp-rem');
            $wp_rem_static_text['wp_rem_order_detail_type'] = esc_html__('Type :', 'wp-rem');
            $wp_rem_static_text['wp_rem_order_detail_paymeny_status'] = esc_html__('Payment Status:', 'wp-rem');
            $wp_rem_static_text['wp_rem_order_detail_order_detail'] = esc_html__('Order Detail', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_inquiry_detail'] = esc_html__('Enquiry Detail', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_custom_detail'] = esc_html__('Customer Detail', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_custom_name'] = esc_html__('Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_custom_phone_num'] = esc_html__('Phone Number', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_custom_email'] = esc_html__('Email', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_custom_address'] = esc_html__('Address', 'wp-rem');
            $wp_rem_static_text['wp_rem_order_detail_service_name'] = esc_html__('Service Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_order_detail_quantity'] = esc_html__('Quantity', 'wp-rem');
            $wp_rem_static_text['wp_rem_order_detail_net'] = esc_html__('Net', 'wp-rem');
            $wp_rem_static_text['wp_rem_order_detail_amount'] = esc_html__('Amount', 'wp-rem');
            $wp_rem_static_text['wp_rem_order_detail_total'] = esc_html__('Total', 'wp-rem');
            $wp_rem_static_text['wp_rem_order_detail_order_status'] = esc_html__('Order Status', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_enquiry_status'] = esc_html__('Enquiry Status', 'wp-rem');
            $wp_rem_static_text['wp_rem_order_detail_ur_order_completed'] = esc_html__('Your order is completed', 'wp-rem');
            $wp_rem_static_text['wp_rem_order_detail_closed_order'] = esc_html__('Close Order.', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_ur_enquiry_completed'] = esc_html__('Your enquiry is completed.', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_closed_enquiry'] = esc_html__('Close Enquiry', 'wp-rem');
            $wp_rem_static_text['wp_rem_order_detail_ur_order_is'] = esc_html__('Your order is ', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_ur_enquiry_is'] = esc_html__('Your enquiry is ', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_post_ur_msg'] = esc_html__('Post Your Message', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_message_here'] = esc_html__('Message here...', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_send_msg'] = esc_html__('Send Message', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_name'] = __('Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_phone'] = __('Phone Number', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_email'] = __('Email', 'wp-rem');
            $wp_rem_static_text['wp_rem_enquiry_detail_msg'] = __('Message', 'wp-rem');

            /*
             * properties php
             */
            $wp_rem_static_text['wp_rem_property_php_tag_name'] = esc_html__('Tags', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_tag_singular_name'] = esc_html__('Tag', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_tag_search_item'] = esc_html__('Tags', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_tag_all_item'] = esc_html__('All Tags', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_tag_prent_iem'] = esc_html__('Parent Tag', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_tag_edit_item'] = esc_html__('Edit Tag', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_tag_update_item'] = esc_html__('Update Tag', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_tag_add_new_item'] = esc_html__('Add New Tag', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_tag_new_item_name'] = esc_html__('New Tag Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_tag_menu_name'] = esc_html__('Tags', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_error_svng_file'] = esc_html__('Error saving file!', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_bkup_generated'] = esc_html__('Backup Generated', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_file_del_successfully'] = esc_html__('File "%s" Deleted Successfully', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_error_deleting_file'] = esc_html__('Error Deleting file!', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_file_restore_success'] = esc_html__('File "%s" Restored Successfully', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_error_restoring_file'] = esc_html__('Error Restoring file!', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_total_ads'] = esc_html__('Total Ads', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_active_ads'] = esc_html__('Active Ads', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_expire_ads'] = esc_html__('Expire ads', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_free_ads'] = esc_html__('Free Ads', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_paid_ads'] = esc_html__('Paid Ads', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_php_file_import_successfully'] = esc_html__('File Imported Successfully', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_add'] = esc_html__('REM : Banner Ads', 'wp-rem');
            $wp_rem_static_text['wp_rem_banner_add_desc'] = esc_html__('WP Real Estate Manager Banner Ads', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_widget'] = esc_html__('REM : Locations', 'wp-rem');
            $wp_rem_static_text['wp_rem_locations_widget_desc'] = esc_html__('WP Real Estate Manager Locations', 'wp-rem');
            $wp_rem_static_text['wp_rem_top_properties_widget'] = esc_html__('REM : Top Properties', 'wp-rem');
            $wp_rem_static_text['wp_rem_top_properties_widget_desc'] = esc_html__('To show Top Properties in widget.', 'wp-rem');
            $wp_rem_static_text['wp_rem_top_properties_widget_sorry'] = esc_html__('Sorry', 'wp-rem');
            $wp_rem_static_text['wp_rem_top_properties_widget_dosen_match'] = esc_html__('No Property match your search criteria.', 'wp-rem');
            $wp_rem_static_text['wp_rem_social_login_error'] = esc_html__('ERROR', 'wp-rem');
            $wp_rem_static_text['wp_rem_social_login_reg_disable'] = esc_html__('Registration is disabled.', 'wp-rem');
            $wp_rem_static_text['wp_rem_social_login_smthng_went_wrong'] = esc_html__('Something went wrong: %s', 'wp-rem');
            $wp_rem_static_text['wp_rem_social_login_login_error'] = esc_html__('Login error', 'wp-rem');
            $wp_rem_static_text['wp_rem_social_login_google_connect'] = esc_html__('This Google profile is already linked with other account. Linking process failed!', 'wp-rem');
            $wp_rem_static_text['wp_rem_search_filter_min_price'] = esc_html__('Min Price', 'wp-rem');
            $wp_rem_static_text['wp_rem_search_filter_max_price'] = esc_html__('Max Price', 'wp-rem');
            $wp_rem_static_text['wp_rem_search_filter_any_price'] = esc_html__('Any Price', 'wp-rem');
            $wp_rem_static_text['wp_rem_search_filter_property_type'] = esc_html__('Property Type', 'wp-rem');

            /*
             * member dashboard
             */
            $wp_rem_static_text['wp_rem_member_dashboard_dashboards_name'] = esc_html__('Members Dashboard', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_dashboard_property_mont_statics'] = esc_html__('Property Monthly Statistic', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_dashboard_top_member'] = esc_html__('Top  %d Members', 'wp-rem');
            $wp_rem_static_text['wp_rem_tp_members_widget_name'] = esc_html__('REM : Top Member', 'wp-rem');
            $wp_rem_static_text['wp_rem_tp_members_widget_desc'] = esc_html__('To show Top Member in widget', 'wp-rem');
            $wp_rem_static_text['wp_rem_tp_members_widget_properties'] = esc_html__('Property(s)', 'wp-rem');
            $wp_rem_static_text['wp_rem_tp_members_widget_sorry'] = esc_html__('Sorry', 'wp-rem');
            $wp_rem_static_text['wp_rem_tp_members_widget_no_member_match'] = esc_html__('No Member match your search criteria', 'wp-rem');
            $wp_rem_static_text['wp_rem_form_fields_brows'] = esc_html__('Browse', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branches_type_address'] = esc_html__('Type Your Address', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branches_latitude'] = esc_html__('Latitude', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branches_longitude'] = esc_html__('Longitude', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branches_search_loc'] = esc_html__('Search Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branches_prvd_name'] = esc_html__('Please provide name', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branches_prvd_email'] = esc_html__('Please provide email address', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branches_prvd_vlid_email'] = esc_html__('Please provide valid email address', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branches_added_success'] = esc_html__('Branch added successfully', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branches_update_success'] = esc_html__('Branch updated successfully', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branches_name'] = esc_html__('Name', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branches_phone'] = esc_html__('Phone', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branches_email'] = esc_html__('Email', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branches_add'] = esc_html__('Add', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branches_update'] = esc_html__('Update', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branches_cancel'] = esc_html__('Cancel', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branches_removed_success'] = esc_html__('Branch Successfully Removed', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branches_branches'] = esc_html__('Branches', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_branches_add_branches'] = esc_html__('Add Branches', 'wp-rem');
            $wp_rem_static_text['wp_rem_tp_members_find_on_map'] = esc_html__('Find On Map', 'wp-rem');
            $wp_rem_static_text['wp_rem_tp_members_drag_drop_pin'] = esc_html__('For the precise location, you can drag and drop the pin.', 'wp-rem');
            $wp_rem_static_text['wp_rem_tp_members_ad_branch'] = esc_html__('Add Branch', 'wp-rem');
            $wp_rem_static_text['wp_rem_tp_members_upd_branch'] = esc_html__('Update Branch', 'wp-rem');
            $wp_rem_static_text['wp_rem_members_company_upload'] = esc_html__('Upload', 'wp-rem');
            $wp_rem_static_text['wp_rem_members_company_update'] = esc_html__('Update', 'wp-rem');
            $wp_rem_static_text['wp_rem_members_company_update_team_member'] = esc_html__('Update Team Member', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_wp'] = esc_html__('WP REM', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_alerts_email'] = esc_html__('Alerts / Emails', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_role_title'] = esc_html__('Real Estate Member', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_property_type'] = esc_html__('Property Type', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_serveice_addeed'] = esc_html__('Service added to list.', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_floor_plan_added'] = esc_html__('Floor plan added to list.', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_near_by_added'] = esc_html__('Nearby added to list.', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_attachment_added'] = esc_html__('Attachment added to list.', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_apartment_added'] = esc_html__('Apartment added to list.', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_off_day_added'] = esc_html__('Off day added to list.', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_buy_exists_pkg'] = esc_html__('Use existing package', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_buy_new_pkg'] = esc_html__('Buy new package', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_off_day_already_added'] = esc_html__('This date is already added in off days list.', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_upload_images'] = esc_html__('Please upload images only', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_action_error'] = esc_html__('Error! There is some Problem.', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_compulsory_fields'] = esc_html__('Please fill the compulsory fields first.', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_payment_text'] = esc_html__('Review', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_sbmit_order'] = esc_html__('Submit Order', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_update_text'] = esc_html__('Update', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_create_list_text'] = esc_html__('Create Property', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_property_updated'] = esc_html__('Property Updated', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_property_created'] = esc_html__('Property Created.', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_valid_price_error'] = esc_html__('Please enter valid price.', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_detail_text'] = esc_html__('Detail', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_close_text'] = esc_html__('Close', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_accept'] = esc_html__('Accept', 'wp-rem');
            $wp_rem_static_text['wp_rem_rem_terms_and_conditions'] = esc_html__('Terms and conditions', 'wp-rem');

            /*
             * propertysearch-list-filter
             */
            $wp_rem_static_text['wp_rem_property_search_flter_wt_looking_for'] = esc_html__('What are you looking for?', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_flter_saerch'] = esc_html__('Search', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_flter_min_price'] = esc_html__('Min Price', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_flter_max_price'] = esc_html__('Max Price', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_flter_all'] = esc_html__('All', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_flter_per_weak'] = esc_html__('Per Week', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_flter_per_caleder'] = esc_html__('Per Month', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_flter_price_options'] = esc_html__('Price Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_flter_advanced'] = esc_html__('Advanced', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_search_flter_wt_keyword'] = esc_html__('What is Keyword search?', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_slider_sorry'] = esc_html__('Sorry', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_grid_listed_on'] = esc_html__('Listed on', 'wp-rem');
			$wp_rem_static_text['wp_rem_property_hidden_heading'] = esc_html__('You have hidden %s on this page', 'wp-rem');

            $wp_rem_static_text['wp_rem_property_grid_by'] = esc_html__('by', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_slider_doesn_match'] = esc_html__('There are no properties matching your search.', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_featrd'] = esc_html__('featured', 'wp-rem');
			$wp_rem_static_text['wp_rem_property_hide'] = esc_html__('Hide', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_leftflter_property_type'] = esc_html__('Property Types', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_leftflter_all_properties'] = esc_html__('All Properties', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_leftflter_open_house'] = esc_html__('Open House', 'wp-rem');
			$wp_rem_static_text['wp_rem_property_leftflter_open_house_today_only'] = esc_html__('Today Only', 'wp-rem');
			$wp_rem_static_text['wp_rem_property_leftflter_open_house_tomorrow_only'] = esc_html__('Tomorrow Only', 'wp-rem');
			$wp_rem_static_text['wp_rem_property_leftflter_open_house_till_weekends'] = esc_html__('Till Week ends', 'wp-rem');
			$wp_rem_static_text['wp_rem_property_leftflter_open_house_upcoming_weekends'] = esc_html__('Upcoming Weekend', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_leftflter_min'] = esc_html__('Min', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_leftflter_max'] = esc_html__('Max', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_leftflter_all'] = esc_html__('All', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_leftflter_per_weak'] = esc_html__('Per Week', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_leftflter_per_calender_month'] = esc_html__('Per Month', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_leftflter_price_options'] = esc_html__('Price Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_leftflter_price'] = esc_html__('Price', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_leftflter_fron_date'] = esc_html__('From Date', 'wp-rem');
            $wp_rem_static_text['wp_rem_property_leftflter_to_date'] = esc_html__('To Date', 'wp-rem');

            /*
             * skrill
             */
            $wp_rem_static_text['wp_rem_skrill_options_on'] = esc_html__('on', 'wp-rem');
            $wp_rem_static_text['wp_rem_skrill_options_off'] = esc_html__('off', 'wp-rem');
            $wp_rem_static_text['wp_rem_skrill_money_booker_stng'] = esc_html__('Skrill-MoneyBooker Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_skrill_cistom_logo'] = esc_html__('Custom Logo', 'wp-rem');
            $wp_rem_static_text['wp_rem_skrill_default_status'] = esc_html__('Default Status', 'wp-rem');
            $wp_rem_static_text['wp_rem_skrill_default_status_hint'] = esc_html__('If this switch will be OFF, no payment will be processed via Skrill-MoneyBooker', 'wp-rem');
            $wp_rem_static_text['wp_rem_skrill_business_email'] = esc_html__('Skrill-MoneryBooker Business Email', 'wp-rem');
            $wp_rem_static_text['wp_rem_skrill_business_email_hint'] = esc_html__('Add your business Email address here to proceed Skrill-MoneryBooker payments..', 'wp-rem');
            $wp_rem_static_text['wp_rem_skrill_ipn_url'] = esc_html__('Skrill-MoneryBooker Ipn Url', 'wp-rem');
            $wp_rem_static_text['wp_rem_skrill_ipn_url_hint'] = esc_html__('Here you can add your Skrill-MoneryBooker IPN URL', 'wp-rem');
            $wp_rem_static_text['wp_rem_skrill_redirecting_to_pg'] = esc_html__('Redirecting to payment gateway website...', 'wp-rem');
            $wp_rem_static_text['wp_rem_paypal_options_on'] = esc_html__('on', 'wp-rem');
            $wp_rem_static_text['wp_rem_paypal_options_off'] = esc_html__('off', 'wp-rem');
            $wp_rem_static_text['wp_rem_paypal_settings'] = esc_html__('Paypal Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_paypal_custom_logo'] = esc_html__('Custom Logo', 'wp-rem');
            $wp_rem_static_text['wp_rem_paypal_default_status'] = esc_html__('Default Status', 'wp-rem');
            $wp_rem_static_text['wp_rem_paypal_default_status_hint'] = esc_html__('If this switch will be OFF, no payment will be processed via Paypal. ', 'wp-rem');
            $wp_rem_static_text['wp_rem_paypal_sandbox'] = esc_html__('Paypal Sandbox', 'wp-rem');
            $wp_rem_static_text['wp_rem_paypal_sandbox_hint'] = esc_html__('Control PayPal sandbox Account with this switch. If this switch is set to ON, payments will be  proceed with sandbox account.', 'wp-rem');
            $wp_rem_static_text['wp_rem_paypal_business_email'] = esc_html__('Paypal Business Email', 'wp-rem');
            $wp_rem_static_text['wp_rem_paypal_business_email_hint'] = esc_html__('Add your business Email address here to proceed PayPal payments.', 'wp-rem');
            $wp_rem_static_text['wp_rem_paypal_ipn_url'] = esc_html__('Paypal Ipn Url', 'wp-rem');
            $wp_rem_static_text['wp_rem_skrill_ipn_url_hint'] = esc_html__('Here you can add your PayPal IPN URL', 'wp-rem');
            $wp_rem_static_text['wp_rem_skrill_redirect_to_pg'] = esc_html__('Redirecting to payment gateway website...', 'wp-rem');
            $wp_rem_static_text['wp_rem_payment_bace_currency'] = esc_html__('Base Currency', 'wp-rem');
            $wp_rem_static_text['wp_rem_payment_base_currency_hint'] = esc_html__('All the transactions will be placed in this currency.', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_delete_permanently'] = esc_html__('Delete this item permanently', 'wp-rem');
            $wp_rem_static_text['wp_rem_notifications_row_delete'] = esc_html__('Delete', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_dashboard_change_pass'] = esc_html__('Change Password', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_dashboard_my_profile'] = esc_html__('My Profile', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_dashboard_Dashboard'] = esc_html__('Dashboard', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_dashboard_my_prop'] = esc_html__('My Properties', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_dashboard_orders'] = esc_html__('Orders', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_dashboard_enquires'] = esc_html__('Enquiries', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_dashboard_alerts_searches'] = esc_html__('Alerts & searches', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_dashboard_fav_prop'] = esc_html__('Favourite Properties', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_dashboard_packages'] = esc_html__('Packages', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_dashboard_account_stng'] = esc_html__('Account Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_dashboard_team_members'] = esc_html__('Team Members', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_dashboard_signout'] = esc_html__('Sign out', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_dashboard_profile_not_active'] = esc_html__('Your profile status is not active. All of your property ads will not activate until your profile status will not active.', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_dashboard_want_to_profile'] = esc_html__('You Want To Delete?', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_dashboard_delete_yes'] = esc_html__('Yes, Delete', 'wp-rem');
            $wp_rem_static_text['wp_rem_member_dashboard_delete_no'] = esc_html__('No, Cancel', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_daily'] = esc_html__('Daily', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_weekly'] = esc_html__('Weekly', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_fortnightly'] = esc_html__('Fortnightly', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_monthly'] = esc_html__('Monthly', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_biannually'] = esc_html__('Biannually', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_annually'] = esc_html__('Annually', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_never'] = esc_html__('Never', 'wp-rem');
            $wp_rem_static_text['wp_rem_last_login_never'] = esc_html__('never', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_no_email_alerts'] = esc_html__('No Email Alerts', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_summary_email'] = esc_html__('Summary Emails', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_create_email_alerts'] = esc_html__('Create email alert', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_email_save_search'] = esc_html__('Email Alerts / Save this Search', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_filter_criteria'] = esc_html__('Filters Criteria', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_all_properties'] = esc_html__('All Properties', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_enter_valid_email'] = esc_html__('Please enter a valid email', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_alert_name_title'] = esc_html__('Title *', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_email_address'] = esc_html__('Email Address *', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_alert_frequency'] = esc_html__('Alert Frequency', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_submit'] = esc_html__('Submit', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_email_template_desc'] = esc_html__('This template will be used when sending a property alert, Template will have a list of properties as per user set filters.', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_biannualy2'] = esc_html__('Bi-Annually', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_save_search'] = esc_html__('Save this search', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_unsubcribe'] = esc_html__('Unsubscribe', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_map_view_properties'] = esc_html__('View Properties', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_map_or'] = esc_html__('OR', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_map_submit'] = esc_html__('Submit', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_view_full_property'] = esc_html__('View Full Property', 'wp-rem');
            $wp_rem_static_text['wp_rem_alerts_property_found_at'] = esc_html__('New Properties Found at', 'wp-rem');

            /*
             * favourites.php
             */
            $wp_rem_static_text['wp_rem_favourite_conform_msg'] = esc_html__('Are you sure to do this?', 'wp-rem');
            $wp_rem_static_text['wp_rem_favourite_favourite'] = esc_html__('Favourites', 'wp-rem');
            $wp_rem_static_text['wp_rem_favourite_favourite_manage'] = esc_html__('Favourites Manage', 'wp-rem');
            $wp_rem_static_text['wp_rem_favourite_fav_added'] = esc_html__('Favourite added', 'wp-rem');
            $wp_rem_static_text['wp_rem_favourite_fav_removed'] = esc_html__('Favourite removed', 'wp-rem');
            $wp_rem_static_text['wp_rem_favourite_favourite_ur_property'] = esc_html__('favourite your property', 'wp-rem');
            $wp_rem_static_text['wp_rem_favourite_delete_successfully'] = esc_html__('Deleted Successfully', 'wp-rem');
            $wp_rem_static_text['wp_rem_favourite_remove_one_list'] = esc_html__(' removed one of your property from favourites.', 'wp-rem');
            $wp_rem_static_text['wp_rem_favourite_dont_have_favourite'] = esc_html__('You don\'t have any favourite properties.', 'wp-rem');
            $wp_rem_static_text['wp_rem_favourite_fav_propert'] = esc_html__('Favourite Properties', 'wp-rem');
            $wp_rem_static_text['wp_rem_favourite_dont_hav_fav_propert'] = esc_html__('You don\'t have any favourite properties.', 'wp-rem');
			
            /*
             * class bank transfer
             */
            $wp_rem_static_text['wp_rem_banktransfer_options_on'] = esc_html__('on', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_options_off'] = esc_html__('off', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_settings'] = esc_html__('Bank Transfer Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_custom_logo'] = esc_html__('Custom Logo', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_dfault_status'] = esc_html__('Default Status', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_dfault_status_hint'] = esc_html__('If this switch will be OFF, no payment will be processed via Bank Transfer', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_bank_info'] = esc_html__('Bank Information', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_bank_info_hint'] = esc_html__('Add information of your bank (Bank Name).', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_account_num'] = esc_html__('Account Number', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_account_num_hint'] = esc_html__('Add your bank account Number where you want receive payment.', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_other_info'] = esc_html__('Other Information', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_other_info_hint'] = esc_html__('In this text box, you can add any help text whatever you want to show on front end for assistance of users regarding bank payment.', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_packages'] = esc_html__('Package', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_charges'] = esc_html__('Charges', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_vat'] = esc_html__('VAT :', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_total_charge'] = esc_html__('Total Charges: ', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_order_detail'] = esc_html__('Order detail', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_order_id'] = esc_html__('Order ID', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_bank_detail'] = esc_html__('Bank detail', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_bank_detail_hint'] = esc_html__('Please transfer amount To this account, After payment Received we will process your Order', 'wp-rem');
            $wp_rem_static_text['wp_rem_banktransfer_account_no'] = esc_html__('Account No', 'wp-rem');

            /*
             * class authorize net
             */
            $wp_rem_static_text['wp_rem_aythorize_option_on'] = esc_html__('on', 'wp-rem');
            $wp_rem_static_text['wp_rem_aythorize_option_off'] = esc_html__('off', 'wp-rem');
            $wp_rem_static_text['wp_rem_aythorize_settings'] = esc_html__('Authorize.net Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_aythorize_custom_logo'] = esc_html__('Custom Logo', 'wp-rem');
            $wp_rem_static_text['wp_rem_aythorize_default_status'] = esc_html__('Default Status', 'wp-rem');
            $wp_rem_static_text['wp_rem_aythorize_default_status_hint'] = esc_html__('If this switch will be OFF, no payment will be processed via Authorize.net', 'wp-rem');
            $wp_rem_static_text['wp_rem_aythorize_sandbox'] = esc_html__('Authorize.net Sandbox', 'wp-rem');
            $wp_rem_static_text['wp_rem_aythorize_sandbox_hint'] = esc_html__('Control Authorize.net sandbox Account with this switch. If this switch is set to ON, payments will be  proceed with sandbox account.', 'wp-rem');
            $wp_rem_static_text['wp_rem_aythorize_login_id'] = esc_html__('Login Id', 'wp-rem');
            $wp_rem_static_text['wp_rem_aythorize_login_id_hint'] = esc_html__('Add your Authorize.net login ID here. You will get it while signing up on Authorize.net.', 'wp-rem');
            $wp_rem_static_text['wp_rem_aythorize_trans_key'] = esc_html__('Transaction Key', 'wp-rem');
            $wp_rem_static_text['wp_rem_aythorize_trans_key_hint'] = esc_html__('Add your Authorize.net Transaction Key here. You will get this key while signing up on Authorize.net', 'wp-rem');
            $wp_rem_static_text['wp_rem_aythorize_ipn_url'] = esc_html__('Authorize.net Ipn Url', 'wp-rem');
            $wp_rem_static_text['wp_rem_aythorize_ipn_url_hint'] = esc_html__('Here you can add your Authorize.net IPN URL', 'wp-rem');
            $wp_rem_static_text['wp_rem_aythorize_cancel_order'] = esc_html__('Cancel Order', 'wp-rem');
            $wp_rem_static_text['wp_rem_aythorize_redirect_payment'] = esc_html__('Redirecting to payment gateway website...', 'wp-rem');
            $wp_rem_static_text['wp_rem_properties_detail_view'] = esc_html__('View', 'wp-rem');
            $wp_rem_static_text['wp_rem_properties_detail_location'] = esc_html__('My Location', 'wp-rem');
            $wp_rem_static_text['wp_rem_properties_detail_street_view'] = esc_html__('Street View', 'wp-rem');
            $wp_rem_static_text['wp_rem_demo_user_not_allowed_to_modify'] = esc_html__('Demo users are not allowed to modify information.', 'wp-rem');

            // Settings Property Detail Page Views
            $wp_rem_static_text['wp_rem_options_property_detail_views'] = esc_html__('Views', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_property_detail_views_hint'] = esc_html__('Select a property detail page view', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_property_detail_top_map'] = esc_html__('Top Map', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_property_detail_top_slider'] = esc_html__('Top Slider', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_property_detail_content_gallery'] = esc_html__('Content Gallery', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_property_detail_content_bottom_member_info'] = esc_html__('Content Bottom Member Info', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_property_detail_sidebar_map'] = esc_html__('Sidebar Map', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_property_detail_sidebar_gallery'] = esc_html__('Sidebar Gallery', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_property_detail_sidebar_member_info'] = esc_html__('Sidebar Member Info', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_property_detail_sidebar_mortgage_calculator'] = esc_html__('Sidebar Mortgage Payment Calculator', 'wp-rem');

			//hidden properties
			$wp_rem_static_text['wp_rem_hidden_dont_hav_hidden_propert'] = esc_html__('You don\'t have any hidden properties.', 'wp-rem');
            /*
             * Currencies
             */
            $wp_rem_static_text['wp_rem_plugin_options_currencies'] = esc_html__('Currencies', 'wp-rem');
            $wp_rem_static_text['wp_rem_plugin_options_currency_settings'] = esc_html__('Currency Settings', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_price_options'] = esc_html__('Price Options', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_currency_symbol'] = esc_html__('Currency Symbol e.g. &#163;', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_conversion_rate'] = esc_html__('Conversion Rate e.g. 0.80', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_currency_name'] = esc_html__('Currency Name e.g. Pound', 'wp-rem');
            
            
            $wp_rem_static_text['wp_rem_options_feature_icon'] = esc_html__('Feature Icon', 'wp-rem');
            $wp_rem_static_text['wp_rem_options_feature_label'] = esc_html__('Feature Label', 'wp-rem');
            $wp_rem_static_text['wp_rem_package_label'] = esc_html__('Package Label', 'wp-rem');
            $wp_rem_static_text['wp_rem_package_type'] = esc_html__('Package Type', 'wp-rem');
            
            $wp_rem_static_text['wp_rem_shortcode_properties_categories'] = esc_html__('Categories', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_filter_prev'] = esc_html__('Prev', 'wp-rem');
            $wp_rem_static_text['wp_rem_shortcode_filter_next'] = esc_html__('Next', 'wp-rem');
            
			$wp_rem_static_text['wp_rem_compare_label'] = esc_html__('Compare', 'wp-rem');
			$wp_rem_static_text['wp_rem_compare_cannot_add_to_list'] = esc_html__('%s - cannot add to compare list', 'wp-rem');
			$wp_rem_static_text['wp_rem_compare_already_compared'] = esc_html__('%s - already compared', 'wp-rem');
			$wp_rem_static_text['wp_rem_compare_add_to_compare'] = esc_html__('Add to Compare', 'wp-rem');
			$wp_rem_static_text['wp_rem_compare_added_successfully_to'] = esc_html__('Added successfully to', 'wp-rem');
			$wp_rem_static_text['wp_rem_compare_added_to_compare'] = esc_html__('%s - added to compare', 'wp-rem');
			$wp_rem_static_text['wp_rem_compare_clear_list'] = esc_html__('Clear List', 'wp-rem');
			$wp_rem_static_text['wp_rem_compare_compare_list'] = esc_html__('compare list', 'wp-rem');
			$wp_rem_static_text['wp_rem_compare_added_successfully_to_compare_list'] = esc_html__('Added successfully to compare list.', 'wp-rem');
			$wp_rem_static_text['wp_rem_compare_already_have_properties'] = esc_html__('Compare list already have 3 properties for this property type.', 'wp-rem');
			$wp_rem_static_text['wp_rem_compare_removed_from_compare_list'] = esc_html__('Removed from compare list.', 'wp-rem');
			$wp_rem_static_text['wp_rem_compare_was_removed_from_compare'] = esc_html__('%s was removed from compare', 'wp-rem');
			$wp_rem_static_text['wp_rem_compare_remove_to_compare'] = esc_html__('Remove to Compare', 'wp-rem');
			$wp_rem_static_text['wp_rem_compare_shortcode_heading'] = esc_html__('REM: Properties Compare', 'wp-rem');
			$wp_rem_static_text['wp_rem_compare_compare_list_is_empty'] = esc_html__('Your compare list is empty, Please add at least two item in list then try it. %s', 'wp-rem');
			$wp_rem_static_text['wp_rem_compare_basic_info'] = esc_html__('Basic Info', 'wp-rem');
			$wp_rem_static_text['wp_rem_compare_vs'] = esc_html__('VS', 'wp-rem');
			$wp_rem_static_text['wp_rem_compare_click_here'] = esc_html__('Click here', 'wp-rem');
			$wp_rem_static_text['wp_rem_options_compare_properties'] = esc_html__('Compare Properties', 'wp-rem');
			$wp_rem_static_text['wp_rem_options_compare_switch'] = esc_html__('Compare', 'wp-rem');
			$wp_rem_static_text['wp_rem_options_compare_switch_label_desc'] = esc_html__('Turn this switch "ON" to show compare properties button otherwise switch it off.', 'wp-rem');
			$wp_rem_static_text['wp_rem_shortcode_compare_switch'] = esc_html__('Compare Switch', 'wp-rem');
			$wp_rem_static_text['wp_rem_shortcode_compare_error'] = esc_html__('Error', 'wp-rem');
			$wp_rem_static_text['wp_rem_shortcode_compare_label'] = esc_html__('Compare', 'wp-rem');
			$wp_rem_static_text['wp_rem_shortcode_compared_label'] = esc_html__('Compared', 'wp-rem');
			$wp_rem_static_text['wp_rem_options_email_logs'] = esc_html__('Email Logs', 'wp-rem');
			$wp_rem_static_text['wp_rem_options_enable_disable_email_logs'] = esc_html__('Enable/Disable sent email logs', 'wp-rem');
			$wp_rem_static_text['wp_rem_register_login_demo_user'] = esc_html__('Demo User', 'wp-rem');
			$wp_rem_static_text['wp_rem_plugin_options_demo_user'] = esc_html__('Demo User', 'wp-rem');
			$wp_rem_static_text['wp_rem_plugin_options_demo_user_hint'] = esc_html__('Please select a user for demo login', 'wp-rem');
                        
			$wp_rem_static_text['wp_rem_payment_woocommerce_enable'] = esc_html__('Woocommerce currency options are being used, please use the settings page for woocommerce to modify currency settings.', 'wp-rem');
			return $wp_rem_static_text;
        }

    }

    new wp_rem_plugin_all_strings_2;
}
