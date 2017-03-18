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

});

var mainNav = $('#masthead');
    headerWrap = $('.header-wrap');
    fixedScroll = 'fixed-scroll';
    hero = $('.hero').outerHeight();
    siteHeader = $('.site-header');

if ($('section.hero').length) {
    siteHeader.removeClass('header-page');
    $('#container').addClass('container');
    headerWrap.removeClass('container');
    $('.container').css("position", "relative");
    $(window).scroll(function() {
        if( $(this).scrollTop() > hero ) {
            mainNav.addClass(fixedScroll);
            headerWrap.addClass('container');
        }
        else {
            mainNav.removeClass(fixedScroll);
            headerWrap.removeClass('container');
        }
    });
}
else {
    /*Tooltips by paxar*/
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({trigger: 'manual'}).tooltip('show');
    });

    $(".progress-bar").each(function(){
        each_bar_width = $(this).attr('aria-valuenow');
        $(this).width(each_bar_width + '%');
    });


}
