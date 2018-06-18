<?php

/**
 * Compare properties class
 * 
 * @return Compare functionalities
 */
if ( ! class_exists('wp_rem_compare_properties') ) {

	class wp_rem_compare_properties {

		public function __construct() {
			add_action('wp_ajax_wp_rem_compare_add', array( $this, 'wp_rem_compare_add' ));
			add_action('wp_ajax_nopriv_wp_rem_compare_add', array( $this, 'wp_rem_compare_add' ));
			
			add_action('wp_ajax_wp_rem_removing_compare', array( $this, 'wp_rem_removing_compare' ));
			add_action('wp_ajax_nopriv_wp_rem_removing_compare', array( $this, 'wp_rem_removing_compare' ));
			
			add_action('wp_ajax_wp_rem_clear_compare', array( $this, 'wp_rem_clear_compare_callback' ));
			add_action('wp_ajax_nopriv_wp_rem_clear_compare', array( $this, 'wp_rem_clear_compare_callback' ));
			
			add_action('wp_rem_compare_btn', array( $this, 'wp_rem_property_compare_button' ), 10, 3);
			add_filter('wp_rem_is_compare', array( $this, 'wp_rem_property_is_compare' ), 10, 2);
			add_action('wp_rem_detail_compare_btn', array( $this, 'wp_rem_property_detail_compare_button' ), 10, 1);
			add_action('wp_footer', array( $this,'wp_rem_property_compare_response')); 
			add_shortcode('wp_rem_compare_property', array( $this, 'wp_rem_compare_properties_listing' ));
			
			add_action( 'wp_ajax_wp_rem_cs_var_page_builder_wp_rem_compare_property', array( $this, 'wp_rem_cs_var_page_builder_wp_rem_compare_property' ));
			add_filter( 'wp_rem_cs_save_page_builder_data_wp_rem_compare_property', array( $this, 'wp_rem_cs_save_page_builder_data_wp_rem_compare_property_callback' ));
			add_filter( 'wp_rem_cs_load_shortcode_counters', array( $this, 'wp_rem_cs_load_shortcode_counters_wp_rem_compare_property_callback' ));
			add_filter( 'wp_rem_cs_element_list_populate', array( $this, 'wp_rem_cs_element_list_populate_wp_rem_compare_property_callback' ));
			add_filter( 'wp_rem_cs_shortcode_names_list_populate', array( $this, 'wp_rem_cs_shortcode_names_list_populate_wp_rem_compare_property_callback' ));
			
			add_filter('wp_rem_properties_shortcode_admin_default_attributes', array( $this, 'wp_rem_properties_shortcode_admin_default_attributes_callback' ), 11, 1);
			add_action( 'wp_rem_compare_properties_element_field', array( $this, 'wp_rem_compare_properties_element_field_callback' ), 11, 1);
			add_filter( 'wp_rem_save_properties_shortcode_admin_fields', array( $this, 'wp_rem_save_properties_shortcode_admin_fields_callback' ), 11, 3);
			
			
		}
		
		public function wp_rem_clear_compare_callback(){
			$property_id = isset($_POST['property_id']) ? $_POST['property_id'] : '';
			$property_type_id = isset($_POST['type_id']) ? $_POST['type_id'] : '';
			if( $property_type_id != '' ){
				if ( isset($_COOKIE['wp_rem_compare_list']) && $_COOKIE['wp_rem_compare_list'] != '' ) {
					$cookie_compare_list = stripslashes($_COOKIE['wp_rem_compare_list']);
					$cookie_compare_list = json_decode($cookie_compare_list, true);
				}
				$cookie_compare_list["type_{$property_type_id}"] = '';
				$cookie_compare_list_clear = json_encode($cookie_compare_list);
				setcookie('wp_rem_compare_list', $cookie_compare_list_clear, time() + 86400, '/');
				echo json_encode(array( 'type' => 'success'));
			}else{
				echo json_encode(array( 'type' => 'error' ));
			}
			die;
		}

		public function wp_rem_properties_shortcode_admin_default_attributes_callback( $attributes = array() ){
			$attributes['compare_property_switch'] = '';
			return $attributes;
		}
		public function wp_rem_compare_properties_element_field_callback( $atts = array() ){
			
			global $wp_rem_plugin_options, $wp_rem_html_fields;
			$wp_rem_all_compare_buttons = isset($wp_rem_plugin_options['wp_rem_all_compare_buttons']) ? $wp_rem_plugin_options['wp_rem_all_compare_buttons'] : '';
			if( $wp_rem_all_compare_buttons ){
				$wp_rem_opt_array = array(
					'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_compare_switch'),
					'desc' => '',
					'hint_text' => '',
					'echo' => true,
					'field_params' => array(
						'std' => esc_attr(isset($atts['compare_property_switch']) ? $atts['compare_property_switch'] : ''),
						'id' => 'compare_properties',
						'classes' => 'chosen-select-no-single',
						'cust_name' => 'compare_property_switch[]',
						'return' => true,
						'options' => array(
							'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
							'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
						)
					),
				);
				$wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
			}
		}
		
		public function wp_rem_save_properties_shortcode_admin_fields_callback( $attributes = '', $data = array(), $counter = '' ){
			if (isset($data['compare_property_switch'][$counter]) && $data['compare_property_switch'][$counter] != '') {
				$attributes .= 'compare_property_switch="' . htmlspecialchars($data['compare_property_switch'][$counter], ENT_QUOTES) . '" ';
			}
			return $attributes;
		}

		public function wp_rem_compare_add() {
			global $wp_rem_plugin_options;
			$compare_listing_url = isset($wp_rem_plugin_options['wp_rem_compare_list_page']) ? $wp_rem_plugin_options['wp_rem_compare_list_page'] : '';
			if ( $compare_listing_url != '' ) {
				$compare_listing_url = esc_url(get_permalink($compare_listing_url));
			}
			$cookie_compare_list_add = $cookie_compare_list = array();
			$cookie_compare_list = '';
			if ( isset($_COOKIE['wp_rem_compare_list']) && $_COOKIE['wp_rem_compare_list'] != '' ) {
				$cookie_compare_list = stripslashes($_COOKIE['wp_rem_compare_list']);
				$cookie_compare_list = json_decode($cookie_compare_list, true);
			}

			$wp_rem_prop_id = isset($_POST['wp_rem_property_id']) ? $_POST['wp_rem_property_id'] : '';
			$wp_rem_check_action = isset($_POST['_action']) ? $_POST['_action'] : '';
			$add_to_compare = '';
			$add_to_compare_already = '';
			$property_type_slug = get_post_meta($wp_rem_prop_id, 'wp_rem_property_type', true);
			if ( $property_type_slug != '' ) {
				$property_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish' ));
				$property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
			} else {
				$property_type_id = '';
			}
			$added_compare = '0';
			$before_btn = '<div class="compare-list-btn-holder">';
			$after_btn = '</div>';
			$mark_msg = wp_rem_plugin_text_srt( 'wp_rem_compare_cannot_add_to_list' );
			if ( $property_type_id != '' ) {
				if ( $wp_rem_check_action == 'check' ) {
					$already_in_list = false;
					if ( isset($cookie_compare_list["type_{$property_type_id}"]['list_ids']) ) {
						$wp_rem_type_comp_list = $cookie_compare_list["type_{$property_type_id}"]['list_ids'];
						if ( is_array($wp_rem_type_comp_list) && in_array($wp_rem_prop_id, $wp_rem_type_comp_list) ) {
							if ( ($key = array_search($wp_rem_prop_id, $wp_rem_type_comp_list)) !== false ) {
								$already_in_list = true;
							}
						}
					}
					if ( $already_in_list == true ) {
						$mark_msg = sprintf('<i class="icon-compare_arrows"></i> '. wp_rem_plugin_text_srt( 'wp_rem_compare_already_compared' ), get_the_title($wp_rem_prop_id));
						if ( $compare_listing_url != '' ) {
							$mark_msg .= $before_btn;
								$mark_msg .= ' <a class="compare-page" href="'. esc_url($compare_listing_url) .'">'. wp_rem_plugin_text_srt( 'wp_rem_compare_compare_list' ) .'</a>';
							$mark_msg .= $after_btn;
							$added_compare = '1';
						}
						$add_to_compare_already = wp_rem_plugin_text_srt( 'wp_rem_compare_add_to_compare' );
					} else {
						$added_compare = '1';
						if ( $compare_listing_url != '' ) {
							$added_succesfully_msg = '<i class="icon-compare_arrows"></i> ';
							$added_succesfully_msg .= sprintf(wp_rem_plugin_text_srt( 'wp_rem_compare_added_to_compare' ), get_the_title($wp_rem_prop_id));
							$added_succesfully_msg .= $before_btn;
								$added_succesfully_msg .= ' <a class="compare-page" href="'. esc_url($compare_listing_url) .'">'. wp_rem_plugin_text_srt( 'wp_rem_compare_compare_list' ) .'</a>';
							$added_succesfully_msg .= $after_btn;
						} else {
							$added_succesfully_msg = '<i class="icon-compare_arrows"></i> ';
							$added_succesfully_msg .= sprintf(wp_rem_plugin_text_srt( 'wp_rem_compare_added_to_compare' ), get_the_title($wp_rem_prop_id));
						}

						if ( isset($cookie_compare_list) && ! isset($cookie_compare_list["type_{$property_type_id}"]) ) {
							$cookie_compare_list["type_{$property_type_id}"] = array(
								'type_id' => $property_type_id,
								'list_ids' => array( $wp_rem_prop_id ),
							);
							$cookie_compare_list_add = json_encode($cookie_compare_list);
							setcookie('wp_rem_compare_list', $cookie_compare_list_add, time() + 86400, '/');
							$mark_msg = $added_succesfully_msg;
						} else if ( isset($cookie_compare_list) && isset($cookie_compare_list["type_{$property_type_id}"]) ) {
							$type_session_arr = $cookie_compare_list["type_{$property_type_id}"];
							if ( isset($type_session_arr['list_ids']) && is_array($type_session_arr['list_ids']) && sizeof($type_session_arr['list_ids']) < 3 ) {
								array_push($type_session_arr['list_ids'], $wp_rem_prop_id);
								$cookie_compare_list["type_{$property_type_id}"] = array(
									'type_id' => $property_type_id,
									'list_ids' => $type_session_arr['list_ids'],
								);
								$cookie_compare_list_add = json_encode($cookie_compare_list);
								setcookie('wp_rem_compare_list', $cookie_compare_list_add, time() + 86400, '/');
								$mark_msg = $added_succesfully_msg;
							} else if ( isset($type_session_arr['list_ids']) && is_array($type_session_arr['list_ids']) && sizeof($type_session_arr['list_ids']) >= 3 ) {
								$mark_msg = wp_rem_plugin_text_srt( 'wp_rem_compare_already_have_properties' );
								$mark_msg .= $before_btn;
									if ( $compare_listing_url != '' ) {
										$mark_msg .= ' <a class="compare-page" href="'. esc_url($compare_listing_url) .'">'. wp_rem_plugin_text_srt( 'wp_rem_compare_compare_list' ) .'</a>';
									}
									$mark_msg .= ' <a data-id="'. $wp_rem_prop_id .'" data-type-id="'. $property_type_id .'" class="clear-list" href="javascript:void(0)">'. wp_rem_plugin_text_srt( 'wp_rem_compare_clear_list' ) .'</a>';
								$mark_msg .= $after_btn;
								$add_to_compare_already = wp_rem_plugin_text_srt( 'wp_rem_compare_add_to_compare' );
								$mark_msg .= '<script>jQuery("#check-list' . $wp_rem_prop_id . '").attr("checked", false);</script>';
								$added_compare = '0';
							} else if ( ! isset($type_session_arr['list_ids']) ) {
								$cookie_compare_list["type_{$property_type_id}"] = array(
									'type_id' => $property_type_id,
									'list_ids' => array( $wp_rem_prop_id ),
								);
								$cookie_compare_list_add = json_encode($cookie_compare_list);
								setcookie('wp_rem_compare_list', $cookie_compare_list_add, time() + 86400, '/');
								$mark_msg = $added_succesfully_msg;
								$added_compare = '0';
							}
						} else {
							$cookie_compare_list = array(
								"type_{$property_type_id}" => array(
									'type_id' => $property_type_id,
									'list_ids' => array( $wp_rem_prop_id ),
								),
							);
							$cookie_compare_list_add = json_encode($cookie_compare_list);
							setcookie('wp_rem_compare_list', $cookie_compare_list_add, time() + 86400, '/');
							$mark_msg = $added_succesfully_msg;
							$added_compare = '1';
						}
					}
				} else {
					if ( isset($cookie_compare_list["type_{$property_type_id}"]['list_ids']) ) {
						$wp_rem_type_comp_list = $cookie_compare_list["type_{$property_type_id}"]['list_ids'];
						if ( is_array($wp_rem_type_comp_list) && in_array($wp_rem_prop_id, $wp_rem_type_comp_list) ) {
							if ( ($key = array_search($wp_rem_prop_id, $wp_rem_type_comp_list)) !== false ) {
								unset($wp_rem_type_comp_list[$key]);
								$cookie_compare_list_add["type_{$property_type_id}"] = array(
									'type_id' => $property_type_id,
									'list_ids' => $wp_rem_type_comp_list,
								);
								
								$cookie_compare_list_add = json_encode($cookie_compare_list_add);
								setcookie('wp_rem_compare_list', $cookie_compare_list_add, time() + 86400, '/');
							}
						}
					}
					
					$mark_msg = '<i class="icon-warning3"></i> ';
					$mark_msg .= sprintf(wp_rem_plugin_text_srt( 'wp_rem_compare_was_removed_from_compare' ), get_the_title($wp_rem_prop_id));
					if ( $compare_listing_url != '' ) {
						$mark_msg .= $before_btn;
							$mark_msg .= ' <a class="compare-page" href="'. esc_url($compare_listing_url) .'">'. wp_rem_plugin_text_srt( 'wp_rem_compare_compare_list' ) .'</a>';
						$mark_msg .= $after_btn;
					}
					
					$add_to_compare = wp_rem_plugin_text_srt( 'wp_rem_compare_add_to_compare' );
					$added_compare = '0';
				}
			} else {
				$mark_msg = sprintf('<i class="icon-compare_arrows"></i> '. wp_rem_plugin_text_srt( 'wp_rem_compare_cannot_add_to_list' ), get_the_title($wp_rem_prop_id));
				if ( $compare_listing_url != '' ) {
					$mark_msg .= $before_btn;
						$mark_msg .= ' <a class="compare-page" href="'. esc_url($compare_listing_url) .'">'. wp_rem_plugin_text_srt( 'wp_rem_compare_compare_list' ) .'</a>';
					$mark_msg .= $after_btn;
				}
				$added_compare = '0';
				
			}
			$compare_msg = '';
			if ( $add_to_compare != '' ) {
				$compare_msg = $add_to_compare;
			} elseif ( $add_to_compare_already != '' ) {
				$compare_msg = $add_to_compare_already;
			} else {
				$compare_msg = wp_rem_plugin_text_srt( 'wp_rem_compare_remove_to_compare' );
			}
			echo json_encode(array( 'mark' => $mark_msg, 'compare' => $compare_msg, 'type' => $added_compare ));
			die;
		}
		
		public function wp_rem_removing_compare() {

			$wp_rem_prop_id = isset($_POST['property_id']) ? $_POST['property_id'] : '';
			$wp_rem_type_id = isset($_POST['type_id']) ? $_POST['type_id'] : '';
			$wp_rem_prop_ids = isset($_POST['prop_ids']) ? $_POST['prop_ids'] : '';
			$wp_rem_page_id = isset($_POST['page_id']) ? $_POST['page_id'] : '';

			$cookie_compare_list_add = array();
			$cookie_compare_list = '';
			if ( isset($_COOKIE['wp_rem_compare_list']) && $_COOKIE['wp_rem_compare_list'] != '' ) {
				$cookie_compare_list = stripslashes($_COOKIE['wp_rem_compare_list']);
				$cookie_compare_list = json_decode($cookie_compare_list, true);
			}
			
			if (isset($cookie_compare_list["type_{$wp_rem_type_id}"]['list_ids'])) {
				$wp_rem_type_comp_list = $cookie_compare_list["type_{$wp_rem_type_id}"]['list_ids'];
				if (is_array($wp_rem_type_comp_list) && in_array($wp_rem_prop_id, $wp_rem_type_comp_list)) {
					if (($key = array_search($wp_rem_prop_id, $wp_rem_type_comp_list)) !== false) {
						unset($wp_rem_type_comp_list[$key]);
						$cookie_compare_list_add["type_{$wp_rem_type_id}"] = array(
							'type_id' => $wp_rem_type_id,
							'list_ids' => $wp_rem_type_comp_list,
						);
						$cookie_compare_list_add = json_encode($cookie_compare_list_add);
						setcookie('wp_rem_compare_list', $cookie_compare_list_add, time() + 86400, '/');
					}
				}
			}

			$wp_rem_prop_ids = explode(',', $wp_rem_prop_ids);
			if (in_array($wp_rem_prop_id, $wp_rem_prop_ids)) {
				if (($key = array_search($wp_rem_prop_id, $wp_rem_prop_ids)) !== false) {
					unset($wp_rem_prop_ids[$key]);
				}
			}
			$wp_rem_prop_ids = implode(',', $wp_rem_prop_ids);

			$final_url = add_query_arg(array('type' => $wp_rem_type_id, 'properties_ids' => $wp_rem_prop_ids), get_permalink($wp_rem_page_id));

			echo json_encode(array('url' => $final_url));
			die;
		}
		
		public function wp_rem_property_compare_response() {
			?>
			<div class="compare-message">
				<div class="compare-success compare-large">
					<div class="compare-close"><i class="icon-cross"></i></div>
					<div class="compare-title"></div>
					<div class="compare-text">
					</div>
					</div>
				</div>
			</div>
			<?php
		}
		
		public function wp_rem_property_is_compare($prop_id = '', $show_compare = 'no' ) {
			global $property_random_id, $wp_rem_plugin_options;
			$prop_is_compare = '';
			$wp_rem_all_compare_buttons = isset($wp_rem_plugin_options['wp_rem_all_compare_buttons']) ? $wp_rem_plugin_options['wp_rem_all_compare_buttons'] : '';
			if( $wp_rem_all_compare_buttons == 'on' && $show_compare == 'yes' ){
				wp_enqueue_script('wp-rem-property-compare');
				$cookie_compare_list = '';
				if ( isset($_COOKIE['wp_rem_compare_list']) && $_COOKIE['wp_rem_compare_list'] != '' ) {
					$cookie_compare_list = stripslashes($_COOKIE['wp_rem_compare_list']);
					$cookie_compare_list = json_decode($cookie_compare_list, true);
				}

				$property_type_slug = get_post_meta($prop_id, 'wp_rem_property_type', true);
				if ($property_type_slug != '') {
					$property_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish'));
					$property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
				} else {
					$property_type_id = '';
				}
				if (isset($cookie_compare_list["type_{$property_type_id}"]['list_ids'])) {
					$wp_rem_type_comp_list = $cookie_compare_list["type_{$property_type_id}"]['list_ids'];
					if (is_array($wp_rem_type_comp_list) && in_array($prop_id, $wp_rem_type_comp_list)) {
						$prop_is_compare = ' active';
					}
				}
				return $prop_is_compare;
			}
		}
		
		public function wp_rem_property_compare_button($prop_id = '', $show_compare = 'no', $tooltip = 'no' ) {
			global $property_random_id, $wp_rem_plugin_options;
			$wp_rem_all_compare_buttons = isset($wp_rem_plugin_options['wp_rem_all_compare_buttons']) ? $wp_rem_plugin_options['wp_rem_all_compare_buttons'] : '';
			if( $wp_rem_all_compare_buttons == 'on' && $show_compare == 'yes' ){
				wp_enqueue_script('wp-rem-property-compare');
				$cookie_compare_list = '';
				if ( isset($_COOKIE['wp_rem_compare_list']) && $_COOKIE['wp_rem_compare_list'] != '' ) {
					$cookie_compare_list = stripslashes($_COOKIE['wp_rem_compare_list']);
					$cookie_compare_list = json_decode($cookie_compare_list, true);
				}

				$property_type_slug = get_post_meta($prop_id, 'wp_rem_property_type', true);
				if ($property_type_slug != '') {
					$property_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish'));
					$property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
				} else {
					$property_type_id = '';
				}
				$prop_compare_check = '';
				$pro_compare_class = '';
				if (isset($cookie_compare_list["type_{$property_type_id}"]['list_ids'])) {
					$wp_rem_type_comp_list = $cookie_compare_list["type_{$property_type_id}"]['list_ids'];
					if (is_array($wp_rem_type_comp_list) && in_array($prop_id, $wp_rem_type_comp_list)) {
						$prop_compare_check = ' checked="checked"';
						$pro_compare_class = ' compared';
					}
				}
				$html = '';
				$html .= '<div class="compare-property '. esc_html($pro_compare_class) .'">';
					if( $tooltip == 'yes'){
						$html .= '<span class="compare-label">' . wp_rem_plugin_text_srt( 'wp_rem_compare_label' ) . '</span>';
					}
					$html .= '<input type="checkbox" ' . $prop_compare_check . ' class="wp_rem_compare_check_add" data-id="' . absint($prop_id). '" data-random = "' . absint($prop_id) . '" name="list" value="check-listn" id="check-list' . absint($prop_id) . '">';
					$html .= '<label for="check-list' . absint($prop_id) . '"><i class="icon-compare_arrows"></i><span class="wp-rem-compare-loader-' . absint($prop_id) . '"></span><em>' . wp_rem_plugin_text_srt( 'wp_rem_compare_label' ) . '</em></label>';
				$html .= '</div>';
                                
				echo force_balance_tags($html);
			}
		}
		
		public function wp_rem_property_detail_compare_button($prop_id = '') {
			global $wp_rem_plugin_options;
			$wp_rem_all_compare_buttons = isset($wp_rem_plugin_options['wp_rem_all_compare_buttons']) ? $wp_rem_plugin_options['wp_rem_all_compare_buttons'] : '';
			if( $wp_rem_all_compare_buttons == 'on'){
				wp_enqueue_script('wp-rem-property-compare');
				$cookie_compare_list = '';
				if ( isset($_COOKIE['wp_rem_compare_list']) && $_COOKIE['wp_rem_compare_list'] != '' ) {
					$cookie_compare_list = stripslashes($_COOKIE['wp_rem_compare_list']);
					$cookie_compare_list = json_decode($cookie_compare_list, true);
				}

				$property_type_slug = get_post_meta($prop_id, 'wp_rem_property_type', true);
				if ($property_type_slug != '') {
					$property_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'property-type', 'name' => $property_type_slug, 'post_status' => 'publish'));
					$property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
				} else {
					$property_type_id = '';
				}
				$prop_compare_check = 'check';
				$compare_title = wp_rem_plugin_text_srt( 'wp_rem_compare_add_to_compare' );
				$remove_compare_title = wp_rem_plugin_text_srt( 'wp_rem_compare_remove_to_compare' );
				$html = '<div class="detail-compare-btn"><a class="btn-compare wp-rem-btn-compare" data-type="detail-page" data-id="' . $prop_id . '" data-check="' . $prop_compare_check . '" data-ajaxurl="' . admin_url( 'admin-ajax.php' ) . '"><i class="icon-flow-tree"></i> <span>' . $compare_title . '</span></a></div>';
				if (isset($cookie_compare_list["type_{$property_type_id}"]['list_ids'])) {
					$wp_rem_type_comp_list = $cookie_compare_list["type_{$property_type_id}"]['list_ids'];
					if (is_array($wp_rem_type_comp_list) && in_array($prop_id, $wp_rem_type_comp_list)) {
						$prop_compare_uncheck = 'uncheck';
						$html = '<div class="detail-compare-btn"><a class="btn-compare wp-rem-btn-compare" data-type="detail-page" data-id="' . $prop_id . '" data-check="' . $prop_compare_uncheck . '" data-check="' . $prop_compare_check . '" data-ajaxurl="' . admin_url( 'admin-ajax.php' ) . '"><i class="icon-flow-tree"></i> <span>' . $remove_compare_title . '</span></a></div>';
					}
				}
				echo force_balance_tags($html);
			}
		}
		
		public function wp_rem_compare_properties_listing($atts, $content = "") {
			global $wp_rem_plugin_options, $wp_rem_form_fields_frontend;
			$wp_rem_search_result_page = isset($wp_rem_plugin_options['wp_rem_search_result_page']) ? $wp_rem_plugin_options['wp_rem_search_result_page'] : '';
			
			wp_enqueue_script('wp-rem-property-compare');

			$wp_rem_blog_num_post = 4; // only allow to compare number of items
			$default_date_time_formate = 'd-m-Y H:i:s';
			$wp_rem_compare_property_posted_date_formate = 'd-m-Y H:i:s';
			$wp_rem_compare_property_expired_date_formate = 'd-m-Y H:i:s';
			$property_type = '';
			ob_start();
			
			$cookie_compare_list = '';
			if ( isset($_COOKIE['wp_rem_compare_list']) && $_COOKIE['wp_rem_compare_list'] != '' ) {
				$cookie_compare_list = stripslashes($_COOKIE['wp_rem_compare_list']);
				$cookie_compare_list = json_decode($cookie_compare_list, true);
			}
			
			$get_query_type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
			$wp_rem_compare_session_list = array();
			if (isset($cookie_compare_list) && is_array($cookie_compare_list) && sizeof($cookie_compare_list) > 0) {
				foreach ($cookie_compare_list as $wp_rem_compare_list) {
					$property_type = isset($wp_rem_compare_list['type_id']) ? $wp_rem_compare_list['type_id'] : '';
					$meta_post_ids_arr = isset($wp_rem_compare_list['list_ids']) ? $wp_rem_compare_list['list_ids'] : '';
					if (is_array($meta_post_ids_arr) && sizeof($meta_post_ids_arr) > 1) {
						$wp_rem_compare_session_list[$property_type] = $wp_rem_compare_list;
					}
				}
			}
			$meta_post_ids_arr = array();
			if ((isset($_REQUEST['properties_ids']) && $_REQUEST['properties_ids'] != '') && (isset($_REQUEST['type']) && $_REQUEST['type'] != '')) {
				$property_type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
				$properties_ids = isset($_REQUEST['properties_ids']) ? $_REQUEST['properties_ids'] : '';
				$meta_post_ids_arr = explode(',', $properties_ids);
			} else if (isset($cookie_compare_list) && is_array($cookie_compare_list) && sizeof($cookie_compare_list) > 0) {
				foreach ($cookie_compare_list as $wp_rem_compare_list) {
					if (isset($wp_rem_compare_list['list_ids']) && is_array($wp_rem_compare_list['list_ids']) && sizeof($wp_rem_compare_list['list_ids']) > 1) {
						$property_type = isset($wp_rem_compare_list['type_id']) ? $wp_rem_compare_list['type_id'] : '';
						$meta_post_ids_arr = isset($wp_rem_compare_list['list_ids']) ? $wp_rem_compare_list['list_ids'] : '';
						if ($get_query_type != '' && $get_query_type == $property_type) {
							$property_type = isset($wp_rem_compare_list['type_id']) ? $wp_rem_compare_list['type_id'] : '';
							$meta_post_ids_arr = isset($wp_rem_compare_list['list_ids']) ? $wp_rem_compare_list['list_ids'] : '';
							break;
						}
					}
				}
			}

			if ($get_query_type == '') {
				$get_query_type = $property_type;
			}
			$open_house_check = get_post_meta($property_type, 'wp_rem_property_type_open_house', true);
			?>
			
			<!-- alert for complete theme -->
			<div class="wp_rem_alerts"></div>
			<!-- main-wp-rem-loader for complete theme -->
			<div class="main-wp-rem-loader"></div>
			<?php
			$defaults = array(
				'property_compare_title' => '',
			);
			extract(shortcode_atts($defaults, $atts));
			?>
			<div class="row">
				<div class="section-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<?php if (isset($property_compare_title) && trim($property_compare_title) <> '') { ?>
						<div class="wp-rem-element-title">
							<h2><?php echo esc_attr($property_compare_title); ?></h2>
						</div>
					<?php } ?>
					<div class="wp-rem-compare" data-id="<?php echo get_the_id() ?>" data-ids="<?php echo isset($_REQUEST['properties_ids']) ? $_REQUEST['properties_ids'] : '' ?>">
						<?php
//						if (sizeof($wp_rem_compare_session_list) > 1) {
//							echo '<div class="wp-rem-compare-options">';
//							echo '<form method="get">';
//							echo '<div class="field-holder select-dropdown">';
//							echo '<select name="type" class="chosen-select-no-single" onchange="this.form.submit()">';
//							foreach ($wp_rem_compare_session_list as $c_m_key => $c_m_val) {
//								if (isset($c_m_val['list_ids']) && sizeof($c_m_val['list_ids']) > 1) {
//									echo '<option ' . selected($c_m_key, $get_query_type, false) . ' value="' . $c_m_key . '">' . get_the_title($c_m_key) . '</option>';
//								}
//							}
//							echo '</select>';
//							echo '</div>';
//							echo '</form>';
//							echo '<script>jQuery(document).ready(function(){chosen_selectionbox();});</script>';
//							echo '</div>';
//						} ?>
						<?php if (sizeof($wp_rem_compare_session_list) > 1) { ?>
							<div class="compare-properties-types">
								<div class="field-holder"> 
									<form method="get" name="compare-types" action="">
										<ul>
											<?php
											$number_option_flag = 1;
											foreach ($wp_rem_compare_session_list as $c_m_key => $c_m_val) {
												?>
												<li>
													<?php
													$checked = '';
													if ( $c_m_key ==  $get_query_type ) {
														$checked = 'checked="checked"';
													}
													$wp_rem_form_fields_frontend->wp_rem_form_radio_render(
															array(
																'simple' => true,
																'cust_id' => 'property_type' . $number_option_flag,
																'cust_name' => 'type',
																'std' => $c_m_key,
																'extra_atr' => $checked .'onchange="this.form.submit();"',
															)
													);
													?>
													<label for="<?php echo force_balance_tags('property_type' . $number_option_flag) ?>"><?php echo get_the_title($c_m_key); ?></label>
												</li>
												<?php
												$number_option_flag ++;
											}
											?>
										</ul>
									</form>
								</div>
							</div>
						<?php } ?>
						<?php if (is_array($meta_post_ids_arr) && sizeof($meta_post_ids_arr) > 1) {
							?>
							<script>
								var current_url = location.protocol + "//" + location.host + location.pathname;
								var query_sep = '?';
								if (current_url.indexOf("?") != -1) {
									query_sep = '&';
								}
								window.history.pushState(null, null, current_url + query_sep + "type=<?php echo absint($property_type) ?>&properties_ids=<?php echo implode(',', $meta_post_ids_arr) ?>");
							</script>
							<ul class="wp-rem-compare-list">
								<li>
									<div class="wp-rem-compare-box"></div>
									<?php
									$meta_post_ids_size = sizeof($meta_post_ids_arr);
									$meta_post_ids_counter = 1;
									foreach ($meta_post_ids_arr as $property_id) {
										?>
										<div class="wp-rem-compare-box dev-rem-<?php echo absint($property_id) ?>">
											<div class="wp-rem-media">
												<figure>
													<?php 
													if (function_exists('property_gallery_first_image')) {
														$size = 'wp_rem_cs_media_5';
														$gallery_image_args = array(
															'property_id' => $property_id,
															'size' => $size,
															'class' => 'img-grid',
															'default_image_src' => esc_url(wp_rem::plugin_url() . 'assets/frontend/images/no-image9x6.jpg')
														);
														echo $property_gallery_first_image = property_gallery_first_image($gallery_image_args);
													}
													?>

													<figcaption>
														<a class="wp-rem-bgcolor wp-rem-remove-compare-item" data-id="<?php echo absint($property_id) ?>" data-type-id="<?php echo absint($property_type) ?>"><i class="icon-cross2"></i></a>
													</figcaption>
												</figure>
											</div>
											<?php if ($meta_post_ids_counter != $meta_post_ids_size) { ?>
												<span class="wp-rem-vs"><?php echo wp_rem_plugin_text_srt( 'wp_rem_compare_vs' ); ?></span>
											<?php } ?>
										</div>
										<?php
										$meta_post_ids_counter++;
									}
									?>
								</li>  
								<li>
									<div class="wp-rem-compare-box">
										<p class="label"><?php echo wp_rem_plugin_text_srt( 'wp_rem_compare_basic_info' ); ?></p>
									</div>
									<?php
									foreach ($meta_post_ids_arr as $property_id) {
										$wp_rem_property_price = '';
										$wp_rem_property_price_options = get_post_meta($property_id, 'wp_rem_property_price_options', true);
										if ($wp_rem_property_price_options == 'price') {
											$wp_rem_property_price = get_post_meta($property_id, 'wp_rem_property_price', true);
										} else if ($wp_rem_property_price_options == 'on-call') {
											$wp_rem_property_price = wp_rem_plugin_text_srt( 'wp_rem_properties_price_on_request' );
										}
										?>
										<div class="wp-rem-compare-box dev-rem-<?php echo absint($property_id) ?>">
											<div class="wp-rem-post-title">
												<h6>
													<a href="<?php echo esc_url(get_permalink($property_id)) ?>"><?php echo get_the_title($property_id) ?></a>
												</h6>
											</div>
											<div class="wp-rem-price">
												<strong class="wp-rem-color">
													<?php
													if ($wp_rem_property_price_options == 'on-call') {
														echo force_balance_tags($wp_rem_property_price);
													} else {
														$property_info_price = wp_rem_property_price($property_id, $wp_rem_property_price, '<span class="guid-price">', '</span>');
														echo force_balance_tags($property_info_price);
													}
													?>
												</strong>
											</div>
										</div>
									<?php } ?>
								</li>
								<li>
									<div class="wp-rem-compare-box">
										<small class="label"><?php echo wp_rem_plugin_text_srt( 'wp_rem_property_property_category' ); ?></small>
									</div>
									<?php
									foreach ($meta_post_ids_arr as $property_id) { ?>
										<div class="wp-rem-compare-box dev-rem-<?php echo absint($property_id) ?>">
											<span>
												<?php 
												$property_category = get_post_meta($property_id, 'wp_rem_property_category', true);
												$property_parent_category = isset($property_category['parent']) ? $property_category['parent'] : '';
												if( $property_parent_category !== ''){
													$term = get_term_by('slug', $property_parent_category, 'property-category');
													echo wp_rem_allow_special_char(isset($term->name) ? $term->name : '<i class="icon icon-cross"></i>');
												}else{
													echo '<i class="icon icon-cross"></i>';
												}
												?>
											</span>
										</div>
									<?php } ?>
								</li>
								<li>
									<div class="wp-rem-compare-box">
										<small class="label"><?php echo wp_rem_plugin_text_srt( 'wp_rem_property_property_sub_category' ); ?></small>
									</div>
									<?php
									foreach ($meta_post_ids_arr as $property_id) { ?>
										<div class="wp-rem-compare-box dev-rem-<?php echo absint($property_id) ?>">
											<span>
												<?php 
												$property_category = get_post_meta($property_id, 'wp_rem_property_category', true);
												$property_parent_category = isset($property_category['parent']) ? $property_category['parent'] : '';
												$property_sub_categories = isset($property_category[$property_parent_category]) ? $property_category[$property_parent_category] : '';
												if( $property_sub_categories !== ''){
													$term = get_term_by('slug', $property_sub_categories, 'property-category');
													echo wp_rem_allow_special_char(isset($term->name) ? $term->name : '<i class="icon icon-cross"></i>');
												}else{
													echo '<i class="icon icon-cross"></i>';
												}
												?>
											</span>
										</div>
									<?php } ?>
								</li>
								<li>
									<div class="wp-rem-compare-box">
										<small class="label"><?php echo wp_rem_plugin_text_srt( 'wp_rem_property_featured' ); ?></small>
									</div>
									<?php
									foreach ($meta_post_ids_arr as $property_id) { ?>
										<div class="wp-rem-compare-box dev-rem-<?php echo absint($property_id) ?>">
											<span>
												<?php 
												$is_featured = get_post_meta($property_id, 'wp_rem_property_is_featured', true);
												if( $is_featured == 'on'){
													echo '<i class="icon icon-check"></i>';
												}else{
													echo '<i class="icon icon-cross"></i>';
												}
												?>
											</span>
										</div>
									<?php } ?>
								</li>
								<li>
									<div class="wp-rem-compare-box">
										<small class="label"><?php echo wp_rem_plugin_text_srt( 'wp_rem_list_meta_top_category' ); ?></small>
									</div>
									<?php
									foreach ($meta_post_ids_arr as $property_id) { ?>
										<div class="wp-rem-compare-box dev-rem-<?php echo absint($property_id) ?>">
											<span>
												<?php 
												$is_top_cat = get_post_meta($property_id, 'wp_rem_property_is_top_cat', true);
												if( $is_top_cat == 'on'){
													echo '<i class="icon icon-check"></i>';
												}else{
													echo '<i class="icon icon-cross"></i>';
												}
												?>
											</span>
										</div>
									<?php } ?>
								</li>
								<?php if( $open_house_check == 'on' ){ ?>
									<li>
										<div class="wp-rem-compare-box">
											<small class="label"><?php echo wp_rem_plugin_text_srt( 'wp_rem_open_house' ); ?></small>
										</div>
										<?php
										foreach ($meta_post_ids_arr as $property_id) { ?>
											<div class="wp-rem-compare-box dev-rem-<?php echo absint($property_id) ?>">
												<span>
													<?php 
													$open_house_start = get_post_meta($property_id, 'open_house_start', true);
													$open_house_end = get_post_meta($property_id, 'open_house_end', true);
													if( $open_house_start != '' && $open_house_end != ''){
														$date = date_i18n(get_option('date_format'), $open_house_start);
														$start_time = date_i18n("h:i a", $open_house_start);
														$end_time = date_i18n("h:i a", $open_house_end);
														echo $date . ' ' . $start_time . ' ' . wp_rem_plugin_text_srt('wp_rem_member_to') . ' ' . $end_time;
													}else{
														echo '<i class="icon icon-cross"></i>';
													}
													?>
												</span>
											</div>
										<?php } ?>
									</li>
								<?php } ?>
								<?php
								// load property type record by slug
								$property_type_fields_arr = array();
								$wp_rem_property_type_cus_fields = get_post_meta($property_type, "wp_rem_property_type_cus_fields", true);
								if (is_array($wp_rem_property_type_cus_fields) && sizeof($wp_rem_property_type_cus_fields) > 0) {
									foreach ($wp_rem_property_type_cus_fields as $cus_field) {
										$wp_rem_unique_id = rand(1111111, 9999999);
										$wp_rem_type = isset($cus_field['type']) ? $cus_field['type'] : '';
										if ($wp_rem_type != 'section') {
											$single_property_arr = array();
											$wp_rem_cus_title = isset($cus_field['label']) ? $cus_field['label'] : '';
											$wp_rem_meta_key_field = isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '';
											foreach ($meta_post_ids_arr as $property_id) {
												$wp_rem_label_value = get_post_meta($property_id, "$wp_rem_meta_key_field", true);
												$single_property_arr[] = array(
													'type' => $wp_rem_type,
													'id' => $property_id,
													'key' => $wp_rem_meta_key_field,
													'label' => $wp_rem_cus_title,
													'value' => $wp_rem_label_value,
												);
											}
											$property_type_fields_arr[$wp_rem_unique_id] = $single_property_arr;
										}
									}
								}
								if (is_array($property_type_fields_arr) && sizeof($property_type_fields_arr) > 0) {
									foreach ($property_type_fields_arr as $li_row) {
										?>
										<li>
											<?php
											if (is_array($li_row) && sizeof($li_row) > 0) {


												$li_row_counter = 0;
												foreach ($li_row as $li_ro) {
													$type = isset($li_ro['type']) ? $li_ro['type'] : '';
													if ($li_row_counter == 0) {
														?>
														<div class="wp-rem-compare-box">
															<small class="label"><?php echo isset($li_ro['label']) ? esc_html($li_ro['label']) : '' ?></small>
														</div>
														<?php
													}
													?>
													<div class="wp-rem-compare-box dev-rem-<?php echo absint(isset($li_ro['id']) ? $li_ro['id'] : '') ?>">
														<span>&nbsp;
															<?php
															$row_val = isset($li_ro['value']) ? $li_ro['value'] : '';
															if (is_array($row_val) && !empty($row_val)) {
																$row_val = implode(', ', $row_val);
																if( $row_val != '' ){
																	echo esc_html( ucwords( str_replace( "-", " ", $row_val ) ) );
																}else{
																	echo '<i class="icon icon-cross"></i>';
																}
															} else {
																if( $row_val != '' ){
																	if( $type == 'date'){
																		echo date_i18n(get_option('date_format'), $row_val);
																	}else{
																		echo esc_html( ucwords( str_replace( "-", " ", $row_val ) ) );
																	}
																}else{
																	echo '<i class="icon icon-cross"></i>';
																}
															}

															?>
														</span>
													</div>
													<?php
													$li_row_counter++;
												}
											}
											?>
										</li>
										<?php
									}
								}
								?>
								<li>
									<div class="wp-rem-compare-box">
										<small class="label"><?php echo wp_rem_plugin_text_srt( 'wp_rem_property_features' ); ?></small>
									</div>
									<?php
									foreach ($meta_post_ids_arr as $property_id) { ?>
										<div class="wp-rem-compare-box dev-rem-<?php echo absint($property_id) ?>">
											<?php $features_list = get_post_meta($property_id, 'wp_rem_property_feature_list', true); //print_r($features_list); ?>
											<span>
												<?php if (isset($features_list) && !empty($features_list)) {
													$comma = '';
													foreach ($features_list as $feature_data) {
														$feature_exploded = explode("_icon", $feature_data);
														$features_data_name = isset($feature_exploded[0]) ? $feature_exploded[0] : '';
														echo esc_html( $comma . ucwords( str_replace( "-", " ", $features_data_name ) ) );
														$comma = ', ';
													}
												} 
												?>
												
											</span>
										</div>
									<?php } ?>
								</li>
							</ul>
							<?php
						} else {
							?>
							<ul class="wp-rem-compare-list">
								<li>
									<div class="compare-text-div">
										<?php
										$listing_url = '';
										if($wp_rem_search_result_page != '' && is_numeric($wp_rem_search_result_page)){
										 $listing_url = '<a href="'. get_permalink($wp_rem_search_result_page).'">'.' '. wp_rem_plugin_text_srt('wp_rem_compare_click_here') .'</a>';
										}
										echo sprintf(wp_rem_plugin_text_srt('wp_rem_compare_compare_list_is_empty'), $listing_url); ?>
									</div>
								</li>
							</ul>
							<?php
						}
						?>               
					</div>
				</div>
			</div>
			
			<?php
			$eventpost_data = ob_get_clean();
			return do_shortcode($eventpost_data);
		}
		
		public function wp_rem_cs_var_page_builder_wp_rem_compare_property( $die = 0 ) {
			global $post, $wp_rem_html_fields, $wp_rem_html_fields, $wp_rem_html_fields, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_frame_static_text;
			if ( function_exists( 'wp_rem_cs_shortcode_names' ) ) {
				$shortcode_element = '';
				$filter_element = 'filterdrag';
				$shortcode_view = '';
				$wp_rem_cs_output = array();
				$wp_rem_cs_PREFIX = 'wp_rem_compare_property';

				$wp_rem_cs_counter = isset( $_POST['counter'] ) ? $_POST['counter'] : '';
				if ( isset( $_POST['action'] ) && ! isset( $_POST['shortcode_element_id'] ) ) {
					$wp_rem_cs_POSTID = '';
					$shortcode_element_id = '';
				} else {
					$wp_rem_cs_POSTID = isset( $_POST['POSTID'] ) ? $_POST['POSTID'] : '';
					$shortcode_element_id = isset( $_POST['shortcode_element_id'] ) ? $_POST['shortcode_element_id'] : '';
					$shortcode_str = stripslashes( $shortcode_element_id );
					$parseObject = new ShortcodeParse();
					$wp_rem_cs_output = $parseObject->wp_rem_cs_shortcodes( $wp_rem_cs_output, $shortcode_str, true, $wp_rem_cs_PREFIX );
				}
				$defaults = array(
					'property_compare_title' => '',
				);
				if ( isset( $wp_rem_cs_output['0']['atts'] ) ) {
					$atts = $wp_rem_cs_output['0']['atts'];
				} else {
					$atts = array();
				}
				if ( isset( $wp_rem_cs_output['0']['content'] ) ) {
					$wp_rem_compare_property_column_text = $wp_rem_cs_output['0']['content'];
				} else {
					$wp_rem_compare_property_column_text = '';
				}
				$wp_rem_compare_property_element_size = '100';
				foreach ( $defaults as $key => $values ) {
					if ( isset( $atts[$key] ) ) {
						$$key = $atts[$key];
					} else {
						$$key = $values;
					}
				}
				$name = 'wp_rem_cs_var_page_builder_wp_rem_compare_property';
				$coloumn_class = 'column_' . $wp_rem_compare_property_element_size;
				if ( isset( $_POST['shortcode_element'] ) && $_POST['shortcode_element'] == 'shortcode' ) {
					$shortcode_element = 'shortcode_element_class';
					$shortcode_view = 'cs-pbwp-shortcode';
					$filter_element = 'ajax-drag';
					$coloumn_class = '';
				}
				$property_title = isset( $atts['property_compare_title'] ) ? $atts['property_compare_title'] : '';
				?>
				<div id="<?php echo esc_attr( $name . $wp_rem_cs_counter ) ?>_del" class="column  parentdelete <?php echo esc_attr( $coloumn_class ); ?>
					 <?php echo esc_attr( $shortcode_view ); ?>" item="wp_rem_compare_property" data="<?php echo wp_rem_cs_element_size_data_array_index( $wp_rem_compare_property_element_size ) ?>" >
						 <?php wp_rem_cs_element_setting( $name, $wp_rem_cs_counter, $wp_rem_compare_property_element_size ) ?>
					<div class="cs-wrapp-class-<?php echo intval( $wp_rem_cs_counter ) ?>
						 <?php echo esc_attr( $shortcode_element ); ?>" id="<?php echo esc_attr( $name . $wp_rem_cs_counter ) ?>" data-shortcode-template="[wp_rem_compare_property {{attributes}}]{{content}}[/wp_rem_compare_property]" style="display: none;">
						<div class="cs-heading-area" data-counter="<?php echo esc_attr( $wp_rem_cs_counter ) ?>">
							<h5><?php echo wp_rem_plugin_text_srt( 'wp_rem_compare_shortcode_heading' ); ?></h5>
							<a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_js( $name . $wp_rem_cs_counter ) ?>','<?php echo esc_js( $filter_element ); ?>')" class="cs-btnclose">
								<i class="icon-cross"></i>
							</a>
						</div>
						<div class="cs-pbwp-content">
							<div class="cs-wrapp-clone cs-shortcode-wrapp">
								<?php
								$wp_rem_opt_array = array(
									'name' => wp_rem_plugin_text_srt( 'wp_rem_element_title' ),
									'desc' => '',
									'hint_text' => wp_rem_plugin_text_srt( 'wp_rem_element_title_hint' ),
									'echo' => true,
									'field_params' => array(
										'std' => $property_subtitle,
										'id' => 'property_compare_title',
										'cust_name' => 'property_compare_title[]',
										'return' => true,
									),
								);

								$wp_rem_html_fields->wp_rem_text_field( $wp_rem_opt_array );
								?>
							</div>
							<?php if ( isset( $_POST['shortcode_element'] ) && $_POST['shortcode_element'] == 'shortcode' ) { ?>
								<ul class="form-elements insert-bg">
									<li class="to-field">
										<a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo str_replace( 'wp_rem_cs_var_page_builder_', '', $name ); ?>', '<?php echo esc_js( $name . $wp_rem_cs_counter ) ?>', '<?php echo esc_js( $filter_element ); ?>')" ><?php echo wp_rem_plugin_text_srt( 'wp_rem_insert' ); ?></a>
									</li>
								</ul>
								<div id="results-shortocde"></div>
							<?php } else { ?>

								<?php
								$wp_rem_cs_opt_array = array(
									'std' => 'wp_rem_compare_property',
									'id' => '',
									'before' => '',
									'after' => '',
									'classes' => '',
									'extra_atr' => '',
									'cust_id' => 'wp_rem_cs_orderby' . $wp_rem_cs_counter,
									'cust_name' => 'wp_rem_cs_orderby[]',
									'required' => false
								);
								$wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render( $wp_rem_cs_opt_array );

								$wp_rem_cs_opt_array = array(
									'name' => '',
									'desc' => '',
									'hint_text' => '',
									'echo' => true,
									'field_params' => array(
										'std' => wp_rem_plugin_text_srt( 'wp_rem_save' ),
										'cust_id' => 'wp_rem_compare_property_save',
										'cust_type' => 'button',
										'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
										'classes' => 'cs-wp_rem_cs-admin-btn',
										'cust_name' => 'wp_rem_compare_property_save',
										'return' => true,
									),
								);

								$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_opt_array );
							}
							?>
						</div>
					</div>
					<script type="text/javascript">
						popup_over();
					</script>
				</div>

				<?php
			}
			if ( $die <> 1 ) {
				die();
			}
		}
		
		public function wp_rem_cs_save_page_builder_data_wp_rem_compare_property_callback( $args ) {

			$data = $args['data'];
			$counters = $args['counters'];
			$widget_type = $args['widget_type'];
			$column = $args['column'];
			$shortcode_data = '';
			if ( $widget_type == "wp_rem_compare_property" || $widget_type == "cs_wp_rem_compare_property" ) {
				$wp_rem_cs_bareber_wp_rem_compare_property = '';

				$page_element_size = $data['wp_rem_compare_property_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_compare_property']];
				$current_element_size = $data['wp_rem_compare_property_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_compare_property']];

				if ( isset( $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] ) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
					$shortcode_str = stripslashes( ( $data['shortcode']['wp_rem_compare_property'][$counters['wp_rem_cs_shortcode_counter_wp_rem_compare_property']] ) );

					$element_settings = 'wp_rem_compare_property_element_size="' . $current_element_size . '"';
					$reg = '/wp_rem_compare_property_element_size="(\d+)"/s';
					$shortcode_str = preg_replace( $reg, $element_settings, $shortcode_str );
					$shortcode_data = $shortcode_str;

					$wp_rem_cs_bareber_wp_rem_compare_property ++;
				} else {
					$element_settings = 'wp_rem_compare_property_element_size="' . htmlspecialchars( $data['wp_rem_compare_property_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_compare_property']] ) . '"';
					$wp_rem_cs_bareber_wp_rem_compare_property = '[wp_rem_compare_property ' . $element_settings . ' ';
					if ( isset( $data['property_compare_title'][$counters['wp_rem_cs_counter_wp_rem_compare_property']] ) && $data['property_compare_title'][$counters['wp_rem_cs_counter_wp_rem_compare_property']] != '' ) {
						$wp_rem_cs_bareber_wp_rem_compare_property .= 'property_compare_title="' . htmlspecialchars( $data['property_compare_title'][$counters['wp_rem_cs_counter_wp_rem_compare_property']], ENT_QUOTES ) . '" ';
					}
					$wp_rem_cs_bareber_wp_rem_compare_property .= ']';
					if ( isset( $data['wp_rem_compare_property_column_text'][$counters['wp_rem_cs_counter_wp_rem_compare_property']] ) && $data['wp_rem_compare_property_column_text'][$counters['wp_rem_cs_counter_wp_rem_compare_property']] != '' ) {
						$wp_rem_cs_bareber_wp_rem_compare_property .= htmlspecialchars( $data['wp_rem_compare_property_column_text'][$counters['wp_rem_cs_counter_wp_rem_compare_property']], ENT_QUOTES ) . ' ';
					}
					$wp_rem_cs_bareber_wp_rem_compare_property .= '[/wp_rem_compare_property]';

					$shortcode_data .= $wp_rem_cs_bareber_wp_rem_compare_property;
					$counters['wp_rem_cs_counter_wp_rem_compare_property'] ++;
				}
				$counters['wp_rem_cs_global_counter_wp_rem_compare_property'] ++;
			}
			return array(
				'data' => $data,
				'counters' => $counters,
				'widget_type' => $widget_type,
				'column' => $shortcode_data,
			);
		}
		
		public function wp_rem_cs_load_shortcode_counters_wp_rem_compare_property_callback( $counters ) {
			$counters['wp_rem_cs_global_counter_wp_rem_compare_property'] = 0;
			$counters['wp_rem_cs_shortcode_counter_wp_rem_compare_property'] = 0;
			$counters['wp_rem_cs_counter_wp_rem_compare_property'] = 0;
			return $counters;
		}
		
		function wp_rem_cs_element_list_populate_wp_rem_compare_property_callback( $element_list ) {
			$element_list['wp_rem_compare_property'] = wp_rem_plugin_text_srt( 'wp_rem_compare_shortcode_heading' );
			return $element_list;
		}
		
		public function wp_rem_cs_shortcode_names_list_populate_wp_rem_compare_property_callback( $shortcode_array ) {
			$shortcode_array['wp_rem_compare_property'] = array(
				'title' => wp_rem_plugin_text_srt( 'wp_rem_compare_shortcode_heading' ),
				'name' => 'wp_rem_compare_property',
				'icon' => 'icon-compare',
				'categories' => 'typography',
			);

			return $shortcode_array;
		}

	}
	
	new wp_rem_compare_properties();
}
