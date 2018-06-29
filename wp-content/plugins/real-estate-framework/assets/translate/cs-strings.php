<?php

/**
 * @Text which is being used in Framework
 *
 */
if ( ! function_exists('wp_rem_cs_var_frame_text_srt') ) {

    function wp_rem_cs_var_frame_text_srt($str = '') {
        global $wp_rem_cs_var_frame_static_text;
        if ( isset($wp_rem_cs_var_frame_static_text[$str]) ) {
            return $wp_rem_cs_var_frame_static_text[$str];
        }
    }

}
if ( ! class_exists('wp_rem_cs_var_frame_all_strings') ) {

    class wp_rem_cs_var_frame_all_strings {

        public function __construct() {
            /*
             * Triggering function for strings.
             */
            add_action('init', array( $this, 'wp_rem_cs_var_frame_all_string_all' ), 0);
        }

        function wp_rem_cs_var_login_strings() {
            global $wp_rem_cs_var_frame_static_text;
            /*
             * Sign Up
             * Sign In
             * Forget Password
             * */
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_join_us'] = __(' Register', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_confirm_password'] = __('CONFIRM PASSWORD ', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_user_registration'] = __('User Registration is disabled', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_you_have_already_logged_in'] = __(' You have already logged in, Please logout to try again.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_please_logout_first'] = __('Please logout first then try to login again', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_user_login'] = __('User Login', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_username'] = __('USERNAME', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_username_small'] = __('username', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_password'] = __('PASSWORD', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_log_in'] = __('Login', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_forgot_password'] = __('Forgot Password', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_new_to_us'] = __('New to Us?', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_signup_signin'] = __('Signup / Signin with', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_desired_username'] = __('Type desired username', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_phone'] = __('Phone Number', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_phone_hint'] = __('Enter Phone Number', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_register_here'] = __('Register Here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_create_account'] = __('Create Account', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_not_member_yet'] = __('Not a Member yet?', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_Sign_up_now'] = __('Sign Up Now', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_or'] = __('Or', 'wp-rem-frame');


            //$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_sign_in'] = __('Log in', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_sign_in'] = __('SIGN IN', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_password_should_not_be_empty'] = __('Password should not be empty', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_password_should_not_match'] = __('Password Not Match', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_already_have_account'] = __(' Already have an account', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_login_now'] = __(' Login Now', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_user_sign_in'] = __('User Sign in', 'wp-rem-frame');

            /*
             *  Login File
             * */
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_register_options'] = __('User Registration Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_set_api_key'] = __('Please set API key', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_signin_with_your_Social_networks'] = __('Signin with your Social Networks', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_google'] = __('google', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_linkedin'] = __('Linkedin', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_linkedin_title'] = __('twitter', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_send_email'] = __('Send Email', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_login_here'] = __('Login Here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_enter_email_address'] = __('Enter E-Mail address...', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_signup_now'] = __('Sign up Now', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_password_recovery'] = __('Password Recovery', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_oops_something_went_wrong_updating_your_account'] = __('Oops something went wrong updating your account', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_check_your_email_address_for_new_password'] = __('Check your email for your new password.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_ur_request_has_been_completed_succssfully'] = __('Your request has been completed succssfully, Now you can use following information for login.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_your_new_password'] = __('Your new password', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_your_username_is'] = __('Your username is:', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_your_new_password_is'] = __('Your new password is:', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_from'] = __('From:', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_there_is_no_user_registered'] = __('There is no user registered with that email address.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_invalid_email_address'] = __('Invalid e-mail address.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_username_should_not_be_empty'] = __('User name should not be empty.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_password_should_not_be_empty.'] = __('Password should not be empty.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_email_should_not_be_empty'] = __('Email should not be empty.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_wrong_username_or_password'] = __('Wrong username or password.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_login_successfully'] = __('Login Successfully...', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_valid_username'] = __('Please enter a valid username. You can only enter alphanumeric value and only ( _ ) longer than or equals 5 chars', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_valid_email'] = __('Please enter a valid email.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_user_already_exists'] = __('User already exists. Please try another one.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_user_registration_detail'] = __('User registration Detail', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_check_email'] = __('Please check your email for login details', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_successfully_registered_with_login'] = __('You have been successfully registered <a href="javascript:void(0);" data-toggle="modal" data-target="#cs-login" data-dismiss="modal" class="cs-color" aria-hidden="true">Login</a>.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_currently_issue'] = __('Currently there are and issue', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_successfully_registered'] = __('Your account has been registered successfully, Please contact to site admin for password.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_captcha_api_key'] = __('Please provide google captcha API keys', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_select_captcha_field'] = __('Please select captcha field.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_reload'] = __('Reload', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_already_linked'] = __('This profile is already linked with other account. Linking process failed!', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_error'] = __('ERROR', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_something_went_wrong'] = __('Something went wrong: %s', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_problem_connecting_to_twitter'] = __(' There is problem while connecting to twitter', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_login_error'] = __('Login error', 'wp-rem-frame');

            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_facebook'] = __('facebook', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_twitter'] = __('twitter', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_google_plus_icon'] = __('google-plus', 'wp-rem-frame');





            return $wp_rem_cs_var_frame_static_text;
        }

        public function wp_rem_cs_var_frame_all_string_all() {

            global $wp_rem_cs_var_frame_static_text;

            /* framework */


            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_add_page_section'] = __('Add Page Sections', 'wp-rem-frame');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_blog_search'] = __('Blog Search', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_Oops_404'] = __('Oops! That page can’t be found. ', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_nothing_found_404'] = __('It looks like nothing was found at this location. Maybe try a search?. ', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_api_set_msg'] = __('There is an issue in API, Please contact to administrator and try again', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_subscribe_success'] = __('subscribe successfully', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_noresult_found'] = __('No result found.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_comments'] = __('Comments', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_by'] = __('By', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_article_ads'] = __('Article Bottom Banner', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_next'] = __('Next', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_prev'] = __('PREVIOUS', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_tag'] = __('Tags', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_ago'] = __('Ago', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_related_posts'] = __('Related Posts', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_image_edit'] = __('Edit "%s"', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_primary_menu'] = __('Primary Menu', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_social_links_menu'] = __('Social Links Menu', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_widget_display_text'] = __('This widget will be displayed on right/left side of the page.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_widget_display_right_text'] = __('This widget will be displayed on right side of the page.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_footer'] = __('Footer ', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_widgets'] = __('Widgets ', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_search_result'] = __('Search Results : %s', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_author'] = __('Author', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_archives'] = __('Archives', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_packages'] = __('Inventory Packages', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_tweets'] = __('Tweets', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_no_tweets_found'] = __('NO tweets found.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_tweets_time_on'] = __('On', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_daily_archives'] = __('Daily Archives: %s', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_monthly_archives'] = __('Monthly Archives: %s', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_yearly_archives'] = __('Yearly Archives: %s', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_tags'] = __('Tags', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_error_404'] = __('Error 404', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_home'] = __('Home', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_current_page'] = __('Current Page', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_theme_options'] = __('CS Theme Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_previous_page'] = __('Previous page', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_next_page'] = __('Next page', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_previous_image'] = __('Previous Image', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_next_image'] = __('Next Image', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_pages'] = __('Pages:', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page'] = __('Page', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_comments_closed'] = __('Comments are closed.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_reply'] = __('Reply', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_full_width'] = __('Full width', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_sidebar_right'] = __('Sidebar Right', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_sidebar_left'] = __('Sidebar Left', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_sidebar_small_left'] = __('Small Left Sidebar', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_sidebar_small_right'] = __('Small Right Sidebar', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_sidebar_small_left_large_right'] = __('Small Left and Large Right Sidebars', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_sidebar_large_left_small_right'] = __('Large Left and Small Right Sidebars', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_sidebar_both_left'] = __('Both Left Sidebars', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_sidebar_both_right'] = __('Both Right Sidebars', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_delete_image'] = __('Delete image', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_item'] = __('Edit Item', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_description'] = __('Description', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_update'] = __('Update', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_delete'] = __('Delete', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_select_attribute'] = __('Select Attribute', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_ads'] = __('CS : Ads', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_select_image_ads'] = __('Select Image from Ads.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_flickr_gallery'] = __('CS : Flickr Gallery', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_flickr_description'] = __('Type a user name to show photos in widget', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_flickr_username'] = __('Flickr username', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_flickr_username_hint'] = __('Enter your Flicker Username here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_flickr_photos'] = __('Number of Photos', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_error'] = __('Error:', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_flickr_api_key'] = __('Please Enter Flickr API key from Theme Options.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_mailchimp'] = __('CS: Mail Chimp', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_mailchimp_desciption'] = __('Mail Chimp Newsletter Widget', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_description_hint'] = __('Enter discription here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_social_icon'] = __('Social Icon On/Off.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_recent_post'] = __('CS : Recent Posts', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_recent_post_des'] = __('Recent Posts from category.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_choose_category'] = __('Choose Category.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_num_post'] = __('Number of Posts To Display.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_availability'] = __('Availability', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_in_stock'] = __('in stock', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_out_stock'] = __('out of stock', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_wait'] = __('Please wait...', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_load_icon'] = __('Successfully loaded icons', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_try_again'] = __('Error: Try Again?', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_load_json'] = __('Load from IcoMoon selection.json', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_are_sure'] = __('Are you sure! You want to delete this', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_hint'] = __('Please enter text for icon', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_path'] = __('Icon Path', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon'] = __('Icon', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_comment_awaiting'] = __('Your comment is awaiting moderation.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit'] = __('Edit', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_you_may'] = __('You may use these HTML tags and attributes: %s', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_message'] = __('Message', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_view_posts'] = __('View all posts by %s', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_nothing'] = __('Nothing Found', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_ready_publish'] = __('Ready to publish your first post? Get started here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_nothing_match'] = __('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_perhaps'] = __('It seems we can’t find what you’re looking for. Perhaps searching can help.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_you_must'] = __('You must be to post a comment.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_log_out'] = __('Log out', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_log_in'] = __('Logged in as', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_require_fields'] = __('Required fields are marked %s', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_name'] = __('Name *', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_full_name'] = __('full name', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_email'] = __('Email', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_enter_email'] = __('Type your email address', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_website'] = __('Website', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_text_here'] = __('Message', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_leave_comment'] = __('Leave us a comment', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_cancel_reply'] = __('Cancel reply', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_post_comment'] = __('Post comments', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_interested'] = __('I am interested in a price quote on this vehicle. Please contact me at your earliest convenience with your best price for this vehicle.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_dealer'] = __('Dealers Property', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_option'] = __('Page Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_general_setting'] = __('General Settings', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_subheader'] = __('Subheader', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_choose_subheader'] = __('Choose Sub-Header', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_default_subheader'] = __('Default Subheader', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_custom_subheader'] = __('Custom Subheader', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_rev_slider'] = __('Revolution Slider', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_map'] = __('Map', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_no_subheader'] = __('No Subheader', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_style'] = __('Style', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_classic'] = __('Classic', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_with_image'] = __('With Background Image', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_padding_top'] = __('Padding Top', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_padding_top_mobile'] = __('Padding Top (Mobile)', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_padding_top_hint'] = __('Set padding top here.(In px)', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_padding_bot'] = __('Padding Bottom', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_padding_bot_mobile'] = __('Padding Bottom (Mobile)', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_padding_bot_hint'] = __('Set padding bottom. (In px)', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_margin_top'] = __('Margin Top', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_margin_top_mobile'] = __('Margin Top (Mobile)', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_margin_top_hint'] = __('Set Margin top here.(In px) ', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_margin_bot'] = __('Margin Bottom', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_margin_bot_mobile'] = __('Margin Bottom (Mobile)', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_margin_bot_hint'] = __('Set Margin bottom. (In px)', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_select_layout'] = __('Select Layout', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_title'] = __('Page Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_text_color'] = __('Text Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_text_color_hint'] = __('Provide a hex color code here (with #) for title.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_breadcrumbs'] = __('Breadcrumbs', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_sub_heading'] = __('Sub Heading', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_sub_heading_hint'] = __('Enter subheading text here.it will display after title.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_bg_image'] = __('Background Image', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_bg_image_hint'] = __('Choose subheader background image from media gallery or leave it empty for display default image set by theme options.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_parallax'] = __('Parallax', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_parallax_hint'] = __('Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling can be enable with this switch.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_bg_color'] = __('Background Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_bg_color_hint'] = __('Provide a hex color code here (with #) if you want to override the default, leave it empty for using background image.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_breadcrumb_bg_color'] = __('Breadcrumb Background Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_breadcrumb_bg_color_hint'] = __('Provide a hex color code here (with #) for breadcrumb background.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_slider'] = __('Select Slider', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_map_sc'] = __('Custom Map Short Code', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_header_border'] = __('Header Border Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_header_hint'] = __('Provide a hex color code here (with #) for header border color.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_header_style'] = __('Choose Header Style', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_modern_header'] = __('Modern Header Style', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_default_header'] = __('Default header style', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_header_view'] = __('Header Style', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_header_view_default'] = __('Default', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_header_view_moderm'] = __('Modern', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_header_view_classic'] = __('Classic', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_header_view_fancy'] = __('Fancy', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_header_view_default_v2'] = __('Default V2', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_header_view_advance'] = __('Advance', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_header_view_advance_v2'] = __('Advance V2', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_header_view_modern_v2'] = __('Modern V2', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_side_bar'] = __('Select Sidebar', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_choose_sidebar'] = __('Choose Sidebar', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_margin'] = __('Page Margin', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_container'] = __('Page Container', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_hide_header_footer'] = __('Hide Header Footer', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_hide_header'] = __('Hide Header', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_hide_footer'] = __('Hide Footer', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_bg_color'] = __('Page Background Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_bg_color_hint'] = __('Please Select Page Background Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_sidebar_hint'] = __('Choose sidebar layout for this post.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_left_sidebar'] = __('Select Left Sidebar', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_right_sidebar'] = __('Select Right Sidebar', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_second_right_sidebar'] = __('Select Second Right Sidebar', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_second_left_sidebar'] = __('Select Second Left Sidebar', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_post_options'] = __('Post Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_social_sharing'] = __('Social Sharing', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_about_author'] = __('About Author', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_product_options'] = __('Product Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_add_element'] = __('Add Element', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_search'] = __('Search', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_show_all'] = __('Show all', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_filter_by'] = __('Filter by', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_insert_sc'] = __('CS: Insert shortcode', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_quote'] = __('Blockquote', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_dropcap'] = __('Dropcap', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_options'] = __('%s Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_title'] = __('Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_title_color'] = __('Title Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_title_hint'] = __('This Title will view on top of this section.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_subtitle'] = __('Sub Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_subtitle_hint'] = __('This Sub Title will view below the Title of this section.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_subtitle_color'] = __('Sub Title Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_bg_view'] = __('Background View', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_choose_bg'] = __('Choose Background View.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_none'] = __('None', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_title_sub_title_align'] = __('Alignment', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_sub_header_align'] = __('Text Align', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_title_sub_title_align_hint'] = __('Set title/sub title alignment from this dropdown.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_align_left'] = __('Left', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_align_center'] = __('Center', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_align_right'] = __('Right', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_align_bottom'] = __('Bottom', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_custom_slider'] = __('Custom Slider', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_video'] = __('Video', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_youtube_vimeo_video_url'] = __('Youtube / Vimeo Video URL', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_bg_position'] = __('Background Image Position', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_choose_bg_position'] = __('Choose Background Image Position', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_no_center_top'] = __('no-repeat center top', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_center_top'] = __('repeat center top', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_no_center'] = __('no-repeat center', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_no_center_cover'] = __('no-repeat center / cover', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_center_cover'] = __('repeat center / cover', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_repeat_center'] = __('repeat center', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_no_left_top'] = __('no-repeat left top', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_repeat_left_top'] = __('repeat left top', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_no_fixed'] = __('no-repeat fixed center', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_no_fixed_cover'] = __('no-repeat fixed center / cover', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_custom_slider_hint'] = __('Enter Custom Slider', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_video_url'] = __('Video Url', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_browse'] = __('Browse', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_mute'] = __('Enable Mute', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_choose_mute'] = __('Choose Mute selection', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_yes'] = __('Yes', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_no'] = __('No', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_video_auto'] = __('Video Auto Play', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_choose_video_auto'] = __('Choose Video Auto Play selection', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_enable_parallax'] = __('Enable Parallax', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_section_nopadding'] = __('No Padding', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_section_nomargin'] = __('No Margin', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_select_view'] = __('Select View', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_box'] = __('Box', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_wide'] = __('Wide', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_choose_bg_coor'] = __('Choose background color.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_border_top'] = __('Border Top', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_border_top_hint'] = __('Set the Border top (In px)', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_border_bot'] = __('Border Bottom', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_border_bot_hint'] = __('Set the Border Bottom (In px)', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_border_color'] = __('Border Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_choose_border_color'] = __('Choose Border color.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_cus_id'] = __('Custom Id', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_cus_id_hint'] = __('Enter Custom Id.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_select_layout'] = __('Select Layout', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_page'] = __('Edit Page Section', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_ads_only'] = __('Ads', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_inventories'] = __('Inventory Property', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_inventories_search'] = __('Inventory Search', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_compare_inventories'] = __('Inventory Compare', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_gallery'] = __('Gallery', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icons_box'] = __('Icons Box', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_plan'] = __('Pricing Tables', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_wc_feature'] = __('WC Feature Product', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_column'] = __('Columns', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_contact_form'] = __('Contact Form', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_schedule_form'] = __('Schedule Form', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_best_time'] = __('Best time', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_testimonial'] = __('Testimonial', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_accordion'] = __('Accordion', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_multi_services'] = __('Multi Services', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_partner'] = __('Partner', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_blog'] = __('Blog - Views', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_heading'] = __('Headings', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_counter'] = __('Counter', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_image_frame'] = __('Image Frame', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_flex_editor'] = __('flex editor', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_editor'] = __('Editor', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_call_action'] = __('Call To Action', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance'] = __('maintenance', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_list'] = __('List', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_contact_info'] = __('Contact Info', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_divider'] = __('Divider', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_promobox'] = __('Promobox', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_auto_heading'] = __('Rem_cs Heading', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_button'] = __('Buttons', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_sitemap'] = __('Site Map', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_property_price'] = __('Property Price', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_spacer'] = __('Spacer', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_typography'] = __('Typography', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_common_elements'] = __('Common Elements', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_media_element'] = __('Media Element', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_content_blocks'] = __('Content Blocks', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_loops'] = __('Loops', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_wpam'] = __('WPAM', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_size'] = __('Size', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_column_hint'] = __('Select column width. This width will be calculated depend page width.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_one_half'] = __('One half', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_one_third'] = __('One third', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_two_third'] = __('Two third', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_one_fourth'] = __('One fourth', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_three_fourth'] = __('Three fourth', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_plz_select'] = __('Please select..', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_text'] = __('Content', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_testimonial_text'] = __('Text', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_text_hint'] = __('Enter testimonial content here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_author_hint'] = __('Enter testimonial author name here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_position'] = __('Position', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_position_hint'] = __('Enter position of author here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_image'] = __('Image', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_image_hint'] = __('Set author image from media gallery.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_active'] = __('Active', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_active_hint'] = __('You can set the accordian section that is open by default on frontend by select dropdown', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_faq_active_hint'] = __('You can set the faq section that is open by default on frontend by select dropdown', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_remove'] = __('Remove', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_list_Item'] = __('List Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_list_Item_hint'] = __('Enter list title here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_tooltip'] = __('Choose icon for list.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_list_sc_icon_color'] = __('Icon Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_list_sc_icon_color_hint'] = __('Select icon color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_list_sc_icon_bg_color'] = __('Icon Background Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_list_sc_icon_bg_color_hint'] = __('Select icon background color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_property_title_hint'] = __('Enter property_price text here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price'] = __('Price', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_hint'] = __('Enter property_price author name here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_color'] = __('Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_color_hint'] = __('Set text color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_counter_hint'] = __('Enter counter text here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_counter_author_hint'] = __('Enter counter author name here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_counter_text_hint'] = __('Enter position of author here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_divider_hint'] = __('Divider setting on/off', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_image_url'] = __('Image Url', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_image_url_hint'] = __('Enter image url', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_multiple_service'] = __('Multiple Service', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_content_title'] = __('Content Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_content_title_hint'] = __('Add service title here..', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_link_url'] = __('Link Url', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_link_hint'] = __('e.g. http://yourdomain.com/.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_content_title_color'] = __('Content title Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_content_title_color_hint'] = __('Set title color from here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_bg_color'] = __('Icon Background Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_bg_color_hint'] = __('Set the Service Background', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_color'] = __('Icon Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_color_hint'] = __('Set the position of service image here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_service_text_hint'] = __('Enter little description about service.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_content_color'] = __('Content Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_content_color_hint'] = __('Provide a hex colour code here (with #) for text color. if you want to override the default.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_builder'] = __('CS Page Builder', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_enter_valid'] = __('Enter Your Email Address...', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_subscribe_success'] = __('subscribe successfully', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_inventory_type'] = __('Inventory Makes', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_post_style'] = __('Style', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_post_view'] = __('View', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_post_view_hint'] = __('Select post view from this dropdown. Default view is selected from theme option.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_post_ad_unit'] = __('Ad Unit', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_post_select_ad'] = __('Select Ad', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_cover_image'] = __('Cover Image', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_post_format'] = __('Format', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_post_view_thumbnail'] = __(' Thumbnail ', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_post_view_slider'] = __(' Slider ', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_post_format_thumbnail'] = __(' Thumbnail ', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_post_format_slider'] = __(' Slider ', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_post_format_sound'] = __('Sound', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_post_format_video'] = __('Video', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_post_inside_thumbnail'] = __('Inside Post Thumbnail', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_soundcloud_url'] = __('SoundCloud URL', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_post_view_select_format'] = __('Select Format', 'wp-rem-frame');

            /*
              multi counter
             */

            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_multiple_counter_title'] = __('Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_multiple_counter_title_hint'] = __('Enter Title Here', 'wp-rem-frame');

            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_multiple_counter'] = __('Counter', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_multiple_counter_icon'] = __('Icon', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_multiple_counter_icon_tooltip'] = __('Please Select Icon ', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_multiple_counter_count'] = __('Count', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_multiple_counter_count_tooltip'] = __('Enter Counter Range', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_multiple_counter_content'] = __('Content', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_multiple_counter_content_tooltip'] = __('Enter Content Here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_multiple_counter_content_color'] = __('Content Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_multiple_counter_content_color_tooltip'] = __('Select Content Color ', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_thumbnail_view_demo'] = __('Thumbnail View demo', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_thumbnail_view_demo_hint'] = __('Choose thumbnial view type for this post. None for no image. Single image for display featured image on properties and slider for display slides on thumbnail view.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_single_image'] = __('Single Image', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_slider'] = __('Slider', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_audio'] = __('Audio', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_thumbnail_audio_url'] = __('Thumbnail Audio URL', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_thumbnail_audio_url_hint'] = __('Enter Audio URL for this Post', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_thumbnail_video_url'] = __('Thumbnail Video URL', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_thumbnail_video_url_hint'] = __('Enter Specific Video Url (Youtube, Vimeo and Dailymotion)', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_add_gallery_images'] = __('Add Gallery Images', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_detail_views'] = __('Detail Views', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_simple'] = __('Simple', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_fancy'] = __('Fancy', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_inside_post_view'] = __('Inside Post Thumbnail View', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_inside_post_view_hint'] = __('Choose inside thumbnial view type for this post. None for no image. Single image for display featured image on detail. Slider for display slides on detail. Audio for make this audio post and video for display video inside post.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_audio_url'] = __('Audio Url', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_audio_url_hint'] = __('Enter Mp3 audio url for this post .', 'wp-rem-frame');

            /*             * accordion Code */
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_accordian'] = __('Accordion', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_faq'] = __('Faq', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_accordion_title'] = __('Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_accordion_title_hint'] = __('Enter accordion title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_faq_title'] = __('Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_faq_title_hint'] = __('Enter faq title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_accordion_text'] = __('Content', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_accordion_text_hint'] = __('Enter accordian content here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_faq_text'] = __('Content', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_faq_text_hint'] = __('Enter faq content here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_accordion_icon'] = __('Icon', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_accordion_icon_hint'] = __('Select Icon for accordion', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_faq_icon'] = __('Icon', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_faq_icon_hint'] = __('Select Icon for faq', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_accordion_title_hint'] = __('Enter accordion title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_accordion_view'] = __('View', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_accordion_view_hint'] = __('Select View for Accordion', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_faq_view'] = __('View', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_faq_view_hint'] = __('Select View for Accordion', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_accordion_view_simple'] = __('Simple', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_accordion_view_modern'] = __('Modern', 'wp-rem-frame');

            /*             * Site map Short Code */
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_sitemap'] = __('Edit SiteMap Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_map_search_page'] = __('REM: Map Search Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_section_title'] = __('Section Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_post_settings'] = __('Post Settings', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_post_gallery'] = __('Post Gallery', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_maintain_page'] = __('Edit Maintain Page Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_insert'] = __('Insert', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_logo'] = __('Logo', 'wp-rem-frame');

            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_no_margin_hint'] = __('Select Yes to remove margin for this section', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_please_select_maintinance'] = __('Please Select a Maintinance Page', 'wp-rem-frame');
            /*             * Client Short Code */
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_clients'] = __('Clients', 'wp-rem-frame');
            /*
              team
             */

            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team'] = __('Team', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_add_item'] = __('Add Team', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_name'] = __('Name', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_name_hint'] = __('Enter team member name here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_designation'] = __('Designation', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_designation_hint'] = __('Enter team member designation here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_image'] = __('Team Profile Image', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_image_hint'] = __('Select team member image from media gallery.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_phone'] = __('Phone No', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_phone_hint'] = __('Enter phone number here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_fb'] = __('Facebook', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_fb_hint'] = __('Enter facebook account link here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_twitter'] = __('Twitter', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_twitter_hint'] = __('Enter twitter account link here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_google'] = __('Google Plus', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_google_hint'] = __('Enter google+ accoount link here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_linkedin'] = __('Linkedin', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_linkedin_hint'] = __('Enter linkedin account link here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_youtube'] = __('Youtube', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_youtube_hint'] = __('Enter youtube link here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_title'] = __('Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_title_hint'] = __('Enter Team Title Here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_sub_title'] = __('Sub Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc_sub_title_hint'] = __('Enter Team Sub Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_team_sc'] = __('Team', 'wp-rem-frame');
            /*             * Maintenance Short Code */

            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_maintenance_page'] = __('Maintenance Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_wp_rem_properties_page'] = __('Properties Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_wp_rem_properties_element'] = __('REM: Properties Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_wp_rem_properties_element_wd_filter'] = __('REM: Properties with Filters Options', 'wp-rem-frame');


            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_wp_rem_properties_page_slider'] = __('REM: Properties Slider Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_wp_rem_propertiesearch_page'] = __('REM: Property Search Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_wp_rem_map_properties_page'] = __('REM: Map Properties Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_wp_rem_members_page'] = __('REM: Members Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_wp_rem_register_page'] = __('REM: Register Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_wp_rem_register_user_and_add_property_page'] = __('REM: Register User and Add Property Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_property_categories_page'] = __('REM: Property Categories Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_pricing_table_page'] = __('REM: Pricing Plan Options', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_tabs_fancy_edit_options'] = __('Facny Tabs Options', 'wp-rem-frame');




            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance'] = __('Maintenance', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_sc_title'] = __('Element Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_sc_title_hint'] = __('Enter Maintenance Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_sc_sub_title'] = __('Element Sub Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_sc_sub_title_hint'] = __('Enter Maintenance Subtitle', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_sc_text'] = __('Content', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_sc_text_hint'] = __('Enter Maintenance Text', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_sc_views'] = __('Views ', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_sc_views_hint'] = __('Select a view for underconstruction page.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_sc_view1'] = __('View 1 ', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_sc_view2'] = __('View 2 ', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_sc_image_hint'] = __('Select Image for Maintaince background.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_sc_logo_hint'] = __('Select Image for Maintaince Logo.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_sc_launch_date'] = __('Launch Date', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_sc_launch_date_hint'] = __('Enter launch Date', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_sc_save'] = __('Save', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_save_settings'] = __('Save Settings', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_select_page'] = __('Select A page', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_newsletter'] = __('Newsletter ', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_newsletter_sign_up'] = __('Sign Up! ', 'wp-rem-frame');
            /*
              tabs */

            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_tabs'] = __('Tabs', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_tab'] = __('Tab', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_tabs_desc'] = __('You can manage your tabs using this shortcode', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_tab_active'] = __('Active', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_tab_active_hint'] = __('You can set the tab section that is open by default on frontend by select dropdown', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_tab_item_text'] = __('Tab Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_tab_item_text_hint'] = __('Enter tab title here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_tab_desc'] = __('Content', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_tab_desc_hint'] = __('Enter tab content here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_tab_icon'] = __('Tab Icon', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_tab_icon_hint'] = __('Select the Icons you would like to show with your tab .', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_saving_changes'] = __('Saving changes...', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_no_title'] = __('No Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_no_padding_hint'] = __('Select Yes to remove padding for this section', 'wp-rem-frame');




            /* Maintenance Mode */

            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_save_btn'] = __('Save Settings', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_field_name'] = __('Maintenance Mode', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_field_mode'] = __('Maintenance Mode', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_field_mode_hint'] = __('Turn Maintenance Mode On/Off here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_field_logo'] = __('Maintenance Mode Logo', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_field_logo_hint'] = __('Turn Logo On/Off here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_field_social'] = __('Social Contact', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_field_social_hint'] = __('Turn Social Contact On/Off here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_field_newsletter'] = __('Newsletter', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_field_newsletter_hint'] = __('Turn newsletter On/Off here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_field_header'] = __('Header Switch', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_field_header_hint'] = __('Turn Header On/Off here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_field_footer'] = __('Footer Switch', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_field_footer_hint'] = __('Turn Footer On/Off here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_field_select_page'] = __('Please Select a Page', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_field_mode_page'] = __('Maintenance Mode Page', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_field_mode_page_hint'] = __('Choose a page that you want to set for maintenance mode', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_save_message'] = __('All Settings Saved', 'wp-rem-frame');
            /*
              icos box
             */
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_boxs_title'] = __('Icon Box', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_boxs_views'] = __('Views', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_boxs_views_hint'] = __('Select the Icon Box style', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_box_view_option_1'] = __('Simple', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_box_view_option_2'] = __('Top Center', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_boxes_content_title'] = __('Icon Box Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_boxes_content_title_hint'] = __('Add Icon Box title here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_boxes_link_url'] = __('Title Link', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_boxes_link_url_hint'] = __('e.g. http://yourdomain.com/.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_boxes_content_title_color'] = __('Content title Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_boxes_content_title_color_hint'] = __('Set title color from here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_boxes_Icon'] = __('Icon Box Icon', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_boxes_Icon_hint'] = __('Select the icons you would like to show with your accordion title.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_box_icon_font_size'] = __('Icon Font Size', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_box_icon_font_size_hint'] = __('Set the Icon Font Size', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_box_icon_font_size_option_1'] = __('Extra Small', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_box_icon_font_size_option_2'] = __('Small', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_box_icon_font_size_option_3'] = __('Medium', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_box_icon_font_size_option_4'] = __('Medium Large', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_box_icon_font_size_option_5'] = __('Large', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_box_icon_font_size_option_6'] = __('Extra Large', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_box_icon_font_size_option_7'] = __('Free Size', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_boxes_Icon_bg'] = __('Icon Background Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_boxes_Icon_bg_hint'] = __('Set the Icon Box Background.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_boxes_Icon_color'] = __('Icon Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_boxes_Icon_color_hint'] = __('Set Icon Box icon color from here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_boxes_text'] = __('Icon Box Content', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_boxes_text_hint'] = __('Enter icon box content here.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_box_icon_type'] = __('Icon Type', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_box_icon_type_hint'] = __('Select icon type image or font icon.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_box_icon_type_1'] = __('Icon', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_box_icon_type_2'] = __('Image', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_box_image'] = __('Image', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_icon_box_image_hint'] = __('Attach image from media gallery.', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_register_heading'] = __('User Registration', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_register'] = __('User Registration', 'wp-rem-frame');




            /* Price Table */
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_title'] = __('Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_title_hint'] = __('Enter Price table Title Here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_title_color'] = __('Title Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_title_color_hint'] = __('Set price-table title color from here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_price_color'] = __('Price Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_price_color_hint'] = __('Set Price color from here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_price'] = __('Price', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_price_hint'] = __('Add price without symbol', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_currency'] = __('Currency Symbols', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_currency_hint'] = __('Add your currency symbol here like $', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_time'] = __('Time Duration', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_time_hint'] = __('Add time duration for package or time range like this package for a month or year So wirte here for Mothly and year for Yearly Package', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_button_link'] = __('Button Link', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_button_link_hint'] = __('Add price table button Link here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_button_text'] = __('Button Text', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_button_text_hint'] = __('Add button text here Example : Buy Now, Purchase Now, View Packages etc', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_button_color'] = __('Button text Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_button_color_hint'] = __('Set button color with color picker', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_button_bg_color'] = __('Button Background Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_button_bg_color_hint'] = __('Set button background color with color picker', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_featured'] = __('Featured on/off', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_featured_hint'] = __('Price table featured option enable/disable with this dropdown', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_description'] = __('Content', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_description_hint'] = __('Features can be add easily in input with this shortcode 
					    					[feature_item]Text here[/feature_item][feature_item]Text here[/feature_item]', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_column_color'] = __('Column Background Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_price_table_column_color_hint'] = __('Set Column Background color', 'wp-rem-frame');

            /* Progressbar Shortcode */
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_progressbars'] = __('Progress Bars', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_progressbar'] = __('Progress Bar', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_progressbar_title'] = __('Progress Bar Title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_progressbar_title_hint'] = __('Enter progress bar title', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_progressbar_skill'] = __('Skill (in percentage)', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_progressbar_skill_hint'] = __('Enter skill (in percentage) here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_progressbar_color'] = __('Progress Bar Color', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_progressbar_color_hint'] = __('Set progress bar color here', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_progressbar_add_button'] = __('Add Progress Bar', 'wp-rem-frame');

            /* Table Shortcode */
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_table'] = __('Table', 'wp-rem-frame');

            /* Page Editor Tabs */
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_classic_editor'] = __('Classic Editor', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_builder'] = __('Page Builder', 'wp-rem-frame');
            /* About Info */
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_about_info'] = __('About Info', 'wp-rem-frame');

            /* Maintenance Page */
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_days'] = __('days', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_hours'] = __('hours', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_minutes'] = __('minutes', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_maintenance_seconds'] = __('seconds', 'wp-rem-frame');



            /*
             * Contact Form Stings 
             */
            
            // frontend
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_contact_default_success_msg'] = esc_html__('Email has been sent Successfully', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_contact_default_error_msg'] = esc_html__('An error Occured, please try again later', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_contact_first_name'] = esc_html__('Name', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_contact_first_name_placeholder'] = esc_html__('First Name & Last Name', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_contact_last_name'] = esc_html__('Subject', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_contact_last_name_placeholder'] = esc_html__('About this Listing', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_contact_email'] = esc_html__('Email', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_contact_email_address'] = esc_html__('Example@domain.com', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_contact_phone_number'] = esc_html__('Phone Number', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_contact_phone_number_placeholder'] = esc_html__('868.702.8650', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_contact_button_text'] = esc_html__('Send A message', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_message'] = esc_html__('Message', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_contact_check_field'] = esc_html__('Subscribe and Get latest updates and offers by Email', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_contact_received'] = esc_html__('Contact Form Submission', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_contact_valid_email'] = esc_html__('Please enter a valid email.', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_contact_email_should_not_be_empty'] = esc_html__('Email should not be empty.', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_contact_full_name'] = esc_html__('Name', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_contact_ip_address'] = esc_html__('IP Address:', 'homevillas-real-estate');

            // backend
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_edit_form'] = esc_html__('Contact Form Options', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_element_title'] = esc_html__('Element Title', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_element_title_hint'] = esc_html__('Enter element title here.', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_element_subtitle'] = esc_html__('Element Sub Title', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_element_subtitle_hint'] = esc_html__('Enter element sub title here', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_var_title_alignment'] = esc_html__('Title Alignment', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_var_title_alignment_hint'] = esc_html__('Select title alignment here', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_var_align_left'] = esc_html__('Left', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_var_align_right'] = esc_html__('Right', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_var_align_center'] = esc_html__('Center', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_send_to'] = esc_html__('Receiver Email', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_send_to_hint'] = esc_html__('Receiver, or receivers of the mail.', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_success_message'] = esc_html__('Success Message', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_success_message_hint'] = esc_html__('Enter Mail Successfully Send Message.', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_error_message'] = esc_html__('Error Message', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_error_message_hint'] = esc_html__('Enter Error Message In any case Mail Not Submited.', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_save'] = esc_html__('Save', 'homevillas-real-estate');
            
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_newsletter_email_id'] = esc_html__('Enter Your Email ID', 'homevillas-real-estate');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_newsletter_subscribe'] = esc_html__('Subscribe', 'homevillas-real-estate');
            
            // Google Fonts
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_fonts_menu_label'] = esc_html__('CS Fonts Manager', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_google_fonts_label'] = esc_html__('Google Fonts', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_custom_fonts_label'] = esc_html__('Custom Fonts', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_refresh_fonts_list'] = esc_html__('Refresh Google Fonts List', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_new_fonts_added'] = esc_html__('%s new fonts added.', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_fonts_added_error'] = esc_html__('Fonts could not be downloaded as there might be some issue with file_get_contents or wp_remote_get due to your server configuration.', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_select_font_attributes'] = esc_html__('Select Attribute', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_search_font'] = esc_html__('Serach font...', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_google_fonts_is_added'] = esc_html__('Font is added in font list.', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_google_fonts_is_deleted'] = esc_html__('Font is deleted in font list.', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_google_fonts_is_updated'] = esc_html__('Font is updated in font list.', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_are_you_sure_remove_font'] = esc_html__('Are you sure you want to remove this font?', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_google_fonts_page_is_loading'] = esc_html__('Please wait, Page is reloading.', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_google_fonts_added_in_list'] = esc_html__('Added in List', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_google_fonts_add_to_list'] = esc_html__('Add to List', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_your_selected_google_fonts'] = esc_html__('Your Selected Google Fonts', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_not_font_search'] = esc_html__('Sorry! there are no font families that match. Try with other search keyword', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_seems_dont_have_font'] = esc_html__('It seems you don\'t have any Google Fonts yet. But you can download them now with', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_google_font_just_click'] = esc_html__('just a click', 'wp-rem-frame');
			/*
             * Custom Font
             */
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_browse'] = esc_html__('Browse', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_theme_option_custom_font_name'] = esc_html__('Font Name', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_theme_option_custom_font_woff'] = esc_html__('Custom Font .woff', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_theme_option_custom_font_woff_hint'] = esc_html__('Upload Your Custom Font file in .woff format', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_theme_option_custom_font_ttf'] = esc_html__('Custom Font .ttf', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_theme_option_custom_font_ttf_hint'] = esc_html__('Upload Your Custom Font file in .ttf format', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_theme_option_custom_font_svg'] = esc_html__('Custom Font .svg', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_theme_option_custom_font_svg_hint'] = esc_html__('Upload Your Custom Font file in .svg format', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_theme_option_custom_font_eot'] = esc_html__('Custom Font .eot', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_theme_option_custom_font_eot_hint'] = esc_html__('Upload Your Custom Font file in .eot format', 'wp-rem-frame');
            $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_theme_option_custom_fonts'] = esc_html__('Custom Fonts', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_cs_var_add_custom_fonts_list'] = esc_html__('+ Add to Custom Fonts List', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_custom_fonts_fields_empty'] = esc_html__('Please fill all mandatory fields.', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_selected_custom_fonts_is_deleted'] = esc_html__('Selected custom font is deleted in custom font list.', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_custom_fonts_is_deleted'] = esc_html__('Custom font is deleted in custom font list.', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_add_new_custom_font'] = esc_html__('Add new Custom Font', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_add_to_selected_custom_fonts'] = esc_html__('Add to List', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_add_in_selected_custom_fonts'] = esc_html__('Added in List', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_your_selected_custom_fonts'] = esc_html__('Your Selected Custom Fonts', 'wp-rem-frame');
			
			$wp_rem_cs_var_frame_static_text['wp_rem_google_font_attr_select_all'] = esc_html__('Select All', 'wp-rem-frame');
			$wp_rem_cs_var_frame_static_text['wp_rem_google_font_attr_unselect_all'] = esc_html__('Un-Select All', 'wp-rem-frame');

            return $wp_rem_cs_var_frame_static_text;
        }

    }

}
new wp_rem_cs_var_frame_all_strings;
/*
  $wp_rem_cs_strings = array(
  'wp_rem_cs_var_tabs' => __('Tabs', 'wp-rem-frame'),
  'wp_rem_cs_var_tabs_desc' => __('You can manage your tabs using this shortcode', 'wp-rem-frame'),
  'wp_rem_cs_var_tab_active' => __('Tab Active', 'wp-rem-frame'),
  'wp_rem_cs_var_tab_active_hint' => __('Select Tab ON/OFF option here', 'wp-rem-frame'),
  'wp_rem_cs_var_tab_item_text' => __('Tab Item Text', 'wp-rem-frame'),
  'wp_rem_cs_var_tab_item_text_hint' => __('Enter tab Item text here', 'wp-rem-frame'),
  'wp_rem_cs_var_tab_desc' => __('Tab Description', 'wp-rem-frame'),
  'wp_rem_cs_var_tab_desc_hint' => __('Enter the tab description here.', 'wp-rem-frame'),
  'wp_rem_cs_var_tab_icon' => __('Tab Icon', 'wp-rem-frame'),
  'wp_rem_cs_var_tab_icon_hint' => __('Select the Icons you would like to show with your tab .', 'wp-rem-frame'),
  );
  foreach ($wp_rem_cs_strings as $key => $value) {
  echo '$wp_rem_cs_var_frame_static_text[\'' . $key . '\'] = __(\'' . $value . '\' , 'wp-rem-frame'); ';
  echo '<br />';
  }
 */

//wp_rem_cs_var_frame_all_strings();
?>