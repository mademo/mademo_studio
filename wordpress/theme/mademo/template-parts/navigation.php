<?php
/**
 * En-tête natif des pages projets.
 */

defined( 'ABSPATH' ) || exit;
?>

<header class="mademo-native-header">
	<a class="mademo-native-header__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php echo esc_html( get_bloginfo( 'name' ) ?: 'Mademo Studio' ); ?>
	</a>

	<nav class="mademo-native-nav" aria-label="<?php esc_attr_e( 'Navigation principale', 'mademo' ); ?>">
		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<?php
			wp_nav_menu( [
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'mademo-native-nav__list',
				'depth'          => 1,
				'fallback_cb'    => false,
			] );
			?>
		<?php else : ?>
			<ul class="mademo-native-nav__list">
				<li><a href="<?php echo esc_url( home_url( '/atelier/' ) ); ?>"><?php esc_html_e( 'Atelier', 'mademo' ); ?></a></li>
				<li class="current-menu-item"><a href="<?php echo esc_url( get_post_type_archive_link( 'mademo_project' ) ); ?>"><?php esc_html_e( 'Projets', 'mademo' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/constellation/' ) ); ?>"><?php esc_html_e( 'Constellation', 'mademo' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/a-propos/' ) ); ?>"><?php esc_html_e( 'À propos', 'mademo' ); ?></a></li>
			</ul>
		<?php endif; ?>
	</nav>
</header>
