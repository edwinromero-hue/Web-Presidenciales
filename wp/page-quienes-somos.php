<?php
/**
 * Template Name: Quiénes somos
 * Template Post Type: page
 *
 * Asignable desde Páginas → Atributos de página → Plantilla.
 * Portado 1:1 desde quienes-somos.html (Fase F, sesión 2).
 *
 * @package ActoresElectorales2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

	<!-- ═══ SECTION 1: Page Hero ═══ -->
	<section class="ph" style="position:relative;overflow:hidden">
		<div class="ph-deco" data-parallax="0.2" aria-hidden="true"></div>
		<div class="ph-deco-2" data-parallax="-0.15" aria-hidden="true"></div>
		<div class="wrap ae-z2">
			<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Ruta de navegación', 'actores-electorales-2026' ); ?>" data-enter>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a> / <span aria-current="page">Quiénes somos</span>
			</nav>
			<div data-enter>
				<div class="eyebrow" style="margin-top:24px">Nosotros</div>
				<h1 style="font-size:clamp(40px,6vw,88px);font-weight:800;line-height:0.95;letter-spacing:-0.03em;margin-top:16px;max-width:900px">Aliados tecnológicos con el CNE.</h1>
				<p style="font-size:20px;line-height:1.55;color:#334155;max-width:680px;margin-top:24px">Somos el equipo detrás de la infraestructura digital que permite acreditar, capacitar y coordinar a más de 127.000 testigos electorales en todo el territorio colombiano para las elecciones presidenciales 2026.</p>
			</div>
		</div>
	</section>

	<!-- ═══ SECTION 2: Big Statement with Word Reveal ═══ -->
	<section class="pad" style="background:#0f172a;color:#fff">
		<div class="wrap" style="text-align:center;max-width:1100px;margin-left:auto;margin-right:auto">
			<h2 style="font-size:clamp(36px,6vw,88px);font-weight:800;line-height:0.95;letter-spacing:-0.03em" data-word-reveal>CONSTRUIMOS LA INFRAESTRUCTURA DIGITAL QUE SOSTIENE LA DEMOCRACIA COLOMBIANA.</h2>
		</div>
	</section>

	<!-- ═══ SECTION 3: Impact Stats with Count-Up ═══ -->
	<section class="pad" style="background:#fff;position:relative;overflow:hidden">
		<div class="wrap">
			<div style="text-align:center;margin-bottom:56px" data-enter>
				<div class="eyebrow" style="justify-content:center">Impacto en cifras</div>
				<h2 class="ae-h2">Nuestro alcance en números</h2>
			</div>
			<div class="g4" style="gap:24px">
				<div class="fcard" data-enter data-delay="1" style="background:#1e3a8a;color:#fff;padding:48px 32px;border-radius:16px;text-align:center">
					<div style="font-size:clamp(48px,8vw,80px);font-weight:800;line-height:1;letter-spacing:-0.03em" data-countup="127" data-suffix="K+">0</div>
					<div style="font-size:15px;font-weight:700;margin-top:16px;text-transform:uppercase;letter-spacing:.1em">Testigos en acción</div>
				</div>
				<div class="fcard" data-enter data-delay="2" style="background:#e11d48;color:#fff;padding:48px 32px;border-radius:16px;text-align:center">
					<div style="font-size:clamp(48px,8vw,80px);font-weight:800;line-height:1;letter-spacing:-0.03em" data-countup="6" data-suffix="M+">0</div>
					<div style="font-size:15px;font-weight:700;margin-top:16px;text-transform:uppercase;letter-spacing:.1em">Sufragantes atendidos</div>
				</div>
				<div class="fcard" data-enter data-delay="3" style="background:#ffc627;color:#0f172a;padding:48px 32px;border-radius:16px;text-align:center">
					<div style="font-size:clamp(48px,8vw,80px);font-weight:800;line-height:1;letter-spacing:-0.03em" data-countup="2798">0</div>
					<div style="font-size:15px;font-weight:700;margin-top:16px;text-transform:uppercase;letter-spacing:.1em">Auditorías internas</div>
				</div>
				<div class="fcard" data-enter data-delay="4" style="background:#2fb3d9;color:#0f172a;padding:48px 32px;border-radius:16px;text-align:center">
					<div style="font-size:clamp(48px,8vw,80px);font-weight:800;line-height:1;letter-spacing:-0.03em" data-countup="100" data-suffix="%">0</div>
					<div style="font-size:15px;font-weight:700;margin-top:16px;text-transform:uppercase;letter-spacing:.1em">Digital y seguro</div>
				</div>
			</div>
		</div>
	</section>

	<!-- ═══ SECTION 4: Allies Section ═══ -->
	<section class="pad" style="background:#f8fafc">
		<div class="wrap">
			<div style="text-align:center;margin-bottom:56px" data-enter>
				<div class="eyebrow" style="justify-content:center">Aliados</div>
				<h2 class="ae-h2">Aliados tecnológicos con el CNE</h2>
			</div>
			<div class="g3" style="gap:24px">
				<div class="fcard ae-mission-card" data-enter data-delay="1">
					<div class="ae-card-icon" aria-hidden="true">🏛️</div>
					<h3 class="ae-card-title">CNE</h3>
					<p class="ae-body-sm">Consejo Nacional Electoral. Autoridad rectora del proceso electoral colombiano.</p>
				</div>
				<div class="fcard ae-mission-card" data-enter data-delay="2">
					<div class="ae-card-icon" aria-hidden="true">📋</div>
					<h3 class="ae-card-title">Registraduría</h3>
					<p class="ae-body-sm">Registraduría Nacional del Estado Civil. Garante de la identidad y el registro electoral.</p>
				</div>
				<div class="fcard ae-mission-card" data-enter data-delay="3">
					<div class="ae-card-icon" aria-hidden="true">💻</div>
					<h3 class="ae-card-title">MinTIC</h3>
					<p class="ae-body-sm">Ministerio de Tecnologías de la Información y las Comunicaciones. Infraestructura digital del Estado.</p>
				</div>
				<div class="fcard ae-mission-card" data-enter="left" data-delay="4">
					<div class="ae-card-icon" aria-hidden="true">🌍</div>
					<h3 class="ae-card-title">ONU Colombia</h3>
					<p class="ae-body-sm">Naciones Unidas en Colombia. Observación y acompañamiento internacional al proceso democrático.</p>
				</div>
				<div class="fcard ae-mission-card" data-enter data-delay="5">
					<div class="ae-card-icon" aria-hidden="true">🤝</div>
					<h3 class="ae-card-title">OEA</h3>
					<p class="ae-body-sm">Organización de los Estados Americanos. Misión de observación electoral y cooperación hemisférica.</p>
				</div>
				<div class="fcard ae-mission-card" data-enter="right" data-delay="6">
					<div class="ae-card-icon" aria-hidden="true">🇨🇴</div>
					<h3 class="ae-card-title">Un Solo Equipo</h3>
					<p class="ae-body-sm">La unión de instituciones, ciudadanos y tecnología al servicio de la democracia colombiana.</p>
				</div>
			</div>
		</div>
	</section>

<?php
get_footer();
