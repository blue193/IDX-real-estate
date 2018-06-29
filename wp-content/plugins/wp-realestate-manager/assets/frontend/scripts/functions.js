/**  jquery document.ready functions */
var $ = jQuery;
var ajaxRequest;

jQuery(document).ready(function($) {
    
    /*Video Play Button*/

    function FluidIframeWidth() {
        "use strict";
        $("#play-video").click(function(event) {
            event.preventDefault();
            $(".video-fit-holder .img-holder .play-btn").parent().css({
                opacity: "0",
                visibility: "hidden",
                "z-index": "-1",
                position: "absolute"
            });
            var video = '<iframe frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen src="' + $(this).attr("data-video") + '"></iframe>';
            $(".video-fit-holder iframe").replaceWith(video);
        });
    }
    FluidIframeWidth();
});

jQuery(document).ready(function($) {
    if($(".property-medium.modern").length > 0){
         var imageUrlFind = $(".property-medium.modern .img-holder").css("background-image").match(/url\(["']?([^()]*)["']?\)/).pop();
         if(imageUrlFind){
            $(".property-medium.modern .img-holder").addClass("image-loaded");
         }
    }
    if ($(".top-locations, .property-medium.modern").length > 0) {
        $(".top-locations ul li .image-holder").matchHeight();
        $(".property-medium.modern").matchHeight();
    }

    if($(".property-grid").hasClass("modern")==false){
        if ($(".property-grid, .blog.blog-grid .blog-post, .member-grid .post-inner-member").length > 0) {
            $(".blog.blog-grid .blog-post").matchHeight();
            $(".member-grid .post-inner-member").matchHeight();
            $(".property-grid").matchHeight();
            $('.property-grid.default').matchHeight({ remove: true });
            $(".property-grid.default .text-holder").matchHeight();
        }
    }else{
        $(".property-grid.modern .text-holder").matchHeight();
    }
    
        if ($(".real-estate-property.masnory").length > 0) {
            $(".property-grid").matchHeight({ remove: true });
        } 

    function Member_info_height() {
        if ($(".member-grid .member-info").length > 0) {
            $(".member-grid .member-info").matchHeight();
        }
    }
    Member_info_height();
    $(window).resize(function() {
        Member_info_height();
    });

    function grid_modern_post_title() {
        if ($(".property-grid.modern .post-title, .property-grid.modern .price-holder").length > 0) {
            $(".property-grid.modern .post-title").matchHeight();
            $(".property-grid.modern .price-holder").matchHeight();
        }
    }
    grid_modern_post_title();
    $(window).resize(function() {
        grid_modern_post_title();
    });
    
    // add class when image loaded
    $(".property-medium .img-holder img, .property-grid .img-holder img").one("load", function() {
        $(this).parents(".img-holder").addClass("image-loaded");
    }).each(function() {
        if (this.complete) $(this).load();
    });

    /*                          
     * Load Dashboard Tabs  
     */
    jQuery(document).on("click", ".user_dashboard_ajax", function() {
        "use strict";
        var actionString = jQuery(this).attr("id");
        if (typeof actionString === "undefined") {
            actionString = jQuery(this).attr("data-id");
        }
        var pageNum = jQuery(this).attr("data-pagenum");
        var filter_parameters = "";
        if (typeof pageNum !== "undefined") {
            filter_parameters = wp_rem_get_filter_parameters();
        } else {
            filter_parameters = "";
        }

        var page_qry_append = "";
        if (typeof pageNum === "undefined") {
            if (typeof page_id_all !== "undefined" && page_id_all > 1) {
                pageNum = page_id_all;
                page_qry_append = "&page_id_all=" + page_id_all;
                page_id_all = 0;
            }
        }

        if (typeof pageNum === "undefined" || pageNum == "") {
            pageNum = "1";
        }
        var actionClass = jQuery(this).attr("class");
        var query_var = jQuery(this).data("queryvar");
        if (history.pushState) {
            if (query_var != undefined) {
                if (query_var != "") {
                    var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + "?" + query_var + page_qry_append;
                } else {
                    var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                }
                window.history.pushState({
                    path: newurl
                }, "", newurl);
            }
        }

        jQuery(".user_dashboard_ajax").removeClass("active");
        jQuery(".orders-inquiries").removeClass("active");
        wp_rem_show_loader(".loader-holder");
        jQuery("#" + actionString + "." + actionClass).addClass("active");
        if (actionString == "wp_rem_member_received_orders" || actionString == "wp_rem_member_received_inquiries") {
            jQuery(".dashboard-nav .orders-inquiries").addClass("active");
            jQuery(".dashboard-nav .orders-inquiries #" + actionString + "." + actionClass).addClass("active");
        } else if (actionString == "wp_rem_member_orders" || actionString == "wp_rem_member_inquiries") {
            jQuery(".dashboard-nav .orders-inquiries").addClass("active");
        }

        if (typeof ajaxRequest != "undefined") {
            ajaxRequest.abort();
        }

        ajaxRequest = jQuery.ajax({
            type: "POST",
            url: wp_rem_globals.ajax_url,
            data: "page_id_all=" + pageNum + "&action=" + actionString + filter_parameters,
            success: function(response) {
                wp_rem_hide_loader();
                var timesRun = 0;
                setInterval(function() {
                    timesRun++;
                    if (timesRun === 1) {
                        if (jQuery(document).find("#cropContainerModal").attr("data-img-type") == "default") {
                            jQuery("#cropContainerModal .cropControls").hide();
                        }
                    }
                }, 50);
                jQuery(".user-holder").html(response);
            }
        });
    });

    /*
     * Saving Member Data
     */
    jQuery(document).on("click", "#company_profile_form", function() {
        "use strict";
        wp_rem_show_loader();
        var serializedValues = jQuery("#member_company_profile").serialize();
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: wp_rem_globals.ajax_url,
            data: serializedValues + "&action=wp_rem_save_company_data",
            success: function(response) {
                wp_rem_show_response(response);
            }
        });
    });
    if (jQuery(".wp_rem_editor").length != "") {
        jQuery(".wp_rem_editor").jqte();
    }
});

function wp_rem_post_likes_count(admin_url, id, views, obj) {
    "use strict";
    var dataString = "post_id=" + id + "&action=wp_rem_post_likes_count" + "&view=" + views;
    jQuery(obj).html(jQuery(obj).attr("data-loader"));
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function(response) {
            if (response != "error") {
                jQuery(obj).removeAttr("onclick");
                jQuery(obj).parent().addClass(jQuery(obj).attr("data-likedclass"));
                jQuery(obj).html(jQuery(obj).attr("data-aftersuccess") + " " + response);
            } else {
                jQuery(obj).html(" There is an error.");
            }
        }
    });
    return false;
}

/*
 * register pop up
 */

jQuery(document).on("click", ".no-logged-in", function() {
    $("#join-us").modal();
});

function wp_rem_load_location_ajax(postfix, allowed_location_types, location_levels, security) {
    //"use strict";
    var $ = jQuery;
    $("#loc_country_" + postfix).change(function() {
        popuplate_data(this, "country");
    });
    
    $("#loc_state_" + postfix).change(function() {
        popuplate_data(this, "state");
    });

    $("#loc_city_" + postfix).change(function() {
        popuplate_data(this, "city");
    });

    $("#loc_town_" + postfix).change(function() {
        popuplate_data(this, "town");
    });

    function popuplate_data(elem, type) {
        "use strict";
        var plugin_url = $(elem).parents("#locations_wrap").data("plugin_url");
        var ajaxurl = $(elem).parents("#locations_wrap").data("ajaxurl");
        var index = allowed_location_types.indexOf(type);
        if (index + 1 >= allowed_location_types.length) {
            return;
        }
        var location_type = allowed_location_types[index + 1];
        $(".loader-" + location_type + "-" + postfix).html("<img src='" + plugin_url + "/assets/frontend/images/ajax-loader.gif' />").show();
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                action: "get_locations_list",
                security: security,
                location_type: location_type,
                location_level: location_levels[location_type],
                selector: elem.value
            },
            dataType: "json",
            success: function(response) {
                if (response.error == true) {
                    return;
                }
                if (typeof response.loc_coords !== "undefined" && response.loc_coords != "" && $("#wp_rem__loc_bounds_rest").length !== 0) {
                    $("#wp_rem__loc_bounds_rest").val(response.loc_coords);
                    var polygonCoords = jQuery("#wp_rem__loc_bounds_rest").val();
                    if (typeof polygonCoords !== "undefined" && polygonCoords != "") {
                        var _this_map = new google.maps.Map($("#cs-map-location-fe-id").get(0), {
                            center: {
                                lat: 40.714224,
                                lng: -73.961452
                            },
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            mapTypeControl: false,
                            disableDoubleClickZoom: true,
                            zoomControlOptions: true,
                            streetViewControl: false,
                            zoom: 8
                        });
                        
                        var LatLngList = [];
                        var polygonCoordsJson = jQuery.parseJSON(polygonCoords);
                        if (polygonCoordsJson.length > 0) {
                            jQuery.each(polygonCoordsJson, function(index, element) {
                                LatLngList.push(new google.maps.LatLng(element.lat, element.lng));
                            });
                        }
                        var draw_color = "#333333";
                        var prePolygon = new google.maps.Polygon({
                            paths: polygonCoordsJson,
                            strokeWeight: 0,
                            fillOpacity: .25,
                            fillColor: draw_color,
                            strokeColor: draw_color,
                            editable: false
                        });
                        
                        prePolygon.setMap(_this_map);
                        if (LatLngList.length > 0) {
                            var latlngbounds = new google.maps.LatLngBounds();
                            for (var i = 0; i < LatLngList.length; i++) {
                                latlngbounds.extend(LatLngList[i]);
                            }
                            _this_map.setCenter(latlngbounds.getCenter(), _this_map.fitBounds(latlngbounds));
                            _this_map.setZoom(_this_map.getZoom());
                            var marker = new google.maps.Marker({
                                position: latlngbounds.getCenter(),
                                center: latlngbounds.getCenter(),
                                map: _this_map,
                                draggable: true
                            });
                            var newLat = marker.getPosition().lat();
                            var newLng = marker.getPosition().lng();
                            document.getElementById("wp_rem_post_loc_latitude").value = newLat;
                            document.getElementById("wp_rem_post_loc_longitude").value = newLng;
                        }

                        marker.addListener("dragend", function() {
                            var newLat = marker.getPosition().lat();
                            var newLng = marker.getPosition().lng();
                            var polygon_area = new google.maps.Polygon({
                                paths: polygonCoordsJson
                            });
                            var nResultCord = google.maps.geometry.poly.containsLocation(new google.maps.LatLng(newLat, newLng), polygon_area) ? "true" : "false";
                            if (nResultCord == "false") {
                                alert("Warning! This address is out of the selected location boundries.");
                                return false;
                            } else {
                                document.getElementById("wp_rem_post_loc_latitude").value = newLat;
                                document.getElementById("wp_rem_post_loc_longitude").value = newLng;
                            }
                        });
                    }
                } else {
                    $("#wp_rem__loc_bounds_rest").val("");
                    var thisLatLng = new google.maps.LatLng(51.4, -.2);
                    var _this_map = new google.maps.Map($("#cs-map-location-fe-id").get(0), {
                        center: thisLatLng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        mapTypeControl: false,
                        disableDoubleClickZoom: true,
                        zoomControlOptions: true,
                        streetViewControl: false,
                        zoom: 9
                    });
                    var marker = new google.maps.Marker({
                        position: thisLatLng,
                        center: thisLatLng,
                        map: _this_map,
                        draggable: true
                    });
                    var newLat = marker.getPosition().lat();
                    var newLng = marker.getPosition().lng();
                    document.getElementById("wp_rem_post_loc_latitude").value = newLat;
                    document.getElementById("wp_rem_post_loc_longitude").value = newLng;
                    marker.addListener("dragend", function() {
                        var newLat = marker.getPosition().lat();
                        var newLng = marker.getPosition().lng();
                        document.getElementById("wp_rem_post_loc_latitude").value = newLat;
                        document.getElementById("wp_rem_post_loc_longitude").value = newLng;
                    });
                }
                var control_selector = "#loc_" + location_type + "_" + postfix;
                var data = response.data;
                $(control_selector + " option").remove();
                $(control_selector).append($("<option></option>").attr("value", "").text("Choose..."));
                $.each(data, function(key, term) {
                    $(control_selector).append($("<option></option>").attr("value", term.slug).text(term.name));
                });
                $(".loader-" + location_type + "-" + postfix).html("").hide();
                // Only for style implementation.
                $(".chosen-select").data("placeholder", "Select").trigger("chosen:updated");
            }
        });
    }

    jQuery(document).ready(function(e) {
        "use strict";
        jQuery("input#wp-rem-search-location").keypress(function(e) {
            if (e.which == "13") {
                e.preventDefault();
                cs_search_map(this.value);
                return false;
            }
        });
        jQuery("#loc_country_property").change(function(e) {
            setAutocompleteCountry("property");
        });
        jQuery("#loc_country_member").change(function(e) {
            setAutocompleteCountry("member");
        });
        jQuery("#loc_country_default").change(function(e) {
            setAutocompleteCountry("default");
        });
    });

    function setAutocompleteCountry(type) {
        "use strict";
        var country = jQuery("select#loc_country_" + type + " option:selected").attr("data-name");
        if (country != "") {
            autocomplete.setComponentRestrictions({
                country: country
            });
        } else {
            autocomplete.setComponentRestrictions([]);
        }
    }
}

/* range slider */

jQuery(document).ready(function() {
    jQuery(".cs-drag-slider").each(function(index) {
        "use strict";
        if (jQuery(this).attr("data-slider-step") != "") {
            var data_min_max = jQuery(this).attr("data-min-max");
            var val_parameter = [parseInt(jQuery(this).attr("data-slider-min")), parseInt(jQuery(this).attr("data-slider-max"))];
            if (data_min_max != "yes") {
                var val_parameter = parseInt(jQuery(this).attr("data-slider-min"));
            }
            jQuery(this).children("input").slider({
                min: parseInt(jQuery(this).attr("data-slider-min")),
                max: parseInt(jQuery(this).attr("data-slider-max")),
                value: val_parameter,
                focus: true
            });
        }
    });

    /*Featured Slider Start*/

    if ("" != jQuery(".featured-slider .swiper-container").length) {
        new Swiper(".featured-slider .swiper-container", {
            nextButton: ".swiper-button-next",
            prevButton: ".swiper-button-prev",
            paginationClickable: true,
            slidesPerView: 1,
            slidesPerColumn: 1,
            grabCursor: !0,
            loop: !0,
            spaceBetween: 30,
            arrow: false,
            pagination: ".swiper-pagination",
            breakpoints: {
                    1024: {
                            slidesPerView: 1
                    },
            }
        })
    }

});

jQuery(document).on("click", "a.wp-rem-dev-property-delete", function() {
    "use strict";
    jQuery("#id_confrmdiv").show();
    var deleting_property, _this_ = jQuery(this),
        _this_id = jQuery(this).data("id"),
        ajax_url = jQuery("#wp-rem-dev-user-property").data("ajax-url"),
        this_parent = jQuery("#user-property-" + _this_id);
    _this_.html('<i class="icon-spinner"></i>');
    jQuery("#id_truebtn").click(function() {
        jQuery("#id_confrmdiv").hide();
        deleting_property = jQuery.ajax({
            url: ajax_url,
            method: "POST",
            data: {
                property_id: _this_id,
                action: "wp_rem_member_property_delete"
            },
            dataType: "json"
        }).done(function(response) {
            if (typeof response.delete !== "undefined" && response.delete == "true") {
                this_parent.hide("slow");
            }
            _this_.html('<i class="icon-close2"></i>');
        }).fail(function() {
            _this_.html('<i class="icon-close2"></i>');
        });
    });

    jQuery("#id_falsebtn").click(function() {
        _this_.html('<i class="icon-close2"></i>');
        jQuery("#id_confrmdiv").hide();
        return false;
    });

});

/**
 * show alert message
 */

function show_alert_msg(msg) {
    "use strict";
    jQuery("#member-dashboard .main-cs-loader").html("");
    jQuery(".cs_alerts").html('<div class="cs-remove-msg"><i class="icon-check-circle"></i>' + msg + "</div>");
    var classes = jQuery(".cs_alerts").attr("class");
    classes = classes + " active";
    jQuery(".cs_alerts").addClass(classes);
    setTimeout(function() {
        jQuery(".cs_alerts").removeClass("active");
    }, 4e3);
}

/*HTML Functions Start*/

jQuery(document).ready(function() {

    /*
     * detail page nav property feature toggler
    */

    $(".detail-nav-toggler").click(function() {
        $(this).next(".detail-nav").slideToggle().toggleClass("open");
    });

    /*Detail Nav Sticky*/

    function stickyDetailNavBar() {
        "use strict";
        var $window = $(window);
        if ($window.width() > 980) {
            if ($(".detail-nav").length) {
                var el = $(".detail-nav");
                var stickyTop = $(".detail-nav").offset().top;
                var stickyHeight = $(".detail-nav").height();
                var AdminBarHeight_ = $("#wpadminbar").height();
                if ($("#wpadminbar").length > 0) {
                    stickyTop = stickyTop - AdminBarHeight_;
                }
                $(window).scroll(function() {
                    var windowTop = $(window).scrollTop();
                    if (stickyTop < windowTop) {
                        el.css({
                            position: "fixed",
                            width: "100%",
                            "z-index": "996",
                            top: "0"
                        });
                        $(".detail-nav").css("margin-top", AdminBarHeight_);
                        $(".property-detail").css("padding-top", stickyHeight);
                    } else {
                        el.css({
                            position: "relative",
                            width: "100%",
                            "z-index": "996",
                            top: "auto"
                        });
                        $(".detail-nav").css("margin-top", "0");
                        $(".property-detail").css("padding-top", "0");
                    }
                });
            }
        }
    }

    stickyDetailNavBar();

    $(window).resize(function() {

        stickyDetailNavBar();

    });

    /*Scroll Nav and Active li Start*/

    if (jQuery(".detail-nav-map").length != "") {
        var wpadminbarHeight = 0;
        if ($("#wpadminbar").length) {
            wpadminbarHeight = $("#wpadminbar").height();
        }
        var lastId, topMenu = $(".detail-nav-map"),
            topMenuHeight = topMenu.outerHeight() + 15 + wpadminbarHeight,
            menuItems = topMenu.find("ul li a"),
            scrollItems = menuItems.map(function() {
                var item = $($(this).attr("href"));
                if (item.length) {
                    return item;
                }
            });

        menuItems.click(function(e) {
            var href = $(this).attr("href"),
                offsetTop = href === "#" ? 0 : $(href).offset().top - topMenuHeight + 1;
            $("html, body").stop().animate({
                scrollTop: offsetTop
            }, 650);
            e.preventDefault();
        });

        $(window).scroll(function() {
            var fromTop = $(this).scrollTop() + topMenuHeight;
            var cur = scrollItems.map(function() {
                if ($(this).offset().top < fromTop) return this;
            });
            cur = cur[cur.length - 1];
            var id = cur && cur.length ? cur[0].id : "";
            if (lastId !== id) {
                lastId = id;
                menuItems.parent().removeClass("active").end().filter("[href='#" + id + "']").parent().addClass("active");
            }
        });
    }

    /*Detail Nav Sticky*/

    /*Modal Backdrop Start*/

    jQuery(".main-search .search-popup-btn").click(function() {
        setTimeout(function() {
            jQuery(".modal-backdrop").appendTo(".main-search.fancy");
        }, 4);
    });

    /*               
     * property banner slider start
     */

    if (jQuery(".banner .property-banner-slider .swiper-container").length != "") {
       var mySwiper = new Swiper(".banner .property-banner-slider .swiper-container", {
            pagination: ".swiper-pagination",
            paginationClickable: true,
            loop: false,
            grabCursor: true,
            nextButton: ".banner .property-banner-slider .swiper-button-next",
            prevButton: ".banner .property-banner-slider .swiper-button-prev",
            spaceBetween: 30,
            autoplay: 3e3,
            effect: "fade",
            onInit: function(swiper) {
               stickyDetailNavBar();
            }
        });
    }

    /*Range Slider Start*/
    if (jQuery("#ex2,#ex3,#ex4,#ex5").length != "") {
        $("#ex2,#ex3,#ex4,#ex5").bootstrapSlider();

        $("#ex2,#ex3,#ex4,#ex5").on("slide", function(slideEvt) {

            var valueChange = $(this).parent().find(".slider-value");

            $(valueChange).text(slideEvt.value);

        });
    }

    /*Range Slider End*/

    /* Property Slider Start */

    if (jQuery(".swiper-container.property-slider").length != "") {

        var swiper = new Swiper(".swiper-container.property-slider", {
            loop: true,
            autoplay: 3500,
            nextButton: ".property-slider .swiper-button-next",
            prevButton: ".property-slider .swiper-button-prev",
            pagination: ".property-slider .swiper-pagination",
            paginationClickable: true,
            slidesPerView: 4,
            breakpoints: {
                1024: {
                    slidesPerView: 3
                },
                768: {
                    slidesPerView: 3
                },
                700: {
                    slidesPerView: 2
                },
                480: {
                    slidesPerView: 1
                }
            }

        });

    }

    /*Main Categories List Show Hide*/

    if (jQuery(".categories-holder .text-holder ul").length != "" && jQuery(".categories-holder .text-holder ul").data("showmore") == "yes") {
        jQuery(".categories-holder .text-holder ul").each(function() {
            var $ul = $(this),
                $lis = $ul.find("li:gt(3)"),
                isExpanded = $ul.hasClass("expanded");
            $lis[isExpanded ? "show" : "hide"]();
            if ($lis.length > 0) {
                $ul.append($('<li class="expand">' + (isExpanded ? "Less" : "view More") + "</li>").click(function(event) {
                    var isExpanded = $ul.hasClass("expanded");
                    event.preventDefault();
                    $(this).text(isExpanded ? "view More" : "Less");
                    $ul.toggleClass("expanded");
                    $lis.toggle(350);
                }));
            }
        });
    }

    /*Modal Tab Link Start*/

    if (jQuery(".login-popup-btn").length != "") {
        jQuery(".login-popup-btn").click(function(e) {
            jQuery(".cs-login-switch").click();
            var tab = e.target.hash;
            var data_id = jQuery(this).data("id");
            jQuery(".tab-content .popupdiv" + data_id).removeClass("in active");
            jQuery('a[href="' + tab + '"]').tab("show");
            jQuery(tab).addClass("in active");
        });
    }

    /*Modal Tab Link End*/

    $(document).on("click", ".reviews-sortby li.reviews-sortby-active", function() {
        setTimeout(function() {
            jQuery("#reviews-overlay").remove();
        }, 4);
    });

    jQuery(".reviews-sortby > li").on("click", function() {
        jQuery("#reviews-overlay").remove();
        setTimeout(function() {
            jQuery(".reviews-sortby > li").toggleClass("reviews-sortby-active");
        }, 3);
        jQuery(".reviews-sortby > li").siblings();
        jQuery(".reviews-sortby > li").siblings().removeClass("reviews-sortby-active");
        jQuery("body").append("<div id='reviews-overlay' class='reviews-overlay'></div>");
    });

    jQuery(".input-reviews > .radio-field label").on("click", function() {
        jQuery(this).parent().toggleClass("active");
        jQuery(this).parent().siblings();
        jQuery(this).parent().siblings().removeClass("active");
        /*replace inner Html*/
        var radio_field_active = jQuery(this).html();
        jQuery(".active-sort").html(radio_field_active);
        jQuery(".reviews-sortby > li").removeClass("reviews-sortby-active");
        setTimeout(function() {
            jQuery("#reviews-overlay").remove();
        }, 400);
    });

    $(document).on("click", "#reviews-overlay", function() {
        "use strict";
        jQuery(this).closest(".reviews-overlay").remove();
        jQuery(".reviews-sortby > li").removeClass("reviews-sortby-active");
    });

    jQuery(document).on("click", ".team-option .send-invitation", function(e) {
        e.preventDefault();
        jQuery(".invited_team_member").addClass("active");
        jQuery("body").append('<div id="overlay" style="display:none"></div>');
        jQuery("#overlay").fadeIn(300);
    });

    jQuery(document).on("click", ".user-profile .invited_team_member .cancel", function(e) {
        e.preventDefault();
        jQuery(".invited_team_member").removeClass("active");
        jQuery("#overlay").fadeOut(300);
        setTimeout(function() {
            jQuery("#overlay").remove();
        }, 400);
    });

    $(document).on("click", "#overlay", function() {
        $(this).closest("#overlay").remove();
        $(".invite-member").removeClass("active");
    });

    /* Spinner Btn Start*/

    $(".spinner .btn:last-of-type").on("click", function() {
        $(".spinner input").val(parseInt($(".spinner input").val(), 10) + 1);
    });

    $(".spinner .btn:first-of-type").on("click", function() {
        var val = parseInt($(".spinner input").val(), 10);
        if (val < 1) {
            return;
        }
        $(".spinner input").val(val - 1);
    });

    $(".spinner2 .btn:last-of-type").on("click", function() {
        $(".spinner2 input").val(parseInt($(".spinner2 input").val(), 10) + 1);
    });

    $(".spinner2 .btn:first-of-type").on("click", function() {
        $(".spinner2 input").val(parseInt($(".spinner2 input").val(), 10) - 1);
    });

    $(".spinner3 .btn:last-of-type").on("click", function() {
        $(".spinner3 input").val(parseInt($(".spinner3 input").val(), 10) + 1);
    });

    $(".spinner3 .btn:first-of-type").on("click", function() {
        $(".spinner3 input").val(parseInt($(".spinner3 input").val(), 10) - 1);
    });

    /* Spinner Btn End*/

    /* locations dropdown */

    $(".main-location > ul > li.location-has-children > a").on("click", function(e) {
        e.preventDefault();
        $(this).parent().toggleClass("menu-open");
        $(this).parent().siblings().removeClass("menu-open");
        setTimeout(function() {
            $(".main-location > ul > li.location-has-children > a").addClass("open-overlay");
        }, 2);
        $("body").append("<div class='location-overlay'></div>");
        $(".main-location > ul > li > ul").append("<i class='icon-cross close-menu-location'></i>");
    });

    $(document).on("click", ".main-location > ul > li.location-has-children > a.open-overlay", function() {
        $(".location-overlay").remove();
        $(".close-menu-location").remove();
        setTimeout(function() {
            $(".main-location > ul > li.location-has-children > a").removeClass("open-overlay");
        }, 2);
    });

    $(document).on("click", ".location-overlay", function() {
        $(this).closest(".location-overlay").remove();
        $(".close-menu-location").remove();
        $(".main-location > ul > li.location-has-children").removeClass("menu-open");
        $(".main-location > ul > li.location-has-children > a").removeClass("open-overlay");
    });

    $(document).on("click", ".close-menu-location", function() {
        $(this).closest(".close-menu-location").remove();
        $(".location-overlay").remove();
        $(".main-location > ul > li.location-has-children").removeClass("menu-open");
        $(".main-location > ul > li.location-has-children > a").removeClass("open-overlay");
    });

    /*Location Menu Function End*/

    /*Location Menu Function Start*/

    jQuery(".user-dashboard-menu > ul > li.user-dashboard-menu-children > a").on("click", function(e) {
        e.preventDefault();
        jQuery(this).parent().toggleClass("menu-open");
        jQuery(this).parent().siblings().removeClass("menu-open");
        setTimeout(function() {
            jQuery(".user-dashboard-menu > ul > li.user-dashboard-menu-children > a").addClass("open-overlay");
        }, 2);
        jQuery(".main-header .login-option,.main-header .login-area").append("<div class='location-overlay'></div>");
        jQuery(".user-dashboard-menu > ul > li > ul").append("<i class='icon-cross close-menu-location'></i>");
    });

    jQuery(document).on("click", ".user-dashboard-menu > ul > li.user-dashboard-menu-children > a.open-overlay", function() {
        jQuery(".location-overlay").remove();
        jQuery(".close-menu-location").remove();
        setTimeout(function() {
            jQuery(".user-dashboard-menu > ul > li.user-dashboard-menu-children > a").removeClass("open-overlay");
        }, 2);
    });

    $(".main-header .user-dashboard-menu li.user-dashboard-menu-children ul").bind("clickoutside", function(event) {
        $(this).hide();
    });

    jQuery(document).on("click", ".location-overlay", function() {
        "use strict";
        jQuery(this).closest(".location-overlay").remove();
        jQuery(".close-menu-location").remove();
        jQuery(".user-dashboard-menu > ul > li.user-dashboard-menu-children").removeClass("menu-open");
        jQuery(".user-dashboard-menu > ul > li.user-dashboard-menu-children > a").removeClass("open-overlay");
    });

    jQuery(document).on("click", ".close-menu-location", function() {
        jQuery(this).closest(".close-menu-location").remove();
        jQuery(".location-overlay").remove();
        jQuery(".user-dashboard-menu > ul > li.user-dashboard-menu-children").removeClass("menu-open");
        jQuery(".user-dashboard-menu > ul > li.user-dashboard-menu-children > a").removeClass("open-overlay");
    });

    /*Location Menu Function End*/

    /*Range Slider Start*/

    if (jQuery("#ex6").length != "") {
        $("#ex6").slider();
        $("#ex6").on("slide", function(slideEvt) {
            $("#ex6SliderVal").text(slideEvt.value);
        });
    }

    if (jQuery("#ex7").length != "") {
        $("#ex7").slider();
        $("#ex7").on("slide", function(slideEvt) {
            $("#ex7SliderVal").text(slideEvt.value);
        });
    }

    if (jQuery("#ex16b").length != "") {
        $("#ex16b").slider({
            min: 0,
            max: 4e3,
            value: [0, 4e3],
            focus: true
        });
    }

    /*Range Slider End*/

    /*cs-calendar-combo input Start*/

    jQuery(document).ready(function() {
        if (jQuery(".cs-calendar-from input").length != "") {
            jQuery(".cs-calendar-from input").datetimepicker({
                minDate: new Date(),
                timepicker: false,
                format: "Y/m/d",
            });
        }

        if (jQuery(".cs-calendar-to input").length != "") {
            jQuery(".cs-calendar-to input").datetimepicker({
                minDate: new Date(),
                timepicker: false,
                format: "Y/m/d",
            });
        }
    });

    /*prettyPhoto Start*/

    if (jQuery(".photo-gallery.gallery").length != "") {
        jQuery("area[rel^='prettyPhoto']").prettyPhoto();
        jQuery(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({
            animation_speed: "normal",
            theme: "light_square",
            slideshow: 5e3,
            deeplinking: true,
            autoplay_slideshow: true
        });

        jQuery(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({
            animation_speed: "fast",
            slideshow: 5e4,
            deeplinking: false,
            hideflash: true
        });

        jQuery("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
            custom_markup: '<div id="map_canvas"></div>',
            changepicturecallback: function() {
                initialize();
            }
        });

        jQuery("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
            custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
            changepicturecallback: function() {
                _bsap.exec();
            }
        });
    }

    /*prettyPhoto End*/

    /* Gallery Counter Start*/

    if (jQuery(".photo-gallery .gallery-counter li").length != "") {
        count = jQuery(".photo-gallery .gallery-counter li").size();
        if (count > 7) {
            jQuery(".photo-gallery .gallery-counter  li:gt(6) .img-holder figure").append("<figcaption><span></span></figcaption>");
            jQuery(".photo-gallery .gallery-counter  li figure figcaption span").append('<em class="counter"></em>');
            jQuery(".photo-gallery .gallery-counter  li figure figcaption span .counter").html("<i class='icon-plus'></i>" + count);
        } else {
            jQuery('<em class="counter"></em>').remove();
        }
        jQuery(".photo-gallery .gallery-counter  li:gt(7)").hide();
    }
    
//    if (jQuery(".responsive-calendar").length != "") {
//        jQuery(".responsive-calendar").responsiveCalendar({
//            time: "2017-03",
//            monthChangeAnimation: false,
//            events: {
//                "2017-03-06": {
//                    number: 5,
//                    url: "https://themeforest.net/user/chimpstudio/portfolio"
//                }
//            }
//        });
//    }
    
});


/*
 * Confusion Block
 */

jQuery(document).on("click", ".icon-circle-with-cross", function() {
    "use strict";
    jQuery(this).parents("li").remove();
    var attachment_id = jQuery(this).attr("data-attachment_id");
    var all_attachments = jQuery("#wp_rem_member_gallery_attathcments").val();
    var new_attachemnts = all_attachments.replace(attachment_id, "");
    jQuery("#wp_rem_member_gallery_attathcments").val(new_attachemnts);
});

var size_li = jQuery("#collapseseven .cs-checkbox-list li").size();
x = 5;
jQuery("#collapseseven .cs-checkbox-list li:lt(" + x + ")").show(200);

jQuery(document).on("click", ".reset-results", function() {
    "use strict";
    jQuery(".search-results").fadeOut(200);
});

jQuery(document).on("click", "#pop-close1", function() {
    "use strict";
    jQuery("#popup1").addClass("popup-open");
});

jQuery(document).on("click", "#close1", function() {
    "use strict";
    jQuery("#popup1").removeClass("popup-open");
});

jQuery(document).on("click", "#pop-close", function() {
    "use strict";
    jQuery("#popup").addClass("popup-open");
});

jQuery(document).on("click", "#close", function() {
    "use strict";
    jQuery("#popup").removeClass("popup-open");
});

if (jQuery(".selectpicker").length != "") {
    jQuery(".selectpicker").selectpicker({
        size: 5
    });
}

jQuery(".closeall").click(function() {
    jQuery(".openall").addClass("show");
    jQuery(".filters-options .panel-collapse.in").collapse("hide");
});

jQuery(".openall").click(function() {
    jQuery(".openall").removeClass("show");
    jQuery('.filters-options .panel-collapse:not(".in")').collapse("show");
});
    
jQuery(".orders-list li a.orders-detail").on("click", function(e) {
    "use strict";
    e.preventDefault();
    jQuery(this).parent().addClass("open").find(".orders-list .info-holder");
    jQuery(this).parent().siblings().find(".orders-list .info-holder");
});

jQuery(".orders-list li a.close").on("click", function(e) {
    e.preventDefault();
    jQuery(".orders-list > li.open").removeClass("open");
});

jQuery(".book-list #close-btn4").click(function() {
    "use strict";
    jQuery(".book-list .open-close-time").addClass("opening-time");
});

jQuery(".book-list #close-btn3").click(function() {
    "use strict";
    jQuery(".book-list .open-close-time").removeClass("opening-time");
});

jQuery(".service-list ul li a.edit").on("click", function(e) {
    "use strict";
    e.preventDefault();
    jQuery(this).parent().toggleClass("open").find(".service-list ul li .info-holder");
    jQuery(this).parent().siblings().find(".service-list ul li .info-holder");
    jQuery(this).parent().siblings().removeClass("open");
});

/* On Scroll Fixed Map Start*/

if (jQuery(".property-map-holder.map-right .detail-map").length != "") {
    "use strict";
    var Header_height = jQuery("header#header").height();
    if (jQuery(".property-map-holder.map-right .detail-map").length != "") {
        jQuery("header#header").addClass("fixed-header");
        jQuery(".property-map-holder.map-right .detail-map").addClass("fixed-item").css("padding-top", Header_height);
    } else {
        jQuery(".property-map-holder.map-right .detail-map").removeClass("fixed-item").css("padding-top", "auto");
        jQuery("header#header").removeClass("fixed-header");
    }
}

/* Close Effects Start */

jQuery(".clickable").on("click", function() {
    "use strict";
    var effect = jQuery(this).data("effect");
    jQuery(this).closest(".page-sidebar")[effect]();
});

jQuery(".filter-show").on("click", function() {
    jQuery(".page-sidebar").fadeIn();
});

/*
 * Croppic Block
 */

jQuery(document).on("click", ".cropControls .cropControlRemoveCroppedImage", function() {
    "use strict";
    jQuery("#cropContainerModal .cropControls").hide();
    var img_src = jQuery("#cropContainerModal").attr("data-def-img");
    var timesRun = 0;
    setInterval(function() {
        timesRun++;
        if (timesRun === 1) {
            jQuery("#cropContainerModal").find("figure a img").attr("src", img_src);
        }
    }, 50);
});

jQuery(document).on("click", ".upload-file", function() {
    jQuery(".cropControlUpload").click();
});

jQuery(document).on("click", ".cropControlRemoveCroppedImage", function() {
    "use strict";
    jQuery("#cropContainerModal img").attr("src", "");
    jQuery("#wp_rem_member_profile_image").val("");
});

/*
 * Packages Block
 */

jQuery(document).on("click", ".wp-rem-subscribe-pkg", function() {
    "use strict";
    var id = jQuery(this).data("id");
    jQuery("#response-" + id).slideDown();
});

$(document).on("click", ".wp-rem-dev-dash-detail-pkg", function() {
    "use strict";
    var _this_id = $(this).data("id"),
        package_detail_sec = $("#package-detail-" + _this_id);
    if (!package_detail_sec.is(":visible")) {
        $(".all-pckgs-sec").find(".package-info-sec").hide();
        package_detail_sec.slideDown();
    } else {
        package_detail_sec.slideUp();
    }
});

jQuery(document).on("click", ".wp-rem-subscribe-pkg-btn .buy-btn", function() {
    "use strict";
    var pkg_id = jQuery(this).parent().attr("data-id");
    var thisObj = jQuery(".buy-btn-" + pkg_id);
    wp_rem_show_loader(".buy-btn-" + pkg_id, "", "button_loader", thisObj);
});


/*
 * Open Time Block
 */

/* Time Open Close Function Start */

jQuery(".time-list #close-btn2").click(function() {
    jQuery(".time-list .open-close-time").addClass("opening-time");
});

jQuery(".time-list #close-btn1").click(function() {
    jQuery(".time-list .open-close-time").removeClass("opening-time");
});
    

jQuery(document).on("click", 'a[id^="wp-rem-dev-open-time"]', function() {
    "use strict";
    var _this_id = jQuery(this).data("id"),
        _this_day = jQuery(this).data("day"),
        _this_con = jQuery("#open-close-con-" + _this_day + "-" + _this_id),
        _this_status = jQuery("#wp-rem-dev-open-day-" + _this_day + "-" + _this_id);
    if (typeof _this_id !== "undefined" && typeof _this_day !== "undefined") {
        _this_status.val("on");
        _this_con.addClass("opening-time");
    }
});

jQuery(document).on("click", 'a[id^="wp-rem-dev-close-time"]', function() {
    "use strict";
    var _this_id = jQuery(this).data("id"),
        _this_day = jQuery(this).data("day"),
        _this_con = jQuery("#open-close-con-" + _this_day + "-" + _this_id),
        _this_status = jQuery("#wp-rem-dev-open-day-" + _this_day + "-" + _this_id);
    if (typeof _this_id !== "undefined" && typeof _this_day !== "undefined") {
        _this_status.val("");
        _this_con.removeClass("opening-time");
    }
});

/*
 * Location Block
 */

jQuery(document).on("click", ".loc-icon-holder", function() {
    "use strict";
    var thisObj = jQuery(this);
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
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
                success: function(response) {
                    thisObj.next("input").val(response.address);
                }
            });
        });
    }
});

/*
 * Opening Hours Block
 */

/*Delivery Timing Dropdown Functions Start*/

jQuery(document).ready(function($) {
    $(".field-select-holder .active").on("click", function() {
        "use strict";
        $(this).next("ul").slideToggle();
        $(this).parents("ul").toggleClass("open");
        $(".dropdown-select > li > a").on("click", function(e) {
            e.preventDefault();
            var anchorText = $(this).text();
            $(".field-select-holder .active small").text(anchorText);
            $(".field-select-holder .active").next("ul").slideUp();
            $(this).parents("ul").removeClass("open");
        });
    });

    $(document).mouseup(function(e) {
        var container = $(".field-select-holder > ul");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $(".field-select-holder .active").next("ul").slideUp();
            $(".field-select-holder > ul").removeClass("open");
        }
    });

    $(".field-select-holder ul li ul.delivery-dropdown li").click(function() {
        $(".field-select-holder .active").next("ul").slideUp();
        $(".field-select-holder > ul").removeClass("open");
    });

    jQuery(document).on("click", "#member-opening-hours-btn", function() {
        "use strict";
        var thisObj = jQuery(this);
        wp_rem_show_loader("#member-opening-hours-btn", "", "button_loader", thisObj);
        var serializedValues = jQuery("#member-opening-hours-form").serialize();
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: wp_rem_globals.ajax_url,
            data: serializedValues + "&action=wp_rem_member_opening_hours_submission",
            success: function(response) {
                wp_rem_show_response(response, "", thisObj);
            }
        });
    });
});


/*
 * Common Block
 */
$(document).on("click", ".book-btn", function() {
    "use strict";
    $(this).next(".calendar-holder").slideToggle("fast");

});

$(document).on("click", 'a[id^="wp-rem-dev-day-off-rem-"]', function() {
    "use strict";
    var _this_id = $(this).data("id");
    $("#day-remove-" + _this_id).remove();
});

$(document).on("click", ".wp-rem-dev-insert-off-days .wp-rem-dev-calendar-days .day a", function() {
    "use strict";
    var adding_off_day, _this_ = $(this),
        _this_id = $(this).parents(".wp-rem-dev-insert-off-days").data("id"),
        _day = $(this).data("day"),
        _month = $(this).data("month"),
        _year = $(this).data("year"),
        _adding_date = _year + "-" + _month + "-" + _day,
        _add_date = true,
        _this_append = $("#wp-rem-dev-add-off-day-app-" + _this_id),
        no_off_day_msg = _this_append.find("#no-book-day-" + _this_id),
        this_loader = $("#dev-off-day-loader-" + _this_id),
        this_act_msg = $("#wp-rem-dev-act-msg-" + _this_id);
    _this_append.find("li").each(function() {
        var date_field = $(this).find('input[name^="wp_rem_property_off_days"]');
        if (_adding_date == date_field.val()) {
            var response = {
                type: "success",
                msg: wp_rem_property_strings.off_day_already_added
            };
            wp_rem_show_response(response);
            _add_date = false;
        }
    });

    if (typeof _day !== "undefined" && typeof _month !== "undefined" && typeof _year !== "undefined" && _add_date === true) {
        var thisObj = jQuery(".book-btn");
        wp_rem_show_loader(".book-btn", "", "button_loader", thisObj);
        adding_off_day = $.ajax({
            url: wp_rem_globals.ajax_url,
            method: "POST",
            data: {
                off_day_day: _day,
                off_day_month: _month,
                off_day_year: _year,
                property_add_counter: _this_id,
                action: "wp_rem_property_off_day_to_list"
            },
            dataType: "json"
        }).done(function(response) {
            if (typeof response.html !== "undefined") {
                no_off_day_msg.remove();
                _this_append.append(response.html);
                this_act_msg.html(wp_rem_property_strings.off_day_added);
            }
            var response = {
                type: "success",
                msg: wp_rem_property_strings.off_day_added
            };
            wp_rem_show_response(response, "", thisObj);
            $("#wp-rem-dev-cal-holder-" + _this_id).slideUp("fast");
        }).fail(function() {
            wp_rem_show_response("", "", thisObj);
        });
    }
});

/*
 * sorting gallery images
 */

function wp_rem_gallery_sorting_list(id, random_id) {
    var gallery = [];
    // more efficient than new Array()
    jQuery("#gallery_sortable_" + random_id + " li").each(function() {
        var data_value = jQuery.trim(jQuery(this).data("attachment_id"));
        gallery.push(jQuery(this).data("attachment_id"));
    });
    jQuery("#" + id).val(gallery.toString());
}

function wp_rem_top_search(counter) {
    "use strict";
    var thisObj = jQuery(".search-btn-loader-" + counter);
    wp_rem_show_loader(".search-btn-loader-" + counter, "", "button_loader", thisObj);
    jQuery("#top-search-form-" + counter).find("input, textarea, select").each(function(_, inp) {
        if (jQuery(inp).val() === "" || jQuery(inp).val() === null) inp.disabled = true;
    });
}

/*
 * chosen selection box
 */

function chosen_selectionbox() {
    "use strict";
    if (jQuery(".chosen-select, .chosen-select-deselect, .chosen-select-no-single, .chosen-select-no-results, .chosen-select-width").length != "") {
        var config = {
            ".chosen-select": {
                width: "100%"
            },
            ".chosen-select-deselect": {
                allow_single_deselect: true
            },
            ".chosen-select-no-single": {
                disable_search_threshold: 10,
                width: "100%",
                search_contains: true
            },
            ".chosen-select-no-results": {
                no_results_text: "Oops, nothing found!"

            },
            ".chosen-select-width": {
                width: "95%"
            }
        };
        for (var selector in config) {
            jQuery(selector).chosen(config[selector]);
        }
    }
}

// handle relationship between min and max filters
function kk_price_filter_handler(min_sel, max_sel){
    kk_price_filter_handle_min_onchange(min_sel, max_sel);
    kk_price_filter_handle_max_onchange(min_sel, max_sel);
    kk_price_filter_initial_state(min_sel, max_sel);
}        

function kk_price_filter_initial_state(min_sel, max_sel){
    $(min_sel).trigger('change');
    $(max_sel).trigger('change');
}

function kk_price_filter_handle_min_onchange(min_sel, max_sel){
    $(document).on('change', min_sel, function(event) {
        var min_chosen = $(this).val();
        if( min_chosen.indexOf('>') != -1 ){
            // chosen "> price" value
            // hide all max price filter
            kk_price_filter_hide_all_options(max_sel);
        } else if( min_chosen == '' ){
            // chosen default (placeholder) value
            // show all max price filter
            kk_price_filter_show_all_options(max_sel);
        } else {
            // chosen some number
            // hide prices in max price filter that < current min value
            kk_price_filter_change_max_options(min_chosen, max_sel);
        }
        $(max_sel).trigger('chosen:updated');
    });
}

function kk_price_filter_handle_max_onchange(min_sel, max_sel){
    $(document).on('change', max_sel, function(event) {
        var max_chosen = $(this).val();
        if( max_chosen == '' ){
            // chosen default (placeholder) value
            // show all min price filter
            kk_price_filter_show_all_options(min_sel);
        } else {
            // chosen some number
            // hide prices in min price filter that > current min value
            kk_price_filter_change_min_options( max_chosen, min_sel );
        }
        $(min_sel).trigger('chosen:updated');
    });
}

function kk_price_filter_change_min_options( max_chosen, min_select ){
    $(min_select).find('option').each( function(index, el) {
        var cur_val = Number($( this ).val().replace('>', ''));
        if( cur_val > 0 && cur_val > Number(max_chosen) ){
            $(this).hide();
        } else {
            $(this).show();
        }
    });
}

function kk_price_filter_change_max_options( min_chosen, max_select ){
    $(max_select).find('option').each( function(index, el) {
        cur_val = Number($( this ).val());
        if( cur_val > 0 && cur_val < Number(min_chosen) ){
            $(this).hide();
        } else {
            $(this).show();
        }
    });
}

function kk_price_filter_hide_all_options( select ){
    $(select).find('option').each(function(index, el) {
        if( $(this).val() != '' ){
            $(this).hide();
        }
    });
}

function kk_price_filter_show_all_options( select ){
    $(select).find('option').each(function(index, el) {
            $(this).show();
    });
}

// update range slider view (for sqt field) on change
function kk_update_slider_params_onchange( selector ){
    $(selector).on( "change", function( el ){
        var container = $(el.target).closest('.kk_slider');
        var from = el.value.newValue[0];
        var to = el.value.newValue[1];
        container.find('.kk_slider_from').text(from);
        container.find('.kk_slider_to').text(to);
    });
}

function wp_rem_multicap_all_functions() {
    "use strict";
    var all_elements = jQuery(".g-recaptcha");
    for (var i = 0; i < all_elements.length; i++) {
        var id = all_elements[i].getAttribute("id");
        var site_key = all_elements[i].getAttribute("data-sitekey");
        if (null != id) {
            grecaptcha.render(id, {
                sitekey: site_key,
                callback: function(resp) {
                    jQuery.data(document.body, "recaptcha", resp);
                }
            });
        }
    }
}

/*
 * captcha reload
 */

function captcha_reload(admin_url, captcha_id) {
    "use strict";
    var dataString = "&action=wp_rem_reload_captcha_form&captcha_id=" + captcha_id;
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        dataType: "html",
        success: function(data) {
            jQuery("#" + captcha_id + "_div").html(data);
        }
    });
}

/*More Less Text Start*/

var showChar = 490;

// How many characters are shown by default

var ellipsestext = "...";
var moretext = "Read more >>";
var lesstext = "Read Less >>";

/* counter more Start */

jQuery(".more").each(function() {
    var content = jQuery(this).text();
    var showcharnew = $(this).attr("data-count");
    if (showcharnew != undefined && showcharnew != "") {
        showChar = showcharnew;
    }

    if (content.length > showChar) {
        var c = content.substr(0, showChar);
        var h = content.substr(showChar, content.length - showChar);
        var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="readmore-text">' + moretext + "</a></span>";
        jQuery(this).html(html);
    }
});
/*Read More Text Start*/

jQuery(".readmore-text").click(function() {
    "use strict";
    if (jQuery(this).hasClass("less")) {
        jQuery(this).removeClass("less");
        jQuery(this).html(moretext);
    } else {
        jQuery(this).addClass("less");
        jQuery(this).html(lesstext);
    }
    jQuery(this).parent().prev().toggle();
    jQuery(this).prev().toggle();
    return false;
});

/*Upload Gallery Start*/

if (jQuery(".upload-gallery").length != "") {
    function dragStart(ev) {
        ev.dataTransfer.effectAllowed = "move";
        ev.dataTransfer.setData("Text", ev.target.getAttribute("id"));
        ev.dataTransfer.setDragImage(ev.target, 100, 100);
        return true;
    }
}

if (jQuery(".upload-gallery").length != "") {
    function dragEnter(ev) {
        event.preventDefault();
        ev.css({
            margin: "0 0 0 15px"
        });
        return true;
    }
}

if (jQuery(".upload-gallery").length != "") {
    function dragOver(ev) {
        event.preventDefault();
        ev.css({
            margin: "0 0 0 15px"
        });
    }
}

if (jQuery(".upload-gallery").length != "") {
    function dragDrop(ev) {
        var data = ev.dataTransfer.getData("Text");
        ev.target.appendChild(document.getElementById(data));
        ev.stopPropagation();
        return false;
    }
}

if (jQuery(".files").length != "") {
    $(".files").sortable({
        revert: true
    });
}

if (jQuery(".fil-cat").length != "") {
    var selectedClass = "";
    $(".fil-cat").click(function() {
        selectedClass = $(this).attr("data-rel");
        $("#portfolio").fadeTo(100, .1);
        $("#portfolio li").not("." + selectedClass).fadeOut().removeClass("scale-anm");
        setTimeout(function() {
            $("." + selectedClass).fadeIn().addClass("scale-anm");
            $("#portfolio").fadeTo(300, 1);
        }, 300);
    });
}


jQuery(document).ready(function($) {
    "use strict";
    if ($("body").hasClass("rtl") == true) {
        jQuery('[data-toggle="popover"]').popover({
            placement: 'right'
        });
    } else {
        jQuery('[data-toggle="popover"]').popover();
    }
});


var default_loader = jQuery(".wp_rem_loader").html();
var default_button_loader = jQuery(".wp-rem-button-loader").html();

/*
 * Loader Show Function
 */
function wp_rem_show_loader(loading_element, loader_data, loader_style, thisObj) {
    "use strict";
    var loader_div = ".wp_rem_loader";
    if (loader_style == "button_loader") {
        loader_div = ".wp-rem-button-loader";
        if (thisObj != "undefined" && thisObj != "") {
            thisObj.addClass("wp-rem-processing");
        }
    }
    if (typeof loader_data !== "undefined" && loader_data != "" && typeof jQuery(loader_div) !== "undefined") {
        jQuery(loader_div).html(loader_data);
    }
    if (typeof loading_element !== "undefined" && loading_element != "" && typeof jQuery(loader_div) !== "undefined") {
        jQuery(loader_div).appendTo(loading_element);
    }
    jQuery(loader_div).css({
        display: "flex",
        display: "-webkit-box",
        display: "-moz-box",
        display: "-ms-flexbox",
        display: "-webkit-flex"
    });
}

/*
 * Loader Show Response Function
 */
function wp_rem_show_response(loader_data, loading_element, thisObj, clickTriger) {
    
    if (thisObj != "undefined" && thisObj != "" && thisObj != undefined) {
        thisObj.removeClass("wp-rem-processing");
    }
    jQuery(".wp-rem-button-loader").appendTo("#footer");
    jQuery(".wp_rem_loader").hide();
    jQuery(".wp-rem-button-loader").hide();
    if (clickTriger != "undefined" && clickTriger != "" && clickTriger != undefined) {
        jQuery(clickTriger).click();
    }
    jQuery("#growls").removeClass("wp_rem_element_growl");
    jQuery("#growls").find(".growl").remove();
    if (loader_data != "undefined" && loader_data != "") {
        if (loader_data.type != "undefined" && loader_data.type == "error") {
            var error_message = jQuery.growl.error({
                message: loader_data.msg
            });
            if (loading_element != "undefined" && loading_element != undefined && loading_element != "") {
                jQuery("#growls").prependTo(loading_element);
                jQuery("#growls").addClass("wp_rem_element_growl");
                setTimeout(function() {
                    jQuery(".growl-close").trigger("click");
                }, 5e3);
            }
        } else if (loader_data.type != "undefined" && loader_data.type == "success") {
            var success_message = jQuery.growl.success({
                message: loader_data.msg
            });
            if (loading_element != "undefined" && loading_element != undefined && loading_element != "") {
                jQuery("#growls").prependTo(loading_element);
                jQuery("#growls").addClass("wp_rem_element_growl");
                setTimeout(function() {
                    jQuery(".growl-close").trigger("click");
                }, 5e3);
            }
        }
    }
}

/*
 * Loader Hide Function  
 */
function wp_rem_hide_loader() {
    jQuery(".wp_rem_loader").hide();
    jQuery(".wp_rem_loader").html(default_loader);
}

/*
 * Hide Button loader
 */

function wp_rem_hide_button_loader(processing_div) {
    "use strict";
    if (processing_div != "undefined" && processing_div != "" && processing_div != undefined) {
        jQuery(processing_div).removeClass("wp-rem-processing");
    }
    jQuery(".wp-rem-button-loader").hide();
    jQuery(".wp-rem-button-loader").html(default_button_loader);
}


jQuery(document).ajaxComplete(function() {
    if ($("body").hasClass("rtl") == true) {
        jQuery('[data-toggle="popover"]').popover({
            placement: 'right'
        });
    } else {
        jQuery('[data-toggle="popover"]').popover();
    }
    if($(".property-grid").hasClass("modern")==false){
        if ($(".property-grid, .blog.blog-grid .blog-post, .member-grid .post-inner-member").length > 0) {
            $(".property-grid").matchHeight();
            $(".blog.blog-grid .blog-post").matchHeight();
            $(".member-grid .post-inner-member").matchHeight();
        }
    }else{
        $(".property-grid.modern .text-holder").matchHeight();
    }
    if ($(".property-grid.modern .post-title, .property-grid.modern .price-holder").length > 0) {
        $(".property-grid.modern .post-title").matchHeight();
        $(".property-grid.modern .price-holder").matchHeight();
    }
});



jQuery(document).on("click", ".rem-pretty-photos", function(e) {
   "use strict";
    var id = jQuery(this).data('id');
    var galleryObj  = jQuery(this).closest('#galley-img'+id+'');
    jQuery(this).closest('#galley-img'+id+'').find("i").removeClass('icon-camera6');
    jQuery(this).closest('#galley-img'+id+'').find("i").addClass('icon-spinner8');
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: wp_rem_globals.ajax_url,
        data: "action=wp_rem_gallery_photo_render&property_id="+id,
        success: function(response) {
            galleryObj.html(response);
            jQuery("#galley-img"+id+" a[rel^='prettyPhoto']").prettyPhoto();
            jQuery(".btnnn"+id+"").trigger("click");
        }
    });
});


jQuery(document).on("click", ".wp-rem-open-register-tab", function(e) {
    e.stopImmediatePropagation();
    jQuery(".wp-rem-open-register-button").click();
});

jQuery(document).on("click", ".wp-rem-open-signin-tab", function(e) { 
    e.stopImmediatePropagation();
    jQuery(".wp-rem-open-signin-button").click();
});

jQuery(document).on("click", ".delete-favourite", function () {

//    if (!confirm(wp_rem_favourites.confirm_msg)) {
//        e.preventDefault();
//        return false;
//    }
    var thisObj = jQuery(this);
    var property_id = thisObj.data('id');
    var delete_icon_class = thisObj.find("i").attr('class');
    var loader_class = 'icon-spinner icon-spin';
    var dataString = 'property_id=' + property_id + '&action=wp_rem_removed_favourite';
    jQuery('#id_confrmdiv').show();
    jQuery('#id_truebtn').click(function () {
        thisObj.find('i').removeClass(delete_icon_class);
        thisObj.find('i').addClass(loader_class);
        jQuery.ajax({
            type: "POST",
            url: wp_rem_globals.ajax_url,
            data: dataString,
            dataType: "json",
            success: function (response) {
                thisObj.find('i').removeClass(loader_class).addClass(delete_icon_class);
                if (response.status == true) {

                    thisObj.closest('li').hide('slow', function () {
                        thisObj.closest('li').remove();
                    });
                    
                    var msg_obj = {msg : response.message, type : 'success'};
                    wp_rem_show_response(msg_obj);
                    if (response.property_count !== 'undefined' && response.property_count !== '') {
                        jQuery('.like-btn').find(".likes-count span").text(response.property_count);
                    }
                }
            }
        });

        jQuery('#id_confrmdiv').hide();
        return false;
    });
    jQuery('#id_falsebtn').click(function () {
        jQuery('#id_confrmdiv').hide();
        return false;
    });
    return false;
});

jQuery(document).on('click', '#wp-rem-dev-user-property-notes .expand-notes', function () {
    var show_more_txt = $(this).data('sh-more');
    var show_less_txt = $(this).data('sh-less');
    var expanded_txt = $(this).parent('p').find('.expanded-txt');
    
    if (expanded_txt.is(':visible')) {
        expanded_txt.hide();
        $(this).html(show_more_txt);
    } else {
        expanded_txt.show();
        $(this).html(show_less_txt);
    }
});

jQuery(document).on("click", ".delete-hidden-property", function () {    
    var thisObj = jQuery(this);
    var property_id = thisObj.data('id');
    var delete_icon_class = thisObj.find("i").attr('class');
    var loader_class = 'icon-spinner icon-spin';
    var dataString = 'property_id=' + property_id + '&action=wp_rem_removed_hidden_properties';
    jQuery('#id_confrmdiv').show();
    jQuery('#id_truebtn').click(function () {
        thisObj.find('i').removeClass(delete_icon_class);
        thisObj.find('i').addClass(loader_class);
        jQuery.ajax({
            type: "POST",
            url: wp_rem_globals.ajax_url,
            data: dataString,
            dataType: "json",
            success: function (response) {
                thisObj.find('i').removeClass(loader_class).addClass(delete_icon_class);
                if (response.status == true) {

                    thisObj.closest('li').hide('slow', function () {
                        thisObj.closest('li').remove();
                    });
                    var msg_obj = {msg: response.message, type: 'success'};
                    wp_rem_show_response(msg_obj);
//                    if (response.property_count !== 'undefined' && response.property_count !== '') {
//                        jQuery('.like-btn').find(".likes-count span").text(response.property_count);
//                    }
                }
            }
        });

        jQuery('#id_confrmdiv').hide();
        return false;
    });
    jQuery('#id_falsebtn').click(function () {
        jQuery('#id_confrmdiv').hide();
        return false;
    });
    return false;
});

jQuery(document).ready(function($) {
    kk_price_filter_handler('select[name=price_minimum]', 'select[name=price_maximum]');
});