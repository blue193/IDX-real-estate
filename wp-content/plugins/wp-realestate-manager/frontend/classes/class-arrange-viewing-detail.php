<?php
/**
 * File Type: Order/Inquiry Detail
 */
if (!class_exists('Wp_rem_Arrange_Viewing_Detail')) {

    class Wp_rem_Arrange_Viewing_Detail {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action('wp_ajax_wp_rem_arrange_viewing_detail', array($this, 'wp_rem_arrange_viewing_detail_callback'), 11, 1);
			add_action( 'wp_ajax_wp_rem_update_viewing_read_status', array( $this, 'wp_rem_update_viewing_read_status_callback' ), 10 );
			add_action( 'wp_ajax_wp_rem_update_viewing_status', array( $this, 'wp_rem_update_viewing_status_callback' ), 10 );
			add_action( 'wp_ajax_wp_rem_closed_viewing', array( $this, 'wp_rem_closed_viewing_callback' ), 10 );
        }

        public function wp_rem_arrange_viewing_detail_callback() {
            global $wp_rem_form_fields, $wp_rem_plugin_options;

            $viewing_id = wp_rem_get_input('viewing_id', 0);
            $type = wp_rem_get_input('type', 0);

            $args = array(
                'post_type' => 'property_viewings',
                'post_status' => 'publish',
                'p' => $viewing_id,
            );
            $order_query = new WP_Query($args);
            while ($order_query->have_posts()): $order_query->the_post();

                $post_id = get_the_ID();
                $wp_rem_property_id = get_post_meta($post_id, 'wp_rem_property_id', true);
                $arrange_view_date = get_post_meta($post_id, 'wp_rem_arrange_view_date', true);
               
                $property_member = get_post_meta($post_id, 'wp_rem_property_member', true);
                $viewing_member = get_post_meta($post_id, 'wp_rem_viewing_member', true);
                $user_id = get_current_user_id();
                $current_login_member = wp_rem_company_id_form_user_id($user_id);
                
                $user_status = '';
                if ($property_member == $current_login_member) {
                    update_post_meta($post_id, 'seller_read_status', '1');
                    $user_status = 'seller';
                } else if ($viewing_member == $current_login_member) {
                    update_post_meta($post_id, 'buyer_read_status', '1');
                    $user_status = 'buyer';
                }
                ?>
                <div class="list-detail-options has-checkbox">
                    <?php
                    if ($type == 'received') {
                        $viewing_id = 'wp_rem_member_received_viewings';
                    } else {
                        
                        $viewing_id = 'wp_rem_member_viewings';
                    }
                    ?>
                    <h3>
                        <a id="wp_rem_member_viewings" class="user_dashboard_ajax" href="javascript:void(0);"><?php echo  wp_rem_plugin_text_srt('wp_rem_member_register_arrange_viewings'); ?></a>
						&nbsp;>&nbsp;<a id="<?php echo esc_html($viewing_id); ?>" class="user_dashboard_ajax" href="javascript:void(0);"><?php echo get_the_title($wp_rem_property_id); ?></a>
						&nbsp;>&nbsp;<?php echo wp_rem_plugin_text_srt('wp_rem_member_arrange_viewing'); ?> #<?php echo absint($post_id); ?>
                    </h3>
                    <ul class="order-detail-options">
                        <li class="created-date">
                            <strong><?php echo wp_rem_plugin_text_srt('wp_rem_order_detail_created'); ?></strong>
                            <span><?php echo get_the_time('d M Y', $post_id); ?></span>
                        </li>
                    </ul>
                    <div class="order-read-unread">
                        <div class="input-field">
                            <?php
                            $read = wp_rem_plugin_text_srt('wp_rem_arrange_viewing_detail_mark_read');
							$unread = wp_rem_plugin_text_srt('wp_rem_arrange_viewing_detail_mark_unread');
                            ?>
                            <div class="checkbox-list viewing-read-checkbox" data-read="<?php echo esc_html($read); ?>" data-unread="<?php echo esc_html($unread); ?>">
                                <input type="hidden" id="viewing_id" value="<?php echo absint($post_id); ?>">
                                <input type="hidden" id="viewing_user_status" value="<?php echo esc_html($user_status); ?>">
                                <input type="checkbox" id="viewing_read_status" class="read_status" name="read_status" checked="checked" value="1">
                                <label for="viewing_read_status" data-toggle="tooltip" data-placement="right" title="<?php echo esc_html($unread); ?>">
                                </label>
                                <script type="text/javascript">
                                    jQuery(document).ready(function () {
                                        if (jQuery('[data-toggle="tooltip"]').length != '') {
                                            jQuery('[data-toggle="tooltip"]').tooltip();
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="description-holder">
                    <?php
                    // Order/Inquiry buyer info.
                    $this->arrange_viewing_buyer_info($post_id);
                    ?>
                    <div class="order-detail-holder">
                        <strong class="heading">
                            <?php echo wp_rem_plugin_text_srt('wp_rem_member_arrange_viewing_detail'); ?>
                        </strong>
						<?php
                        // arrange viewing form field.
                        $this->arrange_viewing_form_fields($post_id);
                        ?>
                    </div>
                    <?php
                    // Order/Inquiry change status & read/unread.
                    $this->arrange_viewing_status_unread_ui($post_id);
                    ?>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
            wp_die();
        }
		
		public function arrange_viewing_buyer_info($post_id = '') {
            global $post;

            if ($post_id == '') {
                $post_id = $post->ID;
            }

            $wp_rem_viewing_user = get_post_meta($post_id, 'wp_rem_viewing_user', true);
            if ($wp_rem_viewing_user) {
                ?>
                <div class="customer-detail-holder">
                    <strong class="heading"><?php echo wp_rem_plugin_text_srt('wp_rem_order_detail_custom_detail'); ?></strong>
                    <?php if ($wp_rem_viewing_user != '') { ?>
                        <ul class="customer-detail">
                            <?php
                            $user_data = get_userdata($wp_rem_viewing_user);
                            $company_id = wp_rem_company_id_form_user_id($user_data->ID);
                            $phone_number = get_post_meta($company_id, 'wp_rem_phone_number', true);
                            $email_address = get_post_meta($company_id, 'wp_rem_email_address', true);
                            $address = get_post_meta($company_id, 'wp_rem_post_loc_address_member', true);
                            ?>
                            <li>
                                <strong><?php echo wp_rem_plugin_text_srt('wp_rem_enquiry_detail_custom_name'); ?></strong>
                                <span><?php echo esc_html( get_the_title( $company_id ) ); ?></span>
                            </li>
                            <?php if ('' != $phone_number) { ?>
                                <li>
                                    <strong><?php echo  wp_rem_plugin_text_srt('wp_rem_enquiry_detail_custom_phone_num')?></strong>
                                    <span><a href="tel:<?php echo esc_html($phone_number); ?>"><?php echo esc_html($phone_number); ?></a></span>
                                </li>
                            <?php } ?>
                            <?php if ('' != $email_address) { ?>
                                <li>
                                    <strong><?php  echo wp_rem_plugin_text_srt('wp_rem_enquiry_detail_custom_email'); ?></strong>
                                    <span><?php echo esc_html($email_address); ?></span>
                                </li>
                            <?php } ?>
                            <?php if ('' != $address) { ?>
                                <li>
                                    <strong><?php echo  wp_rem_plugin_text_srt('wp_rem_enquiry_detail_custom_address');?></strong>
                                    <span><?php echo esc_html($address); ?></span>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
                <?php
            }
        }
		public function arrange_viewing_form_fields($post_id = '') {
            global $post;

            if ($post_id == '') {
                $post_id = $post->ID;
            }
            $arrange_view_date = get_post_meta($post_id, 'wp_rem_arrange_view_date', true);
			$arrange_view_time = get_post_meta($post_id, 'wp_rem_arrange_view_time', true);
			$user_name = get_post_meta($post_id, 'wp_rem_user_name', true);
			$phone_number = get_post_meta($post_id, 'wp_rem_phone_number', true);
			$user_email = get_post_meta($post_id, 'wp_rem_user_email', true);
			$user_message = get_post_meta($post_id, 'wp_rem_user_message', true);
            
            if ($arrange_view_date || $arrange_view_time || $user_name || $phone_number || $user_email || $user_message) {
                ?>
                <ul class="order-detail">
					<?php if ($arrange_view_date || $arrange_view_time ){ ?>
						<li>
							<strong><?php echo wp_rem_plugin_text_srt('wp_rem_arrange_viewing_detail_date'); ?></strong>
							<span><?php echo date_i18n('d M Y', $arrange_view_date); ?> <?php echo date_i18n('h:m a', $arrange_view_time); ?></span>
						</li>
					<?php } ?>
					<?php if ($user_name ){ ?>
						<li>
							<strong><?php echo wp_rem_plugin_text_srt('wp_rem_arrange_viewing_detail_name'); ?></strong>
							<span><?php echo esc_html($user_name); ?></span>
						</li>
					<?php } ?>
					<?php if ($phone_number ){ ?>
						<li>
							<strong><?php echo wp_rem_plugin_text_srt('wp_rem_arrange_viewing_detail_phone'); ?></strong>
							<span><?php echo esc_html($phone_number); ?></span>
						</li>
					<?php } ?>
					<?php if ($user_email ){ ?>
						<li>
							<strong><?php echo wp_rem_plugin_text_srt('wp_rem_arrange_viewing_detail_email'); ?></strong>
							<span><?php echo esc_html($user_email); ?></span>
						</li>
					<?php } ?>
					<?php if ($user_message ){ ?>
						<li class="order-detail-message">
							<strong><?php echo wp_rem_plugin_text_srt('wp_rem_arrange_viewing_detail_msg'); ?></strong>
							<span><?php echo esc_html($user_message); ?></span>
						</li>
					<?php } ?>
                </ul>
                <?php
            }
        }

        public function arrange_viewing_status_unread_ui($post_id = '') {
            global $post, $wp_rem_plugin_options, $wp_rem_form_fields; 
            if ($post_id == '') {
                $post_id = $post->ID;
            }

            $property_member = get_post_meta($post_id, 'wp_rem_property_member', true);
            $viewing_member = get_post_meta($post_id, 'wp_rem_viewing_member', true);
            $user_id = get_current_user_id();
            $current_login_member = wp_rem_company_id_form_user_id($user_id);
			$viewing_status = get_post_meta($post_id, 'wp_rem_viewing_status', true);
            ?>
            <div class="order-status-read-unread-holder">
                <?php if ($property_member == $current_login_member) { ?>
                    <strong class="heading">
                        <?php
							echo wp_rem_plugin_text_srt('wp_rem_arrange_viewing_detail_status');
                        ?>
                    </strong>
                    <div class="input-field">
                        <?php
                        $orders_status = isset($wp_rem_plugin_options['orders_status']) ? $wp_rem_plugin_options['orders_status'] : '';
                        if (is_array($orders_status) && sizeof($orders_status) > 0) {
                            foreach ($orders_status as $key => $label) {
                                $drop_down_options[$label] = $label;
                            }
                        } else {
                            $drop_down_options = array(
                                'Processing' => wp_rem_plugin_text_srt('wp_rem_arrange_viewing_detail_procceing'),
                                'Completed' => wp_rem_plugin_text_srt('wp_rem_arrange_viewing_detail_completed'),
                            );
                        }
                        if ($viewing_status == 'Closed') {
                            $drop_down_options['Closed'] = wp_rem_plugin_text_srt('wp_rem_arrange_viewing_detail_closed');
                        }
						$wp_rem_opt_array = array();
                        $wp_rem_opt_array['std'] = $viewing_status;
                        $wp_rem_opt_array['cust_id'] = 'arrange-viewing-status';
                        $wp_rem_opt_array['cust_name'] = 'arrange-viewing-status';
                        $wp_rem_opt_array['options'] = $drop_down_options;
                        $wp_rem_opt_array['classes'] = 'chosen-select-no-single';
                        $wp_rem_opt_array['extra_atr'] = ' onchange="wp_rem_update_viewing_status(this, \'' . $post_id . '\', \'' . admin_url('admin-ajax.php') . '\')"';
                        $wp_rem_opt_array['return'] = false;

                        $wp_rem_form_fields->wp_rem_form_select_render($wp_rem_opt_array);
                        ?>
                    </div>
                    <script type="text/javascript">
                        jQuery(document).ready(function () {
                            chosen_selectionbox();
                        });
                    </script>
                <?php } else if ($viewing_member == $current_login_member && $viewing_status == 'Completed') { ?>
                    <div class="order-status-process viewing-status">
                        <p><?php echo wp_rem_plugin_text_srt('wp_rem_arrange_viewing_detail_arrange_viewing_completed') ?> <a href="javascript:void(0);" onclick="wp_rem_closed_arrange_viewing('<?php echo esc_html($post_id); ?>');"><?php echo wp_rem_plugin_text_srt('wp_rem_arrange_viewing_detail_closed_arrange_viewing'); ?></a></p>
                    </div>
                <?php } else if ($viewing_member == $current_login_member) { ?>
                    <div class="order-status-process viewing-status">
                        <p><?php echo wp_rem_plugin_text_srt('wp_rem_arrange_viewing_detail_arrange_viewing_is'). $viewing_status; ?></p>
                    </div>
                <?php } ?>
            </div>
            <?php
        }
		
		public function wp_rem_update_viewing_read_status_callback() {
            $json = array();

            $viewing_id = wp_rem_get_input( 'viewing_id', NULL, 'STRING' );
            $viewing_read_status = wp_rem_get_input( 'viewing_read_status', NULL, 'STRING' );
            $user_status = wp_rem_get_input( 'user_status', NULL, 'STRING' );

            if ( $viewing_id ) {
                if ( $user_status == 'seller' ) {
                    update_post_meta( $viewing_id, 'seller_read_status', $viewing_read_status );
                } else {
                    update_post_meta( $viewing_id, 'buyer_read_status', $viewing_read_status );
                }
                if ( $viewing_read_status == 0 ) {
                    $json['read_type'] = 'read';
                    $json['msg'] = wp_rem_plugin_text_srt('wp_rem_arrange_viewing_unread');
                } else {
                    $json['read_type'] = 'unread';
                    $json['msg'] = wp_rem_plugin_text_srt('wp_rem_arrange_viewing_read');
                }
            }
            echo json_encode( $json );
            wp_die();
        }
		
		public function wp_rem_update_viewing_status_callback() {
            $json = array();

            $viewing_id = wp_rem_get_input( 'viewing_id', NULL, 'STRING' );
            $viewing_status = wp_rem_get_input( 'viewing_status', NULL, 'STRING' );

            if ( $viewing_id && $viewing_status ) {
                update_post_meta( $viewing_id, 'wp_rem_viewing_status', $viewing_status );
				// Update Viewing status email
				do_action( 'wp_rem_viewing_status_updated_email', $viewing_id );
                $json['type'] = "success";
                $json['msg'] = wp_rem_plugin_text_srt('wp_rem_arrange_viewing_status_changed');
            } else {
                $json['type'] = "error";
                $json['msg'] = wp_rem_plugin_text_srt('wp_rem_arrange_viewing_status_changed');
            }
			echo json_encode( $json );
            exit();
        }

        public function wp_rem_closed_viewing_callback() {
            $json = array();

            $viewing_id = wp_rem_get_input( 'viewing_id', NULL, 'STRING' );
            update_post_meta( $viewing_id, 'wp_rem_viewing_status', 'Closed' );

            $json['type'] = "success";
            $json['msg'] = wp_rem_plugin_text_srt('wp_rem_arrange_viewing_status_closed');
            echo json_encode( $json );
            exit();
        }
	}

    global $wp_rem_arrange_viewing_detail;
    $wp_rem_arrange_viewing_detail = new Wp_rem_Arrange_Viewing_Detail();
}