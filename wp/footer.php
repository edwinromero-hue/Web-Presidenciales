<?php
/**
 * Footer global del tema.
 *
 * Cierre de <main>, pie con 4 columnas (marca + 3 menús WP),
 * back-to-top, sticky CTA móvil y wp_footer().
 *
 * @package ActoresElectorales2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
	</main>

	<!-- ===== FOOTER ===== -->
	<footer class="footer" role="contentinfo">
		<div class="wrap">
			<div class="footer-top">
				<div>
					<div class="ae-brand-row">
						<span class="ae-dots" aria-hidden="true">
							<span class="ae-dot ae-dot-yellow"></span>
							<span class="ae-dot ae-dot-blue"></span>
							<span class="ae-dot ae-dot-red"></span>
						</span>
						<span class="ae-brand-mono">ACTORES <span style="color:#f43f5e">| 2026</span></span>
					</div>
					<p class="ae-footer-claim">
						<?php esc_html_e( 'Plataforma oficial de Actores Electorales del Consejo Nacional Electoral para las elecciones presidenciales Colombia 2026. Un solo equipo. Un solo país.', 'actores-electorales-2026' ); ?>
					</p>
				</div>

				<div class="footer-col" data-open="false">
					<h5><button class="footer-col-btn" type="button"><?php esc_html_e( 'Plataforma', 'actores-electorales-2026' ); ?></button></h5>
					<div class="footer-col-body">
						<?php
						if ( has_nav_menu( 'footer-plataforma' ) ) {
							wp_nav_menu( array(
								'theme_location' => 'footer-plataforma',
								'container'      => false,
								'items_wrap'     => '%3$s',
								'walker'         => new AE_Flat_Link_Walker(),
								'depth'          => 1,
							) );
						} else {
							?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Inicio', 'actores-electorales-2026' ); ?></a>
							<a href="<?php echo esc_url( home_url( '/quienes-somos/' ) ); ?>"><?php esc_html_e( 'Quiénes somos', 'actores-electorales-2026' ); ?></a>
							<a href="<?php echo esc_url( home_url( '/plataforma/' ) ); ?>"><?php esc_html_e( 'Plataforma', 'actores-electorales-2026' ); ?></a>
							<a href="<?php echo esc_url( home_url( '/entrenamiento/' ) ); ?>"><?php esc_html_e( 'Entrenamiento', 'actores-electorales-2026' ); ?></a>
							<?php
						}
						?>
					</div>
				</div>

				<div class="footer-col" data-open="false">
					<h5><button class="footer-col-btn" type="button"><?php esc_html_e( 'Información', 'actores-electorales-2026' ); ?></button></h5>
					<div class="footer-col-body">
						<?php
						if ( has_nav_menu( 'footer-informacion' ) ) {
							wp_nav_menu( array(
								'theme_location' => 'footer-informacion',
								'container'      => false,
								'items_wrap'     => '%3$s',
								'walker'         => new AE_Flat_Link_Walker(),
								'depth'          => 1,
							) );
						} else {
							?>
							<a href="<?php echo esc_url( home_url( '/regiones/' ) ); ?>"><?php esc_html_e( 'Regiones', 'actores-electorales-2026' ); ?></a>
							<a href="<?php echo esc_url( home_url( '/canales/' ) ); ?>"><?php esc_html_e( 'Canales de atención', 'actores-electorales-2026' ); ?></a>
							<a href="<?php echo esc_url( home_url( '/prensa/' ) ); ?>"><?php esc_html_e( 'Sala de prensa', 'actores-electorales-2026' ); ?></a>
							<a href="<?php echo esc_url( home_url( '/eventos/' ) ); ?>"><?php esc_html_e( 'Eventos', 'actores-electorales-2026' ); ?></a>
							<?php
						}
						?>
					</div>
				</div>

				<?php get_template_part( 'template-parts/footer-contact' ); ?>
			</div>

			<div class="footer-bottom">
				<span>&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php esc_html_e( 'Consejo Nacional Electoral · Aliados tecnológicos', 'actores-electorales-2026' ); ?></span>
				<span><?php esc_html_e( 'Aviso de privacidad · Términos y condiciones', 'actores-electorales-2026' ); ?></span>
			</div>
		</div>
	</footer>

	<!-- Back-to-top -->
	<button type="button" class="back-top" aria-label="<?php esc_attr_e( 'Volver arriba', 'actores-electorales-2026' ); ?>">&uarr;</button>

	<!-- Sticky bottom CTA (móvil) -->
	<div class="sticky-cta" role="region" aria-label="<?php esc_attr_e( 'Acciones rápidas', 'actores-electorales-2026' ); ?>">
		<a class="btn red" href="<?php echo esc_url( home_url( '/plataforma/' ) ); ?>"><?php esc_html_e( 'Ingresar', 'actores-electorales-2026' ); ?></a>
		<a class="btn outline" href="<?php echo esc_url( home_url( '/canales/' ) ); ?>"><?php esc_html_e( 'Contacto', 'actores-electorales-2026' ); ?></a>
	</div>

	<?php wp_footer(); ?>
</body>
</html>
