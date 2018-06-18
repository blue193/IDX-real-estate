<?php

add_action('load-edit-comments.php', 'wpwp_rem_load');

function wpwp_rem_load() {
    $screen = get_current_screen();
    add_filter("manage_{$screen->id}_columns", 'wpwp_rem_add_columns');
}

function wpwp_rem_add_columns($cols) {
    $new_cols = array();
    foreach ($cols as $key => $title) {
        if ($key == 'author') {
            $new_cols[$key] = $title;
            $new_cols['member'] = wp_rem_plugin_text_srt( 'wp_rem_comments_member' );
        } else {
            $new_cols[$key] = $title;
        }
    }
    return $new_cols;
}

add_action('manage_comments_custom_column', 'wpwp_rem_column_cb', 10, 2);

function wpwp_rem_column_cb($col, $comment_id) {
    // you could expand the switch to take care of other custom columns
    switch ($col) {
        case 'member':
            $author_email = get_comment_author_email($comment_id);
            if ($author_email) {
                $user = get_user_by('email', $author_email);
                $comment_user_id = $user->ID;
                $member_id = wp_rem_company_id_form_user_id($comment_user_id);
                echo get_the_title($member_id);
            } else {
                echo wp_rem_plugin_text_srt('wp_rem_no_member');
            }
            break;
    }
}
