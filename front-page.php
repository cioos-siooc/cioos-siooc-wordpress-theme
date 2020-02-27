<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 *
 * @package ThinkUpThemes
 */

get_header(); ?>

<!-- Add in the containers the asset map needs -->

<div class="outer-map-container" id="intro-core">
  <div class="overlay"></div>
  <div class="map-container" id="asset_map_container">
    <div id="map" class="map" ></div>
    <div id="category_panel" class="category-selection"></div>
    <div id="variable_panel" class="variable-selection tab-content"></div>
    <div id="dataset_desc" class="panel_details"></div>
    <div class="panel_search_info" style="text-align:center" id="dataset_search_stats"></div>
  </div>
</div>
  

<?php while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'content', 'page' ); ?>
<?php endwhile; wp_reset_query(); ?>



<?php get_footer(); ?>

<?php    //Language switch system - this will reload the map on WP switch
  function inlinejs($output) {
    $js_code = '<script>' . $output . '</script>';
    echo $js_code;
  }
  if(pll_current_language() == 'en') {
    $lang = 'jQuery(document).ready(function( $ ) {changeCurrentLanguage(\'en\')});';
    inlinejs($lang);
  } else if(pll_current_language() == 'fr') {
    $lang = 'jQuery(document).ready(function( $ ) {changeCurrentLanguage(\'fr\')});'; 
    inlinejs($lang); 
  }; 
?>