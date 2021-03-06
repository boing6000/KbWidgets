(function ($) {
    var parseVideo = function (url) {
        // - Supported YouTube URL formats:
        //   - http://www.youtube.com/watch?v=My2FRPA3Gf8
        //   - http://youtu.be/My2FRPA3Gf8
        //   - https://youtube.googleapis.com/v/My2FRPA3Gf8
        // - Supported Vimeo URL formats:
        //   - http://vimeo.com/25451551
        //   - http://player.vimeo.com/video/25451551
        // - Also supports relative URLs:
        //   - //player.vimeo.com/video/25451551

        url.match(/(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/);

        if (RegExp.$3.indexOf('youtu') > -1) {
            var type = 'youtube';
        } else if (RegExp.$3.indexOf('vimeo') > -1) {
            var type = 'vimeo';
        }

        return {
            type: type,
            id: RegExp.$6
        };
    };

    var methods = {
        init: function () {
            var videos = plyr.setup();

            for (var i = 0; i < videos.length; i++) {
                var video = videos[i];
                var videoSorce = $(video.getMedia());
                var url = parseVideo(videoSorce.data('url') || '');

                video.source({
                    type: 'video',
                    sources: [{
                        src: url.id,
                        type: url.type
                    }]
                });
            }
        },
        update: function (obj) {
            var video = plyr.setup(obj[0]);
            if(video.length > 0){
                var videoSorce = $(video[0].getMedia());
                var url = parseVideo(videoSorce.data('url') || '');

                video[0].source({
                    type: 'video',
                    sources: [{
                        src: url.id,
                        type: url.type
                    }]
                });
            }


        }
    };

    $.fn.kbVideo = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.kbVideo');
        }

    };

    $('.ipWidget-KbVideo .video').kbVideo();
})(jQuery);