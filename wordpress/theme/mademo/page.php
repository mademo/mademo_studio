<?php
/**
 * Template par défaut pour les pages WordPress.
 */

defined('ABSPATH') || exit;

get_header();
get_template_part('template-parts/navigation');
?>

<main id="primary" class="mademo-page">
    <?php while (have_posts()):
        the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('mademo-page__content'); ?>>
            <header class="mademo-page__header">
                <?php the_title('<h1 class="mademo-page__title">', '</h1>'); ?>
            </header>

            <div class="mademo-page__body">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php
get_footer();
