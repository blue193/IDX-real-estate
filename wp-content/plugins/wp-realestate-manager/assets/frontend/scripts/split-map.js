var $ = jQuery;
var ajaxRequest;
jQuery(document).ready(function() {

    // listing split map 
    
    // sticky map tooltip
    if($(".wp-rem-split-map-wrap").length > 0){
        // variables
        var boxWrap=$(".wrapper-boxed");
        var wrapWidth=boxWrap.outerWidth();
        var wrapMarginTop=boxWrap.css("margin-top");
        var wrapMarginBottom=boxWrap.css("margin-bottom");
        var headerOffset=$("#header").offset().top;
        var windowWidth=$(window).width();
        var offsetMargin=(windowWidth-wrapWidth)/2;
        var holderWidth=$(".wp-rem-split-map-wrap .split-map-holder").width();
        var holderWidthOffset=$(".wp-rem-split-map-wrap .split-map-holder").width() - offsetMargin;
        var mapBottomOffset=$(window).height();
        var mapBottomOffset2=mapBottomOffset - $("#header").height();
        var rectRight = "rect(" + headerOffset+'px' + ", " + holderWidthOffset+'px' + ", " + mapBottomOffset+'px' + ", 0)";
        var rectLeft = "rect(" + headerOffset+'px' + ", " + holderWidth+'px' + ", " + mapBottomOffset+'px' + ",  " + offsetMargin+'px' + ")";

        var headerHeight=$("#header").height();
        var stickyHeight=headerHeight - $(".sticky-header").height;
        var windowHeight=$(window).height();
        var mapSplitOffsetbottom=$(".split-map-container").height();
        if(wrapMarginTop==undefined || wrapMarginBottom==undefined){
            wrapMarginTop = 0;
            wrapMarginBottom = 0;
        }

        kk_adjust_content_height();

        function StickyMapTools(element) { 
            this.thisElement = element; 
            this.isSticky=false; 
            this.stickyCheck = function (stickVal) {
                this.isSticky=stickVal;
            }
            this.wpAdminBar = function () {
                this.wpAdminBarVar=$("#wpadminbar").height();
                return this.wpAdminBarVar;
            }
            this.getHeader = function () {
                this.getHeaderHeight=$("#header").height();
                return this.getHeaderHeight;
            }
        }    
        StickyMapTools.prototype.stickyToolActive = function () {
            this.thisElement.css("top", this.wpAdminBar() + this.getHeader() + parseInt(wrapMarginTop));
            this.thisElement.addClass("toolSticky-active");
            this.stickyCheck(true);
        }; 
        StickyMapTools.prototype.stickyToolDisable = function () { 
            this.thisElement.css("top", '');
            this.thisElement.removeClass("toolSticky-active");
            this.stickyCheck(false);
        };
        var stickyTools = new StickyMapTools($(".map-actions, .property-records-sec"));
        if($(".wp-rem-split-map-wrap.split-map-left,.wp-rem-split-map-wrap.split-map-right").length > 0){
            stickyTools.stickyToolActive();
        }

        $(".wp-rem-split-map-wrap.split-map-right .wp-rem-ontop-gmap,.wp-rem-split-map-wrap.split-map-left .wp-rem-ontop-gmap").height(windowHeight );
        //========= on scroll map tools===========
        var w = $(window);
        var wrapOffset = $(".wp-rem-split-map-wrap").offset();
        var counter;
        var elementOffset=wrapOffset.top-w.scrollTop();
        counter=elementOffset;
        if($(".wp-rem-split-map-wrap.split-map-left,.wp-rem-split-map-wrap.split-map-right").length > 0){
            var filterHeight= $(".filters-sidebar").height();
            $(".wp-rem-split-map-wrap .filters-sidebar + .col-lg-9").css("min-height",w.height() - headerHeight);
            // clip map for box view
            if($(".wrapper-boxed").length > 0){   
                // for map on right           
                $(".wp-rem-split-map-wrap.split-map-right .split-map-holder").css("clip",rectRight);
                $(".wp-rem-split-map-wrap.split-map-fixed.split-map-right .map-actions").css({
                    "right":offsetMargin+10, "left":"auto"
                });
                $(".wp-rem-split-map-wrap.split-map-fixed.split-map-right .property-records-sec").css({
                    "right":offsetMargin + $(".map-actions").width()+20,
                     "left":"auto"});
                // for map on right
                // for map on left
                $(".wp-rem-split-map-wrap.split-map-left .split-map-holder").css("clip",rectLeft);
                $(".wp-rem-split-map-wrap.split-map-fixed.split-map-left .map-actions").css({"left":offsetMargin+10, "right":"auto"});
                $(".wp-rem-split-map-wrap.split-map-fixed.split-map-left .property-records-sec").css({
                    "left":offsetMargin + $(".map-actions").width()+20,
                     "right":"auto"});
                // for map on left
            }
            // clip map for box view
            $(window).scroll(function(){
                var stickyTop=$(".sticky-header").offset().top;
                var winTop=$(window).scrollTop();
                if(counter > 0){
                    if(counter < stickyTop-winTop + $(".sticky-header").height()){
                        $(".map-actions, .property-records-sec").css("top", $(".sticky-header").height() + $("#wpadminbar").height());
                    }
                    else {
                        $(".map-actions, .property-records-sec").css("top", counter);
                        counter=wrapOffset.top-w.scrollTop();
                    }
                }else if(counter > elementOffset || counter < 0){
                    counter=stickyTop-winTop + $(".sticky-header").height();
                }
                if(wrapOffset.top-winTop - $(".sticky-header").height() > 0){
                    counter=wrapOffset.top-winTop;
                    $(".map-actions, .property-records-sec").css("top", counter);
                }

                var togglerTop=$(".split-map-toggler").offset().top -winTop;
                if(winTop < mapSplitOffsetbottom - $("#header").outerHeight() -  $("#footer").outerHeight() - $(".company-logo-holder").outerHeight() - 450){
                 $(".split-map-toggler").css("margin-top",winTop-20);
                }
                if($(".wrapper-boxed").length > 0){  
                    if(winTop+headerHeight+parseInt(wrapMarginTop)+parseInt(wrapMarginBottom) + $("#footer").height() + 150 > $("#footer").offset().top - headerHeight - $("#footer").height() - $(".company-logo-holder .company-logo").height()){
                        var rectRight = "rect(" + headerOffset+'px' + ", " + holderWidthOffset+'px' + ", " + mapBottomOffset2+'px' + ", 0)";
                        $(".wp-rem-split-map-wrap.split-map-right .split-map-holder").css("clip",rectRight);
                        var rectLeft = "rect(" + headerOffset+'px' + ", " + holderWidth+'px' + ", " + mapBottomOffset2+'px' + ",  " + offsetMargin+'px' + ")";
                        $(".wp-rem-split-map-wrap.split-map-left .split-map-holder").css("clip",rectLeft);
                    }
                    else{
                        var rectRight = "rect(" + headerOffset+'px' + ", " + holderWidthOffset+'px' + ", " + mapBottomOffset+'px' + ", 0)";
                        $(".wp-rem-split-map-wrap.split-map-right .split-map-holder").css("clip",rectRight);
                        var rectLeft = "rect(" + headerOffset+'px' + ", " + holderWidth+'px' + ", " + mapBottomOffset+'px' + ",  " + offsetMargin+'px' + ")";
                        $(".wp-rem-split-map-wrap.split-map-left .split-map-holder").css("clip",rectLeft);
                    }
                }
                
            });
        }    
        //========= on scroll map tools===========

    }    
    
});
    // sticky map tooltip
    // map toggler
   /* $(".split-map-toggler").css({"top": vCenter});
    $(".split-map-toggler").click(function(){
        $(this).toggleClass("active");
        $(".wp-rem-split-map-wrap .filters-sidebar").toggleClass("active");
    });*/
    
    var windowHeight=jQuery(window).height();
        var headerHeight=jQuery("#header").height();
        var rHeight=windowHeight - headerHeight;
        var vCenter=rHeight/2;
        jQuery(".split-map-toggler").css({"top": vCenter});
        jQuery(".split-map-toggler").off('click');
        jQuery(".split-map-toggler").click(function(){
            if(jQuery(this).hasClass('active')){
                jQuery(this).removeClass('active');
                jQuery(".wp-rem-split-map-wrap .filters-sidebar").removeClass('active');
            } else{
                jQuery(this).addClass('active');
                jQuery(".wp-rem-split-map-wrap .filters-sidebar").addClass('active');
            }
            // jQuery(this).toggleClass("active");
            // jQuery(".wp-rem-split-map-wrap .filters-sidebar").toggleClass("active");
        });
        
        
    jQuery( document ).ajaxComplete(function() {
      //splitMap();
        var windowHeight=jQuery(window).height();
        var headerHeight=jQuery("#header").height();
        var rHeight=windowHeight - headerHeight;
        var vCenter=rHeight/2;
        jQuery(".split-map-toggler").css({"top": vCenter});
        jQuery(".split-map-toggler").click(function(){
            if(jQuery(this).hasClass('active')){
                jQuery(this).removeClass('active');
                jQuery(".wp-rem-split-map-wrap .filters-sidebar").removeClass('active');
            } else{
                jQuery(this).addClass('active');
                jQuery(".wp-rem-split-map-wrap .filters-sidebar").addClass('active');
            }
            // jQuery(this).toggleClass("active");
            // jQuery(".wp-rem-split-map-wrap .filters-sidebar").toggleClass("active");
        });
        kk_adjust_content_height();
    });

    function kk_adjust_content_height() {
        // fix filter block height
        var filter_height = $('.filters-sidebar .wp-rem-filters').outerHeight();
        var filter_ads_height = $('.filters-sidebar .property-filters-ads').outerHeight();
        // var filter_height = $('aside.filters-sidebar').outerHeight();
        var min_content_height = filter_height + filter_ads_height + 100;
        // var min_content_height = filter_height + 85;
        $('.real-estate-property-content').css('min-height', min_content_height + 'px');
    }