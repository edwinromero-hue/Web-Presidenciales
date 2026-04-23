<?php
/**
 * Theme setup: supports, menús y carga de text domain.
 *
 * @package ActoresElectorales2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'ae_theme_setup' ) ) {
	/**
	 * Registra supports y menús del tema.
	 *
	 * @return void
	 */
	function ae_theme_setup() {
		load_theme_textdomain( 'actores-electorales-2026', AE_THEME_PATH . '/languages' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'custom-logo', array(
			'height'      => 80,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		) );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		) );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );

		register_nav_menus( array(
			'header-main'         => __( 'Menú principal (desktop)', 'actores-electorales-2026' ),
			'mobile-main'         => __( 'Menú principal (móvil / drawer)', 'actores-electorales-2026' ),
			'footer-plataforma'   => __( 'Pie · Plataforma', 'actores-electorales-2026' ),
			'footer-informacion'  => __( 'Pie · Información', 'actores-electorales-2026' ),
			'footer-contacto'     => __( 'Pie · Contacto', 'actores-electorales-2026' ),
		) );
	}
}
add_action( 'after_setup_theme', 'ae_theme_setup' );

if ( ! function_exists( 'ae_content_width' ) ) {
	/**
	 * Registra $content_width.
	 *
	 * @return void
	 */
	function ae_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'ae_content_width', 1280 );
	}
}
add_action( 'after_setup_theme', 'ae_content_width', 0 );
