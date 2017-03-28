<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Dwellings_site
 */

get_header(); ?>

	<main id="content" class="site-content blog-page-main">
		<div class="container">
			<div class="top-part-content">
				<?php
				custom_breadcrumbs();
				get_search_form();
				?>
			</div>
			<section class="blog-posts-section single-article-post">

				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content-single', get_post_format() );
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>



			</section>
		</div><!-- #primary -->
	</main><!-- #main -->

<?php
get_footer();