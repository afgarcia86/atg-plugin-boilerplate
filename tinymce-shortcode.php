<?php

if ( ! class_exists( 'ATGPB' ) ) {
  die();
}

/**
 * Class ATGPBShortcode
 *
 * Includes common methods accessed throughout ATG Plugin Boilerplate.
 */
class ATGPBShortcode {

  /**
   * Add a Short Code
   * [insert_button text="" link="" class="btn btn-primary"]
   */
  public static function insert_button_func( $atts ) {
    return '<a href="'.$atts["link"].'" class="'.$atts["class"].'">'.$atts["text"].'</a>';
  }

  /*** Start Wisiwig Button ***/
  /**
   * Set Up Button
   */
  public static function enqueue_plugin_scripts($plugin_array){
    $base_url = ATGPBCommon::get_base_url();
    //enqueue TinyMCE plugin script with its ID.
    $plugin_array["insert_button_plugin"] =  $base_url."/js/tinymce-shortcode.js";
    return $plugin_array;
  }  

  /**
   * Register Button
   */
  public static function register_buttons_editor($buttons){
    //register buttons with their id.
    array_push($buttons, 'insert_button');
    return $buttons;
  }
  /*** End Wisiwig Button ***/


  /*** Start Media Button ***/
  /**
   * Creates the "Insert Button" button.
   *
   * @access public
   * @static
   */
  public static function insert_button() {

    // display button matching new UI
    echo '<style>
            .atgpb_media_icon{
              background-position: center center;
              background-repeat: no-repeat;
              background-size: 16px auto;
              float: left;
              height: 16px;
              margin: 0;
              text-align: center;
              width: 16px;
              padding-top:10px;
              opacity: 0.5;
            }
            .atgpb_media_icon:before{
              color: #999;
              padding: 7px 0;
              transition: all 0.1s ease-in-out 0s;
            }
            .wp-core-ui a.atgpb_media_link{
              padding-left: 0.4em;
            }
          </style>
          <a href="#" class="button atgpb_media_link" id="add_atgpb" title="' . esc_attr__( 'Insert Button', 'atgpb' ) . '"><div class="atgpb_media_icon svg" style="background-image: url(\'' . ATGPB::get_admin_icon_b64()  . '\')"><br /></div><div style="padding-left: 20px;">' . esc_html__( 'Insert Button', 'atgpb' ) . '</div></a>';
  }

  /**
   * Displays the popup to insert a form to a post/page
   *
   * @access public
   * @static
   */
  public static function insert_shortcode() {
    $text = esc_attr( get_option( 'atgpb_default_button_text' ) );
    $class = esc_attr( get_option( 'atgpb_default_button_class' ) );
    ?>
    <script>
      (function($){
        $('#add_atgpb').click(function(){
          window.send_to_editor('[insert_button text="<?php echo $text; ?>" link="" class="<?php echo $class; ?>"]');
        });
      })(jQuery);
    </script>
  <?php
  }
  /*** End Media Button ***/

}