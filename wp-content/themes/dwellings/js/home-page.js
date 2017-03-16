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

if ($('section.hero').length) {
    $('.site-header').removeClass('header-page');
    $('#container').addClass('container');
    $('.header-wrap').removeClass('container');
}
else {
    $('#close-nav').click(function () {
        $('.site-header').addClass('header-page');
        $('#container').removeClass('container');
        $('.header-wrap').addClass('container');
    });
    $('#open-nav').click(function () {
        $('.site-header').removeClass('header-page');
        $('#container').addClass('container');
        $('.header-wrap').removeClass('container');
    });
}