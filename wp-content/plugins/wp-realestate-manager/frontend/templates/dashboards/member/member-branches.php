<?php
/**
 * Member Member Data
 *
 */
if (!class_exists('Wp_rem_Member_Branches')) {

    class Wp_rem_Member_Branches {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action('wp_ajax_wp_rem_member_company', array($this, 'wp_rem_member_company_callback'), 11, 1);
            add_action('wp_ajax_wp_rem_remove_member_branch', array($this, 'wp_rem_remove_member_branch_callback'), 11);
            add_action('wp_ajax_wp_rem_member_branch_add', array($this, 'wp_rem_member_branch_add_callback'), 11);
            add_action('wp_ajax_wp_rem_add_update_branch', array($this, 'wp_rem_add_update_branch_callback'), 11);
			add_filter('wp_rem_member_branches_count', array($this, 'wp_rem_member_branches_count_callback'), 11, 1);
        }

        /**
         * How to show location fields in front end
         */
        public function wp_rem_frontend_location_fields($show_map = 'on', $post_id = '', $field_postfix = '', $user = '') {

            global $wp_rem_plugin_options, $post, $wp_rem_html_fields, $wp_rem_html_fields2, $wp_rem_html_fields_frontend, $wp_rem_form_fields;
            $wp_rem_map_latitude = isset($wp_rem_plugin_options['wp_rem_post_loc_latitude']) ? $wp_rem_plugin_options['wp_rem_post_loc_latitude'] : '';
            $wp_rem_map_longitude = isset($wp_rem_plugin_options['wp_rem_post_loc_longitude']) ? $wp_rem_plugin_options['wp_rem_post_loc_longitude'] : '';
            $wp_rem_map_zoom = isset($wp_rem_plugin_options['wp_rem_map_zoom_level']) ? $wp_rem_plugin_options['wp_rem_map_zoom_level'] : '10';
            $wp_rem_map_marker_icon = isset($wp_rem_plugin_options['wp_rem_map_marker_icon']) ? $wp_rem_plugin_options['wp_rem_map_marker_icon'] : wp_rem::plugin_url() . '/assets/images/map-marker.png';
            $wp_rem_array_data = '';

            $wp_rem_post_loc_address = get_post_meta($post_id, 'wp_rem_post_loc_address_' . $field_postfix, true);
            $wp_rem_post_loc_latitude = get_post_meta($post_id, 'wp_rem_post_loc_latitude_' . $field_postfix, true);
            $wp_rem_post_loc_longitude = get_post_meta($post_id, 'wp_rem_post_loc_longitude_' . $field_postfix, true);
            $wp_rem_post_loc_zoom = get_post_meta($post_id, 'wp_rem_post_loc_zoom_' . $field_postfix, true);
            $wp_rem_loc_radius = get_post_meta($post_id, 'wp_rem_loc_radius_' . $field_postfix, true);

            if ($wp_rem_post_loc_zoom == '') {
                $wp_rem_post_loc_zoom = $wp_rem_map_zoom;
            }
            if ($wp_rem_post_loc_latitude == '') {
                $wp_rem_post_loc_latitude = $wp_rem_map_latitude;
            }
            if ($wp_rem_post_loc_longitude == '') {
                $wp_rem_post_loc_longitude = $wp_rem_map_longitude;
            }

            $wp_rem_obj = new wp_rem();
            $wp_rem_obj->wp_rem_branches_location_gmap_script();
            $wp_rem_obj->wp_rem_google_place_scripts();
            $wp_rem_obj->wp_rem_autocomplete_scripts();
            ?>
            <?php
            $radius_circle = isset($wp_rem_plugin_options['wp_rem_default_radius_circle']) ? $wp_rem_plugin_options['wp_rem_default_radius_circle'] : '10';
            $radius_circle = ($radius_circle * 1000);
            ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <fieldset class="gllpLatlonPicker_<?php echo esc_html($field_postfix); ?>" style="width:100%; float:left;" id="fe_map<?php echo esc_html($field_postfix); ?>" data-radius="<?php echo absint($radius_circle); ?>" data-radiusshow="<?php echo esc_html($wp_rem_loc_radius); ?>">
                    <div class="page-wrap page-opts left" style=" position:relative;" id="locations_wrap" data-themeurl="<?php echo wp_rem::plugin_url(); ?>" data-plugin_url="<?php echo wp_rem::plugin_url(); ?>" data-ajaxurl="<?php echo esc_js(admin_url('admin-ajax.php'), 'wp-rem'); ?>" data-map_marker="<?php echo esc_html($wp_rem_map_marker_icon); ?>">
                        <div class="option-sec" style="margin-bottom:0;">
                            <div class="opt-conts">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <?php
                                        $wp_rem_opt_array = array(
                                            'id' => '',
                                            'std' => esc_attr($wp_rem_post_loc_zoom),
                                            'cust_id' => 'wp_rem_post_loc_zoom',
                                            'cust_name' => "wp_rem_post_loc_zoom_" . $field_postfix,
                                            'classes' => 'gllpZoom',
                                            'return' => false,
                                            'force_std' => true,
                                        );

                                        $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_array);

                                        $wp_rem_opt_array = array(
                                            'id' => 'add_new_loc',
                                            'cust_name' => 'wp_rem_add_new_loc_' . $field_postfix,
                                            'std' => '',
                                            'classes' => 'gllpSearchField',
                                            'extra_atr' => 'style="margin-bottom:10px;"',
                                            'return' => false,
                                            'force_std' => true,
                                        );
										//$wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_array);
                                        ?>
                                        <div class="switchs-holder2">
                                            <div class="field-holder">
                                                <label><?php echo wp_rem_plugin_text_srt('wp_rem_tp_members_find_on_map'); ?></label>
                                                <?php
                                                $wp_rem_opt_array = array(
                                                    'name' => '',
                                                    'desc' => '',
                                                    'echo' => true,
                                                    'field_params' => array(
                                                        'std' => $wp_rem_post_loc_address,
                                                        'cust_id' => 'loc_address_' . $field_postfix,
                                                        'classes' => 'wp-rem-search-location',
                                                        'extra_atr' => 'onkeypress="wp_rem_gl_search_map(this.value)" placeholder="' . wp_rem_plugin_text_srt('wp_rem_member_branches_type_address') . '"',
                                                        'cust_name' => 'wp_rem_post_loc_address_' . $field_postfix,
                                                        'return' => true,
                                                        'force_std' => true,
                                                    ),
                                                );
                                                if (isset($value['address_hint']) && $value['address_hint'] != '') {
                                                    $wp_rem_opt_array['hint_text'] = $value['address_hint'];
                                                }
                                                if (isset($value['split']) && $value['split'] <> '') {
                                                    $wp_rem_opt_array['split'] = $value['split'];
                                                }
                                                $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                                ?>
                                            </div>
                                            <div class="row">
                                                <div style="display:none;" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="field-holder">

                                                        <?php
                                                        $wp_rem_opt_array = array(
                                                            'name' => wp_rem_plugin_text_srt('wp_rem_member_branches_latitude'),
                                                            'id' => 'post_loc_latitude',
                                                            'desc' => '',
                                                            'echo' => true,
                                                            'styles' => 'display:none;',
                                                            'field_params' => array(
                                                                'std' => $wp_rem_post_loc_latitude,
                                                                'id' => 'post_loc_latitude',
                                                                'cust_name' => 'wp_rem_post_loc_latitude_' . $field_postfix,
                                                                'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_member_branches_latitude') . '"',
                                                                'classes' => 'form-control gllpLatitude',
                                                                'return' => true,
                                                                'force_std' => true,
                                                            ),
                                                        );

                                                        if (isset($value['split']) && $value['split'] <> '') {
                                                            $wp_rem_opt_array['split'] = $value['split'];
                                                        }

                                                        $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                                        ?>
                                                    </div>
                                                </div>
                                                <div style="display:none;" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="field-holder">

                                                        <?php
                                                        $wp_rem_opt_array = array(
                                                            'name' => wp_rem_plugin_text_srt('wp_rem_member_branches_longitude'),
                                                            'id' => 'post_loc_longitude',
                                                            'desc' => '',
                                                            'echo' => true,
                                                            'field_params' => array(
                                                                'std' => $wp_rem_post_loc_longitude,
                                                                'id' => 'post_loc_longitude',
                                                                'cust_name' => 'wp_rem_post_loc_longitude_' . $field_postfix,
                                                                'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_member_branches_longitude'). '"',
                                                                'classes' => 'form-control gllpLongitude',
                                                                'return' => true,
                                                                'force_std' => true,
                                                            ),
                                                        );

                                                        if (isset($value['split']) && $value['split'] <> '') {
                                                            $wp_rem_opt_array['split'] = $value['split'];
                                                        }
                                                        $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                                        ?>
                                                    </div>
                                                </div></div>
                                            <div class="search-location-map input-button-loader">
                                                <?php
                                                $wp_rem_opt_array = array(
                                                    'name' => '',
                                                    'id' => 'map_search_btn',
                                                    'desc' => '',
                                                    'echo' => true,
                                                    'field_params' => array(
                                                        'std' => wp_rem_plugin_text_srt('wp_rem_member_branches_search_loc'),
                                                        'id' => 'map_search_btn',
                                                        'cust_type' => 'button',
                                                        'classes' => 'acc-submit cs-section-update cs-color csborder-color gllpSearchButton',
                                                        'return' => true,
                                                    ),
                                                );
                                                if (isset($value['split']) && $value['split'] <> '') {
                                                    $wp_rem_opt_array['split'] = $value['split'];
                                                }
                                                if ($show_map == 'on') {
                                                    $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php if ($show_map == 'on') { ?>
                                            <div class="cs-map-section " style="float:left; width:100%; height:201px;">
                                                <div class="gllpMap" id="cs-map-location-fe-id"></div>
                                            </div>
                                        <?php } ?>
                                        <?php if ($show_map == 'on') { ?>
                                            <p> <?php echo wp_rem_plugin_text_srt('wp_rem_tp_members_drag_drop_pin'); ?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <script type="text/javascript">
                    "use strict";
                    // Call Map gMapsLatLonPicker Class
                    jQuery(document).ready(function () {
                        jQuery(".gllpLatlonPicker_<?php echo esc_html($field_postfix); ?>").each(function () {
                            $obj = jQuery(document).gBranchesMapsLatLonPicker();
                            $obj.init(jQuery(this));
                        });
                    });
                    function wp_rem_gl_search_map() {
                        var vals;
                        vals = jQuery('#loc_address_<?php echo $field_postfix; ?>').val();
                        jQuery('#fe_map<?php echo esc_html($field_postfix); ?> .gllpSearchField').val(vals);
                    }
                    (function ($) {
                        $(function () {
							<?php $wp_rem_obj->wp_rem_google_place_scripts(); ?>
							var autocomplete = new google.maps.places.Autocomplete(document.getElementById('loc_address_<?php echo $field_postfix; ?>'));
						});
                    })(jQuery);
                </script>
            </div>
            <?php
        }

        /*
         * Add/Update Branch
         * @ User ID
         */

        public function wp_rem_add_update_branch_callback() {
            global $wp_rem_html_fields_frontend, $post, $wp_rem_form_fields_frontend;

            $branch_id = wp_rem_get_input('wp_rem_branch_id', NULL, 'INT');
            $branch_member = wp_rem_get_input('wp_rem_branch_member', NULL, 'INT');
            $branch_name = wp_rem_get_input('wp_rem_branch_name', '', 'STRING');
            $branch_phone = wp_rem_get_input('wp_rem_branch_phone', '', 'STRING');
            $branch_email = wp_rem_get_input('wp_rem_branch_email', '', 'STRING');

            $branch_loc_zoom = wp_rem_get_input('wp_rem_post_loc_zoom_branch', '', 'STRING');
            $branch_loc_address = wp_rem_get_input('wp_rem_post_loc_address_branch', '', 'STRING');
            $branch_loc_latitude = wp_rem_get_input('wp_rem_post_loc_latitude_branch', '', 'STRING');
            $branch_loc_longitude = wp_rem_get_input('wp_rem_post_loc_longitude_branch', '', 'STRING');

            if ($branch_name == '') {
                $response_array = array(
                    'type' => 'error',
                    'msg' => wp_rem_plugin_text_srt('wp_rem_member_branches_prvd_name'),
                );
            } else if ($branch_email == '') {
                $response_array = array(
                    'type' => 'error',
                    'msg' => wp_rem_plugin_text_srt('wp_rem_member_branches_prvd_email'),
                );
            } else if (!is_email($branch_email)) {
                $response_array = array(
                    'type' => 'error',
                    'msg' => wp_rem_plugin_text_srt('wp_rem_member_branches_prvd_vlid_email'),
                );
            } else {
                if ($branch_id == NULL) {
                    $branch_post = array(
                        'post_title' => wp_strip_all_tags($branch_name),
                        'post_status' => 'publish',
                        'post_type' => 'branches',
                        'post_date' => current_time('Y/m/d H:i:s')
                    );
                    //insert post
                    $branch_id = wp_insert_post($branch_post);
                    update_post_meta($branch_id, 'wp_rem_branch_member', $branch_member);
                    update_post_meta($branch_id, 'wp_rem_branch_name', $branch_name);
                    update_post_meta($branch_id, 'wp_rem_branch_phone', $branch_phone);
                    update_post_meta($branch_id, 'wp_rem_branch_email', $branch_email);

                    update_post_meta($branch_id, 'wp_rem_post_loc_zoom_branch', $branch_loc_zoom);
                    update_post_meta($branch_id, 'wp_rem_post_loc_address_branch', $branch_loc_address);
                    update_post_meta($branch_id, 'wp_rem_post_loc_latitude_branch', $branch_loc_latitude);
                    update_post_meta($branch_id, 'wp_rem_post_loc_longitude_branch', $branch_loc_longitude);

                    $response_array = array(
                        'type' => 'success',
                        'msg' => wp_rem_plugin_text_srt('wp_rem_member_branches_added_success'),
                    );
                } elseif ($branch_id != '') {
                    $my_branch = array(
                        'ID' => $branch_id,
                        'post_title' => $branch_name,
                        'post_name' => sanitize_title($branch_name),
                    );
                    wp_update_post($my_branch);
                    update_post_meta($branch_id, 'wp_rem_branch_member', $branch_member);
                    update_post_meta($branch_id, 'wp_rem_branch_name', $branch_name);
                    update_post_meta($branch_id, 'wp_rem_branch_name', $branch_name);
                    update_post_meta($branch_id, 'wp_rem_branch_phone', $branch_phone);
                    update_post_meta($branch_id, 'wp_rem_branch_email', $branch_email);

                    update_post_meta($branch_id, 'wp_rem_post_loc_zoom_branch', $branch_loc_zoom);
                    update_post_meta($branch_id, 'wp_rem_post_loc_address_branch', $branch_loc_address);
                    update_post_meta($branch_id, 'wp_rem_post_loc_latitude_branch', $branch_loc_latitude);
                    update_post_meta($branch_id, 'wp_rem_post_loc_longitude_branch', $branch_loc_longitude);

                    $response_array = array(
                        'type' => 'success',
                        'msg' => wp_rem_plugin_text_srt('wp_rem_member_branches_update_success'),
                    );
                }
            }
            echo json_encode($response_array);
            wp_die();
        }

        /*
         * Add/Update Branch
         * @ User ID
         */

        public function wp_rem_member_branch_add_callback() {
            global $wp_rem_html_fields_frontend, $post, $wp_rem_form_fields_frontend;

            $member_id = get_user_meta(get_current_user_id(), 'wp_rem_company', true);
            $branch_id = wp_rem_get_input('wp_rem_branch_id', NULL, 'INT');
            $branch_name = get_post_meta($branch_id, 'wp_rem_branch_name', true);
            $branch_phone = get_post_meta($branch_id, 'wp_rem_branch_phone', true);
            $branch_email = get_post_meta($branch_id, 'wp_rem_branch_email', true);
            ?>
            <div class="invite-member add-update-branch">
                <form id="branch_add_form" method="POST">
                    <div class ="element-title has-border">
                        <a href="javascript:void(0);" class="close-btn cancel">&times;</a>
                        <h4>
                            <?php
                            if ($branch_id == NULL) {
                                echo wp_rem_plugin_text_srt('wp_rem_tp_members_ad_branch');
                            } else {
                                echo wp_rem_plugin_text_srt('wp_rem_tp_members_upd_branch');
                            }
                            ?>
                        </h4>
                    </div>
                    <div class="row branch-fields">
                        <?php
                        $wp_rem_opt_array = array(
                            'std' => esc_attr($branch_id),
                            'id' => 'branch_id',
                            'return' => false,
                            'force_std' => true,
                        );
                        $wp_rem_form_fields_frontend->wp_rem_form_hidden_render($wp_rem_opt_array);

                        $wp_rem_opt_array = array(
                            'std' => esc_attr($member_id),
                            'id' => 'branch_member',
                            'return' => false,
                            'force_std' => true,
                        );
                        $wp_rem_form_fields_frontend->wp_rem_form_hidden_render($wp_rem_opt_array);
                        ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="field-holder">
                                <label><?php echo wp_rem_plugin_text_srt('wp_rem_member_branches_name'); ?></label>
                                <?php
                                $wp_rem_opt_array = array(
                                    'name' => wp_rem_plugin_text_srt('wp_rem_member_branches_name'),
                                    'desc' => '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $branch_name,
                                        'id' => 'branch_name',
                                        'force_std' => true,
                                    ),
                                );
                                $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="field-holder">
                                <label><?php echo wp_rem_plugin_text_srt('wp_rem_member_branches_phone'); ?></label>
                                <?php
                                $wp_rem_opt_array = array(
                                    'name' => wp_rem_plugin_text_srt('wp_rem_member_branches_phone'),
                                    'desc' => '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $branch_phone,
                                        'id' => 'branch_phone',
                                        'force_std' => true,
                                    ),
                                );
                                $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="field-holder">
                                <label><?php echo wp_rem_plugin_text_srt('wp_rem_member_branches_email'); ?></label>
                                <?php
                                $wp_rem_opt_array = array(
                                    'name' => wp_rem_plugin_text_srt('wp_rem_member_branches_email'),
                                    'desc' => '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $branch_email,
                                        'id' => 'branch_email',
                                        'force_std' => true,
                                    ),
                                );
                                $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                ?>
                            </div>
                        </div>
                        <?php $this->wp_rem_frontend_location_fields('on', $branch_id, 'branch'); ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="field-holder">
                                <?php
                                if ($branch_id == NULL) {
                                    $btn_label = wp_rem_plugin_text_srt('wp_rem_member_branches_add');
                                } else {
                                    $btn_label = wp_rem_plugin_text_srt('wp_rem_member_branches_update');
                                }
                                ?>
                                <a href="javascript:void(0);" id="save_branch" class="btn-send"><?php echo esc_html($btn_label); ?></a>
                                <a href = "javascript:void(0);" class="cancel"><?php echo wp_rem_plugin_text_srt('wp_rem_member_branches_cancel'); ?></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <?php
            wp_die();
        }

        /*
         * Removing Branch
         * @ User ID
         */

        public function wp_rem_remove_member_branch_callback() {
            $branch_id = wp_rem_get_input('wp_rem_branch_id', NULL, 'INT');
            if ($branch_id != '' && get_post_type($branch_id) == 'branches') {
                delete_post_meta($branch_id);
                wp_delete_post($branch_id, true);
                $response_array = array(
                    'type' => 'success',
                    'msg' => wp_rem_plugin_text_srt('wp_rem_member_branches_removed_success'),
                );
            }
            echo json_encode($response_array);
            wp_die();
        }

        /**
         * Member Member Form
         */
        public function wp_rem_member_branches_callback($user_id = '') {
            global $wp_rem_html_fields_frontend, $post, $wp_rem_form_fields_frontend;
            if (!isset($user_id) || $user_id == '') {
                $user_id = get_current_user_id();
            }
            $member_id = get_user_meta($user_id, 'wp_rem_company', true);
            ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="user-profile member-branches">
                        <div class="element-title">
                            <h4><?php echo wp_rem_plugin_text_srt('wp_rem_member_branches_branches') ?></h4>
                            <div class="team-option branch-option">
                                <a href="javascript:void(0);" class="add-more add_branch"><?php echo wp_rem_plugin_text_srt('wp_rem_member_branches_add_branches'); ?></a>
                            </div>
                        </div>
                        <div class="row">
                            <?php if (true === Wp_rem_Member_Permissions::check_permissions('company_profile')) { ?>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div id="add_update_branch"></div>
                                    <div class="team-list">
                                        <?php
                                        $args = array(
                                            'post_type' => 'branches',
                                            'posts_per_page' => -1,
                                            'post_status' => 'publish',
                                            'fields' => 'ids',
                                            'meta_query' =>
                                            array(
                                                array(
                                                    'relation' => 'AND',
                                                    array(
                                                        'key' => 'wp_rem_branch_member',
                                                        'value' => $member_id,
                                                        'compare' => '=',
                                                    ),
                                                )
                                            )
                                        );
                                        $branches = get_posts($args);
                                        if (isset($branches) && !empty($branches) && sizeof($branches) > 0) {
                                            ?>
                                            <ul class="panel-group">
                                                <li> 
                                                    <span><?php echo wp_rem_plugin_text_srt('wp_rem_member_branches_name'); ?></span>
                                                    <span><?php echo wp_rem_plugin_text_srt('wp_rem_member_branches_phone'); ?></span>
                                                    <span><?php echo wp_rem_plugin_text_srt('wp_rem_member_branches_email'); ?></span> 
                                                </li>
                                                <?php
                                                foreach ($branches as $branche) {
                                                    $branche_name = get_post_meta($branche, 'wp_rem_branch_name', true);
                                                    $branche_phone = get_post_meta($branche, 'wp_rem_branch_phone', true);
                                                    $branche_email = get_post_meta($branche, 'wp_rem_branch_email', true);
                                                    ?>
                                                    <li>
                                                        <div class="panel panel-default" >
                                                            <a href="javascript:void(0);" class="close-member" data-id="<?php echo esc_attr($branche); ?>"><i class="icon-close remove_branche"></i></a>
                                                            <div class="panel-heading"> 
                                                                <a href="javascript:void(0);" class="member-branch-det" data-id="<?php echo esc_attr($branche); ?>">
                                                                    <span class="branch-name"><?php echo esc_html($branche_name); ?></span> 
                                                                    <span class="branch-phone"><?php echo esc_html($branche_phone); ?></span>
                                                                    <span class="branch-email"><?php echo esc_html($branche_email); ?></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
		/*
		* get branches count by member id
		*/
		 public function wp_rem_member_branches_count_callback($member_id){
			
			$args = array(
				'post_type' => 'branches',
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'fields' => 'ids',
				'meta_query' =>
				array(
					array(
						'relation' => 'AND',
						array(
							'key' => 'wp_rem_branch_member',
							'value' => $member_id,
							'compare' => '=',
						),
					)
				)
			);
			$custom_query_property = new WP_Query($args);
			$post_count = $custom_query_property->post_count;
			return $post_count;
		}
    }

    global $wp_rem_member_branches;
    $wp_rem_member_branches = new Wp_rem_Member_Branches();
}
