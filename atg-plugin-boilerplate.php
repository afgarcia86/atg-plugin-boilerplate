<?php
/*
Plugin Name: ATG Plugin Boilerplate
Plugin URI:  http://www.github.com/afgarcia86/atg-plugin-boilerplate/
Description: This is a basic boilerplate plugin for faster plugin development
Version:     1.0.0
Author:      AndresTheGiant
Author URI:  http://www.andresthegiant.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: atgpb
*/

//------------------------------------------------------------------------------------------------------------------
//---------- ATG License Key ---------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//If you hardcode a ATG License Key here, it will automatically populate on activation.
$atg_license_key = '';

//-- OR ---//

//You can also add the ATG Plugin Boilerplate license key to your wp-config.php file to automatically populate on activation
//Add the code in the comment below to your wp-config.php to do so:
//define('GF_LICENSE_KEY','YOUR_KEY_GOES_HERE');
//------------------------------------------------------------------------------------------------------------------

if ( ! defined( 'ABSPATH' ) ) {
  die();
}

/**
 * Defines the current page.
 * @var string ATG_CURRENT_PAGE The current page
 */
if ( ! defined( 'ATG_CURRENT_PAGE' ) ) {
  define( 'ATG_CURRENT_PAGE', basename( $_SERVER['PHP_SELF'] ) );
}

/**
 * Checks if an admin page is being viewed
 * @var boolean IS_ADMIN True if admin page.  False otherwise.
 */
if ( ! defined( 'IS_ADMIN' ) ) {
  define( 'IS_ADMIN', is_admin() );
}

require_once( plugin_dir_path( __FILE__ ) . 'common.php' );
require_once( plugin_dir_path( __FILE__ ) . 'settings.php' );

add_action( 'init', array( 'ATGPB', 'init' ) );

/**
 * Class ATGPB
 *
 * Handles the loading of ATG Plugin Boilerplate and other core functionality
 */
class ATGPB {

  /**
   * Defines this version of ATG Plugin Boilerplate
   *
   * @access public
   * @static
   * @var string $version The version number
   */
  public static $version = '1.0.0';

  /**
   * Initializes ATG Plugin Boilerplate
   *
   * @access public
   * @static
   */
  public static function init() {
    self::register_scripts();

    add_action( 'wp_enqueue_scripts', array( 'ATGPB', 'enqueue_scripts' ) );
    add_action( 'admin_menu', array( 'ATGPB', 'create_menu' ) );
  }

  /* Registers ATG Plugin Boilerplate scripts
   *
   * If SCRIPT_DEBUG constant is set, uses the un-minified version.
   *
   * @access public
   * @static
   */
  public static function register_scripts() {
    $base_url = ATGPBCommon::get_base_url();
    $version  = ATGPB::$version;

    wp_register_script('atgbp_admin', $base_url . '/js/admin.js', array('jquery'), $version);
    wp_register_style('atgbp_admin', $base_url . '/css/admin.css', array(), $version);
  }

  /**
   * Enqueues registered ATG Plugin Boilerplate scripts
   *
   * @access public
   * @static
   *
   * @param null $hook Not used
   */
  public static function enqueue_scripts( $hook ) {
    $scripts = array();

    if(IS_ADMIN) {
      wp_enqueue_script('atgbp_admin');
      wp_enqueue_style('atgbp_admin');
    }
  }

  /**
   * Creates the "Hello" left nav.
   *
   * WordPress generates the page hook suffix and screen ID by passing the translated menu title through sanitize_title().
   * Screen options and metabox preferences are stored using the screen ID therefore:
   * 1. The page suffix or screen ID should never be hard-coded. Use get_current_screen()->id.
   * 2. The page suffix and screen ID must never change.
   *  e.g. When an update for Gravity Forms is available an icon will be added to the the menu title.
   *  The HTML for the icon will be stripped entirely by sanitize_title() because the number 1 is encoded.
   *
   * @access public
   * @static
   *
   */
  public static function create_menu() {

    $has_full_access = current_user_can( 'manage_options' );

    $admin_icon = self::get_admin_icon_b64();

    add_menu_page( __( 'Hello', 'atgbp' ), __( 'Hello', 'atgbp' ), current_user_can( 'manage_options' ), 'atgbp_settings',array( 'ATGPBSettings', 'settings_page' ), $admin_icon, 80 );

    // Adding submenu pages
    // add_submenu_page( $parent_menu['name'], __( 'Help', 'gravityforms' ), __( 'Help', 'gravityforms' ), $has_full_access ? 'gform_full_access' : $min_cap, 'gf_help', array( 'RGForms', 'help_page' ) );

  }

  /**
   * Gets the admin icon for the Forms menu item
   *
   * @access public
   * @static
   *
   * @param bool|string $color The hex color if changing the color of the icon.  Defualts to false.
   *
   * @return string Base64 encoded icon string.
   */
  public static function get_admin_icon_b64() {
    $base_url = ATGPBCommon::get_base_url();
    $svg = base64_encode(file_get_contents($base_url.'/images/dashicon.svg'));
    $icon = 'data:image/svg+xml;base64,' . $svg;
    return $icon;
  }

}