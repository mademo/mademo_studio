<?php
/**
 * Template par défaut pour les pages WordPress.
 */

defined('ABSPATH') || exit;

if (!function_exists('get_header') || !function_exists('get_template_part')) {
    return;
}

get_header();
if (function_exists('get_template_part')) {
    get_template_part('template-parts/navigation');
}
?>

<main id="primary" class="mademo-page">
    <?php if (function_exists('have_posts') && function_exists('the_post')):
        while (have_posts()):
            the_post(); ?>
            <article id="post-<?php if (function_exists('the_ID')) {
                the_ID();
            } ?>" <?php if (function_exists('post_class')) {
                 post_class('mademo-page__content');
             } ?>>
                <header class="mademo-page__header">
                    <?php if (function_exists('the_title')) {
                        the_title('<h1 class="mademo-page__title">', '</h1>');
                    } ?>
                </header>

                <div class="mademo-page__body">
                    <?php if (function_exists('the_content')) {
                        the_content();
                    } ?>
                </div>
            </article>
        <?php endwhile;
    endif; ?>
</main>

<?php
if (function_exists('get_footer')) {
    get_footer();
}
