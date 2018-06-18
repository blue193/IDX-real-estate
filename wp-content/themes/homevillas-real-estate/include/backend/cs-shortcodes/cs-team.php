<?php
/*
 *
 * @Shortcode Name : Team
 * @retrun
 *
 * 
 */
if ( ! function_exists('wp_rem_cs_var_page_builder_team') ) {

    function wp_rem_cs_var_page_builder_team($die = 0) {
        global $wp_rem_cs_node, $count_node, $post, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $wp_rem_cs_counter = $_POST['counter'];
        $team_num = 0;
        if ( isset($_POST['action']) && ! isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'wp_rem_cs_team|wp_rem_cs_team_item';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'wp_rem_cs_var_team_title' => '',
            'wp_rem_cs_var_team_subtitle' => '',
            'wp_rem_cs_var_team_col' => '',
            'wp_rem_cs_var_team_views' => '',
            'wp_rem_var_team_align' => '',
			'team_counter' => '',
        );
        if ( isset($output['0']['atts']) ) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        if ( isset($output['0']['content']) ) {
            $atts_content = $output['0']['content'];
        } else {
            $atts_content = array();
        }
        if ( is_array($atts_content) ) {
            $team_num = count($atts_content);
        }
        $team_element_size = '25';
        foreach ( $defaults as $key => $values ) {
            if ( isset($atts[$key]) ) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'wp_rem_cs_var_page_builder_team';
        $coloumn_class = 'column_' . $team_element_size;
        $wp_rem_cs_var_team_title = isset($wp_rem_cs_var_team_title) ? $wp_rem_cs_var_team_title : '';
        $wp_rem_cs_var_team_col = isset($wp_rem_cs_var_team_col) ? $wp_rem_cs_var_team_col : '';
        $wp_rem_cs_var_team_views = isset($wp_rem_cs_var_team_views) ? $wp_rem_cs_var_team_views : '';
        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        global $wp_rem_cs_var_static_text;
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        $strings->wp_rem_cs_theme_option_field_strings();
		
        ?>
        <div id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo wp_rem_cs_allow_special_char($coloumn_class); ?> <?php echo wp_rem_cs_allow_special_char($shortcode_view); ?>" item="team" data="<?php echo wp_rem_cs_element_size_data_array_index($team_element_size) ?>" >
            <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $team_element_size, '', 'comments-o', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter) ?> <?php echo wp_rem_cs_allow_special_char($shortcode_element); ?>" id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_edit_options')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>','<?php echo wp_rem_cs_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a>
                </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>" data-shortcode-template="{{child_shortcode}} [/wp_rem_cs_team]" data-shortcode-child-template="[wp_rem_cs_team_item {{attributes}}] {{content}} [/wp_rem_cs_team_item]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[wp_rem_cs_team {{attributes}}]">
                                <?php
                                if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
                                    wp_rem_cs_shortcode_element_size();
                                }
								$wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => wp_rem_cs_allow_special_char($wp_rem_cs_var_team_title),
                                        'id' => 'team_title' . $wp_rem_cs_counter,
                                        'cust_name' => 'wp_rem_cs_var_team_title[]',
                                        'classes' => '',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_subtitle'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_subtitle_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_var_team_subtitle),
                                        'classes' => '',
                                        'cust_name' => 'wp_rem_cs_var_team_subtitle[]',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);


                                $wp_rem_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_var_title_alignment'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_var_title_alignment_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $wp_rem_var_team_align,
                                        'id' => '',
                                        'cust_id' => 'wp_rem_var_team_align',
                                        'cust_name' => 'wp_rem_var_team_align[]',
                                        'classes' => 'service_postion chosen-select-no-single select-medium',
                                        'options' => array(
                                            'align-left' => wp_rem_cs_var_theme_text_srt('wp_rem_var_align_left'),
                                            'align-right' => wp_rem_cs_var_theme_text_srt('wp_rem_var_align_right'),
                                            'align-center' => wp_rem_cs_var_theme_text_srt('wp_rem_var_align_center'),
                                        ),
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_opt_array);

                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_views'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_views_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $wp_rem_cs_var_team_views,
                                        'id' => 'team_view',
                                        'cust_name' => 'wp_rem_cs_var_team_views[]',
                                        'classes' => 'dropdown chosen-select',
                                        'extra_atr' => ' onchange="javascript:wp_rem_team_small(this.value)"',
                                        'options' => array(
											'small' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_small'),
                                            'medium' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_medium'),
                                            'grid' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_grid'),
											'classic' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_classic'),
											'grid-classic' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_grid_classic'),
											'grid-classic-slider' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_grid_classic_with_slider'),
                                        ),
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);


                                $style_modern = '';
                                if ( $wp_rem_cs_var_team_views == 'small' ) {
                                    $style_modern = ' style="display:none;" ';
                                }
                                echo '<div class="small-hide-show" ' . $style_modern . '>';
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_col'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sel_col_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $wp_rem_cs_var_team_col,
                                        'id' => '',
                                        'cust_name' => 'wp_rem_cs_var_team_col[]',
                                        'classes' => 'dropdown chosen-select',
                                        'options' => array(
                                            '1' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_one_col'),
                                            '2' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_two_col'),
                                            '3' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_three_col'),
                                            '4' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_four_col'),
                                            '6' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_six_col'),
                                        ),
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                                echo '</div>';
                                ?>
                            </div>
                            <?php
                            if ( isset($team_num) && $team_num <> '' && isset($atts_content) && is_array($atts_content) ) {
                                foreach ( $atts_content as $team ) {
                                    $rand_id = rand(3333, 99999);
                                    $wp_rem_cs_var_team_text = $team['content'];
                                    $defaults = array(
                                        'wp_rem_cs_var_team_name' => '',
                                        'wp_rem_cs_var_team_designation' => '',
                                        'wp_rem_cs_var_team_image' => '',
                                        'wp_rem_cs_var_team_link' => '',
                                        'wp_rem_cs_var_team_email' => '',
                                        'wp_rem_cs_var_team_facebook' => '',
                                        'wp_rem_cs_var_team_twitter' => '',
                                        'wp_rem_cs_var_team_linkedin' => '',
                                        'wp_rem_cs_var_team_phone' => '',
                                    );
                                    foreach ( $defaults as $key => $values ) {
                                        if ( isset($team['atts'][$key]) )
                                            $$key = $team['atts'][$key];
                                        else
                                            $$key = $values;
                                    }
                                    $wp_rem_cs_var_team_name = isset($wp_rem_cs_var_team_name) ? $wp_rem_cs_var_team_name : '';
                                    $wp_rem_cs_var_team_designation = isset($wp_rem_cs_var_team_designation) ? $wp_rem_cs_var_team_designation : '';
                                    $wp_rem_cs_var_team_link = isset($wp_rem_cs_var_team_link) ? $wp_rem_cs_var_team_link : '';
                                    $wp_rem_cs_var_team_image = isset($wp_rem_cs_var_team_image) ? $wp_rem_cs_var_team_image : '';
                                    $wp_rem_cs_var_team_email = isset($wp_rem_cs_var_team_email) ? $wp_rem_cs_var_team_email : '';
                                    $wp_rem_cs_var_team_facebook = isset($wp_rem_cs_var_team_facebook) ? $wp_rem_cs_var_team_facebook : '';
                                    $wp_rem_cs_var_team_twitter = isset($wp_rem_cs_var_team_twitter) ? $wp_rem_cs_var_team_twitter : '';
                                    $wp_rem_cs_var_team_linkedin = isset($wp_rem_cs_var_team_linkedin) ? $wp_rem_cs_var_team_linkedin : '';
                                    $wp_rem_cs_var_team_phone = isset($wp_rem_cs_var_team_phone) ? $wp_rem_cs_var_team_phone : '';
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp  cs-pbwp-content'  id="wp_rem_cs_infobox_<?php echo wp_rem_cs_allow_special_char($rand_id); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc')); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_remove')); ?></a>
                                        </header>
                                        <?php
                                        echo '<div class="small-hide-show" ' . $style_modern . '>';
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_name'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_name_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($wp_rem_cs_var_team_name),
                                                'id' => 'team_name' . $wp_rem_cs_counter,
                                                'cust_name' => 'wp_rem_cs_var_team_name[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_designation'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_designation_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($wp_rem_cs_var_team_designation),
                                                'id' => 'team_designation' . $wp_rem_cs_counter,
                                                'cust_name' => 'wp_rem_cs_var_team_designation[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                        echo '</div>';

                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_link'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_link_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($wp_rem_cs_var_team_link),
                                                'id' => 'team_link' . $wp_rem_cs_counter,
                                                'cust_name' => 'wp_rem_cs_var_team_link[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                        echo '<div class="small-hide-show" ' . $style_modern . '>';
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_email'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_email_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($wp_rem_cs_var_team_email),
                                                'id' => 'wp_rem_cs_var_team_email' . $wp_rem_cs_counter,
                                                'cust_name' => 'wp_rem_cs_var_team_email[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_phone'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_phone_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($wp_rem_cs_var_team_phone),
                                                'id' => 'wp_rem_cs_var_team_phone' . $wp_rem_cs_counter,
                                                'cust_name' => 'wp_rem_cs_var_team_phone[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_fb'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_fb_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($wp_rem_cs_var_team_facebook),
                                                'id' => 'wp_rem_cs_var_team_facebook' . $wp_rem_cs_counter,
                                                'cust_name' => 'wp_rem_cs_var_team_facebook[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_twitter'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_twitter_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($wp_rem_cs_var_team_twitter),
                                                'id' => 'wp_rem_cs_var_team_twitter' . $wp_rem_cs_counter,
                                                'cust_name' => 'wp_rem_cs_var_team_twitter[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_linkedin'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_linkedin_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($wp_rem_cs_var_team_linkedin),
                                                'id' => 'wp_rem_cs_var_team_linkedin' . $wp_rem_cs_counter,
                                                'cust_name' => 'wp_rem_cs_var_team_linkedin[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                        echo '</div>';
                                        $wp_rem_cs_opt_array = array(
                                            'std' => $wp_rem_cs_var_team_image,
                                            'id' => 'team_image_array',
                                            'main_id' => 'team_image_array',
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_image'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_image_hint'),
                                            'echo' => true,
                                            'array' => true,
                                            'field_params' => array(
                                                'std' => $wp_rem_cs_var_team_image,
                                                'cust_id' => '',
                                                'cust_name' => 'wp_rem_cs_var_team_image[]',
                                                'id' => 'team_image_array',
                                                'return' => true,
                                                'array' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);
                                        echo '<div class="small-hide-show" ' . $style_modern . '>';
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_content'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_content_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => wp_rem_cs_allow_special_char($wp_rem_cs_var_team_text),
                                                'id' => 'team_text',
                                                'cust_name' => 'wp_rem_cs_var_team_text[]',
                                                'extra_atr' => ' data-content-text="cs-shortcode-textarea"',
                                                'return' => true,
                                                'classes' => '',
                                                'wp_rem_cs_editor' => true
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                                        echo '</div>';
                                        ?>
                                        <script>
                                            function wp_rem_team_small(view) {
                                                if (view == 'medium') {
                                                    $('.small-hide-show').show();
                                                } else if (view == 'grid') {
                                                    $('.small-hide-show').show();
                                                } else if (view == 'small') {
                                                    $('.small-hide-show').hide();
                                                }
                                            }
                                        </script>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="hidden-object">
                            <?php
                            $wp_rem_cs_opt_array = array(
                                'std' => $team_num,
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => 'fieldCounter',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'team_num[]',
                                'return' => false,
                                'required' => false
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
                            ?>
                        </div>
                        <div class="wrapptabbox">
                            <div class="opt-conts">
                                <ul class="form-elements noborder">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_servicesss cs-main-btn" onclick="wp_rem_cs_shortcode_element_ajax_call('team', 'shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>', '<?php echo wp_rem_cs_allow_special_char(admin_url('admin-ajax.php')); ?>')"><i class="icon-plus-circle"></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_add_item')); ?></a> </li>
                                    <div id="loading" class="shortcodeload"></div>
                                </ul>
                                <?php if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) { ?>
                                    <ul class="form-elements insert-bg">
                                        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo esc_js(str_replace('wp_rem_cs_var_page_builder_', '', $name)); ?>', 'shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>', '<?php echo wp_rem_cs_allow_special_char($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a> </li>
                                    </ul>
                                    <div id="results-shortocde"></div>
                                    <?php
                                } else {
                                    $wp_rem_cs_opt_array = array(
                                        'std' => 'team',
                                        'id' => '',
                                        'before' => '',
                                        'after' => '',
                                        'classes' => '',
                                        'extra_atr' => '',
                                        'cust_id' => '',
                                        'cust_name' => 'wp_rem_cs_orderby[]',
                                        'return' => false,
                                        'required' => false
                                    );
                                    $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
                                    $wp_rem_cs_opt_array = array(
                                        'name' => '',
                                        'desc' => '',
                                        'hint_text' => '',
                                        'echo' => true,
                                        'field_params' => array(
                                            'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_save'),
                                            'cust_id' => '',
                                            'cust_type' => 'button',
                                            'classes' => 'cs-admin-btn',
                                            'cust_name' => '',
                                            'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                            'return' => true,
                                        ),
                                    );
                                    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if ( $die <> 1 ) {
            die();
        }
        ?>
        <?php
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_team', 'wp_rem_cs_var_page_builder_team');
}

if ( ! function_exists('wp_rem_cs_save_page_builder_data_team_callback') ) {

    /**
     * Save data for team shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_team_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		$shortcode_data = '';
        if ( $widget_type == "team" || $widget_type == "cs_team" ) {
            $shortcode = $shortcode_item = '';
            $page_element_size = $data['team_element_size'][$counters['wp_rem_cs_global_counter_team']];
            $team_element_size = $data['team_element_size'][$counters['wp_rem_cs_global_counter_team']];
            if ( isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
                $shortcode_str = stripslashes($data['shortcode']['team'][$counters['wp_rem_cs_shortcode_counter_team']]);
                $element_settings = 'team_element_size="' . $team_element_size . '"';
                $reg = '/team_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_team'] ++;
            } else {
                if ( isset($data['team_num'][$counters['wp_rem_cs_counter_team']]) && $data['team_num'][$counters['wp_rem_cs_counter_team']] > 0 ) {
                    for ( $i = 1; $i <= $data['team_num'][$counters['wp_rem_cs_counter_team']]; $i ++ ) {
                        $shortcode_item .= '[wp_rem_cs_team_item ';
                        if ( isset($data['wp_rem_cs_var_team_name'][$counters['wp_rem_cs_counter_team_node']]) && $data['wp_rem_cs_var_team_name'][$counters['wp_rem_cs_counter_team_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_team_name="' . htmlspecialchars($data['wp_rem_cs_var_team_name'][$counters['wp_rem_cs_counter_team_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_var_team_designation'][$counters['wp_rem_cs_counter_team_node']]) && $data['wp_rem_cs_var_team_designation'][$counters['wp_rem_cs_counter_team_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_team_designation="' . htmlspecialchars($data['wp_rem_cs_var_team_designation'][$counters['wp_rem_cs_counter_team_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_var_team_link'][$counters['wp_rem_cs_counter_team_node']]) && $data['wp_rem_cs_var_team_link'][$counters['wp_rem_cs_counter_team_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_team_link="' . htmlspecialchars($data['wp_rem_cs_var_team_link'][$counters['wp_rem_cs_counter_team_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_var_team_email'][$counters['wp_rem_cs_counter_team_node']]) && $data['wp_rem_cs_var_team_email'][$counters['wp_rem_cs_counter_team_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_team_email="' . htmlspecialchars($data['wp_rem_cs_var_team_email'][$counters['wp_rem_cs_counter_team_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_var_team_facebook'][$counters['wp_rem_cs_counter_team_node']]) && $data['wp_rem_cs_var_team_facebook'][$counters['wp_rem_cs_counter_team_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_team_facebook="' . htmlspecialchars($data['wp_rem_cs_var_team_facebook'][$counters['wp_rem_cs_counter_team_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_var_team_twitter'][$counters['wp_rem_cs_counter_team_node']]) && $data['wp_rem_cs_var_team_twitter'][$counters['wp_rem_cs_counter_team_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_team_twitter="' . htmlspecialchars($data['wp_rem_cs_var_team_twitter'][$counters['wp_rem_cs_counter_team_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_var_team_linkedin'][$counters['wp_rem_cs_counter_team_node']]) && $data['wp_rem_cs_var_team_linkedin'][$counters['wp_rem_cs_counter_team_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_team_linkedin="' . htmlspecialchars($data['wp_rem_cs_var_team_linkedin'][$counters['wp_rem_cs_counter_team_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_var_team_phone'][$counters['wp_rem_cs_counter_team_node']]) && $data['wp_rem_cs_var_team_phone'][$counters['wp_rem_cs_counter_team_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_team_phone="' . htmlspecialchars($data['wp_rem_cs_var_team_phone'][$counters['wp_rem_cs_counter_team_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_var_team_image'][$counters['wp_rem_cs_counter_team_node']]) && $data['wp_rem_cs_var_team_image'][$counters['wp_rem_cs_counter_team_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_team_image="' . htmlspecialchars($data['wp_rem_cs_var_team_image'][$counters['wp_rem_cs_counter_team_node']], ENT_QUOTES) . '" ';
                        }
                        $shortcode_item .= ']';
                        if ( isset($data['wp_rem_cs_var_team_text'][$counters['wp_rem_cs_counter_team_node']]) && $data['wp_rem_cs_var_team_text'][$counters['wp_rem_cs_counter_team_node']] != '' ) {
                            $shortcode_item .= htmlspecialchars($data['wp_rem_cs_var_team_text'][$counters['wp_rem_cs_counter_team_node']], ENT_QUOTES);
                        }
                        $shortcode_item .= '[/wp_rem_cs_team_item]';
                        $counters['wp_rem_cs_counter_team_node'] ++;
                    }
                }
                $section_title = '';
				if ( isset($data['wp_rem_cs_var_team_title'][$counters['wp_rem_cs_counter_team']]) && $data['wp_rem_cs_var_team_title'][$counters['wp_rem_cs_counter_team']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_team_title="' . htmlspecialchars($data['wp_rem_cs_var_team_title'][$counters['wp_rem_cs_counter_team']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_team_subtitle'][$counters['wp_rem_cs_counter_team']]) && $data['wp_rem_cs_var_team_subtitle'][$counters['wp_rem_cs_counter_team']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_team_subtitle="' . htmlspecialchars($data['wp_rem_cs_var_team_subtitle'][$counters['wp_rem_cs_counter_team']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_var_team_align'][$counters['wp_rem_cs_counter_team']]) && $data['wp_rem_var_team_align'][$counters['wp_rem_cs_counter_team']] != '' ) {
                    $section_title .= 'wp_rem_var_team_align="' . htmlspecialchars($data['wp_rem_var_team_align'][$counters['wp_rem_cs_counter_team']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_team_col'][$counters['wp_rem_cs_counter_team']]) && $data['wp_rem_cs_var_team_col'][$counters['wp_rem_cs_counter_team']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_team_col="' . htmlspecialchars($data['wp_rem_cs_var_team_col'][$counters['wp_rem_cs_counter_team']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_team_views'][$counters['wp_rem_cs_counter_team']]) && $data['wp_rem_cs_var_team_views'][$counters['wp_rem_cs_counter_team']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_team_views="' . htmlspecialchars($data['wp_rem_cs_var_team_views'][$counters['wp_rem_cs_counter_team']], ENT_QUOTES) . '" ';
                }
                $shortcode = '[wp_rem_cs_team team_element_size="' . htmlspecialchars($data['team_element_size'][$counters['wp_rem_cs_global_counter_team']]) . '" ' . $section_title . ' ]' . $shortcode_item . '[/wp_rem_cs_team]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_team'] ++;
            }
            $counters['wp_rem_cs_global_counter_team'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_team', 'wp_rem_cs_save_page_builder_data_team_callback');
}

if ( ! function_exists('wp_rem_cs_load_shortcode_counters_team_callback') ) {

    /**
     * Populate team shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_team_callback($counters) {
        $counters['wp_rem_cs_shortcode_counter_team'] = 0;
        $counters['wp_rem_cs_global_counter_team'] = 0;
        $counters['wp_rem_cs_counter_team'] = 0;
        $counters['wp_rem_cs_counter_team_node'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_team_callback');
}

if ( ! function_exists('wp_rem_cs_shortcode_names_list_populate_team_callback') ) {

    /**
     * Populate team shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_team_callback($shortcode_array) {
        $shortcode_array['team'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_team'),
            'name' => 'team',
            'icon' => 'icon-user',
            'categories' => 'loops',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_team_callback');
}

if ( ! function_exists('wp_rem_cs_element_list_populate_team_callback') ) {

    /**
     * Populate team shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_team_callback($element_list) {
        $element_list['team'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_team');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_team_callback');
}

if ( ! function_exists('wp_rem_cs_shortcode_sub_element_ui_team_callback') ) {

    /**
     * Render UI for sub element in team settings.
     *
     * @param	array $args
     */
    function wp_rem_cs_shortcode_sub_element_ui_team_callback($args) {
        $type = $args['type'];
        $wp_rem_cs_var_html_fields = $args['html_fields'];
        if ( $type == 'team' ) {
            $rand_id = 'multiple_team_' . rand(455345, 23454390);
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp  cs-pbwp-content'  id="wp_rem_cs_infobox_<?php echo wp_rem_cs_allow_special_char($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_team_sc'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_remove'); ?></a>
                </header>

                <script>
                    var team_view = $('#wp_rem_cs_var_team_view').val();
                    
                    if (team_view == 'medium') {
                        $('.small-hide-show').show();
                    } else if (team_view == 'grid') {
                        $('.small-hide-show').show();
                    } else if (team_view == 'small') {
                        $('.small-hide-show').hide();
                    }

                </script>

                <?php
                
                echo '<div class="small-hide-show">';
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_team_sc_name'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_team_sc_name_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'team_name',
                        'cust_name' => 'wp_rem_cs_var_team_name[]',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_team_sc_designation'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_team_sc_designation_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'team_designation',
                        'cust_name' => 'wp_rem_cs_var_team_designation[]',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                echo '</div>';
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_link'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_link_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'team_link' . $wp_rem_cs_counter,
                        'cust_name' => 'wp_rem_cs_var_team_link[]',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                echo '<div class="small-hide-show">';
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_email'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_email_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'wp_rem_cs_var_team_email' . $wp_rem_cs_counter,
                        'cust_name' => 'wp_rem_cs_var_team_email[]',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_phone'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_phone_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => esc_html($wp_rem_cs_var_team_phone),
                        'id' => 'wp_rem_cs_var_team_phone' . $wp_rem_cs_counter,
                        'cust_name' => 'wp_rem_cs_var_team_phone[]',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_fb'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_fb_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'wp_rem_cs_var_team_facebook' . $wp_rem_cs_counter,
                        'cust_name' => 'wp_rem_cs_var_team_facebook[]',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_twitter'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_twitter_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'wp_rem_cs_var_team_twitter' . $wp_rem_cs_counter,
                        'cust_name' => 'wp_rem_cs_var_team_twitter[]',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_linkedin'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_linkedin_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => esc_html($wp_rem_cs_var_team_linkedin),
                        'id' => 'wp_rem_cs_var_team_linkedin' . $wp_rem_cs_counter,
                        'cust_name' => 'wp_rem_cs_var_team_linkedin[]',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                echo '</div>';
                $wp_rem_cs_opt_array = array(
                    'std' => '',
                    'id' => 'team_image_array',
                    'main_id' => 'team_image_array',
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_team_sc_image'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_team_sc_image_hint'),
                    'echo' => true,
                    'array' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => '',
                        'cust_name' => 'wp_rem_cs_var_team_image[]',
                        'id' => 'team_image_array',
                        'return' => true,
                        'array' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);
                echo '<div class="small-hide-show">';
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_content'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_sc_content_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'team_text',
                        'cust_name' => 'wp_rem_cs_var_team_text[]',
                        'extra_atr' => ' data-content-text="cs-shortcode-textarea"',
                        'return' => true,
                        'classes' => '',
                        'wp_rem_cs_editor' => true
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                echo '</div>';
                ?>
            </div>
            <?php
        }
    }

    add_action('wp_rem_cs_shortcode_sub_element_ui', 'wp_rem_cs_shortcode_sub_element_ui_team_callback');
}