<?php

/**
 * Shop Products Lisitng
 * 
 */
if (is_shop()) {

    $wp_rem_cs_shop_id = woocommerce_get_page_id('shop');

    if (have_posts()) :
        
        echo "<div class='site-main'>
			<div class='columns-3'>
				<div class='products-holder'>"
        . do_action('woocommerce_before_shop_loop')
        . "<ul class='products'>";
        while (have_posts()) : the_post();

            get_template_part('woocommerce/content', 'product');

        endwhile; // end of the loop. 

        echo "</ul>
		<div class='row'>
		<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>";

        woocommerce_get_template('loop/pagination.php');

        echo "</div>
		</div>
		</div></div></div>";

    endif;
}