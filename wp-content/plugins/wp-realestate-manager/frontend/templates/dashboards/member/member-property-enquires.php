<?php
/**
 * Member Properties
 *
 */
if (!class_exists('Wp_rem_Member_Property_Enquiries')) {

    class Wp_rem_Member_Property_Enquiries {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action('wp_ajax_wp_rem_member_enquiries', array($this, 'wp_rem_member_enquiries_callback'), 11, 1);
            add_action('wp_ajax_wp_rem_member_received_enquiries', array($this, 'wp_rem_member_received_enquiries_callback'), 11, 1);
        }

        public function wp_rem_member_enquiries_callback($member_id = '') {
            // Member ID.
            if (!isset($member_id) || $member_id == '') {
                $member_id = get_current_user_id();
            }

            $member_company_id = wp_rem_company_id_form_user_id($member_id);
            $args = array(
                'post_type' => 'property_enquiries',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'wp_rem_enquiry_member',
                        'value' => $member_company_id,
                        'compare' => '=',
                    )
                ),
            );

            $enquiry_query = new WP_Query($args); 
            echo force_balance_tags($this->render_view_enquiries($enquiry_query, 'my'));
            wp_reset_postdata();
            wp_die();
        }

        public function wp_rem_member_received_enquiries_callback($member_id = '') {
            // Member ID.
            if (!isset($member_id) || $member_id == '') {
                $member_id = get_current_user_id();
            }

            $member_company_id = wp_rem_company_id_form_user_id($member_id);
            $args = array(
                'post_type' => 'property_enquiries',
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

            $enquiry_query = new WP_Query($args);
            echo force_balance_tags($this->render_view_enquiries($enquiry_query, 'received'));
            wp_reset_postdata();
            wp_die();
        }

        public function render_view_enquiries($enquiry_query = '', $type = 'my') {
             $has_border = ' has-border';
             if ($enquiry_query->have_posts()) : 
                $has_border = '';
             endif;
            ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="element-title<?php echo wp_rem_allow_special_char($has_border); ?>">
                        <h4><?php echo wp_rem_plugin_text_srt('wp_rem_member_enquiries_recent'); ?></h4>

                        <div class="col-lg-6 col-md-6 col-sm-12 pull-right">
                            <ul class="dashboard-nav sub-nav">
                                <li class="user_dashboard_ajax <?php
                                if ($type == 'my') {
                                    echo 'active';
                                }
                                ?>" id="wp_rem_member_enquiries" data-queryvar="dashboard=enquiries"><a href="javascript:void(0);" class="btn-edit-profile"><?php echo wp_rem_plugin_text_srt('wp_rem_member_enquiries_my_enquiries'); ?></a></li>
                                <li class="user_dashboard_ajax <?php
                                if ($type == 'received') {
                                    echo 'active';
                                }
                                ?>" id="wp_rem_member_received_enquiries" data-queryvar="dashboard=enquiries_received"><a href="javascript:void(0);"><?php echo wp_rem_plugin_text_srt('wp_rem_member_enquiries_received_enquiries'); ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="user-orders-list">
                        <ul class="orders-list" id="portfolio">
                            <?php if ($enquiry_query->have_posts()) : ?>
								<li>
									<div class="orders-title"><strong><?php echo wp_rem_plugin_text_srt('wp_rem_member_enquiries_title'); ?></strong></div>
                                    <div class="orders-date"><strong><?php echo wp_rem_plugin_text_srt('wp_rem_member_enquiries_date'); ?></strong></div>
									<?php if ($type == 'received') { ?>
										<div class="orders-type"><strong><?php echo wp_rem_plugin_text_srt('wp_rem_member_enquiries_buyer'); ?></strong></div>
									<?php }else{ ?>
										<div class="orders-type"><strong><?php echo wp_rem_plugin_text_srt('wp_rem_member_enquiries_member'); ?></strong></div>
									<?php } ?>
                                    <div class="orders-status"><strong><?php echo wp_rem_plugin_text_srt('wp_rem_member_enquiries_status'); ?></strong></div>
								</li>
                                <?php echo force_balance_tags($this->render_list_item_view($enquiry_query, $type)); ?>
                            <?php else: ?>
                                <li class="no-order-list-found">
                                    <?php
                                    if ($type == 'received') {
                                        echo wp_rem_plugin_text_srt('wp_rem_member_enquiries_not_received_enquiry');
                                    } else {
                                        echo wp_rem_plugin_text_srt('wp_rem_member_enquiries_not_enquiry');
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

        public function render_list_item_view($enquiry_query, $type = 'my') {
            while ($enquiry_query->have_posts()) : $enquiry_query->the_post();
			
                $enquiry_property_id = get_post_meta(get_the_ID(), 'wp_rem_property_id', true);
                $enquiry_status = get_post_meta(get_the_ID(), 'wp_rem_enquiry_status', true);
                $buyer_read_status = get_post_meta(get_the_ID(), 'buyer_read_status', true);
                $seller_read_status = get_post_meta(get_the_ID(), 'seller_read_status', true);

                if ($type == 'my') {
					$member_name = get_post_meta(get_the_ID(), 'wp_rem_property_member', true);
                    if ($buyer_read_status == 1) {
                        $read_unread = 'read';
                    } else {
                        $read_unread = 'unread';
                    }
                } else {
					$member_name = get_post_meta(get_the_ID(), 'wp_rem_enquiry_member', true);
                    if ($seller_read_status == 1) {
                        $read_unread = 'read';
                    } else {
                        $read_unread = 'unread';
                    }
                }
                ?>
                <li class="<?php echo esc_html($read_unread); ?>">

                    <div class="orders-title">
                        <h6 asif class="order-title"><a href="javascript:void(0);" onclick="javascript:wp_rem_enquiry_detail('<?php the_ID(); ?>','<?php echo esc_html($type); ?>');"><?php echo wp_trim_words(get_the_title($enquiry_property_id), 4, '...'); ?></a><span>( #<?php echo get_the_ID(); ?> )</span></h6>
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
                        $enquiry_status_color = $this->enquiry_status_color($enquiry_status);
                        if ($enquiry_status_color) {
                            $enquiry_color = 'style="background-color: ' . $enquiry_status_color . ';"';
                        }
                        ?>
                        <span class="<?php echo strtolower($enquiry_status); ?>" <?php echo force_balance_tags($enquiry_color); ?>><?php echo esc_html($enquiry_status); ?></span>
                    </div>

                </li>
                <?php
            endwhile;
        }

        public function enquiry_status_color($order_name = 'processing') {
            global $wp_rem_plugin_options;

            $orders_status = isset($wp_rem_plugin_options['orders_status']) ? $wp_rem_plugin_options['orders_status'] : '';
            $orders_color = isset($wp_rem_plugin_options['orders_color']) ? $wp_rem_plugin_options['orders_color'] : '';
            if (is_array($orders_status) && sizeof($orders_status) > 0) {
                foreach ($orders_status as $key => $lable) {
                    if (strtolower($lable) == strtolower($order_name)) {
                        return $order_color = isset($orders_color[$key]) ? $orders_color[$key] : '';
                        break;
                    }
                }
            }
        }

    }

    global $orders_inquiries;
    $orders_inquiries = new Wp_rem_Member_Property_Enquiries();
}
