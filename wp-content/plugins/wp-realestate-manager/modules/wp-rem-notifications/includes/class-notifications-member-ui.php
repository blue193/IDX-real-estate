<?php
/**
 * Create Employer Dashboard UI
 *
 * @package	Homevillas
 */
// Direct access not allowed.
if ( ! defined('ABSPATH') ) {
    exit;
}

/**
 * WP_Property_Hunt_Alerts_Shortcode class.
 */
class WP_Property_Hunt_Employer_UI {

    /**
     * Construct.
     */
    public function __construct() {
        // Initialize Addon
        $this->init();
    }

    public function init() {
        // Add hook for dashboard member top menu links.
        add_action('wp_rem_top_menu_member_dashboard', array( $this, 'top_menu_member_dashboard_callback' ), 10, 3);

        // Add Employer left menu and tabs.
        add_action('wp_rem_member_dashboard_menu_left', array( $this, 'add_member_dashboard_menu_left' ), 10, 2);

        add_action('wp_rem_member_admin_tab_menu', array( $this, 'member_admin_tab_menu_callback' ), 10);
        add_action('wp_rem_member_admin_tab_content', array( $this, 'member_admin_tab_content_callback' ), 10);

        add_action('wp_rem_member_dashboard_tabs', array( $this, 'add_member_dashboard_tab' ), 5, 2);
        // Handle AJAX to list all member property alerts in frontend dashboard.
        add_action('wp_ajax_wp_rem_member_propertyalerts', array( $this, 'list_member_propertyalerts_callback' ));
        add_action('wp_ajax_nopriv_wp_rem_member_propertyalerts', array( $this, 'list_member_propertyalerts_callback' ));
        add_filter('wp_rem_member_permissions', array( $this, 'wp_rem_member_permissions_callback' ), 10, 1);
    }

    public function wp_rem_member_permissions_callback($permissions) {
        $permissions['alerts'] = wp_rem_plugin_text_srt('wp_rem_notifactn_member_alert_search_manage');
        return $permissions;
    }

    public function top_menu_member_dashboard_callback($wp_rem_page_id, $icon = '', $search_alerts_url = '') {
        $permissions = apply_filters('member_permissions', '');
        $permission = apply_filters('check_permissions', 'alerts', '');
        $permission_added = false;

        if ( array_key_exists('alerts', $permissions) ) {
            $permission_added = true;
        }

        if ( isset($search_alerts_url) && $search_alerts_url <> '' ) {
            if ( $permission == true || $permission_added == false ) {
                echo ' <li class="user_dashboard_ajax" id="wp_rem_member_propertyalerts" data-queryvar="dashboard=alerts"><a href="' . $search_alerts_url . '">' . $icon . $wp_rem_page_id . '</a></li>';
            }
        } else if ( $permission == true || $permission_added == false ) {
            echo ' <li class="user_dashboard_ajax" id="wp_rem_member_propertyalerts" data-queryvar="dashboard=alerts"><a href="javascript:void(0);">' . $icon . $wp_rem_page_id . '</a></li>';
        }
    }

    public function add_member_dashboard_menu_left($profile_tab, $uid) {
        $is_active = '';
        if ( isset($profile_tab) && $profile_tab == 'property-alerts' ) {
            $is_active = ' active ';
        }
        echo '
			<li id="member_left_property_alerts_link" class="' . $is_active . '">
				<a id="member_postproperties_click_link_id" href="javascript:void(0);" onclick="wp_rem_dashboard_tab_load(\'property-alerts\', \'member\', \'' . esc_js(admin_url('admin-ajax.php')) . '\', \'' . absint($uid) . '\');" >
					<i class="icon-bell-o"></i>' . wp_rem_plugin_text_srt('wp_rem_notifactn_member_property_alerts') . '
				</a>
			</li>
		';
    }

    public function member_admin_tab_menu_callback() {
        echo '<li><a href="javascript:void(0);" name="#tab-Searches22" href="javascript:;"><i class="icon-add_alert "></i>' . wp_rem_plugin_text_srt('wp_rem_notifactn_member_searches_alerts') . '</a></li>';
    }

    public function member_admin_tab_content_callback() {
        ?>
        <div id="tab-Searches22">
            <?php $this->wp_rem_propertyalerts(); ?>
        </div>
        <?php
    }

    /**
     * Start Function Search Alerts
     */
    public function wp_rem_propertyalerts() {
        global $post, $search_keywords, $post_id;
        $wp_rem_blog_num_post = 10;

        $uid = empty($_POST['wp_rem_uid']) ? '' : sanitize_text_field($_POST['wp_rem_uid']);
        $uid = '111';
        if ( $uid <> '' ) {
            $user_id = wp_rem_get_user_id();
            if ( ! empty($user_id) ) {
                // Get count of total posts
                $args = array(
                    // 'author' => $user_id, // I could also use $user_ID, right?
                    'post_type' => 'property-alert',
                    'posts_per_page' => -1,
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    'meta_query' =>
                    array(
                        array(
                            'key' => 'wp_rem_member',
                            'value' => $post_id,
                            'compare' => '=',
                        ),
                    ),
                );
                $property_alerts = new WP_Query($args);
                $alerts_count = $property_alerts->post_count;

                $page_num = empty($_POST['page_id_all']) ? 1 : sanitize_text_field($_POST['page_id_all']);
                // Get alerts with respect to pagination.
                $args = array(
                    //'author' => $user_id, // I could also use $user_ID, right?
                    'post_type' => 'property-alert',
                    'posts_per_page' => $wp_rem_blog_num_post,
                    'paged' => $page_num,
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    'meta_query' =>
                    array(
                        array(
                            'key' => 'wp_rem_member',
                            'value' => $post_id,
                            'compare' => '=',
                        ),
                    ),
                );
                $property_alerts = new WP_Query($args);
            }
            ?>
            <div class="cs-loader"></div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <section class="cs-favorite-properties">
                        <div class="element-title">
                            <h4><?php echo wp_rem_plugin_text_srt('wp_rem_notifactn_member_ad_alerts'); ?></h4>
                        </div>
                        <?php
                        $wp_rem_plugin_options = get_option('wp_rem_plugin_options');
                        $search_list_page = '';
                        if ( ! empty($wp_rem_plugin_options) && $wp_rem_plugin_options['wp_rem_search_result_page'] ) {
                            $search_list_page = $wp_rem_plugin_options['wp_rem_search_result_page'];
                        }
                        if ( ! empty($property_alerts) && $property_alerts->have_posts() ) {
                            ?>
                            <ul class="top-heading-list">
                                <li><span><?php echo wp_rem_plugin_text_srt('wp_rem_notifactn_member_alerts_detail'); ?></span></li>
                                <li><span><?php echo wp_rem_plugin_text_srt('wp_rem_notifactn_member_email_frequency'); ?></span></li>
                            </ul>
                            <ul class="feature-properties">
                                <?php
                                while ( $property_alerts->have_posts() ) :
                                    $property_alerts->the_post();

                                    $wp_rem_property_expired = get_post_meta($post->ID, 'wp_rem_property_expired', true) . '<br>';
                                    $wp_rem_org_name = get_post_meta($post->ID, 'wp_rem_org_name', true);
                                    // Get property's Meta Data.
                                    // $wp_rem_email = get_post_meta( $post->ID, 'wp_rem_email', true );
                                    $wp_rem_name = get_post_meta($post->ID, 'wp_rem_name', true);
                                    $wp_rem_query = get_post_meta($post->ID, 'wp_rem_query', true);
                                    $wp_rem_complete_url = get_post_meta($post->ID, 'wp_rem_complete_url', true);
                                    // Get selected frequencies. 
                                    $frequencies = array(
                                        'annually',
                                        'biannually',
                                        'monthly',
                                        'fortnightly',
                                        'weekly',
                                        'daily',
                                        'never',
                                    );
                                    $selected_frequencies = array();
                                    foreach ( $frequencies as $key => $frequency ) {
                                        $frequency_val = get_post_meta($post->ID, 'wp_rem_frequency_' . $frequency, true);
                                        if ( ! empty($frequency_val) && $frequency_val == 'on' ) {
                                            $selected_frequencies[] = $frequency;
                                        }
                                    }

                                    $search_keywords = WP_Property_Hunt_Alert_Helpers::query_to_array($wp_rem_query);
                                    ?>
                                    <script>


                                        (function ($) {
                                            $(function () {
                                                $(".delete-property-alert a").click(function () {
                                                    var post_id = $(this).data("post-id");
                                                    $('#id_confrmdiv').show();
                                                    var dataString = 'post_id=' + post_id + '&action=wp_rem_remove_property_alert';
                                                    jQuery('.holder-' + post_id).find('#remove_resume_link' + post_id).html('<i class="icon-spinner icon-spin"></i>');
                                                    jQuery.ajax({
                                                        type: "POST",
                                                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                                                        data: dataString,
                                                        dataType: "JSON",
                                                        success: function (response) {
                                                            if (response.status == 0) {
                                                                show_alert_msg(response.msg);
                                                            } else {
                                                                jQuery('.holder-' + post_id).remove();
                                                                var msg_obj = {msg: 'Deleted Successfully.', type: 'success'};
                                                                wp_rem_show_response(msg_obj);
                                                            }
                                                        }
                                                    });
                                                    $('#id_confrmdiv').hide();
                                                    return false;
                                                    $('#id_falsebtn').click(function () {
                                                        $('#id_confrmdiv').hide();
                                                        return false;
                                                    });
                                                    return false;
                                                });
                                            });
                                        })(jQuery);
                                    </script>
                                    <li class="holder-<?php echo intval($post->ID); ?>">
                                        <div class="company-detail-inner">
                                            <h6><a href="<?php echo esc_url(get_permalink($search_list_page)) . '?' ?>"><?php echo esc_html($wp_rem_name); ?></a></h6><br>
                                            <b><?php echo wp_rem_plugin_text_srt('wp_rem_notifactn_member_search_keywords'); ?> </b><br>
                                            <em>
                                                <?php
                                                $all_words_search = array();
                                                //unset($search_keywords['advanced_search']);
                                                //unset($search_keywords['ajax_filter']);
                                                foreach ( $search_keywords as $key => $value ) {

                                                    $all_words_search[] = $key . ' : ' . $value . ' ';
                                                }
                                                $all_search_words = implode(', ', array_values($all_words_search));
                                                if ( ! empty($all_search_words) ) {
                                                    echo esc_html($all_search_words);
                                                } else {
                                                    echo wp_rem_plugin_text_srt('wp_rem_alerts_all_properties');
                                                }
                                                ?>
                                            </em>
                                        </div>

                                        <div class="company-date-option">
                                            <?php echo implode(', ', array_map('ucfirst', $selected_frequencies)); ?>
                                            <div class="control delete-property-alert">
                                                <a data-toggle="tooltip" data-placement="top" title="<?php echo wp_rem_plugin_text_srt('wp_rem_notifactn_member_remove'); ?>" id="remove_resume_link<?php echo absint($post->ID); ?>" href="#"  class="delete-property delete" data-post-id="<?php echo absint($post->ID); ?>">
                                                    <i class="icon-close2"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                                ?>
                            </ul>
                            <?php
                            //==Pagination Start
                            if ( $alerts_count > $wp_rem_blog_num_post && $wp_rem_blog_num_post > 0 ) {
                                echo '<nav>';
                                echo wp_rem_ajax_pagination($alerts_count, $wp_rem_blog_num_post, 'property-alerts', 'member', $uid, '');
                                echo '</nav>';
                            }//==Pagination End 
                            ?>
                            <?php
                        } else {
                            echo '<div class="cs-no-record">' . wp_rem_info_messages_property(wp_rem_plugin_text_srt('wp_rem_notifactn_member_dont_have_search_update')) . '</div>';
                        }
                        ?>
                    </section>
                </div>
            </div>
            <?php
        } else {
            echo '<div class="no-result"><h1>' . wp_rem_plugin_text_srt('wp_rem_notifactn_member_create_user_profile') . '</h1></div>';
        }
        ?>
        <script>
            jQuery(document).ready(function () {
                jQuery('[data-toggle="tooltip"]').tooltip();
            });
        <?php //echo WP_Property_Hunt_Alert_Helpers::get_script_str();      ?>
        </script>
        <?php
    }

    public function add_member_dashboard_tab($profile_tab, $uid) {
        $is_active = '';
        $script = '';
        if ( isset($profile_tab) && $profile_tab == 'property-alerts' ) {
            $is_active = 'active';
            $script = '
				<script type="text/javascript">
					jQuery(window).load(function () {
						(function (admin_url, wp_rem_uid) {
							var dataString = \'wp_rem_uid=\' + wp_rem_uid + \'&action=wp_rem_member_propertyalerts\';
							wp_rem_data_loader_load(\'#property-alerts\');
							jQuery.ajax({
								type: "POST",
								url: admin_url,
								data: dataString,
								success: function (response) {
									jQuery(\'#property-alerts\').html(response);
									jQuery("#property-alerts .cs-loader").fadeTo(2000, 500).slideUp(500);
								}
							});
						})("' . esc_js(admin_url('admin-ajax.php')) . '", "' . absint($uid) . '");
					});
				</script>
			';
        }
        echo '
			<div class="tab-pane ' . $is_active . ' fade1 tabs-container" id="property-alerts">
				<div class="cs-loader"></div>
				' . $script . '
			</div>
		';
    }

    public function list_member_propertyalerts_callback() {
        global $post;
        $wp_rem_blog_num_post = 10;

        $uid = empty($_POST['wp_rem_uid']) ? '' : sanitize_text_field($_POST['wp_rem_uid']);
        $uid = '111';
        if ( $uid <> '' ) {
            $user_id = wp_rem_get_user_id();
            // Update member.
            $member_id = get_user_meta($user_id, 'wp_rem_company', true);
            if ( ! empty($user_id) ) {
                // Get count of total posts
                $args = array(
                    //'author' => $user_id, // I could also use $user_ID, right?
                    'post_type' => 'property-alert',
                    'posts_per_page' => -1,
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    'meta_query' =>
                    array(
                        array(
                            'key' => 'wp_rem_member',
                            'value' => $member_id,
                            'compare' => '=',
                        ),
                    ),
                );
                $property_alerts = new WP_Query($args);
                $alerts_count = $property_alerts->post_count;

                $page_num = empty($_POST['page_id_all']) ? 1 : sanitize_text_field($_POST['page_id_all']);
                // Get alerts with respect to pagination.
                $args = array(
                    // 'author' => $user_id, // I could also use $user_ID, right?
                    'post_type' => 'property-alert',
                    'posts_per_page' => $wp_rem_blog_num_post,
                    'paged' => $page_num,
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    'meta_query' =>
                    array(
                        array(
                            'key' => 'wp_rem_member',
                            'value' => $member_id,
                            'compare' => '=',
                        ),
                    ),
                );
                $property_alerts = new WP_Query($args);
            }
            $has_border = ' has-border';
            if ( ! empty($property_alerts) && $property_alerts->have_posts() ) {
                 $has_border = '';
            }
            ?>
            <div class="cs-loader"></div>
            <section class="cs-favorite-properties">
                <div class="element-title<?php echo wp_rem_allow_special_char($has_border); ?>">
                    <h4><?php echo wp_rem_plugin_text_srt('wp_rem_notifactn_member_searches_alerts'); ?></h4>
                </div>
                <?php
                $wp_rem_plugin_options = get_option('wp_rem_plugin_options');
                $search_list_page = '';
                if ( ! empty($wp_rem_plugin_options) && $wp_rem_plugin_options['wp_rem_search_result_page'] ) {
                    $search_list_page = $wp_rem_plugin_options['wp_rem_search_result_page'];
                }
                if ( ! empty($property_alerts) && $property_alerts->have_posts() ) {
                    ?>
                    <ul class="top-heading-list">
                        <li><span><?php echo wp_rem_plugin_text_srt('wp_rem_notifactn_member_alerts_detail'); ?></span></li>
                        <li><span><?php echo wp_rem_plugin_text_srt('wp_rem_notifactn_member_email_frequency'); ?></span></li>
                    </ul>
                    <ul class="feature-properties">
                        <?php
                        while ( $property_alerts->have_posts() ) :
                            $property_alerts->the_post();

                            $wp_rem_property_expired = get_post_meta($post->ID, 'wp_rem_property_expired', true) . '<br>';
                            $wp_rem_org_name = get_post_meta($post->ID, 'wp_rem_org_name', true);
                            // Get property's Meta Data.
                            // $wp_rem_email = get_post_meta( $post->ID, 'wp_rem_email', true );
                            $wp_rem_name = get_post_meta($post->ID, 'wp_rem_name', true);
                            $wp_rem_query = get_post_meta($post->ID, 'wp_rem_query', true);
                            $wp_rem_complete_url = get_post_meta($post->ID, 'wp_rem_complete_url', true);

                            // Get selected frequencies.
                            $frequencies = array(
                                'annually',
                                'biannually',
                                'monthly',
                                'fortnightly',
                                'weekly',
                                'daily',
                                'never',
                            );
                            $selected_frequencies = array();
                            foreach ( $frequencies as $key => $frequency ) {
                                $frequency_val = get_post_meta($post->ID, 'wp_rem_frequency_' . $frequency, true);
                                if ( ! empty($frequency_val) && $frequency_val == 'on' ) {
                                    $selected_frequencies[] = $frequency;
                                }
                            }

                            $search_keywords = WP_Property_Hunt_Alert_Helpers::query_to_array($wp_rem_query);
                            ?>
                            <li class="holder-<?php echo intval($post->ID); ?>">
                                <div class="company-detail-inner">
                                    <h5><a href="<?php echo esc_url($wp_rem_complete_url); //echo esc_url( get_permalink( $search_list_page ) ) . '?' . http_build_query( $search_keywords );           ?>"><?php echo $wp_rem_name; ?></a></h5><br>
                                    <div class="search-keyword-alerts"><b><?php echo wp_rem_plugin_text_srt('wp_rem_notifactn_member_search_keywords'); ?> </b>
                                        <em>
                                            <?php
                                            $all_words_search = array();
                                            foreach ( $search_keywords as $key => $value ) {
                                                if ( 'ajax_filter' == $key || 'advanced_search' == $key || 'property_arg' == $key || 'action' == $key || 'alert-frequency' == $key || 'alerts-name' == $key || 'loc_polygon' == $key || 'alerts-email' == $key || 'loc_polygon_path' == $key ) {
                                                    continue;
                                                }
                                                $key = str_replace("wp_rem_wp_rem_", "", $key);
                                                $key = str_replace("_", " ", $key);
                                                //$value = str_replace("-", " ", $value);
                                                $all_words_search[] = ucfirst($key) . ' : ' . ($value) . ' ';
                                            }
                                            $all_search_words = implode(', ', array_values($all_words_search));
                                            if ( ! empty($all_search_words) ) {
                                                echo esc_html($all_search_words);
                                            } else {
                                                echo wp_rem_plugin_text_srt('wp_rem_alerts_all_properties');
                                            }
                                            ?>
                                        </em>
                                    </div>
                                </div>

                                <div class="company-date-option">
                                    <?php echo implode(', ', array_map('ucfirst', $selected_frequencies)); ?>
                                    <div class="control delete-property-alert">
                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo wp_rem_plugin_text_srt('wp_rem_notifactn_member_remove'); ?>" id="remove_resume_link<?php echo absint($post->ID); ?>" href="#"  class="delete short-icon" data-post-id="<?php echo absint($post->ID); ?>">
                                            <i class="icon-close"></i>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <?php
                        endwhile;
                        ?>
                    </ul>
                    <?php
                    //==Pagination Start
                    if ( $alerts_count > $wp_rem_blog_num_post && $wp_rem_blog_num_post > 0 ) {
                        echo '<nav>';
                        echo wp_rem_ajax_pagination($alerts_count, $wp_rem_blog_num_post, 'property-alerts', 'member', $uid, '');
                        echo '</nav>';
                    }//==Pagination End 
                    ?>
                    <?php
                } else {
                    echo '<div class="cs-no-record">' . wp_rem_info_messages_property(wp_rem_plugin_text_srt('wp_rem_notifactn_member_dont_have_any_ad_alert')) . '</div>';
                }
                ?>
            </section>
            <?php
        } else {
            echo '<div class="no-result"><h1>' . wp_rem_plugin_text_srt('wp_rem_notifactn_member_create_user_profile') . '</h1></div>';
        }
        ?>
        <script>
            jQuery(document).ready(function () {
                jQuery('[data-toggle="tooltip"]').tooltip();
            });
        <?php echo WP_Property_Hunt_Alert_Helpers::get_script_str(); ?>
        </script>
        <?php
        wp_die();
    }

}

new WP_Property_Hunt_Employer_UI();
