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

/*About us img circle*/

function avatarHeight() {
    widthImg = $('.avatar-quote').outerWidth();
    $('.avatar-quote').outerHeight(widthImg);
}

avatarHeight();

$(window).resize(avatarHeight);

/*Testimonials block height*/
var maxHeight = 0;
$('.content-quote').each(function(){
    if ( $(this).outerHeight() > maxHeight )
    {
        maxHeight = $(this).outerHeight();
    }
});
$('.content-quote').outerHeight(maxHeight);

/*About us block height*/
function resizeFunc() {
    if (window.matchMedia("(min-width: 1400px)").matches) {
        var maxHeight = $('.about-wrap-img img').outerHeight();
        $('.about-us').each(function(){
            if ( $(this).outerHeight() < maxHeight )
            {
                $('.about-us').outerHeight(maxHeight);
            }
        });
    }
    if (window.matchMedia("(min-width: 768px)").matches) {
        heghtImg = $('.about-us').outerHeight();
        $('.about-wrap-img').outerHeight(heghtImg);
    }
}
resizeFunc();
$(window).resize(resizeFunc);

/*Contact us block height*/
if (window.matchMedia("(min-width: 768px)").matches) {
    var contactHeight = 400;
    $('.contact-info').each(function () {
        if ($(this).height() > contactHeight) {
            contactHeight = $(this).height();
        }
    });
    $('.contact-info').height(contactHeight);
}



