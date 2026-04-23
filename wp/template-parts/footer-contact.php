<?php
/**
 * Columna de contacto del footer.
 *
 * Si existe el menú WP "footer-contacto", se renderiza; si no, se
 * cae al bloque estático con email, teléfono y WhatsApp.
 *
 * @package ActoresElectorales2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="footer-col" data-open="false">
	<h5><button class="footer-col-btn" type="button"><?php esc_html_e( 'Contacto', 'actores-electorales-2026' ); ?></button></h5>
	<div class="footer-col-body">
		<?php
		if ( has_nav_menu( 'footer-contacto' ) ) {
			wp_nav_menu( array(
				'theme_location' => 'footer-contacto',
				'container'      => false,
				'items_wrap'     => '%3$s',
				'walker'         => new AE_Flat_Link_Walker(),
				'depth'          => 1,
			) );
		} else {
			?>
			<a href="mailto:contacto.mesa@actoreselectorales.com">contacto.mesa@actoreselectorales.com</a>
			<a href="tel:+576017702692">(601) 770 2692</a>
			<a href="https://wa.me/573009110489" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'WhatsApp (+57) 300 911 0489', 'actores-electorales-2026' ); ?></a>
			<?php
		}
		?>
	</div>
</div>
