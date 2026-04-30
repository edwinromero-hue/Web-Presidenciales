<?php
/**
 * AE Header — versión WordPress
 * =============================================================
 * Espejo de partials/header.html. Mismo markup, mismas clases.
 * Lo único distinto es de dónde sale la data:
 *
 *   Estático                       WordPress
 *   ----------------------------   ------------------------------------
 *   <body data-page="key">         <body <?php body_class(); ?>
 *                                        data-page="<?php echo $ae_page; ?>">
 *   href="index.html"              href="<?php echo home_url('/'); ?>"
 *   href="quienes-somos.html"      href="<?php echo home_url('/quienes-somos'); ?>"
 *   assets/logo.svg                <?php echo get_template_directory_uri(); ?>/assets/logo.svg
 *   <a class="active" ...>         walker añade .current-menu-item
 *
 * Para activar este header en functions.php:
 *
 *   add_action('after_setup_theme', function () {
 *       register_nav_menus([
 *           'primary' => __('Navegación principal', 'ae'),
 *           'mobile'  => __('Navegación móvil', 'ae'),
 *       ]);
 *   });
 *
 * Y en cualquier *.php usar `<?php get_header(); ?>`.
 *
 * @package ActoresElectorales
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Resuelve la "key" de página para el data-page.
 * Mismo mapa que scripts/sync_partials.py para mantener paridad.
 */
function ae_get_page_key(): string {
    if (is_front_page() || is_home()) {
        return 'inicio';
    }
    $slug = get_post_field('post_name', get_queried_object_id());
    if (!$slug) {
        return 'inicio';
    }
    // Páginas internas que viven dentro del bloque "Quiénes somos"
    $internal_to_qs = ['aliados', 'metricas', 'compromisos', 'propositos'];
    if (in_array($slug, $internal_to_qs, true)) {
        return 'quienes-somos';
    }
    return $slug;
}

$ae_page = ae_get_page_key();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#1e3a8a">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> data-page="<?php echo esc_attr($ae_page); ?>">
<?php wp_body_open(); ?>

<a href="#mainContent" class="skip-link"><?php esc_html_e('Saltar al contenido', 'ae'); ?></a>

<header class="hdr-wrap" role="banner">
    <div class="hdr-inner">
        <a class="hdr-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php esc_attr_e('Actores Electorales 2026 — Inicio', 'ae'); ?>">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/logo.svg'); ?>" alt="<?php esc_attr_e('Actores Electorales 2026', 'ae'); ?>" class="hdr-logo-img">
        </a>
        <?php
        // Walker plano: emite <a> directos sin <ul>/<li>, igual que el HTML estático.
        // Si prefieres no usar walker custom, registra un menú "primary" desde el admin
        // y reemplaza estos arrays por wp_nav_menu(['theme_location' => 'primary']).
        ae_render_flat_nav('primary', 'hdr-nav', __('Navegación principal', 'ae'));
        ?>
        <button type="button" class="hdr-mobile-toggle" aria-label="<?php esc_attr_e('Abrir menú', 'ae'); ?>" aria-expanded="false" aria-controls="aeMobileNav">
            <span class="hdr-burger" aria-hidden="true"><span></span><span></span><span></span></span>
        </button>
    </div>
    <div class="flag-rule" aria-hidden="true">
        <div style="background:#ffc627"></div><div style="background:#1e3a8a"></div><div style="background:#e11d48"></div>
    </div>
    <?php
    ae_render_flat_nav('mobile', 'hdr-mobile-nav', __('Navegación móvil', 'ae'), [
        'id'     => 'aeMobileNav',
        'aria_hidden' => 'true',
        'before' => '<button type="button" class="mnav-close" aria-label="' . esc_attr__('Cerrar menú', 'ae') . '">✕</button>',
    ]);
    ?>
</header>
