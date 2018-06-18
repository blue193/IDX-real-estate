<?php
if (!class_exists('wp_rem_cs_var_widget_data')) {

    class wp_rem_cs_var_widget_data {

        static $export_page;
        static $import_page;

        /**
         * initialize
         */
        public function __construct() {
            if (!is_admin())
                return;

            add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueue_admin_scripts'));
            add_action('wp_ajax_export_widget_settings', array(__CLASS__, 'export_widget_settings'));
            add_action('wp_ajax_import_widget_data', array(__CLASS__, 'ajax_import_widget_data'));
            add_action('wp_ajax_import_settings_page', array(__CLASS__, 'import_settings_page'));
            add_action('wp_ajax_wp_rem_cs_widget_file_delete', array(__CLASS__, 'wp_rem_cs_widget_file_delete'));
        }

        private static function clear_widgets() {
            $sidebars = wp_get_sidebars_widgets();
            $inactive = isset($sidebars['wp_inactive_widgets']) ? $sidebars['wp_inactive_widgets'] : array();

            unset($sidebars['wp_inactive_widgets']);

            foreach ($sidebars as $sidebar => $widgets) {
                if (!is_array($widgets))
                    $widgets = array();
                $inactive = array_merge($inactive, $widgets);
                $sidebars[$sidebar] = array();
            }

            $sidebars['wp_inactive_widgets'] = $inactive;
            wp_set_sidebars_widgets($sidebars);
        }

        public static function enqueue_admin_scripts($hook) {

            wp_enqueue_script('widget_data', get_template_directory_uri() . '/assets/backend/js/cs-widget-data.js', '', '', true);
            wp_localize_script('widget_data', 'widgets_url', get_admin_url(false, 'widgets.php'));
        }

        /**
         * HTML for export admin page
         */
        public static function export_settings_page() {
            global $wp_rem_cs_var_static_text;
          
            
            $sidebar_widgets = self::order_sidebar_widgets(wp_get_sidebars_widgets());

            ob_start();
            ?>
            <div class="widget-data cs-export-widget-settings">
                <div id="cs-import-widget-loader"></div>
                <div class="cs-export-wrapper">
                    <div id="notifier" style="display: none;"></div>
                    <div id="cs-widget-export-form">
                        <div class="title">
                            <h3><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_widget_setting')); ?></h3>
                            <span class="cs-select-butns">
                                <a class="select-all"><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_select_all')); ?></a>
                                <a class="unselect-all"><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_unselect_all')); ?></a>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="sidebars">
                            <?php
                            foreach ($sidebar_widgets as $sidebar_name => $widget_list) :
                                if (empty($widget_list))
                                    continue;

                                $sidebar_info = self::get_sidebar_info($sidebar_name);
                                if (!empty($sidebar_info)):
                                    ?>
                                    <div class="sidebar">
                                        <h4><?php echo esc_html($sidebar_info['name']); ?></h4>

                                        <div class="widgets">
                                            <?php
                                            foreach ($widget_list as $widget) :

                                                $widget_type = trim(substr($widget, 0, strrpos($widget, '-')));
                                                $widget_type_index = trim(substr($widget, strrpos($widget, '-') + 1));
                                                $widget_options = get_option('widget_' . $widget_type);
                                                $widget_title = isset($widget_options[$widget_type_index]['title']) ? $widget_options[$widget_type_index]['title'] : $widget_type_index;
                                                ?>
                                                <div class="import-form-row">
                                                    <input class="<?php echo ($sidebar_name == 'wp_inactive_widgets') ? 'inactive' : 'active'; ?> widget-checkbox" type="checkbox" name="<?php echo esc_attr($widget); ?>" id="<?php echo esc_attr('meta_' . $widget); ?>" />
                                                    <label for="<?php echo esc_attr('meta_' . $widget); ?>">
                                                        <?php
                                                        echo ucfirst($widget_type);
                                                        if (!empty($widget_title))
                                                            echo ' - ' . $widget_title;
                                                        ?>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div> <!-- end widgets -->
                                    </div> <!-- end sidebar -->
                                <?php
                                endif;
                            endforeach;
                            ?>
                        </div> <!-- end sidebars -->
                        <input id="cs-export-wgts-btn" type="button" value="<?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_generate_widget_settings'); ?>"/>
                    </div>
                </div>
            </div> <!-- end export-widget-settings -->
            <?php
            $wp_rem_cs_output = ob_get_clean();
            return $wp_rem_cs_output;
        }

        /**
         * HTML for import admin page
         * @return type
         */
        public static function import_settings_page() {
            global $wp_rem_cs_var_static_text;
          

            if (!isset($_POST['file_name'])) {
                ob_start();
            }
            ?>

            <div class="widget-data import-widget-settings">
            <?php if (isset($_POST['file_name']) && $_POST['file_name'] != '') : ?>

                    <div id="notifier" style="display: none;"></div>
                    <div id="cs-import-widget-loader"></div>
                    <div class="cs-import-wrapper">

                        <div id="cs-import-widget-form">
                            <?php
                            $json = self::get_widget_settings_json();

                            if (is_wp_error($json))
                                wp_die($json->get_error_message());

                            if (!$json || !( $json_data = json_decode($json[0], true) ))
                                return;

                            $json_file = $json[1];
                            ?>
                            <input type="hidden" name="import_file" value="<?php echo esc_attr($json_file); ?>"/>
                            <div class="title">
                                <h3>Widget Setting Import</h3>
                                <span class="cs-select-butns">
                                    <a class="imp-select-all"><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_select_all')); ?></a>
                                    <a class="imp-unselect-all"><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_unselect_all')); ?></a>
                                </span>
                                <div class="clear"></div>
                            </div>
                            <div class="sidebars">
                                <?php
                                if (isset($json_data[0])) :
                                    foreach (self::order_sidebar_widgets($json_data[0]) as $sidebar_name => $widget_list) :
                                        if (count($widget_list) == 0) {
                                            continue;
                                        }
                                        $sidebar_info = self::get_sidebar_info($sidebar_name);
                                        if ($sidebar_info) :
                                            ?>
                                            <div class="sidebar">
                                                <h4><?php echo esc_html($sidebar_info['name']); ?></h4>

                                                <div class="widgets">
                                                    <?php
                                                    foreach ($widget_list as $widget) :
                                                        $widget_options = false;

                                                        $widget_type = trim(substr($widget, 0, strrpos($widget, '-')));
                                                        $widget_type_index = trim(substr($widget, strrpos($widget, '-') + 1));
                                                        foreach ($json_data[1] as $name => $option) {
                                                            if ($name == $widget_type) {
                                                                $widget_type_options = $option;
                                                                break;
                                                            }
                                                        }
                                                        if (!isset($widget_type_options) || !$widget_type_options)
                                                            continue;

                                                        $widget_title = isset($widget_type_options[$widget_type_index]['title']) ? $widget_type_options[$widget_type_index]['title'] : '';
                                                        $widget_options = $widget_type_options[$widget_type_index];
                                                        ?>
                                                        <div class="import-form-row">
                                                            <input class="<?php echo ($sidebar_name == 'wp_inactive_widgets') ? 'inactive' : 'active'; ?> widget-checkbox" type="checkbox" name="<?php echo esc_attr(printf('widgets[%s][%d]', $widget_type, $widget_type_index)); ?>" id="<?php echo esc_attr('meta_' . $widget); ?>" />
                                                            <label for="meta_<?php echo esc_attr('meta_' . $widget); ?>">&nbsp;
                                                                <?php
                                                                echo ucfirst($widget_type);
                                                                if (!empty($widget_title)) {
                                                                    echo ' - ' . $widget_title;
                                                                }
                                                                ?>
                                                            </label>
                                                        </div>
                            <?php endforeach; ?>
                                                </div> <!-- end widgets -->
                                            </div> <!-- end sidebar -->
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                <?php endif; ?>
                            </div> <!-- end sidebars -->
                            <p>
                                <input type="checkbox" name="clear_current" id="clear-current" checked=checked value="true" />
                                <label for="clear-current"><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_clear_current')); ?></label><br/>
                                <span class="description"><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_all_active')); ?></span>
                            </p>
                            <input type="button" name="import-widgets" id="cs-import-wgts-btn" value="Import Widget Settings" />
                        </div>
                    </div>
                    <?php
                else :
                    ?>
                    <p><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_put_file')); ?></p>
                    <p>
                        <input type="text" id="cs-widget-upload-file" />
                    </p>
                    <input type="button" id="widget-import-submit" class="button" value=<?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_show_widget_settings')); ?> />
            <?php endif; ?>
            </div> <!-- end import-widget-settings -->
            <?php
            if (isset($_POST['file_name'])) {
                die;
            } else {

                $wp_rem_cs_output = ob_get_clean();

                return $wp_rem_cs_output;
            }
        }

        /**
         * Retrieve widgets from sidebars and create JSON object
         * @param array $posted_array
         * @return string
         */
        public static function parse_export_data($posted_array) {
            $sidebars_array = get_option('sidebars_widgets');
            $sidebar_export = array();
            foreach ($sidebars_array as $sidebar => $widgets) {
                if (!empty($widgets) && is_array($widgets)) {
                    foreach ($widgets as $sidebar_widget) {
                        if (in_array($sidebar_widget, array_keys($posted_array))) {
                            $sidebar_export[$sidebar][] = $sidebar_widget;
                        }
                    }
                }
            }
            $widgets = array();
            foreach ($posted_array as $k => $v) {
                $widget = array();
                $widget['type'] = trim(substr($k, 0, strrpos($k, '-')));
                $widget['type-index'] = trim(substr($k, strrpos($k, '-') + 1));
                $widget['export_flag'] = ($v == 'on') ? true : false;
                $widgets[] = $widget;
            }
            $widgets_array = array();
            foreach ($widgets as $widget) {
                $widget_val = get_option('widget_' . $widget['type']);
                $widget_val = apply_filters('widget_data_export', $widget_val, $widget['type']);
                $multiwidget_val = $widget_val['_multiwidget'];
                $widgets_array[$widget['type']][$widget['type-index']] = isset($widget_val[$widget['type-index']]) ? $widget_val[$widget['type-index']] : '';
                if (isset($widgets_array[$widget['type']]['_multiwidget']))
                    unset($widgets_array[$widget['type']]['_multiwidget']);

                $widgets_array[$widget['type']]['_multiwidget'] = $multiwidget_val;
            }
            unset($widgets_array['export']);
            $export_array = array($sidebar_export, $widgets_array);
            $json = json_encode($export_array);
            return $json;
        }

        /**
         * Import widgets
         * @param array $import_array
         */
        public static function parse_import_data($import_array) {
            $sidebars_data = $import_array[0];
            $widget_data = $import_array[1];
            $current_sidebars = get_option('sidebars_widgets');

            $new_widgets = array();

            if (is_array($sidebars_data)) {
                foreach ($sidebars_data as $import_sidebar => $import_widgets) :

                    foreach ($import_widgets as $import_widget) :
                        //if the sidebar exists
                        if (isset($current_sidebars[$import_sidebar])) :
                            $title = trim(substr($import_widget, 0, strrpos($import_widget, '-')));
                            $index = trim(substr($import_widget, strrpos($import_widget, '-') + 1));
                            $current_widget_data = get_option('widget_' . $title);
                            $new_widget_name = self::get_new_widget_name($title, $index);
                            $new_index = trim(substr($new_widget_name, strrpos($new_widget_name, '-') + 1));

                            if (!empty($new_widgets[$title]) && is_array($new_widgets[$title])) {
                                while (array_key_exists($new_index, $new_widgets[$title])) {
                                    $new_index++;
                                }
                            }
                            $current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
                            if (array_key_exists($title, $new_widgets)) {
                                $new_widgets[$title][$new_index] = $widget_data[$title][$index];
                                $multiwidget = $new_widgets[$title]['_multiwidget'];
                                unset($new_widgets[$title]['_multiwidget']);
                                $new_widgets[$title]['_multiwidget'] = $multiwidget;
                            } else {
                                $current_widget_data[$new_index] = $widget_data[$title][$index];
                                $current_multiwidget = isset($current_widget_data['_multiwidget']) ? $current_widget_data['_multiwidget'] : false;
                                ;
                                $new_multiwidget = isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : false;
                                $multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
                                unset($current_widget_data['_multiwidget']);
                                $current_widget_data['_multiwidget'] = $multiwidget;
                                $new_widgets[$title] = $current_widget_data;
                            }

                        endif;
                    endforeach;
                endforeach;
            }

            if (isset($new_widgets) && isset($current_sidebars)) {
                update_option('sidebars_widgets', $current_sidebars);

                foreach ($new_widgets as $title => $content) {
                    $content = apply_filters('widget_data_import', $content, $title);
                    update_option('widget_' . $title, $content);
                }

                return true;
            }

            return false;
        }

        /**
         * Output the JSON for download
         */
        public static function export_widget_settings() {

            global $wp_filesystem,$wp_rem_cs_var_static_text;
            $strings = new wp_rem_cs_theme_all_strings;
            $strings->wp_rem_cs_theme_option_field_strings();
        

            if (isset($_POST['action']) && $_POST['action'] == 'export_widget_settings') {
                $backup_url = wp_nonce_url('themes.php?page=wp_rem_cs_options_page');
                if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {

                    return true;
                }

                if (!WP_Filesystem($creds)) {
                    request_filesystem_credentials($backup_url, '', true, false, array());
                    return true;
                }

               $wp_rem_cs_upload_dir = get_template_directory() . '/include/backend/cs-widgets/import/widgets-backup/';
               
                $wp_rem_cs_filename = trailingslashit($wp_rem_cs_upload_dir) . 'widget_' . (current_time('d-M-Y_H.i.s')) . '.json';

                $wp_rem_cs_widgets_file = self::parse_export_data($_POST);

                if (!$wp_filesystem->put_contents($wp_rem_cs_filename, $wp_rem_cs_widgets_file, FS_CHMOD_FILE)) {
                    echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_error_saving_file'));
                } else {
                    echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_backup_generated'));
                }
            }
            die;
        }

        public static function wp_rem_cs_widget_file_delete() {

            global $wp_filesystem,$wp_rem_cs_var_static_text;
            $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_theme_option_field_strings();
            $wp_rem_cs_var_file_deleted_successfully = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_file_deleted_successfully');
            
            $backup_url = wp_nonce_url('themes.php?page=wp_rem_cs_options_page');
            if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {

                return true;
            }

            if (!WP_Filesystem($creds)) {
                request_filesystem_credentials($backup_url, '', true, false, array());
                return true;
            }

            $wp_rem_cs_upload_dir = get_template_directory() . '/include/backend/cs-widgets/import/widgets-backup/';

            $file_name = isset($_POST['file_name']) ? $_POST['file_name'] : '';

            $wp_rem_cs_filename = trailingslashit($wp_rem_cs_upload_dir) . $file_name;

            if (is_file($wp_rem_cs_filename)) {
                unlink($wp_rem_cs_filename);
                printf($wp_rem_cs_var_file_deleted_successfully, $file_name);
            } else {
                echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_error_deleting_file'));
            }

            die();
        }

        /**
         * Parse JSON import file and load
         */
        public static function ajax_import_widget_data() {
            $response = array(
                'what' => 'widget_import_export',
                'action' => 'import_submit'
            );

            $widgets = isset($_POST['widgets']) ? $_POST['widgets'] : false;
            $import_file = isset($_POST['import_file']) ? $_POST['import_file'] : false;

            if (empty($widgets) || empty($import_file)) {
                $response['id'] = new WP_Error('import_widget_data', 'No widget data posted to import');
                $response = new WP_Ajax_Response($response);
                $response->send();
            }

            $clear_current = isset($_POST['clear_current']);

            if ($clear_current)
                self::clear_widgets();

            global $wp_filesystem;
            if (empty($wp_filesystem)) {
                wp_rem_cs_include_file(ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }
            $json_data = $wp_filesystem->get_contents($import_file);
            $json_data = json_decode($json_data, true);
            $sidebar_data = $json_data[0];
            $widget_data = $json_data[1];

            foreach ($sidebar_data as $title => $sidebar) {
                $count = count($sidebar);
                for ($i = 0; $i < $count; $i++) {
                    $widget = array();
                    $widget['type'] = trim(substr($sidebar[$i], 0, strrpos($sidebar[$i], '-')));
                    $widget['type-index'] = trim(substr($sidebar[$i], strrpos($sidebar[$i], '-') + 1));
                    if (!isset($widgets[$widget['type']][$widget['type-index']])) {
                        unset($sidebar_data[$title][$i]);
                    }
                }
                $sidebar_data[$title] = array_values($sidebar_data[$title]);
            }

            foreach ($widgets as $widget_title => $widget_value) {
                foreach ($widget_value as $widget_key => $widget_value) {
                    $widgets[$widget_title][$widget_key] = $widget_data[$widget_title][$widget_key];
                }
            }

            update_option('sidebars_widgets', $sidebar_data);

            $sidebar_data = array(array_filter($sidebar_data), $widgets);

            $response['id'] = ( self::parse_import_data($sidebar_data) ) ? true : new WP_Error('widget_import_submit', 'Unknown Error');

            $response = new WP_Ajax_Response($response);
            $response->send();
        }

        /**
         * Pick File and Load Widget settings
         */
        public static function wp_rem_cs_import_widget_data( $filename = "" ) {

            global $wp_filesystem,$wp_rem_cs_var_static_text;
            

            $backup_url = wp_nonce_url('themes.php');
            if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {

                return true;
            }

            if (!WP_Filesystem($creds)) {
                request_filesystem_credentials($backup_url, '', true, false, array());
                return true;
            }
			if ( $filename == "" ) {
				$wp_rem_cs_upload_dir = get_template_directory() . '/include/backend/cs-widgets/import/import-widgets/';

				$file_name = 'import-widgets.json';

				$import_file = trailingslashit($wp_rem_cs_upload_dir) . $file_name;
			} else {
				$import_file = $filename;
			}
            self::clear_widgets();

            global $wp_filesystem;
            if (empty($wp_filesystem)) {
                wp_rem_cs_include_file(ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }
            $json_data = $wp_filesystem->get_contents($import_file);
            $json_data = json_decode($json_data, true);
            $sidebar_data = $json_data[0];
            $widget_data = $json_data[1];

            $widgets = $widget_data;

            if (is_array($widgets)) {
                foreach ($widgets as $widget_title => $widget_value) {
                    foreach ($widget_value as $widget_key => $widget_value) {
                        $widgets[$widget_title][$widget_key] = $widget_data[$widget_title][$widget_key];
                    }
                }
            }

            if (is_array($sidebar_data)) {
                update_option('sidebars_widgets', $sidebar_data);

                $sidebar_data = array(array_filter($sidebar_data), $widgets);

                self::parse_import_data($sidebar_data);

                echo '<p><strong>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_widget_imported') . '</strong><br />';
            } else {
                echo '<p><strong>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_widget_not') . '</strong><br />';
            }
        }

        /**
         * Read uploaded JSON file
         * @return type
         */
        public static function get_widget_settings_json() {
            $widget_settings = self::upload_widget_settings_file();

            if (is_wp_error($widget_settings) || !$widget_settings)
                return false;

            if (isset($widget_settings['error']))
                return new WP_Error('widget_import_upload_error', $widget_settings['error']);

            global $wp_filesystem;
            if (empty($wp_filesystem)) {
                wp_rem_cs_include_file(ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }
            $file_contents = $wp_filesystem->get_contents($widget_settings);
            return array($file_contents, $widget_settings);
        }

        /**
         * Upload JSON file
         * @return boolean
         */
        public static function upload_widget_settings_file() {
            if (isset($_POST['file_name'])) {

                $upload = $_POST['file_name'];
                return $upload;
            }

            return false;
        }

        /**
         *
         * @param string $widget_name
         * @param string $widget_index
         * @return string
         */
        public static function get_new_widget_name($widget_name, $widget_index) {
            $current_sidebars = get_option('sidebars_widgets');
            $all_widget_array = array();
            foreach ($current_sidebars as $sidebar => $widgets) {
                if (!empty($widgets) && is_array($widgets) && $sidebar != 'wp_inactive_widgets') {
                    foreach ($widgets as $widget) {
                        $all_widget_array[] = $widget;
                    }
                }
            }
            while (in_array($widget_name . '-' . $widget_index, $all_widget_array)) {
                $widget_index++;
            }
            $new_widget_name = $widget_name . '-' . $widget_index;
            return $new_widget_name;
        }

        /**
         *
         * @global type $wp_registered_sidebars
         * @param type $sidebar_id
         * @return boolean
         */
        public static function get_sidebar_info($sidebar_id) {
            global $wp_registered_sidebars;

            //since wp_inactive_widget is only used in widgets.php

            foreach ($wp_registered_sidebars as $sidebar) {
                if (isset($sidebar['id']) && $sidebar['id'] == $sidebar_id)
                    return $sidebar;
            }

            return false;
        }

        /**
         *
         * @param array $sidebar_widgets
         * @return type
         */
        public static function order_sidebar_widgets($sidebar_widgets) {
            $inactive_widgets = false;

            //seperate inactive widget sidebar from other sidebars so it can be moved to the end of the array, if it exists
            if (isset($sidebar_widgets['wp_inactive_widgets'])) {
                $inactive_widgets = $sidebar_widgets['wp_inactive_widgets'];
                unset($sidebar_widgets['wp_inactive_widgets']);
                $sidebar_widgets['wp_inactive_widgets'] = $inactive_widgets;
            }

            return $sidebar_widgets;
        }

        /**
         * Add mime type for JSON
         * @param array $existing_mimes
         * @return string
         */
        public static function json_upload_mimes($existing_mimes = array()) {
            $existing_mimes['json'] = 'application/json';
            return $existing_mimes;
        }

    }

}

$wp_rem_cs_var_widget_data = new wp_rem_cs_var_widget_data();
