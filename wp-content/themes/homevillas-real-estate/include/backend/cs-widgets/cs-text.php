<?php

/**
 * @Text widget Class
 *
 *
 */
class Wp_rem_cs_text extends WP_Widget {

    /**
     * @init Text Module
     *
     *
     */
    public function __construct() {
	global $wp_rem_cs_var_static_text;

	parent::__construct(
		'wp_rem_cs_text_id', // Base ID
		wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_text_widget'), // Name
		array('classname' => 'widget-text', 'description' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_text_widget_description'),) // Args
		
	);
    }

    /**
     * Author posts html form
     *
     *
     */
    function form($instance) {
	global $wp_rem_cs_var_form_fields, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_static_text;
	$strings = new wp_rem_cs_theme_all_strings;
	$strings->wp_rem_cs_short_code_strings();
	$instance = wp_parse_args((array) $instance, array('title' => ''));
	$title = isset($instance['title']) ? $instance['title'] : '';
	$description = isset($instance['description']) ? $instance['description'] : '';

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


	$wp_rem_cs_opt_array = array(
	    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_content'),
	    'desc' => '',
	    'echo' => true,
	    'field_params' => array(
		'std' => esc_attr($description),
		'id' => wp_rem_cs_allow_special_char($this->get_field_id('description')),
		'classes' => 'txtfield',
		'cust_id' => wp_rem_cs_allow_special_char($this->get_field_name('description')),
		'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('description')),
		'return' => true,
		'required' => false,
	    ),
	);
	$wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);

	/*
	 * getting All user and form an array that contain user name as value and user id as key
	 */
    }

    /**
     * @Author update form data
     *
     *
     */
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = $new_instance['title'];
	$instance['description'] = $new_instance['description'];

	return $instance;
    }

    /**
     * @Display Author posts widget
     *
     */
    function widget($args, $instance) {
	global $wp_rem_cs_node, $wpdb, $post, $wp_rem_cs_var_static_text;
	extract($args, EXTR_SKIP);
	$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
	$description = empty($instance['description']) ? ' ' : $instance['description'];
	$title = htmlspecialchars_decode(stripslashes($title));
	echo '  <div class="widget widget-text">';
	echo '<div class="widget-title"><h5>' . $title . '</h5></div>
	                <div class="cs-text">
	                 ' . do_shortcode($description) . '
	                </div>
	             </div>';
	
	// User Loop
    }

}

add_action('widgets_init', create_function('', 'return register_widget("Wp_rem_cs_text");'));
