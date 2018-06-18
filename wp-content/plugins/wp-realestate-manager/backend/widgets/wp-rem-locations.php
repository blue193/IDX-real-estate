<?php

/**
 * Widget API: WP_nav_menu_Widget class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */

/**
 * Core class used to implement the Custom Menu widget.
 *
 * @since 3.0.0
 *
 * @see WP_Widget
 */
class Wp_rem_Locations_Widget extends WP_Widget {

    /**
     * Sets up a new Custom Menu widget instance.
     *
     * @since 3.0.0
     * @access public
     */
    public function __construct() {
       
      $widget_ops = array(
            'classname' => 'locations-widget',
            'description' => wp_rem_plugin_text_srt('wp_rem_locations_widget_desc'),
            'customize_selective_refresh' => true,
        );
        parent::__construct( 'wp_rem_locations_widget', wp_rem_plugin_text_srt('wp_rem_locations_widget'), $widget_ops );
       
    }
      
    /**
     * Outputs the content for the current Custom Menu widget instance.
     *
     * @since 3.0.0
     * @access public
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Custom Menu widget instance.
     */
    public function widget($args, $instance) {
        // Get menu.
        
        $selected_locations = isset($instance['locations']) ? $instance['locations']:'';
       // print_r($selected_locations);
        
       
        $instance['title'] = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

        echo '<div class="widget widget-top-cities">';

        if ('' !== $instance['title']) {
            echo '<div class="widget-title"><h5>' . esc_html($instance['title']) . '</h5></div>';
        }
         if($selected_locations!='' && sizeof($selected_locations)>0){
            echo '<ul>';
            foreach($selected_locations as $single_loc){
               
                if(term_exists((int) $single_loc,'wp_rem_locations')){
               $term_info=get_term_by('id', $single_loc,'wp_rem_locations');
               $term_link= get_term_link($term_info->term_id);
                
               echo '<li><a href="'.$term_link.'">'.$term_info->name.'</a></li>';
                }
            }
             echo '</ul>';
        }

        echo '</div>';
    }

    /**
     * Handles updating settings for the current Custom Menu widget instance.
     *
     * @since 3.0.0
     * @access public
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Updated settings to save.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        if (!empty($new_instance['title'])) {
            $instance['title'] = sanitize_text_field($new_instance['title']);
        }
        if (!empty($new_instance['locations'])) {
            $instance['locations'] = $new_instance['locations'];
        }

        return $instance;
    }

    /**
     * Outputs the settings form for the Custom Menu widget.
     *
     * @since 3.0.0
     * @access public
     *
     * @param array $instance Current settings.
     */
    public function form($instance) {
      
        global $wp_rem_var_form_fields, $wp_rem_var_html_fields, $wp_rem_plugin_options, $wp_rem_html_fields, $wp_rem_form_fields;
        $title = isset($instance['title']) ? $instance['title'] : '';
        $locations = isset($instance['locations']) ? $instance['locations'] : '';


        $title = isset($instance['title']) ? $title = $instance['title'] : '';
        $wp_rem_opt_array = array(
            'name' => wp_rem_plugin_text_srt('wp_rem_widget_title'),
            'desc' => '',
            'hint_text' => wp_rem_plugin_text_srt('wp_rem_widget_title_desc'),
             'echo' => true,
            'field_params' => array(
               'std' => esc_attr($title),
                'cust_id' => '',
                'cust_name' => wp_rem_allow_special_char($this->get_field_name('title')),
                'return' => true,
            ),
        );

       $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
        $taxonomies = array(
            'wp_rem_locations',
        );

        $args = array(
            'hide_empty' => false,
            'hierarchical' => true,
        );

        $options_all = get_terms($taxonomies, $args);

        //$options_all=get_terms(array('taxonomy' => 'wp_rem_locations'));


        $selected_locations = array();
        if ($options_all != '') {
            foreach ($options_all as $option) {
                $selected_locations[$option->term_id] = $option->name;
            }
        }
        $wp_rem_opt_array = array(
            'name' => wp_rem_plugin_text_srt('choose_location_fields'),
            'hint_text' =>  wp_rem_plugin_text_srt('choose_location_fields_desc'),
            'echo' => true,
          'multi' => true,
           'field_params' => array(
            'cust_name' => wp_rem_allow_special_char($this->get_field_name('locations[]')),
            'cust_id' => wp_rem_allow_special_char($this->get_field_id('locations')),
            'options' => $selected_locations,
          'return'=>true,
            'classes' => 'chosen-select',
               'std' => $locations,
            ),
        );

      $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
        ?>
 <script>
            /* modern selection box and help hover text function */
            jQuery(document).ready(function ($) {
                chosen_selectionbox();
                popup_over();
            });
            /* end modern selection box and help hover text function */
        </script>
        <?php

    }

}

add_action('widgets_init', create_function('', 'return register_widget("Wp_rem_Locations_Widget");'));
