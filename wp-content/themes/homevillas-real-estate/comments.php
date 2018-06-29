<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage wp_rem_cs
 * @since Auto Mobile 1.0
  /*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
$var_arrays = array( 'post_id', 'wp_rem_cs_var_static_text' );
$comment_global_vars = wp_rem_cs_VAR_GLOBALS()->globalizing( $var_arrays );
extract( $comment_global_vars );
?>

<?php
if ( have_comments() ) :
	if ( function_exists( 'the_comments_navigation' ) ) {
		the_comments_navigation();
	}
	?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="comments" id="comments">
			<div class="element-title">
				<h4>
					<?php
					$comments_number = get_comments_number();
					if ( 1 === $comments_number ) {
						/* translators: %s: post title */
						printf(  wp_rem_cs_var_theme_text_srt('wp_rem_cs_comment_one_thought') , get_the_title() );
					} else {
                                            	printf(
								// translators: 1: number of comments, 2: post title.
								esc_html( _nx(
												'%1$s comments', '%1$s comments', $comments_number, 'comments title', 'homevillas-real-estate') ), esc_html( number_format_i18n( $comments_number ) ), get_the_title()
						);
					}
					?>
				</h4>
			</div>
			<ul>
				<?php
				wp_list_comments( array( 'callback' => 'wp_rem_cs_var_comment' ) );
				?>
			</ul>	
		</div><!-- .comment-list -->

		<?php
		if ( function_exists( 'the_comments_navigation' ) ) {
			the_comments_navigation();
		}
		?>
	</div>
	<?php
endif; // Check for have_comments().  
// If comments are closed and there are comments, let's leave a little note, shall we?
if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
	<p class="no-comments"><?php echo esc_html( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_comments_closed' ) ); ?></p>
<?php endif; ?>


<div class="comment-form">

	<?php
	$wp_rem_cs_msg_class = '';

	$you_may_use = wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_you_may' );
	$must_login = '<a href="%s">' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_logged_in' ) . '</a>' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_you_must' );
	$logged_in_as = wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_log_in' ) . ' <a href="%1$s">%2$s</a>.<a href="%3$s" title="' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_log_out_title' ) . '">' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_log_out' ) . '</a>';
	$required_fields_mark = ' ' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_require_fields' );
	$required_text = sprintf( $required_fields_mark, '<span class="required">*</span>' );
	$defaults = array(
		'fields' => apply_filters( 'comment_form_default_fields', array(
			'author' => '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <div class="field-holder">
		<strong>' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_name' ) . '</strong>			
               
                <label><input id="author"  name="author" class="nameinput" type="text" placeholder="' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_name_place' ) . ' " value=""' .
			esc_attr( $commenter['comment_author'] ) . ' tabindex="1" required /> </label></div></div>',
			'email' => '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"><div class="field-holder">' .
			'<strong>' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_text_email' ) . '</strong>
                <label><input id="email" name="email" class="emailinput" type="text" placeholder="' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_email_placeholder' ) . ' "  value=""' .
			esc_attr( $commenter['comment_author_email'] ) . ' size="30" tabindex="2" required></label>' .
			'</div></div>',
			'url' => '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"><div class="field-holder">' .
			'<strong>' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_website' ) . '</strong>
                    <label><input id="url" name="url" type="text" class="websiteinput" placeholder="' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_website_placeholder' ) . '" value="" size="30" tabindex="3"></label>' .
			'</div></div>',
		) ),
		'comment_field' => '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="field-holder">
                <label><textarea id="comment_mes" name="comment"  placeholder="' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_comment_text_here' ) . '"></textarea></label>' .
		'</div></div>',
		'must_log_in' => '<span>' . sprintf( $must_login, wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</span>',
		'logged_in_as' => '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><span>' . sprintf( $logged_in_as, admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</span></div>',
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'class_form' => 'comment-form contact-form row',
		'id_form' => 'form-style',
		'class_submit' => 'cs-button cs-bgcolor',
		'id_submit' => 'cs-bg-color',
		'title_reply' => '<span class="element-title">' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_post_comment' ) . '</span>',
		'title_reply_to' => '<h2 class="element-title">' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_leave_comment' ) . '</h2>',
		'cancel_reply_link' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_cancel_reply' ),
		'label_submit' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_leave_comment' ),
	);
	comment_form( $defaults, $post_id );
	?>
</div>