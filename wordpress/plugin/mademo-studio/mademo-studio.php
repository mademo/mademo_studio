<?php
/**
 * Plugin Name: Mademo Studio
 * Plugin URI: https://mademo.studio
 * Description: Plugin principal pour les custom post types, taxonomies, ACF, menu d'administration et API REST de Mademo Studio.
 * Version: 2.1.2
 * Author: Mademo Studio
 * Text Domain: mademo-studio
 * Domain Path: /languages
 * Requires at least: 6.4
 * Requires PHP: 8.1
 */

defined('ABSPATH') || exit;

if (!defined('MADEMO_VERSION')) {
    define('MADEMO_VERSION', '2.1.2');
}

if (!defined('MADEMO_PLUGIN_DIR')) {
    define('MADEMO_PLUGIN_DIR', plugin_dir_path(__FILE__));
}

if (!defined('MADEMO_PLUGIN_URL')) {
    define('MADEMO_PLUGIN_URL', plugin_dir_url(__FILE__));
}

if (!defined('MADEMO_PER_PAGE_MAX')) {
    define('MADEMO_PER_PAGE_MAX', 200);
}

if (!defined('MADEMO_STUDIO_BOOTSTRAPPED')) {
    define('MADEMO_STUDIO_BOOTSTRAPPED', true);
    require_once __DIR__ . '/acf-json/mademo-studio.php';
}
