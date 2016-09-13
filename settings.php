<?php
if ( ! class_exists( 'ATGPB' ) ) {
  die();
}

add_action( 'admin_init', array( 'ATGPBSettings', 'register_settings_fields' ) );

/**
 * Class ATGPBSettings
 *
 * Includes common methods accessed throughout Gravity Forms and add-ons.
 */
class ATGPBSettings {

  /**
   * Output
   */
  public static function settings_page(){
    if ( ! isset( $_REQUEST['settings-updated'] ) ) $_REQUEST['settings-updated'] = false;
    $title = 'ATG Plugin Boilerplate Settings';
    $message = false !== $_REQUEST['settings-updated'] ?  __( 'Settings saved.', 'atgbp'  ) : '';
    ATGPBCommon::page_header($title, $message);
      ATGPBCommon::form_header();
        settings_fields( 'atgbp_settings' );
        do_settings_sections( 'atgbp_settings' );
      ATGPBCommon::form_footer();
    ATGPBCommon::page_footer();
  }

  /*
   * Add all your sections, fields and settings during admin_init
   */
   public function register_settings_fields() {
    // Add the section to atgbp_settings settings so we can add our fields to it
    add_settings_section(
      'atgpb_setting_section',
      'Example settings section in atgbp_settings',
      array( 'ATGPBSettings', 'atgpb_section_callback'),
      'atgbp_settings'
    );
     
    // Add the field with the names and function to use for our new settings, put it in our new section
    add_settings_field(
      'atgpb_default_button_label',
      'Default Button Label',
      array( 'ATGPBSettings', 'atgpb_default_button_label_callback'),
      'atgbp_settings',
      'atgpb_setting_section'
    );

    add_settings_field(
      'atgpb_default_button_class',
      'Default Button Class',
      array( 'ATGPBSettings', 'atgpb_default_button_class_callback'),
      'atgbp_settings',
      'atgpb_setting_section'
    );
     
    // Register our setting in the "atgbp_settings" settings section
    register_setting( 'atgbp_settings', 'atgpb_default_button_label' );
    register_setting( 'atgbp_settings', 'atgpb_default_button_text' );
  }

  /*
   * Settings section callback function
   */ 
  public function atgpb_section_callback() {
    echo '<p>Intro text for our settings section</p>';
  }
   
  /*
   * Callback function for our example setting
   */ 
  public function atgpb_default_button_label_callback() {
    $setting = esc_attr( get_option( 'atgpb_default_button_label' ) );
    echo "<input type='text' name='atgpb_default_button_label' value='$setting' />";
  }

  /*
   * Callback function for our example setting
   */ 
  public function atgpb_default_button_class_callback() {
    $setting = esc_attr( get_option( 'atgpb_default_button_text' ) );
    echo "<input type='text' name='atgpb_default_button_text' value='$setting' />";
  }

}



