(function ($) {
    'use strict';

    function ovic_cols($isotope) {
        var row   = 1,
            width = $isotope.width(),
            col   = $isotope.attr("data-cols");

        if (col === undefined || col === 0) {
            return 0;
        }
        if (col == "1") {
            return 1;
        }
        if (col == "2") {
            row = 2;
            if (width < 600) {
                row = 1;
            } else if (width >= 600) {
                row = 2;
            }
            return row;
        }
        if (col == "3") {
            row = 3;
            if (width < 600) {
                row = 1;
            } else if (width >= 600 && width < 940) {
                row = 2;
            } else if (width >= 940) {
                row = 3;
            }
            return row;
        }
        if (col == "4") {
            row = 4;
            if (width < 600) {
                row = 1;
            } else if (width >= 600 && width < 940) {
                row = 2;
            } else if (width >= 940 && width < 1170) {
                row = 3;
            } else if (width >= 1170) {
                row = 4;
            }
            return row;
        }
        if (col == "5") {
            row = 5;
            if (width < 480) {
                row = 1;
            } else if (width >= 480 && width < 720) {
                row = 2;
            } else if (width >= 720 && width < 940) {
                row = 3;
            } else if (width >= 940 && width < 1170) {
                row = 4;
            } else if (width >= 1170) {
                row = 5;
            }
            return row;
        }
        if (col == "6") {
            row = 6;
            if (width < 480) {
                row = 1;
            } else if (width >= 480 && width < 720) {
                row = 2;
            } else if (width >= 720 && width < 940) {
                row = 3;
            } else if (width >= 940 && width < 1170) {
                row = 4;
            } else if (width >= 1170) {
                row = 6;
            }
            return row;
        }
    }

    function ovic_grid($isotope) {
        if (ovic_cols($isotope) !== 0) {
            var col   = ovic_cols($isotope),
                item  = $isotope.find('.isotope-item'),
                width = $isotope.width(),
                row   = width / col;
            row       = Math.floor(row);
            item.css('width', row);
        }
    }

    $.fn.ovic_isotope = function () {
        var $isotope = $(this);
        $isotope.on('ovic_isotope', function () {
            $isotope.each(function () {
                var $this   = $(this),
                    $layout = $this.data('layout'),
                    $grid   = $this.isotope({
                        percentPosition: true,
                        itemSelector   : '.isotope-item',
                        layoutMode     : $layout,
                        masonry        : {
                            columnWidth    : 100,
                            fitWidth       : true,
                            horizontalOrder: true
                        }
                    });
                ovic_grid($this);
                $grid.imagesLoaded(function () {
                    $grid.isotope('layout');
                });
            });
        }).trigger('ovic_isotope');
        $(window).on('resize', function () {
            $isotope.trigger('ovic_isotope');
        });
    };

    $(document).on('vc-full-width-row', function (event) {
        if ($(event.target).find('.ovic-isotope').length) {
            $(event.target).find('.ovic-isotope').ovic_isotope();
        }
    });

    $(document).on('ovic_success_load_more_post', function (event, content) {
        if (content !== '') {
            $(event.target).isotope('appended', content, true);
            $(event.target).isotope('reloadItems');
            $(event.target).ovic_isotope();
        }
    });

    window.addEventListener("load", function load() {
        /**
         * remove listener, no longer needed
         * */
        window.removeEventListener("load", load, false);
        /**
         * start functions
         * */
        if ($('.ovic-isotope').length) {
            $('.ovic-isotope').ovic_isotope();
        }
    }, false);

})(window.jQuery);