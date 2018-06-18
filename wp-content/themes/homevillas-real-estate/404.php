<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package wp_rem_cs
 */
get_header();
$var_arrays = array( 'wp_rem_cs_var_static_text', 'wp_rem_cs_var_form_fields', 'wp_rem_cs_var_html_fields' );
$error_page_global_vars = WP_REM_CS_VAR_GLOBALS()->globalizing($var_arrays);
extract($error_page_global_vars);
$wp_rem_cs_var_options = WP_REM_CS_VAR_GLOBALS()->theme_options();
$wp_rem_cs_var_page_margin = isset($wp_rem_cs_var_options['wp_rem_cs_var_page_margin']) ? $wp_rem_cs_var_options['wp_rem_cs_var_page_margin'] : '';
$page_margin_class = '';
if ( $wp_rem_cs_var_page_margin == 'on' ) {
    $page_margin_class = 'page-margin';
}
?>

<div class="main-section <?php echo esc_attr($page_margin_class); ?>">
    <div class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="page-not-found">
                        <div class="cs-text"> <span class="cs-error"><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_404_title')); ?></span> <span><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_404_sub_title')); ?></span>
                            <p><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_404_desc')); ?></p>
                        </div>
                        <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
                            <div class="input-holder"><i class="icon-search2"></i>
                                <?php
                                $wp_rem_cs_opt_array = array(
                                    'std' => '',
                                    'id' => '',
                                    'classes' => 'form-control txt-bar',
                                    'extra_atr' => 'onfocus="if (this.value == \'' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_search_by_keyword') . '\') {
                                            this.value = \'\';
                                        }" 
                                       onblur="if (this.value == \'\') {
                                                   this.value = \'' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_search_by_keyword') . '\';
                                               }" 
                                    placeholder="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_search_by_keyword') . '"',
                                    'cust_id' => 's',
                                    'cust_name' => 's',
                                    'return' => true,
                                    'required' => false
                                );
                                echo wp_rem_cs_allow_special_char($wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array));
                                $wp_rem_cs_opt_array = array(
                                    'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_search_button'),
                                    'id' => '',
                                    'before' => '',
                                    'after' => '',
                                    'classes' => 'bgcolor',
                                    'extra_atr' => '',
                                    'cust_id' => '',
                                    'cust_name' => '',
                                    'return' => true,
                                    'required' => false
                                );
                                echo wp_rem_cs_allow_special_char($wp_rem_cs_var_form_fields->wp_rem_cs_var_form_submit_render($wp_rem_cs_opt_array));
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
