<?php

// Direct access not allowed.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * File Type: WP Real Estate Manager Email
 */
if (!class_exists('Wp_rem_Email')) {

    class Wp_rem_Email {

        public $email_post_type_name;

        /**
         * Start construct Functions
         */
        public function __construct() {

            $this->email_post_type_name = 'emails';
            add_action('init', array($this, 'register_post_type_callback'));
            add_action('add_meta_boxes', array($this, 'add_metabox_callback'));
            add_action('wp_ajax_process_emails', array($this, 'process_emails_callback'), 20);
            add_action('wp_ajax_nopriv_process_emails', array($this, 'process_emails_callback'), 20);

            add_filter('wp_rem_plugin_option_smtp_tab', array($this, 'create_plugin_option_smtp_tab'), 10, 1);
            add_filter('wp_rem_smtp_plugin_options', array($this, 'create_smtp_plugin_options'), 10, 1);
            add_action('phpmailer_init', array($this, 'phpmailer_init_callback'), 10, 1);
            add_action('wp_ajax_send_smtp_mail', array($this, 'send_smtp_mail_callback'));
            add_action('wp_rem_send_mail', array($this, 'send_mail_callback'), 20, 1);
            add_filter('wp_mail_from_name', array($this, 'wp_mail_from_name_callback'), 10, 1);
            add_action('do_meta_boxes', array($this, 'remove_post_boxes'));
            add_filter('post_row_actions', array($this, 'remove_row_actions'), 10, 2);
            add_filter('manage_emails_posts_columns', array($this, 'set_custom_edit_columns'));
            add_action('manage_emails_posts_custom_column', array($this, 'custom_column'), 10, 2);
			add_filter('manage_edit-movie_sortable_columns', array($this, 'my_movie_sortable_columns'));
			
			// Custom Sort Columns
			add_filter( 'manage_edit-emails_sortable_columns', array($this, 'wp_rem_emails_sortable'));
			add_filter( 'request', array($this, 'wp_rem_emails_sortable_orderby'));
        }
		
        public function register_post_type_callback() {
            $labels = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_class_email_name'),
                'singular_name' => wp_rem_plugin_text_srt('wp_rem_class_email_singular_name'),
                'menu_name' => wp_rem_plugin_text_srt('wp_rem_class_email_menu_name'),
                'name_admin_bar' => wp_rem_plugin_text_srt('wp_rem_class_email_name_adminbar'),
                'add_new' => wp_rem_plugin_text_srt('wp_rem_class_email_addnew'),
                'add_new_item' => wp_rem_plugin_text_srt('wp_rem_add_new_email'),
                'new_item' => wp_rem_plugin_text_srt('wp_rem_new_email'),
                'edit_item' => wp_rem_plugin_text_srt('wp_rem_edit_email'),
                'view_item' => wp_rem_plugin_text_srt('wp_rem_view_email'),
                'all_items' => wp_rem_plugin_text_srt('wp_rem_sent_emails'),
                'search_items' => wp_rem_plugin_text_srt('wp_rem_search_emails'),
                'parent_item_colon' => wp_rem_plugin_text_srt('wp_rem_parent_emails'),
                'not_found' => wp_rem_plugin_text_srt('wp_rem_no_emails_found'),
                'not_found_in_trash' => wp_rem_plugin_text_srt('wp_rem_no_emails_found_in_trash')
            );
            $args = array(
                'labels' => $labels,
                'description' => wp_rem_plugin_text_srt('wp_rem_property_services_description'),
                'public' => false,
                'publicly_queryable' => false,
                'show_ui' => true,
                'show_in_menu' => 'edit.php?post_type=jh-templates',
                'query_var' => false,
                'rewrite' => array('slug' => 'emails'),
                'capability_type' => 'post',
                'has_archive' => false,
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title', 'editor'),
                'capabilities' => array(
                    'create_posts' => false,
                ),
                'map_meta_cap' => true,
            );
            register_post_type($this->email_post_type_name, $args);
        }

        function set_custom_edit_columns($columns) {
            //unset($columns['title']);
            unset($columns['date']);
			$columns['sent_to'] = wp_rem_plugin_text_srt('wp_rem_class_email_column_sent_to');
            $columns['email_status'] = wp_rem_plugin_text_srt('wp_rem_class_email_column_email_status');
            $columns['email_headers'] = wp_rem_plugin_text_srt('wp_rem_class_email_column_email_headers');
			$columns['email_response'] = wp_rem_plugin_text_srt('wp_rem_mailer_response');
            return $columns;
        }

        function custom_column($column, $post_id) {
            switch ($column) {
				case 'sent_to' :
                    $sent_to = get_post_meta($post_id, 'email_send_to', true);
                    if ( isset( $sent_to ) && $sent_to != '' ) {
						$user = get_user_by( 'email', $sent_to );
						$user_id = '';
						if( !empty($user )){
							$user_id = $user->ID;
						}
						if ( $user_id !== '' ) {
							echo '<a href="'. esc_url(get_edit_user_link( $user_id )) .'">'. esc_html( $sent_to ) .'</a>';
						}else{
							echo esc_html( $sent_to );
						}
					} else {
						echo '-';
					}
                    break;
				case 'email_status' :
                    $email_status = get_post_meta($post_id, 'email_status', true);
					if( $email_status == 'processed' ){
						echo wp_rem_plugin_text_srt('wp_rem_email_processed');
					}else{
						echo esc_html($email_status);
					}
                    break;
				case 'email_headers' :
                    $email_headers = get_post_meta($post_id, 'email_headers', true);
                    if (isset($email_headers[0])) {
                        echo ($email_headers[0]);
                    } else {
                        echo '-';
                    }
                    break;
				case 'email_response' :
					$mailer_response = get_post_meta($post_id, 'mailer_response', true);
                    if (isset($mailer_response[0]) && $mailer_response[0] != '') {
                        echo esc_html($mailer_response[0]);
                    } else {
                        echo '-';
                    }
                    break;
            }
        }

        public function wp_rem_emails_sortable($columns) {
			$columns['sent_to'] = 'sent_to';
			$columns['email_status'] = 'email_status';
			$columns['email_response'] = 'email_response';
			return $columns;
        }
		
		public function wp_rem_emails_sortable_orderby(  $vars ){
			if ( isset( $vars['orderby'] ) && 'sent_to' == $vars['orderby'] ) {
				$vars = array_merge( $vars, array(
					'meta_key' => 'email_send_to',
					'orderby' => 'meta_value',
				) );
				
			}
			if ( isset( $vars['orderby'] ) && 'email_status' == $vars['orderby'] ) {
				$vars = array_merge( $vars, array(
					'meta_key' => 'email_status',
					'orderby' => 'meta_value',
				) );
				
			}
			if ( isset( $vars['orderby'] ) && 'email_response' == $vars['orderby'] ) {
				$vars = array_merge( $vars, array(
					'meta_key' => 'mailer_response',
					'orderby' => 'meta_value',
				) );
				
			}
			return $vars;
		}

        public function remove_row_actions($actions, $post) {
            add_thickbox();  
			if (get_post_type() === 'emails') {
                $actions = array(
                    'content' => '<a href="#TB_inline?width=600&height=800&inlineId=email-content-popup-' . $post->ID . '" class="thickbox">'.wp_rem_plugin_text_srt('wp_rem_email_content_link_text').'</a> <div style="display:none;" id="email-content-popup-' . $post->ID . '">'
                    . '' .  get_the_content($post->ID).''
                    . '</div>',
                    'delete' => '<a>'. wp_rem_plugin_text_srt('wp_rem_property_delete') .'</a>',
                );
            }

            return $actions;
        }

        public function add_metabox_callback() {
            add_meta_box(
                    'email-details', wp_rem_plugin_text_srt('wp_rem_email_details'), array($this, 'render_email_details_metabox'), $this->email_post_type_name, 'advanced', 'default'
            );
        }

        public function render_email_details_metabox($post) {
            if (isset($post)) {
                $post_id = $post->ID;
                $meta = array(
                    'email_send_to' => array('title' => wp_rem_plugin_text_srt('wp_rem_sent_to'), ''),
                    'email_status' => array('title' => wp_rem_plugin_text_srt('wp_rem_email_status'), ''),
                    'email_headers' => array('title' => wp_rem_plugin_text_srt('wp_rem_email_headers'), ''),
                    'mailer_response' => array('title' => wp_rem_plugin_text_srt('wp_rem_mailer_response'), ''),
                );
                echo '<table>';
                foreach ($meta as $key => $val) {
                    echo '<tr>';
                    echo '<td>' . $val['title'] . '</td>';
                    echo '<td>';
                    $val = get_post_meta($post_id, $key, true);
                    if (is_array($val)) {
                        echo implode(', ', $val);
                    } else {
                        echo wp_rem_allow_special_char($val);
                    }
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
        }

        public function save_email($args) {
            // Create post object
            $email_post = array(
                'post_title' => $args['subject'],
                'post_content' => $args['message'],
                'post_status' => 'publish',
                'post_type' => $this->email_post_type_name,
            );

            // Insert the post into the database.
            $id = wp_insert_post($email_post);

            if (!is_wp_error($id)) {
                update_post_meta($id, 'email_status', 'new');
                update_post_meta($id, 'email_headers', $args['headers']);
                update_post_meta($id, 'email_send_to', $args['sent_to']);
                update_post_meta($id, 'email_type', $args['email_type']);
                return $id;
            } else {
                return 0;
            }
        }

        public function process_emails_callback($die = true) {
			
			$args = array(
                'post_type' => $this->email_post_type_name
            );
            $post_id = isset($_REQUEST['email_id']) ? $_REQUEST['email_id'] : 0;
            // if ($post_id != 0) {
            //     $args = array(
            //         'post__in' => array(intval($post_id)),
            //     );
            // }
            $args['meta_key'] = 'email_status';
            $args['meta_query'] = array(
                'value' => 'new',
                'compare' => 'LIKE',
            );


            $query = new WP_Query($args);
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $wp_rem_post_id = get_the_ID();
                    $wp_rem_subject = get_the_title();
                    $wp_rem_message = get_the_content();
                    $wp_rem_send_to = get_post_meta($wp_rem_post_id, 'email_send_to', true);
                    $wp_rem_headers = get_post_meta($wp_rem_post_id, 'email_headers', true);
                    $wp_rem_email_type = get_post_meta($wp_rem_post_id, 'email_type', true);
                    if (!empty($wp_rem_email_type)) {
                        if ($wp_rem_email_type == 'html') {
                            add_filter('wp_mail_content_type', function () {
                                return 'text/html';
                            });
                        } else {
                            add_filter('wp_mail_content_type', function () {
                                return 'text/plain';
                            });
                        }
                    }
					
                    $wp_rem_confirm = wp_mail($wp_rem_send_to, $wp_rem_subject, $wp_rem_message, $wp_rem_headers);
                    update_post_meta($wp_rem_post_id, 'email_status', 'processed');
                    update_post_meta($wp_rem_post_id, 'mailer_response', $wp_rem_confirm + "");
                }
                wp_reset_postdata();
            } else {
                echo wp_rem_plugin_text_srt('wp_rem_no_posts_found');
            }
            if ($die) {
                wp_die();
            }
        }

        /**
          @return array Smtp plugin option fields.
         */
        public function create_plugin_option_smtp_tab($wp_rem_setting_options) {
            $wp_rem_setting_options[] = array(
                "name" => wp_rem_plugin_text_srt('wp_rem_smtp_configuration'),
                "fontawesome" => 'icon-email',
                "id" => "tab-smtp-configuration",
                "std" => "",
                "type" => "main-heading",
                "options" => ''
            );
            return $wp_rem_setting_options;
        }

        /**
          @return array Smtp plugin option fields.
         */
        public function create_smtp_plugin_options($wp_rem_setting_options) {



            $on_off_option = array('yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'), 'no' => wp_rem_plugin_text_srt('wp_rem_property_no'));

            $wp_rem_setting_options[] = array(
                "name" => wp_rem_plugin_text_srt('wp_rem_smtp_configuration'),
                "id" => "tab-smtp-configuration",
                "extra" => 'class="wp_rem_tab_block" data-title="' . wp_rem_plugin_text_srt('wp_rem_smtp_configuration') . '"',
                "type" => "sub-heading",
            );

            $wp_rem_setting_options[] = array("name" => wp_rem_plugin_text_srt('wp_rem_smtp_configuration'),
                "id" => "tab-settings-smtp-configuration",
                "std" => wp_rem_plugin_text_srt('wp_rem_smtp_configuration'),
                "type" => "section",
                "options" => ""
            );

            $wp_rem_setting_options[] = array("col_heading" => wp_rem_plugin_text_srt('wp_rem_smtp_configuration'),
                "type" => "tab-smtp",
                "help_text" => ""
            );
            $wp_rem_setting_options[] = array("name" => wp_rem_plugin_text_srt('wp_rem_smtp_enable_smtp'),
                "desc" => "",
                "hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_smtp_enable_smtp_hint'),
                "id" => "use_smtp_mail",
                "std" => "",
                "type" => "checkbox",
                "onchange" => "use_smtp_mail_opt(this)",
                "options" => $on_off_option,
            );

            $wp_rem_setting_options[] = array(
                "type" => "division",
                "enable_id" => "wp_rem_use_smtp_mail",
                "enable_val" => "on",
                "extra_atts" => 'id="wp-rem-no-smtp-div"',
            );

            $wp_rem_setting_options[] = array("name" => wp_rem_plugin_text_srt('wp_rem_smtp_authentication'),
                "desc" => "",
                "hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_smtp_authentication_hint'),
                "id" => "use_smtp_auth",
                "std" => "",
                "type" => "checkbox",
            );

            $wp_rem_setting_options[] = array("name" => wp_rem_plugin_text_srt('wp_rem_smtp_host_name'),
                "desc" => "",
                "hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_smtp_host_name_hint'),
                "id" => "smtp_host",
                "std" => "",
                "classes" => "wp-rem-dev-req-field-admin",
                'extra_attr' => 'data-visible="wp-rem-no-smtp-div"',
                "type" => "text",
            );

            $wp_rem_setting_options[] = array("name" => wp_rem_plugin_text_srt('wp_rem_smtp_port'),
                "desc" => "",
                "hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_smtp_port_hint'),
                "id" => "smtp_port",
                "std" => "",
                "type" => "text",
            );

            $wp_rem_setting_options[] = array("name" => wp_rem_plugin_text_srt('wp_rem_connection_prefix'),
                "desc" => "",
                "hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_connection_prefix_hint'),
                "id" => "secure_connection_type",
                "cust_name" => "mail_set_return_path",
                "std" => "true",
                "classes" => "chosen-select",
                "type" => "select",
                "options" => array('ssl' => 'ssl', 'tls' => 'tls'),
            );

            $wp_rem_setting_options[] = array("name" => wp_rem_plugin_text_srt('wp_rem_smtp_username'),
                "desc" => "",
                "hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_smtp_username_hint'),
                "id" => "smtp_username",
                "std" => "",
                "type" => "text",
            );
            $wp_rem_setting_options[] = array("name" => wp_rem_plugin_text_srt('wp_rem_smtp_password'),
                "desc" => "",
                "hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_smtp_password_hint'),
                "id" => "smtp_password",
                "std" => "",
                "type" => "password",
            );

            $wp_rem_setting_options[] = array("name" => wp_rem_plugin_text_srt('wp_rem_wordwrap_length'),
                "desc" => "",
                "hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_wordwrap_length_hint'),
                "id" => "wordwrap_length",
                "std" => "",
                "type" => "text",
            );

            $wp_rem_setting_options[] = array("name" => wp_rem_plugin_text_srt('wp_rem_enable_debuggin'),
                "desc" => "",
                "hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_enable_debuggin_hint'),
                "id" => "smtp_debugging",
                "std" => "",
                "type" => "checkbox",
            );

            $wp_rem_setting_options[] = array("name" => wp_rem_plugin_text_srt('wp_rem_sender_email'),
                "desc" => "",
                "hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_sender_email_hint'),
                "id" => "smtp_sender_email",
                "std" => "",
                "type" => "text",
            );

            $wp_rem_setting_options[] = array("name" => wp_rem_plugin_text_srt('wp_rem_sender_name'),
                "desc" => "",
                "hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_sender_name_hint'),
                "id" => "sender_name",
                "std" => "",
                "type" => "text",
            );

            $wp_rem_setting_options[] = array("name" => wp_rem_plugin_text_srt('wp_rem_test_email'),
                "desc" => "",
                "hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_test_email_hint'),
                "id" => "test_email",
                "std" => "",
                "type" => "text",
                "extra_attr" => " placeholder='" . wp_rem_plugin_text_srt('wp_rem_test_email_placeholder') . "'",
            );

            $wp_rem_setting_options[] = array("name" => '',
                "desc" => "",
                "hint_text" => '',
                "id" => "submit_test_email",
                "std" => wp_rem_plugin_text_srt('wp_rem_sender_send_test'),
                "type" => "text",
                "cust_type" => "button",
            );

            $wp_rem_setting_options[] = array(
                "type" => "division_close",
            );

            $wp_rem_setting_options[] = array("col_heading" => wp_rem_plugin_text_srt('wp_rem_smtp_settings'),
                "type" => "col-right-text",
                "help_text" => ""
            );

            return $wp_rem_setting_options;
        }

        /**
         * @param    PHPMailer    $phpmailer    A reference to the current instance of PHP Mailer
         */
        public function phpmailer_init_callback($phpmailer) {
            $options = get_option('wp_rem_plugin_options');
            // Don't configure for SMTP if no host is provided.
            if (empty($options['wp_rem_use_smtp_mail']) || $options['wp_rem_use_smtp_mail'] != 'on') {
                return;
            }
            $phpmailer->IsSMTP();
            $phpmailer->Host = isset($options['wp_rem_smtp_host']) ? $options['wp_rem_smtp_host'] : 'imap.gmail.com';
            $phpmailer->Port = isset($options['wp_rem_smtp_port']) ? $options['wp_rem_smtp_port'] : 25;
            $phpmailer->SMTPAuth = isset($options['wp_rem_use_smtp_auth']) ? $options['wp_rem_use_smtp_auth'] : false;
            if ($phpmailer->SMTPAuth) {
                $phpmailer->Username = isset($options['wp_rem_smtp_username']) ? $options['wp_rem_smtp_username'] : 'admin';
                $phpmailer->Password = isset($options['wp_rem_smtp_password']) ? $options['wp_rem_smtp_password'] : 'admin';
            }
            if ($options['wp_rem_secure_connection_type'] != '')
                $phpmailer->SMTPSecure = isset($options['wp_rem_secure_connection_type']) ? $options['wp_rem_secure_connection_type'] : 'ssl';
            if ($options['wp_rem_smtp_sender_email'] != '')
                $phpmailer->SetFrom($options['wp_rem_smtp_sender_email'], $options['wp_rem_sender_name']);
            if ($options['wp_rem_wordwrap_length'] > 0)
                $phpmailer->WordWrap = isset($options['wp_rem_wordwrap_length']) ? $options['wp_rem_wordwrap_length'] : '20';
            if ($options['wp_rem_smtp_debugging'] == "on" && isset($_POST['action']) && $_POST['action'] == 'send_smtp_mail')
                $phpmailer->SMTPDebug = true;
        }

        public function send_smtp_mail_callback() {
            $user = wp_get_current_user();
            $options = get_option('wp_rem_plugin_options');
            $email = $user->user_email;
            $email = (isset($options['wp_rem_test_email']) && $options['wp_rem_test_email'] != '') ? $options['wp_rem_test_email'] : $email;
            $subject = wp_rem_plugin_text_srt('wp_rem_test_mail');
            $timestamp = current_time('mysql');
            $message = sprintf(wp_rem_plugin_text_srt('wp_rem_plugin_emailing_test'), 'wp-rem');
            $message .= "\n\n";
            $wp_rem_from_name = isset($options['wp_rem_sender_name']) ? $options['wp_rem_sender_name'] : '';
            $wp_rem_from_email = isset($options['wp_rem_smtp_sender_email']) ? $options['wp_rem_smtp_sender_email'] : '';
            $headers[] = 'From:' . $wp_rem_from_name . ' <' . $wp_rem_from_email . '>';
            $array = array('to' => $email, 'subject' => $subject, 'message' => $message, 'headers' => $headers);
            do_action('wp_rem_send_mail', $array);

            // Check success
            global $phpmailer;
            if ($phpmailer->ErrorInfo != "") {
                $error_msg = '<div class="error"><p>' . wp_rem_plugin_text_srt('wp_rem_an_error') . '</p>';
                $error_msg .= '<blockquote style="font-weight:bold;">';
                $error_msg .= '<p>' . $phpmailer->ErrorInfo . '</p>';
                $error_msg .= '</p></blockquote>';
                $error_msg .= '</div>';
            } else {
                $error_msg = '<div class="updated"><p>' . wp_rem_plugin_text_srt('wp_rem_test_email_sent') . '</p>';
                $error_msg .= '<p>' . sprintf(wp_rem_plugin_text_srt('wp_rem_body_of_test_email'), $timestamp) . '</p></div>';
            }
            echo htmlspecialchars_decode($error_msg);
            exit;
        }

        /*
         * Send Mail through SMTP if configured.
         * Allowed array parameters: 
         * array('to' => $email, 'subject' => $subject, 'message' => $message, 'headers' => $headers')
         */

        public function send_mail_callback($args) {
			global $wp_rem_plugin_options;
			$wp_rem_email_logs = isset( $wp_rem_plugin_options['wp_rem_email_logs'] ) ? $wp_rem_plugin_options['wp_rem_email_logs'] : '';
		
            $wp_rem_send_to = (isset($args['to'])) ? $args['to'] : '';
            $wp_rem_subject = (isset($args['subject'])) ? $args['subject'] : '';
            $wp_rem_message = (isset($args['message'])) ? $args['message'] : '';
            $wp_rem_headers = array();
            if (isset($args['from']) && $args['from'] != '') {
                $wp_rem_headers[] = 'From: ' . $args['from'];
            }

            $email_type = 'plain_text';
            if (isset($args['email_type'])) {
                $email_type = $args['email_type'];
            }

            $wp_rem_headers = ( isset($args['headers']) ) ? $args['headers'] : $wp_rem_headers;
            $class_obj = ( isset($args['class_obj']) ) ? $args['class_obj'] : '';

            $post_id = $this->save_email(array(
                'sent_to' => $wp_rem_send_to,
                'subject' => $wp_rem_subject,
                'message' => $wp_rem_message,
                'headers' => $wp_rem_headers,
                'email_type' => $email_type,
            ));

            if ($post_id != 0) {
                $_REQUEST['email_id'] = $post_id;
                $_REQUEST['post_id'] = $post_id;
                $this->process_emails_callback(false);
            }

            if ($class_obj != '') {
                $class_obj->is_email_sent = true;
            }
			
			if( $wp_rem_email_logs != 'on' && $post_id != '' && is_numeric($post_id) && get_post_type($post_id) == $this->email_post_type_name ){
				wp_delete_post($post_id);
				delete_post_meta($post_id);
			}
        }

        /**
          @return string The name from which the email is being sent.
         */
        public function wp_mail_from_name_callback($original_email_from) {
            $options = get_option('wp_rem_plugin_options');
            // Don't configure for SMTP if no host is provided.
            if (empty($options['wp_rem_use_smtp_mail']) || $options['wp_rem_use_smtp_mail'] != 'on' || $options['wp_rem_sender_name'] == '') {
                return get_bloginfo('name');
            } else {
                return $options['wp_rem_sender_name'];
            }
        }

        //remove extra boxes
        public function remove_post_boxes() {
            remove_meta_box('mymetabox_revslider_0', 'emails', 'normal');
        }

    }

    $wp_rem_email = new Wp_rem_Email();
}

if ( ! function_exists( 'wp_rem_remove_a_from_emails' ) ) {

    add_action( 'admin_footer-edit.php', 'wp_rem_remove_a_from_emails' );

    function wp_rem_remove_a_from_emails() {
		if ( get_post_type() == 'emails' ) {
			?>
			<script type="text/javascript">
				jQuery('table.wp-list-table a.row-title').contents().unwrap();
			</script>
			<?php
		}
    }

}