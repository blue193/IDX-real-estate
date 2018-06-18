<?php

/**
 * File Type: Icons Fields
 */
if ( ! class_exists('CS_Icons_Fields') ) {

    class CS_Icons_Fields {

        /**
         * Start construct Functions
         */
        public function __construct() {
            //add_action('cs_icons_fields', array( $this, 'cs_icons_fields_callback' ), 10, 3 );
            add_filter('cs_icons_fields', array( $this, 'cs_icons_fields_callback' ), 10, 5 );
            add_action('wp_ajax_cs_library_icons_list', array( $this, 'cs_library_icons_list_callback' ));
        }

        /*
         * Render Icons Fields
         */

        public function cs_icons_fields_callback( $icon_value = '', $id = '', $name = '', $icons_library = 'default', $group_field_name = '' ) {
            global $cs_icons_form_fields;
            $group_name  = $icons_library;
            $output = '';
            $group_field_name   = ( $group_field_name != '' )? $group_field_name : esc_html($name) . '_group[]';
            ob_start();
            $icons_groups = get_option('cs_icons_groups');
            if( !empty( $icons_groups ) ){
                foreach( $icons_groups  as $icon_key => $icon_obj ){
                    if( isset( $icon_obj['status'] ) && $icon_obj['status'] == 'on' ){
                        $icons_groups_array[$icon_key]  = ucwords( $icon_key );
                    }
                }
            }
            echo '<div class="cs-icon-choser" data-id="' . $id . '" data-name="' . $name . '" data-value="' . $icon_value . '">';
                
                $group_obj = $icons_groups[$group_name];
            
                echo '<div class="cs-library-icons-list">';
                    echo $this->cs_icomoon_icons_box( $group_obj['url'], $group_name, $icon_value, $id, $name );
                echo '</div>';
                
                $cs_icons_opt_array = array(
                    //'name' => cs_icons_manager_text_srt('cs_icons_manager_icon_library'),
                        'std' => $group_name,
                        'id' => 'cs_icon_library',
                        'cust_name' => $group_field_name,
                        'classes' => 'chosen-select-no-single chosen-select cs-icon-library',
                        'options' => $icons_groups_array,
                        'return' => true,
                );

                echo $cs_icons_form_fields->cs_icons_form_select_render($cs_icons_opt_array);
            echo '</div>';
            $output = ob_get_clean();
            
            return $output;
        }
        
        /*
         * Load Icons by Library
         */
        public function cs_library_icons_list_callback(){
            $icons_groups = get_option('cs_icons_groups');
            $id  = isset( $_POST['id'] )? $_POST['id'] : '';
            $name  = isset( $_POST['name'] )? $_POST['name'] : '';
            $icon_value  = isset( $_POST['value'] )? $_POST['value'] : '';
            $icons_library  = isset( $_POST['icons_library'] )? $_POST['icons_library'] : 'default';
            $group_obj = $icons_groups[$icons_library];
            echo $this->cs_icomoon_icons_box( $group_obj['url'], $icons_library, $icon_value, $id, $name );
            wp_die();
        }
        
        public function cs_icomoon_icons_box($selection_path = '', $icons_library = 'default', $icon_value = '', $id = '', $name = '') {
            global $cs_icons_form_fields;
            $cs_icons_cs_var_icomoon = '';
            $cs_icons_cs_var_icomoon .= '
                    <script>
                    jQuery(document).ready(function ($) {
                            var e9_element = $(\'#e9_element_' . esc_html($id) . '\').fontIconPicker({
                                    theme: \'fip-bootstrap\'
                            });
                            // Add the event on the button
                            $(\'#e9_buttons_' . esc_html($id) . ' button\').on(\'click\', function (e) {
                                    e.preventDefault();
                                    // Show processing message
                                    $(this).prop(\'disabled\', true).html(\'<i class="icon-cog demo-animate-spin"></i> ' . cs_icons_manager_text_srt('cs_icons_cs_var_wait') . '\');
                                    $.ajax({
                                            url: "' . $selection_path . '/selection.json",
                                            type: \'GET\',
                                            dataType: \'json\'
                                    }).done(function (response) {
                                                    // Get the class prefix
                                                    var classPrefix = response.preferences.fontPref.prefix,
                                                        icomoon_json_icons = [],
                                                        icomoon_json_search = [];
                                                        $.each(response.icons, function (i, v) {
                                                        icomoon_json_icons.push(classPrefix + v.properties.name);
                                                        if (v.icon && v.icon.tags && v.icon.tags.length) {
                                                            icomoon_json_search.push(v.properties.name + \' \' + v.icon.tags.join(\' \'));
                                                        } else {
                                                            icomoon_json_search.push(v.properties.name);
                                                        }
                                                    });
                                                    // Set new fonts on fontIconPicker
                                                    e9_element.setIcons(icomoon_json_icons, icomoon_json_search);
                                                    // Show success message and disable
                                                    $(\'#e9_buttons_' . esc_html($id) . ' button\').removeClass(\'btn-primary\').addClass(\'btn-success\').text(\'' . cs_icons_manager_text_srt('cs_icons_cs_var_load_icon') . '\').prop(\'disabled\', true);
                                    })
                                    .fail(function () {
                                                    // Show error message and enable
                                                    $(\'#e9_buttons_' . esc_html($id) . ' button\').removeClass(\'btn-primary\').addClass(\'btn-danger\').text(\'' . cs_icons_manager_text_srt('cs_icons_cs_var_try_again') . '\').prop(\'disabled\', false);
                                    });
                                    e.stopPropagation();
                            });
                            jQuery("#e9_buttons_' . esc_html($id) . ' button").click();
                    });
                    </script>';

            $cs_icons_cs_opt_array = array(
                'std' => esc_html($icon_value),
                'cust_id' => 'e9_element_' . esc_html($id),
                'cust_name' => esc_html($name) . '[]',
                'classes' => 'cs-icon-chose-input',
                'return' => true,
            );
            $cs_icons_cs_var_icomoon .= $cs_icons_form_fields->cs_icons_form_text_render($cs_icons_cs_opt_array);
            $cs_icons_cs_var_icomoon .= '
            <span id="e9_buttons_' . esc_html($id) . '" style="display:none">
                <button autocomplete="off" type="button" class="btn btn-primary">' . cs_icons_manager_text_srt('cs_icons_cs_var_load_json') . '</button>
            </span>';

            return $cs_icons_cs_var_icomoon;
        }

    }

    global $cs_icons_fields;
    $cs_icons_fields = new CS_Icons_Fields();
}