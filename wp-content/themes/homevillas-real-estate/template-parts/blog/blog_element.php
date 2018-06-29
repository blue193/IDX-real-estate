<?php
/*
 *
 * @File : blog
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_var_page_builder_blog') ) {

    function wp_rem_cs_var_page_builder_blog($die = 0) {
        global $wp_rem_cs_var_node, $post, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        $strings->wp_rem_cs_theme_option_strings();

        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $counter = $_POST['counter'];
        $wp_rem_cs_counter = $_POST['counter'];
        if ( isset($_POST['action']) && ! isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'wp_rem_cs_blog';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'wp_rem_cs_blog_element_title' => '',
            'wp_rem_cs_blog_element_subtitle' => '',
            'wp_rem_cs_blog_element_title_alignment' => '',
            'wp_rem_cs_blog_view' => 'view1',
            'wp_rem_cs_blog_cat' => '',
            'wp_rem_cs_blog_cat' => '',
            'wp_rem_cs_blog_order_by' => 'ID',
            'wp_rem_cs_blog_order_by_dir' => 'DESC',
            'wp_rem_cs_blog_description' => 'yes',
            'wp_rem_cs_blog_filterable' => '',
            'wp_rem_cs_blog_excerpt' => '30',
            'wp_rem_cs_blog_posts_title_length' => '',
            'wp_rem_cs_blog_num_post' => '5',
            'blog_pagination' => '',
            'wp_rem_cs_blog_class' => '',
            'wp_rem_cs_blog_size' => ''
        );
        if ( isset($output['0']['atts']) ) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        $blog_element_size = '50';
        foreach ( $defaults as $key => $values ) {
            if ( isset($atts[$key]) ) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'blog';
        $coloumn_class = 'column_' . $blog_element_size;
        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        $wp_rem_cs_rand_id = rand(13441324, 93441324);
        ?>
        <div id="<?php echo esc_attr($name . $wp_rem_cs_counter); ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php echo esc_attr($shortcode_view); ?>" item="blog" data="<?php echo wp_rem_cs_element_size_data_array_index($blog_element_size) ?>">
            <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $blog_element_size); ?>
            <div class="cs-wrapp-class-<?php echo intval($wp_rem_cs_counter) ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[wp_rem_cs_blog {{attributes}}]"  style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_edit_blog_items')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_js($name . $wp_rem_cs_counter); ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a>
                </div>
                <div class="cs-pbwp-content">
                    <div class="cs-wrapp-clone cs-shortcode-wrapp">
                        <?php
                        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
                            wp_rem_cs_shortcode_element_size();
                        }
                        ?>
                        <?php
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_blog_element_title),
                                'cust_id' => '',
                                'cust_name' => 'wp_rem_cs_blog_element_title[]',
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
                                'std' => esc_attr($wp_rem_cs_blog_element_subtitle),
                                'classes' => '',
                                'cust_name' => 'wp_rem_cs_blog_element_subtitle[]',
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
                                'std' => $wp_rem_cs_blog_element_title_alignment,
                                'id' => '',
                                'cust_name' => 'wp_rem_cs_blog_element_title_alignment[]',
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





                        $a_options = array();
                        $wp_rem_cs_blog_cat = isset($wp_rem_cs_blog_cat) ? $wp_rem_cs_blog_cat : '';
                        if ( '' != $wp_rem_cs_blog_cat ) {
                            $wp_rem_cs_blog_cat = explode(',', $wp_rem_cs_blog_cat);
                        }
                        $a_options = wp_rem_cs_show_all_cats('', '', $wp_rem_cs_blog_cat, "category", true);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_choose_category'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_cat_hint'),
                            'echo' => true,
                            'multi' => true,
                            'field_params' => array(
                                'std' => $wp_rem_cs_blog_cat,
                                'id' => '',
                                'cust_name' => 'wp_rem_cs_blog_cat[' . $wp_rem_cs_rand_id . '][]',
                                'classes' => 'dropdown chosen-select',
                                'options' => $a_options,
                                'return' => true,
                            ),
                        );

                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                        $rand = rand(12345678, 93242432);
                        $imageurl = get_template_directory_uri() . '/assets/backend/images/views/blog-listings/';

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_design_views'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_design_views_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $wp_rem_cs_blog_view,
                                'id' => '',
                                'cust_name' => 'wp_rem_cs_blog_view[]',
                                'classes' => 'dropdown chosen-select',
                                'options' => array(
                                    'view1' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_design_large'),
                                    'view2' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_design_grid'),
                                    'view3' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_design_medium'),
                                    'view7' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_design_medium_list'),
                                    'view4' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_design_simple'),
                                    'view5' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_design_classic'),
                                    'view6' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_design_medium_default'),
                                    'view8' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_view_boxed'),
                                ),
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                        ?>
                        <div id="Blog-listing<?php echo intval($wp_rem_cs_counter); ?>" >
                            <?php
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_col'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_col_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $wp_rem_cs_blog_size,
                                    'id' => '',
                                    'cust_name' => 'wp_rem_cs_blog_size[]',
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

                            $options = array(
                                'id' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_views_widget_order_by_id'),
                                'date' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_views_widget_order_by_date'),
                                'title' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_views_widget_order_by_title'),
                            );
                            $options = apply_filters('posts_order_by_options', $options);
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_views_widget_order_by'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_post_order_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'options' => $options,
                                    'std' => esc_attr($wp_rem_cs_blog_order_by),
                                    'id' => '',
                                    'classes' => 'dropdown chosen-select',
                                    'cust_id' => '',
                                    'cust_name' => 'wp_rem_cs_var_post_order_by[]',
                                    'return' => true,
                                    'required' => false,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_post_order'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_post_order_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $wp_rem_cs_blog_order_by_dir,
                                    'id' => '',
                                    'cust_name' => 'wp_rem_cs_blog_order_by_dir[]',
                                    'classes' => 'dropdown chosen-select-no-single select-medium',
                                    'options' => array(
                                        'ASC' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_asc'),
                                        'DESC' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_desc'),
                                    ),
                                    'return' => true,
                                ),
                            );

                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_post_description'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_post_description_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $wp_rem_cs_blog_description,
                                    'id' => '',
                                    'cust_name' => 'wp_rem_cs_blog_description[]',
                                    'classes' => 'dropdown chosen-select-no-single select-medium',
                                    'options' => array(
                                        'yes' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_yes'),
                                        'no' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no'),
                                    ),
                                    'return' => true,
                                ),
                            );

                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_length_excerpt'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_length_excerpt_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_blog_excerpt),
                                    'cust_id' => '',
                                    'classes' => 'txtfield',
                                    'cust_name' => 'wp_rem_cs_blog_excerpt[]',
                                    'return' => true,
                                ),
                            );

                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            if ( ! is_numeric($wp_rem_cs_blog_posts_title_length) ) {
                                $wp_rem_cs_blog_posts_title_length = '';
                            }

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_post_title_length'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_post_title_length_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_blog_posts_title_length),
                                    'cust_id' => '',
                                    'cust_name' => 'wp_rem_cs_blog_posts_title_length[]',
                                    'return' => true,
                                ),
                            );

                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                            ?>
                        </div>

                        <?php
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_post_per_page'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_post_per_page_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_blog_num_post),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'wp_rem_cs_blog_num_post[]',
                                'return' => true,
                            ),
                        );

                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                        $filter_view1 = $filter_view2 = $filter_all_posts = '';
                        $all_posts_blog_views = array( 'view11', 'view12', 'view13', 'view17', 'view19' );
                        if ( 'view1' === $wp_rem_cs_blog_view || '' === $wp_rem_cs_blog_view ) {
                            $filter_view1 = 'none';
                            $filter_view2 = 'block';
                            $filter_all_posts = 'none';
                        } else if ( in_array($wp_rem_cs_blog_view, $all_posts_blog_views) ) {
                            $filter_view1 = 'none';
                            $filter_view2 = 'none';
                            $filter_all_posts = 'block';
                        } else {
                            $filter_view1 = 'block';
                            $filter_view2 = 'none';
                            $filter_all_posts = 'none';
                        }

                        //// Pagination Field

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_pagination'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_pagination_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $blog_pagination,
                                'id' => '',
                                'cust_name' => 'blog_pagination[]',
                                'classes' => 'dropdown chosen-select-no-single select-medium',
                                'options' => array(
                                    'yes' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_show_pagination'),
                                    'no' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_single_page'),
                                ),
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);


                        //// All Posts Field

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_all_posts'),
                            'desc' => '',
                            'hint_text' => '',
                            'echo' => true,
                            'field_params' => array(
                                'std' => $wp_rem_cs_blog_all_posts,
                                'id' => '',
                                'cust_name' => 'wp_rem_cs_blog_all_posts[]',
                                'classes' => 'dropdown chosen-select-no-single select-medium',
                                'options' => array(
                                    'all' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_all_posts'),
                                ),
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                        ?>

                        <?php if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) { ?>
                            <ul class="form-elements insert-bg">
                                <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo esc_js(str_replace('wp_rem_cs_', '', $name)); ?>', '<?php echo esc_js($name . $wp_rem_cs_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a> </li>
                            </ul>
                            <div id="results-shortocde"></div>
                        <?php } else { ?>
                            <?php
                            $wp_rem_cs_opt_array = array(
                                'std' => 'blog',
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => '',
                                'extra_atr' => '',
                                'cust_id' => 'wp_rem_cs_orderby' . $wp_rem_cs_counter,
                                'cust_name' => 'wp_rem_cs_orderby[]',
                                'required' => false
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'id' => '',
                                'std' => absint($wp_rem_cs_rand_id),
                                'cust_id' => "",
                                'cust_name' => "wp_rem_cs_blog_id[]",
                            );

                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => '',
                                'desc' => '',
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => 'Save',
                                    'cust_id' => '',
                                    'cust_type' => 'button',
                                    'classes' => 'cs-wp_rem_cs-admin-btn',
                                    'cust_name' => 'button',
                                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                    'return' => true,
                                ),
                            );

                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                            ?>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
        <?php
        if ( $die <> 1 ) {
            die();
        }
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_blog', 'wp_rem_cs_var_page_builder_blog');
}
if ( ! function_exists('wp_rem_cs_save_page_builder_data_blog_callback') ) {

    /**
     * Save data for blog shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_blog_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];

        $shortcode_data = '';
        if ( $widget_type == "blog" || $widget_type == "cs_blog" ) {
            $wp_rem_cs_var_blog = '';

            $page_element_size = $data['blog_element_size'][$counters['wp_rem_cs_global_counter_blog']];
            $current_element_size = $data['blog_element_size'][$counters['wp_rem_cs_global_counter_blog']];

            if ( isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
                $shortcode_str = stripslashes(( $data['shortcode']['blog'][$counters['wp_rem_cs_shortcode_counter_blog']]));

                $element_settings = 'blog_element_size="' . $current_element_size . '"';
                $reg = '/blog_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;

                $counters['wp_rem_cs_shortcode_counter_blog'] ++;
            } else {
                $element_settings = 'blog_element_size="' . htmlspecialchars($data['blog_element_size'][$counters['wp_rem_cs_global_counter_blog']]) . '"';
                $wp_rem_cs_var_blog = '[wp_rem_cs_blog ' . $element_settings . ' ';
                if ( isset($data['wp_rem_cs_blog_element_title'][$counters['wp_rem_cs_counter_blog']]) && $data['wp_rem_cs_blog_element_title'][$counters['wp_rem_cs_counter_blog']] != '' ) {
                    $wp_rem_cs_var_blog .= 'wp_rem_cs_blog_element_title="' . htmlspecialchars($data['wp_rem_cs_blog_element_title'][$counters['wp_rem_cs_counter_blog']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_blog_element_subtitle'][$counters['wp_rem_cs_counter_blog']]) && $data['wp_rem_cs_blog_element_subtitle'][$counters['wp_rem_cs_counter_blog']] != '' ) {
                    $wp_rem_cs_var_blog .= 'wp_rem_cs_blog_element_subtitle="' . htmlspecialchars($data['wp_rem_cs_blog_element_subtitle'][$counters['wp_rem_cs_counter_blog']], ENT_QUOTES) . '" ';
                }if ( isset($data['wp_rem_cs_blog_element_title_alignment'][$counters['wp_rem_cs_counter_blog']]) && $data['wp_rem_cs_blog_element_title_alignment'][$counters['wp_rem_cs_counter_blog']] != '' ) {
                    $wp_rem_cs_var_blog .= 'wp_rem_cs_blog_element_title_alignment="' . htmlspecialchars($data['wp_rem_cs_blog_element_title_alignment'][$counters['wp_rem_cs_counter_blog']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_blog_posts_title_length'][$counters['wp_rem_cs_counter_blog']]) && $data['wp_rem_cs_blog_posts_title_length'][$counters['wp_rem_cs_counter_blog']] != '' ) {
                    $wp_rem_cs_var_blog .= 'wp_rem_cs_blog_posts_title_length="' . htmlspecialchars($data['wp_rem_cs_blog_posts_title_length'][$counters['wp_rem_cs_counter_blog']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_blog_id'][$counters['wp_rem_cs_counter_blog']]) && $data['wp_rem_cs_blog_id'][$counters['wp_rem_cs_counter_blog']] != '' ) {
                    $wp_rem_cs_blog_id = $data['wp_rem_cs_blog_id'][$counters['wp_rem_cs_counter_blog']];

                    if ( isset($_POST['wp_rem_cs_blog_cat'][$wp_rem_cs_blog_id]) && $_POST['wp_rem_cs_blog_cat'][$wp_rem_cs_blog_id] != '' ) {

                        if ( is_array($_POST['wp_rem_cs_blog_cat'][$wp_rem_cs_blog_id]) ) {

                            $wp_rem_cs_var_blog .= ' wp_rem_cs_blog_cat="' . implode(',', $_POST['wp_rem_cs_blog_cat'][$wp_rem_cs_blog_id]) . '" ';
                        }
                    }
                }

                if ( isset($data['wp_rem_cs_var_post_order_by'][$counters['wp_rem_cs_counter_blog']]) && $data['wp_rem_cs_var_post_order_by'][$counters['wp_rem_cs_counter_blog']] != '' ) {
                    $wp_rem_cs_var_blog .= 'wp_rem_cs_blog_order_by="' . htmlspecialchars($data['wp_rem_cs_var_post_order_by'][$counters['wp_rem_cs_counter_blog']], ENT_QUOTES) . '" ';
                }

                if ( isset($data['wp_rem_cs_blog_order_by_dir'][$counters['wp_rem_cs_counter_blog']]) && $data['wp_rem_cs_blog_order_by_dir'][$counters['wp_rem_cs_counter_blog']] != '' ) {
                    $wp_rem_cs_var_blog .= 'wp_rem_cs_blog_order_by_dir="' . htmlspecialchars($data['wp_rem_cs_blog_order_by_dir'][$counters['wp_rem_cs_counter_blog']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['orderby'][$counters['wp_rem_cs_counter_blog']]) && $data['orderby'][$counters['wp_rem_cs_counter_blog']] != '' ) {
                    $wp_rem_cs_var_blog .= 'orderby="' . htmlspecialchars($data['orderby'][$counters['wp_rem_cs_counter_blog']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_blog_description'][$counters['wp_rem_cs_counter_blog']]) && $data['wp_rem_cs_blog_description'][$counters['wp_rem_cs_counter_blog']] != '' ) {
                    $wp_rem_cs_var_blog .= 'wp_rem_cs_blog_description="' . htmlspecialchars($data['wp_rem_cs_blog_description'][$counters['wp_rem_cs_counter_blog']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_blog_filterable'][$counters['wp_rem_cs_counter_blog']]) && $data['wp_rem_cs_blog_filterable'][$counters['wp_rem_cs_counter_blog']] != '' ) {
                    $wp_rem_cs_var_blog .= 'wp_rem_cs_blog_filterable="' . htmlspecialchars($data['wp_rem_cs_blog_filterable'][$counters['wp_rem_cs_counter_blog']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_blog_excerpt'][$counters['wp_rem_cs_counter_blog']]) && $data['wp_rem_cs_blog_excerpt'][$counters['wp_rem_cs_counter_blog']] != '' ) {
                    $wp_rem_cs_var_blog .= 'wp_rem_cs_blog_excerpt="' . htmlspecialchars($data['wp_rem_cs_blog_excerpt'][$counters['wp_rem_cs_counter_blog']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_blog_excerpt'][$counters['wp_rem_cs_counter_blog']]) && $data['wp_rem_cs_blog_excerpt'][$counters['wp_rem_cs_counter_blog']] != '' ) {
                    $wp_rem_cs_var_blog .= 'wp_rem_cs_blog_excerpt="' . htmlspecialchars($data['wp_rem_cs_blog_excerpt'][$counters['wp_rem_cs_counter_blog']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_blog_num_post'][$counters['wp_rem_cs_counter_blog']]) && $data['wp_rem_cs_blog_num_post'][$counters['wp_rem_cs_counter_blog']] != '' ) {
                    $wp_rem_cs_var_blog .= 'wp_rem_cs_blog_num_post="' . htmlspecialchars($data['wp_rem_cs_blog_num_post'][$counters['wp_rem_cs_counter_blog']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['blog_pagination'][$counters['wp_rem_cs_counter_blog']]) && $data['blog_pagination'][$counters['wp_rem_cs_counter_blog']] != '' ) {
                    $wp_rem_cs_var_blog .= 'blog_pagination="' . htmlspecialchars($data['blog_pagination'][$counters['wp_rem_cs_counter_blog']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_blog_class'][$counters['wp_rem_cs_counter_blog']]) && $data['wp_rem_cs_blog_class'][$counters['wp_rem_cs_counter_blog']] != '' ) {
                    $wp_rem_cs_var_blog .= 'wp_rem_cs_blog_class="' . htmlspecialchars($data['wp_rem_cs_blog_class'][$counters['wp_rem_cs_counter_blog']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_blog_view'][$counters['wp_rem_cs_counter_blog']]) && $data['wp_rem_cs_blog_view'][$counters['wp_rem_cs_counter_blog']] != '' ) {
                    $wp_rem_cs_var_blog .= 'wp_rem_cs_blog_view="' . htmlspecialchars($data['wp_rem_cs_blog_view'][$counters['wp_rem_cs_counter_blog']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_blog_size'][$counters['wp_rem_cs_counter_blog']]) && $data['wp_rem_cs_blog_size'][$counters['wp_rem_cs_counter_blog']] != '' ) {
                    $wp_rem_cs_var_blog .= 'wp_rem_cs_blog_size="' . htmlspecialchars($data['wp_rem_cs_blog_size'][$counters['wp_rem_cs_counter_blog']], ENT_QUOTES) . '" ';
                }
                $wp_rem_cs_var_blog .= ']';
                if ( isset($data['blog_text'][$counters['wp_rem_cs_counter_blog']]) && $data['blog_text'][$counters['wp_rem_cs_counter_blog']] != '' ) {
                    $wp_rem_cs_var_blog .= htmlspecialchars($data['blog_text'][$counters['wp_rem_cs_counter_blog']], ENT_QUOTES) . ' ';
                }
                $wp_rem_cs_var_blog .= '[/wp_rem_cs_blog]';

                $shortcode_data .= $wp_rem_cs_var_blog;
                $counters['wp_rem_cs_counter_blog'] ++;
            }
            $counters['wp_rem_cs_global_counter_blog'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_blog', 'wp_rem_cs_save_page_builder_data_blog_callback');
}
if ( ! function_exists('wp_rem_cs_load_shortcode_counters_blog_callback') ) {

    /**
     * Populate blog shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_blog_callback($counters) {
        $counters['wp_rem_cs_global_counter_blog'] = 0;
        $counters['wp_rem_cs_shortcode_counter_blog'] = 0;
        $counters['wp_rem_cs_counter_blog'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_blog_callback');
}
if ( ! function_exists('wp_rem_cs_shortcode_names_list_populate_blog_callback') ) {

    /**
     * Populate blog shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_blog_callback($shortcode_array) {
        $shortcode_array['blog'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_blog'),
            'name' => 'blog',
            'icon' => 'icon-support',
            'categories' => 'typography',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_blog_callback');
}
if ( ! function_exists('wp_rem_cs_element_list_populate_blog_callback') ) {

    /**
     * Populate blog shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_blog_callback($element_list) {
        $element_list['blog'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_blog');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_blog_callback');
}