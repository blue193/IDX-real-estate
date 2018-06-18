<?php
/**
 * @Add Meta Box For Property Types
 * @return
 *
 */
if ( ! class_exists('Wp_rem_Property_Type_Meta') ) {

    class Wp_rem_Property_Type_Meta {

        public function __construct() {
            add_action('wp_ajax_add_feature_to_list', array( $this, 'add_feature_to_list' ));
            add_action('wp_ajax_add_category_to_list', array( $this, 'add_category_to_list' ));
            add_action('add_meta_boxes', array( $this, 'wp_rem_meta_property_type_add' ));
            add_action('save_post', array( $this, 'wp_rem_save_post_categories' ), 12);
            add_action('wp_ajax_wp_rem_ft_iconpicker', array( $this, 'wp_rem_ft_icon' ));
            add_action('wp_ajax_wp_rem_get_tags_list', array( $this, 'wp_rem_get_tags_list' ));
            add_action('wp_ajax_wp_rem_get_cats_list', array( $this, 'wp_rem_get_cats_list' ));
            add_filter("get_user_option_screen_layout_property-type", array( $this, 'property_type_screen_layout' ));
        }

        public function property_type_screen_layout($selected) {
            return 1; // Use 1 column if user hasn't selected anything in Screen Options
        }

        function wp_rem_meta_property_type_add() {
            add_meta_box('wp_rem_meta_property_type', esc_html(wp_rem_plugin_text_srt('wp_rem_property_type_options')), array( $this, 'wp_rem_meta_property_type' ), 'property-type', 'normal', 'high');
        }

        function wp_rem_meta_property_type($post) {
            global $post, $wp_rem_html_fields, $wp_rem_post_property_types, $wp_rem_plugin_static_text;
            ?>		
            <div class="page-wrap page-opts left" style="overflow:hidden; position:relative;">
                <div class="option-sec" style="margin-bottom:0;">
                    <div class="opt-conts">
                        <div class="elementhidden">
                            <nav class="admin-navigtion">
                                <ul id="cs-options-tab">
                                    <li><a href="javascript:void(0);" name="#tab-property_settings"><i class="icon-build"></i><?php echo wp_rem_plugin_text_srt('wp_rem_property_type_meta_general_settings'); ?></a></li>
                                    <li><a href="javascript:void(0);" name="#tab-property_types-settings-makes"><i class="icon-layers3"></i><?php echo wp_rem_plugin_text_srt('wp_rem_property_type_meta_categories'); ?></a></li>
                                    <li><a href="javascript:void(0);" name="#tab-property_types-settings-custom-fields"><i class="icon-support"></i><?php echo wp_rem_plugin_text_srt('wp_rem_property_type_meta_custom_fields'); ?></a></li>
                                    <li><a href="javascript:void(0);" name="#tab-property_types-settings-features"><i class="icon-featured_play_list"></i><?php echo wp_rem_plugin_text_srt('wp_rem_property_type_meta_features'); ?></a></li>
                                    <li><a href="javascript:void(0);" name="#tab-property_types-settings-page-elements"><i class="icon-cogs"></i><?php echo wp_rem_plugin_text_srt('wp_rem_property_type_meta_required_elements'); ?></a></li>
                                    <li><a href="javascript:void(0);" name="#tab-property_types-settings-suggested-tags"><i class="icon-tags"></i><?php echo wp_rem_plugin_text_srt('wp_rem_property_type_meta_suggested_tags'); ?></a></li>
                                    <li><a href="javascript:void(0);" name="#tab-property_types-settings-packages"><i class="icon-dropbox"></i><?php echo wp_rem_plugin_text_srt('wp_rem_property_type_meta_packages'); ?></a></li>
                                    <?php do_action('property_type_options_sidebar_tab'); ?>
                                </ul>
                            </nav>
                            <div id="tabbed-content" data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')) ?>">
                                <div id="tab-property_settings" class="wp_rem_tab_block" data-title="<?php echo wp_rem_plugin_text_srt('wp_rem_property_type_meta_general_settings'); ?>">
                                    <?php $this->property_type_settings_tab(); ?>
                                </div>
                                <div id="tab-property_types-settings-makes">
                                    <?php $this->wp_rem_post_property_type_categories(); ?>
                                </div>
                                <div id="tab-property_types-settings-custom-fields" class="wp_rem_tab_block" data-title="<?php echo wp_rem_plugin_text_srt('wp_rem_property_type_meta_custom_fields'); ?>">
                                    <?php $this->wp_rem_post_property_type_fields(); ?>
                                </div>
                                <div id="tab-property_types-settings-features" class="wp_rem_tab_block" data-title="<?php echo wp_rem_plugin_text_srt('wp_rem_property_type_meta_features'); ?>">
                                    <?php $this->wp_rem_post_property_type_features(); ?>
                                </div>

                                <div id="tab-property_types-settings-page-elements" class="wp_rem_tab_block" data-title="<?php echo wp_rem_plugin_text_srt('wp_rem_property_type_meta_required_elements'); ?>">
                                    <?php $this->wp_rem_post_page_elements_setting(); ?>
                                </div>
                                <div id="tab-property_types-settings-suggested-tags" class="wp_rem_tab_block" data-title="<?php echo wp_rem_plugin_text_srt('wp_rem_property_type_meta_suggested_tags'); ?>">
                                    <?php $this->wp_rem_post_property_type_tags(); ?>
                                </div>
                                <div id="tab-property_types-settings-packages" class="wp_rem_tab_block" data-title="<?php echo wp_rem_plugin_text_srt('wp_rem_property_type_meta_packages'); ?>">
                                    <?php $this->wp_rem_post_property_type_packages(); ?>
                                </div>
                                <?php do_action('property_type_options_tab_container'); ?>
                            </div>
                            <?php $wp_rem_post_property_types->wp_rem_submit_meta_box('property-type', $args = array()); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <?php
        }

        function wp_rem_post_property_type_packages() {
            global $post, $wp_rem_form_fields, $wp_rem_html_fields;


            $args = array(
                'post_type' => 'property-type',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'fields' => 'ids',
                'post__not_in' => array( $post->ID ),
            );
            $over_query = new WP_Query($args);
            $cust_query = $over_query->posts;

            $type_pckgs_arr = array();
            if ( is_array($cust_query) && sizeof($cust_query) > 0 ) {
                foreach ( $cust_query as $package_post ) {
                    $type_pckgs = get_post_meta($package_post, 'wp_rem_property_type_packages', true);
                    if ( is_array($type_pckgs) && sizeof($type_pckgs) > 0 ) {
                        foreach ( $type_pckgs as $type_pckg ) {
                            $type_pckgs_arr[] = $type_pckg;
                        }
                    }
                }
            }

            $wp_rem_packages_list = array();
            $args = array( 'posts_per_page' => '-1', 'post_type' => 'packages', 'orderby' => 'title', 'post_status' => 'publish', 'order' => 'ASC' );
            $cust_query = get_posts($args);
            if ( is_array($cust_query) && sizeof($cust_query) > 0 ) {
                foreach ( $cust_query as $package_post ) {
                    if ( isset($package_post->ID) ) {
                        $package_id = $package_post->ID;
                        $package_title = $package_post->post_title;
                        if ( ! in_array($package_id, $type_pckgs_arr) ) {
                            $wp_rem_packages_list[$package_id] = $package_title;
                        }
                    }
                }
            }

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_select_packages'),
                'desc' => '',
                'hint_text' => wp_rem_plugin_text_srt('wp_rem_select_packages_hint'),
                'echo' => true,
                'multi' => true,
                'desc' => '',
                'field_params' => array(
                    'std' => '',
                    'id' => 'property_type_packages',
                    'classes' => 'chosen-select-no-single chosen-select',
                    'options' => $wp_rem_packages_list,
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
        }

        function get_attached_cats($type = '', $meta_key = '') {
            global $post;

            $wp_rem_category_array = array();
            $args = array(
                'posts_per_page' => "-1",
                'post_type' => "$type",
                'post_status' => array( 'publish', 'pending', 'draft' ),
                'post__not_in' => array( $post->ID )
            );

            $custom_query = new WP_Query($args);
            if ( $custom_query->have_posts() <> "" ) {

                while ( $custom_query->have_posts() ): $custom_query->the_post();
                    $wp_rem_aut_categories = get_post_meta(get_the_ID(), "$meta_key", true);
                    if ( is_array($wp_rem_aut_categories) ) {
                        $wp_rem_category_array = array_merge($wp_rem_category_array, $wp_rem_aut_categories);
                    }
                endwhile;
            }
            wp_reset_postdata();

            return is_array($wp_rem_category_array) ? array_unique($wp_rem_category_array) : $wp_rem_category_array;
        }

        /**
         * @Inventory Type Custom Fileds Function
         * @return
         */
        function wp_rem_post_property_type_fields() {

            global $post, $wp_rem_form_fields, $wp_rem_html_fields, $wp_rem_property_type_fields;

            $wp_rem_property_type_fields->custom_fields();
        }

        /**
         * @Inventory Type Features Function
         * @return
         */
        function wp_rem_post_property_type_features() {

            global $post, $wp_rem_form_fields, $wp_rem_html_fields;

            $this->wp_rem_features_items($post);
        }

        function wp_rem_post_property_type_tags() {

            global $post, $wp_rem_form_fields, $wp_rem_html_fields;

            $this->wp_rem_tags_items();
        }

        function wp_rem_post_property_type_categories() {

            global $post, $wp_rem_form_fields, $wp_rem_html_fields;

            $wp_rem_property_type_tags = get_post_meta($post->ID, 'wp_rem_property_type_cats', true);
            $tag_obj_array = array();
            if ( is_array($wp_rem_property_type_tags) && sizeof($wp_rem_property_type_tags) > 0 ) {
                foreach ( $wp_rem_property_type_tags as $tag_r ) {
                    $tag_obj = get_term_by('slug', $tag_r, 'property-category');
                    if ( is_object($tag_obj) ) {
                        $tag_obj_array[$tag_obj->slug] = $tag_obj->name;
                    }
                }
            }

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_select_cats'),
                'desc' => '',
                'hint_text' => wp_rem_plugin_text_srt('wp_rem_select_cats_hint'),
                'echo' => true,
                'multi' => true,
                'desc' => sprintf('<a href="'. admin_url('edit-tags.php?taxonomy=property-category&post_type=properties', wp_rem_server_protocol()) .'">'. wp_rem_plugin_text_srt('wp_rem_add_new_cats_link') .'</a>'),
                'field_params' => array(
                    'std' => '',
                    'id' => 'property_type_cats',
                    'classes' => 'chosen-select-no-single chosen-select',
                    'options' => $tag_obj_array,
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
            wp_enqueue_script('chosen-ajaxify');
            echo '
			<script>
			jQuery(window).load(function(){
				chosen_ajaxify("wp_rem_property_type_cats", "' . esc_url(admin_url('admin-ajax.php')) . '", "wp_rem_get_cats_list");
			});
			</script>';
        }

        public function wp_rem_get_cats_list() {
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
            $wp_rem_tags_array = get_terms('property-category', array(
                'hide_empty' => false,
                'parent' => 0,
            ));

            $property_types_cats = array();
            $args = array(
                'posts_per_page' => "-1",
                'post_type' => 'property-type',
                'post_status' => 'publish',
                'fields' => 'ids',
                'meta_query' => array(
                    array(
                        'key' => 'wp_rem_property_type_cats',
                        'value' => '',
                        'compare' => '!=',
                    ),
                ),
            );

            $custom_query = new WP_Query($args);
            $property_types_loop = $custom_query->posts;

            $property_types_cats_arr = array();
            if ( is_array($property_types_loop) ) {

                foreach ( $property_types_loop as $property_type_id ) {
                    $property_type_cats = get_post_meta($property_type_id, 'wp_rem_property_type_cats', true);
                    if ( is_array($property_type_cats) ) {
                        foreach ( $property_type_cats as $property_type_cat_in ) {
                            $property_types_cats_arr[] = $property_type_cat_in;
                        }
                    }
                }
            }

            $wp_rem_tags_list = array();
            if ( is_array($wp_rem_tags_array) && sizeof($wp_rem_tags_array) > 0 ) {
                foreach ( $wp_rem_tags_array as $dir_tag ) {
                    if ( ! in_array($dir_tag->slug, $property_types_cats_arr) ) {
                        $wp_rem_tags_list[] = array( 'value' => $dir_tag->slug, 'caption' => $dir_tag->name );
                    }
                }
            }
            echo json_encode($wp_rem_tags_list);
            die;
        }

        public function features_save($post_id) {
            if ( isset($_POST['wp_rem_features_array']) && is_array($_POST['wp_rem_features_array']) ) {
                $feat_array = array();
                $feat_counter = 0;
                foreach ( $_POST['wp_rem_features_array'] as $feat ) {
                    $feat_name = isset($_POST['wp_rem_feature_name_array'][$feat_counter]) ? $_POST['wp_rem_feature_name_array'][$feat_counter] : '';
                    $feat_array[$feat] = array( 'key' => 'feature_' . $feat, 'name' => $feat_name, 'icon' => $_POST['wp_rem_feature_icon_array'][$feat_counter] );
                    $feat_counter ++;
                }
                update_post_meta($post_id, 'wp_rem_property_type_features', $feat_array);
            }
        }

        public function tags_save($post_id) {
            if ( isset($_POST['wp_rem_property_type_tags']) ) {
                update_post_meta($post_id, 'wp_rem_property_type_tags', $_POST['wp_rem_property_type_tags']);
            } else {
                update_post_meta($post_id, 'wp_rem_property_type_tags', '');
            }
        }

        public function categories_save($post_id) {
            if ( isset($_POST['wp_rem_property_type_cats']) ) {
                update_post_meta($post_id, 'wp_rem_property_type_cats', $_POST['wp_rem_property_type_cats']);
            } else {
                update_post_meta($post_id, 'wp_rem_property_type_cats', '');
            }
        }

        public function wp_rem_features_items($post) {
            global $post, $wp_rem_form_fields, $wp_rem_html_fields, $wp_rem_plugin_static_text;
            $wp_rem_get_features = get_post_meta($post->ID, 'wp_rem_property_type_features', true);
            $ratings = array();
            $post_id = $post->ID;
            $featured_lables = get_post_meta($post_id, 'feature_lables', true);
            $wp_rem_feature_icon = get_post_meta($post_id, 'wp_rem_feature_icon', true);
            $wp_rem_feature_icon_group = get_post_meta($post_id, 'wp_rem_feature_icon_group', true);
            $wp_rem_enable_not_selected = get_post_meta($post_id, 'wp_rem_enable_not_selected', true);
            ?>
            <div id="tab-features_settings">
                <?php
                $post_meta = get_post_meta(get_the_id());
                $features_data = array();
                if ( isset($post_meta['wp_rem_property_type_features']) && isset($post_meta['wp_rem_property_type_features'][0]) ) {
                    $features_data = json_decode($post_meta['wp_rem_property_type_features'][0], true);
                }
                if ( count($featured_lables) > 0 ) {
                    $wp_rem_opt_array = array(
                        'name' => wp_rem_plugin_text_srt('wp_rem_show_all_feature_item'),
                        'desc' => '',
                        'hint_text' => wp_rem_plugin_text_srt('wp_rem_show_all_feature_item_desc'),
                        'echo' => true,
                        'field_params' => array(
                            'std' => $wp_rem_enable_not_selected,
                            'id' => 'enable_not_selected',
                            'return' => true,
                        ),
                    );
                    $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);
                }

                $icon_rand_id = rand(10000000, 99999999);
                ?>


                <div class="wp-rem-list-wrap wp-rem-features-list-wrap">
                    <ul class="wp-rem-list-layout">
                        <li class="wp-rem-list-label">
                            <div class="col-lg-1 col-md-1 col-sm-6 col-xs-12">
                                <div class="element-label">
                                    <label></label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="element-label">
                                    <label><?php echo wp_rem_plugin_text_srt('wp_rem_options_feature_icon'); ?></label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="element-label">
                                    <label><?php echo wp_rem_plugin_text_srt('wp_rem_options_feature_label'); ?> </label>
                                </div>
                            </div>
                        </li>


                        <?php
                        $counter = 0;
                        if ( is_array($featured_lables) && sizeof($featured_lables) > 0 ) {

                            foreach ( $featured_lables as $key => $lable ) {
                                $icon = isset($wp_rem_feature_icon[$key]) ? $wp_rem_feature_icon[$key] : '';
                                $icon_group = isset($wp_rem_feature_icon_group[$key]) ? $wp_rem_feature_icon_group[$key] : 'default';
                                ?>
                                <li class="wp-rem-list-item">
                                    <div class="col-lg-1 col-md-1 col-sm-6 col-xs-12">
                                        <!--For Simple Input Element-->
                                        <div class="input-element">
                                            <div class="input-holder">
                                                <span class="cntrl-drag-and-drop"><i class="icon-menu2"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <!--For Simple Input Element-->
                                        <div class="input-element">
                                            <div class="input-holder">
                                                <?php echo apply_filters( 'cs_icons_fields', $icon, 'feature_icon' . $icon_rand_id . $counter, 'wp_rem_feature_icon', $icon_group ); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <!--For Simple Input Element-->
                                        <div class="input-element">
                                            <div class="input-holder">
                                                <?php
                                                $wp_rem_opt_array = array(
                                                    'std' => isset($lable) ? esc_html($lable) : '',
                                                    'cust_name' => 'feature_label[]',
                                                    'extra_atr' => 'placeholder="' . wp_rem_plugin_text_srt('wp_rem_property_type_features_label') . '"',
                                                    'classes' => 'review_label input-field',
                                                );
                                                $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="javascript:void(0);" class="wp-rem-remove wp-rem-parent-li-remove"><i class="icon-close2"></i></a>
                                </li>
                                <?php
                                $counter ++;
                            }
                        }
                        ?>
                    </ul>        
                        <ul class="wp-rem-list-button-ul">
                            <li class="wp-rem-list-button">
                                <div class="input-element">
                                    <a href="javascript:void(0);" id="click-more" class="wp-rem-add-more cntrl-add-new-row" onclick="duplicate()"><?php echo wp_rem_plugin_text_srt('wp_rem_property_type_meta_feature_add_row'); ?></a>
                                </div>
                            </li>
                        </ul>
                </div>

            </div>

            <script type="text/javascript">
                jQuery(document).ready(function () {
                    var table_class = ".wp-rem-features-list-wrap .wp-rem-list-layout";
                    jQuery(table_class).sortable({
                        //items: "> tr:not(:last)",
                       cancel: "input, .wp-rem-list-label"
                    });
                });	// Function for duplicate <tr> for add features.
                var counter_val = 1;
                function duplicate() {
                    counter_val;
                    
                    $(".wp-rem-features-list-wrap .wp-rem-list-layout").append('<li class="wp-rem-list-item"><div class="col-lg-1 col-md-1 col-sm-6 col-xs-12"><div class="input-element"><div class="input-holder"><span class="cntrl-drag-and-drop"><i class="icon-menu2"></i></span></div></div></div><div class="col-lg-2 col-md-2 col-sm-6 col-xs-12"><div class="input-element"><div class="input-holder" id="icon-' + counter_val + '<?php echo absint($icon_rand_id); ?>"></div></div></div><div class="col-lg-8 col-md-8 col-sm-6 col-xs-12"><div class="input-element"><div class="input-holder"><input type="text" placeholder="<?php echo wp_rem_plugin_text_srt('wp_rem_property_type_features_label'); ?>" class="review_label input-field" name="feature_label[]" value=""></div></div></div><a href="javascript:void(0);" class="wp-rem-remove wp-rem-parent-li-remove"><i class="icon-close2"></i></a></li>');
                    wp_rem_ft_icon_feature(counter_val + '<?php echo absint($icon_rand_id); ?>');
                    counter_val++;
                }
                jQuery(document).on('click', '.cntrl-delete-rows', function () {
                    delete_row_top(this);
                    return false;
                });
                function delete_row_top(delete_link) {
                    $(delete_link).parent().parent().remove();
                }
            </script>
            <?php
        }

        public function wp_rem_tags_items() {

            global $post, $wp_rem_form_fields, $wp_rem_html_fields, $wp_rem_plugin_static_text;


            $wp_rem_property_type_tags = get_post_meta($post->ID, 'wp_rem_property_type_tags', true);
            $tag_obj_array = array();
            if ( is_array($wp_rem_property_type_tags) && sizeof($wp_rem_property_type_tags) > 0 ) {
                foreach ( $wp_rem_property_type_tags as $tag_r ) {
                    $tag_obj = get_term_by('slug', $tag_r, 'property-tag');
                    if ( is_object($tag_obj) ) {
                        $tag_obj_array[$tag_obj->slug] = $tag_obj->name;
                    }
                }
            }

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_select_suggested_tags'),
                'desc' => '',
                'hint_text' => wp_rem_plugin_text_srt('wp_rem_select_suggested_tags_hint'),
                'echo' => true,
                'multi' => true,
                'desc' => sprintf(wp_rem_plugin_text_srt('wp_rem_add_new_tag_link'), admin_url('edit-tags.php?taxonomy=property-tag&post_type=properties', wp_rem_server_protocol())),
                'field_params' => array(
                    'std' => '',
                    'id' => 'property_type_tags',
                    'classes' => 'chosen-select-no-single chosen-select',
                    'options' => $tag_obj_array,
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

            echo '
			<script>
			jQuery(window).load(function(){
				chosen_ajaxify("wp_rem_property_type_tags", "' . esc_url(admin_url('admin-ajax.php')) . '", "wp_rem_get_tags_list");
			});
			</script>';
        }

        public function wp_rem_get_tags_list() {
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
            $wp_rem_tags_array = get_terms('property-tag', array(
                'hide_empty' => false,
            ));
            $wp_rem_tags_list = array();
            if ( is_array($wp_rem_tags_array) && sizeof($wp_rem_tags_array) > 0 ) {
                foreach ( $wp_rem_tags_array as $dir_tag ) {
                    $wp_rem_tags_list[] = array( 'value' => $dir_tag->slug, 'caption' => $dir_tag->name );
                }
            }
            echo json_encode($wp_rem_tags_list);
            die;
        }

        public function wp_rem_categories_items() {

            global $post, $wp_rem_form_fields, $wp_rem_html_fields, $wp_rem_plugin_static_text;
            $post_meta = get_post_meta(get_the_id());

            $wp_rem_get_categories = get_the_terms(get_the_id(), 'property-category');


            $html = '
            <script>
                jQuery(document).ready(function($) {
                    $("#total_categories").sortable({
                        cancel : \'td div.table-form-elem
                    });
                });
            </script>
              <ul class="form-elements">
                  <li class="to-button"><a href="javascript:wp_rem_createpop(\'add_category_title\',\'filter\')" class="button">' . wp_rem_plugin_text_srt('wp_rem_add_category') . '</a> </li>
               </ul>
              <div class="cs-service-list-table">
              <table class="to-table" border="0" cellspacing="0">
                    <thead>
                      <tr>
                        <th style="width:60%;">' . wp_rem_plugin_text_srt('wp_rem_title') . '</th>
                        <th style="width:100%;">' . wp_rem_plugin_text_srt('wp_rem_icon') . '</th>
                        <th style="width:20%;" class="right">' . wp_rem_plugin_text_srt('wp_rem_actions') . '</th>
                      </tr>
                    </thead>
                    <tbody id="total_categories">';
            if ( is_array($wp_rem_get_categories) && sizeof($wp_rem_get_categories) > 0 ) {

                foreach ( $wp_rem_get_categories as $categories ) {
                    $category_icon = get_term_meta($categories->term_id, 'wp_rem_property_taxonomy_icon', true);
                    $wp_rem_categories_array = array(
                        'counter_category' => $categories->term_id,
                        'category_id' => $categories->term_id,
                        'wp_rem_category_name' => $categories->name,
                        'wp_rem_property_taxonomy_icons' => $category_icon
                    );

                    $html .= $this->add_category_to_list($wp_rem_categories_array);
                    $category_icon = '';
                }
            }

            $html .= '
                </tbody>
            </table>

            </div>
            <div id="add_category_title" style="display: none;">
                  <div class="cs-heading-area">
                    <h5><i class="icon-plus-circle"></i> ' . wp_rem_plugin_text_srt('wp_rem_property_categories') . '</h5>
                    <span class="cs-btnclose" onClick="javascript:wp_rem_removeoverlay(\'add_category_title\',\'append\')"> <i class="icon-times"></i></span> 	
                  </div>';



            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_name'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'wp_rem_category_name',
                    'cust_name' => 'wp_rem_category_name[]',
                    'return' => true,
                ),
            );

            $html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
            $terms = get_terms(array(
                'taxonomy' => 'property-category',
                'hide_empty' => false,
            ));

            $cats_parents = array();
            $cats_parents[''] = wp_rem_plugin_text_srt('wp_rem_property_type_no_parent');
            foreach ( $terms as $term ) {

                $cats_parents[$term->term_id] = $term->name;
            }
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_parent'),
                'desc' => '',
                'hint_text' => '',
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'wp_rem_category_parent',
                    'cust_name' => 'wp_rem_category_parent[]',
                    'classes' => 'dropdown chosen-select',
                    'options' => $cats_parents,
                    'return' => true,
                ),
            );


            $html .= $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

            $html .= '<div class="form-elements"><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<label>' . wp_rem_plugin_text_srt('wp_rem_icon') . '</label></div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $html .= wp_rem_iconlist_plugin_options("", "property_type_icons", "wp_rem_property_taxonomy_icons");
            $html .= '</div></div>';
            $html .= '
                <ul class="form-elements noborder">
                  <li class="to-label"></li>
                  <li class="to-field">
                        <input type="button" value="' . wp_rem_plugin_text_srt('wp_rem_add_category') . '" onclick="add_property_category(\'' . esc_js(admin_url('admin-ajax.php')) . '\')" />
                        <div class="category-loader"></div>
                  </li>
                </ul>
          </div>';

            echo force_balance_tags($html, true);
        }

        public function add_feature_to_list($wp_rem_atts = array()) {

            global $post, $wp_rem_form_fields, $wp_rem_html_fields, $wp_rem_plugin_static_text;
            $wp_rem_defaults = array(
                'counter_feature' => '',
                'feature_id' => '',
                'wp_rem_feature_name' => '',
                'wp_rem_feature_icon' => '',
                'wp_rem_feature_icon_group' => 'default',
            );
            extract(shortcode_atts($wp_rem_defaults, $wp_rem_atts));

            foreach ( $_POST as $keys => $values ) {
                $$keys = $values;
            }

            if ( isset($_POST['wp_rem_feature_name']) && $_POST['wp_rem_feature_name'] <> '' ) {
                $wp_rem_feature_name = $_POST['wp_rem_feature_name'];
            }

            if ( isset($_POST['wp_rem_feature_icon']) && $_POST['wp_rem_feature_icon'] <> '' ) {
                $wp_rem_feature_icon = $_POST['wp_rem_feature_icon'];
            }


            if ( $feature_id == '' && $counter_feature == '' ) {
                $counter_feature = $feature_id = rand(1000000000, 9999999999);
            }

            $html = '
            <tr class="parentdelete" id="edit_track' . absint($counter_feature) . '">
              <td id="subject-title' . absint($counter_feature) . '" style="width:100%;">' . esc_attr($wp_rem_feature_name) . '</td>
              <td id="subject-title' . absint($counter_feature) . '" style="width:100%;"><i class="' . esc_attr($wp_rem_feature_icon) . '"></i></td>

              <td class="centr" style="width:20%;"><a href="javascript:wp_rem_createpop(\'edit_track_form' . absint($counter_feature) . '\',\'filter\')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
              <td style="width:0"><div id="edit_track_form' . esc_attr($counter_feature) . '" style="display: none;" class="table-form-elem">
                <input type="hidden" name="wp_rem_features_array[]" value="' . absint($feature_id) . '" />
                  <div class="cs-heading-area">
                        <h5 style="text-align: left;">' . wp_rem_plugin_text_srt('wp_rem_property_features') . '</h5>
                        <span onclick="javascript:wp_rem_removeoverlay(\'edit_track_form' . esc_js($counter_feature) . '\',\'append\')" class="cs-btnclose"> <i class="icon-times"></i></span>
                        <div class="clear"></div>
                  </div>';

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_title'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => $wp_rem_feature_name,
                    'id' => 'feature_name',
                    'return' => true,
                    'array' => true,
                    'extra_atr' => 'onchange="change_feature_value(\'subject-title' . $counter_feature . '\',this.value);"',
                    'force_std' => true,
                ),
            );

            $html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

            $html .= '<div class="form-elements"><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<label>' . wp_rem_plugin_text_srt('wp_rem_icon') . '</label></div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            //$html .= wp_rem_iconlist_plugin_options($wp_rem_feature_icon, 'feature_icon' . $counter_feature, 'wp_rem_feature_icon_array');
            
            $html .= apply_filters( 'cs_icons_fields', $wp_rem_feature_icon, 'feature_icon' . $counter_feature, 'wp_rem_feature_icon_array');

            $html .= '</div></div>';

            $html .= '
                    <ul class="form-elements noborder">
                        <li class="to-label">
                          <label></label>
                        </li>
                        <li class="to-field">
                          <input type="button" value="' . wp_rem_plugin_text_srt('wp_rem_update_feature') . '" onclick="wp_rem_removeoverlay(\'edit_track_form' . esc_js($counter_feature) . '\',\'append\')" />
                        </li>
                    </ul>
                  </div>
                </td>
            </tr>';

            if ( isset($_POST['wp_rem_feature_name']) ) {
                echo force_balance_tags($html);
            } else {
                return $html;
            }

            if ( isset($_POST['wp_rem_feature_name']) ) {
                die();
            }
        }

        public function wp_rem_ft_icon($value = '', $id = '', $name = '') {//begin function
            if ( $value == '' && $id == '' && $name == '' ) {
                $id = rand(10000000, 99999999);
                $name = 'wp_rem_feature_icon';
            }
            $html = "
			<script>
			jQuery(document).ready(function ($) {
				var this_icons;
				var rand_num = " . $id . ";
				var e9_element = $('#e9_element_' + rand_num).fontIconPicker({
					theme: 'fip-bootstrap'
				});
				icons_load_call.always(function () {
					this_icons = loaded_icons;
					// Get the class prefix
					var classPrefix = this_icons.preferences.fontPref.prefix,
							icomoon_json_icons = [],
							icomoon_json_search = [];
					$.each(this_icons.icons, function (i, v) {
						icomoon_json_icons.push(classPrefix + v.properties.name);
						if (v.icon && v.icon.tags && v.icon.tags.length) {
							icomoon_json_search.push(v.properties.name + ' ' + v.icon.tags.join(' '));
						} else {
							icomoon_json_search.push(v.properties.name);
						}
					});
					// Set new fonts on fontIconPicker
					e9_element.setIcons(icomoon_json_icons, icomoon_json_search);
					// Show success message and disable
					$('#e9_buttons_' + rand_num + ' button').removeClass('btn-primary').addClass('btn-success').text('Successfully loaded icons').prop('disabled', true);
				})
				.fail(function () {
					// Show error message and enable
					$('#e9_buttons_' + rand_num + ' button').removeClass('btn-primary').addClass('btn-danger').text('Error: Try Again?').prop('disabled', false);
				});
			});
			</script>";

            $html .= '
			<input type="text" id="e9_element_' . $id . '" name="' . $name . '[]" value="' . $value . '">
			<span id="e9_buttons_' . $id . '" style="display:none">\
				<button autocomplete="off" type="button" class="btn btn-primary">Load from IcoMoon selection.json</button>
			</span>';
            
            
             $html = apply_filters( 'cs_icons_fields', $value, $id, $name, 'default' );
            
            if ( isset($_POST['field']) && $_POST['field'] == 'icon' ) {
                echo json_encode(array( 'icon' => $html ));
                die;
            } else {
                return $html;
            }
        }

        public function add_category_to_list($wp_rem_atts = array()) {

            global $post, $wp_rem_form_fields, $wp_rem_html_fields, $wp_rem_plugin_static_text;
            $wp_rem_defaults = array(
                'counter_category' => '',
                'category_id' => '',
                'wp_rem_category_name' => '',
                'wp_rem_category_parent' => '',
                'wp_rem_property_taxonomy_icons' => '',
            );
            extract(shortcode_atts($wp_rem_defaults, $wp_rem_atts));

            foreach ( $_POST as $keys => $values ) {
                $$keys = $values;
            }

            if ( isset($_POST['wp_rem_category_name']) && $_POST['wp_rem_category_name'] <> '' ) {
                $wp_rem_featu_name = $_POST['wp_rem_category_name'];
            }

            if ( isset($_POST['wp_rem_category_parent']) && $_POST['wp_rem_category_parent'] <> '' ) {
                $wp_rem_category_parent = $_POST['wp_rem_category_parent'];
            }
            if ( isset($_POST['wp_rem_property_taxonomy_icons']) && $_POST['wp_rem_property_taxonomy_icons'] <> '' ) {
                $wp_rem_property_taxonomy_icons = $_POST['wp_rem_property_taxonomy_icons'];
            }


            if ( $category_id == '' && $counter_category == '' ) {
                $counter_category = $category_id = rand(1000000000, 9999999999);
            }

            $html = '
            <tr class="parentdelete" id="edit_track' . absint($counter_category) . '">
              <td id="subject-title' . absint($counter_category) . '" style="width:100%;">' . esc_attr($wp_rem_category_name) . '</td>
              <td id="subject-title' . absint($counter_category) . '" style="width:100%;"><i class="' . esc_attr($wp_rem_category_parent) . '"></i></td>

              <td class="centr" style="width:20%;"><a href="javascript:wp_rem_createpop(\'edit_track_form' . absint($counter_category) . '\',\'filter\')" class="actions edit">&nbsp;</a> <a  href="#"  data-catid=' . $counter_category . ' class="delete-it btndeleteit actions delete">&nbsp;</a></td>
              <td style="width:0"><div id="edit_track_form' . esc_attr($counter_category) . '" style="display: none;" class="table-form-elem">
                <input type="hidden" name="wp_rem_categorys_array[]" value="' . absint($category_id) . '" />
                  <div class="cs-heading-area">
                        <h5 style="text-align: left;">' . wp_rem_plugin_text_srt('wp_rem_property_categorys') . '</h5>
                        <span onclick="javascript:wp_rem_removeoverlay(\'edit_track_form' . esc_js($counter_category) . '\',\'append\')" class="cs-btnclose"> <i class="icon-times"></i></span>
                        <div class="clear"></div>
                  </div>';

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_title'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => $wp_rem_category_name,
                    'id' => 'category_name',
                    'return' => true,
                    'array' => true,
                    'extra_atr' => 'onchange="change_category_value(\'subject-title' . $counter_category . '\',this.value);"',
                    'force_std' => true,
                ),
            );

            $terms = get_terms(array(
                'taxonomy' => 'property-category',
                'hide_empty' => false,
            ));
            $cats_parents = array();
            $cats_parents[''] = wp_rem_plugin_text_srt('wp_rem_property_type_no_parent');

            foreach ( $terms as $term ) {

                $cats_parents[$term->term_id] = $term->name;
            }
            $html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);




            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_parent'),
                'desc' => '',
                'hint_text' => '',
                'field_params' => array(
                    'std' => $wp_rem_category_parent,
                    'cust_name' => 'wp_rem_category_parent[]',
                    'classes' => 'dropdown chosen-select',
                    'options' => $cats_parents,
                    'return' => true,
                ),
            );



            $html .= $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
            $html .= '<div class="form-elements"><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<label>' . wp_rem_plugin_text_srt('wp_rem_icon') . '</label></div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            //$html .= wp_rem_iconlist_plugin_options($wp_rem_property_taxonomy_icons, "property_type_icon" . $counter_category, "wp_rem_property_taxonomy_icon_array");
            $html .= apply_filters( 'cs_icons_fields', $wp_rem_property_taxonomy_icons, "property_type_icon" . $counter_category, "wp_rem_property_taxonomy_icon_array");

            $html .= '</div></div>';
            $wp_rem_opt_array = array(
                'name' => '',
                'desc' => '',
                'hint_text' => '',
                'field_params' => array(
                    'std' => '',
                    'return' => true,
                    'cust_name' => 'deleted_categories',
                    'array' => true,
                    'cust_type' => 'hidden',
                ),
            );
            $html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
            $html .= '
                    <ul class="form-elements noborder">
                        <li class="to-label">
                          <label></label>
                        </li>
                        <li class="to-field">
                          <input type="button" value="' . wp_rem_plugin_text_srt('wp_rem_update_category') . '" onclick="wp_rem_removeoverlay(\'edit_track_form' . esc_js($counter_category) . '\',\'append\')" />
                        </li>
                    </ul>
                  </div>
                </td>
            </tr>';

            if ( isset($_POST['wp_rem_category_name']) ) {
                echo force_balance_tags($html);
            } else {
                return $html;
            }

            if ( isset($_POST['wp_rem_category_name']) ) {
                die();
            }
        }

        function wp_rem_post_page_elements_setting() {

            global $post, $wp_rem_form_fields, $wp_rem_html_fields, $wp_rem_plugin_options;

            $wp_rem_html_fields->wp_rem_heading_render(array( 'name' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_property_price_options') ));
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_property_price'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'property_type_price',
                    'extra_atr' => 'onclick="property_type_price(\'wp_rem_property_type_price\');"',
                    'return' => true,
                ),
            );
            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $property_detail_page = get_post_meta($post->ID, 'wp_rem_property_type_price', true);
            $display_style = ( $property_detail_page == 'on' ) ? 'block' : 'none';
            echo '<div class="price-settings" style="display:' . $display_style . ';">';
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_property_price_type'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'property_type_price_type',
                    'classes' => 'chosen-select-no-single',
                    'return' => true,
                    'options' => array(
                        'fixed' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_property_price_type_fixed'),
                        'variant' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_property_price_type_varient'),
                    ),
                ),
            );
            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);


            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_minimum_options_filter'),
                'desc' => '',
                'hint_text' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_minimum_options_filter_desc'),
                'echo' => false,
                'field_params' => array(
                    'std' => '1',
                    'classes' => 'wp-rem-number-field',
                    'id' => 'price_minimum_options',
                    'cust_type' => 'number',
                    // 'active' => 'in-active',
                    'return' => true,
                ),
            );
            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_maximum_options_filter'),
                'desc' => '',
                'hint_text' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_maximum_options_filter_desc'),
                'echo' => false,
                'field_params' => array(
                    'std' => '50000',
                    'classes' => 'wp-rem-number-field',
                    'id' => 'price_max_options',
                    'cust_type' => 'number',
                    'return' => true,
                ),
            );
            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_man_max_interval'),
                'desc' => '',
                'hint_text' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_man_max_interval_desc'),
                'echo' => false,
                'field_params' => array(
                    'std' => '50',
                    'classes' => 'wp-rem-number-field',
                    'id' => 'price_interval',
                    'cust_type' => 'number',
                    'return' => true,
                ),
            );
            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => 'Price Filter Values',
                'desc' => '',
                'hint_text' => 'Set values for min and max price inputs separeted by commas. All non digital values are skipped. Last value will be duplicate in form ">10000"',
                'echo' => true,
                'field_params' => array(
                    'std' => '500,1000,1500',
                    'classes' => 'wp-rem-number-field',
                    'id' => 'price_filter_interval',
                    'cust_type' => 'text',
                    'return' => true,
                ),
            );
            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);


            echo '</div>';

            $wp_rem_html_fields->wp_rem_heading_render(array( 'name' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_others') ));

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_open_house'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'property_type_open_house',
                    'return' => true,
                ),
            );
            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_image_gallery'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => 'on',
                    'id' => 'image_gallery_element',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_social_share'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => 'on',
                    'id' => 'social_share_element',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_location_map'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => 'on',
                    'id' => 'location_element',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_files_attchments_options'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => 'on',
                    'id' => 'attachments_options_element',
                    'return' => true,
                ),
            );
            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_allowed_extension'),
                'desc' => '',
                'hint_text' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_allowed_extension_desc'),
                'echo' => true,
                'multi' => true,
                'field_params' => array(
                    'std' => 'txt,pdf,doc,docx',
                    'id' => 'property_allowd_attachment_extensions',
                    'classes' => 'chosen-select-no-single',
                    'return' => true,
                    'options' => array(
                        'txt' => 'txt',
                        'rtf' => 'rtf',
                        'gif' => 'gif',
                        'jpg' => 'jpg',
                        'jpeg' => 'jpeg',
                        'png' => 'png',
                        'pdf' => 'pdf',
                        'doc' => 'doc',
                        'docx' => 'docx',
                        'xls' => 'xls',
                        'xlsx' => 'xlsx',
                        'ppt' => 'ppt',
                        'pptx' => 'pptx',
                        'bmp' => 'bmp',
                        'tif' => 'tif',
                        'csv' => 'csv',
                        'mp3' => 'mp3',
                        'ogg' => 'ogg',
                        'mp4' => 'mp4',
                        'webm' => 'webm',
                        'swf' => 'swf',
                        'rar' => 'rar',
                        'zip' => 'zip' ),
                ),
            );
            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_floor_plans_options'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => 'on',
                    'id' => 'floor_plans_options_element',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_walk_score'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => 'on',
                    'id' => 'walkscores_options_element',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_near_by_options'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => 'on',
                    'id' => 'near_by_options_element',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_show_more_less_desc'),
                'desc' => '',
                'hint_text' => '',
                'extra_att' => 'id="dir_property_detail_length_switch"',
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'property_detail_length_switch',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

            $property_detail_length_switch = get_post_meta($post->ID, 'wp_rem_property_detail_length_switch', true);
            echo '<div id="property-desc-detail-length-holder" style="display: ' . ($property_detail_length_switch == 'on' ? 'block' : 'none') . ';">';
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_description_length'),
                'desc' => '',
                'hint_text' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_description_length_in_words'),
                'echo' => true,
                'field_params' => array(
                    'std' => '50',
                    'classes' => 'wp-rem-number-field',
                    'id' => 'property_desc_detail_length',
                    'return' => true,
                ),
            );
            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
            echo '</div>';

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_detail_page'),
                'desc' => '',
                'hint_text' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_detail_page_select'),
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'property_detail_page',
                    'classes' => 'chosen-select-no-single',
                    'return' => true,
                    'options' => array(
                        '' => wp_rem_plugin_text_srt('wp_rem_list_meta_default_view'),
                        'detail_view1' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_detail_page_select1'),
                        'detail_view2' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_detail_page_select2'),
                        'detail_view3' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_detail_page_select3'),
                        'detail_view4' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_detail_page_select4'),
                    ),
                ),
            );
            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
        }

        public function wp_rem_save_post_categories($post_id) {
            if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
                return;
            }


            if ( get_post_type() == 'property-type' ) {

                $property_type_categories = array();
                $del_Cats = isset($_POST['deleted_categories']) ? $_POST['deleted_categories'] : '';
                $feature_label = isset($_POST['feature_label']) ? $_POST['feature_label'] : '';
                $enable_not_selected = isset($_POST['wp_rem_enable_not_selected']) ? $_POST['wp_rem_enable_not_selected'] : '';
                $wp_rem_feature_icon = isset($_POST['wp_rem_feature_icon']) ? $_POST['wp_rem_feature_icon'] : '';
                $wp_rem_feature_icon_group = isset($_POST['wp_rem_feature_icon_group']) ? $_POST['wp_rem_feature_icon_group'] : '';
                $feature_array = array();
                if ( ! empty($feature_label) ) {
                    foreach ( $feature_label as $key => $lablel ) {
                        if ( $lablel != '' ) {
                            $feature_array[] = $lablel;
                        }
                    }
                }
                $feature_icons = array();
                if ( ! empty($wp_rem_feature_icon) ) {
                    foreach ( $wp_rem_feature_icon as $icon ) {
                        // if ( $icon != '' ) {
                        $feature_icons[] = $icon;
                        //}
                    }
                }
                
                $feature_icons_group = array();
                if ( ! empty($wp_rem_feature_icon_group) ) {
                    foreach ( $wp_rem_feature_icon_group as $icon_group ) {
                        // if ( $icon != '' ) {
                        $feature_icons_group[] = $icon_group;
                        //}
                    }
                }

                update_post_meta($post_id, 'wp_rem_enable_not_selected', $enable_not_selected);
                update_post_meta($post_id, 'feature_lables', $feature_array);
                update_post_meta($post_id, 'wp_rem_feature_icon', $feature_icons);
                update_post_meta($post_id, 'wp_rem_feature_icon_group', $feature_icons_group);

                $wp_rem_categorys_array = isset($_POST['wp_rem_categorys_array']) ? $_POST['wp_rem_categorys_array'] : '';
                $wp_rem_property_taxonomy_icon_array = isset($_POST['wp_rem_property_taxonomy_icon_array']) ? $_POST['wp_rem_property_taxonomy_icon_array'] : '';

                $delete_categories = explode(',', $del_Cats);
                if ( ! empty($delete_categories) ) {
                    foreach ( $delete_categories as $cat ) {
                        if ( $cat != '' ) {
                            wp_delete_term($cat, 'property-category');
                        }
                    }
                }
                $wp_rem_category_parent = isset($_POST['wp_rem_category_parent']) ? $_POST['wp_rem_category_parent'] : '';
                $wp_rem_category_name_array = isset($_POST['wp_rem_category_name_array']) ? $_POST['wp_rem_category_name_array'] : '';
                $cats_array = array();
                if ( ! empty($wp_rem_category_name_array) ) {
                    foreach ( $wp_rem_category_name_array as $cat_key => $cat_val ) {

                        $cat_parent = isset($wp_rem_category_parent[$cat_key]) ? $wp_rem_category_parent[$cat_key] : '';
                        $cat_name = sanitize_title($cat_val, 'no-title');
                        $cat_display_name = $cat_val;

                        if ( term_exists(intval($wp_rem_categorys_array[$cat_key]), 'property-category') ) {
                            $args = array(
                                'name' => $cat_display_name,
                                'parent' => $cat_parent
                            );
                            wp_update_term($wp_rem_categorys_array[$cat_key], 'property-category', $args);
                            if ( isset($wp_rem_property_taxonomy_icon_array[$cat_key]) ) {
                                update_term_meta($wp_rem_categorys_array[$cat_key], 'wp_rem_property_taxonomy_icon', $wp_rem_property_taxonomy_icon_array[$cat_key]);
                            }
                        } else {

                            if ( ! term_exists($cat_name, 'property-category') ) {
                                $wp_rem_cat_args = array( 'cat_name' => $cat_display_name, 'category_description' => wp_rem_plugin_text_srt('wp_rem_category_description'), 'category_nicename' => $cat_display_name, 'category_parent' => $cat_parent, 'taxonomy' => 'property-category' );

                                $inserted_post_id = wp_insert_category($wp_rem_cat_args);
                                $cats_array[] = $inserted_post_id;
                                if ( isset($wp_rem_property_taxonomy_icon_array[$cat_key]) ) {
                                    update_term_meta($inserted_post_id, 'wp_rem_property_taxonomy_icon', $wp_rem_property_taxonomy_icon_array[$cat_key]);
                                }
                            }
                        }
                    }
                }
                if ( $cats_array != '' ) {
                    update_post_meta(get_the_id(), 'wp_rem_property_type_categories', $cats_array);
                }
                wp_set_post_terms(get_the_ID(), $cats_array, 'property-category', true);
            }
        }

        /**
         * Settins tab contents.
         */
        public function property_type_settings_tab() {
            global $wp_rem_html_fields, $post;
            $property_type_icon_image = get_post_meta($post->ID, 'wp_rem_property_type_icon_image', true);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_list_type_icon_image'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => $property_type_icon_image,
                    'id' => 'property_type_icon_image',
                    'classes' => 'small dropdown chosen-select',
                    'options' => array( 'icon' => wp_rem_plugin_text_srt('wp_rem_icon'), 'image' => wp_rem_plugin_text_srt('wp_rem_image') ),
                    'return' => true,
                ),
            );
            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

            $icon_display = $image_display = 'none';
            if ( $property_type_icon_image == 'image' ) {
                $image_display = 'block';
            } else {
                $icon_display = 'block';
            }

            echo '<div id="property-type-icon-holder" class="form-elements" style="display:' . $icon_display . '">';
            $type_icon = get_post_meta($post->ID, 'wp_rem_property_type_icon', true);
            $type_icon = ( isset($type_icon[0]) ) ? $type_icon[0] : '';
            ?>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label><?php echo wp_rem_plugin_text_srt('wp_rem_property_icon'); ?></label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <?php echo wp_rem_iconlist_plugin_options($type_icon, 'property_type_icon', 'wp_rem_property_type_icon'); ?>
            </div>
            <?php
            echo '</div>';
            echo '<div id="property-type-image-holder" style="display:' . $image_display . '">';
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_small_image'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'id' => 'property_type_image',
                'field_params' => array(
                    'id' => 'property_type_image',
                    'std' => ( isset($wp_rem_property_type_image) ) ? $wp_rem_property_type_image : '',
                    'return' => true,
                ),
            );
            $wp_rem_html_fields->wp_rem_upload_file_field($wp_rem_opt_array);
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_big_iamge'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'id' => 'property_type_big_image',
                'field_params' => array(
                    'id' => 'property_type_big_image',
                    'std' => ( isset($wp_rem_property_type_big_image) ) ? $wp_rem_property_type_big_image : '',
                    'return' => true,
                ),
            );
            $wp_rem_html_fields->wp_rem_upload_file_field($wp_rem_opt_array);
            echo '</div>';

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_map_marker_image'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'id' => 'property_type_marker_image',
                'field_params' => array(
                    'id' => 'property_type_marker_image',
                    'std' => ( isset($wp_rem_property_type_marker_image) ) ? $wp_rem_property_type_marker_image : '',
                    'return' => true,
                ),
            );
            $wp_rem_html_fields->wp_rem_upload_file_field($wp_rem_opt_array);

            $wp_rem_search_result_page = get_post_meta($post->ID, 'wp_rem_search_result_page', true);
            $field_args = array(
                'depth' => 0,
                'child_of' => 0,
                'class' => 'chosen-select',
                'sort_order' => 'ASC',
                'sort_column' => 'post_title',
                'show_option_none' => wp_rem_plugin_text_srt('wp_rem_select_a_page'),
                'hierarchical' => '1',
                'exclude' => '',
                'include' => '',
                'meta_key' => '',
                'meta_value' => '',
                'authors' => '',
                'exclude_tree' => '',
                'selected' => $wp_rem_search_result_page,
                'echo' => 0,
                'name' => 'wp_rem_search_result_page',
                'post_type' => 'page'
            );
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_search_result_page'),
                'id' => 'wp_rem_search_result_page',
                'desc' => '',
                'echo' => true,
                'hint_text' => '',
                'std' => $wp_rem_search_result_page,
                'args' => $field_args,
                'return' => true,
            );
            $wp_rem_html_fields->wp_rem_custom_select_page_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_opening_hour_time_lapse'),
                'desc' => '',
                'hint_text' => wp_rem_plugin_text_srt('wp_rem_property_type_meta_only_num_allwd'),
                'echo' => true,
                'field_params' => array(
                    'std' => '15',
                    'id' => 'opening_hours_time_gap',
                    'classes' => 'wp-rem-number-field',
                    'return' => true,
                ),
            );

            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
        }

    }

    global $wp_rem_property_type_meta;
    $wp_rem_property_type_meta = new Wp_rem_Property_Type_Meta();
    return $wp_rem_property_type_meta;
}