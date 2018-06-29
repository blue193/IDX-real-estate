<?php
/**
 * Html Fields
 */
if ( ! class_exists( 'wp_rem_cs_var_html_fields' ) ) {

    class wp_rem_cs_var_html_fields extends wp_rem_cs_var_form_fields {

        public function __construct() {
            // Do something...
        }

        /**
         * opening field markup
         * 
         */
        public function wp_rem_cs_var_opening_field( $params = '' ) {
            extract( $params );
            $wp_rem_cs_var_output = '';
            $wp_rem_cs_var_styles = '';
            if ( isset( $styles ) && $styles != '' ) {
                $wp_rem_cs_var_styles = ' style="' . wp_rem_cs_allow_special_char($styles) . '"';
            }
            $cust_id = isset( $id ) ? ' id="' . wp_rem_cs_allow_special_char($id) . '"' : '';
            $extra_attr = isset( $extra_att ) ? ' ' . wp_rem_cs_allow_special_char($extra_att) . ' ' : '';
            $name = isset( $name ) ? $name : '';
            $wp_rem_cs_var_output .= '<div' . wp_rem_cs_allow_special_char($cust_id) . wp_rem_cs_allow_special_char($extra_attr) . ' class="form-elements"' . wp_rem_cs_allow_special_char($wp_rem_cs_var_styles) . '>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . esc_attr( $name ) . '</label>';
            if ( isset( $hint_text ) && $hint_text != '' ) {
                $wp_rem_cs_var_output .= wp_rem_cs_var_tooltip_helptext( esc_html( $hint_text ) );
            }
			if ( isset( $label_desc ) && $label_desc != '' ) {
                $wp_rem_cs_var_output .= '<p class="label-desc">' . force_balance_tags( $label_desc ) . '</p>';
            }
            $wp_rem_cs_var_output .= '
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';

            return $wp_rem_cs_var_output;
        }

        /**
         * full opening field markup
         * 
         */
        public function wp_rem_cs_var_full_opening_field( $params = '' ) {
            extract( $params );
            $wp_rem_cs_var_output = '';
            $wp_rem_cs_var_output .= '<div class="form-elements"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';

            return $wp_rem_cs_var_output;
        }

        /**
         * closing field markup
         * 
         */
        public function wp_rem_cs_var_closing_field( $params = '' ) {
            extract( $params );
            $wp_rem_cs_var_output = '';
            if ( isset( $desc ) && $desc != '' ) {
                $wp_rem_cs_var_output .= '<p>' . esc_html( $desc ) . '</p>';
            }
            $wp_rem_cs_var_output .= '</div>';
            if ( isset( $split ) && $split == true ) {
                $wp_rem_cs_var_output .= '<div class="splitter"></div>';
            }
            $wp_rem_cs_var_output .= '</div>';

            return $wp_rem_cs_var_output;
        }

        /**
         * division markup
         * 
         */
        public function wp_rem_cs_var_division( $params = '' ) {
            global $post;
            extract( $params );

            $wp_rem_cs_var_id = 'wp_rem_cs_var_' . wp_rem_cs_allow_special_char($id);

            $d_enable = ' style="display:none;"';
            if ( isset( $enable_val ) ) {

                $d_val = '';
                $d_val = get_post_meta( $post->ID, $enable_id, true );

                $enable_multi = explode( ',', $enable_val );
                if ( is_array( $enable_multi ) && sizeof( $enable_multi ) > 1 ) {
                    $d_enable = in_array( $d_val, $enable_multi ) ? ' style="display:block;"' : ' style="display:none;"';
                } else {
                    $d_enable = $d_val == $enable_val ? ' style="display:block;"' : ' style="display:none;"';
                }
            }

            $wp_rem_cs_var_output = '';
            $wp_rem_cs_var_output .= '<div id="' . wp_rem_cs_allow_special_char($wp_rem_cs_var_id) . '"' . wp_rem_cs_allow_special_char($d_enable) . '>';

            if ( isset( $return ) && $return == true ) {
                return $wp_rem_cs_var_output;
            } else {
                echo wp_rem_cs_allow_special_char( $wp_rem_cs_var_output );
            }
        }

        /**
         * division markup close
         * 
         */
        public function wp_rem_cs_var_division_close( $params = '' ) {

            extract( $params );
            $wp_rem_cs_var_output = '</div>';

            if ( isset( $return ) && $return == true ) {
                return $wp_rem_cs_var_output;
            } else {
                echo wp_rem_cs_allow_special_char( $wp_rem_cs_var_output );
            }
        }

        /**
         * layout style
         * 
         */
        public function wp_rem_cs_form_layout_render( $params = '' ) {
            global $post, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_html_fields, $pagenow;
            extract( $params );

            $wp_rem_cs_value = get_post_meta( $post->ID, 'wp_rem_cs_var_' . $id, true );
            if ( isset( $wp_rem_cs_value ) && $wp_rem_cs_value != '' ) {
                $value = $wp_rem_cs_value;
            } else {
                $value = $std;
            }

            $wp_rem_cs_left_checklist = $wp_rem_cs_right_checklist = $wp_rem_cs_none_checklist = $wp_rem_cs_right = $wp_rem_cs_left = $wp_rem_cs_none = '';
            if ( isset( $wp_rem_cs_value ) ) {
                if ( isset( $value ) && $value == 'left' ) {
                    $wp_rem_cs_left = 'checked';
                    $wp_rem_cs_left_checklist = "class=check-list";
                } else if ( isset( $value ) && $value == 'right' ) {
                    $wp_rem_cs_right = 'checked';
                    $wp_rem_cs_right_checklist = "class=check-list";
                } else if ( isset( $value ) && $value == 'none' ) {
                    $wp_rem_cs_none = 'checked';
                    $wp_rem_cs_none_checklist = "class=check-list";
                }
            }

            $help_text_str = '';
            if ( isset( $help_text ) && $help_text != '' ) {
                $help_text_str = $help_text;
            }

            $wp_rem_cs_styles = '';
            if ( isset( $styles ) && $styles != '' ) {
                $wp_rem_cs_styles = ' style="' . wp_rem_cs_allow_special_char($styles) . '"';
            }
            $cust_id = isset( $id ) ? ' id="' . wp_rem_cs_allow_special_char($id) . '"' : '';
            $extra_attr = isset( $extra_att ) ? ' ' . $extra_att . ' ' : '';

            $wp_rem_cs_output = '
			<div  ' . $cust_id . $extra_attr . ' class="form-elements"' . wp_rem_cs_allow_special_char($wp_rem_cs_styles) . '>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . esc_attr( $name ) . '</label>
				</div>
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $wp_rem_cs_output .= '<div class="input-sec">';
            $wp_rem_cs_output .= '<div class="meta-input pattern">';

            $wp_rem_cs_output .= '<div class=\'radio-image-wrapper\'>';
            $wp_rem_cs_opt_array = array(
                'extra_atr' => '' . $wp_rem_cs_none . ' onclick="show_sidebar_page(\'none\')"',
                'cust_name' => 'wp_rem_cs_var_' . sanitize_html_class( $id ),
                'cust_id' => 'page_radio_1',
                'classes' => 'radio',
                'std' => 'none',
                'return' => true,
            );
            $wp_rem_cs_output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_radio_render( $wp_rem_cs_opt_array );
            $wp_rem_cs_output .= '<label for="page_radio_1">';
            $wp_rem_cs_output .= '<span class="ss">';
            $wp_rem_cs_output .= '<img src="' . get_template_directory_uri() . '/assets/backend/images/no_sidebar.png"  alt="" />';
            $wp_rem_cs_output .= '</span>';
            $wp_rem_cs_output .= '<span ' . wp_rem_cs_allow_special_char($wp_rem_cs_none_checklist) . ' id="check-list"></span>';
            $wp_rem_cs_output .= '</label>';
            $wp_rem_cs_output .= '<span class="title-theme">' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_full_width' ) . '</span></div>';

            $wp_rem_cs_output .= '<div class=\'radio-image-wrapper\'>';
            $wp_rem_cs_opt_array = array(
                'extra_atr' => '' . $wp_rem_cs_right . ' onclick="show_sidebar_page(\'right\')"',
                'cust_name' => 'wp_rem_cs_var_' . sanitize_html_class( $id ),
                'cust_id' => 'page_radio_2',
                'classes' => 'radio',
                'std' => 'right',
                'return' => true,
            );
            $wp_rem_cs_output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_radio_render( $wp_rem_cs_opt_array );
            $wp_rem_cs_output .= '<label for="page_radio_2">';
            $wp_rem_cs_output .= '<span class="ss">';
            $wp_rem_cs_output .= '<img src="' . get_template_directory_uri() . '/assets/backend/images/sidebar_right.png" alt="" />';
            $wp_rem_cs_output .= '</span>';
            $wp_rem_cs_output .= '<span ' . wp_rem_cs_allow_special_char($wp_rem_cs_right_checklist) . ' id="check-list"></span>';
            $wp_rem_cs_output .= '</label>';
            $wp_rem_cs_output .= '<span class="title-theme">' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_sidebar_right' ) . '</span> </div>';

            $wp_rem_cs_output .= '<div class=\'radio-image-wrapper\'>';
            $wp_rem_cs_opt_array = array(
                'cust_id' => 'page_radio_3',
                'classes' => 'radio',
                'std' => 'left',
                'extra_atr' => '' . wp_rem_cs_allow_special_char($wp_rem_cs_left) . ' onclick="show_sidebar_page(\'left\')"',
                'cust_name' => 'wp_rem_cs_var_' . sanitize_html_class( $id ),
                'return' => true,
            );
            $wp_rem_cs_output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_radio_render( $wp_rem_cs_opt_array );
            $wp_rem_cs_output .= '<label for="page_radio_3">';
            $wp_rem_cs_output .= '<span class="ss">';
            $wp_rem_cs_output .= '<img src="' . get_template_directory_uri() . '/assets/backend/images/sidebar_left.png" alt="" />';
            $wp_rem_cs_output .= '</span>';
            $wp_rem_cs_output .= '<span ' . wp_rem_cs_allow_special_char($wp_rem_cs_left_checklist) . ' id="check-list"></span>';
            $wp_rem_cs_output .= '</label>';
            $wp_rem_cs_output .= '<span class="title-theme">' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_sidebar_left' ) . '</span> </div>';

            //
            $cs_extra_layouts = false;
            if ( $pagenow == 'post.php' && get_post_type() == 'page' ) {
                $cs_extra_layouts = true;
            }



            //

            $wp_rem_cs_output .= '</div>';
            $wp_rem_cs_output .= '</div>';
            $wp_rem_cs_output .= '</div>';

            if ( isset( $split ) && $split == true ) {
                $wp_rem_cs_output .= '<div class="splitter"></div>';
            }
            $wp_rem_cs_output .= '
				</div>';

            echo force_balance_tags( $wp_rem_cs_output );
        }

        /**
         * heading markup
         * 
         */
        public function wp_rem_cs_var_heading_render( $params = '' ) {
            global $post;
            extract( $params );
            $wp_rem_cs_var_output = '
			<div class="theme-help" id="' . sanitize_html_class( $id ) . '">
				<h4 style="padding-bottom:0px;">' . esc_attr( $name ) . '</h4>
				<div class="clear"></div>
			</div>';
            echo force_balance_tags( $wp_rem_cs_var_output );
        }

        /**
         * heading markup
         * 
         */
        public function wp_rem_cs_var_set_heading( $params = '' ) {
            extract( $params );
            $wp_rem_cs_var_output = '';
            $wp_rem_cs_var_output .= '<li><a title="' . esc_html( $name ) . '" href="#"><i class="' . sanitize_html_class( $fontawesome ) . '"></i>
				<span class="cs-title-menu">' . esc_html( $name ) . '</span></a>';
            if ( is_array( $options ) && sizeof( $options ) > 0 ) {
                $active = '';
                $wp_rem_cs_var_output .= '<ul class="sub-menu">';
                foreach ( $options as $key => $value ) {
                    $active = ( $key == "tab-general-page-settings" ) ? 'active' : '';
                    $wp_rem_cs_var_output .= '<li class="' . sanitize_html_class( $key ) . ' ' . wp_rem_cs_allow_special_char($active) . '"><a href="#' . wp_rem_cs_allow_special_char($key) . '" onClick="toggleDiv(this.hash);return false;">' . esc_html( $value ) . '</a></li>';
                }
                $wp_rem_cs_var_output .= '</ul>';
            }
            $wp_rem_cs_var_output .= '
			</li>';

            return $wp_rem_cs_var_output;
        }

        /**
         * main heading markup
         * 
         */
        public function wp_rem_cs_var_set_main_heading( $params = '' ) {
            extract( $params );
            $wp_rem_cs_var_output = '';
            $wp_rem_cs_var_output .= '<li><a title="' . wp_rem_cs_allow_special_char($name) . '" href="#' . wp_rem_cs_allow_special_char($id) . '" onClick="toggleDiv(this.hash);return false;"><i class="' . sanitize_html_class( $fontawesome ) . '"></i>
			<span class="cs-title-menu">' . esc_html( $name ) . '</span>
			</a>
			</li>';

            return $wp_rem_cs_var_output;
        }

        /**
         * sub heading markup
         * 
         */
        public function wp_rem_cs_var_set_sub_heading( $params = '' ) {
            extract( $params );
            $wp_rem_cs_var_output = '';
            $style = '';
            if ( $counter > 1 ) {
                $wp_rem_cs_var_output .= '</div>';
            }
            if ( $id != 'tab-general-page-settings' ) {
                $style = 'style="display:none;"';
            }
            $wp_rem_cs_var_output .= '<div  id="' . wp_rem_cs_allow_special_char($id) . '" ' . wp_rem_cs_allow_special_char($style) . '>';
            $wp_rem_cs_var_output .= '<div class="theme-header"><h1>' . esc_html( $name ) . '</h1>
			</div>';

            $wp_rem_cs_var_output .= '<div class="col2-right">';

            return $wp_rem_cs_var_output;
        }

        /**
         * announcement markup
         * 
         */
        public function wp_rem_cs_var_set_announcement( $params = '' ) {
            extract( $params );
            $wp_rem_cs_var_output = '';
            $wp_rem_cs_var_output .= '<div id="' . wp_rem_cs_allow_special_char($id) . '" class="alert alert-info fade in nomargin theme_box"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&#215;</button>
			<h4>' . esc_html( $name ) . '</h4>
			<p>' . esc_html( $std ) . '</p></div>';

            return $wp_rem_cs_var_output;
        }

        /**
         * settings col right markup
         * 
         */
        public function wp_rem_cs_var_set_col_right( $params = '' ) {
            extract( $params );
            $wp_rem_cs_var_output = '';
            $wp_rem_cs_var_output .= '
			</div><!-- end col2-right-->';
            if ( (isset( $col_heading ) && $col_heading != '') || (isset( $help_text ) && $help_text <> '') ) {
                $wp_rem_cs_var_output .= '<div class="col3"><h3>' . esc_html( $col_heading ) . '</h3><p>' . esc_html( $help_text ) . '</p></div>';
            }

            if ( isset( $echo ) && $echo == true ) {
                echo force_balance_tags( $wp_rem_cs_var_output );
            } else {
                return $wp_rem_cs_var_output;
            }
        }

        /**
         * settings section markup
         * 
         */
        public function wp_rem_cs_var_set_section( $params = '' ) {
            extract( $params );
            $wp_rem_cs_var_output = '';
            if ( isset( $accordion ) && $accordion == true ) {
                if ( isset( $active ) && $active == true ) {
                    $active = '';
                } else {
                    $active = ' class="collapsed"';
                }
                $wp_rem_cs_var_output .= '<div class="panel-heading"><a' . wp_rem_cs_allow_special_char($active) . ' href="#accordion-' . esc_attr( $id ) . '" data-parent="#accordion-' . esc_attr( $parrent_id ) . '" data-toggle="collapse"><h4>' . esc_html( $std ) . '</h4>';
            } else {
                $wp_rem_cs_var_output .= '<div class="theme-help"><h4>' . esc_html( $std ) . '</h4><div class="clear"></div></div>';
            }
            if ( isset( $accordion ) && $accordion == true ) {
                $wp_rem_cs_var_output .= '</a></div>';
            }

            if ( isset( $echo ) && $echo == true ) {
                echo force_balance_tags( $wp_rem_cs_var_output );
            } else {
                return $wp_rem_cs_var_output;
            }
        }

        /**
         * text field markup
         * 
         */
        public function wp_rem_cs_var_text_field( $params = '' ) {
            extract( $params );
            $wp_rem_cs_var_output = '';

            $wp_rem_cs_var_styles = '';
            if ( isset( $styles ) && $styles != '' ) {
                $wp_rem_cs_var_styles = ' style="' . wp_rem_cs_allow_special_char($styles) . '"';
            }
            $cust_id = isset( $id ) ? ' id="' . wp_rem_cs_allow_special_char($id) . '"' : '';
            $extra_attr = isset( $extra_att ) ? ' ' . $extra_att . ' ' : '';
            $name = isset( $name ) ? $name : '';
            $field_params = isset( $field_params ) ? $field_params : '';
            $desc = isset( $desc ) ? $desc : '';
            $wp_rem_cs_var_output .= '<div' . wp_rem_cs_allow_special_char($cust_id) . wp_rem_cs_allow_special_char($extra_attr) . ' class="form-elements"' . wp_rem_cs_allow_special_char($wp_rem_cs_var_styles) . '><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<label>' . esc_attr( $name ) . '</label>';
            if ( isset( $hint_text ) && $hint_text != '' ) {
                $wp_rem_cs_var_output .= wp_rem_cs_var_tooltip_helptext( esc_html( $hint_text ) );
            }
			if ( isset( $label_desc ) && $label_desc != '' ) {
                $wp_rem_cs_var_output .= '<p class="label-desc">' . force_balance_tags( $label_desc ) . '</p>';
            }
            $wp_rem_cs_var_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $wp_rem_cs_var_output .= parent::wp_rem_cs_var_form_text_render( $field_params );
            $wp_rem_cs_var_output .= '<p>' . esc_html( $desc ) . '</p></div>';
            if ( isset( $split ) && $split == true ) {
                $wp_rem_cs_var_output .= '<div class="splitter"></div>';
            }
            $wp_rem_cs_var_output .= '</div>';

            if ( isset( $echo ) && $echo == true ) {
                echo force_balance_tags( $wp_rem_cs_var_output );
            } else {
                return $wp_rem_cs_var_output;
            }
        }

        /**
         * date field markup
         * 
         */
        public function wp_rem_cs_var_date_field( $params = '' ) {
            extract( $params );
            $wp_rem_cs_var_output = '';

            $wp_rem_cs_var_styles = '';
            if ( isset( $styles ) && $styles != '' ) {
                $wp_rem_cs_var_styles = ' style="' . wp_rem_cs_allow_special_char($styles) . '"';
            }

            $cust_id = isset( $id ) ? ' id="' . wp_rem_cs_allow_special_char($id) . '"' : '';
            $extra_attr = isset( $extra_att ) ? ' ' . $extra_att . ' ' : '';
            $wp_rem_cs_var_output .= '
			<div' . wp_rem_cs_allow_special_char($cust_id) . wp_rem_cs_allow_special_char($extra_attr) . ' class="form-elements"' . wp_rem_cs_allow_special_char($wp_rem_cs_var_styles) . '>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . esc_attr( $name ) . '</label>';
            if ( isset( $hint_text ) && $hint_text != '' ) {
                $wp_rem_cs_var_output .= wp_rem_cs_var_tooltip_helptext( esc_html( $hint_text ) );
            }
			if ( isset( $label_desc ) && $label_desc != '' ) {
                $wp_rem_cs_var_output .= '<p class="label-desc">' . force_balance_tags( $label_desc ) . '</p>';
            }
            $wp_rem_cs_var_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $wp_rem_cs_var_output .= parent::wp_rem_cs_var_form_date_render( $field_params );
            $wp_rem_cs_var_output .= '<p>' . esc_html( $desc ) . '</p></div>';
            if ( isset( $split ) && $split == true ) {
                $wp_rem_cs_var_output .= '<div class="splitter"></div>';
            }
            $wp_rem_cs_var_output .= '</div>';

            if ( isset( $echo ) && $echo == true ) {
                echo force_balance_tags( $wp_rem_cs_var_output );
            } else {
                return $wp_rem_cs_var_output;
            }
        }

        /**
         * textarea field markup
         * 
         */
        public function wp_rem_cs_var_textarea_field( $params = '' ) {
            extract( $params );
            $wp_rem_cs_var_output = '';
            $wp_rem_cs_var_styles = '';
            if ( isset( $styles ) && $styles != '' ) {
                $wp_rem_cs_var_styles = ' style="' . wp_rem_cs_allow_special_char($styles) . '"';
            }

            $cust_id = isset( $id ) ? ' id="' . wp_rem_cs_allow_special_char($id) . '"' : '';
            $extra_attr = isset( $extra_att ) ? ' ' . wp_rem_cs_allow_special_char($extra_att) . ' ' : '';
            $wp_rem_cs_var_output .= '<div' . wp_rem_cs_allow_special_char($cust_id) . wp_rem_cs_allow_special_char($extra_attr) . ' class="form-elements"' . wp_rem_cs_allow_special_char($wp_rem_cs_var_styles) . '><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><label>' . esc_attr( $name ) . '</label>';
            if ( isset( $hint_text ) && $hint_text != '' ) {
                $wp_rem_cs_var_output .= wp_rem_cs_var_tooltip_helptext( esc_html( $hint_text ) );
            }
			if ( isset( $label_desc ) && $label_desc != '' ) {
                $wp_rem_cs_var_output .= '<p class="label-desc">' . force_balance_tags( $label_desc ) . '</p>';
            }
            $wp_rem_cs_var_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            if ( isset( $field_params['wp_rem_cs_editor'] ) ) {
                if ( $field_params['wp_rem_cs_editor'] == true ) {
                    $editor_class = 'wp_rem_cs_editor' . mt_rand();
                    $field_params['classes'] .= ' ' . $editor_class;
                }
            }
            $wp_rem_cs_var_output .= parent::wp_rem_cs_var_form_textarea_render( $field_params );
            $wp_rem_cs_var_output .= '<p>' . ( $desc ) . '</p>
				</div>';
            if ( isset( $split ) && $split == true ) {
                $wp_rem_cs_var_output .= '<div class="splitter"></div>';
            }
            $wp_rem_cs_var_output .= '</div>';
            if ( isset( $field_params['wp_rem_cs_editor'] ) ) {
                if ( $field_params['wp_rem_cs_editor'] == true ) {
                    $wp_rem_cs_inline_script = 'jQuery(".' . wp_rem_cs_allow_special_char($editor_class) . '").jqte();';
                    $wp_rem_cs_var_output .='<script>' . wp_rem_cs_allow_special_char($wp_rem_cs_inline_script) . '</script>';
                }
            }
            if ( isset( $echo ) && $echo == true ) {
                echo force_balance_tags( $wp_rem_cs_var_output );
            } else {
                return $wp_rem_cs_var_output;
            }
        }

        /**
         * radio field markup
         * 
         */
        public function wp_rem_cs_var_radio_field( $params = '' ) {
            extract( $params );
            $wp_rem_cs_var_output = '';
            $wp_rem_cs_var_output .= '
			<div class="input-sec">';
            $wp_rem_cs_var_output .= parent::wp_rem_cs_var_form_radio_render( $field_params );
            $wp_rem_cs_var_output .= esc_html( $description );
            $wp_rem_cs_var_output .= '
			</div>';

            if ( isset( $echo ) && $echo == true ) {
                echo force_balance_tags( $wp_rem_cs_var_output );
            } else {
                return $wp_rem_cs_var_output;
            }
        }

        /**
         * select field markup
         * 
         */
        public function wp_rem_cs_var_select_field( $params = '' ) {
            extract( $params );
            $wp_rem_cs_var_output = '';
            $wp_rem_cs_var_styles = '';
            $desc = isset( $desc ) ? $desc : '';
            if ( isset( $styles ) && $styles != '' ) {
                $wp_rem_cs_var_styles = ' style="' . wp_rem_cs_allow_special_char($styles) . '"';
            }

            $cust_id = isset( $id ) ? ' id="' . wp_rem_cs_allow_special_char($id) . '"' : '';
            $extra_attr = isset( $extra_att ) ? ' ' . wp_rem_cs_allow_special_char($extra_att) . ' ' : '';
            $wp_rem_cs_var_output .= '<div' . wp_rem_cs_allow_special_char($cust_id) . wp_rem_cs_allow_special_char($extra_attr) . ' class="form-elements"' . wp_rem_cs_allow_special_char($wp_rem_cs_var_styles) . '><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><label>' . esc_attr( $name ) . '</label>';
            if ( isset( $hint_text ) && $hint_text != '' ) {
                $wp_rem_cs_var_output .= wp_rem_cs_var_tooltip_helptext( esc_html( $hint_text ) );
            }
			if ( isset( $label_desc ) && $label_desc != '' ) {
                $wp_rem_cs_var_output .= '<p class="label-desc">' . force_balance_tags( $label_desc ) . '</p>';
            }
            $wp_rem_cs_var_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';

            if ( isset( $array ) && $array == true ) {
                $wp_rem_cs_var_random_id = rand( 123456, 987654 );
                $html_id = ' id="wp_rem_cs_var_' . sanitize_html_class( $id ) . wp_rem_cs_allow_special_char($wp_rem_cs_var_random_id) . '"';
            }
            if ( isset( $multi ) && $multi == true ) {
                $wp_rem_cs_var_output .= parent::wp_rem_cs_var_form_multiselect_render( $field_params );
            } else {
                $wp_rem_cs_var_output .= parent::wp_rem_cs_var_form_select_render( $field_params );
            }
            $wp_rem_cs_var_output .= '<p>' . esc_html( $desc ) . '</p>
				</div>';
            if ( isset( $split ) && $split == true ) {
                $wp_rem_cs_var_output .= '<div class="splitter"></div>';
            }
            $wp_rem_cs_var_output .= '
			</div>';

            if ( isset( $echo ) && $echo == true ) {
                echo force_balance_tags( $wp_rem_cs_var_output );
            } else {
                return $wp_rem_cs_var_output;
            }
        }

        /**
         * checkbox field markup
         * 
         */
        public function wp_rem_cs_var_checkbox_field( $params = '' ) {
            extract( $params );
            $wp_rem_cs_var_output = '';
            $wp_rem_cs_var_styles = '';
            if ( isset( $styles ) && $styles != '' ) {
                $wp_rem_cs_var_styles = ' style="' . wp_rem_cs_allow_special_char($styles) . '"';
            }

            $cust_id = isset( $id ) ? ' id="' . wp_rem_cs_allow_special_char($id) . '"' : '';
            $extra_attr = isset( $extra_att ) ? ' ' . wp_rem_cs_allow_special_char($extra_att) . ' ' : '';
            $wp_rem_cs_var_output .= '
			<div' . wp_rem_cs_allow_special_char($cust_id) . wp_rem_cs_allow_special_char($extra_attr) . ' class="form-elements"' . wp_rem_cs_allow_special_char($wp_rem_cs_var_styles) . '>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . esc_attr( $name ) . '</label>';
            if ( isset( $hint_text ) && $hint_text != '' ) {
                $wp_rem_cs_var_output .= wp_rem_cs_var_tooltip_helptext( esc_html( $hint_text ) );
            }
			if ( isset( $label_desc ) && $label_desc != '' ) {
                $wp_rem_cs_var_output .= '<p class="label-desc">' . force_balance_tags( $label_desc ) . '</p>';
            }
            $wp_rem_cs_var_output .= '
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $wp_rem_cs_var_output .= parent::wp_rem_cs_var_form_checkbox_render( $field_params );
            $wp_rem_cs_var_output .= '<p>' . esc_html( $desc ) . '</p>
				</div>';
            if ( isset( $split ) && $split == true ) {
                $wp_rem_cs_var_output .= '<div class="splitter"></div>';
            }
            $wp_rem_cs_var_output .= '
			</div>';

            if ( isset( $echo ) && $echo == true ) {
                echo force_balance_tags( $wp_rem_cs_var_output );
            } else {
                return $wp_rem_cs_var_output;
            }
        }

        /**
         * upload media field markup
         * 
         */
        public function wp_rem_cs_var_media_url_field( $params = '' ) {
            extract( $params );
            $wp_rem_cs_var_output = '';
            $wp_rem_cs_var_output .= '<div class="form-elements"><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><label>' . esc_attr( $name ) . '</label>';
            if ( isset( $hint_text ) && $hint_text != '' ) {
                $wp_rem_cs_var_output .= wp_rem_cs_var_tooltip_helptext( esc_html( $hint_text ) );
            }
			if ( isset( $label_desc ) && $label_desc != '' ) {
                $wp_rem_cs_var_output .= '<p class="label-desc">' . force_balance_tags( $label_desc ) . '</p>';
            }
            $wp_rem_cs_var_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $wp_rem_cs_var_output .= parent::wp_rem_cs_var_media_url( $field_params );
            $wp_rem_cs_var_output .= '<p>' . esc_html( $desc ) . '</p>
				</div>';
            if ( isset( $split ) && $split == true ) {
                $wp_rem_cs_var_output .= '<div class="splitter"></div>';
            }
            $wp_rem_cs_var_output .= '</div>';

            if ( isset( $echo ) && $echo == true ) {
                echo force_balance_tags( $wp_rem_cs_var_output );
            } else {
                return $wp_rem_cs_var_output;
            }
        }

        /**
         * upload file field markup
         * 
         */
        public function wp_rem_cs_var_upload_file_field( $params = '' ) {
            global $post, $pagenow, $image_val;

            extract( $params );
            $main_wraper_start = '';
            $main_wraper_end = '';
            if ( isset( $main_wraper ) && $main_wraper == true ) {
                $main_wraper_class_str = '';
                if ( isset( $main_wraper_class ) && $main_wraper_class != '' ) {
                    $main_wraper_class_str = $main_wraper_class;
                }
                $main_wraper_extra_str = '';
                if ( isset( $main_wraper_extra ) && $main_wraper_extra != '' ) {
                    $main_wraper_extra_str = $main_wraper_extra;
                }
                $main_wraper_start = '<div class="' . wp_rem_cs_allow_special_char($main_wraper_class_str) . '" ' . wp_rem_cs_allow_special_char($main_wraper_extra_str) . '>';
                $main_wraper_end = '</div>';
            }
            $std = isset( $std ) ? $std : '';
            if ( $pagenow == 'post.php' ) {

                if ( isset( $dp ) && $dp == true ) {
                    $wp_rem_cs_var_value = get_post_meta( $post->ID, $id, true );
                } else {
                    $wp_rem_cs_var_value = get_post_meta( $post->ID, 'wp_rem_cs_var_' . $id, true );
                }
            } elseif ( isset( $user ) && ! empty( $user ) ) {

                if ( isset( $dp ) && $dp == true ) {

                    $wp_rem_cs_var_value = get_the_author_meta( $id, $user->ID );
                } else {
                    $wp_rem_cs_var_value = get_the_author_meta( 'wp_rem_cs_var_' . $id, $user->ID );
                }
            } else {
                $wp_rem_cs_var_value = $std;
            }

            if ( isset( $wp_rem_cs_var_value ) && $wp_rem_cs_var_value != '' ) {
                $value = $wp_rem_cs_var_value;
                if ( isset( $dp ) && $dp == true ) {
                    $value = wp_rem_cs_var_get_img_url( $wp_rem_cs_var_value, 'wp_rem_cs_var_media_5' );
                } else {
                    $value = $wp_rem_cs_var_value;
                }
            } else {
                $value = $std;
            }

            if ( isset( $force_std ) && $force_std == true ) {
                $value = $std;
            }
            if ( isset( $value ) && $value != '' ) {
                $display = 'style=display:block';
            } else {
                $display = 'style=display:none';
            }

            $wp_rem_cs_var_random_id = '';
            $html_id = ' id="wp_rem_cs_var_' . sanitize_html_class( $id ) . '"';
            if ( isset( $array ) && $array == true ) {
                $wp_rem_cs_var_random_id = rand( 123456, 987654 );

                $html_id = ' id="wp_rem_cs_var_' . sanitize_html_class( $id ) . $wp_rem_cs_var_random_id . '"';
            }

            $field_params['wp_rem_cs_var_random_id'] = $wp_rem_cs_var_random_id;

            $wp_rem_cs_var_output = '';
            $wp_rem_cs_var_styles = '';
            if ( isset( $styles ) && $styles != '' ) {
                $wp_rem_cs_var_styles = ' style="' . wp_rem_cs_allow_special_char($styles) . '"';
            }
            $extra_attr = isset( $extra_att ) ? ' ' . wp_rem_cs_allow_special_char($extra_att) . ' ' : '';
            $wp_rem_cs_var_output .= $main_wraper_start;
            $wp_rem_cs_var_output .= '<div' . wp_rem_cs_allow_special_char($extra_attr) . ' class="form-elements"' . wp_rem_cs_allow_special_char($wp_rem_cs_var_styles) . '><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<label>' . esc_attr( $name ) . '</label>';
            if ( isset( $hint_text ) && $hint_text != '' ) {
                $wp_rem_cs_var_output .= wp_rem_cs_var_tooltip_helptext( esc_html( $hint_text ) );
            }
			if ( isset( $label_desc ) && $label_desc != '' ) {
                $wp_rem_cs_var_output .= '<p class="label-desc">' . force_balance_tags( $label_desc ) . '</p>';
            }
            $wp_rem_cs_var_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $wp_rem_cs_var_output .= parent::wp_rem_cs_var_form_fileupload_render( $field_params );
            $wp_rem_cs_var_output .= '<div class="page-wrap" ' . wp_rem_cs_allow_special_char($display) . ' id="wp_rem_cs_var_' . sanitize_html_class( $id ) . wp_rem_cs_allow_special_char($wp_rem_cs_var_random_id) . '_box">';
            $wp_rem_cs_var_output .= '<div class="gal-active">';
            $wp_rem_cs_var_output .= '<div class="dragareamain" style="padding-bottom:0px;">';
            $wp_rem_cs_var_output .= '<ul id="gal-sortable">';
            $wp_rem_cs_var_output .= '<li class="ui-state-default" id="">';
            $wp_rem_cs_var_output .= '<div class="thumb-secs"> <img src="' . esc_url( $value ) . '" id="wp_rem_cs_var_' . sanitize_html_class( $id ) . wp_rem_cs_allow_special_char($wp_rem_cs_var_random_id) . '_img" width="100" alt="" />';
            $wp_rem_cs_var_output .= '<div class="gal-edit-opts"><a href="javascript:del_media(\'wp_rem_cs_var_' . sanitize_html_class( $id ) . wp_rem_cs_allow_special_char($wp_rem_cs_var_random_id) . '\')" class="delete"></a> </div>';
            $wp_rem_cs_var_output .= '</div>';
            $wp_rem_cs_var_output .= '</li>';
            $wp_rem_cs_var_output .= '</ul>';
            $wp_rem_cs_var_output .= '</div>';
            $wp_rem_cs_var_output .= '</div>';
            $wp_rem_cs_var_output .= '</div>';

            $wp_rem_cs_var_output .= '<p>' . esc_html( $desc ) . '</p>
				</div>';
            if ( isset( $split ) && $split == true ) {
                $wp_rem_cs_var_output .= '<div class="splitter"></div>';
            }
            $wp_rem_cs_var_output .= '
			</div>';
            $wp_rem_cs_var_output .= $main_wraper_end;

            if ( isset( $echo ) && $echo == true ) {
                echo force_balance_tags( $wp_rem_cs_var_output );
            } else {
                return $wp_rem_cs_var_output;
            }
        }

        /**
         * select page field markup
         * 
         */
        public function wp_rem_cs_var_select_page_field( $params = '' ) {
            extract( $params );
            $wp_rem_cs_var_output = '';
            $wp_rem_cs_var_output .= '
			<div class="form-elements">
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . esc_attr( $name ) . '</label>';
            if ( isset( $hint_text ) && $hint_text != '' ) {
                $wp_rem_cs_var_output .= wp_rem_cs_var_tooltip_helptext( esc_html( $hint_text ) );
            }
			if ( isset( $label_desc ) && $label_desc != '' ) {
                $wp_rem_cs_var_output .= '<p class="label-desc">' . force_balance_tags( $label_desc ) . '</p>';
            }
            $wp_rem_cs_var_output .= '
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
					<div class="select-style">';
            $wp_rem_cs_var_output .= wp_dropdown_pages( $args );
            $wp_rem_cs_var_output .= '<p>' . esc_html( $desc ) . '</p>
					</div>
				</div>';
            if ( isset( $split ) && $split == true ) {
                $wp_rem_cs_var_output .= '<div class="splitter"></div>';
            }
            $wp_rem_cs_var_output .= '
			</div>';

            if ( isset( $echo ) && $echo == true ) {
                echo force_balance_tags( $wp_rem_cs_var_output );
            } else {
                return $wp_rem_cs_var_output;
            }
        }

        public function wp_rem_cs_var_multi_fields( $params = '' ) {
            extract( $params );
            $wp_rem_cs_var_output = '';

            $wp_rem_cs_var_styles = '';
            if ( isset( $styles ) && $styles != '' ) {
                $wp_rem_cs_var_styles = ' style="' . wp_rem_cs_allow_special_char($styles) . '"';
            }
            $cust_id = isset( $id ) ? ' id="' . wp_rem_cs_allow_special_char($id) . '"' : '';
            $extra_attr = isset( $extra_att ) ? ' ' . wp_rem_cs_allow_special_char($extra_att) . ' ' : '';
            $wp_rem_cs_var_output .= '
			<div' . $cust_id . $extra_attr . ' class="form-elements"' . wp_rem_cs_allow_special_char($wp_rem_cs_var_styles) . '>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . esc_attr( $name ) . '</label>';
            if ( isset( $hint_text ) && $hint_text != '' ) {
                $wp_rem_cs_var_output .= wp_rem_cs_var_tooltip_helptext( esc_html( $hint_text ) );
            }
			if ( isset( $label_desc ) && $label_desc != '' ) {
                $wp_rem_cs_var_output .= '<p class="label-desc">' . force_balance_tags( $label_desc ) . '</p>';
            }
            $wp_rem_cs_var_output .= '
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            if ( isset( $fields_list ) && is_array( $fields_list ) ) {
                foreach ( $fields_list as $field_array ) {
                    if ( $field_array['type'] == 'text' ) {
                        $wp_rem_cs_var_output .= parent::wp_rem_cs_var_form_text_render( $field_array['field_params'] );
                    } elseif ( $field_array['type'] == 'hidden' ) {
                        $wp_rem_cs_var_output .= parent::wp_rem_cs_var_form_hidden_render( $field_array['field_params'] );
                    } elseif ( $field_array['type'] == 'select' ) {
                        $wp_rem_cs_var_output .= parent::wp_rem_cs_var_form_select_render( $field_array['field_params'] );
                    } elseif ( $field_array['type'] == 'multiselect' ) {
                        $wp_rem_cs_var_output .= parent::wp_rem_cs_var_form_multiselect_render( $field_array['field_params'] );
                    } elseif ( $field_array['type'] == 'checkbox' ) {
                        $wp_rem_cs_var_output .= parent::wp_rem_cs_var_form_checkbox_render( $field_array['field_params'] );
                    } elseif ( $field_array['type'] == 'radio' ) {
                        $wp_rem_cs_var_output .= parent::wp_rem_cs_var_form_radio_render( $field_array['field_params'] );
                    } elseif ( $field_array['type'] == 'date' ) {
                        $wp_rem_cs_var_output .= parent::wp_rem_cs_var_form_radio_render( $field_array['field_params'] );
                    } elseif ( $field_array['type'] == 'textarea' ) {
                        $wp_rem_cs_var_output .= parent::wp_rem_cs_var_form_textarea_render( $field_array['field_params'] );
                    } elseif ( $field_array['type'] == 'media' ) {
                        $wp_rem_cs_var_output .= parent::wp_rem_cs_var_media_url( $field_array['field_params'] );
                    } elseif ( $field_array['type'] == 'fileupload' ) {
                        $wp_rem_cs_var_output .= '<div class="page-wrap" ' . wp_rem_cs_allow_special_char($display) . ' id="wp_rem_cs_var_' . sanitize_html_class( $id ) . '_box">';
                        $wp_rem_cs_var_output .= '<div class="gal-active">';
                        $wp_rem_cs_var_output .= '<div class="dragareamain" style="padding-bottom:0px;">';
                        $wp_rem_cs_var_output .= '<ul id="gal-sortable">';
                        $wp_rem_cs_var_output .= '<li class="ui-state-default" id="">';
                        $wp_rem_cs_var_output .= '<div class="thumb-secs"> <img src="' . esc_url( $value ) . '" id="wp_rem_cs_var_' . sanitize_html_class( $id ) . '_img" width="100" alt="" />';
                        $wp_rem_cs_var_output .= '<div class="gal-edit-opts"><a href="javascript:del_media(\'wp_rem_cs_var_' . sanitize_html_class( $id ) . '\')" class="delete"></a> </div>';
                        $wp_rem_cs_var_output .= '</div>';
                        $wp_rem_cs_var_output .= '</li>';
                        $wp_rem_cs_var_output .= '</ul>';
                        $wp_rem_cs_var_output .= '</div>';
                        $wp_rem_cs_var_output .= '</div>';
                        $wp_rem_cs_var_output .= '</div>';
                        $wp_rem_cs_var_output .= parent::wp_rem_cs_var_form_fileupload_render( $field_params );
                    } elseif ( $field_array['type'] == 'dropdown_pages' ) {
                        $wp_rem_cs_var_output .= wp_dropdown_pages( $args );
                    }
                }
            }

            $wp_rem_cs_var_output .= '<p>' . esc_html( $desc ) . '</p>
				</div>';
            if ( isset( $split ) && $split == true ) {
                $wp_rem_cs_var_output .= '<div class="splitter"></div>';
            }
            $wp_rem_cs_var_output .= '
			</div>';

            if ( isset( $echo ) && $echo == true ) {
                echo force_balance_tags( $wp_rem_cs_var_output );
            } else {
                return $wp_rem_cs_var_output;
            }
        }

        public function wp_rem_cs_var_get_attachment_id( $attachment_url ) {
            global $wpdb;
            $attachment_id = false;
            //  If there is no url, return. 
            if ( '' == $attachment_url )
                return;
            // Get the upload wp_rem_cs paths 
            $upload_dir_paths = wp_upload_dir();
            if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
                //  If this is the URL of an auto-generated thumbnail, get the URL of the original image 
                $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
                // Remove the upload path base wp_rem_cs from the attachment URL 
                $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

                $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
            }
            return $attachment_id;
        }

        public function wp_rem_cs_var_get_icon_for_attachment( $post_id ) {

            return wp_get_attachment_image( $post_id, 'thumbnail' );
        }

        public function wp_rem_cs_gallery_render_theme( $params = '' ) {
            extract( $params );
            global $post, $wp_rem_cs_var_plugin_core, $wp_rem_cs_var_plugin_static_text;


            $wp_rem_cs_var_random_id = rand( 156546, 956546 );
            ?>
            <div class="cs-gallery-con">
                <div id="gallery_container_<?php echo esc_attr( $wp_rem_cs_var_random_id ); ?>" data-csid="wp_rem_cs_<?php echo esc_attr( $id ) ?>">
                    <?php
                    $wp_rem_cs_inline_script = '
					jQuery(document).ready(function () {
						jQuery("#gallery_sortable_' . esc_attr( $wp_rem_cs_var_random_id ) . '").sortable({
							out: function (event, ui) {
								wp_rem_cs_var_gallery_sorting_list(\'wp_rem_cs_' . sanitize_html_class( $id ) . '\', \'' . esc_attr( $wp_rem_cs_var_random_id ) . '\');
							}
						});

						gal_num_of_items(\'' . esc_attr( $id ) . '\', \'' . absint( $wp_rem_cs_var_random_id ) . '\', \'\');

						jQuery(\'#gallery_container_' . esc_attr( $wp_rem_cs_var_random_id ) . '\').on(\'click\', \'a.delete\', function () {
							gal_num_of_items(\'' . esc_attr( $id ) . '\', \'' . absint( $wp_rem_cs_var_random_id ) . '\', 1);
							jQuery(this).closest(\'li.image\').remove();
							wp_rem_cs_var_gallery_sorting_list(\'wp_rem_cs_' . sanitize_html_class( $id ) . '\', \'' . esc_attr( $wp_rem_cs_var_random_id ) . '\');
						});
					});';
                    wp_rem_cs_admin_inline_enqueue_script( $wp_rem_cs_inline_script, 'wp_rem_cs-custom-functions' );
                    ?>
                    <ul class="gallery_images" id="gallery_sortable_<?php echo esc_attr( $wp_rem_cs_var_random_id ); ?>">
                        <?php
                        $gallery = get_post_meta( $post->ID, 'wp_rem_cs_' . $id . '_url', true );

                        $wp_rem_cs_var_gal_counter = 0;
                        if ( is_array( $gallery ) && sizeof( $gallery ) > 0 ) {
                            foreach ( $gallery as $attach_url ) {

                                if ( $attach_url != '' ) {

                                    $wp_rem_cs_var_gal_id = rand( 156546, 956546 );

                                    $wp_rem_cs_var_attach_id = $wp_rem_cs_var_plugin_core->wp_rem_cs_var_get_attachment_id( $attach_url );

                                    $wp_rem_cs_var_attach_img = $this->wp_rem_cs_var_get_icon_for_attachment( $wp_rem_cs_var_attach_id );
                                    echo '
                                    <li class="image" data-attachment_id="' . esc_attr( $wp_rem_cs_var_gal_id ) . '">
                                        ' . $wp_rem_cs_var_attach_img . '
                                        <input type="hidden" value="' . esc_url( $attach_url ) . '" name="wp_rem_cs_' . wp_rem_cs_allow_special_char($id) . '_url[]" />
                                        <div class="actions">
                                            <span><a href="javascript:;" class="delete tips" data-tip="' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_delete_image' ) . '"><i class="icon-cross"></i></a></span>
                                        </div>
                                    </li>';
                                }
                                $wp_rem_cs_var_gal_counter ++;
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div id="wp_rem_cs_var_<?php echo esc_attr( $id ) ?>_temp"></div>
                <input type="hidden" value="" name="wp_rem_cs_<?php echo esc_attr( $id ) ?>_num" />
                <div style="width:100%; display:inline-block; margin:20px 0;">
                    <label class="add_gallery hide-if-no-js" data-id="<?php echo 'wp_rem_cs_' . sanitize_html_class( $id ); ?>" data-rand_id="<?php echo esc_attr( $wp_rem_cs_var_random_id ); ?>">
                        <input type="button" class="button button-primary button-large" data-choose="<?php echo esc_attr( $name ); ?>" data-update="<?php echo esc_attr( $name ); ?>" data-delete="<?php echo esc_html( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_delete' ) ); ?>" data-text="<?php echo esc_html( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_delete' ) ); ?>"  value="<?php echo esc_attr( $name ); ?>">
                    </label>
                </div>
            </div>
            <?php
        }

        public function wp_rem_cs_var_gallery_render( $params = '' ) {
            global $post;
            extract( $params );
            $wp_rem_cs_var_random_id = rand( 156546, 956546 );
            ?>
            <div class="form-elements">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label><?php echo esc_html( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_add_gallery' ) ); ?></label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div id="gallery_container_<?php echo esc_attr( $wp_rem_cs_var_random_id ); ?>" data-csid="wp_rem_cs_var_<?php echo esc_attr( $id ) ?>">
                        <?php
                        $wp_rem_cs_inline_script = '
						jQuery(document).ready(function () {
							jQuery("#gallery_sortable_' . esc_attr( $wp_rem_cs_var_random_id ) . '").sortable({
								out: function (event, ui) {
									wp_rem_cs_var_gallery_sorting_list(\'wp_rem_cs_var_' . sanitize_html_class( $id ) . '\', \'' . esc_attr( $wp_rem_cs_var_random_id ) . '\');
								}
							});

							wp_rem_cs_var_num_of_items(\'' . esc_attr( $id ) . '\', \'' . absint( $wp_rem_cs_var_random_id ) . '\');

							jQuery(\'#gallery_container_' . esc_attr( $wp_rem_cs_var_random_id ) . '\').on(\'click\', \'a.delete\', function () {
								var listItems = jQuery(\'#gallery_sortable_' . esc_attr( $wp_rem_cs_var_random_id ) . '\').children();
								var count = listItems.length;
								wp_rem_cs_var_num_of_items(\'' . esc_attr( $id ) . '\', \'' . absint( $wp_rem_cs_var_random_id ) . '\', count);
								jQuery(this).closest(\'li.image\').remove();
								wp_rem_cs_var_gallery_sorting_list(\'wp_rem_cs_var_' . sanitize_html_class( $id ) . '\', \'' . esc_attr( $wp_rem_cs_var_random_id ) . '\');
							});
						});';
                        wp_rem_cs_admin_inline_enqueue_script( $wp_rem_cs_inline_script, 'wp_rem_cs-custom-functions' );
                        ?>
                        <ul class="gallery_images" id="gallery_sortable_<?php echo esc_attr( $wp_rem_cs_var_random_id ); ?>">
                            <?php
                            $gallery = get_post_meta( $post->ID, 'wp_rem_cs_var_' . wp_rem_cs_allow_special_char($id), true );
                            $gallery_titles = get_post_meta( $post->ID, 'wp_rem_cs_var_' . wp_rem_cs_allow_special_char($id) . '_title', true );
                            $gallery_descs = get_post_meta( $post->ID, 'wp_rem_cs_var_' . wp_rem_cs_allow_special_char($id) . '_desc', true );

                            $wp_rem_cs_var_gal_counter = 0;
                            if ( is_array( $gallery ) && sizeof( $gallery ) > 0 ) {
                                foreach ( $gallery as $attach_id ) {

                                    if ( $attach_id != '' ) {

                                        $wp_rem_cs_var_gal_id = rand( 156546, 956546 );

                                        $wp_rem_cs_var_gallery_title = isset( $gallery_titles[$wp_rem_cs_var_gal_counter] ) ? $gallery_titles[$wp_rem_cs_var_gal_counter] : '';
                                        $wp_rem_cs_var_gallery_desc = isset( $gallery_descs[$wp_rem_cs_var_gal_counter] ) ? $gallery_descs[$wp_rem_cs_var_gal_counter] : '';

                                        $wp_rem_cs_var_attach_img = $this->wp_rem_cs_var_get_icon_for_attachment( $attach_id );
                                        echo '
                                            <li class="image" data-attachment_id="' . esc_attr( $wp_rem_cs_var_gal_id ) . '">
                                                    ' . wp_rem_cs_allow_special_char($wp_rem_cs_var_attach_img) . '
                                                    <input type="hidden" value="' . $attach_id . '" name="wp_rem_cs_var_' . wp_rem_cs_allow_special_char($id) . '[]" />
                                                    <div class="actions">
                                                           
                                                            <span><a href="javascript:void(0);" class="delete tips" data-tip="' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_delete_image' ) . '"><i class="icon-cross"></i></a></span>
                                                    </div>
                                                    <tr class="parentdelete" id="edit_track' . absint( $wp_rem_cs_var_gal_id ) . '">
                                                      <td style="width:0">
                                                      <div id="edit_track_form' . absint( $wp_rem_cs_var_gal_id ) . '" style="display: none;" class="table-form-elem">
                                                              <div class="cs-heading-area">
                                                                    <h5 style="text-align: left;">' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_edit_item' ) . '</h5>
                                                                    <span onclick="javascript:wp_rem_cs_var_remove_overlay(\'edit_track_form' . absint( $wp_rem_cs_var_gal_id ) . '\',\'append\')" class="cs-btnclose"> <i class="icon-cross"></i></span>
                                                                    <div class="clear"></div>
                                                              </div>
                                                              <div class="form-elements">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                                      <label>&nbsp;</label>
                                                                    </div>
                                                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                                      ' . wp_rem_cs_allow_special_char($wp_rem_cs_var_attach_img) . '
                                                                    </div>
                                                              </div>
                                                              <div class="form-elements">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                                      <label>' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_title' ) . '</label>
                                                                    </div>
                                                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                                      <input type="text" name="wp_rem_cs_var_' . wp_rem_cs_allow_special_char($id) . '_title[]" value="' . esc_html( $wp_rem_cs_var_gallery_title ) . '" />
                                                                    </div>
                                                              </div>
                                                              <div class="form-elements">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                                      <label>' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_description' ) . '</label>
                                                                    </div>
                                                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                                      <textarea name="wp_rem_cs_var_' . wp_rem_cs_allow_special_char($id) . '_desc[]">' . esc_html( $wp_rem_cs_var_gallery_desc ) . '</textarea>
                                                                    </div>
                                                              </div>
                                                              <ul class="form-elements noborder">
                                                                    <li class="to-label">
                                                                      <label></label>
                                                                    </li>
                                                                    <li class="to-field">
                                                                      <input type="button" value="' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_update' ) . '" onclick="wp_rem_cs_var_remove_overlay(\'edit_track_form' . absint( $wp_rem_cs_var_gal_id ) . '\',\'append\')" />
                                                                    </li>
                                                              </ul>
                                                            </div>
                                                            </td>
                                                    </tr>
                                            </li>';
                                    }
                                    $wp_rem_cs_var_gal_counter ++;
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <div id="wp_rem_cs_var_<?php echo esc_attr( $id ) ?>_temp"></div>
                    <input type="hidden" value="" name="wp_rem_cs_var_<?php echo esc_attr( $id ) ?>_num" />
                    <div style="width:100%; display:inline-block; margin:20px 0;">
                        <label class="browse-icon add_gallery hide-if-no-js" data-id="<?php echo 'wp_rem_cs_var_' . sanitize_html_class( $id ); ?>" data-rand_id="<?php echo esc_attr( $wp_rem_cs_var_random_id ); ?>">
                            <input type="button" class="left" data-choose="<?php echo esc_attr( $name ); ?>" data-update="<?php echo esc_attr( $name ); ?>" data-delete="<?php echo esc_html( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_delete' ) ); ?>" data-text="<?php echo esc_html( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_delete' ) ); ?>"  value="<?php echo esc_attr( $name ); ?>">
                        </label>
                    </div>
                </div>
            </div>
            <?php
        }

    }

    $var_arrays = array( 'wp_rem_cs_var_html_fields' );
    $wp_rem_cs_var_html_fields_global_vars = WP_REM_CS_VAR_GLOBALS()->globalizing( $var_arrays );
    extract( $wp_rem_cs_var_html_fields_global_vars );
    $wp_rem_cs_var_html_fields = new wp_rem_cs_var_html_fields();
}