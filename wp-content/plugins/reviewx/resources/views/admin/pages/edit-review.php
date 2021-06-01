<?php
   /**
    * Edit comment form for inclusion in another file.
    *
    * @package WordPress
    * @subpackage Administration
    */
   
   // Don't load directly.
   if ( ! defined( 'ABSPATH' ) ) {
   	die( '-1' );
   }

   global $action;
   $action = 'editreview';

   $title = __( 'Edit Review', 'reviewx' );
   
   wp_enqueue_script( 'comment' );
   require_once ABSPATH . 'wp-admin/admin-header.php';
   
   $comment_id = absint( $_GET['c'] );
   
   $comment = get_comment( $comment_id );

   if ( ! $comment ) {
       comment_footer_die( esc_html__( 'Invalid comment ID.', 'reviewx' ) . sprintf( ' <a href="%s">' . __( 'Go back', 'reviewx' ) . '</a>.', 'javascript:history.go(-1)' ) );
   }
   
   if ( ! current_user_can( 'edit_comment', $comment_id ) ) {
       comment_footer_die( esc_html__( 'Sorry, you are not allowed to edit this comment.', 'reviewx' ) );
   }
   
   if ( 'trash' == $comment->comment_approved ) {
       comment_footer_die( esc_html__( 'This comment is in the Trash. Please move it out of the Trash if you want to edit it.', 'reviewx' ) );
   }
   $external_video_url          = $self_hosted_video_url = '';   
   $comment                     = get_comment_to_edit( $comment_id );
   $comment_gallery             = get_comment_meta( $comment_id, 'reviewx_attachments', true ); 
   $comment_rating              = get_comment_meta( $comment_id, 'rating', true ); 
   $comment_reviewx_title       = get_comment_meta( $comment_id, 'reviewx_title', true );
   $comment_reviewx_rating      = get_comment_meta( $comment_id, 'reviewx_rating', true );
   $comment_video_url           = get_comment_meta( $comment_id, 'reviewx_video_url', true );
   $comment_parent              = get_comment_meta( $comment_id, 'comment_parent', true );
   $video_source                = get_comment_meta( $comment_id, 'reviewx_video_source_control', true );  
   $recommended                 = get_comment_meta( $comment_id, 'reviewx_recommended', true ); 
   if( !$video_source ) {
      $video_source             = 'self';
   }
   ?>
<form name="post" action="comment.php" method="post" id="post">
   <?php wp_nonce_field( 'update-comment_' . $comment->comment_ID ); ?>
   <div class="wrap">
      <h1><?php echo __( 'Edit Comment', 'reviewx' ); ?></h1>
      <div id="poststuff">
         <input type="hidden" name="action" value="editedcomment" />
         <input type="hidden" name="comment_ID" value="<?php echo esc_attr( $comment->comment_ID ); ?>" />
         <input type="hidden" name="comment_post_ID" value="<?php echo esc_attr( $comment->comment_post_ID ); ?>" />
         <div id="post-body" class="metabox-holder columns-2">
            <div id="post-body-content" class="edit-form-section edit-comment-section">
               <?php
                  if ( 'approved' === wp_get_comment_status( $comment ) && $comment->comment_post_ID > 0 ) :
                      $comment_link = get_comment_link( $comment );
                      ?>
               <div class="inside">
                  <div id="comment-link-box">
                     <strong><?php _ex( 'Permalink:', 'reviewx' ); ?></strong>
                     <span id="sample-permalink">
                     <a href="<?php echo esc_url( $comment_link ); ?>">
                        <?php echo esc_html( $comment_link ); ?>
                     </a>
                     </span>
                  </div>
               </div>
               <?php endif; ?>
               <div id="namediv" class="stuffbox">
                  <div class="inside">
                     <h2 class="edit-comment-author"><?php echo __( 'Author', 'reviewx' ); ?></h2>
                     <fieldset>
                        <legend class="screen-reader-text"><?php echo __( 'Comment Author', 'reviewx' ); ?></legend>
                        <table class="form-table editcomment" role="presentation">
                           <tbody>
                              <tr>
                                 <td class="first"><label for="name"><?php echo __( 'Name', 'reviewx' ); ?></label></td>
                                 <td><input type="text" name="newcomment_author" size="30" value="<?php echo esc_attr( $comment->comment_author ); ?>" id="name" /></td>
                              </tr>
                              <tr>
                                 <td class="first"><label for="email"><?php echo __( 'Email', 'reviewx' ); ?></label></td>
                                 <td>
                                    <input type="text" name="newcomment_author_email" size="30" value="<?php echo esc_attr( $comment->comment_author_email ); ?>" id="email" />
                                 </td>
                              </tr>
                              <tr>
                                 <td class="first"><label for="newcomment_author_url"><?php echo __( 'URL', 'reviewx' ); ?></label></td>
                                 <td>
                                    <input type="text" id="newcomment_author_url" name="newcomment_author_url" size="30" class="code" value="<?php echo esc_url( $comment->comment_author_url ); ?>" />
                                 </td>
                              </tr>
                              <tr>
                                 <td class="first"><label for="newcomment_review_title"><?php echo __( 'Review Title', 'reviewx' ); ?></label></td>
                                 <td>
                                    <input type="text" id="newcomment_review_title" name="newcomment_review_title" size="30" class="code" value="<?php echo esc_attr( $comment_reviewx_title ); ?>" />
                                 </td>
                              </tr>                              
                           </tbody>
                        </table>
                     </fieldset>
                  </div>
               </div>
               <div id="postdiv" class="postarea">
                  <?php
                     echo '<label for="content" class="screen-reader-text">' . __( 'Comment', 'reviewx' ) . '</label>';
                     $quicktags_settings = array( 'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,close' );
                     wp_editor(
                        $comment->comment_content,
                        'content',
                        array(
                           'media_buttons' => true,
                           'tinymce'       => true,
                           'quicktags'     => $quicktags_settings,
                        )
                     );
                     wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
                     ?>
               </div>

               <?php 
                  /**********************
                   * Check this is a customer review. Not admin reply 
                   * 
                   */
                  if( $comment->comment_parent == 0 ): 
               ?>

               <!-- /review recommendation -->
               <div class="stuffbox rx_editreview_image">
                  <div class="inside">
                     <h2 class="edit-review-image"><?php echo __( 'Recommendation', 'reviewx' ); ?> 
                        <?php if( !class_exists('ReviewXPro') ) { ?>
                        <sup class="rx-pro-label"><?php echo __( 'Pro', 'reviewx' ); ?></sup>                        
                        <?php } ?>
                     </h2>
                  </div>
                  <div class="rx-review-image-section misc-pub-section">
                     <div class="rviwx-rating-column">
                        <div class="rviwx-rating-column__desc">
                           <div class="reviewx_recommended">                             
                              <ul class="reviewx_recommended_list">
                                 <li class="reviewx_radio">
                                    <input id="recommend" name="admin_edit_is_recommended" value="1" type="radio" <?php if( $recommended==1 ) { echo 'checked="checked"'; } ?>>
                                    <label for="recommend" class="radio-label happy_face">
                                       <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                viewBox="0 0 80 80" style="enable-background:new 0 0 80 80;" xml:space="preserve">
                                                <style type="text/css">
                                                   .happy_st0{fill:#D0D6DC;}
                                                   .happy_st1{fill:#6d6d6d;}
                                                </style>
                                          <g>
                                                <radialGradient id="SVGID_1_" cx="40" cy="40" r="40" gradientUnits="userSpaceOnUse">
                                                   <stop  offset="0" style="stop-color:#62E2FF"/>
                                                   <stop  offset="0.9581" style="stop-color:#3593FF"/>
                                                </radialGradient>
                                                <path class="happy_st0 rx_happy" d="M40,0C18,0,0,18,0,40c0,22,18,40,40,40s40-18,40-40C80,18,62,0,40,0z M54,24c3.2,0,6,2.8,6,6c0,3.2-2.8,6-6,6
                                                   c-3.2,0-6-2.8-6-6C48,26.8,50.8,24,54,24z M26,24c3.2,0,6,2.8,6,6c0,3.2-2.8,6-6,6c-3.2,0-6-2.8-6-6C20,26.8,22.8,24,26,24z M40,64
                                                   c-10.4,0-19.2-6.8-22.4-16h44.8C59.2,57.2,50.4,64,40,64z"/>
                                                <path class="happy_st1" d="M54,36c3.2,0,6-2.8,6-6c0-3.2-2.8-6-6-6c-3.2,0-6,2.8-6,6C48,33.2,50.8,36,54,36z"/>
                                                <path class="happy_st1" d="M26,36c3.2,0,6-2.8,6-6c0-3.2-2.8-6-6-6c-3.2,0-6,2.8-6,6C20,33.2,22.8,36,26,36z"/>
                                                <path class="happy_st1" d="M40,64c10.4,0,19.2-6.8,22.4-16H17.6C20.8,57.2,29.6,64,40,64z"/>
                                          </g>
                                          </svg>
                                    </label>
                                 </li>
                                 <li class="reviewx_radio">
                                    <input id="neutral" name="admin_edit_is_recommended" value="0" type="radio" <?php if( $recommended==0 ) { echo 'checked="checked"'; } ?>>
                                    <label for="neutral" class="radio-label neutral_face">
                                       <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                viewBox="0 0 80 80" style="enable-background:new 0 0 80 80;" xml:space="preserve">
                                                <style type="text/css">
                                                   .st0{fill:#6D6D6D;}
                                                   .st1{fill:#D1D7DD;}
                                                </style>
                                          <g>
                                                <path class="st0" d="M54,36c3.2,0,6-2.8,6-6c0-3.2-2.8-6-6-6c-3.2,0-6,2.8-6,6C48,33.2,50.8,36,54,36z"/>
                                                <path class="st0" d="M26,36c3.2,0,6-2.8,6-6c0-3.2-2.8-6-6-6c-3.2,0-6,2.8-6,6C20,33.2,22.8,36,26,36z"/>
                                                <path class="st1" d="M40,0C18,0,0,18,0,40c0,22,18,40,40,40s40-18,40-40C80,18,62,0,40,0z M54,24c3.2,0,6,2.8,6,6c0,3.2-2.8,6-6,6
                                                   c-3.2,0-6-2.8-6-6C48,26.8,50.8,24,54,24z M26,24c3.2,0,6,2.8,6,6c0,3.2-2.8,6-6,6c-3.2,0-6-2.8-6-6C20,26.8,22.8,24,26,24z"/>
                                                <path class="st0" d="M58.4,57.3H21.6c-0.5,0-0.9-0.4-0.9-0.9v-7.1c0-0.5,0.4-0.9,0.9-0.9h36.8c0.5,0,0.9,0.4,0.9,0.9v7.1
                                                   C59.3,56.9,58.9,57.3,58.4,57.3z"/>
                                          </g>
                                          </svg>
                                    </label>
                                 </li>
                                 <li class="reviewx_radio">
                                    <input id="not_recommend" name="admin_edit_is_recommended" value="" type="radio" <?php if( $recommended=='' ) { echo 'checked="checked"'; } ?>>
                                    <label for="not_recommend" class="radio-label sad_face">
                                       <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                viewBox="0 0 80 80" style="enable-background:new 0 0 80 80;" xml:space="preserve">
                                                <style type="text/css">
                                                   .st0{fill:#6D6D6D;}
                                                   .st1{fill:#D1D7DD;}
                                                </style>
                                          <g>
                                                <path class="st0" d="M54,36c3.2,0,6-2.8,6-6c0-3.2-2.8-6-6-6c-3.2,0-6,2.8-6,6C48,33.2,50.8,36,54,36z"/>
                                                <path class="st0" d="M26,36c3.2,0,6-2.8,6-6c0-3.2-2.8-6-6-6c-3.2,0-6,2.8-6,6C20,33.2,22.8,36,26,36z"/>
                                                <path class="st1" d="M40,0C18,0,0,18,0,40c0,22,18,40,40,40s40-18,40-40C80,18,62,0,40,0z M54,24c3.2,0,6,2.8,6,6c0,3.2-2.8,6-6,6
                                                   c-3.2,0-6-2.8-6-6C48,26.8,50.8,24,54,24z M26,24c3.2,0,6,2.8,6,6c0,3.2-2.8,6-6,6c-3.2,0-6-2.8-6-6C20,26.8,22.8,24,26,24z"/>
                                                <path class="st0" d="M40,42.8c-9.5,0-17.5,6.2-20.4,14.6h40.8C57.5,49,49.5,42.8,40,42.8z"/>
                                          </g>
                                          </svg>
                                    </label>
                                 </li>
                              </ul>
                           </div>                              
                        </div>
                     </div>
                  </div>
               </div>
               <!-- /end review recommendation -->               

               <!-- /review criteria -->
               <div class="stuffbox rx_editreview_image">
                  <div class="inside">
                     <h2 class="edit-review-image"><?php echo __( 'Rating Criteria', 'reviewx' ); ?> 
                        <?php if( !class_exists('ReviewXPro') ) { ?>
                        <sup class="rx-pro-label"><?php echo __( 'Pro', 'reviewx' ); ?></sup>                        
                        <?php } ?>
                     </h2>                     
                  </div>
                  <div class="rx-review-image-section misc-pub-section">
                     <div class="rviwx-rating-column">
                        <div class="rviwx-rating-column__desc">
                           <?php 
                           
                           if( \ReviewX_Helper::check_post_type_availability( get_post_type($comment->comment_post_ID) ) == TRUE ) {
                              $reviewx_id     = \ReviewX_Helper::get_reviewx_post_type_id( get_post_type($comment->comment_post_ID) );
                              $reviewCriteria = \ReviewX_Helper::get_post_meta( $reviewx_id, 'review_criteria', true );
                           } else {
                              $reviewCriteria = \ReviewX_Helper::get_option( 'review_criteria' );
                           }
                           
                           if( ! empty( $comment_reviewx_rating ) ) {
                              if( \ReviewX_Helper::is_multi_criteria( get_post_type($comment->comment_post_ID) ) ) {
                                 foreach($reviewCriteria as $criteriaId => $label) {
                                    if( isset($comment_reviewx_rating[$criteriaId]) ) {
                              ?>
                                 <div class="rviwx-rating-column__item">
                                    <div class="rviwx-rating-column__item-label"><?php echo esc_html(str_replace('-', ' ', $label)); ?></div>
                                    <div class="rviwx-rating-column__item-value">
                                       <input class="rviwx-rating-column__item-value rviwx-rating-column__item-field" name="<?php echo esc_attr( $criteriaId ); ?>" type="text" value="<?php echo esc_attr($comment_reviewx_rating[$criteriaId]); ?>">
                                       <svg style="width: 10px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" class="svg-inline--fa fa-star fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                          <path style="fill: #FFAF22" fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path>
                                       </svg>
                                    </div>
                                 </div>
                              <?php
                                    }
                                 }
                              } else {
                                 ?>
                                 <div class="rviwx-rating-column__item">
                                    <div class="rviwx-rating-column__item-label"><?php echo  __('Rating', 'reviewx'); ?></div>
                                    <div class="rviwx-rating-column__item-value">
                                       <input class="rviwx-rating-column__item-value rviwx-rating-column__item-field" name="rx-default-star-rating" type="number" min="1" max="5" step="1" value="<?php echo esc_attr($comment_rating); ?>">
                                       <svg style="width: 10px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" class="svg-inline--fa fa-star fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                          <path style="fill: #FFAF22" fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path>
                                       </svg>
                                    </div>
                                 </div>
                              <?php
                              }
                           } else {
                              ?>
                              <div class="rx-no-review-message">
                                 <p><?php echo esc_html__('Review criteria not applicable','reviewx'); ?></p>
                              </div>
                              <?php
                           }
                           ?>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- /end review-criteria -->

               <!-- /review images -->
               <div class="stuffbox rx_editreview_image">
                  <div class="inside">
                     <h2 class="edit-review-image"><?php echo __( 'Highlight Review', 'reviewx' ); ?> 
                     <?php if( !class_exists('ReviewXPro') ){ ?>
                        <sup class="rx-pro-label"><?php echo __( 'Pro', 'reviewx' ); ?></sup>                        
                     <?php } ?>
                     </h2>
                  </div>
                  <div class="rx-review-image-section misc-pub-section">
                     <label class="rx_highlight_switch">
                        <?php if( class_exists('ReviewXPro') ) { 
                           echo apply_filters( 'rx_admin_highlight_comment', $comment_id );
                        } else { ?>
                           <input type="checkbox" disabled class="reviewx_highlight_switcher">
                           <span class="slider round"></span>
                        <?php } ?>       
                     </label>
                  </div>
               </div>
               <!-- /end review images -->

               <!-- /review video upload -->
               <div class="stuffbox rx_editreview_image">
                  <div class="inside">
                     <h2 class="edit-review-image"><?php echo __( 'Review Attachments', 'reviewx' ); ?> 
                     <?php if( !class_exists('ReviewXPro') ){ ?>
                        <sup class="rx-pro-label"><?php echo __( 'Pro', 'reviewx' ); ?></sup>                        
                     <?php } ?>                     
                     </h2>
                  </div>
                  <div class="rx-review-image-section misc-pub-section">                     
                     <div class="rx_flex rx_edit_review_photos">
                        <?php	
                           if( ! empty( $comment_gallery ) ) {				
                              foreach ( $comment_gallery as $comment_gallery_id ) {
                                 if( is_array( $comment_gallery_id ) ) {
                                    foreach ( $comment_gallery_id as $comment_gallery_id_val ) {
                                       $img_url 		= wp_get_attachment_image_src( $comment_gallery_id_val );
                                       $full_img_url 	= wp_get_attachment_image_src( $comment_gallery_id_val, 'full' );
                                       ?>
                                          <div class="rx_photo">
                                             <div class="popup-link">
                                                <a href="<?php echo esc_url( $full_img_url[0] ); ?>">
                                                   <img src="<?php echo esc_url( $img_url[0] ); ?>" class="img-fluid" alt="<?php echo esc_attr__('ReviewX', 'reviewx'); ?>">
                                                </a>
                                             </div>
                                             <div class="rx_remove_images">
                                                <a href="javascript:void(0);" class="rx_admin_remove_image">
                                                   <svg style="width: 15px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" class="svg-inline--fa fa-times-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path style="fill: #d21212" fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path></svg>
                                                </a>
                                             </div>
                                             <input type="hidden" name="rx-image[]" class="rx-image" value="<?php echo esc_attr($comment_gallery_id_val);?>">                                                        
                                          </div>												
                                       <?php
                                    }
                                 }
                              }
                           }
                        ?>                        
                        <p class="rx-comment-form-attachment">
                           <label class="rx_upload_file rx-form-btn">
                              <input id="rx-admin-upload-photo" name="rx-admin-upload-photo" type="button" data-multiple="multiple">
                              <img src="<?php echo esc_url( plugins_url('/', __FILE__) . '../../assets/images/image.svg' ) ?>" class="img-fluid" alt="<?php echo esc_attr__('ReviewX', 'reviewx' ); ?>">
                              <span><?php echo __('Upload images', 'reviewx'); ?></span>
                           </label>
                        </p>                                
                     </div>                     
                  </div>
                  <div class="rx-review-image-section misc-pub-section">
                     <div class="rx_flex rx_edit_review_video">
                        <div class="rx-edit-review-video-source-controller">                           
                           <select id="rx-edit-video-source-control" name="rx_admin_edit_video_source_control" class="rx-edit-video-source-control">
                              <option value="self" <?php selected('self', $video_source); ?>><?php echo __('Upload File', 'reviewx'); ?></option>
                              <option value="external" <?php selected('external', $video_source); ?>><?php echo __('External Link', 'reviewx'); ?></option>
                           </select>
                        </div>  

                        <div class="rx-edit-review-video-external" style="<?php if( $video_source == 'external' ){ echo 'display:block'; }?>">
                           <?php 
                              if( $video_source == 'external' ){
                                 $external_video_url = $comment_video_url;
                              }
                           ?>
                           <input type="text" name="rx_admin_edit_review_video_url" id="rx-set-edit-video-url" class="rx-set-edit-video-url" placeholder="<?php echo __('Video URL', 'reviewx'); ?>" title="" value="<?php echo esc_url($external_video_url); ?>">
                        </div>

                        <div class="rx-edit-review-video-self" style="<?php if( $video_source == 'self' && !empty($comment_video_url) ){ echo 'display:block'; }?>">
                           <?php 
                              if( $video_source == 'self' ){
                                 $self_hosted_video_url = $comment_video_url;
                              }
                           ?>                        
                           <video controls="" id="rx-edit-review-video-self-player" width="200" src="<?php echo esc_url($self_hosted_video_url); ?>"></video>
                        </div>                        
                        
                        <p class="rx-comment-form-attachment rx-edit-review-video-uploader" style="<?php if( $video_source == 'self' ){ echo 'display:block'; }?>">
                           <label class="rx_upload_file rx-form-btn">
                              <input type="hidden" name="rx_admin_edit_review_video_url_self" id="rx_admin_edit_review_video_url_self">
                              <input id="rx-admin-upload-video" name="rx-admin-upload-video" type="button">
                              <img src="<?php echo esc_url( plugins_url('/', __FILE__) . '../../assets/images/image.svg' ) ?>" class="img-fluid" alt="<?php echo esc_attr__('ReviewX', 'reviewx' ); ?>">
                              <span><?php echo __('Upload a video', 'reviewx'); ?></span>
                           </label>
                        </p>                                                                               
                     </div>                    
                  </div>                  
               </div>
               <!-- /end review video upload -->  
               
               <?php 
                  /**********************
                   * End review meta
                   * 
                   */
                  endif; 
               ?>
               <input type="hidden" name="rx-edit-review-nonce" id="rx-edit-review-nonce" value="<?php echo wp_create_nonce( "special-string" ); ?>">
            </div>

            <!-- /post-body-content -->
            <div id="postbox-container-1" class="postbox-container">
               <div id="submitdiv" class="stuffbox" >
                  <h2><?php esc_html_e( 'Save', 'reviewx' ); ?></h2>
                  <div class="inside">
                     <div class="submitbox" id="submitcomment">
                        <div id="minor-publishing">
                           <div id="misc-publishing-actions">
                              <div class="misc-pub-section misc-pub-comment-status" id="comment-status">
                                 <?php _e( 'Status:', 'reviewx' ); ?>
                                 <span id="comment-status-display">
                                 <?php
                                    switch ( $comment->comment_approved ) {
                                        case '1':
                                          esc_html_e( 'Approved', 'reviewx' );
                                            break;
                                        case '0':
                                          esc_html_e( 'Pending', 'reviewx' );
                                            break;
                                        case 'spam':
                                          esc_html_e( 'Spam', 'reviewx' );
                                            break;
                                    }
                                    ?>
                                 </span>
                                 <fieldset id="comment-status-radio">
                                    <legend class="screen-reader-text"><?php esc_html_e( 'Comment status', 'reviewx' ); ?></legend>
                                    <label><input type="radio"<?php checked( $comment->comment_approved, '1' ); ?> name="comment_status" value="1" /><?php _ex( 'Approved', 'comment status', 'reviewx' ); ?></label><br />
                                    <label><input type="radio"<?php checked( $comment->comment_approved, '0' ); ?> name="comment_status" value="0" /><?php _ex( 'Pending', 'comment status', 'reviewx' ); ?></label><br />
                                    <label><input type="radio"<?php checked( $comment->comment_approved, 'spam' ); ?> name="comment_status" value="spam" /><?php _ex( 'Spam', 'comment status', 'reviewx' ); ?></label>
                                 </fieldset>
                              </div>
                              <!-- .misc-pub-section -->
                              <div class="misc-pub-section curtime misc-pub-curtime">
                                 <?php
                                    $submitted = sprintf(
                                    	/* translators: 1: Comment date, 2: Comment time. */
                                    	__( '%1$s at %2$s', 'reviewx' ),
                                    	/* translators: Publish box date format, see https://www.php.net/date */
                                    	date_i18n( _x( 'M j, Y', 'publish box date format', 'reviewx' ), strtotime( $comment->comment_date ) ),
                                    	/* translators: Publish box time format, see https://www.php.net/date */
                                    	date_i18n( _x( 'H:i', 'publish box time format', 'reviewx' ), strtotime( $comment->comment_date ) )
                                    );
                                   // echo $comment->comment_date; 
                                    ?>
                                 <span id="timestamp">
                                 <?php
                                    /* translators: %s: Comment date. */
                                    printf( __( 'Submitted on: %s', 'reviewx' ), '<b>' . $submitted . '</b>' );
                                    ?>
                                 </span>
                                 <a href="#edit_timestamp" class="edit-timestamp hide-if-no-js">
                                    <span aria-hidden="true"><?php esc_html_e( 'Edit', 'reviewx' ); ?></span> 
                                    <span class="screen-reader-text"><?php _e( 'Edit date and time' ); ?></span>
                                 </a>
                                 <fieldset id='timestampdiv' class='hide-if-js'>
                                    <legend class="screen-reader-text"><?php esc_html_e( 'Date and time', 'reviewx' ); ?></legend>
                                    <?php isset($action) ? rx_touch_time( ( 'editreview' === $action ), 0, 0, 0, $comment->comment_date ) : ''; ?>
                                 </fieldset>
                              </div>
                              <?php
                                 $post_id = $comment->comment_post_ID;
                                 if ( current_user_can( 'edit_post', $post_id ) ) {
                                 	$post_link  = "<a href='" . esc_url( get_edit_post_link( $post_id ) ) . "'>";
                                 	$post_link .= esc_html( get_the_title( $post_id ) ) . '</a>';
                                 } else {
                                 	$post_link = esc_html( get_the_title( $post_id ) );
                                 }
                                 ?>
                              <div class="misc-pub-section misc-pub-response-to">
                                 <?php
                                    printf(
                                    	/* translators: %s: Post link. */
                                    	__( 'In response to: %s', 'reviewx' ),
                                    	'<b>' . $post_link . '</b>'
                                    );
                                    ?>
                              </div>
                              <?php
                                 if ( $comment->comment_parent ) :
                                 	$parent = get_comment( $comment->comment_parent );
                                 	if ( $parent ) :
                                 		$parent_link = esc_url( get_comment_link( $parent ) );
                                 		$name        = get_comment_author( $parent );
                                 		?>
                              <div class="misc-pub-section misc-pub-reply-to">
                                 <?php
                                    printf(
                                    	/* translators: %s: Comment link. */
                                    	__( 'In reply to: %s', 'reviewx' ),
                                    	'<b><a href="' . $parent_link . '">' . $name . '</a></b>'
                                    );
                                    ?>
                              </div>
                              <?php
                                 endif;
                                 endif;
                                 ?>
                              <?php
                                 /**
                                  * Filters miscellaneous actions for the edit comment form sidebar.
                                  *
                                  * @since 4.3.0
                                  *
                                  * @param string     $html    Output HTML to display miscellaneous action.
                                  * @param WP_Comment $comment Current comment object.
                                  */
                                 echo apply_filters( 'edit_comment_misc_actions', '', $comment );
                                 ?>
                           </div>
                           <!-- misc actions -->
                           <div class="clear"></div>
                        </div>
                        <div id="major-publishing-actions">
                           <div id="delete-action">
                              <?php echo "<a class='submitdelete deletion' href='" . wp_nonce_url( 'comment.php?action=' . ( ! EMPTY_TRASH_DAYS ? 'deletecomment' : 'trashcomment' ) . "&amp;c=$comment->comment_ID&amp;_wp_original_http_referer=" . urlencode( wp_get_referer() ), 'delete-comment_' . $comment->comment_ID ) . "'>" . ( ! EMPTY_TRASH_DAYS ? __( 'Delete Permanently', 'reviewx' ) : __( 'Move to Trash', 'reviewx' ) ) . "</a>\n"; ?>
                           </div>
                           <div id="publishing-action">
                              <?php submit_button( esc_html__( 'Update', 'reviewx' ), 'primary large', 'save', false ); ?>
                           </div>
                           <div class="clear"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- /submitdiv -->
            </div>

            <div id="postbox-container-2" class="postbox-container">
               <?php
                  /** This action is documented in wp-admin/includes/meta-boxes.php */
                  do_action( 'add_meta_boxes', 'comment', $comment );
                  
                  /**
                   * Fires when comment-specific meta boxes are added.
                   *
                   * @since 3.0.0
                   *
                   * @param WP_Comment $comment Comment object.
                   */
                  do_action( 'add_meta_boxes_comment', $comment );
                  
                  do_meta_boxes( null, 'normal', $comment );
                  
                  $referer = wp_get_referer();
                  ?>
            </div>
            <input type="hidden" name="c" value="<?php echo esc_attr( $comment->comment_ID ); ?>" />
            <input type="hidden" name="p" value="<?php echo esc_attr( $comment->comment_post_ID ); ?>" />
            <input name="referredby" type="hidden" id="referredby" value="<?php echo $referer ? esc_url( $referer ) : ''; ?>" />
            <?php wp_original_referer_field( true, 'previous' ); ?>
            <input type="hidden" name="noredir" value="1" />
         </div>
         <!-- /post-body -->
      </div>
   </div>
</form>
<?php if ( ! wp_is_mobile() ) : ?>
<script type="text/javascript">
   try{document.post.name.focus();}catch(e){}
</script>
<?php
endif;