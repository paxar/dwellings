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

$.fn.swap = function(b) {
    var a = this; b = $(b);
    var tmp = $('<span>').hide();
    a.before(tmp);
    b.before(a);
    tmp.replaceWith(b);
};

$(() => {
    // Inputs functionality
    function changeAmount() {
        if (customRadio.prop('checked')) {
            customInput.css('visibility', 'initial');
        } else customInput.css('visibility', 'hidden');
    }

    var customRadio = $('input#amount-custom');
    var customInput = $('input.amount-input');

    $('#amounts').on('change', changeAmount);
    changeAmount();

    // Page switching/swapping
    function switchPages(oldP, newP, cb) {
        newP.fadeOut();
        oldP.fadeOut('slow', () => {
            oldP.swap(newP);
            newP.fadeIn('slow');
            if (cb) cb();
        });

    }
    function setCurrentPage(index) {
        $('.form-headers .form-header').each((i, el) => {
            curPage = pageArr[index];
            el = $(el);
            (i === index) ? el.addClass('current') : el.removeClass('current');
        })
    }

    var pageArr = [$('.page1'), $('.page2'), $('.page3')];
    var [page1, page2, page3] = pageArr;
    var curPage = null;
    setCurrentPage(0);

    $('.page1-button').on('click', () => {
        switchPages(page1, page2, () => { setCurrentPage(1); });
    });
    [$('.form-header.first'), $('.form-header.second')].forEach((el, i) =>{
        el.on('click', function() {
            if (!(pageArr[i] === curPage)) {
                switchPages(curPage, pageArr[i], () => { setCurrentPage(i); });
            }
        });
    });

});