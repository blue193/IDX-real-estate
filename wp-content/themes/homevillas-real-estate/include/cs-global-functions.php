<?php
/**
 * File Type: Global Varibles Functions
 */
if ( ! class_exists( 'wp_rem_cs_global_functions' ) ) {

	class wp_rem_cs_global_functions {

		// The single instance of the class
		protected static $_instance = null;

		public function __construct() {
			// Do something...
		}

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function theme_options() {
			global $wp_rem_cs_var_options;

			return $wp_rem_cs_var_options;
		}

		public function globalizing( $var_array = array() ) {
			if ( is_array( $var_array ) && sizeof( $var_array ) > 0 ) {
				$return_array = array();
				foreach ( $var_array as $value ) {
					global $$value;
					$return_array[$value] = $$value;
				}
				return $return_array;
			}
		}

	}

	function WP_REM_CS_VAR_GLOBALS() {
		return wp_rem_cs_global_functions::instance();
	}

	$GLOBALS['wp_rem_cs_global_functions'] = WP_REM_CS_VAR_GLOBALS();
}
/**
 * @Removing Image Dimensions
 */
if ( ! function_exists( 'wp_rem_cs_remove_thumbnail_dimensions' ) ) {
	add_filter( 'post_thumbnail_html', 'wp_rem_cs_remove_thumbnail_dimensions', 10, 3 );

	function wp_rem_cs_remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
		$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
		return $html;
	}

}
/**
 * Start Function Related Blog Posts
 */
if ( ! function_exists( 'wp_rem_cs_related_posts' ) ) {

	function wp_rem_cs_related_posts( $number_post = '-1' ) {
		global $post, $wp_rem_cs_var_static_text;
		// check related posts on/off.
		$rel_posts = get_post_meta( $post->ID, 'wp_rem_cs_var_related_post', true );
		if ( 'on' === $rel_posts ) {
			$post_cats = wp_get_post_categories( $post->ID, array( 'fields' => 'ids' ) );
			$args = array(
				'category__in' => $post_cats,
				'posts_per_page' => $number_post,
				'post__not_in' => array( $post->ID ),
			);
			$rel_qry = new WP_Query( $args );
			if ( $rel_qry->have_posts() ) :
				?>
				<div class="related-post">
					<div class="element-title"><h4><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_global_function_you_may_like'); ?></h4></div>
					<div class="row">
						<div class="blog blog-grid swiper-container">
							<div class="swiper-wrapper">
								<?php
								while ( $rel_qry->have_posts() ) : $rel_qry->the_post();
									global $post;
									$thumb_id = get_post_thumbnail_id();
									if ( $thumb_id ) :
										$post_cats = wp_get_post_categories( get_the_ID(), array( 'fields' => 'all' ) );
										$image = wp_get_attachment_image_src( $thumb_id, 'wp_rem_cs_media_4' );
										$image_alt = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
										$image_url = $image[0];
										?>
										<div class="swiper-slide col-lg-4 col-md-4 col-sm-6 col-xs-12">
											<div class="blog-post">
												<div class="img-holder">
													<figure>
														<a href="<?php echo esc_url( get_permalink() ); ?>"><img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_html( $image_alt ); ?>" /></a>
													</figure>
												</div>
												<div class="text-holder">
													<div class="post-title">
														<h5><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo get_the_title(); ?>" ><?php echo wp_rem_cs_get_post_excerpt( get_the_title(), 4 ); ?></a></h5>
													</div>
													<p><?php echo wp_rem_allow_special_char( wp_rem_cs_get_excerpt( 12, '', '' ) ); ?></p>
													<div class="icons-list">
														<?php
														$wp_rem_post_like_counter = get_post_meta( $post->ID, 'wp_rem_post_like_counter', true );
														if ( ! isset( $wp_rem_post_like_counter ) or empty( $wp_rem_post_like_counter ) ) {
															$wp_rem_post_like_counter = 0;
														}
														if ( 'true' === wp_rem_get_cookie( 'wp_rem_post_like_counter' . $post->ID ) ) {
															$post_liked = '';
															$post_liked = '<span><a href="javascript:void(0)"<i class=" icon-heart2"></a></span>';
															echo force_balance_tags( $post_liked );
														} else {
															?>
															<span>
																<a  id="post_likes<?php echo esc_html( $post->ID ); ?>" onclick="wp_rem_post_likes_count('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', '<?php echo esc_html( $post->ID ) ?>', 'blog_views', this)"><i class="icon-heart-outlined"></i></a>
															</span>
														<?php } ?>
														<span><a href="<?php echo esc_url( get_permalink() ); ?>"><i class="icon-dots-three-horizontal"></i></a></span>
													</div>
												</div>
											</div>
										</div>
									<?php endif; ?>
								<?php endwhile; ?>

							</div>
						</div>
						<div class="swiper-button-prev"> <i class="icon-arrow-left3"></i></div>
						<div class="swiper-button-next"><i class="icon-arrow-right3"></i></div>
					</div>
				</div>
				<?php
			endif;
			wp_reset_postdata();
		}
	}
}
/**
 * End Function Related Blog Posts
 */