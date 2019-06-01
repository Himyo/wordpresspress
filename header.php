<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset');?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<?php 
	// hook
	wp_head();?>
</head
<body <?php body_class() ?> >
	<header class="sticky-top">

		<div class="header-container">
			<div class="header-nav">
				<?php 
					wp_nav_menu(array('theme_location' => 'top-menu')); 
				?>
			</div>
			<div class="header-search">
				<?php get_search_form(); ?>
			</div>
		</div>

		<?php 
		// Afficher l'image d'en-tête
		$id = get_theme_mod('ban_image');
			if ($id != 0) {
        			$url = wp_get_attachment_url($id);
			        echo '<div style="margin-bottom: 30px;">';
			        echo '<img src="' . $url . '" alt="" />';
			        echo '</div>';
			    }
		?>
	</header>