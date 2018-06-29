<?php
/**
 * Template Name: package Detail
 *
 */
get_header();

$action = wp_rem_get_input( 'action', '' ); 
?>
<div id="main">
    <div class="container">
        <?php
        if ( $action == 'property-package' ) {
            $trans_id = wp_rem_get_input( 'trans_id', 0 );
            $trans_fields = array(
                'trans_id' => $trans_id,
                'order_type' => $action,
            );
            do_action( 'wp_rem_payment_gateways', $trans_fields );
        }

        if ( $action == 'reservation-order' ) {
            $trans_id = wp_rem_get_input( 'trans_id', 0 );
            $trans_fields = array(
                'trans_id' => $trans_id,
                'order_type' => $action,
            );
            do_action( 'wp_rem_payment_gateways', $trans_fields );
        }
        ?>
    </div>
</div>
<?php
get_footer();
