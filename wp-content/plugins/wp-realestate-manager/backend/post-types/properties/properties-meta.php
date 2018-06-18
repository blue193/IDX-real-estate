<?php
/**
 * @Add Meta Box For Properties Post
 * @return
 *
 */
if ( ! class_exists('wp_rem_property_meta') ) {

    class wp_rem_property_meta {

        var $html_data = '';

        public function __construct() {
            add_action('add_meta_boxes', array( $this, 'wp_rem_meta_properties_add' ));
            add_action('wp_ajax_property_type_dyn_fields', array( $this, 'property_type_change_fields' ));
            add_action('admin_footer-edit-tags.php', array( $this, 'wp_rem_remove_catmeta' ));
            add_filter('manage_edit-wp_rem_locations_columns', array( $this, 'theme_columns' ));
            add_action('wp_ajax_wp_rem_property_off_day_to_list_backend', array( $this, 'append_to_book_days_off' ));

            add_action('wp_ajax_wp_rem_meta_property_categories', array( $this, 'wp_rem_meta_property_categories' ));
            add_action('wp_ajax_nopriv_wp_rem_meta_property_categories', array( $this, 'wp_rem_meta_property_categories' ));
            add_action('save_post', array( $this, 'wp_rem_property_save_off_days' ), 11);
            add_action('save_post', array( $this, 'wp_rem_property_categories' ), 11);
            add_action('save_post', array( $this, 'wp_rem_save_property_custom_fields_dates' ), 20);
            add_action('save_post', array( $this, 'wp_rem_save_property_features' ), 20);
            add_action('save_post', array( $this, 'wp_rem_save_property_open_house' ), 20);

            add_action('save_post', array( $this, 'wp_rem_change_property_member' ), 1, 1);
            add_action('transition_post_status', array( $this, 'wp_rem_move_property_trash' ), 20, 3);
        }

        public function wp_rem_change_property_member($property_id = '') {
            // Stop WP from clearing custom fields on autosave.
            if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
                return;

            // Prevent quick edit from clearing custom fields
            if ( defined('DOING_AJAX') && DOING_AJAX )
                return;

            // If this is just a revision, don't send the email.
            if ( wp_is_post_revision($property_id) )
                return;

            if ( get_post_status($property_id) == 'publish' && get_post_type($property_id) == 'properties' && isset($_POST) && ! empty($_POST) ) {

                $property_old_member_id = get_post_meta($property_id, 'wp_rem_property_member', true);
                $wp_rem_property_status = get_post_meta($property_id, 'wp_rem_property_status', true);
                $property_new_member_id = isset($_POST['wp_rem_property_member']) ? $_POST['wp_rem_property_member'] : '';

                if ( $property_old_member_id != $property_new_member_id && $wp_rem_property_status == 'active' ) {
                    if ( $property_old_member_id != '' ) {
                        do_action('wp_rem_plublisher_properties_decrement', $property_old_member_id);
                    }
                    if ( $property_new_member_id != '' ) {
                        do_action('wp_rem_plublisher_properties_increment', $property_new_member_id);
                    }
                }

                $wp_rem_property_old_status = get_post_meta($property_id, 'wp_rem_property_status', true);
                $wp_rem_property_new_status = isset($_POST['wp_rem_property_status']) ? $_POST['wp_rem_property_status'] : '';
                if ( $wp_rem_property_old_status != $wp_rem_property_new_status ) {
                    if ( $wp_rem_property_new_status == 'active' && $property_new_member_id != '' ) {
                        do_action('wp_rem_plublisher_properties_increment', $property_new_member_id);
                    } else if ( $wp_rem_property_new_status != 'active' && $property_new_member_id != '' ) {
                        do_action('wp_rem_plublisher_properties_decrement', $property_new_member_id);
                    }
                }
            }
        }

        public function wp_rem_move_property_trash($new_status, $old_status, $property) {
            if ( isset($property->ID) && $property->ID != '' && get_post_type($property->ID) == 'properties' ) {
                $wp_rem_property_status = get_post_meta($property->ID, 'wp_rem_property_status', true);
                $property_member_id = get_post_meta($property->ID, 'wp_rem_property_member', true);
                if ( $property_member_id != '' && $wp_rem_property_status == 'active' ) {
                    if ( $old_status == 'publish' && $new_status != 'publish' ) {
                        do_action('wp_rem_plublisher_properties_decrement', $property_member_id);
                    }
                    if ( $old_status != 'publish' && $new_status == 'publish' ) {
                        do_action('wp_rem_plublisher_properties_increment', $property_member_id);
                    }
                }
            }
        }

        function wp_rem_meta_properties_add() {
            add_meta_box('wp_rem_meta_properties', wp_rem_plugin_text_srt('wp_rem_property_options'), array( $this, 'wp_rem_meta_properties' ), 'properties', 'normal', 'high');
        }

        /**
         * Start Function How to Attach mata box with post
         */
        function wp_rem_meta_properties($post) {
            ?>
            <div class="page-wrap page-opts left" style="overflow:hidden; position:relative;">
                <div class="option-sec" style="margin-bottom:0;">
                    <div class="opt-conts">
                        <div class="elementhidden">
                            <nav class="admin-navigtion">
                                <ul id="cs-options-tab">
                                    <li><a href="javascript:void(0);" name="#tab-general-settings" href="javascript:;"><i class="icon-settings"></i><?php echo wp_rem_plugin_text_srt('wp_rem_general_info'); ?> </a></li>
                                    <li><a href="javascript:void(0);" name="#tab-package-settings" href="javascript:;"><i class="icon-list"></i> <?php echo wp_rem_plugin_text_srt('wp_rem_package_info'); ?></a></li>
                                </ul>
                            </nav>
                            <div id="tabbed-content" data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
                                <div id="tab-general-settings">
                                    <?php $this->wp_rem_property_options(); ?>
                                </div>
                                <div id="tab-package-settings">
                                    <?php $this->wp_rem_package_info_options(); ?>
                                </div>
                            </div>
                            <?php $this->wp_rem_submit_meta_box('properties', $args = array()); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <?php
        }

        function wp_rem_property_options() {
            global $post, $wp_rem_form_fields, $wp_rem_form_fields, $wp_rem_html_fields, $wp_rem_plugin_options;
            $post_id = $post->ID;
            $wp_rem_property_types = array();
            $property_detail_page = get_post_meta($post_id, 'wp_rem_property_detail_page', true);
            $wp_rem_args = array( 'posts_per_page' => '-1', 'post_type' => 'properties_capacity', 'orderby' => 'ID', 'post_status' => 'publish' );
            $cust_query = get_posts($wp_rem_args);
            $wp_rem_property_capacity = get_post_meta($post->ID, 'wp_rem_property_capacity', true);
            $wp_rem_property_featured = get_post_meta($post->ID, 'wp_rem_property_featured', true);
            $property_type_slug = get_post_meta($post->ID, 'wp_rem_property_type', true);
            $property_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish' ));
            $property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
            $wp_rem_type_full_data = get_post_meta($property_type_id, 'wp_rem_full_data', true);

            $wp_rem_users_list = array( '' => wp_rem_plugin_text_srt('wp_rem_property_select_member') );
            $args = array( 'posts_per_page' => '-1', 'post_type' => 'members', 'orderby' => 'title', 'post_status' => 'publish', 'order' => 'ASC' );
            $cust_query = get_posts($args);
            if ( is_array($cust_query) && sizeof($cust_query) > 0 ) {
                foreach ( $cust_query as $package_post ) {
                    if ( isset($package_post->ID) ) {
                        $package_id = $package_post->ID;
                        $package_title = $package_post->post_title;
                        $wp_rem_users_list[$package_id] = $package_title;
                    }
                }
            }

            $wp_rem_packages_list = array( '' => wp_rem_plugin_text_srt('wp_rem_select_package') );
            $args = array( 'posts_per_page' => '-1', 'post_type' => 'packages', 'orderby' => 'title', 'post_status' => 'publish', 'order' => 'ASC' );
            $cust_query = get_posts($args);
            if ( is_array($cust_query) && sizeof($cust_query) > 0 ) {
                foreach ( $cust_query as $package_post ) {
                    if ( isset($package_post->ID) ) {
                        $package_id = $package_post->ID;
                        $package_title = $package_post->post_title;
                        $wp_rem_packages_list[$package_id] = $package_title;
                    }
                }
            }


            $wp_rem_calendar = get_post_meta($post_id, 'wp_rem_calendar', true);
            $property_types_data = array( '' => wp_rem_plugin_text_srt('wp_rem_property_type') );
            $wp_rem_property_args = array( 'posts_per_page' => '-1', 'post_type' => 'property-type', 'orderby' => 'title', 'post_status' => 'publish', 'order' => 'ASC' );
            $cust_query = get_posts($wp_rem_property_args);
            if ( is_array($cust_query) && sizeof($cust_query) > 0 ) {
                foreach ( $cust_query as $wp_rem_property_type ) {
                    $property_types_data[$wp_rem_property_type->post_name] = get_the_title($wp_rem_property_type->ID);
                }
            }

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_type'),
                'desc' => '',
                'hint_text' => wp_rem_plugin_text_srt('wp_rem_property_type_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'property_type',
                    'extra_atr' => ' onchange="wp_rem_property_type_change(this.value, \'' . $post_id . '\')"',
                    'classes' => 'chosen-select-no-single',
                    'return' => true,
                    'options' => $property_types_data,
                ),
            );
            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

            echo '<div id="wp-rem-property-type-field">';
            $this->property_type_change_fields($property_type_slug, $post_id);
            echo '</div>';

            $wp_rem_property_cus_fields = get_option("wp_rem_property_cus_fields");
            if ( is_array($wp_rem_property_cus_fields) && sizeof($wp_rem_property_cus_fields) > 0 ) {
                foreach ( $wp_rem_property_cus_fields as $cus_field ) {
                    $wp_rem_type = isset($cus_field['type']) ? $cus_field['type'] : '';
                    switch ( $wp_rem_type ) {
                        case('text'):
                            if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {
                                $wp_rem_opt_array = array(
                                    'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                    'desc' => '',
                                    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                        'id' => $cus_field['meta_key'],
                                        'cus_field' => true,
                                        'return' => true,
                                    ),
                                );

                                $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            }
                            break;
                        case('textarea'):
                            if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {
                                $wp_rem_opt_array = array(
                                    'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                    'desc' => '',
                                    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                        'id' => $cus_field['meta_key'],
                                        'cus_field' => true,
                                        'return' => true,
                                    ),
                                );

                                $wp_rem_html_fields->wp_rem_textarea_field($wp_rem_opt_array);
                            }
                            break;
                        case('dropdown'):
                            if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {
                                $wp_rem_options = array();
                                if ( isset($cus_field['options']['value']) && is_array($cus_field['options']['value']) && sizeof($cus_field['options']['value']) > 0 ) {
                                    if ( isset($cus_field['first_value']) && $cus_field['first_value'] != '' ) {
                                        $wp_rem_options[''] = $cus_field['first_value'];
                                    }
                                    $wp_rem_opt_counter = 0;
                                    foreach ( $cus_field['options']['value'] as $wp_rem_option ) {

                                        $wp_rem_opt_label = $cus_field['options']['label'][$wp_rem_opt_counter];
                                        $wp_rem_options[$wp_rem_option] = $wp_rem_opt_label;
                                        $wp_rem_opt_counter ++;
                                    }
                                }

                                $wp_rem_opt_array = array(
                                    'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                    'desc' => '',
                                    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                        'id' => $cus_field['meta_key'],
                                        'options' => $wp_rem_options,
                                        'classes' => 'chosen-select-no-single',
                                        'cus_field' => true,
                                        'return' => true,
                                    ),
                                );

                                if ( isset($cus_field['multi']) && $cus_field['multi'] == 'yes' ) {
                                    $wp_rem_opt_array['multi'] = true;
                                }
                                $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                            }
                            break;
                        case('date'):
                            if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {
                                $wp_rem_format = isset($cus_field['date_format']) && $cus_field['date_format'] != '' ? $cus_field['date_format'] : 'd-m-Y';

                                $wp_rem_opt_array = array(
                                    'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                    'desc' => '',
                                    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                        'id' => $cus_field['meta_key'],
                                        'format' => $wp_rem_format,
                                        'cus_field' => true,
                                        'return' => true,
                                    ),
                                );

                                $wp_rem_html_fields->wp_rem_date_field($wp_rem_opt_array);
                            }
                            break;
                        case('email'):
                            if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {
                                $wp_rem_opt_array = array(
                                    'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                    'desc' => '',
                                    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                        'id' => $cus_field['meta_key'],
                                        'cus_field' => true,
                                        'return' => true,
                                    ),
                                );

                                $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            }
                            break;
                        case('url'):
                            if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {

                                $wp_rem_opt_array = array(
                                    'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                    'desc' => '',
                                    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                        'id' => $cus_field['meta_key'],
                                        'cus_field' => true,
                                        'return' => true,
                                    ),
                                );

                                $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            }
                            break;
                        case('range'):
                            if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {
                                $wp_rem_opt_array = array(
                                    'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                    'desc' => '',
                                    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                        'id' => $cus_field['meta_key'],
                                        'cus_field' => true,
                                        'classes' => 'wp-rem-range-field',
                                        'extra_atr' => 'data-min="' . $cus_field['min'] . '" data-max="' . $cus_field['max'] . '"',
                                        'return' => true,
                                    ),
                                );

                                $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            }
                            break;
                    }
                }
            }

            do_action('wp_rem_indeed_property_admin_fields');

            $wp_rem_html_fields->wp_rem_heading_render(
                    array(
                        'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_property_video'),
                        'id' => 'property_video',
                        'classes' => '',
                        'std' => '',
                        'description' => '',
                        'hint' => ''
                    )
            );

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_video_url'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'property_video',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

            $wp_rem_form_fields->wp_rem_form_hidden_render(
                    array(
                        'name' => wp_rem_plugin_text_srt('wp_rem_property_organization'),
                        'id' => 'org_name',
                        'classes' => '',
                        'std' => '',
                        'description' => '',
                        'hint' => ''
                    )
            );
            $wp_rem_html_fields->wp_rem_heading_render(
                    array(
                        'name' => wp_rem_plugin_text_srt('wp_rem_property_mailing_information'),
                        'id' => 'mailing_information',
                        'classes' => '',
                        'std' => '',
                        'description' => '',
                        'hint' => ''
                    )
            );

            WP_REM_FUNCTIONS()->wp_rem_location_fields('off', '', 'property');
            $wp_rem_html_fields->wp_rem_heading_render(
                    array(
                        'name' => wp_rem_plugin_text_srt('property_contact_heading'),
                        'id' => 'contact_information',
                        'classes' => '',
                        'std' => '',
                        'description' => '',
                        'hint' => ''
                    )
            );
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('property_contact_email'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'property_contact_email',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('property_contact_phone'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'property_contact_phone',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('property_contact_web'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'property_contact_web',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_page_style'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'property_detail_page',
                    'classes' => 'chosen-select-no-single',
                    'options' => array(
                        '' => wp_rem_plugin_text_srt('wp_rem_list_meta_default_view'),
                        'detail_view1' => wp_rem_plugin_text_srt('wp_rem_list_meta_view_1'),
                        'detail_view2' => wp_rem_plugin_text_srt('wp_rem_list_meta_view_2'),
                        'detail_view3' => wp_rem_plugin_text_srt('wp_rem_list_meta_view_3'),
                        'detail_view4' => wp_rem_plugin_text_srt('wp_rem_list_meta_view_4'),
                    ),
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
        }

        /**
         * Start Function How to add form options in html
         */
        function wp_rem_package_info_options() {
            global $post, $wp_rem_form_fields, $wp_rem_form_fields, $wp_rem_html_fields, $wp_rem_plugin_options;
            $post_id = $post->ID;

            $wp_rem_property_types = array();
            $wp_rem_args = array( 'posts_per_page' => '-1', 'post_type' => 'properties_capacity', 'orderby' => 'ID', 'post_status' => 'publish' );
            $cust_query = get_posts($wp_rem_args);
            $wp_rem_property_capacity = get_post_meta($post->ID, 'wp_rem_property_capacity', true);
            $wp_rem_property_featured = get_post_meta($post->ID, 'wp_rem_property_featured', true);
            $property_type_slug = get_post_meta($post->ID, 'wp_rem_property_type', true);
            $property_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish' ));
            $property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
            $wp_rem_type_full_data = get_post_meta($property_type_id, 'wp_rem_full_data', true);

            $wp_rem_users_list = array( '' => wp_rem_plugin_text_srt('wp_rem_property_select_member') );
            $args = array( 'posts_per_page' => '-1', 'post_type' => 'members', 'orderby' => 'title', 'post_status' => 'publish', 'order' => 'ASC' );
            $cust_query = get_posts($args);
            if ( is_array($cust_query) && sizeof($cust_query) > 0 ) {
                foreach ( $cust_query as $package_post ) {
                    if ( isset($package_post->ID) ) {
                        $package_id = $package_post->ID;
                        $package_title = $package_post->post_title;
                        $wp_rem_users_list[$package_id] = $package_title;
                    }
                }
            }

            $wp_rem_packages_list = array( '' => wp_rem_plugin_text_srt('wp_rem_select_package') );
            $args = array( 'posts_per_page' => '-1', 'post_type' => 'packages', 'orderby' => 'title', 'post_status' => 'publish', 'order' => 'ASC' );
            $cust_query = get_posts($args);
            if ( is_array($cust_query) && sizeof($cust_query) > 0 ) {
                foreach ( $cust_query as $package_post ) {
                    if ( isset($package_post->ID) ) {
                        $package_id = $package_post->ID;
                        $package_title = $package_post->post_title;
                        $wp_rem_packages_list[$package_id] = $package_title;
                    }
                }
            }


            $wp_rem_calendar = get_post_meta($post_id, 'wp_rem_calendar', true);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('transaction_id'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'trans_id',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_posted_on'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'id' => 'property_posted',
                    'classes' => '',
                    'strtotime' => true,
                    'std' => '', //date('d-m-Y H:i:s'),
                    'description' => '',
                    'hint' => '',
                    'format' => 'd-m-Y',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_date_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_expired_on'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => '', //date('d-m-Y'),
                    'id' => 'property_expired',
                    'format' => 'd-m-Y',
                    'strtotime' => true,
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_date_field($wp_rem_opt_array);

            apply_filters('property_hunt_application_deadline_field', '');


            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_package'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'property_package',
                    'classes' => 'chosen-select-no-single',
                    'options' => $wp_rem_packages_list,
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_status'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'property_status',
                    'classes' => 'chosen-select-no-single',
                    'options' => array( 'active' => wp_rem_plugin_text_srt('wp_rem_property_active'), 'awaiting-activation' => wp_rem_plugin_text_srt('wp_rem_property_awaiting_activation'), 'inactive' => wp_rem_plugin_text_srt('wp_rem_property_inactive'), 'delete' => wp_rem_plugin_text_srt('wp_rem_property_delete') ),
                    'return' => true,
                ),
            );

            $wp_rem_property_status = get_post_meta($post->ID, 'wp_rem_property_status', true);
            $wp_rem_form_fields->wp_rem_form_hidden_render(
                    array(
                        'name' => wp_rem_plugin_text_srt('wp_rem_property_property_old_status'),
                        'id' => 'property_old_status',
                        'classes' => '',
                        'std' => $wp_rem_property_status,
                        'description' => '',
                        'hint' => ''
                    )
            );

            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

            // package assign data
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_featured'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'id' => 'property_is_featured',
                    'classes' => '',
                    'std' => '',
                    'description' => '',
                    'hint' => '',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_top_category'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'id' => 'property_is_top_cat',
                    'classes' => '',
                    'std' => '',
                    'description' => '',
                    'hint' => '',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_no_of_pictures'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'id' => 'transaction_property_pic_num',
                    'classes' => '',
                    'std' => '',
                    'description' => '',
                    'hint' => '',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_no_of_documents'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'id' => 'transaction_property_doc_num',
                    'classes' => '',
                    'std' => '',
                    'description' => '',
                    'hint' => '',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_no_of_tags'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'id' => 'transaction_property_tags_num',
                    'classes' => '',
                    'std' => '',
                    'description' => '',
                    'hint' => '',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_reviews'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'id' => 'transaction_property_reviews',
                    'classes' => '',
                    'std' => '',
                    'description' => '',
                    'hint' => '',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_phone_number'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'id' => 'transaction_property_phone',
                    'classes' => '',
                    'std' => '',
                    'description' => '',
                    'hint' => '',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_website_link'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'id' => 'transaction_property_website',
                    'classes' => '',
                    'std' => '',
                    'description' => '',
                    'hint' => '',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_social_reach'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'id' => 'transaction_property_social',
                    'classes' => '',
                    'std' => '',
                    'description' => '',
                    'hint' => '',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_respond'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'id' => 'transaction_property_ror',
                    'classes' => '',
                    'std' => '',
                    'description' => '',
                    'hint' => '',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);


            /*
             * Property Elements Settings
             */

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_features_element'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'id' => 'enable_features_element',
                    'classes' => '',
                    'std' => 'on',
                    'description' => '',
                    'hint' => '',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_video_element'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'id' => 'enable_video_element',
                    'classes' => '',
                    'std' => 'on',
                    'description' => '',
                    'hint' => '',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_yelp_element'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'id' => 'enable_yelp_places_element',
                    'classes' => '',
                    'std' => 'on',
                    'description' => '',
                    'hint' => '',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_appartment_element'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'id' => 'enable_appartment_for_sale_element',
                    'classes' => '',
                    'std' => 'on',
                    'description' => '',
                    'hint' => '',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_file_element'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'id' => 'enable_file_attachments_element',
                    'classes' => '',
                    'std' => 'on',
                    'description' => '',
                    'hint' => '',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_floor_plan_element'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'id' => 'enable_floot_plan_element',
                    'classes' => '',
                    'std' => 'on',
                    'description' => '',
                    'hint' => '',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);


            $trans_dynamic_values = get_post_meta($post_id, 'wp_rem_transaction_dynamic', true);
            if ( is_array($trans_dynamic_values) && sizeof($trans_dynamic_values) > 0 ) {
                foreach ( $trans_dynamic_values as $trans_dynamic ) {
                    if ( isset($trans_dynamic['field_type']) && isset($trans_dynamic['field_label']) && isset($trans_dynamic['field_value']) ) {
                        $d_type = $trans_dynamic['field_type'];
                        $d_label = $trans_dynamic['field_label'];
                        $d_value = $trans_dynamic['field_value'];
                        if ( $d_type == 'single-choice' ) {
                            $d_value = $d_value == 'on' ? wp_rem_plugin_text_srt('wp_rem_property_yes') : wp_rem_plugin_text_srt('wp_rem_property_no');
                        }

                        echo '<div class="form-elements"><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><label>' . $d_label . '</label></div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">' . $d_value . '</div></div>' . "\n";
                    }
                }
                // end foreach
            }
            // package assign data

            /*
             * Fields for property Posted by
             */
            do_action('wp_rem_posted_by_admin_fields');
        }

        public function property_type_change_fields($property_type_slug = 0, $post_id = 0) {
            if ( isset($_POST['property_type_slug']) ) {
                $property_type_slug = $_POST['property_type_slug'];
            }
            if ( isset($_POST['post_id']) ) {
                $post_id = $_POST['post_id'];
            }

            $html = $this->property_price($property_type_slug, $post_id);
            $html .= $this->property_categories($property_type_slug, $post_id);
            $html .= $this->property_tags($property_type_slug, $post_id);
            $html .= $this->property_summary();
            $html .= $this->property_type_dyn_fields($property_type_slug);
            $html .= $this->feature_fields($property_type_slug, $post_id);
            $html .= $this->open_house_fields($property_type_slug, $post_id);
            $html .= apply_filters('wp_rem_images_gallery_admin_fields', $post_id, $property_type_slug);
            $html .= apply_filters('wp_rem_attachemnts_admin_fields', $post_id, $property_type_slug);
            $html .= apply_filters('wp_rem_floor_plans_admin_fields', $post_id, $property_type_slug);
            $html .= apply_filters('wp_rem_apartment_admin_fields', $post_id, $property_type_slug);
            if ( isset($_POST['property_type_slug']) ) {
                echo json_encode(array( 'property_fields' => $html ));
                die;
            } else {
                echo force_balance_tags($html);
            }
        }

        public function wp_rem_save_property_features() {
            $property_id = get_the_id();
            $wp_rem_property_feature_list = isset($_POST['wp_rem_property_feature_list']) ? $_POST['wp_rem_property_feature_list'] : '';
            update_post_meta($property_id, 'wp_rem_property_feature_list', $wp_rem_property_feature_list);
        }

        public function wp_rem_save_property_open_house() {
            $property_id = get_the_id();

            $wp_rem_open_house_date = isset($_POST['wp_rem_open_house_date']) ? $_POST['wp_rem_open_house_date'] : '';
            $wp_rem_open_house_time_from = isset($_POST['wp_rem_open_house_time_from']) ? $_POST['wp_rem_open_house_time_from'] : '';
            $wp_rem_open_house_time_to = isset($_POST['wp_rem_open_house_time_to']) ? $_POST['wp_rem_open_house_time_to'] : '';

            $time_from = isset($wp_rem_open_house_time_from) ? ' ' . $wp_rem_open_house_time_from : '';
            $time_to = isset($wp_rem_open_house_time_to) ? ' ' . $wp_rem_open_house_time_to : '';
            $start_date = strtotime($wp_rem_open_house_date . $time_from);
            $end_date = strtotime($wp_rem_open_house_date . $time_to);
            if ( $wp_rem_open_house_date != '' && $wp_rem_open_house_time_from != '' && $wp_rem_open_house_time_to != '' ) {
                update_post_meta($property_id, 'open_house_start', $start_date);
                update_post_meta($property_id, 'open_house_end', $end_date);
            } else {
                update_post_meta($property_id, 'open_house_start', '');
                update_post_meta($property_id, 'open_house_end', '');
            }
        }

        function property_summary() {
            global $post, $wp_rem_html_fields;
            $wp_rem_property_summary = get_post_meta($post->ID, 'wp_rem_property_summary', true);
            $wp_rem_property_summary = isset($wp_rem_property_summary[0]) ? $wp_rem_property_summary[0] : '';
            $html = '';
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_property_summary'),
                'desc' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_attr($wp_rem_property_summary),
                    'id' => 'property_summary',
                    'return' => true,
                    'classes' => '',
                ),
            );
            $html .= $wp_rem_html_fields->wp_rem_textarea_field($wp_rem_opt_array);
            return $html;
        }

        function property_price($property_type_slug = 0, $post_id = 0) {
            global $post, $wp_rem_html_fields, $wp_rem_plugin_options;
            $property_type_post = get_posts(array( 'fields' => 'ids', 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish' ));
            $property_type_id = isset($property_type_post[0]) && $property_type_post[0] != '' ? $property_type_post[0] : 0;
            $wp_rem_property_type_price = get_post_meta($property_type_id, 'wp_rem_property_type_price', true);
            $price_type = get_post_meta($property_type_id, 'wp_rem_property_type_price_type', true);

            $price_type_options = array(
                'variant_week' => wp_rem_plugin_text_srt('wp_rem_list_meta_per_week'),
                'variant_month' => wp_rem_plugin_text_srt('wp_rem_list_meta_per_cm'),
            );

            if ( $price_type == 'fixed' ) {
                $price_type_options = isset($wp_rem_plugin_options['fixed_price_opt']) ? $wp_rem_plugin_options['fixed_price_opt'] : '';
            }

            $wp_rem_property_type_price = isset($wp_rem_property_type_price) && $wp_rem_property_type_price != '' ? $wp_rem_property_type_price : 'off';
            $html = '';

            if ( $wp_rem_property_type_price == 'on' ) {
                $wp_rem_opt_array = array(
                    'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_price_option'),
                    'desc' => '',
                    'hint_text' => '',
                    'echo' => false,
                    'field_params' => array(
                        'std' => '',
                        'extra_atr' => 'onchange="wp_rem_property_price_change(this.value)"',
                        'id' => 'property_price_options',
                        'classes' => 'chosen-select-no-single ',
                        'options' => array(
                            'none' => wp_rem_plugin_text_srt('wp_rem_list_meta_none'),
                            'on-call' => wp_rem_plugin_text_srt('wp_rem_list_meta_on_call'),
                            'price' => wp_rem_plugin_text_srt('wp_rem_list_meta_price'),
                        ),
                        'return' => true,
                    ),
                );
                $html .= "<script>
		    function wp_rem_property_price_change(price_selection) {
			if (price_selection == 'none' || price_selection == 'on-call') {
			    jQuery('.dynamic_price_field').hide();
			} else {
			    jQuery('.dynamic_price_field').show();
			}
		    }
		</script>";
                $html .= $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                $wp_rem_property_price_options = get_post_meta($post->ID, 'wp_rem_property_price_options', true);
                $wp_rem_property_price_options = isset($wp_rem_property_price_options) ? $wp_rem_property_price_options : '';
                $hide_div = '';
                if ( $wp_rem_property_price_options == '' || $wp_rem_property_price_options == 'none' || $wp_rem_property_price_options == 'on-call' ) {
                    $hide_div = 'style="display:none;"';
                }
                $wp_rem_opt_array = array(
                    'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_ad_price'),
                    'desc' => '',
                    'hint_text' => '',
                    'main_wraper' => true,
                    'main_wraper_class' => 'dynamic_price_field',
                    'main_wraper_extra' => $hide_div,
                    'echo' => false,
                    'field_params' => array(
                        'cust_type' => 'number',
                        'std' => '',
                        'classes' => 'wp-rem-number-field ',
                        'id' => 'property_price',
                        'return' => true,
                    ),
                );
                $html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

                $wp_rem_opt_array = array(
                    'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_ad_price'),
                    'desc' => '',
                    'hint_text' => '',
                    'main_wraper' => true,
                    'main_wraper_class' => 'dynamic_price_field',
                    'main_wraper_extra' => 'style="display:none;"',
                    'echo' => false,
                    'field_params' => array(
                        'std' => '',
                        'classes' => 'wp-rem-number-field ',
                        'id' => 'property_price_num',
                        'return' => true,
                    ),
                );
                // $html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

                $wp_rem_opt_array = array(
                    'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_ad_price_ttd'),
                    'desc' => '',
                    'hint_text' => '',
                    'main_wraper' => true,
                    'main_wraper_class' => 'dynamic_price_field',
                    'main_wraper_extra' => $hide_div,
                    'echo' => false,
                    'field_params' => array(
                        'cust_type' => 'number',
                        'std' => '',
                        'classes' => 'wp-rem-number-field ',
                        'id' => 'property_price_ttd',
                        'return' => true,
                    ),
                );
                $html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

                $wp_rem_opt_array = array(
                    'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_ad_price_ttd'),
                    'desc' => '',
                    'hint_text' => '',
                    'main_wraper' => true,
                    'main_wraper_class' => 'dynamic_price_field',
                    'main_wraper_extra' => 'style="display:none;"',
                    'echo' => false,
                    'field_params' => array(
                        'std' => '',
                        'classes' => 'wp-rem-number-field ',
                        'id' => 'property_price_ttd_num',
                        'return' => true,
                    ),
                );
                // $html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

                $wp_rem_opt_array = array(
                    'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_price_type'),
                    'desc' => '',
                    'hint_text' => '',
                    'main_wraper' => true,
                    'main_wraper_class' => 'dynamic_price_field',
                    'main_wraper_extra' => $hide_div,
                    'echo' => false,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'price_type',
                        'classes' => 'chosen-select-no-single ',
                        'options' => $price_type_options,
                        'return' => true,
                    ),
                );
                $html .= $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
            }

            return $html;
        }

        function property_categories($property_type_slug = 0, $post_id = 0, $backend = true) {
            global $post, $wp_rem_html_fields, $wp_rem_plugin_static_text, $wp_rem_form_fields;
            $html = '';
            wp_enqueue_script('wp-rem-property-categories');
            $property_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish' ));
            $property_type_slug = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;

            $wp_rem_property_type_category_array = get_the_terms($property_type_slug, 'property-category');
            $wp_rem_property_type_categories = array();
            $wp_rem_property_type_categories[''] = wp_rem_plugin_text_srt('wp_rem_property_select_categories');
            if ( is_array($wp_rem_property_type_category_array) && sizeof($wp_rem_property_type_category_array) > 0 ) {
                foreach ( $wp_rem_property_type_category_array as $in_category ) {
                    $wp_rem_property_type_categories[$in_category->term_id] = $in_category->name;
                }
            }
            if ( ! isset($wp_rem_property_type_categories) || ! is_array($wp_rem_property_type_categories) || ! count($wp_rem_property_type_categories) > 0 ) {
                $wp_rem_property_type_categories = array();
            }

            $property_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish' ));
            $property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;

            $wp_rem_property_type_category = get_post_meta($property_type_id, 'wp_rem_property_type_categories', true);

            if ( ! isset($wp_rem_property_type_category) || ! is_array($wp_rem_property_type_category) || ! count($wp_rem_property_type_category) > 0 ) {
                $wp_rem_property_type_category = array();
            }
            $wp_rem_multi_cat_option = 'off';

            $multiple = false;
            if ( $wp_rem_multi_cat_option == 'on' ) {
                $multiple = true;
            }

            $wp_rem_sub_child = '';

            $property_type_cats = array( '' => wp_rem_plugin_text_srt('wp_rem_property_property_all_categories') );
            $wp_rem_property_type_cats = get_post_meta($property_type_slug, 'wp_rem_property_type_cats', true);
            if ( isset($wp_rem_property_type_cats) && ! empty($wp_rem_property_type_cats) ) {
                foreach ( $wp_rem_property_type_cats as $wp_rem_property_type_cat ) {
                    $term = get_term_by('slug', $wp_rem_property_type_cat, 'property-category');
                    $property_type_cats[$term->slug] = $term->name;
                }
            }
            $wp_rem_property_category_val = get_post_meta($post_id, 'wp_rem_property_category', true);
            $wp_rem_property_selected_value = isset($wp_rem_property_category_val['parent']) && $wp_rem_property_category_val['parent'] != '' ? $wp_rem_property_category_val['parent'] : '';
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_categories'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => $wp_rem_property_selected_value,
                    'cust_name' => 'wp_rem_property_category[parent]',
                    'classes' => 'chosen-select wp-rem-dev-req-field',
                    'extra_atr' => ' onchange = "wp_rem_load_category_models(this.value,\'' . $post_id . '\', \'wp_rem_property_category_field\', \'0\')" ',
                    'options' => $property_type_cats,
                    'return' => true,
                ),
            );

            $wp_rem_opt_array_frontend = array(
                'std' => $wp_rem_property_selected_value,
                'cust_name' => 'wp_rem_property_category[parent]',
                'classes' => 'chosen-select wp-rem-dev-req-field',
                'extra_atr' => ' onchange = "wp_rem_load_category_models(this.value,\'' . $post_id . '\', \'wp_rem_property_category_field\', \'0\')" ',
                'options' => $property_type_cats,
                'return' => true,
            );
            if ( $backend == true ) {
                $html .= $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
            } else {
                if ( isset($wp_rem_property_type_cats) && ! empty($wp_rem_property_type_cats) ) {
                    if ( isset($_COOKIE['wp_rem_was_create_property']) && is_user_logged_in() ) {
                        $pre_cookie_val = stripslashes($_COOKIE['wp_rem_was_create_property']);
                        $pre_cookie_val = json_decode($pre_cookie_val, true);
                        $wp_rem_property_selected_value = isset($pre_cookie_val['category']) ? $pre_cookie_val['category'] : '';
                        $wp_rem_sub_child = isset($pre_cookie_val['sub_category']) ? $pre_cookie_val['sub_category'] : '';
                    }
                    $html .= '
                                <div class="dashboard-title">
                                        <strong>' . wp_rem_plugin_text_srt('wp_rem_list_meta_step_2') . '</strong>
                                </div>
                                <div class="field-holder">';
                    $html .= '<ul class="property-cats-list">';
                    $categ_contr = 0;
                    foreach ( $wp_rem_property_type_cats as $wp_rem_property_type_cat ) {
                        $term = get_term_by('slug', $wp_rem_property_type_cat, 'property-category');
                        $term_id = isset($term->term_id) ? $term->term_id : '';
                        if ( $term_id != '' ) {
                            if ( empty($wp_rem_property_selected_value) && $categ_contr == 0 ) {
                                $wp_rem_property_selected_value = $term->slug;
                            }
                            $typ_imag = get_term_meta($term_id, 'wp_rem_property_taxonomy_icon', true);
                            $html .= '<li>
                                            <div class="type-categry-holder-main type-categry-holder-main-' . $term_id . '">
                                                    <input id="property-cat-' . $term_id . '" onclick="wp_rem_load_category_models(this.value,\'' . $term_id . '\', \'wp_rem_property_category_field\', \'0\', \'\', \'parent_loader\')" class="wp-rem-dev-req-field" type="radio" name="wp_rem_property_category[parent]" value="' . $term->slug . '"' . ($term->slug == $wp_rem_property_selected_value ? ' checked="checked"' : '') . '>
                                                    <label for="property-cat-' . $term_id . '">' . ($typ_imag != '' ? '<div class="image-holder"><i class="' . $typ_imag . '"></i></div>' : '') . '<span>' . $term->name . '</span></label>
                                                    <span class="loader-holder"><img src="' . wp_rem::plugin_url() . 'assets/frontend/images/ajax-loader.gif" alt=""></span>
                                            </div>
                                    </li>';
                            $categ_contr ++;
                        }
                    }
                    $html .= '</ul>';
                    $html .= '</div>';
                }
            }

            if ( is_admin() ) {
                $html .= '<div class="form-elements">';
                $html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
            }
            $html .= '<div class="wp_rem_property_category_field">';
            $html .= '</div>';
            if ( is_admin() ) {
                $html .= '</div>';
                $html .= '</div>';
            }
            $html .= '<script>';
            $html .= 'jQuery(document).ready(function () {';
            $html .= 'wp_rem_load_category_models(\'' . $wp_rem_property_selected_value . '\',\'' . $post_id . '\', \'wp_rem_property_category_field\', \'1\', \'' . $wp_rem_sub_child . '\');';
            $html .= '});';
            $html .= '</script>';
            return $html;
        }

        public function wp_rem_meta_property_categories($property_arg = '') {
            global $wp_rem_html_fields, $wp_rem_form_fields;
            $html = '';
            $selected_val = wp_rem_get_input('selected_val', '', 'STRING');
            $load_saved_value = wp_rem_get_input('load_saved_value', '', 'STRING');

            $wp_rem_property_category = wp_rem_get_input('wp_rem_property_category', '', 'STRING');
            $wp_rem_property_category_hidden = isset($wp_rem_property_category) && $wp_rem_property_category != '' ? unserialize(( $wp_rem_property_category)) : '';
            $post_id = wp_rem_get_input('post_id', '', 'STRING');
            $wp_rem_property_category_val = get_post_meta($post_id, 'wp_rem_property_category', true);
            if ( $selected_val != '' ) { // if selected value is empty
                $wp_rem_property_selected_value = isset($wp_rem_property_category_val[$selected_val]) && $wp_rem_property_category_val[$selected_val] != '' ? $wp_rem_property_category_val[$selected_val] : '';
                $single_term = get_term_by('slug', $selected_val, 'property-category');
                $single_term_id = isset($single_term->term_id) && $single_term->term_id != '' ? $single_term->term_id : '';
                $single_term_name = isset($single_term->name) && $single_term->name != '' ? $single_term->name : '';
                if ( $single_term_id != '' || $single_term_id != 0 ) { //if geiven value not correct or not return id
                    $cate_arg = array(
                        'hide_empty' => false,
                        'parent' => $single_term_id,
                    );
                    $wp_rem_category_array = get_terms('property-category', $cate_arg);
                    $property_type_cats = array( 'test' => 'ALL ' . $single_term_name );
                    if ( is_array($wp_rem_category_array) && sizeof($wp_rem_category_array) > 0 ) {

                        if ( isset($_POST['data_child']) && $_POST['data_child'] != '' ) {
                            $wp_rem_property_selected_value = $_POST['data_child'];
                        }
                        foreach ( $wp_rem_category_array as $dir_tag ) {
                            $property_type_cats[$dir_tag->slug] = $dir_tag->name;
                        }

                        $html .= '
						<div class="field-holder">
							<label>' . wp_rem_plugin_text_srt('wp_rem_property_categories') . $single_term_name . ' ?</label>';
                        $wp_rem_opt_array = array(
                            'std' => $wp_rem_property_selected_value,
                            'cust_name' => 'wp_rem_property_category[' . $selected_val . ']',
                            'classes' => 'chosen-select',
                            'extra_atr' => ' onchange="wp_rem_load_category_models(this.value,\'' . $post_id . '\', \'wp_rem_property_category_field' . $selected_val . '\', \'0\')"',
                            'options' => $property_type_cats,
                            'return' => true,
                        );

                        $html .= $wp_rem_html_fields->wp_rem_form_select_render($wp_rem_opt_array);
                        $html .= '
						</div>';

                        $html .= '<div class="wp_rem_property_category_field' . $selected_val . '">';
                        $html .= '</div>';


                        if ( (isset($load_saved_value) && $load_saved_value == '1' ) && $wp_rem_property_category_val != '' ) {
                            $html .= '<script>';
                            $html .= 'wp_rem_load_category_models(\'' . $wp_rem_property_selected_value . '\',\'' . $post_id . '\', \'wp_rem_property_category_field' . $selected_val . '\', ' . $load_saved_value . ');';
                            $html .= '</script>';
                        }
                    }
                }
            }// selected value is empty check
            $output = array( 'html' => $html, );
            echo json_encode($output);
            wp_die();
        }

        function property_tags($property_type_slug = 0, $post_id = 0) {
            global $post, $wp_rem_html_fields, $wp_rem_plugin_static_text;
            $html = '';

            $property_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish' ));
            $property_type_slug = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;

            $wp_rem_property_type_tags = get_post_meta($property_type_slug, 'wp_rem_property_type_tags', true);


            $wp_rem_tags_array = get_terms('property-tag', array(
                'hide_empty' => false,
            ));
            $wp_rem_tags_list = array();
            if ( is_array($wp_rem_tags_array) && sizeof($wp_rem_tags_array) > 0 ) {
                foreach ( $wp_rem_tags_array as $dir_tag ) {
                    $wp_rem_tags_list[$dir_tag->slug] = $dir_tag->name;
                }
            }

            $wp_rem_property_type_tags = get_post_meta($post_id, 'wp_rem_property_type_tags', true);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_select_suggested_tags'),
                'desc' => '',
                'hint_text' => wp_rem_plugin_text_srt('wp_rem_select_suggested_tags_hint'),
                //'echo' => true,
                'multi' => true,
                'desc' => sprintf('<a href="%s">' . wp_rem_plugin_text_srt('wp_rem_add_new_tag_link') . '</a>', admin_url('edit-tags.php?taxonomy=property-tag&post_type=properties', wp_rem_server_protocol())),
                'field_params' => array(
                    'std' => '', $wp_rem_property_type_tags,
                    'id' => 'tags',
                    'classes' => 'chosen-select-no-single chosen-select',
                    'options' => $wp_rem_tags_list,
                    'return' => true,
                ),
            );

            $html .= $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

            return $html;
        }

        function property_off_days($property_type_slug = 0, $post_id = 0) {
            global $wp_rem_form_fields, $wp_rem_html_fields, $wp_rem_plugin_static_text;

            $property_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish' ));
            $property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;

            $wp_rem_off_days = get_post_meta($property_type_id, 'wp_rem_off_days', true);
            if ( $wp_rem_off_days == 'on' ) {
                $html = $wp_rem_html_fields->wp_rem_heading_render(
                        array(
                            'name' => wp_rem_plugin_text_srt('wp_rem_property_off_days'),
                            'id' => 'off_days',
                            'classes' => '',
                            'std' => '',
                            'description' => '',
                            'hint' => '',
                            'echo' => false
                        )
                );
                $date_js = '';
                if ( isset($wp_rem_calendar) && ! empty($wp_rem_calendar) ) {
                    foreach ( $wp_rem_calendar as $calender_date ) {
                        $calender_date = strtotime($calender_date);
                        $dateVal = date("Y, m, d", strtotime('-1 month', $calender_date));
                        $date_js .= '{
							startDate: new Date(' . $dateVal . '),
							endDate: new Date(' . $dateVal . ')
						},';
                    }
                }
                $html .= $this->property_book_days_off();
                return $html;
            }
        }

        function property_type_dyn_fields($property_type_slug = 0) {
            global $wp_rem_html_fields, $wp_rem_plugin_static_text;
            $wp_rem_fields_output = '';
            $property_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish' ));
            $property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
            $wp_rem_property_type_cus_fields = get_post_meta($property_type_id, "wp_rem_property_type_cus_fields", true);
            $wp_rem_fields_output .= $wp_rem_html_fields->wp_rem_heading_render(
                    array(
                        'name' => wp_rem_plugin_text_srt('wp_rem_property_custom_fields'),
                        'id' => 'wp_rem_fields_section',
                        'classes' => '',
                        'std' => '',
                        'description' => '',
                        'hint' => '',
                        'echo' => false
                    )
            );
            if ( is_array($wp_rem_property_type_cus_fields) && sizeof($wp_rem_property_type_cus_fields) > 0 ) {
                foreach ( $wp_rem_property_type_cus_fields as $cus_field ) {
                    $wp_rem_type = isset($cus_field['type']) ? $cus_field['type'] : '';
                    $required_class = '';
                    if ( isset($cus_field['required']) && $cus_field['required'] == 'yes' ) {
                        $required_class = 'wp-rem-dev-req-field-admin';
                    }
                    switch ( $wp_rem_type ) {
                        case('section'):
                            break;
                        case('text'):

                            if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {
                                $wp_rem_opt_array = array(
                                    'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                    'desc' => '',
                                    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                    'echo' => false,
                                    'field_params' => array(
                                        'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                        'id' => $cus_field['meta_key'],
                                        'cus_field' => true,
                                        'classes' => $required_class,
                                        'return' => true,
                                    ),
                                );

                                $wp_rem_fields_output .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            }
                            break;

                        case('number'):

                            if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {
                                $wp_rem_opt_array = array(
                                    'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                    'desc' => '',
                                    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                    'echo' => false,
                                    'field_params' => array(
                                        'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                        'id' => $cus_field['meta_key'],
                                        'cus_field' => true,
                                        'classes' => 'wp-rem-number-field ' . $required_class,
                                        'cust_type' => 'number',
                                        'return' => true,
                                    ),
                                );

                                $wp_rem_fields_output .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            }
                            break;
                        case('textarea'):
                            if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {
                                $wp_rem_opt_array = array(
                                    'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                    'desc' => '',
                                    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                    'echo' => false,
                                    'field_params' => array(
                                        'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                        'id' => $cus_field['meta_key'],
                                        'classes' => $required_class,
                                        'cus_field' => true,
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_fields_output .= $wp_rem_html_fields->wp_rem_textarea_field($wp_rem_opt_array);
                            }
                            break;
                        case('dropdown'):
                            if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {
                                $wp_rem_dropdown_options = array();
                                if ( isset($cus_field['options']['value']) && is_array($cus_field['options']['value']) && sizeof($cus_field['options']['value']) > 0 ) {

                                    if ( isset($cus_field['first_value']) && $cus_field['first_value'] != '' ) {
                                        $wp_rem_dropdown_options[''] = $cus_field['first_value'];
                                    }
                                    $wp_rem_opt_counter = 0;
                                    foreach ( $cus_field['options']['value'] as $wp_rem_option ) {
                                        $wp_rem_opt_label = $cus_field['options']['label'][$wp_rem_opt_counter];
                                        $wp_rem_dropdown_options[$wp_rem_option] = $wp_rem_opt_label;
                                        $wp_rem_opt_counter ++;
                                    }
                                }

                                if ( isset($cus_field['chosen_srch']) && $cus_field['chosen_srch'] == 'yes' && count($wp_rem_dropdown_options) > 5 ) {
                                    $chosen_class = 'chosen-select';
                                } else {
                                    $chosen_class = 'chosen-select-no-single';
                                }

                                $wp_rem_opt_array = array(
                                    'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                    'desc' => '',
                                    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                    'echo' => false,
                                    'field_params' => array(
                                        'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                        'id' => $cus_field['meta_key'],
                                        'options' => $wp_rem_dropdown_options,
                                        'classes' => $chosen_class . ' ' . $required_class,
                                        'cus_field' => true,
                                        'return' => true,
                                    ),
                                );
                                if ( isset($cus_field['post_multi']) && $cus_field['post_multi'] == 'yes' ) {
                                    $wp_rem_opt_array['multi'] = true;
                                }

                                $wp_rem_fields_output .= $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                            }
                            break;
                        case('date'):
                            if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {
                                $wp_rem_format = isset($cus_field['date_format']) && $cus_field['date_format'] != '' ? $cus_field['date_format'] : 'd-m-Y';
                                $wp_rem_opt_array = array(
                                    'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                    'desc' => '',
                                    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                    'echo' => false,
                                    'field_params' => array(
                                        'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                        'id' => $cus_field['meta_key'],
                                        'format' => $wp_rem_format,
                                        'classes' => 'wp-rem-date-field ' . $required_class,
                                        'cus_field' => true,
                                        'strtotime' => true,
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_fields_output .= $wp_rem_html_fields->wp_rem_date_field($wp_rem_opt_array);
                            }
                            break;
                        case('email'):
                            if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {
                                $wp_rem_opt_array = array(
                                    'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                    'desc' => '',
                                    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                    'echo' => false,
                                    'field_params' => array(
                                        'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                        'id' => $cus_field['meta_key'],
                                        'classes' => 'wp-rem-email-field ' . $required_class,
                                        'cus_field' => true,
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_fields_output .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            }
                            break;
                        case('url'):
                            if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {

                                $wp_rem_opt_array = array(
                                    'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                    'desc' => '',
                                    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                    'echo' => false,
                                    'field_params' => array(
                                        'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                        'id' => $cus_field['meta_key'],
                                        'classes' => 'wp-rem-url-field ' . $required_class,
                                        'cus_field' => true,
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_fields_output .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            }
                            break;
                        case('range'):
                            if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {
                                $wp_rem_opt_array = array(
                                    'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                    'desc' => '',
                                    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                    'echo' => false,
                                    'field_params' => array(
                                        'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                        'id' => $cus_field['meta_key'],
                                        'cus_field' => true,
                                        'classes' => 'wp-rem-range-field ' . $required_class,
                                        'extra_atr' => 'data-min="' . $cus_field['min'] . '" data-max="' . $cus_field['max'] . '"',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_fields_output .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            }
                            break;
                    }
                }
                $wp_rem_fields_output .= '
                    <script>
                    jQuery(document).ready(function () {
                        chosen_selectionbox();
                    });
                    </script>';
            } else {
                $wp_rem_fields_output .= '<div class="custom-field-error">';
                $wp_rem_fields_output .= wp_rem_plugin_text_srt('wp_rem_property_no_custom_field_found');
                $wp_rem_fields_output .= '</div>';
            }

            return $wp_rem_fields_output;
        }

        function feature_fields($property_type_slug = 0, $post_id = 0) {
            global $wp_rem_form_fields, $wp_rem_html_fields, $wp_rem_plugin_static_text;

            $wp_rem_property_features = get_post_meta($post_id, 'wp_rem_property_feature_list', true);

            $wp_rem_property_features_array = array();
            if ( ! empty($wp_rem_property_features) ) {
                foreach ( $wp_rem_property_features as $feature ) {
                    if ( $feature != '' ) {
                        $explode_data = explode("_icon", $feature);
                        $feature_name = $explode_data[0];
                        $wp_rem_property_features_array[] = $feature_name;
                    }
                }
            }
            $html = $wp_rem_html_fields->wp_rem_heading_render(
                    array(
                        'name' => wp_rem_plugin_text_srt('wp_rem_property_features'),
                        'id' => 'features_information',
                        'classes' => '',
                        'std' => '',
                        'description' => '',
                        'hint' => '',
                        'echo' => false
                    )
            );

            $html .= $wp_rem_html_fields->wp_rem_opening_field(array( 'name' => wp_rem_plugin_text_srt('wp_rem_property_features') ));

            $property_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish' ));
            $property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
            $wp_rem_get_features = get_post_meta($property_type_id, 'feature_lables', true);
            $wp_rem_feature_icon = get_post_meta($property_type_id, 'wp_rem_feature_icon', true);
            $wp_rem_feature_icon_group = get_post_meta($property_type_id, 'wp_rem_feature_icon_group', true);


            if ( is_array($wp_rem_get_features) && sizeof($wp_rem_get_features) > 0 ) {

                $html .= '<ul class="checkbox-list">';
                foreach ( $wp_rem_get_features as $feat_key => $features ) {
                    $feat_rand = rand(1000000, 99999999);
                    if ( isset($features) && $features <> '' ) {
                        $wp_rem_feature_name = isset($features) ? $features : '';
                        $icon = isset($wp_rem_feature_icon[$feat_key]) ? $wp_rem_feature_icon[$feat_key] : '';
                        $icon_group = isset($wp_rem_feature_icon_group[$feat_key]) ? $wp_rem_feature_icon_group[$feat_key] : '';
                        $html .= '<li class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';
                        $wp_rem_opt_array = array(
                            'std' => '' . $wp_rem_feature_name . "_icon" . $icon . '_icon' . $icon_group,
                            'id' => 'feat-' . $feat_rand . '',
                            'cust_name' => 'wp_rem_property_feature_list[]',
                            'return' => true,
                            'cust_type' => 'checkbox',
                            'extra_atr' => ' ' . (is_array($wp_rem_property_features) && in_array($wp_rem_feature_name, $wp_rem_property_features_array) ? ' checked="checked"' : '') . '',
                            'prefix_on' => false,
                        );
                        $html .=$wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);

                        $html .= '<label for="feat-' . $feat_rand . '">  <i class="' . $icon . '"></i> ' . $wp_rem_feature_name . '</label>';
                        $html .= '</li>';
                    }
                }
                $html .='</ul>';
            }

            $html .= $wp_rem_html_fields->wp_rem_closing_field(array());

            return $html;
        }

        /*
         * Open House Fields
         */

        function open_house_fields($property_type_slug = 0, $post_id = 0) {
            global $wp_rem_html_fields;
            $html = '';
            $property_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish' ));
            $property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
            $wp_rem_property_opening_house = get_post_meta($property_type_id, 'wp_rem_property_type_open_house', true);
            if ( $wp_rem_property_opening_house == 'on' ) {
                $html = $wp_rem_html_fields->wp_rem_heading_render(
                        array(
                            'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_open_house'),
                            'id' => 'open_house',
                            'classes' => '',
                            'std' => '',
                            'description' => '',
                            'hint' => '',
                            'echo' => false
                        )
                );

                $wp_rem_opt_array = array(
                    'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_date'),
                    'desc' => '',
                    'hint_text' => '',
                    'echo' => false,
                    'field_params' => array(
                        'std' => '',
                        'classes' => '',
                        'id' => 'open_house_date',
                        'return' => true,
                    ),
                );
                $html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

                $html .= '<script type="text/javascript">
                                            jQuery(document).ready(function($) {
                                                jQuery("#wp_rem_open_house_date").datetimepicker({
                                                    minDate: new Date(),
                                                    timepicker:false,
                                                    format:	"Y/m/d",
                                                });
                                            });
                                        </script>';

                $wp_rem_opt_array = array(
                    'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_time_fom'),
                    'desc' => '',
                    'hint_text' => '',
                    'echo' => false,
                    'field_params' => array(
                        'std' => '',
                        'classes' => '',
                        'id' => 'open_house_time_from',
                        'return' => true,
                    ),
                );
                $html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

                $html .= '<script type="text/javascript">
                                        jQuery(document).ready(function($) {
                                            jQuery("#wp_rem_open_house_time_from").datetimepicker({
                                                timepicker:true,
                                                datepicker:false,
                                                format:	"H:i",
                                            });
                                        });
                                    </script>';

                $wp_rem_opt_array = array(
                    'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_time_to'),
                    'desc' => '',
                    'hint_text' => '',
                    'echo' => false,
                    'field_params' => array(
                        'std' => '',
                        'classes' => '',
                        'id' => 'open_house_time_to',
                        'return' => true,
                    ),
                );
                $html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

                $html .= '<script type="text/javascript">
                                        jQuery(document).ready(function($) {
                                            jQuery("#wp_rem_open_house_time_to").datetimepicker({
                                                timepicker:true,
                                                datepicker:false,
                                                format:	"H:i",
                                            });
                                        });
                                    </script>';
            }
            return $html;
        }

        function wp_rem_remove_catmeta() {
            global $current_screen;
            switch ( $current_screen->id ) {
                case 'edit-property_type':
                    ?>
                    <script type="text/javascript">
                        jQuery(window).load(function ($) {
                            jQuery('#parent').parent().remove();
                        });
                    </script>
                    <?php
                    break;
                case 'edit-property-tag':
                    break;
            }
        }

        /**
         * Start Function How to create coloumes of post and theme
         */
        //wp_rem_property_name
        function theme_columns($theme_columns) {
            $new_columns = array(
                'cb' => '<input type="checkbox" />',
                'name' => wp_rem_plugin_text_srt('wp_rem_property_name'),
                'header_icon' => '',
                'slug' => wp_rem_plugin_text_srt('wp_rem_property_slug'),
                'posts' => wp_rem_plugin_text_srt('wp_rem_property_posts')
            );
            return $new_columns;
        }

        public function property_book_days_off() {
            global $post;
            $property_add_counter = rand(10000000, 99999999);
            $html = '';
            $off_days_list = '';
            $get_property_off_days = get_post_meta($post->ID, 'wp_rem_calendar', true);
            if ( is_array($get_property_off_days) && sizeof($get_property_off_days) ) {
                foreach ( $get_property_off_days as $get_off_day ) {
                    $off_days_list .= $this->append_to_book_days_off($get_off_day);
                }
            } else {
                $off_days_list = '<li id="no-book-day-' . $property_add_counter . '" class="no-result-msg">' . wp_rem_plugin_text_srt('wp_rem_list_meta_no_of_days') . '</li>';
            }
            wp_enqueue_script('responsive-calendar');
            $html .= '
			<div class="form-elements">
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . wp_rem_plugin_text_srt('wp_rem_list_meta_off_days') . '</label>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div class="book-list">
						<ul id="wp-rem-dev-add-off-day-app-' . $property_add_counter . '">
							' . $off_days_list . '
						</ul>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div id="wp-rem-dev-loader-' . absint($property_add_counter) . '" class="wp-rem-loader"></div>
					<a class="book-btn" href="javascript:void(0);">' . wp_rem_plugin_text_srt('wp_rem_list_meta_off_days') . '</a>
					<div id="wp-rem-dev-cal-holder-' . $property_add_counter . '" class="calendar-holder">
						<div data-id="' . $property_add_counter . '" class="wp-rem-dev-insert-off-days responsive-calendar" data-ajax-url="' . esc_url(admin_url('admin-ajax.php')) . '" data-plugin-url="' . esc_url(wp_rem::plugin_url()) . '">
							<span class="availability">' . wp_rem_plugin_text_srt('wp_rem_member_availability') . '</span>
							<div class="controls">
								<a data-go="prev"><div class="btn btn-primary"><i class="icon-angle-left"></i></div></a>
								<h4><span data-head-month></span> <span data-head-year></span></h4>
								<a data-go="next"><div class="btn btn-primary"><i class="icon-angle-right"></i></div></a>
							</div>
							<div class="day-headers">
								<div class="day header">' . wp_rem_plugin_text_srt('wp_rem_member_sun') . '</div>
								<div class="day header">' . wp_rem_plugin_text_srt('wp_rem_member_mon') . '</div>
								<div class="day header">' . wp_rem_plugin_text_srt('wp_rem_member_tue') . '</div>
								<div class="day header">' . wp_rem_plugin_text_srt('wp_rem_member_wed') . '</div>
								<div class="day header">' . wp_rem_plugin_text_srt('wp_rem_member_thu') . '</div>
								<div class="day header">' . wp_rem_plugin_text_srt('wp_rem_member_fri') . '</div>
								<div class="day header">' . wp_rem_plugin_text_srt('wp_rem_member_sat') . '</div>
							</div>
							<div class="days wp-rem-dev-calendar-days" data-group="days"></div>
						</div>
					</div>
				</div>
				<script>
					jQuery(document).ready(function () {
						jQuery(".responsive-calendar").responsiveCalendar({
							monthChangeAnimation: false,
						});
					});
				</script>
			</div>';
            return force_balance_tags($html);
        }

        /**
         * Appending off days to list via Ajax
         * @return markup
         */
        public function append_to_book_days_off($get_off_day = '') {

            if ( $get_off_day != '' ) {
                $book_off_date = $get_off_day;
            } else {
                $day = wp_rem_get_input('off_day_day', date('d'), 'STRING');
                $month = wp_rem_get_input('off_day_month', date('m'), 'STRING');
                $year = wp_rem_get_input('off_day_year', date('Y'), 'STRING');
                $book_off_date = $year . '-' . $month . '-' . $day;
            }
            $formated_off_date = date_i18n(get_option('date_format'), strtotime($book_off_date));
            $rand_numb = rand(100000000, 999999999);
            $html = '';
            $html .= '
			<li id="day-remove-' . $rand_numb . '">
				<div class="open-close-time opening-time">
					<div class="date-sec">
						<span>' . $formated_off_date . '</span>';
            
            $html .= '	<input type="hidden" value="' . $book_off_date . '" name="wp_rem_property_off_days[]">';
            
            $html .= '	</div>
					<div class="time-sec">
						<a id="wp-rem-dev-day-off-rem-' . $rand_numb . '" data-id="' . $rand_numb . '" href="javascript:void(0);"><i class="icon-close2"></i></a>
					</div>
				</div>
			</li>';

            if ( $get_off_day != '' ) {
                return force_balance_tags($html);
            } else {
                echo json_encode(array( 'html' => $html ));
                die;
            }
        }

        public function wp_rem_property_save_off_days($property_id = '') {
            $wp_rem_off_days = wp_rem_get_input('wp_rem_property_off_days', '', 'ARRAY');
            update_post_meta($property_id, 'wp_rem_calendar', $wp_rem_off_days);
        }

        public function wp_rem_save_property_custom_fields_dates($property_id = '') {
            if ( $property_id != '' ) {

                $property_type_slug = get_post_meta($property_id, 'wp_rem_property_type', true);
                $property_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish' ));
                $property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
                $property_type_fields = get_post_meta($property_type_id, 'wp_rem_property_type_cus_fields', true);
                if ( ! empty($property_type_fields) ) {
                    foreach ( $property_type_fields as $property_type_field ) {
                        $field_type = isset($property_type_field['type']) ? $property_type_field['type'] : '';
                        $meta_key = isset($property_type_field['meta_key']) ? $property_type_field['meta_key'] : '';
                        if ( $field_type == 'date' ) {
                            if ( $meta_key != '' ) {
                                $cus_field_values = '';
                                $cus_field_values = isset($_POST['wp_rem_cus_field']) ? $_POST['wp_rem_cus_field'] : '';
                                if ( $cus_field_values ) {
                                    foreach ( $cus_field_values as $c_key => $c_val ) {
                                        if ( $c_key == $meta_key ) {
                                            update_post_meta($property_id, $c_key, strtotime($c_val));
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        public function wp_rem_property_categories($property_id = '') {
            $wp_rem_property_cats = wp_rem_get_input('wp_rem_property_category', '', 'ARRAY');
            $cat_ids = array();
            wp_set_post_terms($property_id, '', 'property-category');
            if ( $wp_rem_property_cats ) {
                foreach ( $wp_rem_property_cats as $wp_rem_property_cat ) {
                    $term = get_term_by('slug', $wp_rem_property_cat, 'property-category');
                    $cat_ids[] = $term->term_id;
                }
            }
            wp_set_post_terms($property_id, $cat_ids, 'property-category');
        }

        function wp_rem_submit_meta_box($post, $args = array()) {
            global $action, $wp_rem_form_fields, $post, $wp_rem_plugin_static_text;


            $post_type = $post->post_type;
            $post_type_object = get_post_type_object($post_type);
            $can_publish = current_user_can($post_type_object->cap->publish_posts);
            ?>
            <div class="submitbox wp-rem-submit" id="submitpost">
                <div id="minor-publishing">
                    <div style="display:none;">
                        <?php submit_button(wp_rem_plugin_text_srt('wp_rem_submit'), 'button', 'save'); ?>
                    </div>
                    <?php if ( $post_type_object->public && ! empty($post) ) : ?>
                        <!--						<div id="minor-publishing-actions">
                                                                                                                                                                                                                        <div id="preview-action">-->
                        <?php
                        if ( 'publish' == $post->post_status ) {
                            $preview_link = esc_url(get_permalink($post->ID));
                            $preview_button = wp_rem_plugin_text_srt('wp_rem_preview');
                        } else {
                            $preview_link = set_url_scheme(get_permalink($post->ID));

                            /**
                             * Filter the URI of a post preview in the post submit box.
                             *
                             * @since 2.0.5
                             * @since 4.0.0 $post parameter was added.
                             *
                             * @param string  $preview_link URI the user will be directed to for a post preview.
                             * @param WP_Post $post         Post object.
                             */
                            $preview_link = esc_url(apply_filters('preview_post_link', add_query_arg('preview', 'true', esc_url($preview_link)), $post));
                            $preview_button = wp_rem_plugin_text_srt('wp_rem_preview');
                        }
                        ?>
                        <!--							</div>
                                                                                                                                                                                                                        <div class="clear"></div>
                                                                                                                                                                                                                        </div>-->
                    <?php endif; // public post type                        ?>

                    <a href="classes/class-properties-page-elements.php"></a>
                </div>
                <div id="major-publishing-actions" style="border-top:0px">
                    <?php
                    /**
                     * Fires at the beginning of the publishing actions section of the Publish meta box.
                     *
                     * @since 2.7.0
                     */
                    do_action('post_submitbox_start');
                    ?>
                    <div id="delete-action">
                        <?php
                        if ( current_user_can("delete_post", $post->ID) ) {
                            if ( ! EMPTY_TRASH_DAYS ) {
                                $delete_text = wp_rem_plugin_text_srt('wp_rem_delete_permanently');
                            } else {
                                $delete_text = wp_rem_plugin_text_srt('wp_rem_move_to_trash');
                            }
                            if ( isset($_GET['action']) && $_GET['action'] == 'edit' ) {
                                ?>
                                <a class="submitdelete deletion" href="<?php echo get_delete_post_link($post->ID); ?>"><?php echo wp_rem_allow_special_char($delete_text) ?></a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div id="publishing-action">
                        <span class="spinner"></span>
                        <?php
                        if ( ! in_array($post->post_status, array( 'publish', 'future', 'private' )) || 0 == $post->ID ) {
                            if ( $can_publish ) :
                                if ( ! empty($post->post_date_gmt) && time() < strtotime($post->post_date_gmt . ' +0000') ) :
                                    $wp_rem_opt_array = array(
                                        'std' => wp_rem_plugin_text_srt('wp_rem_schedule'),
                                        'id' => 'original_publish',
                                        'cust_name' => 'original_publish',
                                        'return' => false,
                                        'cust_type' => 'hidden',
                                        'prefix_on' => false,
                                    );
                                    $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);

                                    submit_button(esc_html('wp_rem_schedule'), 'primary button-large', 'publish', false, array( 'accesskey' => 'p' ));
                                else :
                                    $wp_rem_opt_array = array(
                                        'std' => wp_rem_plugin_text_srt('wp_rem_publish'),
                                        'id' => 'original_publish',
                                        'cust_name' => 'original_publish',
                                        'return' => false,
                                        'cust_type' => 'hidden',
                                        'prefix_on' => false,
                                    );
                                    $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                                    submit_button(wp_rem_plugin_text_srt('wp_rem_publish'), 'primary button-large', 'publish', false, array( 'accesskey' => 'p' ));
                                endif;
                            else :
                                $wp_rem_opt_array = array(
                                    'std' => wp_rem_plugin_text_srt('wp_rem_submit_for_review'),
                                    'id' => 'original_publish',
                                    'cust_name' => 'original_publish',
                                    'return' => false,
                                    'cust_type' => 'hidden',
                                    'prefix_on' => false,
                                );
                                $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                                submit_button(wp_rem_plugin_text_srt('wp_rem_submit_for_review'), 'primary button-large', 'publish', false, array( 'accesskey' => 'p' ));
                                ?>
                            <?php
                            endif;
                        } else {

                            if ( isset($_GET['action']) && $_GET['action'] == 'edit' ) {
                                $wp_rem_opt_array = array(
                                    'std' => wp_rem_plugin_text_srt('wp_rem_update'),
                                    'id' => 'original_publish',
                                    'cust_name' => 'original_publish',
                                    'return' => false,
                                    'cust_type' => 'hidden',
                                    'prefix_on' => false,
                                );
                                $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                                $wp_rem_opt_array = array(
                                    'std' => wp_rem_plugin_text_srt('wp_rem_update'),
                                    'id' => 'publish',
                                    'cust_name' => 'save',
                                    'return' => false,
                                    'classes' => 'button button-primary button-large',
                                    'cust_type' => 'submit',
                                    'extra_atr' => ' accesskey="p"',
                                    'prefix_on' => false,
                                );
                                $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                            } else {
                                $wp_rem_opt_array = array(
                                    'std' => wp_rem_plugin_text_srt('wp_rem_publish'),
                                    'id' => 'original_publish',
                                    'cust_name' => 'original_publish',
                                    'return' => false,
                                    'cust_type' => 'hidden',
                                    'prefix_on' => false,
                                );
                                $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                                $wp_rem_opt_array = array(
                                    'std' => wp_rem_plugin_text_srt('wp_rem_publish'),
                                    'id' => 'publish',
                                    'cust_name' => 'publish',
                                    'return' => false,
                                    'classes' => 'button button-primary button-large',
                                    'cust_type' => 'submit',
                                    'extra_atr' => ' accesskey="p"',
                                    'prefix_on' => false,
                                );
                                $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                            }
                        }
                        ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <?php
        }

    }

    global $wp_rem_property_meta;
    $wp_rem_property_meta = new wp_rem_property_meta();
    return $wp_rem_property_meta;
}
