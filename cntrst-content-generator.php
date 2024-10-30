<?php
/**
 * Plugin Name: Contrast Content Generator
 * Plugin URI: http://www.contrast.fi
 * Description: A plugin to create dummy lorem ipsum content in WordPress
 * Author: Sampo Silvennoinen / Contrast.fi
 * Author URI: http://www.contrast.fi
 * Version: 1.0.0
 * Text Domain: content-generator
 * Domain Path: /i18n/languages/
 *
 * Copyright: (c) 2016 Contrast Digital Ltd. (hello@contrast.fi)
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @author    Contrast Digital Ltd.
 * @category  
 * @copyright Copyright (c) 2016, Contrast Digital Oy
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Cntrst_Generate {

	/**
	 *  Generate posts for Wordpress
	 *  @param string	$type 		-> Type of content, eg. post, name of cpt...
	 *  @param int		$amount		-> Amount of posts to be generated
	 *  @since  1.0.0
	 */

	public function content( $type, $amount ) {

	    for( $i = 0; $i < $amount; $i++ ) {
	    	$content = file_get_contents( 'http://loripsum.net/api' ); //Generic lorem ipsum
		    $paragraphs = explode( '</p>', $content) ;
		    $words = explode( ' ', trim( $paragraphs[1] ) );
	    	$title = $this->generate_title( $words );

		    // Create post object
			$my_post = array(
			  'post_title'    => wp_strip_all_tags( $title ),
			  'post_content'  => $content,
			  'post_status'   => 'publish',
			  'post_type'	  => $type,
			  'post_author'   => 1,
			);

			wp_insert_post( $my_post );
		    }
	}

	/**
	 *  Generate title of varying length
	 *  @param array	$dictionary -> lorem ipsum words to be used
	 *  @return string 	$title 		-> Title to be used in post
	 *  @since  1.0.0
	 */
	public function generate_title( $dictionary ) {
		$length = rand(2,4);
		$title = "";
		for( $i = 0; $i < $length; $i++ ) {
			$title .= "".$dictionary[$i]." ";
		}
		$title = str_replace( array('.', ',', ':',), '' , $title ); //Kill commas and dots
		return $title;
	}
}

require_once('includes/cntrst-generate-plugin-settings.php');