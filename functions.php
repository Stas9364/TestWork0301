<?php

require_once get_stylesheet_directory() . '/php/custom-posts-type.php';
require_once get_stylesheet_directory() . '/php/coordinates-metabox.php';
require_once get_stylesheet_directory() . '/php/custom-taxonomies.php';
require_once get_stylesheet_directory() . '/php/cities-widget.php';
require_once get_stylesheet_directory() . '/inc/ajax/ajax-search-city.php';
require_once get_stylesheet_directory() . '/inc/db/db-query-cities.php';

add_action('wp_enqueue_scripts', 'themeScripts');
function themeScripts()
{
    wp_enqueue_script('send-city-name', get_stylesheet_directory_uri() . '/assets/js/get-city.js', [], false, true);

    wp_enqueue_style('storefront-style', get_template_directory_uri() . '/style.css');

    wp_enqueue_style('storefront-child-style', get_stylesheet_directory_uri() . '/style.css', array());

    /**
     * add const ajaxurl to head for use in js
     */
    wp_register_script('ajaxurl-script', '', [], false, true);
    wp_enqueue_script('ajaxurl-script');
    wp_add_inline_script('ajaxurl-script', 'const ajaxurl = "' . admin_url('admin-ajax.php') . '";');
}

/** 
 * register ajax action
 */
add_action('wp_ajax_searchCity', 'searchCity');
add_action('wp_ajax_nopriv_searchCity', 'searchCity');
