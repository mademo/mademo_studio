<?php
/**
 * Archive native « Tous les projets ».
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/navigation' );

$mademo_selected_status = isset( $_GET['statut'] )
	? sanitize_title( wp_unslash( $_GET['statut'] ) )
	: '';

$mademo_statuses = get_terms( [
	'taxonomy'   => 'project_status',
	'hide_empty' => false,
	'orderby'    => 'term_order',
	'order'      => 'ASC',
] );

if ( is_wp_error( $mademo_statuses ) ) {
	$mademo_statuses = [];
}

$mademo_status_slugs = wp_list_pluck( $mademo_statuses, 'slug' );

if ( $mademo_selected_status && ! in_array( $mademo_selected_status, $mademo_status_slugs, true ) ) {
	$mademo_selected_status = '';
}

$mademo_query_args = [
	'post_type'      => 'mademo_project',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'orderby'        => [
		'menu_order' => 'ASC',
		'date'       => 'DESC',
	],
];

if ( $mademo_selected_status ) {
	$mademo_query_args['tax_query'] = [
		[
			'taxonomy' => 'project_status',
			'field'    => 'slug',
			'terms'    => $mademo_selected_status,
		],
	];
}

$mademo_projects = new WP_Query( $mademo_query_args );
$mademo_base_url = get_post_type_archive_link( 'mademo_project' );
?>

<main id="primary" class="mademo-projects" data-mademo-projects>
	<header class="mademo-projects__hero">
		<p class="mademo-projects__kicker"><?php esc_html_e( 'Index', 'mademo' ); ?></p>
		<h1 class="mademo-projects__title"><?php esc_html_e( 'Tous les projets', 'mademo' ); ?></h1>

		<nav class="mademo-projects__filters" aria-label="<?php esc_attr_e( 'Filtrer les projets par statut', 'mademo' ); ?>">
			<a
				class="mademo-filter<?php echo '' === $mademo_selected_status ? ' is-active' : ''; ?>"
				href="<?php echo esc_url( $mademo_base_url ); ?>"
				<?php echo '' === $mademo_selected_status ? 'aria-current="page"' : ''; ?>
			>
				<?php esc_html_e( 'Tous', 'mademo' ); ?>
			</a>

			<?php foreach ( $mademo_statuses as $mademo_status ) : ?>
				<a
					class="mademo-filter<?php echo $mademo_selected_status === $mademo_status->slug ? ' is-active' : ''; ?>"
					href="<?php echo esc_url( add_query_arg( 'statut', $mademo_status->slug, $mademo_base_url ) ); ?>"
					<?php echo $mademo_selected_status === $mademo_status->slug ? 'aria-current="page"' : ''; ?>
				>
					<?php echo esc_html( $mademo_status->name ); ?>
				</a>
			<?php endforeach; ?>
		</nav>
	</header>

	<?php if ( $mademo_projects->have_posts() ) : ?>
		<section class="mademo-project-grid" aria-label="<?php esc_attr_e( 'Liste des projets', 'mademo' ); ?>">
			<?php
			$mademo_index = 1;
			while ( $mademo_projects->have_posts() ) :
				$mademo_projects->the_post();
				get_template_part( 'template-parts/card', 'mademo-project', [
					'index' => $mademo_index,
				] );
				++$mademo_index;
			endwhile;
			?>
		</section>
	<?php else : ?>
		<section class="mademo-projects__empty">
			<p><?php esc_html_e( 'Aucun projet publié pour le moment.', 'mademo' ); ?></p>
			<?php if ( $mademo_selected_status ) : ?>
				<a href="<?php echo esc_url( $mademo_base_url ); ?>"><?php esc_html_e( 'Voir tous les projets', 'mademo' ); ?></a>
			<?php endif; ?>
		</section>
	<?php endif; ?>
</main>

<?php
wp_reset_postdata();
get_footer();
