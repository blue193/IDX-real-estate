<?php
/**
 * Header Functions
 *
 * @package WordPress
 * @subpackage wp_rem_cs
 * @since Wp_rem_cs 1.0
 */
if (!function_exists(' wp_rem_cs_top_strip')) {

    /**
     * Header Top Strip Function
     */
    function wp_rem_cs_top_strip() {
        global $wp_rem_cs_var_options;
        $wp_rem_cs_var_header_top_strip = isset($wp_rem_cs_var_options['wp_rem_cs_var_header_top_strip']) ? $wp_rem_cs_var_options['wp_rem_cs_var_header_top_strip'] : '';
        $wp_rem_cs_var_header_top_address = isset($wp_rem_cs_var_options['wp_rem_cs_var_header_top_strip_address']) ? $wp_rem_cs_var_options['wp_rem_cs_var_header_top_strip_address'] : '';
        $wp_rem_cs_var_header_top_email = isset($wp_rem_cs_var_options['wp_rem_cs_var_header_top_strip_email']) ? $wp_rem_cs_var_options['wp_rem_cs_var_header_top_strip_email'] : '';
        $wp_rem_cs_var_header_top_phone = isset($wp_rem_cs_var_options['wp_rem_cs_var_header_top_strip_phone']) ? $wp_rem_cs_var_options['wp_rem_cs_var_header_top_strip_phone'] : '';
        ?>
        <?php if ('on' === $wp_rem_cs_var_header_top_strip) { ?>
            <div class="top-bar">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <?php if (isset($wp_rem_cs_var_options['wp_rem_cs_var_header_top_strip_contact_us']) && 'on' === $wp_rem_cs_var_options['wp_rem_cs_var_header_top_strip_contact_us']) { ?>
                    <div class="contact-detail">
                        <ul>
                            <?php if($wp_rem_cs_var_header_top_address!=''){ ?>
                            <li><?php echo esc_html( $wp_rem_cs_var_header_top_address ); ?></li>
                            <?php } ?>
                            <?php if($wp_rem_cs_var_header_top_email!=''){ ?>
                            <li><a href="#"><i class="icon-back2"></i><?php echo esc_html( $wp_rem_cs_var_header_top_email ); ?></a></li>
                            <?php } ?>
                            <?php if($wp_rem_cs_var_header_top_phone!=''){ ?>
                            <li><a href="#"><i class="icon-phone"></i><?php echo esc_html( $wp_rem_cs_var_header_top_phone ); ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <?php if (isset($wp_rem_cs_var_options['wp_rem_cs_var_header_top_strip_lang']) && 'on' === $wp_rem_cs_var_options['wp_rem_cs_var_header_top_strip_lang']) { ?>
                    <div class="user-option">
                        <div id="lang_sel">
                            <ul>
                                <li> <a href="#" class="lang_sel_sel icl-en"><i class="icon-earth-globe"></i><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_eng'); ?></a>
                                    <ul>
                                        <li class="icl-zh-hant"> 
                                            <a href="#">
                                                <div class="img-holder"><img src="<?php echo get_template_directory_uri(); ?>/assets/frontend/images/flag-france.png" alt=""></div>
                                                <?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_france'); ?>
                                            </a> 
                                        </li>
                                        <li class="icl-es"> 
                                            <a href="#">
                                                <div class="img-holder"><img src="<?php echo get_template_directory_uri(); ?>/assets/frontend/images/flag-germany.png" alt=""></div>
                                                <?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_germany'); ?>
                                            </a> 
                                        </li>
                                        <li class="icl-ar"> 
                                            <a href="#">
                                                <div class="img-holder"><img src="<?php echo get_template_directory_uri(); ?>/assets/frontend/images/flag-ar.png" alt=""></div>
                                                <?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_italy'); ?>
                                            </a> 
                                        </li>
                                        <li class="icl-ar"> 
                                            <a href="#">
                                                <div class="img-holder"><img src="<?php echo get_template_directory_uri(); ?>/assets/frontend/images/flag-iceland.png" alt=""></div>
                                                <?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_iceland'); ?>
                                            </a> 
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <ul class="user-currency">
                            <li>
                                <a href="#"><i class="icon-coins"></i><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_usd'); ?></a>
                                <ul>
                                    <li><a href="#"><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_uae'); ?></a></li>
                                    <li><a href="#"><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_uae'); ?></a></li>
                                    <li><a href="#"><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_uae'); ?></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                        <?php } ?>
                </div>

            </div>
            
            <?php
        }
    }

}
