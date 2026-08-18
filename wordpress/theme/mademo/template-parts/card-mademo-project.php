<?php
/**
 * Carte d'un projet Mademo.
 */

defined( 'ABSPATH' ) || exit;

$mademo_index = isset( $args['index'] ) ? (int) $args['index'] : 1;
$mademo_field = static function ( string $name ) {
	return function_exists( 'get_field' ) ? get_field( $name ) : get_post_meta( get_the_ID(), $name, true );
};

$mademo_category = (string) $mademo_field( 'category' );
$mademo_year     = (string) $mademo_field( 'year' );
$mademo_tagline  = (string) $mademo_field( 'manifeste' );
$mademo_statuses = get_the_terms( get_the_ID(), 'project_status' );
$mademo_themes   = get_the_terms( get_the_ID(), 'mademo_theme' );
$mademo_status   = $mademo_statuses && ! is_wp_error( $mademo_statuses ) ? $mademo_statuses[0]->name : '';
$mademo_theme    = $mademo_themes && ! is_wp_error( $mademo_themes ) ? $mademo_themes[0]->name : '';

if ( ! $mademo_tagline ) {
	$mademo_tagline = get_the_excerpt();
}
?>

<article <?php post_class( 'mademo-project-card' ); ?>>
	<a class="mademo-project-card__link" href="<?php the_permalink(); ?>">
		<div class="mademo-project-card__media">
			<span class="mademo-project-card__number" aria-hidden="true"><?php echo esc_html( str_pad( (string) $mademo_index, 2, '0', STR_PAD_LEFT ) ); ?></span>
			<?php if ( has_post_thumbnail() ) : ?>
				<?php
				the_post_thumbnail( 'mademo-card', [
					'class'   => 'mademo-project-card__image',
					'loading' => 'lazy',
					'sizes'   => '(max-width: 680px) 100vw, (max-width: 1024px) 50vw, 33vw',
				] );
				?>
			<?php else : ?>
				<span class="mademo-project-card__placeholder" aria-hidden="true"></span>
			<?php endif; ?>
		</div>

		<div class="mademo-project-card__content">
			<div class="mademo-project-card__meta">
				<span><?php echo esc_html( $mademo_status ?: $mademo_category ); ?></span>
				<span><?php echo esc_html( $mademo_year ); ?></span>
			</div>

			<h2 class="mademo-project-card__title"><?php the_title(); ?></h2>

			<?php if ( $mademo_tagline ) : ?>
				<p class="mademo-project-card__tagline"><?php echo esc_html( $mademo_tagline ); ?></p>
			<?php endif; ?>

			<?php if ( $mademo_theme ) : ?>
				<p class="mademo-project-card__medium"><?php echo esc_html( $mademo_theme ); ?></p>
			<?php endif; ?>
		</div>
	</a>
</article>
