<?php
/**
 * @ Start front end Blog list view 
 *
 *
 */
global $wp_rem_cs_var_static_text;
$wp_rem_cs_blog_vars = array( 'col_class', 'args', 'post', 'wp_rem_cs_blog_cats', 'wp_rem_cs_blog_description', 'wp_rem_cs_blog_excerpt', 'wp_rem_cs_blog_posts_title_length_var', 'wp_rem_cs_blog_num_post', 'wp_rem_cs_notification', 'wp_query', 'wp_rem_cs_blog_element_title', 'wp_rem_cs_blog_filterable', 'wp_rem_cs_blog_orderby', 'orderby' );
$wp_rem_cs_blog_vars = WP_REM_CS_VAR_GLOBALS()->globalizing($wp_rem_cs_blog_vars);
extract($wp_rem_cs_blog_vars);
$post_id = $post->ID;
extract($wp_query->query_vars);
$wp_rem_cs_blog_filterable;
$wp_rem_cs_blog_element_title = isset($wp_rem_cs_blog_element_title) ? $wp_rem_cs_blog_element_title : '';
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="blog blog-large">
        <div class="row">
            <?php
            global $post;
            $post_id = $post->ID;
            $author_id = $post->post_author;
            $wpb_all_query = new WP_Query($args);
            if ( $wpb_all_query->have_posts() ) {
                while ( $wpb_all_query->have_posts() ) {
                    $wpb_all_query->the_post();
                    $category_ids = get_the_category(get_the_id());
                    $cat_id = isset($category_ids[0]->term_id) ? $category_ids[0]->term_id : '';
                    if ( $cat_id != '' ) {
                        $cat_icon = get_term_meta($cat_id, 'cat_meta_data', true);
                    }
                    $loop_start_tag = true;
                    $post_style = get_post_meta(get_the_id(), 'wp_rem_cs_var_post_style', true);
                    $gallery_images = get_post_meta(get_the_id(), 'wp_rem_cs_var_post_detail_page_gallery', true);
                    $archive_year = get_the_time('Y');
                    $archive_month = get_the_time('m');
                    $archive_day = get_the_time('d');
                    ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="blog-post">
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
                                                        $wp_rem_var_src = wp_get_attachment_image_src($gallery_image_id, 'wp_rem_cs_media_2');
                                                        $image_alt = get_post_meta($gallery_image_id, '_wp_attachment_image_alt', true);
                                                        echo '	<figure class="swiper-slide">
														<a href="javascript:void(0)"><img src="' . esc_url($wp_rem_var_src[0]) . '" alt=""></a></figure>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <!-- Add Arrows -->
                                        <div class="swiper-button-next"><i class="icon-arrow_forward"></i></div>
                                        <div class="swiper-button-prev"> <i class="icon-arrow_back"></i></div>
                                    </div>

                                    <?php
                                }
                            } else {
                                if ( has_post_thumbnail() ) {
                                    ?>
                                    <div class="img-holder">
                                        <figure>
                                            <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_post_thumbnail('wp_rem_cs_media_2'); ?></a>
                                        </figure>
                                    </div>
                                    <?php
                                }
                            }
                            ?>

                            <div class="text-holder">
                                <ul class="post-options">
                                    <li><a href="<?php echo esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))); ?>"><i class="icon-calendar5"></i><?php echo get_the_date('F j, Y'); ?></a></li>
                                </ul>
                                <div class="author-info">
                                    <?php
                                    $auth = get_post($post_id);
                                    $author_name = get_the_author();
                                    $authid = $auth->post_author;
                                    if ( $author_name == '' ) {
                                        $author_data = get_userdata($authid);
                                        $author_name = $author_data->user_login;
                                    }
                                    $author_avatar = get_avatar($authid, apply_filters('wp_rem_cs_author_bio_avatar_size', 80));
                                    if ( isset($author_name) && $author_name <> '' ) {
                                        ?>
                                        <i class="icon-people"></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_view2_by')); ?><span><a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php echo esc_html($author_name); ?></a></span>
                                    <?php } ?>
                                </div>
                                <div class="post-title">
                                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                </div>


                                <?php if ( $wp_rem_cs_blog_description == 'yes' ) { ?>

                                    <p><?php echo wp_rem_allow_special_char(wp_rem_cs_get_excerpt($wp_rem_cs_blog_excerpt, true, wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_archieve_red_more'))); ?></p>

                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>