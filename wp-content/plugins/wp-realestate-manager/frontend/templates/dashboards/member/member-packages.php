<?php
/**
 * Member Properties
 *
 */
if ( ! class_exists('Wp_rem_Member_Packages') ) {

	class Wp_rem_Member_Packages {

		/**
		 * Start construct Functions
		 */
		public function __construct() {
			add_action('wp_ajax_wp_rem_member_packages', array( $this, 'wp_rem_member_packages_callback' ), 11, 1);
		}

		/**
		 * Member Properties
		 * @ filter the properties based on member id
		 */
		public function wp_rem_member_packages_callback($member_id = '') {
			global $current_user;
			$member_id = wp_rem_company_id_form_user_id($current_user->ID);

			$wp_rem_current_date = strtotime(date('d-m-Y'));
			$args = array(
				'posts_per_page' => "-1",
				'post_type' => 'package-orders',
				'post_status' => 'publish',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => 'wp_rem_transaction_user',
						'value' => $member_id,
						'compare' => '=',
					),
					array(
						'key' => 'wp_rem_transaction_expiry_date',
						'value' => $wp_rem_current_date,
						'compare' => '>',
					),
					array(
						'key' => 'wp_rem_transaction_status',
						'value' => 'approved',
						'compare' => '=',
					),
				),
			);

			$pkg_query = new WP_Query($args);
			echo force_balance_tags($this->render_view($pkg_query));
			wp_reset_postdata();
			wp_die();
		}
		
		public function purchase_package_info_field_show($value = '', $label = '', $value_plus = '') {

			if ( $value != '' && $value != 'on' ) {
				$html = '<li><label>' . $label . '</label><span>' . $value . ' ' . $value_plus . '</span></li>';
			} else if ( $value != '' && $value == 'on' ) {
				$html = '<li><label>' . $label . '</label><span><i class="icon-check"></i></span></li>';
			} else {
				$html = '<li><label>' . $label . '</label><span><i class="icon-minus"></i></span></li>';
			}

			return $html;
		}

		public function render_view($pkg_query) {
			global $wp_rem_plugin_options;
			$wp_rem_currency_sign = wp_rem_get_currency_sign();
                        
                        $has_border = ' has-border';
                        if ( isset($pkg_query) && $pkg_query != '' && $pkg_query->have_posts() ) :
                             $has_border = '';
                        endif;
                        ?>
			<div class="user-packages">
				<div class="element-title<?php echo wp_rem_allow_special_char($has_border); ?>">
					<h4><?php echo wp_rem_plugin_text_srt('wp_rem_member_pkg_pkgs'); ?></h4>
				</div>
			</div>
			<div class="user-packages-list">
				<?php if ( isset($pkg_query) && $pkg_query != '' && $pkg_query->have_posts() ) : ?>
					<div class="all-pckgs-sec">
						<?php
						while ( $pkg_query->have_posts() ) : $pkg_query->the_post();
							$transaction_package = get_post_meta(get_the_ID(), 'wp_rem_transaction_package', true);
							$transaction_expiry_date = get_post_meta(get_the_ID(), 'wp_rem_transaction_expiry_date', true);
							$transaction_properties = get_post_meta(get_the_ID(), 'wp_rem_transaction_properties', true);
							$transaction_feature_list = get_post_meta(get_the_ID(), 'wp_rem_transaction_property_feature_list', true);
							$transaction_top_cat_list = get_post_meta(get_the_ID(), 'wp_rem_transaction_property_top_cat_list', true);
							$wp_rem_currency_sign = get_post_meta(get_the_ID(), 'wp_rem_currency', true);
                                                        $wp_rem_currency_sign   = ( $wp_rem_currency_sign != '' )? $wp_rem_currency_sign : '$';
                                                        $currency_position = get_post_meta(get_the_ID(), 'wp_rem_currency_position', true);
							$package_id = get_the_ID();
							$transaction_properties = isset($transaction_properties) ? $transaction_properties : 0;
							$transaction_feature_list = isset($transaction_feature_list) ? $transaction_feature_list : 0;
							$transaction_top_cat_list = isset($transaction_top_cat_list) ? $transaction_top_cat_list : 0;
							
							$package_price = get_post_meta($package_id, 'wp_rem_transaction_amount', true);
							
							$html = '';
							?>
							<div class="wp-rem-pkg-holder">
								<div class="wp-rem-pkg-header">
									<div class="pkg-title-price pull-left">
										<label class="pkg-title"><?php echo get_the_title($transaction_package); ?></label>
										<span class="pkg-price"><?php printf( wp_rem_plugin_text_srt( 'wp_rem_member_price_s' ), wp_rem_get_order_currency( $package_price, $wp_rem_currency_sign, $currency_position )) ?></span>
									</div>
									<div class="pkg-detail-btn pull-right">
										<a data-id="<?php echo absint($package_id) ?>" class="wp-rem-dev-dash-detail-pkg" href="javascript:void(0);"><?php echo wp_rem_plugin_text_srt('wp_rem_member_pkg_detail'); ?></a>
									</div>
								</div>
								<div class="package-info-sec property-info-sec" style="display:none;" id="package-detail-<?php echo absint($package_id) ?>">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<ul class="property-pkg-points">
												<?php
												$trans_packg_expiry = get_post_meta($package_id, 'wp_rem_transaction_expiry_date', true);
												$trans_packg_list_num = get_post_meta($package_id, 'wp_rem_transaction_properties', true);
												$trans_packg_list_expire = get_post_meta($package_id, 'wp_rem_transaction_property_expiry', true);
												$wp_rem_property_ids = get_post_meta($package_id, 'wp_rem_property_ids', true);

												if ( empty($wp_rem_property_ids) ) {
													$wp_rem_property_used = 0;
												} else {
													$wp_rem_property_used = absint(sizeof($wp_rem_property_ids));
												}

												$wp_rem_property_remain = '0';
												if ( (int) $trans_packg_list_num > (int) $wp_rem_property_used ) {
													$wp_rem_property_remain = (int) $trans_packg_list_num - (int) $wp_rem_property_used;
												}

												$trans_featured_num = get_post_meta($package_id, 'wp_rem_transaction_property_feature_list', true);
												$wp_rem_featured_ids = get_post_meta($package_id, 'wp_rem_featured_ids', true);
												if ( empty($wp_rem_featured_ids) ) {
													$wp_rem_featured_used = 0;
												} else {
													$wp_rem_featured_used = absint(sizeof($wp_rem_featured_ids));
												}
												$wp_rem_featured_remain = '0';
												if ( (int) $trans_featured_num > (int) $wp_rem_featured_used ) {
													$wp_rem_featured_remain = (int) $trans_featured_num - (int) $wp_rem_featured_used;
												}

												$trans_top_cat_num = get_post_meta($package_id, 'wp_rem_transaction_property_top_cat_list', true);
												$wp_rem_top_cat_ids = get_post_meta($package_id, 'wp_rem_top_cat_ids', true);

												if ( empty($wp_rem_top_cat_ids) ) {
													$wp_rem_top_cat_used = 0;
												} else {
													$wp_rem_top_cat_used = absint(sizeof($wp_rem_top_cat_ids));
												}

												$wp_rem_top_cat_remain = '0';
												if ( (int) $trans_top_cat_num > (int) $wp_rem_top_cat_used ) {
													$wp_rem_top_cat_remain = (int) $trans_top_cat_num - (int) $wp_rem_top_cat_used;
												} 
												$trans_pics_num = get_post_meta($package_id, 'wp_rem_transaction_property_pic_num', true);
												$trans_docs_num = get_post_meta($package_id, 'wp_rem_transaction_property_doc_num', true);
												$trans_tags_num = get_post_meta($package_id, 'wp_rem_transaction_property_tags_num', true);
												$trans_reviews = get_post_meta($package_id, 'wp_rem_transaction_property_reviews', true);

												$trans_phone = get_post_meta($package_id, 'wp_rem_transaction_property_phone', true);
												$trans_website = get_post_meta($package_id, 'wp_rem_transaction_property_website', true);
												$trans_social = get_post_meta($package_id, 'wp_rem_transaction_property_social', true);
												$trans_ror = get_post_meta($package_id, 'wp_rem_transaction_property_ror', true);
												$trans_dynamic_f = get_post_meta($package_id, 'wp_rem_transaction_dynamic', true);

												$pkg_expire_date = date_i18n(get_option('date_format'), $trans_packg_expiry);

												$html .= $this->purchase_package_info_field_show($pkg_expire_date, wp_rem_plugin_text_srt( 'wp_rem_member_expiry_date' ));
												$html .= '<li><label>' . wp_rem_plugin_text_srt( 'wp_rem_member_properties' ) . '</label><span>' . absint($wp_rem_property_used) . '/' . absint($trans_packg_list_num) . '</span></li>';
												$html .= $this->purchase_package_info_field_show($trans_packg_list_expire, wp_rem_plugin_text_srt( 'wp_rem_member_properties_duration' ), wp_rem_plugin_text_srt( 'wp_rem_member_days' ));
												if ( absint($trans_featured_num) > 0 ) {
													$html .= '<li><label>' . wp_rem_plugin_text_srt( 'wp_rem_member_featured_properties' ) . '</label><span>' . absint($wp_rem_featured_used) . '/' . absint($trans_featured_num) . '</span></li>';
												} else {
													$html .= '<li><label>' . wp_rem_plugin_text_srt( 'wp_rem_member_featured_properties' ) . '</label><span>0</span></li>';
												}
												if ( absint($trans_top_cat_num) > 0 ) {
													$html .= '<li><label>' . wp_rem_plugin_text_srt( 'wp_rem_member_top_categories_properties' ) . '</label><span>' . absint($wp_rem_top_cat_used) . '/' . absint($trans_top_cat_num) . '</span></li>';
												} else {
													$html .= '<li><label>' . wp_rem_plugin_text_srt( 'wp_rem_member_top_categories_properties' ) . '</label><span>0</span></li>';
												}

												$html .= $this->purchase_package_info_field_show($trans_pics_num, wp_rem_plugin_text_srt( 'wp_rem_member_add_list_no_of_pictures' ));
												$html .= $this->purchase_package_info_field_show($trans_docs_num, wp_rem_plugin_text_srt( 'wp_rem_member_add_list_no_of_docs' ));
												$html .= $this->purchase_package_info_field_show($trans_tags_num, wp_rem_plugin_text_srt( 'wp_rem_member_add_list_no_of_tags' ));
												$html .= $this->purchase_package_info_field_show($trans_phone, wp_rem_plugin_text_srt( 'wp_rem_member_add_list_phone_number' ));
												$html .= $this->purchase_package_info_field_show($trans_website, wp_rem_plugin_text_srt( 'wp_rem_member_add_list_web_link' ));
												$html .= $this->purchase_package_info_field_show($trans_social, wp_rem_plugin_text_srt( 'wp_rem_member_add_list_social_reach' ));

												$dyn_fields_html = '';
												if ( is_array($trans_dynamic_f) && sizeof($trans_dynamic_f) > 0 ) {
													foreach ( $trans_dynamic_f as $trans_dynamic ) {
														if ( isset($trans_dynamic['field_type']) && isset($trans_dynamic['field_label']) && isset($trans_dynamic['field_value']) ) {
															$d_type = $trans_dynamic['field_type'];
															$d_label = $trans_dynamic['field_label'];
															$d_value = $trans_dynamic['field_value'];

															if ( $d_value == 'on' && $d_type == 'single-choice' ) {
																$html .= '<li><label>' . $d_label . '</label><span><i class="icon-check"></i></span></li>';
															} else if ( $d_value != '' && $d_type != 'single-choice' ) {
																$html .= '<li><label>' . $d_label . '</label><span>' . $d_value . '</span></li>';
															} else {
																$html .= '<li><label>' . $d_label . '</label><span><i class="icon-minus"></i></span></li>';
															}
														}
													}
													// end foreach
												}
												// emd of Dynamic fields
												// other Features
												echo force_balance_tags($html);
												?>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<?php
						endwhile;
						?>

					</div>
					<?php
				else:
					echo wp_rem_plugin_text_srt('wp_rem_member_pkg_sorry_no_pkg');
				endif;
				?>
			</div>
			<?php
		}

		public function render_list_item_view($pkg_query) {
			
		}

	}

	global $wp_rem_member_packages;
	$wp_rem_member_packages = new Wp_rem_Member_Packages();
}
