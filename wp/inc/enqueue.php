<?php
/**
 * Enqueue de estilos y scripts del tema.
 *
 * Preserva el orden y dependencias del proyecto estático original:
 *   Google Fonts (Manrope + Archivo) → styles.css → GSAP → ScrollTrigger
 *   → shell.js → scrolly.js → inicio.js (solo home).
 *
 * @package ActoresElectorales2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'ae_enqueue_assets' ) ) {
	/**
	 * Carga fuentes, estilos y scripts del front-end.
	 *
	 * @return void
	 */
	function ae_enqueue_assets() {
		// ── Preconnects (vía filter de wp_resource_hints más abajo) ──

		// ── Google Fonts: Manrope + Archivo con display=swap ──
		wp_enqueue_style(
			'ae-google-fonts',
			'https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Archivo:wght@400;500;600;700;800&display=swap',
			array(),
			null
		);

		// ── Stylesheet principal del tema ──
		wp_enqueue_style(
			'ae-theme-styles',
			AE_THEME_URI . '/assets/css/styles.css',
			array( 'ae-google-fonts' ),
			AE_THEME_VERSION
		);

		// style.css oficial (metadatos WP) — cargado por cortesía para que plugins que leen get_stylesheet_uri() no fallen.
		wp_enqueue_style(
			'ae-theme-meta',
			get_stylesheet_uri(),
			array( 'ae-theme-styles' ),
			AE_THEME_VERSION
		);

		// ── GSAP core + ScrollTrigger (CDN, in_footer = false porque inicio.js los espera cargados pronto) ──
		wp_enqueue_script(
			'ae-gsap',
			'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.7/gsap.min.js',
			array(),
			'3.12.7',
			false
		);

		wp_enqueue_script(
			'ae-gsap-scrolltrigger',
			'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.7/ScrollTrigger.min.js',
			array( 'ae-gsap' ),
			'3.12.7',
			false
		);

		// ── JS del tema ──
		wp_enqueue_script(
			'ae-shell',
			AE_THEME_URI . '/assets/js/shell.js',
			array( 'ae-gsap', 'ae-gsap-scrolltrigger' ),
			AE_THEME_VERSION,
			true
		);

		wp_enqueue_script(
			'ae-scrolly',
			AE_THEME_URI . '/assets/js/scrolly.js',
			array( 'ae-shell' ),
			AE_THEME_VERSION,
			true
		);

		// inicio.js solo en la home (front-page).
		if ( is_front_page() ) {
			wp_enqueue_script(
				'ae-inicio',
				AE_THEME_URI . '/assets/js/inicio.js',
				array( 'ae-scrolly' ),
				AE_THEME_VERSION,
				true
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'ae_enqueue_assets' );

if ( ! function_exists( 'ae_resource_hints' ) ) {
	/**
	 * Añade preconnects a Google Fonts (igual que el HTML estático).
	 *
	 * @param array  $urls          URLs filtradas por WordPress.
	 * @param string $relation_type Relación (preconnect, dns-prefetch, etc.).
	 * @return array
	 */
	function ae_resource_hints( $urls, $relation_type ) {
		if ( 'preconnect' === $relation_type ) {
			$urls[] = array(
				'href' => 'https://fonts.googleapis.com',
			);
			$urls[] = array(
				'href'        => 'https://fonts.gstatic.com',
				'crossorigin' => 'anonymous',
			);
		}
		return $urls;
	}
}
add_filter( 'wp_resource_hints', 'ae_resource_hints', 10, 2 );

if ( ! function_exists( 'ae_preload_hero_image' ) ) {
	/**
	 * Preload del hero LCP solo en la home (paridad con index.html estático).
	 *
	 * @return void
	 */
	function ae_preload_hero_image() {
		if ( ! is_front_page() ) {
			return;
		}
		$img = esc_url( AE_THEME_URI . '/assets/img/5.jpeg' );
		echo '<link rel="preload" as="image" href="' . $img . '" fetchpriority="high">' . "\n";
	}
}
add_action( 'wp_head', 'ae_preload_hero_image', 2 );

if ( ! function_exists( 'ae_theme_color_meta' ) ) {
	/**
	 * Meta theme-color institucional.
	 *
	 * @return void
	 */
	function ae_theme_color_meta() {
		echo '<meta name="theme-color" content="#1e3a8a">' . "\n";
	}
}
add_action( 'wp_head', 'ae_theme_color_meta', 1 );
