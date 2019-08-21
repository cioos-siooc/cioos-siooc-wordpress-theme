<?php
function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

function register_logo_config_for_locale( $wp_customize, $locale ) {
   $setting_id = 'logo_'.$locale;
   $control_id = 'cioos_logo_'.$locale;

   $wp_customize->add_setting( $setting_id );
   $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $control_id, array(
      'label' => __( 'Logo ', 'CIOOS').$locale,
      'section' => 'title_tagline',
      'settings' => $setting_id,
   ) ) );
}

function cioos_customize_register($wp_customize) {
   $locales = [
      'en_CA',
      'fr_CA'
   ];
   foreach ( $locales as $locale) {
      register_logo_config_for_locale($wp_customize, $locale);
   }
}

function cioos_customize_logo() {
   global $thinkup_general_logolink;

   if (function_exists('pll_current_language')) {
      $locale = pll_current_language('locale');
      $setting_id = 'logo_' . $locale;
      if ( get_theme_mod( $setting_id ) ) {
         $thinkup_general_logolink = get_theme_mod( $setting_id );
      } else {
         if ( get_theme_mod('custom_logo') ) {
            $thinkup_general_logolink = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full')[0];
         } else {
            $thinkup_general_logolink = get_theme_mod( 'logo_en_CA' );
         }
      }
   }
}

function cioos_customize_css() {
   ?>
      <style type="text/css">
         .accent_color_background {
            background-color: <?php echo get_theme_mod('accent_color', 'rgb(128,128,128)') ?>;
         }
         #pre-header {
            background-color: <?php echo get_theme_mod('accent_color', 'rgb(128,128,128)') ?>;
         }

         .mega-menu-toggle {
            background-color: <?php echo get_theme_mod('accent_color', 'rgb(128,128,128)') ?>!important;
         }

         #footer {
            background-color: <?php echo get_theme_mod('accent_color', 'rgb(128,128,128)') ?>!important;
         }

         .mega-menu-wrap {
            background-color: <?php echo get_theme_mod('accent_color', 'rgb(128,128,128)') ?>!important;
         }
      </style>
   <?php
}

add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
add_action( 'customize_register', 'cioos_customize_register');
add_action( 'wp_head', 'cioos_customize_css' );
add_action( 'wp_head', 'cioos_customize_logo' );
?>
