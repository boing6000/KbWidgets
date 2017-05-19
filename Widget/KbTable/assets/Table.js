/**
 * Widget initialization and management script
 * If you rename the widget, replace WidgetSkeleton instance to the new name
 *
 */

var IpWidget_KbTable = function () {

    this.widgetObject = null;
    this.widgetOverlay = null;

    this.modalId = '#kbWidgetsTable .ipsModal';

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
        var context = this;
        this.$button = this.widgetObject.find('.ipsWidgetEdit');
        this.$button.on('click', $.proxy(openPopup, context));

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
    var openPopup = function (ev) {
        ev.preventDefault();
        var context = this; // store current context for $.proxy bellow. http://api.jquery.com/jquery.proxy/
        $(context.modalId).remove(); //remove any existing popup. This could happen if other widget is in management state right now.

        //get popup HTML using AJAX. See AdminController.php widgetPopupHtml function
        var data = {
            aa: 'KbWidgets.widget',
            widget: 'table',
            action: 'widgetPopupHtml',
            id: this.widgetObject.data('widgetid'),
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
                $popup.find('.ipsConfirm').on('click', function(e){e.preventDefault(); $popup.find('form').submit();}); //submit form on "Confirm" button click
                $popup.find('form').on('ipSubmitResponse', $.proxy(save, context)); //save form data if form has been successfully validated by PHP (AdminController.php -> checkForm)
            },
            error: function (response) {
                alert('Error: ' + response.responseText);
            }

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

