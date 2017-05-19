(function ($) {
    var methods = {
        init: function () {
            $(this).each(function () {
                var $this = $(this);
                var $parent = $this.parent();
                var searchDirection = $parent.find('.floating-directions-panel');
                var map = null;
                var $data = $this.data();
                var contentString = '' +
                    '<div id="content">' +
                    '   <div>' +
                    '       <h3 class="firstHeading">Endereço</h3>' +
                    '   </div>' +
                    '   <div>' +
                    '       <p>' +
                    '       ' + $data['address'] +
                    '       </p>' +
                    '   </div>' +
                    '</div>';

                map = $this.gmap3({
                    address: $data['address'],
                    zoom: $data['zoom'],
                    disableDefaultUI: true,
                    zoomControl: $data['zoomcontrol'],
                    scrollwheel: $data['scrollwheel'],
                    scaleControl: true,
                    rotateControl: true,
                    mapTypeId: google.maps.MapTypeId[$data['maptype']],
                    styles: [
                        {
                            featureType: "poi",
                            stylers: [
                                {visibility: "off"}
                            ]
                        }
                    ]
                }).then(function (map) {
                    map.controls[google.maps.ControlPosition.TOP_LEFT].push(searchDirection[0]);
                    searchDirection.removeClass('hide');
                });

                map.marker({
                    position: [$data['lat'], $data['lng']]
                });

                map.infowindow({
                    content: contentString
                }).then(function (infowindow) {
                    var map = this.get(0);
                    var marker = this.get(1);
                    infowindow.open(map, marker);

                    marker.addListener('click', function () {
                        infowindow.open(map, marker);
                    });
                });

                searchDirection.find('.btn-find-directions').bind('click', function () {
                    var car = searchDirection.find('.btn-car');
                    var bike = searchDirection.find('.btn-bike');
                    var walk = searchDirection.find('.btn-walk');
                    var print = searchDirection.find('.btn-print');

                    print.bind('click', function () {
                        methods.printAnyMaps($this);
                    });

                    car.bind('click', function () {
                        searchDirection.find('.active').removeClass('active');
                        $(this).addClass('active');
                        findRoute();
                    });
                    bike.bind('click', function () {
                        searchDirection.find('.active').removeClass('active');
                        $(this).addClass('active');
                        findRoute();
                    });
                    walk.bind('click', function () {
                        searchDirection.find('.active').removeClass('active');
                        $(this).addClass('active');
                        findRoute();
                    });

                    var getDirection = function () {
                        if (car.hasClass('active')) {
                            return google.maps.DirectionsTravelMode.DRIVING;
                        }

                        if (bike.hasClass('active')) {
                            return google.maps.DirectionsTravelMode.BICYCLING;
                        }

                        if (walk.hasClass('active')) {
                            return google.maps.DirectionsTravelMode.WALKING;
                        }

                        return google.maps.DirectionsTravelMode.DRIVING;
                    };

                    var findRoute = function () {
                        var ride = $parent.find('.ride-actions');
                        ride.hide();
                        map.route({
                            origin: searchDirection.find('.ipsWidgetMapLocationSearch').val(),
                            destination: $data['address'],
                            travelMode: getDirection()
                        }).directionsrenderer(function (results) {
                            if (results) {
                                ride.show();
                                $parent.find('.directions').html('');
                                return {
                                    panel: $parent.find('.directions').addClass("gmap3").show(), // accept: string (jQuery selector), jQuery element or HTML node targeting a div
                                    directions: results
                                }
                            }
                        })
                    };
                    findRoute();
                });
            });

        },
        printAnyMaps: function (element) {
            element.find('.directions').printThis();
        }
    };

    $.gmap3(false);

    $.fn.kbMaps = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.kbMaps');
        }
    };

    if (!ip.isManagementState) {
        ipLoadGoogleMaps();
        $(window).on('ipGoogleMapsLoaded', function () {
            $('.ipWidget-KbMap .ipsMap').kbMaps();
        });
    }


})(jQuery);