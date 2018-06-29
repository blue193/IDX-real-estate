<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wp_rem_cs
 */
?>
<?php
if (!isset($_GET['s'])):
    $_GET['s'] = '';
endif;
?>
<?php $searchg_string = $_GET['s']; ?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<section class="no-results not-found">
    <div class="page-content">
        <?php if (is_home() && current_user_can('publish_posts')) : ?>
            <p><?php printf(wp_kses( wp_rem_cs_var_theme_text_srt('wp_rem_cs_content_none_ready_for_post').' <a href="%1$s">'.wp_rem_cs_var_theme_text_srt('wp_rem_cs_content_none_get_started_here').'</a>', array('a' => array('href' => array()))), esc_url(admin_url('post-new.php'))); ?></p>
        <?php elseif (is_search()) : ?>
             <div class="search-results">
                <div class="suggestions">
                    <h4 class="cs-color"><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_suggestioins')); ?>:</h4>
                    <ul>
                        <li><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_content_none_line1'); ?></li>
                        <li><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_content_none_line2'); ?></li>
                        <li><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_content_none_line3'); ?></li>
                    </ul>
                </div>									
            </div>
            
            <?php
            get_search_form();
        else :
            ?>
            <p><?php echo  wp_rem_cs_var_theme_text_srt('wp_rem_cs_content_seems_search_help'); ?></p>
            <?php
            get_search_form();
        endif;
        ?>
    </div><!-- .page-content -->
</section><!-- .no-results -->
</div>