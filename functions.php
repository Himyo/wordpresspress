<?php

/* 
 * Enqueue style & scripts 
 */


add_action('wp_enqueue_scripts', 'loadcss');
function loadcss() {
	wp_enqueue_style('bootstrapStyle', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
	wp_enqueue_script('bootstrapJs', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
	wp_enqueue_style('style', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'loadjs');
function loadjs() {
	wp_register_script('script', get_template_directory_uri().'/js/script,js');
	wp_enqueue_script('script');
}

add_theme_support( 'menus' );
register_nav_menus(
	array(
		'top-menu' => __('Top Menu', 'mythemelg'),
		'footer-menu' => __('Footer Menu', 'mythemelg'),
	)
);
/* 
 * Active la fonctionnalité Image à la Une dans les articles 
 */
add_theme_support( 'post-thumbnails' );

/* 
 * Ajouter des zones de menus au thème
 */

// Hook 'after_setup_theme'
add_action('after_setup_theme','mytheme_menus');

// Initialiser les menus
function mytheme_menus() {
	register_nav_menus(
		array (
			'main_menu' => __('Menu Principal', 'mythemelg'),
			'footer_menu' => __('Menu du pied de page', 'mythemelg'), 
		)
	);
}

 // Get searchform
 function wpdocs_my_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
    <div><label class="screen-reader-text" for="s">' . __( 'Search for:' ) . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__( 'Search' ) .'" />
    </div>
    </form>';
    return $form;
}
add_filter( 'get_search_form', 'wpdocs_my_search_form' ); 

/*
 *Ajouter des zones de widgets au thème
 */

// Hook 'widgets_init'
add_action ('widgets_init', 'mytheme_sidebars');

// Initialiser les zones
function mytheme_sidebars() {
	register_sidebar(array(
		'name' => __('Ma sidebar', 'mythemelg'),
		'id'   => 'my_sidebar',
		'description' => __('Ma bar latérale', 'mythemelg'),
		)
	);
	register_sidebar(array(
		'name' => __('Ma zone de footer', 'mythemelg'),
		'id'   => 'my_sidebar_2',
		'description' => __('les widgets s\'afficheront dans le footer' , 'mythemelg'),
		)
	);
}


/* 
 * Options dans l'onglet 'Apparences' -> 'Personnaliser'
 * The customizer API 
 */
add_action( 'customize_register', 'themeslug_customize_register' );

function themeslug_customize_register( $wp_customize ) {
  // Do stuff with $wp_customize, the WP_Customize_Manager object.
	$wp_customize->add_section('cd_colors', array(
		'title' => __('Couleurs', 'mythemelg'),
		'priority' => 30,
	));
	$wp_customize->add_setting('bg_color', array(
		'default' => '#FFFFFF',
		'transport' => 'refresh',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'bg_color', array(
		'label' => __('Couleur de fond', 'mythemelg'),
		'section' => 'cd_colors',
		'settings' => 'bg_color',
	)));
	$wp_customize->add_setting('background_color2', array(
		'default' => '#FFFFFF',
		'transport' => 'refresh',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'background_color2', array(
		'label' => __('Couleur du texte', 'mythemelg'),
		'section' => 'cd_colors',
		'settings' => 'background_color2',
	)));
	$wp_customize->add_section('media', array(
		'title' => __('Bannière', 'mythemelg'),
		'priority' => 35,
	));
	$wp_customize->add_setting('ban_image', array(
		'default' => '',
		'transport' => 'refresh',
	));
	$wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'ban_image', array(
		'label' => __('Choisir une bannière', 'mythemelg'),
		'section' => 'media',
		'mime_type' => 'image',
	)));
}

// Hook 'wp_head' pour placer la function 'mytheme_customizer_css' dans le header
add_action('wp_head', 'mytheme_customizer_css');

// CSS inline reprenant les valeurs des options sélectionnées en admin
function mytheme_customizer_css() {
	echo '<style>body{background:'.get_theme_mod('bg_color', 'FFF').'; color:'.get_theme_mod('background_color2', 'FFF').';}</style>';
}

/* 
 * Ajouter un nouveau type de contenu
 * Custom Post Type 
 */

// Hook 'init' pour charger la fonction mytheme_post_types()
add_action('init', 'mytheme_post_types');

// Initialiser le type de contenu Cours
function mytheme_post_types() {
	$labels = array(
		'name' => __('Cours', 'mythemelg'),
	); 

	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'show_in_rest' => true,
		'supports' => array(
			'title',
			'thumbnail',
			'editor',
			'custom-fields',
			'post-formats',
			),
		'menu_position' => 5,
		'menu_icon' => 'dashicons-awards',
		'hierarchical' => false,
	);

	register_post_type('cours', $args);
}

// Hook 'init' pour charger la fonction mytheme_custom_taxonomies()
add_action( 'init', 'mytheme_custom_taxonomies', 0 );

//On crée 3 taxonomies personnalisées: Années, Profs et Matières.
function mytheme_custom_taxonomies() {
	
	// Taxonomie Années

	// On déclare ici les différentes dénominations de notre taxonomie qui seront affichées et utilisées dans l'administration de WordPress
	$labels_annee = array(
		'name'              			=> _x( 'Années', 'taxonomy general name'),
		'singular_name'     			=> _x( 'Année', 'taxonomy singular name'),
		'search_items'      			=> __( 'Chercher une année'),
		'all_items'        				=> __( 'Toutes les années'),
		'edit_item'         			=> __( 'Editer l année'),
		'update_item'       			=> __( 'Mettre à jour l année'),
		'add_new_item'     				=> __( 'Ajouter une nouvelle année'),
		'new_item_name'     			=> __( 'Valeur de la nouvelle année'),
		'separate_items_with_commas'	=> __( 'Séparer les Professeurs avec une virgule'),
		'menu_name'         => __( 'Année'),
	);

	$args_annee = array(
	// Si 'hierarchical' est défini à false, notre taxonomie se comportera comme une étiquette standard
		'hierarchical'      => false,
		'labels'            => $labels_annee,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'annees' ),
		'show_in_rest' => true,
	);

	register_taxonomy( 'annees', 'cours', $args_annee );

	// Taxonomie Profs
	
	$labels_profs = array(
		'name'                       => _x( 'Professeurs', 'taxonomy general name'),
		'singular_name'              => _x( 'Professeur', 'taxonomy singular name'),
		'search_items'               => __( 'Rechercher un Professeur'),
		'popular_items'              => __( 'Professeurs populaires'),
		'all_items'                  => __( 'Tous les Professeurs'),
		'edit_item'                  => __( 'Editer un Professeur'),
		'update_item'                => __( 'Mettre à jour un Professeur'),
		'add_new_item'               => __( 'Ajouter un nouveau Professeur'),
		'new_item_name'              => __( 'Nom du nouveau Professeur'),
		'separate_items_with_commas' => __( 'Séparer les Professeurs avec une virgule'),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer un Professeur'),
		'choose_from_most_used'      => __( 'Choisir parmi les plus utilisés'),
		'not_found'                  => __( 'Pas de Professeurs trouvés'),
		'menu_name'                  => __( 'Professeurs'),
	);

	$args_profs = array(
		'hierarchical'          => false,
		'labels'                => $labels_profs,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'profs' ),
		'show_in_rest' => true,
	);

	register_taxonomy( 'profs', 'cours', $args_profs );
	
	// Taxonomie Matières

	$labels_cat_cours = array(
		'name'                       => _x( 'Matières', 'taxonomy general name'),
		'singular_name'              => _x( 'Matière', 'taxonomy singular name'),
		'search_items'               => __( 'Rechercher une matière'),
		'popular_items'              => __( 'matières populaires'),
		'all_items'                  => __( 'Toutes les matières'),
		'edit_item'                  => __( 'Editer une matière'),
		'update_item'                => __( 'Mettre à jour une matière'),
		'add_new_item'               => __( 'Ajouter une nouvelle matière'),
		'new_item_name'              => __( 'Nom de la nouvelle matière'),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer une matière'),
		'choose_from_most_used'      => __( 'Choisir parmi les matières les plus utilisées'),
		'not_found'                  => __( 'Pas de matières trouvées'),
		'menu_name'                  => __( 'Matières'),
	);

	$args_cat_cours = array(
	// Si 'hierarchical' est défini à true, notre taxonomie se comportera comme une matière standard
		'hierarchical'          => true,
		'labels'                => $labels_cat_cours,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'categories-cours' ),
		'show_in_rest' => true,
	);

	register_taxonomy( 'matiere', 'cours', $args_cat_cours );
}


/*
 * Sélectionner un semestre
 * Champs personnalisé pour le custom post type 
 */

// Hook 'add_meta_boxes' pour charger mytheme_add_custom_metabox()
add_action('add_meta_boxes', 'mytheme_add_custom_metabox');

// Initialiser le champs personnalisé Semestre
function mytheme_add_custom_metabox() {
    $cours = ['cours'];
    foreach ($cours as $cour) {
        add_meta_box(
            'custom_metabox_id', // Unique ID
            'Semestre',  // Box title
            'mytheme_custom_metabox_html',  // Content callback, must be of type callable
            $cour  // Post type
        );
    }
}

// Formulaire du champs personnalisé - ici un menu déroulant avec 2 options possibles
function mytheme_custom_metabox_html($post) {
	$value = get_post_meta($post->ID, '_mymetabox_key', true);
    ?>
    <label for="mymetabox_field">A quel semestre a lieu ce cours?</label>
    <select name="mymetabox_field" id="mymetabox_field" class="postbox">
        <option value="">Selectionner le semestre...</option>
        <option value="semestre1" <?php selected($value, 'semestre1'); ?>>Semestre 1</option>
        <option value="semestre2" <?php selected($value, 'semestre2'); ?>>Semestre 2</option>
    </select>
    <?php
}

// Hook 'save_post' pour charger mytheme_save_postdata()
add_action('save_post', 'mytheme_save_postdata');

// Sauvegarder l'option sélectionnée dans le champs personnalisé Semestre
function mytheme_save_postdata($post_id) {
    if (array_key_exists('mymetabox_field', $_POST)) {
        update_post_meta(
            $post_id,
            '_mymetabox_key',
            $_POST['mymetabox_field']
        );
    }
}
