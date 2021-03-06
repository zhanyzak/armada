'use strict';

$( document ).ready(function () {

    // Material select
    $('.mdb-select').materialSelect();

    // Service show contacts

    {
        let serviceItem = $('.service');

        $.each(serviceItem, function () {
            let button = $( this ).find('.service__contacts-wrap > span:first-child');
            let contacts = $( this ).find('.service__contacts');

            button.on('click', function () {
                button.hide();
                contacts.show();
            })
        });
    }

    // Scheme popup

    {
        let popup = $('.popup');
        let popupWidth = popup.width();
        let popupHeight = popup.height();

        let arrow = popup.find('.popup__arrow');
        let close = $('.popup__close');

        let schemeBlock = $('.scheme .svg polygon');

        close.on('click', function(){
           popup.removeAttr('style').removeClass('active');
        });

        $( document ).mouseup(function (e) {
            if (!popup.is(e.target) && popup.has(e.target).length === 0)
            {
                popup.removeAttr('style').removeClass('active');
            }
        });

        $('.scheme').on('scroll', function () {
            popup.removeAttr('style').removeClass('active');
        });

        $.each(schemeBlock, function (e) {
            $( this ).on('click', function () {
                let blockId = $( this ).attr('id');

                let blockOffsetLeft = $( this ).offset().left;
                let blockOffsetTop = $( this ).offset().top;
                let documentWidth = $( document ).width();
                let windowHeight = $( window ).height();

                schemeBlock.removeClass('active');
                $( this ).addClass('active');

                if((documentWidth - blockOffsetLeft) > popupWidth && ((blockOffsetTop - $(window).scrollTop()) < popupHeight)) {
                    popup.css({
                            'top' : blockOffsetTop - 15,
                            'left' : blockOffsetLeft,
                            'transform' : 'translateY(-100%)'
                        });
                    arrow.css({
                        'top' : '100%',
                        'left' : 15,
                        'border-top' : '15px solid #F5F5F5',
                        'border-right' : '15px solid transparent',
                        'border-left' : '15px solid transparent',
                    })
                } else if((blockOffsetTop - $(window).scrollTop()) < popupHeight) {
                    popup.css({
                        'top' : blockOffsetTop,
                        'left' : blockOffsetLeft - 15,
                        'transform' : 'translateX(-100%)'
                    });
                    arrow.removeAttr('style');
                    arrow.css({
                        'top' : 15
                    })
                } else {
                    popup.css({
                        'top' : blockOffsetTop,
                        'left' : blockOffsetLeft - 15,
                        'transform' : 'translateY(-50%) translateX(-100%)'
                    });
                    arrow.removeAttr('style');
                }

                popup.addClass('active');
            })
        })
    }

});