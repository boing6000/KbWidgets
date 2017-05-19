(function ($) {
    var methods = {
        slider: null,
        init: function () {
            var $this = $(this);

            $this.each(function () {
                var $slideshow = $(this);
                $slideshow.bsTouchSlider();
            });
        }
    };

    $.fn.kbSlideShow = function (method) {

        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.kbSlideshow');
        }
        $(window).trigger('kbSlideShowLoaded');
    };
    $('.ipWidget-KbSlideShow .carousel').kbSlideShow();

})(jQuery);