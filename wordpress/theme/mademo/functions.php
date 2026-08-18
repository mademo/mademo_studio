<?php
/**
 * Thème Mademo Studio — functions.php
 *
 * Le thème conserve la SPA existante pour les routes qui n'ont pas encore été
 * migrées, mais laisse WordPress rendre nativement les projets.
 */

defined('ABSPATH') || exit;

if (
    !function_exists('add_action') ||
    !function_exists('add_filter') ||
    !function_exists('remove_action') ||
    !function_exists('add_theme_support') ||
    !function_exists('register_nav_menus') ||
    !function_exists('__') ||
    !function_exists('is_post_type_archive') ||
    !function_exists('is_singular') ||
    !function_exists('get_stylesheet_directory') ||
    !function_exists('wp_mkdir_p') ||
    !function_exists('current_user_can') ||
    !function_exists('is_admin')
) {
    return;
}

// ─── Support thème ────────────────────────────────────────────────────────────

add_action('after_setup_theme', function (): void {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style']);
    register_nav_menus([
        'primary' => __('Navigation principale', 'mademo'),
    ]);
});

add_action('wp_enqueue_scripts', function (): void {
    if (!function_exists('wp_enqueue_style') || !function_exists('get_stylesheet_uri')) {
        return;
    }

    $css_path = get_stylesheet_directory() . '/style.css';
    $version = file_exists($css_path) ? filemtime($css_path) : false;

    wp_enqueue_style('mademo-theme-style', get_stylesheet_uri(), [], $version ?: null);
});

/**
 * Les projets sont la première section migrée vers des modèles WordPress.
 */
function mademo_is_native_project_request(): bool
{
    if (!function_exists('is_post_type_archive') || !function_exists('is_singular')) {
        return false;
    }

    return is_post_type_archive('mademo_project') || is_singular('mademo_project');
}

// ─── ACF JSON sync ───────────────────────────────────────────────────────────

function mademo_acf_json_dir(): string
{
    if (!function_exists('get_stylesheet_directory') || !function_exists('wp_mkdir_p')) {
        return '';
    }

    $dir = get_stylesheet_directory() . '/acf-json';

    if (!is_dir($dir)) {
        wp_mkdir_p($dir);
    }

    return $dir;
}

add_filter('acf/settings/save_json', function () {
    return mademo_acf_json_dir();
});

add_filter('acf/settings/load_json', function (array $paths): array {
    $dir = mademo_acf_json_dir();
    if ($dir === '') {
        return $paths;
    }

    if (!in_array($dir, $paths, true)) {
        $paths[] = $dir;
    }
    return $paths;
});

// ─── Theme WordPress natif ───────────────────────────────────────────────────
// Le site est désormais exploité comme un thème WordPress éditable depuis le
// back-office. Les contenus ACF, pages, blocs et textes sont rendus nativement
// et la SPA n’est plus utilisée comme fallback sur les pages de contenu.
//
// Si un jour une app React est réintroduite, elle devra être branchée sur des
// routes explicitement dédiées, sans remplacer les pages WordPress classiques.

// ─── Pas de fallback SPA ─────────────────────────────────────────────────────
// Les contenus WordPress doivent rester éditables et rendus nativement. Le
// thème ne redirige plus vers la SPA pour les pages classiques.

// ─── Nettoyage du <head> ──────────────────────────────────────────────────────

// Lien REST dans le head (déjà dans les headers HTTP)
remove_action('wp_head', 'rest_output_link_wp_head');
// Flux RSS inutiles pour une SPA
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);
// Meta generator (sécurité : ne pas exposer la version WP)
remove_action('wp_head', 'wp_generator');
// Emoji (~12 Ko économisés)
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
// oEmbed — inutile pour la SPA
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');
// RSD et Windows Live Writer
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
// Shortlink
remove_action('wp_head', 'wp_shortlink_wp_head');

// ─── Barre d'admin ────────────────────────────────────────────────────────────

add_filter('show_admin_bar', function (): bool {
    if (!function_exists('current_user_can')) {
        return false;
    }

    return current_user_can('administrator');
});

// ─── Désactiver commentaires et trackbacks sur les CPT ───────────────────────

add_action('init', function (): void {
    if (!function_exists('remove_post_type_support')) {
        return;
    }

    $types = ['mademo_project', 'mademo_fragment', 'mademo_text', 'mademo_research'];
    foreach ($types as $type) {
        remove_post_type_support($type, 'comments');
        remove_post_type_support($type, 'trackbacks');
    }
});

// ─── Désactiver xmlrpc si non nécessaire ─────────────────────────────────────

add_filter('xmlrpc_enabled', '__return_false');

// ─── Headers de sécurité supplémentaires ─────────────────────────────────────

add_action('send_headers', function (): void {
    if (!function_exists('is_admin') || is_admin()) {
        return;
    }

    header("Content-Security-Policy: frame-ancestors 'self' https://wordpress.com https://*.wordpress.com");
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
});
