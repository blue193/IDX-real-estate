/**
 *
 * A JQUERY GOOGLE MAPS LATITUDE AND LONGITUDE LOCATION PICKER
 * version 1.2
 *
 * Supports multiple maps. Works on touchscreen. Easy to customize markup and CSS.
 *
 * To see a live demo, go to:
 * http://www.wimagguc.com/projects/jquery-latitude-longitude-picker-gmaps/
 *
 * by Richard Dancsi
 * http://www.wimagguc.com/
 *
 */



(function ($) {
// for ie9 doesn't support debug console >>>
    if (!window.console)
        window.console = {};
    if (!window.console.log)
        window.console.log = function () { };
// ^^^

    jQuery.fn.gBranchesMapsLatLonPicker = (function (readius) {

        var _self = this;
        var show_marker = 'yes';
        if (readius != 'undefined' && readius != undefined && readius != '') {
            var show_marker = 'no';

        }

        var readius = parseInt(readius);


        ///////////////////////////////////////////////////////////////////////////////////////////////
        // PARAMETERS (MODIFY THIS PART) //////////////////////////////////////////////////////////////
        _self.params = {
            defLat: 0,
            defLng: 0,
            defZoom: 1,
            queryLocationNameWhenLatLngChanges: true,
            queryElevationWhenLatLngChanges: true,
            mapOptions: {
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: false,
                disableDoubleClickZoom: true,
                zoomControlOptions: true,
                streetViewControl: false
            },
            strings: {
                markerText: "Drag this Marker",
                error_empty_field: "Couldn't find coordinates for this place",
                error_no_results: "Couldn't find coordinates for this place"
            },
            displayError: function (message) {
                alert(message);
                wp_rem_hide_button_loader(_self.vars.cssID + '.search-location-map');
            }
        };


        ///////////////////////////////////////////////////////////////////////////////////////////////
        // VARIABLES USED BY THE FUNCTION (DON'T MODIFY THIS PART) ////////////////////////////////////
        _self.vars = {
            ID: null,
            LATLNG: null,
            map: null,
            marker: null,
            geocoder: null
        };



        ///////////////////////////////////////////////////////////////////////////////////////////////
        // PRIVATE FUNCTIONS FOR MANIPULATING DATA ////////////////////////////////////////////////////
        var setPosition = function (position) {

            _self.vars.marker.setPosition(position);
            _self.vars.map.panTo(position);

            if (jQuery('#wp_rem__loc_bounds_rest').length !== 0 && jQuery('#wp_rem__loc_bounds_rest').val() != '') {
                var polygonCoords = jQuery('#wp_rem__loc_bounds_rest').val();
                if (typeof polygonCoords !== 'undefined' && polygonCoords != '') {
                    var polygonCoordsJson = jQuery.parseJSON(polygonCoords);
                    var polygon_area = new google.maps.Polygon({paths: polygonCoordsJson});
                    var db_lat = parseFloat(position.lat());
                    var db_long = parseFloat(position.lng());
                    var pResultCord = google.maps.geometry.poly.containsLocation(new google.maps.LatLng(db_lat, db_long), polygon_area) ? 'true' : 'false';

                    if (pResultCord == 'false') {
                        alert('Warning! This address is out of the selected location boundries.');
                        wp_rem_hide_button_loader(_self.vars.cssID + '.search-location-map');
                        return false;
                    }
                }
            }

            jQuery(_self.vars.cssID + ".gllpZoom").val(_self.vars.map.getZoom());
            jQuery(_self.vars.cssID + ".gllpLongitude").val(position.lng());
            jQuery(_self.vars.cssID + ".gllpLatitude").val(position.lat());

            jQuery(_self.vars.cssID).trigger("location_changed", jQuery(_self.vars.cssID));

            if (_self.params.queryLocationNameWhenLatLngChanges) {
                getLocationName(position);
            }
            if (_self.params.queryElevationWhenLatLngChanges) {
                getElevation(position);
            }
        };
        var setPosition_lat_lang = function (lat, lang) {
            _self.vars.marker.setPosition(lat, lang);
            _self.vars.map.panTo(lat, lang);

            jQuery(_self.vars.cssID + ".gllpZoom").val(_self.vars.map.getZoom());
            jQuery(_self.vars.cssID + ".gllpLongitude").val(lang);
            jQuery(_self.vars.cssID + ".gllpLatitude").val(lat);

            jQuery(_self.vars.cssID).trigger("location_changed", jQuery(_self.vars.cssID));
        };

        // for reverse geocoding
        var getLocationName = function (position) {
            var latlng = new google.maps.LatLng(position.lat(), position.lng());
            _self.vars.geocoder.geocode({'latLng': latlng}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK && results[1]) {
                    jQuery(_self.vars.cssID + ".gllpLocationName").val(results[1].formatted_address);
                } else {
                    jQuery(_self.vars.cssID + ".gllpLocationName").val("");
                }
                jQuery(_self.vars.cssID).trigger("location_name_changed", jQuery(_self.vars.cssID));
            });
        };

        // for getting the elevation value for a position
        var getElevation = function (position) {
            var latlng = new google.maps.LatLng(position.lat(), position.lng());

            var locations = [latlng];

            var positionalRequest = {'locations': locations};

            _self.vars.elevator.getElevationForLocations(positionalRequest, function (results, status) {
                if (status == google.maps.ElevationStatus.OK) {
                    if (results[0]) {
                        jQuery(_self.vars.cssID + ".gllpElevation").val(results[0].elevation.toFixed(3));
                    } else {
                        jQuery(_self.vars.cssID + ".gllpElevation").val("");
                    }
                } else {
                    jQuery(_self.vars.cssID + ".gllpElevation").val("");
                }
                jQuery(_self.vars.cssID).trigger("elevation_changed", jQuery(_self.vars.cssID));
            });
        };

        // search function
        var performSearch = function (string, silent) {
            if (string == "") {
                var postiting_lat = jQuery(_self.vars.cssID + '#wp_rem_post_loc_latitude').val();
                var postiting_lon = jQuery(_self.vars.cssID + '#wp_rem_post_loc_longitude').val();
                if (postiting_lat != '' && postiting_lon != '') {
                    reload_map_with_new_location(postiting_lat, postiting_lon);
                    return;
                } else {
                    if (!silent) {
                        _self.params.displayError(_self.params.strings.error_empty_field);
                    }
                    return;
                }
            }
            _self.vars.geocoder.geocode(
                    {"address": string},
                    function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            reload_map_with_new_location(results[0].geometry.location.lat(), results[0].geometry.location.lng());
                            wp_rem_hide_button_loader(_self.vars.cssID + '.search-location-map');
                        } else {
                            if (!silent) {
                                _self.params.displayError(_self.params.strings.error_no_results);
                            }
                        }
                    }
            );
        };


        function reload_map_with_new_location(lat, lng) {
            var thisLatLng = new google.maps.LatLng(lat, lng);
            var _this_map = new google.maps.Map($(_self.vars.cssID + '#cs-map-location-fe-id').get(0), {
                center: thisLatLng,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: false,
                disableDoubleClickZoom: true,
                zoomControlOptions: true,
                streetViewControl: false,
                zoom: 9,
            });
            var marker = new google.maps.Marker({
                position: thisLatLng,
                center: thisLatLng,
                map: _this_map,
                draggable: true,
            });
            var newLat = marker.getPosition().lat();
            var newLng = marker.getPosition().lng();
            jQuery(_self.vars.cssID + '.gllpLatitude').val('');
            jQuery(_self.vars.cssID + '.gllpLongitude').val('');
            jQuery(_self.vars.cssID + '.gllpLatitude').val(newLat);
            jQuery(_self.vars.cssID + '.gllpLongitude').val(newLng);

            marker.addListener('dragend', function () {
                var newLat = marker.getPosition().lat();
                var newLng = marker.getPosition().lng();
                jQuery(_self.vars.cssID + '.gllpLatitude').val('');
                jQuery(_self.vars.cssID + '.gllpLongitude').val('');
                jQuery(_self.vars.cssID + '.gllpLatitude').val(newLat);
                jQuery(_self.vars.cssID + '.gllpLongitude').val(newLng);
            });
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////
        // PUBLIC FUNCTIONS  //////////////////////////////////////////////////////////////////////////
        var publicfunc = {
            // INITIALIZE MAP ON DIV //////////////////////////////////////////////////////////////////
            init: function (object) {

                if (!jQuery(object).attr("id")) {
                    if (jQuery(object).attr("name")) {
                        jQuery(object).attr("id", jQuery(object).attr("name"));
                    } else {
                        jQuery(object).attr("id", "_MAP_" + Math.ceil(Math.random() * 10000));
                    }
                }

                _self.vars.ID = jQuery(object).attr("id");
                _self.vars.cssID = "#" + _self.vars.ID + " ";

                _self.params.defLat = jQuery(_self.vars.cssID + ".gllpLatitude").val() ? jQuery(_self.vars.cssID + ".gllpLatitude").val() : _self.params.defLat;
                _self.params.defLng = jQuery(_self.vars.cssID + ".gllpLongitude").val() ? jQuery(_self.vars.cssID + ".gllpLongitude").val() : _self.params.defLng;
                _self.params.defZoom = jQuery(_self.vars.cssID + ".gllpZoom").val() ? parseInt(jQuery(_self.vars.cssID + ".gllpZoom").val()) : _self.params.defZoom;

                _self.vars.LATLNG = new google.maps.LatLng(_self.params.defLat, _self.params.defLng);

                _self.vars.MAPOPTIONS = _self.params.mapOptions;
                _self.vars.MAPOPTIONS.zoom = _self.params.defZoom;
                _self.vars.MAPOPTIONS.center = _self.vars.LATLNG;

                _self.vars.map = new google.maps.Map(jQuery(_self.vars.cssID + ".gllpMap").get(0), _self.vars.MAPOPTIONS);

                if (jQuery('#wp_rem__loc_bounds_rest').length !== 0 && jQuery('#wp_rem__loc_bounds_rest').val() != '') {
                    var polygonCoords = jQuery('#wp_rem__loc_bounds_rest').val();
                    if (typeof polygonCoords !== 'undefined' && polygonCoords != '') {
                        var polygonCoordsJson = jQuery.parseJSON(polygonCoords);
                        var draw_color = '#333333';
                        var prePolygon = new google.maps.Polygon({
                            paths: polygonCoordsJson,
                            strokeWeight: 0,
                            fillOpacity: 0.25,
                            fillColor: draw_color,
                            strokeColor: draw_color,
                            editable: false
                        });
                        prePolygon.setMap(_self.vars.map);
                    }
                }

                _self.vars.geocoder = new google.maps.Geocoder();
                _self.vars.elevator = new google.maps.ElevationService();

                if (show_marker == 'yes') {
                    _self.vars.marker = new google.maps.Marker({
                        position: _self.vars.LATLNG,
                        map: _self.vars.map,
                        title: _self.params.strings.markerText,
                        draggable: true,
                        marker: ' ',
                    });


                } else {
                    _self.vars.marker = new google.maps.Marker({
                        /*position: _self.vars.LATLNG,*/
                        map: _self.vars.map,
                        title: _self.params.strings.markerText,
                        draggable: true,
                        marker: ' ',
                    });
                }

                if (readius != undefined && readius != '' || myonoffswitch2) {
                    _self.vars.circle = new google.maps.Circle({
                        center: _self.vars.LATLNG,
                        radius: readius, // IN METERS.
                        fillColor: '#FF6600',
                        fillOpacity: 0.3,
                        strokeColor: '#FF6600',
                        map: _self.vars.map,
                        strokeWeight: 1         // CIRCLE BORDER.     
                    });
                }

                // Set position on doubleclick
                google.maps.event.addListener(_self.vars.map, 'dblclick', function (event) {
                    setPosition(event.latLng);
                });

                // Set position on marker move
                google.maps.event.addListener(_self.vars.marker, 'dragend', function (event) {
                    setPosition(_self.vars.marker.position);
                });

                // Set zoom feld's value when user changes zoom on the map
                google.maps.event.addListener(_self.vars.map, 'zoom_changed', function (event) {
                    jQuery(_self.vars.cssID + ".gllpZoom").val('');
                    jQuery(_self.vars.cssID + ".gllpZoom").val(_self.vars.map.getZoom());
                    jQuery(_self.vars.cssID).trigger("location_changed", jQuery(_self.vars.cssID));
                });

                // Update location and zoom values based on input field's value
                jQuery(_self.vars.cssID + ".gllpUpdateButton").bind("click", function () {
                    var lat = jQuery(_self.vars.cssID + ".gllpLatitude").val();
                    var lng = jQuery(_self.vars.cssID + ".gllpLongitude").val();
                    var latlng = new google.maps.LatLng(lat, lng);
                    _self.vars.map.setZoom(parseInt(jQuery(_self.vars.cssID + ".gllpZoom").val()));
                    setPosition(latlng);
                });

                // Search function by search button
                jQuery(_self.vars.cssID + ".gllpSearchButton").bind("click", function () {
                    var thisObj = jQuery(_self.vars.cssID + '.search-location-map');
                    wp_rem_show_loader(_self.vars.cssID + '.search-location-map', '', 'button_loader', thisObj);
                    wp_rem_gl_search_map(jQuery(_self.vars.cssID + '#post_loc_address').val());
                    performSearch(jQuery(_self.vars.cssID + ".wp-rem-search-location").val(), false);
                });

                // Search function by gllp_perform_search listener
                jQuery(document).bind("gllp_perform_search", function (event, object) {
                    performSearch(jQuery(object).attr('string'), true);
                });

                // Zoom function triggered by gllp_perform_zoom listener
                jQuery(document).bind("gllp_update_fields", function (event) {
                    var lat = jQuery(_self.vars.cssID + ".gllpLatitude").val();
                    var lng = jQuery(_self.vars.cssID + ".gllpLongitude").val();
                    var latlng = new google.maps.LatLng(lat, lng);
                    _self.vars.map.setZoom(parseInt(jQuery(_self.vars.cssID + ".gllpZoom").val()));
                    setPosition(latlng);
                });


                // resize map after load
                google.maps.event.addListenerOnce(_self.vars.map, 'idle', function () {
                    google.maps.event.trigger(_self.vars.map, 'resize');
                });
            },
            // EXPORT PARAMS TO EASILY MODIFY THEM ////////////////////////////////////////////////////
            params: _self.params

        };

        return publicfunc;
    });

}(jQuery));

jQuery(document).ready(function () {
    jQuery(".gllpLatlonPicker_branch").each(function () {
        $obj = jQuery(document).gBranchesMapsLatLonPicker();
        $obj.init(jQuery(this));
    });
});