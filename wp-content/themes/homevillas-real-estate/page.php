<?php
/**
 * The template for displaying all pages
 */
get_header();

$var_arrays = array( 'post', 'wp_rem_cs_node', 'wp_rem_cs_sidebarLayout', 'column_class', 'wp_rem_cs_xmlObject', 'wp_rem_cs_node_id', 'column_attributes', 'wp_rem_cs_paged_id', 'wp_rem_cs_elem_id' );
$page_global_vars = WP_REM_CS_VAR_GLOBALS()->globalizing($var_arrays);
extract($page_global_vars);
$wp_rem_cs_post_id = isset($post->ID) ? $post->ID : '';
if ( isset($wp_rem_cs_post_id) and $wp_rem_cs_post_id <> '' ) {
	$wp_rem_cs_postObject = get_post_meta($post->ID, 'wp_rem_cs_full_data', true);
} else {
	$wp_rem_cs_post_id = '';
}
$section_margin_class = 'page-margin';
$wp_rem_cs_var_page_margin_switch = get_post_meta($post->ID, 'wp_rem_cs_var_page_margin_switch', true);
$wp_rem_cs_var_page_container_switch = get_post_meta($post->ID, 'wp_rem_cs_var_page_container_switch', true);
$wp_rem_cs_var_page_container_switch = isset($wp_rem_cs_var_page_container_switch) ? $wp_rem_cs_var_page_container_switch : '';
if ( $wp_rem_cs_var_page_margin_switch == 'on' ) {
	$section_margin_class = 'page-margin';
} else {
	$section_margin_class = '';
}
?>
<!-- Main Content Section -->
<div class="main-section <?php echo esc_attr($section_margin_class); ?>">

	<?php
	if ( $wp_rem_cs_var_page_container_switch == 'on' ) {
		echo '<div class="container">';
	}
	?>
    <div class="row">
		<?php
		$wp_rem_cs_page_sidebar_right = '';
		$wp_rem_cs_page_sidebar_left = '';
		$wp_rem_cs_postObject = get_post_meta($post->ID, 'wp_rem_cs_var_full_data', true);
		$wp_rem_cs_page_layout = get_post_meta($post->ID, 'wp_rem_cs_var_page_layout', true);
		$wp_rem_cs_page_sidebar_right = get_post_meta($post->ID, 'wp_rem_cs_var_page_sidebar_right', true);
		$wp_rem_cs_page_sidebar_left = get_post_meta($post->ID, 'wp_rem_cs_var_page_sidebar_left', true);
		$wp_rem_cs_page_bulider = get_post_meta($post->ID, "wp_rem_cs_page_builder", true);

		//$wp_rem_cs_page_bulider = 1;
		$section_container_width = '';
		$page_element_size = 'page-content-fullwidth';

		if ( ! isset($wp_rem_cs_page_layout) || $wp_rem_cs_page_layout == "none" ) {
			$page_element_size = 'page-content-fullwidth';
		} else {
			$page_element_size = 'page-content col-lg-8 col-md-8 col-sm-12 col-xs-12';
		}

		if ( isset($wp_rem_cs_page_layout) ) {
			$wp_rem_cs_sidebarLayout = $wp_rem_cs_page_layout;
		}
		$pageSidebar = false;
		if ( $wp_rem_cs_sidebarLayout == 'left' || $wp_rem_cs_sidebarLayout == 'right' ) {
			$pageSidebar = true;
		}

		if ( isset($wp_rem_cs_page_bulider) && $wp_rem_cs_page_bulider == 1 ) {
			if ($pageSidebar === true) {
				echo '<div class="col-xs-12">';
			}
			if ( isset($wp_rem_cs_page_layout) ) {
				$wp_rem_cs_page_sidebar_right = $wp_rem_cs_page_sidebar_right;
				$wp_rem_cs_page_sidebar_left = $wp_rem_cs_page_sidebar_left;
			}
			$wp_rem_cs_counter_node = $column_no = 0;
			$fullwith_style = '';
			$section_container_style_elements = ' ';
			if ( isset($wp_rem_cs_page_layout) && $wp_rem_cs_sidebarLayout <> '' and $wp_rem_cs_sidebarLayout <> "none" ) {

				$fullwith_style = 'style="width:100%;"';
				$section_container_style_elements = ' width: 100%;';
				echo '<div class="container">';
				echo '<div class="row">';


				if ( isset($wp_rem_cs_page_layout) && $wp_rem_cs_sidebarLayout <> '' and $wp_rem_cs_sidebarLayout <> "none" and $wp_rem_cs_sidebarLayout == 'left' ) :
					if ( is_active_sidebar(wp_rem_cs_get_sidebar_id($wp_rem_cs_page_sidebar_left)) ) {
						?>
						<aside class="page-sidebar left col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<?php if ( ! function_exists('dynamic_sidebar') || ! dynamic_sidebar($wp_rem_cs_page_sidebar_left) ) : endif; ?>
						</aside>
						<?php
					}
				endif;
				echo '<div class="' . ($page_element_size) . '">';
			}
			if ( post_password_required() ) {
				echo '<header class="heading"><h6 class="transform">' . get_the_title() . '</h6></header>';
				echo wp_rem_cs_password_form();
			} else {
				$width = 840;
				$height = 328;
				$image_url = wp_rem_cs_get_post_img_src($post->ID, $width, $height);
				wp_reset_postdata();


				if ( get_the_content() != '' || $image_url != '' ) {
					if ( $pageSidebar != true ) {
						?>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<?php
						}
						if ( isset($image_url) && $image_url != '' ) {
							?>
							<a href="<?php echo esc_url($image_url); ?>" data-rel="prettyPhoto" data-title="">
								<figure>
									<div class="page-featured-image">
										<img class="img-thumbnail cs-page-thumbnail" title="" alt="" data-src="" src="<?php echo esc_url($image_url); ?>">
									</div>
								</figure>
							</a>
							<?php
						}
						echo '<div class="cs-rich-editor">';
						$pattern = "/<p[^>]*><\\/p[^>]*>/";
						$content = get_the_content();
						preg_replace($pattern, '', $content);
						do_shortcode($content);
						echo '</div>';
						if ( $pageSidebar != true ) {
							?>
						</div>
						<?php
					}
				}
			}

			if ( isset($wp_rem_cs_page_layout) && $wp_rem_cs_sidebarLayout <> '' and $wp_rem_cs_sidebarLayout <> "none" ) {
				echo '</div>';
			}

			if ( isset($wp_rem_cs_page_layout) && $wp_rem_cs_sidebarLayout <> '' && $wp_rem_cs_sidebarLayout <> "none" && $wp_rem_cs_sidebarLayout == 'right' ) :
				if ( is_active_sidebar(wp_rem_cs_get_sidebar_id($wp_rem_cs_page_sidebar_right)) ) {
					?>
					<aside class="page-sidebar right col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<?php dynamic_sidebar($wp_rem_cs_page_sidebar_right); ?>
					</aside>
					<?php
				}
			endif;
			if ( isset($wp_rem_cs_page_layout) && $wp_rem_cs_sidebarLayout <> '' and $wp_rem_cs_sidebarLayout <> "none" ) {
				echo '</div>';
				echo '</div>';
			}
			
			if ($pageSidebar === true) {
				echo '</div>';
			}
		} else {
			$main_con_classes = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
			if ( is_active_sidebar('sidebar-1') ) {
				$main_con_classes = 'col-lg-8 col-md-8 col-sm-12 col-xs-12';
			}
			
			//echo '<div class="col-xs-12">';
			//echo '<div class="container">';
			//echo '<div class="row">';
			?>

			<div class="<?php echo esc_attr($main_con_classes) ?>">
				<?php
				while ( have_posts() ) : the_post();
					echo '<div class="cs-rich-editor">';
					the_content();
					echo '</div>';
				endwhile;

				if ( comments_open() ) :
					comments_template('', true);
				endif;
				?>
			</div>
			<?php
			if ( is_active_sidebar('sidebar-1') ) {
				?>
				<aside class="page-sidebar col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<?php
					dynamic_sidebar('sidebar-1');
					?>
				</aside>
				<?php
			}
			//echo '</div>';
			//echo '</div>';
			//echo '</div>';
		}
		if ( $wp_rem_cs_var_page_container_switch == 'on' ) {
			echo '</div>';
		}
		?>
	</div>
</div><!-- End Main Content Section -->
<?php
get_footer();
