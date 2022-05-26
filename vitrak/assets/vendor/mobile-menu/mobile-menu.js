;(function ($) {
    "use strict"; // Start of use strict

    // BOX MOBILE MENU
    $(document).on('click', '.menu-toggle', function (e) {
        $('.ovic-menu-clone-wrap').addClass('open');
        e.preventDefault();
    });
    // Close box menu
    $(document).on('click', '.ovic-menu-clone-wrap .ovic-menu-close-panels', function (e) {
        $('.ovic-menu-clone-wrap').removeClass('open');
        e.preventDefault();
    });
    $(document).on('click', function (event) {
        if ( $('body').hasClass('rtl') ) {
            if ( event.offsetX < 0 )
                $('.ovic-menu-clone-wrap').removeClass('open');
        } else {
            if ( event.offsetX > $('.ovic-menu-clone-wrap').width() )
                $('.ovic-menu-clone-wrap').removeClass('open');
        }
    });

    // Open next panel
    $(document).on('click', '.ovic-menu-next-panel', function (e) {
        var $this     = $(this),
            thisItem  = $this.closest('.menu-item'),
            thisPanel = $this.closest('.ovic-menu-panel'),
            thisMenu  = $this.closest('.ovic-menu-clone-wrap'),
            target_id = $this.attr('href');

        if ( $(target_id).length ) {
            thisPanel.addClass('ovic-menu-sub-opened');
            $(target_id).addClass('ovic-menu-panel-opened').removeClass('ovic-menu-hidden').attr('data-parent-panel', thisPanel.attr('id'));
            // Insert current panel title
            var item_title     = thisItem.children('a').text(),
                firstItemTitle = '';

            if ( thisMenu.find('.ovic-menu-panels-actions-wrap .ovic-menu-current-panel-title').length > 0 ) {
                firstItemTitle = $('.ovic-menu-panels-actions-wrap .ovic-menu-current-panel-title').html();
            }

            if ( typeof item_title != 'undefined' && typeof item_title != false ) {
                if ( !thisMenu.find('.ovic-menu-panels-actions-wrap .ovic-menu-current-panel-title').length ) {
                    thisMenu.find('.ovic-menu-panels-actions-wrap').prepend('<span class="ovic-menu-current-panel-title"></span>');
                }
                thisMenu.find('.ovic-menu-panels-actions-wrap .ovic-menu-current-panel-title').html(item_title);
            }
            else {
                thisMenu.find('.ovic-menu-panels-actions-wrap .ovic-menu-current-panel-title').remove();
            }

            // Back to previous panel
            thisMenu.find('.ovic-menu-panels-actions-wrap .ovic-menu-prev-panel').remove();
            thisMenu.find('.ovic-menu-panels-actions-wrap').prepend('<a data-prenttitle="' + firstItemTitle + '" class="ovic-menu-prev-panel" href="#' + thisPanel.attr('id') + '" data-cur-panel="' + target_id + '" data-target="#' + thisPanel.attr('id') + '"></a>');
        }

        e.preventDefault();
    });

    // Go to previous panel
    $(document).on('click', '.ovic-menu-prev-panel', function (e) {
        var $this          = $(this),
            cur_panel_id   = $this.attr('data-cur-panel'),
            cur_panel_menu = $this.closest('.ovic-menu-clone-wrap'),
            target_id      = $this.attr('href');

        $(cur_panel_id).removeClass('ovic-menu-panel-opened').addClass('ovic-menu-hidden');
        $(target_id).addClass('ovic-menu-panel-opened').removeClass('ovic-menu-sub-opened');

        // Set new back button
        var new_parent_panel_id = $(target_id).attr('data-parent-panel');
        if ( typeof new_parent_panel_id == 'undefined' || typeof new_parent_panel_id == false ) {
            cur_panel_menu.find('.ovic-menu-panels-actions-wrap .ovic-menu-prev-panel').remove();
            cur_panel_menu.find('.ovic-menu-panels-actions-wrap .ovic-menu-current-panel-title').html('MAIN MENU');
        }
        else {
            cur_panel_menu.find('.ovic-menu-panels-actions-wrap .ovic-menu-prev-panel').attr('href', '#' + new_parent_panel_id).attr('data-cur-panel', target_id).attr('data-target', '#' + new_parent_panel_id);
            // Insert new panel title
            var item_title = $('#' + new_parent_panel_id).find('.ovic-menu-next-panel[data-target="' + target_id + '"]').closest('.menu-item').find('.ovic-menu-item-title').attr('data-title');
            item_title     = $(this).data('prenttitle');
            if ( typeof item_title != 'undefined' && typeof item_title != false ) {
                if ( !cur_panel_menu.find('.ovic-menu-panels-actions-wrap .ovic-menu-current-panel-title').length ) {
                    cur_panel_menu.find('.ovic-menu-panels-actions-wrap').prepend('<span class="ovic-menu-current-panel-title"></span>');
                }
                cur_panel_menu.find('.ovic-menu-panels-actions-wrap .ovic-menu-current-panel-title').html(item_title);
            }
            else {
                cur_panel_menu.find('.ovic-menu-panels-actions-wrap .ovic-menu-current-panel-title').remove();
            }
        }

        e.preventDefault();
    });

})(jQuery); // End of use strict