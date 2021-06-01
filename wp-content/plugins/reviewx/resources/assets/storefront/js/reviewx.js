(function( $, window, document ) {
	'use strict';

	/*========================================
	* Start pagination defination
	*========================================*/
	var Paginator = function(element, options) {
		this.el = $(element);
		this.options = $.extend({}, $.fn.paginathing.defaults, options);
		if( this.options.page != '' && this.options.page != undefined ) {		
			this.currentPage = this.options.page;
		} else {
			this.currentPage = 1;
		}
		this.startPage = 1;
		//this.totalItems = this.el.children().length;
		this.totalItems = this.options.totalItems;
		this.totalPages = Math.max(Math.ceil(this.options.totalItems / this.options.perPage), this.options.limitPagination);
		this.container = $('<div></div>').addClass(this.options.containerClass);
		this.ul = $('<ul></ul>').addClass(this.options.ulClass);
		this.show(this.startPage);
		return this;
	};

	Paginator.prototype = {
	pagination: function(type, page) {
		var _self = this;
		var li = $('<li></li>');
		var a = $('<a></a>').attr('href', '#');
		var cssClass = type === 'number' ? _self.options.liClass : type;
		var text = '';
		if (type === 'number') {
			text = page;
		} else if (type === 'pageNumbers') {
		//get the page numbers text
		//text = _self.paginationNumbersText();
		} else {
			text = _self.paginationText(type);
		}
		li.addClass(cssClass);
		li.data('pagination-type', type);
		li.data('page', page);
		li.append(a.html(text));	
		return li;
	},

	paginationText: function(type) {
		return this.options[type + 'Text'];
	},

	paginationNumbersText: function() {
		var _self = this;
		return 'Page ' + _self.currentPage + '/' + _self.totalPages;
	},

	buildPagination: function() {
		var _self = this;
		var pagination = [];
		var prev =
		_self.currentPage - 1 < _self.startPage
			? _self.startPage
			: _self.currentPage - 1;
		var next =
		_self.currentPage + 1 > _self.totalPages
			? _self.totalPages
			: _self.currentPage + 1;

		var start, end;
		var limit = _self.options.limitPagination;

		if (limit) {
		if (_self.currentPage <= Math.ceil(limit / 2) + 1) {
			start = 1;
			end = limit;
		} else if (
			_self.currentPage + Math.floor(limit / 2) >=
			_self.totalPages
		) {
			start = _self.totalPages + 1 - limit;
			end = _self.totalPages;
		} else {
			start = _self.currentPage - Math.ceil(limit / 2);
			// end = _self.currentPage + Math.floor(limit / 2);
			end = this.options.page
		}
		} else {
		start = _self.startPage;
		end = _self.totalPages;
		}
		// "First" button
		if (_self.options.firstLast) {
		pagination.push(_self.pagination('first', _self.startPage));
		}
		// "Prev" button
		if (_self.options.prevNext) {
		pagination.push(_self.pagination('prev', prev));
		}

		// Pagination
		for (var i = start; i <= end; i++) {
		pagination.push(_self.pagination('number', i));
		}
		// "Next" button
		if (_self.options.prevNext) {
		pagination.push(_self.pagination('next', next));
		}
		// "Last" button
		if (_self.options.firstLast) {
		pagination.push(_self.pagination('last', _self.totalPages));
		}

		return pagination;
	},

	render: function(page) {
		var _self = this;
		var options = _self.options;
		var pagination = _self.buildPagination();
		// Remove children before re-render (prevent duplicate)
		_self.ul.children().remove();
		_self.ul.append(pagination);
		// Manage active DOM
		var startAt = page === 1 ? 0 : (page - 1) * options.perPage;
		var endAt = page * options.perPage;
		_self.el.children().hide();
		_self.el
		.children()
		.slice(startAt, endAt)
		.show();
		// Manage active state
		_self.ul.children().each(function() {			
			var _li = $(this);
			var type = _li.data('pagination-type');
		
			switch (type) {
				case 'number':
				if ( _li.data('page') === _self.options.page ) {
					_li.addClass(options.activeClass);	  
				}
				break;
				case 'first':
				page === _self.startPage && _li.toggleClass(options.disabledClass);
				break;
				case 'last':
				page === _self.totalPages && _li.toggleClass(options.disabledClass);
				break;
				case 'prev':
				page - 1 < _self.startPage &&
					_li.toggleClass(options.disabledClass);
				break;
				case 'next':
				page + 1 > _self.totalPages &&
					_li.toggleClass(options.disabledClass);
				break;
				default:
				break;
			}
		});

		// If insertAfter is defined
		if (options.insertAfter) {
		_self.container.append(_self.ul).insertAfter($(options.insertAfter));
		} else {
		_self.el.after(_self.container.append(_self.ul));
		}
	},

	handle: function() {
		var _self = this;
		_self.container.find('li').each(function() {
			var _li = $(this);
			_li.click(function(e) {
				e.preventDefault();
				var page = _li.data('page');				
				_self.currentPage = page;	
				_self.review(page);
			});
		  });
	},
	review: function(page) {
		$('.rx_double_spinner').show();

		$.ajax({
			url: rx_ajax_data.ajax_url,
			type: 'post',
			data: {
				action: 'rx_sorting',
				selected: $('select.rx_shorting').children("option:selected").val(),
				rx_product_id: $('.rx_product_id').val(),
				security: $(".rx-sort-nonce").val(),
				rx_post_type: $('#rx-sorting-post-type').val(),
				rx_pagination: $('#rx-allow-shortcode-pagination').val(),
				page: page,
				per_page: $('#rx-pagination-limit').val(),
				rx_rating: $('#rx-product-rating').val(),
				user_id: $('#rx-user-id').val(),
				rx_post_title: $("#rx-product-title").val(),
			},
			success: function (data) {
				$('.rx_listing .rx_double_spinner').hide();
				$('.rx_review_sort_list').html(data);
				rx_image_popup(); //Popup image
			},
			error:function (err) {
				$('.rx_listing .rx_double_spinner').hide();
				console.log( err + 'Error....');
			}
		});			
	},
	show: function(page) {
		var _self = this;
		_self.render(page);
		_self.handle();		  
	},
	};
	
	$.fn.paginathing = function(options) {
	var _self = this;
	return _self.each(function() {
		return new Paginator(this, options);
	});
	};
	
	$.fn.paginathing.defaults = {
		limitPagination: true,
		prevNext: true,
		firstLast: true,
		prevText: '&laquo;',
		nextText: '&raquo;',
		firstText: '<svg style="width: 7px; vertical-align: middle" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-left" class="svg-inline--fa fa-angle-left fa-w-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="currentColor" d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"></path></svg>',
		lastText: '<svg style="width: 7px; vertical-align: middle" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" class="svg-inline--fa fa-angle-right fa-w-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg>',
		containerClass: 'rx_pagination',
		ulClass: 'rx-ul-pagination',
		liClass: 'rx-page',
		activeClass: 'active',
		disabledClass: 'disabled',
		insertAfter: null,
		pageNumbers: true,
	};
	/*========================================
	* End pagination defination
	*========================================*/	
	
	$(document).ready( function() {
		let total_reviews 		 = $('#rx-total-review').val();	
		let rx_pagination_limit  = $("#rx-pagination-limit").val();
		rx_pagination_limit 	 = parseInt(rx_pagination_limit);
		let perPage 			 = Math.ceil(parseInt(total_reviews) / rx_pagination_limit);
		let limitPagination      = 5;
		if( limitPagination > perPage ) {
			limitPagination = perPage;
		}

		if(total_reviews > rx_pagination_limit ) {
			$('#rx-commentlist').paginathing({
				totalItems: total_reviews,
				perPage: rx_pagination_limit,
				limitPagination: limitPagination,                                    
				page:1, 
				pageNumbers: true                                   
			})
		}
	}); 	

	/*========================================
	* Load add review form
	*========================================*/
	$(".review-on").on('click', function(){

		$('#prod-link').attr('href', $(this).attr("data-product_url"));
		$('#prod-url').attr('href', $(this).attr("data-product_url"));
		$("#prod-order").text($(this).attr("data-order_id"));
		$("#prod-order-status").text($(this).attr("data-order_status"));
		$("#img-thumb").attr("src",$(this).attr("data-product_img"));
		$("#prod-name").text($(this).attr("data-product_name"));
		$("#prod-qty").text($(this).attr("data-product_quantity"));
		$("#prod-price").text($(this).attr("data-product_price"));
		$("#rx-order-id").val($(this).attr("data-order_id"));
		$("#rx-product-id").val($(this).attr("data-product_id"));

		$("#rx-order-table").hide();
		$("#rx-form").removeClass('hide');
		$(".woocommerce-MyAccount-navigation").hide();
		$(".woocommerce-MyAccount-content").addClass('rx-full-width');
		$(".woocommerce-Pagination").hide();

	});

	$(".rx-cancel").on('click', function(){
		$("#rx-form").addClass('hide');
		$(".woocommerce-MyAccount-navigation").show();
		$(".woocommerce-MyAccount-content").removeClass('rx-full-width');
		$("#rx-order-table").show();
		$(".woocommerce-Pagination").show();
		$("#reviewx_title").val("");
		$("#rx-text").val("");
		$("#rx-text-error").html("");
		$("#rx-rating-error").html("");
	});

	/*========================================
	* Call image uploader for add review
	*========================================*/
	$(document).ready( function() {
		let file_frame; // variable for the wp.media file_frame
		let attachment;
		// attach a click event (or whatever you want) to some element on your page
		$( '#rx-upload-photo' ).on( 'click', function( event ) {
			event.preventDefault();

			// if the file_frame has already been created, just reuse it
			if ( file_frame ) {
				file_frame.open();
				return;
			}

			file_frame = wp.media.frames.file_frame = wp.media({
				title: $( this ).data( 'uploader_title' ),
				button: {
					text: $( this ).data( 'uploader_button_text' ),
				},
				multiple: $(this).data('multiple') // set this to true for multiple file selection
			});

			file_frame.on( 'select', function() {
				attachment = file_frame.state().get('selection').toJSON();
				let wrapper = $('#rx-images'); //Input image wrapper
				$('#rx-images').removeClass('hide');
				$.each(attachment, function(index, value){
					if( $('#rx-upload-photo').data('multiple') == true ) {
						$(wrapper).prepend('<div class="rx-image"><img src="'+value.url+'" alt=""><a href="javascript:void(0);" class="remove_image" title="Remove Image"><svg style="width: 15px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" class="svg-inline--fa fa-times-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path></svg></a><input type="hidden" name="rx-image" value="'+value.id+'"></div>'); // display image
					} else {
						$(wrapper).find('.rx-image').remove();
						$(wrapper).prepend('<div class="rx-image"><img src="'+value.url+'" alt=""><a href="javascript:void(0);" class="remove_image" title="Remove Image"><svg style="width: 15px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" class="svg-inline--fa fa-times-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path></svg></a><input type="hidden" name="rx-image" value="'+value.id+'"></div>'); // display image
					}
					
				});
			});

			file_frame.open();
		});

		let wrapper = $('#rx-images'); //Input image wrapper
		$(wrapper).on('click', '.remove_image', function(e){ //Once remove button is clicked
			e.preventDefault();
			$(this).parent().remove(); //Remove image
		});

		// Edit review
		let edit_file_frame; // variable for the wp.media file_frame
		let edit_attachment;
		// attach a click event (or whatever you want) to some element on your page
		$( '#rx-edit-photo' ).on( 'click', function( event ) {
			event.preventDefault();

			// if the file_frame has already been created, just reuse it
			if ( edit_file_frame ) {
				edit_file_frame.open();
				return;
			}

			edit_file_frame = wp.media.frames.edit_file_frame = wp.media({
				title: $(this).data( 'uploader_title' ),
				button: {
					text: $(this).data( 'uploader_button_text' ),
				},
				multiple: $(this).data('multiple') // set this to true for multiple file selection
			});

			edit_file_frame.on( 'select', function() {
				edit_attachment = edit_file_frame.state().get('selection').toJSON();
				let wrapper = $('#rx-edit-images'); //Input image wrapper
				$('#rx-edit-images').removeClass('hide');
				$.each(edit_attachment, function(index, value){
					if( $('#rx-edit-photo').data('multiple') == true ){
						$(wrapper).prepend('<div class="rx-edit-image"><img src="'+value.url+'" alt=""><a href="javascript:void(0);" class="remove_edit_image" title="Remove Image"><svg style="width: 15px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" class="svg-inline--fa fa-times-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path></svg></a><input type="hidden" name="rx-edit-image" value="'+value.id+'"></div>'); // display image
					} else {
						$(wrapper).html("");
						$(wrapper).prepend('<div class="rx-edit-image"><img src="'+value.url+'" alt=""><a href="javascript:void(0);" class="remove_edit_image" title="Remove Image"><svg style="width: 15px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" class="svg-inline--fa fa-times-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path></svg></a><input type="hidden" name="rx-edit-image" value="'+value.id+'"></div>'); // display image
					}
				});
			});

			edit_file_frame.open();
		});

		let edit_wrapper = $('#rx-edit-images'); //Input image wrapper
		$(edit_wrapper).on('click', '.remove_edit_image', function(e){ //Once remove button is clicked
			e.preventDefault();
			$(this).parent().remove(); //Remove image
		});
	});

	/*========================================
	* Review submit from my account
	*========================================*/	

	$("#rx-submit").on('click', function(){

		let formInput 			= $("#rx-form input");	 // grab all input field
		let review_title 		= $("#reviewx_title").val();  // grab review text
		let review_text 		= $("#rx_text").val();  // grab review text
		let media_compliance 	= $("#rx_allow_media_compliance");
 
		if( review_title == "" ){
			$("#rx-review-title-error").html(rx_ajax_data.rx_review_title_error);
		} else if( review_text == "" ){
			$("#rx_text").focus();
			$("#rx-review-text-error").html(rx_ajax_data.rx_review_text_error);
		} else if( media_compliance.length != 0 && media_compliance.prop('checked') == false ){			
			$("#rx-media-compliance-error").html(rx_ajax_data.please_accept_agreement);
		} else {
			
			$("#rx-submit").attr("disabled", true);
			$("#rx-cancel").attr("disabled", true);
			$(".rx-lds-css").show();

			let data = formInput.serializeArray();
			data.push({ 
				name: 'rx-video-source-control',
				value: $('#rx-video-source-control').val() 
			});

			$.ajax({
				url: rx_ajax_data.ajax_url,
				type: 'post',
				data: {
					action: 'review_submit_from_myorder',
					forminput: data,
					rx_review_text: $("#rx_text").val(),
					security: $("#rx-nonce").val()
				},
				success: function (data) {
					$(".rx-lds-css").hide();
					$("#rx-submit").attr("disabled", false);
					$(".rx-cancel").attr("disabled", false);

					if( data.success == true ) {	
						$("#rx-submit").parent().siblings().closest('.rx-form-submit-status').fadeIn().addClass('success').text(rx_ajax_data.review_success_msg);
						if( data.status == 0 ){
							$("#rx-submit").parent().siblings().closest('.rx-form-submit-notice').fadeIn().addClass('rx-notice').html(rx_ajax_data.review_status_msg);
						}						
						setTimeout(function() { 
							window.location.reload();
						}, 1800);
					} else if( data.success == false ) {	
						$("#rx-submit").parent().siblings().closest('.rx-form-submit-status').fadeIn().addClass('error').text(rx_ajax_data.review_failed_msg);
					} else {
						$("#rx-submit").parent().siblings().closest('.rx-form-submit-status').fadeIn().addClass('error').html(data).text();
					}
				},
				error:function(err) {
					$(".rx-lds-css").hide();
					$("#rx-submit").attr("disabled", false);
					$(".rx-cancel").attr("disabled", false);
				}
			});
		}

	});
	
	/*========================================
	 * Function for default review open image
	 *========================================*/	
	function rx_image_popup(){
		//if( rx_ajax_data.theme_name != 'porto' ){
			$('.popup-link').magnificPopup({
				delegate: 'a',
				type: 'image',
				tLoading: 'Loading image #%curr%...',
				mainClass: 'mfp-img-mobile',
				gallery: {
					enabled: true,
					navigateByImgClick: true,
					preload: [0,1]
				},
				image: {
					tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
				}
			});
		//}
	}

	$(document).ready( function() {
		if($(".rx_review_sort_list").hasClass("popup-link")){		
			$('.popup-link').magnificPopup({
				delegate: 'a',
				type: 'image',
				tLoading: 'Loading image #%curr%...',
				mainClass: 'mfp-img-mobile',
				gallery: {
					enabled: true,
					navigateByImgClick: true,
					preload: [0,1]
				},
				image: {
					tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
				}
			});
		}
	});

	/*========================================
	 * Horizontal bar
	 *========================================*/	
	$('.rx-horizontal .progress-fill span').each(function(){
		var percent = $(this).html();
		$(this).parent().css('width', percent);
	});

	/*========================================
	 * Review ordering filter
	 *========================================*/
	$(document).ready( function() {
		$(document).on('change', "select.rx_shorting", function () {
			$('.rx_double_spinner').show();
			$.ajax({
				url: rx_ajax_data.ajax_url,
				type: 'post',
				data: {
					action: 'rx_sorting',
					selected: $(this).children("option:selected").val(),
					rx_product_id: $('.rx_product_id').val(),
					security: $(".rx-sort-nonce").val(),
					rx_post_type: $('#rx-sorting-post-type').val(),
					rx_pagination: $('#rx-allow-shortcode-pagination').val(),
					page: 1,
					per_page: $('#rx-pagination-limit').val(),
					rx_rating: $('#rx-product-rating').val(),
					user_id: $('#rx-user-id').val(),
					rx_post_title: $("#rx-product-title").val(),
				},
				success: function (data) {

					$('.rx_listing .rx_double_spinner').hide();
					$('.rx_review_sort_list').html( data  );
					rx_image_popup(); //Popup image
				},
				error:function (err) {
					$('.rx_listing .rx_double_spinner').hide();
					console.log( err + 'Error....');
				}
			});
		});
		
		$(document).on('click', ".rx-tooltip", function () {
			$('.rx_double_spinner').show();
			let rating = $(this).data('rating');
			$('#rx-product-rating').val(rating);
			$.ajax({
				url: rx_ajax_data.ajax_url,
				type: 'post',
				data: {
					action: 'rx_sorting',
					selected: 'tooltip_filter',
					rx_product_id: $('.rx_product_id').val(),
					security: $(".rx-sort-nonce").val(),
					rx_post_type: $('#rx-sorting-post-type').val(),
					rx_pagination: $('#rx-allow-shortcode-pagination').val(),
					page: 1,
					per_page: $('#rx-pagination-limit').val(),
					rx_rating: rating,
					user_id: $('#rx-user-id').val(),
					rx_post_title: $("#rx-product-title").val(),
				},
				success: function (data) {
					$('.rx_listing .rx_double_spinner').hide();
					$('.rx_review_sort_list').html( data  );
					rx_image_popup(); //Popup image
				},
				error:function (err) {
					$('.rx_listing .rx_double_spinner').hide();
					console.log( err + 'Error....');
				}
			});
		});
	});

	/*========================================
	 * Progress bar 
	 *========================================*/
	$('.rx_style_one_progress-value > span').each(function(){
		$(this).prop('Counter',0).animate({
			Counter: $(this).text()
		},{
			duration: 1500,
			easing: 'swing',
			step: function (now){
				$(this).text(Math.ceil(now));
			}
		});
	});

	$(document).ready(function() {

	/*========================================
	 * Call image uploader
	 *========================================*/			
		$('.rx-popup-video').magnificPopup({
			disableOn: 700,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false,
			iframe: {
				patterns: {
					youtube_short: {
						index: 'youtu.be/',
						id: 'youtu.be/',
						src: '//www.youtube.com/embed/%id%?autoplay=1'
					}
				}
			}			
		});

				
		//Front-end review image upload
		let file_frame; // variable for the wp.media file_frame
		let attachment;
		$(document).on('click', '#attachment', function(event) { 
			event.preventDefault();
			if ( file_frame ) {
				file_frame.open();
				return;
			}

			file_frame = wp.media.frames.file_frame = wp.media({
				title: $( this ).data( 'uploader_title' ),
				button: {
					text: $( this ).data( 'uploader_button_text' ),
				},
				multiple: $(this).data('multiple') // set this to true for multiple file selection
			});

			file_frame.on( 'select', function() {
				attachment = file_frame.state().get('selection').toJSON();
				let wrapper = $('#rx-images'); //Input image wrapper
				$('#rx-images').removeClass('hide');
				$.each(attachment, function(index, value) {

					if( $('#attachment').data('multiple') == true ) {
						$(wrapper).prepend('<div class="rx-image"><img src="'+value.url+'" alt=""><a href="javascript:void(0);" class="remove_image" title="Remove Image"><svg style="width: 15px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" class="svg-inline--fa fa-times-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path></svg></a><input type="hidden" name="rx-image[]" value="'+value.id+'"></div>'); // display image
					} else {
						$(wrapper).html("");
						$(wrapper).prepend('<div class="rx-image"><img src="'+value.url+'" alt=""><a href="javascript:void(0);" class="remove_image" title="Remove Image"><svg style="width: 15px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" class="svg-inline--fa fa-times-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path></svg></a><input type="hidden" name="rx-image[]" value="'+value.id+'"></div>'); // display image
					}
				});
			});

			file_frame.open();
		});

		/*********************************
		 * Review form validation
		 ********************************/
		$('#comment').attr('name', 'comment');
		$("#attachmentForm").validate({
			rules: {
				author: "required",
				email: {
					required: true,
					email: true,
					regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
				},
				reviewx_title: "required",
				comment: "required",
				rx_allow_media_compliance: "required",
			},
			messages: {
				author: rx_ajax_data.please_enter_name,
				email: rx_ajax_data.please_enter_email,
				reviewx_title: rx_ajax_data.please_enter_title,
				comment: rx_ajax_data.please_reave_message,
				rx_allow_media_compliance: rx_ajax_data.please_accept_agreement				
			},
			submitHandler: function(form) {}
		});

		$.validator.addMethod(
			/* The value you can use inside the email object in the validator. */
			"regex",
		
			/* The function that tests a given string against a given regEx. */
			function(value, element, regexp)  {
				/* Check if the value is truthy (avoid null.constructor) & if it's not a RegEx. (Edited: regex --> regexp)*/
		
				if (regexp && regexp.constructor != RegExp) {
				   /* Create a new regular expression using the regex argument. */
				   regexp = new RegExp(regexp);
				}
		
				/* Check whether the argument is global and, if so set its last index to 0. */
				else if (regexp.global) regexp.lastIndex = 0;
		
				/* Return whether the element is optional or the result of the validation. */
				return this.optional(element) || regexp.test(value);
			}
		);

		/*********************************
		 * 	Review form AJAX submission
		 *********************************/
		$(document).on('click', "#attachmentForm input[type=submit], #attachmentForm #submit", function (event) {
			event.preventDefault();

			let reCaptcha = null;

			if (parseInt($("#enable_recaptcha").val())) {
				reCaptcha = window.grecaptcha.getResponse();
				if (reCaptcha.length === 0) {
					$('.rx-form-submit-status.error').remove();
					$("#submit").parent().before("<div class='rx-form-submit-status error' style='display:block;'>re-Captcha required!</div>");
					return;
				}
			}

			if ($('#attachmentForm').valid()) {
				$(this).prop('disabled', true);
				//AJAX form submit
				let formInput 			= $("#attachmentForm input");	 // grab all input field
				let data 				= formInput.serializeArray();

				if (reCaptcha) {
					data.push({
						name: 'recaptcha-token',
						value: reCaptcha
					})
				}

				data.push({ 
					name: 'rx-video-source-control',
					value: $('#rx-video-source-control').val() 
				});	

				$.ajax({
					url: rx_ajax_data.ajax_url,
					type: 'post',
					data: {
						action: 'rx_front_end_review_submit',
						formInput: data,
						rx_review_text: $("#comment").val(),					
						security: rx_ajax_data.ajax_nonce
					},
					success: function (data) {
						if(data.success == true) {
							$("#attachmentForm input[type=submit]").parent().before("<div class='rx-form-submit-status success' style='display:block;'>"+rx_ajax_data.review_success_msg+"</div>");
							if( data.status == 0 ) {
								$("#attachmentForm input[type=submit]").parent().before("<div class='rx-form-submit-status rx-notice' style='display:block;'>"+rx_ajax_data.review_status_msg+"</div>");
							}												
							$("#review_title").val('');
							$("#comment").val('');
							$("#author").val('');
							$("#email").val('');

							setTimeout(function(){ 
								window.location.reload();
							}, 2000);
						} else if(data.success == false) {	
							$("#attachmentForm input[type=submit]").parent().before("<div class='rx-form-submit-status error' style='display:block;'>"+rx_ajax_data.review_failed_msg+"</div>");
						} else {
							$("#attachmentForm input[type=submit]").parent().before("<div class='rx-form-submit-status error' style='display:block;'>"+data+"</div>");
						}
						$("#attachmentForm input[type=submit]").prop('disabled', false);
						
					},
					error:function(err) {
						$("#attachmentForm input[type=submit]").parent().before("<div class='rx-form-submit-status error' style='display:block;'>Sorry something went wrong.</div>");
					}
				});
			}

		});
	});

	//OceanWP theme - lightbox
	window.addEventListener('load', (event) => {
		if($('.rx-popup-video').hasClass('oceanwp-lightbox')){
			$('.rx-popup-video').removeClass('oceanwp-lightbox');
			$('.rx-popup-video').magnificPopup({
				disableOn: 700,
				type: 'iframe',
				mainClass: 'mfp-fade',
				removalDelay: 160,
				preloader: false,
				fixedContentPos: false,
				iframe: {
					patterns: {
						youtube_short: {
						  index: 'youtu.be/',
						  id: 'youtu.be/',
						  src: '//www.youtube.com/embed/%id%?autoplay=1'
						}
					}
				}			
			});
		}

		if(!$('.popup-link a').hasClass('oceanwp-lightbox')){
			rx_image_popup();
		}
	});	
	
	/*========================================
	 * Call for  non logged in user
	 *========================================*/
	$(document).on('change', '#non-logged-attachment', function(){
		
		let wrapper = $('#rx-images'); //Input image wrapper
		let rx_img 		= new FormData();
		var files_data 	= $(this); 
		$.each($(files_data), function(i, obj) {
            $.each(obj.files,function(j,file){
                rx_img.append('files[' + j + ']', file);
            })
        });
		rx_img.append('action', 'rx_guest_review_image_upload');
		rx_img.append('security', rx_ajax_data.ajax_nonce);
		
		$('.rx_image_upload_spinner').show();
		$.ajax({
			url: rx_ajax_data.ajax_url,
			contentType: false,
			processData: false,
			type: 'post',
			data: rx_img,
			success: function (data) {				
				$(wrapper).prepend(data.image);
				if( data.message != null ) {
					$('.rx-guest-attachment-error').text(data.message);
				}
				$('.rx_image_upload_spinner').hide();
			},
			error:function(error){
				$('.rx_image_upload_spinner').hide();
			}
		});
	});

	let wrapper = $('#rx-images'); //Input image wrapper
	$(wrapper).on('click', '.remove_guest_image', function(e){ //Once remove button is clicked
		e.preventDefault();		
		let $that 			= $(this);		
		let attach_id 		= $(this).siblings(".rx-image").val();
		jQuery.ajax({
			url: rx_ajax_data.ajax_url,
			type: 'post',
			data : {
				action: 'rx_remove_guest_image',
				attach_id: attach_id,
				security: rx_ajax_data.ajax_nonce 				
			},         
			success: function( data ) {
				$($that).parent().remove(); //Remove image
			},
			error: function(err){
				console.log(err);
			}
		});		
	});

	$(document).on('click', '.rx-media-upload-button', function(){
		var button = $( this ),
		wrapper = button.parents('.rx-media-field-wrapper'),
		removeButton = wrapper.find('.rx-media-remove-button'),
		imgContainer = wrapper.find('.rx-thumb-container'),
		idField = wrapper.find('.rx-media-id'),
		urlField = wrapper.find('.rx-media-url');
		// Create a new media frame
		var frame = wp.media({
			title: 'Upload Photo',
			button: {
				text: 'Use this photo'
			},
			multiple: false  // Set to true to allow multiple files to be selected
		});
	
		// When an image is selected in the media frame...
		frame.on( 'select', function() {
			// Get media attachment details from the frame state
			var attachment = frame.state().get('selection').first().toJSON();
	
			/**
			 * Set image to the image container
			 */
			imgContainer.addClass('rx-has-thumb').append( '<img src="'+attachment.url+'" alt="" style="max-width:100%;"/>' );
			idField.val( attachment.id ); // set image id
			urlField.val( attachment.url ); // set image url
	
			// Hide the upload button
			button.addClass( 'rx-media-uploader-hidden' );
	
			// Show the remove button
			removeButton.removeClass( 'rx-media-uploader-hidden' );
		});
	
		// Finally, open the modal on click
		frame.open();
	});

	$(document).on( 'click', '.rx-media-remove-button', function(){
		var button = $( this ),
		wrapper = button.parents('.rx-media-field-wrapper'),
		uploadButton = wrapper.find('.rx-media-upload-button'),
		imgContainer = wrapper.find('.rx-has-thumb'),
		idField = wrapper.find('.rx-media-id'),
		urlField = wrapper.find('.rx-media-url');

		imgContainer.removeClass('rx-has-thumb').find('img').remove();

		urlField.val(''); // URL field has to be empty
		idField.val(''); // ID field has to empty as well

		button.addClass('rx-media-uploader-hidden'); // Hide the remove button first
		uploadButton.removeClass('rx-media-uploader-hidden'); // Show the uplaod button
	});

})(jQuery, window, document);