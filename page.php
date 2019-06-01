<?php
// Template des pages
get_header();

 if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		if ( has_post_thumbnail() ) {
			the_post_thumbnail();
		} 
		the_title();
		the_content();
		echo '<hr>';
	} // end while

get_footer();
?>
