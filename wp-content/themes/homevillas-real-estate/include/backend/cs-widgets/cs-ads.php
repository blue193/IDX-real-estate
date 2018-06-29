<?php

/**
 * Wp_rem_cs_Flickr Class
 *
 * @package Wp_rem_cs
 */
if ( ! class_exists( 'Wp_rem_cs_Ads' ) ) {

    /**
      Wp_rem_cs_Ads class used to implement the custom ads widget.
     */
    class Wp_rem_cs_Ads extends WP_Widget {

        /**
         * Sets up a new wp_rem_cs ads widget instance.
         */
        public function __construct() {
            global $wp_rem_cs_var_static_text;

            parent::__construct(
                    'wp_rem_cs_ads', // Base ID.
                    wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_ads' ), // Name.
                    array( 'classname' => 'widget-ad', 'description' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_ads_description' ) )
            );
        }

        /**
         * Outputs the wp_rem_cs ads widget settings form.
         *
         * @param array $instance current settings.
         */
        function form( $instance ) {
            global $wp_rem_cs_var_form_fields, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_static_text;

            $cs_rand_id = rand( 23789, 934578930 );
            $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'banner_code' => '' ) );
            $title = $instance['title'];
            $banner_style = isset( $instance['banner_style'] ) ? esc_attr( $instance['banner_style'] ) : '';
            $banner_code = $instance['banner_code'];
            $banner_view = isset( $instance['banner_view'] ) ? esc_attr( $instance['banner_view'] ) : '';
            $showcount = isset( $instance['showcount'] ) ? esc_attr( $instance['showcount'] ) : '';
            $has_border = isset( $instance['has_border'] ) ? esc_attr( $instance['has_border'] ) : '';
            $strings = new wp_rem_cs_theme_all_strings;
            $strings->wp_rem_cs_short_code_strings();
            $wp_rem_cs_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_title_field' ),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr( $title ),
                    'classes' => '',
                    'cust_id' => wp_rem_cs_allow_special_char( $this->get_field_name( 'title' ) ),
                    'cust_name' => wp_rem_cs_allow_special_char( $this->get_field_name( 'title' ) ),
                    'return' => true,
                    'required' => false,
                ),
            );
            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_opt_array );

            $wp_rem_cs_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_view' ),
                'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_view_hint' ),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr( $banner_view ),
                    'cust_id' => wp_rem_cs_allow_special_char( $this->get_field_id( 'banner_view' ) ),
                    'cust_name' => wp_rem_cs_allow_special_char( $this->get_field_name( 'banner_view' ) ),
                    'extra_atr' => 'onchange="javascript:banner_widget_toggle(this.value ,  \'' . $cs_rand_id . '\')"',
                    'desc' => '',
                    'classes' => '',
                    'options' => array(
                        'single' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_single_banner' ),
                        'random' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_random_banner' ),
                    ),
                    'return' => true,
                ),
            );

            $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field( $wp_rem_cs_opt_array );
            $display_single = wp_rem_cs_allow_special_char( $banner_view ) == 'random' ? 'block' : 'none';
            echo '<div class="banner_style_field_' . esc_attr( $cs_rand_id ) . '" style="display:' . esc_html( $display_single ) . '">';

            $wp_rem_cs_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_style' ),
                'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_style_hint' ),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr( $banner_style ),
                    'cust_id' => wp_rem_cs_allow_special_char( $this->get_field_id( 'banner_style' ) ),
                    'cust_name' => wp_rem_cs_allow_special_char( $this->get_field_name( 'banner_style' ) ),
                    'desc' => '',
                    'classes' => '',
                    'options' => array(
                        'top_banner' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_type_top' ),
                        'bottom_banner' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_type_bottom' ),
                        'sidebar_banner' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_type_sidebar' ),
                        'vertical_banner' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_type_vertical' ),
                    ),
                    'return' => true,
                ),
            );
            $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field( $wp_rem_cs_opt_array );

            $wp_rem_cs_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_no_of_banner' ),
                'desc' => '',
                'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_no_of_banner_hint' ),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr( $showcount ),
                    'classes' => '',
                    'cust_id' => wp_rem_cs_allow_special_char( $this->get_field_name( 'showcount' ) ),
                    'cust_name' => wp_rem_cs_allow_special_char( $this->get_field_name( 'showcount' ) ),
                    'return' => true,
                    'required' => false,
                ),
            );
            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_opt_array );
            echo '</div>';

            $display_random = wp_rem_cs_allow_special_char( $banner_view ) == 'single' ? 'block' : 'none';
            if ( 'single' !== $banner_view && 'random' !== $banner_view ) {
                $display_random = 'block';
            }
            echo '<div class="banner_code_field_' . esc_attr( $cs_rand_id ) . '" style="display:' . esc_html( $display_random ) . '">';
            $wp_rem_cs_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_code' ),
                'desc' => '',
                'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_code_hint' ),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr( $banner_code ),
                    'classes' => '',
                    'cust_id' => wp_rem_cs_allow_special_char( $this->get_field_name( 'banner_code' ) ),
                    'cust_name' => wp_rem_cs_allow_special_char( $this->get_field_name( 'banner_code' ) ),
                    'return' => true,
                    'required' => false,
                ),
            );
            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_opt_array );
            echo '</div>';

            $wp_rem_cs_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_border' ),
                'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_border_desc' ),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr( $has_border ),
                    'cust_id' => wp_rem_cs_allow_special_char( $this->get_field_id( 'has_border' ) ),
                    'cust_name' => wp_rem_cs_allow_special_char( $this->get_field_name( 'has_border' ) ),
                    'extra_atr' => 'onchange="javascript:banner_widget_toggle(this.value ,  \'' . $cs_rand_id . '\')"',
                    'desc' => '',
                    'classes' => '',
                    'options' => array(
                        'no' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_no' ),
                        'yes' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_yes' ),
                    ),
                    'return' => true,
                ),
            );
            $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field( $wp_rem_cs_opt_array );
        }

        /**
         * Handles updating settings for the current wp_rem_cs ads widget instance.
         *
         * @param array $new_instance New settings for this instance as input by the user.
         * @param array $old_instance Old settings for this instance.
         * @return array Settings to save or bool false to cancel saving.
         */
        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];
            $instance['banner_style'] = esc_sql( $new_instance['banner_style'] );
            $instance['banner_code'] = $new_instance['banner_code'];
            $instance['banner_view'] = esc_sql( $new_instance['banner_view'] );
            $instance['showcount'] = esc_sql( $new_instance['showcount'] );
            $instance['has_border'] = esc_sql( $new_instance['has_border'] );
            return $instance;
        }

        /**
         * Outputs the content for the current wp_rem_cs ads widget instance.
         *
         * @param array $args Display arguments including 'before_title', 'after_title',
         *                        'before_widget', and 'after_widget'.
         * @param array $instance Settings for the current ads widget instance.
         */
        function widget( $args, $instance ) {

            extract( $args, EXTR_SKIP );
            global $wpdb, $post, $wp_rem_cs_var_options;
            $title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );

            $title = htmlspecialchars_decode( stripslashes( $title ) );
            $banner_style = empty( $instance['banner_style'] ) ? ' ' : apply_filters( 'widget_title', $instance['banner_style'] );
            $banner_code = empty( $instance['banner_code'] ) ? ' ' : $instance['banner_code'];
            $banner_view = empty( $instance['banner_view'] ) ? ' ' : apply_filters( 'widget_title', $instance['banner_view'] );
            $showcount = empty( $instance['showcount'] ) ? ' ' : $instance['showcount'];
            $has_border = ( 'yes' === $instance['has_border'] ) ? 'has-border' : '';

            echo '<div class="widget widget-ad ' . esc_attr( $has_border ) . '">';
            if ( '' !== $title ) {
                echo wp_rem_cs_allow_special_char( $args['before_title'] . $title . $args['after_title'] );
            }
            $showcount = ( '' !== $showcount || ! is_integer( $showcount ) ) ? $showcount : 2;

            if ( 'single' === $banner_view ) {
                echo do_shortcode( $banner_code );
            } else {

                $total_banners = ( is_integer( $showcount ) && $showcount > 10) ? 10 : $showcount;

                if ( isset( $wp_rem_cs_var_options['wp_rem_cs_var_banner_title'] ) ) {
                    $i = 0;
                    $d = 0;
                    $banner_array = array();
                    foreach ( $wp_rem_cs_var_options['wp_rem_cs_var_banner_title'] as $banner ) :
                        if ( $banner_style === $wp_rem_cs_var_options['wp_rem_cs_var_banner_style'][$i] ) {
                            $banner_array[] = $i;
                            $d ++;
                        }
                        if ( $total_banners === $d ) {
                            break;
                        }
                        $i ++;
                    endforeach;
                    if ( count( $banner_array ) > 0 ) {
                        $act_size = count( $banner_array ) - 1;
                        $rand_banner = rand( 0, $act_size );

                        $rand_banner = $banner_array[$rand_banner];
                        echo do_shortcode( '[wp_rem_cs_ads id="' . $wp_rem_cs_var_options['wp_rem_cs_var_banner_field_code_no'][$rand_banner] . '"]' );
                    }
                }
            }
            echo '</div>';
        }

    }

}

add_action( 'widgets_init', create_function( '', 'return register_widget("Wp_rem_cs_Ads");' ) );



