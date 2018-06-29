<?php

/*
 *
 * @Shortcode Name : Video 
 * @retrun
 *
 */
if ( ! function_exists( 'wp_rem_cs_var_video' ) ) {

	function wp_rem_cs_var_video( $atts, $content = "" ) {
		$video = '';
		$page_element_size = isset( $atts['video_element_size'] ) ? $atts['video_element_size'] : 100;
		if ( function_exists( 'wp_rem_cs_var_page_builder_element_sizes' ) ) {
			$video .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes( $page_element_size ) . ' ">';
		}
		$defaults = array(
			'wp_rem_cs_var_column_size' => '',
			'wp_rem_cs_var_video_title' => '',
			'wp_rem_cs_var_video_subtitle' => '',
			'wp_rem_cs_var_video_url' => '',
			'wp_rem_cs_var_height' => '',
			'wp_rem_var_video_align' => '',
		);
		extract( shortcode_atts( $defaults, $atts ) );
		$wp_rem_cs_var_video_title = isset( $wp_rem_cs_var_video_title ) ? $wp_rem_cs_var_video_title : '';
		$wp_rem_cs_var_video_url = isset( $wp_rem_cs_var_video_url ) ? $wp_rem_cs_var_video_url : '';
		$wp_rem_cs_var_height = isset( $wp_rem_cs_var_height ) ? $wp_rem_cs_var_height : '';
		$video_url = '';
		$video_url = parse_url( $wp_rem_cs_var_video_url );
		$wp_rem_cs_iframe = '<' . 'i' . 'frame ';
		// Column Class
		$column_class = '';
		if ( isset( $wp_rem_cs_var_column_size ) && $wp_rem_cs_var_column_size != '' ) {
			if ( function_exists( 'wp_rem_cs_var_custom_column_class' ) ) {
				$column_class = wp_rem_cs_var_custom_column_class( $wp_rem_cs_var_column_size );
			}
		}
		// Start Element Column CLass
		if ( isset( $column_class ) && $column_class <> '' ) {
			$video .= '<div class="' . esc_html( $column_class ) . '">';
		}

		// Start Video Element Content

		$video .= wp_rem_title_sub_align( $wp_rem_cs_var_video_title, $wp_rem_cs_var_video_subtitle, $wp_rem_var_video_align );

		$video .= '<div class="video-ifram-holder">';
		if ( $wp_rem_cs_var_video_url != '' ) {
			if ( $video_url['host'] == $_SERVER["SERVER_NAME"] ) {
				$video .= '<figure  class="cs-video ' . $column_class . '">';
				$video .= '' . do_shortcode( '[video height="' . $wp_rem_cs_var_height . '"  src="' . esc_url( $wp_rem_cs_var_video_url ) . '"][/video]' ) . '';
				$video .= '</figure>';
			} else {
				$video .= wp_oembed_get( $wp_rem_cs_var_video_url, array( 'height' => $wp_rem_cs_var_height ) );
			}
		}
		$video .= '</div>';

		// End Video Element Content
		// End Element Column CLass
		if ( isset( $column_class ) && $column_class <> '' ) {
			$video .= '</div>';
		}
		if ( function_exists( 'wp_rem_cs_var_page_builder_element_sizes' ) ) {
			$video .= '</div>';
		}
		return $video;
	}

	if ( function_exists( 'wp_rem_cs_var_short_code' ) )
		wp_rem_cs_var_short_code( 'wp_rem_cs_video', 'wp_rem_cs_var_video' );
}

function wp_rem_cs_oembed_filter( $return, $data, $url ) {
	$return = str_replace( 'frameborder="0"', 'style="border: none"', $return );
	return $return;
}

add_filter( 'oembed_dataparse', 'wp_rem_cs_oembed_filter', 90, 3 );
