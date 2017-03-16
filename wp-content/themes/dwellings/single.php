<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Dwellings_site
 */

get_header(); ?>

	<main id="content" class="site-content">
		<div class="container">
			<section class="blog-page-section">

				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content-single', get_post_format() );

				endwhile; // End of the loop.
				?>
			</section>
		</div><!-- #primary -->
	</main><!-- #main -->

<?php
get_footer();