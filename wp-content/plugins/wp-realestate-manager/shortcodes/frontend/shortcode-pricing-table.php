<?php
/**
 * File Type: Searchs Shortcode Frontend
 */
if ( ! class_exists('Wp_rem_Shortcode_Pricing_Table_front') ) {

	class Wp_rem_Shortcode_Pricing_Table_front {

		/**
		 * Constant variables
		 */
		var $PREFIX = 'pricing_table';

		/**
		 * Start construct Functions
		 */
		public function __construct() {
			add_shortcode($this->PREFIX, array( $this, 'wp_rem_pricing_table_shortcode_callback' ));
		}

		/*
		 * Shortcode View on Frontend
		 */

		public function wp_rem_pkgs($value = '') {
			$pkgs_options = '';
			$args = array( 'posts_per_page' => '-1', 'post_type' => 'packages', 'post_status' => 'publish', 'orderby' => 'title', 'order' => 'ASC' );
			$cust_query = get_posts($args);
			$pkgs_options .= '<option value="">' . wp_rem_plugin_text_srt('wp_rem_select_packages') . '</option>';
			if ( is_array($cust_query) && sizeof($cust_query) > 0 ) {
				$pkg_counter = 1;
				foreach ( $cust_query as $pkg_post ) {
					$option_selected = '';
					if ( $value != '' && $value == $pkg_post->ID ) {
						$option_selected = ' selected="selected"';
					}
					$pkgs_options .= '<option' . $option_selected . ' value="' . $pkg_post->ID . '">' . get_the_title($pkg_post->ID) . '</option>' . "\n";
					$pkg_counter ++;
				}
			}

			$select_field = '<select name="pt_pkg_url[]">' . $pkgs_options . '</select>';

			return $select_field;
		}

		function combine_pt_section($keys, $values) {
			$result = array();
			foreach ( $keys as $i => $k ) {
				$result[$k][] = $values[$i];
			}
			array_walk($result, create_function('&$v', '$v = (count($v) == 1)? array_pop($v): $v;'));
			return $result;
		}

		public function wp_rem_pricing_table_shortcode_callback($atts, $content = "") {
			global $current_user, $wp_rem_plugin_options, $wp_rem_form_fields_frontend;

			$pricing_table_id = isset($atts['wp_rem_pricing_tables']) ? $atts['wp_rem_pricing_tables'] : '';
			$pricing_table_title = isset($atts['pricing_table_title']) ? $atts['pricing_table_title'] : '';
			$pricing_tabl_subtitle = isset($atts['pricing_table_subtitle']) ? $atts['pricing_table_subtitle'] : '';
			$pricing_table_title_align = isset($atts['pricing_table_title_align']) ? $atts['pricing_table_title_align'] : '';
			$pricing_table_view = isset($atts['pricing_table_view']) ? $atts['pricing_table_view'] : '';
			ob_start();
			$page_element_size = isset($atts['pricing_table_element_size']) ? $atts['pricing_table_element_size'] : 100;
			if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
				echo '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
			}
			$rand_numb = rand(1000000, 99999999);
			if ( isset($_POST['wp_rem_package_buy']) && $_POST['wp_rem_package_buy'] == '1' ) {
				$package_id = isset($_POST['package_id']) ? $_POST['package_id'] : 0;

				$wp_rem_price_table_property_switch = get_post_meta($pricing_table_id, 'wp_rem_subscribe_action', true);

				if ( is_user_logged_in() && current_user_can('wp_rem_member') ) {
					if ( $wp_rem_price_table_property_switch == 'property' ) {
						$wp_rem_dashboard_page = isset($wp_rem_plugin_options['wp_rem_member_dashboard']) ? $wp_rem_plugin_options['wp_rem_member_dashboard'] : '';
						$wp_rem_dashboard_link = $wp_rem_dashboard_page != '' ? get_permalink($wp_rem_dashboard_page) : '';
						$redirect_form_id = rand(1000000, 9999999);
						$redirect_html = '
						<form id="form-' . $redirect_form_id . '" method="get" action="' . $wp_rem_dashboard_link . '">' .
								$wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
										array(
											'simple' => true,
											'cust_id' => '',
											'cust_name' => 'tab',
											'return' => true,
											'std' => 'add-property',
										)
								) .
								$wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
										array(
											'simple' => true,
											'cust_id' => '',
											'cust_name' => 'package_id',
											'return' => true,
											'std' => $package_id,
										)
						);
						if ( isset($_GET['lang']) ) {
							$redirect_html .= $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
									array(
										'simple' => true,
										'cust_id' => '',
										'cust_name' => 'lang',
										'return' => true,
										'std' => $_GET['lang'],
									)
							);
						}
						$redirect_html .= '
						</form>
						<script>document.getElementById("form-' . $redirect_form_id . '").submit();</script>';
						echo force_balance_tags($redirect_html);
					} else {

						$form_rand_numb = isset($_POST['wp_rem_package_random']) ? $_POST['wp_rem_package_random'] : '';
						$form_rand_transient = get_transient('wp_rem_package_random');

						if ( $form_rand_transient != $form_rand_numb ) {

							$wp_rem_property_obj = new wp_rem_member_property_actions();
							$company_id = wp_rem_company_id_form_user_id($current_user->ID);

							set_transient('wp_rem_package_random', $form_rand_numb, 60 * 60 * 24 * 30);

							$wp_rem_property_obj->wp_rem_property_add_transaction('buy_package', 0, $package_id, $company_id);
						}
					}
				}
			}

			$no_member_msg = '';
			if ( is_user_logged_in() && ! current_user_can('wp_rem_member') ) {
				$no_member_msg = '
				<div id="response-' . $rand_numb . '" class="response-holder" style="display: none;">
					<div class="alert alert-warning fade in">' . wp_rem_plugin_text_srt('wp_rem_packages_become_member') . '</div>
				</div>';
			}

			if ( $pricing_table_title != '' || $pricing_tabl_subtitle != '' ) {

				$wp_rem_element_structure = '';
				$wp_rem_element_structure = wp_rem_plugin_title_sub_align($pricing_table_title, $pricing_tabl_subtitle, $pricing_table_title_align);
				echo force_balance_tags($wp_rem_element_structure);
			}
			if ( $pricing_table_id != '' ) {

				$pt_pkg_name = get_post_meta($pricing_table_id, 'wp_rem_pt_pkg_names', true);
				$pt_pkg_price = get_post_meta($pricing_table_id, 'wp_rem_pt_pkg_prices', true);
				$pt_pkg_desc = get_post_meta($pricing_table_id, 'wp_rem_pt_pkg_descs', true);
				$pt_pkg_btn_txt = get_post_meta($pricing_table_id, 'wp_rem_pt_pkg_btn_txts', true);
				$pt_pkg_feat = get_post_meta($pricing_table_id, 'wp_rem_pt_pkg_feats', true);
				$pt_pkg_url = get_post_meta($pricing_table_id, 'wp_rem_pt_pkg_urls', true);
				$row_num_input = get_post_meta($pricing_table_id, 'wp_rem_pt_row_num', true);
				$pt_col_input = get_post_meta($pricing_table_id, 'wp_rem_pt_col_vals', true);
				$pt_col_sub_input = get_post_meta($pricing_table_id, 'wp_rem_pt_col_subs', true);
				$pt_row_title = get_post_meta($pricing_table_id, 'wp_rem_pt_row_title', true);
				$pt_pkg_dur = get_post_meta($pricing_table_id, 'wp_rem_pt_pkg_durs', true);
				$pt_pkg_color = get_post_meta($pricing_table_id, 'wp_rem_pt_pkg_color', true);
				$pt_sec_val = get_post_meta($pricing_table_id, 'wp_rem_pt_sec_vals', true);
				$pt_sec_pos = get_post_meta($pricing_table_id, 'wp_rem_pt_sec_pos', true);
				$counter = 0;
				$internal_counter = 1;
				$number_of_pack = count($pt_pkg_name);
				$number_of_rows = count($pt_row_title);
				$totla_features = count($pt_col_input);
				$number_of_cols = $totla_features / $number_of_pack;
				$row_numbers = $totla_features / $number_of_rows;
				$new_col = 0;
				if ( is_array($pt_col_input) ) {
					$chunked_array = (array_chunk($pt_col_input, $row_numbers));
				}
				if ( is_array($pt_col_sub_input) ) {
					$pt_col_icon = (array_chunk($pt_col_sub_input, $row_numbers));
				}

				if ( is_array($pt_pkg_name) && sizeof($pt_pkg_name) > 0 ) {
						?>
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="membership-info-main">
									 <div class="table-responsive">
										<table>
											<thead>
												<?php
												$output = '';
												$featured_flag = false;
												if( !empty($pt_pkg_name)){
													$output .= '<td></td>';
													foreach ( $pt_pkg_name as $key => $val ) {
														$featured = isset($pt_pkg_feat[$key]) ? $pt_pkg_feat[$key] : '';
														if( $featured == 'yes' ){
															$output .= '<td class="active"><span class="popular-plan text-color">'. wp_rem_cs_var_theme_text_srt('wp_rem_price_plan_most_popular') .'</span></td>'."\n";
															$featured_flag = true;
														}else{
															$output .= '<td></td>'."\n";
														}
													}
												}
												if( $featured_flag == true ){
													echo '<tr class="most-popular">'."\n";
														echo $output;
													echo '</tr>'."\n";
												}
												?>
												
												<tr>
													<?php
													if ( $pt_pkg_name != '' ) {
														echo ' <td></td>';
														foreach ( $pt_pkg_name as $key => $val ) {
															$featured = isset($pt_pkg_feat[$key]) ? $pt_pkg_feat[$key] : '';
															$price = isset($pt_pkg_price[$key]) ? $pt_pkg_price[$key] : '';
															$pkg_id = isset($pt_pkg_url[$key]) ? $pt_pkg_url[$key] : '';
															$pkg_btn_txt = isset($pt_pkg_btn_txt[$key]) && $pt_pkg_btn_txt[$key] != '' ? $pt_pkg_btn_txt[$key] : wp_rem_plugin_text_srt('wp_rem_packages_buy_now');
															
															$active_class = '';
															if( $featured == 'yes' ){
																$active_class = ' class="active"';
															}
															?>
															<td<?php echo $active_class; ?>>
																<?php if( $val != '' ){ ?>
																	<span class="package-title"><?php echo esc_html($val); ?></span>
																<?php } ?>
																<?php
																if ( is_user_logged_in() && current_user_can('wp_rem_member') ) {
																	if ( true === Wp_rem_Member_Permissions::check_permissions('packages') ) {
																		?>
																		<form method="post">
																			<?php
																			$wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
																					array(
																						'simple' => true,
																						'cust_id' => '',
																						'cust_name' => 'wp_rem_package_buy',
																						'std' => '1',
																					)
																			);
																			$wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
																					array(
																						'simple' => true,
																						'cust_id' => '',
																						'cust_name' => 'wp_rem_package_random',
																						'std' => absint($rand_numb),
																					)
																			);
																			$wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
																					array(
																						'simple' => true,
																						'cust_id' => '',
																						'cust_name' => 'package_id',
																						'std' => absint($pkg_id),
																					)
																			);
																			$wp_rem_form_fields_frontend->wp_rem_form_text_render(
																					array(
																						'cust_name' => '',
																						'classes' => 'pkg-buy-btn property-pkg-select',
																						'std' => esc_html($pkg_btn_txt),
																						'cust_type' => "submit",
																					)
																			);
																			?>    
																		</form>
																		<?php
																	}
																} else if ( is_user_logged_in() && ! current_user_can('wp_rem_member') ) {
																	?>
																	<a data-id="<?php echo absint($rand_numb) ?>" href="javascript:void(0);" class="wp-rem-subscribe-pkg pkg-buy-btn property-pkg-select"><?php echo esc_html($pkg_btn_txt) ?></a>
																	<?php
																} else if ( ! is_user_logged_in() ) {
																	?>
																	<a href="#" data-target="#sign-in" data-msg="<?php echo wp_rem_plugin_text_srt('wp_rem_packages_login_first'); ?>" data-toggle="modal" class="wp-rem-subscribe-pkg pkg-buy-btn wp-rem-open-signin-tab property-pkg-select"><?php echo esc_html($pkg_btn_txt) ?></a>
																	<?php
																}
																?>
															</td>
															<?php
														}
													}
													?>
												</tr>
											</thead>
											<tbody>
												<tr class="pt_section has-bg">
													<?php
													if ( $pt_pkg_name != '' ) {
														echo ' <td><span>' . wp_rem_plugin_text_srt('wp_rem_package_price') . '</span></td>';
														foreach ( $pt_pkg_name as $key => $val ) {
															$price = isset($pt_pkg_price[$key]) ? $pt_pkg_price[$key] : '';
															$featured = isset($pt_pkg_feat[$key]) ? $pt_pkg_feat[$key] : '';
															
															$active_class = '';
															if( $featured == 'yes' ){
																$active_class = ' class="active"';
															}
															?>
															<td<?php echo $active_class; ?>>
																<strong>
																	<?php
																	if ( is_numeric($price) && $price > 0 ) {
																		echo wp_rem_get_currency($price, true);
																	} else if ( is_numeric($price) ) {
																		echo wp_rem_plugin_text_srt('wp_rem_package_type_free');
																	} else {
																		echo esc_html($price);
																	}
																	?>
																</strong>
															</td>
															<?php
														}
													}
													?>
												</tr>
												<?php
												$table_html = '';
												$row_num_input = get_post_meta($pricing_table_id, 'wp_rem_pt_row_num', true);

												if (
														$row_num_input &&
														is_array($pt_col_input) &&
														(int) $row_num_input > 0 &&
														sizeof($pt_col_input) > 0
												) {
													$row_nums = (int) $row_num_input;
													$col_nums = sizeof($pt_col_input);
													$row_break = 0;
													if ( $col_nums >= $row_nums ) {
														$row_break = $col_nums / $row_nums;
													}

													$rows_array = array();
													if ( $row_break > 0 ) {
														$row_num_field = $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
																array(
																	'simple' => true,
																	'cust_id' => '',
																	'cust_name' => 'dir_pt_row_num[]',
																	'return' => true,
																	'classes' => "row_num_input",
																	'std' => '',
																)
														);
														$row_markup = '';
														$col_markup = '';
														$pt_counter = 1;
														$featured_counter = 0;
														$pt_index_counter = 0;
														$pt_row_counter = 0;
														
														foreach ( $pt_col_input as $col_val ) {
															
															$featured = isset($pt_pkg_feat[$featured_counter]) ? $pt_pkg_feat[$featured_counter] : '';
															$active_class = '';
															if( $featured == 'yes'){
																$active_class = ' class="active"';
															}
															
															$rand_id = rand(10000000, 99999999);
															$pt_sub_input_val = isset($pt_col_sub_input[$pt_index_counter]) ? $pt_col_sub_input[$pt_index_counter] : '';
															$item_icon = '';
															if ( $pt_sub_input_val != '' ) {
																$item_icon = '<i class=" ' . $pt_sub_input_val . '"></i>  ';
															}
															$col_markup .= '<td '. $active_class .'>' . $item_icon . '<span>' . $col_val . ' </span></td>' . "\n";
															if ( $row_break == $pt_counter ) {
																$pt_row_title_txt = isset($pt_row_title[$pt_row_counter]) ? $pt_row_title[$pt_row_counter] : '';
																$pt_row_counter ++;

																$pt_row_del = '<td class="pt_row_actions"><span>' . $pt_row_title_txt . '</span></td>';
																$row_markup .= '<tr class="pt_row">' . $pt_row_del . $col_markup . '</tr>' . "\n";
																$rows_array[] = $row_markup;
																$col_markup = '';
																$row_markup = '';
																$pt_counter = 0;
																$featured_counter = -1;
															}
															$pt_counter ++;
															$featured_counter ++;
															$pt_index_counter ++;
															
														}
													}

													$sections_array = array();
													if (
															is_array($pt_sec_val) &&
															is_array($pt_sec_pos) &&
															sizeof($pt_sec_val) > 0 &&
															sizeof($pt_sec_pos) > 0
													) {
														$sections_array = $this->combine_pt_section($pt_sec_pos, $pt_sec_val);
													}

													if ( sizeof($sections_array) > 0 && isset($sections_array[0]) ) {
														$row_break_new = $row_break + 1;
														$table_html .= '
															<tr class="pt_section has-bg">
																<td colspan="' . $row_break_new . '">
																	<span>' . $sections_array[0] . '</span>
																</td>
															</tr>';
													}
													if ( sizeof($rows_array) > 0 ) {
														$row_counter = 1;
														foreach ( $rows_array as $row_arr ) {
															$table_html .= $row_arr;
															if ( sizeof($sections_array) > 0 && array_key_exists($row_counter, $sections_array) ) {
																if ( is_array($sections_array[$row_counter]) ) {
																	foreach ( $sections_array[$row_counter] as $sec_0 ) {
																		$table_html .= '
																		<tr class="pt_section">
																			<td colspan="' . $row_break . '">' .
																				$wp_rem_form_fields_frontend->wp_rem_form_text_render(
																						array(
																							'cust_name' => 'dir_pt_sec_val[]',
																							'std' => $sec_0,
																							'return' => true,
																						)
																				) . $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
																						array(
																							'simple' => true,
																							'cust_id' => '',
																							'cust_name' => 'dir_pt_sec_pos[]',
																							'return' => true,
																							'std' => ($row_counter),
																						)
																				)
																				. ' 
																			</td>
																		</tr>';
																	}
																} else {
																	if ( sizeof($sections_array) > 0 && isset($sections_array[$row_counter]) ) {
																		$row_break_new = $row_break + 1;
																		$output = '';
																		if( !empty($pt_pkg_name)){
																			foreach ( $pt_pkg_name as $key => $val ) {
																				$featured = isset($pt_pkg_feat[$key]) ? $pt_pkg_feat[$key] : '';
																				if( $featured == 'yes' ){
																					$output .= '<td class="active"></td>'."\n";
																					$featured_flag = true;
																				}else{
																					$output .= '<td></td>'."\n";
																				}
																			}
																		}
																		
																		$table_html .= '
																			<tr class="pt_section has-bg">
																				<td>
																					<span>' . $sections_array[$row_counter] . '</span>
																				</td>
																				'. $output .'
																			</tr>';
																	}
																}
															}
															$row_counter ++;
														}
													}
													echo force_balance_tags($table_html);
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
								<?php echo force_balance_tags($no_member_msg) ?>
							</div>
						</div>
						<?php
					}
				}

				if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
					echo '</div>';
				}
				$html = ob_get_clean();
				return $html;
			}

		}

		global $wp_rem_shortcode_pricing_table_front;
		$wp_rem_shortcode_pricing_table_front = new Wp_rem_Shortcode_Pricing_Table_front();
	}