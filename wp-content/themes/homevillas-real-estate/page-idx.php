<?php
/**
 * Template name: IDX Listings
 */
get_header();
$var_arrays = array('post', 'wp_rem_cs_node', 'wp_rem_cs_sidebarLayout', 'column_class', 'wp_rem_cs_xmlObject', 'wp_rem_cs_node_id', 'column_attributes', 'wp_rem_cs_paged_id', 'wp_rem_cs_elem_id');
$page_global_vars = WP_REM_CS_VAR_GLOBALS()->globalizing($var_arrays);
extract($page_global_vars);
$wp_rem_cs_post_id = isset($post->ID) ? $post->ID : '';
if (isset($wp_rem_cs_post_id) and $wp_rem_cs_post_id <> '') {
    $wp_rem_cs_postObject = get_post_meta($post->ID, 'wp_rem_cs_full_data', true);
} else {
    $wp_rem_cs_post_id = '';
}
$section_margin_class = 'page-margin';
$wp_rem_cs_var_page_margin_switch = get_post_meta($post->ID, 'wp_rem_cs_var_page_margin_switch', true);
$wp_rem_cs_var_page_container_switch = get_post_meta($post->ID, 'wp_rem_cs_var_page_container_switch', true);
$wp_rem_cs_var_page_container_switch = isset($wp_rem_cs_var_page_container_switch) ? $wp_rem_cs_var_page_container_switch : '';
if ($wp_rem_cs_var_page_margin_switch == 'on') {
    $section_margin_class = 'page-margin';
} else {
    $section_margin_class = '';
}
?>
<!-- Main Content Section -->
<div class="main-section <?php echo esc_attr($section_margin_class); ?>">
    <div class="container">
        <div class="row">
            <?php
            $wp_rem_cs_page_sidebar_right = '';
            $wp_rem_cs_page_sidebar_left = '';
            $wp_rem_cs_postObject = get_post_meta($post->ID, 'wp_rem_cs_var_full_data', true);
            $wp_rem_cs_page_layout = get_post_meta($post->ID, 'wp_rem_cs_var_page_layout', true);
            $wp_rem_cs_page_sidebar_right = get_post_meta($post->ID, 'wp_rem_cs_var_page_sidebar_right', true);
            $wp_rem_cs_page_sidebar_left = get_post_meta($post->ID, 'wp_rem_cs_var_page_sidebar_left', true);
            $wp_rem_cs_page_bulider = get_post_meta($post->ID, "wp_rem_cs_page_builder", true); 
            $section_container_width = '';
            $page_element_size = 'page-content-fullwidth';
            if (!isset($wp_rem_cs_page_layout) || $wp_rem_cs_page_layout == "none") {
                $page_element_size = 'page-content-fullwidth';
            } else {
                $page_element_size = 'page-content col-lg-8 col-md-8 col-sm-12 col-xs-12';
            }
            if (isset($wp_rem_cs_page_layout)) {
                $wp_rem_cs_sidebarLayout = $wp_rem_cs_page_layout;
            }
            $pageSidebar = false;
            if ($wp_rem_cs_sidebarLayout == 'left' || $wp_rem_cs_sidebarLayout == 'right') {
                $pageSidebar = true;
            }
            $main_con_classes = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
            if (is_active_sidebar('sidebar-1')) {
                $main_con_classes = 'col-lg-8 col-md-8 col-sm-12 col-xs-12';
            }
            ?>
            <div class="<?php echo esc_attr($main_con_classes) ?>">
                <?php
                while (have_posts()) : the_post();
                    echo '<div class="cs-rich-editor">';
                    the_content();
                    echo '</div>';
                endwhile;

                if (comments_open()) :
                    comments_template('', true);
                endif;
                ?>
            </div>
            <?php
            if (is_active_sidebar('sidebar-1')) {
                ?>
                <aside class="page-sidebar col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <?php
                    dynamic_sidebar('sidebar-1');
                    ?>
                </aside>
                <?php
            }
            ?>
        </div>
    </div><!-- End Container-->
</div><!-- End Main Content Section -->
<?php
get_footer();