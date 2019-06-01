<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<section class="error-404 not-found">
                    <h1 class="page-title">
                        <?php _e( 'Oops! That page can&rsquo;t be found.', 'pixova-lite' ); ?></h1>

					<div class="page-content">
						<p><?php _e( 'It looks like nothing was found at this location. Maybe try a better search?', 'pixova-lite' ); ?></p>

						<?php get_search_form(); ?>

					</div>
				</section>

			</main>
		</div>
	</div>
</div>
<?php get_footer(); ?>