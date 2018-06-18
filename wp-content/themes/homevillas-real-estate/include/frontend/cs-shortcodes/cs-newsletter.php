<?php

/*
 *
 * @Shortcode Name : Video 
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_var_newsletter') ) {

    function wp_rem_cs_var_newsletter($atts, $content = "") {
        $newsletter = '';
        $page_element_size = isset($atts['newsletter_element_size']) ? $atts['newsletter_element_size'] : 100;
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $newsletter .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }
        $defaults = array(
            'wp_rem_cs_var_newsletter_title' => '',
            'wp_rem_cs_var_newsletter_subtitle' => '',
            'wp_rem_var_newsletter_align' => '',
            'wp_rem_cs_var_newsletter_api_key' => '',
            'wp_rem_var_newsletter_list' => '',
            'wp_rem_var_newsletter_styles' => '',
            'wp_rem_var_newsletter_social_icons'=>'',
        );
        extract(shortcode_atts($defaults, $atts));
        $wp_rem_cs_var_newsletter_title = isset($wp_rem_cs_var_newsletter_title) ? $wp_rem_cs_var_newsletter_title : '';
        $wp_rem_cs_var_newsletter_subtitle = isset($wp_rem_cs_var_newsletter_subtitle) ? $wp_rem_cs_var_newsletter_subtitle : '';
        $wp_rem_var_newsletter_align = isset($wp_rem_var_newsletter_align) ? $wp_rem_var_newsletter_align : '';
        $wp_rem_cs_var_newsletter_subtitle = isset($wp_rem_cs_var_newsletter_subtitle) ? $wp_rem_cs_var_newsletter_subtitle : '';
        $wp_rem_var_newsletter_list = isset($wp_rem_var_newsletter_list) ? $wp_rem_var_newsletter_list : '';
        $wp_rem_var_newsletter_styles = isset($wp_rem_var_newsletter_styles) ? $wp_rem_var_newsletter_styles : '';
        $wp_rem_var_newsletter_social_icons = isset($wp_rem_var_newsletter_social_icons) ? $wp_rem_var_newsletter_social_icons : '';
        $social_icon_class = '';
        if(isset($wp_rem_var_newsletter_social_icons) && $wp_rem_var_newsletter_social_icons == 'yes'){
            $social_icon_class = ' has-social-icon';
        }
        

        $news_letter_class = 'classic';
        if ( $wp_rem_var_newsletter_styles == 'modern' ) {
            $news_letter_class = 'classic v2'.$social_icon_class.'';
        }
        
        if ( $wp_rem_var_newsletter_styles == 'boxed' ) {
            $news_letter_class = 'boxed';
        }
        
        // Column Class
        $column_class = '';
        if ( isset($wp_rem_cs_var_column_size) && $wp_rem_cs_var_column_size != '' ) {
            if ( function_exists('wp_rem_cs_var_custom_column_class') ) {
                $column_class = wp_rem_cs_var_custom_column_class($wp_rem_cs_var_column_size);
            }
        }
        // Start Element Column CLass
        if ( isset($column_class) && $column_class <> '' ) {
            $newsletter .= '<div class="' . esc_html($column_class) . '">';
        }
        // Start Video Element Content
        $newsletter .= wp_rem_title_sub_align($wp_rem_cs_var_newsletter_title, $wp_rem_cs_var_newsletter_subtitle, $wp_rem_var_newsletter_align);
        $newsletter .='<div class="newsletter ' . $news_letter_class . '">';
         
        
        if ( $wp_rem_var_newsletter_styles == 'modern' ) {
            $newsletter .= '<div class="newsletter-wrapper">';
        }
        
        
        
        if ( $wp_rem_var_newsletter_styles == 'modern' ) {
            $newsletter .='<div class="news-title"><strong><i class="icon-envelope-o"></i>' . do_shortcode($content) . '</strong></div>';
        }

        if ( function_exists('wp_rem_cs_custom_mailchimp') ) {
            if ( '' !== $content && ' ' !== $content && $wp_rem_var_newsletter_styles != 'modern' ) {
                $newsletter .= '<span class="newsletter-title">';
                $newsletter .= do_shortcode($content);
                $newsletter .= '</span>';
            }
            $mailchim_widget = 4;
            ob_start();
            wp_rem_cs_custom_mailchimp($mailchim_widget, $wp_rem_cs_var_newsletter_api_key, $wp_rem_var_newsletter_list);
            $newsletter .= ob_get_contents();
            ob_end_clean();
        }
        
        if ( $wp_rem_var_newsletter_styles == 'modern' ) {
           $newsletter .= '</div>';
        }
        
        
        if ( $wp_rem_var_newsletter_styles == 'modern' && $wp_rem_var_newsletter_social_icons == 'yes') {
            $newsletter .='<div class="socialmedia">
                                <strong>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_edit_newsletter_folow_us') . '</strong>';
            if ( function_exists('wp_rem_cs_social_network') ) {
                $newsletter .= wp_rem_cs_social_network(1, '', '', 'social-media');
            }
            $newsletter .='</div>';
        }
        $newsletter .='</div>';
        // End Video Element Content
        // End Element Column CLass
        if ( isset($column_class) && $column_class <> '' ) {
            $newsletter .= '</div>';
        }
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $newsletter .= '</div>';
        }
        return $newsletter;
    }

    if ( function_exists('wp_rem_cs_var_short_code') )
        wp_rem_cs_var_short_code('wp_rem_cs_newsletter', 'wp_rem_cs_var_newsletter');
}

