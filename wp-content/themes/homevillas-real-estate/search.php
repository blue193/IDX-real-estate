<?php
/**
 * The template for displaying search results pages
 *
 * @package WordPress
 * @subpackage Wp_rem_cs
 * @since Auto Mobile 1.0
 */
get_header();

$var_arrays = array('post', 'wp_rem_cs_var_static_text');
$archive_global_vars = WP_REM_CS_VAR_GLOBALS()->globalizing($var_arrays);
extract($archive_global_vars);
$wp_rem_cs_var_options = WP_REM_CS_VAR_GLOBALS()->theme_options();
if (isset($wp_rem_cs_var_options['wp_rem_cs_var_excerpt_length']) && $wp_rem_cs_var_options['wp_rem_cs_var_excerpt_length'] <> '') {
    $default_excerpt_length = $wp_rem_cs_var_options['wp_rem_cs_var_excerpt_length'];
} else {
    $default_excerpt_length = '60';
}
$wp_rem_cs_layout = isset($wp_rem_cs_var_options['wp_rem_cs_var_default_page_layout']) ? $wp_rem_cs_var_options['wp_rem_cs_var_default_page_layout'] : '';

if (isset($wp_rem_cs_layout) && ($wp_rem_cs_layout == "sidebar_left" || $wp_rem_cs_layout == "sidebar_right")) {
    $wp_rem_cs_col_class = "page-content col-lg-8 col-md-8 col-sm-12 col-xs-12";
} else {
    $wp_rem_cs_col_class = "page-content-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12";
}
if (!get_option('wp_rem_cs_var_options') && is_active_sidebar('sidebar-1')) {
    $wp_rem_cs_col_class = "page-content col-lg-8 col-md-8 col-sm-12 col-xs-12";
    $wp_rem_cs_def_sidebar = 'sidebar-1';
}

$wp_rem_cs_sidebar = isset($wp_rem_cs_var_options['wp_rem_cs_var_default_layout_sidebar']) ? $wp_rem_cs_var_options['wp_rem_cs_var_default_layout_sidebar'] : '';
$wp_rem_cs_var_page_margin = isset($wp_rem_cs_var_options['wp_rem_cs_var_page_margin']) ? $wp_rem_cs_var_options['wp_rem_cs_var_page_margin'] : '';
$page_margin_class = '';
if ($wp_rem_cs_var_page_margin == 'on') {
    $page_margin_class = 'page-margin';
}
$wp_rem_cs_tags_name = 'post_tag';
$wp_rem_cs_categories_name = 'category';
$width = '350';
$height = '210';

if (!isset($_GET['page_id_all']))
    $_GET['page_id_all'] = 1;
?>   

<div class="main-section <?php echo esc_attr($page_margin_class); ?>">
    <div class="page-section">
        <!-- Container -->
        <div class="container">
            <!-- Row -->

            <!--Left Sidebar Starts-->
            <?php if ($wp_rem_cs_layout == 'sidebar_left') { ?>
                <div class="page-sidebar col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <?php
                    if (is_active_sidebar(wp_rem_cs_get_sidebar_id($wp_rem_cs_sidebar))) {
                        dynamic_sidebar($wp_rem_cs_sidebar);
                    }
                    ?>
                </div>
            <?php } ?>
            <!--Left Sidebar End-->
            <!-- Page Detail Start -->
            <div class="row">
                <div class= "<?php echo esc_html($wp_rem_cs_col_class); ?>">
                    <?php
                    if (is_author()) {
                        $var_arrays = array('author');
                        $archive_global_vars = WP_REM_CS_VAR_GLOBALS()->globalizing($var_arrays);
                        extract($archive_global_vars);
                        $userdata = get_userdata($author);
                    }
                    if (category_description() || is_tag() || (is_author() && isset($userdata->description) && !empty($userdata->description))) {
                        echo '<div class="widget evorgnizer">';
                        if (is_author()) {
                            ?>
                            <figure>
                                <a>
                                    <?php
                                    echo get_avatar($userdata->user_email, apply_filters('wp_rem_cs_author_bio_avatar_size', 70));
                                    ?>
                                </a>
                            </figure>
                            <div class="left-sp">
                                <h5><a><?php echo esc_attr($userdata->display_name); ?></a></h5>
                                <p><?php echo balanceTags($userdata->description, true); ?></p>
                            </div>
                            <?php
                        } elseif (is_category()) {
                            $category_description = category_description();
                            if (!empty($category_description)) {
                                ?>
                                <div class="left-sp">
                                    <p><?php echo category_description(); ?></p>
                                </div>
                                <?php
                            }
                        } elseif (is_tag()) {
                            $tag_description = tag_description();
                            if (!empty($tag_description)) {
                                ?>
                                <div class="left-sp">
                                    <p><?php echo apply_filters('tag_archive_meta', $tag_description); ?></p>
                                </div>
                                <?php
                            }
                        }
                        echo '</div>';
                    }
                    ?>
                    <div class = "blog blog-medium">
                        <div class = "row">
                            <?php
                            if (have_posts()) {
                                while (have_posts()) : the_post();
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
                                            if (isset($post_style) && $post_style == 'slider') {
                                                if (is_array($gallery_images) && array_filter($gallery_images)) {
                                                    ?>
                                                    <div class="img-holder">
                                                        <div class="blog-slider swiper-container">
                                                            <div class="swiper-wrapper">
                                                                <?php
                                                                foreach ($gallery_images as $key => $gallery_image_id) {
                                                                    if ('' != $gallery_image_id) {
                                                                        $wp_rem_var_src = wp_get_attachment_image_src($gallery_image_id, 'wp_rem_cs_media_4');
                                                                        $image_alt = get_post_meta($gallery_image_id, '_wp_attachment_image_alt', true);
                                                                        echo '	<figure class="swiper-slide">
											    <a href="javascript:void(0)"><img src="' . esc_url($wp_rem_var_src[0]) . '"></a>
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
                                                if (has_post_thumbnail()) {
                                                    ?> 
                                                    <div class = "img-holder">
                                                        <figure>
                                                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('wp_rem_cs_media_4'); ?></a>
                                                        </figure>
                                                    </div> 
                                                    <?php
                                                }
                                            }$author_name = get_the_author();
                                            $auth = get_post($post_id);
                                            $authid = $auth->post_author;
                                            if ($author_name == '') {
                                                $author_data = get_userdata($authid);
                                                $author_name = $author_data->user_login;
                                            }
                                            $cs_views_counter = get_post_meta($post_id, "wp_rem_post_views_counter", true);
                                            if ($cs_views_counter == '') {
                                                $cs_views_counter = '0';
                                            }
                                            ?>
                                            <div class = "text-holder">
                                                <span class="post-views"><i class="icon-eye"></i><?php echo intval($cs_views_counter); ?> <?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_archieve_views'); ?></span>
                                                <div class = "post-title">
                                                    <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo esc_html(wp_trim_words(get_the_title(), 6)); ?></a></h3>
                                                </div>
                                                <ul class = "post-options">
                                                    <li><a href="<?php echo esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))); ?>"><i class = "icon-calendar5"></i><?php echo get_the_date('l'); ?><span><?php echo get_the_date(' M j, Y'); ?></span></a></li>
                                                </ul>
                                                <div class = "author-info">
                                                    <?php if (isset($author_name) && $author_name <> '') { ?>
                                                        <i class="icon-people"></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_view2_by')); ?><span><?php echo esc_html($author_name); ?></span>
                                                        <?php } ?>
                                                </div>
                                                <?php if (get_the_excerpt() != '') { ?>
                                                    <p> <?php echo wp_rem_allow_special_char(wp_rem_cs_get_excerpt($default_excerpt_length, true )); ?></p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                endwhile;
                            } else {
                                get_template_part('template-parts/content-none');
                            }
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                    <?php
                    if (function_exists('wp_rem_default_pagination')) {
                        echo wp_rem_default_pagination();
                    }
                    ?>

                </div>
                <?php
                if (isset($wp_rem_cs_layout) and $wp_rem_cs_layout == 'sidebar_right') {
                    if (is_active_sidebar(wp_rem_cs_get_sidebar_id($wp_rem_cs_sidebar))) {
                        echo '<div class="page-sidebar right col-lg-4 col-md-4 col-sm-12 col-xs-12">';
                        dynamic_sidebar($wp_rem_cs_sidebar);
                        echo '</div>';
                    }
                }
                if (!is_active_sidebar(wp_rem_cs_get_sidebar_id($wp_rem_cs_sidebar)) && is_active_sidebar('sidebar-1')) {
                    echo '<div class="page-sidebar col-lg-4 col-md-4 col-sm-12 col-xs-12">';
                    dynamic_sidebar('sidebar-1');
                    echo '</div>';
                }
                ?>
            </div>


        </div><!-- .container -->
    </div><!-- .page-section -->
</div><!-- .main-section -->

<?php
get_footer();
