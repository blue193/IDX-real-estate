<?php
/**
 * Member Properties
 *
 */
if (!class_exists('Wp_rem_Member_Properties')) {

    class Wp_rem_Member_Properties {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action('wp_enqueue_scripts', array($this, 'wp_rem_filters_element_scripts'), 11);
            add_action('wp_ajax_wp_rem_member_properties', array($this, 'wp_rem_member_properties_callback'), 11, 1);
            add_action('wp_ajax_nopriv_wp_rem_member_properties', array($this, 'wp_rem_member_properties_callback'), 11, 1);
            add_action('wp_ajax_wp_rem_member_prop_notes', array($this, 'wp_rem_member_properties_notes_callback'), 11, 1);
            add_action('wp_ajax_nopriv_wp_rem_member_prop_notes', array($this, 'wp_rem_member_properties_notes_callback'), 11, 1);
            add_action('wp_ajax_wp_rem_member_property_delete', array($this, 'delete_user_property'));
            add_action('wp_ajax_wp_rem_removed_prop_removed', array($this, 'delete_user_property_notes'));
            add_action('wp_ajax_wp_rem_member_hidden_properties', array($this, 'wp_rem_member_hidden_properties_callback'));
        }

        public function wp_rem_filters_element_scripts() {
            wp_enqueue_style('daterangepicker');
            wp_enqueue_script('daterangepicker-moment');
            wp_enqueue_script('daterangepicker');
            wp_enqueue_script('wp-rem-filters-functions');
            //wp_enqueue_script('daterangepicker');
            //wp_enqueue_script('wp-rem-filters-functions');
        }

        public function delete_user_property_notes() {

            global $current_user;

            $prop_id = isset($_POST['property_id']) ? $_POST['property_id'] : '';

            $company_id = wp_rem_company_id_form_user_id($current_user->ID);

            $property_notes = get_post_meta($company_id, 'property_notes', true);

            unset($property_notes[$prop_id]);

            update_post_meta($company_id, 'property_notes', $property_notes);

            echo json_encode(array('status' => true, 'message' => wp_rem_plugin_text_srt('wp_rem_prop_notes_prop_notes_deleted')));
            die;
        }

        public function wp_rem_member_hidden_properties_callback() {

            global $wp_rem_plugin_options;
            wp_enqueue_script( 'wp-rem-property-hidden-script' );
            $pagi_per_page = isset($wp_rem_plugin_options['wp_rem_member_dashboard_pagination']) ? $wp_rem_plugin_options['wp_rem_member_dashboard_pagination'] : '';
            $posts_per_page = $pagi_per_page > 0 ? $pagi_per_page : 1;
            $posts_paged = isset($_REQUEST['page_id_all']) ? $_REQUEST['page_id_all'] : '';
            // Member ID.
            if (!isset($member_id) || $member_id == '') {
                $member_id = get_current_user_id();
            }
            // Post Type.
            if (!isset($post_type) || $post_type == '') {
                $post_type = 'properties';
            }
            $user_company = get_user_meta($member_id, 'wp_rem_company', true);
            $wp_rem_property_hide_list = get_post_meta($user_company, 'wp_rem_property_hide_list', true);
            $all_properties = array();
            if (isset($wp_rem_property_hide_list) && !empty($wp_rem_property_hide_list)) {
                $property_ids = array();
                foreach ($wp_rem_property_hide_list as $property_hide_list_data) {
                    $property_ids[] = $property_hide_list_data['property_id'];
                }

                $wp_rem_base_query_args = '';
                $wp_rem_base_query_args[] = array(
                    'key' => 'wp_rem_property_posted',
                    'value' => strtotime(date("d-m-Y")),
                    'compare' => '<=',
                );

                $wp_rem_base_query_args[] = array(
                    'key' => 'wp_rem_property_expired',
                    'value' => strtotime(date("d-m-Y")),
                    'compare' => '>=',
                );

                $wp_rem_base_query_args[] = array(
                    'key' => 'wp_rem_property_status',
                    'value' => 'active',
                    'compare' => '=',
                );
                // check if member not inactive
                $wp_rem_base_query_args[] = array(
                    'key' => 'property_member_status',
                    'value' => 'active',
                    'compare' => '==',
                );

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
                $property_hide_list_query = new WP_Query($args);
                $total_posts = $property_hide_list_query->found_posts;
                ?>
                <div class="user-property-hidden-list">
                    <div class="element-title">
                        <h4><?php echo wp_rem_plugin_text_srt('wp_rem_hidden_properties'); ?></h4>
                    </div>
                    <ul class="property-hidden-list">
                        <?php
                        if ($property_hide_list_query != '' && $property_hide_list_query->have_posts()) :
                            while ($property_hide_list_query->have_posts()) : $property_hide_list_query->the_post();
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
                                        </div>
                                        <div class="text-holder">
                                            <h6><a href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo get_the_title(); ?></a></h6>
                                            <?php if ($wp_rem_cate_str != '') { ?>
                                                <span class="rent-label"><?php echo wp_rem_allow_special_char($wp_rem_cate_str); ?></span>
                                            <?php } ?>
                                            <a href="javascript:void(0);" class="short-icon delete-hidden-property" data-id="<?php echo intval(get_the_ID()); ?>"><i class="icon-close"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            endwhile;
                        else:
                            ?><li class="no-hidden-list-found"><i class="icon-block"></i><?php
                            echo wp_rem_plugin_text_srt('wp_rem_hidden_dont_hav_hidden_propert');
                            ?></li><?php
                        endif;
                        ?>
                    </ul>
                </div> 
                <?php
                wp_reset_postdata();
                $total_pages = 1;
                if ($total_posts > 0 && $posts_per_page > 0 && $total_posts > $posts_per_page) {
                    $total_pages = ceil($total_posts / $posts_per_page);
                    $wp_rem_dashboard_page = isset($wp_rem_plugin_options['wp_rem_member_dashboard']) ? $wp_rem_plugin_options['wp_rem_member_dashboard'] : '';
                    $wp_rem_dashboard_link = $wp_rem_dashboard_page != '' ? get_permalink($wp_rem_dashboard_page) : '';
                    $this_url = $wp_rem_dashboard_link != '' ? add_query_arg(array('dashboard' => 'hidden_properties'), $wp_rem_dashboard_link) : '';
                    wp_rem_dashboard_pagination($total_pages, $posts_paged, $this_url, 'hidden_properties');
                }
            }
            wp_die();
        }

        public function wp_rem_member_properties_notes_callback($member_id = '') {
            global $current_user, $wp_rem_plugin_options;
            $pagi_per_page = isset($wp_rem_plugin_options['wp_rem_member_dashboard_pagination']) ? $wp_rem_plugin_options['wp_rem_member_dashboard_pagination'] : '';
            $posts_per_page = $pagi_per_page > 0 ? $pagi_per_page : 10;
            $posts_paged = isset($_REQUEST['page_id_all']) ? $_REQUEST['page_id_all'] : '';
            $start = 0;
            if ($posts_paged > 0) {
                $start = ( $posts_paged - 1 ) * $posts_per_page;
            }

            $member_id = wp_rem_company_id_form_user_id($current_user->ID);

            $property_notes = get_post_meta($member_id, 'property_notes', true);

            $total_res = 0;
            if (is_array($property_notes) && sizeof($property_notes) > 0) {
                $total_res = sizeof($property_notes);
            }

            $output_property_notes = array_slice($property_notes, $start, $posts_per_page);
            echo force_balance_tags($this->render_notes_view($output_property_notes));

            $total_pages = 1;
            if ($total_res > 0 && $posts_per_page > 0 && $total_res > $posts_per_page) {
                $total_pages = ceil($total_res / $posts_per_page);
                $dashboard_page = isset($wp_rem_plugin_options['wp_rem_member_dashboard']) ? $wp_rem_plugin_options['wp_rem_member_dashboard'] : '';
                $dashboard_link = $dashboard_page != '' ? get_permalink($dashboard_page) : '';
                $this_url = $dashboard_link != '' ? add_query_arg(array('dashboard' => 'prop_notes'), $dashboard_link) : '';
                wp_rem_dashboard_pagination($total_pages, $posts_paged, $this_url, 'prop_notes');
            }

            wp_die();
        }

        public function render_notes_view($all_properties) {
            global $wp_rem_plugin_options, $wp_rem_form_fields_frontend;

            $has_border = ' has-border';
            if (!empty($all_properties)) {
                $has_border = '';
            }
            ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                    <div class="user-property">
                        <div class="element-title">
                            <h4><?php echo wp_rem_plugin_text_srt('wp_rem_prop_notes_properties_notes') ?></h4>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div id="wp-rem-dev-user-property-notes" class="user-favorite-list" data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>"> 
                                    <ul class="favourites-list">

                                        <?php
                                        if (isset($all_properties) && !empty($all_properties)) {
                                            foreach ($all_properties as $property_key => $property_data) {

                                                $notes = isset($property_data['notes']) ? $property_data['notes'] : '';
                                                $property_id = isset($property_data['property_id']) ? $property_data['property_id'] : '';
                                                ?>
                                                <li>
                                                    <div class="suggest-list-holder">
                                                        <div class="text-holder">
                                                            <h6><a href="<?php echo get_permalink($property_id) ?>"><?php echo get_the_title($property_id) ?></a></h6>
                                                            <p>
                                                                <?php
                                                                if (strlen($notes) > 200) {
                                                                    echo substr($notes, 0, 200);
                                                                    echo '<span class="expanded-txt" style="display: none;">' . substr($notes, 200, strlen($notes)) . '</span>';
                                                                    echo ' <a href="javascript:void(0)" class="expand-notes" data-sh-more="' . wp_rem_plugin_text_srt('wp_rem_prop_notes_show_more') . '" data-sh-less="' . wp_rem_plugin_text_srt('wp_rem_prop_notes_show_less') . '">' . wp_rem_plugin_text_srt('wp_rem_prop_notes_show_more') . '</a>';
                                                                } else {
                                                                    echo force_balance_tags($notes);
                                                                }
                                                                ?>
                                                            </p>
                                                            <a href="javascript:void(0);" class="short-icon delete-prop-notes" data-id="<?php echo absint($property_id) ?>"><i class="icon-close"></i></a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <li class="no-property-found">
                                                <i class="icon-caution"></i>
                                                <?php echo wp_rem_plugin_text_srt('wp_rem_prop_notes_no_result_notes') ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Member Properties
         * @ filter the properties based on member id
         */
        public function wp_rem_member_properties_callback($member_id = '') {
            global $current_user, $wp_rem_plugin_options;
            $pagi_per_page = isset($wp_rem_plugin_options['wp_rem_member_dashboard_pagination']) ? $wp_rem_plugin_options['wp_rem_member_dashboard_pagination'] : '';
            $member_id = wp_rem_company_id_form_user_id($current_user->ID);
            $posts_per_page = $pagi_per_page > 0 ? $pagi_per_page : 1;
            $posts_paged = isset($_REQUEST['page_id_all']) ? $_REQUEST['page_id_all'] : '';

            $args = array(
                'post_type' => 'properties',
                'posts_per_page' => $posts_per_page,
                'paged' => $posts_paged,
                'post_status' => 'publish',
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

            $args = wp_rem_filters_query_args($args);
            $custom_query = new WP_Query($args);
            $total_posts = $custom_query->found_posts;
            $all_properties = $custom_query->posts;

            echo force_balance_tags($this->render_view($all_properties));
            wp_reset_postdata();

            $total_pages = 1;
            if ($total_posts > 0 && $posts_per_page > 0 && $total_posts > $posts_per_page) {
                $total_pages = ceil($total_posts / $posts_per_page);
                $wp_rem_dashboard_page = isset($wp_rem_plugin_options['wp_rem_member_dashboard']) ? $wp_rem_plugin_options['wp_rem_member_dashboard'] : '';
                $wp_rem_dashboard_link = $wp_rem_dashboard_page != '' ? get_permalink($wp_rem_dashboard_page) : '';
                $this_url = $wp_rem_dashboard_link != '' ? add_query_arg(array('dashboard' => 'properties'), $wp_rem_dashboard_link) : '';
                wp_rem_dashboard_pagination($total_pages, $posts_paged, $this_url, 'properties');
            }

            wp_die();
        }

        /**
         * Member Properties HTML render
         * @ HTML before and after the property items
         */
        public function render_view($all_properties) {
            global $wp_rem_plugin_options, $wp_rem_form_fields_frontend;
            wp_enqueue_script('wp-rem-filters-functions');
            $wp_rem_dashboard_page = isset($wp_rem_plugin_options['wp_rem_create_property_page']) ? $wp_rem_plugin_options['wp_rem_create_property_page'] : '';
            $wp_rem_dashboard_link = $wp_rem_dashboard_page != '' ? get_permalink($wp_rem_dashboard_page) : '';
            if (isset($_GET['lang'])) {
                $wp_rem_property_add_url = $wp_rem_dashboard_link != '' ? add_query_arg(array('lang' => $_GET['lang']), $wp_rem_dashboard_link) : '#';
            } else if (wp_rem_wpml_lang_url() != '') {
                $cs_lang_string = wp_rem_wpml_lang_url();
                $wp_rem_property_add_url = $wp_rem_dashboard_link != '' ? add_query_arg(array(), wp_rem_wpml_parse_url($cs_lang_string, $wp_rem_dashboard_link)) : '#';
            } else {
                $wp_rem_property_add_url = $wp_rem_dashboard_link != '' ? add_query_arg(array(), $wp_rem_dashboard_link) : '#';
            }

            $date_range = isset($_POST['date_range']) ? $_POST['date_range'] : '';
            $has_border = ' has-border';
            if (!empty($all_properties)) {
                $has_border = '';
            }
            ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                    <div class="user-property">
                        <div class="element-title right-filters-row<?php echo wp_rem_allow_special_char($has_border); ?>">
                            <h4><?php echo wp_rem_plugin_text_srt('wp_rem_properties_properties'); ?></h4>
                            <div class="right-filters row pull-right">
                                <div class="col-lg-8 col-md-8 col-xs-8">
                                    <?php if ((empty($all_properties) && $date_range != '') || (isset($all_properties) && !empty($all_properties))) { ?>
                                        <div class="input-field">
                                            <i class="icon-angle-down"></i> 
                                            <?php
                                            $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                                                    array(
                                                        'cust_name' => '',
                                                        'cust_id' => 'date_range',
                                                        'std' => esc_html($date_range),
                                                        'extra_atr' => 'placeholder="' . wp_rem_plugin_text_srt('wp_rem_properties_date_range') . '"',
                                                    )
                                            );
                                            if (is_rtl()) {
                                                $date_picker_position = 'right';
                                            } else {
                                                $date_picker_position = 'left';
                                            }
                                            ?>  
                                            <script type="text/javascript">
                                                jQuery(document).ready(function () {
                                                    wp_rem_date_range_filter('date_range', 'wp_rem_member_properties', '<?php echo $date_picker_position; ?>');
                                                });
                                            </script>
                                        </div>
                                    <?php } ?>
                                    <div class="team-option">
                                        <a class="ad-submit" href="<?php echo esc_url_raw($wp_rem_property_add_url) ?>" class="add-more"><?php echo wp_rem_plugin_text_srt('wp_rem_properties_submit_ad'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div id="wp-rem-dev-user-property" class="user-list" data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>"> 
                                    <ul class="panel-group">

                                        <?php
                                        if (isset($all_properties) && !empty($all_properties)) {
                                            ?>
                                            <li> <span><?php echo wp_rem_plugin_text_srt('wp_rem_properties_ads'); ?></span>
                                                <span><?php echo wp_rem_plugin_text_srt('wp_rem_properties_posted'); ?></span>
                                                <span><?php echo wp_rem_plugin_text_srt('wp_rem_properties_expires'); ?></span> </li><?php
                                            foreach ($all_properties as $property_data) {
                                                echo force_balance_tags($this->render_list_item_view($property_data));
                                            }
                                        } else {
                                            ?>
                                            <li class="no-property-found">
                                                <i class="icon-caution"></i>
                                                <?php echo wp_rem_plugin_text_srt('wp_rem_memberlist_dont_have'); ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Member Properties Items HTML render
         * @ HTML for property items
         */
        public function render_list_item_view($property_data) {
            global $post, $wp_rem_plugin_options;
            $post = $property_data;
            setup_postdata($post);

            $property_post_on = get_post_meta(get_the_ID(), 'wp_rem_property_posted', true);
            $property_post_expiry = get_post_meta(get_the_ID(), 'wp_rem_property_expired', true);
            $property_status = get_post_meta(get_the_ID(), 'wp_rem_property_status', true);
            $wp_rem_dashboard_page = isset($wp_rem_plugin_options['wp_rem_create_property_page']) ? $wp_rem_plugin_options['wp_rem_create_property_page'] : '';
            $wp_rem_dashboard_link = $wp_rem_dashboard_page != '' ? get_permalink($wp_rem_dashboard_page) : '';
            $wp_rem_property_update_url = $wp_rem_dashboard_link != '' ? add_query_arg(array('property_id' => get_the_ID()), $wp_rem_dashboard_link) : '#';

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
            ?>
            <li id="user-property-<?php echo absint(get_the_ID()); ?>" class="alert" data-id="<?php echo esc_attr(get_the_ID()); ?>">
                <div class="panel panel-default">
                    <a href="javascript:void(0);" data-id="<?php echo absint(get_the_ID()); ?>" class="close-member wp-rem-dev-property-delete"><i class="icon-close"></i></a>
                    <div class="panel-heading"> 
                        <div class="img-holder">
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
                            <div class="property-label-caption">
                                <strong><a href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo wp_trim_words(get_the_title(), 4); ?></a></strong>
                                <?php if ($wp_rem_cate_str != '') { ?>
                                    <span class="rent-label"><?php echo wp_rem_allow_special_char($wp_rem_cate_str); ?></span>
                                <?php } ?>
                            </div>    
                        </div>
                        <span class="post-date"><?php echo esc_html($property_post_on != '' ? date_i18n(get_option('date_format'), $property_post_on) : '-' ) ?></span>
                        <?php
                        if ($property_status == 'active' || $property_status == 'awaiting-activation') {
                            ?>
                            <span class="expire-date"><?php echo esc_html($property_post_expiry != '' ? date_i18n(get_option('date_format'), $property_post_expiry) : '-' ) ?></span>
                            <?php
                        } else {
                            ?>
                            <span class="expire-date">-</span>
                            <?php
                        }
                        ?>
                        <span class="edit"><a href="<?php echo esc_url_raw($wp_rem_property_update_url) ?>"><?php echo wp_rem_plugin_text_srt('wp_rem_memberlist_edit'); ?></a></span>
                    </div>
                </div>
            </li>
            <?php
            wp_reset_postdata();
        }

        /**
         * Deleting user property from dashboard
         * @Delete Property
         */
        public function delete_user_property() {
            global $current_user;
            $property_id = isset($_POST['property_id']) ? $_POST['property_id'] : '';
            $wp_rem_member_id = get_post_meta($property_id, 'wp_rem_property_member', true);
            $member_id = wp_rem_company_id_form_user_id($current_user->ID);

            if (is_user_logged_in() && $member_id == $wp_rem_member_id) {
                update_post_meta($property_id, 'wp_rem_property_status', 'delete');
                $property_member_id = get_post_meta($property_id, 'wp_rem_property_member', true);
                if ($property_member_id != '') {
                    do_action('wp_rem_plublisher_properties_decrement', $property_member_id);
                }
                echo json_encode(array('delete' => 'true'));
            } else {
                echo json_encode(array('delete' => 'false'));
            }
            die;
        }

    }

    global $wp_rem_member_properties;
    $wp_rem_member_properties = new Wp_rem_Member_Properties();
}
