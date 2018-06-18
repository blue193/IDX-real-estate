<?php
/**
 * File Type: Property Posted By
 */
if (!class_exists('wp_rem_posted_by')) {

    class wp_rem_posted_by {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action('wp_rem_posted_by_admin_fields', array($this, 'wp_rem_posted_by_admin_fields_callback'), 11);
            add_action('save_post', array($this, 'wp_rem_insert_posted_by'), 16);
			add_action('wp_ajax_wp_rem_property_back_members', array($this, 'wp_rem_property_back_members'));
			add_action('wp_ajax_wp_rem_load_all_members', array($this, 'wp_rem_load_all_members_callback'));
        }
        
        public function wp_rem_posted_by_admin_fields_callback(){
            global $wp_rem_html_fields, $wp_rem_form_fields, $post;
            
			$get_dir_member = get_post_meta($post->ID, 'wp_rem_property_member', true);
			$get_dir_user = get_post_meta($post->ID, 'wp_rem_property_username', true);
			
                        $wp_rem_users_list = array('' => wp_rem_plugin_text_srt( 'wp_rem_property_select_user' ));
			if( $get_dir_member != '' && is_numeric( $get_dir_member )){
				$wp_rem_users = get_users(
					array(
						'role' => 'wp_rem_member',
						'meta_query' => array(
							array(
								'key' => 'wp_rem_company',
								'value' => $get_dir_member,
								'compare' => '='
							),
						),
						'orderby' => 'display_name',
					)
				);
				foreach ($wp_rem_users as $user) {
					$wp_rem_users_list[$user->ID] = $user->display_name;
				}
			}elseif( $get_dir_user != '' && is_numeric( $get_dir_user ) ){			
				$user_info = get_userdata($get_dir_user);
				$wp_rem_users_list[$get_dir_user] = $user->display_name;
			}
			
			if( $get_dir_member != '' && is_numeric($get_dir_member)){
				$wp_rem_members_list = array( $get_dir_member => get_the_title($get_dir_member) );
			}else{
				$wp_rem_members_list = array( '' => wp_rem_plugin_text_srt( 'wp_rem_property_select_member' ) );
			}
			
			echo $wp_rem_html_fields->wp_rem_opening_field(array(
					'id' => 'property_member',
					'name' => wp_rem_plugin_text_srt('wp_rem_property_select_member'),
					'label_desc' => '',
				)
			);
			
				echo '<div class="property_members_holder" onclick="wp_rem_load_all_members(\'property_members_holder\', \''. $get_dir_member .'\');">';
					$wp_rem_opt_array = array(
						'std' => $get_dir_member,
						'force_std' => true,
						'id' => 'property_member',
						'extra_atr' => 'onchange="wp_rem_show_company_users(this.value, \''.admin_url('admin-ajax.php').'\', \''.wp_rem::plugin_url().'\');"',
						'classes' => 'chosen-select-no-single',
						'options' => $wp_rem_members_list,
						'markup' => '<span class="members-loader"></span>',
						'return' => false,
					);
					$wp_rem_form_fields->wp_rem_form_select_render($wp_rem_opt_array);
				echo '</div>';
			echo $wp_rem_html_fields->wp_rem_closing_field(array('desc' => ''));

			$wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt( 'wp_rem_property_select_user' ),
                'desc' => '',
                'hint_text' => '',
				'col_id' => 'property_user_member_col',
                'echo' => true,
                'field_params' => array(
                    'std' => $get_dir_user,
					'force_std' => true,
                    'id' => 'property_username',
                    'classes' => 'chosen-select-no-single',
                    'options' => $wp_rem_users_list,
                    'return' => true,
                ),
            );
            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
		
		}
		
		public function wp_rem_load_all_members_callback(){
			global $wp_rem_form_fields;
			
			$selected_member = wp_rem_get_input('selected_member', '', 'STRING');
			$wp_rem_members_list = array( '' => wp_rem_plugin_text_srt( 'wp_rem_property_select_member' ) );
			$args = array( 'posts_per_page' => '-1', 'post_type' => 'members', 'orderby' => 'title', 'post_status' => 'publish', 'order' => 'ASC' );
			$cust_query = get_posts($args);
			if ( is_array($cust_query) && sizeof($cust_query) > 0 ) {
				foreach ( $cust_query as $package_post ) {
					if ( isset($package_post->ID) ) {
						$package_id = $package_post->ID;
						$package_title = $package_post->post_title;
						$wp_rem_members_list[$package_id] = $package_title;
					}
				}
			}
			
			$wp_rem_opt_array = array(
				'std' => $selected_member,
				'force_std' => true,
				'id' => 'property_member',
				'extra_atr' => 'onchange="wp_rem_show_company_users(this.value, \''.admin_url('admin-ajax.php').'\', \''.wp_rem::plugin_url().'\');"',
				'classes' => 'chosen-select-no-single',
				'options' => $wp_rem_members_list,
				'return' => true,
            );
            $html = $wp_rem_form_fields->wp_rem_form_select_render($wp_rem_opt_array);
			$html .= '<script type="text/javascript">
				jQuery(document).ready(function () {
					chosen_selectionbox();
				});
			</script>';
			echo json_encode(array('html' => $html));
			die;
		}


		public function wp_rem_property_back_members(){
			global $wp_rem_form_fields;
			
            $company = isset($_POST['company']) ? $_POST['company'] : '';
			$wp_rem_users_list = array('' => wp_rem_plugin_text_srt( 'wp_rem_property_select_user' ));
            $wp_rem_users = get_users(
				array(
					'role' => 'wp_rem_member',
					'meta_query' => array(
						array(
							'key' => 'wp_rem_company',
							'value' => $company,
							'compare' => '='
						),
					),
					'orderby' => 'display_name',
				)
			);
						
            foreach ($wp_rem_users as $user) {
                $wp_rem_users_list[$user->ID] = $user->display_name;
			}
			
			$wp_rem_opt_array = array(
				'std' => '',
				'id' => 'property_username',
				'extra_atr' => '',
				'classes' => 'chosen-select-no-single',
				'options' => $wp_rem_users_list,
				'return' => true,
            );
            
            $html = $wp_rem_form_fields->wp_rem_form_select_render($wp_rem_opt_array);
			
			echo json_encode(array('html' => $html));
			die;
        }
        
        public function wp_rem_insert_posted_by( $post_id ){
            if( isset( $_POST['user_profile_data'] ) ){
                update_post_meta( $post_id, 'wp_rem_user_profile_data', $_POST['user_profile_data'] );
            }
        }
        
    }
    global $wp_rem_posted_by;
    $wp_rem_posted_by    = new wp_rem_posted_by();
}