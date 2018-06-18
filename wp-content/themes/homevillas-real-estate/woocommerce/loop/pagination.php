<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$var_arrays = array('wp_query');
$page_global_vars = WP_REM_CS_VAR_GLOBALS()->globalizing($var_arrays);
extract($page_global_vars);

if ( $wp_query->max_num_pages <= 1 ) {
	return;
}

$woo_pagination = paginate_links( array(
	'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
	'format'       => '',
	'add_args'     => '',
	'current'      => max( 1, get_query_var( 'paged' ) ),
	'total'        => $wp_query->max_num_pages,
	'prev_text'    => '<i class="icon-angle-left"></i> '.wp_rem_cs_var_theme_text_srt('wp_rem_cs_pagination_previous'),
	'next_text'    => wp_rem_cs_var_theme_text_srt('wp_rem_cs_pagination_next').' <i class="icon-angle-right"></i>',
	'type'         => 'array',
	'end_size'     => 3,
	'mid_size'     => 3
) );

$wp_rem_cs_pages = '';
if (is_array($woo_pagination) && sizeof($woo_pagination) > 0) {
    $wp_rem_cs_pages .= '<ul class="pagination">';
    foreach ($woo_pagination as $wp_rem_cs_link) {
        if (strpos($wp_rem_cs_link, 'current') !== false) {
            $wp_rem_cs_pages .= '<li><a class="active">' . preg_replace("/[^0-9]/", "", $wp_rem_cs_link) . '</a></li>';
        } else {
            $wp_rem_cs_pages .= '<li>' . $wp_rem_cs_link . '</li>';
        }
    }
    $wp_rem_cs_pages .= '</ul>';
}
echo force_balance_tags($wp_rem_cs_pages);