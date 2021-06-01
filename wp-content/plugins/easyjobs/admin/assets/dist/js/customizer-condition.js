(function ($) {
	'use strict';
	/**
	 * Run function when customizer is ready.
	 */
	function customizer_controls_show(setting,controler_name,controler_val){
		wp.customize.control( controler_name, function( control ) { 
			var controler_array = controler_val.split(',');
			var visibility = function() {
				if ( $.inArray(setting.get(), controler_array) > -1 ) {
					control.container.slideDown( 180 );
				} else {
					control.container.slideUp( 180 );
				}
			};           
			visibility();         
			setting.bind( visibility ); 
		});	
	}

	function customizer_controls_hide(setting,controler_name,controler_val){
		wp.customize.control( controler_name, function( control ) {
			var controler_array = controler_val.split(',');
			var visibility = function() {
				if ( $.inArray(setting.get(), controler_array) > -1 ) {
					control.container.slideUp( 180 );
				} else {
					control.container.slideDown( 180 );
				}
			};   
			visibility();   
			setting.bind( visibility ); 
		});	
	}

	function customizer_conditional_setting_return_toggle(setting,controler_name,controler_val){
		wp.customize.control( controler_name, function( control ) { 
			var visibility = function() {
				if ( setting.get() == true ) { 
					control.container.slideDown( 180 );     
				} else {
					control.container.slideUp( 180 );
				}
			};           
			visibility();         
			setting.bind( visibility ); 
		});	
	}

	wp.customize.bind( 'ready', function() {
		var dimensionReset  = jQuery('.easyjobs-dimension .easyjobs-customizer-reset');
		dimensionReset.each(function() {
			$(dimensionReset).on( 'click', function (e) {
				e.preventDefault();
				var dimensionId = $(this).parent('.easyjobs-dimension').attr('id');
				$('.'+dimensionId).each(function() {
					var dimensionDefaultVal = $(this).data('default-val');
					$(this).val(dimensionDefaultVal).trigger('change');
				});
			});
		});

		$('.easyjobs-number-field .easyjobs-customizer-reset').on('click', function(e){
			e.preventDefault();
			var field  = $(this).next('input[type="number"]'),
				defaultVal = field.data('default-val');
			field.val(defaultVal).trigger('change');
		})

	});
})(jQuery);