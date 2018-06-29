<?php
/**
 * File Type: Yelp List results for property
 */
if ( ! class_exists( 'wp_rem_yelp_list_results' ) ) {

	class wp_rem_yelp_list_results {

		public function __construct() {
			add_action( 'wp_rem_restaurant_yelp_results', array( $this, 'business_results' ), 10, 1 );
			add_filter( 'wp_rem_yelp_categories', array( $this, 'business_categories' ), 10, 1 );
		}

		/**
		 * List Categories
		 */
		public function business_categories( $cats = array() ) {

			$cats = array(
				'food' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_food' ),
				'nightlife' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_nightlife' ),
				'restaurants' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_restaurants' ),
				'shopping' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_shopping' ),
				'active-life' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_active_life' ),
				'arts-entertainment' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_arts_entertainment' ),
				'automotive' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_automotive' ),
				'beauty-spas' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_beauty_spas' ),
				'education' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_education' ),
				'event-planning-services' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_event_planning_services' ),
				'health-medical' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_health_medical' ),
				'home-services' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_home_services' ),
				'local-services' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_local_services' ),
				'financial-services' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_financial_services' ),
				'hotels-travel' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_hotels_travel' ),
				'local-flavor' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_local_flavor' ),
				'mass-media' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_mass_media' ),
				'pets' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_pets' ),
				'professional-services' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_professional_services' ),
				'public-services-govt' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_public_services_govt' ),
				'real-estate' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_real_estate' ),
				'religious-organizations' => wp_rem_plugin_text_srt( 'wp_rem_yelp_places_religious_organizations' ),
			);

			return $cats;
		}

		/**
		 * List Results return
		 */
		public function business_results( $property_id = '' ) {
			global $wp_rem_plugin_options;
			$access_token = isset( $wp_rem_plugin_options['wp_rem_yelp_access_token'] ) ? $wp_rem_plugin_options['wp_rem_yelp_access_token'] : '';

			$all_cats = $this->business_categories();
			$terms = isset( $wp_rem_plugin_options['wp_rem_yelp_places_cats'] ) ? $wp_rem_plugin_options['wp_rem_yelp_places_cats'] : '';
			$lat = get_post_meta( $property_id, 'wp_rem_post_loc_latitude_property', true );
			$long = get_post_meta( $property_id, 'wp_rem_post_loc_longitude_property', true );
			$limit = 3;

			if ( is_array( $terms ) && $access_token != '' && $lat != '' && $long != '' ) {
				?>
				<div id="best-of-yelp-module" class="ysection">
					<div class="element-title">
						<h3><?php echo wp_rem_plugin_text_srt( 'wp_rem_yelp_places_nearby' ); ?></h3>
						<div class="yelp-logo">
							<a href="https://yelp.com" target="_blank"><img src="<?php echo wp_rem::plugin_url() ?>assets/frontend/images/yelp-logo.jpg" alt=""></a>
						</div>
					</div>
					<div class="stage">
						<div class="best-of-yelp-main">
							<div class="main-content">

								<?php
								foreach ( $terms as $term ) {
									?>
									<ul class="content-list ylist-bordered">
										<?php
										$cate_title = '';
										$cate_term = '';
										if ( array_key_exists( $term, $all_cats ) ) {
											$cate_title = isset( $all_cats[$term] ) ? $all_cats[$term] : '';
											$cate_term = str_replace( '-', '+', $term );
										}
										
										//$data = wp_remote_get( 'https://api.yelp.com/v3/businesses/search?term=' . $cate_term . '&latitude=' . $lat . '&longitude=' . $long . '&limit=' . $limit, array( 'headers' => array( 'Authorization' => "Bearer {$access_token}" ) ) );
										
										$options = array(
											'http' => array(
												'method' => "GET",
												'header' => "Authorization: Bearer " . $access_token . "\r\n"
											)
										);
										$context = stream_context_create($options);
										$data = @file_get_contents('https://api.yelp.com/v3/businesses/search?term=' . $cate_term . '&latitude=' . $lat . '&longitude=' . $long . '&limit=' . $limit . '', false, $context);

										if ( $data ) {
											$data = json_decode( $data, true );
											if ( is_array( $data ) && isset( $data['businesses'] ) && ! empty( $data['businesses'] ) ) {
												?>
												<li>
													<div class="arrange">
														<div class="arrange_unit">
															<h5><?php echo esc_html( $cate_title ) ?></h5>
														</div>
													</div>
													<div class="content">
														<ul class="ylist">
															<?php
															foreach ( $data['businesses'] as $data_business ) {
																$image_url = isset( $data_business['image_url'] ) ? $data_business['image_url'] : '';
																if ( $image_url != '' ) {
																	$image_url = str_replace( 'o.jpg', 'm.jpg', $image_url );
																}
																$business_url = isset( $data_business['url'] ) ? $data_business['url'] : '';
																$business_name = isset( $data_business['name'] ) ? $data_business['name'] : '';
																$business_total_reviews = isset( $data_business['review_count'] ) ? $data_business['review_count'] : '';
																$business_rating = isset( $data_business['rating'] ) ? $data_business['rating'] : '';
																$business_address0 = isset( $data_business['location']['display_address'][0] ) ? $data_business['location']['display_address'][0] : '';
																$business_address1 = isset( $data_business['location']['display_address'][1] ) ? $data_business['location']['display_address'][1] : '';
																$business_address2 = isset( $data_business['location']['display_address'][2] ) ? $data_business['location']['display_address'][2] : '';

																$business_address = $business_address0 . ' ' . $business_address1 . ' ' . $business_address2;

																$business_categories = isset( $data_business['categories'] ) ? $data_business['categories'] : '';
																$business_cats_str = '';
																if ( ! empty( $business_categories ) && count( $business_categories ) > 0 ) {
																	$business_cats_str .= '<span class="category-name">' . wp_rem_plugin_text_srt( 'wp_rem_yelp_places_category' ) . ' ';
																	$business_cat_count = 0;
																	foreach ( $business_categories as $business_cat ) {
																		$business_cat_title = isset( $business_cat['title'] ) ? $business_cat['title'] : '';
																		$business_cat_alias = isset( $business_cat['alias'] ) ? $business_cat['alias'] : '';
																		if ( $business_cat_title != '' && $business_cat_alias != '' ) {
																			$comma_str = $business_cat_count == 0 ? '' : ', ';
																			$business_cats_str .= $comma_str . '<em>' . $business_cat_title . '</em>';
																			$business_cat_count ++;
																		}
																	}
																	$business_cats_str .= '</span>';
																}


																if ( $business_rating > 0 ) {
																	$business_rating = ($business_rating / 5) * 100;
																} else {
																	$business_rating = 0;
																}
																?>
																<li class="media-block">
																	<?php
																	if ( $image_url != '' ) {
																		?>
																		<div class="media-avatar" style="background-image:url('<?php echo esc_url( $image_url ) ?>');">
																			<div class="photo-box">
																				<a href="<?php echo esc_url_raw( $business_url ) ?>" target="_blank"></a>
																			</div>
																		</div>
																		<?php
																	} else {
																		?>
																		<div class="media-avatar">
																			<div class="photo-box">
																				<a href="<?php echo esc_url_raw( $business_url ) ?>" target="_blank"></a>
																			</div>
																		</div>
																		<?php
																	}
																	?>
																	<div class="media-story">
																		<?php echo force_balance_tags( $business_cats_str ) ?>
																		<div class="media-title">
																			<span class="indexed-biz-name">
																				<a href="<?php echo esc_url_raw( $business_url ) ?>" target="_blank" class="biz-name"><span><?php echo esc_html( $business_name ) ?></span></a>
																			</span>
																		</div>
																		<div class="biz-rating biz-rating-medium">
																			<div class="i-stars i-stars-small-5 rating">
																				<span class="rating-stars" style="width: <?php echo ($business_rating) ?>% !important;"></span>
																			</div>
																			<span class="review-count rating-qualifier"><?php printf( wp_rem_plugin_text_srt( 'wp_rem_yelp_places_reviews' ), absint( $business_total_reviews ) ) ?></span>
																		</div>
																		<div class="location"><span><?php echo esc_html( $business_address ) ?></span></div>
																	</div>
																</li>
																<?php
															}
															?>
														</ul>
													</div>
												</li> 
												<?php
											}
										}
										?>
									</ul>
									<?php
								}
								?>

							</div>
						</div>
					</div>
				</div>
				<?php
			}
		}

	}

	$wp_rem_yelp_list_results = new wp_rem_yelp_list_results();
}