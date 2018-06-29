<?php
/*
 *
 * @Shortcode Name : Maintenance
 * @retrun
 *
 */
if ( ! function_exists( 'wp_rem_cs_var_maintenance' ) ) {

    function wp_rem_cs_var_maintenance( $atts, $content = "" ) {
        global $post, $wp_query, $wp_rem_cs_var_options, $wp_rem_cs_var_post_meta;

        update_option( 'wp_rem_cs_underconstruction_redirecting', '0' ); // for undercostruction reset redirect.\

        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_var_column' => '1',
            'wp_rem_cs_var_maintenance_text' => '',
            'wp_rem_cs_var_maintenance_time_left' => '',
            'wp_rem_cs_var_maintainance_logo_array' => '',
            'wp_rem_cs_var_maintainance_image_array' => '',
            'wp_rem_cs_page_view' => '',
            'wp_rem_cs_var_lunch_date' => '',
        );
        extract( shortcode_atts( $defaults, $atts ) );
        $column_class = '';

        if ( isset( $wp_rem_cs_var_column_size ) && $wp_rem_cs_var_column_size != '' ) {
            if ( $wp_rem_cs_var_column_size <> '' ) {
                if ( function_exists( 'wp_rem_cs_var_custom_column_class' ) ) {
                    $column_class = wp_rem_cs_var_custom_column_class( $wp_rem_cs_var_column_size );
                }
            }
        }

        if ( isset( $column_class ) && $column_class <> '' ) {
            echo '<div class="' . esc_html( $column_class ) . '">';
        }
        $wp_rem_cs_page_view = isset( $wp_rem_cs_page_view ) ? $wp_rem_cs_page_view : '2';
        $wp_rem_cs_var_maintainance_image_array = isset( $wp_rem_cs_var_maintainance_image_array ) ? $wp_rem_cs_var_maintainance_image_array : '';
        $wp_rem_cs_var_maintainance_logo_array = isset( $wp_rem_cs_var_maintainance_logo_array ) ? $wp_rem_cs_var_maintainance_logo_array : '';
        $wp_rem_cs_var_maintenance_text = $content;
        $wp_rem_cs_var_lunch_date = isset( $wp_rem_cs_var_lunch_date ) ? $wp_rem_cs_var_lunch_date : '';
        $wp_rem_cs_var_maintenance_switch = isset( $wp_rem_cs_var_options['wp_rem_cs_var_maintenance_switch'] ) ? $wp_rem_cs_var_options['wp_rem_cs_var_maintenance_switch'] : '';
        $wp_rem_cs_var_maintenance_logo = isset( $wp_rem_cs_var_options['wp_rem_cs_var_maintenance_logo_switch'] ) ? $wp_rem_cs_var_options['wp_rem_cs_var_maintenance_logo_switch'] : '';
        $wp_rem_cs_var_maintenance_header_switch = isset( $wp_rem_cs_var_options['wp_rem_cs_var_maintenance_header_switch'] ) ? $wp_rem_cs_var_options['wp_rem_cs_var_maintenance_header_switch'] : '';
        $wp_rem_cs_var_footer_switch = isset( $wp_rem_cs_var_options['wp_rem_cs_var_maintenance_footer_switch'] ) ? $wp_rem_cs_var_options['wp_rem_cs_var_maintenance_footer_switch'] : '';
        $wp_rem_cs_var_maintenance_social_switch = isset( $wp_rem_cs_var_options['wp_rem_cs_var_maintenance_social_switch'] ) ? $wp_rem_cs_var_options['wp_rem_cs_var_maintenance_social_switch'] : '';
        $wp_rem_cs_var_maintenance_newsletter_switch = isset( $wp_rem_cs_var_options['wp_rem_cs_var_maintenance_newsletter_switch'] ) ? $wp_rem_cs_var_options['wp_rem_cs_var_maintenance_newsletter_switch'] : '';
        $wp_rem_cs_var_date = date_i18n( 'Y/m/d', strtotime( $wp_rem_cs_var_lunch_date ) );
        $wp_rem_cs_var_maintenance = '';
        ob_start();
        wp_enqueue_script('countdown');
        ?>
        <script>
            jQuery(document).ready(function ($) {
                var date = '<?php echo $wp_rem_cs_var_date; ?>';
                if (jQuery('#getting-started').length != '') {
                    jQuery('#getting-started').countdown(date, function (event) {
                        jQuery(this).html(event.strftime('<div class="time-box"><h4 class="dd">%D</h4> <span class="label"><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_maintenance_days'); ?></span> </div><div class="time-box"><h4 class="hh">%H</h4><span class="label"><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_maintenance_hours'); ?></span></div><div class="time-box"><h4 class="mm">%M</h4> <span class="label"><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_maintenance_minutes'); ?></span></div><div class="time-box"><h4 class="ss">%S</h4> <span class="label"><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_maintenance_seconds'); ?></span></div> '));
                    });
                }
            });
        </script>
            <div id="cs-construction" class="page-section" style="background:#f8f8f8 url(<?php echo $wp_rem_cs_var_maintainance_image_array; ?>)no-repeat; background-size:cover; height:50%; padding-top:260px;">
                <div class="container">
                    <div class="row">
                        <div class="cs-construction-holder">
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <div class="cs-construction">
                                    <div class="cs-logo">
                                        <?php if ( isset( $wp_rem_cs_var_maintenance_logo ) && $wp_rem_cs_var_maintenance_logo == 'on' ) { ?>
                                            <div class="cs-media">
                                                <figure>
                                                    <img src="<?php echo esc_url( $wp_rem_cs_var_maintainance_logo_array ); ?>" alt="" />
                                                </figure>
                                            </div>
                                        <?php } ?>

                                        <?php if ( $wp_rem_cs_var_maintenance_text <> '' ) { ?>
                                            <span><?php echo htmlspecialchars_decode( $wp_rem_cs_var_maintenance_text ); ?></span>
                                        <?php } ?>
                                    </div>
                                    <div class="cs-const-counter">
                                        <div id="getting-started"></div>
                                    </div>
                                    <div class="cs-seprater"></div>
                                    <?php if ( $wp_rem_cs_var_maintenance_newsletter_switch <> '' && $wp_rem_cs_var_maintenance_newsletter_switch == "on" ) { ?>
                                        <div class="cs-news-letter">
                                            <div class="news-letter-form">
                                                <?php
                                                $under_construction = '2';
                                                wp_rem_cs_custom_mailchimp( $under_construction );
                                                ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if ( isset( $wp_rem_cs_var_maintenance_social_switch ) && $wp_rem_cs_var_maintenance_social_switch == 'on' ) { ?>
                                        <div class="cs-social-media">
                                            <?php echo wp_rem_cs_social_network(1, '', '', 'social-media', false); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       
        <?php
        if ( isset( $column_class ) && $column_class <> '' ) {
            echo '</div>';
        }
        ?>
        <?php
        $wp_rem_cs_var_maintenance = ob_get_clean();
        return $wp_rem_cs_var_maintenance;
    }

    if ( function_exists( 'wp_rem_cs_var_short_code' ) )
        wp_rem_cs_var_short_code( 'maintenance', 'wp_rem_cs_var_maintenance' );
}