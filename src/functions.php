<?php

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
function my_theme_enqueue_styles() {
 
    $parent_style = 'parent-style'; // This is 'twentytwelve-style' for the Twenty Twelve theme.
 
    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style),
        wp_get_theme()->get('Version')
    );

	// LOAD ADDITIONAL STYLESHEETS
	wp_register_style('jquery-ui', get_stylesheet_directory_uri() . '/lib/jquery-ui.css', array(), '1.0', 'all');
	wp_enqueue_style('jquery-ui');
    
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');
function my_theme_enqueue_scripts() {

	// LOAD ADDITIONAL SCRIPTS
	wp_deregister_script('jquery-ui');
	wp_register_script('jquery-ui', get_stylesheet_directory_uri() . '/lib/jquery-ui.js', array('jquery'), '1.0', false);
	wp_enqueue_script('jquery-ui');
	wp_register_script('globalize', get_stylesheet_directory_uri() . '/lib/globalize.js', array('jquery', 'jquery-ui'), '1.0', false);
	wp_enqueue_script('globalize');
	wp_register_script('globalize.culture.de-DE', get_stylesheet_directory_uri() . '/lib/globalize.culture.de-DE.js', array('jquery', 'jquery-ui', 'globalize'), '1.0', false);
	wp_enqueue_script('globalize.culture.de-DE');
	wp_register_script('datepicker-widget', get_stylesheet_directory_uri() . '/js/datepicker-widget.js', array('jquery', 'jquery-ui'), '1.0', false);
	wp_enqueue_script('datepicker-widget');
	wp_register_script('timespinner-widget', get_stylesheet_directory_uri() . '/js/timespinner-widget.js', array('jquery', 'jquery-ui', 'globalize', 'globalize.culture.de-DE'), '1.0', false);
	wp_enqueue_script('timespinner-widget');
	wp_register_script('booking-form', get_stylesheet_directory_uri() . '/js/booking-form.js', array('jquery'), '1.0', false);
	wp_enqueue_script('booking-form');
	
}

?>