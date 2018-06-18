function wp_rem_cs_map_select_style(style) {
    "use strict";
    var styles = '';
    if (style == 'map-box') {
        var styles = [
            {
                "featureType": "water",
                "stylers": [
                    {
                        "saturation": 43
                    },
                    {
                        "lightness": -11
                    },
                    {
                        "hue": "#0088ff"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "hue": "#ff0000"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 99
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#808080"
                    },
                    {
                        "lightness": 54
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ece2d9"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ccdca1"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#767676"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "poi",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape.natural",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#b8cb93"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "poi.sports_complex",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "poi.medical",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "poi.business",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            }
        ];
    } else if (style == 'blue-water') {
        var styles = [
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#444444"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2f2f2"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#46bcec"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            }
        ];
    } else if (style == 'icy-blue') {
        var styles = [
            {
                "stylers": [
                    {
                        "hue": "#2c3e50"
                    },
                    {
                        "saturation": 250
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                    {
                        "lightness": 50
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            }
        ];
    } else if (style == 'bluish') 
    {
        var styles = [
            {
                "stylers": [
                    {
                        "hue": "#007fff"
                    },
                    {
                        "saturation": 89
                    }
                ]
            },
            {
                "featureType": "water",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            }
        ];
    } else if (style == 'light-blue-water') {
        var styles = [
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "hue": "#71d6ff"
                    },
                    {
                        "saturation": 100
                    },
                    {
                        "lightness": -5
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "hue": "#ffffff"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 100
                    },
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "hue": "#ffffff"
                    },
                    {
                        "saturation": 0
                    },
                    {
                        "lightness": 100
                    },
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#deecec"
                    },
                    {
                        "saturation": -73
                    },
                    {
                        "lightness": 72
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels",
                "stylers": [
                    {
                        "hue": "#bababa"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 25
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#e3e3e3"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 0
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#ffffff"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 100
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "labels",
                "stylers": [
                    {
                        "hue": "#59cfff"
                    },
                    {
                        "saturation": 100
                    },
                    {
                        "lightness": 34
                    },
                    {
                        "visibility": "on"
                    }
                ]
            }
        ];
    } else if (style == 'clad-me') {
        var styles = [
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#444444"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2f2f2"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#4f595d"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            }
        ];
    }
    else if (style == 'chilled') {
        var styles = [
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "stylers": [
                    {
                        "hue": 149
                    },
                    {
                        "saturation": -78
                    },
                    {
                        "lightness": 0
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "stylers": [
                    {
                        "hue": -31
                    },
                    {
                        "saturation": -40
                    },
                    {
                        "lightness": 2.8
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "label",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "stylers": [
                    {
                        "hue": 163
                    },
                    {
                        "saturation": -26
                    },
                    {
                        "lightness": -1.1
                    }
                ]
            },
            {
                "featureType": "transit",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "stylers": [
                    {
                        "hue": 3
                    },
                    {
                        "saturation": -24.24
                    },
                    {
                        "lightness": -38.57
                    }
                ]
            }
        ];
    } else if (style == 'two-tone') {
        var styles = [
            {
                "featureType": "all",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#c9323b"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#c9323b"
                    },
                    {
                        "weight": 1.2
                    }
                ]
            },
            {
                "featureType": "administrative.locality",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "lightness": "-1"
                    }
                ]
            },
            {
                "featureType": "administrative.neighborhood",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "lightness": "0"
                    },
                    {
                        "saturation": "0"
                    }
                ]
            },
            {
                "featureType": "administrative.neighborhood",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "weight": "0.01"
                    }
                ]
            },
            {
                "featureType": "administrative.land_parcel",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "weight": "0.01"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#c9323b"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#99282f"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#99282f"
                    }
                ]
            },
            {
                "featureType": "road.highway.controlled_access",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#99282f"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#99282f"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#99282f"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#99282f"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#090228"
                    }
                ]
            }
        ];
    } else if (style == 'light-and-dark') {
        var styles = [
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#444444"
                    }
                ]
            },
            {
                "featureType": "administrative.land_parcel",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2f2f2"
                    }
                ]
            },
            {
                "featureType": "landscape.natural",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#052366"
                    },
                    {
                        "saturation": "-70"
                    },
                    {
                        "lightness": "85"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "lightness": "-53"
                    },
                    {
                        "weight": "1.00"
                    },
                    {
                        "gamma": "0.98"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                    {
                        "saturation": "-18"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#57677a"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            }
        ];
    } 
    else if (style == 'ilustracao') {
        var styles = [
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#71ABC3"
                    },
                    {
                        "saturation": -10
                    },
                    {
                        "lightness": -21
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "landscape.natural",
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#7DC45C"
                    },
                    {
                        "saturation": 37
                    },
                    {
                        "lightness": -41
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#C3E0B0"
                    },
                    {
                        "saturation": 23
                    },
                    {
                        "lightness": -12
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "hue": "#A19FA0"
                    },
                    {
                        "saturation": -98
                    },
                    {
                        "lightness": -20
                    },
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#FFFFFF"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 100
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            }
        ];
    } else if (style == 'flat-pale') {
        var styles = [
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#6195a0"
                    }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [
                    {
                        "lightness": "0"
                    },
                    {
                        "saturation": "0"
                    },
                    {
                        "color": "#f5f5f2"
                    },
                    {
                        "gamma": "1"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "all",
                "stylers": [
                    {
                        "lightness": "-3"
                    },
                    {
                        "gamma": "1.00"
                    }
                ]
            },
            {
                "featureType": "landscape.natural.terrain",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#bae5ce"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#fac9a9"
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "color": "#4e4e4e"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#787878"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "transit.station.airport",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "hue": "#0a00ff"
                    },
                    {
                        "saturation": "-77"
                    },
                    {
                        "gamma": "0.57"
                    },
                    {
                        "lightness": "0"
                    }
                ]
            },
            {
                "featureType": "transit.station.rail",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#43321e"
                    }
                ]
            },
            {
                "featureType": "transit.station.rail",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "hue": "#ff6c00"
                    },
                    {
                        "lightness": "4"
                    },
                    {
                        "gamma": "0.75"
                    },
                    {
                        "saturation": "-68"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#eaf6f8"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#c7eced"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "lightness": "-49"
                    },
                    {
                        "saturation": "-53"
                    },
                    {
                        "gamma": "0.79"
                    }
                ]
            }
        ];
    } else if (style == 'title') {
        var styles =
                [
                    {
                        "featureType": "administrative",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#444444"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.neighborhood",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "visibility": "off"
                            },
                            {
                                "hue": "#17ff00"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.neighborhood",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape",
                        "elementType": "all",
                        "stylers": [
                            {
                                "color": "#f2f2f2"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.business",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.business",
                        "elementType": "labels.text",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.business",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "all",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 45
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "color": "#ff0000"
                            }
                        ]
                    },
                    {
                        "featureType": "road.arterial",
                        "elementType": "labels.icon",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road.local",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "all",
                        "stylers": [
                            {
                                "color": "#0088cc"
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    }
                ]

                ;
    } else if (style == 'moret') {
        var styles = [
            {
                "featureType": "administrative.country",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "color": "#737373"
                    },
                    {
                        "weight": "0.01"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": "97"
                    },
                    {
                        "color": "#ffffff"
                    },
                    {
                        "visibility": "simplified"
                    },
                    {
                        "lightness": "81"
                    }
                ]
            },
            {
                "featureType": "landscape.natural.landcover",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": "100"
                    },
                    {
                        "lightness": "100"
                    },
                    {
                        "gamma": "10.00"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": "100"
                    },
                    {
                        "lightness": "100"
                    },
                    {
                        "gamma": "10.00"
                    },
                    {
                        "weight": "0.01"
                    }
                ]
            },
            {
                "featureType": "poi.attraction",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#565656"
                    }
                ]
            },
            {
                "featureType": "poi.business",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#565656"
                    }
                ]
            },
            {
                "featureType": "poi.government",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#565656"
                    }
                ]
            },
            {
                "featureType": "poi.medical",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#565656"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": "100"
                    },
                    {
                        "lightness": "100"
                    },
                    {
                        "gamma": "10.00"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#565656"
                    }
                ]
            },
            {
                "featureType": "poi.place_of_worship",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#565656"
                    }
                ]
            },
            {
                "featureType": "poi.school",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#565656"
                    }
                ]
            },
            {
                "featureType": "poi.sports_complex",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#565656"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": "-70"
                    },
                    {
                        "lightness": "43"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#39d2ca"
                    }
                ]
            }
        ];
    }else if (style == 'rpn-map') {
	var styles = [
	    {
		"featureType": "administrative.country",
		"elementType": "geometry.stroke",
		"stylers": [
		    {
			"visibility": "on"
		    },
		    {
			"color": "#1c99ed"
		    }
		]
	    },
	    {
		"featureType": "administrative.country",
		"elementType": "labels.text.fill",
		"stylers": [
		    {
			"color": "#1f79b5"
		    }
		]
	    },
	    {
		"featureType": "administrative.province",
		"elementType": "labels.text.fill",
		"stylers": [
		    {
			"color": "#6d6d6d"
		    },
		    {
			"visibility": "on"
		    }
		]
	    },
	    {
		"featureType": "administrative.locality",
		"elementType": "labels.text.fill",
		"stylers": [
		    {
			"color": "#555555"
		    }
		]
	    },
	    {
		"featureType": "administrative.neighborhood",
		"elementType": "labels.text.fill",
		"stylers": [
		    {
			"color": "#999999"
		    }
		]
	    },
	    {
		"featureType": "landscape",
		"elementType": "all",
		"stylers": [
		    {
			"color": "#f2f2f2"
		    }
		]
	    },
	    {
		"featureType": "landscape.natural",
		"elementType": "geometry.fill",
		"stylers": [
		    {
			"visibility": "on"
		    }
		]
	    },
	    {
		"featureType": "landscape.natural.landcover",
		"elementType": "geometry.fill",
		"stylers": [
		    {
			"visibility": "on"
		    }
		]
	    },
	    {
		"featureType": "poi.attraction",
		"elementType": "all",
		"stylers": [
		    {
			"visibility": "on"
		    }
		]
	    },
	    {
		"featureType": "poi.business",
		"elementType": "all",
		"stylers": [
		    {
			"visibility": "on"
		    }
		]
	    },
	    {
		"featureType": "poi.government",
		"elementType": "all",
		"stylers": [
		    {
			"visibility": "on"
		    }
		]
	    },
	    {
		"featureType": "poi.medical",
		"elementType": "all",
		"stylers": [
		    {
			"visibility": "on"
		    }
		]
	    },
	    {
		"featureType": "poi.park",
		"elementType": "geometry.fill",
		"stylers": [
		    {
			"color": "#e1eddd"
		    }
		]
	    },
	    {
		"featureType": "poi.place_of_worship",
		"elementType": "all",
		"stylers": [
		    {
			"visibility": "on"
		    }
		]
	    },
	    {
		"featureType": "poi.school",
		"elementType": "all",
		"stylers": [
		    {
			"visibility": "on"
		    }
		]
	    },
	    {
		"featureType": "poi.sports_complex",
		"elementType": "all",
		"stylers": [
		    {
			"visibility": "on"
		    }
		]
	    },
	    {
		"featureType": "road",
		"elementType": "all",
		"stylers": [
		    {
			"saturation": "-100"
		    },
		    {
			"lightness": "45"
		    }
		]
	    },
	    {
		"featureType": "road.highway",
		"elementType": "all",
		"stylers": [
		    {
			"visibility": "simplified"
		    }
		]
	    },
	    {
		"featureType": "road.highway",
		"elementType": "geometry.fill",
		"stylers": [
		    {
			"color": "#ff9500"
		    }
		]
	    },
	    {
		"featureType": "road.highway",
		"elementType": "labels.icon",
		"stylers": [
		    {
			"visibility": "on"
		    },
		    {
			"hue": "#009aff"
		    },
		    {
			"saturation": "100"
		    },
		    {
			"lightness": "5"
		    }
		]
	    },
	    {
		"featureType": "road.highway.controlled_access",
		"elementType": "all",
		"stylers": [
		    {
			"visibility": "on"
		    }
		]
	    },
	    {
		"featureType": "road.highway.controlled_access",
		"elementType": "geometry.fill",
		"stylers": [
		    {
			"color": "#ff9500"
		    }
		]
	    },
	    {
		"featureType": "road.highway.controlled_access",
		"elementType": "geometry.stroke",
		"stylers": [
		    {
			"visibility": "off"
		    }
		]
	    },
	    {
		"featureType": "road.highway.controlled_access",
		"elementType": "labels.icon",
		"stylers": [
		    {
			"lightness": "1"
		    },
		    {
			"saturation": "100"
		    },
		    {
			"hue": "#009aff"
		    }
		]
	    },
	    {
		"featureType": "road.arterial",
		"elementType": "geometry.fill",
		"stylers": [
		    {
			"color": "#ffffff"
		    }
		]
	    },
	    {
		"featureType": "road.arterial",
		"elementType": "labels.text.fill",
		"stylers": [
		    {
			"color": "#8a8a8a"
		    }
		]
	    },
	    {
		"featureType": "road.arterial",
		"elementType": "labels.icon",
		"stylers": [
		    {
			"visibility": "off"
		    }
		]
	    },
	    {
		"featureType": "road.local",
		"elementType": "geometry.fill",
		"stylers": [
		    {
			"color": "#ffffff"
		    }
		]
	    },
	    {
		"featureType": "transit",
		"elementType": "all",
		"stylers": [
		    {
			"visibility": "off"
		    }
		]
	    },
	    {
		"featureType": "transit.station.airport",
		"elementType": "all",
		"stylers": [
		    {
			"visibility": "on"
		    }
		]
	    },
	    {
		"featureType": "transit.station.airport",
		"elementType": "geometry.fill",
		"stylers": [
		    {
			"lightness": "33"
		    },
		    {
			"saturation": "-100"
		    },
		    {
			"visibility": "on"
		    }
		]
	    },
	    {
		"featureType": "transit.station.bus",
		"elementType": "all",
		"stylers": [
		    {
			"visibility": "on"
		    }
		]
	    },
	    {
		"featureType": "transit.station.rail",
		"elementType": "all",
		"stylers": [
		    {
			"visibility": "on"
		    }
		]
	    },
	    {
		"featureType": "water",
		"elementType": "all",
		"stylers": [
		    {
			"color": "#46bcec"
		    },
		    {
			"visibility": "on"
		    }
		]
	    },
	    {
		"featureType": "water",
		"elementType": "geometry.fill",
		"stylers": [
		    {
			"color": "#4db4f8"
		    }
		]
	    },
	    {
		"featureType": "water",
		"elementType": "labels.text.fill",
		"stylers": [
		    {
			"color": "#ffffff"
		    }
		]
	    },
	    {
		"featureType": "water",
		"elementType": "labels.text.stroke",
		"stylers": [
		    {
			"visibility": "off"
		    }
		]
	    }
	];
    }
    return styles;
}