<?php
/**
 * Template Name: Sala de prensa
 * Template Post Type: page
 *
 * Portado 1:1 desde prensa.html (Fase F, sesión 2).
 * Incluye IIFE inline para tabs .prensa-tab y filtros .filter-btn.
 *
 * @package ActoresElectorales2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

	<!-- Page Hero -->
	<section class="ph">
		<div class="ph-deco" data-parallax="0.2"></div>
		<div class="wrap ae-z2">
			<nav class="crumb" aria-label="<?php esc_attr_e( 'Ruta de navegación', 'actores-electorales-2026' ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a> / <span aria-current="page">Sala de prensa</span></nav>
			<div class="eyebrow">Sala de prensa</div>
			<h1 data-enter style="margin-top:18px">Comunicados, noticias<br>y <span style="color:#1e3a8a">kit de prensa.</span></h1>
			<p class="kicker" data-enter data-delay="1">Información oficial actualizada sobre el proceso electoral 2026. Descarga recursos para medios.</p>
			<!-- Tab bar (role=group + aria-pressed; no existen paneles 1:1 distintos por tab, así que modelamos como toggles agrupados en lugar de tablist) -->
			<div role="group" aria-label="<?php esc_attr_e( 'Categorías de contenido', 'actores-electorales-2026' ); ?>" style="display:flex;gap:6px;margin-top:32px;border-bottom:2px solid #e2e8f0">
				<button type="button" class="prensa-tab" aria-pressed="true" style="padding:14px 22px;border:0;background:transparent;font-size:15px;font-weight:700;color:#1e3a8a;border-bottom:3px solid #1e3a8a;margin-bottom:-2px;cursor:pointer;font-family:inherit">Comunicados</button>
				<button type="button" class="prensa-tab" aria-pressed="false" style="padding:14px 22px;border:0;background:transparent;font-size:15px;font-weight:700;color:#475569;border-bottom:3px solid transparent;margin-bottom:-2px;cursor:pointer;font-family:inherit">Noticias</button>
				<button type="button" class="prensa-tab" aria-pressed="false" style="padding:14px 22px;border:0;background:transparent;font-size:15px;font-weight:700;color:#475569;border-bottom:3px solid transparent;margin-bottom:-2px;cursor:pointer;font-family:inherit">Kit de prensa</button>
			</div>
		</div>
	</section>

	<!-- Featured Story -->
	<section class="pad-sm">
		<div class="wrap">
			<a data-enter class="news-card" href="#" style="display:grid;grid-template-columns:1.1fr 1fr;align-items:stretch;padding:0;overflow:hidden">
				<div style="aspect-ratio:16/10"><img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/4.jpeg' ); ?>" alt="CNE entrega credenciales" loading="lazy" decoding="async" class="ae-img-cover"></div>
				<div style="padding:48px 40px;display:flex;flex-direction:column;justify-content:center">
					<div style="display:inline-flex;gap:6px;margin-bottom:16px;width:fit-content">
						<span style="background:#e11d48;color:#fff;font-size:11px;padding:4px 10px;border-radius:999px;font-weight:800;letter-spacing:.1em">DESTACADO</span>
						<span style="font-size:12px;color:#475569;font-weight:700;align-self:center">15 abr 2026</span>
					</div>
					<h2 style="font-size:clamp(24px,3vw,36px);font-weight:800;letter-spacing:-0.02em;line-height:1.15;color:#1e3a8a">CNE entrega credenciales a los siete representantes a la Cámara del Atlántico para el período 2026-2030.</h2>
					<p style="font-size:15px;color:#334155;margin-top:16px;line-height:1.6">La Sala Electoral del CNE procedió con la acreditación oficial de los nuevos representantes, garantizando el debido proceso y la representatividad democrática de la región.</p>
					<div style="margin-top:24px;display:flex;gap:12px">
						<span class="btn">Leer nota completa →</span>
						<span class="btn outline">Enlace externo</span>
					</div>
				</div>
			</a>
		</div>
	</section>

	<!-- Media Quotes -->
	<section style="background:#0f172a;color:#fff;padding:56px 0">
		<div class="wrap">
			<div style="text-align:center;margin-bottom:32px">
				<div style="color:#ffc627;font-size:13px;letter-spacing:.22em;text-transform:uppercase;font-weight:800">Lo que hablan los medios</div>
			</div>
			<div class="g2" style="gap:40px">
				<div data-enter data-delay="1">
					<div style="font-size:28px;color:#ffc627;line-height:1;margin-bottom:14px;font-weight:800" aria-hidden="true">"</div>
					<p style="font-size:17px;line-height:1.5;color:#cbd5e1;font-style:italic">El simulacro se realizó con éxito, reforzando las garantías para el registro de los testigos electorales.</p>
					<div style="font-size:18px;font-weight:800;color:#f43f5e;margin-top:20px;letter-spacing:.04em">— SEMANA</div>
				</div>
				<div data-enter data-delay="2">
					<div style="font-size:28px;color:#ffc627;line-height:1;margin-bottom:14px;font-weight:800" aria-hidden="true">"</div>
					<p style="font-size:17px;line-height:1.5;color:#cbd5e1;font-style:italic">El aplicativo facilitará la vigilancia en los más de 127.000 puestos de votación distribuidos en todo el territorio nacional y en el exterior.</p>
					<div style="font-size:18px;font-weight:800;color:#f43f5e;margin-top:20px;letter-spacing:.04em">— EL TIEMPO</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Filter + Grid -->
	<section class="pad">
		<div class="wrap">
			<div role="group" aria-label="<?php esc_attr_e( 'Filtros por tipo', 'actores-electorales-2026' ); ?>" style="display:flex;gap:10px;margin-bottom:32px;flex-wrap:wrap;align-items:center">
				<span id="filtrosLabel" style="font-size:13px;color:#475569;font-weight:700;text-transform:uppercase;letter-spacing:.1em;margin-right:8px">Filtros:</span>
				<button type="button" class="filter-btn" aria-pressed="true" style="padding:8px 16px;border-radius:999px;border:1.5px solid #1e3a8a;background:#1e3a8a;color:#fff;font-size:13px;font-weight:700;cursor:pointer;font-family:inherit">Todos</button>
				<button type="button" class="filter-btn" aria-pressed="false" style="padding:8px 16px;border-radius:999px;border:1.5px solid #e2e8f0;background:transparent;color:#475569;font-size:13px;font-weight:700;cursor:pointer;font-family:inherit">Comunicados</button>
				<button type="button" class="filter-btn" aria-pressed="false" style="padding:8px 16px;border-radius:999px;border:1.5px solid #e2e8f0;background:transparent;color:#475569;font-size:13px;font-weight:700;cursor:pointer;font-family:inherit">Noticias</button>
				<button type="button" class="filter-btn" aria-pressed="false" style="padding:8px 16px;border-radius:999px;border:1.5px solid #e2e8f0;background:transparent;color:#475569;font-size:13px;font-weight:700;cursor:pointer;font-family:inherit">Kit</button>
			</div>
			<div class="g3">
				<article class="news-card" data-enter data-delay="1"><div class="im"><img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/4.jpeg' ); ?>" alt="CNE credenciales" loading="lazy" decoding="async"></div><div class="body"><div class="m">15 abr 2026 · comunicado</div><h4>CNE entrega credenciales a los siete representantes a la Cámara del Atlántico</h4><p>La sala plena del Consejo Nacional Electoral entregó las credenciales...</p><span class="readmore">Leer más →</span></div></article>
				<article class="news-card" data-enter data-delay="2"><div class="im"><img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/16.jpg' ); ?>" alt="CNE entrega" loading="lazy" decoding="async"></div><div class="body"><div class="m">14 abr 2026 · noticia</div><h4>Consejo Nacional Electoral entrega...</h4><p>Nuevas acciones para garantizar la transparencia del proceso.</p><span class="readmore">Leer más →</span></div></article>
				<article class="news-card" data-enter data-delay="3"><div class="im"><img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/17.jpg' ); ?>" alt="Transparencia electoral" loading="lazy" decoding="async"></div><div class="body"><div class="m">12 abr 2026 · comunicado</div><h4>Se destaca transparencia en el proceso electoral 2026</h4><p>El Consejo Nacional Electoral resalta el trabajo mancomunado...</p><span class="readmore">Leer más →</span></div></article>
				<article class="news-card" data-enter data-delay="1"><div class="im"><img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/22.jpg' ); ?>" alt="Credenciales representantes" loading="lazy" decoding="async"></div><div class="body"><div class="m">10 abr 2026 · noticia</div><h4>CNE entrega credenciales a los 17 nuevos representantes</h4><p>Testigos electorales fueron reconocidos en ceremonia oficial.</p><span class="readmore">Leer más →</span></div></article>
				<article class="news-card" data-enter data-delay="2"><div class="im"><img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/18.jpg' ); ?>" alt="Representantes" loading="lazy" decoding="async"></div><div class="body"><div class="m">8 abr 2026 · kit</div><h4>Días con los nuevos 17 representantes</h4><p>Reporte detallado del seguimiento al proceso de acreditación.</p><span class="readmore">Leer más →</span></div></article>
				<article class="news-card" data-enter data-delay="3"><div class="im"><img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/9.jpeg' ); ?>" alt="Simulacro electoral" loading="lazy" decoding="async"></div><div class="body"><div class="m">5 abr 2026 · noticia</div><h4>Simulacro electoral refuerza garantías</h4><p>Se realizó exitosamente el segundo simulacro nacional.</p><span class="readmore">Leer más →</span></div></article>
			</div>
		</div>
	</section>

	<script>
	(function(){
		var tabs = document.querySelectorAll('.prensa-tab');
		tabs.forEach(function(btn){
			btn.addEventListener('click',function(){
				tabs.forEach(function(b){
					b.style.color='#475569';b.style.borderBottom='3px solid transparent';
					b.setAttribute('aria-pressed','false');
				});
				btn.style.color='#1e3a8a';btn.style.borderBottom='3px solid #1e3a8a';
				btn.setAttribute('aria-pressed','true');
			});
		});
		var filters = document.querySelectorAll('.filter-btn');
		filters.forEach(function(btn){
			btn.addEventListener('click',function(){
				filters.forEach(function(b){
					b.style.background='transparent';b.style.color='#475569';b.style.borderColor='#e2e8f0';
					b.setAttribute('aria-pressed','false');
				});
				btn.style.background='#1e3a8a';btn.style.color='#fff';btn.style.borderColor='#1e3a8a';
				btn.setAttribute('aria-pressed','true');
			});
		});
	})();
	</script>

<?php
get_footer();
