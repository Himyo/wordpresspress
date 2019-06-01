<?php get_header(); ?>

    <div class="container" id="front-page">
        <?php if(have_posts()) : while (have_posts()) : the_post(); ?>

        <article class="container" id="front-page-article">
            <h1 class="article-title"><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </article>
        <?php endwhile; endif; ?>
    </div>

<?php get_footer(); ?>