<?php
// Template pour les articles
get_header();

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		if ( has_post_thumbnail() ) {
			the_post_thumbnail();
		} 
		// Post Content here
		the_title();
		the_content();
		echo '<hr>';
	} 
}

dynamic_sidebar('my_sidebar');
get_footer();
?>
