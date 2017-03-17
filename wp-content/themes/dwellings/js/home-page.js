$(document).ready(function () {
    $('#close-nav').click(function () {
        $('.navigation').slideUp(300);
        $('#open-nav').removeClass("remove-btn");
        $('#close-nav').addClass("remove-btn")
    });

    $('#open-nav').click(function () {
        $('.navigation').slideDown(300);
        $('#close-nav').removeClass("remove-btn");
        $('#open-nav').addClass("remove-btn")
    });
    var main_nav = $("#masthead");
    page_nav = $("#container");
    fixed_scroll = "fixed-scroll";
    hero = $('.hero').outerHeight();
    nav = $('.header-wrap').outerHeight();

    $(window).scroll(function() {
        if( $(this).scrollTop() > hero ) {
            main_nav.addClass(fixed_scroll);
            $('.header-wrap').addClass('container');
        }

        else {
            main_nav.removeClass(fixed_scroll);
            $('.header-wrap').removeClass('container');
        }
    });
});

if ($('section.hero').length) {
    $('.site-header').removeClass('header-page');
    $('#container').addClass('container');
    $('.header-wrap').removeClass('container');
    $('.container').css("position", "relative");
}
else {
    $(window).scroll(function() {
        if( $(this).scrollTop() > 0 ) {
            page_nav.addClass(fixed_scroll);
            nav.addClass('container');
        }
        else {
            page_nav.removeClass(fixed_scroll);
            nav.removeClass('container');
        }
    });


    /*Tooltips by paxar*/
    $('[data-toggle="tooltip"]').tooltip('show');

}
