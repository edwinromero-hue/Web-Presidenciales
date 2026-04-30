# Deploy en Vercel — Gate de acceso con token

Este proyecto despliega como **sitio estático** en Vercel con un **Edge Middleware** que protege todo el contenido detrás de un token. Ningún HTML se sirve a un usuario sin cookie válida.

## Cómo funciona (resumen técnico)

```
┌─────────────┐   GET /       ┌──────────────────┐
│   Cliente   │ ────────────► │  Edge Middleware │
└─────────────┘               │  middleware.ts   │
       ▲                      └────────┬─────────┘
       │                               │
       │   ┌───────────────────────────┴───────────────────┐
       │   │   ¿Cookie ae_gate con HMAC válido?            │
       │   │     └─ Sí  → next() (sirve index.html)        │
       │   │     └─ No  → responde HTML del login (401)    │
       │   └───────────────────────────────────────────────┘
       │
       │   POST /api/gate   (form: token=XXX&redirect=/...)
       │                      │
       │                      ▼
       │             ┌──────────────────┐
       │             │  Edge Function   │
       │             │   api/gate.ts    │
       │             └────────┬─────────┘
       │                      │
       │                      ▼
       │        ¿token == GATE_TOKEN? (comparación time-safe)
       │              │                      │
       │              ▼                      ▼
       │        Set-Cookie ae_gate=HMAC   401 + login con error
       │        HttpOnly Secure SameSite
       │        Max-Age 7 días
       │        303 Redirect to ?redirect
       │
       └──────────────── GET /ruta con cookie válida
```

**Seguridad**:

- El token `GATE_TOKEN` **nunca** está en el código cliente — vive sólo en variables de entorno de Vercel, accesibles únicamente desde el Edge Runtime.
- La cookie es `HttpOnly` → JavaScript del cliente no puede leerla ni modificarla.
- La cookie es `Secure` → sólo viaja sobre HTTPS.
- El valor de la cookie es `HMAC-SHA256(GATE_TOKEN, GATE_SECRET)`. Un atacante sin `GATE_SECRET` **no puede forjar** una cookie válida.
- Comparación time-safe en el login → resistente a ataques de timing.
- `SameSite=Lax` → mitiga CSRF en POSTs cross-site.
- Headers `X-Frame-Options: DENY`, `noindex nofollow`, `X-Content-Type-Options: nosniff` configurados.

## Paso 1 — Prepara las variables de entorno

Genera un secreto aleatorio fuerte (≥ 32 bytes):

```bash
openssl rand -hex 32
# o
node -e "console.log(require('crypto').randomBytes(32).toString('hex'))"
```

Esto te devuelve algo como `d4a8f2e1...` (64 hex chars). Cópialo.

## Paso 2 — Conecta el proyecto a Vercel

```bash
cd "/Users/usuario1/Desktop/presidenciales para wordpress"
npx vercel
```

Seguí el prompt:
- Set up and deploy? **Yes**
- Scope: el tuyo o tu team
- Link to existing project? **No**
- Project name: `actores-electorales-2026` (o el que prefieras)
- Directory: **./** (default)
- Override settings? **No**

## Paso 3 — Configura las variables de entorno en Vercel

Una vez creado el proyecto, configura las env vars. Dos opciones:

### Opción A — Dashboard (UI)
1. Abre https://vercel.com/dashboard
2. Proyecto → Settings → Environment Variables
3. Agrega:
   - `GATE_TOKEN` = `presi2026` (o el token que decidas)
   - `GATE_SECRET` = el hex aleatorio de 64 chars del paso 1
4. Marca los 3 environments: **Production**, **Preview**, **Development**
5. Guarda

### Opción B — CLI
```bash
vercel env add GATE_TOKEN
# pega el valor, elige Production + Preview + Development

vercel env add GATE_SECRET
# pega el hex aleatorio
```

## Paso 4 — Deploy a producción

```bash
vercel --prod
```

Al abrir la URL de producción verás el login. Ingresa el `GATE_TOKEN` y ya.

## Testing local del middleware

Vercel CLI simula el Edge Runtime en local:

```bash
# Crea .env local (NO lo commitees)
cp .env.example .env
# edita .env con tus valores

# Corre dev server con middleware activo
vercel dev
```

Abre http://localhost:3000 — verás el gate.

## Cómo rotar el token

1. Cambia `GATE_TOKEN` en Vercel (Settings → Environment Variables).
2. Cambia `GATE_SECRET` también (esto **invalida todas las cookies existentes** — todos los usuarios tendrán que volver a ingresar el token).
3. Redeploy: `vercel --prod`. Vercel re-invoca el middleware con las nuevas env vars.

## Cómo hacer logout

- Añadir `?logout` a cualquier URL → borra la cookie.
  Ej: `https://tu-sitio.vercel.app/?logout`

## Rutas que NO requieren auth

Sólo `/api/gate` (el endpoint del formulario) y los internos `/_vercel/*`. Todo lo demás pasa por el middleware.

Ver el `matcher` en [middleware.ts](middleware.ts).

## Migrar a WordPress

Cuando el proyecto pase a WordPress (carpeta `wp/`), **el middleware de Vercel ya no aplica** — WP tiene su propio sistema. Opciones:

1. Plugin gratuito **Password Protected** (wordpress.org/plugins/password-protected) — replica esta UX en WP.
2. HTTP Basic Auth en el servidor (nginx/Apache).
3. Página privada con contraseña nativa de WP (`post_password`).

El tema WP de esta carpeta (`wp/`) no incluye ningún gate — se asume que se gestiona a nivel servidor o plugin.

## Archivos relevantes

| Archivo | Propósito |
|---|---|
| [`middleware.ts`](middleware.ts) | Intercepta todos los requests, valida cookie, sirve login si falta |
| [`api/gate.ts`](api/gate.ts) | POST para validar token y setear cookie firmada |
| [`vercel.json`](vercel.json) | Headers de seguridad + caché de assets |
| [`.env.example`](.env.example) | Plantilla de variables de entorno |

## Troubleshooting

### "Missing GATE_TOKEN or GATE_SECRET env vars"
Configura las env vars en Vercel (paso 3) y redeploy.

### El login aparece pero el POST no funciona
- Verifica que el archivo `api/gate.ts` existe y no tiene errores de TS.
- Revisa Vercel logs: Dashboard → Deployments → último → Functions Logs.

### El gate no aparece (el sitio se ve sin login)
- Verifica que `middleware.ts` está en la raíz del proyecto.
- Revisa que el matcher no excluya la ruta que estás visitando.
- En local con `python -m http.server` **el middleware NO corre** — ese servidor sirve archivos planos sin Edge Runtime. Usa `vercel dev` para testing.

### Quiero proteger también el `/api/gate`
No — eso crearía un loop (nadie podría loguearse nunca). `/api/gate` debe ser público para recibir el POST del formulario.
