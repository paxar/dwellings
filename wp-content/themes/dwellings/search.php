<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Dwellings_site
 */

get_header(); ?>

		<main id="main" class="site-content" role="main">
			<div class="container">
				<div class="top-part-content">
					<?php
					custom_breadcrumbs();
					get_search_form();
					?>
				</div>
				<section class="blog-page-section">
		<?php
		if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>
			</section>
				<?php custom_numeric_posts_nav() ?>
		</div>
		</main><!-- #main -->

<?php
get_footer();
