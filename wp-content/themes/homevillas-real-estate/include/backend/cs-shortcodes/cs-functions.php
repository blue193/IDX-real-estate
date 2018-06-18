<?php

//=====================================================================
//Bootstrap Coloumn Class
//=====================================================================
if ( ! function_exists( 'wp_rem_cs_var_custom_column_class' ) ) {

    function wp_rem_cs_var_custom_column_class( $column_size ) {
        $coloumn_class = '';
        if ( isset( $column_size ) && $column_size <> '' ) {
            list($top, $bottom) = explode( '/', $column_size );
            $width = $top / $bottom * 100;
            $width = (int) $width;
            $coloumn_class = '';
            if ( round( $width ) == '25' || round( $width ) < 25 ) {
                $coloumn_class = 'col-md-3';
            } elseif ( round( $width ) == '33' || (round( $width ) < 33 && round( $width ) > 25) ) {
                $coloumn_class = 'col-md-4';
            } elseif ( round( $width ) == '50' || (round( $width ) < 50 && round( $width ) > 33) ) {
                $coloumn_class = 'col-md-6';
            } elseif ( round( $width ) == '67' || (round( $width ) < 67 && round( $width ) > 50) ) {
                $coloumn_class = 'col-md-8';
            } elseif ( round( $width ) == '75' || (round( $width ) < 75 && round( $width ) > 67) ) {
                $coloumn_class = 'col-md-9';
            } elseif ( round( $width ) == '100' ) {
                $coloumn_class = 'col-md-12';
            } else {
                $coloumn_class = '';
            }
        }
        return sanitize_html_class( $coloumn_class );
    }

}