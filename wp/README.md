# wp/ — equivalentes WordPress de los partials

Cada `partials/NAME.html` tiene su espejo aquí en `NAME.php`. La estructura
HTML es **idéntica** (mismas clases, mismos data-attrs), por lo que el CSS
y el JS del sitio estático funcionan sin modificaciones.

## Instalación en un tema WordPress

1. Copiar el contenido de este directorio a la raíz del tema:
   ```
   wp-content/themes/actores-electorales/
     ├── header.php           # ← desde wp/header.php
     ├── footer.php           # ← desde wp/footer.php (cuando exista)
     ├── inc-nav.php          # ← helper para navegación plana
     ├── functions.php        # (ver snippet abajo)
     └── assets/, css/, js/   # ← copiar tal cual desde la raíz estática
   ```

2. En `functions.php` registrar menús + cargar el helper:
   ```php
   require_once __DIR__ . '/inc-nav.php';

   add_action('after_setup_theme', function () {
       add_theme_support('title-tag');
       add_theme_support('post-thumbnails');
       register_nav_menus([
           'primary' => __('Navegación principal', 'ae'),
           'mobile'  => __('Navegación móvil', 'ae'),
       ]);
   });

   add_action('wp_enqueue_scripts', function () {
       $theme = get_template_directory_uri();
       wp_enqueue_style('ae-fonts', 'https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Archivo:wght@400;500;600;700;800&display=swap');
       wp_enqueue_style('ae-styles', $theme . '/css/styles.css', ['ae-fonts'], '1.0.0');
       wp_enqueue_script('ae-shell', $theme . '/js/shell.js', [], '1.0.0', true);
   });
   ```

3. En el admin de WP, crear los menús "primary" y "mobile" con las páginas
   en el mismo orden del partial. Los slugs deben coincidir con las keys:
   `inicio` (= página de inicio), `quienes-somos`, `plataforma`,
   `entrenamiento`, `regiones`, `canales`, `prensa`, `eventos`.

## Mapa estático ⇄ WordPress

| Estático                                  | WordPress                                                          |
|-------------------------------------------|--------------------------------------------------------------------|
| `<body data-page="X">`                    | `<body data-page="<?php echo ae_get_page_key(); ?>">`              |
| `<a href="index.html">`                   | `<a href="<?php echo home_url('/'); ?>">`                          |
| `<a href="quienes-somos.html">`           | `<a href="<?php echo home_url('/quienes-somos'); ?>">`             |
| `assets/logo.svg`                         | `<?php echo get_template_directory_uri(); ?>/assets/logo.svg`      |
| `<a class="active" aria-current="page">`  | walker añade `.current-menu-item` automáticamente                  |
| Hardcoded link list                       | `wp_nav_menu(['theme_location' => 'primary'])` o `ae_render_flat_nav()` |

## Por qué `ae_render_flat_nav` y no `wp_nav_menu` directo

`wp_nav_menu` por defecto envuelve cada link en `<li>` dentro de un `<ul>`,
lo que rompería el CSS actual (`.hdr-nav { display: flex }` espera `<a>`s
hijos directos). El helper en `inc-nav.php` emite la misma estructura plana
del partial estático: `<nav><a></a><a></a>...</nav>`.

Si prefieres rehacer el CSS para soportar `<ul>/<li>` (y usar el `wp_nav_menu`
estándar), basta con ajustar `.hdr-nav > ul { display: flex; list-style: none; }`
y borrar `inc-nav.php`.

## Estado activo

`js/shell.js` corre `initHeaderActive()` en cada página. Lee
`<body data-page>` y aplica `.active` + `aria-current="page"` al link
con `[data-nav]` coincidente. Esto funciona en estático y en WP — y se
suma a la marca `current-menu-item` que WP aplica automáticamente, así
que el link queda activo de cualquiera de las dos vías.
