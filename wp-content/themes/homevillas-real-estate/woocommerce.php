<?php
/**
 * The template for displaying 
 * WooCommerace Products
 */
get_header();
$var_arrays = array('post','mashup_shop_id');
$woocommerece_global_vars = WP_REM_CS_VAR_GLOBALS()->globalizing($var_arrays);
extract($woocommerece_global_vars);
$mashup_shop_id = woocommerce_get_page_id('shop');

if (is_shop()) {
    get_template_part('woocommerce/woocommerce-shop', 'page');
} else if (is_single()) {
    get_template_part('woocommerce/woocommerce-single-product', 'page');
} else if (is_product_category() or is_product_tag()) {

    // Shop Taxonomies pages
    get_template_part('woocommerce/woocommerce-archive', 'page');
} else {
    // Shop Other Pages
    ?>
    <div class="cs-shop-wrap row">
        <?php 
        if (function_exists('woocommerce_content')) {
            woocommerce_content();
        } 
        ?>
    </div>
    <?php
}
get_footer();