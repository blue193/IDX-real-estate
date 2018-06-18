<?php
/**
 * @Spacer html form for page builder
 */
if (!function_exists('wp_rem_cs_sitemap')) {

    function wp_rem_cs_sitemap($atts, $content = "") {
        global $wp_rem_cs_border, $wp_rem_cs_var_plugin_options, $wp_rem_cs_var_static_text;
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_theme_option_strings();
        $wp_rem_cs_search_result_page = isset($wp_rem_cs_var_plugin_options['wp_rem_cs_search_result_page']) ? $wp_rem_cs_var_plugin_options['wp_rem_cs_search_result_page'] : '';

        $defaults = array(
            'wp_rem_cs_sitemap_section_title' => '',
            'wp_rem_cs_sitemap_section_subtitle' => '',
            'wp_rem_var_sitemap_align' => ''
        );
        extract(shortcode_atts($defaults, $atts));

        $wp_rem_cs_sitemap_section_title = $wp_rem_cs_sitemap_section_title ? $wp_rem_cs_sitemap_section_title : '';
        ob_start();
        ?>
        <div class="row">
            <div class="sitemap-links">	
                <?php
                $wp_rem_cs_elemement = '';
                $wp_rem_cs_elemement = wp_rem_title_sub_align($wp_rem_cs_sitemap_section_title, $wp_rem_cs_sitemap_section_subtitle, $wp_rem_var_sitemap_align);
                echo force_balance_tags($wp_rem_cs_elemement);
                ?>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="site-maps-links">
                        <h3><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_pages')); ?></h3>
                        <ul>
                            <?php
                            $args = array(
                                'posts_per_page' => "-1",
                                'post_type' => 'page',
                                'order' => 'ASC',
                                'post_status' => 'publish',
                            );
                            $query = new WP_Query($args);
                            $post_count = $query->post_count;
                            if ($query->have_posts()) {
                                while ($query->have_posts()) : $query->the_post();
                                    ?>
                                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                    <?php
                                endwhile;
                            }
                            wp_reset_postdata();
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="site-maps-links">
                        <h4><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_posts')); ?></h4>
                        <ul>
                            <?php
                            $args = array(
                                'posts_per_page' => "-1",
                                'post_type' => 'post',
                                'order' => 'ASC',
                                'post_status' => 'publish',
                            );
                            $query = new WP_Query($args);
                            $post_count = $query->post_count;
                            if ($query->have_posts()) {
                                while ($query->have_posts()) : $query->the_post();
                                    ?>
                                    <li><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), 3, '...'); ?></a></li>
                                    <?php
                                endwhile;
                            }
                            wp_reset_postdata();
                            ?>
                        </ul>
                    </div>	
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="site-maps-links">
                        <h4><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_categories')); ?></h4>
                        <ul>
                            <?php
                            $args = array(
                                'show_option_all' => '',
                                'order' => 'ASC',
                                'post_type' => 'post',
                                'order' => 'ASC',
                                'style' => 'list',
                                'title_li' => '',
                                'taxonomy' => 'category'
                            );

                            wp_list_categories($args);
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="site-maps-links">
                        <h4><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tag')); ?></h4>
                        <ul>
                            <?php
                            $tags = get_tags(array('order' => 'ASC', 'post_type' => 'post', 'order' => 'DESC'));
                            foreach ((array) $tags as $tag) {
                                ?>
                                <li> <?php echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" rel="tag">' . esc_html($tag->name) . ' (' . esc_html($tag->count) . ') </a>'; ?></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $wp_rem_cs_sitemap = ob_get_clean();
        return do_shortcode($wp_rem_cs_sitemap);
    }

    if (function_exists('wp_rem_cs_var_short_code')) {
        wp_rem_cs_var_short_code('wp_rem_cs_sitemap', 'wp_rem_cs_sitemap');
    }
}