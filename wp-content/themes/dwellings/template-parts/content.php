<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Dwellings_site
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('blog-item'); ?>>
	<div class="image-box">
		<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail();
			}
			else {
				echo '<img src="' . get_bloginfo('stylesheet_directory')
					. '/images/thumbnail-default.jpg" />';
			}
			?>
	</div>
	<div class="content-post-wrap">
	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="post-title">', '</h1>' );
		else :
			the_title( '<h2 class="post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta post-information">
				<?php dwellings_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>

		<?php

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'dwellings' ),
			'after'  => '</div>',
		) );

		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php dwellings_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	</div>
</article><!-- #post-## -->
