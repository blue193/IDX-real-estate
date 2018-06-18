<?php

/*
  pagination class_alias */

if ( ! class_exists( 'Wp_rem_cs_Pagination' ) ) {

	Class Wp_rem_cs_Pagination {

		public function __construct() {
			add_action( 'wp_rem_cs_pagination', array( $this, 'wp_rem_cs_pagination_callback' ), 11, 1 );
		}

		public function wp_rem_cs_pagination_callback( $args ) {
			$total_posts = '';
			$posts_per_page = '5';
			$paging_var = 'paged_id';
			$show_pagination = 'yes';

			extract( $args );
			if ( $show_pagination <> 'yes' ) {
				return;
			} else if ( $total_posts < $posts_per_page ) {
				return;
			} else {
				if ( ! isset( $_GET['page_id'] ) ) {
					$_GET['page_id'] = '';
				}
				$qrystr = '';

				$html = '';
				$dot_pre = '';
				$dot_more = '';
				$total_page = 0;
				if ( $total_posts <> 0 )
					$total_page = ceil( $total_posts / $posts_per_page );
				$paged_id = 1;
				if ( isset( $_GET[$paging_var] ) && $_GET[$paging_var] != '' ) {
					$paged_id = $_GET[$paging_var];
				}
				$loop_start = $paged_id - 2;

				$loop_end = $paged_id + 2;

				if ( $paged_id < 3 ) {

					$loop_start = 1;

					if ( $total_page < 5 )
						$loop_end = $total_page;
					else
						$loop_end = 5;
				}

				else if ( $paged_id >= $total_page - 1 ) {

					if ( $total_page < 5 )
						$loop_start = 1;
					else
						$loop_start = $total_page - 4;

					$loop_end = $total_page;
				}

				$html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><nav role="navigation"><ul class="pagination">';
				if ( $paged_id > 1 ) {
					$html .= '<li><a href="?' . wp_rem_cs_allow_special_char($paging_var) . '=' . ($paged_id - 1) . wp_rem_cs_allow_special_char($qrystr) . '"  class="prev"><i class="icon-angle-left"></i></a></li>';
				} else {
					$html .= '<li><a class="prev"><i class="icon-angle-left"></i></a></li>';
				}

				if ( $paged_id > 3 and $total_page > 5 )
					$html .= '<li><a class="" href="?' . wp_rem_cs_allow_special_char($paging_var) . '=1' . wp_rem_cs_allow_special_char($qrystr) . '">1</a></li>';

				if ( $paged_id > 4 and $total_page > 6 )
					$html .= '<li><a>. . .</a><li>';

				if ( $total_page > 1 ) {

					for ( $i = $loop_start; $i <= $loop_end; $i ++ ) {

						if ( $i <> $paged_id )
							$html .= '<li><a class="" href="?' . wp_rem_cs_allow_special_char($paging_var) . '=' . esc_html($i) . wp_rem_cs_allow_special_char($qrystr) . '">' . esc_html($i) . '</a></li>';
						else
							$html .= '<li class="active"><a class="">' . esc_html($i) . '</a></li>';
					}
				}
				if ( $loop_end <> $total_page and $loop_end <> $total_page - 1 ) {
					$html .= '<li><a>. . .</a></li>';
				}
				if ( $loop_end <> $total_page ) {
					$html .= '<li><a href="?' . wp_rem_cs_allow_special_char($paging_var) . '=' . wp_rem_cs_allow_special_char($total_page) . '&' . wp_rem_cs_allow_special_char($qrystr) . '">' . wp_rem_cs_allow_special_char($total_page) . '</a></li>';
				}
				if ( $total_posts > 0 and $paged_id < ($total_posts / $posts_per_page) ) {
					$html .= '<li><a class="next" href="?' . wp_rem_cs_allow_special_char($paging_var) . '=' . (wp_rem_cs_allow_special_char($paged_id) + 1) . wp_rem_cs_allow_special_char($qrystr) . '" ><i class="icon-angle-right"></i></a></li>';
				} else {
					$html .= '<li><a class="next"><i class="icon-angle-right"></i></a><li>';
				}
				$html .= "</ul></nav></div>";
				echo force_balance_tags( wp_rem_cs_allow_special_char($html) );
			}
		}

	}

	global $Wp_rem_cs_Pagination;
	$Wp_rem_cs_Pagination = new Wp_rem_cs_Pagination();
}
?>