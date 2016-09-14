<?php
if ( ! class_exists( 'ATGPB' ) ) {
  die();
}

/**
 * Class ATGPBSettings
 *
 * Includes common methods accessed throughout ATG Plugin Boilerplate.
 */
class ATGPBHelp {

  /**
   * Output
   */
  public static function help_page(){
    $title = 'Help';
    ATGPBCommon::page_header($title);
      echo 'Help text goes here...';
    ATGPBCommon::page_footer();
  }
}



