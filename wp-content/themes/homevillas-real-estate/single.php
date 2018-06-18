<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package wp_rem_cs
 */
global $post;
if (is_single()) {
    wp_rem_post_views_count($post->ID);
}
get_header();
$wp_rem_cs_var_options = WP_REM_CS_VAR_GLOBALS()->theme_options();
$section_margin_class = 'page-margin';
$wp_rem_cs_var_page_margin_switch = get_post_meta($post->ID, 'wp_rem_cs_var_page_margin_switch', true);
if ( $wp_rem_cs_var_page_margin_switch == 'on' ) {
	$section_margin_class = 'page-margin';
}else{
    $section_margin_class = '';
}
?>
<div class="main-section <?php echo esc_attr($section_margin_class); ?>">
	<?php
	while ( have_posts() ) : the_post();
	   	get_template_part('template-parts/blog-detail/default_view', get_post_format());
	endwhile; // End of the loop.
	?>
</div>
<?php
get_footer();