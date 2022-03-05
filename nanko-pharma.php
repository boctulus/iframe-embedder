<?php

/*
Plugin Name: Nanko Pharma
Description: Conector de Nanko con estimador de dósis
Version: 1.0.0
Author: boctulus@gmail.com <Pablo>
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/libs/Debug.php';
require __DIR__ . '/libs/Strings.php';
require __DIR__ . '/libs/Files.php';
require __DIR__ . '/config.php';


if (!function_exists('dd')){
	function dd($val, $msg = null, $pre_cond = null){
		Debug::dd($val, $msg, $pre_cond);
	}
}


function enqueues() 
{  
	wp_register_script('bootstrap', Files::get_rel_path(). 'assets/js/bootstrap/bootstrap.bundle.min.js');
    wp_enqueue_script('bootstrap');

	wp_register_style('bootstrap', Files::get_rel_path() . 'assets/css/bootstrap/bootstrap.min.css');
    #wp_register_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap');
}

add_action( 'wp_enqueue_scripts', 'enqueues');



// function that runs when shortcode is called
function dosis_shortcode($atts = []) {  
	global $nanko_dosis_url;

	if (empty($atts)){
		$atts = [];
	}

	if (!isset($atts['width'])) { 
		$atts['width'] = 630; 
	}

	if (!isset($atts['height'])) { 
		$atts['height'] = 600; 
	}

	if (!isset($atts['src'])){
		// debería vernir del config.php
		$atts['src'] = $nanko_dosis_url;
	}


	return '<iframe border="0" class="shortcode_iframe" src="' . $atts['src'] . '" width="' . $atts['width'] . '" height="' . $atts['height'] . '"></iframe>';
}
	
function dosis_collapse_shortcode($atts = []) { 
	return '<p>  
    <button type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" class="btn btn-primary btn-sm">Calcular dósis</button>

    </p>
    <div class="collapse" id="collapseExample">
        '.dosis_shortcode($atts).'
    </div>';
} 

// register shortcodes
add_shortcode('dosis', 'dosis_shortcode');
add_shortcode('dosis_btn', 'dosis_collapse_shortcode');



