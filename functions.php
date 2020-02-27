<?php
function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

//==================================================================================
// Asset Map JS
//==================================================================================

 function assetmap_scripts() {
     if( is_front_page() ){ 
     // CSS
       wp_enqueue_style( 'asset-style', get_stylesheet_directory_uri().'/cioos-siooc-assetmap/asset/css/asset.css' );
       wp_enqueue_style( 'map-style', get_stylesheet_directory_uri().'/cioos-siooc-assetmap/asset/css/ol.css' );
     
     // SCRIPTS
         wp_enqueue_script( 'map-build','https:/cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/build/ol.js', array('jquery'), '', false  );
         wp_enqueue_script( 'i18', get_stylesheet_directory_uri() . '/cioos-siooc-assetmap/asset/js/asset_i18n.js', array('jquery'), '', false   );
         wp_enqueue_script( 'assetckan', get_stylesheet_directory_uri() . '/cioos-siooc-assetmap/asset/js/asset_ckan.js', array('jquery'), '', false   );
         wp_enqueue_script( 'assetgeneral', get_stylesheet_directory_uri() . '/cioos-siooc-assetmap/asset/js/asset.js', array('jquery'), '', false   );
         wp_enqueue_script( 'assetui', get_stylesheet_directory_uri() . '/cioos-siooc-assetmap/asset/js/asset_ui.js', array('jquery'), '', false   );
         wp_enqueue_script( 'assetol', get_stylesheet_directory_uri() . '/cioos-siooc-assetmap/asset/js/asset_ol.js', array('jquery'), '', true   );
     }
     
 }

 add_action( 'wp_enqueue_scripts', 'assetmap_scripts', 10);

//==================================================================================
// The Rest
//==================================================================================

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

/**
 * Checks for the existance of a stylesheet named ra_custom.css, if found it 
 * loads it with a lower priority than the parent and theme styles to be sure 
 * and be last in the styling order to avoid being overridden.
 */
function cioos_custom_stylesheet() {
   # custom CSS url for browser
   $custom_css_url = get_stylesheet_directory_uri() . '/ra_custom.css';
   
   # used to check for existance of custom file
   $custom_css_path = get_stylesheet_directory() . '/ra_custom.css';
   if (file_exists($custom_css_path)) {
      wp_enqueue_style( 'ra-custom-style', $custom_css_url, array('parent-style'));
   }
}

add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
add_action( 'wp_enqueue_scripts', 'cioos_custom_stylesheet', 50000);
add_action( 'customize_register', 'cioos_customize_register');
add_action( 'wp_head', 'cioos_customize_logo' );

function register_copyright_config_for_locale( $wp_customize, $locale ) {
   $setting_id = 'wrt_copyright_'.$locale;
   $control_id = 'cioos_wrt_copyright_'.$locale;

   $wp_customize->add_setting( $setting_id );
   $wp_customize->add_control( $control_id, array(
       'label'   => __( 'Copyright Text ', 'CIOOS').$locale,
       'type'    => 'text',
       'section' => 'title_tagline',
       'settings' => $setting_id,
   ) );
}

function cioos_customize_copyright_register($wp_customize) {
   $locales = [
       'en_CA',
       'fr_CA'
   ];
   foreach ( $locales as $locale) {
      register_copyright_config_for_locale($wp_customize, $locale);
   }
}

function cioos_customize_copyright() {
   global $thinkup_footer_copyright;

   if (function_exists('pll_current_language')) {
      $locale = pll_current_language('locale');
      $setting_id = 'wrt_copyright_' . $locale;
      if ( get_theme_mod( $setting_id ) ) {
         $thinkup_footer_copyright = get_theme_mod( $setting_id );
      } else {
         if ( get_theme_mod('wrt_copyright') ) {
            $thinkup_footer_copyright = get_theme_mod('wrt_copyright');
         } else {
            $thinkup_footer_copyright = get_theme_mod( 'wrt_copyright_en_CA' );
         }
      }
   }
}

add_action( 'customize_register', 'cioos_customize_copyright_register');
add_action( 'wp_head', 'cioos_customize_copyright' );

?>
