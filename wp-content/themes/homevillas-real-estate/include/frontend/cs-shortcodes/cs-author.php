<?php
/**
 * @  Blog html form for page builder Frontend side
 *
 *
 */
if ( ! function_exists('wp_rem_cs_author_shortcode') ) {

	function wp_rem_cs_author_shortcode($atts) {
		global $post, $wp_rem_cs_author_element_title, $wpdb, $author_pagination, $wp_rem_cs_author_num_post, $wp_rem_cs_counter_node, $wp_rem_cs_column_atts, $wp_rem_cs_author_description, $wp_rem_cs_author_excerpt, $post_thumb_view, $wp_rem_cs_author_section_title, $args, $wp_rem_cs_author_orderby, $orderby;
		$html = '';
		ob_start();
		$defaults = array(
			'wp_rem_cs_author_element_title' => '',
                        'wp_rem_cs_author_element_subtitle' => '',
			'wp_rem_cs_author_orderby' => 'DESC',
			'orderby' => 'ID',
			'wp_rem_cs_author_description' => 'yes',
			'wp_rem_cs_author_excerpt' => '30',
			'wp_rem_cs_author_num_post' => '10',
			'wp_rem_var_author_align' => '',
		);
		extract(shortcode_atts($defaults, $atts));
		$page_element_size = isset($atts['author_element_size']) ? $atts['author_element_size'] : 100;
		if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
			echo '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
		}

		/*
		 * We start by doing a query to retrieve all users
		 * We need a total user count so that we can calculate how many pages there are
		 */

		$count_args = array(
			'fields' => 'all_with_meta',
			'number' => 999999
		);
		$user_count_query = new WP_User_Query($count_args);
		$user_count = $user_count_query->get_results();
		static $wp_rem_cs_var_custom_counter;
		if ( ! isset($wp_rem_cs_var_custom_counter) ) {
			$wp_rem_cs_var_custom_counter = 1;
		} else {
			$wp_rem_cs_var_custom_counter ++;
		}

// count the number of users found in the query
		$total_users = $user_count ? count($user_count) : 1;
// grab the current page number and set to 1 if no page number is set
		$page = isset($_GET['page_id_all_' . $wp_rem_cs_var_custom_counter]) ? $_GET['page_id_all_' . $wp_rem_cs_var_custom_counter] : 1;

// how many users to show per page
		if ( isset($author_pagination) && $author_pagination == 'yes' ) {
			$users_per_page = $wp_rem_cs_author_num_post;
		} else {
			$users_per_page = $wp_rem_cs_author_num_post;
		}
// calculate the total number of pages.
		$total_pages = 1;
		$offset = $users_per_page * ($page - 1);
		$total_pages = ceil($total_users / $users_per_page);

// main user query
		$args = array(
			'orderby' => 'post_count',
			'fields' => 'all_with_meta',
			'number' => $users_per_page,
			'offset' => $offset,
			'order' => $wp_rem_cs_author_orderby
		);

// Create the WP_User_Query object
		$wp_user_query = new WP_User_Query($args);

// Get the results
		$authors = $wp_user_query->get_results();

// check to see if we have users
		if ( ! empty($authors) ) {

			$element_title = '';
                        $element_title = wp_rem_title_sub_align($wp_rem_cs_author_element_title, $wp_rem_cs_author_element_subtitle, $wp_rem_var_author_align);
			echo wp_rem_cs_allow_special_char($element_title);

			echo '<ul class="author-list col-lg-12 col-md-12 col-sm-12 col-xs-12">';
			// loop trough each user
			$excerpt = $author_first_name = $author_last_name = $author_descreption = $excerpt_new = '';
			foreach ( $authors as $user ) {
				//get usermeta
				$author_meta = get_user_meta($user->ID);
				$author_first_name = $author_meta['first_name'][0];
				$author_last_name = $author_meta['last_name'][0];
				$author_descreption = $author_meta['description'][0];
				$author_roles = $user->roles;
				$author_avatar = get_avatar($user->ID, apply_filters('wp_rem_cs_author_bio_avatar_size', 70));
				$excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', $author_descreption));
				$excerpt_new = wp_trim_words($excerpt, $wp_rem_cs_author_excerpt, $more = '');
				$author_facebook_profile = isset($author_meta['facebook_profile'][0]) ? $author_meta['facebook_profile'][0] : '';
				$author_twitter_profile = isset($author_meta['twitter_profile'][0]) ? $author_meta['twitter_profile'][0] : '';
				$author_google_profile = isset($author_meta['google_profile'][0]) ? $author_meta['google_profile'][0] : '';
				$author_instagrame_profile = isset($author_meta['instagrame_profile'][0]) ? $author_meta['instagrame_profile'][0] : '';
				$dynamic_col = '';
				$args = array( 'post_type' => 'post', 'posts_per_page' => '2', 'author' => $user->ID );
				$loop = new WP_Query($args);
				if ( $loop->have_posts() ) {
					$dynamic_col = 'class="col-lg-7 col-md-7 col-sm-12 col-xs-12"';
				} else {
					$dynamic_col = 'class="col-lg-12 col-md-12 col-sm-12 col-xs-12"';
				}
				?>
				<li class="scrollingeffect fadeInUp">
					<div class="row">
						<div <?php echo force_balance_tags($dynamic_col); ?> >
							<div class="img-holder">
								<figure><?php echo force_balance_tags($author_avatar); ?></figure>
							</div>
							<div class="text-holder">
								<h5><a href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>"><?php echo esc_html($user->display_name); ?></a> <span><?php echo esc_html($author_roles[0]); ?></span></h5>
								<?php if ( $wp_rem_cs_author_description == 'yes' && $excerpt_new <> '' ) { ?>
									<p><?php echo esc_html($excerpt_new); ?></p>
								<?php } ?>
								<ul class="author-post-options">
									<?php if ( isset($author_facebook_profile) && $author_facebook_profile <> '' ) { ?>
										<li><a href="<?php echo esc_url($author_facebook_profile); ?>" data-original-title="facebook"><i class="icon-facebook"></i></a></li>
									<?php } ?>
									<?php if ( isset($author_twitter_profile) && $author_twitter_profile <> '' ) { ?>
										<li><a href="<?php echo esc_url($author_twitter_profile); ?>" data-original-title="twitter"><i class="icon-twitter"></i></a></li>
									<?php } ?>
									<?php if ( isset($author_google_profile) && $author_google_profile <> '' ) { ?>
										<li><a href="<?php echo esc_url($author_google_profile); ?>" data-original-title="googleplus"><i class="icon-google4"></i></a></li>
									<?php } ?>
									<?php if ( isset($author_instagrame_profile) && $author_instagrame_profile <> '' ) { ?>
										<li><a href="<?php echo esc_url($author_instagrame_profile); ?>" data-original-title="instagram"><i class="icon-instagram3"></i></a></li>
									<?php } ?>
								</ul>
								<?php if ( $loop->have_posts() != '' ) { ?>
									<a class="btn-view-post" href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>"><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_view_all_posts')); ?><i class="icon-keyboard_arrow_right"></i></a> </div>
							<?php } ?>
						</div>
						<?php if ( $loop->have_posts() != '' ) { ?>
							<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
								<div class="author-post-list">
									<ul class="row">
										<?php
										if ( $loop->have_posts() ):
											while ( $loop->have_posts() ):
												$loop->the_post();
												?>
												<li class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
													<div class="img-holder">
														<figure><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('wp_rem_cs_media_6'); ?></a>
															<figcaption><span><?php echo wp_rem_cs_get_post_excerpt(get_the_title(), 4); ?></span></figcaption>
														</figure>
													</div>
												</li>
												<?php
											endwhile;
										endif;
										wp_reset_postdata();
										?>
									</ul>
								</div>
							</div>
						<?php } ?>
					</div>
				</li>
				<?php
			}
			echo '</ul>';
		} else {
			echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no_authors_found'));
		}

// grab the current query parameters
		$query_string = $_SERVER['QUERY_STRING'];

// if on the front end, your base is the current page
		if ( isset($author_pagination) && $author_pagination == 'yes' ) {
			$wp_rem_cs_var_page = 'page_id_all_' . $wp_rem_cs_var_custom_counter;
			echo '<nav>';
			echo '<div class="row">';
			wp_rem_cs_var_get_pagination($total_pages, isset($_GET[$wp_rem_cs_var_page]) ? $_GET[$wp_rem_cs_var_page] : 1, $wp_rem_cs_var_page);
			echo '</div>';
			echo '</nav>';
		}
		if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
			echo '</div>';
		}
		$post_data = ob_get_clean();
		return $post_data;
	}

	if ( function_exists('wp_rem_cs_var_short_code') ) {
		wp_rem_cs_var_short_code('wp_rem_cs_author', 'wp_rem_cs_author_shortcode');
	}
}
