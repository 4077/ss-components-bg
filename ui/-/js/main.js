(function (__nodeNs__, __nodeId__) {
    $.widget(__nodeNs__ + "." + __nodeId__, $.ewma.node, {
        options: {},

        __create: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            w.bind();
        },

        bind: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            var $target = $(o.target);

            var $bg = $("." + __nodeId__ + '__bg');

            if (!$bg.length) {
                $bg = $("<div>")
                    .addClass(__nodeId__ + '__bg')
                    .prependTo($target);
            }

            $bg.css({
                position:        'fixed',
                width:           '100vw',
                height:          '100vh',
                backgroundImage: 'url(' + o.imageSrc + ')'
            });

            var $window = $(window);

            var wh = $window.height();
            var ww = $window.width();
            var dh = $(document).height();
            var bgw = o.imageWidth;
            var bgh = o.imageHeight;

            var renderBackgroundOffset = function () {
                var st = $window.scrollTop();

                var backgroundPositionY;
                var backgroundPositionX = (ww - bgw) / 2;

                if (o.mode === 'parallax') {
                    var stMax = dh - wh;
                    var yMax = dh - bgh;

                    backgroundPositionY = st * (yMax / stMax - 1);
                }

                if (o.mode === 'static') {
                    backgroundPositionY = -st;
                }

                $bg.css({
                    "background-position-y": backgroundPositionY + "px",
                    "background-position-x": backgroundPositionX + "px"
                });
            };

            if (o.mode === 'parallax' || o.mode === 'static') {
                renderBackgroundOffset();

                $window.rebind("scroll." + __nodeId__, function () {
                    renderBackgroundOffset();
                });

                $window.rebind("resize." + __nodeId__, function () {
                    renderBackgroundOffset();
                });
            }

            $window.rebind("resize." + __nodeId__, function () {
                wh = $window.height();
                ww = $window.width();
            });
        },

        update: function (data) {
            var w = this;
            var o = w.options;
            var $w = w.element;

            $.extend(o, data);

            w.bind();

            $(window).trigger("resize." + __nodeId__);
        }
    });
})(__nodeNs__, __nodeId__);
