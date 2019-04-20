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

function bumidatar_social() {
	if ($_SERVER['HTTP_HOST'] == 'bumidatar.id') {
		$twitter = 'bumidatarid';
		$fbw = 104;
	} elseif ($_SERVER['HTTP_HOST'] == 'flatearth.ws') {
		$twitter = 'bumidatarid';
		$fbw = 88;
	} elseif ($_SERVER['HTTP_HOST'] == 'terraplana.ws') {
		$twitter = 'terraplanaws';
		$fbw = 140;
	} elseif ($_SERVER['HTTP_HOST'] == 'tierraplana.ws') {
		$twitter = 'tierraplanaws';
		$fbw = 142;
	} else {
		$twitter = '';
		$fbw = 0;
	}	
	?>
	<div class="social">
		<span class="facebook" style="width: <?php echo $fbw ?>px">
			<div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
		</span>
		<span class="twitter">
			<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-via="<?php echo $twitter ?>" data-show-count="true" data-text="<?php echo esc_html(the_title(false)) ?>"></a>
		</span>
		<!--<span class="google">
			<div class="g-plusone" data-size="medium" data-href="<?php the_permalink(); ?>"></div>
		</span>-->
	</div>
	<?php
}


// change thumbnail size
function jetpackchange_image_size ( $thumbnail_size ) {
 $thumbnail_size['width'] = 300;
 $thumbnail_size['height'] = 300;
// $thumbnail_size['crop'] = true;
 return $thumbnail_size;
}
add_filter( 'jetpack_relatedposts_filter_thumbnail_size', 'jetpackchange_image_size' );
