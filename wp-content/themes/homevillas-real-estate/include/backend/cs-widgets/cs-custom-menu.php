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
class Wp_rem_cs_Custom_Menu_Widget extends WP_Widget {

    /**
     * Sets up a new Custom Menu widget instance.
     *
     * @since 3.0.0
     * @access public
     */
    public function __construct() {
        $widget_ops = array(
            'description' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_custom_menu_description' ),
            'customize_selective_refresh' => true,
        );
        parent::__construct( 'wp_rem_cs_custom_menu_widget', wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_custom_menu' ), $widget_ops );
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
    public function widget( $args, $instance ) {
        // Get menu.
        $nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

        if ( '' === $nav_menu ) {
            return;
        }
        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        echo '<div class="widget widget-categories">';

        if ( '' !== $instance['title'] ) {
            echo '<div class="widget-title"><h5>' . esc_html( $instance['title'] ) . '</h5></div>';
        }
        $nav_menu_args = array(
            'fallback_cb' => '',
            'menu' => $nav_menu,
            'container' => false,
            'link_before' => ' ',
            'items_wrap' => '<ul>%3$s</ul>',
        );


        /**
         * Filter the arguments for the Custom Menu widget.
         *
         * @since 4.2.0
         * @since 4.4.0 Added the `$instance` parameter.
         *
         * @param array    $nav_menu_args {
         *     An array of arguments passed to wp_nav_menu() to retrieve a custom menu.
         *
         *     @type callable|bool $fallback_cb Callback to fire if the menu doesn't exist. Default empty.
         *     @type mixed         $menu        Menu ID, slug, or name.
         * }
         * @param stdClass $nav_menu      Nav menu object for the current menu.
         * @param array    $args          Display arguments for the current widget.
         * @param array    $instance      Array of settings for the current widget.
         */
        wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $args, $instance ) );

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
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        if ( ! empty( $new_instance['title'] ) ) {
            $instance['title'] = sanitize_text_field( $new_instance['title'] );
        }
        if ( ! empty( $new_instance['nav_menu'] ) ) {
            $instance['nav_menu'] = sanitize_text_field( $new_instance['nav_menu'] );
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
    public function form( $instance ) {
        global $wp_rem_cs_var_form_fields, $wp_rem_cs_var_html_fields;
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';

        // Get menus.
        $menus = wp_get_nav_menus();

        // If no menus exists, direct the user to go and create some.
        ?>
        <p class="nav-menu-widget-no-menus-message" <?php
        if ( ! empty( $menus ) ) {
            echo ' style="display:none" ';
        }
        ?>>
               <?php
               if ( isset( $GLOBALS['wp_customize'] ) && $GLOBALS['wp_customize'] instanceof WP_Customize_Manager ) {
                   $url = 'javascript: wp.customize.panel( "nav_menus" ).focus();';
               } else {
                   $url = admin_url( 'nav-menus.php' );
               }
               ?>
               <?php echo sprintf( esc_html( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_no_menus' ) ), esc_attr( $url ) ); ?>
        </p>
        <div class="nav-menu-widget-form-controls" <?php if ( empty( $menus ) ) {
            echo ' style="display:none" ';
        } ?>>
            <?php
            $title = isset( $instance['title'] ) ? $title = $instance['title'] : '';
            $wp_rem_cs_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_html_fields_title' ),
                'desc' => '',
                'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_enter_title_here' ),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr( $title ),
                    'cust_id' => '',
                    'cust_name' => wp_rem_cs_allow_special_char( $this->get_field_name( 'title' ) ),
                    'return' => true,
                ),
            );

            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_opt_array );

            if ( ! empty( $menus ) ) :
                $cs_menu_all = array();
                foreach ( $menus as $menu ) :
                    $cs_menu_all[$menu->slug] = $menu->name;

                endforeach;
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_select_menu' ),
                    'desc' => '',
                    'hint_text' => '',
                    'echo' => true,
                    'field_params' => array(
                        'std' => $nav_menu,
                        'id' => wp_rem_cs_allow_special_char( $this->get_field_id( 'select_view' ) ),
                        'cust_name' => wp_rem_cs_allow_special_char( $this->get_field_name( 'nav_menu' ) ),
                        'classes' => 'dropdown',
                        'options' => $cs_menu_all,
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field( $wp_rem_cs_opt_array );
            endif;
            ?>
        </div>
        <?php
    }

}

add_action( 'widgets_init', create_function( '', 'return register_widget("Wp_rem_cs_Custom_Menu_Widget");' ) );
