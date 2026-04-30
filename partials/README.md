# Partials — single-source-of-truth components

Cada archivo `*.html` en este directorio es un componente HTML reutilizable
que se propaga a todas las páginas del sitio mediante un script.

## Cómo funciona

1. Cada `partials/NAME.html` contiene **solo el markup** (sin docs ni
   marcadores anidados — el regex del sync no tolera markers literales
   dentro del contenido).
2. Cada página del sitio que use el partial declara el espacio destino con
   marcadores `<!-- @partial:NAME -->` y `<!-- @end-partial:NAME -->`.
3. Al ejecutar `python3 scripts/sync_partials.py` desde la raíz, el
   contenido de `partials/NAME.html` reemplaza lo que haya entre los
   marcadores en cada `*.html` del proyecto.

## Estado activo (página actual)

El partial NO contiene la marca de página activa. En su lugar:

1. Cada página marca su body con la key correspondiente:
   ```html
   <body data-page="quienes-somos">
   ```
2. El partial expone `data-nav="X"` en cada link de navegación.
3. `js/shell.js` ejecuta `initHeaderActive()` que añade `.active` y
   `aria-current="page"` al link cuyo `data-nav` coincide con `data-page`.

## Keys de página

Las keys soportadas son las siguientes:

| Archivo                | data-page          |
|------------------------|--------------------|
| `index.html`           | `inicio`           |
| `quienes-somos.html`   | `quienes-somos`    |
| `plataforma.html`      | `plataforma`       |
| `entrenamiento.html`   | `entrenamiento`    |
| `regiones.html`        | `regiones`         |
| `canales.html`         | `canales`          |
| `prensa.html`          | `prensa`           |
| `eventos.html`         | `eventos`          |
| `aliados.html`         | `quienes-somos`    |
| `metricas.html`        | `quienes-somos`    |
| `compromisos.html`     | `quienes-somos`    |
| `propositos.html`      | `quienes-somos`    |

(las páginas internas usan `quienes-somos` porque viven dentro de ese bloque
narrativo del diagrama radial.)

## Workflow típico

```bash
# 1. Editar el partial
$EDITOR partials/header.html

# 2. Propagar a todas las páginas
python3 scripts/sync_partials.py

# 3. Verificar que todo esté en sync (CI / pre-commit)
python3 scripts/sync_partials.py --check
```

## Migración a WordPress

Cada `partials/NAME.html` tiene su espejo en `wp/NAME.php`. La estructura
HTML es idéntica; solo cambian:

| Estático                              | WordPress                                   |
|---------------------------------------|---------------------------------------------|
| `<a href="index.html">`               | `<a href="<?php echo home_url('/'); ?>">`   |
| `assets/logo.svg`                     | `<?php echo get_template_directory_uri(); ?>/assets/logo.svg` |
| `class="active"` manual               | walker con `current-menu-item`              |
| Links hardcodeados                    | `wp_nav_menu(['theme_location' => 'primary'])` |

## Crear un nuevo partial (p. ej. footer)

1. Crear `partials/footer.html` con el markup canónico (solo markup).
2. En cada `*.html` que lo use, añadir los marcadores donde corresponda:
   ```html
   <!-- @partial:footer -->
   <!-- @end-partial:footer -->
   ```
3. Correr `python3 scripts/sync_partials.py`.
4. (Opcional) Crear `wp/footer.php` con el equivalente WP.
