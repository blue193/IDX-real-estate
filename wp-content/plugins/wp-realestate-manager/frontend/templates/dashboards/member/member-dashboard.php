<?php
/**
 * The template for displaying member dashboard
 *
 */
function cs_member_popup_style() {
    wp_enqueue_style('custom-member-style-inline', plugins_url('../../../../assets/frontend/css/custom_script.css', __FILE__));
    $cs_plugin_options = get_option('cs_plugin_options');
    $cs_custom_css = '#id_confrmdiv
    {
        display: none;
        background-color: #eee;
        border-radius: 5px;
        border: 1px solid #aaa;
        position: fixed;
        width: 300px;
        left: 50%;
        margin-left: -150px;
        padding: 6px 8px 8px;
        box-sizing: border-box;
        text-align: center;
    }
    #id_confrmdiv .button {
        background-color: #ccc;
        display: inline-block;
        border-radius: 3px;
        border: 1px solid #aaa;
        padding: 2px;
        text-align: center;
        width: 80px;
        cursor: pointer;
    }
    #id_confrmdiv .button:hover
    {
        background-color: #ddd;
    }
    #confirmBox .message
    {
        text-align: left;
        margin-bottom: 8px;
    }';
    wp_add_inline_style('custom-member-style-inline', $cs_custom_css);
}
add_action('wp_enqueue_scripts', 'cs_member_popup_style', 5);
get_header();
//editor
wp_enqueue_style('jquery-te');
wp_enqueue_script('jquery-te');

//iconpicker
wp_enqueue_style('fonticonpicker');
wp_enqueue_script('fonticonpicker');
wp_enqueue_script('wp-rem-reservation-functions');
wp_enqueue_script('wp-rem-validation-script');
wp_enqueue_script('wp-rem-members-script');

wp_enqueue_script('jquery-latlon-picker');

$post_id = get_the_ID();
$user_details = wp_get_current_user();
global $wp_rem_plugin_options;
$user_company_id = get_user_meta($user_details->ID, 'wp_rem_company', true);
$fullName = isset($user_company_id) && $user_company_id != '' ? get_the_title($user_company_id) : '';
if ( is_super_admin() ) {
    $fullName = $userdata->display_name;
}
$profile_image_id = $wp_rem_member_profile->member_get_profile_image($user_details->ID);
$member_profile_type = get_user_meta($user_details->ID, 'wp_rem_member_profile_type', true);
$user_type = get_user_meta($user_details->ID, 'wp_rem_user_type', true);
$profile_description = $user_details->description;
?>
<div id="main">
    <div class="page-section account-header">
        <div class="container">
            <?php
            $member_profile_status = get_post_meta($user_company_id, 'wp_rem_user_status', true);
            if ( $member_profile_status != 'active' ) {
                ?>
                <div class="user-message alert" style="background-color:#ff6767">
                    <p><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_profile_not_active'); ?></p>
                </div>
                <?php
            }
            ?>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="user-account-holder">
                        <div class="user-info user-info-sidebar">
                            <?php
                            if ( isset($profile_image_id) && $profile_image_id !== '' ) {
                                if ( is_numeric($profile_image_id) ) {
                                    $profile_image_id = wp_get_attachment_url($profile_image_id);
                                }
                            }
                            if ( $profile_image_id == '' ) {
                                $profile_image_id = wp_rem::plugin_url() . '/assets/frontend/images/member-no-image.jpg';
                            }
                            echo '
							<div class="img-holder">
								<figure><img src="' . esc_url($profile_image_id) . '" alt=""></figure>
							</div>';
                            ?>
                            <div class="text-holder">
                                <?php
                                if ( isset($fullName) && $fullName != '' ) {
                                    echo '<h3 class="user-full-name">' . $fullName . '</h3>';
                                }
                                ?>
                                <p><?php echo force_balance_tags($profile_description); ?></p>
                                <?php
                                $change_pass_text = wp_rem_plugin_text_srt('wp_rem_member_dashboard_change_pass');
                                if ( $user_type == 'team-member' ) {
                                    $change_pass_text = wp_rem_plugin_text_srt('wp_rem_member_dashboard_my_profile');
                                }
                                ?>
                                <div class="user_dashboard_ajax" id="wp_rem_member_change_password" data-queryvar="dashboard=change_pass"><a class="btn-change-password" href="javascript:void(0)"><?php echo esc_html($change_pass_text); ?></a></div>

                            </div>
                        </div>
                    </div>
                    <div class="user-account-nav user-account-sidebar">
                        <div class="user-account-holder">
                            <?php
                            $active_tab = ''; // default tab
                            $child_tab = '';
                            $wp_rem_dashboard_page = isset($wp_rem_plugin_options['wp_rem_member_dashboard']) ? $wp_rem_plugin_options['wp_rem_member_dashboard'] : '';
                            $wp_rem_dashboard_link = $wp_rem_dashboard_page != '' ? get_permalink($wp_rem_dashboard_page) : '';

                            if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'account' ) { // for account settings active tab
                                $active_tab = 'wp_rem_member_accounts';
                            }
                            ?>
                            <ul class="dashboard-nav">
                                <?php
                                if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'suggested' ) {
                                    $active_tab = 'wp_rem_member_suggested';
                                }
                                ?>
                                <li class="user_dashboard_ajax active" id="wp_rem_member_suggested" data-queryvar="dashboard=suggested"><a href="javascript:void(0);"><i class="icon-dashboard"></i><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_Dashboard'); ?></a></li>

                                <?php
                                $current_user = wp_get_current_user();
                                $wp_rem_user_type = get_user_meta($current_user->ID, 'wp_rem_user_type', true);
                                $member_id = wp_rem_company_id_form_user_id($current_user->ID);
                                $member_profile_type = '';
                                if ( $member_id != '' ) {
                                    $member_profile_type = get_post_meta($member_id, 'wp_rem_member_profile_type', true);
                                }
                                $args = array(
                                    'posts_per_page' => "1",
                                    'post_type' => 'properties',
                                    'post_status' => 'publish',
                                    'fields' => 'ids',
                                    'meta_query' => array(
                                        'relation' => 'AND',
                                        array(
                                            'key' => 'wp_rem_property_member',
                                            'value' => $member_id,
                                            'compare' => '=',
                                        ),
                                        array(
                                            'key' => 'wp_rem_property_status',
                                            'value' => 'delete',
                                            'compare' => '!=',
                                        ),
                                    ),
                                );
                                $custom_query = new WP_Query($args);
                                $total_properties = $custom_query->found_posts;
                                wp_reset_postdata();
                                if ( true === Wp_rem_Member_Permissions::check_permissions('properties') ) {
                                    if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'properties' ) {
                                        $active_tab = 'wp_rem_member_properties';
                                    }
                                    ?>
                                    <li class="user_dashboard_ajax" id="wp_rem_member_properties" data-queryvar="dashboard=properties"><a href="javascript:void(0);"><i class="icon-megaphone2"></i><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_my_prop'); ?></a><b class="label"><?php echo absint($total_properties); ?></b></li>
                                    <?php
                                }

                                if ( true === Wp_rem_Member_Permissions::check_permissions('enquiries') ) {
                                    $args = array(
                                        'post_type' => 'property_enquiries',
                                        'post_status' => 'publish',
                                        'posts_per_page' => '-1',
                                        'fields' => 'ids',
                                        'meta_query' => array(
                                            'relation' => 'AND',
                                            array(
                                                'key' => 'wp_rem_enquiry_member',
                                                'value' => $member_id,
                                                'compare' => '=',
                                            )
                                        ),
                                    );

                                    $enquiry_query = new WP_Query($args);
                                    $total_enquiries = $enquiry_query->found_posts;
                                    wp_reset_postdata();
                                    if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'enquiries' ) {
                                        $active_tab = 'wp_rem_member_enquiries';
                                    }
                                    ?>
                                    <li class="user_dashboard_ajax" id="wp_rem_member_enquiries" data-queryvar="dashboard=enquiries"><a href="javascript:void(0);"><i class="icon-question_answer"></i><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_enquires'); ?></a><b class="label"><?php echo absint($total_enquiries); ?></b></li>

                                    <?php
                                }

                                if ( true === Wp_rem_Member_Permissions::check_permissions('arrange_viewings') ) {
                                    $args = array(
                                        'post_type' => 'property_viewings',
                                        'post_status' => 'publish',
                                        'posts_per_page' => '-1',
                                        'fields' => 'ids',
                                        'meta_query' => array(
                                            'relation' => 'AND',
                                            array(
                                                'key' => 'wp_rem_viewing_member',
                                                'value' => $member_id,
                                                'compare' => '=',
                                            )
                                        ),
                                    );

                                    $order_query = new WP_Query($args);
                                    $total_inquiries = $order_query->found_posts;
                                    wp_reset_postdata();
                                    if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'viewings' ) {
                                        $active_tab = 'wp_rem_member_viewings';
                                    }
                                    if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'viewings_received' ) {
                                        $child_tab = 'wp_rem_member_received_viewings';
                                        $active_tab = 'wp_rem_member_viewings';
                                    }
                                    ?>
                                    <li class="user_dashboard_ajax" id="wp_rem_member_viewings" data-queryvar="dashboard=viewings"><a href="javascript:void(0);"><i class="icon-layers3"></i><?php echo wp_rem_plugin_text_srt('wp_rem_member_register_arrange_viewings'); ?></a><b class="label"><?php echo absint($total_inquiries); ?></b></li>
                                    <?php
                                }

                                if ( true === Wp_rem_Member_Permissions::check_permissions('alerts') ) {
                                    if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'alerts' ) {
                                        $active_tab = 'wp_rem_member_propertyalerts';
                                    }
                                    echo do_action('wp_rem_top_menu_member_dashboard', wp_rem_plugin_text_srt('wp_rem_member_dashboard_alerts_searches'), '<i class="icon-save"></i>');
                                }

                                if ( true === Wp_rem_Member_Permissions::check_permissions('favourites') ) {
                                    if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'favourites' ) {
                                        $active_tab = 'wp_rem_member_favourites';
                                    }
                                    echo do_action('wp_rem_top_menu_favourites_dashboard', wp_rem_plugin_text_srt('wp_rem_member_dashboard_fav_prop'), '<i class="icon-heart5"></i>');
                                }

								 if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'prop_notes' ) {
                                        $active_tab = 'wp_rem_member_prop_notes';
                                    }
									if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'hidden_properties' ) {
                                        $active_tab = 'wp_rem_member_hidden_properties';
                                    }
								?>
								<li class="user_dashboard_ajax" id="wp_rem_member_prop_notes" data-queryvar="dashboard=prop_notes"><a href="javascript:void(0);"><i class="icon-book2"></i><?php echo wp_rem_plugin_text_srt('wp_rem_prop_notes_notes') ?></a></li>

								<li class="user_dashboard_ajax" id="wp_rem_member_hidden_properties" data-queryvar="dashboard=hidden_properties"><a href="javascript:void(0);"><i class="icon-block"></i><?php echo wp_rem_plugin_text_srt('wp_rem_hidden_properties') ?></a></li>
	
								<?php
                                if ( true === Wp_rem_Member_Permissions::check_permissions('packages') ) {
                                    if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'packages' ) {
                                        $active_tab = 'wp_rem_member_packages';
                                    }
                                    ?>
                                    <li class="user_dashboard_ajax" id="wp_rem_member_packages" data-queryvar="dashboard=packages"><a href="javascript:void(0);"><i class="icon-dropbox2"></i><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_packages'); ?></a></li>

                                    <?php
                                }

                                if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'packages' ) {
                                    $active_tab = 'wp_rem_member_packages';
                                }
                                if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'change_pass' ) {

                                    $active_tab = 'wp_rem_member_change_password';
                                }
                                if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'received_orders' ) {
                                    $child_tab = 'wp_rem_member_received_orders';
                                    $active_tab = 'wp_rem_member_orders';
                                }
                                if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'location' ) {
                                    $child_tab = 'wp_rem_member_change_locations';
                                    $active_tab = 'wp_rem_member_accounts';
                                }
                                if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'enquiries_received' ) {
                                    $child_tab = 'wp_rem_member_received_enquiries';
                                    $active_tab = 'wp_rem_member_enquiries';
                                }
                                if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'opening-hours' ) {
                                    $child_tab = 'wp_rem_member_opening_hours';
                                    $active_tab = 'wp_rem_member_accounts';
                                }
                                if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'team_members' ) {
                                    $active_tab = 'wp_rem_member_company';
                                }
                                ?>
                                <?php if ( true === Wp_rem_Member_Permissions::check_permissions('company_profile') ) {
                                    ?><li class="user_dashboard_ajax" id="wp_rem_member_accounts" data-queryvar="dashboard=account"><a href="javascript:void(0);"><i class="icon-tools2"></i><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_account_stng'); ?></a></li>
                                <?php } ?>
                                <?php if ( $member_profile_type == 'company' && $wp_rem_user_type == 'supper-admin' ) {
                                    ?><li class="user_dashboard_ajax" id="wp_rem_member_company" data-queryvar="dashboard=team_members"><a href="javascript:void(0);"><i class="icon-group"></i><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_team_members'); ?></a></li>
                                        <?php } ?>
                                <li class="user_dashboard_ajax" ><a href="<?php echo esc_url(wp_logout_url(wp_rem_server_protocol() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])) ?>"><i class="icon-log-out"></i><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_signout'); ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">

                    <div class="user-account-holder loader-holder">
                        <div class="user-holder">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?php
                                if ( ! isset($_REQUEST['dashboard']) || $_REQUEST['dashboard'] == '' ) {
                                    ?>
                                    <script>jQuery(document).ready(function (e) {
                                            jQuery('#wp_rem_member_suggested>').trigger('click');


                                        });
                                    </script>
                                <?php } ?>
                            </div>
                            <?php ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-section">
        <div class="container">
            <div class="row">
                <!-- warning popup -->
                <div id="id_confrmdiv">
                    <div class="cs-confirm-container">
                        <i class="icon-sad"></i>
                        <div class="message"><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_want_to_profile'); ?></div>
                        <a href="javascript:void(0);" id="id_truebtn"><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_delete_yes'); ?></a>
                        <a href="javascript:void(0);" id="id_falsebtn"><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_delete_no'); ?></a>
                    </div>
                </div>
                <!-- end warning popup -->
            </div>
        </div>
    </div>
</div>
<?php if ( $active_tab != '' ) {
    ?>
    <script type="text/javascript">
        var page_id_all = <?php echo isset($_REQUEST['page_id_all']) && $_REQUEST['page_id_all'] != '' ? $_REQUEST['page_id_all'] : '1' ?>;
        jQuery(document).ready(function (e) {
            jQuery('#<?php echo esc_html($active_tab); ?>').trigger('click');
            //window.setTimeout( show_child(), 1000 );
        });
        var count = 0;
        jQuery(document).ajaxComplete(function (event, request, settings) {
            if (count == 2) {
                jQuery('#<?php echo esc_html($child_tab); ?>').trigger('click');
            }
            count++;
        });

        function show_child() {
            jQuery('#<?php echo esc_html($child_tab); ?>').trigger('click');
        }
    </script>
    <?php
}

get_footer();
