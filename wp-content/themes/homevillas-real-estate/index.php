<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wp_rem_cs
 */
get_header();
$var_arrays = array('post', 'current_user', 'wp_rem_cs_user', 'wp_rem_cs_num');
$search_global_vars = WP_REM_CS_VAR_GLOBALS()->globalizing($var_arrays);
extract($search_global_vars);
extract($search_global_vars);
$wp_rem_cs_var_options = WP_REM_CS_VAR_GLOBALS()->theme_options();
$paging_var = 'paged_id';
if (!isset($_GET[$paging_var])) {
    $_GET[$paging_var] = '';
}
if (isset($wp_rem_cs_var_options['wp_rem_cs_var_excerpt_length']) && $wp_rem_cs_var_options['wp_rem_cs_var_excerpt_length'] <> '') {
    $default_excerpt_length = $wp_rem_cs_var_options['wp_rem_cs_var_excerpt_length'];
} else {
    $default_excerpt_length = '60';
}
$wp_rem_cs_layout = isset($wp_rem_cs_var_options['wp_rem_cs_var_default_page_layout']) ? $wp_rem_cs_var_options['wp_rem_cs_var_default_page_layout'] : '';
$wp_rem_cs_default_sidebar = false;
if ($wp_rem_cs_layout == '') {
    $wp_rem_cs_default_sidebar = true;
}
if (isset($wp_rem_cs_layout) && ($wp_rem_cs_layout == "sidebar_left" || $wp_rem_cs_layout == "sidebar_right")) {
    $wp_rem_cs_col_class = "page-content col-lg-8 col-md-8 col-sm-12 col-xs-12";
} else if ($wp_rem_cs_default_sidebar == true) {
    $wp_rem_cs_col_class = "page-content col-lg-8 col-md-8 col-sm-12 col-xs-12";
} else {
    $wp_rem_cs_col_class = "page-content-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12";
}
$strings = new wp_rem_cs_theme_all_strings;
$strings->wp_rem_cs_theme_option_strings();
$wp_rem_cs_sidebar = isset($wp_rem_cs_var_options['wp_rem_cs_var_default_layout_sidebar']) ? $wp_rem_cs_var_options['wp_rem_cs_var_default_layout_sidebar'] : '';
$wp_rem_cs_var_page_margin = isset($wp_rem_cs_var_options['wp_rem_cs_var_page_margin']) ? $wp_rem_cs_var_options['wp_rem_cs_var_page_margin'] : '';
$page_margin_class = '';
if ($wp_rem_cs_var_page_margin == 'on') {
    $page_margin_class = 'page-margin';
}
?>
<div class="main-section <?php echo esc_attr($page_margin_class); ?>">
    <div class="page-section">
        <!-- Container -->
        <div class="container">
            <!-- Row -->
            <div class="row"> 
                <?php
                if ($wp_rem_cs_layout == 'sidebar_left') {
                    if (is_active_sidebar(wp_rem_cs_get_sidebar_id($wp_rem_cs_sidebar))) {
                        ?>
                        <div class="page-sidebar col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <?php
                            dynamic_sidebar($wp_rem_cs_sidebar);
                            ?>
                        </div>
                        <?php
                    }
                }
                ?>
                <div class="<?php echo esc_html($wp_rem_cs_col_class); ?>">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?php
                            $wp_rem_cs_cat_name = isset($_GET['cat']) ? $_GET['cat'] : '';
                            $wp_rem_cs_post_title = isset($_GET['s']) ? $_GET['s'] : '';
                            $paged = isset($_GET['paged_id']) ? $_GET['paged_id'] : 1;

                            $posts_per_page = get_option('posts_per_page');

                            $args = array('post_type' => 'post',
                                'search_title' => $wp_rem_cs_post_title,
                                'posts_per_page' => $posts_per_page,
                                'paged' => $_GET[$paging_var],
                            );
                            if (isset($wp_rem_cs_cat_name) && $wp_rem_cs_cat_name != "") {
                                $args['tax_query'] = array(
                                    array(
                                        'taxonomy' => 'category',
                                        'field' => 'slug',
                                        'terms' => $wp_rem_cs_cat_name,
                                    )
                                );
                            }
                            $wp_rem_cs_total = 0;
                            $query = new WP_Query($args);
                            ?>
                            <div class = "blog blog-medium">
                                <div class = "row">
                                    <?php
                                    if ($query->have_posts()) {
                                        while ($query->have_posts()) : $query->the_post();
                                            global $post;
                                            $post_id = $post->ID;
                                            $author_id = $post->post_author;
                                            $cat = get_the_category($post_id);
                                            $cat_id = isset($cat[0]->cat_ID) ? $cat[0]->cat_ID : '';
                                            $cat_meta = get_term_meta($cat_id, 'cat_meta_data', true);
                                            $post_style = get_post_meta($post_id, 'wp_rem_cs_var_post_style', true);
                                            $gallery_images = get_post_meta($post->ID, 'wp_rem_cs_var_post_detail_page_gallery', true);
                                            ?>
                                            <div <?php post_class('col-lg-12 col-md-12 col-sm-12 col-xs-12') ?>>
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
                                                    }
                                                    $author_name = get_the_author();
                                                    $auth = get_post($post_id);
                                                    $authid = $auth->post_author;
                                                    if ($author_name == '') {
                                                        if ($authid != '') {
                                                            $author_data = get_userdata($authid);
                                                            $author_name = isset($author_data->user_login) ? $author_data->user_login: '';
                                                        }else{
                                                            $author_name = '';
                                                        }
                                                    }
                                                    $cs_views_counter = get_post_meta($post_id, "wp_rem_post_views_counter", true);
                                                    if ($cs_views_counter == '') {
                                                        $cs_views_counter = '0';
                                                    }
                                                    ?>
                                                    <div class = "text-holder">
                                                        <span class="post-views"><i class="icon-eye"></i><?php echo intval($cs_views_counter); ?> <?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_views'); ?></span>
                                                        <div class = "post-title">
                                                            <h3>
                                                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo esc_html(wp_trim_words(get_the_title(), 6)); ?></a>
                                                                <?php
                                                                if (is_sticky($post_id)) {
                                                                    echo '<span>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_featured') . '</span>';
                                                                }
                                                                ?>
                                                            </h3>
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
                                                            <p> <?php echo wp_rem_allow_special_char(wp_rem_cs_get_excerpt($default_excerpt_length, '', '')); ?></p>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        endwhile;
                                    } else {
                                        echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_noresult_found'));
                                    }
                                    wp_reset_postdata();
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $wp_rem_cs_current_page = 1;
                        $wp_rem_cs_totalposts = wp_count_posts()->publish;
                        if (isset($_GET['paged_id'])) {
                            $wp_rem_cs_current_page = $_GET['paged_id'];
                        }
                        $posts_per_page = get_option('posts_per_page');
                        if (isset($wp_rem_cs_cat_name) && $wp_rem_cs_cat_name != "") {
                            $posts_per_page = $wp_rem_cs_total;
                            $wp_rem_cs_totalposts = $wp_rem_cs_total;
                        }
                        $wp_rem_cs_pages = ceil($wp_rem_cs_totalposts / $posts_per_page);
                        $qrystr = '';
                        if (isset($_GET['page_id'])) {
                            $qrystr .= "&amp;page_id=" . $_GET['page_id'];
                        }
                        $args_count = array(
                            'posts_per_page' => "-1",
                            'post_type' => 'post',
                            'post_status' => 'publish',
                            'fields' => 'ids', // only load ids
                        );

                        $listing_loop_count = new WP_Query($args_count);
                        $listing_totnum = $listing_loop_count->found_posts;
                        $paging_args = array(
                            'total_posts' => $listing_totnum,
                            'posts_per_page' => get_option('posts_per_page'),
                            'paging_var' => $paging_var,
                            'show_pagination' => 'yes',
                        );
                        if ($posts_per_page < $wp_rem_cs_totalposts) {
                            do_action('wp_rem_cs_pagination', $paging_args);
                        }
                        ?>
                    </div> <!--row-->
                </div> <!--col-class-div-end -->
                <?php
                if (isset($wp_rem_cs_layout) && $wp_rem_cs_layout == 'sidebar_right') {

                    if (is_active_sidebar(wp_rem_cs_get_sidebar_id($wp_rem_cs_sidebar))) {
                        ?>
                        <div class="page-sidebar col-lg-4 col-md-4 col-sm-12 col-xs-12"><?php
                            dynamic_sidebar($wp_rem_cs_sidebar);
                            ?>
                        </div>
                        <?php
                    }
                }
                if (!is_active_sidebar(wp_rem_cs_get_sidebar_id($wp_rem_cs_sidebar)) && is_active_sidebar('sidebar-1')) {
                    echo '<div class="page-sidebar col-lg-4 col-md-4 col-sm-12 col-xs-12">';
                    dynamic_sidebar('sidebar-1');
                    echo '</div>';
                }
                ?>
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .page-section -->
</div><!-- .main-section -->
<?php
get_footer();
