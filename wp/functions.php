<?php
/**
 * Actores Electorales 2026 — Bootstrap del tema
 *
 * Carga de constantes, setup (menús, supports) y enqueue de assets.
 *
 * @package ActoresElectorales2026
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AE_THEME_VERSION', '1.0.0' );
define( 'AE_THEME_PATH', get_template_directory() );
define( 'AE_THEME_URI', get_template_directory_uri() );

require_once AE_THEME_PATH . '/inc/theme-setup.php';
require_once AE_THEME_PATH . '/inc/enqueue.php';
require_once AE_THEME_PATH . '/inc/nav-walker.php';
