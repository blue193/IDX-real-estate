jQuery(document).ready(function (jQuery) {
    "use strict";
    jQuery.fn.extend({
        cityAutocomplete: function (options) {

            return this.each(function () {

                var input = jQuery(this), opts = jQuery.extend({}, jQuery.cityAutocomplete);

                var autocompleteService = new google.maps.places.AutocompleteService();

                var predictionsDropDown = jQuery('<div class="wp_rem_location_autocomplete" class="city-autocomplete" style="min-height: 35px;"></div>').appendTo(jQuery(this).parent());
				
				var predictionsLoader = jQuery('<div class="location-loader-wrapper" style="display: none;"><i class="icon-spinner8 icon-spin"></i></div>');
				predictionsDropDown.append( predictionsLoader );
				
				var predictionsGoogleWrapper = jQuery('<div class="location-google-wrapper" style="display: none;"></div>');
				predictionsDropDown.append( predictionsGoogleWrapper );

				var predictionsDBWrapper = jQuery('<div class="location-db-wrapper" style="display: none;"></div>');
				predictionsDropDown.append( predictionsDBWrapper );
				
				var plugin_url = input.parent(".wp_rem_searchbox_div").data('locationadminurl');
				
				var last_query = '';
				var new_query = '';
				var xhr = '';

				var showDropDown = function () {
					new_query = input.val();
					// Min Number of characters
					var num_of_chars = 0;
					if (new_query.length >= num_of_chars) {
						predictionsDropDown.show();
						predictionsGoogleWrapper.hide();
						predictionsDBWrapper.hide();
						predictionsLoader.show();
						
						var params = {
							input: new_query,
							bouns: 'upperbound',
							//types: ['address'],
							componentRestrictions: '', //{country: window.country_code}
						};
						updateDBPredictions();
					} else {
						predictionsDropDown.hide();
					}
					$("input.search_type").val('custom');
                }

                input.keyup(showDropDown);
                input.click(showDropDown);
				
                function updateGooglePredictions(predictions, status) {
                    var google_results = '';

                    if (google.maps.places.PlacesServiceStatus.OK == status) {
                        // AJAX GET ADDRESS FROM GOOGLE
                        google_results += '<div class="address_headers"><h5>ADDRESS</h5></div>'
                        jQuery.each(predictions, function (i, prediction) {
                            google_results += '<div class="wp_rem_google_suggestions"><i class="icon-location-arrow"></i> ' + jQuery.fn.cityAutocomplete.transliterate(prediction.description) + '<span style="display:none">' + jQuery.fn.cityAutocomplete.transliterate(prediction.description) + '</span></div>';
                        });
						predictionsLoader.hide();
						predictionsGoogleWrapper.empty().append(google_results).show();
                    }
				}
				
				function updateDBPredictions() {
					if ( last_query == new_query && predictionsDBWrapper.html() ) {
						predictionsLoader.hide();
						predictionsDBWrapper.show();
						return;
					}
					last_query = new_query;
                    // AJAX GET STATE / PROVINCE.
                    var dataString = 'action=get_locations_for_search' + '&keyword=' + new_query;
					if ( xhr != '' ) {
						xhr.abort();
					}
                    xhr = jQuery.ajax({
                        type: "POST",
                        url: plugin_url,
                        data: dataString,
                        success: function (data) {
                            var results = jQuery.parseJSON(data);
                            if (results != '') {
								// Set label for suggestions.
								var labels_str = "";
								if ( typeof results.title != "undefined" ) {
									labels_str = results.title.join(" / ");
								}
								var locations_str = "";
								// Populate suggestions.
								if ( typeof results.locations_for_display != "undefined" ) {
									var data = results.locations_for_display;
									$.each( data, function( key1, val1 ) {
										if ( results.location_levels_to_show[0] == true && typeof val1.item != "undefined" ) {
											if( val1.match == "yes" || ( val1.match == "no" && val1.children.length > 0 ))
												locations_str += '<div class="wp_rem_google_suggestions wp_rem_location_parent address_headers"><i class="icon-location-arrow"></i><h5>' + val1.item.name + '</h5><span style="display:none">' + val1.item.slug + '</span></div>';
										}
										if ( val1.children.length > 0 ) {
											$.each( val1.children, function( key2, val2 ) {
												if ( results.location_levels_to_show[1] == true && typeof val2.item != "undefined" ) {
													locations_str += '<div class="wp_rem_google_suggestions wp_rem_location_child"><i class="icon-location-arrow"></i>' + val2.item.name + '<span style="display:none">' + val2.item.slug + '</span></div>';
												}
												if ( val2.children.length > 0 ) {
													$.each( val2.children, function( key3, val3 ) {
														if ( results.location_levels_to_show[2] == true && typeof val3.item != "undefined" ) {
															locations_str += '<div class="wp_rem_google_suggestions wp_rem_location_child"><i class="icon-location-arrow"></i>' + val3.item.name + '<span style="display:none">' + val3.item.slug + '</span></div>';
														}
														if ( val3.children.length > 0 ) {
															$.each( val3.children, function( key4, val4 ) {
																if ( results.location_levels_to_show[3] == true && typeof val4.item != "undefined" ) {
																	locations_str += '<div class="wp_rem_google_suggestions wp_rem_location_child"><i class="icon-location-arrow"></i>' + val4.item.name + '<span style="display:none">' + val4.item.slug + '</span></div>';
																}
															});
														}
													});
												}
											});
										}
									});
									predictionsDBWrapper.empty();
									if ( locations_str != "" ) {
										predictionsLoader.hide();
										predictionsDBWrapper.append('' + locations_str).show();
									}
								}
                            }
                            predictionsLoader.hide();
                        }
                    });
                }
				
				predictionsDropDown.delegate('div.wp_rem_google_suggestions', 'click', function () {
                    // if (jQuery(this).text() != "ADDRESS" && jQuery(this).text() != "STATE / PROVINCE" && jQuery(this).text() != "COUNTRY") {
                        // address with slug			
                        var wp_rem_address_html = jQuery(this).text();
                        // slug only
                        var wp_rem_address_slug = jQuery(this).find('span').html();
                        // remove slug
                        jQuery(this).find('span').remove();
                        input.val(jQuery(this).text());
                        input.next('.search_keyword').val(wp_rem_address_slug);
                        predictionsDropDown.hide();
                        input.next('.search_keyword').closest("form.side-loc-srch-form").submit();
						$("input.search_type").val('autocomplete');
                    // }
                });
				
                jQuery(document).mouseup(function (e) {
                	if( !(e.target.className == "icon-angle-down"))
                    	predictionsDropDown.hide();
                });
				jQuery(".wp-rem-radius-location").on("click", function(){
					if( jQuery(".wp_rem_location_autocomplete").is(":visible"))
						predictionsDropDown.hide();
					else
						showDropDown();
				});

                jQuery(window).resize(function () {
                    updatePredictionsDropDownDisplay(predictionsDropDown, input);
                });
				
                updatePredictionsDropDownDisplay(predictionsDropDown, input);
				
                return input;
            });
        }
    });
    jQuery.fn.cityAutocomplete.transliterate = function (s) {
        s = String(s);
        var char_map = {
			// Latin
			'Ã€': 'A', 'Ã?': 'A', 'Ã‚': 'A', 'Ãƒ': 'A', 'Ã„': 'A', 'Ã…': 'A', 'Ã†': 'AE', 'Ã‡': 'C',
			'Ãˆ': 'E', 'Ã‰': 'E', 'ÃŠ': 'E', 'Ã‹': 'E', 'ÃŒ': 'I', 'Ã?': 'I', 'ÃŽ': 'I', 'Ã?': 'I',
			'Ã?': 'D', 'Ã‘': 'N', 'Ã’': 'O', 'Ã“': 'O', 'Ã”': 'O', 'Ã•': 'O', 'Ã–': 'O', 'Å?': 'O',
			'Ã˜': 'O', 'Ã™': 'U', 'Ãš': 'U', 'Ã›': 'U', 'Ãœ': 'U', 'Å°': 'U', 'Ã?': 'Y', 'Ãž': 'TH',
			'ÃŸ': 'ss',
			'Ã ': 'a', 'Ã¡': 'a', 'Ã¢': 'a', 'Ã£': 'a', 'Ã¤': 'a', 'Ã¥': 'a', 'Ã¦': 'ae', 'Ã§': 'c',
			'Ã¨': 'e', 'Ã©': 'e', 'Ãª': 'e', 'Ã«': 'e', 'Ã¬': 'i', 'Ã­': 'i', 'Ã®': 'i', 'Ã¯': 'i',
			'Ã°': 'd', 'Ã±': 'n', 'Ã²': 'o', 'Ã³': 'o', 'Ã´': 'o', 'Ãµ': 'o', 'Ã¶': 'o', 'Å‘': 'o',
			'Ã¸': 'o', 'Ã¹': 'u', 'Ãº': 'u', 'Ã»': 'u', 'Ã¼': 'u', 'Å±': 'u', 'Ã½': 'y', 'Ã¾': 'th',
			'Ã¿': 'y',
			// Latin symbols
			'Â©': '(c)',
			// Greek
			'Î‘': 'A', 'Î’': 'B', 'Î“': 'G', 'Î”': 'D', 'Î•': 'E', 'Î–': 'Z', 'Î—': 'H', 'Î˜': '8',
			'Î™': 'I', 'Îš': 'K', 'Î›': 'L', 'Îœ': 'M', 'Î?': 'N', 'Îž': '3', 'ÎŸ': 'O', 'Î ': 'P',
			'Î¡': 'R', 'Î£': 'S', 'Î¤': 'T', 'Î¥': 'Y', 'Î¦': 'F', 'Î§': 'X', 'Î¨': 'PS', 'Î©': 'W',
			'Î†': 'A', 'Îˆ': 'E', 'ÎŠ': 'I', 'ÎŒ': 'O', 'ÎŽ': 'Y', 'Î‰': 'H', 'Î?': 'W', 'Îª': 'I',
			'Î«': 'Y',
			'Î±': 'a', 'Î²': 'b', 'Î³': 'g', 'Î´': 'd', 'Îµ': 'e', 'Î¶': 'z', 'Î·': 'h', 'Î¸': '8',
			'Î¹': 'i', 'Îº': 'k', 'Î»': 'l', 'Î¼': 'm', 'Î½': 'n', 'Î¾': '3', 'Î¿': 'o', 'Ï€': 'p',
			'Ï?': 'r', 'Ïƒ': 's', 'Ï„': 't', 'Ï…': 'y', 'Ï†': 'f', 'Ï‡': 'x', 'Ïˆ': 'ps', 'Ï‰': 'w',
			'Î¬': 'a', 'Î­': 'e', 'Î¯': 'i', 'ÏŒ': 'o', 'Ï?': 'y', 'Î®': 'h', 'ÏŽ': 'w', 'Ï‚': 's',
			'ÏŠ': 'i', 'Î°': 'y', 'Ï‹': 'y', 'Î?': 'i',
			// Turkish
			'Åž': 'S', 'Ä°': 'I', 'Ã‡': 'C', 'Ãœ': 'U', 'Ã–': 'O', 'Äž': 'G',
			'ÅŸ': 's', 'Ä±': 'i', 'Ã§': 'c', 'Ã¼': 'u', 'Ã¶': 'o', 'ÄŸ': 'g',
			// Russian
			'Ð?': 'A', 'Ð‘': 'B', 'Ð’': 'V', 'Ð“': 'G', 'Ð”': 'D', 'Ð•': 'E', 'Ð?': 'Yo', 'Ð–': 'Zh',
			'Ð—': 'Z', 'Ð˜': 'I', 'Ð™': 'J', 'Ðš': 'K', 'Ð›': 'L', 'Ðœ': 'M', 'Ð?': 'N', 'Ðž': 'O',
			'ÐŸ': 'P', 'Ð ': 'R', 'Ð¡': 'S', 'Ð¢': 'T', 'Ð£': 'U', 'Ð¤': 'F', 'Ð¥': 'H', 'Ð¦': 'C',
			'Ð§': 'Ch', 'Ð¨': 'Sh', 'Ð©': 'Sh', 'Ðª': '', 'Ð«': 'Y', 'Ð¬': '', 'Ð­': 'E', 'Ð®': 'Yu',
            'Ð¯': 'Ya',
            'Ð°': 'a', 'Ð±': 'b', 'Ð²': 'v', 'Ð³': 'g', 'Ð´': 'd', 'Ðµ': 'e', 'Ñ‘': 'yo', 'Ð¶': 'zh',
            'Ð·': 'z', 'Ð¸': 'i', 'Ð¹': 'j', 'Ðº': 'k', 'Ð»': 'l', 'Ð¼': 'm', 'Ð½': 'n', 'Ð¾': 'o',
            'Ð¿': 'p', 'Ñ€': 'r', 'Ñ?': 's', 'Ñ‚': 't', 'Ñƒ': 'u', 'Ñ„': 'f', 'Ñ…': 'h', 'Ñ†': 'c',
            'Ñ‡': 'ch', 'Ñˆ': 'sh', 'Ñ‰': 'sh', 'ÑŠ': '', 'Ñ‹': 'y', 'ÑŒ': '', 'Ñ?': 'e', 'ÑŽ': 'yu',
            'Ñ?': 'ya',
            // Ukrainian
            'Ð„'
                : 'Ye', 'Ð†': 'I', 'Ð‡': 'Yi', 'Ò?': 'G',
                'Ñ”'
                : 'ye', 'Ñ–': 'i', 'Ñ—': 'yi', 'Ò‘': 'g',
                // Czech
                'ÄŒ'
                : 'C', 'ÄŽ': 'D', 'Äš': 'E', 'Å‡': 'N', 'Å˜': 'R', 'Å ': 'S', 'Å¤': 'T', 'Å®': 'U',
                'Å½'
                : 'Z',
                'Ä?'
                : 'c', 'Ä?': 'd', 'Ä›': 'e', 'Åˆ': 'n', 'Å™': 'r', 'Å¡': 's', 'Å¥': 't', 'Å¯': 'u',
                'Å¾'
                : 'z',
                // Polish
                'Ä„'
                : 'A', 'Ä†': 'C', 'Ä˜': 'e', 'Å?': 'L', 'Åƒ': 'N', 'Ã“': 'o', 'Åš': 'S', 'Å¹': 'Z',
                'Å»'
                : 'Z',
                'Ä…'
                : 'a', 'Ä‡': 'c', 'Ä™': 'e', 'Å‚': 'l', 'Å„': 'n', 'Ã³': 'o', 'Å›': 's', 'Åº': 'z',
                'Å¼'
                : 'z',
                // Latvian
                'Ä€'
                : 'A', 'ÄŒ': 'C', 'Ä’': 'E', 'Ä¢': 'G', 'Äª': 'i', 'Ä¶': 'k', 'Ä»': 'L', 'Å…': 'N',
                'Å '
                : 'S', 'Åª': 'u', 'Å½': 'Z',
                'Ä?'
                : 'a', 'Ä?': 'c', 'Ä“': 'e', 'Ä£': 'g', 'Ä«': 'i', 'Ä·': 'k', 'Ä¼': 'l', 'Å†': 'n',
                'Å¡'
                : 's', 'Å«': 'u', 'Å¾': 'z'
		};
		for (var k in char_map) {
			//s = s.replace(new RegExp(k, 'g'), char_map[k]);
		}
		return s;
	};
        function updatePredictionsDropDownDisplay(dropDown, input) {
            if (typeof (input.offset()) !== 'undefined') {
                dropDown.css({
                    'width': input.outerWidth(),
                    'left': input.offset().left,
                    'top': input.offset().top + input.outerHeight()
                });
            }
        }

		jQuery('input.wp_rem_search_location_field').cityAutocomplete();

		jQuery(document).on('click', '.wp_rem_searchbox_div', function () {
			jQuery('.wp_rem_search_location_field').prop('disabled', false);
		});

		jQuery(document).on('click', 'form', function () {
			var src_loc_val = jQuery(this).find('.wp_rem_search_location_field');
			src_loc_val.next('.search_keyword').val(src_loc_val.val());
		});
}(jQuery));