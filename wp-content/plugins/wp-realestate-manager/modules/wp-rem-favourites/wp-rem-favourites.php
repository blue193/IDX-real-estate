<?php
/**
 * Homevillas Favourites Module
 */
// Direct access not allowed.
if ( ! defined('ABSPATH') ) {
    exit;
}

if ( ! class_exists('Wp_rem_Favourites') ) {

    class Wp_rem_Favourites {

        public $admin_notices;

        /**
         * Start construct Functions
         */
        public function __construct() {
            // Define constants

            $this->admin_notices = array();
            //admin notices
            // Initialize Addon
            add_action('init', array( $this, 'init' ), 0);
        }

        /**
         * Initialize application, load text domain, enqueue scripts and bind hooks
         */
        public function init() {
            // Enqueue JS
            wp_register_script('wp-rem-favourites-script', plugins_url('assets/js/functions.js', __FILE__), '', '', true);
            wp_localize_script('wp-rem-favourites-script', 'wp_rem_favourites', array(
                'admin_url' => esc_url(admin_url('admin-ajax.php')),
                'confirm_msg' => wp_rem_plugin_text_srt('wp_rem_favourite_conform_msg')
            ));

            // Add hook for dashboard member top menu links.
            add_action('wp_rem_top_menu_favourites_dashboard', array( $this, 'favourites_top_menu_member_dashboard_callback' ), 10, 3);
            add_filter('wp_rem_member_permissions', array( $this, 'wp_rem_favourites_member_permissions_callback' ), 11, 1);
            // Add actions
            add_action('wp_ajax_wp_rem_member_favourites', array( $this, 'wp_rem_member_favourites_callback' ), 11, 2);
            add_action('wp_rem_favourites_frontend_button', array( $this, 'wp_rem_favourites_frontend_button_callback' ), 11, 3);
            add_action('wp_ajax_wp_rem_favourite_submit', array( $this, 'wp_rem_favourite_submit_callback' ), 11);
            add_action('wp_ajax_wp_rem_removed_favourite', array( $this, 'wp_rem_removed_favourite_callback' ), 11);
            add_action('wp_rem_member_admin_tab_menu', array( $this, 'member_admin_tab_menu_callback' ), 10);
            add_action('wp_rem_member_admin_tab_content', array( $this, 'member_admin_tab_content_callback' ), 10);
        }

        public function member_admin_tab_menu_callback() {
            wp_enqueue_script('wp-rem-favourites-script');
            echo '<li><a href="javascript:void(0);" name="#tab-favourites22" href="javascript:;"><i class="icon-favorite"></i>' . wp_rem_plugin_text_srt('wp_rem_favourite_favourite') . '</a></li>';
        }

        public function member_admin_tab_content_callback() {
            ?>
            <div id="tab-favourites22">
                <?php $this->wp_rem_favourites(); ?>
            </div>
            <?php
        }

        /**
         * Start Function Favourite
         */
        public function wp_rem_favourites($post_type = '') {
            wp_enqueue_script('wp-rem-favourites-script');
            global $post, $post_id;
            $favourite_query = '';
            // Post Type.
            if ( ! isset($post_type) || $post_type == '' ) {
                $post_type = 'properties';
            }

            $favourites = get_post_meta($post_id, 'wp_rem_favourites', true);
            $all_properties = array();
            if ( isset($favourites) && ! empty($favourites) ) {
                $property_ids = array();
                foreach ( $favourites as $favourite_data ) {
                    if ( isset($favourite_data['property_id']) && ! empty($favourite_data['property_id']) ) {
                        $property_ids[] = $favourite_data['property_id'];
                    }
                }
                $args = array(
                    'post_type' => $post_type,
                    'post__in' => $property_ids,
                    'post_status' => 'publish',
                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'key' => 'wp_rem_property_expired',
                            'value' => strtotime(date("d-m-Y")),
                            'compare' => '>=',
                        ),
                        array(
                            'key' => 'wp_rem_property_status',
                            'value' => 'active',
                            'compare' => '=',
                        ),
                    ),
                );
                $favourite_query = new WP_Query($args);
                ?>
                <div class="user-favorite-list">
                    <div class="element-title">
                        <h4><?php echo wp_rem_plugin_text_srt('wp_rem_favourite_favourite'); ?></h4>
                    </div>
                    <ul class="favourites-list">
                        <script>
                            /*
                             * 
                             * Homevillas Member Removed Favourite function
                             */
                            jQuery(document).on("click", ".delete-favourite", function () {
                                var thisObj = jQuery(this);
                                var property_id = thisObj.data('id');
                                var post_id = thisObj.data('post');
                                var delete_icon_class = thisObj.find("i").attr('class');
                                var loader_class = 'icon-spinner icon-spin';
                                var dataString = 'post_id=' + post_id + '&property_id=' + property_id + '&action=wp_rem_removed_favourite_backend';
                                jQuery('#id_confrmdiv').show();
                                jQuery.ajax({
                                    type: "POST",
                                    url: wp_rem_globals.ajax_url,
                                    data: dataString,
                                    dataType: "json",
                                    success: function (response) {
                                        thisObj.find('i').removeClass(loader_class).addClass(delete_icon_class);
                                        if (response.status == true) {

                                            thisObj.closest('li').hide('slow', function () {
                                                thisObj.closest('li').remove();
                                            });

                                            var msg_obj = {msg: wp_rem_favourites.deleted_favourite, type: 'success'};

                                            wp_rem_show_response(msg_obj);
                                        }
                                    }
                                });
                                jQuery('#id_falsebtn').click(function () {
                                    jQuery('#id_confrmdiv').hide();
                                    return false;
                                });
                                return false;
                            });
                        </script>
                        <?php
                        if ( $favourite_query != '' && $favourite_query->have_posts() ) :
                            while ( $favourite_query->have_posts() ) : $favourite_query->the_post();
                                $member_category = get_post_meta(get_the_ID(), 'wp_rem_property_category', true);
                                ?>
                                <li>
                                    <div class="suggest-list-holder">
                                        <div class="img-holder">
                                            <figure>
                                                <?php
                                                if ( has_post_thumbnail() ) {
                                                    the_post_thumbnail('thumbnail');
                                                } else {
                                                    $no_image_url = esc_url(wp_rem::plugin_url() . 'assets/frontend/images/no-image4x3.jpg');
                                                    $no_image = '<img class="img-grid" src="' . $no_image_url . '" />';
                                                    echo force_balance_tags($no_image);
                                                }
                                                ?>
                                            </figure>
                                        </div>
                                        <div class="text-holder">
                                            <h6><a href="<?php echo esc_url(get_edit_post_link(get_the_ID())); ?>"><?php echo get_the_title(); ?></a></h6>
                                            <?php
                                            if ( is_array($member_category) ) {
                                                foreach ( $member_category as $cate_slug => $cat_val ) {
                                                    $category = get_term_by('slug', $cat_val, 'property-category');
                                                }
                                            }
                                            if ( isset($category->name) && $category->name != '' ) {
                                                ?>
                                                <span><?php echo esc_html($category->name); ?></span>
                                            <?php }
                                            ?>
                                            <a href="#" class="short-icon delete-favourite" data-id="<?php echo intval(get_the_ID()); ?>" data-post="<?php echo esc_attr($post_id); ?>"><i class="icon-close2"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            endwhile;
                        else:
                            ?><li class="no-favourites-found"><i class="icon-favourite"></i><?php
                            echo wp_rem_plugin_text_srt('wp_rem_favourite_dont_have_favourite');
                            ?></li><?php
                        endif;
                        ?>
                    </ul>
                </div>
                <?php
                wp_reset_postdata();
            } else {
                ?>
                <div class="user-favorite-list">
                    <div class="element-title">
                        <h4><?php echo wp_rem_plugin_text_srt('wp_rem_favourite_favourite'); ?></h4>
                    </div>
                    <ul class="favourites-list">
                        <?php
                        if ( $favourite_query != '' && $favourite_query->have_posts() ) :

                            echo force_balance_tags($this->render_list_item_view($favourite_query));
                        else:
                            ?><li class="no-favourites-found"><i class="icon-favourite"></i><?php
                            echo wp_rem_plugin_text_srt('wp_rem_favourite_dont_have_favourite');
                            ?></li><?php
                        endif;
                        ?>
                    </ul>
                </div>
                <?php
            }
        }

        public function favourites_top_menu_member_dashboard_callback($wp_rem_page_id, $icon = '', $favourite_url = '') {
            global $total_favourites;
            $permissions = apply_filters('member_permissions', '');
            $permission = apply_filters('check_permissions', 'favourites', '');

            $member_id = get_current_user_id();
            $user_company = get_user_meta($member_id, 'wp_rem_company', true);

            $favourites = get_post_meta($user_company, 'wp_rem_favourites', true);
            //  print_r($favourites);
            $all_properties = array();
            $total_favourites = 0;
            if ( isset($favourites) && ! empty($favourites) ) {
                $property_ids = array();
                foreach ( $favourites as $favourite_data ) {
                    if ( isset($favourite_data['property_id']) && ! empty($favourite_data['property_id']) ) {
                        $property_ids[] = $favourite_data['property_id'];
                    }
                }

                $wp_rem_base_query_args = '';
                $wp_rem_base_query_args = $this->wp_rem_base_query_args();
                $args = array(
                    'post_type' => 'properties',
                    'post__in' => $property_ids,
                    'post_status' => 'publish',
                    'fields' => 'ids',
                    'meta_query' => array(
                        'relation' => 'AND',
                        $wp_rem_base_query_args,
                    ),
                );
                $favourite_query = new WP_Query($args);

                $total_favourites = $favourite_query->found_posts;
                wp_reset_postdata();
            }


            $permission_added = false;
            if ( array_key_exists('favourites', $permissions) ) {
                $permission_added = true;
            }
            if ( isset($favourite_url) && $favourite_url <> '' ) {
                if ( $permission == true || $permission_added == false ) {
                    echo ' <li class="user_dashboard_ajax" id="wp_rem_member_favourites" data-queryvar="dashboard=favourites"><a href="' . $favourite_url . '">' . $icon . $wp_rem_page_id . '</a></li>';
                }
            } else if ( $permission == true || $permission_added == false ) {
                echo ' <li class="user_dashboard_ajax" id="wp_rem_member_favourites" data-queryvar="dashboard=favourites"><a href="javascript:void(0);">' . $icon . $wp_rem_page_id . '</a><b class="label l">' . $total_favourites . '</b></li>';
            }
        }

        public function favourites_dashboard_callback($wp_rem_page_id, $icon = '') {
            $permissions = apply_filters('member_permissions', '');
            $permission = apply_filters('check_permissions', 'favourites', '');
            $permission_added = false;
            if ( array_key_exists('favourites', $permissions) ) {
                $permission_added = true;
            }
            echo ' <li class="user_dashboard_ajax" id="wp_rem_member_favourites" > <a href="javascript:void(0);">' . $icon . ' ' . $wp_rem_page_id . '</a></li>';
        }

        public function wp_rem_favourites_member_permissions_callback($permissions) {
            $permissions['favourites'] = wp_rem_plugin_text_srt('wp_rem_favourite_favourite_manage');
            return $permissions;
        }

        public function wp_rem_favourite_notices_callback() {
            if ( isset($this->admin_notices) && ! empty($this->admin_notices) ) {
                foreach ( $this->admin_notices as $value ) {
                    echo $value;
                }
            }
        }

        /**
         * Member Favourites
         * @ filter the favourites based on member id
         */
        public function wp_rem_member_favourites_callback($member_id = '', $post_type = '') {
            wp_enqueue_script('wp-rem-favourites-script');
            global $wp_rem_plugin_options;

            $pagi_per_page = isset($wp_rem_plugin_options['wp_rem_member_dashboard_pagination']) ? $wp_rem_plugin_options['wp_rem_member_dashboard_pagination'] : '';
            $posts_per_page = $pagi_per_page > 0 ? $pagi_per_page : 1;
            $posts_paged = isset($_REQUEST['page_id_all']) ? $_REQUEST['page_id_all'] : '';
            // Member ID.
            if ( ! isset($member_id) || $member_id == '' ) {
                $member_id = get_current_user_id();
            }
            // Post Type.
            if ( ! isset($post_type) || $post_type == '' ) {
                $post_type = 'properties';
            }
            $user_company = get_user_meta($member_id, 'wp_rem_company', true);
            $favourites = get_post_meta($user_company, 'wp_rem_favourites', true);
            //  print_r($favourites);
            $all_properties = array();
            if ( isset($favourites) && ! empty($favourites) ) {
                $property_ids = array();
                foreach ( $favourites as $favourite_data ) {
                    $property_ids[] = $favourite_data['property_id'];
                }

                $wp_rem_base_query_args = '';
                $wp_rem_base_query_args = $this->wp_rem_base_query_args();

                $args = array(
                    'posts_per_page' => $posts_per_page,
                    'paged' => $posts_paged,
                    'post_type' => $post_type,
                    'post__in' => $property_ids,
                    'post_status' => 'publish',
                    'meta_query' => array(
                        'relation' => 'AND',
                        $wp_rem_base_query_args,
                    ),
                );
                $favourite_query = new WP_Query($args);
                $total_posts = $favourite_query->found_posts;

                echo $this->render_view($favourite_query);
                wp_reset_postdata();

                $total_pages = 1;
                if ( $total_posts > 0 && $posts_per_page > 0 && $total_posts > $posts_per_page ) {
                    $total_pages = ceil($total_posts / $posts_per_page);
                    $wp_rem_dashboard_page = isset($wp_rem_plugin_options['wp_rem_member_dashboard']) ? $wp_rem_plugin_options['wp_rem_member_dashboard'] : '';
                    $wp_rem_dashboard_link = $wp_rem_dashboard_page != '' ? get_permalink($wp_rem_dashboard_page) : '';
                    $this_url = $wp_rem_dashboard_link != '' ? add_query_arg(array( 'dashboard' => 'favourites' ), $wp_rem_dashboard_link) : '';
                    wp_rem_dashboard_pagination($total_pages, $posts_paged, $this_url, 'favourites');
                }
            } else {
                echo $this->render_view();
            }
            wp_die();
        }

        /**
         * Member Favourites HTML render
         * @ HTML before and after the favourites property items
         */
        public function render_view($favourite_query = '') {
            ?>
            <div class="user-favorite-list">
                <div class="element-title">
                    <h4><?php echo wp_rem_plugin_text_srt('wp_rem_favourite_fav_propert'); ?></h4>
                </div>
                <ul class="favourites-list">
                    <?php
                    if ( $favourite_query != '' && $favourite_query->have_posts() ) :
                        echo $this->render_list_item_view($favourite_query);
                    else:
                        ?><li class="no-favourites-found"><i class="icon-favourite"></i><?php
                        echo wp_rem_plugin_text_srt('wp_rem_favourite_dont_hav_fav_propert');
                        ?></li><?php
                    endif;
                    ?>
                </ul>
            </div>
            <?php
        }

        /**
         * Member Favourites Items HTML render
         * @ HTML for favourites property items
         */
        public function render_list_item_view($favourite_query) {
            while ( $favourite_query->have_posts() ) : $favourite_query->the_post();
                //$category = get_term_by( 'id', get_post_meta( get_the_ID(), 'wp_rem_property_category', true ), 'property-category' );
                //$category = get_the_terms( get_the_ID(), 'property-category' );
                $wp_rem_property_type = get_post_meta(get_the_ID(), 'wp_rem_property_type', true);
                if ( $property_type_post = get_page_by_path($wp_rem_property_type, OBJECT, 'property-type') )
                    $property_type_id = $property_type_post->ID;
                $wp_rem_cate_str = '';
                $wp_rem_property_category = get_post_meta(get_the_ID(), 'wp_rem_property_category', true);
                $wp_rem_post_loc_address_property = get_post_meta(get_the_ID(), 'wp_rem_post_loc_address_property', true);

                if ( ! empty($wp_rem_property_category) && is_array($wp_rem_property_category) ) {
                    $comma_flag = 0;
                    foreach ( $wp_rem_property_category as $cate_slug => $cat_val ) {
                        $wp_rem_cate = get_term_by('slug', $cat_val, 'property-category');

                        if ( ! empty($wp_rem_cate) ) {
                            $cate_link = wp_rem_property_category_link($property_type_id, $cat_val);
                            if ( $comma_flag != 0 ) {
                                $wp_rem_cate_str .= ', ';
                            }
                            $wp_rem_cate_str .= '<a href="' . $cate_link . '">' . $wp_rem_cate->name . '</a>';
                            $comma_flag ++;
                        }
                    }
                }
                ?>
                <li>
                    <div class="suggest-list-holder">
                        <div class="img-holder">
                            <figure>
                                <?php
                                if ( function_exists('property_gallery_first_image') ) {
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
                        </div>
                        <div class="text-holder">
                            <h6><a href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo get_the_title(); ?></a></h6>
                            <?php if ( $wp_rem_cate_str != '' ) { ?>
                                <span class="rent-label"><?php echo wp_rem_allow_special_char($wp_rem_cate_str); ?></span>
                            <?php } ?>
                            <a href="javascript:void(0);" class="short-icon delete-favourite" data-id="<?php echo intval(get_the_ID()); ?>"><i class="icon-close"></i></a>
                        </div>
                    </div>
                </li>
                <?php
            endwhile;
        }

        /**
         * Member Favourites Frontend Button
         * @ favourites frontend buuton based on property id
         */
        public function wp_rem_favourites_frontend_button_callback($post_id = '', $args = array(), $figcaption_div = false) {
            // remove favourite button
            return;
            wp_enqueue_script('wp-rem-favourites-script');
            $before_label = '';
            $after_label = '';
            $before_icon = '<i class="icon-heart"></i>';
            $after_icon = '<i class="icon-heart5"></i>';
            $show_count = false;
            extract($args);
            $user_id = get_current_user_id();
            $class = 'favourite';
            $favourite_icon = $before_icon;
            $change_icon = $after_icon;
            $favourite_text = $before_label;
            $count_property_favourites = get_post_meta($post_id, 'wp_rem_property_favourites', true);
            $count_property_favourites = (isset($count_property_favourites) && $count_property_favourites != '') ? $count_property_favourites : 0;
            if ( $user_id != 0 && $post_id != '' ) {
                $user_info = get_userdata($user_id);
                $user_role = implode(', ', $user_info->roles);
                $user_company = get_user_meta($user_id, 'wp_rem_company', true);
                $property_favourites = get_post_meta($user_company, 'wp_rem_favourites', true);

                if ( ! empty($property_favourites) && $this->wp_rem_favourites_find_in_multiarray($post_id, $property_favourites, 'property_id') ) {
                    $class = 'favourite';
                    $favourite_text = $after_label;
                    $favourite_icon = $after_icon;
                    $change_icon = $before_icon;
                }
                if ( true === Wp_rem_Member_Permissions::check_permissions('favourites') ) {
                    if ( isset($figcaption_div) && $figcaption_div == true ) {
                        ?>
                        <div class="like-btn">
                            <?php
                        }
                        ?>
                        <?php if ( $show_count == true ) { ?>
                            <span class="likes-count">
                                <i class="icon-keyboard_arrow_left"></i> <span><?php echo $count_property_favourites; ?></span> <i class="icon-keyboard_arrow_right"></i> 
                            </span>
                        <?php } ?>
                        <a href="javascript:void(0);" class="<?php echo esc_html($class); ?>" onclick="wp_rem_member_favourite(this, '<?php echo intval($post_id); ?>', '<?php echo intval($user_id); ?>', '<?php echo esc_html($before_label); ?>', '<?php echo esc_html($after_label); ?>', '<?php echo esc_html($before_icon); ?>', '<?php echo esc_html($after_icon); ?>', {'added': '<?php echo wp_rem_plugin_text_srt('wp_rem_favourite_fav_added'); ?>', 'removed': '<?php echo wp_rem_plugin_text_srt('wp_rem_favourite_fav_removed'); ?>'});">
                            <?php echo $favourite_icon; ?><?php echo esc_html($favourite_text); ?>
                        </a>
                        <?php
                        if ( isset($figcaption_div) && $figcaption_div == true ) {
                            ?>
                        </div>			
                        <?php
                    }
                }
            } else {
                ?>
                <div class="like-btn">
                    <?php if ( $show_count == true ) { ?>
                        <span class="likes-count">
                            <i class="icon-keyboard_arrow_left"></i> <span><?php echo $count_property_favourites; ?></span> <i class="icon-keyboard_arrow_right"></i> 
                        </span>
                    <?php } ?>
                    <a href="javascript:void(0);" class="<?php echo esc_html($class); ?> wp-rem-open-signin-tab" >
                        <?php echo $favourite_icon; ?><?php echo esc_html($favourite_text); ?>
                    </a>
                </div>
                <?php
            }
        }

        /**
         * Member Favourites
         * @ added member favourites based on property id
         */
        public function wp_rem_favourite_submit_callback() {

            $property_id = wp_rem_get_input('property_id');
            $member_id = wp_rem_get_input('member_id');
            $current_user = wp_get_current_user();
            $response = $member_favourites = array();

            if ( '' != $member_id ) {
                $user_company = get_user_meta($member_id, 'wp_rem_company', true);
                $member_name = get_the_title($user_company);
                $member_favourites = get_post_meta($user_company, 'wp_rem_favourites', true);
                if ( ! empty($member_favourites) && $this->wp_rem_favourites_find_in_multiarray($property_id, $member_favourites, 'property_id') ) {
                    foreach ( $member_favourites as $key => $sub_array ) {
                        if ( $sub_array['property_id'] == $property_id ) {
                            unset($member_favourites[$key]);
                            $response['status'] = false;
                        }
                    }

                    // Removing Property Favourite
                    $property_favourites = get_post_meta($property_id, 'wp_rem_property_favourites', true);
                    if ( $property_favourites > 0 ) {
                        $property_favourites --;
                    }
                    update_post_meta($property_id, 'wp_rem_property_favourites', $property_favourites);
                    $response['property_count'] = $property_favourites;
                } else {
                    $member_favourites[] = array(
                        'property_id' => $property_id,
                        'date' => strtotime(date('d-m-Y')),
                    );
                    $response['status'] = true;

                    /*
                     * Adding Notification
                     */
                    $notification_array = array(
                        'type' => 'property',
                        'element_id' => $property_id,
                        'message' => force_balance_tags($member_name . wp_rem_plugin_text_srt('wp_rem_favourite_favourite_ur_property') . ' <a href="' . get_the_permalink($property_id) . '">' . wp_trim_words(get_the_title($property_id), 5) . '</a> .'),
                    );
                    do_action('wp_rem_add_notification', $notification_array);

                    // Adding Property Favourite
                    $property_favourites = get_post_meta($property_id, 'wp_rem_property_favourites', true);
                    $property_favourites ++;
                    update_post_meta($property_id, 'wp_rem_property_favourites', $property_favourites);
                    $response['property_count'] = $property_favourites;
                }
                if ( ! empty($member_favourites) ) {
                    $member_favourites = array_values($member_favourites);
                }

                update_post_meta($user_company, 'wp_rem_favourites', $member_favourites);
            } else {
                $response['status'] = false;
            }
            echo json_encode($response);

            wp_die();
        }

        /**
         * Member Removed Favourite
         * @ removed member favourites based on property id
         */
        public function wp_rem_removed_favourite_callback() {

            $property_id = wp_rem_get_input('property_id');
            $current_user = wp_get_current_user();
            $member_id = get_current_user_id();
            $user_data = get_user_info_array();
            $response = array();
            $response['status'] = false;
            if ( '' != $property_id && '' != $member_id ) {
                $user_company = get_user_meta($member_id, 'wp_rem_company', true);
                $member_favourites = get_post_meta($user_company, 'wp_rem_favourites', true);
                foreach ( $member_favourites as $key => $sub_array ) {
                    if ( $sub_array['property_id'] == $property_id ) {
                        unset($member_favourites[$key]);
                        $response['status'] = true;
                        $response['message'] = wp_rem_plugin_text_srt('wp_rem_favourite_delete_successfully');
                    }
                }
                if ( ! empty($member_favourites) ) {
                    $member_favourites = array_values($member_favourites);
                }
                update_post_meta($user_company, 'wp_rem_favourites', $member_favourites);

                // Removing Property Favourite
                $property_favourites = get_post_meta($property_id, 'wp_rem_property_favourites', true);
                if ( $property_favourites > 0 ) {
                    $property_favourites --;
                }
                update_post_meta($property_id, 'wp_rem_property_favourites', $property_favourites);
                $response['property_count'] = $property_favourites;

                $display_name = isset($user_data['display_name']) ? $user_data['display_name'] : '';
                $notification_array = array(
                    'type' => 'property',
                    'element_id' => $property_id,
                    'message' => $display_name . wp_rem_plugin_text_srt('wp_rem_favourite_remove_one_list'),
                );
                do_action('wp_rem_add_notification', $notification_array);
            }
            echo json_encode($response);
            wp_die();
        }

        public function wp_rem_favourites_find_in_multiarray($elem, $array, $field) {

            $top = sizeof($array);
            $k = 0;
            $new_array = array();
            for ( $i = 0; $i <= $top; $i ++ ) {
                if ( isset($array[$i]) ) {
                    $new_array[$k] = $array[$i];
                    $k ++;
                }
            }
            $array = $new_array;
            $top = sizeof($array) - 1;
            $bottom = 0;

            $finded_index = '';
            if ( is_array($array) ) {
                while ( $bottom <= $top ) {
                    if ( isset($array[$bottom][$field]) && $array[$bottom][$field] == $elem )
                        $finded_index[] = $bottom;
                    else
                    if ( isset($array[$bottom][$field]) && is_array($array[$bottom][$field]) )
                        if ( wp_rem_find_in_multiarray($elem, ($array[$bottom][$field])) )
                            $finded_index[] = $bottom;
                    $bottom ++;
                }
            }
            return $finded_index;
        }

        public function wp_rem_base_query_args($element_filter_arr = array()) {
            $element_filter_arr[] = array(
                'key' => 'wp_rem_property_posted',
                'value' => strtotime(date("d-m-Y")),
                'compare' => '<=',
            );

            $element_filter_arr[] = array(
                'key' => 'wp_rem_property_expired',
                'value' => strtotime(date("d-m-Y")),
                'compare' => '>=',
            );

            $element_filter_arr[] = array(
                'key' => 'wp_rem_property_status',
                'value' => 'active',
                'compare' => '=',
            );
            // check if member not inactive
            $element_filter_arr[] = array(
                'key' => 'property_member_status',
                'value' => 'active',
                'compare' => '==',
            );
            return $element_filter_arr;
        }

    }

    global $wp_rem_favourites;
    $wp_rem_favourites = new Wp_rem_Favourites();
}