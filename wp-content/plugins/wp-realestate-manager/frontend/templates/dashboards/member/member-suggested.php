<?php
/**
 * Member Suggested Data
 *
 */
if (!class_exists('Wp_rem_Member_Suggested')) {

    class Wp_rem_Member_Suggested {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action('wp_ajax_wp_rem_member_suggested', array($this, 'wp_rem_member_suggested_callback'), 11, 1);
            add_action('wp_ajax_wp_rem_save_suggested_data', array($this, 'wp_rem_save_suggested_data_callback'), 11, 1);
            add_action('wp_ajax_wp_rem_add_team_member', array($this, 'wp_rem_add_team_member_callback'), 11, 1);
            add_action('wp_ajax_wp_rem_update_team_member', array($this, 'wp_rem_update_team_member_callback'), 11);
            add_action('wp_ajax_wp_rem_remove_team_member', array($this, 'wp_rem_remove_team_member_callback'), 11);
            add_action('wp_ajax_transient_call_back', array($this, 'transient_call_back'), 11);
            add_action('wp_ajax_nopriv_transient_call_back', array($this, 'transient_call_back'), 11);
            add_action('clear_auth_cookie', array($this, 'clear_transient_on_logout'), 11);
        }

        /**
         * Member Suggested Form
         */
        public function wp_rem_member_suggested_callback($member_id = '') {

            global $wp_rem_html_fields_frontend, $post, $wp_rem_form_fields_frontend, $wp_rem_plugin_options, $wp_rem_post_property_types, $wp_rem_shortcode_properties_frontend;

            $pagi_per_page = isset($wp_rem_plugin_options['wp_rem_member_dashboard_pagination']) ? $wp_rem_plugin_options['wp_rem_member_dashboard_pagination'] : '';

            $user = wp_get_current_user();
            $suggested_default_properties_categories = '';

            $this->wp_rem_default_suggestions_settings_dashboard_callback();

            $wp_rem_dashboard_announce_title = isset($wp_rem_plugin_options['wp_rem_dashboard_announce_title']) ? $wp_rem_plugin_options['wp_rem_dashboard_announce_title'] : '';
            $wp_rem_dashboard_announce_description = isset($wp_rem_plugin_options['wp_rem_dashboard_announce_description']) ? $wp_rem_plugin_options['wp_rem_dashboard_announce_description'] : '';
            $wp_rem_announce_bg_color = isset($wp_rem_plugin_options['wp_rem_announce_bg_color']) ? $wp_rem_plugin_options['wp_rem_announce_bg_color'] : '#2b8dc4';
            ?>
            <?php
            if ((isset($wp_rem_dashboard_announce_title) && $wp_rem_dashboard_announce_title <> '') || (isset($wp_rem_dashboard_announce_description) && $wp_rem_dashboard_announce_description <> '')) {
                if ('true' !== get_transient('cookie_close' . $user->ID)) {
                    ?>
                    <div id="close-me" class="user-message" style="background-color:<?php echo esc_html($wp_rem_announce_bg_color); ?>;" > 
                        <a onclick="transient_call_back('<?php echo esc_html($user->ID) ?>')" class="close close-div" href="javascript:void(0);"><i class="icon-cross-out"></i></a>
                        <h2><?php echo esc_html($wp_rem_dashboard_announce_title); ?></h2>
                        <p><?php echo htmlspecialchars_decode($wp_rem_dashboard_announce_description); ?></p>
                    </div>

                    <?php
                }
            }
            ?>
            <script>
                function transient_call_back(id) {
                    "use strict";
                    var dataString = 'user_id=' + id + '&action=transient_call_back';
                    jQuery.ajax({
                        type: "POST",
                        url: wp_rem_globals.ajax_url,
                        data: dataString,
                        success: function (response) {
                            if (response != 'error') {
                                jQuery("#close-me").remove();
                            }
                        }
                    });
                    return false;
                }

            </script>
            <div class="row">

                <?php do_action('wp_rem_new_notifications'); ?>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="user-suggest-list">
                        <div class="element-title">
                            <h4><?php echo wp_rem_plugin_text_srt( 'wp_rem_member_suggested_ads' ); ?></h4>
                            <span><?php echo wp_rem_plugin_text_srt( 'wp_rem_member_define' ) . ' ' . force_balance_tags( '<em data-target="#suggestions-box" data-toggle="modal">' . wp_rem_plugin_text_srt( 'wp_rem_member_search_criteria' ) . '</em>' . wp_rem_plugin_text_srt( 'wp_rem_member_specific' )); ?></span>
                        </div>
                        <?php
                        $suggested_properties_categories = array();
                        $suggested_properties_max_properties = 20;
                        if ($user->ID > 0) {
                            $suggested_properties_categories = get_user_meta($user->ID, 'suggested_properties_categories', true);
                            $suggested_properties_max_properties = get_user_meta($user->ID, 'suggested_properties_max_properties', true);
                        }

                        $posts_per_page = $pagi_per_page > 0 ? $pagi_per_page : 10;
                        $posts_paged = isset($_REQUEST['page_id_all']) ? $_REQUEST['page_id_all'] : '';

                        if ($suggested_properties_max_properties < $posts_per_page) {
                            $posts_per_page = $suggested_properties_max_properties;
                        }

                        $all_category_in_array = in_array('all_categories', $suggested_properties_categories);
                        $cate_filter_multi_arr = '';
                        if (isset($suggested_properties_categories) && empty($all_category_in_array)) {
                            if (count($suggested_properties_categories) > 0) {
                                $cate_filter_multi_arr ['relation'] = 'OR';
                                foreach ($suggested_properties_categories as $suggested_properties_categories_single) {
                                    $cate_filter_multi_arr[] = array(
                                        'key' => 'wp_rem_property_category',
                                        'value' => serialize($suggested_properties_categories_single),
                                        'compare' => 'LIKE',
                                    );
                                }
                            }
                        }


                        $args = array(
                            'posts_per_page' => $posts_per_page,
                            'paged' => $posts_paged,
                            'post_type' => 'properties',
                            'post_status' => 'publish',
                            'meta_query' => array(
                                'relation' => 'AND',
                                array(
                                    'key' => 'wp_rem_property_posted',
                                    'value' => strtotime(date("d-m-Y")),
                                    'compare' => '<=',
                                ),
                                array(
                                    'key' => 'wp_rem_property_expired',
                                    'value' => strtotime(date("d-m-Y")),
                                    'compare' => '>=',
                                ),
                                array(
                                    'key' => 'property_member_status',
                                    'value' => 'active',
                                    'compare' => '=',
                                ),
                                array(
                                    'key' => 'wp_rem_property_status',
                                    'value' => 'delete',
                                    'compare' => '!=',
                                ),
                                $cate_filter_multi_arr,
                            ),
                        );
                        $custom_query = new WP_Query($args);
                        $total_posts = $custom_query->found_posts;
                        $all_properties = $custom_query->posts;
                        ?>
                        <ul class="user-suggest-list-holder">
                            <?php
                            if (isset($all_properties) && !empty($all_properties)) {
                                foreach ($all_properties as $property_data) {
                                    $post = $property_data;
                                    setup_postdata($post);
                                    $wp_rem_property_type = get_post_meta(get_the_ID(), 'wp_rem_property_type', true);
                                    if ($property_type_post = get_page_by_path($wp_rem_property_type, OBJECT, 'property-type'))
                                    $property_type_id = $property_type_post->ID;
                                    $wp_rem_cate_str = '';
                                    $wp_rem_property_category = get_post_meta(get_the_ID(), 'wp_rem_property_category', true);
                                    $wp_rem_post_loc_address_property = get_post_meta(get_the_ID(), 'wp_rem_post_loc_address_property', true);

                                    if (!empty($wp_rem_property_category) && is_array($wp_rem_property_category)) {
                                        $comma_flag = 0;
                                        foreach ($wp_rem_property_category as $cate_slug => $cat_val) {
                                            $wp_rem_cate = get_term_by('slug', $cat_val, 'property-category');

                                            if (!empty($wp_rem_cate)) {
                                                $cate_link = wp_rem_property_category_link($property_type_id, $cat_val);
                                                if ($comma_flag != 0) {
                                                    $wp_rem_cate_str .= ', ';
                                                }
                                                $wp_rem_cate_str = '<a href="' . $cate_link . '">' . $wp_rem_cate->name . '</a>';
                                                $comma_flag ++;
                                            }
                                        }
                                    }
                                    $property_post_on = get_post_meta(get_the_ID(), 'wp_rem_property_posted', true);
                                    $property_post_expiry = get_post_meta(get_the_ID(), 'wp_rem_property_expired', true);
                                    $property_status = get_post_meta(get_the_ID(), 'wp_rem_property_status', true);
                                    ?>
                                    <li>
                                        <div class="suggest-list-holder">
                                            <div class="img-holder">
                                                <a href="<?php echo esc_url(get_the_permalink()); ?>">
                                                    <figure>
                                                        <?php
                                                        if (function_exists('property_gallery_first_image')) {
															$gallery_image_args = array(
																'property_id' => get_the_ID(),
																'size' => 'thumbnail',
																'class' => '',
																'default_image_src' => esc_url(wp_rem::plugin_url() . 'assets/frontend/images/no-image4x3.jpg')
															);
															echo $property_gallery_first_image = property_gallery_first_image($gallery_image_args); 
														}
                                                        ?>
                                                    </figure>
                                                </a>
                                            </div>
                                            <div class="text-holder">
                                                <h6><a href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></h6>
                                                <?php if ($wp_rem_cate_str != '') { ?>
                                                    <span class="rent-label"><?php echo wp_rem_allow_special_char($wp_rem_cate_str); ?></span>
                                                    <?php
                                                }
                                                $post_id = get_the_ID();
                                                $favourite_label = 'Favourite';
                                                $favourite_label = 'Favourite';
                                                $book_mark_args = array(
                                                    'before_icon' => '<i class="icon-heart-o"></i>',
                                                    'after_icon' => '<i class="icon-heart5"></i>',
                                                );
                                                do_action('wp_rem_favourites_frontend_button', $post_id, $book_mark_args);
                                                ?>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                            }
                            wp_reset_postdata();
                            ?>
                        </ul>
                    </div>
                    <?php
                    $total_pages = 1;
                    if ($total_posts > 0 && $posts_per_page > 0 && $total_posts > $posts_per_page) {
                        $total_pages = ceil($total_posts / $posts_per_page);
                        $wp_rem_dashboard_page = isset($wp_rem_plugin_options['wp_rem_member_dashboard']) ? $wp_rem_plugin_options['wp_rem_member_dashboard'] : '';
                        $wp_rem_dashboard_link = $wp_rem_dashboard_page != '' ? get_permalink($wp_rem_dashboard_page) : '';
                        $this_url = $wp_rem_dashboard_link != '' ? add_query_arg(array('dashboard' => 'suggested'), $wp_rem_dashboard_link) : '';
                        wp_rem_dashboard_pagination($total_pages, $posts_paged, $this_url, 'suggested');
                    }
                    ?>
                </div>
            </div>
            <div class="modal fade" id="suggestions-box" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
                <div class="modal-dialog" role="document">
                    <div class="login-form">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><?php echo esc_html('&times;', 'wp-rem'); ?></span>
                                </button>
                                <h3 class="modal-title"><?php echo esc_html('Suggested Properties Settings', 'wp-rem'); ?></h3>
                            </div>
                            <div class="modal-body">
                                <div class="status status-message"></div>
                                <form method="post" class="wp-user-form webkit" id="ControlForm_suggestions">
                                    <div class="input-filed">
                                        <?php
                                        $select_options = '';
                                        $select_options = array('all_categories' => wp_rem_plugin_text_srt( 'wp_rem_member_all_categories' ));
                                        $wp_rem_post_property_types = new Wp_rem_Post_Property_Types();
                                        $property_types_array = $wp_rem_post_property_types->wp_rem_types_array_callback();
                                        foreach ($property_types_array as $key => $value) {
                                            if ($key != 'all') {
                                                $wp_rem_property_type_category_array = $wp_rem_shortcode_properties_frontend->wp_rem_property_filter_categories($key, '');

                                                if (isset($wp_rem_property_type_category_array['cate_list']) && is_array($wp_rem_property_type_category_array['cate_list'])) {
                                                    foreach ($wp_rem_property_type_category_array['cate_list'] as $category) {
                                                        if ($category != '') {
                                                            $term = get_term_by('slug', $category, 'property-category');
                                                            $property_type_category_slug = $term->slug;
                                                            $property_type_category_lable = $term->name;
                                                            $select_options[$property_type_category_slug] = $property_type_category_lable . ' - ' . $value;
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        $wp_rem_opt_array = array(
                                            'id' => 'suggested_properties_categories',
                                            'cust_id' => 'suggested_properties_categories',
                                            'cust_name' => 'suggested_properties_categories[]',
                                            'std' => $suggested_properties_categories,
                                            'desc' => '',
                                            'extra_atr' => 'data-placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_member_select_categories' ) . '"',
                                            'options' => $select_options,
                                            'hint_text' => '',
                                            'required' => 'yes',
                                            'return' => false,
                                            'description' => '',
                                            'name' => wp_rem_plugin_text_srt( 'wp_rem_member_categories_for_sugg' ),
                                        );

                                        $wp_rem_form_fields_frontend->wp_rem_form_multiselect_render($wp_rem_opt_array);
                                        ?>
                                    </div>
                                    <div class="input-filed">
                                        <label><?php echo wp_rem_plugin_text_srt( 'wp_rem_member_no_of_suggestions' ); ?></label>
                                        <?php
                                        $wp_rem_opt_array = array(
                                            'id' => '',
                                            'std' => $suggested_properties_max_properties,
                                            'cust_id' => 'suggested_properties_max_properties',
                                            'cust_name' => 'suggested_properties_max_properties',
                                            'classes' => 'form-control',
                                            'extra_atr' => ' tabindex="11" placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_member_example' ) . '"',
                                            'return' => false,
                                        );
                                        $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                        ?>
                                    </div>
                                    <div class="input-filed">
                                        <div class="search-criteria-loader input-button-loader">
                                            <input type="button" class="btn-suggestions-settings cs-bgcolor" name="submit-suggestions-settings" value="<?php echo wp_rem_plugin_text_srt( 'wp_rem_member_save_settings' ); ?>">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>          

                        <script type="text/javascript">
                            (function ($) {
                                $(function () {
                                    $(".btn-suggestions-settings").click(function () {
                                        var thisObj = jQuery(".search-criteria-loader");
                                        wp_rem_show_loader('.search-criteria-loader', '', 'button_loader', thisObj);
                                        var input_data = $('#ControlForm_suggestions').serialize() + '&action=wp_rem_save_suggestions_settings_dashboard';
                                        $.ajax({
                                            type: "POST",
                                            url: "<?php echo esc_js(admin_url('admin-ajax.php')); ?>",
                                            data: input_data,
                                            dataType: "json",
                                            success: function (data) {
                                                wp_rem_show_response(data, '#ControlForm_suggestions', thisObj);
                                                if (data.type == 'success') {
                                                    setTimeout(function () {
                                                        jQuery("#suggestions-box").modal('toggle');
                                                        jQuery('#wp_rem_member_suggested').trigger('click');
                                                    }, 900);
                                                }
                                            },
                                        });
                                        return false;
                                    });
                                    $('#wp_rem_suggested_properties_categories').chosen();
                                });
                            })(jQuery);
                        </script>
                    </div>
                </div>
            </div>
            <?php
            wp_die();
        }

        public function transient_call_back() {
            set_transient("cookie_close" . $_POST['user_id'], 'true', (3600 * 60) * 24);
            wp_die();
        }

        public function clear_transient_on_logout() {
            $user_data = wp_get_current_user();
            delete_transient('cookie_close' . $user_data->ID);
        }

        /**
         * Member Suggested Saving Data
         */
        public function wp_rem_save_suggested_data_callback() {

            $suggested_id = wp_rem_get_input('member_suggested_id', NULL, 'INT');
            $suggested_name = wp_rem_get_input('member_suggested_name', NULL, 'STRING');
            $website_url = wp_rem_get_input('member_suggested_website', NULL, 'STRING');
            $suggested_phone = wp_rem_get_input('member_suggested_phone', NULL, 'STRING');
            $suggested_content = wp_rem_get_input('wp_rem_member_suggested_description', NULL, 'STRING');
            $post_data = array(
                'ID' => $suggested_id,
                'post_title' => $suggested_name,
                'post_content' => $suggested_content,
            );

            wp_update_post($post_data);

            update_post_meta($suggested_id, 'wp_rem_website', $website_url);
            update_post_meta($suggested_id, 'wp_rem_phone_number', $suggested_phone);

            $response_array = array(
                'type' => 'success',
                'msg' => 'Successfully Updated!'
            );
            echo json_encode($response_array);
            wp_die();
        }

        /*
         * Adding Team Member
         */

        public function wp_rem_add_team_member_callback() {
            $first_name = wp_rem_get_input('wp_rem_first_name', NULL, 'STRING');
            $last_name = wp_rem_get_input('wp_rem_last_name', NULL, 'STRING');
            $permissions = wp_rem_get_input('permissions', NULL, 'ARRAY');
            $email = wp_rem_get_input('wp_rem_email_address', NULL, 'STRING');
            if ($email == NULL) {
                $response_array = array(
                    'type' => 'error',
                    'msg' => wp_rem_plugin_text_srt( 'wp_rem_member_sugg_provide_email' ),
                );
                echo json_encode($response_array);
                wp_die();
            }
            if (email_exists($email)) {
                $response_array = array(
                    'type' => 'error',
                    'msg' => wp_rem_plugin_text_srt( 'wp_rem_member_sugg_email_exists' ),
                );
                echo json_encode($response_array);
                wp_die();
            }

            $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);

            $user_ID = wp_create_user($email, $random_password, $email);

            if (!is_wp_error($user_ID)) {

                wp_update_user(array(
                    'ID' => $user_ID,
                    'role' => 'wp_rem_member'
                ));

                update_user_meta($user_ID, 'show_admin_bar_front', false);

                if ($permissions != NULL) {
                    update_user_meta($user_ID, 'wp_rem_permissions', $permissions);
                }



                if ($first_name != NULL) {
                    update_user_meta($user_ID, 'first_name', $first_name);
                }

                if ($last_name != NULL) {
                    update_user_meta($user_ID, 'last_name', $last_name);
                }


                update_user_meta($user_ID, 'wp_rem_user_type', 'team-member');
                update_user_meta($user_ID, 'wp_rem_user_status', 'active');

                $suggested_ID = get_user_meta(get_current_user_id(), 'wp_rem_suggested', true);
                update_user_meta($user_ID, 'wp_rem_suggested', $suggested_ID);
                update_user_meta($user_ID, 'wp_rem_is_admin', 0);

                $message = 'Hi, ' . $first_name . ' ' . $last_name . ' ';
                $message .= 'Your account was created on wp_rem, you can login with following details  ';
                $message .= 'Username: ' . $email . ' | ';
                $message .= 'Password: ' . $random_password . '';

                /*
                 * Sending Email with login details.
                 */
                $email_array = array(
                    'to' => $email,
                    'subject' => 'Login Details',
                    'message' => $message,
                );

                do_action('wp_rem_send_mail', $email_array);

                $response_array = array(
                    'type' => 'success',
                    'msg' => wp_rem_plugin_text_srt( 'wp_rem_member_team_member_added' ),
                );
                echo json_encode($response_array);

                wp_die();
            }
        }

        /*
         * Updating Team Member
         */

        public function wp_rem_update_team_member_callback() {
            $user_ID = wp_rem_get_input('wp_rem_user_id', NULL, 'INT');

            $permissions = wp_rem_get_input('permissions', '', 'ARRAY');
            update_user_meta($user_ID, 'wp_rem_permissions', $permissions);

            $response_array = array(
                'type' => 'success',
                'msg' => wp_rem_plugin_text_srt( 'wp_rem_member_team_member_updated' ),
            );
            echo json_encode($response_array);
            wp_die();
        }

        /*
         * Removing Team Member
         * @ User ID
         */

        public function wp_rem_remove_team_member_callback() {
            $user_ID = wp_rem_get_input('wp_rem_user_id', NULL, 'INT');
            update_user_meta($user_ID, 'wp_rem_user_status', 'deleted');
            $response_array = array(
                'type' => 'success',
                'msg' => wp_rem_plugin_text_srt( 'wp_rem_member_team_member_removed' ),
            );
            echo json_encode($response_array);
            wp_die();
        }

        /**
         * Suggestions default settings for user's dashaboard.
         */
        public function wp_rem_default_suggestions_settings_dashboard_callback() {
            $suggested_default_properties_categories = array();
            $suggested_default_properties_categories[] = 'all_categories';
            $suggested_properties_max_properties = 20;
            if (!empty($suggested_default_properties_categories) && $suggested_properties_max_properties != '') {
                $user = wp_get_current_user();
                if ($user->ID > 0) {
                    $user_selected_cats = get_user_meta($user->ID, 'suggested_properties_categories', true);
                    if (empty($user_selected_cats) || $user_selected_cats == '') {
                        update_user_meta($user->ID, 'suggested_properties_categories', $suggested_default_properties_categories);
                        update_user_meta($user->ID, 'suggested_properties_max_properties', $suggested_properties_max_properties);
                    }
                }
            }
        }

    }

    global $wp_rem_member_suggested;
    $wp_rem_member_suggested = new Wp_rem_Member_Suggested();
}
