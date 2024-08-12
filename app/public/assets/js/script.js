jQuery(document).ready(function ($) {
    $(document).on('click', '#openMenu', function (e) {
        e.preventDefault();
        $('.sidebar header').slideToggle();
    });

    $(document).on('click', '.openModal', function (e) {
        e.preventDefault();

        let href = $(this).attr('href');

        $('.modal').fadeOut();
        $(href).fadeIn();
    });

    if (window.location.pathname === '/login') {
        $('#login').show(); // або інша логіка для відкриття модального вікна
    }

    $(document).on('click', '.close, .closeBtn', function (e) {
        e.preventDefault();

        $(this).parents('.modal').fadeOut();
    });

    $(document).click(function(e) {
        if (!$(e.target).closest(".modalWrap, .openModal").length) {
            $('.modal').fadeOut();
        }
    });

    const icons = {
        header: "plusIcon",
        activeHeader: "closeIcon",
    };

    if ($(document).find('#accordion').length > 0) {
        $("#accordion").accordion({
            icons: icons,
            collapsible: true,
            heightStyle: "content",
            active: false,
        });
    }
    if ($(document).find('#tabs').length > 0) {
        $( "#tabs" ).tabs();

        $(document).on('click', '.close', function (e) {
            e.preventDefault();

            $(this).parents('.modal').fadeOut();
        });
    }

    $(document).on('click', '#myWinnings a', function (e) {
        e.preventDefault();
        $(this).toggleClass('checked');
    });

    $(document).on('click', '#changePassword', function (e) {
        $(this).addClass('hidden');
        $('.accountInfoSettings').addClass('hidden');

        $('.accountInfoPassword ').removeClass('hidden');
    });

    $(document).on('click', '#saveNewPassword', function (e) {
        $(this).removeClass('hidden');
        $('.accountInfoSettings').removeClass('hidden');

        $('.accountInfoPassword ').addClass('hidden');
    });

    if ($(document).find('#takeAway').length > 0) {
        $('#phone').mask('+7 (000) 000 00 00 ');
    }

    $(window).scroll(function () {
        if ($(this).scrollTop() > 0) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });
    $('#toTop').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 400);
        return false;
    });

    $(document).on('click', '.rate', function (e) {
        e.preventDefault();

        $('.wheel .rate').removeClass('active');
        $(this).addClass('active');
    })
});
