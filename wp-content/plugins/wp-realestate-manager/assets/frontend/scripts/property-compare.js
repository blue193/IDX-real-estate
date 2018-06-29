var $ = jQuery;

$(document).on('click', '.wp_rem_compare_check_add, .wp-rem-btn-compare', function () {
    var _this = $(this);
    var this_id = _this.data('id');
    var this_rand = _this.data('random');
    var this_ajaxurl = wp_rem_property_compare.ajax_url;

    var _action = 'check';
    if (_this.hasClass('wp_rem_compare_check_add')) {
        if (_this.is(":checked")) {
            _action = 'check';
            $('.wp-rem-compare-loader-' + this_rand).parent().parent().closest( ".property-medium" ).addClass('active');
            $('.wp-rem-compare-loader-' + this_rand).parent().parent().closest( ".property-grid" ).addClass('active');
        } else {
            _action = 'uncheck';
            $('.wp-rem-compare-loader-' + this_rand).parent().parent().closest( ".property-medium" ).removeClass('active');
            $('.wp-rem-compare-loader-' + this_rand).parent().parent().closest( ".property-grid" ).removeClass('active');
        }
    } else {
        _action = _this.attr("data-check");
    }

    var dataString = 'wp_rem_property_id=' + this_id + '&_action=' + _action + '&action=wp_rem_compare_add';
    if (_this.hasClass('wp_rem_compare_check_add')) {
        
        $('.wp-rem-compare-loader-' + this_rand).html('<span class="compare-loader"><i class="icon-spinner8"></i></span> ');
        $('.wp-rem-compare-loader-' + this_rand).parent().parent().addClass('comparing');
        
    } else {
        _this.find('span').append('<span><i class="icon-spinner8 icon-spin"></i></span>');
    }

    $.ajax({
        type: "POST",
        url: this_ajaxurl,
        data: dataString,
        dataType: 'json',
        success: function (response) {
            if (response.mark !== 'undefined') {
                if (_this.hasClass('wp_rem_compare_check_add')) {
                    if( response.type === '1' ){
                        $('.wp-rem-compare-loader-' + this_rand).parent().parent().closest( ".property-medium" ).addClass('active');
                        $('.wp-rem-compare-loader-' + this_rand).parent().parent().closest( ".property-grid" ).addClass('active');
                        $('.wp-rem-compare-loader-' + this_rand).parent('label').find('em').html(wp_rem_property_compare.compared_label);
                    }else{
                        $('.wp-rem-compare-loader-' + this_rand).parent().parent().closest( ".property-medium" ).removeClass('active');
                        $('.wp-rem-compare-loader-' + this_rand).parent().parent().closest( ".property-grid" ).removeClass('active');
                        $('.wp-rem-compare-loader-' + this_rand).parent('label').find('em').html(wp_rem_property_compare.compare_label);
                    }
                    $('.wp-rem-compare-loader-' + this_rand).parent().parent().removeClass('comparing');
                    $('.wp-rem-compare-loader-' + this_rand).parent().parent().toggleClass('compared');
                    $('.wp-rem-compare-loader-' + this_rand).html('');
                    
                    jQuery('.compare-message').addClass('active');
                    jQuery('.compare-message .compare-large .compare-text').html('');
                    jQuery('.compare-message .compare-large .compare-text').html(response.mark);
                    setTimeout(function() {
                        jQuery('.compare-message').removeClass('active');
                        jQuery('.compare-message .compare-large .compare-text').html('');
                    }, 5000);
                } else {
                    $('.wp-rem-compare-loader-' + this_rand).parent().parent().removeClass('comparing');
                    $('.wp-rem-compare-loader-' + this_rand).parent().parent().toggleClass('compared');
                    $('.wp-rem-compare-loader-' + this_rand).html('');
                    
                    jQuery('.compare-message').addClass('active');
                    jQuery('.compare-message .compare-large .compare-text').html('');
                    jQuery('.compare-message .compare-large .compare-text').html(response.mark);
                    setTimeout(function() {
                        jQuery('.compare-message').removeClass('active');
                        jQuery('.compare-message .compare-large .compare-text').html('');
                    }, 5000);
                    _this.find('span').html(response.compare);
                    var check_val = _this.attr("data-check");
                    if (check_val == 'uncheck') {
                        check_val = 'check';
                    } else {
                        check_val = 'uncheck';
                    }
                    _this.attr('data-check', check_val);
                }
            }
        }
    });
});

$(document).on('click', '.compare-message .compare-large .icon-cross', function () {
    jQuery('.compare-message').removeClass('active');
    jQuery('.compare-message .compare-large .compare-text').html('');
});
$(document).on('click', '.clear-list', function () {
    var this_id = $(this).data('id');
    var this_type_id = $(this).data('type-id');
    var this_ajaxurl = wp_rem_property_compare.ajax_url;
    var dataString = 'property_id=' + this_id + '&type_id=' + this_type_id + '&action=wp_rem_clear_compare';
    $.ajax({
        type: "POST",
        url: this_ajaxurl,
        data: dataString,
        dataType: 'json',
        success: function (response) {
            if (response.type === 'success') {
                var current_url = window.location.href; //window.location.href;
                window.location.href = current_url;
            }
        }
    });
});

$(document).on('click', '.wp-rem-remove-compare-item', function () {
    var this_id = $(this).data('id');
    var this_type_id = $(this).data('type-id');
    var this_ajaxurl = wp_rem_property_compare.ajax_url;
    var wp_rem_prop_ids = $('.wp-rem-compare').data('ids');
    var wp_rem_page_id = $('.wp-rem-compare').data('id');
    var dataString = 'property_id=' + this_id + '&type_id=' + this_type_id + '&prop_ids=' + wp_rem_prop_ids + '&page_id=' + wp_rem_page_id + '&action=wp_rem_removing_compare';
    $(this).html('<i class="icon-spinner8 icon-spin"></i>');
    $.ajax({
        type: "POST",
        url: this_ajaxurl,
        data: dataString,
        dataType: 'json',
        success: function (response) {
            if (response.url !== 'undefined' && response.url != '') {
                $('.dev-rem-' + this_id).remove();
                window.location.href = response.url;
            }
        }
    });
});