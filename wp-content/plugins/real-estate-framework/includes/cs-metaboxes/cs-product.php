<?php
/**
 * @ Start function for Add Meta Box For Product  
 * @return
 *
 */
add_action('add_meta_boxes', 'wp_rem_cs_meta_product_add');
if (!function_exists('wp_rem_cs_meta_product_add')) {

    function wp_rem_cs_meta_product_add() {
        global $wp_rem_cs_var_frame_static_text;
        
        add_meta_box('wp_rem_cs_meta_product', wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_product_options'), 'wp_rem_cs_meta_product', 'product', 'normal', 'high');
    }

}

/**
 * @ Start function for Meta Box For Product  
 * @return
 *
 */
if (!function_exists('wp_rem_cs_meta_product')) {

    function wp_rem_cs_meta_product($post) {
        global $wp_rem_cs_var_frame_static_text;
       
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
                                <?php
                                wp_rem_cs_sidebar_layout_options();
                                ?>
                            </div>
                            <div id="tab-slideshow">
                                <?php wp_rem_cs_subheader_element(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <?php
    }
}