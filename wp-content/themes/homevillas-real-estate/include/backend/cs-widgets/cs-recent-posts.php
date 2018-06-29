<?php

/**
 * @Recent posts widget Class
 *
 *
 */
class Wp_rem_cs_recentposts extends WP_Widget {

    /**
     * @init Recent posts Module
     *
     *
     */
    public function __construct() {
	global $wp_rem_cs_var_static_text;

	parent::__construct(
		'wp_rem_cs_recentposts_id', // Base ID
		wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_recent_post'), // Name
		array('classname' => 'widget-recent-blog', 'description' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_recent_post_des'),) // Args
	);
    }

    /**
     * @Recent posts html form
     *
     *
     */
    function form($instance) {
	global $wp_rem_cs_var_form_fields, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_static_text;
	$strings = new wp_rem_cs_theme_all_strings;
	$strings->wp_rem_cs_short_code_strings();
	$instance = wp_parse_args((array) $instance, array('title' => ''));
	$title = $instance['title'];
	$select_category = isset($instance['select_category']) ? esc_attr($instance['select_category']) : '';
	$select_blog_views = isset($instance['select_blog_views']) ? esc_attr($instance['select_blog_views']) : '';
	$showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';
	$wp_rem_cs_opt_array = array(
	    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_title_field'),
	    'desc' => '',
	    'hint_text' => '',
	    'echo' => true,
	    'field_params' => array(
		'std' => esc_attr($title),
		'id' => wp_rem_cs_allow_special_char($this->get_field_id('title')),
		'classes' => '',
		'cust_id' => wp_rem_cs_allow_special_char($this->get_field_name('title')),
		'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('title')),
		'return' => true,
		'required' => false
	    ),
	);
	$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
	if (function_exists('wp_rem_cs_show_all_cats')) {
	    $default_option = $cats_options = array();
	    $default_option[''] = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_all_cats');
	    $cats_options = wp_rem_cs_show_all_cats('', '', wp_rem_cs_allow_special_char($this->get_field_id('select_category')), 'category', true);
	    $cats_options = array_merge($default_option, $cats_options);
	    $wp_rem_cs_opt_array = array(
		'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_choose_category'),
		'desc' => '',
		'hint_text' => '',
		'echo' => true,
		'field_params' => array(
		    'std' => $select_category,
		    'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('select_category')),
		    'cust_id' => wp_rem_cs_allow_special_char($this->get_field_id('select_category')),
		    'id' => '',
		    'options' => $cats_options,
		    
		    'return' => true,
		),
	    );

	    $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
	}

	$wp_rem_cs_opt_array = array(
	    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_blog_widget_style_desc'),
	    'desc' => '',
	    'hint_text' => '',
	    'echo' => true,
	    'field_params' => array(
		'std' => $select_blog_views,
		'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('select_blog_views')),
		'cust_id' => wp_rem_cs_allow_special_char($this->get_field_id('select_blog_views')),
		'id' => '',
		'options' => array(
		    'yes' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_thumbnail_display_show_yes'),
		    'no' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_thumbnail_display_show_no'),
		),
		
		'return' => true,
	    ),
	);

	$wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
	$wp_rem_cs_opt_array = array(
	    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_num_post'),
	    'desc' => '',
	    'hint_text' => '',
	    'echo' => true,
	    'field_params' => array(
		'std' => esc_attr($showcount),
		'id' => wp_rem_cs_allow_special_char($this->get_field_id('showcount')),
		'classes' => '',
		'cust_id' => wp_rem_cs_allow_special_char($this->get_field_name('showcount')),
		'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('showcount')),
		'return' => true,
		'required' => false
	    ),
	);
	$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

	$wp_rem_cs_inline_script = 'jQuery(document).ready(function ($) {
				chosen_selectionbox();
			});';
	wp_rem_cs_admin_inline_enqueue_script($wp_rem_cs_inline_script, 'wp_rem_cs-custom-functions');
    }

    /**
     * @Recent posts update form data
     *
     *
     */
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = $new_instance['title'];
	$instance['select_category'] = $new_instance['select_category'];
	$instance['select_blog_views'] = $new_instance['select_blog_views'];
	$instance['showcount'] = $new_instance['showcount'];
	return $instance;
    }

    /**
     * @Display Recent posts widget
     *
     */
    function widget($args, $instance) {
	global $wp_rem_cs_node, $wpdb, $post, $wp_rem_cs_var_static_text;
	extract($args, EXTR_SKIP);
	$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
	$title = htmlspecialchars_decode(stripslashes($title));
	$select_category = empty($instance['select_category']) ? '' : apply_filters('widget_title', $instance['select_category']);
	$select_blog_views = empty($instance['select_blog_views']) ? '' : apply_filters('widget_title', $instance['select_blog_views']);
	$showcount = empty($instance['showcount']) ? ' ' : apply_filters('widget_title', $instance['showcount']);
	if ($instance['showcount'] == "") {
	    $instance['showcount'] = '-1';
	}
	echo '<div class="widget widget-latest-post">';
	if (!empty($title) && $title <> ' ') {
	    echo '<div class="widget-title">';
	    echo '<h5>' . wp_rem_cs_allow_special_char($title) . '</h5>';
	    echo '</div>';
	}
	?>

	<?php
	if (isset($select_category) && $select_category <> '') {
	    $args = array('posts_per_page' => $showcount, 'post_type' => 'post', 'category_name' => $select_category);
	} else {
	    $args = array('posts_per_page' => $showcount, 'post_type' => 'post');
	}
	$title_limit = 4;
	$custom_query2 = new WP_Query($args);
	if ($custom_query2->have_posts() <> "") {
	    echo '<ul>';
	    while ($custom_query2->have_posts()) : $custom_query2->the_post();
		?>
		<li>
		    <?php if ($select_blog_views == 'yes' && has_post_thumbnail()) { ?>
		        <div class="img-holder">
		    	<a href="<?php echo esc_url(get_permalink()); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
		        </div>
		    <?php } ?>
		    <div class="text-holder">
			<h6><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo wp_trim_words(get_the_title(),6); ?></a></h6>
			<div class="post-option">
			    <span class="post-date">
				<a href="<?php echo esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))); ?>"><?php echo get_the_date('j F Y'); ?></a>
			    </span>
			</div>
		    </div>
		</li>
		<?php
	    endwhile;
	    echo '</ul>';
	    wp_reset_postdata();
	} else {
	    echo '<p>' . esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_noresult_found')) . '</p>';
	}
	echo '</div>';
    }

}

add_action('widgets_init', create_function('', 'return register_widget("Wp_rem_cs_recentposts");'));
