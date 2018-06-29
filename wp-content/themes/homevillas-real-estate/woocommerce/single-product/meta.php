<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.4
 */
if ( ! defined('ABSPATH') ) {
    exit; // Exit if accessed directly
}

global $post, $product;

$cat_count = sizeof(get_the_terms($post->ID, 'product_cat'));
$tag_count = sizeof(get_the_terms($post->ID, 'product_tag'));
?>
<div class="product_meta">

<?php do_action('woocommerce_product_meta_start'); ?>

    <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type('variable') ) ) : ?>

        <span class="sku_wrapper"><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_meta_sku'); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : wp_rem_cs_var_theme_text_srt('wp_rem_cs_meta_na'); ?></span></span>

<?php endif; ?>
    <?php
    $category_text = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_meta_category');
    if ( $cat_count > 1 ) {
        $category_text = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_meta_categories');
    }
    ?>
    <?php echo wp_rem_cs_allow_special_char($product->get_categories(', ', '<span class="posted_in">' . $category_text . ' ', '</span>')); ?>
    <?php
    $tag_text = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_meta_tag');
    if ( $tag_count > 1 ) {
        $tag_text = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_meta_tags');
    }
    ?>
    <?php echo wp_rem_cs_allow_special_char($product->get_tags(', ', '<span class="posted_in">' . $tag_text . ' ', '</span>')); ?>

    <?php do_action('woocommerce_product_meta_end'); ?>

</div>