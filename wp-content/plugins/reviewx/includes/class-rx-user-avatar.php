<?php 

  class ReviewX_User_Avatar {
      
    public function __construct() {

      add_action( 'woocommerce_edit_account_form', [ $this,'rx_user_avatar_uploader' ] );
      add_action( 'woocommerce_save_account_details', [ $this,'rx_action_woocommerce_save_account_details' ], 10, 1 );
      add_filter( 'get_avatar', [ $this, 'rx_get_avatar_filter' ], 10, 5);
      add_filter( 'get_avatar_url', [ $this,'rx_get_avatar_url' ], 10, 3 );
      
    }

    /**
     * Image upload
     *
     * @param int
     * @return html
     */      
    public function rx_user_avatar_uploader() {
      
        $user_avatar = get_user_meta(get_current_user_id(), 'reviewx_user_avatar', true);
        $avatar_url  = wp_get_attachment_image_src($user_avatar, array(70,70));
        $avatar_url  = isset($avatar_url[0]) ? $avatar_url[0] : '';
        ?>
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

      <?php
    }

    /**
     * Save avatar id
     *
     * @param array
     * @return void
     */ 
    public function rx_action_woocommerce_save_account_details( $user_id ) {  
      if ( isset( $_POST['reviewx-user-avatar'] ) ) {
        update_user_meta( $user_id, 'reviewx_user_avatar', sanitize_text_field($_POST['reviewx-user-avatar']));
      }
    }

    public function rx_get_avatar_filter($avatar, $id_or_email="", $size="", $default="", $alt="") {
    
        global $avatar_default;
        // User has WPUA
    
        if( $alt == '' ) {
            $alt = apply_filters('rx_default_alt_tag',__("Avatar",'reviewx'));
        }
        
    
          $avatar = str_replace('gravatar_default','',$avatar);
        if(is_object($id_or_email)) {
          if(!empty($id_or_email->comment_author_email)) {
            $avatar = $this->rx_get_user_avatar($id_or_email, $size, $default, $alt);
          } else {
            $avatar = $this->rx_get_user_avatar('unknown@gravatar.com', $size, $default, $alt);
          }
        } else {
          if($this->rx_has_user_avatar($id_or_email)) {
            $avatar = $this->rx_get_user_avatar($id_or_email, $size, $default, $alt);
          // User has Gravatar and Gravatar is not disabled
          } elseif( $this->rx_has_gravatar($id_or_email)) {
            // find our src
            if(!empty($avatar)) {
              $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $avatar, $matches, PREG_SET_ORDER);
              $rx_avatar_image_src = !empty($matches) ? $matches [0] [1] : "";
              $default_image_details = $this->rx_default_image($size); 
              $rx_default_avatar_image_src = $default_image_details['src'];
              $rx_final_avatar_image_src = str_replace('d=reviewx_user_avatar', 'd='.urlencode($rx_default_avatar_image_src), $rx_avatar_image_src);
            }
    
            //$avatar = $avatar;
            $avatar = '<img src="'.$rx_final_avatar_image_src.'"'.$default_image_details['dimensions'].' alt="'.$alt.'" class="avatar avatar-'.$size.' rx-user-avatar rx-user-avatar-'.$size.' photo avatar-default" />';
    
          // User doesn't have WPUA or Gravatar and Default Avatar is wp_user_avatar, show custom Default Avatar
          } elseif($avatar_default == 'reviewx_user_avatar') {
    
            $default_image_details = $this->rx_default_image($size); 
            $avatar = '<img src="'.$default_image_details['src'].'"'.$default_image_details['dimensions'].' alt="'.$alt.'" class="avatar avatar-'.$size.' rx-user-avatar rx-user-avatar-'.$size.' photo avatar-default" />';
      
            return $avatar;            
          }
        }
        /**
         * Filter get_avatar filter
         * @since 1.9
         * @param string $avatar
         * @param int|string $id_or_email
         * @param int|string $size
         * @param string $default
         * @param string $alt
         */
        return apply_filters('rx_get_avatar_filter', $avatar, $id_or_email, $size, $default, $alt);
    
    }
    
    public function rx_get_avatar_url($url, $id_or_email, $args){

        //global $rx_disable_gravatar;
    
        $user_id=null;
        if(is_object($id_or_email)){
            if(!empty($id_or_email->comment_author_email)) {
              $user_id = $id_or_email->user_id;
            }
    
        }else{
          if ( is_email( $id_or_email ) ) {
            $user = get_user_by( 'email', $id_or_email );
            if($user){
              $user_id = $user->ID;
            }
          } else {
            $user_id = $id_or_email;
          }
        }
    
        // First checking custom avatar.
        if( $this->rx_has_user_avatar( $user_id ) ) {
    
          $url = $this->rx_get_user_avatar_src( $user_id );
    
        } else {
    
          $has_valid_url = $this->rx_has_gravatar($id_or_email);
          if(!$has_valid_url){
            $url = $this->rx_get_default_avatar_url($url, $id_or_email, $args);
          }
        
        }
        /**
         * Filter get_avatar_url filter
         * @since 4.1.9
         * @param string $url
         * @param int|string $id_or_email
         * @param array $args
         */
        return apply_filters( 'rx_get_avatar_filter_url', $url, $id_or_email);
        
    }
    
    public function rx_get_user_avatar($id_or_email="", $size='96', $align="", $alt="") {
        global $_wp_additional_image_sizes;
        $email='unknown@gravatar.com';
        // Checks if comment 
        
        if( $alt == '' ) {
            $alt = apply_filters('rx_default_alt_tag',__("Avatar",'reviewx'));
        }
    
        if(is_object($id_or_email)) {
          // Checks if comment author is registered user by user ID
          if($id_or_email->user_id != 0) {
            $email = $id_or_email->user_id;
          // Checks that comment author isn't anonymous
          } elseif(!empty($id_or_email->comment_author_email)) {
            // Checks if comment author is registered user by e-mail address
            $user = get_user_by('email', $id_or_email->comment_author_email);
            // Get registered user info from profile, otherwise e-mail address should be value
            $email = !empty($user) ? $user->ID : $id_or_email->comment_author_email;
          }
          $alt = $id_or_email->comment_author;
        } else {
          if(!empty($id_or_email)) {
            // Find user by ID or e-mail address
            $user = is_numeric($id_or_email) ? get_user_by('id', $id_or_email) : get_user_by('email', $id_or_email);
          } else {
            // Find author's name if id_or_email is empty
            $author_name = get_query_var('author_name');
            if(is_author()) {
              // On author page, get user by page slug
              $user = get_user_by('slug', $author_name);
            } else {
              // On post, get user by author meta
              $user_id = get_the_author_meta('ID');
              $user = get_user_by('id', $user_id);
            }
          }
          // Set user's ID and name
          if(!empty($user)) {
            $email = $user->ID;
            $alt = $user->display_name;
          }
        }
        // Checks if user has WPUA
        $rx_meta = get_the_author_meta('reviewx_user_avatar', $email);
        // Add alignment class
        $alignclass = !empty($align) && ($align == 'left' || $align == 'right' || $align == 'center') ? ' align'.$align : ' alignnone';
        // User has WPUA, check if on excluded list and bypass get_avatar
        if(!empty($rx_meta) && $this->rx_attachment_is_image($rx_meta)) {
          // Numeric size use size array
          $get_size = is_numeric($size) ? array($size,$size) : $size;
          // Get image src
          $rx_image = $this->rx_get_attachment_image_src($rx_meta, $get_size);
          // Add dimensions to img only if numeric size was specified
          $dimensions = is_numeric($size) ? ' width="'.$rx_image[1].'" height="'.$rx_image[2].'"' : "";
          // Construct the img tag
          $avatar = '<img src="'.$rx_image[0].'"'.$dimensions.' alt="'.$alt.'" class="avatar avatar-'.$size.' rx-user-avatar rx-user-avatar-'.$size.$alignclass.' photo" />';
        } else {
          // Check for custom image sizes
          if(in_array($size, array_merge(get_intermediate_image_sizes(), array('original')))) {
            if(in_array($size, array('original', 'large', 'medium', 'thumbnail'))) {
              $get_size = ($size == 'original') ? get_option('large_size_w') : get_option($size.'_size_w');
            } else {
              $get_size = $_wp_additional_image_sizes[$size]['width'];
            }
          } else {
            // Numeric sizes leave as-is
            $get_size = $size;
          }
          // User with no WPUA uses get_avatar
          $avatar = get_avatar($email, $get_size, $default="", $alt="");
          // Remove width and height for non-numeric sizes
          if(in_array($size, array('original', 'large', 'medium', 'thumbnail'))) {
            $avatar = preg_replace('/(width|height)=\"\d*\"\s/', "", $avatar);
            $avatar = preg_replace("/(width|height)=\'\d*\'\s/", "", $avatar);
          }
          $replace = array('rx-user-avatar ', 'rx-user-avatar-'.$get_size.' ', 'rx-user-avatar-'.$size.' ', 'avatar-'.$get_size, ' photo');
          $replacements = array("", "", "", 'avatar-'.$size, 'rx-user-avatar rx-user-avatar-'.$size.$alignclass.' photo');
          $avatar = str_replace($replace, $replacements, $avatar);
        }
        /**
         * Filter get_wp_user_avatar
         * @since 1.9
         * @param string $avatar
         * @param int|string $id_or_email
         * @param int|string $size
         * @param string $align
         * @param string $alt
         */
        return apply_filters('get_wp_user_avatar', $avatar, $id_or_email, $size, $align, $alt);
    }
    
    public function rx_has_gravatar($id_or_email="", $has_gravatar=0, $user="", $email="") {
        global $rx_hash_gravatar,$avatar_default;
        // User has WPUA
        //Decide if check gravatar required or not.
        if(trim($avatar_default)!='reviewx_user_avatar')
          return true;
        
        if(!is_object($id_or_email) && !empty($id_or_email)) {
          // Find user by ID or e-mail address
          $user = is_numeric($id_or_email) ? get_user_by('id', $id_or_email) : get_user_by('email', $id_or_email);
          // Get registered user e-mail address
          $email = !empty($user) ? $user->user_email : "";
        }
    
        if($email == ""){
    
          if(!is_numeric($id_or_email) and !is_object($id_or_email))
            $email = $id_or_email;
          elseif(!is_numeric($id_or_email) and is_object($id_or_email))
            $email = $id_or_email->comment_author_email;
        }
        if($email!="")
        {
          $hash = md5(strtolower(trim($email)));
          //check if gravatar exists for hashtag using options
          
          if(is_array($rx_hash_gravatar)){
            if ( array_key_exists($hash, $rx_hash_gravatar) and is_array($rx_hash_gravatar[$hash]) and array_key_exists(date('m-d-Y'), $rx_hash_gravatar[$hash]) )
            {
              return (bool) $rx_hash_gravatar[$hash][date('m-d-Y')];
            } 
          }
          
          //end
            if ( isset( $_SERVER['HTTPS'] ) && ( 'on' == $_SERVER['HTTPS'] || 1 == $_SERVER['HTTPS'] ) || isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' == $_SERVER['HTTP_X_FORWARDED_PROTO'] ) { 
            $http='https';
          }else{
            $http='http';
          }
          $gravatar = $http.'://www.gravatar.com/avatar/'.$hash.'?d=404';
          
          $data = wp_cache_get($hash);
    
          if(false === $data) {
            $response = wp_remote_head($gravatar);
            $data = is_wp_error($response) ? 'not200' : $response['response']['code'];
            
            wp_cache_set($hash, $data, $group="", $expire=60*5);
            //here set if hashtag has avatar
            $has_gravatar = ($data == '200') ? true : false;
            if($rx_hash_gravatar == false){
            $rx_hash_gravatar[$hash][date('m-d-Y')] = (bool)$has_gravatar;
            add_option('rx_hash_gravatar',serialize($rx_hash_gravatar));
          } else { 
    
            if(is_array($rx_hash_gravatar) && !empty($rx_hash_gravatar)){

              if (array_key_exists($hash, $rx_hash_gravatar)){

                  unset($rx_hash_gravatar[$hash]);
                  $rx_hash_gravatar[$hash][date('m-d-Y')] = (bool)$has_gravatar;
                  update_option('rx_hash_gravatar',serialize($rx_hash_gravatar));
              }
              else
              {
                $rx_hash_gravatar[$hash][date('m-d-Y')] = (bool)$has_gravatar;
                update_option('rx_hash_gravatar',serialize($rx_hash_gravatar));

              }

            }
            
          }
          //end
          }
          $has_gravatar = ($data == '200') ? true : false;
          
        }
        else
          $has_gravatar = false;
    
        // Check if Gravatar image returns 200 (OK) or 404 (Not Found)
        return (bool) $has_gravatar;
    }
    
    public function rx_has_user_avatar($id_or_email="", $has_wpua=0, $user="", $user_id="") {
      global $rx_avatar_default, $avatar_default;
      if(!is_object($id_or_email) && !empty($id_or_email)) {
        // Find user by ID or e-mail address
  
        $user = is_numeric($id_or_email) ? get_user_by('id', $id_or_email) : get_user_by('email', $id_or_email);
        // Get registered user ID
          $user_id = !empty($user) ? $user->ID : "";
      }
      $wpua = get_user_meta($user_id, 'reviewx_user_avatar', true);
      // Check if avatar is same as default avatar or on excluded list
      $has_wpua = !empty($wpua) && ($avatar_default!='reviewx_user_avatar' or $wpua != $rx_avatar_default) && $this->rx_attachment_is_image($wpua) ? true : false;
      return (bool) $has_wpua;
    }
    
    public function rx_default_image($size)
    {
      global $avatar_default, $mustache_admin, $mustache_avatar, $mustache_medium, $mustache_original, $mustache_thumbnail, $rx_avatar_default, $rx_disable_gravatar;
      
      $default_image_details = array();
      // Show custom Default Avatar
      if(!empty($rx_avatar_default) && $this->rx_attachment_is_image($rx_avatar_default)) {
        // Get image
        $rx_avatar_default_image = $this->rx_get_attachment_image_src($rx_avatar_default, array($size,$size));
        // Image src
        $default = $rx_avatar_default_image[0];
        // Add dimensions if numeric size
        $default_image_details['dimensions'] = ' width="'.$rx_avatar_default_image[1].'" height="'.$rx_avatar_default_image[2].'"';
      
      } else {
        // Get mustache image based on numeric size comparison
        if($size > get_option('medium_size_w')) {
          $default = $mustache_original;
        } elseif($size <= get_option('medium_size_w') && $size > get_option('thumbnail_size_w')) {
          $default = $mustache_medium;
        } elseif($size <= get_option('thumbnail_size_w') && $size > 96) {
          $default = $mustache_thumbnail;
        } elseif($size <= 96 && $size > 32) {
          $default = $mustache_avatar;
        } elseif($size <= 32) {
          $default = $mustache_admin;
        }
        // Add dimensions if numeric size
        $default_image_details['dimensions'] = ' width="'.$size.'" height="'.$size.'"';
      }
      // Construct the img tag
      $default_image_details['size'] = $size;
      $default_image_details['src'] = $default;
      return $default_image_details;

    }
    
    public function rx_get_default_avatar_url($url, $id_or_email, $args){

      global $avatar_default, $mustache_admin, $mustache_avatar, $mustache_medium, $mustache_original, $mustache_thumbnail, $post, $rx_avatar_default;
      
      $default_image_details = array();

      $size = !empty($args['size'])?$args['size']:96;
      
      //Show custom Default Avatar
      if(!empty($rx_avatar_default) && $this->rx_attachment_is_image($rx_avatar_default)) {
        // Get image
        $rx_avatar_default_image = $this->rx_get_attachment_image_src($rx_avatar_default, array($size,$size));
        // Image src
        $url = $rx_avatar_default_image[0];
        // Add dimensions if numeric size        
      } else {
        // Get mustache image based on numeric size comparison
        if($size > get_option('medium_size_w')) {
          $url = $mustache_original;
        } elseif($size <= get_option('medium_size_w') && $size > get_option('thumbnail_size_w')) {
          $url = $mustache_medium;
        } elseif($size <= get_option('thumbnail_size_w') && $size > 96) {
          $url = $mustache_thumbnail;
        } elseif($size <= 96 && $size > 32) {
          $url = $mustache_avatar;
        } elseif($size <= 32) {
          $url = $mustache_admin;
        }
        // Add dimensions if numeric size
      }

      return $url;
    }
    
    public function rx_get_user_avatar_src($id_or_email="", $size="", $align="") {
      $rx_image_src = "";
      // Gets the avatar img tag
      $rx_image = $this->rx_get_user_avatar($id_or_email, $size, $align);
      // Takes the img tag, extracts the src
      if(!empty($rx_image)) {
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $rx_image, $matches, PREG_SET_ORDER);
        $rx_image_src = !empty($matches) ? $matches [0] [1] : "";
      }
      return $rx_image_src;
    } 
    
    public function rx_attachment_is_image($attachment_id) {
      $is_image = wp_attachment_is_image($attachment_id);
      /**
       * Filter local image check
       * @since 1.9.2
       * @param bool $is_image
       * @param int $attachment_id
       */
      $is_image = apply_filters('rx_attachment_is_image', $is_image, $attachment_id);
      return (bool) $is_image;
    }

    public function rx_get_attachment_image_src($attachment_id, $size='thumbnail', $icon=0) {
      $image_src_array = wp_get_attachment_image_src($attachment_id, $size, $icon);
      /**
       * Filter local image src
       * @since 1.9.2
       * @param array $image_src_array
       * @param int $attachment_id
       * @param int|string $size
       * @param bool $icon
       */
      return apply_filters('rx_get_attachment_image_src', $image_src_array, $attachment_id, $size, $icon);
    }
      
  }

  /**
   * Initialize
   * @since 1.1.5
   */
  function rxua_functions_init() {
    global $rxua_functions;
    $rxua_functions = new ReviewX_User_Avatar();
  }
  add_action('plugins_loaded', 'rxua_functions_init');