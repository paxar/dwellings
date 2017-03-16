function init() {
    var mcmeqeil46hzy;
    (function (d, t) {
        var s = d.createElement(t), opts = {"checkoutToken": "meqeil46hzy", "width": "100%"};
        s.src = 'https://d2l7e0y6ygya2s.cloudfront.net/assets/embed.js';
        s.onload = s.onreadystatechange = function () {
            var rs = this.readyState;
            if (rs) if (rs != 'complete') if (rs != 'loaded') return;
            try {
                mcmeqeil46hzy = new MoonclerkEmbed(opts);
                mcmeqeil46hzy.display();
            } catch (e) {
                console.log(e);
            }
        };
        var scr = d.getElementsByTagName(t)[0];
        scr.parentNode.insertBefore(s, scr);
    })(document, 'script');

}

$(() => {
    // init script only if on a certain page (with donation form)
    if ($('.donation-wrap').length) {
        console.log('donation scripts loaded');
        init();
    }
});