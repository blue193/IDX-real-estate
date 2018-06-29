<?php
/**
 * @ Start frontend Blog Grid View 
 *
 *
 */
global $wp_rem_cs_var_static_text;
$wp_rem_cs_blog_vars = array( 'col_class', 'args', 'post', 'wp_rem_cs_blog_cats', 'wp_rem_cs_blog_description', 'wp_rem_cs_blog_excerpt', 'wp_rem_cs_blog_posts_title_length_var', 'wp_rem_cs_notification', 'wp_query', 'wp_rem_cs_blog_element_title' );
$wp_rem_cs_blog_vars = WP_REM_CS_VAR_GLOBALS()->globalizing($wp_rem_cs_blog_vars);
extract($wp_rem_cs_blog_vars);
$post_id = $post->ID;
extract($wp_query->query_vars);
$wp_rem_cs_blog_element_title = isset($wp_rem_cs_blog_element_title) ? $wp_rem_cs_blog_element_title : '';
$wpb_all_query = new WP_Query($args);


if ( $wpb_all_query->have_posts() ) :
    while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post();
        global $post;
        $post_idd = $post->ID;
        $author_id = $post->post_author;
        $image_url = '';
        $image_url = get_the_post_thumbnail_url($post_idd);
        $image_style = '';
        if ( isset($image_url) && $image_url != '' ) {
            $image_style = 'style="background: url(' . esc_url($image_url) . ') no-repeat center / cover;"';
        }
        ?>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="blog blog-medium classic">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="blog-post">
                            <?php
                            if ( has_post_thumbnail() ) {
                                ?>
                                <a href="<?php the_permalink(); ?>"><div class="img-holder" <?php echo force_balance_tags($image_style); ?>></a>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="text-holder">

                            <div class="post-title">
                                <h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo esc_html(wp_rem_cs_get_post_excerpt(get_the_title(), $wp_rem_cs_blog_posts_title_length_var)); ?></a></h4>
                            </div>
                            <div class="author-info">
                                <a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_blog_info_author_by'); ?><?php echo the_author_meta('display_name', $author_id); ?></a>
                            </div>
                            <ul class="post-options">
                                <li><a href="<?php echo get_month_link(get_the_time('Y'), get_the_time('m')); ?>"><?php echo get_the_date('F j, Y'); ?></a></li>
                            </ul>
                            <?php if ( $wp_rem_cs_blog_description == 'yes' ) { ?>
                                <p> <?php echo wp_rem_allow_special_char(wp_rem_cs_get_excerpt($wp_rem_cs_blog_excerpt, '', '')); ?></p>
                                <a href="<?php the_permalink(); ?>" class="readmore-btn text-color"><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_readmore_text'); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
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