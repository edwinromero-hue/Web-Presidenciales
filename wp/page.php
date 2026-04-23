<?php
/**
 * Template genérico de página.
 *
 * Las 7 páginas principales tienen page-templates específicos (page-*.php)
 * con el markup 1:1 del HTML estático. Este archivo es el fallback para
 * cualquier otra página que el dev WP cree.
 *
 * @package ActoresElectorales2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<section class="ph" style="position:relative;overflow:hidden">
		<div class="ph-deco" data-parallax="0.2" aria-hidden="true"></div>
		<div class="ph-deco-2" data-parallax="-0.15" aria-hidden="true"></div>
		<div class="wrap ae-z2">
			<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Ruta de navegación', 'actores-electorales-2026' ); ?>" data-enter>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Inicio', 'actores-electorales-2026' ); ?></a> / <span aria-current="page"><?php the_title(); ?></span>
			</nav>
			<div data-enter>
				<h1 style="font-size:clamp(40px,6vw,88px);font-weight:800;line-height:0.95;letter-spacing:-0.03em;margin-top:24px;max-width:900px"><?php the_title(); ?></h1>
			</div>
		</div>
	</section>

	<section class="pad">
		<div class="wrap">
			<div class="ae-prose">
				<?php the_content(); ?>
			</div>
		</div>
	</section>

	<?php
endwhile;

get_footer();
