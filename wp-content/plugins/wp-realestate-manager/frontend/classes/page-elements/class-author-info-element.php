<?php
/**
 * File Type: Property Author info Page Element
 */
if ( ! class_exists('wp_rem_author_info_element') ) {

    class wp_rem_author_info_element {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action('wp_rem_author_info_html', array( $this, 'wp_rem_author_info_html_callback' ), 11, 1);
            add_filter('wp_rem_member_members_count', array( $this, 'wp_rem_member_members_count_callback' ), 11, 1);
        }

        public function wp_rem_author_info_html_callback($property_id = '') {
            global $post, $wp_rem_plugin_options, $Wp_rem_Captcha, $wp_rem_form_fields;
			
			$content_bottom_member_info = isset($wp_rem_plugin_options['wp_rem_property_detail_page_content_bottom_member_info']) ? $wp_rem_plugin_options['wp_rem_property_detail_page_content_bottom_member_info'] : '';
			if( $content_bottom_member_info != 'on' ){
				return;
			}

            $wp_rem_captcha_switch = '';
            $wp_rem_captcha_switch = isset($wp_rem_plugin_options['wp_rem_captcha_switch']) ? $wp_rem_plugin_options['wp_rem_captcha_switch'] : '';
            $wp_rem_sitekey = isset($wp_rem_plugin_options['wp_rem_sitekey']) ? $wp_rem_plugin_options['wp_rem_sitekey'] : '';
            $wp_rem_secretkey = isset($wp_rem_plugin_options['wp_rem_secretkey']) ? $wp_rem_plugin_options['wp_rem_secretkey'] : '';
            if ( $property_id == '' ) {
                $property_id = $post->ID;
            }
            if ( $property_id != '' ) {

                $wp_rem_property_member_id = get_post_meta($property_id, 'wp_rem_property_member', true);
                if ( isset($wp_rem_property_member_id) && $wp_rem_property_member_id <> '' && TRUE == get_post_status($wp_rem_property_member_id) ) {
                    ?>
                    <div id="email-friend" class="profile-info">
                        <?php
                        $member_image_id = get_post_meta($wp_rem_property_member_id, 'wp_rem_profile_image', true);
                        $member_image = wp_get_attachment_url($member_image_id);
                        if ( $member_image == '' ) {
                            $member_image = esc_url(wp_rem::plugin_url() . 'assets/frontend/images/member-no-image.jpg');
                        }
                        $wp_rem_member_title = '';
                        if ( isset($wp_rem_property_member_id) && $wp_rem_property_member_id <> '' ) {
                            $wp_rem_member_title = get_the_title($wp_rem_property_member_id);
                        }
                        $wp_rem_post_loc_address_member = get_post_meta($wp_rem_property_member_id, 'wp_rem_post_loc_address_member', true);
                        $wp_rem_member_phone_num = get_post_meta($wp_rem_property_member_id, 'wp_rem_phone_number', true);
                        $wp_rem_member_email_address = get_post_meta($wp_rem_property_member_id, 'wp_rem_email_address', true);
                        ?>
                        <?php if ( isset($member_image) && $member_image <> '' ) { ?>
                            <div class="img-holder">
                                <figure>
                                    <a href="<?php echo get_the_permalink($wp_rem_property_member_id); ?>">
                                        <img src="<?php echo esc_url($member_image); ?>" alt="<?php esc_html($wp_rem_member_title); ?>" />
                                    </a>
                                </figure>
                            </div>
                        <?php } ?>
                        <div class="text-holder">
                            <?php if ( isset($wp_rem_member_title) && $wp_rem_member_title != '' ) { ?>
                                <a href="<?php echo get_the_permalink($wp_rem_property_member_id); ?>">
                                    <h5><?php echo esc_html($wp_rem_member_title); ?></h5>
                                </a>
                            <?php } ?>
                            <ul>
                                <?php if ( isset($wp_rem_post_loc_address_member) && $wp_rem_post_loc_address_member != '' ) { ?>
                                    <li><i class="icon-location"></i><?php echo esc_html($wp_rem_post_loc_address_member); ?></li>
                                <?php } ?>
                                <?php if ( isset($wp_rem_member_phone_num) && $wp_rem_member_phone_num != '' ) { ?>
                                    <li><i class="icon-phone3 "></i><?php echo esc_html($wp_rem_member_phone_num); ?></li>
                                <?php } ?>
                            </ul>
                            <?php
                            ob_start();
                            do_action('wp_rem_opening_hours_element_html', $wp_rem_property_member_id);
                            $opening_hours_val = ob_get_clean();
                            if ( $opening_hours_val ) {
                                ?>
                                <div class="field-select-holder">
                                    <?php echo do_action('wp_rem_opening_hours_element_html', $wp_rem_property_member_id); ?>
                                </div>
                            <?php } ?>
                            <?php
							$target_modal = 'sign-in';
                            $target_class = ' wp-rem-open-signin-tab';
                            // if ( is_user_logged_in() ) {
                                $target_class = '';
								$target_modal = ' data-toggle="modal" data-target="#enquiry-modal"';
                            // }
                            ?>
                            <a href="javascript:void(0);" class="submit-btn bgcolor<?php echo esc_attr($target_class); ?>"<?php echo ($target_modal); ?>><?php echo wp_rem_plugin_text_srt('wp_rem_author_info_request_details'); ?></a>
                        </div>
                    </div>
                    <?php
                }
            }
        }



        /*
         * get member count by member id
         */

        public function wp_rem_member_members_count_callback($member_id) {

            $team_args = array(
                'role' => 'wp_rem_member',
                'meta_query' => array(
                    array(
                        'key' => 'wp_rem_company',
                        'value' => $member_id,
                        'compare' => '='
                    ),
                    array(
                        'key' => 'wp_rem_user_status',
                        'value' => 'deleted',
                        'compare' => '!='
                    )
                    , array(
                        'key' => 'wp_rem_public_profile',
                        'value' => 'yes',
                        'compare' => '='
                    ),
                ),
            );
            $custom_query_property = new WP_User_Query($team_args);
            $users_count = (int) $custom_query_property->get_total();
            return $users_count;
        }

    }

    global $wp_rem_author_info;
    $wp_rem_author_info = new wp_rem_author_info_element();
}