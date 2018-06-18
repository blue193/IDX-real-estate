<?php

/**
 * @Blog Categories html form for page builder
 */
if ( ! function_exists( 'wp_rem_cs_var_wp_rem_cs_blog_categories_shortcode' ) ) {

    function wp_rem_cs_var_wp_rem_cs_blog_categories_shortcode( $atts, $content = "" ) {
		global $wp_rem_cs_var_static_text;
		$strings = new wp_rem_cs_theme_all_strings;
		$strings->wp_rem_cs_short_code_strings();
        $wp_rem_cs_var_defaults = array(
            'blog_cats_element_title' => '',
            'blog_cats' => '',
			'blog_num_cats' => '',
			'blog_cats_more_link_switch' => '',
			'blog_cats_more_link' => ''
        );
        extract( shortcode_atts( $wp_rem_cs_var_defaults, $atts ) );
		
		if ( isset( $wp_rem_cs_var_column_size ) && $wp_rem_cs_var_column_size != '' ) {
            if ( function_exists( 'wp_rem_cs_var_custom_column_class' ) ) {
                $column_class = wp_rem_cs_var_custom_column_class( $wp_rem_cs_var_column_size );
            }
        }
        
        $blog_cats_element_title = isset( $blog_cats_element_title ) ? $blog_cats_element_title : '';
        $blog_cats = isset( $blog_cats ) ? $blog_cats : '';
        $blog_num_cats = isset( $blog_num_cats ) ? $blog_num_cats : '';
        
		
        $html = '';
		if ( isset( $column_class ) && $column_class <> '' ) {
			$html .= '<div class="' . esc_html( $column_class ) . '">';
        }
			if ( $blog_cats_element_title !== '' ) {
				$html .= '<div class="element-title"><h2>' . esc_html( $blog_cats_element_title ) . '</h4></div>';
			}
			$html .= '<ul class="game-category">';
				if( '' !== $blog_cats ){
					$cats = explode( ',', $blog_cats );
					$count = 1;
					foreach( $cats as $cat ){
						$category = get_category_by_slug( $cat );
						$cat_meta = get_term_meta( $category->term_id, 'cat_meta_data', true );
                        $cat_icon = isset( $cat_meta['cat_icon'] ) ? $cat_meta['cat_icon'] : '';
						$cat_icon_html = '';
						if ( '' !== $cat_icon ) {
                            $cat_icon_html = '<i class="' . $cat_icon . '"></i>';
                        }
						$html .= '<li><a href="'. get_term_link( $category->term_id ) .'">'. esc_html($cat_icon_html) . esc_html($category->name) .'</a></li>';
						if( $blog_num_cats == $count ){
							break;
						}
						$count++;
					}
				}else{
					$categories = get_categories( 'post' );
					if ( $categories ) {
						$count = 1;
						foreach ( $categories as $category ) {
							$cat_meta = get_term_meta( $category->term_id, 'cat_meta_data', true );
							$cat_icon = isset( $cat_meta['cat_icon'] ) ? $cat_meta['cat_icon'] : '';
							$cat_icon_html = '';
							if ( '' !== $cat_icon ) {
								$cat_icon_html = '<i class="' . $cat_icon . '"></i>';
							}
							$html .= '<li><a href="'. get_term_link( $category->term_id ) .'">'. esc_html($cat_icon_html) . esc_html($category->name) .'</a></li>';
							if( $blog_num_cats == $count ){
								break;
							}
							$count++;
						}
					}
				}
				if( 'on' === $blog_cats_more_link_switch && '' !== $blog_cats_more_link ){
					$html .= '<li><a href="'. esc_url( $blog_cats_more_link ) .'"><i class="icon-uniF11B"></i>'. wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_cats_more' ) .'</a></li>';
				}
			$html .= '</ul>';
		
		if ( isset( $column_class ) && $column_class <> '' ) {
            $html .= '</div>';
        }

		return do_shortcode( $html );
    }

    if ( function_exists( 'wp_rem_cs_var_short_code' ) )
        wp_rem_cs_var_short_code( 'wp_rem_cs_blog_categories', 'wp_rem_cs_var_wp_rem_cs_blog_categories_shortcode' );
}