/**
 * Script run inside a Customizer control sidebar
 */
;(function($) {
    wp.customize.bind('ready', function() {
        rangeSlider();

        var rangeValReset  = jQuery('.crowdfundly-customizer-reset.crowdfundly-range-value');
        rangeValReset.each(function() {
            $(rangeValReset).on( 'click', function (e) {
				e.preventDefault();
				
                var nextRangeselector = $(this).parent().next('.crowdfundly-range-slider');
                nextRangeselector.find('.crowdfundly-range-slider__range').val('').trigger('change');
                nextRangeselector.find('.crowdfundly-range-slider__value').html('');
                
            });
        });
    });

    var rangeSlider = function() {
        var slider = $('.crowdfundly-range-slider'),
            range = $('.crowdfundly-range-slider__range'),
            value = $('.crowdfundly-range-slider__value');

        slider.each(function() {

            value.each(function() {
                var value = $(this).prev().attr('value');
				var suffix = ($(this).prev().attr('suffix')) ? $(this).prev().attr('suffix') : '';
                $(this).html(value + suffix);
            });

            range.on('input', function() {
				var suffix = ($(this).attr('suffix')) ? $(this).attr('suffix') : '';
                $(this).next(value).html(this.value + suffix );
            });
        });
    };

})(jQuery);
