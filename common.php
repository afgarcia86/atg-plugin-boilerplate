<?php

if ( ! class_exists( 'ATGPB' ) ) {
  die();
}

/**
 * Class GFCommon
 *
 * Includes common methods accessed throughout Gravity Forms and add-ons.
 */
class ATGPBCommon {

  //Returns the url of the plugin's root folder
  public static function get_base_url() {
    return plugins_url( '', __FILE__ );
  }

  //Returns the physical path of the plugin's root folder
  public static function get_base_path() {
    return dirname( __FILE__ );
  }

  /**
   * Outputs the page header
   *
   * @access public
   * @static
   *
   * @param string $title   Optional. The page title to be used. Defaults to an empty string.
   * @param string $message Optional. The message to display in the header. Defaults to empty string.
   */
  public static function page_header( $title = '', $message = '' ) { ?>
    <div class="wrap">
      <?php if ( $message ) { ?>
        <div id="message" class="updated fade"><p><strong><?php echo $message; ?></strong></p></div>
      <?php } ?>
      <h1><?php echo esc_html( $title ) ?></h1>

  <?php
  }

  /**
   * Outputs the page footer
   *
   * @access public
   * @static
   */
  public static function page_footer() { ?>
      <br class="clear" style="clear: both;" />
    </div> <!-- / wrap -->
  <?php
  }


  /**
   * Outputs the options form header
   *
   * @access public
   * @static
   */
  public static function form_header() { ?>
    <form method="post" action="options.php"> 

  <?php
  }

  /**
   * Outputs the options form footer
   *
   * @access public
   * @static
   */
  public static function form_footer() { ?>
      <?php submit_button(); ?>
    </form> <!-- / form -->
  <?php
  }

}