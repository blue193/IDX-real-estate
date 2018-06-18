<?php
/*
 * Remove wordpress 
 * default comment 
 * filter
 */
remove_filter('comment_form_field_comment', 'wp_rem_cs_filter_comment_form_field_comment', 10, 1);
remove_action('comment_form_logged_in_after', 'wp_rem_cs_comment_tut_fields');
remove_action('comment_form_after_fields', 'wp_rem_cs_comment_tut_fields');
/**
 * The template for 
 * product detail
 */
get_header();
$wp_rem_cs_page_sidebar_right = '';
$wp_rem_cs_page_sidebar_left = '';
$wp_rem_cs_var_layout = '';
$leftSidebarFlag = false;
$rightSidebarFlag = false;
$wp_rem_cs_var_layout = get_post_meta($post->ID, 'wp_rem_cs_var_page_layout', true);
$wp_rem_cs_sidebar_right = get_post_meta($post->ID, 'wp_rem_cs_var_page_sidebar_right', true);
$wp_rem_cs_sidebar_left = get_post_meta($post->ID, 'wp_rem_cs_var_page_sidebar_left', true);

if ($wp_rem_cs_var_layout == 'left') {
    $wp_rem_cs_var_layout = "page-content col-lg-9 col-md-9 col-sm-12 col-xs-12";
    $leftSidebarFlag = true;
} else if ($wp_rem_cs_var_layout == 'right') {
    $wp_rem_cs_var_layout = "page-content col-lg-9 col-md-9 col-sm-12 col-xs-12";
    $rightSidebarFlag = true;
} else {
    $wp_rem_cs_var_layout = "page-content-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12";
}
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <!-- .entry -header -->
        <div class="main-section"> 
            <div class="page-section">
                <div class="container">
                    <div class="row">
                        <?php if ($leftSidebarFlag == true) { ?>
                            <div class="page-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <?php
                                if (is_active_sidebar(wp_rem_cs_get_sidebar_id($wp_rem_cs_sidebar_left))) {
                                    if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($wp_rem_cs_sidebar_left)) : endif;
                                }
                                ?>
                            </div>
                        <?php } ?>

                        <div class="<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_layout) ?>">
                            <div class="cs-shop-wrap">
                                <?php
                                if (function_exists('woocommerce_content')) {
                                    woocommerce_content();
                                } 
                                ?>
                            </div>
                        </div>
                        <?php if ($rightSidebarFlag == true) { ?>
                            <div class="page-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <?php
                                if (is_active_sidebar(wp_rem_cs_get_sidebar_id($wp_rem_cs_sidebar_right))) {
                                    if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($wp_rem_cs_sidebar_right)) : endif;
                                }
                                ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </main><!-- .Site Main start -->
</div><!-- .content-area -->
<?php get_footer(); ?>
