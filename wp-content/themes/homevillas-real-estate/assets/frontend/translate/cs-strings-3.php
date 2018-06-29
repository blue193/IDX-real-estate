<?php

/**
 * Static string 3
 */
if ( ! class_exists('wp_rem_cs_theme_all_strings_3') ) {

    class wp_rem_cs_theme_all_strings_3 {

        public function __construct() {

            add_filter('wp_rem_cs_theme_strings', array( $this, 'wp_rem_cs_theme_strings_callback' ), 10);
        }

        public function wp_rem_cs_theme_strings_callback($wp_rem_cs_var_static_text) {
            global $wp_rem_cs_var_static_text;

            $wp_rem_cs_var_static_text['wp_rem_cs_admin_func_title'] = esc_html__('Title', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_admin_func_url'] = esc_html__('URL', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_admin_func_logo'] = esc_html__('Logo', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_plugin_options_fields_success_installed'] = esc_html__('Successfully installed', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_plugin_options_fields_unable_upgrade'] = esc_html__('Sorry unable to upgrade theme. Contact Theme Author and repot this issue.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_plugin_options_fields_clients'] = esc_html__('Clients', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_plugin_options_fields_enable_in_footer'] = esc_html__('Enable clients in footer', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_plugin_options_fields_client_footer_title'] = esc_html__('Title', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_plugin_options_fields_client_footer_url'] = esc_html__('URL', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_plugin_options_fields_client_footer_logo'] = esc_html__('Logo', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_plugin_options_fields_added_clients'] = esc_html__('Added Clients', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_rating_rating_outoff'] = esc_html__('Rated %s out of 5', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_product_image_placeholder'] = esc_html__('Placeholder', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_meta_na'] = esc_html__('N/A', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_pagination_next'] = esc_html__('Next', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_pagination_previous'] = esc_html__('Previous', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_pagination_prev'] = esc_html__('Prev', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_cart_product'] = esc_html__('Product', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_cart_price'] = esc_html__('Price', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_cart_quantity'] = esc_html__('Quantity', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_cart_total'] = esc_html__('Total', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_cart_remove_item'] = esc_html__('Remove this item', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_cart_available_on_backorder'] = esc_html__('Available on backorder', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_cart_coupen'] = esc_html__('Coupon', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_cart_coupen_code'] = esc_html__('Coupon code', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_cart_coupen_update_cart'] = esc_html__('Update Cart', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_cart_coupen_apply_coupen'] = esc_html__('Apply Coupon', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_cart_total_calcu_shp'] = esc_html__('calculated_shipping', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_cart_total_estimated'] = esc_html__('estimated for %s', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_cart_total_cart_total'] = esc_html__('Cart Totals', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_cart_total_subtotal'] = esc_html__('Subtotal', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_cart_total_shipping'] = esc_html__('Shipping', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_cart_total_total'] = esc_html__('Total', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_content_page_pages'] = esc_html__('Pages:', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_content_page_eddit'] = esc_html__('Edit %s', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_default_view_previous_article'] = esc_html__('Previous Article', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_default_view_next_article'] = esc_html__('Next Article ', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_default_view_pages'] = esc_html__('Pages:', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_default_view_written_by'] = esc_html__('Written by ', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_default_view_share'] = esc_html__('Share ', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_global_function_you_may_like'] = esc_html__('You May also Like this', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_header_primary'] = esc_html__('Primary Menu', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_about_info_image'] = esc_html__('About info Image', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_about_search'] = esc_html__('Search', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_meta_sku'] = esc_html__('SKU:', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_image_edit'] = esc_html__('Edit', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_tweets_secongs_ago'] = esc_html__('%d seconds ago', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_content_none_ready_for_post'] = esc_html__('Ready to publish your first post?', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_content_none_get_started_here'] = esc_html__('Get started here', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_content_continue_reding'] = esc_html__('Continue reading', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_content_seems_search_help'] = esc_html__('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_comment_one_thought'] = esc_html_x('One thought on &ldquo;%s&rdquo;', 'comments title', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_quality_input'] = esc_attr_x('Qty', 'Product quantity input tooltip', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_image_published_in'] = _x('<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_plugin_activation_plugin_a_b'] = esc_html_x('and', 'plugin A *and* plugin B', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_full_size_image_footer'] = esc_html_x('Full size', 'Used before full size attachment link.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_heading_element_font_weight'] = esc_html__('Font Weight', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_heading_element_font_weight_hint'] = esc_html__('Select font weight for heading here', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_heading_element_font_weight_select'] = esc_html__('Select font weight', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_blog_info_author_by'] = esc_html__('By ', 'homevillas-real-estate');

            /*
             * newsletter
             */
            $wp_rem_cs_var_static_text['wp_rem_cs_var_edit_newsletter_text'] = esc_html__('NEWSLETTER OPTIONS', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_edit_newsletter_api_key'] = esc_html__('API Key', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_edit_newsletter_api_key_hint'] = esc_html__('Enter the Mail Chimp Api key', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_edit_newsletter_list'] = esc_html__('Mail Chimp List', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_edit_newsletter_element'] = esc_html__('Newsletter', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_edit_newsletter_content'] = esc_html__('Description', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_edit_newsletter_styles'] = esc_html__('Styles', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_edit_newsletter_styles_hint'] = esc_html__('Select newsletter style from this dropdown', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_edit_newsletter_styles_classic'] = esc_html__('Classic', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_edit_newsletter_styles_modern'] = esc_html__('Modern', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_edit_newsletter_folow_us'] = esc_html__('Follow Us', 'homevillas-real-estate');


            /*
             * Call to Action
             */
            $wp_rem_cs_var_static_text['wp_rem_call_to_action_style'] = esc_html__('Style', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_call_to_action_style_default'] = esc_html__('Default', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_call_to_action_style_classic'] = esc_html__('Classic', 'homevillas-real-estate');

            /*
             * Gallery Element
             */

            $wp_rem_cs_var_static_text['wp_rem_cs_var_gallery_edit_options'] = esc_html__('Gallery Options', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_element_gallery_margin_left'] = esc_html__('Margin Left', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_element_gallery_margin_left_hint'] = esc_html__('Use this option if u want to use margin left for this element  (without px).', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_element_gallery_margin_right'] = esc_html__('Margin Right', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_element_gallery_margin_right_hint'] = esc_html__('Use this option if u want to use margin right for this element (without px).', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_gallery_image_url'] = esc_html__('Image URL', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_gallery_image_url_hint'] = esc_html__('Add image url', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_gallery_image_size'] = esc_html__('Image Size', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_gallery_image_size_hint'] = esc_html__('Select image size from this dropdown', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_gallery_image_size_small'] = esc_html__('Small', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_gallery_image_size_large'] = esc_html__('Large', 'homevillas-real-estate');

            /*
             * Blog Boxed
             */

            $wp_rem_cs_var_static_text['wp_rem_cs_var_blog_view_boxed'] = esc_html__('Boxed', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_testimonial_view_default'] = esc_html__('Default', 'homevillas-real-estate');

            /*
             * Faq view
             */
            $wp_rem_cs_var_static_text['wp_rem_cs_var_faq_view'] = esc_html__('Styles', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_faq_view_default'] = esc_html__('Default', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_faq_view_modern'] = esc_html__('Modern', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_testimonial_view_default'] = esc_html__('Default', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_footer_logo'] = esc_html__('Footer Logo', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_footer_logo_hint'] = esc_html__('Upload your custom footer logo in .png .jpg .gif formats only.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_theme_options_element_title_fonts'] = esc_html__('Element Title fonts', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_theme_options_element_title_fonts_attr'] = esc_html__('fonts Attr', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_client_style_classic_v2'] = esc_html__('Classic v2', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_counter_title_color'] = esc_html__('Counter Title Color', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_client_style_classic_v2'] = esc_html__('Classic v2', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_theme_option_footer_style_advance'] = esc_html__('Advance', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_theme_option_footer_menu_switch'] = esc_html__('Footer Menu', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_element_newsletter_show_icons'] = esc_html__('Show Icons', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_element_newsletter_show_icons_yes'] = esc_html__('Yes', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_element_newsletter_show_icons_no'] = esc_html__('No', 'homevillas-real-estate');
            
            
            /*
             * Twitter Api keys
             */
            
            $wp_rem_cs_var_static_text['wp_rem_cs_var_twitter_element_api_consumer_key'] = esc_html__('Consumer Key', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_twitter_element_api_consumer_key_hint'] = esc_html__('Insert Twitter Consumer Key here. When you create your Twitter App, you will get this key.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_twitter_element_api_consumer_secret_key'] = esc_html__('Consumer Secret', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_twitter_element_api_consumer_secret_key_hint'] = esc_html__('Insert Twitter Consumer secret here. When you create your Twitter App, you will get this key.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_twitter_element_api_access_token_key'] = esc_html__('Access Token', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_twitter_element_api_access_token_key_hint'] = esc_html__('Insert Twitter Access Token for permissions. When you create your Twitter App, you will get this Token.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_twitter_element_api_access_token_secret_key'] = esc_html__('Access Token Secret', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_twitter_element_api_access_token_secret_key_hint'] = esc_html__('Insert Twitter Access Token Secret here. When you create your Twitter App, you will get this Token.', 'homevillas-real-estate');
            
            $wp_rem_cs_var_static_text['wp_rem_cs_var_newslwtter_styles_boxed'] = esc_html__('Boxed', 'homevillas-real-estate');
            
            
            return $wp_rem_cs_var_static_text;
        }

    }

    new wp_rem_cs_theme_all_strings_3;
}
