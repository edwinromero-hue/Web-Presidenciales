<?php
/**
 * Drawer de navegación móvil (off-canvas).
 *
 * Se incluye dentro de <header> justo después de .flag-rule.
 * Mantiene la estructura visual original: botón cerrar, 8 enlaces,
 * CTA bloque con dos botones (Plataforma + Contacto).
 *
 * Si existe el menú WP "mobile-main" lo usamos; si no, renderizamos
 * los 8 enlaces por defecto (igual que el HTML estático).
 *
 * @package ActoresElectorales2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<nav class="hdr-mobile-nav" id="aeMobileNav" aria-label="<?php esc_attr_e( 'Navegación móvil', 'actores-electorales-2026' ); ?>" aria-hidden="true">
	<button type="button" class="mnav-close" aria-label="<?php esc_attr_e( 'Cerrar menú', 'actores-electorales-2026' ); ?>">&#10005;</button>

	<?php
	if ( has_nav_menu( 'mobile-main' ) ) {
		wp_nav_menu( array(
			'theme_location' => 'mobile-main',
			'container'      => false,
			'menu_class'     => 'mnav-list',
			'items_wrap'     => '%3$s', // render plano de <a>, sin <ul>.
			'walker'         => new AE_Flat_Link_Walker(),
			'depth'          => 1,
			'fallback_cb'    => 'ae_mobile_nav_fallback',
		) );
	} else {
		ae_mobile_nav_fallback();
	}
	?>

	<div class="mnav-cta">
		<a class="btn red" href="<?php echo esc_url( home_url( '/plataforma/' ) ); ?>"><?php esc_html_e( 'Ingresar a la Plataforma', 'actores-electorales-2026' ); ?></a>
		<a class="btn outline" href="<?php echo esc_url( home_url( '/canales/' ) ); ?>"><?php esc_html_e( 'Contacto', 'actores-electorales-2026' ); ?></a>
	</div>
</nav>
