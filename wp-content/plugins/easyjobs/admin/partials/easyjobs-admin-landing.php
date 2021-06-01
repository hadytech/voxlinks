<div class="wrap">
    <hr class="wp-header-end">
    <div class="easy-page-body">
        <div class="content__wrapper">
            <?php if(!empty($company_create_view) && !empty($company_metadata)): ?>
                <div class="section-gap">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="create__company">
                                    <h2 class="create__company__title">Share More Information About Your Company To Jumpstart</h2>
                                    <p class="create__company__subtitle">You are just one step away from getting started with Easy.Jobs! Fill out your company's basic information to unlock the huge benefits</p>
                                    <div class="shape__wrap">
                                        <div class="shapes">
                                            <img src="<?php echo EASYJOBS_ADMIN_URL; ?>assets/img/circle.png" class="shape-circle" alt="">
                                            <img src="<?php echo EASYJOBS_ADMIN_URL; ?>assets/img/dots.png" class="shape-dots" alt="">
                                            <img src="<?php echo EASYJOBS_ADMIN_URL; ?>assets/img/triangle.png" class="shape-triangle" alt="">
                                        </div>
                                        <div class="account__wrap">
                                            <div class="account__form">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <?php if(!$login_view): ?>
                    <div class="welcome">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="text-center">
                                        <a href="#" class="site-logo">
                                            <img src="<?php echo EASYJOBS_ADMIN_URL; ?>assets/img/logo.png" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="section-gap">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div class="basic__content__block">
                                            <h1>The Best Hiring Solution For 2021</h1>
                                            <div class="feature__list">
                                                <div class="feature__item feature__item--one">
                                                    <div class="icon">
                                                        <img src="<?php echo EASYJOBS_ADMIN_URL; ?>assets/img/icon-1.png" alt="">
                                                    </div>
                                                    <p>Automated Remote Hiring</p>
                                                </div>
                                                <div class="feature__item feature__item--two">
                                                    <div class="icon">
                                                        <img src="<?php echo EASYJOBS_ADMIN_URL; ?>assets/img/icon-2.png" alt="">
                                                    </div>
                                                    <p>Reporting With AI Score</p>
                                                </div>
                                                <div class="feature__item feature__item--three">
                                                    <div class="icon">
                                                        <img src="<?php echo EASYJOBS_ADMIN_URL; ?>assets/img/icon-3.png" alt="">
                                                    </div>
                                                    <p>Easy Onboarding Process</p>
                                                </div>
                                                <div class="feature__item feature__item--four">
                                                    <div class="icon">
                                                        <img src="<?php echo EASYJOBS_ADMIN_URL; ?>assets/img/icon-4.png" alt="">
                                                    </div>
                                                    <p>Design With Elementor</p>
                                                </div>
                                            </div>
                                            <p>Recruiting for your company has been made easier and more effective with the right tool for tracking, analyzing, communicating, and evaluating candidates from one platform.</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 ej-intro-video">
                                        <div class="content__thumb">
                                            <img src="<?php echo EASYJOBS_ADMIN_URL; ?>assets/img/macbook-air1.png" class="img-fluid" alt="">
                                            <div class="embed-responsive embed-responsive-16by9 video">
                                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/xp1E65oLnlc?rel=0" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <a href="#" class="watch-button"><span></span> Watch Video</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="section-gap">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="text-center">
                                            <a href="<?php echo admin_url('/admin.php?page=easyjobs-admin&landing_view=login');?>" class="get-started-button">Get Started <span></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
                <?php if(isset($login_view) && $login_view) : ?>
                    <div class="login-vew">
                        <div class="">
                            <a href="#" class="site-logo">
                                <img src="<?php echo EASYJOBS_ADMIN_URL; ?>assets/img/logo.png" alt="">
                            </a>
                        </div>
                        <div class="section-gap">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-7">
                                        <div class="shape__wrap">
                                            <div class="shapes">
                                                <img src="<?php echo EASYJOBS_ADMIN_URL; ?>assets/img/circle.png" class="shape-circle" alt="">
                                                <img src="<?php echo EASYJOBS_ADMIN_URL; ?>assets/img/dots.png" class="shape-dots" alt="">
                                                <img src="<?php echo EASYJOBS_ADMIN_URL; ?>assets/img/triangle.png" class="shape-triangle" alt="">
                                            </div>
                                            <div class="account__wrap">
                                                <ul class="nav nav-tabs landing-tabs" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">Sign In</a>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link" id="signup-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="signup" aria-selected="false">Sign Up</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content landing-tab-content" id="myTabContent">
                                                    <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                                        <div class="account__form connect-option sign-in active">
                                                            <a href="#" class="alt__login" data-target="api-key">Conntet via API</a>
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
                                                                <button class="button info-button btn-block" type="submit">
                                                                    <?php _e('Sign In', EASYJOBS_TEXTDOMAIN); ?>
                                                                </button>
                                                                <div class="d-flex justify-content-between mt-4">
                                                                    <p class="another__account">New here? <a href="#" class="create-account-btn">Create an account!</a></p>
                                                                    <a href="<?php echo EASYJOBS_APP_URL;?>/forgot-password" target="_blank" class="forget-button">
                                                                        <?php _e('Forgot Password?', EASYJOBS_TEXTDOMAIN);?>
                                                                    </a>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="account__form connect-option api-key">
                                                            <a href="#" class="alt__login" data-target="sign-in">Connect via Login Credentials</a>
                                                            <form class="ej-connect-form">
                                                                <div class="form-group">
                                                                    <label>
                                                                        <?php _e('Api key', EASYJOBS_TEXTDOMAIN); ?>
                                                                    </label>
                                                                    <input type="text" name="easyjobs_api_key" class="form-control" placeholder="<?php _e('Enter your api key', EASYJOBS_TEXTDOMAIN);?>">
                                                                    <a href="#" class="get__api">Get API Key</a>
                                                                </div>
                                                                <button class="button info-button btn-block ej-connect-form-btn" type="submit" data-nonce="<?php echo wp_create_nonce('easyjobs_connect_api_nonce')?>" data-key="connect_api">
                                                                    <?php _e('Connect', EASYJOBS_TEXTDOMAIN);?>
                                                                </button>
                                                                <div class="d-flex justify-content-between mt-4">
                                                                    <p class="another__account">New here? <a href="#" class="create-account-btn">Create an account!</a></p>
                                                                    <a href="#" class="forget-button">Forget Password?</a>
                                                                </div>
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
                                                    <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                                                        <div class="account__form">
                                                            <form class="ej-signup-form" data-nonce="<?php echo wp_create_nonce('easyjobs_signup_nonce'); ?>">
                                                                <div class="d-flex w-100">
                                                                    <div class="pr-2 w-50">
                                                                        <div class="form-group">
                                                                            <label>
                                                                                <?php _e('First Name', EASYJOBS_TEXTDOMAIN); ?> *
                                                                            </label>
                                                                            <input class="form-control" type="text" placeholder="Your First Name" name="first_name"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="pl-2 w-50">
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
                                                                <div class="d-flex justify-content-between mt-4">
                                                                    <p class="another__account">Already have an account? <a href="#" class="sign-in-btn">Sign In</a></p>
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
                    </div>
                <?php endif;?>
            <?php endif; ?>
        </div>
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
