<?php
/**
 * File Type: Price Tables Post Type Metas
 */
if ( ! class_exists( 'price_tables_post_type_meta' ) ) {

    class price_tables_post_type_meta {

        /**
         * Start Contructer Function
         */
        public function __construct() {
            add_action( 'add_meta_boxes', array( &$this, 'price_tables_add_meta_boxes_callback' ) );
            add_action( 'save_post', array( $this, 'wp_rem_insert_price_table_metas' ), 19 );
            add_action( 'wp_ajax_wp_rem_pt_iconpicker', array( $this, 'wp_rem_pt_icon' ) );

            add_action( 'admin_menu', array( $this, 'remove_cus_meta_boxes' ) );
            add_action( 'do_meta_boxes', array( $this, 'remove_cus_meta_boxes' ) );
            add_filter( "get_user_option_screen_layout_wp_rem-pt", array( $this, 'property_type_screen_layout' ) );
        }

        public function property_type_screen_layout( $selected ) {
            return 1; // Use 1 column if user hasn't selected anything in Screen Options
        }

        function remove_cus_meta_boxes() {
            remove_meta_box( 'submitdiv', 'wp-rem-pt', 'side' );
        }

        /**
         * Add meta boxes Callback Function
         */
        public function price_tables_add_meta_boxes_callback() {
            add_meta_box( 'wp_rem_meta_price_tables', esc_html( wp_rem_plugin_text_srt( 'wp_rem_property_price_tables_options' ) ), array( $this, 'wp_rem_meta_price_tables' ), 'wp-rem-pt', 'normal', 'high' );
        }

        /**
         * Creating an array for meta fields
         */
        public function wp_rem_meta_price_tables() {
            global $post, $wp_rem_html_fields;

            $rand_numb = rand( 1000000, 9999999 );
            ?>
            <div class="wp-rem-price-table">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <?php
                        $wp_rem_opt_array = array(
                            'name' => wp_rem_plugin_text_srt( 'wp_rem_price_subscribe' ),
                            'desc' => '',
                            'hint_text' => '',
                            'echo' => true,
                            'field_params' => array(
                                'std' => '',
                                'id' => 'subscribe_action',
                                'classes' => 'chosen-select-no-single',
                                'options' => array( 'order-deatail' => wp_rem_plugin_text_srt( 'wp_rem_price_order_detail' ), 'property' => wp_rem_plugin_text_srt( 'wp_rem_price_add_property' ) ),
                                'return' => true,
                            ),
                        );
                        $wp_rem_html_fields->wp_rem_select_field( $wp_rem_opt_array );
                        ?>
                    </div>
                </div>
                <div class="action-btns">
                    <input id="dir-add-column-<?php echo absint( $rand_numb ) ?>" data-id="<?php echo absint( $rand_numb ) ?>" class="dir-add-column" type="button" value="<?php echo wp_rem_plugin_text_srt('wp_rem_price_table_add_package'); ?>">
                    <input id="dir-add-row-<?php echo absint( $rand_numb ) ?>" data-id="<?php echo absint( $rand_numb ) ?>" class="dir-add-row" type="button" value="<?php echo wp_rem_plugin_text_srt('wp_rem_price_table_add_row'); ?>">
                    <input id="dir-add-section-<?php echo absint( $rand_numb ) ?>" data-id="<?php echo absint( $rand_numb ) ?>" class="dir-add-section" type="button" value="<?php echo wp_rem_plugin_text_srt('wp_rem_price_table_add_section'); ?>">
                    <input id="dir-cols-reset-<?php echo absint( $rand_numb ) ?>" data-id="<?php echo absint( $rand_numb ) ?>" class="dir-cols-reset" type="button" value="<?php echo wp_rem_plugin_text_srt('wp_rem_price_table_reset_all'); ?>">
                </div>
                <table id="wp-rem-price-table-<?php echo absint( $rand_numb ) ?>" data-id="<?php echo absint( $rand_numb ) ?>" cellpadding="5" cellspacing="0" border="1">
                    <tbody>
                        <?php
                        $table_html = '';

                        $price_tables_blank = false;

                        $default_field = '';
						$wp_rem_currency_sign = wp_rem_get_currency_sign();

                        $pt_pkg_name = get_post_meta( $post->ID, 'wp_rem_pt_pkg_names', true );
                        $pt_pkg_price = get_post_meta( $post->ID, 'wp_rem_pt_pkg_prices', true );
                        $pt_pkg_color = get_post_meta( $post->ID, 'wp_rem_pt_pkg_color', true );
                        $pt_pkg_desc = get_post_meta( $post->ID, 'wp_rem_pt_pkg_descs', true );
                        $pt_pkg_btn_txt = get_post_meta( $post->ID, 'wp_rem_pt_pkg_btn_txts', true );
                        $pt_pkg_dur = get_post_meta( $post->ID, 'wp_rem_pt_pkg_durs', true );
                        $pt_pkg_feat = get_post_meta( $post->ID, 'wp_rem_pt_pkg_feats', true );
                        $pt_pkg_url = get_post_meta( $post->ID, 'wp_rem_pt_pkg_urls', true );

                        $def_pkg_name_marup = '';
                        $def_pkg_price_marup = '';
                        $def_pkg_color_marup = '';
                        $def_pkg_desc_marup = '';
                        $def_pkg_btn_txt_marup = '';
                        $def_pkg_dur_marup = '';
                        $def_pkg_feat_marup = '';
                        $def_pkg_url_marup = '';

                        if (
                                is_array( $pt_pkg_name ) &&
                                is_array( $pt_pkg_price ) &&
                                is_array( $pt_pkg_color ) &&
                                is_array( $pt_pkg_desc ) > 0 &&
                                is_array( $pt_pkg_url ) > 0
                        ) {

                            $pkgs_counter = 0;
                            foreach ( $pt_pkg_name as $pkg_name ) {

                                //default fields
                                $def_pkg_name = $pkg_name;
                                $def_pkg_price = isset( $pt_pkg_price[$pkgs_counter] ) ? $pt_pkg_price[$pkgs_counter] : '';
                                $def_pkg_color = isset( $pt_pkg_color[$pkgs_counter] ) ? $pt_pkg_color[$pkgs_counter] : '';
                                $def_pkg_desc = isset( $pt_pkg_desc[$pkgs_counter] ) ? $pt_pkg_desc[$pkgs_counter] : '';
                                $def_pkg_btn_txt = isset( $pt_pkg_btn_txt[$pkgs_counter] ) ? $pt_pkg_btn_txt[$pkgs_counter] : '';
                                $def_pkg_dur = isset( $pt_pkg_dur[$pkgs_counter] ) ? $pt_pkg_dur[$pkgs_counter] : '';
                                $def_pkg_feat = isset( $pt_pkg_feat[$pkgs_counter] ) ? $pt_pkg_feat[$pkgs_counter] : '';
                                $def_pkg_url = isset( $pt_pkg_url[$pkgs_counter] ) ? $pt_pkg_url[$pkgs_counter] : '';
                                //
                                //default fields
                                $def_pkg_name_marup .= '<td class="pkg-name"><input type="text" name="pt_pkg_name[]" value="' . $def_pkg_name . '"></td>' . "\n";
                                $def_pkg_price_marup .= '<td class="pkg-price"><input class="price-table-pkg-price" type="text" name="pt_pkg_price[]" value="' . $def_pkg_price . '"></td>' . "\n";
                                $def_pkg_color_marup .= '<td class="pkg-color "><input class="bg_color" type="text"  name="pt_pkg_color[]" value="' . $def_pkg_color . '"></td>' . "\n";
                                $def_pkg_desc_marup .= '<td class="pkg-desc"><input type="text" name="pt_pkg_desc[]" value="' . $def_pkg_desc . '"></td>' . "\n";
                                $def_pkg_btn_txt_marup .= '<td class="pkg-btn-text"><input type="text" name="pt_pkg_btn_txt[]" value="' . $def_pkg_btn_txt . '"></td>' . "\n";
                                $def_pkg_dur_marup .= '<td class="pkg-duration"><input type="text" name="pt_pkg_dur[]" value="' . $def_pkg_dur . '"></td>' . "\n";
                                $def_pkg_feat_marup .= '<td class="pkg-featured"><select name="pt_pkg_feat[]"><option value="no">' . wp_rem_plugin_text_srt( 'wp_rem_property_no' ) . '</option><option' . ($def_pkg_feat == 'yes' ? ' selected="selected"' : '') . ' value="yes">' . wp_rem_plugin_text_srt( 'wp_rem_property_yes' ) . '</option></select></td>' . "\n";
                                $def_pkg_url_marup .= '<td class="pkg-url">' . $this->wp_rem_pkgs( $def_pkg_url ) . '</td>' . "\n";
                                //
                                $pkgs_counter ++;
                            }
                        }

                        // in case of no pricetables
                        if ( $def_pkg_name_marup == '' && $def_pkg_price_marup == '' && $def_pkg_desc_marup == '' ) {
                            $price_tables_blank = true;
                            for ( $pri = 0; $pri < 3; $pri ++ ) {
                                $def_pkg_name_marup .= '<td class="pkg-name"><input type="text" name="pt_pkg_name[]" value="Package ' . (1 + $pri) . '"></td>' . "\n";
                                $def_pkg_price_marup .= '<td class="pkg-price"><input class="price-table-pkg-price" type="text" name="pt_pkg_price[]" value="20"></td>' . "\n";
                                $def_pkg_color_marup .= '<td class="pkg-color"><input type="text" class="bg_color" name="pt_pkg_color[]" value="#fff"></td>' . "\n";
                                $def_pkg_desc_marup .= '<td class="pkg-desc"><input type="text" name="pt_pkg_desc[]" value=""></td>' . "\n";
                                $def_pkg_btn_txt_marup .= '<td class="pkg-btn-text"><input type="text" name="pt_pkg_btn_txt[]" value="' . wp_rem_plugin_text_srt( 'wp_rem_price_table_buy_now' ) . '"></td>' . "\n";
                                $def_pkg_dur_marup .= '<td class="pkg-duration"><input type="text" name="pt_pkg_dur[]" value="' . (7 + $pri) . '"></td>' . "\n";
                                $def_pkg_feat_marup .= '<td class="pkg-featured"><select name="pt_pkg_feat[]"><option value="no">' . wp_rem_plugin_text_srt( 'wp_rem_property_no' ) . '</option><option value="yes">' . wp_rem_plugin_text_srt( 'wp_rem_property_yes' ) . '</option></select></td>' . "\n";
                                $def_pkg_url_marup .= '<td class="pkg-url">' . $this->wp_rem_pkgs( '' ) . '</td>' . "\n";
                            }
                        }

                        $default_field = '
						<tr class="default-fields">
							<td class="pkg-name">' . wp_rem_plugin_text_srt( 'wp_rem_price_name' ) . '</td>
							' . $def_pkg_name_marup . '
						</tr>
						<tr class="default-fields">
							<td class="pkg-price">' . wp_rem_plugin_text_srt( 'wp_rem_price_price' ) . ' ('. $wp_rem_currency_sign .')</td>
							' . $def_pkg_price_marup . '
						</tr>
                                                                                                            <tr class="default-fields">
							<td class="pkg-color">' . wp_rem_plugin_text_srt( 'wp_rem_price_color' ) . '</td>
							' . $def_pkg_color_marup . '
						</tr>
						<tr class="default-fields">
							<td class="pkg-desc">' . wp_rem_plugin_text_srt( 'wp_rem_price_description' ) . '</td>
							' . $def_pkg_desc_marup . '
						</tr>
						<tr class="default-fields">
							<td class="pkg-btn-text">' . wp_rem_plugin_text_srt( 'wp_rem_price_button_text' ) . '</td>
							' . $def_pkg_btn_txt_marup . '
						</tr>
						<tr class="default-fields">
							<td class="pkg-duration">' . wp_rem_plugin_text_srt( 'wp_rem_price_duration' ) . '</td>
							' . $def_pkg_dur_marup . '
						</tr>
						<tr class="default-fields">
							<td class="pkg-featured">' . wp_rem_plugin_text_srt( 'wp_rem_price_featured' ) . '</td>
							' . $def_pkg_feat_marup . '
						</tr>
						<tr class="default-fields">
							<td class="pkg-url">' . wp_rem_plugin_text_srt( 'wp_rem_price_package' ) . '</td>
							' . $def_pkg_url_marup . '
						</tr>';

                        if ( is_array( $pt_pkg_name ) && sizeof( $pt_pkg_name ) > 0 ) {
                            $col_actions_html = '<td>&nbsp;</td>';
                            for ( $col_coun = 1; $col_coun <= sizeof( $pt_pkg_name ); $col_coun ++ ) {
                                $col_actions_html .= '<td class="pt_col_actions"><a class="pt_delete_col">x</a></td>';
                            }
                            $table_html .= '<tr class="actions_row">' . $col_actions_html . '</tr>';
                        } else {
                            $col_actions_html = '<td>&nbsp;</td>';
                            // in case of no pricetables
                            for ( $col_coun = 0; $col_coun < 3; $col_coun ++ ) {
                                $col_actions_html .= '<td class="pt_col_actions"><a class="pt_delete_col">x</a></td>';
                            }
                            $table_html .= '<tr class="actions_row">' . $col_actions_html . '</tr>';
                        }

                        $table_html .= $default_field;

                        $row_num_input = get_post_meta( $post->ID, 'wp_rem_pt_row_num', true );
                        $pt_col_input = get_post_meta( $post->ID, 'wp_rem_pt_col_vals', true );
                        $pt_col_sub_input = get_post_meta( $post->ID, 'wp_rem_pt_col_subs', true );
                        $pt_row_title = get_post_meta( $post->ID, 'wp_rem_pt_row_title', true );
                        $pt_sec_val = get_post_meta( $post->ID, 'wp_rem_pt_sec_vals', true );
                        $pt_sec_pos = get_post_meta( $post->ID, 'wp_rem_pt_sec_pos', true );
                        if (
                                $row_num_input &&
                                is_array( $pt_col_input ) &&
                                (int) $row_num_input > 0 &&
                                sizeof( $pt_col_input ) > 0
                        ) {
                            $row_nums = (int) $row_num_input;
                            $col_nums = sizeof( $pt_col_input );
                            $row_break = 0;
                            if ( $col_nums >= $row_nums ) {
                                $row_break = $col_nums / $row_nums;
                            }

                            $rows_array = array();
                            if ( $row_break > 0 ) {
                                $row_num_field = '<input type="hidden" class="row_num_input" name="dir_pt_row_num[]">';
                                $row_markup = '';
                                $col_markup = '';
                                $pt_counter = 1;
                                $pt_index_counter = 0;
                                $pt_row_counter = 0;
                                foreach ( $pt_col_input as $col_val ) {

                                    $rand_numb = rand( 10000000, 99999999 );
                                    $pt_sub_input_val = isset( $pt_col_sub_input[$pt_index_counter] ) ? $pt_col_sub_input[$pt_index_counter] : '';
                                    $col_markup .= '<td><input type="text" name="dir_pt_col_val[]" size="10" value="' . $col_val . '"> <br> ' . $this->wp_rem_pt_icon( $pt_sub_input_val, $rand_numb, 'dir_pt_col_sub' ) . (1 == $pt_counter ? $row_num_field : '') . '</td>' . "\n";
                                    $pt_row_del = '';
                                    if ( $row_break == $pt_counter ) {
                                        $pt_row_title_txt = isset( $pt_row_title[$pt_row_counter] ) ? $pt_row_title[$pt_row_counter] : '';
                                        $pt_row_counter ++;

                                        $pt_row_del = '<td class="pt_row_actions"><a class="pt_delete_row">x</a><br><input type="text" name="dir_pt_row_title[]" value="' . $pt_row_title_txt . '"></td>';
                                        $row_markup .= '<tr class="pt_row">' . $pt_row_del . $col_markup . '</tr>' . "\n";
                                        $rows_array[] = $row_markup;
                                        $col_markup = '';
                                        $row_markup = '';
                                        $pt_counter = 0;
                                    }
                                    $pt_counter ++;
                                    $pt_index_counter ++;
                                }
                            }

                            $sections_array = array();
                            if (
                                    is_array( $pt_sec_val ) &&
                                    is_array( $pt_sec_pos ) &&
                                    sizeof( $pt_sec_val ) > 0 &&
                                    sizeof( $pt_sec_pos ) > 0
                            ) {
                                $sections_array = $this->combine_pt_section( $pt_sec_pos, $pt_sec_val );
                            }

                            $pt_sec_del = '<td class="pt_row_actions"><a class="pt_delete_row">x</a></td>';
                            if ( sizeof( $sections_array ) > 0 && isset( $sections_array[0] ) ) {
                                if ( is_array( $sections_array[0] ) ) {
                                    foreach ( $sections_array[0] as $sec_0 ) {
                                        $table_html .= '
										<tr class="pt_section">
											' . $pt_sec_del . '
											<td colspan="' . $row_break . '">
												<input type="text" name="dir_pt_sec_val[]" value="' . $sec_0 . '">
												<input type="hidden" name="dir_pt_sec_pos[]" value="0">
											</td>
										</tr>';
                                    }
                                } else {
                                    $table_html .= '
									<tr class="pt_section">
										' . $pt_sec_del . '
										<td colspan="' . $row_break . '">
											<input type="text" name="dir_pt_sec_val[]" value="' . $sections_array[0] . '">
											<input type="hidden" name="dir_pt_sec_pos[]" value="0">
										</td>
									</tr>';
                                }
                            }
                            if ( isset($rows_array) && sizeof( $rows_array ) > 0 ) {
                                $row_counter = 1;
                                foreach ( $rows_array as $row_arr ) {
                                    $table_html .= $row_arr;
                                    if ( sizeof( $sections_array ) > 0 && array_key_exists( $row_counter, $sections_array ) ) {
                                        if ( is_array( $sections_array[$row_counter] ) ) {
                                            foreach ( $sections_array[$row_counter] as $sec_0 ) {
                                                $table_html .= '
												<tr class="pt_section">
													' . $pt_sec_del . '
													<td colspan="' . $row_break . '">
														<input type="text" name="dir_pt_sec_val[]" value="' . $sec_0 . '">
														<input type="hidden" name="dir_pt_sec_pos[]" value="' . $row_counter . '">
													</td>
												</tr>';
                                            }
                                        } else {
                                            $table_html .= '
											<tr class="pt_section">
												' . $pt_sec_del . '
												<td colspan="' . $row_break . '">
													<input type="text" name="dir_pt_sec_val[]" value="' . $sections_array[$row_counter] . '">
													<input type="hidden" name="dir_pt_sec_pos[]" value="' . $row_counter . '">
												</td>
											</tr>';
                                        }
                                    }
                                    $row_counter ++;
                                }
                            }
                        } else {
                            // in case of no pricetables
                            if ( $price_tables_blank ) {
                                $rows_array = array();
                                $row_break = 3;
                                $row_num_field = '<input type="hidden" class="row_num_input" name="dir_pt_row_num[]">';
                                $row_markup = '';
                                $col_markup = '';
                                $pt_counter = 1;
                                $pt_index_counter = 0;
                                $pt_row_counter = 0;
                                for ( $pri = 0; $pri < 6; $pri ++ ) {
                                    $rand_numb = rand( 10000000, 99999999 );
                                    $col_markup .= '<td><input type="text" name="dir_pt_col_val[]" size="10" value="Title"> <br> ' . $this->wp_rem_pt_icon( '', $rand_numb, 'dir_pt_col_sub' ) . (1 == $pt_counter ? $row_num_field : '') . '</td>' . "\n";
                                    $pt_row_del = '';
                                    if ( $row_break == $pt_counter ) {
                                        $pt_row_title_txt = 'Row Title';
                                        $pt_row_counter ++;

                                        $pt_row_del = '<td class="pt_row_actions"><a class="pt_delete_row">x</a><br><input type="text" name="dir_pt_row_title[]" value="' . $pt_row_title_txt . '"></td>';
                                        $row_markup .= '<tr class="pt_row">' . $pt_row_del . $col_markup . '</tr>' . "\n";
                                        $rows_array[] = $row_markup;
                                        $col_markup = '';
                                        $row_markup = '';
                                        $pt_counter = 0;
                                    }
                                    $pt_counter ++;
                                    $pt_index_counter ++;
                                }
                            }
                            if ( isset($rows_array) && sizeof( $rows_array ) > 0 ) {
                                foreach ( $rows_array as $row_arr ) {
                                    $table_html .= $row_arr;
                                }
                            }
                        }
                        echo force_balance_tags( $table_html );
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
            $this->submit_meta_box( 'wp-rem-pt', $args = array() );
        }

        function combine_pt_section( $keys, $values ) {
            $result = array();
            foreach ( $keys as $i => $k ) {
                $result[$k][] = $values[$i];
            }
            array_walk( $result, create_function( '&$v', '$v = (count($v) == 1)? array_pop($v): $v;' ) );
            return $result;
        }

        public function wp_rem_pkgs( $value = '' ) {
            $pkgs_options = '';
            $args = array( 'posts_per_page' => '-1', 'post_type' => 'packages', 'post_status' => 'publish', 'orderby' => 'title', 'order' => 'ASC' );
            $cust_query = get_posts( $args );
            $pkgs_options .= '<option value="">' . wp_rem_plugin_text_srt( 'wp_rem_price_select_package' ) . '</option>';
            if ( is_array( $cust_query ) && sizeof( $cust_query ) > 0 ) {
                $pkg_counter = 1;
                foreach ( $cust_query as $pkg_post ) {
                    $option_selected = '';
                    if ( $value != '' && $value == $pkg_post->ID ) {
                        $option_selected = ' selected="selected"';
                    }
                    $pkgs_options .= '<option' . $option_selected . ' value="' . $pkg_post->ID . '">' . get_the_title( $pkg_post->ID ) . '</option>' . "\n";
                    $pkg_counter ++;
                }
            }

            $select_field = '<select name="pt_pkg_url[]">' . $pkgs_options . '</select>';

            return $select_field;
        }

        public function wp_rem_insert_price_table_metas( $post_id ) {

            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            }

            $row_num_input = wp_rem_get_input( 'dir_pt_row_num', '', 'ARRAY' );
            $pt_col_input = wp_rem_get_input( 'dir_pt_col_val', '', 'ARRAY' );
            $pt_col_sub_input = wp_rem_get_input( 'dir_pt_col_sub', '', 'ARRAY' );
            $pt_row_title = wp_rem_get_input( 'dir_pt_row_title', '', 'ARRAY' );
            $pt_sec_val = wp_rem_get_input( 'dir_pt_sec_val', '', 'ARRAY' );
            $pt_sec_pos = wp_rem_get_input( 'dir_pt_sec_pos', '', 'ARRAY' );

            $pt_pkg_name = wp_rem_get_input( 'pt_pkg_name', '', 'ARRAY' );
            $pt_pkg_price = wp_rem_get_input( 'pt_pkg_price', '', 'ARRAY' );
            $pt_pkg_color = wp_rem_get_input( 'pt_pkg_color', '', 'ARRAY' );
            $pt_pkg_desc = wp_rem_get_input( 'pt_pkg_desc', '', 'ARRAY' );
            $pt_pkg_btn_txt = wp_rem_get_input( 'pt_pkg_btn_txt', '', 'ARRAY' );
            $pt_pkg_dur = wp_rem_get_input( 'pt_pkg_dur', '', 'ARRAY' );
            $pt_pkg_feat = wp_rem_get_input( 'pt_pkg_feat', '', 'ARRAY' );
            $pt_pkg_url = wp_rem_get_input( 'pt_pkg_url', '', 'ARRAY' );

            // saving package names		
            update_post_meta( $post_id, 'wp_rem_pt_pkg_names', $pt_pkg_name );

            // saving package prices		
            update_post_meta( $post_id, 'wp_rem_pt_pkg_prices', $pt_pkg_price );
            update_post_meta( $post_id, 'wp_rem_pt_pkg_color', $pt_pkg_color );

            // saving package descs		
            update_post_meta( $post_id, 'wp_rem_pt_pkg_descs', $pt_pkg_desc );

            // saving package btn texts		
            update_post_meta( $post_id, 'wp_rem_pt_pkg_btn_txts', $pt_pkg_btn_txt );

            // saving package durs		
            update_post_meta( $post_id, 'wp_rem_pt_pkg_durs', $pt_pkg_dur );

            // saving package feats		
            update_post_meta( $post_id, 'wp_rem_pt_pkg_feats', $pt_pkg_feat );

            // saving package urls		
            update_post_meta( $post_id, 'wp_rem_pt_pkg_urls', $pt_pkg_url );

            // saving num of rows			
            update_post_meta( $post_id, 'wp_rem_pt_row_num', absint( sizeof( $row_num_input ) ) );

            // saving all cols values			
            update_post_meta( $post_id, 'wp_rem_pt_col_vals', $pt_col_input );

            // saving all cols sub values			
            update_post_meta( $post_id, 'wp_rem_pt_col_subs', $pt_col_sub_input );

            // saving row titles values			
            update_post_meta( $post_id, 'wp_rem_pt_row_title', $pt_row_title );

            // saving all section values
            update_post_meta( $post_id, 'wp_rem_pt_sec_vals', $pt_sec_val );

            // saving all section pos values
            update_post_meta( $post_id, 'wp_rem_pt_sec_pos', $pt_sec_pos );
        }

        public function wp_rem_pt_icon( $value = '', $id = '', $name = '' ) {//begin function
            if ( $value == '' && $id == '' && $name == '' ) {
                $id = rand( 10000000, 99999999 );
                $name = 'dir_pt_col_sub';
            }
            $html = "
			<script>
			jQuery(document).ready(function ($) {
				var this_icons;
				var rand_num = " . $id . ";
				var e9_element = $('#e9_element_' + rand_num).fontIconPicker({
					theme: 'fip-bootstrap'
				});
				icons_load_call.always(function () {
					this_icons = loaded_icons;
					// Get the class prefix
					var classPrefix = this_icons.preferences.fontPref.prefix,
							icomoon_json_icons = [],
							icomoon_json_search = [];
					$.each(this_icons.icons, function (i, v) {
						icomoon_json_icons.push(classPrefix + v.properties.name);
						if (v.icon && v.icon.tags && v.icon.tags.length) {
							icomoon_json_search.push(v.properties.name + ' ' + v.icon.tags.join(' '));
						} else {
							icomoon_json_search.push(v.properties.name);
						}
					});
					// Set new fonts on fontIconPicker
					e9_element.setIcons(icomoon_json_icons, icomoon_json_search);
					// Show success message and disable
					$('#e9_buttons_' + rand_num + ' button').removeClass('btn-primary').addClass('btn-success').text('Successfully loaded icons').prop('disabled', true);
				})
				.fail(function () {
					// Show error message and enable
					$('#e9_buttons_' + rand_num + ' button').removeClass('btn-primary').addClass('btn-danger').text('Error: Try Again?').prop('disabled', false);
				});
			});
			</script>";

            $html .= '
			<input type="text" id="e9_element_' . $id . '" name="' . $name . '[]" value="' . $value . '">
			<span id="e9_buttons_' . $id . '" style="display:none">\
				<button autocomplete="off" type="button" class="btn btn-primary">Load from IcoMoon selection.json</button>
			</span>';

            if ( isset( $_POST['field'] ) && $_POST['field'] == 'icon' ) {
                echo json_encode( array( 'icon' => $html ) );
                die;
            } else {
                return $html;
            }
        }

        function submit_meta_box( $post, $args = array() ) {
            global $action, $post, $wp_rem_plugin_static_text;


            $post_type = $post->post_type;
            $post_type_object = get_post_type_object( $post_type );
            $can_publish = current_user_can( $post_type_object->cap->publish_posts );
            ?>
            <div class="submitbox wp-rem-submit" id="submitpost">
                <div id="minor-publishing">
                    <div style="display:none;">
                        <?php submit_button( wp_rem_plugin_text_srt( 'wp_rem_submit' ), 'button', 'save' ); ?>
                    </div>
                    <?php if ( $post_type_object->public && ! empty( $post ) ) : ?>
                        <?php
                        if ( 'publish' == $post->post_status ) {
                            $preview_link = esc_url( get_permalink( $post->ID ) );
                            $preview_button = wp_rem_plugin_text_srt( 'wp_rem_preview' );
                        } else {
                            $preview_link = set_url_scheme( get_permalink( $post->ID ) );

                            /**
                             * Filter the URI of a post preview in the post submit box.
                             *
                             * @since 2.0.5
                             * @since 4.0.0 $post parameter was added.
                             *
                             * @param string  $preview_link URI the user will be directed to for a post preview.
                             * @param WP_Post $post         Post object.
                             */
                            $preview_link = esc_url( apply_filters( 'preview_post_link', add_query_arg( 'preview', 'true', esc_url( $preview_link ) ), $post ) );
                            $preview_button = wp_rem_plugin_text_srt( 'wp_rem_preview' );
                        }
                        ?>
                    <?php endif; // public post type        ?>


                </div>
                <div id="major-publishing-actions" style="border-top:0px">
                    <?php
                    /**
                     * Fires at the beginning of the publishing actions section of the Publish meta box.
                     *
                     * @since 2.7.0
                     */
                    do_action( 'post_submitbox_start' );
                    ?>
                    <div id="delete-action">
                        <?php
                        if ( current_user_can( "delete_post", $post->ID ) ) {
                            if ( ! EMPTY_TRASH_DAYS ) {
                                $delete_text = wp_rem_plugin_text_srt( 'wp_rem_delete_permanently' );
                            } else {
                                $delete_text = wp_rem_plugin_text_srt( 'wp_rem_move_to_trash' );
                            }
                            if ( isset( $_GET['action'] ) && $_GET['action'] == 'edit' ) {
                                ?>
                                <a class="submitdelete deletion" href="<?php echo get_delete_post_link( $post->ID ); ?>"><?php echo wp_rem_allow_special_char( $delete_text ) ?></a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div id="publishing-action">
                        <span class="spinner"></span>
                        <?php
                        if ( ! in_array( $post->post_status, array( 'publish', 'future', 'private' ) ) || 0 == $post->ID ) {
                            if ( $can_publish ) :
                                if ( ! empty( $post->post_date_gmt ) && time() < strtotime( $post->post_date_gmt . ' +0000' ) ) :
                                    ?>
                                    <input name="original_publish" type="hidden" id="original_publish" value="<?php echo esc_html( 'wp_rem_schedule' ); ?>" />
                                    <?php submit_button( esc_html( 'wp_rem_schedule' ), 'primary button-large', 'publish', false, array( 'accesskey' => 'p' ) ); ?>
                                <?php else : ?>
                                    <input name="original_publish" type="hidden" id="original_publish" value="<?php echo wp_rem_plugin_text_srt( 'wp_rem_publish' ); ?>" />
                                    <?php submit_button( wp_rem_plugin_text_srt( 'wp_rem_publish' ), 'primary button-large', 'publish', false, array( 'accesskey' => 'p' ) ); ?>
                                <?php
                                endif;
                            else :
                                ?>
                                <input name="original_publish" type="hidden" id="original_publish" value="<?php echo wp_rem_plugin_text_srt( 'wp_rem_submit_for_review' ); ?>" />
                                <?php submit_button( wp_rem_plugin_text_srt( 'wp_rem_submit_for_review' ), 'primary button-large', 'publish', false, array( 'accesskey' => 'p' ) ); ?>
                            <?php
                            endif;
                        } else {

                            if ( isset( $_GET['action'] ) && $_GET['action'] == 'edit' ) {
                                ?>
                                <input name="original_publish" type="hidden" id="original_publish" value="<?php echo wp_rem_plugin_text_srt( 'wp_rem_update' ); ?>" />
                                <input name="save" type="submit" class="button button-primary button-large" id="publish" accesskey="p" value="<?php echo wp_rem_plugin_text_srt( 'wp_rem_update' ); ?>" />
                                <?php
                            } else {
                                ?>
                                <input name="original_publish" type="hidden" id="original_publish" value="<?php echo wp_rem_plugin_text_srt( 'wp_rem_publish' ); ?>">
                                <input type="submit" name="publish" id="publish" class="button button-primary button-large" value="<?php echo wp_rem_plugin_text_srt( 'wp_rem_publish' ); ?>" accesskey="p">
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <?php
        }

    }

    // Initialize Object
    global $price_tables_meta_object;
    $price_tables_meta_object = new price_tables_post_type_meta();
}