<?php
/**
 * Template par défaut pour les articles WordPress.
 */

defined('ABSPATH') || exit;

get_header();
get_template_part('template-parts/navigation');
?>

<main id="primary" class="mademo-single-post">
    <?php while (have_posts()):
        the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('mademo-single-post__content'); ?>>
            <header class="mademo-single-post__header">
                <?php the_title('<h1 class="mademo-single-post__title">', '</h1>'); ?>
                <p class="mademo-single-post__meta"><?php echo esc_html(get_the_date()); ?></p>
            </header>

            <div class="mademo-single-post__body">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php
get_footer();
