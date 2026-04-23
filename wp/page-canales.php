<?php
/**
 * Template Name: Canales de atención
 * Template Post Type: page
 *
 * Portado 1:1 desde canales.html (Fase F, sesión 2).
 * Incluye chat widget estático + IIFE con null-guards para cerrar/abrir.
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
				<span aria-current="page" style="color:#1e3a8a;font-weight:600">Canales de atención</span>
			</nav>
			<div class="eyebrow">Estamos contigo</div>
			<h1 style="font-size:clamp(40px,6vw,80px);font-weight:800;line-height:0.95;letter-spacing:-0.03em;margin-top:16px">Canales de atención.</h1>
			<p style="font-size:18px;color:#334155;max-width:640px;line-height:1.55;margin-top:20px">Resolvemos tus dudas por correo, teléfono o WhatsApp. También puedes consultar las preguntas frecuentes sobre la plataforma de Actores Electorales.</p>
		</div>
		<div class="ph-deco" data-parallax="0.15" aria-hidden="true" style="position:absolute;top:10%;right:5%;width:200px;height:200px;background:rgba(30,58,138,0.1);border-radius:50%"></div>
	</section>

	<!-- ═══ SECTION 2: Sidebar + FAQ ═══ -->
	<section class="pad" style="background:#fff">
		<div class="wrap ae-split-sidebar">

			<!-- Left sidebar -->
			<aside class="ae-sticky-side">
				<div class="card" style="background:#f8fafc;border-radius:16px;padding:32px;border:1px solid #e2e8f0">
					<div class="eyebrow" style="margin-bottom:12px">Información</div>
					<p style="font-size:15px;color:#334155;line-height:1.55;margin-bottom:28px">Si tienes alguna duda sobre el proceso de postulación, acreditación o uso de la plataforma, contáctanos por cualquiera de estos canales.</p>

					<!-- Email -->
					<div style="display:flex;align-items:flex-start;gap:14px;padding:16px 0;border-top:1px solid #e2e8f0">
						<div style="width:40px;height:40px;border-radius:10px;background:#eef2ff;display:grid;place-items:center;flex-shrink:0">
							<svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1e3a8a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><polyline points="22,7 12,13 2,7"/></svg>
						</div>
						<div>
							<div style="font-size:12px;letter-spacing:.1em;text-transform:uppercase;font-weight:700;color:#475569">Correo</div>
							<a href="mailto:contacto.mesa@actoreselectorales.com" style="font-size:14px;font-weight:600;color:#1e3a8a;text-decoration:none;word-break:break-all">contacto.mesa@actoreselectorales.com</a>
						</div>
					</div>

					<!-- Phone -->
					<div style="display:flex;align-items:flex-start;gap:14px;padding:16px 0;border-top:1px solid #e2e8f0">
						<div style="width:40px;height:40px;border-radius:10px;background:#fef2f2;display:grid;place-items:center;flex-shrink:0">
							<svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#e11d48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.79 19.79 0 012.12 4.18 2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.362 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
						</div>
						<div>
							<div style="font-size:12px;letter-spacing:.1em;text-transform:uppercase;font-weight:700;color:#475569">Teléfono</div>
							<a href="tel:+576017702692" style="font-size:14px;font-weight:600;color:#0f172a;text-decoration:none">(601) 770 2692</a>
						</div>
					</div>

					<!-- WhatsApp -->
					<div style="display:flex;align-items:flex-start;gap:14px;padding:16px 0;border-top:1px solid #e2e8f0">
						<div style="width:40px;height:40px;border-radius:10px;background:#f0fdf4;display:grid;place-items:center;flex-shrink:0">
							<svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" fill="#15803d"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
						</div>
						<div>
							<div style="font-size:12px;letter-spacing:.1em;text-transform:uppercase;font-weight:700;color:#475569">WhatsApp</div>
							<a href="https://wa.me/573009110489" target="_blank" rel="noopener noreferrer" style="font-size:14px;font-weight:600;color:#15803d;text-decoration:none">(+57) 300 911 0489</a>
						</div>
					</div>
				</div>
			</aside>

			<!-- Right: FAQ -->
			<div>
				<h2 style="font-size:clamp(28px,4vw,44px);font-weight:800;letter-spacing:-0.025em;margin-bottom:32px">Preguntas frecuentes</h2>

				<div class="faq-group" style="display:flex;flex-direction:column;gap:8px">

					<!-- FAQ 1 -->
					<div class="ae-faq-item">
						<button type="button" class="ae-faq-btn" aria-expanded="false" onclick="var p=this.parentElement;var o=p.classList.toggle('open');this.setAttribute('aria-expanded',o?'true':'false');">
							<span>&iquest;Cuáles son las fechas de postulación?</span>
							<span class="ae-faq-plus" aria-hidden="true">+</span>
						</button>
						<div class="ae-faq-answer">
							<div class="ae-faq-answer-inner">
								El período de postulación abre el <strong>1 de marzo</strong> y cierra el <strong>15 de abril de 2026</strong>. Las agrupaciones políticas deben completar el registro de sus testigos dentro de este plazo a través de la plataforma oficial.
							</div>
						</div>
					</div>

					<!-- FAQ 2 -->
					<div class="ae-faq-item">
						<button type="button" class="ae-faq-btn" aria-expanded="false" onclick="var p=this.parentElement;var o=p.classList.toggle('open');this.setAttribute('aria-expanded',o?'true':'false');">
							<span>&iquest;A dónde llega el usuario y contraseña?</span>
							<span class="ae-faq-plus" aria-hidden="true">+</span>
						</button>
						<div class="ae-faq-answer">
							<div class="ae-faq-answer-inner">
								Las credenciales de acceso (usuario y contraseña) se envían al <strong>correo electrónico registrado</strong> por la agrupación política al momento de la inscripción en la plataforma.
							</div>
						</div>
					</div>

					<!-- FAQ 3 -->
					<div class="ae-faq-item">
						<button type="button" class="ae-faq-btn" aria-expanded="false" onclick="var p=this.parentElement;var o=p.classList.toggle('open');this.setAttribute('aria-expanded',o?'true':'false');">
							<span>Si no me llega el correo electrónico, &iquest;qué puedo hacer?</span>
							<span class="ae-faq-plus" aria-hidden="true">+</span>
						</button>
						<div class="ae-faq-answer">
							<div class="ae-faq-answer-inner">
								Si no ha recibido el correo, por favor revise la carpeta de spam o correo no deseado. Si aún así no lo encuentra, escriba a <strong>contacto.mesa@actoreselectorales.com</strong> indicando el nombre de la agrupación política y el correo registrado.
							</div>
						</div>
					</div>

					<!-- FAQ 4 -->
					<div class="ae-faq-item">
						<button type="button" class="ae-faq-btn" aria-expanded="false" onclick="var p=this.parentElement;var o=p.classList.toggle('open');this.setAttribute('aria-expanded',o?'true':'false');">
							<span>Me llegó el usuario y contraseña, pero no he logrado ingresar</span>
							<span class="ae-faq-plus" aria-hidden="true">+</span>
						</button>
						<div class="ae-faq-answer">
							<div class="ae-faq-answer-inner">
								Verifique que está ingresando a la <strong>URL correcta</strong> de la plataforma. Si el problema persiste, utilice la opción <strong>"Restablecer contraseña"</strong> en la pantalla de inicio de sesión. En caso de que continúe sin poder acceder, contacte a la mesa de ayuda.
							</div>
						</div>
					</div>

					<!-- FAQ 5 -->
					<div class="ae-faq-item">
						<button type="button" class="ae-faq-btn" aria-expanded="false" onclick="var p=this.parentElement;var o=p.classList.toggle('open');this.setAttribute('aria-expanded',o?'true':'false');">
							<span>&iquest;Cómo puedo conseguir la Divipole Definitiva?</span>
							<span class="ae-faq-plus" aria-hidden="true">+</span>
						</button>
						<div class="ae-faq-answer">
							<div class="ae-faq-answer-inner">
								La Divipole Definitiva está disponible para <strong>descarga directa desde la Plataforma</strong> de Actores Electorales, en la sección de documentos y recursos. Ingrese con sus credenciales y busque el archivo en el módulo correspondiente.
							</div>
						</div>
					</div>

					<!-- FAQ 6 -->
					<div class="ae-faq-item">
						<button type="button" class="ae-faq-btn" aria-expanded="false" onclick="var p=this.parentElement;var o=p.classList.toggle('open');this.setAttribute('aria-expanded',o?'true':'false');">
							<span>&iquest;De cuántos usuarios dispondrá la agrupación política?</span>
							<span class="ae-faq-plus" aria-hidden="true">+</span>
						</button>
						<div class="ae-faq-answer">
							<div class="ae-faq-answer-inner">
								Cada agrupación política podrá contar con <strong>hasta 3 usuarios administradores</strong> para gestionar la postulación de testigos electorales a través de la plataforma.
							</div>
						</div>
					</div>

					<!-- FAQ 7 -->
					<div class="ae-faq-item">
						<button type="button" class="ae-faq-btn" aria-expanded="false" onclick="var p=this.parentElement;var o=p.classList.toggle('open');this.setAttribute('aria-expanded',o?'true':'false');">
							<span>Cuando se presenta un error en la información de postulación, &iquest;qué hacer?</span>
							<span class="ae-faq-plus" aria-hidden="true">+</span>
						</button>
						<div class="ae-faq-answer">
							<div class="ae-faq-answer-inner">
								Si detecta un error en los datos de postulación, debe diligenciar el <strong>formulario de corrección</strong> disponible en la plataforma. El equipo de soporte revisará y procesará la solicitud en un plazo de 24 a 48 horas hábiles.
							</div>
						</div>
					</div>

					<!-- FAQ 8 -->
					<div class="ae-faq-item">
						<button type="button" class="ae-faq-btn" aria-expanded="false" onclick="var p=this.parentElement;var o=p.classList.toggle('open');this.setAttribute('aria-expanded',o?'true':'false');">
							<span>Queremos hacer un cargue máximo de testigos, pero no se permite</span>
							<span class="ae-faq-plus" aria-hidden="true">+</span>
						</button>
						<div class="ae-faq-answer">
							<div class="ae-faq-answer-inner">
								La plataforma permite un <strong>máximo de 5.000 registros por archivo</strong> en cada carga masiva. Si necesita postular mas testigos, divida la información en múltiples archivos y realice cargas sucesivas respetando este límite.
							</div>
						</div>
					</div>

				</div>

			</div>

		</div>
	</section>

	<!-- ===== CHAT WIDGET (static) ===== -->
	<div id="chatWidget" style="position:fixed;bottom:24px;right:24px;width:360px;display:flex;flex-direction:column;background:#fff;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,0.15);overflow:hidden;z-index:1000;max-height:480px">
		<!-- Header -->
		<div style="background:#1e3a8a;color:#fff;padding:16px 20px;display:flex;align-items:center;gap:12px">
			<div style="width:36px;height:36px;border-radius:50%;background:#ffc627;display:grid;place-items:center;font-weight:800;font-size:14px;color:#1e3a8a;flex-shrink:0">C</div>
			<div style="flex:1">
				<div style="font-weight:700;font-size:15px">Custos</div>
				<div style="font-size:12px;color:rgba(255,255,255,0.7)">Asistente virtual</div>
			</div>
			<button id="chatClose" style="background:none;border:none;color:#fff;font-size:22px;cursor:pointer;padding:0;line-height:1" aria-label="<?php esc_attr_e( 'Cerrar chat', 'actores-electorales-2026' ); ?>">&times;</button>
		</div>
		<!-- Messages -->
		<div style="flex:1;padding:20px;display:flex;flex-direction:column;gap:12px;overflow-y:auto;background:#f8fafc">
			<div style="align-self:flex-start;background:#e2e8f0;border-radius:12px 12px 12px 4px;padding:12px 16px;max-width:85%;font-size:14px;line-height:1.5;color:#0f172a">
				Hola, soy <strong>Custos</strong>, tu asistente virtual de Actores Electorales. &iquest;En qué puedo ayudarte hoy?
			</div>
			<div style="align-self:flex-start;background:#e2e8f0;border-radius:12px 12px 12px 4px;padding:12px 16px;max-width:85%;font-size:14px;line-height:1.5;color:#0f172a">
				Puedo ayudarte con información sobre postulación de testigos, uso de la plataforma, fechas y mas. Escribe tu pregunta.
			</div>
		</div>
		<!-- Input -->
		<div style="padding:12px 16px;border-top:1px solid #e2e8f0;display:flex;gap:8px;align-items:center;background:#fff">
			<input type="text" placeholder="<?php esc_attr_e( 'Escribe tu mensaje...', 'actores-electorales-2026' ); ?>" style="flex:1;border:1px solid #e2e8f0;border-radius:8px;padding:10px 14px;font-size:14px;outline:none" disabled>
			<button style="width:40px;height:40px;border-radius:10px;background:#1e3a8a;border:none;cursor:pointer;display:grid;place-items:center;flex-shrink:0" aria-label="<?php esc_attr_e( 'Enviar', 'actores-electorales-2026' ); ?>" disabled>
				<svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
			</button>
		</div>
	</div>

	<!-- Chat toggle button (when minimized) -->
	<button id="chatToggle" style="display:none;position:fixed;bottom:24px;right:24px;width:56px;height:56px;border-radius:50%;background:#1e3a8a;border:none;cursor:pointer;box-shadow:0 8px 30px rgba(30,58,138,0.4);z-index:1000;color:#fff;font-size:24px" aria-label="<?php esc_attr_e( 'Abrir chat', 'actores-electorales-2026' ); ?>">
		<svg aria-hidden="true" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
	</button>

	<script>
	(function(){
		var widget = document.getElementById('chatWidget');
		var toggle = document.getElementById('chatToggle');
		var closeBtn = document.getElementById('chatClose');
		if(!widget || !toggle) return;
		if(closeBtn) closeBtn.addEventListener('click', function(){ widget.style.display='none'; toggle.style.display='block'; });
		toggle.addEventListener('click', function(){ widget.style.display='flex'; toggle.style.display='none'; });
	})();
	</script>

<?php
get_footer();
