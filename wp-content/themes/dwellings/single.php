<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Dwellings_site
 */

get_header(); ?>

	<div class="container">
		<main id="main" class="site-content" role="main">
			<section class="blog-page-section">

				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content-single', get_post_format() );

				endwhile; // End of the loop.
				?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();