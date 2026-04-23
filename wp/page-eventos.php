<?php
/**
 * Template Name: Eventos
 * Template Post Type: page
 *
 * Portado 1:1 desde eventos.html (Fase F, sesión 2).
 * El calendario 30 días usa event-delegation (1 listener en el grid) ya optimizado.
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
			<nav class="crumb" aria-label="<?php esc_attr_e( 'Ruta de navegación', 'actores-electorales-2026' ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a> / <span aria-current="page">Eventos</span></nav>
			<div class="eyebrow">Calendario 2026</div>
			<h1 data-enter style="margin-top:18px">Eventos del <span style="color:#1e3a8a">proceso electoral.</span></h1>
			<p class="kicker" data-enter data-delay="1">Inscríbete a eventos, sigue la campaña presidencial y consulta el repositorio completo.</p>
		</div>
	</section>

	<!-- Hero Inscription -->
	<section class="pad-sm">
		<div class="wrap">
			<div data-enter style="background:linear-gradient(120deg,#1e3a8a 0%,#2b4aa3 100%);color:#fff;border-radius:20px;padding:56px 48px;overflow:hidden;position:relative">
				<div class="hex-deco" aria-hidden="true" style="position:absolute;top:-40px;right:-40px;width:220px;height:220px;background:#ffc627;opacity:0.3"></div>
				<div class="ae-split" style="position:relative;z-index:2;align-items:center">
					<div>
						<div class="ae-kicker-y">Próximo evento</div>
						<h2 style="font-size:clamp(32px,5vw,56px);font-weight:800;letter-spacing:-0.025em;color:#fff;line-height:1">Inscríbete a los eventos.</h2>
						<p style="font-size:17px;color:rgba(255,255,255,0.85);margin-top:14px;max-width:560px;line-height:1.55">El próximo simulacro de escrutinio es el <b style="color:#ffc627">24 de abril</b>. Cupos limitados para testigos electorales acreditados.</p>
						<button class="btn yellow" style="margin-top:28px">Inscribirme ahora →</button>
					</div>
					<div style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.2);border-radius:14px;padding:24px;backdrop-filter:blur(10px)">
						<div style="font-size:11px;letter-spacing:.2em;text-transform:uppercase;font-weight:800;color:#ffc627;margin-bottom:10px">Evento más cercano</div>
						<h4 style="font-size:20px;font-weight:800;color:#fff;line-height:1.25">Simulacro nacional de escrutinio</h4>
						<div style="margin-top:16px;display:flex;flex-direction:column;gap:8px;font-size:14px">
							<div>24 de febrero, 2026</div>
							<div>8:00 a.m. – 11:00 a.m.</div>
							<div>Bogotá D.C., Colombia</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- 3 Event Cards -->
	<section class="pad-sm">
		<div class="wrap">
			<div class="g3">
				<div data-enter data-delay="1" style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:24px 26px;border-left:6px solid #e11d48;display:flex;flex-direction:column;gap:10px">
					<div style="font-size:11px;letter-spacing:.18em;text-transform:uppercase;font-weight:800;color:#be123c">Próximo</div>
					<h4 style="font-size:17px;font-weight:800;line-height:1.3">Campaña presidencial · Primera vuelta</h4>
					<div style="font-size:13px;color:#475569;font-weight:600">15 mar – 30 may 2026</div>
					<a href="#" style="font-size:13px;font-weight:800;color:#1e3a8a;margin-top:auto">Ver detalle →</a>
				</div>
				<div data-enter data-delay="2" style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:24px 26px;border-left:6px solid #1e3a8a;display:flex;flex-direction:column;gap:10px">
					<div style="font-size:11px;letter-spacing:.18em;text-transform:uppercase;font-weight:800;color:#1e3a8a">Próximo</div>
					<h4 style="font-size:17px;font-weight:800;line-height:1.3">Debates presidenciales</h4>
					<div style="font-size:13px;color:#475569;font-weight:600">Abril – Mayo 2026</div>
					<a href="#" style="font-size:13px;font-weight:800;color:#1e3a8a;margin-top:auto">Ver detalle →</a>
				</div>
				<div data-enter data-delay="3" style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:24px 26px;border-left:6px solid #ffc627;display:flex;flex-direction:column;gap:10px">
					<div style="font-size:11px;letter-spacing:.18em;text-transform:uppercase;font-weight:800;color:#ffc627">Próximo</div>
					<h4 style="font-size:17px;font-weight:800;line-height:1.3">Capacitación nacional de testigos</h4>
					<div style="font-size:13px;color:#475569;font-weight:600">20 abr 2026</div>
					<a href="#" style="font-size:13px;font-weight:800;color:#1e3a8a;margin-top:auto">Ver detalle →</a>
				</div>
			</div>
		</div>
	</section>

	<!-- Calendar + Detail -->
	<section class="pad">
		<div class="wrap">
			<div class="ae-split" style="align-items:start">
				<div data-enter>
					<div style="display:flex;justify-content:space-between;align-items:end;margin-bottom:20px">
						<h3 style="font-size:28px;font-weight:800;letter-spacing:-0.02em">Abril 2026</h3>
						<div style="display:flex;gap:6px">
							<button style="width:36px;height:36px;border:1px solid #e2e8f0;background:#fff;border-radius:8px;cursor:pointer" aria-label="<?php esc_attr_e( 'Mes anterior', 'actores-electorales-2026' ); ?>">←</button>
							<button style="width:36px;height:36px;border:1px solid #1e3a8a;background:#1e3a8a;color:#fff;border-radius:8px;cursor:pointer" aria-label="<?php esc_attr_e( 'Mes siguiente', 'actores-electorales-2026' ); ?>">→</button>
						</div>
					</div>
					<div style="border:1px solid #e2e8f0;border-radius:14px;overflow:hidden">
						<div style="display:grid;grid-template-columns:repeat(7,1fr);background:#f8fafc;border-bottom:1px solid #e2e8f0">
							<div class="ae-cal-dow">LUN</div>
							<div class="ae-cal-dow">MAR</div>
							<div class="ae-cal-dow">MIÉ</div>
							<div class="ae-cal-dow">JUE</div>
							<div class="ae-cal-dow">VIE</div>
							<div class="ae-cal-dow">SÁB</div>
							<div class="ae-cal-dow">DOM</div>
						</div>
						<div id="calGrid" style="display:grid;grid-template-columns:repeat(7,1fr)"></div>
					</div>
				</div>
				<div data-enter="right">
					<div class="eyebrow">Detalle del evento</div>
					<h3 style="font-size:22px;font-weight:800;margin-top:14px;line-height:1.3;color:#1e3a8a">El CNE presenta en Quito plataforma para participación y vigilancia electoral de colombianos en el exterior.</h3>
					<div style="aspect-ratio:4/3;border-radius:12px;overflow:hidden;margin-top:20px;position:relative">
						<img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/1.jpeg' ); ?>" alt="Evento CNE" loading="lazy" decoding="async" class="ae-img-cover">
						<div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(15,23,42,0.7),rgba(15,23,42,0.2))"></div>
						<div style="position:absolute;top:20px;left:20px;right:20px;color:#fff">
							<div style="font-size:12px;font-weight:700">Bogotá D.C., 24 de febrero de 2026</div>
							<div style="font-size:12px;opacity:0.8;margin-top:4px">(@CNE_COLOMBIA) — El Consejo Nacional Electoral presenta su innovadora plataforma de postulación.</div>
						</div>
						<div style="position:absolute;bottom:20px;left:20px;color:#fff;font-size:12px;display:flex;flex-direction:column;gap:6px">
							<div>24 de febrero de 2026</div><div>8:00 a.m. – 11:00 a.m.</div><div>Bogotá D.C., Colombia</div>
						</div>
					</div>
					<p style="font-size:13px;color:#334155;margin-top:18px;line-height:1.65;font-style:italic;border-left:3px solid #ffc627;padding-left:14px">La Plataforma de Postulación y Acreditación de Actores Electorales digitaliza completamente este proceso mediante la eliminación de trámites físicos.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- Past Events -->
	<section class="pad" style="background:#f8fafc">
		<div class="wrap">
			<div style="margin-bottom:40px" data-enter>
				<div class="eyebrow">Repositorio</div>
				<h2 class="ae-h2">Eventos pasados.</h2>
			</div>
			<div class="g3">
				<article class="news-card" data-enter data-delay="1"><div class="im"><img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/4.jpeg' ); ?>" alt="Estrategia CNE" loading="lazy" decoding="async"></div><div class="body"><div class="m">15 abr 2026</div><h4>Colombia unida en democracia: el CNE presentó su estrategia</h4><p>Bogotá D.C. — Este miércoles en Corferias se reunieron...</p><span class="readmore">Leer más →</span></div></article>
				<article class="news-card" data-enter data-delay="2"><div class="im"><img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/16.jpg' ); ?>" alt="Elección Atlántico" loading="lazy" decoding="async"></div><div class="body"><div class="m">15 abr 2026</div><h4>CNE declara la elección de Representante a la Cámara</h4><p>Luego de surtir el debido proceso.</p><span class="readmore">Leer más →</span></div></article>
				<article class="news-card" data-enter data-delay="3"><div class="im"><img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/11.jpeg' ); ?>" alt="Garantías electorales" loading="lazy" decoding="async"></div><div class="body"><div class="m">14 abr 2026</div><h4>Garantías plenas en elecciones</h4><p>El Consejo Nacional Electoral informa...</p><span class="readmore">Leer más →</span></div></article>
				<article class="news-card" data-enter data-delay="1"><div class="im"><img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/17.jpg' ); ?>" alt="Comité técnico" loading="lazy" decoding="async"></div><div class="body"><div class="m">12 abr 2026</div><h4>CNE instaló mañana jueves</h4><p>Instalación oficial del comité técnico 2026.</p><span class="readmore">Leer más →</span></div></article>
				<article class="news-card" data-enter data-delay="2"><div class="im"><img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/18.jpg' ); ?>" alt="Escrutinio" loading="lazy" decoding="async"></div><div class="body"><div class="m">10 abr 2026</div><h4>CNE acelera escrutinio</h4><p>Nuevas medidas para agilizar el escrutinio nacional.</p><span class="readmore">Leer más →</span></div></article>
				<article class="news-card" data-enter data-delay="3"><div class="im"><img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/7.jpeg' ); ?>" alt="Foro transparencia" loading="lazy" decoding="async"></div><div class="body"><div class="m">8 abr 2026</div><h4>Foro de transparencia electoral</h4><p>Expertos nacionales e internacionales participaron.</p><span class="readmore">Leer más →</span></div></article>
			</div>
		</div>
	</section>

	<script>
	(function(){
		var grid = document.getElementById('calGrid');
		if(!grid) return;
		var eventDays = [8,15,17,22,24];
		// Event delegation: 1 listener en el grid en vez de 30.
		grid.addEventListener('click', function(e){
			var btn = e.target.closest('.cal-day');
			if(!btn || !grid.contains(btn)) return;
			grid.querySelectorAll('.cal-day').forEach(function(b){ b.style.background='#fff'; });
			btn.style.background='#ffc627';
		});
		for(var i=1;i<=30;i++){
			var btn = document.createElement('button');
			btn.type='button';
			btn.className='cal-day';
			btn.setAttribute('aria-label','Día '+i);
			btn.style.cssText='aspect-ratio:1/1;border:0.5px solid #f1f5f9;background:'+(i===15?'#ffc627':'#fff')+';cursor:pointer;padding:8px;display:flex;flex-direction:column;align-items:flex-start;font-family:inherit';
			var num = document.createElement('div');
			num.style.cssText='font-size:13px;font-weight:800;color:#0f172a';
			num.textContent=i;
			btn.appendChild(num);
			if(eventDays.indexOf(i)!==-1){
				var lbl = document.createElement('div');
				lbl.style.cssText='font-size:9px;margin-top:4px;padding:2px 4px;background:'+(i===15?'#1e3a8a':'#eaf1ff')+';color:'+(i===15?'#fff':'#1e3a8a')+';border-radius:4px;font-weight:700;line-height:1.2;text-align:left';
				lbl.textContent='Campaña pres...';
				btn.appendChild(lbl);
			}
			grid.appendChild(btn);
		}
	})();
	</script>

<?php
get_footer();
