<?php
/*
Plugin Name: MP People
Plugin URI: http://moveplugins.com
Description: Save person profiles and display them in themes etc. 
Version: 1.0
Author: Move Plugins
Author URI: http://moveplugins.com
Text Domain: mp_people
Domain Path: languages
License: GPL2
*/

/*  Copyright 2012  Phil Johnston  (email : phil@moveplugins.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Move Plugins Core.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Move Plugins Core, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/
// Plugin version
if( !defined( 'MP_PEOPLE_VERSION' ) )
	define( 'MP_PEOPLE_VERSION', '1.0.0.0' );

// Plugin Folder URL
if( !defined( 'MP_PEOPLE_PLUGIN_URL' ) )
	define( 'MP_PEOPLE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Plugin Folder Path
if( !defined( 'MP_PEOPLE_PLUGIN_DIR' ) )
	define( 'MP_PEOPLE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Plugin Root File
if( !defined( 'MP_PEOPLE_PLUGIN_FILE' ) )
	define( 'MP_PEOPLE_PLUGIN_FILE', __FILE__ );

/*
|--------------------------------------------------------------------------
| GLOBALS
|--------------------------------------------------------------------------
*/



/*
|--------------------------------------------------------------------------
| INTERNATIONALIZATION
|--------------------------------------------------------------------------
*/

function mp_people_textdomain() {

	// Set filter for plugin's languages directory
	$mp_people_lang_dir = dirname( plugin_basename( MP_PEOPLE_PLUGIN_FILE ) ) . '/languages/';
	$mp_people_lang_dir = apply_filters( 'mp_people_languages_directory', $mp_people_lang_dir );


	// Traditional WordPress plugin locale filter
	$locale        = apply_filters( 'plugin_locale',  get_locale(), 'mp-people' );
	$mofile        = sprintf( '%1$s-%2$s.mo', 'mp-people', $locale );

	// Setup paths to current locale file
	$mofile_local  = $mp_people_lang_dir . $mofile;
	$mofile_global = WP_LANG_DIR . '/mp-people/' . $mofile;

	if ( file_exists( $mofile_global ) ) {
		// Look in global /wp-content/languages/mp_people folder
		load_textdomain( 'mp_people', $mofile_global );
	} elseif ( file_exists( $mofile_local ) ) {
		// Look in local /wp-content/plugins/message_bar/languages/ folder
		load_textdomain( 'mp_people', $mofile_local );
	} else {
		// Load the default language files
		load_plugin_textdomain( 'mp_people', false, $mp_people_lang_dir );
	}

}
add_action( 'init', 'mp_people_textdomain', 1 );

/*
|--------------------------------------------------------------------------
| INCLUDES
|--------------------------------------------------------------------------
*/
function mp_people_include_files(){
	/**
	 * If mp_core isn't active, stop and install it now
	 */
	if (!function_exists('mp_core_textdomain')){
		
		/**
		 * Include Plugin Checker
		 */
		require( MP_PEOPLE_PLUGIN_DIR . 'includes/plugin-checker/class-plugin-checker.php' );
		
		/**
		 * Check if wp_core in installed
		 */
		require( MP_PEOPLE_PLUGIN_DIR . 'includes/plugin-checker/included-plugins/mp-core-check.php' );
		
	}
	/**
	 * Otherwise, if mp_core is active, carry out the plugin's functions
	 */
	else{
		
		/**
		 * Update script - keeps this plugin up to date
		 */
		require( MP_PEOPLE_PLUGIN_DIR . 'includes/updater/mp-people-update.php' );
		
		/**
		 * Enqueue Scripts
		 */
		require( MP_PEOPLE_PLUGIN_DIR . 'includes/misc-functions/enqueue-scripts.php' );
		
		/**
		 * Misc Functions
		 */
		require( MP_PEOPLE_PLUGIN_DIR . 'includes/misc-functions/misc-functions.php' );
		
		/**
		 * Settings Metabox for mp_people
		 */
		require( MP_PEOPLE_PLUGIN_DIR . 'includes/metaboxes/mp-person-meta/mp-person-meta.php' );
		
		/**
		 * Settings Metabox for mp_social_networks
		 */
		require( MP_PEOPLE_PLUGIN_DIR . 'includes/metaboxes/mp-links/mp-links.php' );
		
		/**
		 * People Custom Post Type
		 */
		require( MP_PEOPLE_PLUGIN_DIR . 'includes/custom-post-types/people.php' );
		
		/**
		 * Template Tags
		 */
		require( MP_PEOPLE_PLUGIN_DIR . 'includes/template-tags/template-tags.php' );
				
	}
}
add_action('plugins_loaded', 'mp_people_include_files', 9);