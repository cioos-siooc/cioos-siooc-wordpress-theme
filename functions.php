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

/**
 * Checks for the existence of a stylesheet named ra_custom.css, if found it
 * loads it with a lower priority than the parent and theme styles to be sure 
 * and be last in the styling order to avoid being overridden.
 */
function cioos_custom_stylesheet() {
   # custom CSS url for browser
   $custom_css_url = get_stylesheet_directory_uri() . '/ra_custom.css';
   
   # used to check for existence of custom file
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

// CIOOS Atlantic Regional Association functions.php code below this line

function enqueue_css_styles(){
   wp_enqueue_style( 'css-style', "https://fonts.googleapis.com/css?family=Montserrat:400,450,500,700,900|Quicksand:400,700&display=swap");
}

// TODO: fix this implementation potentially, or find better solution. Breaks some CSS as implemented months ago.
function enqueue_assetmap_styles(){
   wp_enqueue_style( 'asset-style', "/wp-content/asset/css/asset.css");
   wp_enqueue_style( 'openlayer-style', "/wp-content/asset/css/ol.css");
   wp_enqueue_style( 'style-style', "/wp-content/asset/css/style.css");
   wp_enqueue_style( 'css-style', "https://fonts.googleapis.com/css?family=Montserrat:400,700,900|Quicksand:400,700&display=swap");
   wp_enqueue_style( 'bootstrap-style', "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css");
   wp_register_script( 'openlayer', "https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/build/ol.js");
   wp_enqueue_script( 'openlayer');
   #<!--The line below is only needed for old environments like Internet Explorer and Android 4.x-->
   wp_register_script( 'polyfill', "https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL");
   wp_enqueue_script( 'polyfill');
   wp_register_script( 'jquery-v341', "https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js");
   wp_enqueue_script( 'jquery-v341');
   #wp_add_inline_script( 'jquery-v341', 'var jQuery3_4_1 = $.noConflict(true);' );
   #wp_enqueue_script( 'plugin-javascript', plugins_url( 'js.js', __FILE__ ), array('jquery-v341') );
   wp_register_script( 'bootstrap', "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js", array('jquery-v341'));
   wp_enqueue_script( 'bootstrap');
   wp_register_script( 'i18n', "/wp-content/asset/js/asset_i18n.js", array('jquery-v341'));
   wp_enqueue_script( 'i18n');
   wp_register_script( 'ckan', "/wp-content/asset/js/asset_ckan.js", array('jquery-v341'));
   wp_enqueue_script( 'ckan');
   wp_register_script( 'asset', "/wp-content/asset/js/asset.js", array('jquery-v341'));
   wp_enqueue_script( 'asset');
   wp_register_script( 'debug', "/wp-content/asset/js/debugging.js", array('jquery-v341'));
   wp_enqueue_script( 'debug');
}

add_action( 'wp_enqueue_scripts', 'enqueue_assetmap_styles' );

add_action( 'wp_enqueue_scripts', 'enqueue_css_styles' );

?>
