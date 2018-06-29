// properties map

function wp_rem_get_poly_cords_properties(db_cords, polygonCoords) {
    var cordsActualLimit = 1000;
    var list_all_ids = '';
    if (typeof polygonCoords !== 'undefined' && polygonCoords != '') {
        var polygonCoordsJson = jQuery.parseJSON(polygonCoords);
        var polygon_area = new google.maps.Polygon({paths: polygonCoordsJson});

        if (typeof db_cords === 'object' && db_cords.length > 0) {
            var actual_length;
            if (db_cords.length > cordsActualLimit) {
                actual_length = cordsActualLimit;
            } else {
                actual_length = db_cords.length;
            }

            var resultProperties = 0;
            jQuery.each(db_cords, function (index, element) {
                if (index === actual_length) {
                    return false;
                }

                var db_lat = parseFloat(element.lat);
                var db_long = parseFloat(element.long);
                var property_id = element.id;

                var resultCord = google.maps.geometry.poly.containsLocation(new google.maps.LatLng(db_lat, db_long), polygon_area) ? 'true' : 'false';

                if (resultCord == 'true') {
                    if (resultProperties === 0) {
                        list_all_ids += property_id;
                    } else {
                        list_all_ids += ',' + property_id;
                    }
                    resultProperties++;
                }
            });

        }
    }
    return list_all_ids;
}

function wp_rem_property_map_init(dataobj) {
    var map_id = dataobj.map_id,
            map_zoom = dataobj.map_zoom,
            this_map_style = dataobj.map_style,
            latitude = dataobj.latitude,
            longitude = dataobj.longitude;

    if (latitude != '' && longitude != '') {

        map_zoom = parseInt(map_zoom);
        if (!jQuery.isNumeric(map_zoom)) {
            var map_zoom = 9;
        }
        var map_type = google.maps.MapTypeId.ROADMAP;
        var mapLatlng = new google.maps.LatLng(latitude, longitude);
        var map = new google.maps.Map(document.getElementById('wp-rem-property-map-' + map_id), {
            zoom: map_zoom,
            center: mapLatlng,
            mapTypeControl: false,
            streetViewControl: false,
            mapTypeId: map_type,
        });

        if (typeof this_map_style !== 'undefined' && this_map_style != '') {

            var styles = wp_rem_map_select_style(this_map_style);
            if (styles != '') {
                var styledMap = new google.maps.StyledMapType(styles, {name: 'Styled Map'});
                map.mapTypes.set('map_style', styledMap);
                map.setMapTypeId('map_style');
            }
        }
    }
}

function wp_rem_property_map(dataobj, db_cords) {
    var map_id = dataobj.map_id,
            map_zoom = dataobj.map_zoom,
            this_map_style = dataobj.map_style,
            latitude = dataobj.latitude,
            longitude = dataobj.longitude,
            marker_icon = dataobj.marker_icon,
            cluster_icon = dataobj.cluster_icon,
            polygonCoords = dataobj.location_cords,
            cordsActualLimit = 1000,
            plugin_url = wp_rem_loc_strings.plugin_url;

    if (latitude != '' && longitude != '') {

        var marker;
        var all_marker = [];
        var LatLngList = [];

        map_zoom = parseInt(map_zoom);
        if (!jQuery.isNumeric(map_zoom)) {
            var map_zoom = 9;
        }
        var map_type = google.maps.MapTypeId.ROADMAP;
        var mapLatlng = new google.maps.LatLng(latitude, longitude);
        var map = new google.maps.Map(document.getElementById('wp-rem-property-map-' + map_id), {
            zoom: map_zoom,
            center: mapLatlng,
            mapTypeControl: false,
            streetViewControl: false,
            mapTypeId: map_type,
        });

        if (typeof this_map_style !== 'undefined' && this_map_style != '') {

            var styles = wp_rem_map_select_style(this_map_style);
            if (styles != '') {
                var styledMap = new google.maps.StyledMapType(styles, {name: 'Styled Map'});
                map.mapTypes.set('map_style', styledMap);
                map.setMapTypeId('map_style');
            }
        }

        var open_info_window;
        var markerClusterers;
        var drawingManager;
        var selectedShape; 
        var prePolygon;
        var draw_color = '#1e90ff';

        if (typeof polygonCoords !== 'undefined' && polygonCoords != '') {

            var polygonCoordsJson = jQuery.parseJSON(polygonCoords);
            prePolygon = new google.maps.Polygon({
                paths: polygonCoordsJson,
                strokeWeight: 0,
                fillOpacity: 0.25,
                fillColor: draw_color,
                strokeColor: draw_color,
                editable: false
            });
            prePolygon.setMap(map);

            setSelection(prePolygon, true);
        } else {
            // Showing all markers in default for page load
            if (typeof db_cords === 'object' && db_cords.length > 0) {
                var actual_length;
                if (db_cords.length > cordsActualLimit) {
                    actual_length = cordsActualLimit;
                } else {
                    actual_length = db_cords.length;
                }

                var def_cords_obj = [];
                var def_cords_creds = [];
                jQuery.each(db_cords, function (index, element) {
                    if (index === actual_length) {
                        return false;
                    }
                    var i = index;

                    var db_lat = parseFloat(element.lat);
                    var db_long = parseFloat(element.long);
                    var list_title = element.title;
                    var list_marker = element.marker;

                    var def_cords = {lat: db_lat, lng: db_long};
                    def_cords_obj.push(def_cords);

                    var def_coroeds = {list_title: list_title, list_marker: list_marker, element: element};
                    def_cords_creds.push(def_coroeds);

                    var db_latLng = new google.maps.LatLng(db_lat, db_long);

                    LatLngList.push(new google.maps.LatLng(db_lat, db_long));
                    marker = new google.maps.Marker({
                        position: db_latLng,
                        center: db_latLng,
                        //animation: google.maps.Animation.DROP,
                        map: map,
                        draggable: false,
                        icon: list_marker,
                        title: list_title,
                    });

                    var contentString = infoContentString(element);

                    var infowindow = new InfoBox({
                        boxClass: 'liting_map_info',
                        content: contentString,
                        disableAutoPan: true,
                        maxWidth: 0,
                        alignBottom: true,
                        pixelOffset: new google.maps.Size(-108, -72),
                        zIndex: null,
                        closeBoxMargin: "2px",
                        closeBoxURL: "close",
                        infoBoxClearance: new google.maps.Size(1, 1),
                        isHidden: false,
                        pane: "floatPane",
                        enableEventPropagation: false
                    });

                    google.maps.event.addListener(marker, 'click', (function (marker, i) {
                        return function () {
                            map.panTo(marker.getPosition());
                            map.panBy(0, -100);
                            if (open_info_window)
                                open_info_window.close();
                            infowindow.open(map, this);
                            open_info_window = infowindow;
                        }
                    })(marker, i));
                    all_marker.push(marker);
                });

                if (actual_length > 0 && LatLngList.length > 0) {
                    var latlngbounds = new google.maps.LatLngBounds();
                    for (var i = 0; i < LatLngList.length; i++) {
                        latlngbounds.extend(LatLngList[i]);
                    }
                    map.setCenter(latlngbounds.getCenter(), map.fitBounds(latlngbounds));

                    if (map.getZoom() < 1) {
                        map.setZoom(4);
                    }
                    map.setZoom(map.getZoom() - 1);

                    var mapResizeTimes = 0;
                    setTimeout(function () {
                        if (mapResizeTimes === 0) {
                            jQuery("#wp-rem-property-map-" + map_id).height(jQuery(window).height);
                            google.maps.event.trigger(map, "resize");
                        }
                        mapResizeTimes++;
                    }, 500);

                    if (actual_length >= (cordsActualLimit - 1)) {
                        jQuery('#total-records-' + map_id).html(cordsActualLimit + '+');
                    } else {
                        jQuery('#total-records-' + map_id).html(actual_length);
                    }
                    // jQuery('#showing-records-' + map_id).html(actual_length);
                    jQuery('#property-records-' + map_id).show();
                }

                //clusters
                mapClusters();
                google.maps.event.addListener(map, "click", function (event) {
                    open_info_window.close();
                });
            }
            //
        }

        function mapClusters() {
            if (all_marker) {
                var mcOptions;
                var clusterStyles = [
                    {
                        textColor: '#ffffff',
                        opt_textColor: '#ffffff',
                        url: cluster_icon,
                        height: 40,
                        width: 40,
                        textSize: 12
                    }
                ];
                mcOptions = {
                    gridSize: 45,
                    ignoreHidden: true,
                    maxZoom: 12,
                    styles: clusterStyles
                };
                markerClusterers = new MarkerClusterer(map, all_marker, mcOptions);
            }
        }

        var polyOptions = {
            strokeWeight: 0,
            fillOpacity: 0.25,
            editable: true
        };

        function infoContentString(element) {
            var property_id = element.id;
            var list_title = element.title;
            var list_link = element.link;
            var list_img = element.img;
            var list_price = element.price;
            var list_favourite = element.favourite;
            var list_member = element.member;
            var list_featured = element.featured;
            var list_reviews = element.reviews;
            var list_address = element.address;

            var img_html = '';
            if (list_img !== 'undefined' && list_img != '') {
                img_html = '<figure>' + list_img + '</figure>';
            }

            var contentString = '\
            <div id="property-info-' + property_id + '-' + map_id + '" class="property-info-inner">\
                <div class="info-main-container">\
                    ' + img_html + '\
                    <div class="info-txt-holder">\
                        ' + list_featured + '\
                        ' + list_reviews + '\
                        ' + list_favourite + '\
                        <a class="info-title" href="' + list_link + '">' + list_title + '</a>\
                        ' + list_price + '\
                        ' + list_address + '\
                    </div>\
                </div>\
            </div>';

            return contentString;
        }

        function clearSelection() {
            if (selectedShape) {
                if (typeof selectedShape.setEditable == 'function') {
                    selectedShape.setEditable(false);
                }
                selectedShape = null;
            }
        }

        // Sets the map on all markers in the array.
        function setMapOnAll(map) {
            if (all_marker) {
                for (var i = 0; i < all_marker.length; i++) {
                    all_marker[i].setMap(map);
                }
            }
        }

        function deleteSelectedShape() {
            setMapOnAll(null);
            if (markerClusterers) {
                markerClusterers.clearMarkers();
            }
            if (selectedShape) {
                selectedShape.setMap(null);
            }
            if (prePolygon) {
                prePolygon.setMap(null);
            }

            jQuery('#cancel-draw-map-' + map_id).attr('class', 'act-btn is-disabled');
            jQuery('#draw-map-' + map_id).attr('class', 'act-btn');
            jQuery('#delete-button-' + map_id).attr('class', 'act-btn is-disabled');

            var property_form = jQuery('form[id^="frm_property_arg"]');
            var data_vals = '&ajax_filter=true';
            var current_url = location.protocol + "//" + location.host + location.pathname + "?" + data_vals;//window.location.href;
            window.history.pushState(null, null, decodeURIComponent(current_url));
            property_form.find('input[name="loc_polygon"]').remove();

            if (open_info_window) {
                open_info_window.close();
            }
        }

        function updateCurSelText() {
            var posstr;
            var pathstr;
            var poly_cords_obj;
            // clear all markers data
            all_marker = [];
            var this_loader = jQuery('#map-loader-' + map_id);
            var property_form = jQuery('form[id^="frm_property_arg"]');
            var data_vals = property_form.serialize();
            data_vals = data_vals.replace(/[^&]+=\.?(?:&|$)/g, ''); // remove extra and empty variables

            posstr = "" + selectedShape.position;
            if (typeof selectedShape.position == 'object') {
                posstr = selectedShape.position.toUrlValue();
            }
            pathstr = "" + selectedShape.getPath;
            if (typeof selectedShape.getPath == 'function') {
                pathstr = "[";
                poly_cords_obj = new Array();
                for (var i = 0; i < selectedShape.getPath().getLength(); i++) {

                    var latLongVals = selectedShape.getPath().getAt(i).toUrlValue();
                    var latLongValsObj = latLongVals.split(',');
                    var putLat = parseFloat(latLongValsObj[0]);
                    var putLong = parseFloat(latLongValsObj[1]);

                    // puting polygon coordinates for bounds
                    LatLngList.push(new google.maps.LatLng(putLat, putLong));

                    var pathComma = ',';
                    if (i === (selectedShape.getPath().getLength() - 1)) {
                        pathComma = '';
                    }
                    pathstr += '{"lat": ' + putLat + ', "lng": ' + putLong + '}' + pathComma;

                    var poly_cords = {lat: putLat, lng: putLong};
                    poly_cords_obj.push(poly_cords);
                }
                pathstr += "]";

                var resultInsTimes = 0;
                var resultCordTimes = 0;
                this_loader.html('<div class="loader-holder"><img src="' + plugin_url + 'assets/frontend/images/ajax-loader.gif" alt=""></div>');
                setTimeout(function () {
                    if (resultInsTimes === 0) {
                        var poly_in_properties = wp_rem_get_poly_cords_properties(db_cords, pathstr);

                        var cords_query_string = jQuery.ajax({
                            url: wp_rem_loc_strings.ajax_url,
                            method: "POST",
                            data: {
                                pathstr: pathstr,
                                poly_in_properties: poly_in_properties,
                                action: 'wp_rem_properties_map_cords_to_url'
                            },
                            dataType: "json"
                        }).done(function (response) {

                            var polygon_area = new google.maps.Polygon({paths: poly_cords_obj});

                            setTimeout(function () {
                                if (resultCordTimes === 0) {
                                    var property_ids = '';
                                    if (typeof db_cords === 'object' && db_cords.length > 0) {
                                        var actual_length;
                                        if (db_cords.length > cordsActualLimit) {
                                            actual_length = cordsActualLimit;
                                        } else {
                                            actual_length = db_cords.length;
                                        }

                                        var trueCords = 0;
                                        var resultProperties = 0;
                                        jQuery.each(db_cords, function (index, element) {
                                            if (index === actual_length) {
                                                return false;
                                            }
                                            var i = index;

                                            var db_lat = parseFloat(element.lat);
                                            var db_long = parseFloat(element.long);
                                            var property_id = element.id;
                                            var list_title = element.title;
                                            var list_marker = element.marker;

                                            var resultCord = google.maps.geometry.poly.containsLocation(new google.maps.LatLng(db_lat, db_long), polygon_area) ? 'true' : 'false';

                                            if (resultCord == 'true') {
                                                var db_latLng = new google.maps.LatLng(db_lat, db_long);


                                                marker = new google.maps.Marker({
                                                    position: db_latLng,
                                                    center: db_latLng,
                                                    animation: google.maps.Animation.DROP,
                                                    map: map,
                                                    draggable: false,
                                                    icon: list_marker,
                                                    title: list_title,
                                                });

                                                var contentString = infoContentString(element);

                                                var infowindow = new InfoBox({
                                                    boxClass: 'liting_map_info',
                                                    content: contentString,
                                                    disableAutoPan: true,
                                                    maxWidth: 0,
                                                    alignBottom: true,
                                                    pixelOffset: new google.maps.Size(-108, -72),
                                                    zIndex: null,
                                                    closeBoxMargin: "2px",
                                                    closeBoxURL: "close",
                                                    infoBoxClearance: new google.maps.Size(1, 1),
                                                    isHidden: false,
                                                    pane: "floatPane",
                                                    enableEventPropagation: false
                                                });

                                                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                                                    return function () {
                                                        map.panTo(marker.getPosition());
                                                        map.panBy(0, -100);
                                                        if (open_info_window)
                                                            open_info_window.close();
                                                        infowindow.open(map, this);
                                                        open_info_window = infowindow;
                                                    }
                                                })(marker, i));
                                                all_marker.push(marker);
                                                trueCords++;

                                                if (resultProperties === 0) {
                                                    property_ids += property_id;
                                                } else {
                                                    property_ids += ',' + property_id;
                                                }
                                                resultProperties++;
                                            }
                                        });
                                        if (trueCords > 0) {
                                            if (trueCords >= (cordsActualLimit - 1)) {
                                                jQuery('#total-records-' + map_id).html(cordsActualLimit + '+');
                                            } else {
                                                jQuery('#total-records-' + map_id).html(trueCords);
                                            }
                                           // jQuery('#showing-records-' + map_id).html(trueCords);
                                            jQuery('#property-records-' + map_id).show();

                                            //clusters
                                            mapClusters();
                                        }
                                    }

                                    if (typeof response.string !== 'undefined' && response.string != '') {

                                        if (jQuery('#wp-rem-property-map-' + map_id).is(':visible')) {
                                            data_vals = '&loc_polygon=' + response.string + '&ajax_filter=true';
                                            var current_url = location.protocol + "//" + location.host + location.pathname + "?" + data_vals;//window.location.href;
                                            window.history.pushState(null, null, decodeURIComponent(current_url));
                                            property_form.find('input[name="loc_polygon"]').remove();
                                            property_form.find('input[name="location"]').val('');
                                            property_form.append('<input type="hidden" name="loc_polygon" value="' + response.string + '">');
                                            //
                                            var property_holder_counter = jQuery('.wp-rem-dev-property-content').data('id');
                                            wp_rem_property_content(property_holder_counter);
                                        }
                                    }

                                    this_loader.html('');
                                }
                                resultCordTimes++;
                            }, 2000);

                        }).fail(function () {
                            this_loader.html('');
                        });

                        if (LatLngList.length > 0) {
                            var latlngbounds = new google.maps.LatLngBounds();
                            for (var i = 0; i < LatLngList.length; i++) {
                                latlngbounds.extend(LatLngList[i]);
                            }
                            map.setCenter(latlngbounds.getCenter(), map.fitBounds(latlngbounds));
                            map.setZoom(map.getZoom());
                        }
                    }
                    resultInsTimes++;

                }, 2000);
                //clearInterval(resultInsTimer);
            }
        }

        function setSelection(shape, isNotMarker) {
            clearSelection();
            selectedShape = shape;
            if (isNotMarker)
                shape.setEditable(false);
            selectColor(shape.get('fillColor') || shape.get('strokeColor'));
            updateCurSelText();

            if (selectedShape) {
                if (selectedShape.type == google.maps.drawing.OverlayType.POLYLINE) {
                    selectedShape.set('strokeColor', draw_color);
                } else {
                    selectedShape.set('fillColor', draw_color);
                }
            }
        }

        function selectColor(color) {

            if (drawingManager) {
                // Retrieves the current options from the drawing manager and replaces the
                // stroke or fill color as appropriate.
                var polylineOptions = drawingManager.get('polylineOptions');
                polylineOptions.strokeColor = color;
                drawingManager.set('polylineOptions', polylineOptions);
                var polygonOptions = drawingManager.get('polygonOptions');
                polygonOptions.fillColor = color;
                drawingManager.set('polygonOptions', polygonOptions);
            }
        }

        // Creates a drawing manager attached to the map that allows the user to draw
        // markers, lines, and shapes.
        drawingManager = new google.maps.drawing.DrawingManager({
            //drawingMode: google.maps.drawing.OverlayType.POLYGON,
            markerOptions: {
                draggable: true,
                editable: true,
            },
            polylineOptions: {
                editable: false
            },
            drawingControl: false,
            drawingControlOptions: {
                drawingModes: ['polygon']
            },
            polygonOptions: polyOptions,
            map: map
        });

        google.maps.event.addListener(drawingManager, 'overlaycomplete', function (e) {
            //~ if (e.type != google.maps.drawing.OverlayType.MARKER) {
            var isNotMarker = (e.type != google.maps.drawing.OverlayType.MARKER);
            // Switch back to non-drawing mode after drawing a shape.
            drawingManager.setDrawingMode(null);
            // Add an event listener that selects the newly-drawn shape when the user
            // mouses down on it.
            var newShape = e.overlay;

            setSelection(newShape, isNotMarker);

            drawingManager.setOptions({
                drawingControl: false
            });
            jQuery('#cancel-draw-map-' + map_id).attr('class', 'act-btn is-disabled');
            jQuery('#draw-map-' + map_id).attr('class', 'act-btn is-disabled');
            jQuery('#delete-button-' + map_id).attr('class', 'act-btn');
        });

        // Start Drawing Mode
        google.maps.event.addDomListener(document.getElementById('draw-map-' + map_id), 'click', function () {
            drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);
            setMapOnAll(null);
            if (markerClusterers) {
                markerClusterers.clearMarkers();
            }
            if (selectedShape) {
                selectedShape.setMap(null);
            }
            if (prePolygon) {
                prePolygon.setMap(null);
            }
            if (open_info_window) {
                open_info_window.close();
            }
            jQuery('#property-records-' + map_id).hide();
            jQuery('#draw-map-' + map_id).attr('class', 'act-btn is-active');
            jQuery('#cancel-draw-map-' + map_id).attr('class', 'act-btn');
            jQuery('#delete-button-' + map_id).attr('class', 'act-btn is-disabled');
        });

        // Cancel Drawing Mode
        google.maps.event.addDomListener(document.getElementById('cancel-draw-map-' + map_id), 'click', function () {
            drawingManager.setDrawingMode(null);
            jQuery('#cancel-draw-map-' + map_id).attr('class', 'act-btn is-disabled');
            jQuery('#draw-map-' + map_id).attr('class', 'act-btn');
            jQuery('#delete-button-' + map_id).attr('class', 'act-btn is-disabled');
        });

        // Clear the current selection when the drawing mode is changed, or when the
        // map is clicked.
        google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
        //google.maps.event.addListener(map, 'click', clearSelection);
        google.maps.event.addDomListener(document.getElementById('delete-button-' + map_id), 'click', deleteSelectedShape);

        if (document.getElementById('map-lock-' + map_id)) {
            google.maps.event.addDomListener(document.getElementById('map-lock-' + map_id), 'click', function () {
                if (jQuery('#map-lock-' + map_id).hasClass('map-loked')) {
                    map.setOptions({scrollwheel: true});
                    map.setOptions({draggable: true});
                    document.getElementById('map-lock-' + map_id).innerHTML = '<i class="icon-unlock"></i>';
                    jQuery('#map-lock-' + map_id).attr('class', 'map-unloked');
                } else if (jQuery('#map-lock-' + map_id).hasClass('map-unloked')) {
                    map.setOptions({scrollwheel: false});
                    map.setOptions({draggable: false});
                    document.getElementById('map-lock-' + map_id).innerHTML = '<i class="icon-lock2"></i>';
                    jQuery('#map-lock-' + map_id).attr('class', 'map-loked');
                }
            });
        }
    }
}

jQuery("div[id^='wp-rem-property-map-']").css("pointer-events", "none");

var onMapMouseleaveHandler = function (event) {
    var that = jQuery(this);

    that.on('click', onMapClickHandler);
    that.off('mouseleave', onMapMouseleaveHandler);
    jQuery("div[id^='wp-rem-property-map-']").css("pointer-events", "none");
}

var onMapClickHandler = function (event) {
    var that = jQuery(this);
    // Disable the click handler until the user leaves the map area
    that.off('click', onMapClickHandler);

    // Enable scrolling zoom
    that.find('div[id^="wp-rem-property-map-"]').css("pointer-events", "auto");

    // Handle the mouse leave event
    that.on('mouseleave', onMapMouseleaveHandler);
}
jQuery(document).on('click', '.wp-rem-property-map', onMapClickHandler);

/*
 * Map Block
 */

$(".widget-map, .map-sec-holder").click(function() {
    $(".widget-map #googleMap1, #contactMap1, #contactMap2, #contactMap3, #contactMap4 ").css("pointer-events", "auto");
});

$(".widget-map, .map-sec-holder").mouseleave(function() {
    $(".widget-map #googleMap1, #contactMap1, #contactMap2, #contactMap3, #contactMap4").css("pointer-events", "none");
});

jQuery(document).on("click", ".map-holder .map-actions li", function() {
    "use strict";
    var this_id = jQuery(this).attr("id");
    if (this_id == "slider-view" || this_id == "slider-view1") {
        jQuery(".dominant-places").hide();
        jQuery(".wp-rem-property-banner").removeClass("hidden");
        jQuery(".wp-rem-property-map").addClass("hidden");
        jQuery(".map-switch").show();
        if (jQuery(".banner .property-banner-slider .swiper-container").length != "") {
            var mySwiper = new Swiper(".banner .property-banner-slider .swiper-container", {
                pagination: ".swiper-pagination",
                paginationClickable: true,
                loop: true,
                grabCursor: true,
                nextButton: ".banner .property-banner-slider .swiper-button-next",
                prevButton: ".banner .property-banner-slider .swiper-button-prev",
                spaceBetween: 30,
                autoplay: 3e3,
                effect: "fade"
            });
        }
    }
    if (this_id == "map-view" || this_id == "map-view1") {
        if (map != undefined && map != 'undefined' && map != '') {
            panorama = map.getStreetView();
            panorama.setVisible(false);
            jQuery(".slider-view").removeClass("active");
            jQuery(".map-view-street").removeClass("active");
            jQuery(".map-view").addClass("active");
            jQuery(".wp-rem-property-map").removeClass("hidden");
            jQuery(".wp-rem-property-banner").addClass("hidden");
            jQuery(".map-switch").hide();
            jQuery(".dominant-places").show();
            var new_latitude = jQuery(".map-view").data('lat');
            var new_longitude = jQuery(".map-view").data('lng');
            google.maps.event.trigger(map, 'resize');
            var NewMapCenter = map.getCenter();
            if( typeof new_latitude == 'undefined' ){
                var new_latitude = NewMapCenter.lat();
            }
            if( typeof new_longitude == 'undefined' ){
                var new_longitude = NewMapCenter.lng();
            }
            var mapResizeTimes = 0;
            setTimeout(function() {
                if (mapResizeTimes === 0) {
                    map.setCenter(new google.maps.LatLng(new_latitude, new_longitude));
                    mapResizeTimes++;
                }
            }, 500);
        }
    } else if (this_id == "map-view-street" || this_id == "map-view-street1") {
        jQuery(".slider-view").removeClass("active");
        jQuery(".map-view").removeClass("active");
        jQuery(".map-view-street").addClass("active");
        jQuery(".dominant-places").hide();
        jQuery(".wp-rem-property-map").removeClass("hidden");
        jQuery(".wp-rem-property-banner").addClass("hidden");
        var panorama = map.getStreetView();
        panorama.setVisible(true);
    } else {
        jQuery(".map-view").removeClass("active");
        jQuery(".map-view-street").removeClass("active");
        jQuery(".slider-view").addClass("active");
    }
});
jQuery(document).ready(function($) {
    jQuery(".map-switch").hide();
});