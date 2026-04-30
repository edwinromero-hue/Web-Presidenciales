<?php
/**
 * AE Flat Nav helper — emite navegación HTML5 plana (sin <ul>/<li>)
 * para coincidir 1:1 con el partials/header.html estático.
 *
 * Uso: ae_render_flat_nav('primary', 'hdr-nav', 'Navegación principal');
 *
 * @package ActoresElectorales
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('ae_render_flat_nav')) {
    /**
     * @param string $location    theme_location registrada con register_nav_menus().
     * @param string $class       Clase del <nav> contenedor.
     * @param string $aria_label  aria-label del <nav>.
     * @param array  $opts        Opcionales:
     *   - id         (string)   id del <nav>.
     *   - aria_hidden(string)   "true" si arranca oculto (mobile).
     *   - before     (string)   HTML inyectado antes del primer link.
     */
    function ae_render_flat_nav(string $location, string $class, string $aria_label, array $opts = []): void {
        $locations = get_nav_menu_locations();
        if (empty($locations[$location])) {
            return;
        }
        $menu_obj = wp_get_nav_menu_object($locations[$location]);
        if (!$menu_obj) {
            return;
        }
        $items = wp_get_nav_menu_items($menu_obj->term_id);
        if (empty($items)) {
            return;
        }

        $current_id = get_queried_object_id();
        $current_url = trailingslashit(get_permalink($current_id));

        $attrs = sprintf(
            'class="%s" aria-label="%s"',
            esc_attr($class),
            esc_attr($aria_label)
        );
        if (!empty($opts['id'])) {
            $attrs .= ' id="' . esc_attr($opts['id']) . '"';
        }
        if (!empty($opts['aria_hidden'])) {
            $attrs .= ' aria-hidden="' . esc_attr($opts['aria_hidden']) . '"';
        }

        echo '<nav ' . $attrs . '>';

        if (!empty($opts['before'])) {
            echo $opts['before']; // Ya viene escapado por quien lo pasa.
        }

        foreach ($items as $item) {
            $url = trailingslashit($item->url);
            $is_current = ($url === $current_url);

            // data-nav usa el slug del post asociado al item de menú,
            // así shell.js puede activar el link aunque WP también lo marque.
            $data_nav = '';
            if ($item->object === 'page') {
                $page = get_post($item->object_id);
                if ($page) {
                    $data_nav = ' data-nav="' . esc_attr($page->post_name) . '"';
                }
            }

            $class_attr = '';
            if ($is_current) {
                $class_attr = ' class="active" aria-current="page"';
            }

            printf(
                '<a href="%s"%s%s>%s</a>',
                esc_url($item->url),
                $data_nav,
                $class_attr,
                esc_html($item->title)
            );
        }

        echo '</nav>';
    }
}
