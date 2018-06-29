<?php
/*
 * property taxonomy mata
 */
if (!class_exists('Property_taxonomy_Meta')) {

    Class Property_taxonomy_Meta {

        public function __construct() {
            add_action('property-category_add_form_fields', array($this, 'icon_taxonomy_add_new_meta_field'), 10, 2);
            add_action('property-category_edit_form_fields', array($this, 'icon_taxonomy_edit_meta_field'), 10, 2);
            add_action('edited_property-category', array($this, 'save_taxonomy_custom_meta'), 10, 2);
            add_action('create_property-category', array($this, 'save_taxonomy_custom_meta'), 10, 2);
        }

        function icon_taxonomy_add_new_meta_field($term) {
            // this will add the custom meta field to the add new term page



            $type_icon = ( isset($type_icon[0]) ) ? $type_icon[0] : '';
            ?>
            <div class="form-field term-slug-wrap">
                <div class="form-elements">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label><?php echo wp_rem_plugin_text_srt('wp_rem_icon'); ?></label>
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <?php echo apply_filters( 'cs_icons_fields', '', 'property_type_icon', 'wp_rem_property_taxonomy_icon' ); ?>
                    </div>
                </div>
            </div>
            <?php
        }

        public function icon_taxonomy_edit_meta_field($term) {
            $t_id = $term->term_id;

            // retrieve the existing value(s) for this meta field. This returns an array
            $term_meta = get_term_meta($t_id, 'wp_rem_property_taxonomy_icon', true);
            $icon_group = get_term_meta($t_id, 'wp_rem_property_taxonomy_icon_group', true);
            $icon_group = ( isset( $icon_group ) && $icon_group != '' )? $icon_group : 'default';
            ?>


            <div class="form-field term-slug-wrap">
                <div class="form-elements">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label><?php echo wp_rem_plugin_text_srt('wp_rem_icon'); ?></label>
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <?php echo apply_filters( 'cs_icons_fields', $term_meta, 'property_type_icon', 'wp_rem_property_taxonomy_icon', $icon_group ); ?>
                    </div>
                </div>
            </div>
            <?php
        }

        public function save_taxonomy_custom_meta($term_id) {
            if (isset($_POST['wp_rem_property_taxonomy_icon'])) {

                $icon = $_POST['wp_rem_property_taxonomy_icon'][0];
                $icon_group = $_POST['wp_rem_property_taxonomy_icon_group'][0];

                $t_id = $term_id;

                // Save the option array.
                update_term_meta($t_id, 'wp_rem_property_taxonomy_icon', $icon);
                update_term_meta($t_id, 'wp_rem_property_taxonomy_icon_group', $icon_group);
            }
        }

    }

    $Property_taxonomy_Meta = new Property_taxonomy_Meta();
}