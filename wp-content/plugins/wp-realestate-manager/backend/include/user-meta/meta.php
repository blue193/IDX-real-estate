<?php
/**
 * @Add Meta Box For Member Profile
 * @return
 *
 */
add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function extra_user_profile_fields( $user ) {
    global $post, $wp_rem_form_fields, $wp_rem_form_fields, $wp_rem_html_fields, $wp_rem_plugin_options;
    $wp_rem_plugin_options = get_option( 'wp_rem_plugin_options' );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="user_status"><?php echo wp_rem_plugin_text_srt( 'wp_rem_user_meta_profile_approved' ); ?></label></th>
            <td><?php
                $user_status = array();
                $user_status = array(
                    '1' => wp_rem_plugin_text_srt( 'wp_rem_meta_approved' ),
                    '0' => wp_rem_plugin_text_srt( 'wp_rem_meta_pending' ),
                );
                $wp_rem_opt_array = array(
                    'std' => isset( $user->user_status ) ? $user->user_status : '',
                    'id' => '',
                    'cust_id' => 'profile_approved',
                    'cust_name' => 'profile_approved',
                    'classes' => 'chosen-select-no-single small',
                    'options' => $user_status,
                );
                $wp_rem_form_fields->wp_rem_form_select_render( $wp_rem_opt_array );
                ?></td>
        </tr>
        <tr>
            <th><label for="user_status"><?php echo wp_rem_plugin_text_srt( 'wp_rem_meta_user_type' ); ?></label></th>
            <td><?php
                $user_type = array(
                    'supper-admin' => wp_rem_plugin_text_srt( 'wp_rem_meta_supper_admin' ),
                    'team-member' => wp_rem_plugin_text_srt( 'wp_rem_meta_team_member' ),
                );
                $selected_user_type = get_the_author_meta( 'wp_rem_user_type', $user->ID );
                $selected_user_type = ( $selected_user_type == '' ? 'team-member' : $selected_user_type );
                $wp_rem_opt_array = array(
                    'std' => $selected_user_type,
                    'id' => 'user_type',
                    'classes' => 'chosen-select-no-single',
                    'options' => $user_type,
                );
                $wp_rem_form_fields->wp_rem_form_select_render( $wp_rem_opt_array );
                ?></td>
        </tr>
        <tr>
            <th><label for="user_status"><?php echo wp_rem_plugin_text_srt( 'wp_rem_meta_user_company' ); ?></label></th>
            <td><?php
                $user_type = array(
                    'supper-admin' => wp_rem_plugin_text_srt( 'wp_rem_meta_supper_admin' ),
                    'team-member' => wp_rem_plugin_text_srt( 'wp_rem_meta_team_member' ),
                );
                $post_company_args=array('post_type' => 'members', 'posts_per_page' => '-1', 'post_status' => 'publish', 'orderby' => 'title', 'order' => 'ASC' );
                $loop= new wp_query( $post_company_args);
                $options=array();
                while($loop->have_posts()){
                    $loop->the_post();
                   
                    $options[get_the_ID()]=get_the_title();
                }
                wp_reset_postdata();
               
				$selected_user_company = get_user_meta(  $user->ID, 'wp_rem_company',true);
                $wp_rem_opt_array = array(
                    'std' => $selected_user_company,
                    'id' => 'company',
                    'classes' => 'chosen-select-no-single',
                    'options' =>  $options,
                );
                $wp_rem_form_fields->wp_rem_form_select_render( $wp_rem_opt_array );
                ?></td>
        </tr>
    </table> 
    <?php
}

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
    global $wpdb, $buyer_permissions;
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    $member_id     = isset( $_POST['wp_rem_company'] ) ? $_POST['wp_rem_company'] : '';
    $data = array();
    if ( isset( $_POST['profile_approved'] ) ) {
        $wpdb->update(
                $wpdb->prefix . 'users', array( 'user_status' => $_POST['profile_approved'] ), array( 'ID' => esc_sql( $user_id ) )
        );
    }
    if ( isset( $_POST['wp_rem_user_type'] ) ) {
        update_user_meta( $user_id, 'wp_rem_user_type', $_POST['wp_rem_user_type'] );
    }
    if ( isset( $_POST['wp_rem_company'] ) ) {
        update_user_meta( $user_id, 'wp_rem_company', $_POST['wp_rem_company'] );
      
    }
}