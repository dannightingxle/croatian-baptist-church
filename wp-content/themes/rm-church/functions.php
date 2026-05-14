<?php
/**
 * RM Church child theme functions.
 *
 * Keep this file lean. Site-specific logic belongs in the
 * rm-church-customizations plugin so it survives theme changes.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'hello-elementor', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style(
		'rm-church',
		get_stylesheet_directory_uri() . '/style.css',
		[ 'hello-elementor' ],
		wp_get_theme()->get( 'Version' )
	);
}, 20 );

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );

	register_nav_menus( [
		'menu-1' => __( 'Primary', 'rm-church' ),
		'footer' => __( 'Footer', 'rm-church' ),
	] );
} );
