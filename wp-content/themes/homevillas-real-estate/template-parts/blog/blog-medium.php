<?php
/**
 * @ Start front end Blog list view 
 *
 *
 */
global $wp_rem_cs_var_static_text;
$wp_rem_cs_blog_vars = array( 'col_class', 'args', 'post', 'wp_rem_cs_blog_cats', 'wp_rem_cs_blog_description', 'wp_rem_cs_blog_excerpt', 'wp_rem_cs_blog_posts_title_length_var', 'wp_rem_cs_notification', 'wp_query', 'wp_rem_cs_blog_element_title' );
$wp_rem_cs_blog_vars = WP_REM_CS_VAR_GLOBALS()->globalizing($wp_rem_cs_blog_vars);
extract($wp_rem_cs_blog_vars);
extract($wp_query->query_vars);
$wp_rem_cs_blog_element_title = isset($wp_rem_cs_blog_element_title) ? $wp_rem_cs_blog_element_title : '';
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class = "blog blog-medium">
        <div class = "row">
            <?php
            $wpb_all_query = new WP_Query($args);
            if ( $wpb_all_query->have_posts() ) :
                $cat = '';
                while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post();
                    global $post;
                    $post_id = $post->ID;
                    $author_id = $post->post_author;
                    $cat = get_the_category($post_id);
                    $cat_id = isset($cat[0]->cat_ID) ? $cat[0]->cat_ID : '';
                    $cat_meta = get_term_meta($cat_id, 'cat_meta_data', true);
                    $post_style = get_post_meta($post_id, 'wp_rem_cs_var_post_style', true);
                    $gallery_images = get_post_meta($post->ID, 'wp_rem_cs_var_post_detail_page_gallery', true);
                    ?>
                    <div class = "col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class = "blog-post">

                            <?php
                            if ( isset($post_style) && $post_style == 'slider' ) {
                                if ( is_array($gallery_images) && array_filter($gallery_images) ) {
                                    ?>
                                    <div class="img-holder">
                                        <div class="blog-slider swiper-container">
                                            <div class="swiper-wrapper">
                                                <?php
                                                foreach ( $gallery_images as $key => $gallery_image_id ) {
                                                    if ( '' != $gallery_image_id ) {
                                                        $wp_rem_var_src = wp_get_attachment_image_src($gallery_image_id, 'wp_rem_cs_media_4');
                                                        $image_alt = get_post_meta($gallery_image_id, '_wp_attachment_image_alt', true);
                                                        echo '	<figure class="swiper-slide">
	    				<a href="javascript:void(0)"><img src="' . esc_url($wp_rem_var_src[0]) . '" alt=""></a>
	    			    </figure>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <!-- Add Arrows -->
                                        </div>
                                        <div class="swiper-button-prev"> <i class="icon-chevron-thin-left"></i></div>
                                        <div class="swiper-button-next"><i class="icon-chevron-thin-right"></i></div>
                                    </div>
                                    <?php
                                }
                            } else {
                                if ( has_post_thumbnail() ) {
                                    ?> 
                                    <div class = "img-holder">
                                        <figure>
                                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('wp_rem_cs_media_4'); ?></a>
                                        </figure>
                                    </div> 
                                    <?php
                                }
                            }
                            $author_name = get_the_author();
                            $auth = get_post($post_id);
                            $authid = $auth->post_author;
                            if ( $author_name == '' ) {
                                $author_data = get_userdata($authid);
                                $author_name = $author_data->user_login;
                            }
                            $cs_views_counter = get_post_meta($post_id, "wp_rem_post_views_counter", true);
                            if ( $cs_views_counter == '' ) {
                                $cs_views_counter = '0';
                            }
                            ?>
                            <div class = "text-holder">
                                <span class="post-views"><i class="icon-eye"></i><?php echo intval($cs_views_counter); ?> <?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_archieve_views'); ?></span>
                                <div class = "post-title">
                                    <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo esc_html(wp_rem_cs_get_post_excerpt(get_the_title(), $wp_rem_cs_blog_posts_title_length_var)); ?></a></h3>
                                </div>
                                <ul class = "post-options">
                                    <li><a href="<?php echo esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))); ?>"><i class = "icon-calendar5"></i><?php echo get_the_date('l'); ?><span><?php echo get_the_date(' M j, Y'); ?></span></a></li>

                                </ul>
                                <div class = "author-info">
                                    <?php if ( isset($author_name) && $author_name <> '' ) { ?>
                                        <i class="icon-people"></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_view2_by')); ?><span><a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php echo esc_html($author_name); ?></a></span>
                                        <?php } ?>
                                </div>


                                <?php if ( $wp_rem_cs_blog_description == 'yes' ) { ?>
                                    <p> <?php echo wp_rem_allow_special_char(wp_rem_cs_get_excerpt($wp_rem_cs_blog_excerpt, true, wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_archieve_red_more'))); ?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                ?>	
                <p><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no_post_found')); ?></p>
            <?php endif;
            ?>
        </div>
    </div>
</div>
