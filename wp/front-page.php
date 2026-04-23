<?php
/**
 * Front Page — Home narrativa scrolly con 7 escenas.
 *
 * Equivalencia 1:1 con index.html del proyecto estático:
 *   Hero pineado → Big Statement → Pin-photo 3 estados → Card Stack
 *   → Horizontal Section → Big Numbers → Press Quotes → News → Training Teaser → Final CTA.
 *
 * Los assets (imágenes) se resuelven vía AE_THEME_URI para portabilidad.
 * Todo el markup visual, paleta, a11y y data-attributes se preservan.
 *
 * @package ActoresElectorales2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$img_base = esc_url( AE_THEME_URI . '/assets/img' );
?>

	<!-- ═══ SCENE 1: Hero pineado ═══ -->
	<section class="scene" id="heroScene" data-steps="3" data-vh-per-step="70">
		<div class="pin">
			<div id="heroWrap" style="position:relative;width:100%;height:100%;background:#0f172a">
				<div id="heroPhoto" style="position:absolute;inset:0;opacity:0;transform:scale(1.15)">
					<img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/5.jpeg' ); ?>" alt="<?php esc_attr_e( 'Colombia unida en democracia', 'actores-electorales-2026' ); ?>" fetchpriority="high" width="1920" height="1080" style="width:100%;height:100%;object-fit:cover">
					<div id="heroScrim" style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(15,23,42,0.35),rgba(15,23,42,0.5))"></div>
				</div>
				<div id="heroBgLight" style="position:absolute;inset:0;background:radial-gradient(120% 80% at 50% 0%,#eaf1ff 0%,#fff 55%);opacity:1"></div>

				<div class="hex-deco" id="heroHex1" data-parallax="0.35" data-parallax-rotate="40" aria-hidden="true" style="top:10%;left:8%;width:90px;height:90px;background:rgba(255,198,39,0.25)"></div>
				<div class="hex-deco" id="heroHex2" data-parallax="-0.3" data-parallax-rotate="-30" aria-hidden="true" style="bottom:15%;right:6%;width:140px;height:140px;background:rgba(225,29,72,0.2)"></div>
				<div class="hex-deco" data-parallax="0.2" data-parallax-rotate="25" aria-hidden="true" style="top:25%;right:10%;width:50px;height:50px;background:rgba(30,58,138,0.18)"></div>
				<div class="hex-deco" data-parallax="-0.18" data-parallax-x="0.05" aria-hidden="true" style="bottom:30%;left:14%;width:70px;height:70px;background:rgba(255,198,39,0.16)"></div>
				<div class="hex-deco" data-parallax="0.15" aria-hidden="true" style="top:55%;left:4%;width:40px;height:40px;background:rgba(225,29,72,0.14)"></div>

				<div id="heroChip" style="position:absolute;top:40px;left:50%;transform:translateX(-50%);z-index:3">
					<span class="tri-chip">
						<span class="dots" aria-hidden="true"><span style="background:#ffc627"></span><span style="background:#1e3a8a"></span><span style="background:#e11d48"></span></span>
						<?php esc_html_e( 'Elecciones Presidenciales · Colombia 2026', 'actores-electorales-2026' ); ?>
					</span>
				</div>

				<div id="heroTitle" style="position:absolute;inset:0;display:grid;place-items:center;text-align:center;padding:32px;z-index:2">
					<div style="max-width:1200px">
						<h1 class="hero-title" data-word-reveal><?php esc_html_e( 'UN SOLO EQUIPO. UN SOLO PAÍS.', 'actores-electorales-2026' ); ?></h1>
						<div class="hero-sub" id="heroSub">
							<?php esc_html_e( 'Plataforma oficial de Actores Electorales del CNE para las elecciones presidenciales 2026. Lo conseguimos juntos.', 'actores-electorales-2026' ); ?>
						</div>
					</div>
				</div>

				<div id="heroCd" data-countdown role="timer" aria-label="<?php esc_attr_e( 'Cuenta regresiva para la primera vuelta del 31 de mayo de 2026', 'actores-electorales-2026' ); ?>" style="position:absolute;left:50%;bottom:max(80px,env(safe-area-inset-bottom));transform:translateX(-50%);opacity:1;text-align:center;z-index:3;width:100%;padding:0 16px">
					<div style="font-size:11px;letter-spacing:.24em;text-transform:uppercase;font-weight:700;margin-bottom:12px;color:#475569"><?php esc_html_e( 'Faltan para la primera vuelta · 31 de mayo 2026', 'actores-electorales-2026' ); ?></div>
					<div aria-hidden="true" style="display:flex;gap:clamp(10px,3vw,24px);justify-content:center;font-variant-numeric:tabular-nums">
						<div style="text-align:center"><div data-cd="d" style="font-size:clamp(36px,10vw,64px);font-weight:800;line-height:1;letter-spacing:-0.03em;color:#1e3a8a">00</div><div style="font-size:10px;letter-spacing:.18em;text-transform:uppercase;font-weight:700;margin-top:6px;opacity:.75"><?php esc_html_e( 'Días', 'actores-electorales-2026' ); ?></div></div>
						<div style="text-align:center"><div data-cd="h" style="font-size:clamp(36px,10vw,64px);font-weight:800;line-height:1;letter-spacing:-0.03em;color:#1e3a8a">00</div><div style="font-size:10px;letter-spacing:.18em;text-transform:uppercase;font-weight:700;margin-top:6px;opacity:.75"><?php esc_html_e( 'Horas', 'actores-electorales-2026' ); ?></div></div>
						<div style="text-align:center"><div data-cd="m" style="font-size:clamp(36px,10vw,64px);font-weight:800;line-height:1;letter-spacing:-0.03em;color:#1e3a8a">00</div><div style="font-size:10px;letter-spacing:.18em;text-transform:uppercase;font-weight:700;margin-top:6px;opacity:.75"><?php esc_html_e( 'Min', 'actores-electorales-2026' ); ?></div></div>
						<div style="text-align:center"><div data-cd="s" style="font-size:clamp(36px,10vw,64px);font-weight:800;line-height:1;letter-spacing:-0.03em;color:#1e3a8a">00</div><div style="font-size:10px;letter-spacing:.18em;text-transform:uppercase;font-weight:700;margin-top:6px;opacity:.75"><?php esc_html_e( 'Seg', 'actores-electorales-2026' ); ?></div></div>
					</div>
				</div>

				<div id="heroScroll" style="position:absolute;left:50%;bottom:24px;transform:translateX(-50%);color:#475569;font-size:11px;letter-spacing:.2em;text-transform:uppercase;font-weight:700;display:flex;align-items:center;gap:10px">
					<?php esc_html_e( 'Desplázate', 'actores-electorales-2026' ); ?> <span aria-hidden="true" style="font-size:18px">&darr;</span>
				</div>
			</div>
		</div>
	</section>

	<!-- ═══ SCENE 2: Big Statement ═══ -->
	<section class="scene" id="statementScene" data-parallax-trigger data-steps="3" data-vh-per-step="55">
		<div class="pin">
			<div id="statementWrap" style="width:100%;height:100%;display:grid;place-items:center;padding:32px;background:var(--ae-blue-soft);transition:background 300ms ease;position:relative;overflow:hidden">
				<div class="hex-deco" data-parallax="0.3" data-parallax-rotate="40" aria-hidden="true" style="top:8%;left:6%;width:100px;height:100px;background:rgba(30,58,138,0.14)"></div>
				<div class="hex-deco" data-parallax="-0.25" data-parallax-rotate="-30" aria-hidden="true" style="bottom:10%;right:8%;width:140px;height:140px;background:rgba(255,198,39,0.18)"></div>
				<div class="hex-deco" data-parallax="0.18" data-parallax-x="-0.05" aria-hidden="true" style="top:40%;right:3%;width:50px;height:50px;background:rgba(225,29,72,0.14)"></div>
				<div class="hex-deco" data-parallax="-0.16" aria-hidden="true" style="bottom:35%;left:5%;width:60px;height:60px;background:rgba(30,58,138,0.12)"></div>
				<div style="max-width:1100px;text-align:center;position:relative;z-index:2">
					<h2 style="font-size:clamp(36px,6vw,88px);font-weight:800;line-height:0.95;letter-spacing:-0.03em" data-word-reveal><?php esc_html_e( 'GARANTIZAMOS LA LEGITIMIDAD, TRANSPARENCIA Y PARTICIPACIÓN EN LAS ELECCIONES DE COLOMBIA.', 'actores-electorales-2026' ); ?></h2>
				</div>
			</div>
		</div>
	</section>

	<!-- ═══ SCENE 3: Pin-photo 3 estados ═══ -->
	<section class="scene" id="pinPhotoScene" data-steps="3" data-vh-per-step="70">
		<div class="pin">
			<div class="pin-photo" id="pinPhotoWrap">
				<div class="pin-photo-slide" data-slide="0" style="position:absolute;inset:0;opacity:1;transition:opacity 500ms var(--ease)">
					<img class="bg-img" src="<?php echo esc_url( AE_THEME_URI . '/assets/img/1.jpeg' ); ?>" alt="<?php esc_attr_e( 'Legitimidad electoral', 'actores-electorales-2026' ); ?>" loading="lazy" decoding="async">
					<div class="scrim" style="background:linear-gradient(90deg,rgba(15,23,42,0.85) 0%,rgba(15,23,42,0.3) 70%)"></div>
				</div>
				<div class="pin-photo-slide" data-slide="1" style="position:absolute;inset:0;opacity:0;transition:opacity 500ms var(--ease)">
					<img class="bg-img" src="<?php echo esc_url( AE_THEME_URI . '/assets/img/9.jpeg' ); ?>" alt="<?php esc_attr_e( 'Transparencia del proceso', 'actores-electorales-2026' ); ?>" loading="lazy" decoding="async">
					<div class="scrim" style="background:linear-gradient(90deg,rgba(15,23,42,0.85) 0%,rgba(15,23,42,0.3) 70%)"></div>
				</div>
				<div class="pin-photo-slide" data-slide="2" style="position:absolute;inset:0;opacity:0;transition:opacity 500ms var(--ease)">
					<img class="bg-img" src="<?php echo esc_url( AE_THEME_URI . '/assets/img/11.jpeg' ); ?>" alt="<?php esc_attr_e( 'Modernizar la democracia', 'actores-electorales-2026' ); ?>" loading="lazy" decoding="async">
					<div class="scrim" style="background:linear-gradient(90deg,rgba(15,23,42,0.85) 0%,rgba(15,23,42,0.3) 70%)"></div>
				</div>
				<div class="stage-text ae-stage-left" aria-live="polite" aria-atomic="true">
					<div style="max-width:720px">
						<div id="ppTag" style="font-size:13px;letter-spacing:.2em;text-transform:uppercase;font-weight:700;color:#ffc627;margin-bottom:20px">01 · <?php esc_html_e( 'LEGITIMIDAD', 'actores-electorales-2026' ); ?></div>
						<h2 id="ppTitle" style="font-size:clamp(36px,5.5vw,78px);font-weight:800;line-height:0.95;letter-spacing:-0.025em;color:#fff;margin-bottom:24px;text-shadow:0 2px 20px rgba(0,0,0,0.4)"><?php esc_html_e( 'GARANTIZAR LA LEGITIMIDAD ELECTORAL', 'actores-electorales-2026' ); ?></h2>
						<p id="ppBody" class="ae-body-light"><?php esc_html_e( 'Con más de 127.000 testigos acreditados, Actores Electorales verifica cada paso del proceso para que cada voto cuente.', 'actores-electorales-2026' ); ?></p>
					</div>
				</div>
				<div style="position:absolute;right:48px;top:50%;transform:translateY(-50%);display:flex;flex-direction:column;gap:14px;z-index:3" aria-hidden="true">
					<div class="pp-dot" style="width:3px;height:40px;background:#ffc627;transition:background 200ms"></div>
					<div class="pp-dot" style="width:3px;height:40px;background:rgba(255,255,255,0.25);transition:background 200ms"></div>
					<div class="pp-dot" style="width:3px;height:40px;background:rgba(255,255,255,0.25);transition:background 200ms"></div>
				</div>
			</div>
		</div>
	</section>

	<!-- ═══ SCENE 4: Card Stack ═══ -->
	<section class="scene" id="cardStackScene" data-parallax-trigger data-steps="3" data-vh-per-step="70">
		<div class="pin">
			<div style="width:100%;height:100%;display:grid;place-items:center;background:var(--ae-paper-2);position:relative;overflow:hidden">
				<div class="hex-deco" data-parallax="0.28" data-parallax-rotate="30" aria-hidden="true" style="top:12%;left:5%;width:110px;height:110px;background:rgba(30,58,138,0.1)"></div>
				<div class="hex-deco" data-parallax="-0.22" data-parallax-rotate="-25" aria-hidden="true" style="bottom:14%;right:6%;width:130px;height:130px;background:rgba(255,198,39,0.14)"></div>
				<div class="hex-deco" data-parallax="0.16" data-parallax-x="0.06" aria-hidden="true" style="top:50%;right:10%;width:55px;height:55px;background:rgba(225,29,72,0.1)"></div>
				<div style="text-align:center;position:absolute;top:8%;left:0;right:0;z-index:5">
					<div class="eyebrow" style="justify-content:center"><?php esc_html_e( 'Pilares del proceso', 'actores-electorales-2026' ); ?></div>
				</div>
				<div class="layer-stack">
					<div class="layer-card l1" id="lcard0" style="border-top:6px solid #1e3a8a;display:flex;flex-direction:column;justify-content:center">
						<div style="font-size:13px;letter-spacing:.2em;text-transform:uppercase;font-weight:800;color:#1e3a8a;margin-bottom:14px"><?php esc_html_e( 'Acreditación', 'actores-electorales-2026' ); ?></div>
						<h3 style="font-size:clamp(22px,6vw,44px);font-weight:800;line-height:1.05;letter-spacing:-0.025em;margin-bottom:14px"><?php esc_html_e( 'Plataforma de postulación digital', 'actores-electorales-2026' ); ?></h3>
						<p style="font-size:clamp(15px,4vw,17px);color:#334155;line-height:1.55;max-width:60ch;margin:0"><?php esc_html_e( 'Eliminamos los trámites físicos con una plataforma 100% digital para acreditar testigos electorales.', 'actores-electorales-2026' ); ?></p>
					</div>
					<div class="layer-card l2" id="lcard1" style="border-top:6px solid #e11d48;display:flex;flex-direction:column;justify-content:center">
						<div style="font-size:13px;letter-spacing:.2em;text-transform:uppercase;font-weight:800;color:#be123c;margin-bottom:14px"><?php esc_html_e( 'Observación', 'actores-electorales-2026' ); ?></div>
						<h3 style="font-size:clamp(22px,6vw,44px);font-weight:800;line-height:1.05;letter-spacing:-0.025em;margin-bottom:14px"><?php esc_html_e( 'Monitoreo en tiempo real', 'actores-electorales-2026' ); ?></h3>
						<p style="font-size:clamp(15px,4vw,17px);color:#334155;line-height:1.55;max-width:60ch;margin:0"><?php esc_html_e( 'COMITIUM permite vigilar en vivo la apertura de mesas, escrutinio y conteo desde cualquier dispositivo.', 'actores-electorales-2026' ); ?></p>
					</div>
					<div class="layer-card l3" id="lcard2" style="border-top:6px solid #ffc627;display:flex;flex-direction:column;justify-content:center">
						<div style="font-size:13px;letter-spacing:.2em;text-transform:uppercase;font-weight:800;color:#ffc627;margin-bottom:14px"><?php esc_html_e( 'Formación', 'actores-electorales-2026' ); ?></div>
						<h3 style="font-size:clamp(22px,6vw,44px);font-weight:800;line-height:1.05;letter-spacing:-0.025em;margin-bottom:14px"><?php esc_html_e( '6 módulos certificables', 'actores-electorales-2026' ); ?></h3>
						<p style="font-size:clamp(15px,4vw,17px);color:#334155;line-height:1.55;max-width:60ch;margin:0"><?php esc_html_e( 'Capacitación oficial con certificación para testigos, jurados y actores clave del proceso electoral 2026.', 'actores-electorales-2026' ); ?></p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- ═══ SCENE 5: Horizontal Section ═══ -->
	<section class="hz-section">
		<div class="hz-track">
			<div class="hz-panel">
				<img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/7.jpeg' ); ?>" alt="<?php esc_attr_e( 'Capacitación nacional', 'actores-electorales-2026' ); ?>" loading="lazy" decoding="async" class="ae-img-cover-abs">
				<div class="ae-scrim" aria-hidden="true"></div>
				<div class="ae-panel-body">
					<div class="ae-kicker-y">01 / 04</div>
					<h3 style="font-size:clamp(32px,4vw,56px);font-weight:800;line-height:0.95;letter-spacing:-0.025em;margin-bottom:16px"><?php esc_html_e( 'Capacitación nacional', 'actores-electorales-2026' ); ?></h3>
					<p class="ae-body-light"><?php esc_html_e( 'Talleres presenciales en todas las regiones para formar testigos electorales de excelencia.', 'actores-electorales-2026' ); ?></p>
				</div>
			</div>
			<div class="hz-panel">
				<img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/12.jpeg' ); ?>" alt="<?php esc_attr_e( 'Tecnología COMITIUM', 'actores-electorales-2026' ); ?>" loading="lazy" decoding="async" class="ae-img-cover-abs">
				<div class="ae-scrim" aria-hidden="true"></div>
				<div class="ae-panel-body">
					<div class="ae-kicker-y">02 / 04</div>
					<h3 style="font-size:clamp(32px,4vw,56px);font-weight:800;line-height:0.95;letter-spacing:-0.025em;margin-bottom:16px"><?php esc_html_e( 'Tecnología COMITIUM', 'actores-electorales-2026' ); ?></h3>
					<p class="ae-body-light"><?php esc_html_e( 'App móvil con biometría, geolocalización y reportes en tiempo real desde cada mesa.', 'actores-electorales-2026' ); ?></p>
				</div>
			</div>
			<div class="hz-panel">
				<img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/14.jpeg' ); ?>" alt="<?php esc_attr_e( 'Aliados internacionales', 'actores-electorales-2026' ); ?>" loading="lazy" decoding="async" class="ae-img-cover-abs">
				<div class="ae-scrim" aria-hidden="true"></div>
				<div class="ae-panel-body">
					<div class="ae-kicker-y">03 / 04</div>
					<h3 style="font-size:clamp(32px,4vw,56px);font-weight:800;line-height:0.95;letter-spacing:-0.025em;margin-bottom:16px"><?php esc_html_e( 'Aliados internacionales', 'actores-electorales-2026' ); ?></h3>
					<p class="ae-body-light"><?php esc_html_e( 'OEA, ONU y observadores acreditados verifican junto a nosotros la transparencia del proceso.', 'actores-electorales-2026' ); ?></p>
				</div>
			</div>
			<div class="hz-panel">
				<img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/10.jpeg' ); ?>" alt="<?php esc_attr_e( 'Cobertura total', 'actores-electorales-2026' ); ?>" loading="lazy" decoding="async" class="ae-img-cover-abs">
				<div class="ae-scrim" aria-hidden="true"></div>
				<div class="ae-panel-body">
					<div class="ae-kicker-y">04 / 04</div>
					<h3 style="font-size:clamp(32px,4vw,56px);font-weight:800;line-height:0.95;letter-spacing:-0.025em;margin-bottom:16px"><?php esc_html_e( 'Cobertura total', 'actores-electorales-2026' ); ?></h3>
					<p class="ae-body-light"><?php esc_html_e( '1.103 municipios, 67 consulados y más de 127.000 testigos listos para el 31 de mayo.', 'actores-electorales-2026' ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<!-- ═══ SCENE 6: Big Numbers ═══ -->
	<section class="pad" data-parallax-trigger style="background:#ffc627;position:relative;overflow:hidden">
		<div class="hex-deco" data-parallax="0.35" data-parallax-rotate="45" aria-hidden="true" style="top:40px;left:60px;width:120px;height:120px;background:#e11d48"></div>
		<div class="hex-deco" data-parallax="-0.25" data-parallax-rotate="-30" aria-hidden="true" style="bottom:80px;right:80px;width:180px;height:180px;background:#1e3a8a"></div>
		<div class="hex-deco" data-parallax="0.18" data-parallax-x="-0.08" aria-hidden="true" style="top:45%;right:12%;width:70px;height:70px;background:rgba(30,58,138,0.18)"></div>
		<div class="hex-deco" data-parallax="-0.12" data-parallax-x="0.06" aria-hidden="true" style="bottom:30%;left:14%;width:90px;height:90px;background:rgba(225,29,72,0.18)"></div>
		<div class="wrap ae-z2">
			<div style="text-align:center;margin-bottom:56px">
				<h2 style="font-size:13px;letter-spacing:.22em;text-transform:uppercase;font-weight:800;color:#1e3a8a;margin:0"><?php esc_html_e( 'Impacto en cifras · 2026', 'actores-electorales-2026' ); ?></h2>
			</div>
			<div class="g4" style="gap:40px;text-align:center">
				<div>
					<div class="bignum" style="color:#0f172a" data-countup="127592">0</div>
					<div class="ae-stat-label"><?php esc_html_e( 'Testigos acreditados', 'actores-electorales-2026' ); ?></div>
				</div>
				<div>
					<div class="bignum" style="color:#0f172a" data-countup="1103">0</div>
					<div class="ae-stat-label"><?php esc_html_e( 'Municipios', 'actores-electorales-2026' ); ?></div>
				</div>
				<div>
					<div class="bignum" style="color:#0f172a" data-countup="67">0</div>
					<div class="ae-stat-label"><?php esc_html_e( 'Consulados', 'actores-electorales-2026' ); ?></div>
				</div>
				<div>
					<div class="bignum" style="color:#0f172a" data-countup="6000000" data-suffix="+">0</div>
					<div class="ae-stat-label"><?php esc_html_e( 'Sufragantes atendidos', 'actores-electorales-2026' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- ═══ SCENE 7: Press Quotes ═══ -->
	<section class="scene" id="quotesScene" data-parallax-trigger data-steps="3" data-vh-per-step="55">
		<div class="pin">
			<div style="width:100%;height:100%;background:#0f172a;color:#fff;display:grid;place-items:center;padding:32px;position:relative;overflow:hidden">
				<div class="hex-deco" data-parallax="0.32" data-parallax-rotate="35" aria-hidden="true" style="top:10%;left:8%;width:120px;height:120px;background:rgba(255,198,39,0.12)"></div>
				<div class="hex-deco" data-parallax="-0.26" data-parallax-rotate="-28" aria-hidden="true" style="bottom:12%;right:7%;width:150px;height:150px;background:rgba(225,29,72,0.14)"></div>
				<div class="hex-deco" data-parallax="0.18" data-parallax-x="-0.06" aria-hidden="true" style="top:45%;right:15%;width:60px;height:60px;background:rgba(47,179,217,0.14)"></div>
				<div class="hex-deco" data-parallax="-0.14" aria-hidden="true" style="bottom:40%;left:12%;width:70px;height:70px;background:rgba(255,198,39,0.1)"></div>
				<div style="text-align:center;max-width:1100px">
					<div style="font-size:13px;letter-spacing:.2em;text-transform:uppercase;font-weight:700;color:#ffc627;margin-bottom:32px"><?php esc_html_e( 'Lo que hablan los medios', 'actores-electorales-2026' ); ?></div>
					<div style="position:relative;min-height:280px" aria-live="polite" aria-atomic="true">
						<div class="quote-slide" data-qslide="0" style="position:absolute;inset:0;opacity:1;transition:all 400ms var(--ease)">
							<div style="font-size:clamp(24px,3.5vw,42px);font-weight:600;line-height:1.25;letter-spacing:-0.02em;margin-bottom:32px">
								<span style="color:#ffc627;font-size:60px;vertical-align:middle;margin-right:8px" aria-hidden="true">&ldquo;</span>
								<?php esc_html_e( 'El simulacro se realizó con éxito, reforzando las garantías para el registro de los testigos electorales.', 'actores-electorales-2026' ); ?>
								<span style="color:#ffc627;font-size:60px;vertical-align:middle;margin-left:8px" aria-hidden="true">&rdquo;</span>
							</div>
							<div style="font-size:22px;font-weight:800;letter-spacing:.08em;color:#f43f5e">&mdash; SEMANA</div>
						</div>
						<div class="quote-slide" data-qslide="1" style="position:absolute;inset:0;opacity:0;transform:translateY(20px);transition:all 400ms var(--ease)">
							<div style="font-size:clamp(24px,3.5vw,42px);font-weight:600;line-height:1.25;letter-spacing:-0.02em;margin-bottom:32px">
								<span style="color:#ffc627;font-size:60px;vertical-align:middle;margin-right:8px" aria-hidden="true">&ldquo;</span>
								<?php esc_html_e( 'El aplicativo facilitará la vigilancia en los más de 127.000 puestos de votación distribuidos en todo el territorio.', 'actores-electorales-2026' ); ?>
								<span style="color:#ffc627;font-size:60px;vertical-align:middle;margin-left:8px" aria-hidden="true">&rdquo;</span>
							</div>
							<div style="font-size:22px;font-weight:800;letter-spacing:.08em;color:#f43f5e">&mdash; EL TIEMPO</div>
						</div>
						<div class="quote-slide" data-qslide="2" style="position:absolute;inset:0;opacity:0;transform:translateY(20px);transition:all 400ms var(--ease)">
							<div style="font-size:clamp(24px,3.5vw,42px);font-weight:600;line-height:1.25;letter-spacing:-0.02em;margin-bottom:32px">
								<span style="color:#ffc627;font-size:60px;vertical-align:middle;margin-right:8px" aria-hidden="true">&ldquo;</span>
								<?php esc_html_e( 'Un precedente en transparencia para las elecciones presidenciales de 2026.', 'actores-electorales-2026' ); ?>
								<span style="color:#ffc627;font-size:60px;vertical-align:middle;margin-left:8px" aria-hidden="true">&rdquo;</span>
							</div>
							<div style="font-size:22px;font-weight:800;letter-spacing:.08em;color:#f43f5e">&mdash; EL ESPECTADOR</div>
						</div>
					</div>
					<div id="quoteDots" style="display:flex;gap:8px;justify-content:center;margin-top:40px" aria-hidden="true">
						<div style="width:32px;height:4px;background:#ffc627;transition:all 200ms"></div>
						<div style="width:12px;height:4px;background:rgba(255,255,255,0.2);transition:all 200ms"></div>
						<div style="width:12px;height:4px;background:rgba(255,255,255,0.2);transition:all 200ms"></div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- ═══ Recent News ═══ -->
	<section class="pad" data-parallax-trigger style="background:#f8fafc;position:relative;overflow:hidden">
		<div class="hex-deco" data-parallax="0.25" data-parallax-rotate="25" aria-hidden="true" style="top:10%;right:-40px;width:160px;height:160px;background:rgba(225,29,72,0.08)"></div>
		<div class="hex-deco" data-parallax="-0.18" data-parallax-rotate="-20" aria-hidden="true" style="bottom:5%;left:-30px;width:130px;height:130px;background:rgba(30,58,138,0.08)"></div>
		<div class="wrap ae-z2">
			<div style="display:flex;justify-content:space-between;align-items:end;margin-bottom:40px;gap:20px;flex-wrap:wrap">
				<div data-enter>
					<div class="eyebrow"><?php esc_html_e( 'Sala de prensa', 'actores-electorales-2026' ); ?></div>
					<h2 class="ae-h2"><?php esc_html_e( 'Las noticias más recientes', 'actores-electorales-2026' ); ?></h2>
					<p style="max-width:640px;color:#334155;font-size:17px;line-height:1.55;margin-top:16px"><?php esc_html_e( 'Comunicados oficiales, avances electorales y talleres de capacitación que impulsan la transparencia y la participación ciudadana en el proceso 2026.', 'actores-electorales-2026' ); ?></p>
				</div>
				<a href="<?php echo esc_url( home_url( '/prensa/' ) ); ?>" class="btn outline"><?php esc_html_e( 'Ver toda la sala de prensa', 'actores-electorales-2026' ); ?> &rarr;</a>
			</div>
			<div class="g3">
				<article class="news-card" data-enter data-delay="1">
					<div class="im"><img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/4.jpeg' ); ?>" alt="<?php esc_attr_e( 'Colombia unida en democracia', 'actores-electorales-2026' ); ?>" width="640" height="400" loading="lazy" decoding="async"></div>
					<div class="body">
						<div class="m">15 abr 2026</div>
						<h4><?php esc_html_e( 'Colombia unida en democracia: el CNE presentó su estrategia para los testigos electorales', 'actores-electorales-2026' ); ?></h4>
						<p><?php esc_html_e( 'Bogotá D.C., 15 de abril de 2026 (@CNE_COLOMBIA) — Este miércoles, en Corferias, el Consejo...', 'actores-electorales-2026' ); ?></p>
						<span class="readmore"><?php esc_html_e( 'Leer más', 'actores-electorales-2026' ); ?> &rarr;</span>
					</div>
				</article>
				<article class="news-card" data-enter data-delay="2">
					<div class="im"><img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/16.jpg' ); ?>" alt="<?php esc_attr_e( 'CNE declara elección', 'actores-electorales-2026' ); ?>" width="640" height="400" loading="lazy" decoding="async"></div>
					<div class="body">
						<div class="m">15 abr 2026</div>
						<h4><?php esc_html_e( 'CNE declara la elección de Representante a la Cámara por el Atlántico', 'actores-electorales-2026' ); ?></h4>
						<p><?php esc_html_e( 'Luego de surtir el debido proceso, la Sala plena del Consejo Nacional Electoral declaró...', 'actores-electorales-2026' ); ?></p>
						<span class="readmore"><?php esc_html_e( 'Leer más', 'actores-electorales-2026' ); ?> &rarr;</span>
					</div>
				</article>
				<article class="news-card" data-enter data-delay="3">
					<div class="im"><img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/22.jpg' ); ?>" alt="<?php esc_attr_e( 'Garantías plenas', 'actores-electorales-2026' ); ?>" width="640" height="400" loading="lazy" decoding="async"></div>
					<div class="body">
						<div class="m">14 abr 2026</div>
						<h4><?php esc_html_e( 'Garantías plenas en elecciones atípicas de Sitionuevo', 'actores-electorales-2026' ); ?></h4>
						<p><?php esc_html_e( 'El Consejo Nacional Electoral (CNE) informa que se mantienen las garantías plenas...', 'actores-electorales-2026' ); ?></p>
						<span class="readmore"><?php esc_html_e( 'Leer más', 'actores-electorales-2026' ); ?> &rarr;</span>
					</div>
				</article>
			</div>
		</div>
	</section>

	<!-- ═══ Training Teaser ═══ -->
	<section class="pad" data-parallax-trigger style="background:#1e3a8a;color:#fff;overflow:hidden;position:relative">
		<div class="hex-deco" data-parallax="0.35" data-parallax-rotate="35" aria-hidden="true" style="top:-60px;right:-80px;width:260px;height:260px;background:rgba(255,198,39,0.15)"></div>
		<div class="hex-deco" data-parallax="-0.22" data-parallax-rotate="-25" aria-hidden="true" style="bottom:-40px;left:-60px;width:200px;height:200px;background:rgba(225,29,72,0.18)"></div>
		<div class="hex-deco" data-parallax="0.14" data-parallax-x="-0.08" aria-hidden="true" style="top:50%;left:40%;width:80px;height:80px;background:rgba(255,198,39,0.12)"></div>
		<div class="wrap ae-split ae-z2">
			<div data-enter="left">
				<div style="color:#ffc627;font-size:13px;letter-spacing:.2em;text-transform:uppercase;font-weight:800;margin-bottom:20px"><?php esc_html_e( 'Entrenamiento', 'actores-electorales-2026' ); ?></div>
				<h2 style="font-size:clamp(36px,5vw,72px);font-weight:800;line-height:0.95;letter-spacing:-0.025em;color:#fff"><?php esc_html_e( 'FORTALECEMOS LA PARTICIPACIÓN POLÍTICA CON FORMACIÓN ESTRATÉGICA.', 'actores-electorales-2026' ); ?></h2>
				<p style="font-size:18px;color:rgba(255,255,255,0.85);max-width:560px;margin-top:20px;line-height:1.55"><?php esc_html_e( 'Plataforma de capacitación oficial para testigos electorales, jurados y actores clave del proceso electoral 2026.', 'actores-electorales-2026' ); ?></p>
				<div class="ae-cta-row-lg">
					<a href="<?php echo esc_url( home_url( '/entrenamiento/' ) ); ?>" class="btn yellow"><?php esc_html_e( 'Comenzar capacitación', 'actores-electorales-2026' ); ?> &rarr;</a>
					<a href="<?php echo esc_url( home_url( '/entrenamiento/' ) ); ?>" class="btn" style="background:transparent;border:1.5px solid rgba(255,255,255,0.3)"><?php esc_html_e( 'Ver módulos', 'actores-electorales-2026' ); ?></a>
				</div>
			</div>
			<div data-enter="right" style="position:relative">
				<div style="background:#fff;border-radius:16px;padding:8px;box-shadow:0 30px 60px rgba(0,0,0,0.2);transform:rotate(-2deg)">
					<img src="<?php echo esc_url( AE_THEME_URI . '/assets/img/10.jpeg' ); ?>" alt="<?php esc_attr_e( 'Capacitación de testigos', 'actores-electorales-2026' ); ?>" loading="lazy" decoding="async" style="width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:8px">
				</div>
				<div style="position:absolute;bottom:-20px;right:-20px;background:#ffc627;color:#0f172a;padding:16px 24px;border-radius:12px;font-weight:800;box-shadow:0 10px 30px rgba(0,0,0,0.25)">
					<div style="font-size:32px;line-height:1"><?php esc_html_e( '6 módulos', 'actores-electorales-2026' ); ?></div>
					<div style="font-size:11px;letter-spacing:.15em;text-transform:uppercase"><?php esc_html_e( 'certificables', 'actores-electorales-2026' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- ═══ Final CTA ═══ -->
	<section class="pad" data-parallax-trigger style="position:relative;overflow:hidden">
		<div class="hex-deco" data-parallax="0.3" data-parallax-rotate="40" aria-hidden="true" style="top:-30px;left:5%;width:140px;height:140px;background:rgba(255,198,39,0.18)"></div>
		<div class="hex-deco" data-parallax="-0.25" data-parallax-rotate="-35" aria-hidden="true" style="bottom:-20px;right:6%;width:170px;height:170px;background:rgba(30,58,138,0.12)"></div>
		<div class="hex-deco" data-parallax="0.18" aria-hidden="true" style="top:40%;right:18%;width:60px;height:60px;background:rgba(225,29,72,0.18)"></div>
		<div class="wrap" style="text-align:center;max-width:900px;margin-left:auto;margin-right:auto;position:relative;z-index:2">
			<div data-enter>
				<div class="eyebrow" style="justify-content:center"><?php esc_html_e( 'Súmate al movimiento', 'actores-electorales-2026' ); ?></div>
				<h2 style="font-size:clamp(36px,5vw,72px);font-weight:800;letter-spacing:-0.025em;margin-top:12px;line-height:0.95"><?php esc_html_e( 'Por una Colombia', 'actores-electorales-2026' ); ?><br><?php esc_html_e( 'que juega', 'actores-electorales-2026' ); ?> <span style="color:#e11d48"><?php esc_html_e( 'en equipo.', 'actores-electorales-2026' ); ?></span></h2>
				<p style="font-size:18px;color:#334155;margin-top:20px;line-height:1.55"><?php esc_html_e( 'No es una campaña. Es un compromiso. Cada voto cuenta, cada testigo importa.', 'actores-electorales-2026' ); ?></p>
				<div style="display:flex;gap:12px;justify-content:center;margin-top:32px;flex-wrap:wrap">
					<a href="<?php echo esc_url( home_url( '/plataforma/' ) ); ?>" class="btn red"><?php esc_html_e( 'Ir a la Plataforma', 'actores-electorales-2026' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/canales/' ) ); ?>" class="btn outline"><?php esc_html_e( 'Contáctanos', 'actores-electorales-2026' ); ?></a>
				</div>
			</div>
		</div>
	</section>

<?php
get_footer();
