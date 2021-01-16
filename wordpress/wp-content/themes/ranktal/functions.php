<?php
function ranktal_register_styles(){   
    // Bootstrap CSS
    wp_enqueue_style( 'ranktal-bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css",array(),"4.1.3" );
    // Font Awesome Icons CSS For all types of styles solid regular light
    wp_enqueue_style( 'ranktal-fontawesome', get_template_directory_uri() . "/assets/fontawesome/css/all.min.css",array(),"5.12.1" );
    // Ranktal CSS
    // get theme version
    $version = wp_get_theme()->get('Version');
    wp_enqueue_style( 'ranktal-main', get_template_directory_uri() . "/style.css",array('ranktal-bootstrap'),$version );

}
add_action( 'wp_enqueue_scripts', 'ranktal_register_styles' );


function ranktal_register_scripts(){
    // jQuery first, then Popper.js, then Bootstrap JS
    wp_enqueue_script( 'ranktal-jQuery', "https://code.jquery.com/jquery-3.5.1.min.js", array(), '3.5.1', true );
    wp_enqueue_script( 'ranktal-Popper', "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js", array('ranktal-jQuery'), '1.14.3', true );
    wp_enqueue_script( 'ranktal-Bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js", array('ranktal-Popper'), '4.1.3', true );
    wp_enqueue_script( 'ranktal-jQuery-mobile', get_template_directory_uri() . '/assets/js/jquery.mobile.custom.min.js', array('ranktal-jQuery'), '1.5.0-rc1', true );
    // Ranktal javascript
    // get theme version
    $version = wp_get_theme()->get('Version');
    wp_enqueue_script( 'ranktal-main', get_template_directory_uri() . '/assets/js/main.js', array(), $version, true );

}
add_action( 'wp_enqueue_scripts', 'ranktal_register_scripts' );

function ranktal_theme_support(){
    // Add Dynamic title tag support
    add_theme_support('title-tag');
    // Add featured image support
    add_theme_support( 'post-thumbnails');
    // Adding Excerpts to Pages 
    add_post_type_support( 'page', 'excerpt' );

}
add_action('after_setup_theme','ranktal_theme_support');

function ranktal_menus(){
    $locations = array(
        'primary' => "Top navigation menu",
        'footer' => "Footer menu items"
    );
    register_nav_menus($locations);
}
add_action( 'init', 'ranktal_menus' );

// Bootstrap pagination
function ranktal_wpbs_pagination($pages = '', $range = 2){  
	$showitems = ($range * 2) + 1;  
	global $paged;
	if(empty($paged)) $paged = 1;
	if($pages == '')
	{
		global $wp_query; 
		$pages = $wp_query->max_num_pages;
	
		if(!$pages)
			$pages = 1;		 
	}   
	
	if(1 != $pages)
	{
	    echo '<nav aria-label="Page navigation" role="navigation">';
        echo '<span class="sr-only">Page navigation</span>';
        echo '<ul class="pagination justify-content-center ft-wpbs">';
		
        echo '<li class="page-item disabled hidden-md-down d-none d-lg-block"><span class="page-link">Page '.$paged.' of '.$pages.'</span></li>';
	
	 	if($paged > 2 && $paged > $range+1 && $showitems < $pages) 
			echo '<li class="page-item"><a class="page-link" href="'.get_pagenum_link(1).'" aria-label="First Page">&laquo;<span class="hidden-sm-down d-none d-md-block"> First</span></a></li>';
	
	 	if($paged > 1 && $showitems < $pages) 
			echo '<li class="page-item"><a class="page-link" href="'.get_pagenum_link($paged - 1).'" aria-label="Previous Page">&lsaquo;<span class="hidden-sm-down d-none d-md-block"> Previous</span></a></li>';
	
		for ($i=1; $i <= $pages; $i++)
		{
		    if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
				echo ($paged == $i)? '<li class="page-item active"><span class="page-link"><span class="sr-only">Current Page </span>'.$i.'</span></li>' : '<li class="page-item"><a class="page-link" href="'.get_pagenum_link($i).'"><span class="sr-only">Page </span>'.$i.'</a></li>';
		}
		
		if ($paged < $pages && $showitems < $pages) 
			echo '<li class="page-item"><a class="page-link" href="'.get_pagenum_link($paged + 1).'" aria-label="Next Page"><span class="hidden-sm-down d-none d-md-block">Next </span>&rsaquo;</a></li>';  
	
	 	if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) 
			echo '<li class="page-item"><a class="page-link" href="'.get_pagenum_link($pages).'" aria-label="Last Page"><span class="hidden-sm-down d-none d-md-block">Last </span>&raquo;</a></li>';
	
	 	echo '</ul>';
        echo '</nav>';
        //echo '<div class="pagination-info mb-5 text-center">[ <span class="text-muted">Page</span> '.$paged.' <span class="text-muted">of</span> '.$pages.' ]</div>';	 	
	}
}

function ranktal_widget_areas(){

    // Left Menu Area
    register_sidebar(array(
        'before_title' => '',
        'after_title' => '',
        'before_widget' => '',
        'after_widget' => '',
        'name' => 'Left Menu Area',
        'id' => 'left-menu',
        'description' => 'Left Nav Menu Area'
    ));

    // Above Footer Area
    register_sidebar(array(
        'before_title' => '',
        'after_title' => '',
        'before_widget' => '',
        'after_widget' => '',
        'name' => 'Above Footer Area',
        'id' => 'before_footer',
        'description' => 'Above Footer Area (Included in search, single post, blog, 404, tags and catagories pages)'
    ));

    // Social Links Area Above Footer
    register_sidebar(array(
        'before_title' => '<div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0"> <h6 class="mb-0 white">',
        'after_title' => '</h6> </div> <div class="social-area col-md-6 col-lg-7 text-center text-md-right">',
        'before_widget' => '<div class="row py-4 d-flex align-items-center">',
        'after_widget' => '</div>',
        'name' => 'Social Links Area',
        'id' => 'social',
        'description' => 'Social Links Area Above Footer'

    ));

    // Ranktal About Area (First Column In Footer)
    register_sidebar(array(
        'before_title' => '<h6 class="text-uppercase font-weight-bold">',
        'after_title' => '</h6> <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">',
        'before_widget' => '<div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">',
        'after_widget' => '</div>',
        'name' => 'About Area',
        'id' => 'about',
        'description' => 'Ranktal About Area (First Column In Footer)'

    ));

    // Ranktal Products Area (Second Column In Footer)
    register_sidebar(array(
        'before_title' => '<h6 class="text-uppercase font-weight-bold">',
        'after_title' => '</h6> <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">',
        'before_widget' => '<div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">',
        'after_widget' => '</div>',
        'name' => 'Products Area',
        'id' => 'products',
        'description' => 'Ranktal Products Area (Second Column In Footer)'

    ));

    // Ranktal Links Area (Third Column In Footer)
    register_sidebar(array(
        'before_title' => '<h6 class="text-uppercase font-weight-bold">',
        'after_title' => '</h6> <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">',
        'before_widget' => '<div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">',
        'after_widget' => '</div>',
        'name' => 'Links Area',
        'id' => 'links',
        'description' => 'Ranktal Links Area (Third Column In Footer)'

    ));

    // Ranktal Contact Area (Fourth Column In Footer)
    register_sidebar(array(
        'before_title' => '<h6 class="text-uppercase font-weight-bold">',
        'after_title' => '</h6> <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">',
        'before_widget' => '<div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">',
        'after_widget' => '</div>',
        'name' => 'Contact Area',
        'id' => 'contact',
        'description' => 'Ranktal Contact Area (Fourth Column In Footer)'

    ));

    // Ranktal Footer Copyright Area
    register_sidebar(array(
        'before_title' => '',
        'after_title' => '',
        'before_widget' => '<div class="copyright text-center py-3 bcolor-3">',
        'after_widget' => '</div>',
        'name' => 'Copyright Area',
        'id' => 'copyright',
        'description' => 'Ranktal Footer Copyright Area'

    ));
}
add_action('widgets_init','ranktal_widget_areas');

// Advanced Custom Feilds
include_once('acf.php');

// Custom Post Types
include_once('custom-post-types.php');