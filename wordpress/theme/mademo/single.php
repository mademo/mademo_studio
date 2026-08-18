<?php
/**
 * Template par défaut pour les articles WordPress.
 */

defined('ABSPATH') || exit;

if (!function_exists('get_header') || !function_exists('get_template_part') || !function_exists('have_posts') || !function_exists('the_post')) {
    return;
}

get_header();
get_template_part('template-parts/navigation');
?>

<main id="primary" class="mademo-single-post">
    <?php if (function_exists('have_posts')):
        while (have_posts()):
            the_post(); ?>
            <article id="post-<?php if (function_exists('the_ID')) {
                the_ID();
            } ?>" <?php if (function_exists('post_class')) {
                 post_class('mademo-single-post__content');
             } ?>>
                <header class="mademo-single-post__header">
                    <?php if (function_exists('the_title')) {
                        the_title('<h1 class="mademo-single-post__title">', '</h1>');
                    } ?>
                    <p class="mademo-single-post__meta"><?php echo esc_html(get_the_date()); ?></p>
                </header>

                <div class="mademo-single-post__body">
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
