<?php
/**
 * @Add Page Meta Boxe
 * @return
 */
add_action('add_meta_boxes', 'wp_rem_cs_page_options_add');

if (!function_exists('wp_rem_cs_page_options_add')) {

    function wp_rem_cs_page_options_add() {
        global $wp_rem_cs_var_frame_static_text;
        add_meta_box('id_page_options', wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_page_option'), 'wp_rem_cs_page_options', 'page', 'normal', 'low');
    }

}

/**
 * @Getting Page Options Layout
 *
 */
if (!function_exists('wp_rem_cs_page_options')) {

    function wp_rem_cs_page_options($post) {
        global $post, $wp_rem_cs_var_frame_static_text;
        ?>

        <div class="page-wrap page-opts left" style="overflow:hidden; position:relative;">
            <div class="option-sec" style="margin-bottom:0;">
                <div class="opt-conts">
                    <div class="elementhidden">
                        <nav class="admin-navigtion">
                            <ul id="cs-options-tab">
                                <li><a name="#tab-general-settings" href="javascript:;"><i class="icon-cog3"></i><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_general_setting'); ?> </a></li>
                                <li><a name="#tab-slideshow" href="javascript:;"><i class="icon-forward2"></i> <?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_subheader'); ?></a></li>
                            </ul> 
                        </nav>
                        <div id="tabbed-content">
                            <div id="tab-general-settings">
                               
                                <?php wp_rem_cs_sidebar_layout_options(); ?>
                            </div>
                            <div id="tab-slideshow">
                                <?php wp_rem_cs_subheader_element(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}