<div class="wrap">
    <hr class="wp-header-end">
    <div class="easy-page-body">
        <main class="content-area">
            <header class="content-area__header d-flex justify-content-center">
                <div>
                    <img src="<?php echo EASYJOBS_ADMIN_URL?>/assets/img/logo-blue.svg" alt="">
                    <small class="easyjobs-version"><?php _e('Version: ', EASYJOBS_TEXTDOMAIN);?><?php echo EASYJOBS_VERSION;?> </small>
                </div>
            </header>
            <!-- content body -->
            <div class="content-area__body easyjobs-landing-body">
                <div class="easyjobs-wrapper admin-area landing">
                    <div class="page-content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="easyjobs-landing-header">
                                    <h1><?php _e('Easy Solution For Hiring & Talent sourcing', EASYJOBS_TEXTDOMAIN); ?></h1>
                                </div>
                            </div>
                            <div class="row align-items-center landing-inner-content">
                                <div class="col-sm-6">
                                    <div class="intro-panel">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/xp1E65oLnlc?rel=0" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="login-box">
                                        <?php if(!empty($company_create_view) && !empty($company_metadata)): ?>
                                            <form class="ej-company-create-form" data-user-key="<?php echo $_GET['user']?>" data-nonce="<?php echo wp_create_nonce('easyjobs_create_company_nonce')?>">
                                                <div class="form-note mb-4">
                                                    <?php _e('Give us few more information about your company', EASYJOBS_TEXTDOMAIN);?>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        <?php _e('Company Name', EASYJOBS_TEXTDOMAIN); ?>*
                                                    </label>
                                                    <input class="form-control" type="text" placeholder="Your Company Name" name="name"/>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        <?php _e('Username / Company', EASYJOBS_TEXTDOMAIN); ?>*
                                                    </label>
                                                    <div class="input-group">
                                                        <input class="form-control" type="text" placeholder="Company Username" name="username"/>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text color-primary background-light">.easy.jobs</span>
                                                        </div>
                                                    </div>
                                                    <div  class="form-note mt-2">
                                                        <span class="text-capitalize">
                                                            <?php _e('tips', EASYJOBS_TEXTDOMAIN);?>:
                                                        </span>
                                                        <?php _e('Accepted characters for username are alphabets, numbers, hyphen & underscore.', EASYJOBS_TEXTDOMAIN);?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        <?php _e('Phone No', EASYJOBS_TEXTDOMAIN);?>*
                                                    </label>
                                                    <input class="form-control" type="text" placeholder="0123456789" name="mobile_number"/>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        <?php _e('Industry', EASYJOBS_TEXTDOMAIN);?>*
                                                    </label>
                                                    <select class="ej-select" type="text" placeholder="Your Industry Type..." name="industry">
                                                        <?php foreach ($company_metadata->company_type as $company_type):?>
                                                            <option value="<?php echo $company_type->id?>">
                                                                <?php echo $company_type->name?>
                                                            </option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        <?php _e('Website url', EASYJOBS_TEXTDOMAIN);?>*
                                                    </label>
                                                    <input class="form-control" type="text" placeholder="http://www.example.com" name="website"/>
                                                    <div  class="form-note mt-2">
                                                        <span class="text-capitalize">
                                                            <?php _e('tips', EASYJOBS_TEXTDOMAIN);?>:
                                                        </span>
                                                        <?php _e('Tips: Website URL should look like http://www.example.com', EASYJOBS_TEXTDOMAIN);?>
                                                    </div>
                                                </div>
                                                <div class="row employeeNumber">
                                                    <label for="Category">
                                                        <?php _e('Number of Employees*', EASYJOBS_TEXTDOMAIN); ?>
                                                    </label>
                                                    <?php foreach ($company_metadata->company_sizes as $key => $company_size): ?>
                                                    <div class="col company-size">
                                                        <div class="employeeNumber__counter">
                                                            <input type="radio" name="company_size" id="employee-count<?php echo $company_size->id ?>" value="<?php echo $company_size->id; ?>" <?php echo (int)$key === 1 ? 'checked' : '';?> />
                                                            <label class="employeeNumber__info" for="employee-count<?php echo $company_size->id?>">
                                                                <h4 class="employeeNumber__total"><?php echo $company_size->size?></h4>
                                                                <span class="employeeNumber__title">Employees</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <?php endforeach;?>
                                                </div>
                                                <label class="checkbox mt-3">
                                                    <input type="checkbox" value="1" id="terms-and-policy" name="terms_and_policy"/>
                                                    <span>
                                                        <?php _e('I Agree to the Terms and Policy*', EASYJOBS_TEXTDOMAIN)?>
                                                    </span>
                                                </label>
                                                <div class="d-flex justify-content-between equal-divided mt-3">
                                                    <button class="button info-button">
                                                        <?php _e('Get Started', EASYJOBS_TEXTDOMAIN); ?>
                                                    </button>
                                                </div>
                                            </form>
                                        <?php else: ?>
                                            <div class="login-toggler nav nav-pills" id="myTab" role="tablist">
                                                <a class="tab--toggler active" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">
                                                    <?php _e('Sign In', EASYJOBS_TEXTDOMAIN); ?>
                                                </a>
                                                <a class="tab--toggler" id="signup-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="signup" aria-selected="false">
                                                    <?php _e('Sign Up', EASYJOBS_TEXTDOMAIN); ?>
                                                </a>
                                            </div>
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active " id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                                    <div class="social-signin">
                                                        <button class="social-signin__button active" data-target="api-key">
                                                            <div class="social-signin__button__logo">
                                                                <img src="<?php echo EASYJOBS_ADMIN_URL;?>assets/img/api.svg" alt="" class="img-fluid" />
                                                            </div>
                                                            <p class="social-signin__button__text w-100">
                                                                <?php _e('Connect with API key', EASYJOBS_TEXTDOMAIN ); ?>
                                                            </p>
                                                        </button>
                                                        <button class="social-signin__button" data-target="sign-in">
                                                            <div class="social-signin__button__logo">
                                                                <img src="<?php echo EASYJOBS_ADMIN_URL;?>assets/img/user.svg" alt="" class="img-fluid" />
                                                            </div>
                                                            <p class="social-signin__button__text w-100">
                                                                <?php _e('Sign in with credentials', EASYJOBS_TEXTDOMAIN ); ?>
                                                            </p>
                                                        </button>
                                                    </div>
                                                    <div class="sign-in connect-option active">
                                                        <form class="ej-login-form" data-nonce="<?php echo wp_create_nonce('easyjobs_signin_nonce')?>">
                                                            <div class="form-group">
                                                                <label>
                                                                    <?php _e('Email Address', EASYJOBS_TEXTDOMAIN);?>
                                                                </label>
                                                                <input class="form-control" type="text" placeholder="youremail@gmail.com" name="email"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label><?php _e('Password', EASYJOBS_TEXTDOMAIN);?> </label>
                                                                <input class="form-control" type="password" placeholder="************" name="password"/>
                                                            </div>
                                                            <div class="d-flex justify-content-between mt-2">
                                                                <button class="button info-button" type="submit">
                                                                    <?php _e('Sign In', EASYJOBS_TEXTDOMAIN); ?>
                                                                </button>
                                                                <a href="<?php echo EASYJOBS_APP_URL;?>/forgot-password" target="_blank" class="forget-button">
                                                                    <?php _e('Forgot Password?', EASYJOBS_TEXTDOMAIN);?>
                                                                </a>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="api-key connect-option">
                                                        <form class="ej-connect-form">
                                                            <div class="form-group">
                                                                <label>
                                                                    <?php _e('Api key', EASYJOBS_TEXTDOMAIN); ?>
                                                                </label>
                                                                <input type="text" name="easyjobs_api_key" class="form-control" placeholder="<?php _e('Enter your api key', EASYJOBS_TEXTDOMAIN);?>">
                                                                <a href="https://easy.jobs/docs/generate-app-key/" class="ej-api-key-link mt-1 ml-1 d-inline-block text-info" target="_blank">
                                                                    <?php _e('Get Api Key', EASYJOBS_TEXTDOMAIN);?>
                                                                </a>
                                                            </div>
                                                            <button type="submit" name="submit" data-nonce="<?php echo wp_create_nonce('easyjobs_connect_api_nonce')?>" data-key="connect_api" class="button info-button ej-connect-form-btn">
                                                                <?php _e('Connect', EASYJOBS_TEXTDOMAIN);?>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="company-select">
                                                        <form class="ej-company-select-form" data-nonce="<?php echo wp_create_nonce('easyjobs_company_select_nonce')?>">
                                                            <div class="form-group">
                                                                <label>
                                                                    <?php _e('Select Company', EASYJOBS_TEXTDOMAIN);?>
                                                                </label>
                                                                <select name="select_company" class="form-control">
                                                                    <option value="0" disabled selected>
                                                                        <?php _e('Select Company', EASYJOBS_TEXTDOMAIN);?>
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <button type="submit" name="submit" class="button info-button">
                                                                <?php _e('Save', EASYJOBS_TEXTDOMAIN);?>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade show" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                                                    <form class="ej-signup-form" data-nonce="<?php echo wp_create_nonce('easyjobs_signup_nonce'); ?>">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>
                                                                        <?php _e('First Name', EASYJOBS_TEXTDOMAIN); ?> *
                                                                    </label>
                                                                    <input class="form-control" type="text" placeholder="Your First Name" name="first_name"/>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>
                                                                        <?php _e('Last Name', EASYJOBS_TEXTDOMAIN); ?>*
                                                                    </label>
                                                                    <input class="form-control" type="text" placeholder="Your Last Name" name="last_name"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                               <?php _e('Email Address', EASYJOBS_TEXTDOMAIN); ?> *
                                                            </label>
                                                            <input class="form-control" type="text" placeholder="youremail@gmail.com" name="email" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                <?php _e('Password', EASYJOBS_TEXTDOMAIN); ?>*
                                                            </label>
                                                            <input class="form-control" type="password" placeholder="************" name="password" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                <?php _e('Confirm Password', EASYJOBS_TEXTDOMAIN); ?>*
                                                            </label>
                                                            <input class="form-control" type="password" placeholder="************" name="password_confirm" />
                                                        </div>
                                                        <div class="d-flex justify-content-between mt-2">
                                                            <button class="button info-button" type="submit">
                                                                <?php _e('Sign UP', EASYJOBS_TEXTDOMAIN); ?>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <div class="modal fade api-confirmation-modal" id="apiConnectStatus" tabindex="-1" role="dialog" aria-labelledby="apiConnectStatus" aria-modal="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="ej-error-msg">
                            <i class="dashicons dashicons-dismiss"></i>
                            <h4 class="ej-msg">
                                <?php _e('Api Connect Failed !!', EASYJOBS_TEXTDOMAIN);?>
                            </h4>
                            <p>
                                <?php _e('Invalid api key', EASYJOBS_TEXTDOMAIN);?>
                            </p>
                        </div>
                        <div class="ej-success-msg">
                            <i class="dashicons dashicons-yes-alt"></i>
                            <h4 class="ej-msg">
                                <?php _e('Api Connected Successfully !!', EASYJOBS_TEXTDOMAIN);?>
                            </h4>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <?php _e('Close', EASYJOBS_TEXTDOMAIN);?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>