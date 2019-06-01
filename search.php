
<?php get_header(); ?>
<?php

if (have_posts()) : while( have_posts()) : the_post();?>
<div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo '<a href='.get_the_permalink().'">'.get_the_title().'</a>';?></h5>
                <p class="card-text"><?php the_excerpt(); ?></p>
                <?php echo '<a href='.get_the_permalink().'">Consulter</a>';?>
            </div>
        </div>
<?php endwhile; else : ?>
<p><?php esc_html_e('Sorry, no posts matched your criteria'); ?></p>
<?php endif; ?> 