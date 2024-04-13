<?php
// https://www.adamboother.com/blog/automatically-posting-to-a-facebook-page-using-the-facebook-sdk-v5-for-php-facebook-api/
// https://developers.facebook.com/docs/pages/publishing/
// https://developers.facebook.com/docs/graph-api/reference/photo
/**
 * The plugin bootstrap file
 *
 * @link              https://wpspins.com/
 * @since             1.0.0
 * @package           Wpspins
 */

/**
 * Plugin Name:    Facebook Post Push
 * Plugin URI:     https://wpspins.com/
 * Description:    Plugin for utilizing the facebook graph API and pushing and deleting walls to multiple Facebook pages using page ids and post templates.
 * Version:        1.0.0
 * Author:         WPSpins
 * Author URI:     https://wpspins.com/
 * License:        GPL-2.0+
 * License URI:    http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:    wpspins
 * Domain Path:    /languages
 */

define( 'FPP_VERSION', '1.0.1' );
define( 'FPP_NAME', 'Facebook Post Push' );
define( 'FPP_PLUGIN_NAME', 'facebook-post-push' );
define( 'FPP_PLUGIN_FILE', plugin_basename( __FILE__ ) ); 
define( 'FPP_PLUGIN_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'FPP_PLUGIN_URL', trailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
define( 'FPP_TABLE', 'fpp' );
define( 'FPP_TABLE_COMPANY', 'fpp_company' );

require 'classes/load-classes.php';
require 'installation.php';
