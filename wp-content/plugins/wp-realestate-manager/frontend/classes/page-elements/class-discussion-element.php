<?php
/**
 * File Type: Services Page Element
 */
if ( ! class_exists( 'wp_rem_discussion_element' ) ) {

	class wp_rem_discussion_element {

		/**
		 * Start construct Functions
		 */
		public function __construct() {
			add_action( 'wp_ajax_wp_rem_discussion_submit', array( $this, 'wp_rem_discussion_submit_callback' ), 10, 2 );
			add_action( 'wp_ajax_nopriv_wp_rem_discussion_submit', array( $this, 'wp_rem_discussion_submit_callback' ), 10, 2 );
			add_action( 'wp_rem_discussion_list', array( $this, 'wp_rem_discussion_list_callback' ), 1 );
			add_action( 'wp_ajax_wp_rem_update_enquiry_status', array( $this, 'wp_rem_update_enquiry_status_callback' ), 10 );
			add_action( 'wp_ajax_wp_rem_update_enquiry_read_status', array( $this, 'wp_rem_update_enquiry_read_status_callback' ), 10 );
			add_action( 'wp_ajax_wp_rem_closed_enquiry', array( $this, 'wp_rem_closed_enquiry_callback' ), 10 );
		}

		public function wp_rem_discussion_submit_callback() {
			global $post;
			$current_user = wp_get_current_user();

			$json = array();
			$json['empty'] = false;
			if ( 0 == $current_user->ID ) {
				$json['type'] = "error";
				$json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_discussion_login_post_comment' );
				echo json_encode( $json );
				exit();
			}

			$comment_post_ID = wp_rem_get_input( 'comment_post_ID', NULL, 'STRING' );
			$comment_member = wp_rem_get_input( 'comment_member', NULL, 'STRING' );
			$current_login_member = wp_rem_company_id_form_user_id( $current_user->ID );

			$property_member = get_post_meta( $comment_post_ID, 'wp_rem_property_member', true );
			$enquiry_member = get_post_meta( $comment_post_ID, 'wp_rem_enquiry_member', true );
			$order_type_string = wp_rem_plugin_text_srt( 'wp_rem_discussion_enquiry' );

			$message = wp_rem_get_input( 'message', NULL, 'STRING' );
			if ( '' == $message ) {
				$json['empty'] = true;
				$json['type'] = "error";
				$json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_discussion_enter_message' );
				echo json_encode( $json );
				exit();
			}

			if ( $current_login_member == $property_member || $current_login_member == $enquiry_member ) {

				$order_status = get_post_meta( $comment_post_ID, 'wp_rem_order_status', true );

				if ( $order_status == 'Closed' ) {
					$json['type'] = "error";
					$json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_discussion_not_send_discussion_closed' );
					echo json_encode( $json );
					exit();
				}

				if ( true !== Wp_rem_Member_Permissions::check_permissions( 'enquiries' ) ) {
					$json['type'] = "error";
					$json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_discussion_not_send_discussion_permission' );
					echo json_encode( $json );
					exit();
				}

				$time = current_time( 'mysql' );
				$data = array(
					'comment_post_ID' => $comment_post_ID,
					'comment_author' => $current_user->display_name,
					'comment_author_email' => $current_user->user_email,
					'comment_author_url' => '',
					'comment_content' => $message,
					'comment_type' => '',
					'comment_parent' => 0,
					'user_id' => $current_user->ID,
					'comment_author_IP' => $this->get_the_user_ip(),
					'comment_member' => $this->get_the_user_member(),
					'comment_date' => $time,
					'comment_approved' => 1,
				);

				// check comment already added or not.
				$this->comment_validation( $data );
				// insert new comment
				$comment_id = wp_insert_comment( $data );
				update_comment_meta( $comment_id, 'comment_member', $comment_member );

				// added last post comment in comments list.
				$args = array(
					'post_id' => $comment_post_ID,
					'comment__in' => array( $comment_id ),
					'status' => 'approve',
				);
				$comments = get_comments( $args );
				foreach ( $comments as $comment ) {
					$json['comments_count'] = get_comments_number( $comment_post_ID );
					;
					$json['comments_number'] = $this->wp_rem_comments_number( $comment_post_ID );
					$json['new_comment'] = $this->wp_rem_discussion_list_items( $comments );
				}

				$sender_id = $current_login_member;
				$member_name = get_the_title( $sender_id );
				if ( $current_login_member == $property_member ) {
					$reciever_id = $enquiry_member;
					update_post_meta( $comment_post_ID, 'buyer_read_status', '0' );
				} else {
					$reciever_id = $property_member;
					update_post_meta( $comment_post_ID, 'seller_read_status', '0' );
				}


				/*
				 * Adding Notification
				 */
				$notification_type = 'enquiry';
				$notification_array = array(
					'type' => $notification_type,
					'element_id' => $comment_post_ID,
					'sender_id' => $sender_id,
					'reciever_id' => $reciever_id,
					'message' => $member_name . ' ' . wp_rem_plugin_text_srt( 'wp_rem_discussion_sent_you_message' ) . ' <a href="javascript:void();" onclick="javascript:wp_rem_enquiry_detail(\'' . $comment_post_ID . '\',\'my\');">' . wp_trim_words( get_the_title( $comment_post_ID ), 5 ) . '</a> .',
				);
				do_action( 'wp_rem_add_notification', $notification_array );


				$json['type'] = "success";
				$json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_discussion_sent_successfully' );
				echo json_encode( $json );
				exit();
			} else {
				$json['type'] = "error";
				$json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_discussion_not_send_discussion_against' );
				echo json_encode( $json );
				exit();
			}

			echo json_encode( $json );
			wp_die();
		}

		public function comment_validation( $commentdata ) {
			global $wpdb;

			$json = array();
			$cs_danger_html = '<div class="alert alert-danger"><button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button><p><i class="icon-warning4"></i>';
			$cs_success_html = '<div class="alert alert-success"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button><p><i class="icon-checkmark6"></i>';
			$cs_msg_html = '</p></div>';

			$dupe = $wpdb->prepare(
					"SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = %d AND comment_parent = %s AND comment_approved != 'trash' AND ( comment_author = %s ", wp_unslash( $commentdata['comment_post_ID'] ), wp_unslash( $commentdata['comment_parent'] ), wp_unslash( $commentdata['comment_author'] )
			);
			if ( $commentdata['comment_author_email'] ) {
				$dupe .= $wpdb->prepare(
						"AND comment_author_email = %s ", wp_unslash( $commentdata['comment_author_email'] )
				);
			}
			$dupe .= $wpdb->prepare(
					") AND comment_content = %s LIMIT 1", wp_unslash( $commentdata['comment_content'] )
			);

			$dupe_id = $wpdb->get_var( $dupe );
			$dupe_id = apply_filters( 'duplicate_comment_id', $dupe_id, $commentdata );
			if ( $dupe_id ) {
				$json['type'] = "error";
				$json['message'] = $cs_danger_html . wp_rem_plugin_text_srt( 'wp_rem_discussion_duplicate_message' ) . $cs_msg_html;
				echo json_encode( $json );
				exit();
			}
		}

		public function get_the_user_ip() {
			if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
				//check ip from share internet
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
				//to check ip is pass from proxy
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			return apply_filters( 'wpb_get_ip', $ip );
		}

		public function get_the_user_member() {
			return $_SERVER['HTTP_USER_MEMBER'];
		}

		public function wp_rem_discussion_list_callback( $post_id ) {
			global $post;

			if ( $post_id == '' ) {
				$post_id = $post->ID;
			}
			$args = array(
				'post_id' => $post_id,
				'status' => 'approve',
				'orderby' => 'ID',
				'order' => 'ASC',
			);
			$comments = get_comments( $args );
			?>
			<div class="order-discussions-holder">
				<?php if ( $comments ) { ?>
					<div class="order-discussions">
						<div class="element-title">
							<h3>
								<?php echo esc_html( $this->wp_rem_comments_number( $post_id ) ); ?>
							</h3>
						</div>
						<ul id="discussion-list" class="order-discussion-list">
							<?php echo force_balance_tags( $this->wp_rem_discussion_list_items( $comments ) ); ?>
						</ul>

					</div>
				<?php } ?>
			</div>
			<?php
		}

		public function wp_rem_comments_number( $comment_post_ID = '' ) {
			$comments_number = get_comments_number( $comment_post_ID );
			if ( 1 >= $comments_number ) {
				$comments = sprintf( wp_rem_plugin_text_srt( 'wp_rem_discussion_message' ), $comments_number );
			} else {
				$comments = sprintf( wp_rem_plugin_text_srt( 'wp_rem_discussion_messages' ), $comments_number );
			}
			return $comments;
		}

		public function wp_rem_discussion_list_items( $comments ) {
			global $post, $wp_rem_member_profile;
			$output = '';
			ob_start();
			foreach ( $comments as $comment ) {
				$login_user_id = get_current_user_id();
				$login_user_comapny_id = wp_rem_company_id_form_user_id( $comment_user_id );
				$user = get_user_by( 'email', $comment->comment_author_email );
				$comment_user_id = $user->ID;
				$member_id = wp_rem_company_id_form_user_id( $comment_user_id );
				$property_member = get_post_meta( $comment->comment_post_ID, 'wp_rem_property_member', true );
				$enquiry_member = get_post_meta( $comment->comment_post_ID, 'wp_rem_enquiry_member', true );
				$profile_image_id = $wp_rem_member_profile->member_get_profile_image( $user->ID );
				if ( $member_id == $property_member ) {
					$discussion_member_type = 'seller';
				} else if ( $member_id == $enquiry_member ) {
					$discussion_member_type = 'buyer';
				}
				?>
				<li class="<?php echo esc_html( $discussion_member_type ); ?>">
					<?php
					if ( isset( $profile_image_id ) && $profile_image_id !== '' ) {
						echo '<div class="img-holder">
								<figure><img src="' . esc_url( $profile_image_id ) . '" alt=""></figure>
						</div>';
					}
					?>
					<div class="text-holder">
						<div class="heading">
							<h5><?php
								if ( $login_user_comapny_id == $member_id ) {
									echo wp_rem_plugin_text_srt( 'wp_rem_discussion_message_me' );
								} else {
									echo get_the_title( $member_id );
								}
								?></h5>
							<span datetime="<?php echo date( 'Y/m/d', strtotime( $comment->comment_date ) ); ?>" class="post-date">
								<?php echo human_time_diff( strtotime( $comment->comment_date ), current_time( 'timestamp' ) ) . ' ' . wp_rem_plugin_text_srt( 'wp_rem_discussion_message_ago' ); ?>
							</span>
						</div>
						<?php echo apply_filters( 'the_content', $comment->comment_content ); ?>
					</div>
				</li>
				<?php
			}
			$output = ob_get_clean();
			return $output;
		}

		public function wp_rem_update_enquiry_read_status_callback() {
			$json = array();

			$enquiry_id = wp_rem_get_input( 'enquiry_id', NULL, 'STRING' );
			$enquiry_read_status = wp_rem_get_input( 'enquiry_read_status', NULL, 'STRING' );
			$user_status = wp_rem_get_input( 'user_status', NULL, 'STRING' );
			if ( $enquiry_id ) {
				if ( $user_status == 'seller' ) {
					update_post_meta( $enquiry_id, 'seller_read_status', $enquiry_read_status );
				} else {
					update_post_meta( $enquiry_id, 'buyer_read_status', $enquiry_read_status );
				}
				$json['type'] = "success";
				if ( $enquiry_read_status == 0 ) {
					$json['read_type'] = 'read';
					$json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_discussion_message_unread' );
				} else {
					$json['read_type'] = 'unread';
					$json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_discussion_message_read' );
				}
			}
			echo json_encode( $json );
			wp_die();
		}

		public function wp_rem_update_enquiry_status_callback() {
			$json = array();

			$enquiry_id = wp_rem_get_input( 'enquiry_id', NULL, 'STRING' );
			$enquiry_status = wp_rem_get_input( 'enquiry_status', NULL, 'STRING' );

			if ( $enquiry_id && $enquiry_status ) {
				update_post_meta( $enquiry_id, 'wp_rem_enquiry_status', $enquiry_status );
				// Update inquiry status email
				do_action( 'wp_rem_inquiry_status_updated_email', $enquiry_id );
				$json['type'] = "success";
				$json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_discussion_message_status_changed' );
			} else {
				$json['type'] = "error";
				$json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_discussion_message_status_not_changed' );
			}

			echo json_encode( $json );
			exit();
		}

		public function wp_rem_closed_enquiry_callback() {
			$json = array();

			$enquiry_id = wp_rem_get_input( 'enquiry_id', NULL, 'STRING' );
			update_post_meta( $enquiry_id, 'wp_rem_enquiry_status', 'Closed' );
			$json['type'] = "success";
			$json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_discussion_message_status_closed' );
			echo json_encode( $json );
			exit();
		}

	}

	global $wp_rem_discussion_element;
	$wp_rem_discussion_element = new wp_rem_discussion_element();
}