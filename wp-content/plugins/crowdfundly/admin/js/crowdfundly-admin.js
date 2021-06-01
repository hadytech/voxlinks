(function( $ ) {
	'use strict';

	$(document).ready(function() {
		signUpView();
		authTypeView();
		emailLogInAuth();
		signUpAuth();
		forgetPassword();

	 	if ( crowdfundlyAuth && crowdfundlyAuth.has_bearer_token ) {
			pre_set_dashboard();
			disconnect_api();
		} else {
			connect_api();
		}
	});

	function signUpView() {
		const authType = $('#crowdfundly-auth-type');
		const authTypeText = $('#auth-type-text');
		const signIn = $('#crowdfundly-signin-form');
		const signUp = $('#crowdfundl-signup-form-wrapper');
		const forgetPassword = $('#crowdfundl-forget-password-form-wrapper');

		authType.on('click', function() {
			$(this).toggleClass('sign-in');
			$(this).text($(this).data('sign-in'));
			authTypeText.text(authTypeText.data('sign-up-text'));

			signIn.css('display', 'none');
			signUp.css('display', 'block');
			forgetPassword.css('display', 'none');

			if ( $(this).hasClass('sign-in') ) {
				$(this).text($(this).data('sign-up'));
				authTypeText.text(authTypeText.data('sign-up-text'));
				authTypeText.text(authTypeText.data('sign-in-text'));
				$('#app-key-auth-btn').text($('#app-key-auth-btn').data('key-text'));
				$('#app-key-auth-btn').addClass('email-auth');

				signIn.css('display', 'block');
				signUp.css('display', 'none');
				$('#email-auth').css('display', 'block');
				$('#app-key-auth').css('display', 'none');
			}
		})
	}

	// function signUpValidation() {
	// 	let errorList = [];
	// 	// confirm password match validation
	// 	let signupConfirmPasswordValue = '';
	// 	$('#signupConfirmPassword').on( 'input', function(e) {
	// 		const signupPasswordValue = $('#signupPassword').val();
	// 		signupConfirmPasswordValue = $(this).val();
	// 		const confirmPassField = $('#confirmPassFieldGroup');

	// 		if ( signupPasswordValue != '' && signupConfirmPasswordValue != '' ) {
	// 			if ( signupPasswordValue !== signupConfirmPasswordValue ) {
	// 				errorList[0] = 'Password didn\'t match...';
	// 				// console.log("signupPasswordValue !== signupConfirmPasswordValue", errorList);
	// 				if ( $('.signup-validation.confirm-password').length < 1 ) {
	// 					confirmPassField.append('<label id="signupConfirmPassCheck-error" class="signup-validation confirm-password">Password didn\'t match...</label>');
	// 				}
	// 			} else {
	// 				errorList = [];
	// 				// console.log("confirm else", errorList);
	// 				$('.signup-validation.confirm-password').remove();
	// 			}
	// 		}
	// 	});

	// 	$('#signupPassword').on( 'input', function(e) {
	// 		let signupPasswordValue = $('#signupPassword').val();
	// 		// signupPasswordValue = e.keyCode === 8 ? signupPasswordValue.length - 1 : signupPasswordValue.length + 1;
	// 		signupConfirmPasswordValue = $('#signupConfirmPassword').val();
	// 		const passwordFieldGroup = $('#PasswordFieldGroup');
	// 		const confirmPassField = $('#confirmPassFieldGroup');
			
	// 		if (signupPasswordValue.length <= 5) {
	// 			errorList[0] = 'Password must be at least 6 characters.';
	// 			// console.log("signupPasswordValue.length <= 5", errorList);
	// 			if ($('.signup-validation.password').length < 1) {
	// 				passwordFieldGroup.append('<label id="signupPassCheck-error" class="signup-validation password">Password must be at least 6 characters.</label>');
	// 			}
	// 		} else {
	// 			errorList = [];
	// 			// console.log("else", errorList);
	// 			$('.signup-validation.password').remove();
	// 		}
			
	// 		if ( signupConfirmPasswordValue != '' ) {
	// 			if ( signupConfirmPasswordValue != signupPasswordValue ) {
	// 				errorList[0] = 'Password didn\'t match...';
	// 				// console.log("signupConfirmPasswordValue != signupPasswordValue", errorList);
	// 				if ( $('.signup-validation.confirm-password').length < 1 ) {
	// 					confirmPassField.append('<label id="signupConfirmPassCheck-error" class="signup-validation confirm-password">Password didn\'t match...</label>');
	// 				}
	// 			} else {
	// 				// console.log("2n confirm else", errorList);
	// 				errorList = [];
	// 				$('.signup-validation.confirm-password').remove();
	// 			}
	// 		}
	// 	});

	// 	console.log("signUpValidation return", errorList);
	// 	return errorList;
	// }

	function signUpSubmitAuth() {
		const formData = {};
		formData['name'] = $('#signupFname').val();
		formData['email'] = $('#signupEmail').val();
		formData['password']= $('#signupPassword').val();
		formData['password_confirmation'] = $('#signupConfirmPassword').val();
		formData['type'] = 'regular';

		const emailAuthBtn = $('#crowdfundly-sign-up-btn');
		emailAuthBtn.attr('disabled', true);
		$('.auth-form__loader').css('display', 'block');

		$.ajax({
			type: 'POST',
			url: crowdfundlyAuth.ajax_url,
			data: {
				action: "crowdfundly_signup_auth",
				signupData: formData,
				security: crowdfundlyAuth.nonce,
			},
			success: function (response) {
				// console.log(response);
				if (response.code == 200) {
					swal({
						title: crowdfundlyAuth.success,
						text: "Sign Up Successful",
						icon: 'success'
					});
				}

				setDashboard(response);
				$('.auth-form__loader').css('display', 'none');
				setTimeout(() => {
					window.location.reload();
				}, 1500);
			},
			error: function(error) {
				console.log(error);

				if (error.status === 422) {
					swal({
						title: crowdfundlyAuth.warning,
						text: "The email is already registered with us. Please log in instead.",
						icon: 'warning'
					});
				}

				emailAuthBtn.removeAttr('disabled');
				$('.auth-form__loader').css('display', 'none');
			}
		});
	}

	function signUpAuth() {
		const signUpSubmit = $("#crowdfundly-signup-form");
		const signUpSubmitBtn = $("#crowdfundly-sign-up-btn");

		let errorList = [];
		// confirm password match validation
		let signupConfirmPasswordValue = '';
		$('#signupConfirmPassword').on( 'input', function(e) {
			const signupPasswordValue = $('#signupPassword').val();
			signupConfirmPasswordValue = $(this).val();
			const confirmPassField = $('#confirmPassFieldGroup');

			if ( signupPasswordValue != '' && signupConfirmPasswordValue != '' ) {
				if ( signupPasswordValue !== signupConfirmPasswordValue ) {
					errorList[0] = 'Password didn\'t match...';
					if ( $('.signup-validation.confirm-password').length < 1 ) {
						confirmPassField.append('<label id="signupConfirmPassCheck-error" class="signup-validation confirm-password">Password didn\'t match...</label>');
					}
				} else {
					errorList = [];
					$('.signup-validation.confirm-password').remove();
				}
			}
		});

		$('#signupPassword').on( 'input', function(e) {
			let signupPasswordValue = $('#signupPassword').val();
			signupConfirmPasswordValue = $('#signupConfirmPassword').val();
			const passwordFieldGroup = $('#PasswordFieldGroup');
			const confirmPassField = $('#confirmPassFieldGroup');
			
			if (signupPasswordValue.length <= 5) {
				errorList[0] = 'Password must be at least 6 characters.';
				if ($('.signup-validation.password').length < 1) {
					passwordFieldGroup.append('<label id="signupPassCheck-error" class="signup-validation password">Password must be at least 6 characters.</label>');
				}
			} else {
				errorList = [];
				$('.signup-validation.password').remove();
			}
			
			if ( signupConfirmPasswordValue != '' ) {
				if ( signupConfirmPasswordValue != signupPasswordValue ) {
					errorList[0] = 'Password didn\'t match...';
					if ( $('.signup-validation.confirm-password').length < 1 ) {
						confirmPassField.append('<label id="signupConfirmPassCheck-error" class="signup-validation confirm-password">Password didn\'t match...</label>');
					}
				} else {
					errorList = [];
					$('.signup-validation.confirm-password').remove();
				}
			}
		});

		signUpSubmit.on('submit', function(e) {
			e.preventDefault();

			if ( errorList.length == 0 ) {
				signUpSubmitAuth();
			}
		});
	}

	function emailSubmitAuth() {
		const formData = {};
		formData['email'] = $('#email-login').val();
		formData['password']= $('#password-login').val();
		formData['type'] = 'regular';

		const emailAuthBtn = $('#crowdfundly-email-sign-btn');
		emailAuthBtn.attr('disabled', true);
		$('.auth-form__loader').css('display', 'block');

		$.ajax({
			type: 'POST',
			url: crowdfundlyAuth.ajax_url,
			data: {
				action: "crowdfundly_email_login_auth",
				emailLoginData: formData,
				security: crowdfundlyAuth.nonce,
			},
			success: function (response) {
				console.log(response);

				if (response.code == 200) {
					swal({
						title: crowdfundlyAuth.success,
						text: "Log In Successful",
						icon: 'success'
					});

					setDashboard(response);
					setTimeout(() => {
						window.location.reload();
					}, 1500);
				}

				$('.auth-form__loader').css('display', 'none');
			},
			error: function(error) {
				console.log(error);

				swal({
					title: crowdfundlyAuth.warning,
					text: crowdfundlyAuth.email_not_found,
					icon: 'warning'
				});

				$('.auth-form__loader').css('display', 'none');
				emailAuthBtn.removeAttr('disabled');
			}
		});
	}
	function emailLogInAuth() {
		const emailAuth = $('#email-auth-form');

		emailAuth.on('submit', function(e) {
			e.preventDefault();
			emailSubmitAuth();
		});
	}

	function authTypeView() {
		const keyAuthBtn = $('#app-key-auth-btn');
		const appKeyMarkup = $('#app-key-auth');
		const emailAuthMarkup = $('#email-auth');
		const forgetPassword = $('#crowdfundl-forget-password-form-wrapper');

		keyAuthBtn.on('click', function() {
			$(this).toggleClass('email-auth');
			$(this).text($(this).data('email-text'));

			appKeyMarkup.css('display', 'block');
			emailAuthMarkup.css('display', 'none');
			forgetPassword.css('display', 'none');

			if ( $(this).hasClass('email-auth') ) {
				$(this).text($(this).data('key-text'));

				appKeyMarkup.css('display', 'none');
				emailAuthMarkup.css('display', 'block');
			}
		});
	}

	function forgetPassword() {
		const forgetPasswordElement = $('#forget-password-btn');
		const forgetPasswordBtn = $('#crowdfundly-forget-password-btn');
		const forgetPasswordWrap = $('#crowdfundl-forget-password-form-wrapper');
		const emailAuth = $('#email-auth');

		if (forgetPasswordElement) {
			forgetPasswordElement.on('click', function() {
				console.log("Forget Password...");
				emailAuth.css('display', 'none');
				forgetPasswordWrap.css('display', 'block');
			});
		}

		if (forgetPasswordBtn) {
			forgetPasswordBtn.on('click', function() {
				const self = $(this);
				self.attr('disabled', true);
				$('#forgetpassword-loader').css('display', 'block');

				const emailAddress = $('#forgetPasswordEmail').val();
				const url = $(this).data('api-base') + '/api/v1/auth/password/email';

				$.ajax({
					type: "POST",
					url: url,
					data: {email: emailAddress},
					success: function(res) {
						$('.forget-password-msg').html(res.message);

						self.attr('disabled', false);
						$('#forgetpassword-loader').css('display', 'none');
					},
					error: function(err) {
						$('.forget-password-msg').addClass('error');
						$('.forget-password-msg').html(self.data('error-msg'));

						self.attr('disabled', false);
						$('#forgetpassword-loader').css('display', 'none');
					}
				});
			});
		}
	}

	function connect_api() {
		let ApiKeyInput = $("#crowdfundly_api_key");
		let ConnectApiKeyButton = $("#connect_api");

		if (!ApiKeyInput || !ConnectApiKeyButton) {
			return;
		}

		ConnectApiKeyButton.on( "click", function(e) {
			const self = $(this);
			self.attr('disabled', true);

			if (! ApiKeyInput.val() ) {
				swal({
					title: crowdfundlyAuth.warning,
					text: crowdfundlyAuth.api_not_provided,
					icon: 'warning'
				});
				return;
			}
			ConnectApiKeyButton.children("span").text(crowdfundlyAuth.connecting);
			$('.auth-form__loader').show();

			$.ajax({
				type: 'POST',
				url: crowdfundlyAuth.ajax_url,
				data: {
					action: "crowdfundly_connect_api",
					crowdfundly_connect_apikey: ApiKeyInput.val(),
					security: crowdfundlyAuth.nonce,
				},
				success: function (response) {
					// console.log(response);
					if ( response.code == 200 ) {
						swal({
							title: crowdfundlyAuth.success,
							text: crowdfundlyAuth.success_authenticated,
							icon: 'success'
						});

						setDashboard(response);
						window.location.reload();
					} else {
						swal({
							title: crowdfundlyAuth.failed,
							text: crowdfundlyAuth.failed_authentication,
							icon: 'error'
						}).then((result) => {
							ApiKeyInput.val('');
						});
					}
					ConnectApiKeyButton.children("span").text(crowdfundlyAuth.connect);
					$('.auth-form__loader').hide();
					self.removeAttr('disabled');
				},
				error: function(error) { 
					// console.log(error);
					swal({
						title: crowdfundlyAuth.failed,
						text: crowdfundlyAuth.failed_authentication,
						icon: 'error'
					}).then((result) => {
						ApiKeyInput.val('');
					});

					ConnectApiKeyButton.children("span").text(crowdfundlyAuth.connect);
					$('.auth-form__loader').hide();
					self.removeAttr('disabled');
				}
			})
		});
	}

	function disconnect_api() {
		let button = $(this);
		let disconnectApiElem = $(".crowdfundly-footer-link-general");
		disconnectApiElem.click(function (e) {
			$.ajax({
				type: "POST",
				url: crowdfundlyAuth.ajax_url,
				data: {
					action: 'crowdfundly_disconnect_api',
					security: crowdfundlyAuth.nonce,
				},
				beforeSend: function () {
					$(this).html('<span>'+crowdfundlyAuth.disconnecting+'</span>');
				},
				success: function (res) {
					swal({
						title: crowdfundlyAuth.success,
						text: crowdfundlyAuth.success_disconnected,
						icon: 'success'
					});
					localStorage.removeItem('auth._token.local');
					localStorage.removeItem('crowdfundly');
					Cookies.remove('auth._token.local');
					
					window.location.reload();
				}
			})
		});
	}

	// set data when authenticating
	async function setDashboard(response) {
		await Cookies.set('auth._token.local', 'Bearer ' + response.token);
		await localStorage.setItem('auth._token.local', 'Bearer ' + response.token);

		var crowdfundly = JSON.parse(await localStorage.getItem('crowdfundly'));
		if ( !crowdfundly ) {
			crowdfundly = {
				auth: {
					busy: false,
					loggedIn: true,
					redirect: '/dashboard',
					strategy: 'local'
				}
			}
		}

		crowdfundly.auth.busy = false;
		crowdfundly.auth.loggedIn = true;
		crowdfundly.auth.redirect = "/dashboard";
		crowdfundly.auth.strategy = "local";
		// crowdfundly.organization = (response.user.length != 0) ? response.user : null;
		crowdfundly.organization = (response.email_login == 1 && response.user) ? response.user : null;
		if ( response.email_login == 0 ) {
			crowdfundly.organization = response.organization ? response.organization : null;
		}
		crowdfundly.countries = response.countries;
		crowdfundly.currencies = response.currencies;
		crowdfundly.logout_api_url = crowdfundlyAuth.logout_api_url;
		crowdfundly.changed_organization = crowdfundlyAuth.changed_organization;
		crowdfundly.logout_redirect_url = crowdfundlyAuth.plugin_url;
		crowdfundly.email_login = response.email_login;

		crowdfundly.site_url = response.site_url;
		crowdfundly.organization_url = response.organization_url;
		crowdfundly.campaign_url = response.campaign_url;
		crowdfundly.site_url = crowdfundlyAuth.site_url;
		crowdfundly.organization_url = crowdfundlyAuth.organization_url;
		crowdfundly.campaign_url = crowdfundlyAuth.campaign_url;
		await localStorage.setItem('crowdfundly', JSON.stringify(crowdfundly));
	}

	// login redirection
	function pre_set_dashboard() {
		const token = localStorage.getItem('auth._token.local');

		if ( !token && (crowdfundlyAuth.is_dashboard_page || crowdfundlyAuth.is_setting_page) ) {
		   
			Cookies.set('auth._token.local', 'Bearer ' + crowdfundlyAuth.bearer_token);
			localStorage.setItem('auth._token.local', 'Bearer ' + crowdfundlyAuth.bearer_token)
			var crowdfundly = JSON.parse(localStorage.getItem('crowdfundly'));

		   if (!crowdfundly) {
			   crowdfundly = {
				   auth: {
					   busy: false,
					   loggedIn: true,
					   redirect: '/dashboard',
					   strategy: 'local'
				   }
			   }
		   }

		   crowdfundly.auth.busy = false
		   crowdfundly.auth.loggedIn = true
		   crowdfundly.auth.redirect = "/dashboard"
		   crowdfundly.auth.strategy = "local"
			//    crowdfundly.organization = (crowdfundlyAuth.user.length != 0) ? crowdfundlyAuth.user : null;
			crowdfundly.organization = (crowdfundlyAuth.email_login == 1 && crowdfundlyAuth.user.organizations) ? crowdfundlyAuth.user.organizations[0] : null;
		   if ( crowdfundlyAuth.email_login == false ) {
				crowdfundly.organization = crowdfundlyAuth.user ? crowdfundlyAuth.user : null;
		   }
		   crowdfundly.countries = crowdfundlyAuth.countries;
		   crowdfundly.currencies = crowdfundlyAuth.currencies;
		   crowdfundly.logout_api_url = crowdfundlyAuth.logout_api_url;
		   crowdfundly.changed_organization = crowdfundlyAuth.changed_organization;
		   crowdfundly.logout_redirect_url = crowdfundlyAuth.plugin_url;
		   crowdfundly.email_login = crowdfundlyAuth.email_login;
		   crowdfundly.site_url = crowdfundlyAuth.site_url;
		   crowdfundly.organization_url = crowdfundlyAuth.organization_url;
		   crowdfundly.campaign_url = crowdfundlyAuth.campaign_url;

		   localStorage.setItem('crowdfundly', JSON.stringify(crowdfundly));

		   window.location.href = crowdfundlyAuth.plugin_url;
	   }
	}

})( jQuery );
