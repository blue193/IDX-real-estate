<?php
/**
 * The template for displaying image attachments
 *
 * @package WordPress
 * @subpackage Wp_rem_cs
 * @since Wp_rem_cs
 */
get_header();

if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_excerpt_length']) && $wp_rem_cs_var_options['wp_rem_cs_var_excerpt_length'] <> '' ) {
    $default_excerpt_length = $wp_rem_cs_var_options['wp_rem_cs_var_excerpt_length'];
} else {
    $default_excerpt_length = '60';
}
$wp_rem_cs_layout = isset($wp_rem_cs_var_options['wp_rem_cs_var_default_page_layout']) ? $wp_rem_cs_var_options['wp_rem_cs_var_default_page_layout'] : '';
$wp_rem_cs_default_sidebar = false;
if ( $wp_rem_cs_layout == '' ) {
    $wp_rem_cs_default_sidebar = true;
}
if ( isset($wp_rem_cs_layout) && ($wp_rem_cs_layout == "sidebar_left" || $wp_rem_cs_layout == "sidebar_right") ) {
    $wp_rem_cs_col_class = "page-content col-lg-8 col-md-8 col-sm-12 col-xs-12";
} else if ( $wp_rem_cs_default_sidebar == true ) {
    $wp_rem_cs_col_class = "page-content col-lg-8 col-md-8 col-sm-12 col-xs-12";
} else {
    $wp_rem_cs_col_class = "page-content-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12";
}
$strings = new wp_rem_cs_theme_all_strings;
$strings->wp_rem_cs_theme_option_strings();
$wp_rem_cs_sidebar = isset($wp_rem_cs_var_options['wp_rem_cs_var_default_layout_sidebar']) ? $wp_rem_cs_var_options['wp_rem_cs_var_default_layout_sidebar'] : '';
$wp_rem_cs_blog_excerpt_theme_option = isset($wp_rem_cs_var_options['wp_rem_cs_var_excerpt_length']) ? $wp_rem_cs_var_options['wp_rem_cs_var_excerpt_length'] : '255';
$section_margin_class = 'page-margin';
$wp_rem_cs_var_page_margin_switch = get_post_meta($post->ID, 'wp_rem_cs_var_page_margin_switch', true);
if ( $wp_rem_cs_var_page_margin_switch == 'on' ) {
    $section_margin_class = 'page-margin';
} else {
    $section_margin_class = '';
}
?>
<div class="main-section <?php echo esc_attr($section_margin_class); ?>">
    <div class="page-section">
        <!-- Container -->
        <div class="container">
            <!-- Row -->
            <div class="row">
                <?php if ( $wp_rem_cs_layout == 'sidebar_left' ) { ?>
                    <div class="page-sidebar col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <?php
                        if ( is_active_sidebar(wp_rem_cs_get_sidebar_id($wp_rem_cs_sidebar)) ) {
                            if ( ! function_exists('dynamic_sidebar') || ! dynamic_sidebar($wp_rem_cs_sidebar) ) : endif;
                        }
                        ?>
                    </div>
                <?php } ?>
                <div class="<?php echo esc_html($wp_rem_cs_col_class); ?>">
                    <?php
                    // Start the loop.
                    while ( have_posts() ) : the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <nav id="image-navigation" class="navigation image-navigation">
                                <div class="nav-links">
                                    <div class="nav-previous"><?php previous_image_link(false, wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_page_previous')); ?></div>
                                    <div class="nav-next"><?php next_image_link(false, wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_page_next')); ?></div>
                                </div><!-- .nav-links -->
                            </nav><!-- .image-navigation -->
                            <div class="entry-content">
                                <div class="entry-attachment">
                                    <?php
                                    /**
                                     * Filter the default wp_rem_cs image attachment size.
                                     *
                                     * @since Wp Rem *
                                     * @param string $image_size Image size. Default 'large'.
                                     */
                                    $image_size = apply_filters('wp_rem_cs_attachment_size', 'large');
                                    echo wp_get_attachment_image(get_the_ID(), $image_size);
                                    ?>
                                    <?php
                                    if ( function_exists('wp_rem_cs_excerpt') ):
                                        wp_rem_cs_excerpt('entry-caption');
                                    endif;
                                    ?>
                                </div><!-- .entry-attachment -->
                                <?php
                                the_content();
                                wp_link_pages(array(
                                    'before' => '<div class="page-links"><span class="page-links-title">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_pages') . '</span>',
                                    'after' => '</div>',
                                    'link_before' => '<span>',
                                    'link_after' => '</span>',
                                    'pagelink' => '<span class="screen-reader-text">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_page') . ' </span>%',
                                    'separator' => '<span class="screen-reader-text">, </span>',
                                ));
                                ?>
                            </div><!-- .entry-content -->
                            <footer class="entry-footer">
                                <?php
                                if ( function_exists('wp_rem_cs_entry_meta') ):
                                    wp_rem_cs_entry_meta();
                                endif;

                                // Retrieve attachment metadata.
                                $metadata = wp_get_attachment_metadata();
                                if ( $metadata ) {
                                    printf('<span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>', wp_rem_cs_var_theme_text_srt('wp_rem_cs_full_size_image_footer'), esc_url(wp_get_attachment_url()), absint($metadata['width']), absint($metadata['height'])
                                    );
                                }
                                edit_post_link(
                                        sprintf(
                                                /* translators: %s: Name of current post */
                                                wp_rem_cs_var_theme_text_srt('wp_rem_cs_image_edit') . '<span class="screen-reader-text"> "%s"</span>', get_the_title()
                                        ), '<span class="edit-link">', '</span>'
                                );
                                ?>
                            </footer><!-- .entry-footer -->
                        </article><!-- #post-## -->
                        <?php
                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) {
                            comments_template();
                        }
                        // Parent post navigation.
                        the_post_navigation(array(
                            'prev_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_image_published_in'),
                        ));
                    // End the loop.
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
                <?php
                if ( isset($wp_rem_cs_layout) && $wp_rem_cs_layout == 'sidebar_right' ) {
                    if ( is_active_sidebar(wp_rem_cs_get_sidebar_id($wp_rem_cs_sidebar)) ) {
                        ?>
                        <div class="page-sidebar col-lg-4 col-md-4 col-sm-12 col-xs-12"><?php
                            if ( ! function_exists('dynamic_sidebar') || ! dynamic_sidebar($wp_rem_cs_sidebar) ) :
                                ?><?php
                            endif;
                            ?>
                        </div>
                        <?php
                    }
                }
                if ( is_active_sidebar('sidebar-1') ) {
                    echo '<div class="page-sidebar col-lg-4 col-md-4 col-sm-12 col-xs-12">';
                    if ( ! function_exists('dynamic_sidebar') || ! dynamic_sidebar('sidebar-1') ) : endif;
                    echo '</div>';
                }
                ?>
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .page-section -->
</div><!-- .main-section -->
<?php
get_footer();
