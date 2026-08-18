<?php
/**
 * Template Name: ACF Native Page
 * Description: Modèle WordPress natif pour les pages éditables, contenus et champs ACF.
 */

defined('ABSPATH') || exit;

if (!function_exists('get_header') || !function_exists('get_footer')) {
    return;
}

get_header();
?>

<main id="primary" class="mademo-page mademo-acf-page">
    <?php while (have_posts()):
        the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('mademo-page__content'); ?>>
            <header class="mademo-page__header">
                <?php the_title('<h1 class="mademo-page__title">', '</h1>'); ?>
            </header>

            <div class="mademo-page__body">
                <?php the_content(); ?>
            </div>

            <?php if (function_exists('get_fields')): ?>
                <?php
                $acf_fields = get_fields(get_the_ID());
                if (is_array($acf_fields) && !empty($acf_fields)):
                    echo '<div class="mademo-acf-fields">';
                    foreach ($acf_fields as $key => $value) {
                        if (in_array($key, ['_edit_last', '_edit_lock', '_wp_page_template'], true)) {
                            continue;
                        }

                        if ($key === 'content' || $key === 'post_content') {
                            continue;
                        }

                        if (empty($value) && !is_numeric($value)) {
                            continue;
                        }

                        echo '<section class="mademo-acf-field">';
                        echo '<h2>' . esc_html(str_replace(['_', '-'], ' ', $key)) . '</h2>';

                        if (is_array($value)) {
                            echo '<pre>' . esc_html(wp_json_encode($value)) . '</pre>';
                        } else {
                            echo '<div>' . wp_kses_post($value) . '</div>';
                        }

                        echo '</section>';
                    }
                    echo '</div>';
                endif;
                ?>
            <?php endif; ?>
        </article>
    <?php endwhile; ?>
</main>

<?php
get_footer();
