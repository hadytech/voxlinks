<div id="public">
  <div class="auth" style="background-image: url('<?php echo esc_url( CROWDFUNDLY_URL . 'admin/images/auth-bg.png' ); ?>')">
    <div class="auth__inner">
      <div class="auth__header">
        <a href="<?php echo esc_url( the_permalink() ); ?>" class="auth__logo">
          <img src="<?php echo esc_url( CROWDFUNDLY_URL . 'admin/images/crowdfundly.png' ); ?>" class="auth__logo-img" alt="<?php echo __('Logo','crowdfundly'); ?>">
        </a>
      </div>
      <div class="auth__body">
        <div class="auth__body-left">
          <img src="<?php echo esc_url( CROWDFUNDLY_URL. 'admin/images/signin.svg' ); ?>" class="auth__body-banner" alt="<?php echo __('Auth banner image','crowdfundly'); ?>">
        </div>
        <div class="auth__body-right">
          <div class="auth-form auth-form--login">
            <div class="auth-form__header">
                <h2 class="auth-form__title">
                  <?php echo __( 'Start crowdfunding with greatly optimized fundraising process', 'crowdfundly' ); ?>
                </h2>
                <p class="auth-form__subtitle">
                  <?php echo __( 'Welcome to the world of opportunities to collaboration', 'crowdfundly' ); ?>
                </p>
            </div>

            <div class="auth-form__body">

              <div class="auth-card">
                
                <div class="auth-card__header mb-3">
                    <p class="auth-card__header-text">
                      <span id="auth-type-text" data-sign-in-text="<?php echo __( "Don't have an account?", 'crowdfundly' ); ?>" data-sign-up-text="<?php echo __( "Already have an account?", 'crowdfundly' ); ?>">
                        <?php echo __( "Don't have an account?", 'crowdfundly' ); ?>
                      </span>

                      <button id="crowdfundly-auth-type" class="auth-card__header-link sign-in" data-sign-in="<?php echo __( 'Sign In', 'crowdfundly' ); ?>" data-sign-up="<?php echo __( 'Sign Up', 'crowdfundly' ); ?>">
                        <img src="<?php echo esc_url( CROWDFUNDLY_URL . 'admin/images/spinner.svg' ); ?>" class="auth-form__loader"/>
                        <?php echo __( 'Sign Up', 'crowdfundly' ); ?>
                      </button>
                    </p>
                </div>

                <div id="crowdfundly-signin-form">
                  <div class="signin-btn-wrapper text-center">
                    <button
                      class="btn btn-primary mb-5 email-auth" 
                      id="app-key-auth-btn"
                      data-key-text="<?php echo __( 'Connect with App Key', 'crowdfundly' ); ?>"
                      data-email-text="<?php echo __( 'Connect with Email', 'crowdfundly' ); ?>"
                      >
                        <?php echo __( 'Connect with App Key', 'crowdfundly' ); ?>
                    </button>
                  </div>

                    <!-- API login section-->
                  <div class="api-auth-card" id="app-key-auth" style="display: none;">
                    <form>
                      <div class="auth-card__inner">
                        <div class="form-group">
                          <label for="api_key"><?php echo __( 'APP Key', 'crowdfundly' ); ?></label>
                          <input type="text" class="form-control" id="crowdfundly_api_key" name="api_key" placeholder="<?php echo esc_attr__( 'Enter API key here', 'crowdfundly' ); ?>">
                        </div>
                      </div>
                      <div class="auth-card__footer">
                        <div class="auth-card__forgot-password mb-3">
                          <a target="_blank" href="<?php echo esc_url( 'https://app.crowdfundly.io/dashboard/settings/app-key' ); ?>" class="auth-card__forgot-password-link"><?php echo __( 'Get APP Key', 'crowdfundly' ); ?></a>
                        </div>
                        <button id="connect_api" class="btn btn-primary auth-card__footer-btn" type="button">
                          <img src="<?php echo esc_url( CROWDFUNDLY_URL . 'admin/images/spinner.svg' ); ?>" class="auth-form__loader"/>                                                
                          <span class="auth-card__footer-btn-label"><?php echo __( 'Connect', 'crowdfundly' ); ?></span>
                        </button>
                      </div>
                    </form>
                  </div>

                    <!-- normal login section-->
                    <div id="email-auth">
                      <form id="email-auth-form">
                        <div class="form-group">
                          <label for="email-login"><?php echo __( 'Email address', 'crowdfundly' ); ?></label>
                          <input type="email" class="form-control" id="email-login" name="email" placeholder="example@email.com" required>
                        </div>
                        <div class="form-group">
                            <label for="password-login"><?php echo __( 'Password', 'crowdfundly' ); ?></label>
                            <input type="password" class="form-control" id="password-login" name="password" placeholder="********" required>
                        </div>

                          <!-- <div class="form-group__password">
                                <button class="form-group__password-btn" tabindex="1" type="button">
                                  <i class="form-group__password-btn-icon fas fa-eye-slash"></i>
                                </button>
                          </div> -->

                        <button class="btn btn-primary auth-card__footer-btn" id="crowdfundly-email-sign-btn" type="submit">
                          <img src="<?php echo esc_url( CROWDFUNDLY_URL . 'admin/images/spinner.svg' ); ?>" class="auth-form__loader"/>
                          <?php echo __( 'Sign In', 'crowdfundly' ); ?>
                        </button>

                        <div class="auth-card__forgot-password">
                          <a href="#" id="forget-password-btn" class="auth-card__forgot-password-link">
                            <?php echo __( 'Forgot password?', 'crowdfundly' ); ?>
                          </a>
                        </div>

                      </form>
                    </div>

                </div>

                <div id="crowdfundl-signup-form-wrapper" style="display: none;">
                  <form id="crowdfundly-signup-form">
                    <div class="form-group">
                      <label for="signupFname"><?php echo __( 'Full Name', 'crowdfundly' ); ?></label>
                      <input type="text" class="form-control" id="signupFname" name="name" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                      <label for="signupEmail"><?php echo __( 'Email Address', 'crowdfundly' ); ?></label>
                      <input type="email" class="form-control" id="signupEmail" name="email" placeholder="example@email.com" required>
                    </div>
                    <div class="form-group" id="PasswordFieldGroup">
                      <label for="signupPassword"><?php echo __( 'Password', 'crowdfundly' ); ?></label>
                      <input type="password" class="form-control" id="signupPassword" name="password" placeholder="********" required>
                    </div>
                    <div class="form-group" id="confirmPassFieldGroup">
                      <label for="signupConfirmPassword"><?php echo __( 'Confirm Password', 'crowdfundly' ); ?></label>
                      <input type="password" class="form-control" id="signupConfirmPassword" name="password_confirmation" placeholder="********" required>
                    </div>

                    <div class="form-check pl-0">
                      <input type="checkbox" class="form-control" id="signupConfermTerms" name="signupConfermTerms" required>
                      <label class="form-check-label" for="signupConfermTerms">
                        <?php 
                          printf(
                            esc_html__( '%1$s %2$s %3$s %4$s %5$s', 'crowdfundly' ),
                            esc_html__( 'By Creating An Account, I Accept The ', 'crowdfundly' ),
                            sprintf(
                              '<a href="%s" target="_blank">%s</a>',
                              esc_url( 'https://crowdfundly.io/terms/' ),
                              esc_html__( 'Terms', 'crowdfundly' )
                            ),
                            esc_html__( ' and ', 'crowdfundly' ),
                            sprintf(
                              '<a href="%s" target="_blank">%s</a>',
                              esc_url( 'https://crowdfundly.io/privacy/' ),
                              esc_html__( 'Privacy', 'crowdfundly' )
                            ),
                            esc_html__( ' Conditions.', 'crowdfundly' )                            
                          );
                        ?>
                      </label>
                    </div>

                    <div class="auth-card__footer mt-4">
                      <button class="btn btn-primary auth-card__footer-btn" id="crowdfundly-sign-up-btn" type="submit">
                        <img src="<?php echo esc_url( CROWDFUNDLY_URL . 'admin/images/spinner.svg' ); ?>" class="auth-form__loader"/>
                        <?php echo __( 'Sign Up', 'crowdfundly' ); ?>
                      </button>
                    </div>
                  </form>
                </div>

                <div id="crowdfundl-forget-password-form-wrapper" style="display: none;">
                  <form id="crowdfundly-forget-password-form">
                      <div class="form-group">
                        <label for="forgetPasswordEmail"><?php echo __( 'Email Address', 'crowdfundly' ); ?></label>
                        <input type="email" class="form-control" id="forgetPasswordEmail" name="email" placeholder="example@email.com" required>
                      </div>

                      <div class="auth-card__footer mt-4">
                        <button 
                        type="submit"
                        class="btn btn-primary auth-card__footer-btn" 
                        id="crowdfundly-forget-password-btn"
                        data-api-base="<?php echo esc_attr( CROWDFUNDLY_APP_URL ); ?>"
                        data-error-msg="<?php echo esc_attr__( "Something went wrong, Please try again", "crowdfundly" ); ?>"
                        >
                          <img src="<?php echo esc_url( CROWDFUNDLY_URL . 'admin/images/spinner.svg' ); ?>" id="forgetpassword-loader" class="auth-form__loader" />
                          <?php echo __( 'Send', 'crowdfundly' ); ?>
                        </button>
                      </div>

                      <div class="forget-password-msg"></div>
                  </form>
                </div>

              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>