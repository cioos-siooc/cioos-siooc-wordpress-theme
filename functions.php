<?php

   function enqueue_parent_styles() {
       wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
      wp_enqueue_style( 'bootstyle','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' );
      wp_enqueue_style( 'style',get_stylesheet_directory_uri().'/style.css' );
    }

    add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );



    function assetmap_scripts() {
        if( is_front_page() ){ 
        // CSS
          wp_enqueue_style( 'asset-style', get_stylesheet_directory_uri().'/asset/css/asset.css' );
          wp_enqueue_style( 'map-style', get_stylesheet_directory_uri().'/asset/css/ol.css' );

        //google fonts
          wp_enqueue_style( 'gfont','https://fonts.googleapis.com/css?family=Montserrat:400,700,900|Quicksand:400,700&display=swap' );
        
        // SCRIPTS
            wp_enqueue_script( 'map-build','https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/build/ol.js', array('jquery'), '', false  );
            wp_enqueue_script( 'polyfill','https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL', array('jquery'), '', false  );
            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'jquery-migrate' );
            wp_enqueue_script( 'bootstrap','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'), '', false  );
            wp_enqueue_script( 'i18', get_stylesheet_directory_uri() . '/asset/js/asset_i18n.js', array('jquery'), '', false   );
            wp_enqueue_script( 'assetckan', get_stylesheet_directory_uri() . '/asset/js/asset_ckan.js', array('jquery'), '', false   );
            wp_enqueue_script( 'assetgeneral', get_stylesheet_directory_uri() . '/asset/js/asset.js', array('jquery'), '', false   );
            wp_enqueue_script( 'assetol', get_stylesheet_directory_uri() . '/asset/js/asset_ol.js', array('jquery'), '', true   );
        }
        
    }

    add_action( 'wp_enqueue_scripts', 'assetmap_scripts', 10);





//==================================================================================
// Header iframe options and security policy
//===================================================================================

    function addheaders() {        
        
        header("Content-Security-Policy: default-src 'self' 'unsafe-inline' 'unsafe-eval' *.googleapis.com *.wikimedia.org *.hakai.org *.cioos.org *.cioos.ca *.canada.ca d3js.org *.cloudflare.com *.gstatic.com unpkg.com *.bootstrapcdn.com *.rawgit.com *.polyfill.io *.gebco.net *.mailchimp.com cdn-images.mailchimp.com *.dropboxusercontent.com/s/pxxqg90g7zxtt8n/q67JXA0dJ1dt.js *.gravatar.com *.arcgis.com data: ;");
        header("Access-Control-Allow-Origin: *");
        header("X-Frame-Options: SAMEORIGIN" );
        header("X-XSS-Protection: 1; mode=block");
        header("Strict-Transport-Security: max-age=31536000");
        header("Referrer-Policy: no-referrer-when-downgrade");

        if ($wp_query->is_404) {
            header("HTTP/1.0 404 Not Found");
        }
    }
    add_action('init','addheaders');

    define( 'WP_DEBUG', true );



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
    add_action( 'wp_head', 'cioos_customize_logo' );
?>