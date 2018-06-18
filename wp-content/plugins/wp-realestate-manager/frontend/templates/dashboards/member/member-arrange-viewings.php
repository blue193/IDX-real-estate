<?php
/**
 * Member Properties
 *
 */
if ( ! class_exists('Wp_rem_Member_Viewings') ) {

    class Wp_rem_Member_Viewings {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action('wp_ajax_wp_rem_member_viewings', array( $this, 'wp_rem_member_viewings_callback' ), 11, 1);
            add_action('wp_ajax_wp_rem_member_received_viewings', array( $this, 'wp_rem_member_received_viewings_callback' ), 11, 1);
        }

        public function wp_rem_member_viewings_callback($member_id = '') {
            // Member ID.
            if ( ! isset($member_id) || $member_id == '' ) {
                $member_id = get_current_user_id();
            }

            $member_company_id = wp_rem_company_id_form_user_id($member_id);
            $args = array(
                'post_type' => 'property_viewings',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'wp_rem_viewing_member',
                        'value' => $member_company_id,
                        'compare' => '=',
                    )
                ),
            );

            $viewing_query = new WP_Query($args);
            echo force_balance_tags($this->render_view_viewings($viewing_query, 'my'));
            wp_reset_postdata();
            wp_die();
        }

        public function wp_rem_member_received_viewings_callback($member_id = '') {
            // Member ID.
            if ( ! isset($member_id) || $member_id == '' ) {
                $member_id = get_current_user_id();
            }

            $member_company_id = wp_rem_company_id_form_user_id($member_id);
            $args = array(
                'post_type' => 'property_viewings',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'wp_rem_property_member',
                        'value' => $member_company_id,
                        'compare' => '=',
                    )
                ),
            );

            $viewing_query = new WP_Query($args);
            echo force_balance_tags($this->render_view_viewings($viewing_query, 'received'));
            wp_reset_postdata();
            wp_die();
        }

        public function render_view_viewings($viewing_query = '', $type = 'my') {

            $has_border = ' has-border';
            if ( $viewing_query->have_posts() ) {
                $has_border = '';
            }
            ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="element-title<?php echo wp_rem_allow_special_char($has_border); ?>">
                        <h4><?php echo wp_rem_plugin_text_srt('wp_rem_member_viewings_recent_viewings'); ?></h4>

                        <div class="col-lg-6 col-md-6 col-sm-12 pull-right">
                            <ul class="dashboard-nav sub-nav">
                                <li class="user_dashboard_ajax <?php
                                if ( $type == 'my' ) {
                                    echo 'active';
                                }
                                ?>" id="wp_rem_member_viewings" data-queryvar="dashboard=viewings"><a href="javascript:void(0);" class="btn-edit-profile"><?php echo wp_rem_plugin_text_srt('wp_rem_member_viewings_my_viewings'); ?></a></li>
                                <li class="user_dashboard_ajax <?php
                                if ( $type == 'received' ) {
                                    echo 'active';
                                }
                                ?>" id="wp_rem_member_received_viewings" data-queryvar="dashboard=viewings_received"><a href="javascript:void(0);"><?php echo wp_rem_plugin_text_srt('wp_rem_member_viewings_received_viewings'); ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="user-orders-list">
                        <ul class="orders-list" id="portfolio">
                            <?php if ( $viewing_query->have_posts() ) : ?>
                                <li>
                                    <div class="orders-title"><strong><?php echo wp_rem_plugin_text_srt('wwp_rem_member_viewings_title'); ?></strong></div>
                                    <div class="orders-date"><strong><?php echo wp_rem_plugin_text_srt('wp_rem_member_viewings_date'); ?></strong></div>
                                    <?php if ( $type == 'received' ) { ?>
                                        <div class="orders-type"><strong><?php echo wp_rem_plugin_text_srt('wp_rem_member_viewings_buyer'); ?></strong></div>
                                    <?php } else { ?>
                                        <div class="orders-type"><strong><?php echo wp_rem_plugin_text_srt('wp_rem_member_viewings_member'); ?></strong></div>
                                    <?php } ?>
                                    <div class="orders-status"><strong><?php echo wp_rem_plugin_text_srt('wp_rem_member_viewings_status'); ?></strong></div>
                                </li>
                                <?php echo force_balance_tags($this->render_list_item_view($viewing_query, $type)); ?>
                            <?php else: ?>
                                <li class="no-order-list-found">
                                    <?php
                                    if ( $type == 'received' ) {
                                        echo wp_rem_plugin_text_srt('wp_rem_member_viewings_not_received_viewing');
                                    } else {
                                        echo wp_rem_plugin_text_srt('wp_rem_member_viewings_not_viewing');
                                    }
                                    ?>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
        }

        public function render_list_item_view($viewing_query, $type = 'my') {
            while ( $viewing_query->have_posts() ) : $viewing_query->the_post();
                $viewing_property_id = get_post_meta(get_the_ID(), 'wp_rem_property_id', true);
                $viewing_status = get_post_meta(get_the_ID(), 'wp_rem_viewing_status', true);
                $buyer_read_status = get_post_meta(get_the_ID(), 'buyer_read_status', true);
                $seller_read_status = get_post_meta(get_the_ID(), 'seller_read_status', true);

                if ( $type == 'my' ) {
                    $member_name = get_post_meta(get_the_ID(), 'wp_rem_property_member', true);
                    if ( $buyer_read_status == 1 ) {
                        $read_unread = 'read';
                    } else {
                        $read_unread = 'unread';
                    }
                } else {
                    $member_name = get_post_meta(get_the_ID(), 'wp_rem_viewing_member', true);
                    if ( $seller_read_status == 1 ) {
                        $read_unread = 'read';
                    } else {
                        $read_unread = 'unread';
                    }
                }
                ?>
                <li class="<?php echo esc_html($read_unread); ?>">
                    <div class="orders-title">
                        <h6 class="order-title"><a href="javascript:void(0);" onclick="javascript:wp_rem_arrange_viewing_detail('<?php the_ID(); ?>', '<?php echo esc_html($type); ?>');"><?php echo wp_trim_words(get_the_title($viewing_property_id), 4, '...'); ?></a><span>( #<?php echo get_the_ID(); ?> )</span></h6>
                    </div>
                    <div class="orders-date">
                        <span><?php echo get_the_date('M, d Y'); ?></span>
                    </div>
                    <div class="orders-type">
                        <span><?php echo get_the_title($member_name); ?></span>
                    </div>
                    <div class="orders-status">
                        <?php
                        $order_color = '';
                        $order_status_color = $this->order_status_color($viewing_status);
                        if ( $order_status_color ) {
                            $order_color = 'style="background-color: ' . $order_status_color . ';"';
                        }
                        ?>
                        <span class="<?php echo strtolower($order_status); ?>" <?php echo force_balance_tags($order_color); ?>><?php echo esc_html($viewing_status); ?></span>
                    </div>

                </li>
                <?php
            endwhile;
        }

        public function order_status_color($order_name = 'processing') {
            global $wp_rem_plugin_options;

            $orders_status = isset($wp_rem_plugin_options['orders_status']) ? $wp_rem_plugin_options['orders_status'] : '';
            $orders_color = isset($wp_rem_plugin_options['orders_color']) ? $wp_rem_plugin_options['orders_color'] : '';
            if ( is_array($orders_status) && sizeof($orders_status) > 0 ) {
                foreach ( $orders_status as $key => $lable ) {
                    if ( strtolower($lable) == strtolower($order_name) ) {
                        return $order_color = isset($orders_color[$key]) ? $orders_color[$key] : '';
                        break;
                    }
                }
            }
        }

    }

    global $viewings;
    $viewings = new Wp_rem_Member_Viewings();
}
