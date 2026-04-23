<?php
/**
 * Walkers de navegación y fallbacks.
 *
 * AE_Flat_Link_Walker — emite <a> planos (sin <ul>/<li>) para encajar
 * con el marcado original de .hdr-nav y .hdr-mobile-nav.
 *
 * Fallbacks — si los menús WP no existen, replican los 8 enlaces
 * del HTML estático.
 *
 * @package ActoresElectorales2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'AE_Flat_Link_Walker' ) ) {
	/**
	 * Walker de menú que emite <a> planos.
	 */
	class AE_Flat_Link_Walker extends Walker_Nav_Menu {

		public function start_lvl( &$output, $depth = 0, $args = null ) {}
		public function end_lvl( &$output, $depth = 0, $args = null ) {}
		public function end_el( &$output, $item, $depth = 0, $args = null ) {}

		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
			$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
			$is_active = in_array( 'current-menu-item', $classes, true ) || in_array( 'current_page_item', $classes, true );

			$attrs = '';
			if ( ! empty( $item->url ) ) {
				$attrs .= ' href="' . esc_url( $item->url ) . '"';
			}
			if ( ! empty( $item->target ) ) {
				$attrs .= ' target="' . esc_attr( $item->target ) . '"';
			}
			if ( ! empty( $item->xfn ) ) {
				$attrs .= ' rel="' . esc_attr( $item->xfn ) . '"';
			}
			if ( ! empty( $item->attr_title ) ) {
				$attrs .= ' title="' . esc_attr( $item->attr_title ) . '"';
			}
			if ( $is_active ) {
				$attrs .= ' class="active" aria-current="page"';
			}

			$title = apply_filters( 'the_title', $item->title, $item->ID );

			$output .= '<a' . $attrs . '>' . esc_html( $title ) . '</a>';
		}
	}
}

/**
 * Renderiza los 8 enlaces estáticos del header.
 *
 * @return void
 */
function ae_header_nav_fallback() {
	$items = ae_default_nav_items();
	foreach ( $items as $slug => $label ) {
		$url    = ae_default_nav_url( $slug );
		$active = ae_is_current_page( $slug );
		printf(
			'<a href="%1$s"%2$s>%3$s</a>',
			esc_url( $url ),
			$active ? ' class="active" aria-current="page"' : '',
			esc_html( $label )
		);
	}
}

/**
 * Renderiza los 8 enlaces estáticos del drawer móvil.
 *
 * @return void
 */
function ae_mobile_nav_fallback() {
	$items = ae_default_nav_items();
	foreach ( $items as $slug => $label ) {
		$url    = ae_default_nav_url( $slug );
		$active = ae_is_current_page( $slug );
		printf(
			'<a href="%1$s"%2$s>%3$s</a>',
			esc_url( $url ),
			$active ? ' class="active"' : '',
			esc_html( $label )
		);
	}
}

/**
 * Lista canónica de 8 ítems (slug => label).
 *
 * @return array
 */
function ae_default_nav_items() {
	return array(
		'inicio'         => __( 'Inicio', 'actores-electorales-2026' ),
		'quienes-somos'  => __( 'Quiénes somos', 'actores-electorales-2026' ),
		'plataforma'     => __( 'Plataforma', 'actores-electorales-2026' ),
		'entrenamiento'  => __( 'Entrenamiento', 'actores-electorales-2026' ),
		'regiones'       => __( 'Regiones', 'actores-electorales-2026' ),
		'canales'        => __( 'Canales de atención', 'actores-electorales-2026' ),
		'prensa'         => __( 'Sala de prensa', 'actores-electorales-2026' ),
		'eventos'        => __( 'Eventos', 'actores-electorales-2026' ),
	);
}

/**
 * URL para un slug de navegación por defecto.
 *
 * @param string $slug Slug simbólico.
 * @return string
 */
function ae_default_nav_url( $slug ) {
	if ( 'inicio' === $slug ) {
		return home_url( '/' );
	}
	return home_url( '/' . $slug . '/' );
}

/**
 * Heurística para marcar el enlace activo en los fallbacks.
 *
 * @param string $slug Slug simbólico.
 * @return bool
 */
function ae_is_current_page( $slug ) {
	if ( 'inicio' === $slug ) {
		return is_front_page() || is_home();
	}
	return is_page( $slug );
}
