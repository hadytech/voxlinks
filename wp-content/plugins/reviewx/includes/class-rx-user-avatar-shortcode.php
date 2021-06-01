<?php
/**
 * Defines shortcodes.
 *
 * @package RX User Avatar
 * @version 1.1.12
 */

class RX_User_Avatar_Shortcode {
  /**
   * Constructor
   * @since 1.1.12
   * @uses add_action()
   * @uses add_shortcode()
   */
  public function __construct() {
    add_shortcode( 'rvx_user_avatar', [ $this, 'rx_user_avatar' ] );
    add_action( 'rx_avatar_update', [ $this, 'rx_action_process_option_update'] );
  }

  public function rx_user_avatar( $atts ) {

    global $current_user, $errors;
    // Shortcode only works for users with permission
    if( is_user_logged_in() ) {
      extract(shortcode_atts(array('user' => ""), $atts));
      
      // Default user is current user
      $valid_user = $current_user;
      
      // Find user by ID, login, slug, or e-mail address
      if(!empty($user)) {
        $get_user = is_numeric($user) ? get_user_by('id', $user) : get_user_by('login', $user);
        $get_user = empty($get_user) ? get_user_by('slug', $user) : $get_user;
        $get_user = empty($get_user) ? get_user_by('email', $user) : $get_user;
        // Check if current user can edit this user
        $valid_user = current_user_can('edit_user', $get_user) ? $get_user : null;
      }

      // Show form only for valid user
      if($valid_user) {
        
        // Save
        if( isset($_POST['submit']) && $_POST['submit'] && $_POST['rx_avatar_action'] == 'update' ) {
          do_action('rx_avatar_update', $valid_user->ID);
          //Check for errors
          $errors = $this->rx_edit_user($valid_user->ID);          
        }
        
        // Errors
        if( isset($errors) && is_wp_error($errors) ) {
          echo '<div class="error"><p>'.implode("</p>\n<p>", $errors->get_error_messages()).'</p></div>';
        } elseif( isset($_GET['rx-avatar-updated']) && $_GET['rx-avatar-updated'] == '1' ) {
          echo '<div class="updated"><p><strong>'.__('Profile updated.','reviewx').'</strong></p></div>';
        }
        // Edit form
        return $this->rx_avatar_form($valid_user);
      }
    }

  }

  private function rx_edit_user($user_id=0) {

    $update = $user_id ? true : false;
    $user = new stdClass;
    $errors = new WP_Error();
    do_action_ref_array('rx_update_errors', array(&$errors, $update, &$user));
    if($errors->get_error_codes()) {
      // Return with errors
      return $errors;
    }
    if($update) {
      // Redirect with updated variable
      $redirect_url = esc_url_raw(add_query_arg(array('rx-avatar-updated' => '1'), wp_get_referer()));
      wp_safe_redirect($redirect_url);
    }

  }
  
  private function rx_avatar_form($user) {
    ob_start();
    $user_avatar = get_user_meta(get_current_user_id(), 'reviewx_user_avatar', true);
    $avatar_url  = wp_get_attachment_image_src($user_avatar, array(70,70));
    $avatar_url  = isset($avatar_url[0]) ? $avatar_url[0] : '';
    require_once(ABSPATH.'wp-admin/includes/template.php');
  ?>
    <form id="rx-edit-<?php echo $user->ID; ?>" action="" method="post" enctype="multipart/form-data">
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="image" class="rx-profile-image"><?php esc_html_e( 'Profile Image', 'reviewx' ); ?>&nbsp;</label>
            <div class="rx-media-field-wrapper">
              <div class="rx-thumb-container rx-shop-icon-display-area <?php echo $avatar_url == '' ? '' : 'rx-has-thumb'; ?>"> 
                  <?php 
                    if( $avatar_url ) {
                      echo '<img src="'. esc_url( $avatar_url ) .'">';
                    }
                  ?>                                                 
                  <a href="javascript:void(0);" class="rx-media-remove-button" title="<?php echo __( 'Remove Image', 'reviewx' ); ?>">
                    <svg style="width: 15px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" class="svg-inline--fa fa-times-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path></svg>
                  </a>
              </div>
              <div class="rx-media-content">
                  <input class="rx-media-id" type="hidden" name="reviewx-user-avatar" value="<?php echo $user_avatar; ?>">        
              </div>                                        
              <div class="rx-shop-icon-upload-area rx-media-upload-button <?php echo esc_attr( $avatar_url ) == '' ? '' : 'rx-media-uploader-hidden'; ?>">
                  <div class="rx-media-button">
                      <label class="rx_upload_file rx-form-btn">
                          <img src="<?php echo esc_url( assets('storefront/images/image.svg') ); ?>" class="img-fluid">
                          <span><?php echo __( 'Upload image', 'reviewx' ); ?></span>
                      </label>
                  </div>
              </div>                
            </div>                
        </p>
      <input type="hidden" name="rx_avatar_action" value="update" />
      <input type="hidden" nwpua_edit_userame="user_id" id="user_id" value="<?php echo esc_attr($user->ID); ?>" />
      <?php wp_nonce_field('update-user_'.$user->ID); ?>
      <?php if( isset($_GET['rx-avatar-updated']) && $_GET['rx-avatar-updated'] ) { ?>
        <p class="rx-avatar-upload-success"><?php echo __( 'Profile image updated successfully','reviewx' );?></p>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('.rx-avatar-upload-success').fadeOut(1000,function(){
                    window.location.href = "<?php echo get_permalink(); ?>"
                });
            });
        </script>    
      <?php } ?>
      <?php submit_button(__('Update Profile','reviewx') ); ?>
    </form>
  <?php
    return ob_get_clean();
  }
  
  public function rx_action_process_option_update($user_id) {
    // Check if user has publish_posts capability
    if( is_user_logged_in() ) {
      $rx_avatar_id = isset($_POST['reviewx-user-avatar']) ? strip_tags($_POST['reviewx-user-avatar']) : "";
      // Update usermeta
      update_user_meta($user_id, 'reviewx_user_avatar', sanitize_text_field($rx_avatar_id) );
    } 

  }

}

/**
 * Initialize
 * @since 1.1.12
 */
function rx_shortcode_init() {
  new RX_User_Avatar_Shortcode();
  // Clean output
  ob_start();
}
add_action('init', 'rx_shortcode_init');