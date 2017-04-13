<?php
/*
Template Name: Template new campaign
*/
?>
<?php get_header() ?>
	<main id="content" class="site-content blog-page-main">

	<section>
		<div class="container">
			<?php
			global $current_user;



			if ($current_user->ID == '') {
				echo do_shortcode('[charitable_login]');
			}
			else {
				echo do_shortcode('[charitable_submit_campaign]');
			}

			?>


		</div>
	</section>

<?php get_footer() ?>