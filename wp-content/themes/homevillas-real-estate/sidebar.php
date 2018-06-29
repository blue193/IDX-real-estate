<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_rem_cs
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area" role="complementary">
<?php if (is_active_sidebar('sidebar-1')) {
		if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-1')) :
			echo '';
		endif;
	}?> 
</aside><!-- #secondary -->