<?php
/**
 * File Type: Opening Hours
 */
if ( ! class_exists( 'Wp_rem_Categories' ) ) {

    class Wp_rem_Categories {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action( 'wp_rem_categories_admin_fields', array( $this, 'wp_rem_categories_admin_fields_callback' ), 11, 1 );
        }

        public function wp_rem_presave_categories( $data, $postarr ) {
            if ( isset( $postarr['post_ID'] ) ) {
                $property_type_categories = get_post_meta( $postarr['post_ID'], 'wp_rem_property_type_categories', true );
                $wp_rem_property_type_categories = $postarr['wp_rem_property_type_categories'];
                $exclude_categories = array_diff( $property_type_categories, $wp_rem_property_type_categories );
                foreach ( $exclude_categories as $category ) {
                    $category_data = get_term_by( 'slug', $category, 'property-category' );
                    wp_delete_term( $category_data->term_id, 'property-category' );
                }
            }
            return $data;
        }

        public function wp_rem_save_post_categories( $post_id ) {
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            }
            $property_type_categories = array();
            if ( get_post_type() == 'property-type' ) {
                $dr_property_type_categories = get_post_meta( $post_id, 'wp_rem_property_type_categories', true );
                foreach ( $_POST as $key => $value ) {
                    if ( $key == 'wp_rem_property_type_categories' ) {
                        foreach ( $value as $c_key => $c_val ) {
                            $parent_id = $_POST['wp_rem_category_parent'][$c_key];
                            $term_slug = sanitize_title_with_dashes( $c_val );
                            $term = term_exists( $term_slug, 'property-category' );
                            if ( isset( $term['term_id'] ) && $term['term_id'] != '' ) {
                                wp_update_term( $term['term_id'], 'category', array(
                                    'name' => $c_val,
                                    'slug' => $term_slug,
                                ) );
                            } else {
                                //if ( '' == $term ) {
                                wp_insert_term(
                                        $c_val, 'property-category', array(
                                    'description' => '',
                                    'slug' => $term_slug,
                                    'parent' => $parent_id
                                        )
                                );
                                $property_type_categories[] = $term_slug;
                                //}
                            }
                        }
                    }
                }
                update_post_meta( $post_id, 'wp_rem_property_type_categories', $property_type_categories );
            }
        }

        public function wp_rem_categories_admin_fields_callback( $post_id ) {

            echo '<ul class="form-elements">
                  <li class="to-button"><a href="javascript:wp_rem_createpop(\'add_category\',\'filter\')" class="button">' . wp_rem_plugin_text_srt( 'wp_rem_add_category' ) . '</a> </li>
               </ul>';

            $this->category_properties( $post_id );

            $this->category_popup();
        }

        /*
         * Category Popup to add new.
         * 
         */

        private function category_popup() {
            global $wp_rem_html_fields;
            $html = '';
            $html .= ' <div id="add_category" style="display: none;">
                  <div class="cs-heading-area">
                    <h5><i class="icon-plus-circle"></i> ' . wp_rem_plugin_text_srt( 'wp_rem_property_categories' ) . '</h5>
                    <span class="cs-btnclose" onClick="javascript:wp_rem_removeoverlay(\'add_category\',\'append\')"> <i class="icon-times"></i></span> 	
                  </div>';


            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt( 'wp_rem_name' ),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'wp_rem_category_name',
                    'cust_name' => 'wp_rem_category_name[]',
                    'return' => true,
                ),
            );

            $html .= $wp_rem_html_fields->wp_rem_text_field( $wp_rem_opt_array );

            $cats_options = ''; 
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt( 'wp_rem_type_parent' ),
                'desc' => '',
                'hint_text' => '',
                'field_params' => array(
                    'std' => '',
                    'cust_name' => 'wp_rem_category_parent[]',
                    'classes' => 'dropdown chosen-select',
                    'options' => $cats_options,
                    'return' => true,
                ),
            );

            $html .= $wp_rem_html_fields->wp_rem_select_field( $wp_rem_opt_array );

            $html .= '<ul class="form-elements noborder">
                  <li class="to-label"></li>
                  <li class="to-field">
                        <input type="button" value="' . wp_rem_plugin_text_srt( 'wp_rem_add_category' ) . '" onclick="add_property_category(\'' . esc_js( admin_url( 'admin-ajax.php' ) ) . '\')" />
                        <div class="category-loader"></div>
                  </li>
                </ul>';

            $html .= '</div>';

            echo force_balance_tags($html);
        }

        private function category_properties( $post_id ) {
            global $post, $wp_rem_form_fields, $wp_rem_html_fields, $wp_rem_plugin_static_text;

            $wp_rem_get_categories = get_post_meta( $post_id, 'wp_rem_property_type_categories', true );

            $html = '
            <script>
                jQuery(document).ready(function($) {
                    $("#total_features").sortable({
                        cancel : \'td div.table-form-elem\'
                    });
                });
            </script>
              <div class="cs-service-list-table">
              <table class="to-table" border="0" cellspacing="0">
                    <thead>
                      <tr>
                        <th style="width:100%;">' . wp_rem_plugin_text_srt( 'wp_rem_name' ) . '</th>
                        <th style="width:20%;" class="right">' . wp_rem_plugin_text_srt( 'wp_rem_actions' ) . '</th>
                      </tr>
                    </thead>
                    <tbody id="total_categories">';
            if ( is_array( $wp_rem_get_categories ) && sizeof( $wp_rem_get_categories ) > 0 ) {

                foreach ( $wp_rem_get_categories as $cat_key => $category_slug ) {
                    if ( isset( $category_slug ) && $category_slug <> '' ) {
                        $category_data = get_term_by( 'slug', $category_slug, 'property-category' );
                        $counter_category = $category_id = $cat_key;
                        $wp_rem_category_name = isset( $category_data->name ) ? $category_data->name : '';
                        $html .= '<tr class="parentdelete"><td>';
                        $html .= $wp_rem_category_name;
                        $html .= '</td>';
                        $html .= '<td class="centr" style="width:20%;"><a href="javascript:wp_rem_createpop(\'edit_category_form' . absint( $counter_category ) . '\',\'filter\')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it delete-category actions delete">&nbsp;</a></td>';
                        $html .= '<input type="hidden" value="' . $category_data->slug . '" name="wp_rem_property_type_categories[]">';
                        $html .= '<input type="hidden" value="' . $category_data->parent . '" name="wp_rem_property_type_categories_parent[]">';
                        $html .= '</tr>';
                        $this->category_update_popup( $category_data, $counter_category );
                    }
                }
            }
            $html .= '
                </tbody>
            </table>

            </div>';

            echo force_balance_tags($html);
        }

        /*
         * Category Popup to Update.
         * 
         */

        private function category_update_popup( $category_data, $counter_category ) {
            global $wp_rem_html_fields;
            $html = '';
            $html .= ' <div id="edit_category_form' . absint( $counter_category ) . '" style="display: none;">
                  <div class="cs-heading-area">
                    <h5><i class="icon-plus-circle"></i> ' . wp_rem_plugin_text_srt( 'wp_rem_property_categories' ) . '</h5>
                    <span class="cs-btnclose" onClick="javascript:wp_rem_removeoverlay(\'edit_category_form' . esc_js( $counter_category ) . '\',\'append\')"> <i class="icon-times"></i></span> 	
                  </div>';


            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt( 'wp_rem_name' ),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => isset( $category_data->name ) ? $category_data->name : '',
                    'cust_name' => 'wp_rem_category_name',
                    'return' => true,
                ),
            );

            $html .= $wp_rem_html_fields->wp_rem_text_field( $wp_rem_opt_array );

            $cat_parent = isset( $category_data->parent ) ? $category_data->parent : '';
            $cats_options = $this->wp_rem_show_all_cats( '', '', $cat_parent, 'property-category', true );
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt( 'wp_rem_type_parent' ),
                'desc' => '',
                'hint_text' => '',
                'field_params' => array(
                    'std' => intval( $cat_parent ),
                    'cust_name' => 'wp_rem_category_parent[]',
                    'classes' => 'dropdown chosen-select',
                    'options' => $cats_options,
                    'return' => true,
                ),
            );

            $html .= $wp_rem_html_fields->wp_rem_select_field( $wp_rem_opt_array );

            $html .= '<ul class="form-elements noborder">
                  <li class="to-label"></li>
                  <li class="to-field">
                        <input type="button" value="' . wp_rem_plugin_text_srt( 'wp_rem_update_category' ) . '" onclick="wp_rem_removeoverlay(\'edit_category_form' . esc_js( $counter_category ) . '\',\'append\')" />
                        <div class="category-loader"></div>
                  </li>
                </ul>';

            $html .= '</div>';

            echo force_balance_tags($html);
        }

        public function add_category_to_list() {

            $category_name = wp_rem_get_input( 'wp_rem_category_name', NULL, 'STRING' );
            $category_slug = $category_name;
            $html .= '<tr><td>';
            $html .= esc_html( $category_name );
            $html .= '</td>';
            $html .= '<td class="centr" style="width:20%;"><a href="javascript:wp_rem_createpop(\'edit_category_form' . absint( $counter_category ) . '\',\'filter\')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>';
            $html .= '<input type="hidden" value="' . esc_html( $category_slug ) . '" name="wp_rem_property_type_categories[]">';
            $html .= '</tr>';
            echo force_balance_tags($html);
        }

        function wp_rem_show_all_cats( $parent, $separator, $selected = "", $taxonomy, $optional = '' ) {
            if ( $parent == "" ) {
                global $wpdb;
                $parent = 0;
            } else
                $separator .= " &ndash; ";
            $args = array(
                //'parent' => $parent,
                'hide_empty' => 0,
                'taxonomy' => $taxonomy
            );
            $categories = get_categories( $args );
            if ( $optional ) {
                $a_options = array();
                $a_options[''] = 'None';
                foreach ( $categories as $category ) {
                    $a_options[$category->term_id] = $category->cat_name;
                }
                return $a_options;
            } else {
                foreach ( $categories as $category ) {
                    ?>
                    <option <?php
                    if ( $selected == $category->term_id ) {
                        echo "selected";
                    }
                    ?> value="<?php echo esc_attr( $category->term_id ); ?>"><?php echo esc_attr( $separator . $category->cat_name ); ?></option>
                        <?php
                    wp_rem_show_all_cats( $category->term_id, $separator, $selected, $taxonomy );
                }
            }
        }

    }

    global $wp_rem_categories;
    $wp_rem_categories = new Wp_rem_Categories();
}