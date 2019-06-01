<footer>
	<?php 
	// Afficher le menu de pied de page
	wp_nav_menu(array(
		'theme_location' => 'footer_menu'));
	// Afficher la zone de widgets de pied de page
	dynamic_sidebar('my_sidebar_2');
	?>
</footer>
<?php 
// hook
wp_footer();
?>
</body>
</html>