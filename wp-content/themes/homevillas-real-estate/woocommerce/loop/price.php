<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$var_arrays = array('product');
$page_global_vars = WP_REM_CS_VAR_GLOBALS()->globalizing($var_arrays);
extract($page_global_vars);
?>

<?php if ( $price_html = $product->get_price_html() ) : ?>
	<span class="price"><?php echo force_balance_tags($price_html); ?></span>
<?php endif; ?>
