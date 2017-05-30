<?php
/*
Template Name: Template donate page
*/
?>
<?php get_header() ?>
    <main id="content" class="site-content">

        <section class="donation">
            <div class="container">
                <div class="donation-block">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="organization-wrap">
                                <div class="cover-organization">

                                    <?php if (get_theme_mod('cover_organization-url') != ''): ?>
                                        <iframe width="100%" height="300px" src="<?php echo get_theme_mod('cover_organization-url'); ?>"
                                                frameborder="0" allowfullscreen>
                                        </iframe>
                                    <?php endif; ?>

                                </div>
                                <h2 class="title-cover">

                                    <?php if (get_theme_mod('cover_title') != ''): ?>
                                        <?php echo get_theme_mod('cover_title'); ?>
                                    <?php endif; ?>

                                </h2>

                                <?php if (get_theme_mod('cover_description') != ''): ?>
                                <p class="description-cover">
                                    <?php echo get_theme_mod('cover_description'); ?>
                                </p>
                                <?php endif; ?>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="donation-wrap">
                                <div id="mc5h7l7zhkkym9"><a href="https://app.moonclerk.com/pay/5h7l7zhkkym9">Dwellings General Donations</a></div><script type="text/javascript">var mc5h7l7zhkkym9;(function(d,t) {var s=d.createElement(t),opts={"checkoutToken":"5h7l7zhkkym9","width":"100%"};s.src='https://d2l7e0y6ygya2s.cloudfront.net/assets/embed.js';s.onload=s.onreadystatechange = function() {var rs=this.readyState;if(rs) if(rs!='complete') if(rs!='loaded') return;try {mc5h7l7zhkkym9=new MoonclerkEmbed(opts);mc5h7l7zhkkym9.display();} catch(e){}};var scr=d.getElementsByTagName(t)[0];scr.parentNode.insertBefore(s,scr);})(document,'script');</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php get_footer() ?>