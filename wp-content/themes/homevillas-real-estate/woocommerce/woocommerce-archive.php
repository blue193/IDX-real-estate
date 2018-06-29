<?php
/**
 * Shop Archive
 */
$var_arrays = array('post', 'wp_rem_cs_var_options');
$page_global_vars = WP_REM_CS_VAR_GLOBALS()->globalizing($var_arrays);
extract($page_global_vars);

$wp_rem_cs_layout = isset($wp_rem_cs_var_options['wp_rem_cs_var_woo_archive_layout']) ? $wp_rem_cs_var_options['wp_rem_cs_var_woo_archive_layout'] : '';
if ($wp_rem_cs_layout == "sidebar_left" || $wp_rem_cs_layout == "sidebar_right") {
    $wp_rem_cs_col_class = "page-content col-lg-9 col-md-9 col-sm-12 col-xs-12";
} else {
    $wp_rem_cs_col_class = "page-content-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12";
}
$wp_rem_cs_sidebar = isset($wp_rem_cs_var_options['wp_rem_cs_var_woo_archive_sidebar']) ? $wp_rem_cs_var_options['wp_rem_cs_var_woo_archive_sidebar'] : '';

?>   

<div class="main-section">
    <div class="page-section">
        <!-- Container -->
        <div class="container">
            <!-- Row -->
            <div class="row">
                <?php if ($wp_rem_cs_layout == 'sidebar_left') { ?>
                    <div class="page-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <?php
                        if (is_active_sidebar(wp_rem_cs_get_sidebar_id($wp_rem_cs_sidebar))) {
                            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($wp_rem_cs_sidebar)) : endif;
                        }
                        ?>
                    </div>
                <?php } ?>
                
                <div class="<?php echo esc_html($wp_rem_cs_col_class); ?>">
                    <?php
                    if (function_exists('woocommerce_content')) {
                        woocommerce_content();
                    }
                    ?>
                </div>
                <?php if ($wp_rem_cs_layout == 'sidebar_right') { ?>
                    <div class="page-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12"><?php
                    if (is_active_sidebar(wp_rem_cs_get_sidebar_id($wp_rem_cs_sidebar))) {
                        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($wp_rem_cs_sidebar)) : endif;
                    }
                    ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>