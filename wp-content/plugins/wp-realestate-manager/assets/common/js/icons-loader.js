var icons_load_call;
var loaded_icons;
jQuery(document).ready(function ($) {
    'use strict';
    var plugin_url = icons_vars.plugin_url;

    icons_load_call = $.getJSON(plugin_url + "assets/icomoon/js/selection.json")
    .done(function (response) {
        loaded_icons = response;
    });
});