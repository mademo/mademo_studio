<?php
/**
 * Fiche native d'un projet.
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/navigation' );

while ( have_posts() ) :
	the_post();

	$mademo_field = static function ( string $name ) {
		return function_exists( 'get_field' ) ? get_field( $name ) : get_post_meta( get_the_ID(), $name, true );
	};

	$mademo_year      = (string) $mademo_field( 'year' );
	$mademo_category  = (string) $mademo_field( 'category' );
	$mademo_question  = (string) $mademo_field( 'question' );
	$mademo_manifeste = (string) $mademo_field( 'manifeste' );
	$mademo_statuses  = get_the_terms( get_the_ID(), 'project_status' );
	$mademo_status    = $mademo_statuses && ! is_wp_error( $mademo_statuses ) ? $mademo_statuses[0]->name : '';
	?>

	<main id="primary" class="mademo-project-single">
		<a class="mademo-project-single__back" href="<?php echo esc_url( get_post_type_archive_link( 'mademo_project' ) ); ?>">← <?php esc_html_e( 'Tous les projets', 'mademo' ); ?></a>

		<header class="mademo-project-single__header">
			<p class="mademo-project-single__meta">
				<?php echo esc_html( implode( ' · ', array_filter( [ $mademo_status, $mademo_category, $mademo_year ] ) ) ); ?>
			</p>
			<h1><?php the_title(); ?></h1>
			<?php if ( $mademo_manifeste ) : ?>
				<p class="mademo-project-single__manifesto"><?php echo esc_html( $mademo_manifeste ); ?></p>
			<?php endif; ?>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="mademo-project-single__hero"><?php the_post_thumbnail( 'mademo-hero' ); ?></figure>
		<?php endif; ?>

		<div class="mademo-project-single__body">
			<?php if ( $mademo_question ) : ?>
				<aside class="mademo-project-single__question">
					<span><?php esc_html_e( 'Question centrale', 'mademo' ); ?></span>
					<p><?php echo esc_html( $mademo_question ); ?></p>
				</aside>
			<?php endif; ?>

			<article class="mademo-project-single__content">
				<?php the_content(); ?>
			</article>
		</div>
	</main>

<?php endwhile; ?>

<?php get_footer(); ?>
