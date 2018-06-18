<?php
/**
 * File Type: Services Page Element
 */
if ( ! class_exists( 'Wp_rem_Images_Gallery_Element' ) ) {

	class Wp_rem_Images_Gallery_Element {

		/**
		 * Start construct Functions
		 */
		public function __construct() {
			add_action( 'wp_rem_images_gallery_element_html', array( $this, 'wp_rem_images_gallery_element_html_callback' ), 11, 1 );
		}

		/*
		 * Output features html for frontend on property detail page.
		 */

		public function wp_rem_images_gallery_element_html_callback( $post_id ) {
			global $wp_rem_plugin_options;
			
			$content_gallery = isset($wp_rem_plugin_options['wp_rem_property_detail_page_content_gallery']) ? $wp_rem_plugin_options['wp_rem_property_detail_page_content_gallery'] : '';
			if( $content_gallery != 'on' ){
				return;
			}
			
			$html = '';
			$gallery_limit = wp_rem_cred_limit_check( $post_id, 'wp_rem_transaction_property_pic_num' );
			$gallery_ids_list = get_post_meta( $post_id, 'wp_rem_detail_page_gallery_ids', true );
			$gallery_pics_allowed = get_post_meta($post_id, 'wp_rem_transaction_property_pic_num', true);

			if ( is_array( $gallery_ids_list ) && sizeof( $gallery_ids_list ) > 0 && $gallery_pics_allowed > 0 ) { ?>
				<div class="main-post slider">
					<div class="swiper-container gallery-top">
						<div class="swiper-wrapper">
							<?php
							$gallery_counterr = 1;
							foreach ( $gallery_ids_list as $gallery_idd ) {
								if ( isset( $gallery_idd ) && $gallery_idd != '' ) {
									if ( wp_get_attachment_url( $gallery_idd ) ) {
										$image = wp_get_attachment_image_src( $gallery_idd, 'wp_rem_media_9' );
										?>
										<div class="swiper-slide">
											<figure>
												<img src="<?php echo esc_url($image[0]); ?>" alt="" />
											</figure>
										</div>
										<?php
										if ( $gallery_limit == $gallery_counterr ) {
											break;
										}
										$gallery_counterr ++;
									}
								}
							}
							?>
						</div>
						<!-- Add Arrows -->
						<div class="swiper-button-prev"> <i class="icon-chevron-thin-left"></i></div>
						<div class="swiper-button-next"><i class="icon-chevron-thin-right"></i></div>
					</div>
					<div class="swiper-container gallery-thumbs">
						<div class="swiper-wrapper">
							<?php
							$gallery_counter = 1;

							foreach ( $gallery_ids_list as $gallery_id ) {
								if ( isset( $gallery_id ) && $gallery_id != '' ) {
									if ( wp_get_attachment_url( $gallery_id ) ) {
										?>
										<div class="swiper-slide">
											<figure>
												<?php echo wp_get_attachment_image( $gallery_id, 'wp_rem_media_7' ); ?>
											</figure>
										</div>
										<?php
										if ( $gallery_limit == $gallery_counter ) {
											break;
										}
										$gallery_counter ++;
									}
								}
							}
							?>
						</div>
					</div>
				</div>
			<?php
			}
						$if_top_loop = ( isset( $gallery_counterr ) && $gallery_counterr == 2 ) ? 'false' : 'true';
						$if_thumb_loop = ( isset( $gallery_counterr ) && $gallery_counterr <= 8 ) ? 'false' : 'true';
                        $wp_rem_cs_inline_script = '
                        jQuery(document).ready(function () {
                            if (jQuery(".main-post.slider .gallery-top, .main-post.slider .gallery-thumbs").length != "") {
                                "use strict";
                                var galleryTop = new Swiper(".main-post.slider .gallery-top", {
                                    nextButton: ".main-post.slider .swiper-button-next",
                                    prevButton: ".main-post.slider .swiper-button-prev",
                                    spaceBetween: 0,
                                    loop: '.$if_top_loop.',
                                    loopedSlides: 15
                                });

                                var galleryThumbs = new Swiper(".main-post.slider .gallery-thumbs", {
                                    spaceBetween: 5,
                                    slidesPerView: 7,
                                    touchRatio: .2,
                                    loop: '.$if_thumb_loop.',
                                    loopedSlides: 15,
                                    //looped slides should be the same
                                    slideToClickedSlide: true,
                                    breakpoints: {
                                        1024: {
                                            slidesPerView: 6,
                                        },
                                        600: {
                                            slidesPerView: 4,
                                        }
                                    }
                                });
                                galleryTop.params.control = galleryThumbs;
                                galleryThumbs.params.control = galleryTop;
                            }

                        });';
                        wp_rem_cs_inline_enqueue_script($wp_rem_cs_inline_script, 'wp-rem-custom-inline');
                        
			echo force_balance_tags( $html );
		}

	}

	global $wp_rem_images_gallery_element;
	$wp_rem_images_gallery_element = new Wp_rem_Images_Gallery_Element();
}