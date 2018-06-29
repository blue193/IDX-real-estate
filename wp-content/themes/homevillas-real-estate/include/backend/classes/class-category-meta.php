<?php

/**
 * Wp_rem_cs_Category_Meta Class
 *
 * @package Wp_rem_cs
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
  Wp_rem_cs_Category_Meta class used to implement the category meta fields.
 */
class Wp_rem_cs_Category_Meta {

    /**
     * Set up wp_rem_cs category meta fields.
     */
    public function __construct() {
        // add extra fields to category add/edit form callback function.
        add_action( 'category_add_form_fields', array( $this, 'add_category_meta_fields' ) );
        add_action( 'category_edit_form_fields', array( $this, 'edit_category_meta_fields' ), 10, 2 );
        // save extra category extra fields hook.
        add_action( 'edited_category', array( $this, 'save_extra_category_fileds' ), 10, 2 );
    }

    /**
     * Adding category meta fields.
     */
    public function add_category_meta_fields() {
        global $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;
    }

    /**
     * Updating category meta fields.
     *
     * @param array  $cat_data category data.
     * @param string $cat_slug category.
     */
    public function edit_category_meta_fields( $cat_data = '', $cat_slug ) {
        global $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;
        $cat_meta = array();
        if ( $cat_data ) {
            $cat_id = $cat_data->term_id;
            $cat_meta = get_term_meta( $cat_id, 'cat_meta_data', true );
        }

    }

    /**
     * Saving category meta fields.
     *
     * @param int    $cat_id category id.
     * @param string $cat_slug category slug.
     */
    public function save_extra_category_fileds( $cat_id, $cat_slug ) {
        $post_data = wp_rem_cs_get_input( 'cat_meta', false, false );
        if ( isset( $post_data ) ) {
            $cat_meta = get_term_meta( $cat_slug . '_' . $cat_id );
            $cat_keys = array_keys( $post_data );
            foreach ( $cat_keys as $key ) {
                if ( isset( $post_data[$key] ) ) {
                    $cat_meta[$key] = $post_data[$key][0];
                }
            }
            update_term_meta( $cat_id, 'cat_meta_data', $cat_meta );
        }
    }

}

new Wp_rem_cs_Category_Meta();