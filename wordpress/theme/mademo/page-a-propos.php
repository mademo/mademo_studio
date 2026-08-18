<?php
/**
 * Template React : À propos
 */

defined('ABSPATH') || exit;

if (!function_exists('get_header') || !function_exists('get_template_part')) {
    return;
}

get_header();
get_template_part('template-parts/navigation');
?>

<a class="screen-reader-text" href="#mademo-react-page">
    <?php
    if (function_exists('esc_html_e')) {
        esc_html_e('Aller au contenu', 'mademo');
    } else {
        echo 'Aller au contenu';
    }
    ?>
</a>

<main id="mademo-react-page" class="mademo-react-page" data-react-route="a-propos" aria-label="<?php
if (function_exists('esc_attr_e')) {
    esc_attr_e('À propos', 'mademo');
} else {
    echo 'À propos';
}
?>">
    <noscript>
        <p class="mademo-react-page__noscript">
            <?php
            if (function_exists('esc_html_e')) {
                esc_html_e('Cette page nécessite JavaScript pour fonctionner correctement.', 'mademo');
            } else {
                echo 'Cette page nécessite JavaScript pour fonctionner correctement.';
            }
            ?>
        </p>
    </noscript>
    <div id="root" role="main" aria-live="polite" aria-busy="true"></div>
</main>

<?php
if (function_exists('get_footer')) {
    get_footer();
}
