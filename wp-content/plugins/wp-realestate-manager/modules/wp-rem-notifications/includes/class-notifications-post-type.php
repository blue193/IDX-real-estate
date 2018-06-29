<?php
/**
 * Create Custom Post Type and it's meta boxes for Property Alert Notifications
 *
 * @package	Homevillas
 */
// Direct access not allowed.
if ( ! defined('ABSPATH') ) {
    exit;
}

/**
 * WP_Property_Hunt_Custom_Post_Type class.
 */
class WP_Property_Hunt_Custom_Post_Type {

    /**
     * Constructor
     */
    public function __construct() {
        //$this->create_property_alert_post_type();
        add_action('init', array( $this, 'create_property_alert_post_type' ), 10);

        // add column 
        add_filter('manage_property-alert_posts_columns', array( $this, 'wp_rem_property_alert_columns_add' ));
        add_action('manage_property-alert_posts_custom_column', array( $this, 'wp_rem_property_alert_columns' ), 10, 2);



        // Configure meta boxes to be created for Property Notifications property type.
        add_action('add_meta_boxes', array( $this, 'wp_rem_add_meta_boxes_to_property_alerts' ));

        // Handle AJAX to create a property alert.
        add_action('wp_ajax_wp_rem_create_property_alert', array( $this, 'create_property_alert_callback' ));
        add_action('wp_ajax_nopriv_wp_rem_create_property_alert', array( $this, 'create_property_alert_callback' ));

        // Handle AJAX to delete a property alert.
        add_action('wp_ajax_wp_rem_remove_property_alert', array( $this, 'remove_property_alert_callback' ));
        add_action('wp_ajax_nopriv_wp_rem_remove_property_alert', array( $this, 'remove_property_alert_callback' ));

        // Handle AJAX to delete a property alert.
        add_action('wp_ajax_wp_rem_unsubscribe_property_alert', array( $this, 'unsubscribe_property_alert' ));
        add_action('wp_ajax_nopriv_wp_rem_unsubscribe_property_alert', array( $this, 'unsubscribe_property_alert' ));

        add_action('admin_menu', array( $this, 'wp_rem_remove_post_boxes' ));
        add_action('do_meta_boxes', array( $this, 'wp_rem_remove_post_boxes' ));
		
		// Custom Sort Columns
		add_filter( 'manage_edit-property-alert_sortable_columns', array($this, 'wp_rem_email_alerts_sortable'));
		add_filter( 'request', array($this, 'wp_rem_email_alerts_column_orderby'));
		// Custom Filter
		add_action( 'restrict_manage_posts', array($this, 'wp_rem_admin_email_alerts_filter'), 11 );
		add_filter('parse_query', array( $this, 'wp_rem_admin_email_alerts_filter_query' ), 11, 1);
    }
	
	public function wp_rem_admin_email_alerts_filter(){
		global $wp_rem_form_fields, $post_type;

		//only add filter to post type you want
		if ($post_type == 'property-alert'){

			$alert_frequencies_options = array( 
				'' => wp_rem_plugin_text_srt('wp_rem_class_noti_post_type_email_frequemcies'),
				'annually' => wp_rem_plugin_text_srt('wp_rem_notification_post_annually'), 
				'biannually' => wp_rem_plugin_text_srt('wp_rem_notification_post_biannually'), 
				'monthly' => wp_rem_plugin_text_srt('wp_rem_notification_post_monthly'), 
				'fortnightly' => wp_rem_plugin_text_srt('wp_rem_notification_post_fortnightly'),
				'weekly' => wp_rem_plugin_text_srt('wp_rem_notification_post_weekly'),
				'daily' => wp_rem_plugin_text_srt('wp_rem_notification_post_daily'),
				'never' => wp_rem_plugin_text_srt('wp_rem_notification_post_never'),
			);
			$alert_frequency = isset($_GET['alert_frequency']) ? $_GET['alert_frequency'] : '';
			$wp_rem_opt_array = array(
				'std' => $alert_frequency,
				'id' => 'alert_frequency',
				'cust_name' => 'alert_frequency',
				'extra_atr' => '',
				'classes' => '',
				'options' => $alert_frequencies_options,
				'return' => false,
			);
			$wp_rem_form_fields->wp_rem_form_select_render($wp_rem_opt_array);
		}
	}

	public function wp_rem_admin_email_alerts_filter_query( $query ){
		global $pagenow;
		$custom_filter_arr = array();
		if ( is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'property-alert' && isset($_GET['alert_frequency']) && $_GET['alert_frequency'] != '' ) {
			$custom_filter_arr[] = array(
				'key' => 'wp_rem_frequency_'.$_GET['alert_frequency'],
				'value' => 'on',
				'compare' => '=',
			);
		}
		if( is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'property-alert' && !empty($custom_filter_arr)){
			$query->set( 'meta_query', $custom_filter_arr );
		}
	}
	
	public function wp_rem_email_alerts_sortable( $columns ){
		$columns['email'] = 'alert_email';
		$columns['serach_keyword'] = 'alert_serach_keyword';
		return $columns;
	}
	
	public function wp_rem_email_alerts_column_orderby(  $vars ){
		if ( isset( $vars['orderby'] ) && 'alert_email' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => 'wp_rem_email',
				'orderby' => 'meta_value',
			) );

		}
		if ( isset( $vars['orderby'] ) && 'alert_query' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => 'wp_rem_query',
				'orderby' => 'meta_value',
			) );

		}
		return $vars;
	}

    public function wp_rem_property_alert_columns_add($columns) {

        unset($columns['date']);
        $columns['email'] = wp_rem_plugin_text_srt('wp_rem_notification_post_lao_email');
        $columns['frequency'] = wp_rem_plugin_text_srt('wp_rem_class_noti_post_type_email_frequemcies');
        $columns['serach_keyword'] = wp_rem_plugin_text_srt('wp_rem_class_noti_post_type_keywords_search');
        return $columns;
    }

    public function wp_rem_property_alert_columns($name) {
        global $post;

        switch ( $name ) {
            default:
                //echo "name is " . $name;
                break;
            case 'email':
                $wp_rem_email = get_post_meta($post->ID, 'wp_rem_email', true);
				if ( isset( $wp_rem_email ) && $wp_rem_email != '' ) {
					$user = get_user_by( 'email', $wp_rem_email );
					$user_id = '';
					if( !empty($user )){
						$user_id = $user->ID;
					}
					if ( $user_id !== '' ) {
						echo '<a href="'. esc_url(get_edit_user_link( $user_id )) .'">'. esc_html( $wp_rem_email ) .'</a>';
					}else{
						echo esc_html( $wp_rem_email );
					}
				} else {
					echo '-';
				}
				break;
            case 'frequency':
                $wp_rem_frequency_annually = get_post_meta($post->ID, 'wp_rem_frequency_annually', true);
                $wp_rem_frequency_biannually = get_post_meta($post->ID, 'wp_rem_frequency_biannually', true);
                $wp_rem_frequency_monthly = get_post_meta($post->ID, 'wp_rem_frequency_monthly', true);
                $wp_rem_frequency_fortnightly = get_post_meta($post->ID, 'wp_rem_frequency_fortnightly', true);
                $wp_rem_frequency_weekly = get_post_meta($post->ID, 'wp_rem_frequency_weekly', true);
                $wp_rem_frequency_daily = get_post_meta($post->ID, 'wp_rem_frequency_daily', true);
                $wp_rem_frequency_never = get_post_meta($post->ID, 'wp_rem_frequency_never', true);
                $frequency_array = array();
                if ( isset($wp_rem_frequency_annually) && $wp_rem_frequency_annually == 'on' ) {
                    $frequency_array[] = wp_rem_plugin_text_srt('wp_rem_notification_post_annually');
                }
                if ( isset($wp_rem_frequency_biannually) && $wp_rem_frequency_biannually == 'on' ) {
                    $frequency_array[] = wp_rem_plugin_text_srt('wp_rem_notification_post_biannually');
                }
                if ( isset($wp_rem_frequency_monthly) && $wp_rem_frequency_monthly == 'on' ) {
                    $frequency_array[] = wp_rem_plugin_text_srt('wp_rem_notification_post_monthly');
                }
                if ( isset($wp_rem_frequency_fortnightly) && $wp_rem_frequency_fortnightly == 'on' ) {
                    $frequency_array[] = wp_rem_plugin_text_srt('wp_rem_notification_post_fortnightly');
                }
                if ( isset($wp_rem_frequency_weekly) && $wp_rem_frequency_weekly == 'on' ) {
                    $frequency_array[] = wp_rem_plugin_text_srt('wp_rem_notification_post_weekly');
                }
                if ( isset($wp_rem_frequency_daily) && $wp_rem_frequency_daily == 'on' ) {
                    $frequency_array[] = wp_rem_plugin_text_srt('wp_rem_notification_post_daily');
                }
                if ( isset($wp_rem_frequency_never) && $wp_rem_frequency_never == 'on' ) {
                    $frequency_array[] = wp_rem_plugin_text_srt('wp_rem_notification_post_never');
                }
                echo esc_html(implode(", ", $frequency_array));
                break;
            case 'serach_keyword':
                $wp_rem_query = get_post_meta($post->ID, 'wp_rem_query', true);
                $search_keywords = WP_Property_Hunt_Alert_Helpers::query_to_array($wp_rem_query);
                $all_words_search = array();
                foreach ( $search_keywords as $key => $value ) {
                    if ( 'ajax_filter' == $key || 'advanced_search' == $key || 'property_arg' == $key || 'action' == $key || 'alert-frequency' == $key || 'alerts-name' == $key || 'loc_polygon' == $key || 'alerts-email' == $key || 'loc_polygon_path' == $key ){
                        continue;
                    }
                    $key = str_replace("wp_rem_wp_rem_", "", $key);
                    $key = str_replace("_", " ", $key);
                    $all_words_search[] = ucfirst($key) . ' : ' . $value . ' ';
                }
                $all_search_words = implode(', ', array_values($all_words_search));
                if ( $all_search_words != '' ) {
                    echo esc_html($all_search_words);
                } else {
                    echo wp_rem_plugin_text_srt('wp_rem_alerts_all_properties');
                }
                break;
        }
    }

    /**
     * Register Custom Post Type for Property Notifications
     */
    public function create_property_alert_post_type() {
        // Check if post type already exists then don't register
        if ( post_type_exists("property_hunt_notification") ) {
            return;
        }
        $labels = array(
            'name' => wp_rem_plugin_text_srt('wp_rem_notification_post_name'),
            'singular_name' => wp_rem_plugin_text_srt('wp_rem_notification_post_singular_name'),
            'menu_name' => wp_rem_plugin_text_srt('wp_rem_notification_post_menu_name'),
            'name_admin_bar' => wp_rem_plugin_text_srt('wp_rem_notification_post_name_admin'),
            'add_new' => wp_rem_plugin_text_srt('wp_rem_notification_post_add_new'),
            'add_new_item' => wp_rem_plugin_text_srt('wp_rem_notification_post_add_new_item'),
            'new_item' => wp_rem_plugin_text_srt('wp_rem_notification_post_new_item'),
            'edit_item' => wp_rem_plugin_text_srt('wp_rem_notification_post_edit_item'),
            'view_item' => wp_rem_plugin_text_srt('wp_rem_notification_post_view_item'),
            'all_items' => wp_rem_plugin_text_srt('wp_rem_notification_post_all_item'),
            'search_items' => wp_rem_plugin_text_srt('wp_rem_notification_post_search_item'),
            'parent_item_colon' => wp_rem_plugin_text_srt('wp_rem_notification_post_parent_clone'),
            'not_found' => wp_rem_plugin_text_srt('wp_rem_notification_post_not_found'),
            'not_found_in_trash' => wp_rem_plugin_text_srt('wp_rem_notification_post_not_found_trash'),
        );

        $args = array(
            'labels' => $labels,
            'description' => wp_rem_plugin_text_srt('wp_rem_notification_post_description'),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => 'edit.php?post_type=jh-templates',
            'query_var' => true,
            'capability_type' => 'post',
            'publicly_queryable' => false,
            'exclude_from_search' => true,
            'hierarchical' => false,
            'rewrite' => array( 'slug' => 'property-alert' ),
            'supports' => false,
            'has_archive' => false,
            'capabilities' => array(
                'create_posts' => 'do_not_allow', // Removes support for the "Add New" function ( use 'do_not_allow' instead of false for multisite set ups )
            ),
            'map_meta_cap' => true,// Set to `false`, if users are not allowed to edit/delete existing posts
        );

        // Register custom post type.
        register_post_type("property-alert", $args);
    }

    /**
     * Add meta boxes for Custom post type Property Alerts
     */
    public function wp_rem_add_meta_boxes_to_property_alerts() {
        add_meta_box('wp_rem_meta_properties', wp_rem_plugin_text_srt('wp_rem_notification_post_property_alerts_options'), array( $this, 'wp_rem_create_meta_boxes_to_property_alerts' ), 'property-alert', 'normal', 'high');
    }

    public function wp_rem_create_meta_boxes_to_property_alerts() {
        global $post;
        ?>
        <div class="page-wrap page-opts left">
            <div class="option-sec" style="margin-bottom:0;">
                <div class="opt-conts">
                    <div class="elementhidden">
                        <?php $this->wp_rem_property_alert_options(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <?php
    }

    public function wp_rem_property_alert_options() {
        global $post, $wp_rem_html_fields;
        $wp_rem_opt_array = array(
            'name' => wp_rem_plugin_text_srt('wp_rem_notification_post_lao_email'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => get_post_meta($post->ID, 'wp_rem_email', true),
                'id' => 'email',
                'return' => true,
            ),
        );
        $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

        $wp_rem_opt_array = array(
            'name' => wp_rem_plugin_text_srt('wp_rem_notification_post_lao_name'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => get_post_meta($post->ID, 'wp_rem_name', true),
                'id' => 'name',
                'return' => true,
            ),
        );
        $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
        $wp_rem_opt_array = array(
            'name' => wp_rem_plugin_text_srt('wp_rem_notification_post_query'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => get_post_meta($post->ID, 'wp_rem_query', true),
                'id' => 'query',
                'return' => true,
            ),
        );
        $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

        $wp_rem_opt_array = array(
            'name' => wp_rem_plugin_text_srt('wp_rem_notification_post_complete_url'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => get_post_meta($post->ID, 'wp_rem_complete_url', true),
                'id' => 'complete_url',
                'return' => true,
            ),
        );
        $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);


        $on_off_option = array( 'yes' => wp_rem_plugin_text_srt('wp_rem_notification_post_options_yes'), 'no' => wp_rem_plugin_text_srt('wp_rem_notification_post_options_no') );
        $wp_rem_opt_array = array(
            "name" => wp_rem_plugin_text_srt('wp_rem_notification_post_annually'),
            "desc" => "",
            "hint_text" => wp_rem_plugin_text_srt('wp_rem_notification_post_annually_hint'),
            'echo' => true,
            "options" => $on_off_option,
            'field_params' => array(
                'std' => get_post_meta($post->ID, 'wp_rem_frequency_annually', true),
                'id' => 'frequency_annually',
                'return' => true,
            ),
        );
        $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);
        $wp_rem_opt_array = array(
            "name" => wp_rem_plugin_text_srt('wp_rem_notification_post_biannually'),
            "desc" => "",
            "hint_text" => wp_rem_plugin_text_srt('wp_rem_notification_post_biannually_hint'),
            'echo' => true,
            "options" => $on_off_option,
            'field_params' => array(
                'std' => get_post_meta($post->ID, 'wp_rem_frequency_biannually', true),
                'id' => 'frequency_biannually',
                'return' => true,
            ),
        );
        $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);
        $wp_rem_opt_array = array(
            "name" => wp_rem_plugin_text_srt('wp_rem_notification_post_monthly'),
            "desc" => "",
            "hint_text" => wp_rem_plugin_text_srt('wp_rem_notification_post_monthly_hint'),
            'echo' => true,
            "options" => $on_off_option,
            'field_params' => array(
                'std' => get_post_meta($post->ID, 'wp_rem_frequency_monthly', true),
                'id' => 'frequency_monthly',
                'return' => true,
            ),
        );
        $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);
        $wp_rem_opt_array = array(
            "name" => wp_rem_plugin_text_srt('wp_rem_notification_post_fortnightly'),
            "desc" => "",
            "hint_text" => wp_rem_plugin_text_srt('wp_rem_notification_post_fortnightly_hint'),
            'echo' => true,
            "options" => $on_off_option,
            'field_params' => array(
                'std' => get_post_meta($post->ID, 'wp_rem_frequency_fortnightly', true),
                'id' => 'frequency_fortnightly',
                'return' => true,
            ),
        );
        $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);
        $wp_rem_opt_array = array(
            "name" => wp_rem_plugin_text_srt('wp_rem_notification_post_weekly'),
            "desc" => "",
            "hint_text" => wp_rem_plugin_text_srt('wp_rem_notification_post_weekly_hint'),
            'echo' => true,
            "options" => $on_off_option,
            'field_params' => array(
                'std' => get_post_meta($post->ID, 'wp_rem_frequency_weekly', true),
                'id' => 'frequency_weekly',
                'return' => true,
            ),
        );
        $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);
        $wp_rem_opt_array = array(
            "name" => wp_rem_plugin_text_srt('wp_rem_notification_post_daily'),
            "desc" => "",
            "hint_text" => wp_rem_plugin_text_srt('wp_rem_notification_post_daily_hint'),
            'echo' => true,
            "options" => $on_off_option,
            'field_params' => array(
                'std' => get_post_meta($post->ID, 'wp_rem_frequency_daily', true),
                'id' => 'frequency_daily',
                'return' => true,
            ),
        );
        $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);
        $wp_rem_opt_array = array(
            "name" => wp_rem_plugin_text_srt('wp_rem_notification_post_never'),
            "desc" => "",
            "hint_text" => wp_rem_plugin_text_srt('wp_rem_notification_post_never_hint'),
            'echo' => true,
            "options" => $on_off_option,
            'field_params' => array(
                'std' => get_post_meta($post->ID, 'wp_rem_frequency_never', true),
                'id' => 'frequency_never',
                'return' => true,
            ),
        );
        $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);
    }

    public function create_property_alert_callback() {
        check_ajax_referer('wp_rem_create_property_alert', 'security');

        // Read data from user input.
        $email = sanitize_text_field($_POST['email']);
        $name = sanitize_text_field($_POST['name']);
        $location = sanitize_text_field($_POST['location']);
        $complete_url = $location;  // for permalink
        $query = end(explode('?', $location));
        $frequency = sanitize_text_field($_POST['frequency']);
        $properties_query = $_POST['query'];
        if ( empty($name) ) {
            $return = array(
                'type' => 'error',
                'msg' => wp_rem_plugin_text_srt('wp_rem_notification_post_title_not_empty'),
            );
            echo json_encode($return);
            wp_die();
        }
        if ( empty($email) || ! filter_var($email, FILTER_VALIDATE_EMAIL) ) {
            $return = array(
                'type' => 'error',
                'msg' => wp_rem_plugin_text_srt('wp_rem_notification_post_valid_email'),
            );
            echo json_encode($return);
            wp_die();
        }
        $meta_query = array(
            array(
                'key' => 'wp_rem_email',
                'value' => $email,
                'compare' => '=',
            ),
            array(
                'key' => 'wp_rem_frequency_' . $frequency,
                'value' => 'on',
                'compare' => '=',
            ),
        );
        if ( $properties_query <> '' ) {
            $meta_query[] = array(
                'key' => 'wp_rem_properties_query',
                'value' => $properties_query,
                'compare' => '=',
            );
        }
        $args = array(
            'post_type' => 'property-alert',
            'meta_query' => $meta_query,
        );

        $obj_query = new WP_Query($args);
        $count = $obj_query->post_count;
        if ( $count > 0 ) {
            $return = array(
                'type' => 'error',
                'msg' => wp_rem_plugin_text_srt('wp_rem_notification_post_laready_exists'),
            );
        } else {
            // Insert Property Alert as a post.
            $property_alert_data = array(
                'post_title' => $name,
                'post_status' => 'publish',
                'post_type' => 'property-alert',
                'comment_status' => 'closed',
                'post_author' => get_current_user_id(),
            );
            $property_alert_id = wp_insert_post($property_alert_data);
            // Update email.
            update_post_meta($property_alert_id, 'wp_rem_email', $email);
            // Update name.
            update_post_meta($property_alert_id, 'wp_rem_name', $name);
            // Update member.
            $member_id = get_user_meta(get_current_user_id(), 'wp_rem_company', true);
            update_post_meta($property_alert_id, 'wp_rem_member', $member_id);

            // Update frequencies.

            $frequencies = array(
                'annually',
                'biannually',
                'monthly',
                'fortnightly',
                'weekly',
                'daily',
                'never',
            );
            $selected_frequencies = explode(',', $frequency);
            foreach ( $selected_frequencies as $key => $frequency ) {
                if ( in_array($frequency, $frequencies) ) {
                    update_post_meta($property_alert_id, 'wp_rem_frequency_' . $frequency, 'on');
                }
            }
            // Update query.
            update_post_meta($property_alert_id, 'wp_rem_query', $query);
            // complete url 
            update_post_meta($property_alert_id, 'wp_rem_complete_url', $complete_url);
            // Last time email sent.
            update_post_meta($property_alert_id, 'wp_rem_last_time_email_sent', 0);
            // Query.
            update_post_meta($property_alert_id, 'wp_rem_properties_query', $properties_query);
            $return = array(
                'type' => 'success',
                'msg' => wp_rem_plugin_text_srt('wp_rem_notification_post_successfully_added'),
            );
        }
        echo json_encode($return);
        wp_die();
    }

    public function unsubscribe_property_alert() {
        $property_alert_id = sanitize_text_field($_REQUEST['jaid']);
        $post_data = get_post($property_alert_id);
        if ( $post_data ) {
            wp_delete_post($property_alert_id);
            echo '<div class="property_alert_unsubscribe_msg" style="text-align: center;"><h3>' . wp_rem_plugin_text_srt('wp_rem_notification_post_successfully_unsubcribe') . '</h3></div>';
        } else {
            echo '<div class="property_alert_unsubscribe_msg" style="text-align: center;"><h3>' . wp_rem_plugin_text_srt('wp_rem_notification_post_already_subcribe') . '</h3></div>';
        }
        die();
    }

    public function remove_property_alert_callback() {
        $status = 0;
        $msg = '';
        if ( isset($_POST['post_id']) ) {
            wp_delete_post($_POST['post_id']);
            $status = 1;
            $msg = wp_rem_plugin_text_srt('wp_rem_notification_post_successfully_deleted');
        } else {
            $msg = wp_rem_plugin_text_srt('wp_rem_notification_post_provided_data_incomplete');
            $status = 0;
        }
        echo json_encode(array( "msg" => $msg, 'status' => $status ));
        wp_die();
    }

    //remove extra boxes
    public function wp_rem_remove_post_boxes() {
        remove_meta_box('mymetabox_revslider_0', 'property-alert', 'normal');
    }

}

new WP_Property_Hunt_Custom_Post_Type();
