<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
add_filter( 'prettify_skin', function() { return 'desert'; } );

add_theme_support( 'infinite-scroll', array(
     'container' => 'content',
     'footer' => 'page',
     'footer_widgets' => false,
));

function my_theme_enqueue_styles() {
    $parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}

function bumidatarid_body_classes( $classes ) {
	return array_filter($classes, function($i) { return $i != 'home';});
}
add_filter( 'body_class', 'bumidatarid_body_classes' );

function bumidatarid_seo_conflicted_themes() {
	return [
		'bumidatar-child' => 1,
		'twentyseventeen' => 1,
	];
}
#add_filter('jetpack_seo_meta_tags_conflicted_themes', 'bumidatarid_seo_conflicted_themes');

// change thumbnail size
function jetpackchange_image_size ( $thumbnail_size ) {
 $thumbnail_size['width'] = 300;
 $thumbnail_size['height'] = 300;
// $thumbnail_size['crop'] = true;
 return $thumbnail_size;
}
add_filter( 'jetpack_relatedposts_filter_thumbnail_size', 'jetpackchange_image_size' );
