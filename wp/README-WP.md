# Actores Electorales 2026 — Tema WordPress

Tema institucional para las elecciones presidenciales de Colombia 2026.
Generado a partir del proyecto estático de `../` (HTML + CSS + JS vanilla con GSAP).

- **Textdomain**: `actores-electorales-2026`
- **Versión**: 1.0.0
- **WordPress**: 6.0+
- **PHP**: 7.4+
- **Licencia**: Propietaria (CNE Colombia)

---

## 1. Instalación

### 1.1 Copiar el tema a WordPress

El tema está pensado para vivir en `wp-content/themes/actores-electorales-2026/`.

```bash
# desde la raíz del proyecto estático (carpeta "presidenciales para wordpress")
cp -R wp/ /ruta/a/tu/wordpress/wp-content/themes/actores-electorales-2026/
```

En Windows (PowerShell):

```powershell
Copy-Item -Path .\wp\* -Destination "C:\ruta\wordpress\wp-content\themes\actores-electorales-2026\" -Recurse
```

> **Importante**: se usa copia física (no symlinks) para mantener portabilidad
> Windows/Linux y evitar problemas con hostings compartidos.

### 1.2 Activar

1. `wp-admin/` → **Apariencia → Temas**.
2. Buscar "Actores Electorales 2026" y **Activar**.
3. (Opcional) `wp cli`: `wp theme activate actores-electorales-2026`.

---

## 2. Configuración obligatoria post-activación

### 2.1 Crear las 8 páginas

En **Páginas → Añadir nueva**, crear con el slug exacto:

| Título                    | Slug              | Plantilla (Atributos de página)        |
|---------------------------|-------------------|----------------------------------------|
| Inicio                    | `inicio` (o raíz) | — (usa `front-page.php` automático)    |
| Quiénes somos             | `quienes-somos`   | Quiénes somos                          |
| Plataforma                | `plataforma`      | Plataforma                             |
| Entrenamiento             | `entrenamiento`   | Entrenamiento                          |
| Regiones                  | `regiones`        | Regiones                               |
| Canales de atención       | `canales`         | Canales de atención                    |
| Sala de prensa            | `prensa`          | Sala de prensa                         |
| Eventos                   | `eventos`         | Eventos                                |

Luego **Ajustes → Lectura → Tu página de inicio muestra: una página estática**,
asignar "Inicio" como *Página de inicio*. Esto hace que `/` use `front-page.php`.

### 2.2 Crear los 5 menús

En **Apariencia → Menús**, crear estos 5 menús y asignarlos a sus ubicaciones.
Si no se crean, el tema usa fallbacks estáticos con los 8 enlaces canónicos —
así la home funciona desde el minuto cero.

#### `header-main` — Menú principal (desktop)
```
Inicio                  → /
Quiénes somos           → /quienes-somos/
Plataforma              → /plataforma/
Entrenamiento           → /entrenamiento/
Regiones                → /regiones/
Canales de atención     → /canales/
Sala de prensa          → /prensa/
Eventos                 → /eventos/
```

#### `mobile-main` — Menú principal móvil (drawer)
Idéntico a `header-main`.

#### `footer-plataforma` — Pie · columna Plataforma
```
Inicio, Quiénes somos, Plataforma, Entrenamiento
```

#### `footer-informacion` — Pie · columna Información
```
Regiones, Canales de atención, Sala de prensa, Eventos
```

#### `footer-contacto` — Pie · columna Contacto
Enlaces manuales (no son páginas):
- Email → `mailto:contacto.mesa@actoreselectorales.com`
- Teléfono → `tel:+576017702692`
- WhatsApp → `https://wa.me/573009110489` (target `_blank`, rel `noopener noreferrer`)

### 2.3 Logo

**Apariencia → Personalizar → Identidad del sitio → Seleccionar logo** →
subir `assets/logo.svg` a la Media Library y seleccionarlo.

Si no se configura, el tema cae al SVG físico en `assets/logo.svg`.

---

## 3. Media Library — imágenes a subir

Se pueden dejar referenciadas desde `assets/img/` (el tema ya las enlaza por
`AE_THEME_URI . '/assets/img/X.ext'`), pero se recomienda subirlas a la Media
Library si se quiere editarlas desde el admin o asociarlas a posts/CPTs.

Archivos clave usados por `front-page.php`:

| Archivo              | Uso                              |
|----------------------|----------------------------------|
| `5.jpeg`             | Hero LCP (preload)               |
| `1.jpeg`, `9.jpeg`, `11.jpeg` | Pin-photo (3 estados)   |
| `7.jpeg`, `12.jpeg`, `14.jpeg`, `10.jpeg` | Horizontal section |
| `4.jpeg`, `16.jpg`, `22.jpg`  | Grid de noticias home   |
| `10.jpeg`            | Teaser de entrenamiento          |

Más imágenes (`1–14.jpeg`, `16–23.jpg`) están disponibles para las páginas
internas que se porten en sesión 2.

---

## 4. CPTs sugeridos (no generados aún — PHP se añade en sesión 2)

Los contenidos dinámicos de `prensa.html`, `eventos.html`, `entrenamiento.html`
y `regiones.html` se modelarán como Custom Post Types. Registro propuesto:

### 4.1 `ae_noticia` — Noticias / Sala de prensa

```
Nombre      : Noticias
Slug        : noticias
Supports    : title, editor, thumbnail, excerpt, author, revisions
Taxonomías  : ae_noticia_categoria (categoría), post_tag (reutilizable)
Archive     : true (/noticias/)
```

**Campos ACF sugeridos** (grupo "Noticia — meta"):
- `fecha_publicacion` (Date) — fallback al `post_date` si vacío.
- `fuente` (Text) — ej. "SEMANA", "El Tiempo", "CNE_COLOMBIA".
- `destacada` (True/False) — aparece en home.
- `url_externa` (URL, opcional) — si la noticia apunta a un medio externo.

### 4.2 `ae_evento` — Eventos / Calendario

```
Nombre      : Eventos
Slug        : eventos
Supports    : title, editor, thumbnail, excerpt
Taxonomías  : ae_evento_tipo (taller, simulacro, capacitación, rueda de prensa)
Archive     : true (/agenda/)
```

**Campos ACF sugeridos**:
- `fecha_inicio` (Date Time) — requerido.
- `fecha_fin` (Date Time) — opcional.
- `ubicacion` (Text).
- `region` (Taxonomy → `ae_region`).
- `cupo` (Number).
- `registro_url` (URL).

### 4.3 `ae_modulo` — Módulos de entrenamiento

```
Nombre      : Módulos
Slug        : modulos
Supports    : title, editor, thumbnail, page-attributes (para menu_order)
Archive     : false
```

**Campos ACF sugeridos**:
- `duracion_min` (Number) — minutos estimados.
- `certificable` (True/False).
- `prerequisito` (Relationship → ae_modulo).
- `nivel` (Select: básico / intermedio / avanzado).

### 4.4 `ae_region` — Regiones (taxonomía además de CPT)

Se puede modelar como **taxonomy** pura (más ligera) o como CPT si se quiere
página propia por región. Recomendado: **taxonomy `ae_region`** con terms:
Caribe, Andina, Pacífica, Orinoquía, Amazonía, Insular.

Si se quiere página independiente por región: CPT `ae_region` con
`has_archive = true`, supports `title, editor, thumbnail`, y meta ACF:
`capital`, `municipios_count`, `testigos_count`, `contacto_email`, `contacto_tel`.

---

## 5. ACF (si se usa)

Si el equipo usa **Advanced Custom Fields** (PRO recomendado), crear un
archivo `inc/acf-fields.php` exportando los groups desde ACF → Tools →
Export Field Groups como PHP, e incluirlo desde `functions.php`.

Grupos mínimos propuestos:

1. **Home — Countdown config**
   - `countdown_fecha` (Date Time, default 31/05/2026 08:00)
   - Permite cambiar la fecha desde admin sin tocar JS.

2. **Home — Quotes rotator** (repeater)
   - `texto` (Textarea)
   - `fuente` (Text) — ej. "EL TIEMPO"

3. **Global — Contacto**
   - `email_contacto`
   - `telefono_contacto`
   - `whatsapp_numero`
   - Usar en `template-parts/footer-contact.php` y en `header.php`.

4. **Página — Page Hero** (aplicar a todas las páginas)
   - `eyebrow` (Text)
   - `titulo` (Text) — si vacío, usa `the_title()`.
   - `subtitulo` (Textarea)

---

## 6. Estructura del tema

```
wp/
├── style.css                    ← cabecera oficial WP (metadatos)
├── functions.php                ← bootstrap (constantes + requires)
├── header.php                   ← <doctype> hasta <main>
├── footer.php                   ← desde </main> hasta </html>
├── front-page.php               ← home narrativa scrolly (1:1 con index.html)
├── index.php                    ← fallback para loops
├── page.php                     ← página genérica (fallback)
├── page-quienes-somos.php       ← Template Name: Quiénes somos
├── page-plataforma.php          ← Template Name: Plataforma
├── page-regiones.php            ← Template Name: Regiones
├── page-canales.php             ← Template Name: Canales de atención
├── page-entrenamiento.php       ← Template Name: Entrenamiento
├── page-eventos.php             ← Template Name: Eventos
├── page-prensa.php              ← Template Name: Sala de prensa
├── template-parts/
│   ├── nav-mobile.php           ← drawer off-canvas
│   └── footer-contact.php       ← columna contacto del footer
├── assets/
│   ├── css/styles.css           ← CSS del proyecto estático (copia física)
│   ├── js/
│   │   ├── shell.js             ← drawer, scroll UI, overlay, back-to-top
│   │   ├── scrolly.js           ← GSAP scenes, word-reveal, countup, FAQ
│   │   └── inicio.js            ← countdown, pin-photo, quotes (solo home)
│   ├── img/                     ← 22 imágenes del proyecto estático
│   ├── logo.svg                 ← logo principal
│   └── logo_mono.svg            ← logo monocromo (para fondos oscuros)
└── inc/
    ├── theme-setup.php          ← supports, menús, text domain
    ├── enqueue.php              ← fonts + styles + scripts + preloads
    └── nav-walker.php           ← walker plano para <a> + fallbacks de menú
```

---

## 7. Decisiones técnicas tomadas

| Tema | Decisión |
|------|----------|
| Textdomain | `actores-electorales-2026` (usado en TODOS los `__()`, `esc_html__()`, `_e()`). |
| Menús WP | 5 ubicaciones: `header-main`, `mobile-main`, `footer-plataforma`, `footer-informacion`, `footer-contacto`. |
| Walker de menú | `AE_Flat_Link_Walker` — emite `<a>` planos, sin `<ul>`/`<li>`, para encajar con el CSS del tema que espera hermanos `<a>`. |
| Fallbacks | Si un menú no está creado, se renderizan los 8 enlaces canónicos vía `ae_header_nav_fallback()` / `ae_mobile_nav_fallback()`. |
| Enqueue orden | Google Fonts → styles.css → GSAP → ScrollTrigger → shell.js → scrolly.js → inicio.js (solo home). Preserva el orden del proyecto estático. |
| GSAP | Desde CDN (CDNJS, 3.12.7). Si se quiere self-host, bajar `gsap.min.js` + `ScrollTrigger.min.js` a `assets/js/vendor/` y editar `inc/enqueue.php`. |
| Preload hero | Solo en `is_front_page()`, inyectado en `wp_head` prioridad 2. |
| Meta theme-color | `#1e3a8a` (azul institucional), inyectado en `wp_head` prioridad 1. |
| `wp_body_open()` | Llamado justo después de `<body>` en `header.php` (compat plugins). |
| Copia de assets | Física (no symlink) — portabilidad Windows/Linux y compat con hostings. |
| CPTs | **NO generados aún** — el PHP se añade en sesión 2 cuando el dev WP decida si ACF o Meta nativo. |

---

## 8. Escaping y seguridad

Todo el markup PHP sigue las reglas WP:

- URLs: `esc_url()`
- Atributos HTML: `esc_attr()`, `esc_attr__()`, `esc_attr_e()`
- Contenido textual: `esc_html()`, `esc_html__()`, `esc_html_e()`
- Traducciones: siempre con textdomain `actores-electorales-2026`
- `wp_kses_post()` / `the_content()` para salida de editor (ya sanitiza).

---

## 9. Flujo de desarrollo recomendado

```bash
# 1) clonar / copiar proyecto
cp -R "presidenciales para wordpress/wp" /srv/wp/wp-content/themes/actores-electorales-2026

# 2) local dev (Local, LocalWP, DDEV, Lando, o XAMPP)
#    arrancar WP en localhost, crear DB, instalar

# 3) activar tema
wp theme activate actores-electorales-2026

# 4) poblar
#    - crear 8 páginas (sección 2.1)
#    - asignar plantillas
#    - crear 5 menús (sección 2.2)
#    - establecer "Inicio" como front page

# 5) ver en http://localhost (o tu dominio local)
```

### Hot-reload durante desarrollo

Para edits rápidos, recomendamos **BrowserSync** o el hot-reload de
LocalWP "Live Link". El tema no usa build step (no webpack, no sass);
editar `assets/css/styles.css` o `assets/js/*.js` se refleja tras un
`Ctrl+F5`.

---

## 10. Qué queda pendiente (sesión 2+)

**Fase F — Portar 7 page-templates**: los stubs actuales tienen solo el
Page Hero institucional. Falta portar 1:1 todas las secciones desde:
- `quienes-somos.html` → `page-quienes-somos.php`
- `plataforma.html` → `page-plataforma.php`
- `entrenamiento.html` → `page-entrenamiento.php` (incluye FAQ + 6 módulos)
- `regiones.html` → `page-regiones.php` (mapa interactivo + tabs)
- `canales.html` → `page-canales.php` (grid + chat widget + FAQ)
- `prensa.html` → `page-prensa.php` (grid + filtros tabs)
- `eventos.html` → `page-eventos.php` (calendario 30 días)

**Fase A — Prefijado `ae-*` de clases**: diferida. La paleta de clases
utilitarias (ya parcialmente prefijada en la sesión de limpieza 2) debería
completarse para evitar colisiones con otros plugins/temas. Es invasivo;
mejor hacerlo en rama aparte.

**CPTs + ACF groups**: registrar `ae_noticia`, `ae_evento`, `ae_modulo`
(y taxonomía `ae_region`) en `inc/cpts.php`. Exportar grupos ACF a PHP.

**Traducciones**: generar `/languages/actores-electorales-2026.pot` con
WP-CLI (`wp i18n make-pot . languages/actores-electorales-2026.pot`).

**Imágenes a Media Library**: decisión del equipo. Si se quieren dinámicas,
subir las 22 imágenes a Media y reemplazar `AE_THEME_URI . '/assets/img/X'`
por `the_post_thumbnail()` o attachment URLs en los lugares que corresponda.

---

## 11. Soporte

Documentación viva: este archivo + `.claude/wp-progress.md` (en la raíz del
proyecto) con el historial de cada sesión de migración.

Dudas: pegar el error o contexto en el chat del equipo; el tema está
estructurado para ser leído de arriba abajo en 15 minutos.
