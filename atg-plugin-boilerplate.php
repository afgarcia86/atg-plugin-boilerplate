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
require_once( plugin_dir_path( __FILE__ ) . 'help.php' );
require_once( plugin_dir_path( __FILE__ ) . 'tinymce-shortcode.php' );

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
    add_action( 'admin_init', array( 'ATGPBSettings', 'register_settings_fields' ) );
    add_shortcode('insert_button', array('ATGPBShortcode', 'insert_button_func'));

    if ( ATGPB::page_supports_insert_button() ) {
      // /*** Start Wisiwig Button ***/
      // add_filter('mce_external_plugins', array('ATGPBShortcode', 'enqueue_plugin_scripts'));
      // add_filter('mce_buttons', array('ATGPBShortcode', 'register_buttons_editor'));
      // /*** End Wisiwig Button ***/

      /*** Start Media Button ***/
      add_action( 'media_buttons', array( 'ATGPBShortcode', 'insert_button' ), 20 );
      add_action( 'admin_print_footer_scripts', array( 'ATGPBShortcode', 'insert_shortcode' ) );
      /*** End Media Button ***/
    }
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
   * Creates the "Bootstrap Button" left nav.
   *
   * @access public
   * @static
   *
   */
  public static function create_menu() {
    $capability = current_user_can( 'manage_options' );
    $menu_slug = 'atgbp_settings';
    
    /*** Add Settings Page ***/
    // add_options_page( __( 'Bootstrap Button', 'atgbp' ), __( 'Bootstrap Button', 'atgbp' ), $capability, $menu_slug, array( 'ATGPBSettings', 'settings_page' ));
    /*** End Settigns Page ***/

    /*** Add Custom Menu ***/
    $admin_icon = self::get_admin_icon_b64();
    add_menu_page( __( 'Bootstrap Button', 'atgbp' ), __( 'Bootstrap Button', 'atgbp' ), $capability, $menu_slug, array( 'ATGPBSettings', 'settings_page' ), $admin_icon, 80 );
    // Adding submenu pages
    add_submenu_page( $menu_slug, __( 'Help', 'atgpb' ), __( 'Help', 'atgpb' ), $capability, 'atgbp_help', array( 'ATGPBHelp', 'help_page' ) );
    /*** End Custom Menu ***/
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

  /**
   * Determines if the "Add Form" button should be added to the page.
   *
   * @access public
   * @static
   *
   * @return boolean $display_add_form_button True if the page is supported.  False otherwise.
   */
  public static function page_supports_insert_button() {
    $is_post_edit_page = in_array( ATG_CURRENT_PAGE, array( 'post.php', 'page.php', 'page-new.php', 'post-new.php', 'customize.php' ) );

    return $is_post_edit_page;
  }

}