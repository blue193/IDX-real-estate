<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wp_rem_cs
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(array(
			'before' => '<div class="page-links">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_content_page_pages'),
			'after' => '</div>',
		));
		?>
		</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
						wp_rem_cs_var_theme_text_srt('wp_rem_cs_content_page_eddit'), the_title( '<span class="screen-reader-text">"', '"</span>', false )
				), '<span class="edit-link">', '</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-## -->