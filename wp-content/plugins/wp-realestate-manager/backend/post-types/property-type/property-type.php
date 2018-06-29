<?php
/**
 * Register Post Type Inventory Type
 * @return
 *
 */
if (!class_exists('Wp_rem_Post_Property_Types')) {

    class Wp_rem_Post_Property_Types {

        // The Constructor
        public function __construct() {
            add_action('init', array($this, 'property_type_register'), 12);
            add_action('admin_menu', array($this, 'wp_rem_remove_post_boxes'));
            add_action('do_meta_boxes', array($this, 'wp_rem_remove_post_boxes'));
            add_filter('post_row_actions', array($this, 'property_type_remove_row_actions'), 10, 1);
            add_action('admin_head', array($this, 'stop_heartbeat'), 1);
        }

        public function stop_heartbeat() {
            if (get_post_type() == 'property-type') {
                wp_deregister_script('heartbeat');
            }
        }

        /**
         * @Register Post Type
         * @return
         *
         */
        function property_type_register() {

            global $wp_rem_plugin_static_text;

            $labels = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_types'),
                'singular_name' => wp_rem_plugin_text_srt('wp_rem_property_type'),
                'menu_name' => wp_rem_plugin_text_srt('wp_rem_property_types'),
                'name_admin_bar' => wp_rem_plugin_text_srt('wp_rem_property_types'),
                'add_new' => wp_rem_plugin_text_srt('wp_rem_add_property_type'),
                'add_new_item' => wp_rem_plugin_text_srt('wp_rem_add_property_type'),
                'new_item' => wp_rem_plugin_text_srt('wp_rem_add_property_type'),
                'edit_item' => wp_rem_plugin_text_srt('wp_rem_edit_property_type'),
                'view_item' => wp_rem_plugin_text_srt('wp_rem_property_type'),
                'all_items' => wp_rem_plugin_text_srt('wp_rem_property_types'),
                'search_items' => wp_rem_plugin_text_srt('wp_rem_property_type'),
                'not_found' => wp_rem_plugin_text_srt('wp_rem_property_types'),
                'not_found_in_trash' => wp_rem_plugin_text_srt('wp_rem_property_types'),
            );

            $args = array(
                'labels' => $labels,
                'description' => wp_rem_plugin_text_srt('wp_rem_property_types'),
                'public' => true,
                'taxonomies' => array('property-category'),
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => 'edit.php?post_type=properties',
                'query_var' => false,
                'capability_type' => 'post',
                'has_archive' => false,
                'supports' => array('title'),
                'exclude_from_search' => true
            );

            register_post_type('property-type', $args);
        }

        function wp_rem_submit_meta_box($post, $args = array()) {
            global $action, $post, $wp_rem_plugin_static_text, $wp_rem_form_fields;


            $post_type = $post->post_type;
            $post_type_object = get_post_type_object($post_type);
            $can_publish = current_user_can($post_type_object->cap->publish_posts);
            ?>
            <div class="submitbox wp-rem-submit" id="submitpost">
                <div id="minor-publishing">
                    <div style="display:none;">
                        <?php submit_button(wp_rem_plugin_text_srt('wp_rem_submit'), 'button', 'save'); ?>
                    </div>
                    <?php if ($post_type_object->public && !empty($post)) : ?>
                        <div id="preview-action">
                            <?php
                            if ('publish' == $post->post_status) {
                                $preview_link = esc_url(get_permalink($post->ID));
                                $preview_button = wp_rem_plugin_text_srt('wp_rem_preview');
                            } else {
                                $preview_link = set_url_scheme(get_permalink($post->ID));

                                /**
                                 * Filter the URI of a post preview in the post submit box.
                                 *
                                 * @since 2.0.5
                                 * @since 4.0.0 $post parameter was added.
                                 *
                                 * @param string  $preview_link URI the user will be directed to for a post preview.
                                 * @param WP_Post $post         Post object.
                                 */
                                $preview_link = esc_url(apply_filters('preview_post_link', add_query_arg('preview', 'true', esc_url($preview_link)), $post));
                                $preview_button = wp_rem_plugin_text_srt('wp_rem_preview');
                            }
                            ?>
                            <div class="clear"></div>
                        </div>
                    <?php endif; // public post type        ?>


                </div>
                <div id="major-publishing-actions" style="border-top:0px">
                    <?php
                    /**
                     * Fires at the beginning of the publishing actions section of the Publish meta box.
                     *
                     * @since 2.7.0
                     */
                    do_action('post_submitbox_start');
                    ?>
                    <div id="delete-action">
                        <?php
                        if (current_user_can("delete_post", $post->ID)) {
                            if (!EMPTY_TRASH_DAYS) {
                                $delete_text = wp_rem_plugin_text_srt('wp_rem_delete_permanently');
                            } else {
                                $delete_text = wp_rem_plugin_text_srt('wp_rem_move_to_trash');
                            }
                            if (isset($_GET['action']) && $_GET['action'] == 'edit') {
                                ?>
                                <a class="submitdelete deletion" href="<?php echo get_delete_post_link($post->ID); ?>"><?php echo wp_rem_allow_special_char($delete_text) ?></a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div id="publishing-action">
                        <span class="spinner"></span>
                        <?php
                        if (!in_array($post->post_status, array('publish', 'future', 'private')) || 0 == $post->ID) {
                            if ($can_publish) :
                                if (!empty($post->post_date_gmt) && time() < strtotime($post->post_date_gmt . ' +0000')) :
                                    $wp_rem_opt_array = array(
										'std' => wp_rem_plugin_text_srt( 'wp_rem_schedule' ),
										'cust_id' => 'original_publish',
										'cust_name' => 'original_publish',
										'cust_type' => 'hidden',
										'classes' => '',
									);
									$wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
									?>
                                    <?php submit_button(esc_html('wp_rem_schedule'), 'primary button-large', 'publish', false, array('accesskey' => 'p')); ?>
                                <?php else : ?>
									<?php
									$wp_rem_opt_array = array(
										'std' => wp_rem_plugin_text_srt( 'wp_rem_publish' ),
										'cust_id' => 'original_publish',
										'cust_name' => 'original_publish',
										'cust_type' => 'hidden',
										'classes' => '',
									);
									$wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
									?>
                                    <?php submit_button(wp_rem_plugin_text_srt('wp_rem_publish'), 'primary button-large', 'publish', false, array('accesskey' => 'p')); ?>
                                <?php
                                endif;
                            else :
                                $wp_rem_opt_array = array(
									'std' => wp_rem_plugin_text_srt( 'wp_rem_submit_for_review' ),
									'cust_id' => 'original_publish',
									'cust_name' => 'original_publish',
									'cust_type' => 'hidden',
									'classes' => '',
								);
								$wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
								?>
                                <?php submit_button(wp_rem_plugin_text_srt('wp_rem_submit_for_review'), 'primary button-large', 'publish', false, array('accesskey' => 'p')); ?>
                            <?php
                            endif;
                        } else {

                            if (isset($_GET['action']) && $_GET['action'] == 'edit') {
								$wp_rem_opt_array = array(
									'std' => wp_rem_plugin_text_srt( 'wp_rem_update' ),
									'cust_id' => 'original_publish',
									'cust_name' => 'original_publish',
									'cust_type' => 'hidden',
									'classes' => '',
								);
								$wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
								$wp_rem_opt_array = array(
									'std' => wp_rem_plugin_text_srt( 'wp_rem_update' ),
									'cust_id' => 'publish',
									'cust_name' => 'save',
									'cust_type' => 'submit',
									'classes' => 'button button-primary button-large',
									'extra_attr' => ' accesskey="p"',
								);
								$wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
							} else {
								$wp_rem_opt_array = array(
									'std' => wp_rem_plugin_text_srt( 'wp_rem_publish' ),
									'cust_id' => 'original_publish',
									'cust_name' => 'original_publish',
									'cust_type' => 'hidden',
									'classes' => '',
								);
								$wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
								$wp_rem_opt_array = array(
									'std' => wp_rem_plugin_text_srt( 'wp_rem_publish' ),
									'cust_id' => 'publish',
									'cust_name' => 'submit',
									'cust_type' => 'submit',
									'classes' => 'button button-primary button-large',
									'extra_attr' => ' accesskey="p"',
								);
								$wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                            }
                        }
                        ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <?php
        }

        public function wp_rem_types_array_callback($first_option_label = '') {
            $property_types_data = array();
            if ($first_option_label != '' && $first_option_label != 'NULL') {
                $property_types_data['all'] = $first_option_label;
            } else if ($first_option_label != 'NULL') {
                $property_types_data['all'] = wp_rem_plugin_text_srt( 'wp_rem_property_type_meta_categories' );
            }
            $wp_rem_property_args = array('posts_per_page' => '-1', 'post_type' => 'property-type', 'orderby' => 'title', 'post_status' => 'publish', 'order' => 'ASC');
            $cust_query = get_posts($wp_rem_property_args);
            if (is_array($cust_query) && sizeof($cust_query) > 0) {
                foreach ($cust_query as $wp_rem_property_type) {
                    $property_types_data[$wp_rem_property_type->post_name] = get_the_title($wp_rem_property_type->ID);
                }
            }
            return $property_types_data;
        }

        public function wp_rem_types_custom_fields_array_required_fields($fields) {
            return 'ID, wp_rem_property_type_cus_fields'; // etc
        }

        public function wp_rem_types_custom_fields_array($property_type) {
            $wp_rem_property_type_cus_fields = '';
            if ($property_type != '') {

                $property_type_post = get_posts(array('fields' => 'ids', 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type", 'post_status' => 'publish'));
                $property_type_id = isset($property_type_post[0]) ? $property_type_post[0] : 0;
                $wp_rem_property_type_cus_fields = get_post_meta($property_type_id, "wp_rem_property_type_cus_fields", true);
            }
            return $wp_rem_property_type_cus_fields;
        }

        public function property_type_remove_row_actions($actions) {

            if (get_post_type() === 'property-type')
                unset($actions['view']);
            unset($actions['inline hide-if-no-js']);
            return $actions;
        }

        function wp_rem_remove_post_boxes() {

            remove_meta_box('submitdiv', 'property-type', 'side');
            remove_meta_box('mymetabox_revslider_0', 'property-type', 'normal'); 
        }

    }

    global $wp_rem_post_property_types;

    $wp_rem_post_property_types = new Wp_rem_Post_Property_Types();
}

function wp_rem_remove_help_tabs() {
    $screen = get_current_screen();
    if ($screen->post_type == 'property-type') {
        add_filter('screen_options_show_screen', '__return_false');
        add_filter('bulk_actions-edit-property-type', '__return_empty_array');
        echo '<style type="text/css">
				.post-type-property-type .tablenav.top,
				.post-type-property-type .tablenav.bottom,
				.post-type-property-type #titlediv .inside,
				.post-type-property-type #postdivrich{
					display: none;
				}
			</style>';
        echo '
		<script>
			jQuery(document).ready(function($){
				$(\'form#post\').submit(function() {
					var errorr = 0;
					$(\'.dir-res-meta-key-field\').each(function(){
						if($(this).val() == \'\'){
							//alert(\' Please fill the fields \');
							errorr = 1;
							$(this).parents(\'.pb-item-container\').find(\'.pbwp-legend\').addClass(\'item-field-error\');
						}
						if($(this).parents(\'.pb-item-container\').find(\'.pbwp-legend\').hasClass(\'item-field-error\')){
							errorr = 1;
						}
					});
					
					$(\'.dir-meta-key-field\').each(function(){
						if($(this).val() == \'\') {
							errorr = 1;
							$(this).parents(\'.pb-item-container\').find(\'.pbwp-legend\').addClass(\'item-field-error\');
						}
						if($(this).parents(\'.pb-item-container\').find(\'.pbwp-legend\').hasClass(\'item-field-error\')){
							errorr = 1;
						}
					});
					
					$(\'.field-dropdown-opt-values1\').each(function(){
						var field_this = $(this);
						var val_field = $(this).find(\'input[id^="cus_field_dropdown_options_values_"]\');
						if(val_field.length === 0){
							errorr = 1;
							$(this).parents(\'.pb-item-container\').find(\'.pbwp-legend\').addClass(\'item-field-error\');
							alert(\'Please Put atleat 1 or 2 values for dropdown options.\');
						} else {
							val_field.each(function(){
								if($(this).val() == \'\'){
									errorr = 1;
									field_this.parents(\'.pb-item-container\').find(\'.pbwp-legend\').addClass(\'item-field-error\');
									alert(\'Options Values cannot be blank.\');
								}
							});
						}
					});

					if(errorr == 0){
						return true;
					}
					return false;
				});
			});
		</script>';
    }
}

function property_type_cpt_columns($columns) {
    unset($columns['date']);
    return $columns;
}

add_filter('manage_property-type_posts_columns', 'property_type_cpt_columns');
