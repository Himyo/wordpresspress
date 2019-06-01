<?php
// Template pour les articles
get_header();
?>

<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->
            <div class="contenu">
	            <div class="innercont">
			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();
                
				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo '<a href='.get_the_permalink().'">'.get_the_title().'</a>';?></h5>
                        <p class="card-text"><?php the_excerpt(); ?></p>
                        <?php echo '<a href='.get_the_permalink().'">Consulter</a>';?>
                    </div>
                </div>
                <?php 
				// End the loop.
			endwhile;?>
                </div>
            </div>
            <?php
			// Previous/next page navigation.
			the_posts_pagination(
				array(
					'prev_text'          => __( 'Previous page', 'mythemelg' ),
					'next_text'          => __( 'Next page', 'mythemelg' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'mythemelg' ) . ' </span>',
				)
			);
		endif;
		?>

		</main><!-- .site-main -->
    </div><!-- .content-area -->
<?php get_footer(); ?>