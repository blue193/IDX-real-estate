<?php

/**
 * Wp_rem_Flickr Class
 *
 * @package Wp Rem */
if ( ! class_exists('Wp_rem_contact') ) {

    /**
      Wp_rem_contact class used to implement the custom contact widget.
     */
    class Wp_rem_contact extends WP_Widget {

        /**
         * Sets up a new rem contact widget instance.
         */
        public function __construct() {
            global $wp_rem_cs_var_static_text;
            wp_rem_cs_var_theme_text_srt('wp_rem_var_contact_description');
            parent::__construct(
                    'wp_rem_contact', // Base ID.
                    wp_rem_cs_var_theme_text_srt('wp_rem_var_contact'), // Name.
                    array( 'classname' => 'widget-ad', 'description' => wp_rem_cs_var_theme_text_srt('wp_rem_var_contact_description'), )
            );
        }

        /**
         * Outputs the rem contact widget settings form.
         *
         * @param array $instance current settings.
         */
        function form($instance) {
            global $wp_rem_cs_var_form_fields, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_static_text;

            $cs_rand_id = rand(23789, 934578930);
            $instance = wp_parse_args((array) $instance, array( 'title' => '', 'contact_code' => '', 'show_icon' => '' ));
            $title = $instance['title'];
            $address_content = isset($instance['address_content']) ? esc_attr($instance['address_content']) : '';
            $contact_code = $instance['contact_code'];
            $phone = isset($instance['phone']) ? esc_attr($instance['phone']) : '';
            $showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';
            $email = isset($instance['email']) ? esc_attr($instance['email']) : '';
            $description = isset($instance['description']) ? esc_attr($instance['description']) : '';
            $contact_logo = isset($instance['contact_logo']) ? esc_attr($instance['contact_logo']) : '';
            $show_icon = isset($instance['show_icon']) ? esc_attr($instance['show_icon']) : '';



            $wp_rem_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_var_title_field'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($title),
                    'classes' => '',
                    'cust_id' => wp_rem_cs_allow_special_char($this->get_field_name('title')),
                    'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('title')),
                    'return' => true,
                    'required' => false,
                ),
            );
            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'std' => $contact_logo,
                'id' => 'contact_logo',
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_var_contact_logo'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'array' => true,
                'field_params' => array(
                    'std' => $contact_logo,
                    'return' => true,
                    'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('contact_logo')),
                    'cust_id' => 'contact_logo',
                    'id' => 'contact_logo',
                    'array' => true,
                    'array_txt' => false,
                ),
            );

            $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_var_contact_desc'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => esc_textarea($description),
                    'classes' => 'txtfield',
                    'cust_id' => wp_rem_cs_allow_special_char($this->get_field_name('description')),
                    'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('description')),
                    'return' => true,
                ),
            );

            $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_var_contact_email'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($email),
                    'classes' => '',
                    'cust_id' => wp_rem_cs_allow_special_char($this->get_field_name('email')),
                    'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('email')),
                    'return' => true,
                    'required' => false,
                ),
            );
            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_var_contact_address'),
                'desc' => '',
                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_var_contact_address_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_textarea($address_content),
                    'classes' => 'txtfield',
                    'cust_id' => wp_rem_cs_allow_special_char($this->get_field_name('address_content')),
                    'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('address_content')),
                    'return' => true,
                ),
            );
            $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_opt_array);
            $wp_rem_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_var_contact_phone'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($phone),
                    'classes' => '',
                    'cust_id' => wp_rem_cs_allow_special_char($this->get_field_name('phone')),
                    'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('phone')),
                    'return' => true,
                    'required' => false,
                ),
            );
            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_opt_array);
            $wp_rem_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_var_widget_contact_info_show_icon'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => $show_icon,
                    'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('show_icon')),
                    'cust_id' => wp_rem_cs_allow_special_char($this->get_field_id('show_icon')),
                    'id' => '',
                    'options' => array(
                        'yes' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_thumbnail_display_show_yes'),
                        'no' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_thumbnail_display_show_no'),
                    ),
                    'return' => true,
                ),
            );
            $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_opt_array);
        }

        /**
         * Handles updating settings for the current rem contact widget instance.
         *
         * @param array $new_instance New settings for this instance as input by the user.
         * @param array $old_instance Old settings for this instance.
         * @return array Settings to save or bool false to cancel saving.
         */
        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];
            $instance['address_content'] = esc_sql($new_instance['address_content']);
            $instance['contact_code'] = $new_instance['contact_code'];
            $instance['phone'] = esc_sql($new_instance['phone']);
            $instance['showcount'] = esc_sql($new_instance['showcount']);
            $instance['email'] = esc_sql($new_instance['email']);
            $instance['description'] = esc_sql($new_instance['description']);
            $instance['contact_logo'] = esc_sql($new_instance['contact_logo']);
            $instance['show_icon'] = esc_sql($new_instance['show_icon']);
            return $instance;
        }

        /**
         * Outputs the content for the current rem contact widget instance.
         *
         * @param array $args Display arguments including 'before_title', 'after_title',
         *                        'before_widget', and 'after_widget'.
         * @param array $instance Settings for the current contact widget instance.
         */
        function widget($args, $instance) {

            extract($args, EXTR_SKIP);
            global $wpdb, $post, $wp_rem_cs_var_options;
            $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
            $title = htmlspecialchars_decode(stripslashes($title));
            $address_content = empty($instance['address_content']) ? '' : $instance['address_content'];
            $contact_code = empty($instance['contact_code']) ? '' : $instance['contact_code'];
            $phone = empty($instance['phone']) ? '' : $instance['phone'];
            $email = empty($instance['email']) ? '' : $instance['email'];
            $description = empty($instance['description']) ? '' : $instance['description'];
            $contact_logo = empty($instance['contact_logo']) ? '' : $instance['contact_logo'];
            $showcount = empty($instance['showcount']) ? '' : $instance['showcount'];
            $show_icon = empty($instance['show_icon']) ? '' : $instance['show_icon'];
            echo '<div class="widget widget-text">';
            if ( '' !== $title ) {
                echo wp_rem_cs_allow_special_char($args['before_title'] . $title . $args['after_title']);
            }
            $showcount = ( '' !== $showcount || ! is_integer($showcount) ) ? $showcount : 2;
            echo '<div class="logowidget"> ';
            if ( filter_var($contact_logo, FILTER_VALIDATE_URL) != FALSE ) {
                echo '<img src="' . esc_url($contact_logo) . '" alt="" />';
            }
            echo '</div>';
            if ( '' !== $description ) {
                echo '<p>' . esc_html($description) . '</p>';
            }
            echo '<ul>';
            if ( '' !== $address_content ) {
                echo '<li>';
                if ( isset($show_icon) && $show_icon == 'yes' ) {
                    echo '<i class="icon-map-marker2"></i>';
                }
                echo esc_html($address_content);
                echo '</li>';
            }
            if ( '' !== $phone ) {
                echo '<li>';
                if ( isset($show_icon) && $show_icon == 'yes' ) {
                    echo '<i class="icon-phone"></i>';
                }
                echo esc_html($phone);
                echo '</li>';
            }
            if ( '' !== $email ) {
                echo '<li>';
                if ( isset($show_icon) && $show_icon == 'yes' ) {
                    echo '<i class="icon-envelope3"></i>';
                }
                echo '<a href="mailto:' . esc_html($email) . '">' . esc_html($email) . '</a>';
                echo '</li>';
            }
            echo '</ul>';

            echo '</div>';
        }

    }

}
add_action('widgets_init', create_function('', 'return register_widget("Wp_rem_contact");'));
