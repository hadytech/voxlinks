(function( $ ) {
	'use strict';

	$('.org-slider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		fade: true,
		autoplay:true,
	});

	$('.gallery-slider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		fade: true,
		asNavFor: '.gallery-slider-nav'
	});

	$('.gallery-slider-nav').slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		asNavFor: '.gallery-slider',
		dots: false,
		focusOnSelect: true
	});
	
	$(window).load(function() {
		const searchParams = new URLSearchParams(window.location.search);
		if ( searchParams.has('search') || searchParams.has('type') ) {
			$("#crowdfundly-all-camp-loadmore").css('display', 'none');
		}
	});
	const allCampaignSubmitElem = $("#allCampaignSearch");
	allCampaignSubmitElem.click(function() {
		var searchParams = new URLSearchParams(window.location.search);
		var location = $(this).data('page-url');
		var searchBoxElem = $("#allCampaignSearchBox");

		if (searchBoxElem.val()) {
			searchParams.set('search', searchBoxElem.val());
			window.location.href = location + '?' + searchParams.toLocaleString();
		}
	});

	const allCampaignTypeSelectElem = $("#allCampaignTypeSelect");
	allCampaignTypeSelectElem.change(function () {
		var searchParams = new URLSearchParams(window.location.search);
		var location = $(this).data('page-url');
		// searchParams.delete('search');

		if ($(this).val()) {
			searchParams.set('type', $(this).val());
			window.location.href = location + '?' + searchParams.toLocaleString();
		}
	});

	// single campaign activites log
	const single_campaign_activites = $("#crowdfundly-activites-load-more");
	if ( single_campaign_activites ) {

		let current_page = 1;
		single_campaign_activites.click(function(e) {
			e.preventDefault();
			const $self = $(this);
			const target_div = $('#activities .activities');
			const last_page = $(this).data('last-page');
			current_page += 1;

			$self.find('.ml-2').text(crowdfundlyPublicData.loading);

			$.ajax({
				url: crowdfundlyPublicData.ajax_url,
				type: 'POST',
				data: {
					action: "crowdfundly_single_campaign_activites_log",
					security: crowdfundlyPublicData.nonce,
					nonce: $(this).data('nonce'),
					camp_id: $(this).data('camp-id'),
					current_page: current_page,
				},
				success: function(response) {
					$(response).appendTo(target_div);
					if( last_page == current_page ) {
						setTimeout( function() {
							$self.css({"display": "none"});
						}, 300 );
					}
					$self.find('.ml-2').text(crowdfundlyPublicData.load_more);
				},
				error: function(error) {
					console.log(error);
					$self.find('.ml-2').text(crowdfundlyPublicData.load_more);
				}
			});
		});
	}

	function donation_presets() {
		const donate_amount = $(".donate__amount");
		const donate_custom_amount = $(".donate__custom-amount-input");

		donate_amount.click(function(e) {
			let searchParams = new URLSearchParams($('#crowdfundly-ajax-cart').attr('href'));	
			donate_custom_amount.val('');
			$('.donate__custom-amount').removeClass('focus');
			$('.donate__amount-inner').removeClass('selected');
			$(this).find('.donate__amount-inner').addClass('selected');
			$('#crowdfundly-donate-confirm').removeAttr("disabled", "disabled");
			
			if( searchParams.get('crowdfundly_donation') !=undefined ){	
				searchParams.set('crowdfundly_campaign', $('#crowdfundly-donate-confirm').data('donate-campaign'));
				searchParams.set('crowdfundly_campaign_id', $('#crowdfundly-donate-confirm').data('donate-campaign-id'));
				searchParams.set('crowdfundly_donation', $(this).data('donate-amount'));
				searchParams.set('crowdfundly_currency', $('#crowdfundly-donate-confirm').data('donate-currency'));
				searchParams.set('crowdfundly_csymbol', $('#crowdfundly-donate-confirm').data('donate-csymbol'));
				$('#crowdfundly-ajax-cart').attr('href', '?'+searchParams.toString());			
			}			
		});
	}

	function custom_donation() {
		const donate_custom_amount = $(".donate__custom-amount-input");

		donate_custom_amount.keyup(function(e) {
			let searchParams = new URLSearchParams($('#crowdfundly-ajax-cart').attr('href'));	
			$('.donate__amount-inner').removeClass('selected');

			if( $(this).val() == 0 || $(this).val() === '' ) {	
				$('#crowdfundly-donate-confirm').attr("disabled", "disabled");
			} else {
				$('#crowdfundly-donate-confirm').removeAttr("disabled", "disabled");
			}

			if( searchParams.get('crowdfundly_donation') !=undefined ){			
				searchParams.set('crowdfundly_donation', $(this).val());
				searchParams.set('crowdfundly_campaign', $('#crowdfundly-donate-confirm').data('donate-campaign'));
				searchParams.set('crowdfundly_campaign_id', $("#crowdfundly-donate-confirm").data('donate-campaign-id'));
				searchParams.set('crowdfundly_currency', $("#crowdfundly-donate-confirm").data('donate-currency'));
				searchParams.set('crowdfundly_csymbol', $("#crowdfundly-donate-confirm").data('donate-csymbol'));				
				$('#crowdfundly-ajax-cart').attr('href', '?'+searchParams.toString());				
			}
		});
	}

	// single campaign contribute
	const campaign_contribute = $("#campaign-contribute-btn");
	if ( campaign_contribute ) {
		campaign_contribute.click(function(e) {
			e.preventDefault();
			const $self = $(this);

			const donate = $("#crowdfundly-donation-modal");
			const donate_close = $(".donate__close");

			donate.addClass('show-modal');
			donate_close.click(function(e) {
				e.preventDefault();
				$(".donate__custom-amount-input").val('');
				donate.removeClass('show-modal');
			});

			donation_presets();
			custom_donation();

			$('#crowdfundly-donate-confirm').click(function(e) {
				$(this).attr("disabled", "disabled");
			});
		});			

	}

	const reward_presets = function() {
		const custom_reward_btn = $('#reward-contribution-btn');
		const reward_form = $('.reward-form');
		const reward_items = $('.reward-items');
		const reward_presets = $('.reward-presets');
		const contribution_heading = $('.contribution-heading');
		const donate_custom_amount = $('.donate__custom-amount-input');

		custom_reward_btn.click(function(e) { 
			$(this).parent().addClass('hide');
			reward_form.addClass('hide');
			reward_items.addClass('hide');
			reward_presets.addClass('show');
			contribution_heading.css('display', 'none');

			const donate_amount = $(".donate__amount");
			donate_amount.click(function(e) {
				donate_custom_amount.val('');
				donate_custom_amount.parent().removeClass('focus');

				$('.donate__amount-inner').removeClass('selected');
				$(this).find('.donate__amount-inner').addClass('selected');
				$('#crowdfundly-donate-btn').removeAttr("disabled", "disabled");
				
				let searchParams = new URLSearchParams($('#crowdfundly-ajax-cart').attr('href'));	
				if( searchParams.get('crowdfundly_donation') !=undefined ) {
					searchParams.set('crowdfundly_donation', $(this).data('donate-amount'));
					searchParams.set('crowdfundly_campaign', $('#crowdfundly-donate-btn').data('donate-campaign'));
					searchParams.set('crowdfundly_campaign_id', $('#crowdfundly-donate-btn').data('donate-campaign-id'));
					searchParams.set('crowdfundly_currency', $("#crowdfundly-donate-btn").data('donate-currency'));
					searchParams.set('crowdfundly_csymbol', $("#crowdfundly-donate-btn").data('donate-csymbol'));				
					$('#crowdfundly-ajax-cart').attr('href', '?'+searchParams.toString());			
				}
			});
		});

		donate_custom_amount.keyup(function(e) {
			$('.donate__amount-inner').removeClass('selected');
			
			if ( donate_custom_amount.val() == 0 || donate_custom_amount.val() === '' ) {			
				$('#crowdfundly-donate-btn').attr("disabled", "disabled");	
			} else {
				$('#crowdfundly-donate-btn').removeAttr("disabled", "disabled");
			}
			$('#crowdfundly-donate-btn').removeClass('selected');

			// const rewardInput = $('#reward_contribution_input');
			// if ( rewardInput.val() != '' || rewardInput.val() != 0  ) {
			// 	get_product(rewardInput.val());
			// }
		});

		const crowdfundly_donate_btn = $('#crowdfundly-donate-btn');
		crowdfundly_donate_btn.click(function(e) {
			const reward_presets = $('.reward-presets');
			reward_presets.removeClass('show');
			$('.back-modal').removeClass('show-modal');

			let searchParams = new URLSearchParams($('#crowdfundly-ajax-cart').attr('href'));
			if ( $('.donate__custom-amount-input').val() != '' && searchParams.get('crowdfundly_donation') != undefined ) {
				searchParams.set('crowdfundly_donation', $('.donate__custom-amount-input').val());
				searchParams.set('crowdfundly_campaign', $('#crowdfundly-donate-btn').data('donate-campaign'));
				searchParams.set('crowdfundly_campaign_id', $('#crowdfundly-donate-btn').data('donate-campaign-id'));
				searchParams.set('crowdfundly_currency', $("#crowdfundly-donate-btn").data('donate-currency'));
				searchParams.set('crowdfundly_csymbol', $("#crowdfundly-donate-btn").data('donate-csymbol'));				
				$('#crowdfundly-ajax-cart').attr('href', '?'+searchParams.toString());		
			}
		});
	}

	function get_reward_product() {
		const getNow = $('.reward-get-product');
		
		if ( getNow ) {
			getNow.each( function(index) {
				$(this).click(function(e) {
					const productPrice = $(this).data('donate-reward-product-price');
					const rewardInputField = $('#reward-contribution-input').val() != '' ? $('#reward-contribution-input').val() : 0;
	
					let searchParams = new URLSearchParams($(this).attr('href'));
					if ( searchParams.get('crowdfundly_donation') != undefined ) {
						searchParams.set('crowdfundly_donation', parseInt(productPrice) + parseInt(rewardInputField));
						searchParams.set('crowdfundly_campaign', $(this).data('donate-campaign'));
						searchParams.set('crowdfundly_campaign_slug', $(this).data('donate-campaign-slug'));
						searchParams.set('crowdfundly_campaign_id', $(this).data('donate-campaign-id'));
						searchParams.set('crowdfundly_currency', $(this).data('donate-currency'));
						searchParams.set('crowdfundly_csymbol', $(this).data('donate-csymbol'));
						searchParams.set('crowdfundly_offer_id', $(this).data('donate-offer-id'));
						// searchParams.set('crowdfundly_shipping_info', $(this).data('donate-sipping-info'));
						$(this).attr('href', '?' + searchParams.toString());
					}
				});
			});
		}
	}

	// reward modal
	const campaign_reward_btn = $("#campaign-reward-btn");
	if ( campaign_reward_btn ) {
		
		campaign_reward_btn.click(function(e) {
			e.preventDefault();
			
			const reward_modal = $(".back-modal");
			const reward_modal_close = $('.reward-modal-close');
			const reward_contribution_btn = $('#reward-contribution-btn');
			const reward_contribution_input = $('#reward-contribution-input');

			reward_modal.addClass('show-modal');

			reward_contribution_input.val('');
			reward_contribution_input.keyup(function(e) {
				$('.donate__amount-inner').removeClass('selected');

				if( $(this).val() == 0 || $(this).val() === '' ) {			
					reward_contribution_btn.attr("disabled", "disabled");	
				} else {
					$('.donate__custom-amount-input').val($(this).val());
					reward_contribution_btn.removeAttr("disabled", "disabled");
				}								
			});

			reward_presets();
			get_reward_product();

			reward_modal_close.click(function(e) {
				e.preventDefault();
				reward_modal.removeClass('show-modal');

				const reward_presets = $('.reward-presets');
				if ( reward_presets ) {
					reward_presets.removeClass('show');
					$('.contribution-heading').css('display', 'block');
					$('.reward-form').removeClass('hide');
					$('.reward-items').removeClass('hide');
					$('.reward-btn-wrapper').removeClass('hide');
				}
			});
		});	
	}

	const campaign_get_reward = $('.crowdfundly-get-reward');
	if ( campaign_get_reward ) {
		campaign_get_reward.click(function(e) {
			e.preventDefault();
			let reward_url = $(this).data('reward-url');
			if(reward_url !='' || reward_url !=undefined){
				window.location.href = reward_url;
			}
		});
	}

	$(document).on('change', '#crowdfundly_shipping_amount', function(event){
		event.preventDefault()

		let shipping_text= $( "#crowdfundly_shipping_amount option:selected" ).text();
		if (shipping_text.indexOf('-') > -1)
		{
			let shipping_address = shipping_text.substr(0, shipping_text.indexOf('-'));
			$('#crowdfundly_shipping_location').val(shipping_address);

			let data = {
				action : 'crowdfundly_update_cart',
				crowdfundly_shipping_fee : $( "#crowdfundly_shipping_amount").val()
			}
			$.post(crowdfundlyPublicData.ajax_url, data, function(response) {
				jQuery(document.body).trigger('update_checkout');
			});			
		} 
		
	})

	// all camps load more
	const crowdfundly_all_camp_loadmore = $("#crowdfundly-all-camp-loadmore");
	if ( crowdfundly_all_camp_loadmore ) {

		let current_page = 1;
		crowdfundly_all_camp_loadmore.click(function() {
			const $self = $(this);

			current_page += 1;
			const target_div = $('#all-camp-row');
			const last_page = $(this).data('last-page');

			$self.text(crowdfundlyPublicData.loading);
			$self.attr('disabled', true);
			$.ajax({
				url: crowdfundlyPublicData.ajax_url,
				type: 'POST',
				data: {
					action: "crowdfundly_all_campaign_load_more",
					security: crowdfundlyPublicData.nonce,
					grid_column: $(this).data('column'),
					per_page: $(this).data('per-page'),
					current_page: current_page,
				},
				success: function(response) {
					$(response).appendTo(target_div);

					if( last_page == current_page ) {
						setTimeout( function() {
							$self.css({"display": "none"});
						}, 300 );
					}
					$self.text(crowdfundlyPublicData.load_more);
					$self.removeAttr('disabled');
				},
				error: function(error) {
					console.log(error);
					$self.text(crowdfundlyPublicData.load_more);
					$self.removeAttr('disabled');
				}
			});
		});
	}

})( jQuery );
