<?php

/**
 * @  Blog html form for page builder Frontend side
 *
 *
 */
if ( ! function_exists('wp_rem_cs_blog_shortcode') ) {

    function wp_rem_cs_blog_shortcode($atts) {
        global $wp_rem_cs_blog_size, $post, $col_class, $wp_rem_cs_blog_element_title, $wpdb, $blog_pagination, $wp_rem_cs_blog_num_post, $wp_rem_cs_counter_node, $wp_rem_cs_column_atts, $wp_rem_cs_blog_cats, $wp_rem_cs_blog_description, $wp_rem_cs_blog_excerpt, $wp_rem_cs_blog_posts_title_length_var, $post_thumb_view, $wp_rem_cs_blog_section_title, $wp_rem_cs_exclude_post_id, $args, $wp_rem_cs_blog_orderby, $orderby;
        $paging_var = 'paged_id';
        if ( ! isset($_GET[$paging_var]) ) {
            $_GET[$paging_var] = '';
        }
        $defaults = array(
            'wp_rem_cs_blog_element_title' => '',
            'wp_rem_cs_blog_element_subtitle' => '',
            'wp_rem_cs_blog_element_title_alignment' => '',
            'wp_rem_cs_blog_view' => '',
            'wp_rem_cs_exclude_post_id' => '0',
            'wp_rem_cs_blog_cat' => '',
            'wp_rem_cs_blog_orderby' => 'DESC',
            'orderby' => 'ID',
            'wp_rem_cs_blog_order_by' => 'ID', // This is used for ratings sorting
            'wp_rem_cs_blog_order_by_dir' => 'DESC', // This is used for ratings sorting
            'wp_rem_cs_blog_description' => 'yes',
            'wp_rem_cs_blog_excerpt' => '255',
            'wp_rem_cs_blog_posts_title_length' => '',
            'wp_rem_cs_blog_num_post' => '10',
            'blog_pagination' => '',
            'wp_rem_cs_blog_class' => '',
            'wp_rem_cs_blog_size' => ''
        );
        wp_enqueue_script('wp-rem-matchHeight-script');
        extract(shortcode_atts($defaults, $atts));
        $wp_rem_cs_blog_posts_title_length_var = '';
        if ( ! is_numeric($wp_rem_cs_blog_posts_title_length) || $wp_rem_cs_blog_posts_title_length == '' ) {
            $wp_rem_cs_blog_posts_title_length_var = '100';
        } else {
            $wp_rem_cs_blog_posts_title_length_var = $wp_rem_cs_blog_posts_title_length;
        }

        $buildere_data = get_post_meta(get_the_ID(), 'wp_rem_cs_page_builder', true);


        $wp_rem_cs_blog_cats = $wp_rem_cs_blog_cat;
        static $wp_rem_cs_var_custom_counter;
        if ( ! isset($wp_rem_cs_var_custom_counter) ) {
            $wp_rem_cs_var_custom_counter = 1;
        } else {
            $wp_rem_cs_var_custom_counter ++;
        }
        $wp_rem_cs_var_page = isset($_GET['post_paging_' . $wp_rem_cs_var_custom_counter]) ? $_GET['post_paging_' . $wp_rem_cs_var_custom_counter] : '1';
        if ( isset($wp_rem_cs_blog_size) && $wp_rem_cs_blog_size != '' ) {
            $number_col = 12 / $wp_rem_cs_blog_size;
            $number_col_sm = 12;
            $number_col_xs = 12;
            if ( $number_col == 2 ) {
                $number_col_sm = 4;
                $number_col_xs = 6;
            }
            if ( $number_col == 3 ) {
                $number_col_sm = 6;
                $number_col_xs = 12;
            }
            if ( $number_col == 4 ) {
                $number_col_sm = 6;
                $number_col_xs = 12;
            }
            if ( $number_col == 6 ) {
                $number_col_sm = 12;
                $number_col_xs = 12;
            }
            $col_class = 'col-lg-' . $number_col . ' col-md-' . $number_col . ' col-sm-' . $number_col_sm . ' col-xs-' . $number_col_xs . '';
        }
        $wp_rem_cs_dataObject = get_post_meta($post->ID, 'wp_rem_cs_full_data');
        $wp_rem_cs_sidebarLayout = '';
        $section_wp_rem_cs_layout = '';
        $pageSidebar = false;
        $box_col_class = 'col-md-3';
        if ( isset($wp_rem_cs_dataObject['wp_rem_cs_page_layout']) ) {
            $wp_rem_cs_sidebarLayout = $wp_rem_cs_dataObject['wp_rem_cs_page_layout'];
        }

        if ( isset($wp_rem_cs_column_atts->wp_rem_cs_layout) ) {
            $section_wp_rem_cs_layout = $wp_rem_cs_column_atts->wp_rem_cs_layout;
            if ( $section_wp_rem_cs_layout == 'left' || $section_wp_rem_cs_layout == 'right' ) {
                $pageSidebar = true;
            }
        }
        if ( $wp_rem_cs_sidebarLayout == 'left' || $wp_rem_cs_sidebarLayout == 'right' ) {
            $pageSidebar = true;
        }
        if ( $pageSidebar == true ) {
            $box_col_class = 'col-md-4';
        }
        if ( (isset($wp_rem_cs_dataObject['wp_rem_cs_page_layout']) && $wp_rem_cs_dataObject['wp_rem_cs_page_layout'] <> '' and $wp_rem_cs_dataObject['wp_rem_cs_page_layout'] <> "none") || $pageSidebar == true ) {
            $wp_rem_cs_blog_grid_layout = 'col-md-4';
        } else {
            $wp_rem_cs_blog_grid_layout = 'col-md-3';
        }
        $CustomId = '';
        if ( isset($wp_rem_cs_blog_class) && $wp_rem_cs_blog_class ) {
            $CustomId = 'id="' . $wp_rem_cs_blog_class . '"';
        }
        $owlcount = rand(40, 9999999);
        $wp_rem_cs_counter_node ++;
        ob_start();
        $filter_category = '';
        $filter_tag = '';
        $author_filter = '';
        if ( isset($_GET['filter_category']) && $_GET['filter_category'] <> '' && $_GET['filter_category'] <> '0' ) {
            $filter_category = $_GET['filter_category'];
        }
        if ( isset($_GET['sort']) and $_GET['sort'] == 'asc' ) {
            $wp_rem_cs_blog_orderby = 'ASC';
        } else {
            $wp_rem_cs_blog_orderby = $wp_rem_cs_blog_orderby;
        }
        if ( isset($_GET['sort']) and $_GET['sort'] == 'alphabetical' ) {
            $orderby = 'title';
            $wp_rem_cs_blog_orderby = 'ASC';
        } else if ( isset($wp_rem_cs_blog_order_by) ) {
            $orderby = $wp_rem_cs_blog_order_by;
            $wp_rem_cs_blog_orderby = $wp_rem_cs_blog_order_by_dir;
        } elseif ( isset($_GET['catform']) && isset($_GET['sort_option']) ) {
            if ( ! empty($_GET['sort_option']) || $_GET['sort_option'] != '0' ) {
                $orderby = $_GET['sort_option'];
            }
        } else {
            $orderby = 'meta_value';
        }


        if ( empty($_GET['page_id_all']) ) {
            $_GET['page_id_all'] = 1;
        }
        $wp_rem_cs_blog_num_post = $wp_rem_cs_blog_num_post ? $wp_rem_cs_blog_num_post : '-1';
        if ( $wp_rem_cs_exclude_post_id == 0 && $wp_rem_cs_exclude_post_id == '' ) {
            $args = array( 'posts_per_page' => "-1", 'post_type' => 'post', 'order' => $wp_rem_cs_blog_orderby, 'orderby' => $orderby, 'post_status' => 'publish', 'ignore_sticky_posts' => 1 );
        } else {
            $args = array( 'posts_per_page' => "-1", 'post__not_in' => array( $wp_rem_cs_exclude_post_id ), 'post_type' => 'post', 'order' => $wp_rem_cs_blog_orderby, 'orderby' => $orderby, 'post_status' => 'publish', 'ignore_sticky_posts' => 1 );
        }
        if ( isset($wp_rem_cs_blog_cat) && $wp_rem_cs_blog_cat <> '' && $wp_rem_cs_blog_cat <> '0' ) {
            $blog_category_array = array( 'category_name' => "$wp_rem_cs_blog_cat" );
            $args = array_merge($args, $blog_category_array);
        }
        if ( isset($filter_category) && $filter_category <> '' && $filter_category <> '0' ) {
            if ( isset($_GET['filter-tag']) ) {
                $filter_tag = $_GET['filter-tag'];
            }
            if ( $filter_tag <> '' ) {
                $blog_category_array = array( 'category_name' => "$filter_category", 'tag' => "$filter_tag" );
            } else {
                $blog_category_array = array( 'category_name' => "$filter_category" );
            }
            $args = array_merge($args, $blog_category_array);
        }
        if ( isset($_GET['filter-tag']) && $_GET['filter-tag'] <> '' && $_GET['filter-tag'] <> '0' ) {
            $filter_tag = $_GET['filter-tag'];
            if ( $filter_tag <> '' ) {
                $course_category_array = array( 'category_name' => "$filter_category", 'tag' => "$filter_tag" );
                $args = array_merge($args, $course_category_array);
            }
        }
        if ( isset($_GET['by_author']) && $_GET['by_author'] <> '' && $_GET['by_author'] <> '0' ) {
            $author_filter = $_GET['by_author'];
            if ( $author_filter <> '' ) {
                $authorArray = array( 'author' => "$author_filter" );
                $args = array_merge($args, $authorArray);
            }
        }
        if ( isset($_GET['catform']) ) {
            if ( isset($_GET['category']) && ! empty($_GET['category']) ) {
                $cats = $_GET['category'];
                $args['tax_query'] = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'category',
                        'field' => 'slug',
                        'terms' => $cats
                    ),
                );
            }
        }
        $query = new WP_Query($args);
        $count_post = $query->post_count;
        wp_reset_postdata();
        $wp_rem_cs_blog_num_post = $wp_rem_cs_blog_num_post ? $wp_rem_cs_blog_num_post : '-1';
        if ( $wp_rem_cs_exclude_post_id == 0 && $wp_rem_cs_exclude_post_id == '' ) {
            $args = array( 'posts_per_page' => "$wp_rem_cs_blog_num_post", 'post_type' => 'post', 'paged' => $_GET[$paging_var], 'order' => $wp_rem_cs_blog_orderby, 'orderby' => $orderby, 'post_status' => 'publish', 'ignore_sticky_posts' => 1 );
        } else {
            $args = array( 'posts_per_page' => "$wp_rem_cs_blog_num_post", 'post__not_in' => array( $wp_rem_cs_exclude_post_id ), 'post_type' => 'post', 'paged' => $_GET[$paging_var], 'order' => $wp_rem_cs_blog_orderby, 'orderby' => $orderby, 'post_status' => 'publish', 'ignore_sticky_posts' => 1 );
        }
        if ( isset($wp_rem_cs_blog_cat) && $wp_rem_cs_blog_cat <> '' && $wp_rem_cs_blog_cat <> '0' ) {

            $blog_category_array = array( 'category_name' => "$wp_rem_cs_blog_cat" );
            $args = array_merge($args, $blog_category_array);
        }
        if ( isset($filter_category) && $filter_category <> '' && $filter_category <> '0' ) {
            if ( isset($_GET['filter-tag']) ) {
                $filter_tag = $_GET['filter-tag'];
            }
            if ( $filter_tag <> '' ) {
                $blog_category_array = array( 'category_name' => "$filter_category", 'tag' => "$filter_tag" );
            } else {
                $blog_category_array = array( 'category_name' => "$filter_category" );
            }
            $args = array_merge($args, $blog_category_array);
        }

        if ( isset($_GET['filter-tag']) && $_GET['filter-tag'] <> '' && $_GET['filter-tag'] <> '0' ) {
            $filter_tag = $_GET['filter-tag'];
            if ( $filter_tag <> '' ) {
                $course_category_array = array( 'category_name' => "$filter_category", 'tag' => "$filter_tag" );
                $args = array_merge($args, $course_category_array);
            }
        }
        if ( isset($_GET['by_author']) && $_GET['by_author'] <> '' && $_GET['by_author'] <> '0' ) {
            $author_filter = $_GET['by_author'];
            if ( $author_filter <> '' ) {
                $authorArray = array( 'author' => "$author_filter" );
                $args = array_merge($args, $authorArray);
            }
        }
        if ( $wp_rem_cs_blog_cat != '' && $wp_rem_cs_blog_cat != '0' ) {

            $row_cat = $wpdb->get_row($wpdb->prepare("SELECT * from $wpdb->terms WHERE slug = %s", $wp_rem_cs_blog_cat));
        }

        $page_element_size = isset($atts['blog_element_size']) ? $atts['blog_element_size'] : 100;
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            echo '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }


        $section_title = '';
        $seperator = '';
        if ( $wp_rem_cs_blog_view == 'view5' ) {
            $seperator = 'zigzag';
        }
        $section_title .= wp_rem_title_sub_align($wp_rem_cs_blog_element_title, $wp_rem_cs_blog_element_subtitle, $wp_rem_cs_blog_element_title_alignment, '', $seperator);
        echo wp_rem_cs_allow_special_char($section_title);

        if ( isset($_GET['catform']) ) {
            if ( isset($_GET['category']) && ! empty($_GET['category']) ) {
                $cats = $_GET['category'];
                $args['tax_query'] = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'category',
                        'field' => 'slug',
                        'terms' => $cats
                    ),
                );
            }
        }

        $args = apply_filters('blog_views_query', $args);

        set_query_var('args', $args);


        if ( $wp_rem_cs_blog_view == 'view1' || $wp_rem_cs_blog_view == 'view2' || $wp_rem_cs_blog_view == 'view3' || $wp_rem_cs_blog_view == 'view5' || $wp_rem_cs_blog_view == 'view7') {
            echo '<div class="row">';
        }

        if ( $wp_rem_cs_blog_view == 'view1' ) {
            get_template_part('template-parts/blog/blog', 'large');
        } else if ( $wp_rem_cs_blog_view == 'view2' ) {
            get_template_part('template-parts/blog/blog', 'grid');
        } else if ( $wp_rem_cs_blog_view == 'view3' ) {
            get_template_part('template-parts/blog/blog', 'medium');
        } else if ( $wp_rem_cs_blog_view == 'view4' ) {
            get_template_part('template-parts/blog/blog', 'simple');
        } else if ( $wp_rem_cs_blog_view == 'view5' ) {
            get_template_part('template-parts/blog/blog', 'classic');
        } else if ( $wp_rem_cs_blog_view == 'view6' ) {
            get_template_part('template-parts/blog/blog', 'medium-default');
        } else if ( $wp_rem_cs_blog_view == 'view7' ) {
            get_template_part('template-parts/blog/blog', 'medium-list');
        } else if ( $wp_rem_cs_blog_view == 'view8' ) {
            get_template_part('template-parts/blog/blog', 'boxed');
        }
        $wp_rem_cs_var_post_counts = $query->post_count;
        $wp_rem_cs_var_page = 'post_paging_' . $wp_rem_cs_var_custom_counter;
        $blog_views_without_paging = array( 'view1', 'view11', 'view12', 'view13', 'view17', 'view19' );

        if ( $blog_pagination == "yes" && $count_post > $wp_rem_cs_blog_num_post && $wp_rem_cs_blog_num_post > 0 ) {
            $total_pages = '';
            $total_pages = ceil($wp_rem_cs_var_post_counts / $wp_rem_cs_blog_num_post);

            $args_count = array(
                'posts_per_page' => "-1",
                'post_type' => 'post',
                'post_status' => 'publish',
                'fields' => 'ids', // only load ids
            );
            $listing_loop_count = new WP_Query($args_count);
            $listing_totnum = $listing_loop_count->found_posts;
            $paging_args = array( 'total_posts' => $wp_rem_cs_var_post_counts,
                'posts_per_page' => $wp_rem_cs_blog_num_post,
                'paging_var' => $paging_var,
                'show_pagination' => 'yes',
            );
            
            if ( $wp_rem_cs_blog_view == 'view4' || $wp_rem_cs_blog_view == 'view6') {
                echo '<div class="row">'; // start row
            }
            do_action('wp_rem_cs_pagination', $paging_args);
            if ( $wp_rem_cs_blog_view == 'view4' || $wp_rem_cs_blog_view == 'view6') {
                echo '</div>'; // end row
            }
        }
        if ( $wp_rem_cs_blog_view == 'view1' || $wp_rem_cs_blog_view == 'view2' || $wp_rem_cs_blog_view == 'view3' || $wp_rem_cs_blog_view == 'view5' || $wp_rem_cs_blog_view == 'view7') {
            echo '</div>'; // end row
        }
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            echo '</div>'; // close page builder size in classic blog view 
        }


        wp_reset_postdata();
        $post_data = ob_get_clean();
        return $post_data;
    }

    if ( function_exists('wp_rem_cs_var_short_code') ) {
        wp_rem_cs_var_short_code('wp_rem_cs_blog', 'wp_rem_cs_blog_shortcode');
    }
}
/**
 * @ cs get categories all post
 *
 *
 */
if ( ! function_exists('wp_rem_cs_get_categories') ) {

    function wp_rem_cs_get_categories($wp_rem_cs_blog_cat) {
        global $post, $wpdb;
        if ( isset($wp_rem_cs_blog_cat) && $wp_rem_cs_blog_cat != '' && $wp_rem_cs_blog_cat != '0' ) {
            $row_cat = $wpdb->get_row($wpdb->prepare("SELECT * from $wpdb->terms WHERE slug = %s", $wp_rem_cs_blog_cat));
            echo '<a class="cs-color" href="' . esc_url(home_url('/')) . '?cat=' . $row_cat->term_id . '">' . esc_html($row_cat->name) . '</a>';
        } else {
            $before_cat = "";
            $categories_list = get_the_term_list(get_the_id(), 'category', $before_cat, ' ', '');
            if ( $categories_list ) {
                printf('%1$s', $categories_list);
            }
            // End if Categories 
        }
    }

}

if ( ! function_exists('wp_rem_cs_get_single_category') ) {

    function wp_rem_cs_get_single_category($post_id) {

        $categories_list = get_the_category($post_id);
        if ( isset($categories_list[0]) && is_object($categories_list[0]) ) {
            $cat_id = $categories_list[0]->term_id;
            $cat_name = $categories_list[0]->name;
            $cat_link = get_term_link($cat_id);
            $cat_meta = get_term_meta($cat_id, 'cat_meta_data', true);
            $cat_color = isset($cat_meta['cat_color']) ? $cat_meta['cat_color'] : '';

            $category_color = '';
            if ( $cat_color != '' ) {
                $category_color = ' style="background:' . wp_rem_cs_allow_special_char($cat_color) . ';"';
            }

            return '<a href="' . esc_url($cat_link) . '" class="category"' . wp_rem_cs_allow_special_char($category_color) . '>' . esc_html($cat_name) . '</a>';
        }
    }

}
