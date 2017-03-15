<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Dwellings_site
 */

?>

	</main><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
        <div class="container">
            <div class="site-info">

                <div class="row">
                    <div class="col-xs-12 col-sm-7">
                        <?php the_custom_logo(); ?>
                        <div class="nav-footer">
                            <?php wp_nav_menu(array('them_location' => 'menu-1', 'container' => false, 'menu_class' => 'navigation')) ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-5">
                        <label for="subscribe">Join our newsletter</label>
                        <input id="subscribe" type="text">
                        <input type="button" value="Subscribe">
                    </div>
                    <div class="col-xs-12">
                        <div class="copy">
                            &copy; <?php echo get_theme_mod('copy'); ?>,<?= date(' Y') ?>
                        </div>
                        <div class="implementers">
                            <span class="design">
                                Design by Maria Osadcha
                            </span>
                            <span class="dev">
                                Developed by Geekhub <a href="http://geekhub.ck.ua/">geekhub.ck.ua</a>
                            </span>
                        </div>

                    </div>
                </div>

            </div><!-- .site-info -->
        </div><!-- .scontainer -->
	</footer><!-- #colophon -->
<!--</nav>--><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
