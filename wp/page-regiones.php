<?php
/**
 * Template Name: Regiones
 * Template Post Type: page
 *
 * Portado 1:1 desde regiones.html (Fase F, sesión 2).
 * Incluye inline JS (IIFE) para tabs de región y puntos interactivos del mapa.
 *
 * @package ActoresElectorales2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

	<!-- ═══ SECTION 1: Hero ═══ -->
	<section class="ph" style="position:relative;overflow:hidden">
		<div class="wrap ae-z2">
			<nav aria-label="<?php esc_attr_e( 'Ruta de navegación', 'actores-electorales-2026' ); ?>" style="font-size:13px;color:#475569;margin-bottom:24px">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:#475569;text-decoration:none">Inicio</a>
				<span aria-hidden="true" style="margin:0 8px">/</span>
				<span aria-current="page" style="color:#1e3a8a;font-weight:600">Regiones</span>
			</nav>
			<div class="eyebrow">Territorio</div>
			<h1 style="font-size:clamp(40px,6vw,80px);font-weight:800;line-height:0.95;letter-spacing:-0.03em;margin-top:16px">Conoce lo que pasa<br>en las regiones.</h1>
			<p style="font-size:18px;color:#334155;max-width:640px;line-height:1.55;margin-top:20px">Presencia en cada rincon del territorio nacional y en los consulados del mundo. Así garantizamos la transparencia electoral.</p>
		</div>
		<div class="ph-deco" data-parallax="0.15" aria-hidden="true" style="position:absolute;top:10%;right:5%;width:200px;height:200px;background:rgba(255,198,39,0.15);border-radius:50%"></div>
	</section>

	<!-- ═══ SECTION 2: Big Statement ═══ -->
	<section class="pad" style="background:var(--ae-blue-soft)">
		<div class="wrap" style="max-width:1100px;text-align:center">
			<h2 style="font-size:clamp(36px,6vw,88px);font-weight:800;line-height:0.95;letter-spacing:-0.03em" data-word-reveal>COLOMBIA ENTERA VIGILANDO SU DEMOCRACIA, MUNICIPIO POR MUNICIPIO.</h2>
		</div>
	</section>

	<!-- ═══ SECTION 3: Count-up ═══ -->
	<section class="pad" style="background:#ffc627;position:relative;overflow:hidden" aria-labelledby="statsRegionHeading">
		<div class="wrap">
			<h2 id="statsRegionHeading" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0">Cobertura territorial</h2>
			<div class="g2" style="max-width:700px;margin:0 auto;text-align:center;gap:48px">
				<div>
					<div class="bignum" style="color:#0f172a" data-countup="1103">0</div>
					<div class="ae-stat-label">Municipios</div>
				</div>
				<div>
					<div class="bignum" style="color:#0f172a" data-countup="67">0</div>
					<div class="ae-stat-label">Consulados</div>
				</div>
			</div>
		</div>
	</section>

	<!-- ═══ SECTION 4: Interactive Map ═══ -->
	<section class="pad" style="background:#f8fafc;position:relative;overflow:hidden">
		<style>
			@keyframes pulse-ring {
				0% { transform:scale(1); opacity:0.6; }
				100% { transform:scale(2.2); opacity:0; }
			}
			.map-dot { position:absolute; width:14px; height:14px; background:#15803d; border-radius:50%; cursor:pointer; border:none; padding:0; z-index:3; transition:all 200ms ease; }
			.map-dot::before { content:''; position:absolute; inset:-4px; border-radius:50%; border:2px solid #15803d; animation:pulse-ring 1.8s ease-out infinite; }
			.map-dot:hover { background:#1e3a8a; transform:scale(1.3); }
			.map-container { position:relative; max-width:600px; margin:0 auto; aspect-ratio:3/4; }
			.region-tab.active-tab { background:#1e3a8a!important; color:#fff!important; }
		</style>

		<div class="wrap">
			<div style="text-align:center;margin-bottom:40px">
				<div class="eyebrow" style="justify-content:center">Mapa interactivo</div>
				<h2 class="ae-h2">Explora las regiones</h2>
			</div>

			<!-- Tabs -->
			<div role="group" aria-label="<?php esc_attr_e( 'Nivel de detalle del mapa', 'actores-electorales-2026' ); ?>" style="display:flex;gap:12px;justify-content:center;margin-bottom:40px;flex-wrap:wrap">
				<button type="button" class="btn region-tab" aria-pressed="true" style="background:#1e3a8a;color:#fff">Colombia</button>
				<button type="button" class="btn outline region-tab" aria-pressed="false">Municipios</button>
				<button type="button" class="btn outline region-tab" aria-pressed="false">Consulados</button>
			</div>

			<!-- Map -->
			<div class="map-container">
				<!-- Colombia SVG silhouette -->
				<svg aria-hidden="true" viewBox="0 0 400 500" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:100%">
					<path d="M180 20 C160 30,140 50,130 70 C120 90,100 110,90 140 C80 170,70 190,75 220 C80 250,85 270,95 290 C105 310,110 330,120 350 C130 370,145 390,160 400 C175 410,190 420,210 425 C230 430,250 420,265 410 C280 400,290 380,300 360 C310 340,320 310,325 280 C330 250,330 220,325 190 C320 160,310 130,295 110 C280 90,260 70,240 50 C220 30,200 20,180 20Z" fill="#e2e8f0" stroke="#94a3b8" stroke-width="1.5"/>
				</svg>

				<!-- City dots -->
				<button class="map-dot" data-city="Bogota" style="top:52%;left:48%" aria-label="Bogota"></button>
				<button class="map-dot" data-city="Medellin" style="top:38%;left:35%" aria-label="Medellin"></button>
				<button class="map-dot" data-city="Cali" style="top:58%;left:30%" aria-label="Cali"></button>
				<button class="map-dot" data-city="Barranquilla" style="top:18%;left:38%" aria-label="Barranquilla"></button>
				<button class="map-dot" data-city="Cartagena" style="top:22%;left:32%" aria-label="Cartagena"></button>
				<button class="map-dot" data-city="Bucaramanga" style="top:38%;left:50%" aria-label="Bucaramanga"></button>
				<button class="map-dot" data-city="Cucuta" style="top:32%;left:55%" aria-label="Cucuta"></button>
				<button class="map-dot" data-city="Pereira" style="top:48%;left:33%" aria-label="Pereira"></button>
				<button class="map-dot" data-city="Manizales" style="top:46%;left:34%" aria-label="Manizales"></button>
				<button class="map-dot" data-city="Santa Marta" style="top:15%;left:42%" aria-label="Santa Marta"></button>
				<button class="map-dot" data-city="Villavicencio" style="top:56%;left:55%" aria-label="Villavicencio"></button>
				<button class="map-dot" data-city="Pasto" style="top:72%;left:30%" aria-label="Pasto"></button>
				<button class="map-dot" data-city="Ibague" style="top:50%;left:38%" aria-label="Ibague"></button>
				<button class="map-dot" data-city="Neiva" style="top:58%;left:38%" aria-label="Neiva"></button>
			</div>

			<!-- Selected city label -->
			<div style="text-align:center;margin-top:32px">
				<div style="display:inline-block;background:#fff;border:2px solid #e2e8f0;border-radius:12px;padding:16px 32px;box-shadow:0 4px 16px rgba(0,0,0,0.06)">
					<div style="font-size:11px;letter-spacing:.2em;text-transform:uppercase;font-weight:700;color:#475569;margin-bottom:4px">Ciudad seleccionada</div>
					<div id="cityLabel" aria-live="polite" aria-atomic="true" style="font-size:24px;font-weight:800;color:#1e3a8a">Bogota</div>
				</div>
			</div>
		</div>
	</section>

	<!-- ═══ SECTION 5: Region Detail ═══ -->
	<section class="pad" style="background:#fff">
		<div class="wrap">
			<div style="display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:start">
				<!-- Left: Detail card -->
				<div data-enter="left">
					<div class="eyebrow">Ficha territorial</div>
					<h2 style="font-size:clamp(32px,4.5vw,48px);font-weight:800;letter-spacing:-0.025em;margin-top:12px;margin-bottom:32px">Bogota D.C.</h2>

					<div style="display:flex;flex-direction:column;gap:20px">
						<div class="ae-head-row">
							<span style="font-size:13px;letter-spacing:.1em;text-transform:uppercase;font-weight:700;color:#475569">Puntos de votacion</span>
							<span style="font-weight:800;color:#0f172a;font-size:18px">1.248</span>
						</div>
						<div class="ae-head-row">
							<span style="font-size:13px;letter-spacing:.1em;text-transform:uppercase;font-weight:700;color:#475569">Direccion</span>
							<span style="font-weight:600;color:#0f172a;font-size:15px">Cra 7 # 26-90 Of. 301</span>
						</div>
						<div class="ae-head-row">
							<span style="font-size:13px;letter-spacing:.1em;text-transform:uppercase;font-weight:700;color:#475569">Correo</span>
							<a href="mailto:bogota@actoreselectorales.com" style="font-weight:600;color:#1e3a8a;font-size:15px;text-decoration:none">bogota@actoreselectorales.com</a>
						</div>
						<div class="ae-head-row">
							<span style="font-size:13px;letter-spacing:.1em;text-transform:uppercase;font-weight:700;color:#475569">Mesa de ayuda</span>
							<span style="font-weight:600;color:#0f172a;font-size:15px">(601) 770 2692</span>
						</div>
						<div class="ae-head-row">
							<span style="font-size:13px;letter-spacing:.1em;text-transform:uppercase;font-weight:700;color:#475569">Eventos programados</span>
							<span style="font-weight:800;color:#be123c;font-size:18px">3</span>
						</div>
					</div>

					<div style="margin-top:32px">
						<a href="<?php echo esc_url( home_url( '/eventos/' ) ); ?>" class="btn red">Ver eventos en esta región</a>
					</div>
				</div>

				<!-- Right: Image grid -->
				<div data-enter="right" style="display:grid;grid-template-columns:1fr 1fr;grid-template-rows:1fr 1fr;gap:12px">
					<div style="grid-column:1/3;grid-row:1/3;border-radius:12px;overflow:hidden">
						<img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/5.jpeg' ); ?>" alt="Región Bogota" loading="lazy" decoding="async" class="ae-img-cover">
					</div>
					<div style="border-radius:12px;overflow:hidden">
						<img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/7.jpeg' ); ?>" alt="Capacitación regional" loading="lazy" decoding="async" style="width:100%;height:100%;object-fit:cover;aspect-ratio:1/1">
					</div>
					<div style="border-radius:12px;overflow:hidden">
						<img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/9.jpeg' ); ?>" alt="Testigos electorales" loading="lazy" decoding="async" style="width:100%;height:100%;object-fit:cover;aspect-ratio:1/1">
					</div>
					<div style="border-radius:12px;overflow:hidden;grid-column:1/3">
						<img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/11.jpeg' ); ?>" alt="Proceso electoral" loading="lazy" decoding="async" style="width:100%;height:100%;object-fit:cover;aspect-ratio:3/1">
					</div>
				</div>
			</div>
		</div>
	</section>

	<script>
	(function(){
		// Tab buttons — cache única al cargar
		var tabs = document.querySelectorAll('.region-tab');
		tabs.forEach(function(btn){
			btn.addEventListener('click', function(){
				tabs.forEach(function(b){
					b.className='btn outline region-tab';
					b.setAttribute('aria-pressed','false');
				});
				btn.className='btn region-tab';
				btn.setAttribute('aria-pressed','true');
			});
		});
		// Map dots — cache única
		var cityLabel = document.getElementById('cityLabel');
		var dots = document.querySelectorAll('.map-dot');
		dots.forEach(function(dot){
			dot.addEventListener('click', function(){
				dots.forEach(function(d){ d.style.background='#15803d'; d.style.width='14px'; d.style.height='14px'; d.setAttribute('aria-pressed','false'); });
				dot.style.background='#1e3a8a'; dot.style.width='18px'; dot.style.height='18px';
				dot.setAttribute('aria-pressed','true');
				if(cityLabel) cityLabel.textContent = dot.getAttribute('data-city');
			});
		});
	})();
	</script>

<?php
get_footer();
