<?php
/**
 * Fallback template — requerido por WordPress aunque el tema use
 * front-page.php + page templates específicos.
 *
 * Se usará si alguien visita una URL que no calce con otra jerarquía
 * (ej. /blog/ sin singular propio). Renderiza loop estándar.
 *
 * @package ActoresElectorales2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

	<section class="ph" style="position:relative;overflow:hidden">
		<div class="wrap ae-z2">
			<?php if ( have_posts() ) : ?>
				<div class="eyebrow" style="margin-top:24px"><?php esc_html_e( 'Archivo', 'actores-electorales-2026' ); ?></div>
				<h1 style="font-size:clamp(40px,6vw,72px);font-weight:800;line-height:0.95;letter-spacing:-0.03em;margin-top:16px"><?php esc_html_e( 'Publicaciones', 'actores-electorales-2026' ); ?></h1>
			<?php else : ?>
				<div class="eyebrow" style="margin-top:24px"><?php esc_html_e( 'Sin resultados', 'actores-electorales-2026' ); ?></div>
				<h1 style="font-size:clamp(40px,6vw,72px);font-weight:800;line-height:0.95;letter-spacing:-0.03em;margin-top:16px"><?php esc_html_e( 'Nada por aquí todavía', 'actores-electorales-2026' ); ?></h1>
				<p style="font-size:18px;line-height:1.55;color:#334155;max-width:680px;margin-top:16px"><?php esc_html_e( 'Vuelve pronto: estamos publicando noticias y comunicados del proceso electoral 2026.', 'actores-electorales-2026' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<?php if ( have_posts() ) : ?>
		<section class="pad">
			<div class="wrap">
				<div class="g3">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<article class="news-card">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="im"><?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy', 'decoding' => 'async' ) ); ?></div>
							<?php endif; ?>
							<div class="body">
								<div class="m"><?php echo esc_html( get_the_date() ); ?></div>
								<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
								<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
								<a href="<?php the_permalink(); ?>" class="readmore"><?php esc_html_e( 'Leer más', 'actores-electorales-2026' ); ?> &rarr;</a>
							</div>
						</article>
						<?php
					endwhile;
					?>
				</div>
				<div style="margin-top:40px">
					<?php the_posts_pagination(); ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

<?php
get_footer();
