<?php
function cptui_register_my_cpts() {

	/**
	 * Post Type: Clients.
	 */

	$labels = [
		"name" => __( "Clients", "Ranktal" ),
		"singular_name" => __( "Client", "Ranktal" ),
	];

	$args = [
		"label" => __( "Clients", "Ranktal" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "client", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-groups",
		"supports" => [ "title", "editor", "thumbnail" ],
	];

	register_post_type( "client", $args );

	/**
	 * Post Type: Features.
	 */

	$labels = [
		"name" => __( "Features", "Ranktal" ),
		"singular_name" => __( "Feature", "Ranktal" ),
	];

	$args = [
		"label" => __( "Features", "Ranktal" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "feature", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-chart-area",
		"supports" => [ "title", "editor", "thumbnail" ],
	];

	register_post_type( "feature", $args );

	/**
	 * Post Type: Numbers.
	 */

	$labels = [
		"name" => __( "Numbers", "Ranktal" ),
		"singular_name" => __( "Number", "Ranktal" ),
	];

	$args = [
		"label" => __( "Numbers", "Ranktal" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "number", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-cover-image",
		"supports" => [ "title", "editor" ],
	];

	register_post_type( "number", $args );

	/**
	 * Post Type: Perks.
	 */

	$labels = [
		"name" => __( "Perks", "Ranktal" ),
		"singular_name" => __( "Perk", "Ranktal" ),
	];

	$args = [
		"label" => __( "Perks", "Ranktal" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "perk", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-saved",
		"supports" => [ "title", "editor", "thumbnail" ],
	];

	register_post_type( "perk", $args );

	/**
	 * Post Type: Testimonials.
	 */

	$labels = [
		"name" => __( "Testimonials", "Ranktal" ),
		"singular_name" => __( "Testimonial", "Ranktal" ),
	];

	$args = [
		"label" => __( "Testimonials", "Ranktal" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "testimonial", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-format-quote",
		"supports" => [ "title", "editor", "thumbnail", "excerpt" ],
	];

	register_post_type( "testimonial", $args );

	/**
	 * Post Type: Use Cases.
	 */

	$labels = [
		"name" => __( "Use Cases", "Ranktal" ),
		"singular_name" => __( "Use Case", "Ranktal" ),
	];

	$args = [
		"label" => __( "Use Cases", "Ranktal" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "use_case", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-clipboard",
		"supports" => [ "title", "editor", "thumbnail", "excerpt" ],
	];

	register_post_type( "use_case", $args );

	/**
	 * Post Type: Resources.
	 */

	$labels = [
		"name" => __( "Resources", "Ranktal" ),
		"singular_name" => __( "Resource", "Ranktal" ),
	];

	$args = [
		"label" => __( "Resources", "Ranktal" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "resource", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-edit-page",
		"supports" => [ "title", "editor", "thumbnail", "excerpt" ],
	];

	register_post_type( "resource", $args );

	/**
	 * Post Type: Plans.
	 */

	$labels = [
		"name" => __( "Plans", "Ranktal" ),
		"singular_name" => __( "Plan", "Ranktal" ),
	];

	$args = [
		"label" => __( "Plans", "Ranktal" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "plan", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-money-alt",
		"supports" => [ "title", "editor", "excerpt", "page-attributes" ],
	];

	register_post_type( "plan", $args );

	/**
	 * Post Type: FAQs.
	 */

	$labels = [
		"name" => __( "FAQs", "Ranktal" ),
		"singular_name" => __( "FAQ", "Ranktal" ),
	];

	$args = [
		"label" => __( "FAQs", "Ranktal" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "faq", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-format-status",
		"supports" => [ "title", "editor", "page-attributes" ],
	];

	register_post_type( "faq", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );
