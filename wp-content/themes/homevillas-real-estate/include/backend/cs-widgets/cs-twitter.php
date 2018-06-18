<?php

/**
 * Wp_rem_cs_Twitter_Widget Class
 *
 * @package Wp_rem_cs
 */
if (!class_exists('Wp_rem_cs_Twitter_Widget')) {

    /**
      Wp_rem_cs_Weather class used to implement the custom weather widget.
     */
    class Wp_rem_cs_Twitter_Widget extends WP_Widget {

	/**
	 * Sets up a new wp_rem_cs twitter widget instance.
	 */
	public function __construct() {
	    global $wp_rem_cs_var_static_text;
	    parent::__construct(
		    'wp_rem_cs_var_twitter_widget', // Base ID.
		    wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_widget'), // Name.
		    array('classname' => 'twitter-post', 'description' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_widget_desciption'))
	    );
	}

	/**
	 * Outputs the wp_rem_cs twitter widget settings form.
	 *
	 * @param array $instance Current settings.
	 */
	function form($instance) {
	    global $wp_rem_cs_var_form_fields, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_static_text;
	    $strings = new wp_rem_cs_theme_all_strings;
	    $strings->wp_rem_cs_short_code_strings();
	    $instance = wp_parse_args((array) $instance, array('title' => ''));
	    $title = $instance['title'];
	    $username = isset($instance['username']) ? esc_attr($instance['username']) : '';
	    $numoftweets = isset($instance['numoftweets']) ? esc_attr($instance['numoftweets']) : '';

	    $wp_rem_cs_opt_array = array(
		'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_title_field'),
		'desc' => '',
		'hint_text' => '',
		'echo' => true,
		'field_params' => array(
		    'std' => esc_html($title),
		    'id' => '',
		    'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('title')),
		    'cust_id' => wp_rem_cs_allow_special_char($this->get_field_name('title')),
		    'return' => true,
		),
	    );
	    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

	    $wp_rem_cs_opt_array = array(
		'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_widget_user_name'),
		'desc' => '',
		'hint_text' => '',
		'echo' => true,
		'field_params' => array(
		    'std' => esc_html($username),
		    'id' => '',
		    'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('username')),
		    'cust_id' => wp_rem_cs_allow_special_char($this->get_field_name('username')),
		    'return' => true,
		),
	    );
	    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

	    $wp_rem_cs_opt_array = array(
		'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_widget_tweets_num'),
		'desc' => '',
		'hint_text' => '',
		'echo' => true,
		'field_params' => array(
		    'std' => esc_html($numoftweets),
		    'id' => '',
		    'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('numoftweets')),
		    'cust_id' => wp_rem_cs_allow_special_char($this->get_field_name('numoftweets')),
		    'return' => true,
		),
	    );
	    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
	}

	/**
	 * Handles updating settings for the current wp_rem_cs twitter widget instance.
	 *
	 * @param array $new_instance New settings for this instance as input by the user.
	 * @param array $old_instance Old settings for this instance.
	 * @return array Settings to save or bool false to cancel saving.
	 */
	function update($new_instance, $old_instance) {

	    $instance = $old_instance;
	    $instance['title'] = $new_instance['title'];
	    $instance['username'] = $new_instance['username'];
	    $instance['numoftweets'] = $new_instance['numoftweets'];
	    return $instance;
	}

	/**
	 * Outputs the content for the current wp_rem_cs twitter widget instance.
	 *
	 * @param array $args Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current twitter widget instance.
	 */
	function widget($args, $instance) {
	    global $wp_rem_cs_var_options, $wp_rem_cs_twitter_arg;

	    // include_once ABSPATH . 'wp-admin/includes/plugin.php';
	    if (is_plugin_active('wp-realestate-manager/wp-realestate-manager.php')) {
		global $wp_rem_plugin_options;
		$wp_rem_cs_twitter_arg['consumerkey'] = isset($wp_rem_plugin_options['wp_rem_consumer_key']) ? $wp_rem_plugin_options['wp_rem_consumer_key'] : '';
		$wp_rem_cs_twitter_arg['consumersecret'] = isset($wp_rem_plugin_options['wp_rem_consumer_secret']) ? $wp_rem_plugin_options['wp_rem_consumer_secret'] : '';
		$wp_rem_cs_twitter_arg['accesstoken'] = isset($wp_rem_plugin_options['wp_rem_access_token']) ? $wp_rem_plugin_options['wp_rem_access_token'] : '';
		$wp_rem_cs_twitter_arg['accesstokensecret'] = isset($wp_rem_plugin_options['wp_rem_access_token_secret']) ? $wp_rem_plugin_options['wp_rem_access_token_secret'] : '';
		$wp_rem_cs_cache_limit_time = isset($wp_rem_plugin_options['wp_rem_cache_limit_time']) ? $wp_rem_plugin_options['wp_rem_cs_var_cache_limit_time'] : '';
		$wp_rem_cs_tweet_num_from_twitter = isset($wp_rem_plugin_options['wp_rem_tweet_num_post']) ? $wp_rem_plugin_options['wp_rem_cs_var_tweet_num_post'] : '';
		$wp_rem_cs_twitter_datetime_formate = isset($wp_rem_plugin_options['wp_rem_twitter_datetime_formate']) ? $wp_rem_plugin_options['wp_rem_cs_var_twitter_datetime_formate'] : '';
	    } else {
		$wp_rem_cs_twitter_arg['consumerkey'] = isset($wp_rem_cs_var_options['wp_rem_cs_var_consumer_key']) ? $wp_rem_cs_var_options['wp_rem_cs_var_consumer_key'] : '';
		$wp_rem_cs_twitter_arg['consumersecret'] = isset($wp_rem_cs_var_options['wp_rem_cs_var_consumer_secret']) ? $wp_rem_cs_var_options['wp_rem_cs_var_consumer_secret'] : '';
		$wp_rem_cs_twitter_arg['accesstoken'] = isset($wp_rem_cs_var_options['wp_rem_cs_var_access_token']) ? $wp_rem_cs_var_options['wp_rem_cs_var_access_token'] : '';
		$wp_rem_cs_twitter_arg['accesstokensecret'] = isset($wp_rem_cs_var_options['wp_rem_cs_var_access_token_secret']) ? $wp_rem_cs_var_options['wp_rem_cs_var_access_token_secret'] : '';
		$wp_rem_cs_cache_limit_time = isset($wp_rem_cs_var_options['wp_rem_cs_var_cache_limit_time']) ? $wp_rem_cs_var_options['wp_rem_cs_var_cache_limit_time'] : '';
		$wp_rem_cs_tweet_num_from_twitter = isset($wp_rem_cs_var_options['wp_rem_cs_var_tweet_num_post']) ? $wp_rem_cs_var_options['wp_rem_cs_var_tweet_num_post'] : '';
		$wp_rem_cs_twitter_datetime_formate = isset($wp_rem_cs_var_options['wp_rem_cs_var_twitter_datetime_formate']) ? $wp_rem_cs_var_options['wp_rem_cs_var_twitter_datetime_formate'] : '';
	    }

	    if ('' === intval($wp_rem_cs_cache_limit_time)) {
		$wp_rem_cs_cache_limit_time = 60;
	    }
	    if ('' === $wp_rem_cs_twitter_datetime_formate) {
		$wp_rem_cs_twitter_datetime_formate = 'time_since';
	    }

	    if ('' === intval($wp_rem_cs_tweet_num_from_twitter)) {
		$wp_rem_cs_tweet_num_from_twitter = 5;
	    }
	    extract($args, EXTR_SKIP);
	    $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
	    $title = htmlspecialchars_decode(stripslashes($title));
	    $username = $instance['username'];
	    $numoftweets = $instance['numoftweets'];

	    if ('' === intval($numoftweets)) {
		$numoftweets = 2;
	    }

	    echo wp_rem_cs_allow_special_char($before_widget);
	    if (!empty($title) && ' ' !== $title) {
		echo wp_rem_cs_allow_special_char($args['before_title'] . esc_html($title) . $args['after_title']);
	    }
	    if (class_exists('wp_rem_real_estate_framework')) {
		if (strlen($username) > 1) {
		    wp_rem_cs_include_file(wp_rem_real_estate_framework::plugin_path() . '/includes/cs-twitter/display-tweets.php');
		    display_tweets($username, $wp_rem_cs_twitter_datetime_formate, $wp_rem_cs_tweet_num_from_twitter, $numoftweets, $wp_rem_cs_cache_limit_time);
		}
	    }
	    echo wp_rem_cs_allow_special_char($after_widget);
	}

    }

}
add_action('widgets_init', create_function('', 'return register_widget("Wp_rem_cs_Twitter_Widget");'));


