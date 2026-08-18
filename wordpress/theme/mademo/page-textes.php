<?php
/**
 * Template React : Textes
 */

defined('ABSPATH') || exit;

get_header();
get_template_part('template-parts/navigation');
?>

<a class="screen-reader-text" href="#mademo-react-page">
    <?php esc_html_e('Aller au contenu', 'mademo'); ?>
</a>

<main id="mademo-react-page" class="mademo-react-page" data-react-route="textes"
    aria-label="<?php esc_attr_e('Textes', 'mademo'); ?>">
    <noscript>
        <p class="mademo-react-page__noscript">
            <?php esc_html_e('Cette page nécessite JavaScript pour fonctionner correctement.', 'mademo'); ?>
        </p>
    </noscript>
    <div id="root" role="main" aria-live="polite" aria-busy="true"></div>
</main>

<?php
get_footer();
