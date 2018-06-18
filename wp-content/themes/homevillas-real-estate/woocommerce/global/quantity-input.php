<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
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
?>
<div class="quantity">
    <input type="button" value="-" class="qtyminus" field="quantity" placeholder="">   
    <input type="number" step="<?php echo esc_attr( $step ); ?>" min="<?php echo esc_attr( $min_value ); ?>" max="<?php echo esc_attr( $max_value ); ?>" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $input_value ); ?>" title="<?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_quality_input'); ?>" class="input-text qty text" size="4">
    <input type="button" value="+" class="qtyplus" field="quantity" placeholder="">
    
<!--        <input type='button' value='+' class='qtyplus' field='quantity' placeholder="" />
                                                <input type='button' value='-' class='qtyminus' field='quantity' placeholder="" />-->

</div>