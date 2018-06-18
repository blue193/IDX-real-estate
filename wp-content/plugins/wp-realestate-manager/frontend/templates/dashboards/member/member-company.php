<?php
/**
 * Member Member Data
 *
 */
if ( ! class_exists('Wp_rem_Member_Member') ) {

    class Wp_rem_Member_Member {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action('wp_ajax_wp_rem_member_company', array( $this, 'wp_rem_member_company_callback' ), 11, 1);

            add_action('wp_ajax_wp_rem_add_team_member', array( $this, 'wp_rem_add_team_member_callback' ), 11, 1);
            add_action('wp_ajax_wp_rem_update_team_member', array( $this, 'wp_rem_update_team_member_callback' ), 11);
            add_action('wp_ajax_wp_rem_remove_team_member', array( $this, 'wp_rem_remove_team_member_callback' ), 11);

            add_action('wp_ajax_wp_rem_update_branch', array( $this, 'wp_rem_update_branch_callback' ), 11);
            add_action('wp_ajax_wp_rem_remove_branch', array( $this, 'wp_rem_remove_branch_callback' ), 11);
        }

        /**
         * Member Member Form
         */
        public function wp_rem_member_company_callback($member_id = '') {
            global $wp_rem_html_fields_frontend, $post, $wp_rem_form_fields_frontend;
            if ( ! isset($member_id) || $member_id == '' ) {
                $member_id = get_current_user_id();
            }
            $company_id = get_user_meta($member_id, 'wp_rem_company', true);
            $company_data = get_post($company_id);

            $post = $company_data;

            setup_postdata($post);

            $website_url = get_post_meta($post->ID, 'wp_rem_website', true);
            $phone_number = get_post_meta($post->ID, 'wp_rem_phone_number', true);

            $company_ID = get_user_meta(get_current_user_id(), 'wp_rem_company', true);
            $team_args = array(
                'role' => 'wp_rem_member',
                'meta_query' => array(
                    array(
                        'key' => 'wp_rem_company',
                        'value' => $company_ID,
                        'compare' => '='
                    ),
                    array(
                        'relation' => 'OR',
                        array(
                            'key' => 'wp_rem_user_status',
                            'compare' => 'NOT EXISTS',
                            'value' => 'completely'
                        ),
                        array(
                            'key' => 'wp_rem_user_status',
                            'value' => 'deleted',
                            'compare' => '!='
                        ),
                    ),
                ),
            );
            $team_members = get_users($team_args);
            $has_border = ' has-border';
            if ( isset($team_members) && $team_members != '' && sizeof($team_members) > 0 ) {
                $has_border = '';
            }
            ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="user-profile">
                        <div class="element-title<?php echo wp_rem_allow_special_char($has_border); ?>">
                            <h4><?php echo wp_rem_plugin_text_srt('wp_rem_member_team_members') ?></h4>
                            <div class="team-option">
                                <a href="javascript:void(0);" class="add-more add_team_member"><?php echo wp_rem_plugin_text_srt('wp_rem_member_add_members'); ?></a>
                            </div>
                        </div>
                        <div class="row">

                            <?php
                            wp_reset_postdata();
                            ?>
                            <?php if ( true === Wp_rem_Member_Permissions::check_permissions('company_profile') ) { ?>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="invite-member add-member">
                                        <div class="invite-member-popup">   
                                            <form id="team_add_form" method="POST" enctype="multipart/form-data">
                                                <div class ="element-title has-border">
                                                    <a href="javascript:void(0);" class="close-btn cancel">&times;</a>
                                                    <h4><?php echo wp_rem_plugin_text_srt('wp_rem_member_add_team_member'); ?></h4>
                                                </div>
                                                <div class="row team-fields">

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="field-holder">
                                                            <label><?php echo wp_rem_plugin_text_srt('wp_rem_member_name'); ?></label>
                                                            <?php
                                                            $wp_rem_opt_array = array(
                                                                'name' => wp_rem_plugin_text_srt('wp_rem_member_name'),
                                                                'desc' => '',
                                                                'echo' => true,
                                                                'field_params' => array(
                                                                    'std' => '',
                                                                    'id' => 'member_name',
                                                                ),
                                                            );
                                                            $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="field-holder">
                                                            <label><?php echo wp_rem_plugin_text_srt('wp_rem_member_email_address'); ?></label>
                                                            <?php
                                                            $wp_rem_opt_array = array(
                                                                'name' => wp_rem_plugin_text_srt('wp_rem_member_email_address'),
                                                                'desc' => '',
                                                                'echo' => true,
                                                                'field_params' => array(
                                                                    'std' => '',
                                                                    'id' => 'email_address',
                                                                ),
                                                            );
                                                            $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="field-holder">
                                                            <label><?php echo wp_rem_plugin_text_srt('wp_rem_member_phone_number'); ?></label>
                                                            <?php
                                                            $wp_rem_opt_array = array(
                                                                'name' => wp_rem_plugin_text_srt('wp_rem_member_phone_number'),
                                                                'desc' => '',
                                                                'echo' => true,
                                                                'field_params' => array(
                                                                    'std' => '',
                                                                    'id' => 'member_phone_number',
                                                                ),
                                                            );
                                                            $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="field-holder profile-image-field">
                                                            <label><?php echo wp_rem_plugin_text_srt('wp_rem_member_profile_image'); ?></label>
                                                            <?php
                                                            $wp_rem_opt_array = array(
                                                                'name' => wp_rem_plugin_text_srt('wp_rem_member_profile_image'),
                                                                'desc' => '',
                                                                'echo' => true,
                                                                'field_params' => array(
                                                                    'std' => '',
                                                                    'id' => 'member_thumb_1',
                                                                    'extra_atr' => 'data-id="1" class="wp-rem-member-thumb" style="display:none;"',
                                                                    'cust_name' => 'wp_rem_member_thumb',
                                                                    'cust_type' => 'file',
                                                                ),
                                                            );
                                                            $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                                            ?>
                                                            <div class="member-thumbnail-1 member-profile-image"></div>
                                                            <div class="upload-file"><button for="file-1" class="member-thumbnail-upload" data-id="1" type="button"><span><?php echo wp_rem_plugin_text_srt('wp_rem_member_upload'); ?></span></button></div>

                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="field-holder">
                                                            <label><?php echo wp_rem_plugin_text_srt('wp_rem_member_public_profile'); ?></label>
                                                            <?php
                                                            $user_option = array(
                                                                'no' => 'No',
                                                                'yes' => 'Yes',
                                                            );
                                                            $wp_rem_opt_array = array(
                                                                'name' => wp_rem_plugin_text_srt('wp_rem_member_public_profile'),
                                                                'desc' => '',
                                                                'echo' => true,
                                                                'field_params' => array(
                                                                    'std' => '',
                                                                    'id' => 'public_profile',
                                                                    'classes' => 'chosen-select-no-single',
                                                                    'options' => $user_option,
                                                                ),
                                                            );
                                                            $wp_rem_html_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="field-holder">
                                                            <label><?php echo wp_rem_plugin_text_srt('wp_rem_member_user_type'); ?></label>
                                                            <?php
                                                            $user_type = array(
                                                                'team-member' => wp_rem_plugin_text_srt('wp_rem_member_team_member'),
                                                                'supper-admin' => wp_rem_plugin_text_srt('wp_rem_member_super_admin'),
                                                            );
                                                            $wp_rem_opt_array = array(
                                                                'name' => wp_rem_plugin_text_srt('wp_rem_member_user_type'),
                                                                'desc' => '',
                                                                'echo' => true,
                                                                'field_params' => array(
                                                                    'std' => '',
                                                                    'id' => 'user_type',
                                                                    'classes' => 'chosen-select-no-single',
                                                                    'options' => $user_type,
                                                                    'extra_atr' => 'onchange="wp_rem_user_permission(this, \'add_member_permission\', \'supper-admin\');"'
                                                                ),
                                                            );
                                                            $wp_rem_html_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array);
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class = "panel-body add_member_permission">
                                                        <h6> <?php echo wp_rem_plugin_text_srt('wp_rem_member_roles'); ?></h6>
                                                        <?php
                                                        global $permissions;
                                                        $permissions_array = $permissions->member_permissions();
                                                        ?>
                                                        <ul class = "checkbox-list">
                                                            <?php
                                                            foreach ( $permissions_array as $permission_key => $permission_value ) {
                                                                $rand = rand(0, 99);
                                                                ?>
                                                                <li class = "col-lg-6 col-md-6 col-sm-12 col-xs-12" draggable = "true" style = "display: inline-block;">
                                                                    <?php
                                                                    $wp_rem_opt_array = array(
                                                                        'name' => $permission_value,
                                                                        'desc' => '',
                                                                        'echo' => true,
                                                                        'simple' => true,
                                                                        'field_params' => array(
                                                                            'std' => '',
                                                                            'simple' => true,
                                                                            'id' => $permission_key . $rand,
                                                                            'cust_name' => 'permissions[' . $permission_key . ']',
                                                                        ),
                                                                    );
                                                                    $wp_rem_html_fields_frontend->wp_rem_form_checkbox_render($wp_rem_opt_array);
                                                                    ?>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                    <div class = "col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class = "field-holder">
                                                            <a href="javascript:;" id="add_member" class="btn-send"><?php echo wp_rem_plugin_text_srt('wp_rem_member_send'); ?></a>
                                                            <a href = "javascript:void(0);" class = "cancel"><?php echo wp_rem_plugin_text_srt('wp_rem_member_cancel'); ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="team-list">
                                        <?php
                                        if ( isset($team_members) && $team_members != '' && sizeof($team_members) > 0 ) {
                                            ?>

                                            <ul class="panel-group">
                                                <li> 
                                                    <span><?php echo wp_rem_plugin_text_srt('wp_rem_member_username'); ?></span>
                                                    <span><?php echo wp_rem_plugin_text_srt('wp_rem_member_email_address'); ?></span> 
                                                </li>
                                                <?php
                                                // count the supper admin in complete team
                                                $supper_admin_count = 0;
                                                foreach ( $team_members as $member_data ) {
                                                    $selected_user_type = get_user_meta($member_data->ID, 'wp_rem_user_type', true);
                                                    if ( $selected_user_type == 'supper-admin' ) {
                                                        $supper_admin_count ++;
                                                    }
                                                }

                                                foreach ( $team_members as $member_data ) {
                                                    $selected_user_type = get_user_meta($member_data->ID, 'wp_rem_user_type', true);
                                                    $selected_user_type = isset($selected_user_type) && $selected_user_type != '' ? $selected_user_type : 'team-member';
                                                    $member_permissions = get_user_meta($member_data->ID, 'wp_rem_permissions', true);
                                                    $member_name = get_user_meta($member_data->ID, 'member_name', true);
                                                    $phone_number = get_user_meta($member_data->ID, 'member_phone_number', true);
                                                    $wp_rem_member_thumb_id = get_user_meta($member_data->ID, 'member_thumb', true);
                                                    $wp_rem_public_profile = get_user_meta($member_data->ID, 'wp_rem_public_profile', true);
                                                    $member_name = ( isset($member_name) && $member_name != '' ) ? $member_name : $member_data->user_login;
                                                    ?>
                                                    <li>
                                                        <div class="panel panel-default" >
                                                            <form name="wp_rem_update_team_member" id="wp_rem_update_team_member<?php echo esc_attr($member_data->ID); ?>" data-selected_user_type="<?php echo esc_attr($selected_user_type); ?>" data-count_supper_admin="<?php echo esc_attr($supper_admin_count); ?>" data-id="<?php echo esc_attr($member_data->ID); ?>" method="POST">
                                                                <a href="javascript:void(0);" class="close-member" data-id="<?php echo esc_attr($member_data->ID); ?>"><i class="icon-close remove_member"></i></a>
                                                                <div class="panel-heading"> 
                                                                    <a href="javascript:void(0);" class="restaurant-team-member-det" data-id="<?php echo esc_attr($member_data->ID); ?>">
                                                                        <div class="img-holder">
                                                                            <strong><?php echo esc_html($member_name); ?> </strong> 
                                                                        </div>
                                                                        <span class="email"><?php echo esc_html($member_data->user_email); ?> </span> 
                                                                        <?php if ( $selected_user_type == 'supper-admin' ) { ?><span class="supper-admin"><?php echo wp_rem_plugin_text_srt('wp_rem_member_super_admin'); ?></span>
                                                                        <?php } ?>
                                                                    </a>
                                                                </div>
                                                                <div id="team-member-det-<?php echo esc_attr($member_data->ID); ?>" class="invite-member team-member-det-box">
                                                                    <div class="invite-member-popup">
                                                                        <?php
                                                                        // TOTAL SUPPER ADMIN COUNT
                                                                        $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                                                                                array(
                                                                                    'cust_name' => 'count_supper_admin',
                                                                                    'classes' => 'count_supper_admin',
                                                                                    'std' => $supper_admin_count,
                                                                                )
                                                                        );
                                                                        $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                                                                                array(
                                                                                    'cust_name' => 'wp_rem_old_user_type',
                                                                                    'std' => $selected_user_type,
                                                                                )
                                                                        );
                                                                        ?>
                                                                        <div class="element-title has-border">
                                                                            <a href="javascript:void(0);" class="close-btn cancel">&times;</a>
                                                                            <h4><?php echo wp_rem_plugin_text_srt('wp_rem_members_company_update_team_member'); ?></h4>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                <div class="field-holder">
                                                                                    <label><?php echo wp_rem_plugin_text_srt('wp_rem_member_name'); ?></label>
                                                                                    <?php
                                                                                    $wp_rem_opt_array = array(
                                                                                        'name' => wp_rem_plugin_text_srt('wp_rem_member_name'),
                                                                                        'desc' => '',
                                                                                        'echo' => true,
                                                                                        'field_params' => array(
                                                                                            'std' => esc_html($member_name),
                                                                                            'id' => 'member_name',
                                                                                        ),
                                                                                    );
                                                                                    $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                <div class = "field-holder">
                                                                                    <label><?php echo wp_rem_plugin_text_srt('wp_rem_member_email_address'); ?></label>
                                                                                    <?php
                                                                                    $wp_rem_opt_array = array(
                                                                                        'name' => wp_rem_plugin_text_srt('wp_rem_member_email_address'),
                                                                                        'desc' => '',
                                                                                        'echo' => true,
                                                                                        'field_params' => array(
                                                                                            'std' => esc_html($member_data->user_email),
                                                                                            'id' => 'email_address',
                                                                                        ),
                                                                                    );
                                                                                    $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                <div class="field-holder">
                                                                                    <label><?php echo wp_rem_plugin_text_srt('wp_rem_member_phone_number'); ?></label>
                                                                                    <?php
                                                                                    $wp_rem_opt_array = array(
                                                                                        'name' => wp_rem_plugin_text_srt('wp_rem_member_phone_number'),
                                                                                        'desc' => '',
                                                                                        'echo' => true,
                                                                                        'field_params' => array(
                                                                                            'std' => esc_html($phone_number),
                                                                                            'id' => 'member_phone_number',
                                                                                        ),
                                                                                    );
                                                                                    $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                                                                    ?>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                <div class="field-holder profile-image-field">
                                                                                    <label><?php echo wp_rem_plugin_text_srt('wp_rem_member_profile_image'); ?></label>
                                                                                    <?php
                                                                                    $wp_rem_opt_array = array(
                                                                                        'name' => wp_rem_plugin_text_srt('wp_rem_member_profile_image'),
                                                                                        'desc' => '',
                                                                                        'echo' => true,
                                                                                        'field_params' => array(
                                                                                            'std' => '',
                                                                                            'id' => 'member_thumb_' . $member_data->ID,
                                                                                            'extra_atr' => 'data-id="' . $member_data->ID . '" class="wp-rem-member-thumb" style="display:none;"',
                                                                                            'cust_name' => 'wp_rem_member_thumb',
                                                                                            'cust_type' => 'file',
                                                                                        ),
                                                                                    );
                                                                                    $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);

                                                                                    $wp_rem_opt_array = array(
                                                                                        'name' => '',
                                                                                        'desc' => '',
                                                                                        'echo' => true,
                                                                                        'field_params' => array(
                                                                                            'std' => $wp_rem_member_thumb_id,
                                                                                            'id' => 'member_thumb_id_' . $member_data->ID,
                                                                                            'cust_name' => 'wp_rem_member_thumb_id',
                                                                                            'cust_type' => 'hidden',
                                                                                        ),
                                                                                    );
                                                                                    $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                                                                    ?>
                                                                                    <div class="member-thumbnail-<?php echo esc_attr($member_data->ID); ?> member-profile-image">
                                                                                        <?php
                                                                                        if ( isset($wp_rem_member_thumb_id) && $wp_rem_member_thumb_id != '' ) {
                                                                                            echo wp_get_attachment_image($wp_rem_member_thumb_id, 'thumbnail');
                                                                                            ?>
                                                                                            <div class="remove-member-thumb" data-id="<?php echo esc_attr($member_data->ID); ?>"><i class="icon-close"></i></div>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                    <div class="upload-file"><button for="file-1" class="member-thumbnail-upload" data-id="<?php echo esc_attr($member_data->ID); ?>" type="button"><span><?php echo wp_rem_plugin_text_srt('wp_rem_members_company_upload'); ?></span></button></div>

                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                <div class="field-holder">
                                                                                    <label><?php echo wp_rem_plugin_text_srt('wp_rem_member_public_profile'); ?></label>
                                                                                    <?php
                                                                                    $user_option = array(
                                                                                        'no' => 'No',
                                                                                        'yes' => 'Yes',
                                                                                    );
                                                                                    $wp_rem_opt_array = array(
                                                                                        'name' => wp_rem_plugin_text_srt('wp_rem_member_public_profile'),
                                                                                        'desc' => '',
                                                                                        'echo' => true,
                                                                                        'field_params' => array(
                                                                                            'std' => $wp_rem_public_profile,
                                                                                            'id' => 'public_profile',
                                                                                            'classes' => 'chosen-select-no-single',
                                                                                            'options' => $user_option,
                                                                                        ),
                                                                                    );
                                                                                    $wp_rem_html_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array);
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                <div class="field-holder">
                                                                                    <label><?php echo wp_rem_plugin_text_srt('wp_rem_member_user_type'); ?></label>
                                                                                    <?php
                                                                                    $user_type = array(
                                                                                        'supper-admin' => 'Supper Admin',
                                                                                        'team-member' => 'Team Member',
                                                                                    );
                                                                                    $wp_rem_opt_array = array(
                                                                                        'name' => wp_rem_plugin_text_srt('wp_rem_member_user_type'),
                                                                                        'desc' => '',
                                                                                        'echo' => true,
                                                                                        'field_params' => array(
                                                                                            'std' => $selected_user_type,
                                                                                            'id' => 'user_type',
                                                                                            'classes' => 'chosen-select-no-single',
                                                                                            'options' => $user_type,
                                                                                            'extra_atr' => 'onchange="wp_rem_user_permission(this, \'add_member_permission' . esc_attr($member_data->ID) . '\', \'supper-admin\');"'
                                                                                        ),
                                                                                    );
                                                                                    $wp_rem_html_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array);
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                            $permission_display = '';
                                                                            if ( $selected_user_type == 'supper-admin' ) {
                                                                                $permission_display = 'display:none';
                                                                            }
                                                                            ?>
                                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 add_member_permission<?php echo esc_attr($member_data->ID); ?>" style="<?php echo esc_html($permission_display); ?>">
                                                                                <h6 ><?php echo wp_rem_plugin_text_srt('wp_rem_member_roles'); ?></h6>
                                                                                <?php
                                                                                global $permissions;
                                                                                $permissions_array = $permissions->member_permissions();
                                                                                ?>
                                                                                <ul class ="checkbox-list">
                                                                                    <?php
                                                                                    foreach ( $permissions_array as $permission_key => $permission_value ) {
                                                                                        $value = '';
                                                                                        if ( isset($member_permissions[$permission_key]) && $member_permissions[$permission_key] == 'on' ) {
                                                                                            $value = $member_permissions[$permission_key];
                                                                                        } else if ( $selected_user_type == 'supper-admin' ) {  // if user supper admin then show all permission
                                                                                            $value = 'on';
                                                                                        }
                                                                                        $rand = rand(0, 99);
                                                                                        ?>
                                                                                        <li class = "col-lg-6 col-md-6 col-sm-12 col-xs-12" draggable = "true" style = "display: inline-block;">
                                                                                            <?php
                                                                                            $wp_rem_opt_array = array(
                                                                                                'name' => $permission_value,
                                                                                                'desc' => '',
                                                                                                'echo' => true,
                                                                                                'simple' => true,
                                                                                                'field_params' => array(
                                                                                                    'std' => $value,
                                                                                                    'simple' => true,
                                                                                                    'id' => $permission_key . $rand,
                                                                                                    'cust_name' => 'permissions[' . $permission_key . ']',
                                                                                                ),
                                                                                            );
                                                                                            $wp_rem_html_fields_frontend->wp_rem_form_checkbox_render($wp_rem_opt_array);
                                                                                            ?>
                                                                                        </li>
                                                                                    <?php } ?>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                <button name="button" class="btn-submit team-update-button-<?php echo esc_attr($rand); ?>" data-id="<?php echo esc_attr($rand); ?>" type="button" id="team_update_form"><?php echo wp_rem_plugin_text_srt('wp_rem_members_company_update'); ?></button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <script>
                                                            jQuery(document).ready(function () {
                                                                'use strict'
                                                                jQuery(".chosen-select-no-single").chosen();
                                                            });
                                                        </script>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                            <?php
                                        } else {
                                            echo '<ul class="panel-group"><li class="no-order-list-found">' . wp_rem_plugin_text_srt('wp_rem_member_no_any_member') . '.</li></ul>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                chosen_selectionbox();
            </script>
            <?php
            wp_die();
        }

        /*
         * Adding Team Member
         */

        public function wp_rem_add_team_member_callback() {
            global $wpdb;
            $permissions = wp_rem_get_input('permissions', NULL, 'ARRAY');
            $email = wp_rem_get_input('wp_rem_email_address', NULL, 'STRING');
            $user_type = wp_rem_get_input('wp_rem_user_type', NULL, 'STRING');
            $member_name = wp_rem_get_input('wp_rem_member_name', NULL, 'STRING');
            $public_profile = wp_rem_get_input('wp_rem_public_profile', NULL, 'STRING');
            $member_phone_number = wp_rem_get_input('wp_rem_member_phone_number', NULL, 'STRING');
            $member_thumb = isset($_FILES['wp_rem_member_thumb']) ? $_FILES['wp_rem_member_thumb'] : '';
            $user_type = isset($user_type) && $user_type != '' ? $user_type : 'team-member';
            if ( $email == NULL ) {
                $response_array = array(
                    'type' => 'error',
                    'msg' => wp_rem_plugin_text_srt('wp_rem_member_valid_email'),
                );
                echo json_encode($response_array);
                wp_die();
            }
            if ( ! filter_var($email, FILTER_VALIDATE_EMAIL) ) {
                $response_array = array(
                    'type' => 'error',
                    'msg' => wp_rem_plugin_text_srt('wp_rem_member_valid_email'),
                );
                echo json_encode($response_array);
                wp_die();
            }
            if ( email_exists($email) ) {
                $response_array = array(
                    'type' => 'error',
                    'msg' => wp_rem_plugin_text_srt('wp_rem_member_email_exists'),
                );
                echo json_encode($response_array);
                wp_die();
            }
            $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
            $user_ID = wp_create_user($email, $random_password, $email);
            if ( ! is_wp_error($user_ID) ) {
                wp_update_user(array(
                    'ID' => $user_ID,
                    'role' => 'wp_rem_member'
                ));

                update_user_meta($user_ID, 'show_admin_bar_front', false);

                if ( $permissions != NULL ) {
                    update_user_meta($user_ID, 'wp_rem_permissions', $permissions);
                }

                update_user_meta($user_ID, 'wp_rem_user_type', $user_type);

                // active user
                $wpdb->update(
                        $wpdb->prefix . 'users', array( 'user_status' => 1 ), array( 'ID' => esc_sql($user_ID) )
                );


                update_user_meta($user_ID, 'wp_rem_user_status', 'active');

                $company_ID = get_user_meta(get_current_user_id(), 'wp_rem_company', true);
                update_user_meta($user_ID, 'wp_rem_company', $company_ID);
                update_user_meta($user_ID, 'wp_rem_is_admin', 0);

                if ( ! empty($member_thumb['name']) ) {
                    $types = array( 'image/jpeg', 'image/jpg', 'image/gif', 'image/png' );

                    if ( in_array($member_thumb['type'], $types) ) {
                        $this->update_member_thumb($member_thumb, $user_ID);
                    } else {
                        $response_array = array(
                            'type' => 'error',
                            'msg' => wp_rem_plugin_text_srt('wp_rem_member_valid_file'),
                        );
                        echo json_encode($response_array);
                        wp_die();
                    }
                }

                if ( isset($member_name) && $member_name != '' ) {
                    update_user_meta($user_ID, 'member_name', $member_name);
                }
                if ( isset($member_phone_number) && $member_phone_number != '' ) {
                    update_user_meta($user_ID, 'member_phone_number', $member_phone_number);
                }
                if ( isset($public_profile) && $public_profile != '' ) {
                    update_user_meta($user_ID, 'wp_rem_public_profile', $public_profile);
                }

                /*
                 * Sending Email with login details.
                 */
                $member_data = get_user_info_array();
                $email_array = array(
                    'user_name' => $email,
                    'user_email' => $email,
                    'user_password' => $random_password,
                    'user_type' => $user_type,
                    'user_permissions' => $permissions,
                    'member_first_name' => isset($member_data['first_name']) ? $member_data['first_name'] : '',
                    'member_last_name' => isset($member_data['last_name']) ? $member_data['last_name'] : '',
                    'member_user_email' => isset($member_data['email']) ? $member_data['email'] : '',
                );

                do_action('wp_rem_add_member_email', $email_array);

                $response_array = array(
                    'type' => 'success',
                    'msg' => wp_rem_plugin_text_srt('wp_rem_member_member_added'),
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

            $wp_rem_public_profile = wp_rem_get_input('wp_rem_public_profile', NULL, 'STRING');
            $wp_rem_user_type = wp_rem_get_input('wp_rem_user_type', NULL, 'STRING');
            $wp_rem_old_user_type = wp_rem_get_input('wp_rem_old_user_type', NULL, 'STRING');
            $count_supper_admin = wp_rem_get_input('count_supper_admin', NULL, 'STRING');
            $member_name = wp_rem_get_input('wp_rem_member_name', NULL, 'STRING');
            $member_phone_number = wp_rem_get_input('wp_rem_member_phone_number', NULL, 'STRING');
            $wp_rem_member_thumb_id = wp_rem_get_input('wp_rem_member_thumb_id', '', 'STRING');
            $member_thumb = isset($_FILES['wp_rem_member_thumb']) ? $_FILES['wp_rem_member_thumb'] : '';

            $update_allow = 1;
            if ( $wp_rem_old_user_type == $wp_rem_user_type ) {
                $update_allow = 1;
            } elseif ( 'supper-admin' == $wp_rem_user_type ) {
                $update_allow = 1;
            } elseif ( $count_supper_admin > 1 ) {
                $update_allow = 1;
            } else {
                $update_allow = 0;
            }
            if ( $update_allow == 1 ) {
                $permissions = wp_rem_get_input('permissions', '', 'ARRAY');

                update_user_meta($user_ID, 'wp_rem_user_type', $wp_rem_user_type);
                update_user_meta($user_ID, 'wp_rem_permissions', $permissions);
                update_user_meta($user_ID, 'wp_rem_public_profile', $wp_rem_public_profile);

                if ( isset($member_name) && $member_name != '' ) {
                    update_user_meta($user_ID, 'member_name', $member_name);
                }
                if ( isset($member_phone_number) && $member_phone_number != '' ) {
                    update_user_meta($user_ID, 'member_phone_number', $member_phone_number);
                }
                if ( ! empty($member_thumb['name']) ) {

                    $types = array( 'image/jpeg', 'image/jpg', 'image/gif', 'image/png' );

                    if ( in_array($member_thumb['type'], $types) ) {
                        $this->update_member_thumb($member_thumb, $user_ID);
                    } else {
                        $response_array = array(
                            'type' => 'error',
                            'msg' => wp_rem_plugin_text_srt('wp_rem_member_valid_file'),
                        );
                        echo json_encode($response_array);
                        wp_die();
                    }
                } else {
                    update_user_meta($user_ID, 'member_thumb', $wp_rem_member_thumb_id);
                }
                if ( isset($_POST['update_from_admin']) && $_POST['update_from_admin'] == 1 ) {
                    $member_thumb_id = $_POST['wp_rem_member_thumb_' . $user_ID];
                    if ( $member_thumb_id != '' ) {
                        update_user_meta($user_ID, 'member_thumb', $member_thumb_id);
                    }
                }

                $response_array = array(
                    'type' => 'success',
                    'msg' => wp_rem_plugin_text_srt('wp_rem_member_member_updated'),
                );
            } else {
                $response_array = array(
                    'type' => 'error',
                    'msg' => wp_rem_plugin_text_srt('wp_rem_member_supper_admin_error'),
                );
            }
            echo json_encode($response_array);
            wp_die();
        }

        /*
         * Updating Branch
         */

        public function wp_rem_update_branch_callback() {
            $branch_id = wp_rem_get_input('branch_id', NULL, 'INT');

            $branch_name = wp_rem_get_input('wp_rem_branch_name', NULL, 'STRING');
            update_post_meta($branch_id, 'wp_rem_branch_name', $branch_name);

            $phone_number = wp_rem_get_input('wp_rem_phone_number', NULL, 'STRING');
            update_post_meta($branch_id, 'wp_rem_branch_phone', $phone_number);

            $wp_rem_email_address = wp_rem_get_input('wp_rem_email_address', NULL, 'STRING');
            update_post_meta($branch_id, 'wp_rem_branch_email', $wp_rem_email_address);

            $wp_rem_branch_address = wp_rem_get_input('wp_rem_branch_address', NULL, 'STRING');
            update_post_meta($branch_id, 'wp_rem_post_loc_address_branch', $wp_rem_branch_address);

            $wp_rem_branch_member = wp_rem_get_input('wp_rem_branch_member', NULL, 'INT');
            update_post_meta($branch_id, 'wp_rem_branch_member', $wp_rem_branch_member);

            $response_array = array(
                'type' => 'success',
                'msg' => wp_rem_plugin_text_srt('wp_rem_member_branch_updated'),
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
            $wp_rem_user_type = get_user_meta($user_ID, 'wp_rem_user_type', true);
            $count_supper_admin = wp_rem_get_input('count_supper_admin', NULL, 'INT');

            if ( $wp_rem_user_type == 'supper-admin' ) {
                if ( $count_supper_admin > 1 ) {
                    update_user_meta($user_ID, 'wp_rem_user_status', 'deleted');
                    $response_array = array(
                        'type' => 'success',
                        'msg' => wp_rem_plugin_text_srt('wp_rem_member_super_admin_removed'),
                    );
                } else {
                    $response_array = array(
                        'type' => 'error',
                        'msg' => wp_rem_plugin_text_srt('wp_rem_member_supper_admin_error'),
                    );
                }
            }
            if ( $wp_rem_user_type == 'team-member' ) {
                update_user_meta($user_ID, 'wp_rem_user_status', 'deleted');
                $response_array = array(
                    'type' => 'success',
                    'msg' => wp_rem_plugin_text_srt('wp_rem_member_member_removed'),
                );
            }
            echo json_encode($response_array);
            wp_die();
        }

        /*
         * Removing Branch
         * @ User ID
         */

        public function wp_rem_remove_branch_callback() {

            $branch_id = wp_rem_get_input('wp_rem_branch_id', NULL, 'INT');
            wp_delete_post($branch_id);

            $response_array = array(
                'type' => 'success',
                'msg' => wp_rem_plugin_text_srt('wp_rem_member_branch_removed'),
            );

            echo json_encode($response_array);
            wp_die();
        }

        public function update_member_thumb($thumb_file, $user_id) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
            $current_user_id = get_current_user_id();
            $status = wp_handle_upload($thumb_file, array( 'test_form' => false ));
            if ( isset($status) && ! isset($status['error']) ) {
                $uploads = wp_upload_dir();
                $filename = isset($status['url']) ? $status['url'] : '';
                $filetype = wp_check_filetype(basename($filename), null);

                if ( $filename != '' ) {
                    // Prepare an array of post data for the attachment.

                    $attachment = array(
                        'guid' => $status['url'],
                        'post_mime_type' => $filetype['type'],
                        'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                        'post_content' => '',
                        'post_status' => 'inherit'
                    );
                    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
                    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
                    // Insert the attachment.
                    $attach_id = wp_insert_attachment($attachment, $status['file']);
                    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
                    $attach_data = wp_generate_attachment_metadata($attach_id, $status['file']);
                    wp_update_attachment_metadata($attach_id, $attach_data);
                    $attach_id = $attach_id;

                    update_user_meta($user_id, 'member_thumb', $attach_id);
                }
            }
        }

    }

    global $wp_rem_member_company;
    $wp_rem_member_company = new Wp_rem_Member_Member();
}
