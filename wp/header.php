<?php
/**
 * Header global del tema.
 *
 * Desde <!DOCTYPE> hasta justo antes de <main>. Incluye skip-link,
 * header institucional con logo + nav desktop + CTA + burger móvil,
 * franja tricolor (flag-rule), drawer móvil y progress rail global.
 *
 * @package ActoresElectorales2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

	<a href="#mainContent" class="skip-link"><?php esc_html_e( 'Saltar al contenido', 'actores-electorales-2026' ); ?></a>

	<!-- ===== HEADER ===== -->
	<header class="hdr-wrap" role="banner">
		<div class="hdr-inner">
			<a class="hdr-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ' — ' . __( 'Inicio', 'actores-electorales-2026' ) ); ?>">
				<?php
				if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
					the_custom_logo();
				} else {
					printf(
						'<img src="%1$s" alt="%2$s" class="hdr-logo-img">',
						esc_url( AE_THEME_URI . '/assets/logo.svg' ),
						esc_attr( get_bloginfo( 'name' ) )
					);
				}
				?>
			</a>

			<nav class="hdr-nav" aria-label="<?php esc_attr_e( 'Navegación principal', 'actores-electorales-2026' ); ?>">
				<?php
				if ( has_nav_menu( 'header-main' ) ) {
					wp_nav_menu( array(
						'theme_location' => 'header-main',
						'container'      => false,
						'menu_class'     => 'hdr-nav-list',
						'items_wrap'     => '%3$s',
						'walker'         => new AE_Flat_Link_Walker(),
						'depth'          => 1,
						'fallback_cb'    => 'ae_header_nav_fallback',
					) );
				} else {
					ae_header_nav_fallback();
				}
				?>
			</nav>

			<div class="hdr-cta">
				<a class="btn red" href="<?php echo esc_url( home_url( '/plataforma/' ) ); ?>">
					<span style="color:#ffc627" aria-hidden="true">&#9679;</span>
					<?php esc_html_e( 'Ingresar', 'actores-electorales-2026' ); ?>
				</a>
			</div>

			<button type="button" class="hdr-mobile-toggle" aria-label="<?php esc_attr_e( 'Abrir menú', 'actores-electorales-2026' ); ?>" aria-expanded="false" aria-controls="aeMobileNav">
				<span class="hdr-burger" aria-hidden="true"><span></span><span></span><span></span></span>
			</button>
		</div>

		<div class="flag-rule" aria-hidden="true">
			<div style="background:#ffc627"></div><div style="background:#1e3a8a"></div><div style="background:#e11d48"></div>
		</div>

		<?php get_template_part( 'template-parts/nav-mobile' ); ?>
	</header>

	<!-- Progress Rail -->
	<div class="progress-rail" aria-hidden="true"><div id="pfill" class="fill"></div></div>

	<main id="mainContent">
