<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package cioos
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php esc_url( bloginfo( 'pingback_url' ) ); ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'cioos' ); ?></a>

<header class="page-header">
	<div class="pre-nav">
		<div class="container">
			<div class="nationallogo"><a rel="home" href="<?php esc_url( bloginfo() ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/logo/Icons-mark/ICON_White.svg"></a></div>
			<div class="logotype"><a rel="home" href="<?php esc_url( bloginfo() ); ?>"><?php dynamic_sidebar('sidebar-logotype') ?></a></div>	
		</div>
	</div>
	
	<div class="post-nav">
		<div class="container">
			<div class="sitelogo">
				<a rel="home" href="<?php esc_url( bloginfo() ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/cioos-national_EN_FR.svg" alt="Logo"></a>
			</div>	
			<nav id="site-navigation" class="site-navigation nav main-nav main-navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', '_s' ); ?></button>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					)
				);
				?>
			</nav>
			<nav id="language" class="site-navigation nav language-nav">
				<div class="menu-default-container">
					<ul class="sitelanguages">
						<?php if (function_exists('pll_the_languages')){
							pll_the_languages(array(
							'hide_current' => 1,
							'display_names_as' => 'slug'
							));
						}?>
					</ul>
				</div>
			</nav>
		</div>
	</div>
</header>