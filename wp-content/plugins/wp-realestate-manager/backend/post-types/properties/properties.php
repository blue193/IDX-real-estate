<?php

/**
 * File Type: Property Post Type
 */
if (!class_exists('post_type_property')) {

    class post_type_property {

        /**
         * Start Contructer Function
         */
        public function __construct() {
            add_action('init', array($this, 'wp_rem_property_init'), 12);
            add_filter('manage_properties_posts_columns', array($this, 'wp_rem_property_columns_add'));
            add_action('manage_properties_posts_custom_column', array($this, 'wp_rem_property_columns'), 10, 2);
            add_action('create_daily_properties_check', array($this, 'create_daily_properties_check_callback'), 10);

            add_action('admin_menu', array($this, 'remove_cus_meta_boxes'));
            add_action('do_meta_boxes', array($this, 'remove_cus_meta_boxes'));
            add_filter("get_user_option_screen_layout_properties", array($this, 'property_type_screen_layout'));
            add_action('admin_head', array($this, 'check_post_type_and_remove_media_buttons'));

            // AJAX handlers for import/export property type categories in plugin options.
            add_action('wp_ajax_generate_property_type_categories_backup', array($this, 'generate_property_type_categories_backup_callback'));
            add_action('wp_ajax_delete_property_type_categories_backup_file', array($this, 'delete_property_type_categories_backup_file_callback'));
            add_action('wp_ajax_restore_property_type_categories_backup', array($this, 'restore_property_type_categories_backup_callback'));
            add_action('wp_ajax_wp_rem_uploading_import_cat_file', array($this, 'wp_rem_uploading_import_cat_file_callback'));
            // Custom Sort Columns
            add_filter('manage_edit-properties_sortable_columns', array($this, 'wp_rem_properties_sortable'));
            add_filter('request', array($this, 'wp_rem_properties_column_orderby'));
            // Custom Filter
            add_action('restrict_manage_posts', array($this, 'wp_rem_admin_properties_filter_restrict_manage_properties'), 11);
            add_filter('parse_query', array(&$this, 'wp_rem_property_filter'), 11, 1);
            // Change Property Featured
            add_action('wp_ajax_wp_rem_feature_property', array($this, 'wp_rem_feature_property_callback'), 11, 1);
            add_action('wp_ajax_wp_rem_top_category_property', array($this, 'wp_rem_top_category_property_callback'), 11, 1);
        }

        public function property_type_screen_layout($selected) {
            return 1; // Use 1 column if user hasn't selected anything in Screen Options
        }

        function check_post_type_and_remove_media_buttons() {
            global $current_screen;
            if (get_post_type() == 'properties') {
                remove_action('media_buttons', 'media_buttons');
                echo '<style type="text/css">';
                echo '.post-type-properties .column-property_image { width:50px !important; overflow:hidden }';
                echo '.post-type-properties .column-featured { width:70px !important; overflow:hidden }';
                echo '.post-type-properties .column-top_category { width:80px !important; overflow:hidden }';
                echo '</style>';
            }
        }

        function remove_cus_meta_boxes() {
            remove_meta_box('submitdiv', 'properties', 'side');
            remove_meta_box('tagsdiv-property-tag', 'properties', 'side');
            remove_meta_box('wp_rem_locationsdiv', 'properties', 'side');
            remove_meta_box('postimagediv', 'properties', 'side');
            remove_meta_box('mymetabox_revslider_0', 'properties', 'normal');
        }

        /**
         * Start Wp's Initilize action hook Function
         */
        public function wp_rem_property_init() {
            // Initialize Post Type
            $this->wp_rem_property_register();
            $this->create_property_category();
            $this->create_property_tags();
        }

        /**
         * End Wp's Initilize action hook Function
         */
        public function wp_rem_trim_content() {

            global $post;
            $read_more = '....';
            $the_content = get_the_content($post->ID);
            if (strlen(get_the_content($post->ID)) > 200) {
                $the_content = substr(get_the_content($post->ID), 0, 200) . $read_more;
            }

            return $the_content;
        }

        /**
         * Start Function How to Register post type
         */
        public function wp_rem_property_register() {

            $labels = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_properties'),
                'menu_name' => wp_rem_plugin_text_srt('wp_rem_property_properties'),
                'add_new_item' => wp_rem_plugin_text_srt('wp_rem_property_add_new_property'),
                'edit_item' => wp_rem_plugin_text_srt('wp_rem_property_edit_property'),
                'new_item' => wp_rem_plugin_text_srt('wp_rem_property_new_property_item'),
                'add_new' => wp_rem_plugin_text_srt('wp_rem_property_add_new_property'),
                'view_item' => wp_rem_plugin_text_srt('wp_rem_property_view_property_item'),
                'search_items' => wp_rem_plugin_text_srt('wp_rem_property_search'),
                'not_found' => wp_rem_plugin_text_srt('wp_rem_property_nothing_found'),
                'not_found_in_trash' => wp_rem_plugin_text_srt('wp_rem_property_nothing_found_in_trash'),
                'parent_item_colon' => ''
            );
            $args = array(
                'exclude_from_search' => true,
                'labels' => $labels,
                'public' => true,
                'menu_position' => 26,
                'menu_icon' => wp_rem::plugin_url() . 'assets/backend/images/properties.png',
                'has_archive' => false,
                'capability_type' => 'post',
                'supports' => array('title', 'editor', 'thumbnail')
            );

            register_post_type('properties', $args);
        }

        /**
         * End Function How to Register post type
         */

        /**
         * @Register Property Category
         * @return
         */
        function create_property_category() {
            global $wp_rem_var_plugin_static_text;
            $labels = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_property_categories'),
                'singular_name' => wp_rem_plugin_text_srt('wp_rem_property_property_category'),
                'search_items' => wp_rem_plugin_text_srt('wp_rem_property_property_category'),
                'all_items' => wp_rem_plugin_text_srt('wp_rem_property_property_all_categories'),
                'parent_item' => wp_rem_plugin_text_srt('wp_rem_property_property_parent_category'),
                'parent_item_colon' => wp_rem_plugin_text_srt('wp_rem_property_property_parent_category_clone'),
                'edit_item' => wp_rem_plugin_text_srt('wp_rem_property_property_edit_category'),
                'update_item' => wp_rem_plugin_text_srt('wp_rem_property_property_update_category'),
                'add_new_item' => wp_rem_plugin_text_srt('wp_rem_property_property_add_new_category'),
                'new_item_name' => wp_rem_plugin_text_srt('wp_rem_property_property_category'),
                'menu_name' => wp_rem_plugin_text_srt('wp_rem_property_property_categories'),
            );
            $args = array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column' => false,
                'query_var' => false,
                'meta_box_cb' => false,
                'show_in_quick_edit' => false,
                'rewrite' => array('slug' => 'property-category'),
            );
            register_taxonomy('property-category', array('properties'), $args);
        }

        /**
         * @Register Property Tags
         * @return
         */
        function create_property_tags() {
            global $wp_rem_var_plugin_static_text;
            $labels = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_php_tag_name'),
                'singular_name' => wp_rem_plugin_text_srt('wp_rem_property_php_tag_singular_name'),
                'search_items' => wp_rem_plugin_text_srt('wp_rem_property_php_tag_search_item'),
                'all_items' => wp_rem_plugin_text_srt('wp_rem_property_php_tag_all_item'),
                'parent_item' => wp_rem_plugin_text_srt('wp_rem_property_php_tag_prent_iem'),
                'parent_item_colon' => null,
                'edit_item' => wp_rem_plugin_text_srt('wp_rem_property_php_tag_edit_item'),
                'update_item' => wp_rem_plugin_text_srt('wp_rem_property_php_tag_update_item'),
                'add_new_item' => wp_rem_plugin_text_srt('wp_rem_property_php_tag_add_new_item'),
                'new_item_name' => wp_rem_plugin_text_srt('wp_rem_property_php_tag_new_item_name'),
                'menu_name' => wp_rem_plugin_text_srt('wp_rem_property_php_tag_menu_name'),
            );
            $args = array(
                'hierarchical' => false,
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column' => false,
                'query_var' => true,
                'meta_box_cb' => false,
                'show_in_quick_edit' => false,
                'rewrite' => array('slug' => 'property-tag'),
            );
            register_taxonomy('property-tag', array('properties'), $args);
        }

        /**
         * Start Function How to Add Title Columns
         */
        public function wp_rem_property_columns_add($columns) {

            unset($columns['date']);
            unset($columns['tags']);
            $columns['company'] = wp_rem_plugin_text_srt('wp_rem_property_company');
            $columns['property_type'] = wp_rem_plugin_text_srt('wp_rem_property_property_type');
            $columns['featured'] = '<span data-toggle="tooltip" data-placement="bottom" title="' . wp_rem_plugin_text_srt('wp_rem_property_featured') . '" class="dashicons dashicons-star-filled"></span>';
            $columns['top_category'] = '<span data-toggle="tooltip" data-placement="bottom" title="' . wp_rem_plugin_text_srt('wp_rem_list_meta_top_category') . '" class="dashicons dashicons-category"></span>';
            $columns['posted'] = wp_rem_plugin_text_srt('wp_rem_property_property_posted');
            $columns['expired'] = wp_rem_plugin_text_srt('wp_rem_property_property_expired');
            $columns['status'] = wp_rem_plugin_text_srt('wp_rem_property_property_status');
            $new_columns = array();
            foreach ($columns as $key => $value) {
                $new_columns[$key] = $value;
                if ($key == 'cb') {
                    $new_columns['property_image'] = '<i data-toggle="tooltip" data-placement="bottom" title="' . wp_rem_plugin_text_srt('wp_rem_property_column_property_image') . '" class="dashicons dashicons-format-image"></i>';
                }
            }
            return $new_columns;
        }

        /**
         * End Function How to Add Title Columns
         */

        /**
         * Start Function How to Add  Columns
         */
        public function wp_rem_property_columns($name) {
            global $post, $gateway;

            switch ($name) {
                default:
                    //echo "name is " . $name;
                    break;
                case 'property_image':
                    if (function_exists('property_gallery_first_image')) {
                        $gallery_image_args = array(
                            'property_id' => $post->ID,
                            'size' => 'thumbnail',
                            'class' => 'column-property-image',
                            'default_image_src' => esc_url(wp_rem::plugin_url() . 'assets/backend/images/placeholder.png')
                        );
                        echo $property_gallery_first_image = property_gallery_first_image($gallery_image_args);
                    }
                    break;
                case 'company':
                    $wp_rem_property_member = get_post_meta($post->ID, "wp_rem_property_member", true); //
                    $member_title = '';
                    if ($wp_rem_property_member != '') {
                        $member_title = '<a href="' . esc_url(get_edit_post_link($wp_rem_property_member)) . '">' . get_the_title($wp_rem_property_member) . '</a>';
                    }
                    echo force_balance_tags($member_title);
                    break;
                case 'property_type':
                    $property_type = get_post_meta($post->ID, 'wp_rem_property_type', true);
                    if ($listing_type_post = get_page_by_path($property_type, OBJECT, 'property-type')) {
                        $property_type_id = $listing_type_post->ID;
                    } else {
                        $property_type_id = 0;
                    }
                    echo '<a href="' . esc_url(get_edit_post_link($property_type_id)) . '">' . get_the_title($property_type_id) . '</a>';
                    break;
                case 'featured':
                    $fetured = get_post_meta($post->ID, 'wp_rem_property_is_featured', true);
                    $url = wp_nonce_url(admin_url('admin-ajax.php?action=wp_rem_feature_property&property_id=' . $post->ID), 'wp-rem-feature-property');
                    echo '<a href="' . esc_url($url) . '">';
                    if ($fetured == 'on') {
                        echo '<i data-toggle="tooltip" data-placement="bottom" title="' . wp_rem_plugin_text_srt('wp_rem_property_yes') . '" class="dashicons dashicons-star-filled"></i>';
                    } else {
                        echo '<i data-toggle="tooltip" data-placement="bottom" title="' . wp_rem_plugin_text_srt('wp_rem_property_no') . '" class="dashicons dashicons-star-empty"></i>';
                    }
                    echo '</a>';
                    break;
                case 'top_category':
                    $top_cat = get_post_meta($post->ID, 'wp_rem_property_is_top_cat', true);
                    $url = wp_nonce_url(admin_url('admin-ajax.php?action=wp_rem_top_category_property&property_id=' . $post->ID), 'wp-rem-top-category-property');
                    echo '<a href="' . esc_url($url) . '">';
                    if ($top_cat == 'on') {
                        echo '<i data-toggle="tooltip" data-placement="bottom" title="' . wp_rem_plugin_text_srt('wp_rem_property_yes') . '" class="dashicons dashicons-category" style="color: green; !important"></i>';
                    } else {
                        echo '<i data-toggle="tooltip" data-placement="bottom" title="' . wp_rem_plugin_text_srt('wp_rem_property_no') . '" class="dashicons dashicons-category"></i>';
                    }
                    echo '</a>';
                    break;
                case 'posted':
                    $date_format = get_option('date_format');
                    $wp_rem_property_posted = get_post_meta($post->ID, 'wp_rem_property_posted', true);
                    $wp_rem_property_posted_date = isset($wp_rem_property_posted) && $wp_rem_property_posted != '' ? date_i18n($date_format, ($wp_rem_property_posted)) : '';
                    echo esc_html($wp_rem_property_posted_date);
                    break;
                case 'expired':
                    $date_format = get_option('date_format');
                    $wp_rem_property_expired = get_post_meta($post->ID, 'wp_rem_property_expired', true);
                    $wp_rem_property_expiry_date = isset($wp_rem_property_expired) && $wp_rem_property_expired != '' ? date_i18n($date_format, ($wp_rem_property_expired)) : '';
                    echo esc_html($wp_rem_property_expiry_date);
                    break;
                case 'views':
                    $wp_rem_views = get_post_meta($post->ID, "wp_rem_count_views", true);
                    echo absint($wp_rem_views);
                    echo ' / ';
                    $wp_rem_favourite = count_usermeta('cs-properties-wishlist', serialize(strval($post->ID)), 'LIKE');
                    echo absint($wp_rem_favourite);
                    echo ' / ';
                    $applications = count_usermeta('cs-properties-applied', serialize(strval($post->ID)), 'LIKE');
                    echo absint($applications);
                    break;
                case 'status':
                    $status = get_post_meta($post->ID, 'wp_rem_property_status', true);
                    $status_color = '';
                    if ($status == 'active') {
                        $status_color = ' style="color: #2ecc71; font-weight:700; !important"';
                    }
                    if ($status == 'inactive') {
                        $status_color = ' style="color: #f67a82; font-weight:700; !important"';
                    }
                    if ($status == 'delete') {
                        $status_color = ' style="color: #ff0000; font-weight:700; !important"';
                    }
                    if ($status == 'awaiting-activation') {
                        $status_color = ' style="color: #f0ad4e; font-weight:700; !important"';
                    }
                    $property_status_options = array(
                        'awaiting-activation' => wp_rem_plugin_text_srt('wp_rem_property_awaiting_activation'),
                        'active' => wp_rem_plugin_text_srt('wp_rem_property_active'),
                        'inactive' => wp_rem_plugin_text_srt('wp_rem_property_inactive'),
                        'delete' => wp_rem_plugin_text_srt('wp_rem_property_deleted')
                    );
                    $status = isset($property_status_options[$status]) ? $property_status_options[$status] : $status;
                    echo '<strong ' . $status_color . '>' . ucwords(str_replace('-', ' ', $status)) . '</strong>';
                    break;
            }
        }

        /**
         * End Function How to Add  Columns
         */
        public function wp_rem_properties_sortable($columns) {
            $columns['property_type'] = 'property_type';
            $columns['featured'] = 'featured';
            $columns['top_category'] = 'top_category';
            $columns['posted'] = 'posted';
            $columns['expired'] = 'expired';
            $columns['status'] = 'status';
            return $columns;
        }

        public function wp_rem_properties_column_orderby($vars) {
            if (isset($vars['orderby']) && 'property_type' == $vars['orderby']) {
                $vars = array_merge($vars, array(
                    'meta_key' => 'wp_rem_property_type',
                    'orderby' => 'meta_value',
                        ));
            }
            if (isset($vars['orderby']) && 'featured' == $vars['orderby']) {
                $vars = array_merge($vars, array(
                    'meta_key' => 'wp_rem_property_is_featured',
                    'orderby' => 'meta_value',
                        ));
            }
            if (isset($vars['orderby']) && 'top_category' == $vars['orderby']) {
                $vars = array_merge($vars, array(
                    'meta_key' => 'wp_rem_property_is_top_cat',
                    'orderby' => 'meta_value',
                        ));
            }
            if (isset($vars['orderby']) && 'posted' == $vars['orderby']) {
                $vars = array_merge($vars, array(
                    'meta_key' => 'wp_rem_property_posted',
                    'orderby' => 'meta_value_num',
                        ));
            }
            if (isset($vars['orderby']) && 'expired' == $vars['orderby']) {
                $vars = array_merge($vars, array(
                    'meta_key' => 'wp_rem_property_expired',
                    'orderby' => 'meta_value_num',
                        ));
            }
            if (isset($vars['orderby']) && 'status' == $vars['orderby']) {
                $vars = array_merge($vars, array(
                    'meta_key' => 'wp_rem_property_status',
                    'orderby' => 'meta_value',
                        ));
            }
            return $vars;
        }

        public function wp_rem_admin_properties_filter_restrict_manage_properties() {
            global $wp_rem_form_fields, $post_type;

            //only add filter to post type you want
            if ($post_type == 'properties') {

                $member_name = isset($_GET['member_name']) ? $_GET['member_name'] : '';
                $wp_rem_opt_array = array(
                    'id' => 'member_name',
                    'cust_name' => 'member_name',
                    'std' => $member_name,
                    'classes' => 'filter-member-name',
                    'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_property_filter_search_for_member') . '"',
                    'return' => false,
                    'force_std' => true,
                );
                $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);

                $wp_rem_property_options = array(
                    '' => wp_rem_plugin_text_srt('wp_rem_property_leftflter_all_properties'),
                    'featured' => wp_rem_plugin_text_srt('wp_rem_featured_properties'),
                    'top_category' => wp_rem_plugin_text_srt('wp_rem_property_top_categories'),
                );
                $wp_rem_property_type = isset($_GET['wp_rem_property_type']) ? $_GET['wp_rem_property_type'] : '';
                $wp_rem_opt_array = array(
                    'std' => $wp_rem_property_type,
                    'id' => 'property_type',
                    'extra_atr' => '',
                    'classes' => '',
                    'options' => $wp_rem_property_options,
                    'return' => false,
                );
                $wp_rem_form_fields->wp_rem_form_select_render($wp_rem_opt_array);

                $property_status_options = array(
                    '' => wp_rem_plugin_text_srt('wp_rem_select_property_status'),
                    'awaiting-activation' => wp_rem_plugin_text_srt('wp_rem_property_awaiting_activation'),
                    'active' => wp_rem_plugin_text_srt('wp_rem_property_active'),
                    'inactive' => wp_rem_plugin_text_srt('wp_rem_property_inactive'),
                    'delete' => wp_rem_plugin_text_srt('wp_rem_property_delete'),
                    'expire' => wp_rem_plugin_text_srt('wp_rem_property_expire'),
                );
                $wp_rem_property_status = isset($_GET['wp_rem_property_status']) ? $_GET['wp_rem_property_status'] : '';
                $wp_rem_opt_array = array(
                    'std' => $wp_rem_property_status,
                    'id' => 'property_status',
                    'extra_atr' => '',
                    'classes' => '',
                    'options' => $property_status_options,
                    'return' => false,
                );
                $wp_rem_form_fields->wp_rem_form_select_render($wp_rem_opt_array);
            }
        }

        function wp_rem_property_filter($query) {
            global $pagenow;
            $custom_filter_arr = array();
            if (is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'properties' && isset($_GET['member_name']) && $_GET['member_name'] != '') {
                remove_filter('parse_query', array(&$this, 'wp_rem_property_filter'), 11, 1);
                $members_args = array(
                    'post_type' => 'members',
                    'posts_per_page' => -1,
                    's' => $_GET['member_name'],
                    'fields' => 'ids',
                );
                $members_ids = get_posts($members_args);
                wp_reset_postdata();
                add_filter('parse_query', array(&$this, 'wp_rem_property_filter'), 11, 1);
                if (empty($members_ids)) {
                    $members_ids = array(0);
                }
                $custom_filter_arr[] = array(
                    'key' => 'wp_rem_property_member',
                    'value' => $members_ids,
                    'compare' => 'IN',
                );
            }
            if (is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'properties' && isset($_GET['wp_rem_property_type']) && $_GET['wp_rem_property_type'] != '') {
                $property_type = isset($_GET['wp_rem_property_type']) ? $_GET['wp_rem_property_type'] : '';
                if ($property_type == 'featured') {
                    $key_name = 'wp_rem_property_is_featured';
                } else {
                    $key_name = 'wp_rem_property_is_top_cat';
                }
                $custom_filter_arr[] = array(
                    'key' => $key_name,
                    'value' => 'on',
                    'compare' => '=',
                );
            }
            if (is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'properties' && isset($_GET['wp_rem_property_status']) && $_GET['wp_rem_property_status'] != '') {
                if ($_GET['wp_rem_property_status'] == 'expire') {
                    $custom_filter_arr[] = array(
                        'key' => 'wp_rem_property_expired',
                        'value' => current_time('timestamp'),
                        'compare' => '<',
                    );
                } else {
                    $custom_filter_arr[] = array(
                        'key' => 'wp_rem_property_status',
                        'value' => $_GET['wp_rem_property_status'],
                        'compare' => '=',
                    );
                }
            }
            if (is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'properties' && !empty($custom_filter_arr)) {
                $query->set('meta_query', $custom_filter_arr);
            }
        }

        public function wp_rem_feature_property_callback() {
            if (check_admin_referer('wp-rem-feature-property')) {
                $property_id = absint($_GET['property_id']);
                if ('properties' === get_post_type($property_id)) {
                    update_post_meta($property_id, 'wp_rem_property_is_featured', get_post_meta($property_id, 'wp_rem_property_is_featured', true) === 'on' ? 'off' : 'on' );
                }
            }
            wp_safe_redirect(wp_get_referer() ? remove_query_arg(array('trashed', 'untrashed', 'deleted', 'ids'), wp_get_referer()) : admin_url('edit.php?post_type=properties') );
            die();
        }

        public function wp_rem_top_category_property_callback() {
            if (check_admin_referer('wp-rem-top-category-property')) {
                $property_id = absint($_GET['property_id']);
                if ('properties' === get_post_type($property_id)) {
                    update_post_meta($property_id, 'wp_rem_property_is_top_cat', get_post_meta($property_id, 'wp_rem_property_is_top_cat', true) === 'on' ? 'off' : 'on' );
                }
            }
            wp_safe_redirect(wp_get_referer() ? remove_query_arg(array('trashed', 'untrashed', 'deleted', 'ids'), wp_get_referer()) : admin_url('edit.php?post_type=properties') );
            die();
        }

        /**
         * Invoked when daily cron runs for checking if any property expired.
         */
        public function create_daily_properties_check_callback() {
            $args = array(
                'posts_per_page' => '-1',
                'post_type' => 'properties',
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key' => 'wp_rem_property_status',
                        'value' => 'active',
                    ),
                ),
            );
            $properties = new WP_Query($args);
            $properties = $properties->get_posts();
            foreach ($properties as $key => $property) {
                $property_post_expiry = get_post_meta($property->ID, 'wp_rem_property_expired', true);
                if (!empty($property_post_expiry)) {
                    $username = get_post_meta($property->ID, 'wp_rem_property_username', true);

                    if ($property_post_expiry <= time()) {
                        update_post_meta($property->ID, 'wp_rem_property_status', 'inactive');

                        //
                        $property_member_id = get_post_meta($property->ID, 'wp_rem_property_member', true);
                        if ($property_member_id != '') {
                            do_action('wp_rem_plublisher_properties_decrement', $property_member_id);
                        }
                        //
                        do_action('wp_rem_property_expired_email', get_user_by('ID', $username), $property->ID);
                    }
                }
            }
        }

        /**
         * Generate property type categories backup.
         */
        public function generate_property_type_categories_backup_callback() {
            global $wp_filesystem;

            $backup_url = wp_nonce_url('edit.php?page=wp_rem_settings');
            if (false === ( $creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {
                return true;
            }
            if (!WP_Filesystem($creds)) {
                request_filesystem_credentials($backup_url, '', true, false, array());
                return true;
            }

            $terms = get_terms('property-category', array('hide_empty' => 0));

            $terms_arr = array();
            $terms_str = 'Name,Parent,Description' . PHP_EOL;
            foreach ($terms as $key => $term) {
                $term_arr = array();
                $term_arr[] = $term->name;
                $parent_term = get_term($term->parent, 'property-category');
                if ($parent_term != null) {
                    $term_arr[] = $parent_term->name;
                } else {
                    $term_arr[] = "";
                }
                $term_arr[] = $term->description;
                $terms_str .= '"' . implode('","', $term_arr) . '"' . PHP_EOL;
            }
            $wp_rem_upload_dir = wp_rem::plugin_dir() . 'backend/settings/backups/property-type-categories/';
            $wp_rem_filename = trailingslashit($wp_rem_upload_dir) . ( current_time('d-M-Y_H.i.s') ) . '.csv';
            if (!$wp_filesystem->put_contents($wp_rem_filename, $terms_str, FS_CHMOD_FILE)) {
                echo wp_rem_plugin_text_srt('wp_rem_property_php_error_svng_file');
            } else {
                echo wp_rem_plugin_text_srt('wp_rem_property_php_bkup_generated');
            }
            wp_die();
        }

        /**
         * Delete selected locations back file using AJAX.
         */
        public function delete_property_type_categories_backup_file_callback() {
            global $wp_filesystem;
            $backup_url = wp_nonce_url('edit.php?post_type=vehicles&page=wp_rem_settings');
            if (false === ( $creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {
                return true;
            }
            if (!WP_Filesystem($creds)) {
                request_filesystem_credentials($backup_url, '', true, false, array());
                return true;
            }
            $wp_rem_upload_dir = wp_rem::plugin_dir() . 'backend/settings/backups/property-type-categories/';

            $file_name = isset($_POST['file_name']) ? $_POST['file_name'] : '';
            $wp_rem_filename = trailingslashit($wp_rem_upload_dir) . $file_name;
            if (is_file($wp_rem_filename)) {
                unlink($wp_rem_filename);
                printf(wp_rem_plugin_text_srt('wp_rem_property_php_file_del_successfully'), $file_name);
            } else {
                echo wp_rem_plugin_text_srt('wp_rem_property_php_error_deleting_file');
            }
            die();
        }

        /**
         * Uploading Category File
         */
        public function wp_rem_uploading_import_cat_file_callback() {
            global $wp_filesystem;
            add_filter('upload_dir', array($this, 'wp_rem_category_upload_wp_rem'));
            $uploadedfile = $_FILES['wp_rem_btn_browse_category_file'];
            $upload_overrides = array('test_form' => false);
            $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

            if ($movefile && !isset($movefile['error'])) {
                echo esc_html($movefile['url']);
            }
            remove_filter('upload_dir', array($this, 'wp_rem_category_upload_wp_rem'));
            wp_die();
        }

        public function wp_rem_category_upload_wp_rem($dir) {
            return array(
                'path' => $dir['basedir'] . '/category',
                'url' => $dir['baseurl'] . '/category',
                'subdir' => '/category',
                    ) + $dir;
        }

        /**
         * Restore location from backup file or URL.
         */
        public function restore_property_type_categories_backup_callback() {
            global $wp_filesystem;
            $backup_url = wp_nonce_url('edit.php?post_type=vehicles&page=wp_rem_settings');
            if (false === ( $creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {
                return true;
            }
            if (!WP_Filesystem($creds)) {
                request_filesystem_credentials($backup_url, '', true, false, array());
                return true;
            }
            $wp_rem_upload_dir = wp_rem::plugin_dir() . 'backend/settings/backups/property-type-categories/';
            $file_name = isset($_POST['file_name']) ? $_POST['file_name'] : '';
            $file_path = isset($_POST['file_path']) ? $_POST['file_path'] : '';
            if ($file_path == 'yes') {
                $wp_rem_file_body = '';
                $wp_rem_file_response = wp_remote_get($file_name);
                if (is_array($wp_rem_file_response)) {
                    $wp_rem_file_body = isset($wp_rem_file_response['body']) ? $wp_rem_file_response['body'] : '';
                    if ($wp_rem_file_body != '') {
                        $this->import_property_type_categories($wp_rem_file_body);
                        echo wp_rem_plugin_text_srt('wp_rem_property_php_file_import_successfully');
                    }
                } else {
                    echo wp_rem_plugin_text_srt('wp_rem_property_php_error_restoring_file');
                }
            } else {
                $wp_rem_filename = trailingslashit($wp_rem_upload_dir) . $file_name;
                if (is_file($wp_rem_filename)) {
                    $locations_file = $wp_filesystem->get_contents($wp_rem_filename);
                    $this->import_property_type_categories($locations_file);
                    printf(wp_rem_plugin_text_srt('wp_rem_property_php_file_restore_success'), $file_name);
                } else {
                    echo wp_rem_plugin_text_srt('wp_rem_property_php_error_restoring_file');
                }
            }
            wp_die();
        }

        public function import_property_type_categories($csv_str) {
            $term_new_ids = array();
            $lines = preg_split('/\r*\n+|\r+/', $csv_str);
            $not_found = array();
            foreach ($lines as $key => $line) {
                if (0 == $key) {
                    continue;
                }
                $parts = str_getcsv($line);
                if (count($parts) < 3) {
                    continue;
                }
                $args = array(
                    'parent' => 0,
                    'slug' => sanitize_title($parts[0]),
                    'description' => $parts[2],
                );
                if (!empty($parts[1])) {
                    if (isset($term_new_ids[$parts[0]])) {
                        $args['parent'] = $term_new_ids[$parts[0]];
                    } else {
                        $not_found[] = $line;
                    }
                }
                $return = wp_insert_term(
                        $parts[0], // The term.
                        'property-category', // The taxonomy.
                        $args
                );
            }
        }

    }

    // End of class
    // Initialize Object
    $property_object = new post_type_property();
}

add_action('admin_head', 'wp_rem_property_remove_help_tabs');

function wp_rem_property_remove_help_tabs() {
    $screen = get_current_screen();
    if (isset($screen->post_type) && $screen->post_type == 'properties') {
        add_filter('screen_options_show_screen', '__return_false');
        add_filter('bulk_actions-edit-property-type', '__return_empty_array');
        echo '<style type="text/css">
				.post-type-property-type .tablenav.top,
				.post-type-property-type .tablenav.bottom,
				.post-type-property-type #titlediv .inside,
				.post-type-property-type #postdivrich{
					display: none;
				}
			</style>';
    }
}

add_filter('views_edit-properties', function( $views ) {
    
    $args_expire = array(
	'post_type' => 'properties',
	'posts_per_page' => 1,
        'fields' => 'ids',
	'meta_query' => array(
	    'relation' => 'AND',
	    array(
		'key' => 'wp_rem_property_expired',
		'value' => current_time('timestamp'),
		'compare' => '<',
	    ),
	),
    );
    $query_expire = new WP_Query($args_expire);
    $count_lisings_expire   = $query_expire->found_posts;
    // end expired property count
    
    $total_add = wp_count_posts( 'properties' );
    
    $args = array(
	'post_type' => 'properties',
	'posts_per_page' => "1",
        'fields' => 'ids',
    );
    $args['meta_query'] = array(
        array(
                'key'     => 'wp_rem_property_status',
                'value'   => 'active',
                'compare' => '=',
        ),
    );
    
    $total_query = new WP_Query($args);
    $total_active   = $total_query->found_posts;
    
    /*
     * Getting Free Packages
     */
    
    $args = array(
	'post_type' => 'packages',
	'posts_per_page' => -1,
        'fields' => 'ids',
    );
    $args['meta_query'] = array(
        array(
                'key'     => 'wp_rem_package_type',
                'value'   => 'free',
                'compare' => '=',
        ),
    );
    $free_listings_query = new WP_Query($args);
    $free_package_ids   = $free_listings_query->posts;
    
    /*
     * Getting Paid Packages
     */
    
    $args = array(
	'post_type' => 'packages',
	'posts_per_page' => -1,
        'fields' => 'ids',
    );
    $args['meta_query'] = array(
        array(
                'key'     => 'wp_rem_package_type',
                'value'   => 'paid',
                'compare' => '=',
        ),
    );
    $paid_listings_query = new WP_Query($args);
    $paid_package_ids   = $paid_listings_query->posts;
    
    
     /*
     * Free Ads
     */
    $args = array(
	'post_type' => 'properties',
	'posts_per_page' => "1",
        'fields' => 'ids',
    );
    $args['meta_query'] = array(
        array(
                'key'     => 'wp_rem_property_package',
                'value'   => $free_package_ids,
                'compare' => 'IN',
        ),
    );
    $free_query = new WP_Query($args);
    $free_ads   = $free_query->found_posts;
    
    
    /*
     * Paid Ads
     */
    $args = array(
	'post_type' => 'properties',
	'posts_per_page' => "1",
        'fields' => 'ids',
    );
    $args['meta_query'] = array(
        array(
                'key'     => 'wp_rem_property_package',
                'value'   => $paid_package_ids,
                'compare' => 'IN',
        ),
    );
    $paid_query = new WP_Query($args);
    $paid_ads   = $paid_query->found_posts;
    
    wp_reset_postdata();
    echo '
    <ul class="total-wp-rem-property row">
	<li class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="wp-rem-text-holder"><strong>' . wp_rem_plugin_text_srt('wp_rem_property_php_total_ads') . ' </strong><em>' . $total_add->publish . '</em><i class="icon-coins"></i></div></li>
	<li class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="wp-rem-text-holder"><strong>' . wp_rem_plugin_text_srt('wp_rem_property_php_active_ads') . ' </strong><em>' . $total_active . '</em><i class="icon-check_circle"></i></div></li>
	<li class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="wp-rem-text-holder"><strong>' . wp_rem_plugin_text_srt('wp_rem_property_php_expire_ads') . ' </strong><em>' . $count_lisings_expire . '</em><i class="icon-back-in-time"></i></div></li>
	<li class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="wp-rem-text-holder"><strong>' . wp_rem_plugin_text_srt('wp_rem_property_php_free_ads') . '</strong><em>' . $free_ads . '</em><i class="icon-money_off"></i></div></li>
	<li class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="wp-rem-text-holder"><strong>' . wp_rem_plugin_text_srt('wp_rem_property_php_paid_ads') . '</strong><em>' . $paid_ads . '</em><i class="icon-attach_money"></i></div></li>
    </ul>
    ';
    return $views;
});


if (!function_exists('wp_rem_get_walk_score')) {

    function wp_rem_get_walk_score($lat, $lon, $address) {
        $key = sanitize_title($address . $lat . $lon);

        if (false === ( $results = get_transient($key) )) {
            global $wp_rem_plugin_options;
            $walkscore_api_key = isset($wp_rem_plugin_options['wp_rem_walkscore_api_key']) ? $wp_rem_plugin_options['wp_rem_walkscore_api_key'] : '';
            //$walkscore_api_key = '765b0508002bc955c5fb3761d5e1ab9c'; // hardcoded for testing purposes.
            $address = urlencode($address);
            $results = wp_remote_get("http://api.walkscore.com/score?format=json&transit=1&bike=1&address=$address&lat=$lat&lon=$lon&wsapikey=$walkscore_api_key");
            set_transient($key, $results, 24 * 7 * HOUR_IN_SECONDS);
        }
        return $results;
    }

}