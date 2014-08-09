Object.keys = Object.keys || function (e) {
    var o = [];
    for (var t in e) e.hasOwnProperty(t) && o.push(t);
    return o
}, jQuery(document).ready(function (e) {
    function o() {
        var e = parseFloat(n.attr("data-map-level")),
            o = parseFloat(n.attr("data-map-lat")),
            t = parseFloat(n.attr("data-map-lng")),
            a = (n.attr("data-map-img"), n.attr("data-overlay-color")),
            i = 0;
        isNaN(e) && (e = 15), isNaN(o) && (o = 51.47), isNaN(t) && (t = -.268199), "" == a && (a = "none"), jQuery(window).width() > 690 ? (i = 150, enableAnimation = google.maps.Animation.BOUNCE) : enableAnimation = null;
        var l = new google.maps.LatLng(o, t),
            s = [{
                stylers: [{
                    hue: a
                }, {
                    saturation: -30
                }]
            }, {
                featureType: "road",
                elementType: "geometry",
                stylers: [{
                    lightness: 100
                }, {
                    visibility: "simplified"
                }]
            }, {
                featureType: "road",
                elementType: "labels",
                stylers: [{
                    visibility: "on"
                }]
            }],
            r = {
                center: l,
                zoom: e,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                scrollwheel: !1,
                panControl: !0,
                zoomControl: !0,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.LARGE
                },
                mapTypeControl: !1,
                scaleControl: !1,
                streetViewControl: !1
            };
        window.map = new google.maps.Map(document.getElementById("contact-map"), r), "none" != a && window.map.setOptions({
            styles: s
        }), window.infoWindows = [], google.maps.event.addListenerOnce(window.map, "tilesloaded", function () {})

    }

    function t(e) {
        for (var o = (parseFloat(n.attr("data-map-level")), parseFloat(n.attr("data-map-lat")), parseFloat(n.attr("data-map-lng")), n.attr("data-map-img")), t = (n.attr("data-overlay-color"), 0), a = 1; a <= Object.keys(hb_gmap).length; a++)! function (a) {
            setTimeout(function () {
                var t = new google.maps.Marker({
                    position: new google.maps.LatLng(hb_gmap[a].lat, hb_gmap[a].lng),
                    map: e,
                    infoWindowIndex: a - 1,
                    animation: enableAnimation,
                    icon: o,
                    optimized: !1
                });
                setTimeout(function () {
                    t.setAnimation(null)
                }, 200);
                var n = new google.maps.InfoWindow({
                    content: hb_gmap[a].ibx,
                    maxWidth: 300
                });
                window.infoWindows.push(n), google.maps.event.addListener(t, "click", function () {
                    return function () {
                        window.infoWindows[this.infoWindowIndex].open(e, this)
                    }
                }(t, a))
            }, a * t)
        }(a)
    }
    var a = jQuery(".hb-gmap-map");
    a.length && ("object" == typeof google && "object" == typeof google.maps ? a.each(function () {
        function o(e) {
            var o = new google.maps.Marker({
                position: new google.maps.LatLng(i, l),
                map: e,
                infoWindowIndex: 0,
                animation: enableAnimation,
                icon: s,
                optimized: !1
            });
            setTimeout(function () {
                o.setAnimation(null)
            }, 200)
        }

        function t(e) {
            if (jQuery(window).width() > 690) var o = google.maps.Animation.BOUNCE;
            else var o = null;
            for (var t = 1; t <= Object.keys(hb_gmap).length; t++)! function (t) {
                setTimeout(function () {
                    var a = new google.maps.Marker({
                            position: new google.maps.LatLng(hb_gmap[t].lat, hb_gmap[t].lng),
                            map: e,
                            infoWindowIndex: t - 1,
                            animation: o,
                            icon: s,
                            optimized: !1
                        }),
                        n = new google.maps.InfoWindow({
                            content: hb_gmap[t].ibx,
                            maxWidth: 300
                        });
                    w.push(n), google.maps.event.addListener(a, "click", function () {
                        return function () {
                            w[this.infoWindowIndex].open(e, this)
                        }
                    }(a, t))
                }, 200 * t)
            }(t)
        }
        var a = jQuery(this),
            n = parseFloat(a.attr("data-map-level")),
            i = parseFloat(a.attr("data-map-lat")),
            l = parseFloat(a.attr("data-map-lng")),
            s = a.attr("data-map-img"),
            r = a.attr("data-overlay-color"),
            p = 0,
            m = a.attr("data-show-location"),
            g = a.attr("data-pan-control"),
            d = a.attr("data-zoom-control");
        d = "undefined" == typeof d ? !0 : "true" == d ? !0 : !1, g = "undefined" == typeof g ? !0 : "true" == g ? !0 : !1, isNaN(n) && (n = 15), isNaN(i) && (i = 51.47), isNaN(l) && (l = -.268199), "" == r && (r = "none"), jQuery(window).width() > 690 ? (p = 150, enableAnimation = google.maps.Animation.BOUNCE) : enableAnimation = null;
        var u = new google.maps.LatLng(i, l),
            c = [{
                stylers: [{
                    hue: r
                }, {
                    saturation: -30
                }]
            }, {
                featureType: "road",
                elementType: "geometry",
                stylers: [{
                    lightness: 100
                }, {
                    visibility: "simplified"
                }]
            }, {
                featureType: "road",
                elementType: "labels",
                stylers: [{
                    visibility: "on"
                }]
            }],
            y = {
                center: u,
                zoom: n,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                scrollwheel: !1,
                panControl: g,
                zoomControl: d,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.LARGE
                },
                mapTypeControl: !1,
                scaleControl: !1,
                streetViewControl: !1
            },
            f = new google.maps.Map(a.get(0), y);
        "none" != r && f.setOptions({
            styles: c
        });
        var w = [];
        google.maps.event.addListenerOnce(f, "tilesloaded", function () {
            if (s.length > 0) {
                var a = new Image;
                a.src = s, e(a).load(function () {
                    "-1" == m ? t(f) : "0" == m && o(f)
                })
            } else "-1" == m ? t(f) : "0" == m && o(f)
        })
    }) : google.load("maps", "3", {
        other_params: "sensor=false",
        callback: function () {
            a.each(function () {
                function o(e) {
                    var o = new google.maps.Marker({
                        position: new google.maps.LatLng(i, l),
                        map: e,
                        infoWindowIndex: 0,
                        animation: enableAnimation,
                        icon: s,
                        optimized: !1
                    });
                    setTimeout(function () {
                        o.setAnimation(null)
                    }, 200)
                }

                function t(e) {
                    for (var o = 1; o <= Object.keys(hb_gmap).length; o++)! function (o) {
                        setTimeout(function () {
                            var t = new google.maps.Marker({
                                position: new google.maps.LatLng(hb_gmap[o].lat, hb_gmap[o].lng),
                                map: e,
                                infoWindowIndex: o - 1,
                                animation: enableAnimation,
                                icon: s,
                                optimized: !1
                            });
                            setTimeout(function () {
                                t.setAnimation(null)
                            }, 200);
                            var a = new google.maps.InfoWindow({
                                content: hb_gmap[o].ibx,
                                maxWidth: 300
                            });
                            w.push(a), google.maps.event.addListener(t, "click", function () {
                                return function () {
                                    w[this.infoWindowIndex].open(e, this)
                                }
                            }(t, o))
                        }, o * p)
                    }(o)
                }
                var a = jQuery(this),
                    n = parseFloat(a.attr("data-map-level")),
                    i = parseFloat(a.attr("data-map-lat")),
                    l = parseFloat(a.attr("data-map-lng")),
                    s = a.attr("data-map-img"),
                    r = a.attr("data-overlay-color"),
                    p = 0,
                    m = a.attr("data-show-location"),
                    g = a.attr("data-pan-control"),
                    d = a.attr("data-zoom-control");
                d = "undefined" == typeof d ? !0 : "true" == d ? !0 : !1, g = "undefined" == typeof g ? !0 : "true" == g ? !0 : !1, isNaN(n) && (n = 15), isNaN(i) && (i = 51.47), isNaN(l) && (l = -.268199), "" == r && (r = "none"), jQuery(window).width() > 690 ? (p = 150, enableAnimation = google.maps.Animation.BOUNCE) : enableAnimation = null;
                var u = new google.maps.LatLng(i, l),
                    c = [{
                        stylers: [{
                            hue: r
                        }, {
                            saturation: -30
                        }]
                    }, {
                        featureType: "road",
                        elementType: "geometry",
                        stylers: [{
                            lightness: 100
                        }, {
                            visibility: "simplified"
                        }]
                    }, {
                        featureType: "road",
                        elementType: "labels",
                        stylers: [{
                            visibility: "on"
                        }]
                    }],
                    y = {
                        center: u,
                        zoom: n,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        scrollwheel: !1,
                        panControl: g,
                        zoomControl: d,
                        zoomControlOptions: {
                            style: google.maps.ZoomControlStyle.LARGE
                        },
                        mapTypeControl: !1,
                        scaleControl: !1,
                        streetViewControl: !1
                    },
                    f = new google.maps.Map(a.get(0), y);
                "none" != r && f.setOptions({
                    styles: c
                });
                var w = [];
                google.maps.event.addListenerOnce(f, "tilesloaded", function () {
                    if (s.length > 0) {
                        var a = new Image;
                        a.src = s, e(a).load(function () {
                            "-1" == m ? t(f) : "0" == m && o(f)
                        })
                    } else "-1" == m ? t(f) : "0" == m && o(f)
                })
            })
        }
    }));
    var n = jQuery("#contact-map");
    if (n.length) {
        var i = jQuery("#header-dropdown"),
            l = 0;
        jQuery("#show-map-button").click(function (e) {
            jQuery(this).hasClass("close-map") ? (jQuery(i).stop(!0, !1).animate({
                height: "0px"
            }, 400, "easeInOutQuad", function () {
                jQuery(i).css("opacity", 0)
            }), jQuery("#show-map-button").removeClass("close-map active")) : (e.preventDefault(), jQuery(this).addClass("close-map active"), jQuery(i).stop(!0, !1).animate({
                height: "380px",
                opacity: 1
            }, 400, "easeInOutQuad", function () {
                0 == l ? google.load("maps", "3", {
                    other_params: "sensor=false",
                    callback: function () {
                        o(), l = 1, setTimeout(function () {
                            jQuery("#contact-map").addClass("visible-map"), t(window.map)
                        }, 500)
                    }
                }) : (google.maps.event.trigger(window.map, "resize"), setTimeout(function () {
                    jQuery("#contact-map").addClass("visible-map")
                }, 500))
            }))
        }), jQuery(".close-map").click(function () {
            jQuery(i).stop(!0, !1).animate({
                height: "0px"
            }, 400, "easeInOutQuad", function () {
                jQuery(i).css("opacity", 0)
            }), jQuery("#show-map-button").removeClass("close-map active")
        })
    }
});