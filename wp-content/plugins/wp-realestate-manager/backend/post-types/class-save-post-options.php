<?php
/**
 * File Type: Plugin Functions
 */
if ( ! class_exists('Wp_rem_Plugin_Functions') ) {

    class Wp_rem_Plugin_Functions {

        // The single instance of the class
        protected static $_instance = null;

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action('save_post', array( $this, 'wp_rem_save_post_option' ), 11);
            add_action('admin_init', array( $this, 'wp_rem_wpml_strings_translate' ));
            add_action('wp_rem_member_status_assign', array( $this, 'member_status_change_actions' ), 10, 2);
            add_filter('manage_users_columns', array( $this, 'wp_rem_new_modify_user_table' ));
            add_filter('manage_users_custom_column', array( $this, 'wp_rem_new_modify_user_table_row' ), 10, 3);
        }

        /**
         * End construct Functions
         * Start Creating  Instance of the Class Function
         */
        public static function instance() {
            if ( is_null(self::$_instance) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function wp_rem_new_modify_user_table($column) {
            $column['display_name'] = wp_rem_plugin_text_srt('wp_rem_save_post_display_name_table');
            return $column;
        }

        public function wp_rem_wpml_strings_translate() {
            global $wp_rem_plugin_options;
            if ( function_exists('icl_register_string') ) {
                $d_announcemrnt_title = isset($wp_rem_plugin_options['wp_rem_dashboard_announce_title']) ? $wp_rem_plugin_options['wp_rem_dashboard_announce_title'] : '';
                $d_announcemrnt_desc = isset($wp_rem_plugin_options['wp_rem_dashboard_announce_description']) ? $wp_rem_plugin_options['wp_rem_dashboard_announce_description'] : '';
                $l_announcemrnt_title = isset($wp_rem_plugin_options['wp_rem_property_announce_title']) ? $wp_rem_plugin_options['wp_rem_property_announce_title'] : '';
                $l_announcemrnt_desc = isset($wp_rem_plugin_options['wp_rem_property_announce_description']) ? $wp_rem_plugin_options['wp_rem_property_announce_description'] : '';

                do_action('wpml_register_single_string', 'property_notices', 'Announcement "' . $l_announcemrnt_title . '" - Title field', $l_announcemrnt_title);
                do_action('wpml_register_single_string', 'property_notices', 'Announcement "' . $l_announcemrnt_desc . '" - Description field', $l_announcemrnt_desc);
                do_action('wpml_register_single_string', 'dashboard_notices', 'Announcement "' . $d_announcemrnt_title . '" - Title field', $d_announcemrnt_title);
                do_action('wpml_register_single_string', 'dashboard_notices', 'Announcement "' . $d_announcemrnt_desc . '" - Description field', $d_announcemrnt_desc);
            }
        }

        /**
         * End Creating  Instance Main Fuunctions
         * Start Saving Post  options Function
         */
        public function wp_rem_save_post_option($post_id = '') {
            global $post, $wp_rem_property_type_fields, $wp_rem_html_fields, $wp_rem_property_type_meta, $wp_rem_property_type_form_builder_fields;
            // Stop WP from clearing custom fields on autosave.
            if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
                return;

            // Prevent quick edit from clearing custom fields
            if ( defined('DOING_AJAX') && DOING_AJAX )
                return;

            // If this is just a revision, don't send the email.
            if ( wp_is_post_revision($post_id) )
                return;

            $wp_rem_data = array();
            foreach ( $_POST as $key => $value ) {
                if ( strstr($key, 'wp_rem_') ) {
                    if ($key === 'wp_rem_post_loc_country_property') {
                        wp_set_object_terms($post_id, $_POST['wp_rem_post_loc_country_property'], 'wp_rem_locations');
                    }
                    if ( $key == 'wp_rem_transaction_expiry_date' || $key == 'wp_rem_property_expired' || $key == 'wp_rem_property_posted' || $key == 'wp_rem_user_last_activity_date' || $key == 'wp_rem_user_last_activity_date' ) {
                        if ( ($key == 'wp_rem_user_last_activity_date' && $value == '') || $key == 'wp_rem_user_last_activity_date' ) {
                            $value = date('d-m-Y H:i:s');
                        }
                        $wp_rem_data[$key] = strtotime($value);
                        update_post_meta($post_id, $key, strtotime($value));
                    } else {
                        $wp_rem_data[$key] = $value;
                        if ( $key == 'wp_rem_property_new_price' ) {
                            $value = preg_replace('/\D/', '', $value);
                        }

                        update_post_meta($post_id, $key, $value);
                        if ( $key == 'wp_rem_cus_field' && get_post_type($post_id) != 'property-type' ) {
                            if ( is_array($value) && sizeof($value) > 0 ) {
                                foreach ( $value as $c_key => $c_val ) {
                                    update_post_meta($post_id, $c_key, $c_val);
                                }
                            }
                        }
                    }
                    if ( strstr($key, 'wp_rem_transaction_') && get_post_type($post_id) == 'properties' ) {
                        $wp_rem_property_add_obj = new wp_rem_member_property_actions();
                        $wp_rem_property_trans_array = $wp_rem_property_add_obj->property_assign_meta();

                        $wp_rem_property_trans_update_arr = array();
                        foreach ( $wp_rem_property_trans_array as $property_trans_key => $property_trans_val ) {
                            if ( isset($property_trans_val['label']) && isset($property_trans_val['key']) && isset($_POST[$property_trans_val['key']]) ) {
                                $wp_rem_property_trans_update_arr[] = array(
                                    'key' => $property_trans_val['key'],
                                    'label' => $property_trans_val['label'],
                                    'value' => $_POST[$property_trans_val['key']],
                                );
                            }
                        }
                        update_post_meta($post_id, 'wp_rem_trans_all_meta', $wp_rem_property_trans_update_arr);
                    }
                    if ( $key == 'wp_rem_tags' && get_post_type($post_id) == 'properties' ) {
                        $wp_rem_property_tags = $_POST['wp_rem_tags'];
                        if ( ! empty($wp_rem_property_tags) && is_array($wp_rem_property_tags) ) {
                            wp_set_post_terms($post_id, $wp_rem_property_tags, 'property-tag', FALSE);
                            update_post_meta($post_id, 'wp_rem_property_tags', $wp_rem_property_tags);
                        }
                    }
                    if ( $key == 'wp_rem_user_status' && $value == 'active' && get_post_type($post_id) == 'members' ) {
                        do_action('wp_rem_member_status_assign', $post_id, 'active');
                    } else if ( $key == 'wp_rem_user_status' && $value != 'active' && get_post_type($post_id) == 'members' ) {
                        do_action('wp_rem_member_status_assign', $post_id, 'inactive');
                    }
                    if ( get_post_type($post_id) == 'properties' ) {
                        update_post_meta($post_id, 'property_member_status', 'active');
                    }
                }
                if ( get_post_type($post_id) == 'property-type' ) {
                    if ( array_key_exists('wp_rem_reviews_labels', $_POST) ) {
                        delete_post_meta($post_id, 'wp_rem_reviews_labels');
                        update_post_meta($post_id, 'wp_rem_reviews_labels', $_POST['wp_rem_reviews_labels']);
                    }
                    if ( ! array_key_exists('wp_rem_property_type_makes', $_POST) ) {
                        update_post_meta($post_id, 'wp_rem_property_type_makes', '');
                    }
                }
            }

            update_post_meta($post_id, 'wp_rem_full_data', $wp_rem_data);
            update_post_meta($post_id, 'wp_rem_array_data', $wp_rem_data);

            if ( get_post_type($post_id) == 'property-type' ) {
                $wp_rem_property_type_fields->wp_rem_update_custom_fields($post_id);
                $wp_rem_property_type_meta->features_save($post_id);
                $wp_rem_property_type_meta->tags_save($post_id);
                $wp_rem_property_type_meta->categories_save($post_id);
            }
            //}
        }

        public function member_status_change_actions($member_id, $status = '') {

            $args = array(
                'posts_per_page' => "-1",
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
                ),
            );
            $custom_query = new WP_Query($args);
            $all_properties = $custom_query->posts;

            if ( $status == 'active' ) {
                foreach ( $all_properties as $property_id ) {
                    update_post_meta($property_id, 'property_member_status', 'active');
                }
            } else {
                foreach ( $all_properties as $property_id ) {
                    update_post_meta($property_id, 'property_member_status', 'inactive');
                }
            }
        }

        public function wp_rem_new_modify_user_table_row($val, $column_name, $user_id) {
            $user = get_userdata($user_id);
            switch ( $column_name ) {
                case 'display_name' :
                    $wp_rem_user = get_userdata($user_id);
                    $return = $wp_rem_user->display_name;
                    break;
                default:
            }
            return $return;
        }

        /**
         * Start Special Characters Function
         */
        public function special_chars($input = '') {
            return $input;
        }

        /**
         * Get Property Status
         */
        public function get_property_status($property_status = '') {

            if ( $property_status == 'awaiting-activation' ) {
                $property_status_str = wp_rem_plugin_text_srt('wp_rem_save_post_property_status_awaiting_activation');
            } else if ( $property_status == 'inactive' ) {
                $property_status_str = wp_rem_plugin_text_srt('wp_rem_save_post_property_status_inactive');
            } else if ( $property_status == 'delete' ) {
                $property_status_str = wp_rem_plugin_text_srt('wp_rem_save_post_property_status_delete');
            } else if ( $property_status == 'pending' ) {
                $property_status_str = wp_rem_plugin_text_srt('wp_rem_save_post_property_status_pending');
            } else {
                $property_status_str = wp_rem_plugin_text_srt('wp_rem_save_post_property_status_active');
            }
            return $property_status_str;
        }

        /**
         * End Special Characters Function
         * Start Regular Expression  Text Function
         */
        public function slugy_text($str) {
            $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
            $clean = strtolower(trim($clean, '_'));
            $clean = preg_replace("/[\/_|+ -]+/", '_', $clean);
            return $clean;
        }

        /**
         * End Regular Expression  Text Function
         * Start  Creating  Random Id Function
         */
        public function rand_id() {
            $output = rand(12345678, 98765432);
            return $output;
        }

        /**
         * End  Creating  Random Id Function
         * Start Advance Deposit Function
         */
        public function percent_return($num) {
            if ( is_numeric($num) && $num > 0 && $num <= 100 ) {
                $num = $num;
            } else if ( is_numeric($num) && $num > 0 && $num > 100 ) {
                $num = 100;
            } else {
                $num = 0;
            }

            return $num;
        }

        /**
         * Number Format Function
         * Function how to get  attachment image src 
         */
        public function num_format($num) {
            $wp_rem_number = number_format((float) $num, 0, '.', '');
            return $wp_rem_number;
        }

        public function wp_rem_attach_image_src($attachment_id, $width, $height) {
            $image_url = wp_get_attachment_image_src($attachment_id, array( $width, $height ), true);
            if ( $image_url[1] == $width and $image_url[2] == $height )
                ;
            else
                $image_url = wp_get_attachment_image_src($attachment_id, "full", true);
            $parts = explode('/uploads/', $image_url[0]);
            if ( count($parts) > 1 )
                return $image_url[0];
        }

        /**
         *  End How to get first image from gallery and its image src Function
         * Get post Id Through meta key Fundtion
         */
        public function wp_rem_get_post_id_by_meta_key($key, $value) {
            global $wpdb;
            $meta = $wpdb->get_results("SELECT * FROM `" . $wpdb->postmeta . "` WHERE meta_key='" . $key . "' AND meta_value='" . $value . "'");

            if ( is_array($meta) && ! empty($meta) && isset($meta[0]) ) {
                $meta = $meta[0];
            }
            if ( is_object($meta) ) {
                return $meta->post_id;
            } else {
                return false;
            }
        }

        /**
         *  end Get post Id Through meta key Fundtion
         * Start Show All Taxonomy(categories) Function
         */
        public function wp_rem_show_all_cats($parent, $separator, $selected = "", $taxonomy) {

            if ( $parent == "" ) {
                global $wpdb;
                $parent = 0;
            } else
                $separator .= " &ndash; ";
            $args = array(
                'parent' => $parent,
                'hide_empty' => 0,
                'taxonomy' => $taxonomy
            );
            $categories = get_categories($args);

            foreach ( $categories as $category ) {
                ?>
                <option <?php if ( $selected == $category->slug ) echo "selected"; ?> value="<?php echo esc_attr($category->slug); ?>"><?php echo esc_attr($separator . $category->cat_name); ?></option>
                <?php
                wp_rem_show_all_cats($category->term_id, $separator, $selected, $taxonomy);
            }
        }

        /**
         *  End Show All Taxonomy(categories) Function
         *  Start how to icomoon get
         */
        public function wp_rem_icomoons($icon_value = '', $id = '', $name = '') {
            global $wp_rem_form_fields;
            ob_start();
            ?>
            <script>
                jQuery(document).ready(function ($) {

                    var e9_element = $('#e9_element_<?php echo wp_rem_allow_special_char($id); ?>').fontIconPicker({
                        theme: 'fip-bootstrap'
                    });
                    // Add the event on the button
                    $('#e9_buttons_<?php echo wp_rem_allow_special_char($id); ?> button').on('click', function (e) {
                        e.preventDefault();
                        // Show processing message//
                        $(this).prop('disabled', true).html('<i class="icon-cog demo-animate-spin"></i><?php echo wp_rem_plugin_text_srt('wp_rem_property_save_post_please_wait'); ?>');
                        $.ajax({
                            url: '<?php echo wp_rem::plugin_url(); ?>/assets/icomoon/js/selection.json',
                            type: 'GET',
                            dataType: 'json'
                        })
                                .done(function (response) {
                                    // Get the class prefix
                                    var classPrefix = response.preferences.fontPref.prefix,
                                            icomoon_json_icons = [],
                                            icomoon_json_search = [];
                                    $.each(response.icons, function (i, v) {
                                        icomoon_json_icons.push(classPrefix + v.properties.name);
                                        if (v.icon && v.icon.tags && v.icon.tags.length) {
                                            icomoon_json_search.push(v.properties.name + ' ' + v.icon.tags.join(' '));
                                        } else {
                                            icomoon_json_search.push(v.properties.name);
                                        }
                                    });
                                    // Set new fonts on fontIconPicker
                                    e9_element.setIcons(icomoon_json_icons, icomoon_json_search);
                                    // Show success message and disable
                                    $('#e9_buttons_<?php echo wp_rem_allow_special_char($id); ?> button').removeClass('btn-primary').addClass('btn-success').text(<?php echo wp_rem_plugin_text_srt('wp_rem_property_save_post_loaded_icons'); ?>).prop('disabled', true);
                                })
                                .fail(function () {
                                    // Show error message and enable
                                    $('#e9_buttons_<?php echo wp_rem_allow_special_char($id); ?> button').removeClass('btn-primary').addClass('btn-danger').text(<?php echo wp_rem_plugin_text_srt('wp_rem_property_save_post_error_try_again'); ?>).prop('disabled', false);
                                });
                        e.stopPropagation();
                    });

                    jQuery("#e9_buttons_<?php echo wp_rem_allow_special_char($id); ?> button").click();
                });


            </script>
            <?php
            $wp_rem_opt_array = array(
                'id' => '',
                'std' => wp_rem_allow_special_char($icon_value),
                'cust_id' => "e9_element_" . wp_rem_allow_special_char($id),
                'cust_name' => wp_rem_allow_special_char($name) . "[]",
                'return' => false,
            );

            $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
            ?>
            <span id="e9_buttons_<?php echo wp_rem_allow_special_char($id); ?>" style="display:none">
                <button autocomplete="off" type="button" class="btn btn-primary"><?php echo wp_rem_plugin_text_srt('wp_rem_property_save_post_load_icomoon'); ?></button>
            </span>
            <?php
            $fontawesome = ob_get_clean();
            return $fontawesome;
        }

        /**
         * @ render Random ID
         * Start Get Current  user ID Function
         *
         */
        public static function wp_rem_generate_random_string($length = 3) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ( $i = 0; $i < $length; $i ++ ) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $randomString;
        }

        public function wp_rem_get_user_id() {
            global $current_user;
            wp_get_current_user();
            return $current_user->ID;
        }

        /**
         * End Current get user ID Function
         * How to create location Fields(fields) Function
         */

        /**
         * How to create location Fields(fields) Function
         */
        public function wp_rem_location_fields($show_map = 'on', $user = '', $field_postfix = '', $output = true) {
            
            global $wp_rem_plugin_options, $post, $wp_rem_html_fields, $wp_rem_form_fields;
            $wp_rem_map_latitude = isset($wp_rem_plugin_options['wp_rem_default_map_latitude']) ? $wp_rem_plugin_options['wp_rem_default_map_latitude'] : '';
            $wp_rem_map_longitude = isset($wp_rem_plugin_options['wp_rem_default_map_longitude']) ? $wp_rem_plugin_options['wp_rem_default_map_longitude'] : '';
            $wp_rem_map_zoom = isset($wp_rem_plugin_options['wp_rem_map_zoom_level']) ? $wp_rem_plugin_options['wp_rem_map_zoom_level'] : '6';
            $wp_rem_map_marker_icon = isset($wp_rem_plugin_options['wp_rem_map_marker_icon']) ? $wp_rem_plugin_options['wp_rem_map_marker_icon'] : wp_rem::plugin_url() . '/assets/images/map-marker.png';
            $wp_rem_array_data = '';
            $wp_rem_post_loc_zoom = $wp_rem_map_zoom;

            //start_ob();
            if ( isset($user) && ! empty($user) ) { // get values from usermeta
                $wp_rem_array_data = get_the_author_meta('wp_rem_array_data', $user->ID);

                if ( isset($wp_rem_array_data) && ! empty($wp_rem_array_data) ) {
                    $wp_rem_post_loc_country = get_the_author_meta('wp_rem_post_loc_country_' . $field_postfix, $user->ID);
                    $wp_rem_post_loc_state = get_the_author_meta('wp_rem_post_loc_state_' . $field_postfix, $user->ID);
                    $wp_rem_post_loc_city = get_the_author_meta('wp_rem_post_loc_city_' . $field_postfix, $user->ID);
                    $wp_rem_post_loc_town = get_the_author_meta('wp_rem_post_loc_town_' . $field_postfix, $user->ID);
                    $wp_rem_post_loc_address = get_the_author_meta('wp_rem_post_loc_address_' . $field_postfix, $user->ID);
                    $wp_rem_post_loc_latitude = get_the_author_meta('wp_rem_post_loc_latitude_' . $field_postfix, $user->ID);
                    $wp_rem_post_loc_longitude = get_the_author_meta('wp_rem_post_loc_longitude_' . $field_postfix, $user->ID);
                    $wp_rem_post_loc_zoom = get_the_author_meta('wp_rem_post_loc_zoom_' . $field_postfix, $user->ID);
                    $wp_rem_add_new_loc = get_the_author_meta('wp_rem_add_new_loc_' . $field_postfix, $user->ID);
                    $wp_rem_loc_radius = get_the_author_meta('wp_rem_loc_radius_' . $field_postfix, $user->ID);
                } else {
                    $wp_rem_post_loc_country = '';
                    $wp_rem_post_loc_region = '';
                    $wp_rem_post_loc_town = '';
                    $wp_rem_post_loc_city = '';
                    $wp_rem_post_loc_state = '';
                    $wp_rem_post_loc_address = '';
                    $wp_rem_post_loc_latitude = isset($wp_rem_plugin_options['wp_rem_post_loc_latitude']) ? $wp_rem_plugin_options['wp_rem_post_loc_latitude'] : '';
                    $wp_rem_post_loc_longitude = isset($wp_rem_plugin_options['wp_rem_post_loc_longitude']) ? $wp_rem_plugin_options['wp_rem_post_loc_longitude'] : '';
                    $wp_rem_post_loc_zoom = isset($wp_rem_plugin_options['wp_rem_post_loc_zoom']) ? $wp_rem_plugin_options['wp_rem_post_loc_zoom'] : '';
                    $loc_city = '';
                    $loc_postcode = '';
                    $loc_region = '';
                    $loc_country = '';
                    $event_map_switch = '';
                    $event_map_heading = '';
                    $wp_rem_add_new_loc = '';
                    $wp_rem_loc_radius = '';
                }
            } else {  // get values from postmeta
                $wp_rem_array_data = get_post_meta($post->ID, 'wp_rem_array_data', true);

                if ( isset($wp_rem_array_data) && ! empty($wp_rem_array_data) ) {
                    $wp_rem_post_loc_town = get_post_meta($post->ID, 'wp_rem_post_loc_town_' . $field_postfix, true);
                    $wp_rem_post_loc_city = get_post_meta($post->ID, 'wp_rem_post_loc_city_' . $field_postfix, true);
                    $wp_rem_post_loc_state = get_post_meta($post->ID, 'wp_rem_post_loc_state_' . $field_postfix, true);
                    $wp_rem_post_loc_country = get_post_meta($post->ID, 'wp_rem_post_loc_country_' . $field_postfix, true);
                    $wp_rem_post_loc_latitude = get_post_meta($post->ID, 'wp_rem_post_loc_latitude_' . $field_postfix, true);
                    $wp_rem_post_loc_longitude = get_post_meta($post->ID, 'wp_rem_post_loc_longitude_' . $field_postfix, true);
                    $wp_rem_post_loc_zoom = get_post_meta($post->ID, 'wp_rem_post_loc_zoom_' . $field_postfix, true);
                    $wp_rem_post_loc_address = get_post_meta($post->ID, 'wp_rem_post_loc_address_' . $field_postfix, true);
                    $wp_rem_add_new_loc = get_post_meta($post->ID, 'wp_rem_add_new_loc_' . $field_postfix, true);
                    $wp_rem_loc_radius = get_post_meta($post->ID, 'wp_rem_loc_radius_' . $field_postfix, true);
                } else {
                    $wp_rem_post_loc_country = '';
                    $wp_rem_post_loc_region = '';
                    $wp_rem_post_loc_state = '';
                    $wp_rem_post_loc_city = '';
                    $wp_rem_post_loc_town = '';
                    $wp_rem_post_loc_address = '';
                    $wp_rem_post_loc_latitude = isset($wp_rem_plugin_options['wp_rem_post_loc_latitude']) ? $wp_rem_plugin_options['wp_rem_post_loc_latitude'] : '';
                    $wp_rem_post_loc_longitude = isset($wp_rem_plugin_options['wp_rem_post_loc_longitude']) ? $wp_rem_plugin_options['wp_rem_post_loc_longitude'] : '';
                    $wp_rem_post_loc_zoom = isset($wp_rem_plugin_options['wp_rem_post_loc_zoom']) ? $wp_rem_plugin_options['wp_rem_post_loc_zoom'] : '';
                    $loc_city = '';
                    $loc_postcode = '';
                    $loc_region = '';
                    $loc_country = '';
                    $event_map_switch = '';
                    $event_map_heading = '';
                    $wp_rem_add_new_loc = '';
                    $wp_rem_loc_radius = '';
                }
            }
            if ( $wp_rem_post_loc_latitude == '' ) {
                $wp_rem_post_loc_latitude = $wp_rem_map_latitude;
            }
            if ( $wp_rem_post_loc_longitude == '' ) {
                $wp_rem_post_loc_longitude = $wp_rem_map_longitude;
            }
            if ( $wp_rem_post_loc_zoom == '' ) {
                $wp_rem_post_loc_zoom = $wp_rem_map_zoom;
            }

            $wp_rem_obj = new wp_rem();

            $wp_rem_obj->wp_rem_location_gmap_script();
            $wp_rem_obj->wp_rem_google_place_scripts();
            $wp_rem_obj->wp_rem_autocomplete_scripts();

            $wp_rem_post_loc_country = 'trinidad-and-tobago';

            $locations_data = array(
                'data' => array(
                    'country' => array(),
                    'state' => array(),
                    'city' => array(),
                    'town' => array(),
                ),
                'selected' => array(
                    'country' => $wp_rem_post_loc_country,
                    'state' => $wp_rem_post_loc_state,
                    'city' => $wp_rem_post_loc_city,
                    'town' => $wp_rem_post_loc_town,
                ),
                'location_levels' => array(
                    'country' => -1,
                    'state' => -1,
                    'city' => -1,
                    'town' => -1,
                ),
            );
            $locations_data = apply_filters('get_locations_fields_data', $locations_data, 'locations_fields_selector');
            /*
             * How to get countries against location Function Start
             */
            $_locations_parent_id = 0;
            $wp_rem_location_countries = isset($locations_data['data']['country']) ? $locations_data['data']['country'] : array();

            $location_countries_list = '';
            $location_states_list = '';
            $location_cities_list = '';
            $location_towns_list = '';
            $iso_code_list_admin = '';
            
            if ( isset($wp_rem_location_countries) && ! empty($wp_rem_location_countries) ) {
                $selected_iso_code = '';
                foreach ( $wp_rem_location_countries as $key => $country ) {
                    $selected = '';
                    $iso_code_list_admin = $country['iso_code'];
                    if ( isset($wp_rem_post_loc_country) && $wp_rem_post_loc_country == $country['slug'] ) {
                        $selected_iso_code = $iso_code_list_admin;
                        $selected = 'selected';
                    }
                    $location_countries_list .= "<option " . $selected . "  value='" . $country['slug'] . "' data-name='" . $iso_code_list_admin . "'>" . $country['name'] . "</option>";
                }
            }

            $selected_country = $wp_rem_post_loc_country;
            $selected_state = $wp_rem_post_loc_state;
            $selected_city = $wp_rem_post_loc_city;
            $selected_town = $wp_rem_post_loc_town;

            $states = isset($locations_data['data']['state']) ? $locations_data['data']['state'] : array();
            if ( isset($states) && ! empty($states) ) {
                foreach ( $states as $key => $state ) {
                    $selected = ( $selected_state == $state['slug'] ) ? 'selected' : '';
                    $location_states_list .= "<option " . $selected . " value='" . $state['slug'] . "'>" . $state['name'] . "</option>";
                }
            }

            $cities = isset($locations_data['data']['city']) ? $locations_data['data']['city'] : array();
            if ( isset($cities) && ! empty($cities) ) {
                foreach ( $cities as $key => $city ) {
                    $selected = ( $selected_city == $city['slug'] ) ? 'selected' : '';
                    $location_cities_list .= "<option " . $selected . " value='" . $city['slug'] . "'>" . $city['name'] . "</option>";
                }
            }

            $towns = isset($locations_data['data']['town']) ? $locations_data['data']['town'] : array();
            if ( isset($towns) && ! empty($towns) ) {
                foreach ( $towns as $key => $town ) {
                    $selected = ( $selected_town == $town['slug'] ) ? 'selected' : '';
                    $location_towns_list .= "<option " . $selected . " value='" . $town['slug'] . "'>" . $town['name'] . "</option>";
                }
            }
            ?>

            <fieldset class="gllpLatlonPicker" style="width:100%; float:left;" id="locations-wraper-<?php echo absint($field_postfix) ?>" >
                <div class="page-wrap page-opts left" style="overflow:hidden; position:relative;" id="locations_wrap" data-themeurl="<?php echo wp_rem::plugin_url(); ?>" data-plugin_url="<?php echo wp_rem::plugin_url(); ?>" data-ajaxurl="<?php echo esc_js(admin_url('admin-ajax.php'), 'wp-rem'); ?>" data-map_marker="<?php echo esc_html($wp_rem_map_marker_icon); ?>">
                    <div class="option-sec" style="margin-bottom:0;">
                        <div class="opt-conts">
                            <?php
                            $output = '';
                            if ( $field_postfix != 'branch' ) {
                                if ( isset($locations_data['data']['country']) ) {
                                    $wp_rem_opt_array = array(
                                        'name' => wp_rem_plugin_text_srt('wp_rem_save_post_location_country'),
                                        'desc' => '',
                                        'field_params' => array(
                                            'std' => '',
                                            'cust_id' => 'loc_country_' . $field_postfix,
                                            'cust_name' => 'wp_rem_post_loc_country_' . $field_postfix,
                                            'classes' => 'chosen-select form-select-country dir-map-search single-select SlectBox',
                                            'options_markup' => true,
                                            'return' => true,
                                        ),
                                    );

                                    if ( isset($location_countries_list) && $location_countries_list != '' ) {
                                        $wp_rem_opt_array['field_params']['options'] = '<option value="">' . wp_rem_plugin_text_srt('wp_rem_save_post_location_select_country') . '</option>' . $location_countries_list;
                                    } else {
                                        $wp_rem_opt_array['field_params']['options'] = '<option value="">' . wp_rem_plugin_text_srt('wp_rem_save_post_location_select_country') . '</option>';
                                    }

                                    $output .= $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                                }

                                if ( isset($locations_data['data']['state']) ) {
                                    $wp_rem_opt_array = array(
                                        'name' => wp_rem_plugin_text_srt('wp_rem_save_post_location_state'),
                                        'id' => 'loc_state_' . $field_postfix . '_container',
                                        'desc' => '',
                                        'field_params' => array(
                                            'std' => '',
                                            'id' => 'loc_state_' . $field_postfix,
                                            'cust_id' => 'loc_state_' . $field_postfix,
                                            'cust_name' => 'wp_rem_post_loc_state_' . $field_postfix,
                                            'classes' => 'chosen-select form-select-state dir-map-search single-select',
                                            'markup' => '<span class="loader-state-' . $field_postfix . '"></span>',
                                            'options_markup' => true,
                                            'return' => true,
                                        ),
                                    );
                                    if ( isset($location_states_list) && $location_states_list != '' ) {
                                        $wp_rem_opt_array['field_params']['options'] = '<option value="">' . wp_rem_plugin_text_srt('wp_rem_save_post_location_select_state') . '</option>' . $location_states_list;
                                    } else {
                                        $wp_rem_opt_array['field_params']['options'] = '<option value="">' . wp_rem_plugin_text_srt('wp_rem_save_post_location_select_state') . '</option>';
                                    }

                                    $output .= $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                                }

                                if ( isset($locations_data['data']['city']) ) {
                                    $wp_rem_opt_array = array(
                                        'name' => wp_rem_plugin_text_srt('wp_rem_save_post_location_city'),
                                        'id' => 'loc_city_' . $field_postfix . '_container',
                                        'desc' => '',
                                        'field_params' => array(
                                            'std' => '',
                                            'id' => 'loc_city_' . $field_postfix,
                                            'cust_id' => 'loc_city_' . $field_postfix,
                                            'cust_name' => 'wp_rem_post_loc_city_' . $field_postfix,
                                            'classes' => 'chosen-select form-select-city dir-map-search single-select',
                                            'markup' => '<span class="loader-city-' . $field_postfix . '"></span>',
                                            'options_markup' => true,
                                            'return' => true,
                                        ),
                                    );
                                    if ( isset($location_cities_list) && $location_cities_list != '' ) {
                                        $wp_rem_opt_array['field_params']['options'] = '<option value="">' . wp_rem_plugin_text_srt('wp_rem_save_post_location_select_city') . '</option>' . $location_cities_list;
                                    } else {
                                        $wp_rem_opt_array['field_params']['options'] = '<option value="">' . wp_rem_plugin_text_srt('wp_rem_save_post_location_select_city') . '</option>';
                                    }

                                    $output .= $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                                }

                                if ( isset($locations_data['data']['town']) ) {
                                    $wp_rem_opt_array = array(
                                        'name' => wp_rem_plugin_text_srt('wp_rem_save_post_location_town'),
                                        'id' => 'loc_town_' . $field_postfix . '_container',
                                        'desc' => '',
                                        'field_params' => array(
                                            'std' => '',
                                            'id' => 'loc_town_' . $field_postfix,
                                            'cust_id' => 'loc_town_' . $field_postfix,
                                            'cust_name' => 'wp_rem_post_loc_town_' . $field_postfix,
                                            'classes' => 'chosen-select form-select-town dir-map-search single-select',
                                            'markup' => '<span class="loader-town-' . $field_postfix . '"></span>',
                                            'options_markup' => true,
                                            'return' => true,
                                        ),
                                    );
                                    if ( isset($location_towns_list) && $location_towns_list != '' ) {
                                        $wp_rem_opt_array['field_params']['options'] = '<option value="">' . wp_rem_plugin_text_srt('wp_rem_save_post_location_town') . '</option>' . $location_towns_list;
                                    } else {
                                        $wp_rem_opt_array['field_params']['options'] = '<option value="">' . wp_rem_plugin_text_srt('wp_rem_save_post_location_town') . '</option>';
                                    }

                                    $output .= $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                                }
                            }

                            $output .= '
							<div class="theme-help" id="mailing_information">
								<h4 style="padding-bottom:0px;">' . wp_rem_plugin_text_srt('wp_rem_save_post_location_find_on_map') . '</h4>
								<div class="clear"></div>
							</div>';

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_save_post_location_address'),
                                'desc' => '',
                                'field_params' => array(
                                    'std' => $wp_rem_post_loc_address,
                                    'id' => 'loc_address',
                                    'classes' => 'wp-rem-search-location',
                                    'extra_atr' => 'onkeypress="wp_rem_gl_search_map(this.value)"',
                                    'cust_id' => 'loc_address',
                                    'cust_name' => 'wp_rem_post_loc_address_' . $field_postfix,
                                    'return' => true,
                                    'force_std' => true,
                                ),
                            );

                            $output .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_save_post_location_latitude'),
                                'id' => 'post_loc_latitude',
                                'desc' => '',
                                'field_params' => array(
                                    'std' => $wp_rem_post_loc_latitude,
                                    'id' => 'post_loc_latitude',
                                    'cust_name' => 'wp_rem_post_loc_latitude_' . $field_postfix,
                                    'classes' => 'gllpLatitude',
                                    'return' => true,
                                    'force_std' => true,
                                ),
                            );

                            if ( isset($value['split']) && $value['split'] <> '' ) {
                                $wp_rem_opt_array['split'] = $value['split'];
                            }

                            $output .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_save_post_location_longitude'),
                                'id' => 'post_loc_longitude',
                                'desc' => '',
                                'field_params' => array(
                                    'std' => $wp_rem_post_loc_longitude,
                                    'id' => 'post_loc_longitude',
                                    'cust_name' => 'wp_rem_post_loc_longitude_' . $field_postfix,
                                    'classes' => 'gllpLongitude',
                                    'return' => true,
                                    'force_std' => true,
                                ),
                            );

                            if ( isset($value['split']) && $value['split'] <> '' ) {
                                $wp_rem_opt_array['split'] = $value['split'];
                            }
                            $output .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            if ( $user == '' ) {
                                if ( $field_postfix != 'branch' ) {
                                    $wp_rem_opt_array = array(
                                        'name' => wp_rem_plugin_text_srt('wp_rem_save_post_location_exact_location_radius'),
                                        'desc' => '',
                                        'field_params' => array(
                                            'std' => $wp_rem_loc_radius,
                                            'id' => 'loc_radius_' . $field_postfix,
                                            'return' => true,
                                        ),
                                    );
                                    $output .= $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);
                                }
                            }

                            $wp_rem_opt_array = array(
                                'name' => '',
                                'id' => 'map_search_btn',
                                'desc' => '',
                                'field_params' => array(
                                    'std' => wp_rem_plugin_text_srt('wp_rem_save_post_location_search_on_map'),
                                    'id' => 'map_search_btn',
                                    'cust_type' => 'button',
                                    'classes' => 'gllpSearchButton cs-bgcolor',
                                    'return' => true,
                                ),
                            );

                            if ( isset($value['split']) && $value['split'] <> '' ) {
                                $wp_rem_opt_array['split'] = $value['split'];
                            }

                            $output .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            $output .= $wp_rem_html_fields->wp_rem_full_opening_field(array());
                            $output .= '<div class="clear"></div>';

                            $wp_rem_opt_array = array(
                                'id' => 'add_new_loc',
                                'cust_name' => 'wp_rem_add_new_loc_' . $field_postfix,
                                'std' => $wp_rem_add_new_loc,
                                'cust_type' => 'hidden',
                                'classes' => 'gllpSearchField',
                                'return' => true,
                                'force_std' => true,
                            );

                            $output .= $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                            $wp_rem_opt_array = array(
                                'id' => 'post_loc_zoom',
                                'cust_name' => 'wp_rem_post_loc_zoom_' . $field_postfix,
                                'std' => $wp_rem_post_loc_zoom,
                                'cust_type' => 'hidden',
                                'classes' => 'gllpZoom',
                                'return' => true,
                                'force_std' => true,
                            );

                            $output .= $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                            $output .= '<div class="clear"></div><div class="cs-map-section" style="float:left; width:100%; height:100%;"><div class="gllpMap" id="cs-map-location-fe-id"></div></div>';
                            $output .= $wp_rem_html_fields->wp_rem_closing_field(array(
                                'desc' => '',
                                    )
                            );
                            echo balanceTags($output);
                            ?>
                        </div>
                    </div>
                </div>
            </fieldset>
            <script type="text/javascript">
                "use strict";
                var autocomplete;
                jQuery(document).ready(function () {
                    wp_rem_load_location_ajax('<?php echo esc_html($field_postfix); ?>', <?php echo json_encode(array_keys($locations_data['data'])); ?>, <?php echo json_encode($locations_data['location_levels']); ?>, '<?php echo wp_create_nonce('get_locations_list'); ?>');
                });

                // Call Map gMapsLatLonPicker Class
                jQuery(document).ready(function () {
                    jQuery(".gllpLatlonPicker").each(function () {
                        $obj = jQuery(document).gMapsLatLonPicker();
                        $obj.init(jQuery(this));
                    });
                });
                function wp_rem_gl_search_map() {
                    var vals;
                    vals = jQuery('#loc_address').val();
                    if (jQuery('#loc_town').length > 0) {
                        vals = vals + ", " + jQuery('#loc_town').val();
                    }
                    if (jQuery('#loc_city').length > 0) {
                        vals = vals + ", " + jQuery('#loc_city').val();
                    }
                    if (jQuery('#loc_state').length > 0) {
                        vals = vals + ", " + jQuery('#loc_state').val();
                    }
                    if (jQuery('#loc_country').length > 0) {
                        vals = vals + ", " + jQuery('#loc_country').val();
                    }
                    jQuery('.gllpSearchField').val(vals);

                }
                (function ($) {
                    $(function () {
            <?php $wp_rem_obj->wp_rem_google_place_scripts(); ?>
                        autocomplete = new google.maps.places.Autocomplete(document.getElementById('loc_address'));
            <?php if ( isset($selected_iso_code) && ! empty($selected_iso_code) ) : ?>
                            autocomplete.setComponentRestrictions({'country': '<?php echo esc_html($selected_iso_code); ?>'});
            <?php endif; ?>
                    });
                })(jQuery);


            </script>
            <?php
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
            $wp_rem_post_loc_zoom = $wp_rem_map_zoom;
            $wp_rem_array_data = '';
            if ( isset($user) && ! empty($user) ) { // get values from usermeta
                $wp_rem_post_loc_town = get_the_author_meta('wp_rem_post_loc_town_' . $field_postfix, $user->ID);
                $wp_rem_post_loc_city = get_the_author_meta('wp_rem_post_loc_city_' . $field_postfix, $user->ID);
                $wp_rem_post_loc_state = get_the_author_meta('wp_rem_post_loc_state_' . $field_postfix, $user->ID);
                $wp_rem_post_loc_country = get_the_author_meta('wp_rem_post_loc_country_' . $field_postfix, $user->ID);
                if (
                        ( isset($wp_rem_post_loc_town) && ! empty($wp_rem_post_loc_town) ) ||
                        ( isset($wp_rem_post_loc_city) && ! empty($wp_rem_post_loc_city) ) ||
                        ( isset($wp_rem_post_loc_state) && ! empty($wp_rem_post_loc_state) ) ||
                        ( isset($wp_rem_post_loc_country) && ! empty($wp_rem_post_loc_country) )
                ) {
                    $wp_rem_post_loc_latitude = get_the_author_meta('wp_rem_post_loc_latitude_' . $field_postfix, $user->ID);
                    $wp_rem_post_loc_longitude = get_the_author_meta('wp_rem_post_loc_longitude_' . $field_postfix, $user->ID);
                    $wp_rem_post_loc_zoom = get_the_author_meta('wp_rem_post_loc_zoom_' . $field_postfix, $user->ID);
                    $wp_rem_post_loc_address = get_the_author_meta('wp_rem_post_loc_address_' . $field_postfix, $user->ID);
                    $wp_rem_add_new_loc = get_the_author_meta('wp_rem_add_new_loc_' . $field_postfix, $user->ID);
                    $wp_rem_loc_radius = get_the_author_meta('wp_rem_loc_radius_' . $field_postfix, $user->ID);
                } else {
                    $wp_rem_post_loc_country = '';
                    $wp_rem_post_loc_region = '';
                    $wp_rem_post_loc_town = '';
                    $wp_rem_post_loc_city = '';
                    $wp_rem_post_loc_state = '';
                    $wp_rem_post_loc_address = '';
                    $wp_rem_post_loc_latitude = isset($wp_rem_plugin_options['wp_rem_post_loc_latitude']) ? $wp_rem_plugin_options['wp_rem_post_loc_latitude'] : '';
                    $wp_rem_post_loc_longitude = isset($wp_rem_plugin_options['wp_rem_post_loc_longitude']) ? $wp_rem_plugin_options['wp_rem_post_loc_longitude'] : '';
                    $wp_rem_post_loc_zoom = isset($wp_rem_plugin_options['wp_rem_post_loc_zoom']) ? $wp_rem_plugin_options['wp_rem_post_loc_zoom'] : '';
                    $loc_city = '';
                    $loc_postcode = '';
                    $loc_region = '';
                    $loc_country = '';
                    $event_map_switch = '';
                    $event_map_heading = '';
                    $wp_rem_add_new_loc = '';
                    $wp_rem_loc_radius = '';
                }
            } else {
                $wp_rem_array_data = get_post_meta($post_id, 'wp_rem_array_data', true);
                if ( isset($wp_rem_array_data) && ! empty($wp_rem_array_data) ) {

                    $wp_rem_post_loc_town = get_post_meta($post_id, 'wp_rem_post_loc_town_' . $field_postfix, true);
                    $wp_rem_post_loc_city = get_post_meta($post_id, 'wp_rem_post_loc_city_' . $field_postfix, true);
                    $wp_rem_post_loc_state = get_post_meta($post_id, 'wp_rem_post_loc_state_' . $field_postfix, true);
                    $wp_rem_post_loc_country = get_post_meta($post_id, 'wp_rem_post_loc_country_' . $field_postfix, true);

                    $wp_rem_post_loc_latitude = get_post_meta($post_id, 'wp_rem_post_loc_latitude_' . $field_postfix, true);
                    $wp_rem_post_loc_longitude = get_post_meta($post_id, 'wp_rem_post_loc_longitude_' . $field_postfix, true);
                    $wp_rem_post_loc_zoom = get_post_meta($post_id, 'wp_rem_post_loc_zoom_' . $field_postfix, true);
                    $wp_rem_post_loc_address = get_post_meta($post_id, 'wp_rem_post_loc_address_' . $field_postfix, true);
                    $wp_rem_add_new_loc = get_post_meta($post_id, 'wp_rem_add_new_loc_' . $field_postfix, true);
                    $wp_rem_loc_bounds_rest = get_post_meta($post_id, 'wp_rem_loc_bounds_rest_' . $field_postfix, true);
                    $wp_rem_loc_radius = get_post_meta($post_id, 'wp_rem_loc_radius_' . $field_postfix, true);
                } else {
                    $wp_rem_post_loc_country = '';
                    $wp_rem_post_loc_region = '';
                    $wp_rem_post_loc_state = '';
                    $wp_rem_post_loc_city = '';
                    $wp_rem_post_loc_town = '';
                    $wp_rem_post_loc_address = '';
                    $wp_rem_post_loc_latitude = isset($wp_rem_plugin_options['wp_rem_post_loc_latitude']) ? $wp_rem_plugin_options['wp_rem_post_loc_latitude'] : '';
                    $wp_rem_post_loc_longitude = isset($wp_rem_plugin_options['wp_rem_post_loc_longitude']) ? $wp_rem_plugin_options['wp_rem_post_loc_longitude'] : '';
                    $wp_rem_post_loc_zoom = isset($wp_rem_plugin_options['wp_rem_post_loc_zoom']) ? $wp_rem_plugin_options['wp_rem_post_loc_zoom'] : '';
                    $loc_city = '';
                    $loc_postcode = '';
                    $loc_region = '';
                    $loc_country = '';
                    $event_map_switch = '';
                    $event_map_heading = '';
                    $wp_rem_add_new_loc = '';
                    $wp_rem_loc_bounds_rest = '';
                    $wp_rem_loc_radius = '';
                }
            }
            if ( $wp_rem_post_loc_latitude == '' )
                $wp_rem_post_loc_latitude = isset($wp_rem_plugin_options['wp_rem_post_loc_latitude']) ? $wp_rem_plugin_options['wp_rem_post_loc_latitude'] : '';
            if ( $wp_rem_post_loc_longitude == '' )
                $wp_rem_post_loc_longitude = isset($wp_rem_plugin_options['wp_rem_post_loc_longitude']) ? $wp_rem_plugin_options['wp_rem_post_loc_longitude'] : '';
            if ( $wp_rem_post_loc_zoom == '' )
                $wp_rem_post_loc_zoom = isset($wp_rem_plugin_options['wp_rem_map_zoom_level']) ? $wp_rem_plugin_options['wp_rem_map_zoom_level'] : '';

            $wp_rem_obj = new wp_rem();
            $wp_rem_obj->wp_rem_location_gmap_script();
            $wp_rem_obj->wp_rem_google_place_scripts();
            $wp_rem_obj->wp_rem_autocomplete_scripts();

            $locations_data = array(
                'data' => array(
                    'country' => array(),
                    'state' => array(),
                    'city' => array(),
                    'town' => array(),
                ),
                'selected' => array(
                    'country' => $wp_rem_post_loc_country,
                    'state' => $wp_rem_post_loc_state,
                    'city' => $wp_rem_post_loc_city,
                    'town' => $wp_rem_post_loc_town,
                ),
                'location_levels' => array(
                    'country' => -1,
                    'state' => -1,
                    'city' => -1,
                    'town' => -1,
                ),
            );
            $locations_data = apply_filters('get_locations_fields_data', $locations_data, 'locations_fields_selector');
            $locations_parent_id = 0;
            $wp_rem_location_countries = isset($locations_data['data']['country']) ? $locations_data['data']['country'] : array();
            $location_countries_list = '';
            $location_states_list = '';
            $location_cities_list = '';
            $location_towns_list = '';
            $iso_code_list = '';
            $iso_code_list_main = '';
            $iso_code = '';
            if ( isset($wp_rem_location_countries) && ! empty($wp_rem_location_countries) ) {
                $selected_iso_code = '';
                foreach ( $wp_rem_location_countries as $key => $country ) {
                    $selected = '';
                    $iso_code_list_main = $country['iso_code'];

                    if ( isset($wp_rem_post_loc_country) && $wp_rem_post_loc_country == $country['slug'] ) {
                        $selected = 'selected';
                        $selected_iso_code = $iso_code_list_main;
                    }
                    $location_countries_list .= "<option " . $selected . "  value='" . $country['slug'] . "' data-name='" . $iso_code_list_main . "'>" . $country['name'] . "</option>";
                }
            }

            $selected_country = $wp_rem_post_loc_country;
            $selected_state = $wp_rem_post_loc_state;
            $selected_city = $wp_rem_post_loc_city;
            $selected_town = $wp_rem_post_loc_town;

            $states = isset($locations_data['data']['state']) ? $locations_data['data']['state'] : array();
            if ( isset($states) && ! empty($states) ) {
                foreach ( $states as $key => $state ) {
                    $selected = ( $selected_state == $state['slug'] ) ? 'selected' : '';
                    $location_states_list .= "<option " . $selected . " value='" . $state['slug'] . "'>" . $state['name'] . "</option>";
                }
            }

            $cities = isset($locations_data['data']['city']) ? $locations_data['data']['city'] : array();
            if ( isset($cities) && ! empty($cities) ) {
                foreach ( $cities as $key => $city ) {
                    $selected = ( $selected_city == $city['slug'] ) ? 'selected' : '';
                    $location_cities_list .= "<option " . $selected . " value='" . $city['slug'] . "'>" . $city['name'] . "</option>";
                }
            }

            $towns = isset($locations_data['data']['town']) ? $locations_data['data']['town'] : array();
            if ( isset($towns) && ! empty($towns) ) {
                foreach ( $towns as $key => $town ) {
                    $selected = ( $selected_town == $town['slug'] ) ? 'selected' : '';
                    $location_towns_list .= "<option " . $selected . " value='" . $town['slug'] . "'>" . $town['name'] . "</option>";
                }
            }
            ?>
            <?php
            $radius_circle = isset($wp_rem_plugin_options['wp_rem_default_radius_circle']) ? $wp_rem_plugin_options['wp_rem_default_radius_circle'] : '10';
            $radius_circle = ($radius_circle * 1000);
            ?>
            <?php
            if ( $field_postfix == 'member' ) {
                $wp_rem_loc_radius = 'off';
            }
            ?>


            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <fieldset class="gllpLatlonPicker" style="width:100%; float:left;" id="fe_map<?php echo absint($field_postfix) ?>" data-radius="<?php echo absint($radius_circle); ?>" data-radiusshow="<?php echo esc_html($wp_rem_loc_radius); ?>">
                    <div class="page-wrap page-opts left" style=" position:relative;" id="locations_wrap" data-themeurl="<?php echo wp_rem::plugin_url(); ?>" data-plugin_url="<?php echo wp_rem::plugin_url(); ?>" data-ajaxurl="<?php echo esc_js(admin_url('admin-ajax.php'), 'wp-rem'); ?>" data-map_marker="<?php echo esc_html($wp_rem_map_marker_icon); ?>">
                        <div class="option-sec" style="margin-bottom:0;">
                            <div class="opt-conts">
                                <div class="row">

                                    <?php if ( isset($locations_data['data']['country']) ) : ?>    
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-holder">
                                                <label><?php echo wp_rem_plugin_text_srt('wp_rem_save_post_location_country'); ?></label>
                                                <div class="select-holder">
                                                    <?php
                                                    $output = '';
                                                    if ( isset($locations_data['data']['country']) ) {
                                                        $wp_rem_opt_array = array(
                                                            'name' => wp_rem_plugin_text_srt('wp_rem_save_post_location_country'),
                                                            'desc' => '',
                                                            'echo' => true,
                                                            'field_params' => array(
                                                                'std' => $wp_rem_post_loc_country,
                                                                'cust_id' => 'loc_country_' . $field_postfix,
                                                                'force_std' => true,
                                                                'cust_name' => 'wp_rem_post_loc_country_' . $field_postfix,
                                                                'classes' => 'form-control chosen-select form-select-country dir-map-search single-select SlectBox',
                                                                'markup' => '<span class="loader-country-' . $field_postfix . '"></span>',
                                                                'extra_atr' => 'data-placeholder="' . wp_rem_plugin_text_srt('wp_rem_save_post_location_select_country') . '"',
                                                                'options_markup' => true,
                                                                'return' => true,
                                                            ),
                                                        );

                                                        if ( isset($location_countries_list) && $location_countries_list != '' ) {
                                                            $wp_rem_opt_array['field_params']['options'] = '<option value="">' . wp_rem_plugin_text_srt('wp_rem_save_post_location_select_country') . '</option>' . $location_countries_list;
                                                        } else {
                                                            $wp_rem_opt_array['field_params']['options'] = '<option value="">' . wp_rem_plugin_text_srt('wp_rem_save_post_location_select_country') . '</option>';
                                                        }

                                                        $wp_rem_html_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array);
                                                    }
                                                    ?>

                                                </div>
                                            </div>   
                                        </div>
                                    <?php endif; ?>
                                    <?php if ( isset($locations_data['data']['state']) ) : ?>      
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="field-holder">
                                                <label><?php echo wp_rem_plugin_text_srt('wp_rem_save_post_location_state'); ?></label>
                                                <div class="select-holder">
                                                    <?php
                                                    if ( isset($locations_data['data']['state']) ) {
                                                        $wp_rem_opt_array = array(
                                                            'name' => wp_rem_plugin_text_srt('wp_rem_save_post_location_state'),
                                                            'id' => 'loc_state_' . $field_postfix . '_container',
                                                            'desc' => '',
                                                            'echo' => true,
                                                            'field_params' => array(
                                                                'std' => $wp_rem_post_loc_state,
                                                                'id' => 'loc_state_' . $field_postfix,
                                                                'cust_id' => 'loc_state_' . $field_postfix,
                                                                'cust_name' => 'wp_rem_post_loc_state_' . $field_postfix,
                                                                'classes' => 'form-control chosen-select form-select-state dir-map-search single-select',
                                                                'markup' => '<span class="loader-state-' . $field_postfix . '"></span>',
                                                                'extra_atr' => 'data-placeholder="' .wp_rem_plugin_text_srt('wp_rem_save_post_location_select_state') . '"',
                                                                'options_markup' => true,
                                                                'return' => true,
                                                            ),
                                                        );
                                                        if ( isset($location_states_list) && $location_states_list != '' ) {
                                                            $wp_rem_opt_array['field_params']['options'] = '<option value="">' . wp_rem_plugin_text_srt('wp_rem_save_post_location_select_state'). '</option>' . $location_states_list;
                                                        } else {
                                                            $wp_rem_opt_array['field_params']['options'] = '<option value="">' . wp_rem_plugin_text_srt('wp_rem_save_post_location_select_state') . '</option>';
                                                        }

                                                        $wp_rem_html_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array);
                                                    }
                                                    ?>
                                                </div>
                                            </div>  
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( isset($locations_data['data']['city']) ) : ?>    
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="field-holder">
                                                <label><?php echo wp_rem_plugin_text_srt('wp_rem_save_post_location_city'); ?></label>
                                                <div class="select-holder">
                                                    <?php
                                                    if ( isset($locations_data['data']['city']) ) {
                                                        $wp_rem_opt_array = array(
                                                            'name' => wp_rem_plugin_text_srt('wp_rem_save_post_location_city'),
                                                            'id' => 'loc_city_' . $field_postfix . '_container',
                                                            'desc' => '',
                                                            'echo' => true,
                                                            'field_params' => array(
                                                                'std' => $wp_rem_post_loc_city,
                                                                'id' => 'loc_city_' . $field_postfix,
                                                                'cust_id' => 'loc_city_' . $field_postfix,
                                                                'cust_name' => 'wp_rem_post_loc_city_' . $field_postfix,
                                                                'classes' => 'form-control chosen-select form-select-city dir-map-search single-select',
                                                                'markup' => '<span class="loader-city-' . $field_postfix . '"></span>',
                                                                'extra_atr' => 'data-placeholder="' . wp_rem_plugin_text_srt('wp_rem_save_post_location_select_city') . '"',
                                                                'options_markup' => true,
                                                                'return' => true,
                                                            ),
                                                        );
                                                        if ( isset($location_cities_list) && $location_cities_list != '' ) {
                                                            $wp_rem_opt_array['field_params']['options'] = '<option value="">' . wp_rem_plugin_text_srt('wp_rem_save_post_location_select_city') . '</option>' . $location_cities_list;
                                                        } else {
                                                            $wp_rem_opt_array['field_params']['options'] = '<option value="">' . wp_rem_plugin_text_srt('wp_rem_save_post_location_select_city') . '</option>';
                                                        }

                                                        $wp_rem_html_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array);
                                                    }
                                                    ?>
                                                </div>
                                            </div> 
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( isset($locations_data['data']['town']) ) : ?>        
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="field-holder">
                                                <label><?php echo wp_rem_plugin_text_srt('wp_rem_save_post_location_town'); ?></label>
                                                <div class="select-holder">
                                                    <?php
                                                    $wp_rem_opt_array = array(
                                                        'name' => wp_rem_plugin_text_srt('wp_rem_save_post_location_town'),
                                                        'id' => 'loc_town_' . $field_postfix . '_container',
                                                        'desc' => '',
                                                        'echo' => true,
                                                        'field_params' => array(
                                                            'std' => $wp_rem_post_loc_town,
                                                            'force_std' => true,
                                                            'id' => 'loc_town_' . $field_postfix,
                                                            'cust_id' => 'loc_town_' . $field_postfix,
                                                            'cust_name' => 'wp_rem_post_loc_town_' . $field_postfix,
                                                            'classes' => 'form-control chosen-select form-select-town dir-map-search single-select',
                                                            'markup' => '<span class="loader-town-' . $field_postfix . '"></span>',
                                                            'extra_atr' => 'data-placeholder="' . wp_rem_plugin_text_srt('wp_rem_save_post_location_select_town') . '"',
                                                            'options_markup' => true,
                                                            'return' => true,
                                                        ),
                                                    );
                                                    if ( isset($location_towns_list) && $location_towns_list != '' ) {
                                                        $wp_rem_opt_array['field_params']['options'] = '<option value="">' . wp_rem_plugin_text_srt('wp_rem_save_post_location_select_town') . '</option>' . $location_towns_list;
                                                    } else {
                                                        $wp_rem_opt_array['field_params']['options'] = '<option value="">' . wp_rem_plugin_text_srt('wp_rem_save_post_location_select_town') . '</option>';
                                                    }

                                                    $wp_rem_html_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array);
                                                    ?>
                                                </div>
                                            </div>      
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <?php
                                        $wp_rem_opt_array = array(
                                            'id' => '_loc_bounds_rest',
                                            'cust_name' => 'wp_rem_loc_bounds_rest_' . $field_postfix,
                                            'std' => $wp_rem_loc_bounds_rest,
                                            'classes' => '',
                                            'force_std' => true,
                                        );

                                        $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_array);

                                        $wp_rem_opt_array = array(
                                            'id' => 'add_new_loc',
                                            'cust_name' => 'wp_rem_add_new_loc_' . $field_postfix,
                                            'std' => $wp_rem_add_new_loc,
                                            'classes' => 'gllpSearchField',
                                            'extra_atr' => 'style="margin-bottom:10px;"',
                                            'return' => false,
                                            'force_std' => true,
                                        );

                                        $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_array);

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
                                        ?>

                                        <div class="map-address-holder">
                                            <div class="field-holder">
                                                <label><?php echo wp_rem_plugin_text_srt('wp_rem_save_post_location_address_location'); ?></label>
                                                <?php
                                                $wp_rem_opt_array = array(
                                                    'name' => '',
                                                    'desc' => '',
                                                    'echo' => true,
                                                    'field_params' => array(
                                                        'std' => $wp_rem_post_loc_address,
                                                        'cust_id' => 'loc_address',
                                                        'classes' => 'wp-rem-search-location',
                                                        'extra_atr' => 'onkeypress="wp_rem_gl_search_map(this.value)" placeholder="' . wp_rem_plugin_text_srt('wp_rem_save_post_location_type_address') . '"',
                                                        'cust_name' => 'wp_rem_post_loc_address_' . $field_postfix,
                                                        'return' => true,
                                                        'force_std' => true,
                                                    ),
                                                );
                                                if ( isset($value['address_hint']) && $value['address_hint'] != '' ) {
                                                    $wp_rem_opt_array['hint_text'] = $value['address_hint'];
                                                }
                                                if ( isset($value['split']) && $value['split'] <> '' ) {
                                                    $wp_rem_opt_array['split'] = $value['split'];
                                                }
                                                $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                                ?>
                                            </div>
                                            <div class="switchs-holder2">
                                                <div class="search-location-map input-button-loader">
                                                    <?php
                                                    $wp_rem_opt_array = array(
                                                        'name' => '',
                                                        'id' => 'map_search_btn',
                                                        'desc' => '',
                                                        'echo' => true,
                                                        'field_params' => array(
                                                            'std' => wp_rem_plugin_text_srt('wp_rem_save_post_location_find_on_map'),
                                                            'id' => 'map_search_btn',
                                                            'cust_type' => 'button',
                                                            'classes' => 'acc-submit cs-section-update cs-color csborder-color gllpSearchButton',
                                                            'return' => true,
                                                        ),
                                                    );

                                                    if ( isset($value['split']) && $value['split'] <> '' ) {
                                                        $wp_rem_opt_array['split'] = $value['split'];
                                                    }
                                                    if ( $show_map == 'on' ) {
                                                        $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row hidden">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="field-holder">
                                            <label><?php echo wp_rem_plugin_text_srt('wp_rem_save_post_location_latitude'); ?></label>
                                            <?php
                                            $wp_rem_opt_array = array(
                                                'name' => wp_rem_plugin_text_srt('wp_rem_save_post_location_latitude'),
                                                'id' => 'post_loc_latitude',
                                                'desc' => '',
                                                'echo' => true,
                                                'styles' => 'display:none;',
                                                'field_params' => array(
                                                    'std' => $wp_rem_post_loc_latitude,
                                                    'id' => 'post_loc_latitude',
                                                    'cust_name' => 'wp_rem_post_loc_latitude_' . $field_postfix,
                                                    'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_save_post_location_latitude') . '"',
                                                    'classes' => 'form-control gllpLatitude',
                                                    'return' => true,
                                                    'force_std' => true,
                                                ),
                                            );

                                            if ( isset($value['split']) && $value['split'] <> '' ) {
                                                $wp_rem_opt_array['split'] = $value['split'];
                                            }

                                            $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="field-holder">
                                            <label><?php echo wp_rem_plugin_text_srt('wp_rem_save_post_location_longitude'); ?></label>
                                            <?php
                                            $wp_rem_opt_array = array(
                                                'name' => wp_rem_plugin_text_srt('wp_rem_save_post_location_longitude'),
                                                'id' => 'post_loc_longitude',
                                                'desc' => '',
                                                'echo' => true,
                                                'field_params' => array(
                                                    'std' => $wp_rem_post_loc_longitude,
                                                    'id' => 'post_loc_longitude',
                                                    'cust_name' => 'wp_rem_post_loc_longitude_' . $field_postfix,
                                                    'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_save_post_location_longitude') . '"',
                                                    'classes' => 'form-control gllpLongitude',
                                                    'return' => true,
                                                    'force_std' => true,
                                                ),
                                            );

                                            if ( isset($value['split']) && $value['split'] <> '' ) {
                                                $wp_rem_opt_array['split'] = $value['split'];
                                            }
                                            $wp_rem_html_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if ( $show_map == 'on' ) {
                                    ?>

                                    <div class="cs-map-section " style="float:left; width:100%; height:290px;">
                                        <?php if ( $field_postfix != 'member' ) {
                                            ?>

                                            <div class="hide_location">
                                                <span><?php echo wp_rem_plugin_text_srt('wp_rem_save_post_location_hide_location'); ?></span>
                                                <div class="right-area">
                                                    <div class="onoffswitch onoffswitch-v2">
                                                        <?php
                                                        $wp_rem_form_fields->wp_rem_form_checkbox_render(
                                                                array( 'name' => wp_rem_plugin_text_srt('wp_rem_save_post_location_radius_exact_location'),
                                                                    'cust_id' => 'myonoffswitch2',
                                                                    'cust_name' => 'wp_rem_loc_radius_' . $field_postfix,
                                                                    'classes' => 'onoffswitch-checkbox',
                                                                    'std' => $wp_rem_loc_radius,
                                                                    'description' => '',
                                                                    'simple' => true,
                                                                    'return' => false,
                                                                )
                                                        );
                                                        ?>
                                                        <label class="onoffswitch-label" for="myonoffswitch2"><span class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span> </label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="gllpMap" id="cs-map-location-fe-id"></div>
                                    </div>
                                <?php } ?>
                                <?php if ( $show_map == 'on' ) { ?>
                                    <p> <?php echo wp_rem_plugin_text_srt('wp_rem_save_post_location_precise_drag_drop'); ?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
            </div>
            </div>
            </fieldset>
            </div>
            <script type="text/javascript">
                // Call Map gMapsLatLonPicker Class

                jQuery(document).on("change", "#myonoffswitch2", function () {
                    $check = jQuery(this).is(':checked');
                    if ($check) {
                        jQuery(".gllpLatlonPicker").each(function () {
                            var radius = $(this).data('radius');
                            $obj = jQuery(document).gMapsLatLonPicker(radius);
                            $obj.init(jQuery(this));
                        });
                    } else {
                        jQuery(".gllpLatlonPicker").each(function () {

                            $obj = jQuery(document).gMapsLatLonPicker();
                            $obj.init(jQuery(this));
                        });
                    }
                });
                jQuery(document).ready(function () {
                    chosen_selectionbox();

                    jQuery(".gllpLatlonPicker").each(function () {
                        var radius = jQuery(this).data('radius');
                        var show_rad = jQuery(this).data('radiusshow');
                        if (show_rad == 'on') {
                            $obj = jQuery(document).gMapsLatLonPicker(radius);
                        } else {
                            $obj = jQuery(document).gMapsLatLonPicker();
                        }
                        $obj.init(jQuery(this));
                    });
                });

                jQuery(document).ready(function () {
                    wp_rem_load_location_ajax('<?php echo esc_html($field_postfix); ?>', <?php echo json_encode(array_keys($locations_data['data'])); ?>, <?php echo json_encode($locations_data['location_levels']); ?>, '<?php echo wp_create_nonce('get_locations_list'); ?>');
                });
                function wp_rem_gl_search_map() {
                    var vals;
                    vals = jQuery('#loc_address').val();
                    if (jQuery('#loc_town').length > 0) {
                        vals = vals + ", " + jQuery('#loc_town').val();
                    }
                    if (jQuery('#loc_city').length > 0) {
                        vals = vals + ", " + jQuery('#loc_city').val();
                    }
                    if (jQuery('#loc_state').length > 0) {
                        vals = vals + ", " + jQuery('#loc_state').val();
                    }
                    if (jQuery('#loc_country').length > 0) {
                        vals = vals + ", " + jQuery('#loc_country').val();
                    }
                    jQuery('.gllpSearchField').val(vals);
                }
                function wp_rem_fe_search_map() {
                    var vals;
                    vals = jQuery('#fe_map<?php echo absint($field_postfix) ?> #loc_address').val();
                    jQuery('#fe_map<?php echo absint($field_postfix); ?> .gllpSearchField_fe').val(vals);
                }

                (function ($) {
                    $(function () {
            <?php $wp_rem_obj->wp_rem_google_place_scripts(); ?> //var autocomplete;
                        autocomplete = new google.maps.places.Autocomplete(document.getElementById('loc_address'));

            <?php if ( isset($selected_iso_code) && ! empty($selected_iso_code) ) { ?>
                            autocomplete.setComponentRestrictions({'country': '<?php echo esc_js($selected_iso_code) ?>'});
            <?php } ?>
                    });
                })(jQuery);
                jQuery(document).ready(function () {
                    var $ = jQuery;
                    jQuery("[id^=map_canvas]").css("pointer-events", "none");
                    jQuery("[id^=cs-map-location]").css("pointer-events", "none");
                    // on leave handle
                    var onMapMouseleaveHandler = function (event) {
                        var that = jQuery(this);
                        that.on('click', onMapClickHandler);
                        that.off('mouseleave', onMapMouseleaveHandler);
                        jQuery("[id^=map_canvas]").css("pointer-events", "none");
                        jQuery("[id^=cs-map-location]").css("pointer-events", "none");
                    }
                    // on click handle
                    var onMapClickHandler = function (event) {
                        var that = jQuery(this);
                        // Disable the click handler until the user leaves the map area
                        that.off('click', onMapClickHandler);
                        // Enable scrolling zoom
                        that.find('[id^=map_canvas]').css("pointer-events", "auto");
                        that.find('[id^=cs-map-location]').css("pointer-events", "auto");
                        // Handle the mouse leave event
                        that.on('mouseleave', onMapMouseleaveHandler);
                    }
                    // Enable map zooming with mouse scroll when the user clicks the map
                    jQuery('.cs-map-section').on('click', onMapClickHandler);
                    // new addition
                });
            </script>
            <?php
        }

    }

    /**
     * End Function How to know about working  current Theme Function
     * Design Pattern for Object initilization
     */
    function WP_REM_FUNCTIONS() {
        return Wp_rem_Plugin_Functions::instance();
    }

    $GLOBALS['Wp_rem_Plugin_Functions'] = WP_REM_FUNCTIONS();
}

                