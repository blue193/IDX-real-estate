<?php
/*
 * Class start for location check search 
 */
class RadiusCheck {

    var $maxLat;
    var $minLat;
    var $maxLong;
    var $minLong;

    // Start function for radius search 
    function __construct($Latitude, $Longitude, $Miles) {
        global $maxLat, $minLat, $maxLong, $minLong;
        $EQUATOR_LAT_MILE = 69.172; // in MIles
        $maxLat = $Latitude + $Miles / $EQUATOR_LAT_MILE;
        $minLat = $Latitude - ($maxLat - $Latitude);
        $maxLong = $Longitude + $Miles / (cos($minLat * M_PI / 180) * $EQUATOR_LAT_MILE);
        $minLong = $Longitude - ($maxLong - $Longitude);
    }
    // Start function for get max latitude 
    function MaxLatitude() {
        return $GLOBALS["maxLat"];
    }

   // Start function for get Min latitude 
    function MinLatitude() {
        return $GLOBALS["minLat"];
    }
    
  // Start function for get Max Longitude
    
    function MaxLongitude() {
        return $GLOBALS["maxLong"];
    }
  // Start function for get Min Longitude
    function MinLongitude() {
        return $GLOBALS["minLong"];
    }

}

// Start Class for Distance Check
class DistanceCheck {

    function __construct() {
        
    }
// Start function for calculate distance 
    function Calculate($dblLat1, $dblLong1, $dblLat2, $dblLong2) {
        $EARTH_RADIUS_MILES = 3963;
        $dist = 0;
        //convert degrees to radians
        $dblLat1 = $dblLat1 * M_PI / 180;
        $dblLong1 = $dblLong1 * M_PI / 180;
        $dblLat2 = $dblLat2 * M_PI / 180;
        $dblLong2 = $dblLong2 * M_PI / 180;
        if ($dblLat1 != $dblLat2 || $dblLong1 != $dblLong2) {
            //the two points are not the same
            $dist = sin($dblLat1) * sin($dblLat2) + cos($dblLat1) * cos($dblLat2) * cos($dblLong2 - $dblLong1);
            $dist = $EARTH_RADIUS_MILES * (-1 * atan($dist / sqrt(1 - $dist * $dist)) + M_PI / 2);
        }
        return $dist;
    }

}
