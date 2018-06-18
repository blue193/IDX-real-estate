<?php
/*
 * Start class for facebook page and profile activities 
 */
if ( ! class_exists( 'wp_rem_cs_facebook_module' ) ) {

    class wp_rem_cs_facebook_module extends WP_Widget {
        /**
         * Outputs the content of the widget
         *
         * @param array $args
         * @param array $instance
         */

        /**
         * @Facebook Module
         *
         *
         */
        public function __construct() {
            global $wp_rem_cs_var_static_text;
            parent::__construct(
                    'wp_rem_cs_facebook_module', // Base ID
                    esc_html( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_facebook' ) ), // Name
                    array( 'classname' => 'facebok_widget', 'description' => esc_html( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_facebook_desc' ) ), ) // Args
            );
        }

        /**
         * @Facebook html Form
         *
         *
         */
        function form( $instance ) {
            $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
            $title = $instance['title'];
            $pageurl = isset( $instance['pageurl'] ) ? esc_attr( $instance['pageurl'] ) : '';
            $showfaces = isset( $instance['showfaces'] ) ? esc_attr( $instance['showfaces'] ) : '';
            $showstream = isset( $instance['showstream'] ) ? esc_attr( $instance['showstream'] ) : '';
            $showheader = isset( $instance['showheader'] ) ? esc_attr( $instance['showheader'] ) : '';
            $likebox_height = isset( $instance['likebox_height'] ) ? esc_attr( $instance['likebox_height'] ) : '';
            $width = isset( $instance['width'] ) ? esc_attr( $instance['width'] ) : '';
            $hide_cover = isset( $instance['hide_cover'] ) ? esc_attr( $instance['hide_cover'] ) : '';
            $show_posts = isset( $instance['show_posts'] ) ? esc_attr( $instance['show_posts'] ) : '';
            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_facebook_title' ) ); ?>
                    <input class="upcoming" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" size='40' name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'pageurl' ) ); ?>"><?php echo esc_html( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_facebook_url' ) ); ?> 
                    <input class="upcoming" id="<?php echo wp_rem_cs_allow_special_char( $this->get_field_id( 'pageurl' ) ); ?>" size='40' name="<?php echo esc_attr( $this->get_field_name( 'pageurl' ) ); ?>" type="text" value="<?php echo esc_attr( $pageurl ); ?>" />
                    <br />
                    <small><?php echo esc_html( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_facebook_profile_url' ) ); ?> http://www.facebook.com/profilename OR <br />
                        https://www.facebook.com/pages/wxyz/123456789101112 </small><br />
                </label>
            </p>
            <p>
                <label for="<?php echo$this->get_field_id( 'width' ); ?>"><?php echo esc_html( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_facebook_width' ) ); ?> 
                    <input class="upcoming" id="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>" size='2' name="<?php echo esc_attr( $this->get_field_name( 'width' ) ); ?>" type="text" value="<?php echo esc_attr( $width ); ?>" />
                </label>
            </p>

            <p>
                <label for="<?php echo$this->get_field_id( 'likebox_height' ); ?>"><?php echo esc_html( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_facebook_lightbox_height' ) ); ?> 
                    <input class="upcoming" id="<?php echo esc_attr( $this->get_field_id( 'likebox_height' ) ); ?>" size='2' name="<?php echo esc_attr( $this->get_field_name( 'likebox_height' ) ); ?>" type="text" value="<?php echo esc_attr( $likebox_height ); ?>" />
                </label>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'hide_cover' ) ); ?>"><?php echo esc_html( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_facebook_hide_cover' ) ); ?> 
                    <input class="upcoming" id="<?php echo esc_attr( $this->get_field_id( 'hide_cover' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_cover' ) ); ?>" type="checkbox" <?php
            if ( esc_attr( $hide_cover ) != '' ) {
                echo 'checked';
            }
            ?> />
                </label>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'showfaces' ) ); ?>"><?php echo esc_html( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_facebook_show_faces' ) ); ?> 
                    <input class="upcoming" id="<?php echo esc_attr( $this->get_field_id( 'showfaces' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'showfaces' ) ); ?>" type="checkbox" <?php
            if ( esc_attr( $showfaces ) != '' ) {
                echo 'checked';
            }
            ?> />
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'show_posts' ) ); ?>"><?php echo esc_html( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_facebook_show_post' ) ); ?> 
                    <input class="upcoming" id="<?php echo esc_attr( $this->get_field_id( 'show_posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_posts' ) ); ?>" type="checkbox" <?php
            if ( esc_attr( $show_posts ) != '' ) {
                echo 'checked';
            }
            ?> />
                </label>
            </p>
            <?php
        }

        /**
         * @Facebook Update Form Data
         *
         *
         */
        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];
            $instance['pageurl'] = $new_instance['pageurl'];
            $instance['showfaces'] = $new_instance['showfaces'];
            $instance['showstream'] = $new_instance['showstream'];
            $instance['showheader'] = $new_instance['showheader'];
            $instance['likebox_height'] = $new_instance['likebox_height'];
            $instance['width'] = $new_instance['width'];
            $instance['hide_cover'] = $new_instance['hide_cover'];
            $instance['show_posts'] = $new_instance['show_posts'];
            return $instance;
        }

        /**
         * @Facebook Widget Display
         *
         *
         */
        function widget( $args, $instance ) {
            extract( $args, EXTR_SKIP );
            $title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
            $title = htmlspecialchars_decode( stripslashes( $title ) );
            $pageurl = empty( $instance['pageurl'] ) ? ' ' : apply_filters( 'widget_title', $instance['pageurl'] );
            $showfaces = empty( $instance['showfaces'] ) ? ' ' : apply_filters( 'widget_title', $instance['showfaces'] );
            $showstream = empty( $instance['showstream'] ) ? ' ' : apply_filters( 'widget_title', $instance['showstream'] );
            $showheader = empty( $instance['showheader'] ) ? ' ' : apply_filters( 'widget_title', $instance['showheader'] );
            $likebox_height = empty( $instance['likebox_height'] ) ? ' ' : apply_filters( 'widget_title', $instance['likebox_height'] );
            $width = empty( $instance['width'] ) ? ' ' : apply_filters( 'widget_title', $instance['width'] );
            $hide_cover = empty( $instance['hide_cover'] ) ? ' ' : apply_filters( 'widget_title', $instance['hide_cover'] );
            $show_posts = empty( $instance['show_posts'] ) ? ' ' : apply_filters( 'widget_title', $instance['show_posts'] );

            if ( isset( $showfaces ) AND $showfaces == 'on' ) {
                $showfaces = 'true';
            } else {
                $showfaces = 'false';
            }
            if ( isset( $showstream ) AND $showstream == 'on' ) {
                $showstream = 'true';
            } else {
                $showstream = 'false';
            }

            if ( isset( $hide_cover ) AND $hide_cover == 'on' ) {
                $hide_cover = 'true';
            } else {
                $hide_cover = 'false';
            }

            echo '<div class="widget widget-facebook">';
            if ( ! empty( $title ) && $title <> ' ' ) {
                echo '<div class="widget-title"><h5>' . esc_html( $title ) . '</h5></div>';
            }
            global $wpdb, $post;
            ?>		

            <div id="fb-root"></div>
            <?php
            $wp_rem_cs_inline_script = '(function (d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id))
					return;
				js = d.createElement(s);
				js.id = id;
				js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.6";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, \'script\', \'facebook-jssdk\'));';
            wp_rem_cs_inline_enqueue_script( $wp_rem_cs_inline_script, 'wp_rem_cs-functions' );

            $output = '';
            $output .= '<div';
            $output .= ' class="fb-page" ';
            if ( isset( $pageurl ) && $pageurl != '' ) {
                $output .= ' data-href="' . esc_url( $pageurl ) . '"';
            }
            if ( isset( $width ) && $width != '' ) {
                $output .= ' data-width="' . $width . '" ';
            }
            if ( isset( $likebox_height ) && $likebox_height != '' ) {
                $output .= ' data-height="' . $likebox_height . '" ';
            }
            if ( isset( $hide_cover ) && $hide_cover != '' ) {
                $output .= ' data-hide-cover="' . $hide_cover . '" ';
            }
            if ( isset( $showfaces ) && $showfaces != '' ) {
                $output .= ' data-show-facepile="' . $showfaces . '" ';
            }
            if ( isset( $show_posts ) && $show_posts == 'on' ) {
                $output .= ' data-tabs="timeline" ';
            }
            $output .= '>';
            $output .= '</div></div>';
            echo wp_rem_cs_allow_special_char( $output );
        }

    }

}
add_action( 'widgets_init', create_function( '', 'return register_widget("wp_rem_cs_facebook_module");' ) );

