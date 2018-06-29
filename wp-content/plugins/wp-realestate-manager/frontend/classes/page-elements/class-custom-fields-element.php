<?php
/**
 * File Type: Nearby Properties Page Element
 */
if ( ! class_exists('wp_rem_custom_fields_element') ) {

    class wp_rem_custom_fields_element {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action('wp_rem_custom_fields_html', array( $this, 'wp_rem_custom_fields_html_callback' ), 11, 1);
            add_filter('wp_rem_custom_fields', array( $this, 'wp_rem_custom_fields_callback' ), 11, 6);
            add_filter('wp_rem_featured_custom_fields', array( $this, 'wp_rem_featured_custom_fields_callback' ), 11, 4);
        }

        public function wp_rem_custom_fields_callback($property_id = '', $custom_fields = array(), $fields_number = '', $field_label = true, $field_icon = true, $custom_value_position = true) {
            global $post, $wp_rem_post_property_types;
            if ( $property_id == '' ) {
                $property_id = $post->ID;
            }
            $content = '';
            if ( $property_id != '' && (($fields_number != '' && $fields_number > 0) || $fields_number == '') ) {
                $property_type = get_post_meta($property_id, 'wp_rem_property_type', true);
                $wp_rem_property_type_cus_fields = $wp_rem_post_property_types->wp_rem_types_custom_fields_array($property_type);
                if ( is_array($wp_rem_property_type_cus_fields) && isset($wp_rem_property_type_cus_fields) && ! empty($wp_rem_property_type_cus_fields) ) {
                    ob_start();
                    $custom_field_flag = 1;
                    foreach ( $wp_rem_property_type_cus_fields as $cus_fieldvar => $cus_field ) {
                        if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] <> '' ) {
                            $cus_field_value_arr = get_post_meta($property_id, $cus_field['meta_key'], true);
                            $cus_field_label_arr = isset($cus_field['label']) ? $cus_field['label'] : '';
                            $cus_field_icon_arr = isset($cus_field['fontawsome_icon']) ? $cus_field['fontawsome_icon'] : '';
                            $cus_format = isset($cus_field['date_format']) ? $cus_field['date_format'] : '';
                            $type = isset($cus_field['type']) ? $cus_field['type'] : '';

                            if ( $type == 'dropdown' ) {
                                $drop_down_arr = array();
                                $cut_field_flag = 0;
                                foreach ( $cus_field['options']['value'] as $key => $cus_field_options_value ) {

                                    $drop_down_arr[$cus_field_options_value] = force_balance_tags($cus_field['options']['label'][$cut_field_flag]);
                                    $cut_field_flag ++;
                                }
                            }
                            if ( is_array($cus_field_value_arr) ) {
                                $cus_field_value_arr = array_filter($cus_field_value_arr);
                            }
                            if ( isset($cus_field_value_arr) && (is_array($cus_field_value_arr) && ! empty($cus_field_value_arr)) || ( ! is_array($cus_field_value_arr) && $cus_field_value_arr <> '') ) {
                                ?>
                                <li>
                                    <?php if ( isset($cus_field_icon_arr) && $cus_field_icon_arr <> '' && $field_icon == true ) { ?>
                                        <i class="<?php echo esc_html($cus_field_icon_arr) ?>"></i>
                                        <?php
                                    }
                                    if ( is_array($cus_field_value_arr) ) {
                                        foreach ( $cus_field_value_arr as $key => $single_value ) {
                                            if ( $single_value != '' ) {
                                                if ( isset($cus_format) && $cus_format != '' ) {
                                                    echo date($cus_format, $single_value);
                                                } else if ( $type == 'dropdown' && isset($drop_down_arr[$single_value]) && $drop_down_arr[$single_value] != '' ) {
                                                    echo '<span>' . esc_html($drop_down_arr[$single_value]) . '</span>';
                                                } else {
                                                    echo '<span>' . esc_html(ucwords(str_replace("-", " ", $single_value))) . '</span>';
                                                }
                                            }
                                        }
                                        if ( isset($cus_field_label_arr) && $cus_field_label_arr <> '' && $type != 'dropdown' ) {
                                            echo '<span>' . esc_html($cus_field_label_arr) . '</span>';
                                        }
                                    } else {
                                        if ( isset($cus_format) && $cus_format != '' ) {
                                            echo date($cus_format, $cus_field_value_arr);
                                        } else if ( $type == 'dropdown' && isset($drop_down_arr[$cus_field_value_arr]) && $drop_down_arr[$cus_field_value_arr] != '' ) {
                                            echo esc_html($drop_down_arr[$cus_field_value_arr]);
                                        } else {
                                            if ( $custom_value_position ) {
                                                echo esc_html(ucwords(str_replace("-", " ", $cus_field_value_arr)));
                                            }
                                        }
                                        if ( isset($cus_field_label_arr) && $cus_field_label_arr <> '' && $type != 'dropdown' ) {
                                            if ( $custom_value_position ) { 
                                                if ( $field_label == true ) {
                                                    echo '&nbsp;' . esc_html($cus_field_label_arr);
                                                }
                                            }
                                        }

                                        if ( $custom_value_position == false ) { // done only for view medium list property
                                            echo '<span>' . esc_html($cus_field_label_arr) . '</span>';
                                            echo '<small>' . esc_html(ucwords(str_replace("-", " ", $cus_field_value_arr))) . '</small>';
                                        }
                                    }
                                    ?>
                                </li>
                                    <?php
                                    $custom_field_flag ++;
                                    if ( $custom_field_flag > $fields_number && $fields_number != '' ) {
                                        break;
                                    }
                                }
                            }
                        }
                        $content = ob_get_clean();
                    }
                }
                $custom_fields['content'] = $content;
                return $custom_fields;
            }

            public function wp_rem_featured_custom_fields_callback($property_id = '', $custom_fields = array(), $fields_number = '', $field_label = true) {
                global $post, $wp_rem_post_property_types;
                if ( $property_id == '' ) {
                    $property_id = $post->ID;
                }
                $content = '';
                if ( $property_id != '' && (($fields_number != '' && $fields_number > 0) || $fields_number == '') ) {
                    $property_type = get_post_meta($property_id, 'wp_rem_property_type', true);
                    $wp_rem_property_type_cus_fields = $wp_rem_post_property_types->wp_rem_types_custom_fields_array($property_type);
                    if ( is_array($wp_rem_property_type_cus_fields) && isset($wp_rem_property_type_cus_fields) && ! empty($wp_rem_property_type_cus_fields) ) {
                        ob_start();
                        $custom_field_flag = 1;
                        foreach ( $wp_rem_property_type_cus_fields as $cus_fieldvar => $cus_field ) {
                            if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] <> '' ) {
                                $cus_field_value_arr = get_post_meta($property_id, $cus_field['meta_key'], true);
                                $cus_field_label_arr = isset($cus_field['label']) ? $cus_field['label'] : '';
                                $cus_field_icon_arr = isset($cus_field['fontawsome_icon']) ? $cus_field['fontawsome_icon'] : '';
                                $cus_format = isset($cus_field['date_format']) ? $cus_field['date_format'] : '';
                                $type = isset($cus_field['type']) ? $cus_field['type'] : '';

                                if ( $type == 'dropdown' ) {
                                    $drop_down_arr = array();
                                    $cut_field_flag = 0;
                                    foreach ( $cus_field['options']['value'] as $key => $cus_field_options_value ) {
                                        $drop_down_arr[$cus_field_options_value] = force_balance_tags($cus_field['options']['label'][$cut_field_flag]);
                                        $cut_field_flag ++;
                                    }
                                }
                                if ( is_array($cus_field_value_arr) ) {
                                    $cus_field_value_arr = array_filter($cus_field_value_arr);
                                }
                                if ( isset($cus_field_value_arr) && (is_array($cus_field_value_arr) && ! empty($cus_field_value_arr)) || ( ! is_array($cus_field_value_arr) && $cus_field_value_arr <> '') ) {
                                    ?>
                                <li class="has-border">
                                <?php if ( isset($cus_field_icon_arr) && $cus_field_icon_arr <> '' ) { ?>
                                        <i class="<?php echo esc_html($cus_field_icon_arr) ?>"></i>
                                    <?php
                                }
                                if ( is_array($cus_field_value_arr) ) {
                                    if ( isset($cus_field_label_arr) && $cus_field_label_arr <> '' && $type != 'dropdown' ) {
                                        echo '<span>' . esc_html($cus_field_label_arr) . '</span>';
                                    }
                                    foreach ( $cus_field_value_arr as $key => $single_value ) {
                                        if ( $single_value != '' ) {
                                            if ( isset($cus_format) && $cus_format != '' ) {
                                                echo date($cus_format, $single_value);
                                            } else if ( $type == 'dropdown' && isset($drop_down_arr[$single_value]) && $drop_down_arr[$single_value] != '' ) {
                                                echo '<span>' . esc_html($drop_down_arr[$single_value]) . '</span>';
                                            } else {
                                                echo '<span>' . esc_html(ucwords(str_replace("-", " ", $single_value))) . '</span>';
                                            }
                                        }
                                    }
                                } else {
                                    if ( isset($cus_field_label_arr) && $cus_field_label_arr <> '' && $type != 'dropdown' ) {
                                        if ( $field_label == true ) {
                                            echo esc_html($cus_field_label_arr);
                                        }
                                    }
                                    if ( isset($cus_format) && $cus_format != '' ) {
                                        echo '<span>' . date($cus_format, $cus_field_value_arr) . '</span>';
                                    } else if ( $type == 'dropdown' && isset($drop_down_arr[$cus_field_value_arr]) && $drop_down_arr[$cus_field_value_arr] != '' ) {
                                        echo '<span>' . esc_html($drop_down_arr[$cus_field_value_arr]) . '</span>';
                                    } else {
                                        echo '<span>' . esc_html(ucwords(str_replace("-", " ", $cus_field_value_arr))) . '</span>';
                                        ;
                                    }
                                }
                                ?>
                                </li>
                                    <?php
                                    $custom_field_flag ++;
                                    if ( $custom_field_flag > $fields_number && $fields_number != '' ) {
                                        break;
                                    }
                                }
                            }
                        }
                        $content = ob_get_clean();
                    }
                }
                $custom_fields['content'] = $content;
                return $custom_fields;
            }

            public function wp_rem_custom_fields_html_callback($property_id = '') {
                global $post, $wp_rem_post_property_types;
                if ( $property_id == '' ) {
                    $property_id = $post->ID;
                }
                if ( $property_id != '' ) {
                    $property_type = get_post_meta($property_id, 'wp_rem_property_type', true);
                    $wp_rem_property_type_cus_fields = $wp_rem_post_property_types->wp_rem_types_custom_fields_array($property_type);
                    if ( is_array($wp_rem_property_type_cus_fields) && isset($wp_rem_property_type_cus_fields) && ! empty($wp_rem_property_type_cus_fields) ) {
                        ob_start();
                        foreach ( $wp_rem_property_type_cus_fields as $cus_fieldvar => $cus_field ) {
                            if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] <> '' ) {

                                $cus_field_value_arr = get_post_meta($property_id, $cus_field['meta_key'], true);
                                $cus_field_label_arr = isset($cus_field['label']) ? $cus_field['label'] : '';
                                $cus_field_icon_arr = isset($cus_field['fontawsome_icon']) ? $cus_field['fontawsome_icon'] : '';
                                $cus_field_icon_group_arr = isset($cus_field['fontawsome_icon_group']) ? $cus_field['fontawsome_icon_group'] : 'default';
                                
                                $cus_format = isset($cus_field['date_format']) ? $cus_field['date_format'] : '';
                                $type = isset($cus_field['type']) ? $cus_field['type'] : '';

                                if ( $type == 'dropdown' ) {
                                    $drop_down_arr = array();
                                    $cut_field_flag = 0;
                                    foreach ( $cus_field['options']['value'] as $key => $cus_field_options_value ) {
                                        $drop_down_arr[$cus_field_options_value] = force_balance_tags($cus_field['options']['label'][$cut_field_flag]);
                                        $cut_field_flag ++;
                                    }
                                }

                                if ( isset($cus_field_value_arr) && $cus_field_value_arr <> '' ) {
                                    ?>
                                <li>
                                <?php if ( isset($cus_field_icon_arr) && $cus_field_icon_arr <> '' ) {
                                    wp_enqueue_style('cs_icons_data_css_'.$cus_field_icon_group_arr ); ?>
                                    <i class="<?php echo esc_html($cus_field_icon_arr) ?>"></i>
                                <?php
                                }
                                if ( is_array($cus_field_value_arr) ) {
                                    foreach ( $cus_field_value_arr as $key => $single_value ) {
                                        ?>
                                            <span>
                                            <?php
                                            if ( isset($cus_format) && $cus_format != '' ) {
                                                echo date($cus_format, $single_value);
                                            } else if ( $type == 'dropdown' && isset($drop_down_arr[$single_value]) && $drop_down_arr[$single_value] != '' ) {
                                                echo esc_html($drop_down_arr[$single_value]);
                                            } else {
                                                echo esc_html($single_value);
                                            }
                                            ?>
                                            </span>
                                                <?php
                                            }
                                            if ( isset($cus_field_label_arr) && $cus_field_label_arr <> '' && $type != 'dropdown' ) {
                                                echo esc_html($cus_field_label_arr);
                                            }
                                        } else {
                                            ?>
                                        <span>
                                        <?php
                                        if ( isset($cus_format) && $cus_format != '' ) {
                                            echo date($cus_format, $cus_field_value_arr);
                                        } else if ( $type == 'dropdown' && isset($drop_down_arr[$cus_field_value_arr]) && $drop_down_arr[$cus_field_value_arr] != '' ) {
                                            echo esc_html($drop_down_arr[$cus_field_value_arr]);
                                        } else {
                                            echo esc_html($cus_field_value_arr);
                                        }
                                        ?>
                                        </span>
                                            <?php
                                            if ( isset($cus_field_label_arr) && $cus_field_label_arr <> '' && $type != 'dropdown' ) {
                                                echo esc_html($cus_field_label_arr);
                                            }
                                            ?>
                                        <?php
                                    }
                                    ?>
                                </li>

                                    <?php
                                }
                            }
                        }
                        $content = ob_get_clean();
                        if ( $content != '' ) {
                            echo '<ul class="categories-holder">';
                            echo wp_rem_allow_special_char($content);
                            echo '</ul>';
                        }
                    }
                }
            }

        }

        global $wp_rem_custom_fields;
        $wp_rem_custom_fields = new wp_rem_custom_fields_element();
    }