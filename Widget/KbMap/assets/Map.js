/**
 * @package ImpressPages
 *
 */
var IpWidget_KbMap = function () {
    this.widgetObject = null;
    this.widgetOverlay = null;
    this.data = null;
    this.map = null;
    this.marker = null;

    this.modalId = '#kbWidgetsMap .ipsModal';

    /**
     * Initialize widget management
     * @param widgetObject jquery object of an widget div
     * @param data widget's data
     */
    this.init = function (widgetObject, data) {
        //store widgetObject variable to be accessible from other functions
        this.widgetObject = widgetObject;
        this.widgetObject.css('min-height', '30px'); //if widget is empty it could be impossible to click on.
        this.data = data;

        var context = this; // set this so $.proxy would work below. http://api.jquery.com/jquery.proxy/

        this.$button = this.widgetObject.find('.ipsWidgetEdit');
        this.$button.on('click', $.proxy(openPopup, context));

        var $map = this.widgetObject.find('.ipsMap');

        if (!$map.length) {
            // happens if there is no Google Maps key
            return;
        }

        if (jQuery.fn.ipWidgetMap && typeof(google) !== 'undefined' && typeof(google.maps) !== 'undefined' && typeof(google.maps.LatLng) !== 'undefined') {
            jQuery(this.widgetObject.get()).ipWidgetMap();
        }

        if (typeof(google) !== 'undefined' && typeof(google.maps) !== 'undefined' && typeof(google.maps.LatLng) !== 'undefined') {
            $map.kbMaps();
        } else {
            $(document).on('ipGoogleMapsLoaded', function () {
                $map.kbMaps();
            });
            ipLoadGoogleMaps();
        }

        //put an overlay over the widget and open popup on mouse click event
        this.$widgetOverlay = $('<div></div>');
        this.widgetObject.prepend(this.$widgetOverlay);
        //this.$widgetOverlay.on('click', $.proxy(openPopup, this));
        $.proxy(fixOverlay, context)();

        //fix overlay size when widget is resized / moved
        $(document).on('ipWidgetResized', function () {
            context.widgetObject.save({height: $map.height}, 1);
            //google.maps.event.trigger(map, "resize");
        });
        $(window).on('resize', function () {
           // google.maps.event.trigger(map, "resize");
        });

    };

    /**
     * Make the overlay div to cover the whole widget.
     */
    var fixOverlay = function () {
        this.$widgetOverlay
            .css('position', 'absolute')
            .css('z-index', 1000) // should be higher enough but lower than widget controls
            .width(this.widgetObject.width())
            .height(this.widgetObject.height());
    };

    /**
     * Automatically open settings popup when new widget added
     */
    this.onAdd = function () {
        $.proxy(openPopup, this)();
    };

    /**
     * Open widget management popup
     */
    var openPopup = function (e) {
        if(typeof e !== 'undefined'){
            e.preventDefault();
        }

        var context = this; // store current context for $.proxy bellow. http://api.jquery.com/jquery.proxy/
        $(context.modalId).remove(); //remove any existing popup. This could happen if other widget is in management state right now.

        //get popup HTML using AJAX. See AdminController.php widgetPopupHtml function
        var data = {
            aa: 'KbWidgets.widget',
            widget: 'maps',
            action: 'widgetPopupHtml',
            id: context.widgetObject.data('widgetid'),
            securityToken: ip.securityToken
        };

        $.ajax({
            url: ip.baseUrl,
            data: data,
            dataType: 'json',
            type: 'GET',
            success: function (response) {
                //create new popup
                var $popupHtml = $(response.data.popup);
                $('body').append($popupHtml);
                var $popup = $(context.modalId);
                $popup.modal();
                ipInitForms(); //This is standard ImpressPages function to initialize JS specific form fields
                $popup.find('.ipsConfirm').on('click', $.proxy(parseAddress, context)); //submit form on "Confirm" button click
                $popup.find('form').on('ipSubmitResponse', $.proxy(save, context)); //save form data if form has been successfully validated by PHP (AdminController.php -> checkForm)
            },
            error: function (response) {
                alert('Error: ' + response.responseText);
            }

        });
    };

    var parseAddress = function(e){
        e.preventDefault();

        var context = this;
        var $popup = $(context.modalId);
        var geocoder = new google.maps.Geocoder();
        var $address = $popup.find('input[name=address]');
        var lat = $popup.find('input[name=lat]');
        var lng = $popup.find('input[name=lng]');

        geocoder.geocode({
            'address': $address.val()
        }, function (results, status) {

            if (status === google.maps.GeocoderStatus.OK) {

                lat.val(results[0].geometry.location.lat());
                lng.val(results[0].geometry.location.lng());

            } else {
                console.log("Geocode was not successful for the following reason: " + status);
            }
            $popup.find('form').submit();
        });
    };

    /**
     * Permanently store widget's data and destroy the popup
     * @param e
     * @param response
     */
    var save = function (e, response) {
        this.widgetObject.save(response.data.data, 1); // save and reload widget
        var $popup = $(this.modalId);
        $popup.modal('hide');
    };
};

