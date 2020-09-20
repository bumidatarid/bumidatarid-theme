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

    if ( is_rtl() ) {
	wp_enqueue_style( 'child-style-rtl', get_template_directory_uri() . '/rtl.css', array(), wp_get_theme()->get('Version') );
    }	
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


function bumidatar_fonts_url() {
    $fonts_url = '';
    $font_families = array();

    $font_families[] = 'Lato:300,400,700';
    $font_families[] = 'Open Sans::400,400i,700,700i';
    $font_families[] = 'Open Sans Condensed::300';

    $query_args = array(
        'family' => urlencode( implode( '|', $font_families ) ),
        'subset' => urlencode( 'latin,latin-ext' ),
    );

    $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

    return esc_url_raw( $fonts_url );
}

function mb_scripts(){
    wp_dequeue_style( 'twentyseventeen-fonts');
    wp_enqueue_style( 'bumidatar-fonts', bumidatar_fonts_url(), array(), null );
}
add_action('wp_enqueue_scripts','mb_scripts',11);

function twentyseventeen_posted_on() {
}
function twentyseventeen_time_link() {
}

// change thumbnail size
function jetpackchange_image_size ( $thumbnail_size ) {
 $thumbnail_size['width'] = 300;
 $thumbnail_size['height'] = 300;
// $thumbnail_size['crop'] = true;
 return $thumbnail_size;
}
add_filter( 'jetpack_relatedposts_filter_thumbnail_size', 'jetpackchange_image_size' );
