/**
 * Vercel Edge Middleware — Token gate para el sitio.
 *
 * Se ejecuta en el Edge ANTES de servir cualquier HTML/estático. Si la cookie
 * `ae_gate` existe y tiene HMAC válido contra GATE_SECRET sobre GATE_TOKEN,
 * deja pasar. Si no, sirve una página de login inline (no requiere archivos
 * adicionales). El POST al formulario va a `/api/gate`, que valida el token,
 * firma, y setea la cookie httpOnly.
 *
 * Env vars requeridas (Vercel dashboard → Settings → Environment Variables):
 *   - GATE_TOKEN    : El token que debe ingresar el usuario (ej. "presi2026")
 *   - GATE_SECRET   : Secreto para firmar la cookie (mínimo 32 chars, aleatorio)
 */

export const config = {
  // Excluye el endpoint de login y el favicon (el browser lo pide siempre).
  // Todo lo demás pasa por el gate.
  matcher: ['/((?!api/gate|_vercel|favicon\\.ico|robots\\.txt).*)'],
};

const COOKIE_NAME = 'ae_gate';

async function hmacHex(data: string, secret: string): Promise<string> {
  const enc = new TextEncoder();
  const key = await crypto.subtle.importKey(
    'raw',
    enc.encode(secret),
    { name: 'HMAC', hash: 'SHA-256' },
    false,
    ['sign']
  );
  const sig = await crypto.subtle.sign('HMAC', key, enc.encode(data));
  const bytes = Array.from(new Uint8Array(sig));
  return bytes.map((b) => b.toString(16).padStart(2, '0')).join('');
}

function timingSafeEqual(a: string, b: string): boolean {
  if (a.length !== b.length) return false;
  let diff = 0;
  for (let i = 0; i < a.length; i++) {
    diff |= a.charCodeAt(i) ^ b.charCodeAt(i);
  }
  return diff === 0;
}

function renderLogin(requestPath: string, error?: string): string {
  const safeRedirect = requestPath.replace(/[^a-zA-Z0-9/_\-.?&=]/g, '');
  const errorHtml = error
    ? `<p class="ae-gate__error" role="alert">${error}</p>`
    : '<p class="ae-gate__error" role="alert"></p>';

  return `<!DOCTYPE html>
<html lang="es-CO">
<head>
<meta charset="UTF-8">
<title>Acceso restringido — Actores Electorales 2026</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<meta name="theme-color" content="#1e3a8a">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&display=swap">
<style>
*{box-sizing:border-box}
html,body{margin:0;padding:0;min-height:100dvh;font-family:'Manrope',system-ui,sans-serif;-webkit-font-smoothing:antialiased;color:#0f172a}
body{background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%);display:grid;place-items:center;padding:20px}
.ae-gate__card{width:100%;max-width:440px;background:#fff;border-radius:20px;padding:40px 32px;box-shadow:0 40px 80px rgba(0,0,0,.35);position:relative;overflow:hidden}
.ae-gate__card::before{content:"";position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,#ffc627 0%,#ffc627 33%,#1e3a8a 33%,#1e3a8a 66%,#e11d48 66%,#e11d48 100%)}
.ae-gate__brand{display:flex;gap:4px;margin-bottom:24px}
.ae-gate__brand span{width:10px;height:10px;border-radius:999px;display:block}
.ae-gate__brand span:nth-child(1){background:#ffc627}
.ae-gate__brand span:nth-child(2){background:#1e3a8a}
.ae-gate__brand span:nth-child(3){background:#e11d48}
.ae-gate__eyebrow{display:inline-block;font-size:12px;letter-spacing:.16em;text-transform:uppercase;font-weight:700;color:#1e3a8a;margin-bottom:10px}
.ae-gate__title{font-size:26px;font-weight:800;letter-spacing:-0.02em;margin:0 0 10px;line-height:1.15;color:#0f172a}
.ae-gate__lead{font-size:14px;line-height:1.55;color:#475569;margin:0 0 24px}
.ae-gate__form{display:flex;flex-direction:column;gap:8px}
.ae-gate__label{font-size:12px;font-weight:700;color:#334155;letter-spacing:.04em}
.ae-gate__input{width:100%;padding:14px 16px;border:2px solid #e2e8f0;border-radius:10px;font-size:16px;font-family:inherit;min-height:48px;background:#f8fafc;color:#0f172a;transition:border-color 180ms,background 180ms;box-sizing:border-box;outline:none}
.ae-gate__input:focus{border-color:#1e3a8a;background:#fff;box-shadow:0 0 0 3px rgba(30,58,138,.15)}
.ae-gate__error{font-size:13px;color:#e11d48;min-height:18px;margin:0;font-weight:600}
.ae-gate__btn{margin-top:8px;padding:14px 24px;background:#e11d48;color:#fff;border:0;border-radius:999px;font-size:15px;font-weight:700;font-family:inherit;cursor:pointer;min-height:48px;transition:background 180ms,transform 180ms;touch-action:manipulation;-webkit-tap-highlight-color:transparent}
.ae-gate__btn:hover{background:#be123c}
.ae-gate__btn:active{transform:scale(.98)}
.ae-gate__btn:focus-visible{outline:3px solid #fff;outline-offset:2px}
.ae-gate__foot{margin-top:22px;padding-top:18px;border-top:1px solid #e2e8f0;font-size:12px;color:#64748b;text-align:center;line-height:1.5}
</style>
</head>
<body>
<main class="ae-gate__card" role="dialog" aria-labelledby="aeGateTitle" aria-modal="true">
  <div class="ae-gate__brand" aria-hidden="true"><span></span><span></span><span></span></div>
  <span class="ae-gate__eyebrow">Actores Electorales 2026</span>
  <h1 id="aeGateTitle" class="ae-gate__title">Acceso restringido</h1>
  <p class="ae-gate__lead">Ingresa el token de acceso para visualizar la plataforma.</p>
  <form class="ae-gate__form" method="POST" action="/api/gate" autocomplete="off">
    <input type="hidden" name="redirect" value="${safeRedirect}">
    <label class="ae-gate__label" for="aeGateInput">Token de acceso</label>
    <input class="ae-gate__input" id="aeGateInput" name="token" type="password" autocomplete="off" autocapitalize="off" autocorrect="off" spellcheck="false" required autofocus>
    ${errorHtml}
    <button class="ae-gate__btn" type="submit">Ingresar</button>
  </form>
  <div class="ae-gate__foot">Preview de desarrollo · Consejo Nacional Electoral</div>
</main>
</body>
</html>`;
}

export default async function middleware(request: Request): Promise<Response | undefined> {
  const token = (process.env.GATE_TOKEN || '').trim();
  const secret = (process.env.GATE_SECRET || '').trim();

  if (!token || !secret) {
    return new Response(
      'Missing GATE_TOKEN or GATE_SECRET env vars. Configure them in Vercel dashboard.',
      { status: 500, headers: { 'content-type': 'text/plain; charset=utf-8' } }
    );
  }

  const url = new URL(request.url);

  // ?logout limpia cookie y muestra login
  if (url.searchParams.has('logout')) {
    return new Response(renderLogin('/'), {
      status: 200,
      headers: {
        'content-type': 'text/html; charset=utf-8',
        'cache-control': 'no-store',
        'set-cookie': `${COOKIE_NAME}=; Path=/; HttpOnly; Secure; SameSite=Lax; Max-Age=0`,
      },
    });
  }

  const cookieHeader = request.headers.get('cookie') || '';
  const match = new RegExp(`${COOKIE_NAME}=([^;]+)`).exec(cookieHeader);
  const cookieVal = match ? decodeURIComponent(match[1]) : '';

  if (cookieVal) {
    const expected = await hmacHex(token, secret);
    if (timingSafeEqual(cookieVal, expected)) {
      return; // Cookie válida → pasar al siguiente handler (archivo estático)
    }
  }

  // Sin cookie válida → servir login
  return new Response(renderLogin(url.pathname + url.search), {
    status: 401,
    headers: {
      'content-type': 'text/html; charset=utf-8',
      'cache-control': 'no-store',
      'x-robots-tag': 'noindex, nofollow',
    },
  });
}
