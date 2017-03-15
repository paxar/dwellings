<?php
/*
Template Name: Template donation page
*/
?>

<?php get_header() ?>
    <main id="content" class="site-content">
        <?php
        while ( have_posts() ) : the_post();

            get_template_part( 'template-parts/content', 'page' );

        endwhile; // End of the loop.
        ?>
        <div class="container">
            <section class="donation">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="cover-organization">
                            <iframe width="100%" height="300px" src="<?php echo get_theme_mod('cover_organization-url'); ?>" frameborder="0" allowfullscreen>
                            </iframe>
                        </div>
                        <h2 class="title-cover">
                            <?php echo get_theme_mod('cover_title'); ?>
                        </h2>
                        <p class="description-cover">
                            <?php echo get_theme_mod('cover_description'); ?>
                        </p>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="donation-wrap">
                            <div class="form-headers">
                                <div class="form-header first current"> 1. Amount </div>
                                <div class="form-header second"> 2. Payment </div>
                                <div class="form-header third"> 3. Thank You! </div>
                            </div>
                            <div class="page1">
                                <p>Donation amount </p>
                                <div id="amounts">
                                    <!--                            first row-->
                                    <div class="first-row">
                                        <input type="radio" id="amount25" name="amount" value="25"/>
                                        <label for="amount25">$25</label>
                                        <input type="radio" id="amount50" name="amount" value="50" checked="checked" />
                                        <label for="amount50">$50</label>
                                        <input type="radio" id="amount100" name="amount" value="100"/>
                                        <label for="amount100">$100</label>
                                        <input type="radio" id="amount250" name="amount" value="250"/>
                                        <label for="amount250">$250</label>
                                        <input type="radio" id="amount500" name="amount" value="500"/>
                                        <label for="amount500">$500</label>
                                    </div>
                                    <!--                            second row -->
                                    <div class="second-row">
                                        <input type="radio" id="amount-custom" name="amount" value="custom"/>
                                        <label for="amount-custom">Enter other amount</label>
                                        <input type="text" class="amount-input">
                                    </div>
                                </div>
                                <div id="types">
                                    <p>Donation Type</p>
                                    <input type="radio" id="one-time" name="type" value="one"/>
                                    <label for="one-time">One-time</label>
                                    <input type="radio" id="monthly" name="type" value="monthly" checked="checked" />
                                    <label for="monthly">Monthly</label>
                                </div>
                                <button class="page1-button"> Next </button>
                            </div>

                            <div class="hidden">
                                <div class="page2">
                                    <input type="text" id="input-name">
                                    <input type="email" id="input-email">
                                    <input type="number" id="input-card">
                                    <input type="date" id="input-expiration">
                                    <input type="number" id="input-cv">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

<?php get_footer() ?>