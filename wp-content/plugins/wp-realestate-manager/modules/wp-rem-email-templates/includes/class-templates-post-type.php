<?php
/**
 * Main plugin Templates Post Type File.
 *
 * @since 1.0
 * @package	Homevillas
 */
// Direct access not allowed.
if ( ! defined('ABSPATH') ) {
    exit;
}

/**
 * Templates Post Type Class.
 */
class Wp_rem_Email_Templates_Post {

    public static $email_template_options;

    /**
     * Put hooks in place and activate.
     */
    public function __construct() {
        add_action('init', array( $this, 'init' ), 1);
    }

    public function init() {

        $this->register_emails_post_type();
        $this->register_email_post_taxonomy();
        $this->load_email_template_options();
        add_action('save_post', array( $this, 'save_templates_meta' ));
        if ( is_admin() ) {
            add_action('add_meta_boxes', array( $this, 'templates_meta_box' ));
            add_filter('post_row_actions', array( $this, 'remove_quick_edit' ), 10, 2);
            add_action('admin_head', array( $this, 'custom_admin_css_callback' ));
            add_filter('manage_posts_columns', array( $this, 'remove_post_columns_callback' ));
            add_filter('manage_edit-jh-templates_columns', array( $this, 'columns' ), 15);
            add_action('manage_jh-templates_posts_custom_column', array( $this, 'custom_columns' ), 15, 2);
            add_action('admin_menu', array( $this, 'admin_menu_position' ));
            add_action('restrict_manage_posts', array( $this, 'wp_rem_filter_email_templates_by_taxonomy' ));
            add_filter('parse_query', array( $this, 'wp_rem_filter_email_templates_by_taxonomy_query' ));
        }
    }

    /**
     * Start Function how position admin menu
     */
    public function admin_menu_position() {
        global $menu, $submenu;
        foreach ( $menu as $key => $menu_item ) {
            if ( isset($menu_item[2]) && $menu_item[2] == 'edit.php?post_type=jh-templates' ) {
                $menu[$key][0] = wp_rem_plugin_text_srt('wp_rem_rem_alerts_email');
            }
            if ( isset($submenu['edit.php?post_type=jh-templates'][10]) ) {
                unset($submenu['edit.php?post_type=jh-templates'][10]);
            }
        }
    }

    /**
     * Load email template types.
     */
    public function load_email_template_options() {
        self::$email_template_options = array(
            'types' => array(),
            'templates' => array(),
            'variables' => array(),
        );

        self::$email_template_options = apply_filters('wp_rem_email_template_settings', self::$email_template_options, 1);
    }

    /**
     * Remove Checkboxes column from Email Template property page
     */
    public function remove_post_columns_callback($columns) {
        global $post;

        if ( isset($post) && $post->post_type == 'jh-templates' ) {
            // Remove the checkbox and date column
            unset($columns['cb']);
            unset($columns['date']);
        }
        return $columns;
    }

    public function columns($columns) {
        $columns['help'] = wp_rem_plugin_text_srt('wp_rem_template_post_desc');
        return $columns;
    }

    public function custom_columns($column, $post_id) {
        if ( $column == 'help' ) {
            $description = get_post_meta($post_id, 'description', true);
            if ( $description != '' ) {
                echo force_balance_tags($description);
            } else {
                echo esc_html('&ndash;');
            }
        }
    }

    /**
     * Remove Table nav, filters and search box from Email templates property.
     */
    public function custom_admin_css_callback() {
        global $post;
        if ( isset($post) && $post->post_type == 'jh-templates' ) {
            wp_enqueue_style('wp_rem_email_templates_css', WP_REM_EMAIL_TEMPLATES_PLUGIN_URL . '/assets/css/wp-rem-email-templates.css');
        }
    }

    /**
     * Removes quick edit and delete from custom post type list.
     */
    public function remove_quick_edit($actions) {
        global $post;
        if ( $post->post_type == 'jh-templates' ) {
            unset($actions['inline hide-if-no-js']);
            unset($actions['trash']);
            unset($actions['duplicate_post']);
        }
        return $actions;
    }

    /**
     * Save Post type meta data.
     */
    public function save_templates_meta($post_id = '') {
        global $post;

        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
            return;
        }
        if ( is_admin() ) {

            foreach ( $_POST as $key => $value ) {
                if ( strstr($key, 'jh_') ) {
                    update_post_meta($post_id, $key, $value);
                }
            }
            if ( ! empty($_POST) ) {
                $value = (isset($_POST['jh_email_notification']) && $_POST['jh_email_notification'] == 1) ? $_POST['jh_email_notification'] : 0;
                update_post_meta($post_id, 'jh_email_notification', $value);
            }
        }
    }

    /**
     * Register Custom Post Type for Job Email_Templates
     */
    public function register_emails_post_type() {

        $labels = array(
            'name' => wp_rem_plugin_text_srt('wp_rem_template_post_name'),
            'singular_name' => wp_rem_plugin_text_srt('wp_rem_template_post_singular_name'),
            'menu_name' => wp_rem_plugin_text_srt('wp_rem_template_post_menu_name'),
            'name_admin_bar' => wp_rem_plugin_text_srt('wp_rem_template_post_name_admin_bar'),
            'add_new' => wp_rem_plugin_text_srt('wp_rem_template_post_add_new'),
            'add_new_item' => wp_rem_plugin_text_srt('wp_rem_template_post_add_new_item'),
            'new_item' => wp_rem_plugin_text_srt('wp_rem_template_post_new_itwm'),
            'edit_item' => wp_rem_plugin_text_srt('wp_rem_template_post_edit_item'),
            'view_item' => wp_rem_plugin_text_srt('wp_rem_template_post_view_itwem'),
            'search_items' => wp_rem_plugin_text_srt('wp_rem_template_post_search_item'),
            'parent_item_colon' => wp_rem_plugin_text_srt('wp_rem_template_post_parent_clone'),
            'not_found' => wp_rem_plugin_text_srt('wp_rem_template_post_not_found'),
            'not_found_in_trash' => wp_rem_plugin_text_srt('wp_rem_template_post_not_found_in_trash')
        );

        $args = array(
            'labels' => $labels,
            'description' => wp_rem_plugin_text_srt('wp_rem_template_post_description'),
            'public' => false,
            'publicly_queryable' => false,
            'show_ui' => true,
            'menu_position' => 28,
            'menu_icon' => 'dashicons-email',
            'query_var' => false,
            'rewrite' => array( 'slug' => 'jh-templates' ),
            'capability_type' => 'post',
            'create_posts' => false,
            'has_archive' => false,
            'hierarchical' => false,
            'supports' => array( 'title', 'editor' )
        );

        // Register custom post type.
        register_post_type("jh-templates", $args);
    }

    /**
     * Add new taxonomy for email post type, make it hierarchical (like categories).
     */
    public function register_email_post_taxonomy() {

        $labels = array(
            'name' => wp_rem_plugin_text_srt('wp_rem_template_texonomy_name'),
            'singular_name' => wp_rem_plugin_text_srt('wp_rem_template_texonomy_singular_name'),
            'search_items' => wp_rem_plugin_text_srt('wp_rem_template_texonomy_search_item'),
            'all_items' => wp_rem_plugin_text_srt('wp_rem_template_texonomy_all_item'),
            'parent_item' => wp_rem_plugin_text_srt('wp_rem_template_texonomy_parent_item'),
            'parent_item_colon' => wp_rem_plugin_text_srt('wp_rem_template_texonomy_parent_item_clone'),
            'edit_item' => wp_rem_plugin_text_srt('wp_rem_template_texonomy_edit_item'),
            'update_item' => wp_rem_plugin_text_srt('wp_rem_template_texonomy_update_item'),
            'add_new_item' => wp_rem_plugin_text_srt('wp_rem_template_texonomy_add_new_item'),
            'new_item_name' => wp_rem_plugin_text_srt('wp_rem_template_texonomy_new_item_name'),
            'menu_name' => wp_rem_plugin_text_srt('wp_rem_template_texonomy_menu_name'),
        );
        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => false,
            'show_admin_column' => true,
            //'query_var'         => true,
            'rewrite' => array( 'slug' => 'email-template-group' ),
        );
        register_taxonomy('email_template_group', 'jh-templates', $args);
    }

    /*
     * @ Metabox
     */

    public function templates_meta_box() {
        add_action('edit_form_after_title', array( $this, 'render_email_template_type_meta_box' ));
        add_meta_box('jh_email_template_variables', wp_rem_plugin_text_srt('wp_rem_template_post_template_variables'), array( $this, 'template_variables' ), 'jh-templates', 'side', 'core');
        add_meta_box('jh_email_template_config', wp_rem_plugin_text_srt('wp_rem_template_post_template_options'), array( $this, 'email_template_type_options' ), 'jh-templates', 'side', 'core');
        add_action('admin_menu', array( $this, 'remove_post_boxes' ));
        add_action('do_meta_boxes', array( $this, 'remove_post_boxes' ));
    }

    public function email_template_type_meta_box() {
        global $post, $wp_rem_html_fields, $wp_rem_form_fields, $wp_rem_plugin_options;
        $jh_from = isset($wp_rem_plugin_options['wp_rem_smtp_sender_email']) ? $wp_rem_plugin_options['wp_rem_smtp_sender_email'] : '';
        if ( $post->post_type == 'jh-templates' ) {
            $email_template_type = get_post_meta($post->ID, 'jh_email_template_type', true);
            $jh_subject = get_post_meta($post->ID, 'jh_subject', true);
            $jh_recipients = get_post_meta($post->ID, 'jh_recipients', true);
            $is_recipients_enabled = get_post_meta($post->ID, 'is_recipients_enabled', true);
            $ecipients_enabled = '';
            if ( $is_recipients_enabled == false ) {
                $ecipients_enabled = 'disabled';
            }
            ?>
            <div class="jh-email-helper-variables">
                <div class="jh-form-elements">
                    <div style="display:none;">
                        <div class="jh-label">
                            <label><?php echo wp_rem_plugin_text_srt('wp_rem_template_post_template_type'); ?></label>
                        </div>
                        <div class="jh-field">
                            <?php
                            $template_type_array = array();
                            foreach ( self::$email_template_options['types'] as $key => $type ):
                                $template_type_array[$type] = ucfirst($type);
                            endforeach;
                            $wp_rem_opt_array = array(
                                'std' => ($email_template_type),
                                'cust_name' => 'jh_email_template_type',
                                'classes' => 'slct_jh_email_template_type',
                                'return' => false,
                                'options' => $template_type_array,
                            );
                            $wp_rem_form_fields->wp_rem_form_select_render($wp_rem_opt_array);
                            ?>
                        </div>
                    </div>
                    <h3><?php echo esc_attr($post->post_title); ?></h3>
                    <div class="email-template-fields">
                        <div class="jh-field subject">
                            <?php
                            $wp_rem_opt_array = array(
                                'std' => esc_attr($jh_subject),
                                'cust_name' => 'jh_subject',
                                'return' => false,
                                'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_template_post_subject') . '" ',
                            );
                            $wp_rem_html_fields->wp_rem_form_text_render($wp_rem_opt_array);
                            ?>
                        </div>
                        <div class="jh-field">
                            <?php
                            $wp_rem_opt_array = array(
                                'std' => esc_attr($jh_from),
                                'cust_name' => 'jh_from',
                                'return' => false,
                                'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_template_post_from') . '" disabled title="' . wp_rem_plugin_text_srt('wp_rem_template_post_from_title') . '"',
                            );
                            $wp_rem_html_fields->wp_rem_form_text_render($wp_rem_opt_array);
                            ?>
                        </div>
                        <div class="jh-field last">
                            <?php
                            $wp_rem_opt_array = array(
                                'std' => esc_attr($jh_recipients),
                                'cust_name' => 'jh_recipients',
                                'return' => false,
                                'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_template_post_recipient') . '" ' . $ecipients_enabled . ' ',
                            );
                            $wp_rem_html_fields->wp_rem_form_text_render($wp_rem_opt_array);
                            ?>
                        </div>
                    </div>

                </div>
            </div>
            <script tyep="text/javascript">
                var default_templates = <?php echo json_encode(self::$email_template_options["templates"]); ?>;
                (function ($) {
                    $(function () {
                        var template_type = $(".slct_jh_email_template_type").val();
                        var selected_type_class = '.' + template_type.toLowerCase().replace(/\s/g, "-") + '-variables-list';
                        $(".variables-list").hide();
                        // Show only General and selected type variables.
                        $(".general-variables-list," + selected_type_class).show();

                        $(".slct_jh_email_template_type").change(function () {
                            change_template();
                        });

                        $("#btn-restore-default-template").click(function () {
                            change_template();
                        });

                        function change_template() {
                            var template_type = $(".slct_jh_email_template_type").val();
                            var selected_type_class = '.' + template_type.toLowerCase().replace(/\s/g, "-") + '-variables-list';
                            //console.log(selected_type_class);
                            $(".variables-list").hide();
                            // Show only General and selected type variables.
                            $(".general-variables-list," + selected_type_class).show();
                            if ($("#wp-content-wrap").hasClass("tmce-active")) {
                                tinyMCE.activeEditor.setContent(default_templates[template_type]);
                            } else {
                                $('#content').val(default_templates[template_type]);
                            }
                        }
                    });
                })(jQuery);
            </script>
            <?php
        }
    }

    public function render_email_template_type_meta_box() {
        $this->email_template_type_meta_box();
        // Get the globals.
        global $post, $wp_meta_boxes;

        // Output the "top" meta boxes.
        do_meta_boxes(get_current_screen(), 'top', $post);

        // Remove the initial "top" meta boxes.
        unset($wp_meta_boxes['jh-templates']['top']);
    }

    public function template_variables() {
        global $post;

        ob_start();
        ?>
        <div class="jh-email-helper-variables">
                <!--<h2><?php echo wp_rem_plugin_text_srt('wp_rem_template_post_template_variables'); ?></h2>-->
            <p><?php echo wp_rem_plugin_text_srt('wp_rem_template_post_click_variable_add'); ?></p>

            <?php foreach ( self::$email_template_options['variables'] as $group_name => $tags ): ?>
                <div class="<?php echo str_replace(' ', '-', strtolower($group_name)) . '-variables-list'; ?> variables-list">
                    <h4><?php echo ucfirst($group_name); ?></h4>
                    <ul class="jh-var-list">
                        <?php foreach ( $tags as $key => $tag_details ): ?>
                            <li><a class="add-email-var" data-variable="<?php echo $tag_details['tag']; ?>" title="<?php echo $tag_details['display_text']; ?>"><?php echo '[' . $tag_details['tag'] . ']'; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
        $jh_html = ob_get_clean();

        echo force_balance_tags($jh_html);
    }

    public function email_template_type_options() {
        global $wp_rem_form_fields,$post;
        $jh_email_notification = get_post_meta($post->ID, 'jh_email_notification', true);
        $jh_email_type = get_post_meta($post->ID, 'jh_email_type', true);
        $checked = 'checked';
        $plain_text_checked = $html_checked = '';
        $notification_value = 1;
        if ( $jh_email_notification == 1 ) {
            $checked = 'checked';
            $notification_value = 1;
        } else if ( $jh_email_notification == 0 && $jh_email_notification != '' ) {
            $checked = 'unchecked';
            $notification_value = 0;
        }
        if ( $jh_email_type == 'plain_text' ) {
            $plain_text_checked = 'checked';
        } else if ( $jh_email_type == 'html' ) {
            $html_checked = 'checked';
        } else {
            $html_checked = 'checked';
        }
        ?>
        <div class="jh-email-helper-variables email-template_options">
            <div class="opt-conts">
                <div class="jh-form-elements">
                    <div class="jh-label">
                        <input type="button" value="<?php echo wp_rem_plugin_text_srt('wp_rem_template_post_restore_default'); ?>" name="btn-restore-default-template" id="btn-restore-default-template" style="background-color: #63aa63;">
                    </div>
                    <div class="jh-label">
                        <label><b><?php echo wp_rem_plugin_text_srt('wp_rem_template_post_anable_disable_notifi'); ?></b></label>&nbsp;&nbsp;&nbsp;
                        <?php
                        $wp_rem_opt_array = array(
                            'std' => esc_attr($notification_value),
                            'id' => 'jh_email_notification',
                            'cust_name' => 'jh_email_notification',
                            'return' => false,
                            'cust_type' => 'checkbox',
                            'extra_atr' => ' ' . $checked . '',
                            'prefix_on'=> false,
                        );
                        $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                        ?>
                    </div>
                    <div class="jh-label">
                        <label><b><?php echo wp_rem_plugin_text_srt('wp_rem_template_post_email_type'); ?></b></label>&nbsp;&nbsp;&nbsp;
                        <?php
                        $wp_rem_opt_array = array(
                            'std' => 'plain_text',
                            'id' => 'plain_text',
                            'cust_name' => 'jh_email_type',
                            'return' => false,
                            'cust_type' => 'radio',
                            'extra_atr' => ' ' . $plain_text_checked . '',
                            'prefix_on'=> false,
                        );
                        $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                        ?>
                        <label for="plain_text"><?php echo wp_rem_plugin_text_srt('wp_rem_template_post_plain_text'); ?></label>  &nbsp;&nbsp;
                        <?php
                        $wp_rem_opt_array = array(
                            'std' => 'html',
                            'id' => 'html',
                            'cust_name' => 'jh_email_type',
                            'return' => false,
                            'cust_type' => 'radio',
                            'extra_atr' => ' ' . $html_checked . '',
                            'prefix_on'=> false,
                        );
                        $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                        ?>
                        <label for="html"><?php echo wp_rem_plugin_text_srt('wp_rem_template_post_html'); ?></label>
                    </div>
                    <div class="clear"></div>

                </div>
            </div>
        </div>
        <?php
    }

    public function remove_post_boxes() {
        remove_meta_box('mymetabox_revslider_0', 'jh-templates', 'normal');
    }

    public function wp_rem_filter_email_templates_by_taxonomy() {
        global $typenow;
        $post_type = 'jh-templates'; // change to your post type
        $taxonomy = 'email_template_group'; // change to your taxonomy
        if ( $typenow == $post_type ) {
            $selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
            $info_taxonomy = get_taxonomy($taxonomy);
            wp_dropdown_categories(array(
                'show_option_all' => wp_rem_plugin_text_srt('wp_rem_template_all_email_types'),
                'taxonomy' => $taxonomy,
                'name' => $taxonomy,
                'orderby' => 'name',
                'selected' => $selected,
                'show_count' => false,
                'hide_empty' => true,
            ));
        };
    }

    public function wp_rem_filter_email_templates_by_taxonomy_query($query) {
        global $pagenow;
        $post_type = 'jh-templates'; // change to your post type
        $taxonomy = 'email_template_group'; // change to your taxonomy
        $q_vars = &$query->query_vars;
        if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
            $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
            $q_vars[$taxonomy] = $term->slug;
        }
    }

}

$wp_rem_email_templates_instance = new Wp_rem_Email_Templates_Post();


