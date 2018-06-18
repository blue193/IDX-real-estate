<?php
/**
 * The template for displaying product content within loops.
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 */
if ( ! defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly


$var_arrays = array( 'product', 'woocommerce_loop' );
$page_global_vars = WP_REM_CS_VAR_GLOBALS()->globalizing( $var_arrays );
extract( $page_global_vars );

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
    $woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
    $woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
    return;

// Increase loop count
$woocommerce_loop['loop'] ++;

// Extra post classes
$classes = array( 'col-sm-6 col-md-4 col-lg-4' );
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
    $classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
    $classes[] = 'last';

$wp_rem_cs_prod_attach_id = get_post_thumbnail_id( get_the_id() );
$wp_rem_cs_prod_attach_src = wp_rem_cs_attachment_image_src( $wp_rem_cs_prod_attach_id, 350, 350 );
?>

<li class="product">
    <a href="<?php esc_url( the_permalink() ) ?>">
        <?php
        if ( $wp_rem_cs_prod_attach_src != '' ) {
            ?>
            <img src="<?php echo esc_url( $wp_rem_cs_prod_attach_src ) ?>" alt="<?php esc_html( the_title() ) ?>">
            <?php
            woocommerce_template_loop_rating();
        } else {
            echo wc_placeholder_img();
            woocommerce_template_loop_rating();
        }
        ?>
        <h4><?php the_title() ?></h4>                                          
    </a>
    <?php echo woocommerce_template_loop_price() ?>
    <?php wp_rem_cs_loop_add_to_cart(); ?>

</li>
