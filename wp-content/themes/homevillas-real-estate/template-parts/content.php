<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wp_rem_cs
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class='entry-header'>
		<?php
		if ( is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php wp_rem_cs_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php
		endif;
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		the_content(sprintf(
			/* translators: %s: Name of current post. */
				wp_kses( wp_rem_cs_var_theme_text_srt('wp_rem_cs_content_continue_reding').' %s <span class="meta-nav">&rarr;</span>', array( 'span' => array( 'class' => array() ) ) ), the_title( '<span class="screen-reader-text">"', '"</span>', false )
		));

		wp_link_pages(array(
			'before' => '<div class="page-links">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_default_view_pages'),
			'after' => '</div>',
		));
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php wp_rem_cs_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->