<?php
/*
Template Name: Template profile page
*/
?>
<?php get_header(); ?>



	<main id="content" class="site-content">

	<section class="testimonials">
		<div class="container">
			<div class="buttons-wrap">
				<a href="<?php echo home_url() . '/my-campaigns/';?>" class="btn btn-profile">My campaigns</a>
				<a href="<?php echo home_url() . '/my-donations/';?>" class="btn btn-profile">Campaign donations</a>
			</div>
			<?php echo do_shortcode('[charitable_profile]'); ?>
		</div>
	</section>

<?php get_footer();
