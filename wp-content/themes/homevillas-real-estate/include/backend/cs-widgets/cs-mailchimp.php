<?php

/**
 * Wp_rem_cs_Mailchimp Class
 *
 * @package Wp_rem_cs
 */
if ( ! class_exists('Wp_rem_cs_Mailchimp') ) {

    /**
      Wp_rem_cs_Mailchimp class used to implement the custom mailchimp widget.
     */
    class Wp_rem_cs_Mailchimp extends WP_Widget {

        /**
         * Sets up a new wp_rem_cs mailchimp widget instance.
         */
        public function __construct() {
            global $wp_rem_cs_var_static_text;

            parent::__construct(
                    'wp_rem_cs_mailchimp', // Base ID.
                    wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_mailchimp'), // Name.
                    array( 'classname' => ' widget-newsletter', 'description' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_mailchimp_desciption') ) // Args.
            );
        }

        /**
         * Outputs the wp_rem_cs mailchimp widget settings form.
         *
         * @param array $instance current settings.
         */
        function form($instance) {
            global $wp_rem_cs_var_form_fields, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_static_text;
            $strings = new wp_rem_cs_theme_all_strings;
            $strings->wp_rem_cs_short_code_strings();
            $instance = wp_parse_args((array) $instance, array( 'title' => '' ));

            $title = $instance['title'];
            $description = isset($instance['description']) ? esc_attr($instance['description']) : '';
            $content = isset($instance['content']) ? esc_attr($instance['content']) : '';
            $url = isset($instance['url']) ? esc_attr($instance['url']) : '';
            $mail_chimp_api_key = isset($instance['mail_chimp_api_key']) ? esc_html($instance['mail_chimp_api_key']) : '';
            $mail_chimp_list_id = isset($instance['mail_chimp_list_id']) ? esc_html($instance['mail_chimp_list_id']) : '';




            $wp_rem_cs_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_title_field'),
                'desc' => '',
                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_multiple_counter_title_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($title),
                    'cust_id' => '',
                    'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('title')),
                    'return' => true,
                ),
            );
            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

            $wp_rem_cs_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_description'),
                'desc' => '',
                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_description_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($description),
                    'cust_id' => '',
                    'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('description')),
                    'return' => true,
                ),
            );
            $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
            $wp_rem_cs_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_short_text'),
                'desc' => '',
                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_short_text_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($content),
                    'cust_id' => '',
                    'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('content')),
                    'return' => true,
                ),
            );
            $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);

            $wp_rem_cs_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_url_mailchimp_field'),
                'desc' => '',
                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_url_field_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($url),
                    'cust_id' => '',
                    'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('url')),
                    'return' => true,
                ),
            );
            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

            $wp_rem_cs_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_mailchimp_key'),
                'desc' => '',
                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_mailchimp_key_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($mail_chimp_api_key),
                    'cust_id' => '',
                    'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('mail_chimp_api_key')),
                    'return' => true,
                ),
            );
            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

            $mail_chimp_list = array();
            if ( isset($mail_chimp_api_key) && $mail_chimp_api_key != '' ) {
                $mailchimp_option = $mail_chimp_api_key;
                if ( $mailchimp_option <> '' ) {
                    if ( function_exists('wp_rem_cs_mailchimp_list') ) {
                        $mc_list = wp_rem_cs_mailchimp_list($mailchimp_option);
                        if ( is_array($mc_list) && ! empty($mc_list) ) {
                            if ( is_array($mc_list) && isset($mc_list['data']) ) {
                                foreach ( $mc_list['data'] as $list ) {
                                    $mail_chimp_list[$list['id']] = $list['name'];
                                }
                            }
                        }
                    }
                }
            }

            $wp_rem_cs_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_mailchimp_list'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'classes' => 'chosen-select',
                    'std' => $mail_chimp_list_id,
                    'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('mail_chimp_list_id')),
                    'cust_id' => wp_rem_cs_allow_special_char($this->get_field_id('mail_chimp_list_id')),
                    'id' => '',
                    'options' => $mail_chimp_list,
                    'return' => true,
                ),
            );
            $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
        }

        /**
         * Handles updating settings for the current wp_rem_cs mailchimp widget instance.
         *
         * @param array $new_instance New settings for this instance as input by the user.
         * @param array $old_instance Old settings for this instance.
         * @return array Settings to save or bool false to cancel saving.
         */
        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];
            $instance['url'] = $new_instance['url'];
            $instance['description'] = $new_instance['description'];
            $instance['content'] = $new_instance['content'];
            $instance['mail_chimp_api_key'] = $new_instance['mail_chimp_api_key'];
            $instance['mail_chimp_list_id'] = $new_instance['mail_chimp_list_id'];

            return $instance;
        }

        /**
         * Outputs the content for the current wp_rem_cs mailchimp widget instance.
         *
         * @param array $args Display arguments including 'before_title', 'after_title',
         *                        'before_widget', and 'after_widget'.
         * @param array $instance Settings for the current ads widget instance.
         */
        function widget($args, $instance) {
            global $wp_rem_cs_node, $wpdb, $post;

            extract($args, EXTR_SKIP);
            $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
            $description = empty($instance['description']) ? ' ' : apply_filters('widget_title', $instance['description']);
            $content = isset($instance['content']) ? esc_attr($instance['content']) : '';
            $url = isset($instance['url']) ? esc_url($instance['url']) : '';
            $mail_chimp_api_key = isset($instance['mail_chimp_api_key']) ? esc_html($instance['mail_chimp_api_key']) : '';
            $mail_chimp_list_id = isset($instance['mail_chimp_list_id']) ? esc_html($instance['mail_chimp_list_id']) : '';


            echo wp_rem_cs_allow_special_char($args['before_widget']);
            if ( ! empty($title) && ' ' !== $title ) {
                echo wp_rem_cs_allow_special_char($args['before_title'] . $title . $args['after_title']);
            }

            if ( function_exists('wp_rem_cs_custom_mailchimp') ) {
                if ( '' !== $description && ' ' !== $description ) {
                    echo '<p>';
                    echo html_entity_decode($description);
                    echo '</p>';
                }
                $mailchim_widget = 3;
                echo wp_rem_cs_custom_mailchimp($mailchim_widget, $mail_chimp_api_key, $mail_chimp_list_id);
            }
            if ( '' !== $content ) {
                echo '<a href="' . $url . '">' . wp_rem_cs_allow_special_char($content) . '</a>';
            }

            echo wp_rem_cs_allow_special_char($args['after_widget']);
        }

    }

}
add_action('widgets_init', create_function('', 'return register_widget("Wp_rem_cs_Mailchimp");'));
