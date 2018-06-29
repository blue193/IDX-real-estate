<?php

/**
 * wp_rem_cs Theme Options Fields
 *
 * @package WordPress
 * @subpackage wp_rem_cs
 * @since Auto Mobile 1.0
 */
if ( ! class_exists('wp_rem_cs_var_fields') ) {

    class wp_rem_cs_var_fields {

        /**
         * Construct
         *
         * @return
         */
        public function __construct() {
            
        }

        /**
         * Sub Menu Fields
         *
         * @return
         */
        public function sub_menu($sub_menu = '') {

            $menu_items = '';
            $active = '';

            if ( is_array($sub_menu) && sizeof($sub_menu) > 0 ) {

                $menu_items .= '<ul class="sub-menu">';
                foreach ( $sub_menu as $key => $value ) {
                    $active = $key == "tab-global-setting" ? 'active' : '';
                    $menu_items .= '<li class="' . sanitize_html_class($key) . ' ' . $active . ' "><a href="#' . esc_html($key) . '" onClick="toggleDiv(this.hash);return false;">' . esc_attr($value) . '</a></li>';
                }
                $menu_items .= '</ul>';
            }

            return $menu_items;
        }

        /**
         * All Options Fields
         *
         * @return
         */
        public function wp_rem_cs_var_fields($wp_rem_cs_var_settings = '') {

            global $wp_rem_cs_var_options, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_static_text;

            $strings = new wp_rem_cs_theme_all_strings;
            $strings->wp_rem_cs_theme_option_field_strings();
            $counter = 0;
            $wp_rem_cs_var_counter = 0;
            $menu = '';
            $output = '';
            $parent_heading = '';
            $style = '';
            $wp_rem_cs_var_countries_list = '';

            if ( is_array($wp_rem_cs_var_settings) && sizeof($wp_rem_cs_var_settings) > 0 ) {
                foreach ( $wp_rem_cs_var_settings as $value ) {
                    $counter ++;
                    $val = '';

                    $select_value = '';
                    switch ( $value['type'] ) {

                        case "heading":
                            $parent_heading = $value['name'];
                            $menu .= '<li><a title="' . esc_html($value['name']) . '" href="#"><i class="' . sanitize_html_class($value["fontawesome"]) . '"></i><span class="cs-title-menu">' . esc_attr($value['name']) . '</span></a>';
                            if ( is_array($value['options']) && $value['options'] <> '' ) {
                                $menu .= $this->sub_menu($value['options']);
                            }
                            $menu .= '</li>';
                            break;

                        case "main-heading":
                            $parent_heading = $value['name'];
                            $menu .= '<li><a title="' . esc_html($value['name']) . '" href="#' . $value['id'] . '" onClick="toggleDiv(this.hash);return false;">
							<i class="' . sanitize_html_class($value["fontawesome"]) . '"></i><span class="cs-title-menu">' . esc_attr($value['name']) . '</span></a>';
                            $menu .= '</li>';
                            break;

                        case 'select_dashboard':
                            if ( isset($wp_rem_cs_var_options) and $wp_rem_cs_var_options <> '' ) {
                                if ( isset($wp_rem_cs_var_options[$value['id']]) ) {
                                    $select_value = $wp_rem_cs_var_options[$value['id']];
                                }
                            } else {
                                $select_value = $value['std'];
                            }
                            $args = array(
                                'depth' => 0,
                                'child_of' => 0,
                                'sort_order' => 'ASC',
                                'sort_column' => 'post_title',
                                'show_option_none' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_please_select_a_page'),
                                'hierarchical' => '1',
                                'exclude' => '',
                                'meta_key' => '',
                                'meta_value' => '',
                                'authors' => '',
                                'exclude_tree' => '',
                                'selected' => $select_value,
                                'echo' => 0,
                                'name' => $value['id'],
                                'post_type' => 'page'
                            );
                            $wp_rem_cs_var_pages = wp_dropdown_pages($args);
                            $all_pages = get_pages();
                            //print_r( get_pages());
                            $pages_array = array();
                            foreach ( $all_pages as $page ) {
                                if ( $page->post_type == 'page' ) {
                                    $pages_array[$page->ID] = $page->post_name;
                                }
                            }
                            print_r($pages_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'field_params' => array(
                                    'std' => $val,
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'classes' => isset($value['classes']) ? $value['classes'] : '',
                                    'return' => true,
                                    'options_markup' => true,
                                ),
                                'options' => $pages_array,
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                            break;

                        case "division":
                            $extra_atts = isset($value['extra_atts']) ? $value['extra_atts'] : '';
                            $default_show = isset($value['default_show']) ? $value['default_show'] : '';
                            $preview_image_tag = isset($value['preview_image_tag']) ? $value['preview_image_tag'] : '';
                            $preview_image_name = isset($value['preview_image_name']) ? $value['preview_image_name'] : '';
                            $preview_field_name = isset($value['preview_field_name']) ? $value['preview_field_name'] : '';
                            $preview_folder_path = isset($value['preview_folder_path']) ? $value['preview_folder_path'] : '';

                            $d_enable = ' style="display:none;"';
                            if ( $default_show == 'yes' ) {
                                $d_enable = ' style="display:block;"';
                            }
                            if ( isset($value['enable_val']) ) {
                                $enable_id = isset($value['enable_id']) ? $value['enable_id'] : '';
                                $enable_val = $value['enable_val'];
                                $d_val = '';
                                if ( isset($wp_rem_cs_var_options[$enable_id]) ) {
                                    $d_val = $wp_rem_cs_var_options[$enable_id];
                                }
                                $enable_multi = explode(',', $enable_val);
                                if ( is_array($enable_multi) && sizeof($enable_multi) > 1 ) {
                                    $d_enable = in_array($d_val, $enable_multi) ? ' style="display:block;"' : ' style="display:none;"';
                                } else {

                                    if ( $enable_id == 'wp_rem_cs_var_header_full_width' ) {
                                        echo $d_val;
                                        echo $enable_val;
                                    }


                                    $d_enable = $d_val == $enable_val ? ' style="display:block;"' : ' style="display:none;"';
                                }
                                if ( $default_show == 'yes' ) {
                                    $d_enable = ' style="display:block;"';
                                }
                            }
                            $output .= '<div' . $d_enable . ' ' . $extra_atts . '>';
                            if ( $preview_image_tag == 'yes' ) {
                                if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $preview_field_name . '']) ) {
                                    $preview_image_name = $wp_rem_cs_var_options['wp_rem_cs_var_' . $preview_field_name . ''];
                                }
                                if ( '' !== $preview_image_name ) {
                                    $output .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
                                    $output .= '<div class="img-holder">';
                                    $output .= '<figure>';
                                    $output .= '<a href="' . esc_url($preview_folder_path . $preview_image_name) . '.jpg" class="thumbnail" title="' . $preview_image_name . '"><img src="' . esc_url($preview_folder_path . $preview_image_name) . '.jpg" alt="' . $preview_image_name . '"></a>';
                                    $output .= '</figure>';
                                    $output .= '</div>';
                                    $output .= '</div>';
                                }
                            }
                            break;

                        case "division_close":
                            $output .= '</div>';
                            break;

                        case "col-right-text":
                            $col_heading = "";
                            $help_text = "";
                            if ( isset($value['col_heading']) ) {
                                $col_heading = isset($value['col_heading']) ? $value['col_heading'] : '';
                            }
                            if ( isset($value['help_text']) ) {
                                $help_text = isset($value['help_text']) ? $value['help_text'] : '';
                            }
                            $wp_rem_cs_opt_array = array(
                                'col_heading' => $col_heading,
                                'help_text' => $help_text,
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_set_col_right($wp_rem_cs_opt_array);
                            break;

                        case "sub-heading":
                            $wp_rem_cs_var_counter ++;
                            if ( $wp_rem_cs_var_counter > 1 ) {
                                $output .='</div>';
                            }
                            if ( $value['id'] != 'tab-global-setting' ) {
                                $style = 'style="display:none;"';
                            }

                            $output .= '<div id="' . $value['id'] . '" ' . $style . ' >';
                            $output .= '<div class="theme-header">
											<h1>' . esc_attr($value['name']) . '</h1>
									   </div>';
                            if ( isset($value['with_col']) && $value['with_col'] == true ) {
                                $output .='<div class="col2-right">';
                            }
                            break;

                        case "announcement":
                            $wp_rem_cs_var_counter ++;
                            $output.='<div id="' . $value['id'] . '" class="sidebar-area theme-help">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&#215;</button>
											<h4>' . force_balance_tags($value['name']) . '</h4>
											<p>' . force_balance_tags($value['std']) . '</p>
								 </div>';
                            break;

                        case "section":
                            $output .='<div class="theme-help">
									<h4>' . force_balance_tags($value['std']) . '</h4>
									<div class="clear"></div>
								  </div>';
                            break;

                        case 'text':
                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) ) {
                                $val = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $val = isset($value['std']) ? $value['std'] : '';
                            }

                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                'field_params' => array(
                                    'std' => $val,
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'classes' => '',
                                    'return' => true,
                                ),
                            );

                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                            break;

                        case 'slider_code':
                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) && $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']] <> '' ) {
                                $select_value = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $select_value = isset($value['std']) ? $value['std'] : '';
                            }

                            $wp_rem_cs_slider_options = '';

                            if ( class_exists('RevSlider') && class_exists('wp_rem_cs_var_RevSlider') ) {
                                $slider = new wp_rem_cs_var_RevSlider();
                                $arrSliders = $slider->getAllSliderAliases();
                                if ( is_array($arrSliders) ) {
                                    foreach ( $arrSliders as $key => $entry ) {

                                        $selected = '';
                                        if ( $select_value != '' ) {
                                            if ( $select_value == $entry['alias'] ) {
                                                $selected = ' selected="selected"';
                                            }
                                        } else {
                                            if ( isset($value['std']) )
                                                if ( $value['std'] == $entry['alias'] ) {
                                                    $selected = ' selected="selected"';
                                                }
                                        }
                                        $wp_rem_cs_slider_options .= '<option ' . $selected . ' value="' . $entry['alias'] . '">' . $entry['title'] . '</option>';
                                    }
                                }
                            }

                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                'field_params' => array(
                                    'std' => $val,
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'classes' => isset($value['classes']) ? $value['classes'] : '',
                                    'return' => true,
                                    'options_markup' => true,
                                    'options' => $wp_rem_cs_slider_options,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                            break;

                        case 'range_font' :
                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) ) {
                                $val = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $val = isset($value['std']) ? $value['std'] : '';
                            }

                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'extra_att' => 'style="width:50%; display:inline-block;"',
                                'id' => 'wp_rem_cs_var_' . $value['id'] . '_range',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                'field_params' => array(
                                    'std' => $val,
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'classes' => '',
                                    'return' => true,
                                ),
                            );

                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            break;

                        case 'range':
                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) ) {
                                $val = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $val = isset($value['std']) ? $value['std'] : '';
                            }

                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'id' => 'wp_rem_cs_var_' . $value['id'] . '_range',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                'field_params' => array(
                                    'std' => $val,
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'classes' => '',
                                    'return' => true,
                                ),
                            );

                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            break;

                        case 'textarea':
                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) ) {
                                $val = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $val = isset($value['std']) ? $value['std'] : '';
                            }
                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'id' => 'wp_rem_cs_var_' . $value['id'] . '_textarea',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                'field_params' => array(
                                    'std' => $val,
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'classes' => '',
                                    'return' => true,
                                ),
                            );

                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);

                            break;
                        case 'automatic_upgrade':
                            // If this is an request to upgrade theme.
                            if ( isset($_GET['action']) && $_GET['action'] == 'upgrade_theme' ) {
                                $data = wp_rem_cs_auto_upgrade_theme_and_plugins();

                                $cs_theme_upgraded_name = '';
                                if ( isset($data['cs_theme_upgraded_name']) ) {
                                    $cs_theme_upgraded_name = $data['cs_theme_upgraded_name'];
                                }

                                $plugins_str = '';
                                if ( isset($data['cs_plugins_upgraded']) ) {
                                    $cs_plugins_upgraded = $data['cs_plugins_upgraded'];
                                    $plugins_str = implode(', ', $cs_plugins_upgraded);
                                }

                                $msgStr = $cs_theme_upgraded_name;
                                if ( $msgStr != '' ) {
                                    $msgStr .= ', ' . $plugins_str;
                                } else {
                                    $msgStr = $plugins_str;
                                }

                                if ( $msgStr != '' ) {
                                    $message = wp_rem_cs_var_theme_text_srt('wp_rem_cs_plugin_options_fields_success_installed');
                                    ;
                                } else {
                                    $message = wp_rem_cs_var_theme_text_srt('wp_rem_cs_plugin_options_fields_unable_upgrade');
                                    ;
                                }

                                $cs_counter ++;
                                $output.='<div id="' . $value['id'] . '" class="sidebar-area theme-help">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&#215;</button>
										<h4>Upgrade Theme and Plugin(s)</h4>
										<p>' . $message . '</p>
								</div>';
                                $wp_rem_cs_inline_script = '
								(function($){
									$(function() {
										$(".wrap").hide();
									});
								})(jQuery);';
                                wp_rem_cs_admin_inline_enqueue_script($wp_rem_cs_inline_script, 'wp_rem_cs-custom-functions');
                            }
                            break;
                        case 'generate_backup':

                            global $wp_filesystem;

                            $backup_url = wp_nonce_url('themes.php?page=wp_rem_settings_page');

                            if ( false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) ) ) {

                                return true;
                            }

                            if ( ! WP_Filesystem($creds) ) {
                                request_filesystem_credentials($backup_url, '', true, false, array());
                                return true;
                            }

                            $wp_rem_cs_var_upload_dir = get_template_directory() . '/include/backend/cs-theme-options/backups/';

                            $wp_rem_cs_var_upload_dir_path = get_template_directory_uri() . '/include/backend/cs-theme-options/backups/';

                            $wp_rem_cs_var_all_list = $wp_filesystem->dirlist($wp_rem_cs_var_upload_dir);

                            $output .= '<div class="backup_generates_area form-elements" data-ajaxurl="' . esc_url(admin_url('admin-ajax.php')) . '">';

                            $output .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';

                            $wp_rem_cs_var_import_options = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_import_options');
                            $output .= '
							<div class="cs-import-help">
								<h4>' . $wp_rem_cs_var_import_options . '</h4>
							</div>';

                            $output .= '<div class="external_backup_areas">';
                            $wp_rem_cs_var_location_and_hit_import_button = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_location_and_hit_import_button');
                            $output .= '<p>' . $wp_rem_cs_var_location_and_hit_import_button . '</p>';

                            $wp_rem_cs_opt_array = array(
                                'std' => '',
                                'cust_id' => 'bkup_import_url',
                                'cust_name' => 'bkup_import_url',
                                'return' => true,
                            );
                            $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_import'),
                                'cust_id' => 'cs-backup-url-restore',
                                'cust_name' => 'cs-backup-url-restore',
                                'cust_type' => 'button',
                                'return' => true,
                            );
                            $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array);

                            $output .= '</div>';
                            $wp_rem_cs_var_export_options = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_export_options');
                            $output .= '
							<div class="cs-import-help">
								<h4>' . $wp_rem_cs_var_export_options . '</h4>
							</div>';

                            if ( is_array($wp_rem_cs_var_all_list) && sizeof($wp_rem_cs_var_all_list) > 0 ) {

                                $output .= '<p>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_download_backups_hint') . '</p>';

                                $output .= '<select onchange="wp_rem_cs_var_set_filename(this.value, \'' . esc_url($wp_rem_cs_var_upload_dir_path) . '\')">';

                                $wp_rem_cs_var_list_count = 1;
                                foreach ( $wp_rem_cs_var_all_list as $file_key => $file_val ) {

                                    if ( isset($file_val['name']) ) {

                                        $wp_rem_cs_var_slected = sizeof($wp_rem_cs_var_all_list) == $wp_rem_cs_var_list_count ? ' selected="selected"' : '';
                                        $output .= '<option' . $wp_rem_cs_var_slected . '>' . $file_val['name'] . '</option>';
                                    }
                                    $wp_rem_cs_var_list_count ++;
                                }
                                $output .= '</select>';
                                $output .= '<div class="backup_action_btns">';

                                if ( isset($file_val['name']) ) {

                                    $wp_rem_cs_opt_array = array(
                                        'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_restore'),
                                        'cust_id' => 'cs-backup-restore',
                                        'cust_name' => 'cs-backup-restore',
                                        'cust_type' => 'button',
                                        'extra_atr' => 'data-file="' . $file_val['name'] . '"',
                                        'return' => true,
                                    );
                                    $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array);
                                    $wp_rem_cs_var_download = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_download');
                                    $output .= '<a download="' . $file_val['name'] . '" href="' . esc_url($wp_rem_cs_var_upload_dir_path . $file_val['name']) . '">' . $wp_rem_cs_var_download . '</a>';

                                    $wp_rem_cs_opt_array = array(
                                        'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_delete'),
                                        'cust_id' => 'cs-backup-delte',
                                        'cust_name' => 'cs-backup-delte',
                                        'cust_type' => 'button',
                                        'extra_atr' => 'data-file="' . $file_val['name'] . '"',
                                        'return' => true,
                                    );
                                    $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array);
                                }

                                $output .= '</div>';
                            }

                            $wp_rem_cs_opt_array = array(
                                'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_generate_backup'),
                                'cust_id' => 'cs-backup-generte',
                                'cust_name' => 'cs-backup-generte',
                                'cust_type' => 'button',
                                'extra_atr' => 'onclick="javascript:wp_rem_cs_var_backup_generate(\'' . esc_js(admin_url('admin-ajax.php')) . '\');"',
                                'return' => true,
                            );
                            $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array);

                            $output .= '</div></div>';

                            break;



                        case "banner_fields":
                            $wp_rem_cs_var_rand_id = rand(23789, 534578930);
                            if ( isset($wp_rem_cs_var_options) && $wp_rem_cs_var_options <> '' ) {
                                if ( ! isset($wp_rem_cs_var_options['wp_rem_cs_var_banner_title']) ) {
                                    $network_list = '';
                                    $display = 'none';
                                } else {

                                    $network_list = isset($wp_rem_cs_var_options['wp_rem_cs_var_banner_title']) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_title'] : '';
                                    $banner_style = isset($wp_rem_cs_var_options['wp_rem_cs_var_banner_style']) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_style'] : '';
                                    $banner_type = isset($wp_rem_cs_var_options['wp_rem_cs_var_banner_type']) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_type'] : '';
                                    $banner_image = isset($wp_rem_cs_var_options['wp_rem_cs_var_banner_image_array']) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_image_array'] : '';
                                    $banner_field_url = isset($wp_rem_cs_var_options['wp_rem_cs_var_banner_field_url']) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_field_url'] : '';
                                    $banner_target = isset($wp_rem_cs_var_options['wp_rem_cs_var_banner_target']) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_target'] : '';
                                    $adsense_code = isset($wp_rem_cs_var_options['wp_rem_cs_var_adsense_code']) ? $wp_rem_cs_var_options['wp_rem_cs_var_adsense_code'] : '';
                                    $code_no = isset($wp_rem_cs_var_options['wp_rem_cs_var_banner_field_code_no']) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_field_code_no'] : '';

                                    $display = 'block';
                                }
                            } else {
                                $val = isset($wp_rem_cs_var_options['options']) ? $value['options'] : '';
                                $std = isset($wp_rem_cs_var_options['id']) ? $value['id'] : '';
                                $display = 'block';
                                $network_list = isset($wp_rem_cs_var_options['wp_rem_cs_var_banner_title']) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_title'] : '';
                                $banner_style = isset($wp_rem_cs_var_options['wp_rem_cs_var_banner_style']) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_style'] : '';
                                $banner_type = isset($wp_rem_cs_var_options['wp_rem_cs_var_banner_type']) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_type'] : '';
                                $banner_image = isset($wp_rem_cs_var_options['wp_rem_cs_var_banner_image_array']) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_image_array'] : '';
                                $banner_field_url = isset($wp_rem_cs_var_options['wp_rem_cs_var_banner_field_url']) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_field_url'] : '';
                                $banner_target = isset($wp_rem_cs_var_options['wp_rem_cs_var_banner_target']) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_target'] : '';
                                $adsense_code = isset($wp_rem_cs_var_options['wp_rem_cs_var_adsense_code']) ? $wp_rem_cs_var_options['wp_rem_cs_var_adsense_code'] : '';
                                $code_no = isset($wp_rem_cs_var_options['wp_rem_cs_var_banner_field_code_no']) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_field_code_no'] : '';
                            }
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_title_field'),
                                'desc' => '',
                                'label_desc' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_title_field_hint'),
                                'field_params' => array(
                                    'std' => '',
                                    'cust_id' => 'banner_title_input',
                                    'cust_name' => 'banner_title_input',
                                    'classes' => '',
                                    'return' => true,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);


                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_style'),
                                'label_desc' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_style_hint'),
                                'field_params' => array(
                                    'std' => '',
                                    'desc' => '',
                                    'cust_id' => "banner_style_input",
                                    'cust_name' => 'banner_style_input',
                                    'classes' => 'input-small chosen-select',
                                    'options' =>
                                    array(
                                        'top_banner' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_type_top'),
                                        'bottom_banner' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_type_bottom'),
                                        'sidebar_banner' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_type_sidebar'),
                                        'vertical_banner' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_type_vertical'),
                                    ),
                                    'return' => true,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);




                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_type'),
                                'label_desc' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_type_hint'),
                                'field_params' => array(
                                    'std' => '',
                                    'desc' => '',
                                    'cust_id' => "banner_type_input",
                                    'cust_name' => 'banner_type_input',
                                    'classes' => 'input-small chosen-select',
                                    'extra_atr' => 'onchange="javascript:wp_rem_cs_var_banner_type_toggle(this.value , \'' . $wp_rem_cs_var_rand_id . '\')"',
                                    'options' =>
                                    array(
                                        'image' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_image'),
                                        'code' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_code'),
                                    ),
                                    'return' => true,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);


                            $output .='<div id="ads_image' . absint($wp_rem_cs_var_rand_id) . '">';

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_image'),
                                'id' => 'banner_field_image',
                                'std' => '',
                                'desc' => '',
                                'label_desc' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_image_hint'),
                                'prefix' => '',
                                'field_params' => array(
                                    'std' => '',
                                    'id' => 'banner_field_image',
                                    'prefix' => '',
                                    'return' => true,
                                ),
                            );

                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);
                            $output .='</div>';

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_url_field'),
                                'desc' => '',
                                'label_desc' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_url_hint'),
                                'field_params' => array(
                                    'std' => '',
                                    'cust_id' => 'banner_field_url_input',
                                    'cust_name' => 'banner_field_url_input',
                                    'classes' => '',
                                    'return' => true,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);




                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_target'),
                                'label_desc' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_target_hint'),
                                'field_params' => array(
                                    'std' => '',
                                    'desc' => '',
                                    'cust_id' => "banner_target_input",
                                    'cust_name' => 'banner_target_input',
                                    'classes' => 'input-small chosen-select',
                                    'options' =>
                                    array(
                                        '_self' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_target_self'),
                                        '_blank' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_target_blank'),
                                    ),
                                    'return' => true,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                            $output .='<div id="ads_code' . absint($wp_rem_cs_var_rand_id) . '" style="display:none">';
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_ad_sense_code'),
                                'desc' => '',
                                'label_desc' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_ad_sense_code_hint'),
                                'field_params' => array(
                                    'std' => '',
                                    'cust_id' => 'adsense_code_input',
                                    'cust_name' => 'adsense_code_input[]',
                                    'classes' => '',
                                    'return' => true,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);

                            $output .='</div>';

                            $wp_rem_cs_opt_array = array(
                                'name' => '&nbsp;',
                                'desc' => '',
                                'hint_text' => '',
                                'field_params' => array(
                                    'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_add'),
                                    'id' => 'wp_rem_cs_var_add_banner',
                                    'classes' => '',
                                    'cust_type' => 'button',
                                    'extra_atr' => 'onclick="javascript:wp_rem_cs_var_add_banner(\'' . admin_url("admin-ajax.php") . '\')"',
                                    'return' => true,
                                ),
                            );

                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $output .= '
							<div class="social-area" style="display:' . $display . '">
							<div class="theme-help">
							  <h4 style="padding-bottom:0px;">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_already_added') . '</h4>
							  <div class="clear"></div>
							</div>
							<div class="boxes">
							<table class="to-table" border="0" cellspacing="0">
								<thead>
								  <tr>
                                                                  
                                                                        <th>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_table_title') . '</th>
									<th>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_table_style') . '</th>
									<th>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_table_image') . '</th>

									<th>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_table_clicks') . '</th>
									<th>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_table_shortcode') . '</th>
									<th class="centr">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_actions') . '</th>
								  </tr>
								</thead>
								<tbody id="banner_area">';
                            $i = 0;
                            if ( is_array($network_list) ) {
                                foreach ( $network_list as $network ) {
                                    if ( isset($network_list[$i]) || isset($network_list[$i]) ) {

                                        $wp_rem_cs_rand_num = rand(123456, 987654);
                                        $output .= '<tr id="del_' . $wp_rem_cs_rand_num . '">';

                                        $output .= '<td>' . esc_html($network_list[$i]) . '</td>';
                                        $output .= '<td>' . esc_html($banner_style[$i]) . '</td>';
                                        if ( isset($banner_image[$i]) && ! empty($banner_image[$i]) && $banner_type[$i] == 'image' ) {
                                            $output .= '<td><img src="' . esc_url($banner_image[$i]) . '" alt="" width="100" /></td>';
                                        } else {
                                            $output .= '<td>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_custom_code') . '</td>';
                                        }

                                        if ( $banner_type[$i] == 'image' ) {
                                            $banner_click_count = get_option("banner_clicks_" . $code_no[$i]);
                                            $banner_click_count = $banner_click_count <> '' ? $banner_click_count : '0';
                                            $output .= '<td>' . $banner_click_count . '</td>';
                                        } else {
                                            $output .= '<td>&nbsp;</td>';
                                        }

                                        $output .= '<td>[wp_rem_cs_ads id="' . $code_no[$i] . '"]</td>';
                                        $output .= '
                                          <td class="centr">
                                          <a class="remove-btn" onclick="javascript:return confirm(\'' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_alert_msg') . '\')" href="javascript:ads_del(\'' . $wp_rem_cs_rand_num . '\')" data-toggle="tooltip" data-placement="top" title="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_remove') . '">
                                          <i class="icon-cross"></i></a>
                                          <a href="javascript:wp_rem_cs_var_toggle(\'' . absint($wp_rem_cs_rand_num) . '\')" data-toggle="tooltip" data-placement="top" title="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_edit') . '">
                                          <i class="icon-mode_edit"></i>
                                          </a>
                                          </td>
                                          </tr>';

                                        $output .= '
                                          <tr id="' . absint($wp_rem_cs_rand_num) . '" style="display:none">
                                          <td colspan="3">
                                          <div class="form-elements">
                                          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
                                          <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                          <a class="cs-remove-btn" onclick="wp_rem_cs_var_toggle(\'' . $wp_rem_cs_rand_num . '\')"><i class="icon-cross"></i></a>
                                          </div>
                                          </div>';

                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_title_field'),
                                            'desc' => '',
                                            'label_desc' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_title_field_hint'),
                                            'field_params' => array(
                                                'std' => isset($network_list[$i]) ? $network_list[$i] : '',
                                                'cust_id' => 'banner_title',
                                                'cust_name' => 'wp_rem_cs_var_banner_title[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);


                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_style'),
                                            'label_desc' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_style_hint'),
                                            'field_params' => array(
                                                'std' => isset($banner_style[$i]) ? $banner_style[$i] : '',
                                                'cust_id' => 'banner_style',
                                                'cust_name' => 'wp_rem_cs_var_banner_style[]',
                                                'desc' => '',
                                                'classes' => 'input-small chosen-select',
                                                'options' =>
                                                array(
                                                    'top_banner' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_type_top'),
                                                    'bottom_banner' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_type_bottom'),
                                                    'sidebar_banner' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_type_sidebar'),
                                                    'vertical_banner' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_type_vertical'),
                                                ),
                                                'return' => true,
                                            ),
                                        );
                                        $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);




                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_type'),
                                            'label_desc' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_type_hint'),
                                            'field_params' => array(
                                                'std' => isset($banner_type[$i]) ? $banner_type[$i] : '',
                                                'cust_id' => 'banner_type',
                                                'cust_name' => 'wp_rem_cs_var_banner_type[]',
                                                'desc' => '',
                                                'extra_atr' => 'onchange="javascript:wp_rem_cs_var_banner_type_toggle(this.value , \'' . $wp_rem_cs_rand_num . '\')"',
                                                'classes' => 'input-small chosen-select',
                                                'options' =>
                                                array(
                                                    'image' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_image'),
                                                    'code' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_code'),
                                                ),
                                                'return' => true,
                                            ),
                                        );
                                        $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                                        $display_ads = 'none';
                                        if ( $banner_type[$i] == 'image' ) {
                                            $display_ads = 'block';
                                        } elseif ( $banner_type[$i] == 'code' ) {
                                            $display_ads = 'none';
                                        }
                                        $output .='<div id="ads_image' . absint($wp_rem_cs_rand_num) . '" style="display:' . esc_html($display_ads) . '">';

                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_image'),
                                            'id' => 'banner_image',
                                            'std' => isset($banner_image[$i]) ? $banner_image[$i] : '',
                                            'desc' => '',
                                            'label_desc' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_image_hint'),
                                            'prefix' => '',
                                            'array' => true,
                                            'field_params' => array(
                                                'std' => isset($banner_image[$i]) ? $banner_image[$i] : '',
                                                'id' => 'banner_image',
                                                'prefix' => '',
                                                'array' => true,
                                                'return' => true,
                                            ),
                                        );

                                        $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);
                                        $output .='</div>';


                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_url_field'),
                                            'desc' => '',
                                            'label_desc' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_url_hint'),
                                            'field_params' => array(
                                                'std' => isset($banner_field_url[$i]) ? $banner_field_url[$i] : '',
                                                'cust_id' => 'banner_field_url',
                                                'cust_name' => 'wp_rem_cs_var_banner_field_url[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);


                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_target'),
                                            'label_desc' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_target_hint'),
                                            'field_params' => array(
                                                'desc' => '',
                                                'std' => isset($banner_target[$i]) ? $banner_target[$i] : '',
                                                'cust_id' => 'banner_target',
                                                'cust_name' => 'wp_rem_cs_var_banner_target[]',
                                                'classes' => 'input-small chosen-select',
                                                'options' =>
                                                array(
                                                    '_self' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_target_self'),
                                                    '_blank' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_target_blank'),
                                                ),
                                                'return' => true,
                                            ),
                                        );
                                        $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                                        $display_ads = 'none';
                                        if ( $banner_type[$i] == 'image' ) {
                                            $display_ads = 'none';
                                        } elseif ( $banner_type[$i] == 'code' ) {
                                            $display_ads = 'block';
                                        }
                                        $output .='<div id="ads_code' . absint($wp_rem_cs_rand_num) . '" style="display:' . esc_html($display_ads) . '">';
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_ad_sense_code'),
                                            'desc' => '',
                                            'label_desc' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_banner_ad_sense_code_hint'),
                                            'field_params' => array(
                                                'std' => isset($adsense_code[$i]) ? $adsense_code[$i] : '',
                                                'cust_id' => 'adsense_code',
                                                'cust_name' => 'wp_rem_cs_var_adsense_code[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                                        $output .='</div>';

                                        $wp_rem_cs_opt_array = array(
                                            'std' => isset($code_no[$i]) ? $code_no[$i] : '',
                                            'id' => 'banner_field_code_no',
                                            'cust_name' => 'wp_rem_cs_var_banner_field_code_no[]',
                                            'return' => true,
                                        );
                                        $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);

                                        $output .= '
										  </td>
										</tr>';
                                    }
                                    $i ++;
                                }
                            }

                            $output .= '</tbody></table></div></div>';
                            break;


                        case 'widgets_backup':

                            $output .= '<div class="backup_generates_area form-elements" data-ajaxurl="' . esc_url(admin_url('admin-ajax.php')) . '">';
                            $output .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
                            if ( class_exists('wp_rem_cs_var_widget_data') ) {

                                global $wp_filesystem;

                                $backup_url = wp_nonce_url('themes.php?page=wp_rem_settings_page');

                                if ( false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) ) ) {

                                    return true;
                                }

                                if ( ! WP_Filesystem($creds) ) {
                                    request_filesystem_credentials($backup_url, '', true, false, array());
                                    return true;
                                }

                                $wp_rem_cs_var_upload_dir = get_template_directory() . '/include/backend/cs-widgets/import/widgets-backup/';

                                $wp_rem_cs_var_upload_dir_path = get_template_directory_uri() . '/include/backend/cs-widgets/import/widgets-backup/';

                                $wp_rem_cs_var_all_list = $wp_filesystem->dirlist($wp_rem_cs_var_upload_dir);
                                $wp_rem_cs_var_import_widgets = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_import_widgets');
                                $output .= '
                                            <div class="cs-import-help">
                                                    <h4>' . $wp_rem_cs_var_import_widgets . '</h4>
                                            </div>';

                                $output .= '
                                            <div class="external_backup_areas">
                                                    <div id="cs-import-widgets-con">
                                                            <div id="cs-import-widget-loader"></div>
                                                            ' . wp_rem_cs_var_widget_data::import_settings_page() . '
                                                    </div>
                                            </div>';

                                if ( is_array($wp_rem_cs_var_all_list) && sizeof($wp_rem_cs_var_all_list) > 0 ) {
                                    $wp_rem_cs_var_download_backups_hint = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_download_backups_hint');
                                    $output .= '<p>' . $wp_rem_cs_var_download_backups_hint . '</p>';

                                    $output .= '<select id="cs-wid-backup-change" onchange="wp_rem_cs_var_set_filename(this.value, \'' . esc_url($wp_rem_cs_var_upload_dir_path) . '\')">';

                                    $wp_rem_cs_var_list_count = 1;
                                    foreach ( $wp_rem_cs_var_all_list as $file_key => $file_val ) {

                                        if ( isset($file_val['name']) ) {

                                            $wp_rem_cs_var_slected = sizeof($wp_rem_cs_var_all_list) == $wp_rem_cs_var_list_count ? ' selected="selected"' : '';
                                            $output .= '<option' . $wp_rem_cs_var_slected . '>' . $file_val['name'] . '</option>';
                                        }
                                        $wp_rem_cs_var_list_count ++;
                                    }
                                    $output .= '</select>';
                                    $output .= '<div class="backup_action_btns">';

                                    if ( isset($file_val['name']) ) {

                                        $wp_rem_cs_opt_array = array(
                                            'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_show_widget_settings'),
                                            'cust_id' => 'cs-wid-backup-restore',
                                            'cust_name' => 'cs-wid-backup-restore',
                                            'cust_type' => 'button',
                                            'extra_atr' => 'data-path="' . $wp_rem_cs_var_upload_dir_path . '" data-file="' . $file_val['name'] . '"',
                                            'return' => true,
                                        );
                                        $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array);
                                        $wp_rem_cs_var_download = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_download');
                                        $output .= '<a download="' . $file_val['name'] . '" href="' . esc_url($wp_rem_cs_var_upload_dir_path . $file_val['name']) . '">' . $wp_rem_cs_var_download . '</a>';

                                        $wp_rem_cs_opt_array = array(
                                            'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_delete'),
                                            'cust_id' => 'cs-wid-backup-delte',
                                            'cust_name' => 'cs-wid-backup-delte',
                                            'cust_type' => 'button',
                                            'extra_atr' => 'data-file="' . $file_val['name'] . '"',
                                            'return' => true,
                                        );
                                        $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array);
                                    }

                                    $output .= '</div>';
                                }
                                $output .= '
                                            <div class="cs-import-help">
                                                    <h4>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_export_widgets') . '</h4>
                                            </div>';

                                $output .= '
                                            <div id="cs-export-widgets-con">
                                                    <div id="cs-export-widget-loader"></div>
                                                    ' . wp_rem_cs_var_widget_data::export_settings_page() . '
                                            </div>';
                            }

                            $output .= '</div></div>';

                            break;

                        case "layout":
                            global $wp_rem_cs_var_header_colors;

                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) ) {
                                $select_value = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $select_value = isset($value['std']) ? $value['std'] : '';
                            }

                            if ( isset($value['id']) ) {

                                $wp_rem_cs_name = 'wp_rem_cs_var_' . $value['id'];

                                $wp_rem_cs_opt_array = array(
                                    'name' => isset($value['name']) ? $value['name'] : '',
                                    'id' => $wp_rem_cs_name . '_layout',
                                    'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                    'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                );
                                $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_opening_field($wp_rem_cs_opt_array);

                                if ( is_array($value['options']) && sizeof($value['options']) > 0 ) {
                                    $output .= '
									<div class="input-sec">
										<div class="meta-input pattern">';
                                    foreach ( $value['options'] as $key => $option ) {
                                        $checked = '';
                                        $custom_class = '';
                                        if ( $select_value != '' ) {

                                            if ( $select_value == $key ) {
                                                $checked = ' checked';
                                                $custom_class = 'check-list';
                                            }
                                        } else {
                                            if ( $value['std'] == $key ) {
                                                $checked = ' checked';
                                                $custom_class = 'check-list';
                                            }
                                        }

                                        $wp_rem_cs_rand_id = rand(123456, 987654);

                                        $output .= '
					<div class="radio-image-wrapper">';
                                        $wp_rem_cs_opt_array = array(
                                            'std' => esc_html($key),
                                            'cust_id' => $wp_rem_cs_name . $wp_rem_cs_rand_id,
                                            'cust_name' => $wp_rem_cs_name,
                                            'cust_type' => 'radio',
                                            'classes' => 'radio',
                                            'extra_atr' => 'onclick="select_bg(\'' . $wp_rem_cs_name . '\',\'' . esc_html($key) . '\',\'' . get_template_directory_uri() . '\',\'\')" ' . $checked,
                                            'return' => true,
                                        );
                                        $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array);
                                        $output .= '
                                                    <label for="' . esc_html($wp_rem_cs_name . $wp_rem_cs_rand_id) . '"> 
                                                            <span class="ss"><img src="' . get_template_directory_uri() . '/assets/backend/images/' . esc_html($key) . '.png" /></span> 
                                                            <span class="' . sanitize_html_class($custom_class) . '" id="check-list">&nbsp;</span>
                                                    </label>
                                                    <span class="title-theme">' . esc_attr($option) . '</span>            
                                            </div>';
                                    }
                                    $output .= '
                                                </div>
                                        </div>';
                                }
                                $wp_rem_cs_opt_array = array(
                                    'desc' => isset($value['desc']) ? $value['desc'] : '',
                                );
                                $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_closing_field($wp_rem_cs_opt_array);
                            }
                            break;

                        case "horizontal_tab":
                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_layout']) && $wp_rem_cs_var_options['wp_rem_cs_var_layout'] <> 'boxed' ) {
                                echo '
                                        <style type="text/css" scoped>
                                                .horizontal_tabs,.main_tab{
                                                        display:none;
                                                }
                                        </style>';
                            }
                            $output .= '<div class="horizontal_tabs"><ul>';
                            $i = 0;
                            if ( is_array($value['options']) && sizeof($value['options']) > 0 ) {
                                foreach ( $value['options'] as $key => $val ) {
                                    $active = ($i == 0) ? 'active' : '';
                                    $output .= '<li class="' . sanitize_html_class($val) . ' ' . $active . '"><a href="#' . $val . '" onclick="show_hide(this.hash);return false;">' . esc_html($key) . '</a></li>';
                                    $i ++;
                                }
                            }
                            $output .= '</ul></div>';

                            break;

                        case "layout_body":
                            global $wp_rem_cs_var_header_colors;
                            $bg_counter = 0;
                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) ) {
                                $select_value = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $select_value = isset($value['std']) ? $value['std'] : '';
                            }

                            if ( $value['path'] == "background" ) {
                                $image_name = "background";
                            } else {
                                $image_name = "pattern";
                            }

                            if ( isset($value['id']) ) {

                                $wp_rem_cs_name = 'wp_rem_cs_var_' . $value['id'];

                                $output .= '
                                        <div class="main_tab">
                                                <div class="horizontal_tab" style="display:' . $value['display'] . '" id="' . $value['tab'] . '">';

                                $wp_rem_cs_opt_array = array(
                                    'name' => isset($value['name']) ? $value['name'] : '',
                                    'id' => $wp_rem_cs_name . '_layout_body',
                                    'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                    'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                );
                                $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_opening_field($wp_rem_cs_opt_array);

                                $output .= '
                                        <div class="input-sec">
                                                <div class="meta-input pattern">';
                                if ( is_array($value['options']) && sizeof($value['options']) > 0 ) {
                                    foreach ( $value['options'] as $key => $option ) {
                                        $checked = '';
                                        $custom_class = '';
                                        if ( $select_value == $option ) {
                                            $checked = ' checked';
                                            $custom_class = 'check-list';
                                        }

                                        $wp_rem_cs_rand_id = rand(123456, 987654);

                                        $output .= '
                                                <div class="radio-image-wrapper">';
                                        $wp_rem_cs_opt_array = array(
                                            'std' => $option,
                                            'cust_id' => $wp_rem_cs_name . $wp_rem_cs_rand_id,
                                            'cust_name' => $wp_rem_cs_name,
                                            'cust_type' => 'radio',
                                            'classes' => 'radio',
                                            'extra_atr' => 'onClick="javascript:select_bg(\'' . $wp_rem_cs_name . '\',\'' . $option . '\',\'' . get_template_directory_uri() . '\',\'\')" ' . $checked,
                                            'return' => true,
                                        );
                                        $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array);
                                        $output .= '
														<label for="' . esc_html($wp_rem_cs_name . $wp_rem_cs_rand_id) . '"> 
															<span class="ss"><img src="' . get_template_directory_uri() . '/assets/backend/images/' . $value['path'] . '/' . $image_name . $bg_counter . '.png" /></span> 
															<span id="check-list" class="' . sanitize_html_class($custom_class) . '">&nbsp;</span>
														</label>
													</div>';
                                        $bg_counter ++;
                                    }
                                }
                                $output .= '
											</div>
										</div>
									</div>
								</div>';
                                $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_closing_field(array());
                            }
                            break;

                        case 'select':
                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) ) {
                                $select_value = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $select_value = isset($value['std']) ? $value['std'] : '';
                            }
                            $display = isset($value['display']) ? $value['display'] : '';
                            $tab = isset($value['tab']) ? $value['tab'] : '';
                            if ( $tab == 'custom_image_position' ) {
                                $output .= '
                                        <div class="main_tab">
                                                <div class="horizontal_tab" style="display:' . $display . '" id="' . $tab . '">';
                            }
                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                'field_params' => array(
                                    'std' => $select_value,
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'classes' => isset($value['classes']) ? $value['classes'] : '',
                                    'extra_atr' => isset($value['extra_att']) ? $value['extra_att'] : '',
                                    'return' => true,
                                    'options' => isset($value['options']) ? $value['options'] : '',
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                            if ( $tab == 'custom_image_position' ) {
                                $output .= '
                                                </div>
                                            </div>';
                            }
                            break;
                        case 'custom_page_select':

                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) ) {
                                $select_value = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $select_value = isset($value['std']) ? $value['std'] : '';
                            }

                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_opening_field(array(
                                'id' => 'maintinance_mode_page',
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                    )
                            );
                            $id = isset($value['id']) ? $value['id'] : '';
                            $output .= '<div class="select-style pages_loader_holder pages-loader-holder" onclick="rem_load_all_pages(\'pages_loader_holder\', \'' . $id . '\', \'' . $select_value . '\');">';
                            $output .= '<span class="pages-loader"></span>';
                            $wp_rem_cs_opt_array = array(
                                'std' => $select_value,
                                'id' => isset($value['id']) ? $value['id'] : '',
                                'classes' => isset($value['classes']) ? $value['classes'] : '',
                                'extra_atr' => isset($value['extra_att']) ? $value['extra_att'] : '',
                                'return' => true,
                                'options' => isset($value['options']) ? $value['options'] : '',
                            );
                            $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_select_render($wp_rem_cs_opt_array);
                            $output .= '</div>';
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_closing_field(array( 'desc' => '' ));
                            break;

                        case 'gfont_select':
                            $output .= '<div class="sidebar-area theme-help ">
                                    <h4><b>' . esc_attr($value['name']) . '</b>';
                            $output .= wp_rem_cs_var_tooltip_helptext(isset($value['hint_text']) ? $value['hint_text'] : '');
                            $output .= '   </h4></div>';

                            $id = isset($value['id']) ? $value['id'] : '';

                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id'] . '_type']) ) {
                                $fonts_type_select_value = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id'] . '_type'];
                            } else {
                                $fonts_type_select_value = 'google_fonts';
                            }

                            $id = isset($value['id']) ? $value['id'] : '';
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_google_fonts_type'),
                                'id' => $id . '_type',
                                'extra_att' => 'style="width:100%; display:inline-block;"',
                                'label_desc' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_google_fonts_type_hint'),
                                'field_params' => array(
                                    'std' => $fonts_type_select_value,
                                    'id' => $id . '_type',
                                    'classes' => isset($value['classes']) ? $value['classes'] : '' . '_type',
                                    'return' => true,
                                    'extra_atr' => 'onchange="wp_rem_cs_var_google_fonts_type(this.value, \'' . $value['id'] . '\')"',
                                    "options" => array(
                                        'google_fonts' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_google_fonts_option'),
                                        'custom_fonts' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_custom_fonts_option'),
                                    )
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);


                            if ( $fonts_type_select_value == '' || $fonts_type_select_value == 'google_fonts' ) {
                                $google_fonts_display = 'style="width:50%; display:inline-block;"';
                                $custom_fonts_display = 'style="display: none;"';
                            } else {
                                $google_fonts_display = 'style="width:50%; display:none;"';
                                $custom_fonts_display = '';
                            }

                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) ) {
                                $select_value = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $select_value = isset($value['std']) ? $value['std'] : '';
                            }

							if( (empty($value['options']) && is_array($value['options'])) || (!is_array($value['options']) && $value['options'] == '') ){
								$value['options'] = array();
							}
                            if( !in_array($select_value, $value['options'])){
								if( !empty($value['options'])){
									$value['options'][$select_value] = $select_value;
								}else{
									$value['options'] = array($select_value => $select_value);
								}
							}
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_google_font_family'),
                                'id' => isset($value['id']) ? 'wp_rem_cs_var_' . $value['id'] . '_select' : '',
                                'extra_att' => $google_fonts_display,
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                'field_params' => array(
                                    'std' => $select_value,
                                    'id' => $id,
                                    'classes' => isset($value['classes']) ? $value['classes'] : '',
                                    'return' => true,
                                    'extra_atr' => 'onchange="wp_rem_selected_google_font_att_field(\'' . admin_url("admin-ajax.php") . '\',this.value, \'wp_rem_cs_var_' . $value['id'] . '_att\')"',
                                    'first_option' => '<option value="">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_default_font') . '</option>',
                                    'options' => isset($value['options']) ? $value['options'] : '',
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                            

                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_custom_' . $value['id']]) ) {
                                $select_value = $wp_rem_cs_var_options['wp_rem_cs_var_custom_' . $value['id']];
                            } else {
                                $select_value = '';
                            }
                            $wp_rem_cs_var_custom_fonts = wp_rem_cs_var_custom_fonts_list();
                            $output .= '<div class="custom_' . $id . '_holder" ' . $custom_fonts_display . '>';
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_custom_font_family'),
                                'id' => 'custom_' . $id,
                                'extra_att' => 'style="width:50%; display:inline-block;"',
                                'label_desc' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_custom_content_font_discription'),
                                'field_params' => array(
                                    'std' => $select_value,
                                    'id' => 'custom_' . $id,
                                    'classes' => 'custom_' . isset($value['classes']) ? $value['classes'] : '',
                                    'return' => true,
                                    'first_option' => '<option value="">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_default_font') . '</option>',
                                    'options' => $wp_rem_cs_var_custom_fonts,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_custom_' . $value['id'] . '_weight']) ) {
                                $font_weight_select_value = $wp_rem_cs_var_options['wp_rem_cs_var_custom_' . $value['id'] . '_weight'];
                            } else {
                                $font_weight_select_value = '400';
                            }
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_custom_font_weight'),
                                'desc' => '',
                                'hint_text' => '',
                                'label_desc' => '',
                                'id' => 'custom_' . $id . '_weight',
                                'extra_att' => 'style="width:50%; display:inline-block;"',
                                'field_params' => array(
                                    'std' => $font_weight_select_value,
                                    'id' => 'custom_' . $id . '_weight',
                                    'classes' => '',
                                    'return' => true,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                            $output .= '</div>';
                            break;
                        case 'mailchimp':

                            if ( isset($wp_rem_cs_var_options) && $wp_rem_cs_var_options <> '' ) {
                                if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) ) {
                                    $select_value = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                                }
                            } else {
                                $select_value = $value['std'];
                            }

                            $output .= '';



                            $output_str = '';
                            foreach ( $value['options'] as $option_key => $option ) {
                                $selected = '';
                                if ( $select_value != '' ) {
                                    if ( $select_value == $option_key ) {
                                        $selected = ' selected="selected"';
                                    }
                                } else {
                                    if ( isset($value['std']) )
                                        if ( $value['std'] == $option_key ) {
                                            $selected = ' selected="selected"';
                                        }
                                }
                                $output_str .= '<option' . $selected . ' value="' . $option_key . '">';
                                $output_str .= $option;
                                $output_str .= '</option>';
                            }
                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'id' => isset($value['id']) ? 'wp_rem_cs_var_' . $value['id'] . '_select' : '',
                                'extra_att' => '',
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                'field_params' => array(
                                    'std' => $select_value,
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'classes' => isset($value['classes']) ? $value['classes'] : '',
                                    'return' => true,
                                    'first_option' => '<option value="">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_select_attribute') . '</option>',
                                    'options' => isset($output_str) ? $output_str : '',
                                    'options_markup' => true,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                            $output .= '';
                            break;
                        case 'gfont_att_select':
                            $type_id = str_replace('_att', '_type', $value['id']);
                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $type_id]) ) {
                                $fonts_type_select_value = $wp_rem_cs_var_options['wp_rem_cs_var_' . $type_id];
                            } else {
                                $fonts_type_select_value = 'google_fonts';
                            }
							
							$font_name_id = str_replace('_att', '', $value['id']);
                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $font_name_id]) ) {
                                $selected_font_name = $wp_rem_cs_var_options['wp_rem_cs_var_' . $font_name_id];
                            } else {
                                $selected_font_name = '';
                            }

                            if ( $fonts_type_select_value == '' || $fonts_type_select_value == 'google_fonts' ) {
                                $google_fonts_attr_display = 'style="width:50%; display:inline-block;"';
                            } else {
                                $google_fonts_attr_display = 'style="width:50%; display:none;"';
                            }

                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) && $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']] <> '' ) {
                                $select_value = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $select_value = isset($value['std']) ? $value['std'] : '';
                            }
							if (class_exists('wp_rem_google_fonts_admin_frontend')) {
								if ( isset($wp_rem_cs_var_options[str_replace('_att', '', 'wp_rem_cs_var_' . $value['id'])]) && $wp_rem_cs_var_options[str_replace('_att', '', 'wp_rem_cs_var_' . $value['id'])] <> '' ) {
									$fonts_admin_frontend = new wp_rem_google_fonts_admin_frontend();
									$value['options'] = $fonts_admin_frontend->wp_rem_selected_google_fonts_attributes( $wp_rem_cs_var_options[str_replace('_att', '', 'wp_rem_cs_var_' . $value['id'])]);
								} 
							}

                            $wp_rem_cs_atts_array = array();
                            if ( isset($value['options']) && is_array($wp_rem_cs_atts_array) && ! empty($value['options']) ) {
                                foreach ( $value['options'] as $wp_rem_cs_att )
                                    $wp_rem_cs_atts_array[$wp_rem_cs_att] = $wp_rem_cs_att;
                            }
							
							if( (empty($wp_rem_cs_atts_array) && is_array($wp_rem_cs_atts_array)) || (!is_array($wp_rem_cs_atts_array) && $wp_rem_cs_atts_array == '') ){
								$wp_rem_cs_atts_array = array();
							}
							
							if( !in_array($select_value, $wp_rem_cs_atts_array) && $selected_font_name != '' ){
								if(!empty($wp_rem_cs_atts_array)){
									$wp_rem_cs_atts_array[$select_value] = $select_value;
								}else{
									$wp_rem_cs_atts_array = array($select_value => $select_value);
								}
							}
							
                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'id' => isset($value['id']) ? 'wp_rem_cs_var_' . $value['id'] . '_select' : '',
                                'extra_att' => $google_fonts_attr_display,
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                'field_params' => array(
                                    'std' => $select_value,
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'classes' => isset($value['classes']) ? $value['classes'] : '',
                                    'return' => true,
                                    'first_option' => '<option value="">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_select_attribute') . '</option>',
                                    'options' => $wp_rem_cs_atts_array,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                            break;

                        case 'select_ftext':

                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) ) {
                                $select_value = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $select_value = isset($value['std']) ? $value['std'] : '';
                            }

                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'id' => isset($value['id']) ? 'wp_rem_cs_var_' . $value['id'] . '_select' : '',
                                'extra_att' => 'style="width:50%; display:inline-block;"',
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                'field_params' => array(
                                    'std' => $select_value,
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'classes' => isset($value['classes']) ? $value['classes'] : '',
                                    'return' => true,
                                    'options' => isset($value['options']) ? $value['options'] : '',
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                            break;

                        case 'default_header':
                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) ) {
                                $select_value = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $select_value = isset($value['std']) ? $value['std'] : '';
                            }

                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'id' => isset($value['id']) ? 'wp_rem_cs_var_' . $value['id'] . '_header' : '',
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                'field_params' => array(
                                    'std' => $select_value,
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'classes' => isset($value['classes']) ? $value['classes'] : '',
                                    'return' => true,
                                    'extra_atr' => 'onchange="javascript:wp_rem_cs_var_show_slider(this.value)"',
                                    'options' => isset($value['options']) ? $value['options'] : '',
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                            break;

                        case 'select_sidebar' :

                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) ) {
                                $select_value = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $select_value = isset($value['std']) ? $value['std'] : '';
                            }

                            $wp_rem_cs_options_markup = '<option value="">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sidebar') . '</option>';

                            if ( is_array($value['options']['sidebar']) && sizeof($value['options']['sidebar']) > 0 ) {
                                foreach ( $value['options']['sidebar'] as $option ) {

                                    $key = sanitize_title($option);
                                    $selected = '';
                                    if ( $select_value != '' ) {
                                        if ( $select_value == $key ) {
                                            $selected = ' selected="selected"';
                                        }
                                    }
                                    $wp_rem_cs_options_markup .= '<option value="' . $key . '"' . $selected . '>' . $option . '</option>';
                                }
                            }

                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                'field_params' => array(
                                    'std' => $select_value,
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'classes' => isset($value['classes']) ? $value['classes'] : '',
                                    'return' => true,
                                    'options_markup' => true,
                                    'options' => $wp_rem_cs_options_markup,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                            break;

                        case "checkbox":

                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) ) {
                                $checked_value = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $checked_value = isset($value['std']) ? $value['std'] : '';
                            }

                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'id' => isset($value['id']) ? 'wp_rem_cs_var_' . $value['id'] . '_checkbox' : '',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                'field_params' => array(
                                    'std' => $checked_value,
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'classes' => '',
                                    'return' => true,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_checkbox_field($wp_rem_cs_opt_array);

                            break;

                        case 'hidden':
                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) ) {
                                $val = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $val = isset($value['std']) ? $value['std'] : '';
                            }

                            $wp_rem_cs_opt_array = array(
                                'std' => $val,
                                'id' => isset($value['id']) ? $value['id'] : '',
                                'classes' => '',
                                'return' => true,
                            );
                            $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);

                            break;

                        case 'hidden_field':
                            $val = isset($value['std']) ? $value['std'] : '';
                            $wp_rem_cs_opt_array = array(
                                'std' => $val,
                                'id' => isset($value['id']) ? $value['id'] : '',
                                'classes' => '',
                                'return' => true,
                            );
                            $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);

                            break;

                        case "color":

                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) ) {
                                $val = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $val = isset($value['std']) ? $value['std'] : '';
                            }
                            $display = isset($value['display']) ? $value['display'] : 'block';
                            $tab = isset($value['tab']) ? $value['tab'] : '';
                            $output .= '
                                        <div class="main_tab">
                                                <div class="horizontal_tab" style="display:' . $display . ';" id="' . $tab . '">';
                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                'id' => isset($value['id']) ? 'wp_rem_cs_var_' . $value['id'] . '_color' : '',
                                'field_params' => array(
                                    'std' => $val,
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'classes' => 'bg_color',
                                    'return' => true,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                            $output .= '
						</div>
                                        </div>';

                            break;

                        case "upload logo":
                            $wp_rem_cs_var_counter ++;

                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) ) {
                                $val = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $val = isset($value['std']) ? $value['std'] : '';
                            }
                            $display = isset($value['display']) ? $value['display'] : '';
                            $tab = isset($value['tab']) ? $value['tab'] : '';
                            $output .= '
                                        <div class="main_tab">
                                                <div class="horizontal_tab" style="display:' . $display . '" id="' . $tab . '">';
                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'id' => isset($value['id']) ? $value['id'] : '',
                                'main_id' => isset($value['mian_id']) ? $value['mian_id'] : '',
                                'std' => $val,
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                'prefix' => '',
                                'field_params' => array(
                                    'std' => isset($val) ? $val : '',
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'prefix' => '',
                                    'return' => true,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);
                            $output .= '
						</div>
                                        </div>';

                            break;

                        case "upload font":
                            $wp_rem_cs_var_counter ++;

                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) ) {
                                $val = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $val = isset($value['std']) ? $value['std'] : '';
                            }

                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'id' => $wp_rem_cs_name . '_upload',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_opening_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'std' => $val,
                                'cust_id' => $value['id'],
                                'cust_name' => 'wp_rem_cs_var_' . $value['id'],
                                'classes' => 'input-medium',
                                'return' => true,
                            );
                            $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array);
                            $output .= '
							<label class="browse-icon">';
                            $wp_rem_cs_opt_array = array(
                                'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_browse'),
                                'cust_id' => 'wp_rem_cs_var_' . $value['id'],
                                'cust_name' => $value['id'],
                                'cust_type' => 'button',
                                'classes' => 'cs-wp_rem_cs-media left ',
                                'return' => true,
                            );
                            $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array);
                            $output .= '
							</label>';
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_closing_field(array());

                            break;

                        case "upload favicon":
                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']]) ) {
                                $val = $wp_rem_cs_var_options['wp_rem_cs_var_' . $value['id']];
                            } else {
                                $val = isset($value['std']) ? $value['std'] : '';
                            }

                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'id' => isset($value['id']) ? $value['id'] : '',
                                'main_id' => isset($value['mian_id']) ? $value['mian_id'] : '',
                                'std' => $val,
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                'prefix' => '',
                                'field_params' => array(
                                    'std' => isset($val) ? $val : '',
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'prefix' => '',
                                    'return' => true,
                                ),
                            );

                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);

                            break;
                        case "sidebar" :

                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_sidebar']) && sizeof($wp_rem_cs_var_options['wp_rem_cs_var_sidebar']) > 0 ) {
                                $val['sidebar'] = $wp_rem_cs_var_options['wp_rem_cs_var_sidebar'];
                            }
                            if ( isset($val['sidebar']) && is_array($val['sidebar']) && sizeof($val['sidebar']) > 0 ) {
                                $display = 'block';
                            } else {
                                $display = 'none';
                            }

                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_opening_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'std' => '',
                                'cust_id' => 'sidebar_input',
                                'cust_name' => 'sidebar_input',
                                'classes' => 'input-medium',
                                'return' => true,
                            );
                            $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_add_sidebar'),
                                'cust_type' => 'button',
                                'cust_id' => 'add_new_sidebar',
                                'cust_name' => 'add_new_sidebar',
                                'extra_atr' => 'onclick="javascript:add_sidebar()"',
                                'return' => true,
                            );
                            $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array);

                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_closing_field(array());


                            $output .= '<div class="wp-rem-list-wrap wp-rem-sidebar-list-wrapper">
                    <ul class="wp-rem-list-layout">
                        <li class="wp-rem-list-label">
                            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                                <div class="element-label">
                                    <label>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sidebar_name') . ' </label>
                                </div>
                            </div>
                        </li>';
                            if ( $display == 'block' ) {
                                $i = 1;
                                if ( isset($val['sidebar']) && is_array($val['sidebar']) && sizeof($val['sidebar']) > 0 ) {
                                    foreach ( $val['sidebar'] as $sidebar ) {

                                        $output .= '<li class="wp-rem-list-item">
                                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                                            <div class="input-element">
                                                <div class="input-holder">
                                                    ' . $sidebar . '
                                                ';

                                        $wp_rem_cs_opt_array = array(
                                            'std' => $sidebar,
                                            'id' => 'sidebar' . $i,
                                            'cust_name' => 'wp_rem_cs_var_sidebar[]',
                                            'return' => true,
                                        );
                                        $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);

                                        $output .= '</div>
                                            </div></div>
                                        <a href="javascript:void(0);" class="wp-rem-remove wp-rem-parent-li-remove"><i class="icon-close2"></i></a>
                                        </li>';
                                        $i ++;
                                    }
                                }
                            }
                            $output .= '</ul></div>';
                            break;

                        case "wp_rem_cs_var_footer_sidebar":
                            $val = $value['std'];

                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_footer_sidebar']) and count($wp_rem_cs_var_options['wp_rem_cs_var_footer_sidebar']) > 0 ) {
                                $val['wp_rem_cs_var_footer_sidebar'] = $wp_rem_cs_var_options['wp_rem_cs_var_footer_sidebar'];
                            }

                            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_footer_width']) and count($wp_rem_cs_var_options['wp_rem_cs_var_footer_width']) > 0 ) {
                                $val['wp_rem_cs_var_footer_width'] = $wp_rem_cs_var_options['wp_rem_cs_var_footer_width'];
                            }

                            if ( isset($val['wp_rem_cs_var_footer_sidebar']) and count($val['wp_rem_cs_var_footer_sidebar']) > 0 and $val['wp_rem_cs_var_footer_sidebar'] <> '' ) {
                                $display = 'block';
                            } else {
                                $display = 'none';
                            }


                            if ( isset($val['wp_rem_cs_var_footer_width']) and count($val['wp_rem_cs_var_footer_width']) > 0 and $val['wp_rem_cs_var_footer_width'] <> '' ) {
                                $display = 'block';
                            } else {
                                $display = 'none';
                            }

                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_opening_field(array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'label_desc' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer_sidebar_title'),
                                    )
                            );

                            $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render(array(
                                'std' => '',
                                'cust_id' => "footer_sidebar_input",
                                'cust_name' => 'footer_sidebar_input',
                                'classes' => 'input-medium',
                                'return' => true,
                            ));

                            $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_select_render(array(
                                'std' => '',
                                'cust_id' => "footer_sidebar_width",
                                'cust_name' => 'footer_sidebar_width',
                                'classes' => 'select-medium chosen-select',
                                'options' =>
                                array(
                                    '2 Column (16.67%)' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_2column'),
                                    '3 Column (25%)' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_3column'),
                                    '4 Column (33.33%)' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_4column'),
                                    '6 Column (50%)' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_6column'),
                                    '8 Column (66.66%)' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_8column'),
                                    '9 Column (75%)' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_9column'),
                                    '10 Column (83.33%)' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_10column'),
                                    '12 Column (100%)' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_12column'),
                                ),
                                'return' => true,
                            ));

                            $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render(array(
                                'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_add_sidebar'),
                                'id' => "add_footer_sidebar",
                                'cust_name' => '',
                                'cust_type' => 'button',
                                'extra_atr' => ' onclick="javascript:add_footer_sidebar()"',
                                'return' => true,
                            ));

                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_closing_field(array(
                                'desc' => '',
                                    )
                            );

                            $output .= '<div class="wp-rem-list-wrap wp-rem-footer-sidebar-list-wrap wp-rem-parent-edit-wraper">
                            <ul class="wp-rem-list-layout">
                                <li class="wp-rem-list-label">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="element-label">
                                            <label>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_siderbar_name') . '</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="element-label">
                                            <label>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_siderbar_width') . '</label>
                                        </div>
                                    </div>
                                </li>';

                            $wp_rem_cs_inline_script = '
                                                        var $ = jQuery;
                                                        $(document).ready(function () {
                                                                function slideout() {
                                                                        setTimeout(function () {
                                                                                $("#footer_sidebar_area").slideUp("slow", function () {
                                                                                });

                                                                        }, 2000);
                                                                }

                                                                $(function () {
                                                                        $("#footer_sidebar_area").sortable({opacity: 0.8, cursor: \'move\', update: function () {

                                                                                        $("#footer_sidebar_area").html(theResponse);
                                                                                        $("#footer_sidebar_area").slideDown(\'slow\');
                                                                                        slideout();

                                                                                }
                                                                        });
                                                                });
                                                        });';
                            wp_rem_cs_admin_inline_enqueue_script($wp_rem_cs_inline_script, 'wp_rem_cs-custom-functions');
                            $i = 0;
                            if ( isset($val['wp_rem_cs_var_footer_sidebar']) && ! empty($val['wp_rem_cs_var_footer_sidebar']) ) {
                                foreach ( $val['wp_rem_cs_var_footer_sidebar'] as $wp_rem_cs_var_footer_sidebar ) {

                                    $output .= '<li class="wp-rem-list-item">';

                                    $output .= '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="input-element">
                                                <div class="input-holder">';

                                    $wp_rem_cs_footer_sidebar_name = wp_rem_cs_get_sidebar_id($wp_rem_cs_var_footer_sidebar);
                                    $wp_rem_cs_footer_sidebar_width = $wp_rem_cs_var_options['wp_rem_cs_var_footer_width'][$i];

                                    $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render(array(
                                        'std' => isset($wp_rem_cs_var_footer_sidebar) ? $wp_rem_cs_var_footer_sidebar : '',
                                        'id' => "hide_footer_sidebar" . $i,
                                        'cust_name' => 'wp_rem_cs_var_footer_sidebar[]',
                                        'cust_type' => 'hidden',
                                        'return' => true,
                                    ));

                                    $output .= $wp_rem_cs_var_footer_sidebar;

                                    $output.='</div>
                                            </div>
                                        </div>';


                                    $output .= '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="input-element">
                                                <div class="input-holder">';

                                    $wp_rem_cs_footer_sidebar_name = wp_rem_cs_get_sidebar_id($wp_rem_cs_var_footer_sidebar);
                                    $output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render(array(
                                        'std' => isset($wp_rem_cs_footer_sidebar_width) ? $wp_rem_cs_footer_sidebar_width : '',
                                        'id' => "hide_footer_sidebar_width" . $i,
                                        'cust_name' => 'wp_rem_cs_var_footer_width[]',
                                        'cust_type' => 'hidden',
                                        'return' => true,
                                    ));
                                    $output.= absint($wp_rem_cs_footer_sidebar_width);

                                    $output.='</div>
                                            </div>
                                        </div>';

                                    $output .= '<a href="javascript:void(0);" class="wp-rem-remove wp-rem-parent-li-remove"><i class="icon-close2"></i></a>';

                                    $output .= '</li>';
                                    $i ++;
                                }
                            }


                            $output .= '</ul></div>';

                            break;

                        case 'select_footer_sidebar':
                            if ( isset($wp_rem_cs_var_options) and $wp_rem_cs_var_options <> '' ) {
                                if ( isset($wp_rem_cs_var_options[$value['id']]) ) {
                                    $select_value = $wp_rem_cs_var_options[$value['id']];
                                }
                            } else {
                                $select_value = $value['std'];
                            }
                            $wp_rem_cs_single_post_layout = $wp_rem_cs_var_options['wp_rem_cs_single_post_layout'];

                            if ( isset($wp_rem_cs_single_post_layout) and $wp_rem_cs_single_post_layout == 'no_footer_sidebar' ) {
                                $cus_style = ' style="display:none;"';
                            } else {
                                $cus_style = ' style="display:block;"';
                            }
                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'id' => $value['id'] . '_header',
                                'extra_att' => isset($cus_style) ? $cus_style : '',
                                'desc' => $value['desc'],
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                'field_params' => array(
                                    'std' => $select_value,
                                    'cust_id' => isset($value['id']) ? $value['id'] : '',
                                    'cust_name' => isset($value['id']) ? $value['id'] : '',
                                    'options' => $value['options']['wp_rem_cs_var_footer_sidebar'],
                                    'return' => true,
                                    'classes' => $wp_rem_cs_classes,
                                ),
                            );

                            if ( isset($value['split']) && $value['split'] <> '' ) {
                                $wp_rem_cs_opt_array['split'] = $value['split'];
                            }
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                            break;

                        case 'select_footer_sidebar1':

                            if ( isset($wp_rem_cs_var_options) and $wp_rem_cs_var_options <> '' ) {
                                if ( isset($wp_rem_cs_var_options[$value['id']]) ) {
                                    $select_value = $wp_rem_cs_var_options[$value['id']];
                                }
                            } else {
                                $select_value = $value['std'];
                            }
                            $wp_rem_cs_single_post_layout = $wp_rem_cs_var_options['wp_rem_cs_default_page_layout'];

                            if ( isset($wp_rem_cs_single_post_layout) and $wp_rem_cs_single_post_layout == 'no_footer_sidebar' ) {
                                $cus_style = ' style="display:none;"';
                            } else {
                                $cus_style = ' style="display:block;"';
                            }

                            $wp_rem_cs_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'id' => $value['id'] . '_header',
                                'extra_att' => isset($cus_style) ? $cus_style : '',
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'label_desc' => isset($value['label_desc']) ? $value['label_desc'] : '',
                                'field_params' => array(
                                    'std' => $select_value,
                                    'cust_id' => isset($value['id']) ? $value['id'] : '',
                                    'cust_name' => isset($value['id']) ? $value['id'] : '',
                                    'classes' => $wp_rem_cs_classes,
                                    'options' => $value['options']['wp_rem_cs_var_footer_sidebar'],
                                    'return' => true,
                                ),
                            );

                            if ( isset($value['split']) && $value['split'] <> '' ) {
                                $wp_rem_cs_opt_array['split'] = $value['split'];
                            }
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                            break;

                        case "networks" :

                            if ( isset($wp_rem_cs_var_options) && $wp_rem_cs_var_options <> '' ) {

                                if ( ! isset($wp_rem_cs_var_options['wp_rem_cs_var_social_net_awesome']) ) {
                                    $network_list = '';
                                    $display = 'none';
                                } else {
                                    $network_list = isset($wp_rem_cs_var_options['wp_rem_cs_var_social_net_awesome']) ? $wp_rem_cs_var_options['wp_rem_cs_var_social_net_awesome'] : '';
                                    $network_list_group = isset($wp_rem_cs_var_options['wp_rem_cs_var_social_net_awesome_group']) ? $wp_rem_cs_var_options['wp_rem_cs_var_social_net_awesome_group'] : '';
                                    $social_net_tooltip = isset($wp_rem_cs_var_options['wp_rem_cs_var_social_net_tooltip']) ? $wp_rem_cs_var_options['wp_rem_cs_var_social_net_tooltip'] : '';
                                    $social_net_icon_path = isset($wp_rem_cs_var_options['wp_rem_cs_var_social_icon_path_array']) ? $wp_rem_cs_var_options['wp_rem_cs_var_social_icon_path_array'] : '';
                                    $social_net_url = isset($wp_rem_cs_var_options['wp_rem_cs_var_social_net_url']) ? $wp_rem_cs_var_options['wp_rem_cs_var_social_net_url'] : '';
                                    $social_font_awesome_color = isset($wp_rem_cs_var_options['wp_rem_cs_var_social_icon_color']) ? $wp_rem_cs_var_options['wp_rem_cs_var_social_icon_color'] : '';
                                    $display = 'block';
                                }
                            } else {
                                $val = isset($wp_rem_cs_var_options['options']) ? $value['options'] : '';
                                $std = isset($wp_rem_cs_var_options['id']) ? $value['id'] : '';
                                $display = 'block';
                                $network_list = isset($wp_rem_cs_var_options['wp_rem_cs_var_social_net_awesome']) ? $wp_rem_cs_var_options['wp_rem_cs_var_social_net_awesome'] : '';
                                $network_list_group = isset($wp_rem_cs_var_options['wp_rem_cs_var_social_net_awesome_group']) ? $wp_rem_cs_var_options['wp_rem_cs_var_social_net_awesome_group'] : '';
                                $social_net_tooltip = isset($wp_rem_cs_var_options['wp_rem_cs_var_social_net_tooltip']) ? $wp_rem_cs_var_options['wp_rem_cs_var_social_net_tooltip'] : '';
                                $social_net_icon_path = isset($wp_rem_cs_var_options['wp_rem_cs_var_social_icon_path_array']) ? $wp_rem_cs_var_options['wp_rem_cs_var_social_icon_path_array'] : '';
                                $social_net_url = isset($wp_rem_cs_var_options['wp_rem_cs_var_social_net_url']) ? $wp_rem_cs_var_options['wp_rem_cs_var_social_net_url'] : '';
                                $social_font_awesome_color = isset($wp_rem_cs_var_options['wp_rem_cs_var_social_icon_color']) ? $wp_rem_cs_var_options['wp_rem_cs_var_social_icon_color'] : '';
                            }



                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_network_name') . ' *',
                                'desc' => '',
                                'field_params' => array(
                                    'std' => '',
                                    'cust_id' => 'social_net_tooltip_input',
                                    'cust_name' => 'social_net_tooltip_input',
                                    'classes' => '',
                                    'return' => true,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_social_icon_url') . ' *',
                                'desc' => '',
                                'field_params' => array(
                                    'std' => '',
                                    'cust_id' => 'social_net_url_input',
                                    'cust_name' => 'social_net_url_input',
                                    'classes' => '',
                                    'return' => true,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_social_icon_image_choose_str'),
                                'id' => 'social_icon_input',
                                'std' => '',
                                'desc' => '',
                                'prefix' => '',
                                'field_params' => array(
                                    'std' => '',
                                    'id' => 'social_icon_input',
                                    'prefix' => '',
                                    'return' => true,
                                ),
                            );

                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);

                            $output .= '
							<div class="form-elements">  
								<div id="wp_rem_cs_var_infobox_networks' . $counter . '">
								  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<label>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_social_icon_choose_str') . '</label>';
                            $output .= '</div>                      
								  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">' . apply_filters( 'cs_icons_fields',"", "networks" . $counter, 'social_net_awesome_input') . '</div>
								</div>
							</div>';

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_color'),
                                'desc' => '',
                                'field_params' => array(
                                    'std' => '',
                                    'cust_id' => 'social_font_awesome_color',
                                    'cust_name' => 'social_font_awesome_color',
                                    'classes' => 'bg_color',
                                    'return' => true,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $output .= '<ul class="wp-rem-list-button-ul">
                                <li class="wp-rem-list-button">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                        <div class="input-element">
                                            <a href="javascript:void(0);" id="click-more" class="wp-rem-add-more cntrl-add-new-row add-social-icon-button" onclick="javascript:wp_rem_cs_var_add_social_icon(\'' . admin_url("admin-ajax.php") . '\')">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_add') . '</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>';


                            $output .= '<div class="wp-rem-list-wrap wp-rem-social-list-wrap wp-rem-parent-edit-wraper">
                    <ul class="wp-rem-list-layout">
                        <li class="wp-rem-list-label">
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <div class="element-label">
                                    <label>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon') . '</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="element-label">
                                    <label>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_network_name') . '</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="element-label">
                                    <label>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_social_icon_url') . '</label>
                                </div>
                            </div>
                        </li>';

                            $i = 0;
                            if ( is_array($network_list) ) {
                                foreach ( $network_list as $network ) {
                                    if ( isset($network_list[$i]) || isset($network_list[$i]) ) {

                                        $wp_rem_cs_rand_num = rand(123456, 987654);

                                        $output .= '<li class="wp-rem-list-item">';

                                        $output .= '<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                            <div class="input-element">
                                                <div class="input-holder">';
                                        if ( isset($network_list[$i]) && ! empty($network_list[$i]) ) {
                                            $output .= '<i  class="fa ' . $network_list[$i] . ' icon-2x"></i>';
                                        } else {
                                            $output.='<img width="50" src="' . esc_url($social_net_icon_path[$i]) . '">';
                                        }

                                        $output.='</div>
                                            </div>
                                        </div>';

                                        $output .= '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                            <div class="input-element">
                                                <div class="input-holder">';
                                        $output .= $social_net_tooltip[$i];
                                        $output.='</div>
                                            </div>
                                        </div>';


                                        $output .= '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="input-element">
                                                <div class="input-holder">';
                                        $output .= '<a href="#">' . $social_net_url[$i] . '</a>';
                                        $output.='</div>
                                            </div>
                                        </div>';

                                        $output .= '<a href="javascript:void(0);" class="wp-rem-remove wp-rem-parent-li-remove"><i class="icon-close2"></i></a>';
                                        $output .= '<a href="javascript:void(0);" class="wp-rem-edit wp-rem-parent-li-edit"><i class="icon-edit2"></i></a>';

                                        $output .= '<div class="parent-li-edit-div" style="display:none;">';
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_network_name'),
                                            'desc' => '',
                                            'field_params' => array(
                                                'std' => isset($social_net_tooltip[$i]) ? $social_net_tooltip[$i] : '',
                                                'cust_id' => 'social_net_tooltip' . $i,
                                                'cust_name' => 'wp_rem_cs_var_social_net_tooltip[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_social_icon_url'),
                                            'desc' => '',
                                            'field_params' => array(
                                                'std' => isset($social_net_url[$i]) ? $social_net_url[$i] : '',
                                                'cust_id' => 'social_net_url' . $i,
                                                'cust_name' => 'wp_rem_cs_var_social_net_url[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_social_icon_image_choose_str'),
                                            'id' => 'social_icon_path',
                                            'std' => isset($social_net_icon_path[$i]) ? $social_net_icon_path[$i] : '',
                                            'desc' => '',
                                            'hint_text' => '',
                                            'prefix' => '',
                                            'array' => true,
                                            'field_params' => array(
                                                'std' => isset($social_net_icon_path[$i]) ? $social_net_icon_path[$i] : '',
                                                'id' => 'social_icon_path',
                                                'prefix' => '',
                                                'array' => true,
                                                'return' => true,
                                            ),
                                        );

                                        $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);
                                        $wp_rem_cs_var_icon = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_social_icon_choose_str');
                                        $network_group  = isset( $network_list_group[$i] )? $network_list_group[$i] : 'default';
                                        $output .= '
                                                    <div class="form-elements">
                                                            <div id="wp_rem_cs_var_infobox_theme_options' . $i . '">
                                                              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                                    <label>' . $wp_rem_cs_var_icon . '</label>
                                                              </div>
                                                              <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                              
                                                                    ' . apply_filters( 'cs_icons_fields', $network_list[$i], "theme_options" . $i, 'wp_rem_cs_var_social_net_awesome', $network_group ) . '
                                                              </div>
                                                            </div>
                                                    </div>';

                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_color'),
                                            'desc' => '',
                                            'hint_text' => '',
                                            'field_params' => array(
                                                'std' => isset($social_font_awesome_color[$i]) ? $social_font_awesome_color[$i] : '',
                                                'cust_id' => 'social_font_awesome_color' . $i,
                                                'cust_name' => 'wp_rem_cs_var_social_icon_color[]',
                                                'classes' => 'bg_color',
                                                'return' => true,
                                            ),
                                        );
                                        $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                        $output .= '</div>';
                                        $output .= '</li>';
                                    }
                                    $i ++;
                                }
                            }


                            $output .= '</ul></div>';

                            break;




                        case "clients" :

                            if ( isset($wp_rem_cs_var_options) && $wp_rem_cs_var_options <> '' ) {

                                if ( ! isset($wp_rem_cs_var_options['wp_rem_cs_var_clients_image']) ) {
                                    $clients_list = '';
                                    $display = 'none';
                                } else {
                                    $clients_list = isset($wp_rem_cs_var_options['wp_rem_cs_var_clients_image_array']) ? $wp_rem_cs_var_options['wp_rem_cs_var_clients_image_array'] : '';
                                    $clients_title = isset($wp_rem_cs_var_options['wp_rem_clients_title']) ? $wp_rem_cs_var_options['wp_rem_clients_title'] : '';
                                    $clients_url = isset($wp_rem_cs_var_options['wp_rem_clients_url']) ? $wp_rem_cs_var_options['wp_rem_clients_url'] : '';
                                    $clients_images = isset($wp_rem_cs_var_options['wp_rem_cs_var_clients_image_array']) ? $wp_rem_cs_var_options['wp_rem_cs_var_clients_image_array'] : '';
                                    $display = 'block';
                                }
                            } else {
                                $val = isset($wp_rem_cs_var_options['options']) ? $value['options'] : '';
                                $std = isset($wp_rem_cs_var_options['id']) ? $value['id'] : '';
                                $display = 'block';
                                $clients_list = isset($wp_rem_cs_var_options['wp_rem_cs_var_clients_image_array']) ? $wp_rem_cs_var_options['wp_rem_cs_var_clients_image_array'] : '';
                                $clients_title = isset($wp_rem_cs_var_options['wp_rem_clients_title']) ? $wp_rem_cs_var_options['wp_rem_clients_title'] : '';
                                $clients_url = isset($wp_rem_cs_var_options['wp_rem_clients_url']) ? $wp_rem_cs_var_options['wp_rem_clients_url'] : '';
                                $clients_images = isset($wp_rem_cs_var_options['wp_rem_cs_var_clients_image_array']) ? $wp_rem_cs_var_options['wp_rem_cs_var_clients_image_array'] : '';
                            }

                            $output .= '<div class="social-area" style="display:' . $display . '">
                            <div class="theme-help">
                              <h4 style="padding-bottom:0px;">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_plugin_options_fields_clients') . '</h4>
                              <div class="clear"></div>
                            </div>';


                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_plugin_options_fields_enable_in_footer'),
                                'desc' => '',
                                'hint_text' => '',
                                'field_params' => array(
                                    'std' => isset($wp_rem_cs_var_options['wp_rem_cs_var_enable_clients']) ? $wp_rem_cs_var_options['wp_rem_cs_var_enable_clients'] : '',
                                    'id' => 'enable_clients',
                                    'classes' => '',
                                    'return' => true,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_checkbox_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_plugin_options_fields_client_footer_title'),
                                'desc' => '',
                                'hint_text' => '',
                                'field_params' => array(
                                    'std' => '',
                                    'cust_id' => 'clients_title',
                                    'cust_name' => 'clients_title',
                                    'classes' => '',
                                    'return' => true,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_plugin_options_fields_client_footer_url'),
                                'desc' => '',
                                'hint_text' => '',
                                'field_params' => array(
                                    'std' => '',
                                    'cust_id' => 'clients_url',
                                    'cust_name' => 'clients_url',
                                    'classes' => '',
                                    'return' => true,
                                ),
                            );
                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_plugin_options_fields_client_footer_logo'),
                                'id' => 'clients_image',
                                'std' => '',
                                'desc' => '',
                                'hint_text' => '',
                                'prefix' => '',
                                'field_params' => array(
                                    'std' => '',
                                    'id' => 'clients_image',
                                    'prefix' => '',
                                    'return' => true,
                                ),
                            );

                            $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);


                            $output .= '<ul class="wp-rem-list-button-ul">
                                <li class="wp-rem-list-button">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                        <div class="input-element">
                                            <a href="javascript:void(0);" id="click-more" class="wp-rem-add-more cntrl-add-new-row add-clients-button" onclick="javascript:wp_rem_cs_var_clients(\'' . admin_url("admin-ajax.php") . '\')">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_add') . '</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>';




                            $output .= '<div class="wp-rem-list-wrap wp-rem-clients-list-wrap wp-rem-parent-edit-wraper">
                            <ul class="wp-rem-list-layout">
                                <li class="wp-rem-list-label">
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <div class="element-label">
                                            <label>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_plugin_options_fields_client_footer_logo') . '</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <div class="element-label">
                                            <label>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_plugin_options_fields_client_footer_title') . '</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <div class="element-label">
                                            <label>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_plugin_options_fields_client_footer_url') . '</label>
                                        </div>
                                    </div>
                                </li>';

                            $i = 0;
                            if ( is_array($clients_list) ) {
                                foreach ( $clients_list as $client ) {
                                    if ( isset($clients_list[$i]) || isset($clients_list[$i]) ) {

                                        $wp_rem_cs_rand_num = rand(123456, 987654);

                                        $output .= '<li class="wp-rem-list-item">
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                            <div class="input-element">
                                                <div class="input-holder">';
                                        if ( isset($clients_images[$i]) && ! empty($clients_images[$i]) ) {
                                            $output.='<img width="50" src="' . esc_url($clients_images[$i]) . '">';
                                        }
                                        $output .= '</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                            <div class="input-element">
                                                <div class="input-holder">
                                                ' . $clients_title[$i] . '
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                            <div class="input-element">
                                                <div class="input-holder">
                                                <a href="#">' . $clients_url[$i] . '</a>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="wp-rem-remove wp-rem-parent-li-remove"><i class="icon-close2"></i></a>
                                        <a href="javascript:void(0);" class="wp-rem-edit wp-rem-parent-li-edit"><i class="icon-edit2"></i></a>';

                                        $output .= '<div class="parent-li-edit-div" style="display:none;">';

                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_plugin_options_fields_client_footer_title'),
                                            'desc' => '',
                                            'hint_text' => '',
                                            'field_params' => array(
                                                'std' => isset($clients_title[$i]) ? $clients_title[$i] : '',
                                                'cust_id' => 'clients_title' . $i,
                                                'cust_name' => 'wp_rem_clients_title[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_plugin_options_fields_client_footer_url'),
                                            'desc' => '',
                                            'hint_text' => '',
                                            'field_params' => array(
                                                'std' => isset($clients_url[$i]) ? $clients_url[$i] : '',
                                                'cust_id' => 'clients_url' . $i,
                                                'cust_name' => 'wp_rem_clients_url[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_plugin_options_fields_client_footer_logo'),
                                            'id' => 'clients_image',
                                            'std' => isset($clients_images[$i]) ? $clients_images[$i] : '',
                                            'desc' => '',
                                            'hint_text' => '',
                                            'prefix' => '',
                                            'array' => true,
                                            'field_params' => array(
                                                'std' => isset($clients_images[$i]) ? $clients_images[$i] : '',
                                                'id' => 'clients_image',
                                                'prefix' => '',
                                                'array' => true,
                                                'return' => true,
                                            ),
                                        );

                                        $output .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);


                                        $output .= '</div>';
                                        $output .= '</li>';
                                    }
                                    $i ++;
                                }
                            }

                            $output .= '</ul></div>';

                            $output .= '</div>';


                            break;
                    }
                }
            }

            return array( $output, $menu );
        }

    }

}
