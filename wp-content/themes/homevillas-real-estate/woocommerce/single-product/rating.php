<?php
/**
 * Single Product Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/rating.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.6.4
 */
if ( ! defined('ABSPATH') ) {
    exit; // Exit if accessed directly
}

global $product;

if ( get_option('woocommerce_enable_review_rating') === 'no' ) {
    return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average = $product->get_average_rating();

if ( $rating_count > 0 ) :
    ?>

    <div class="woocommerce-product-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
        <div class="star-rating" title="<?php printf(wp_rem_cs_var_theme_text_srt('wp_rem_cs_rating_rating_outoff'), $average); ?>">
            <span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
                <strong itemprop="ratingValue" class="rating"><?php echo ($average); ?></strong> <?php printf(wp_rem_cs_var_theme_text_srt('wp_rem_wooc_out_of_rating'), '<span itemprop="bestRating">', '</span>'); ?>

                <?php
                $rating_text = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_rating_rating');
                if ( $rating_count > 1 ) {
                    $rating_text = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_rating_ratings');
                }
                ?>
    <?php printf($rating_text, '<span itemprop="ratingCount" class="rating">' . $rating_count . '</span>'); ?>
            </span>
        </div>
    <?php if ( comments_open() ) : ?><a href="#reviews" class="woocommerce-review-link" rel="nofollow"><?php printf('%s', '<em itemprop="reviewCount" class="count"> ' . $average . ' / ' . $review_count . ' ' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_rating_reviews') . '</em>'); ?></a><?php endif ?>
    </div>

    <?php
 endif;