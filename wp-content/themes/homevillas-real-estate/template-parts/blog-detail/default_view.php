<?php
/**
 * Template part for displaying post detail view 1.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wp_rem_cs
 */
$wp_rem_cs_page_sidebar_right = '';
$wp_rem_cs_page_sidebar_left = '';
$wp_rem_cs_var_layout = '';
$left_sidebar_flag = false;
$right_sidebar_flag = false;
$wp_rem_cs_def_sidebar = false;

global $post, $wp_rem_cs_var_options;


$image_url = wp_rem_cs_get_post_img_src($post->ID, 960, 540);
$wp_rem_cs_section_bg = ( '' !== $image_url ) ? esc_url($image_url) : '';
$wp_rem_cs_var_layout = get_post_meta($post->ID, 'wp_rem_cs_var_page_layout', true);
$wp_rem_cs_var_post_social_sharing = get_post_meta($post->ID, 'wp_rem_cs_var_post_social_sharing', true);
$wp_rem_cs_var_post_tags_show = get_post_meta($post->ID, 'wp_rem_cs_var_post_tags_show', true);
$wp_rem_cs_var_feature_image = get_post_meta($post->ID, 'wp_rem_cs_var_feature_image', true);
$wp_rem_cs_var_article_banner = get_post_meta($post->ID, 'wp_rem_cs_var_article_banner', true);
$wp_rem_cs_var_post_about_author_show = get_post_meta($post->ID, 'wp_rem_cs_var_post_about_author_show', true);
$wp_rem_cs_var_related_post = get_post_meta($post->ID, 'wp_rem_cs_var_related_post', true);

$wp_rem_cs_sidebar_right = get_post_meta($post->ID, 'wp_rem_cs_var_page_sidebar_right', true);
$wp_rem_cs_sidebar_left = get_post_meta($post->ID, 'wp_rem_cs_var_page_sidebar_left', true);
$wp_rem_cs_var_author_id = get_post_field('post_author', $post->ID);
$wp_rem_cs_var_post_format = get_post_meta($post->ID, 'wp_rem_cs_var_post_format', true);
$rating_template = get_post_meta($post->ID, 'selected_rating_template', true);
$wp_rem_cs_var_format_video_url = get_post_meta($post->ID, 'wp_rem_cs_var_format_video_url', true);
$wp_rem_cs_var_soundcloud_url = get_post_meta($post->ID, 'wp_rem_cs_var_soundcloud_url', true);
$gallery_images = get_post_meta($post->ID, 'wp_rem_cs_var_post_detail_page_gallery', true);

//get theme options for default layout

$wp_rem_cs_default_layout = isset($wp_rem_cs_var_options['wp_rem_cs_var_default_page_layout']) ? $wp_rem_cs_var_options['wp_rem_cs_var_default_page_layout'] : '';

if ('left' === $wp_rem_cs_var_layout) {
    $wp_rem_cs_var_layout = 'page-content col-lg-8 col-md-8 col-sm-12 col-xs-12';
    $left_sidebar_flag = true;
} else if ('right' === $wp_rem_cs_var_layout) {
    $wp_rem_cs_var_layout = 'page-content col-lg-8 col-md-8 col-sm-12 col-xs-12';
    $right_sidebar_flag = true;
} else {
    $wp_rem_cs_var_layout = 'page-content-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12';
}

if (!get_option('wp_rem_cs_var_options') && is_active_sidebar('sidebar-1')) {
    $wp_rem_cs_var_layout = "page-content col-lg-8 col-md-8 col-sm-12 col-xs-12";
    //$wp_rem_cs_def_sidebar = 'sidebar-1';
    $wp_rem_cs_def_sidebar = true;
}

// plugin active or not 
$plugins = get_option('active_plugins');
$required_plugin = 'wp_rem_cs-ratings/wp_rem_cs-ratings.php';
$plugin_status = FALSE;
if (in_array($required_plugin, $plugins)) {
    $plugin_status = TRUE; // Example for yes, it's active
}

// get author data
$auth = get_post($post->ID); // gets author from post
$authid = $auth->post_author; // gets author id for the post
$user_nickname = get_the_author_meta('nickname', $authid); // retrieve user nickname
$user_display_name = get_the_author_meta('display_name', $authid); // retrieve user nickname
$author_avatar = get_avatar($authid, apply_filters('wp_rem_cs_author_bio_avatar_size', 40));
$author_avatar_detail_page = get_avatar($authid, apply_filters('wp_rem_cs_author_bio_avatar_size', 92));
$author_meta = get_user_meta($authid);
$author_first_name = $author_meta['first_name'][0];
$author_last_name = $author_meta['last_name'][0];
$author_descreption = $author_meta['description'][0];
if ($user_display_name == '') {
    $author_data = get_userdata($authid);
    $user_display_name = $author_data->user_login;
}


// get categories data
$cat = '';
$cat = get_the_category($post->ID);
$cat_id = isset($cat[0]->cat_ID) ? $cat[0]->cat_ID : '';
$cat_meta = get_term_meta($cat_id, 'cat_meta_data', true);
$prev_post_url = '';
$prev_post = get_adjacent_post(false, '', true);
if ($prev_post) {
    $prev_post_url = get_permalink($prev_post->ID);
}
$next_post_url = '';
$next_post = get_adjacent_post(false, '', false);
if ($next_post) {
    $next_post_url = get_permalink($next_post->ID);
}
?>
<div id="main">

    <div class="page-section">
        <div class="blog-detail">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="detail-author">
                            <div class="author-info">
                                <?php if (isset($author_avatar) && $author_avatar <> '') { ?>
                                    <figure>
                                        <a href="<?php echo get_author_posts_url($authid); ?>"><?php echo force_balance_tags($author_avatar); ?></a>
                                    </figure>
                                <?php } ?>
                                <div class="text-holder">
                                    <span class="post-date"><a href="<?php echo esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))); ?>"><?php echo get_the_date('j F Y'); ?></a></span>
                                    <span class="post-name"><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_default_view_written_by'); ?><em ><a class="text-color" href="<?php echo get_author_posts_url($authid); ?>"><?php echo esc_html($user_display_name); ?></a></em> </span>
                                </div>
                            </div>
                        </div>
                        <div class="prv-next-post">
                            <?php if ($prev_post_url != '') { ?>
                                <div class="prv-post"><a href="<?php echo esc_url($prev_post_url); ?>"><i class="icon-arrow-left3"></i><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_default_view_previous_article'); ?></a></div>
                            <?php }if ($next_post_url != '') { ?>
                                <div class="next-post"><a href="<?php echo esc_url($next_post_url); ?>"><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_default_view_next_article'); ?><i class="icon-arrow-right3"></i></a></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if (true === $left_sidebar_flag) { ?>
                        <aside class="page-sidebar col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <?php
                            if (is_active_sidebar(wp_rem_cs_get_sidebar_id($wp_rem_cs_sidebar_left))) {
                                dynamic_sidebar($wp_rem_cs_sidebar_left);
                            }
                            ?>
                        </aside>
                    <?php } ?>
                    
                    <div class="page-content <?php echo esc_html($wp_rem_cs_var_layout); ?>">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="main-post">
                                    <div class="img-holder">
                                        <figure><?php the_post_thumbnail('wp_rem_cs_media_1'); ?></figure>
                                    </div>
                                </div>
                                <div class="rich_editor_text">
                                    <?php if (isset($wp_rem_cs_var_post_social_sharing) && 'on' === $wp_rem_cs_var_post_social_sharing) { ?>
                                        <div class="social-media">
                                            <span class="social-share">
                                                <?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_default_view_share'); ?>
                                            </span>
                                            <ul>
                                                <?php echo wp_rem_cs_social_share_blog(); ?>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                    <div class="detail-content">
                                        <?php the_content(); ?>
                                        <?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_default_view_pages') . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
                                    </div>

                                </div>
                                <?php if (isset($wp_rem_cs_var_post_tags_show) && 'on' === $wp_rem_cs_var_post_tags_show) { ?>
                                    <div class="tags-list"> <strong><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tag'); ?></strong>
                                        <?php the_tags('<ul> <li>', '</li> <li>', '</li> </ul>'); ?>
                                    </div>
                                <?php } ?>

                                <?php
                                if (isset($wp_rem_cs_var_related_post) && 'on' === $wp_rem_cs_var_related_post) {
                                    if (function_exists('wp_rem_cs_related_posts')) {
                                        wp_rem_cs_related_posts();
                                    }
                                }
                                ?>
                                <?php
                                if (comments_open() || get_comments_number()) :
                                    comments_template();
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>

                    <?php if (true === $right_sidebar_flag) { ?>
                        <aside class="page-sidebar col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <?php
                            if (is_active_sidebar(wp_rem_cs_get_sidebar_id($wp_rem_cs_sidebar_right))) {
                                dynamic_sidebar($wp_rem_cs_sidebar_right);
                            }
                            ?>
                        </aside>
                    <?php } else if ($wp_rem_cs_def_sidebar === true) { ?>
                        <aside class="page-sidebar col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <?php
                            if (is_active_sidebar('sidebar-1')) {
                                dynamic_sidebar('sidebar-1');
                            }
                            ?>
                        </aside>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>