<?php ob_start("ob_gzhandler");?>
<?php 
global $post;

require_once __DIR__ . '/custom/header-data.php';
//
//
//$contents = ob_get_contents();
//ob_end_clean();
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_rem_cs
 */
do_action( 'wp_rem_cs_before_header' );

$metakeywords = cetGetProductMetaKeywords(@$post->ID, @$post->post_title);
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <?php
    global $wp_rem_cs_var_options;
    $wp_rem_cs_var_layout = isset( $wp_rem_cs_var_options['wp_rem_cs_var_layout'] ) ? $wp_rem_cs_var_options['wp_rem_cs_var_layout'] : '';
    ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if ($metakeywords) { ?>
    <meta name="keywords" itemprop="keywords" content="<?= $metakeywords ?>" />
    <?php } ?>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php

    $bg_color = get_post_meta( get_the_id(), 'wp_rem_cs_var_page_bg_color', true );
    $style_bgcol = '';
    if ( isset( $bg_color ) && $bg_color != '' && ! is_array( $bg_color ) ) {
        $style_bgcol = 'style="background-color:' . $bg_color . '"';
    }
    wp_head();
    ?>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-102190640-1', 'auto');
      ga('send', 'pageview');

    </script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-MP6R2LK');</script>
    <!-- End Google Tag Manager -->
</head>
<body <?php body_class(); ?>>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MP6R2LK"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="wrapper wrapper-<?php echo esc_html( $wp_rem_cs_var_layout ); ?>" <?php echo esc_html($style_bgcol); ?>>
        <!-- Side Menu Start -->
        <div id="overlay"></div>
        <?php
        $wp_rem_cs_var_maintenance_page = isset( $wp_rem_cs_var_options['wp_rem_cs_var_maintinance_mode_page'] ) ? $wp_rem_cs_var_options['wp_rem_cs_var_maintinance_mode_page'] : '';
        $wp_rem_cs_var_maintenance_check = isset( $wp_rem_cs_var_options['wp_rem_cs_var_maintenance_switch'] ) ? $wp_rem_cs_var_options['wp_rem_cs_var_maintenance_switch'] : '';
        $wp_rem_cs_var_maintenance_header_switch = isset( $wp_rem_cs_var_options['wp_rem_cs_var_maintenance_header_switch'] ) ? $wp_rem_cs_var_options['wp_rem_cs_var_maintenance_header_switch'] : 'off';
        if ( get_the_ID() == $wp_rem_cs_var_maintenance_page && $wp_rem_cs_var_maintenance_check == 'on' && $wp_rem_cs_var_maintenance_header_switch <> 'on' ) {
            echo '<header id="header"></header>';
        } elseif ( '' != get_the_ID() && get_the_ID() == $wp_rem_cs_var_maintenance_page && $wp_rem_cs_var_maintenance_check <> 'on' && $wp_rem_cs_var_maintenance_header_switch <> 'on' ) {
            echo '<header id="header"></header>';
        } else {
            wp_rem_cs_main_header();
            if ( function_exists( 'wp_rem_cs_var_subheader_style' ) ) {
                wp_rem_cs_var_subheader_style();
            }
        }
		