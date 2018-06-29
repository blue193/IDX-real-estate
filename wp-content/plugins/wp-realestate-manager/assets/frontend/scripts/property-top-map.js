// properties map
function wp_rem_get_poly_cords_properties_topmap(db_cords, polygonCoords) {
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
// properties top map

// jQuery('form[name="wp-rem-top-map-form"]').keydown(function (event) {
// if (event.keyCode == 13) {
// event.preventDefault();
// return false;
// }
// });

jQuery(document).on('focusin', '.wp-rem-top-loc-wrap input', function () {
    var ajax_url = wp_rem_top_gmap_strings.ajax_url;
    var _plugin_url = wp_rem_top_gmap_strings.plugin_url;
    var _this = jQuery(this);
    if (jQuery(this).hasClass('wp-rem-dev-load-locs')) {
        var list_to_append = jQuery(this).parents('label').find(".top-search-locations");
        var this_loader = jQuery(this).parents('label').find('.loc-icon-holder');
        this_loader.html('<img src="' + _plugin_url + 'assets/frontend/images/ajax-loader.gif" alt="">');
        var _top_map_locs = jQuery.ajax({
            url: ajax_url,
            method: "POST",
            data: 'locs=top_map&action=dropdown_options_for_search_location_data',
            dataType: "json"
        }).done(function (response) {
            if (response) {
                list_to_append.html('');
                jQuery.each(response, function () {
                    list_to_append.append("<li data-val=\'" + this.value + "\'>" + this.caption + "</li>");
                });
                _this.removeClass('wp-rem-dev-load-locs');
            }
            this_loader.html('<i class="icon-target3"></i>');
        }).fail(function () {
            this_loader.html('<i class="icon-target3"></i>');
        });
    }
    jQuery(this).parents('.wp-rem-top-loc-wrap').find('.top-search-locations').show();
});

jQuery(document).on('click', '.wp-rem-top-loc-wrap .top-search-locations > li', function () {
    var _this_data = jQuery(this).data('val');
    var locations_field = jQuery(this).parents('.wp-rem-top-loc-wrap').find('input');
    locations_field.val(_this_data);
    wp_rem_top_serach_trigger();
    jQuery(this).parents('.wp-rem-top-loc-wrap').find('.top-search-locations').hide();
});

jQuery(document).on('click', 'body', function (e) {
    var container = jQuery(".wp-rem-top-loc-wrap");

    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.find('.top-search-locations').hide();
    }
});
// get my location 
function wp_rem_getLocation(id) {
    if (navigator.geolocation) {
        var _plugin_url = wp_rem_top_gmap_strings.plugin_url;
        var this_loader = jQuery('.slide-loader');

        jQuery('#geo-location-button-' + id).attr('class', 'act-btn is-disabled');
        //jQuery('#geo-location-button-' + id).html('<img src="' + _plugin_url + 'assets/frontend/images/geo_on.svg" alt="">');

        var browserGeolocationFail = function (error) {
            switch (error.code) {
                case error.TIMEOUT:
                    alert(wp_rem_top_gmap_strings.geoloc_timeout);
                    break;
                case error.PERMISSION_DENIED:
                    if (error.message.indexOf("Only secure origins are allowed") == 0) {
                        alert(wp_rem_top_gmap_strings.geoloc_not_support);
                    }
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert(wp_rem_top_gmap_strings.geoloc_unavailable);
                    break;
            }
        };

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                this_loader.addClass('loading');
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var dataString = "lat=" + pos.lat + "&lng=" + pos.lng + "&action=wp_rem_get_geolocation";
                jQuery.ajax({
                    type: "POST",
                    url: wp_rem_globals.ajax_url,
                    data: dataString,
                    dataType: "json",
                    success: function (response) {
                        var address = response.address;
                        var property_form = jQuery('form[id^="frm_property_arg"]');
                        var data_vals = '&ajax_filter=true';
                        var current_url = location.protocol + "//" + location.host + location.pathname + "?" + data_vals;
                        window.history.pushState(null, null, decodeURIComponent(current_url));
                        property_form.find('input[name="loc_polygon"]').remove();
                        jQuery('.wp-rem-locations-field-geo' + id).val(address);
                        wp_rem_top_serach_trigger();
                        if ($(".property-counter").length > 0) {
                            jQuery('body').addClass('wp-rem-changing-view');
                            wp_rem_property_content($(".property-counter").val(), '', 'false');
                            jQuery('body').removeClass('wp-rem-changing-view');
                        }
                        jQuery('#geo-location-button-' + id).attr('class', 'act-btn');
                        //jQuery('#geo-location-button-' + id).html('<img src="' + _plugin_url + 'assets/frontend/images/geo.svg" alt="">');
                        this_loader.removeClass('loading');
                    }
                });
            }, browserGeolocationFail);
        } else {
            alert(wp_rem_top_gmap_strings.geoloc_not_support);
        }
    }
}

function wp_rem_showPosition(position) {

    jQuery.ajax({
        url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + position.coords.latitude + ',' + position.coords.longitude + '&sensor=true',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            //jQuery('#wp-rem-search-location').val(data.results[0].formatted_address);
            //jQuery('#goe_loc_bt').hide(); 
            wp_rem_top_serach_trigger();
        },
        error: function (xhr, textStatus, errorThrown) {
            jQuery('#goe_loc_bt').show();
        }
    });

}


function wp_rem_top_serach_trigger() {
    var ajax_url = wp_rem_top_gmap_strings.ajax_url;
    var _plugin_url = wp_rem_top_gmap_strings.plugin_url;
    var _this_form = jQuery('form[name="wp-rem-top-map-form"]');
    var this_loader = jQuery('.slide-loader');
    var split_map = jQuery(".wp-rem-split-map-wrap").size();
    var view_type = '';
    if (split_map > 0) {
        view_type = 'split_map';
    }
    var data_vals = 'ajax_filter=true&map=top_map&action=wp_rem_top_map_search&' + _this_form.serialize() + '&atts=' + jQuery('#atts').html();
    if ($(".property-counter").length > 0) {
        data_vals += "&" + jQuery("#frm_property_arg" + $(".property-counter").length).serialize();
    }

    if ($("input[name='loc_polygon_path']").length > 0) {
        data_vals += "&loc_polygon_path=" + $("input[name='loc_polygon_path']").val();
    }
    data_vals = stripUrlParams(data_vals);
    this_loader.addClass('loading');

    var loading_top_map = jQuery.ajax({
        url: ajax_url,
        method: "POST",
        data: data_vals,
        dataType: "json"
    }).done(function (response) {
        if (typeof response.html !== 'undefined') {
            jQuery('.top-map-action-scr').html(response.html);
        }

        this_loader.removeClass('loading');
    }).fail(function () {
        this_loader.removeClass('loading');
    });

    if ($(".property-counter").length > 0) {
        jQuery('body').addClass('wp-rem-changing-view');
        wp_rem_property_content($(".property-counter").val(), view_type, 'false');
        jQuery('body').removeClass('wp-rem-changing-view');
    }
}

function saveSearchAlert(pathstr) {
    var this_area = jQuery('.property-alert-box-map');
    var email = this_area.find(".email-input-top").val();
    // This one is removed
    var name = this_area.find(".name-input-top").val();
    //var name = email;
    var frequency = this_area.find('input[name="alert-frequency"]:checked').val();
    if (typeof frequency == "undefined") {
        frequency = "never";
    }

    var thisObj = this_area.find('.propertyalert-submit-button');
    wp_rem_show_loader('.propertyalert-submit-button', '', 'button_loader', thisObj);
    $.ajax({
        "type": "POST",
        "url": wp_rem_notifications.ajax_url,
        "data": {
            "action": "wp_rem_create_property_alert",
            "email": email,
            "name": name,
            "frequency": frequency,
            "location": window.location.toString(),
            "security": wp_rem_notifications.security,
            "query": '',
        },
        "dataType": "json",
        "success": function (response) {

            wp_rem_show_response(response, '.property-alert-box-map .newsletter', thisObj);
            if (response.type == 'success') {
                this_area.find(".name-input-top").val('');
                var setIntr = setInterval(function () {
                    viewProperties(pathstr);
                    clearInterval(setIntr);
                }, 1000);
            }
        },
    });
    return false;
}

function wp_rem_property_top_map(top_dataobj, is_ajax) {

    var ajax_url = wp_rem_top_gmap_strings.ajax_url;
    var _plugin_url = wp_rem_top_gmap_strings.plugin_url;
    var map_id = top_dataobj.map_id,
            map_zoom = top_dataobj.map_zoom,
            this_map_style = top_dataobj.map_style,
            this_map_cus_style = top_dataobj.map_custom_style,
            latitude = top_dataobj.latitude,
            longitude = top_dataobj.longitude,
            db_cords = top_dataobj.map_cords,
            polygonCoords = top_dataobj.location_cords,
            cluster_icon = top_dataobj.cluster_icon,
            cordsActualLimit = 1000;

    var open_info_window;

    if (latitude != '' && longitude != '') {

        var marker;
        all_marker = [];
        reset_top_map_marker = [];

        var LatLngList = [];

        if (is_ajax != 'true') {
            map_zoom = parseInt(map_zoom);
            if (!jQuery.isNumeric(map_zoom)) {
                var map_zoom = 9;
            }
            var map_type = google.maps.MapTypeId.ROADMAP;
            var mapLatlng = new google.maps.LatLng(latitude, longitude);

            map = new google.maps.Map(jQuery('.wp-rem-ontop-gmap').get(0), {
                zoom: map_zoom,
                center: mapLatlng,
                mapTypeControl: false,
                streetViewControl: false,
                mapTypeId: map_type,
                scrollwheel: false,
                zoomControl: true,
                  zoomControlOptions: {
                      position: google.maps.ControlPosition.RIGHT_CENTER
                  },
            });
        } else {
            map.panTo(new google.maps.LatLng(latitude, longitude));
        }
        if (typeof this_map_cus_style !== 'undefined' && this_map_cus_style != '') {
            var cust_style = jQuery.parseJSON(this_map_cus_style);
            var styledMap = new google.maps.StyledMapType(cust_style, {name: 'Styled Map'});
            map.mapTypes.set('map_style', styledMap);
            map.setMapTypeId('map_style');
        } else if (typeof this_map_style !== 'undefined' && this_map_style != '') {

            var styles = wp_rem_map_select_style(this_map_style);
            if (styles != '') {
                var styledMap = new google.maps.StyledMapType(styles, {name: 'Styled Map'});
                map.mapTypes.set('map_style', styledMap);
                map.setMapTypeId('map_style');
            }
        }

        var open_info_window;
        markerClusterers = '';
        var drawingManager;
        var selectedShape;
        var prePolygon;
        var draw_color = '#1e90ff';

        if (typeof polygonCoords !== 'undefined' && polygonCoords != '') {
            
            if (is_ajax != 'true') {
                var points = [];
                for (var i = 0; i < polygonCoords.length; i++) {
                    points.push(new google.maps.LatLng(polygonCoords[i][0], polygonCoords[i][1]));
                }

                if (prePolygon) {
                    prePolygon.setMap(null);
                }

                prePolygon = new google.maps.Polygon({
                    paths: points,
                    strokeWeight: 0,
                    fillOpacity: 0.25,
                    fillColor: draw_color,
                    strokeColor: draw_color,
                    editable: false
                });
                prePolygon.setMap(map);

                //setSelection(prePolygon, true);
            }
        }
        
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

            // variables for same lat lng merge
            var ohterLatLonObj = [];
            var sameLatLonObjMajor = [];
            var sameLatLonIndObj = [];

            var sameAddIndex = [];
            var allPostsMajorObj = [];

            jQuery.each(db_cords, function (index, element) {
                if (typeof element.lat !== 'undefined' && typeof element.lat != '' && typeof element.long !== 'undefined' && typeof element.long != '') {
                    var other_pos = true;
                    for (var oi = 0; oi < db_cords.length; oi++) {
                        if (
                                oi !== index &&
                                sameAddIndex.indexOf(oi) === -1 &&
                                db_cords[oi]['lat'] === element.lat &&
                                db_cords[oi]['long'] === element.long
                                ) {
                            sameAddIndex.push(oi);
                            other_pos = false;
                        }
                    }
                    if (other_pos === true && sameAddIndex.indexOf(index) === -1) {
                        var thisObj = {
                            obj_type: 'single',
                            lat: element.lat,
                            long: element.long,
                            id: element.id,
                            title: element.title,
                            link: element.link,
                            img: element.img,
                            price: element.price,
                            address: element.address,
                            favourite: element.favourite,
                            featured: element.featured,
                            reviews: element.reviews,
                            member: element.member,
                            marker: element.marker,
                        };
                        ohterLatLonObj.push(thisObj);
                        allPostsMajorObj.push(thisObj);
                    } else {
                        var sameLatLonObj = [];
                        for (var oi = 0; oi < db_cords.length; oi++) {
                            if (db_cords[oi]['lat'] === element.lat && db_cords[oi]['long'] === element.long && sameLatLonIndObj.indexOf(oi) === -1) {
                                var thisObj = {
                                    lat: db_cords[oi]['lat'],
                                    long: db_cords[oi]['long'],
                                    id: db_cords[oi]['id'],
                                    title: db_cords[oi]['title'],
                                    link: db_cords[oi]['link'],
                                    img: db_cords[oi]['img'],
                                    price: db_cords[oi]['price'],
                                    address: db_cords[oi]['address'],
                                    favourite: db_cords[oi]['favourite'],
                                    featured: db_cords[oi]['featured'],
                                    reviews: db_cords[oi]['reviews'],
                                    member: db_cords[oi]['member'],
                                    marker: db_cords[oi]['marker'],
                                };
                                sameLatLonObj.push(thisObj);
                                sameLatLonIndObj.push(oi);
                            }
                        }
                        if (sameLatLonObj.length > 0) {
                            var thisObj = {
                                obj_type: 'multiple',
                                allObjs: sameLatLonObj,
                            };
                            sameLatLonObjMajor.push(thisObj);
                            allPostsMajorObj.push(thisObj);
                        }
                    }
                }
            });

            jQuery.each(allPostsMajorObj, function (index, element) {

                if (element.obj_type == 'multiple') {

                    if (element.allObjs.length > 0) {
                        var post_lats = [];
                        var post_longs = [];
                        var post_ids = [];
                        var post_titles = [];
                        var post_links = [];
                        var post_imgs = [];
                        var post_prices = [];
                        var post_addresss = [];
                        var post_favourites = [];
                        var post_featureds = [];
                        var post_reviewss = [];
                        var post_members = [];
                        var post_markers = [];

                        for (var oi = 0; oi < element.allObjs.length; oi++) {
                            var thisElem = element.allObjs[oi];

                            post_lats.push(thisElem.lat);
                            post_longs.push(thisElem.long);
                            post_ids.push(thisElem.id);
                            post_titles.push(thisElem.title);
                            post_links.push(thisElem.link);
                            post_imgs.push(thisElem.img);
                            post_prices.push(thisElem.price);
                            post_addresss.push(thisElem.address);
                            post_favourites.push(thisElem.favourite);
                            post_featureds.push(thisElem.featured);
                            post_reviewss.push(thisElem.reviews);
                            post_members.push(thisElem.member);
                            post_markers.push(thisElem.marker);
                        }

                        var thisElemF = element.allObjs[0];

                        if (index === actual_length) {
                            return false;
                        }
                        var i = index;

                        var db_lat = parseFloat(thisElemF.lat);
                        var db_long = parseFloat(thisElemF.long);
                        var list_title = thisElemF.title;
                        var list_marker = thisElemF.marker;

                        var def_cords = {lat: db_lat, lng: db_long};
                        def_cords_obj.push(def_cords);

                        var def_coroeds = {list_title: list_title, list_marker: list_marker, element: thisElemF};
                        def_cords_creds.push(def_coroeds);

                        var db_latLng = new google.maps.LatLng(db_lat, db_long);

                        LatLngList.push(new google.maps.LatLng(db_lat, db_long));

                        var markerPointsLen = '' + element.allObjs.length;
                        marker = new google.maps.Marker({
                            position: db_latLng,
                            center: db_latLng,
                            map: map,
                            draggable: false,
                            icon: cluster_icon,
                            label: markerPointsLen,
                            post_lats: post_lats,
                            post_longs: post_longs,
                            post_ids: post_ids,
                            post_titles: post_titles,
                            post_links: post_links,
                            post_imgs: post_imgs,
                            post_prices: post_prices,
                            post_addresss: post_addresss,
                            post_favourites: post_favourites,
                            post_featureds: post_featureds,
                            post_reviewss: post_reviewss,
                            post_members: post_members,
                            post_markers: post_markers,
                        });

                        google.maps.event.addListener(marker, 'click', (function (marker, i) {
                            return function () {

                                var contentString = '';
                                for (var oi = 0; oi < marker.post_ids.length; oi++) {
                                    var infoElemObj = {
                                        lat: marker.post_lats[oi],
                                        long: marker.post_longs[oi],
                                        id: marker.post_ids[oi],
                                        title: marker.post_titles[oi],
                                        link: marker.post_links[oi],
                                        img: marker.post_imgs[oi],
                                        price: marker.post_prices[oi],
                                        address: marker.post_addresss[oi],
                                        favourite: marker.post_favourites[oi],
                                        featured: marker.post_featureds[oi],
                                        reviews: marker.post_reviewss[oi],
                                        member: marker.post_members[oi],
                                        marker: marker.post_markers[oi],
                                    };

                                    contentString += infoContentString(infoElemObj);
                                }

                                var infowindow = new InfoBox({
                                    boxClass: 'liting_map_info multi_properties',
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

                                map.panTo(marker.getPosition());
                                map.panBy(0, -150);
                                if (open_info_window)
                                    open_info_window.close();
                                infowindow.open(map, this);
                                open_info_window = infowindow;
                            }
                        })(marker, i));
                        all_marker.push(marker);
                        reset_top_map_marker.push(marker);

                    }
                } else {
                    if (index === actual_length) {
                        return false;
                    }
                    var i = index;
                    //alert(element.title);
                    //alert(element.marker);
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

                    google.maps.event.addListener(marker, 'click', (function (marker, i) {
                        return function () {

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

                            map.panTo(marker.getPosition());
                            map.panBy(0, -150);
                            if (open_info_window)
                                open_info_window.close();
                            infowindow.open(map, this);
                            open_info_window = infowindow;
                        }
                    })(marker, i));
                    all_marker.push(marker);
                    reset_top_map_marker.push(marker);
                }
            });

//            jQuery.each(db_cords, function (index, element) {
//
//                if (index === actual_length) {
//                    return false;
//                }
//                var i = index;
//                //alert(element.title);
//                //alert(element.marker);
//                var db_lat = parseFloat(element.lat);
//                var db_long = parseFloat(element.long);
//                var list_title = element.title;
//                var list_marker = element.marker;
//
//                var def_cords = {lat: db_lat, lng: db_long};
//                def_cords_obj.push(def_cords);
//
//                var def_coroeds = {list_title: list_title, list_marker: list_marker, element: element};
//                def_cords_creds.push(def_coroeds);
//
//                var db_latLng = new google.maps.LatLng(db_lat, db_long);
//
//                LatLngList.push(new google.maps.LatLng(db_lat, db_long));
//                marker = new google.maps.Marker({
//                    position: db_latLng,
//                    center: db_latLng,
//                    //animation: google.maps.Animation.DROP,
//                    map: map,
//                    draggable: false,
//                    icon: list_marker,
//                    title: list_title,
//                });
//
//                google.maps.event.addListener(marker, 'click', (function (marker, i) {
//                    return function () {
//
//                        var contentString = infoContentString(element);
//
//                        var infowindow = new InfoBox({
//                            boxClass: 'liting_map_info',
//                            content: contentString,
//                            disableAutoPan: true,
//                            maxWidth: 0,
//                            alignBottom: true,
//                            pixelOffset: new google.maps.Size(-108, -72),
//                            zIndex: null,
//                            closeBoxMargin: "2px",
//                            closeBoxURL: "close",
//                            infoBoxClearance: new google.maps.Size(1, 1),
//                            isHidden: false,
//                            pane: "floatPane",
//                            enableEventPropagation: false
//                        });
//
//                        map.panTo(marker.getPosition());
//                        map.panBy(0, -150);
//                        if (open_info_window)
//                            open_info_window.close();
//                        infowindow.open(map, this);
//                        open_info_window = infowindow;
//                    }
//                })(marker, i));
//                all_marker.push(marker);
//                reset_top_map_marker.push(marker);
//            });

            if (LatLngList.length > 0) {
                if (typeof polygonCoords === 'undefined' || polygonCoords == '') {
                    var latlngbounds = new google.maps.LatLngBounds();
                    for (var i = 0; i < LatLngList.length; i++) {
                        latlngbounds.extend(LatLngList[i]);
                    }
                    map.setCenter(latlngbounds.getCenter(), map.fitBounds(latlngbounds));

                    map.setZoom(map.getZoom());
                }

                var mapResizeTimes = 0;
                setTimeout(function () {
                    if (mapResizeTimes === 0) {
                        jQuery(".wp-rem-ontop-gmap").height(jQuery(window).height);
                        google.maps.event.trigger(map, "resize");
                    }
                    mapResizeTimes++;
                }, 500);
            }

            //clusters
            mapClusters();
            google.maps.event.addListener(map, "click", function (event) {
                if (open_info_window) {
                    open_info_window.close();
                }
            });
        }
        //

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
                    gridSize: 15,
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
            var list_featured = element.featured;
            var list_reviews = element.reviews;
            //var list_address = element.address;

            var img_html = '';
            if (list_img !== 'undefined' && list_img != '') {
                img_html = '<figure><a class="info-title" href="' + list_link + '">' + list_img + '</a><figcaption>' + list_favourite + '</figcaption></figure>';
            }

            var contentString = '\
            <div id="property-info-' + property_id + '" class="property-info-inner">\
                <div class="info-main-container">\
                    ' + img_html + '\
                    <div class="info-txt-holder">\
                        ' + list_featured + '\
                        ' + list_reviews + '\
                        <a class="info-title" href="' + list_link + '">' + list_title + '</a>\
                        ' + list_price + '\
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
                $('#wp-rem-top-map-holder .wp-rem-top-gmap-holder').find('.wp-rem-top-gmap-layer').remove();
                $('#wp-rem-top-map-holder').removeClass('drawing-area');
            }
        }

        // Sets the map on all markers in the array.
        function setMapOnAll(map) {
            if (all_marker) {
                for (var i = 0; i < all_marker.length; i++) {
                    all_marker[i].setMap(map);
                }
            }

            if (infoMarker) {
                for (var i = 0; i < infoMarker.length; i++) {
                    infoMarker[i].setMap(map);
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

            jQuery('#delete-button-' + map_id).hide();
            jQuery('#draw-map-' + map_id).attr('class', 'act-btn');
            jQuery('#draw-map-' + map_id).html('<i class="icon-pencil5"></i><span>' + wp_rem_top_gmap_strings.draw_area + '</span>');
            jQuery('#draw-map-' + map_id).show();
            jQuery('input[name="zoom_level"]').val('');
            var property_form = jQuery('form[id^="frm_property_arg"]');
            var data_vals = '&ajax_filter=true';
            var current_url = location.protocol + "//" + location.host + location.pathname + "?" + data_vals;//window.location.href;
            window.history.pushState(null, null, decodeURIComponent(current_url));
            property_form.find('input[name="loc_polygon_path"]').remove();
            property_form.find('input[name="location"]').val('');

            if (open_info_window) {
                open_info_window.close();
            }

            if (info_open_info_window) {
                info_open_info_window.close();
            }
            $('#wp-rem-top-map-holder .wp-rem-top-gmap-holder').find('.wp-rem-top-gmap-layer').remove();
            $('#wp-rem-top-map-holder').removeClass('drawing-area');
            wp_rem_top_serach_trigger();
        }

        function updateCurSelText() {
            // Clear all markers data.
            all_marker = [];

            infoMarker = [];

            if (typeof selectedShape.getPath == 'function') {

                var coords = selectedShape.getPath().getArray();
                var pathstr = '';
                var first = true;

                var lastLat = '';
                var lastLng = '';

                for (var i = 0; i < coords.length; i++) {
                    var obj = coords[i];
                    if (!first) {
                        pathstr += '||';
                    } else {
                        first = false;
                    }
                    pathstr += obj.lat() + ',' + obj.lng();

                    lastLat = obj.lat();
                    lastLng = obj.lng();
                }

                var last_latLng = new google.maps.LatLng(lastLat, lastLng);

                var lastMarker = new google.maps.Marker({
                    position: last_latLng,
                    center: last_latLng,
                    map: map,
                    draggable: false,
                    icon: wp_rem_top_gmap_strings.plugin_url + 'assets/frontend/images/info-marker.png',
                    title: '',
                });

                infoMarker.push(lastMarker);

                var lastContentStr = '\
                <div class="property-info-inner">\
                    <div class="info-main-container">\
                        <div class="info-txt-holder">\
                            <div class="property-alert-box property-alert-box-map">\
                                <div class="search-query-filters">\
                                    <a id="view-properties-' + map_id + '" href="javascript:void(0)" class="view-properties-btn" onclick="viewProperties(\'' + pathstr + '\')">' + wp_rem_top_gmap_strings.alert_view_prop + '</a>\
                            </div>\
                        </div>\
                    </div>\
                </div>';

                var lastInfoWin = new InfoBox({
                    boxClass: 'liting_map_info save_search_map_popup',
                    content: lastContentStr,
                    disableAutoPan: true,
                    maxWidth: 0,
                    alignBottom: true,
                    pixelOffset: new google.maps.Size(-108, 0),
                    zIndex: null,
                    closeBoxMargin: "2px",
                    closeBoxURL: "close",
                    infoBoxClearance: new google.maps.Size(1, 1),
                    isHidden: false,
                    pane: "floatPane",
                    enableEventPropagation: false
                });

                lastInfoWin.open(map, lastMarker);

                info_open_info_window = lastInfoWin;

                map.panTo(new google.maps.LatLng(lastLat, lastLng));
                map.panBy(0, -50);
                jQuery(".wp-rem-ontop-gmap").height(jQuery(window).height);
                google.maps.event.trigger(map, "resize");

                return false;
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
                $('#wp-rem-top-map-holder').find('.wp-rem-top-gmap-holder').append('<div class="wp-rem-top-gmap-layer"></div>');
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

        if (is_ajax != 'true') {
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

                jQuery('#draw-map-' + map_id).hide();
                jQuery('#cancel-button-' + map_id).hide();
                jQuery('#delete-button-' + map_id).show();

                $('#wp-rem-top-map-holder').removeClass('drawing-area');

            });

            google.maps.event.addListener(map, 'zoom_changed', function () {
                jQuery("input[name='zoom_level']").val(map.getZoom());
            });

            if (map_id != '') {
                
                // Cancel Drawing Mode
                google.maps.event.addDomListener(document.getElementById('cancel-button-' + map_id), 'click', function () {
                    
                    jQuery('#draw-map-' + map_id).show();
                    jQuery('#draw-map-' + map_id).attr('class', 'act-btn draw-pencil-btn');
                    jQuery('#delete-button-' + map_id).hide();
                    jQuery('#cancel-button-' + map_id).hide();

                    $('#wp-rem-top-map-holder').removeClass('drawing-area');
                    
                    drawingManager.setDrawingMode(null);

                    drawingManager.setOptions({
                        drawingControl: false
                    });
                });
                
                // Start Drawing Mode
                google.maps.event.addDomListener(document.getElementById('draw-map-' + map_id), 'click', function () {

                    var property_form = jQuery('form[id^="frm_property_arg"]');
                    var data_vals = '&ajax_filter=true';
                    var current_url = location.protocol + "//" + location.host + location.pathname + "?" + data_vals;//window.location.href;
                    window.history.pushState(null, null, decodeURIComponent(current_url));
                    property_form.find('input[name="loc_polygon"]').remove();
                    jQuery('#draw-map-' + map_id).attr('class', 'act-btn is-disabled');
                    //jQuery('#draw-map-' + map_id).html('<img src="' + _plugin_url + 'assets/frontend/images/draw_on.svg" alt="">');

                    // add drawing class on map holder
                    $('#wp-rem-top-map-holder').addClass('drawing-area');
                    //

                    if (open_info_window) {
                        open_info_window.close();
                    }
                    // end remove old selected result

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
                    jQuery('#delete-button-' + map_id).hide();
                    jQuery('#draw-map-' + map_id).hide();
                    jQuery('#cancel-button-' + map_id).show();
                });
            }

            // Clear the current selection when the drawing mode is changed, or when the
            // map is clicked.
            google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);

            google.maps.event.addDomListener(document.getElementById('delete-button-' + map_id), 'click', deleteSelectedShape);

            google.maps.event.addDomListener(document.getElementById('top-gmap-lock-btn'), 'click', function () {
                if (jQuery('#top-gmap-lock-btn').hasClass('map-loked')) {
                    map.setOptions({scrollwheel: true});
                    map.setOptions({draggable: true});
                    jQuery('#top-gmap-lock-btn').attr('class', 'top-gmap-lock-btn map-unloked').html('<i class="icon-lock_open"></i>');
                    jQuery('#top-gmap-lock-btn').attr('data-original-title', wp_rem_top_gmap_strings.map_locked);
                    return false;
                } else if (jQuery('#top-gmap-lock-btn').hasClass('map-unloked')) {
                    map.setOptions({scrollwheel: false});
                    map.setOptions({draggable: false});
                    jQuery('#top-gmap-lock-btn').attr('class', 'top-gmap-lock-btn map-loked').html('<i class="icon-lock_outline"></i>');
                    jQuery('#top-gmap-lock-btn').attr('data-original-title', wp_rem_top_gmap_strings.map_unlocked);
                    return false;
                }
            });
        }
        //
    }
}

function viewProperties(pathstr) {

    var this_loader = jQuery('.slide-loader');
    var property_form = jQuery('form[id^="frm_property_arg"]');
    var data_vals = property_form.serialize();
    data_vals = data_vals.replace(/[^&]+=\.?(?:&|$)/g, ''); // Remove extra and empty variables.

    this_loader.addClass('loading');

    data_vals += '&loc_polygon_path=' + pathstr + '&ajax_filter=true';
    var current_url = location.protocol + "//" + location.host + location.pathname + "?" + data_vals; // window.location.href;
    window.history.pushState(null, null, decodeURIComponent(current_url));
    property_form.find('input[name="loc_polygon_path"]').remove();
    property_form.find('input[name="location"]').val('Drawn Area');
    property_form.append('<input type="hidden" name="loc_polygon_path" value="' + pathstr + '">');

    wp_rem_top_serach_trigger();

    if (infoMarker) {
        for (var i = 0; i < infoMarker.length; i++) {
            infoMarker[i].setMap(null);
        }
    }

    if (info_open_info_window) {
        info_open_info_window.close();
    }
    $('#wp-rem-top-map-holder .wp-rem-top-gmap-holder').find('.wp-rem-top-gmap-layer').remove();
    $('#wp-rem-top-map-holder').removeClass('drawing-area');

    return;
}

jQuery(".wp-rem-ontop-gmap").css("pointer-events", "none");

var onTopMapMouseleaveHandler = function (event) {
    if (!($('#wp-rem-top-map-holder').hasClass('drawing-area'))) {
        var that = jQuery(this);

        that.on('click', onTopMapClickHandler);
        that.off('mouseleave', onTopMapMouseleaveHandler);
        jQuery(".wp-rem-ontop-gmap").css("pointer-events", "none");
    }
}

var onTopMapClickHandler = function (event) {
    var that = jQuery(this);
    // Disable the click handler until the user leaves the map area
    that.off('click', onTopMapClickHandler);

    // Enable scrolling zoom
    that.find('.wp-rem-ontop-gmap').css("pointer-events", "auto");

    // Handle the mouse leave event
    that.on('mouseleave', onTopMapMouseleaveHandler);
}
jQuery(document).on('click', '.wp-rem-top-map-holder', onTopMapClickHandler);