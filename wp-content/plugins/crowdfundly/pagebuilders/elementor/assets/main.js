;(function ($) {

	var $window = $(window);

	$window.on('elementor/frontend/init', function() {

		var ModuleHandler = elementorModules.frontend.handlers.Base;
		var HeaderSlider = ModuleHandler.extend({

			bindEvents: function() {
				this.run();
			},

			getDefaultSettings: function() {
				return {
					container   : '.org-slider',
					autoplay    : true,
					arrows      : false,
					dots        : false,
					infinite    : true,
					slidesToShow: 1,
					fade: true,
				}
			},

			getDefaultElements: function () {
				return {
					$container: this.findElement(this.getSettings('container'))
				};
			},
			
			run: function() {
				this.elements.$container.slick(this.getDefaultSettings());
			}
		});

		// var gallery = $('.gallery-slider');
		// var galleryNav = $('.gallery-slider-nav');
		// var GallerySlider = ModuleHandler.extend({

		// 	bindEvents: function() {
		// 		this.run();
		// 	},

		// 	getDefaultSettings: function() {
		// 		return {
		// 			// container   : '.gallery-slider',
		// 			autoplay    : true,
		// 			arrows      : false,
		// 			dots        : false,
		// 			infinite    : true,
		// 			slidesToShow: 1,
		// 			fade: true,
		// 			asNavFor: '.gallery-slider-nav'
		// 		}
		// 	},

		// 	navSettings: function() {
		// 		return {
		// 			// container   : '.gallery-slider-nav',
		// 			slidesToShow: 4,
		// 			slidesToScroll: 1,
		// 			asNavFor: '.gallery-slider',
		// 			dots: false,
		// 			focusOnSelect: true
		// 		}
		// 	},

		// 	getDefaultElements: function () {
		// 		return {
		// 			$container: this.findElement(this.getSettings('container'))
		// 		};
		// 	},
			
		// 	run: function() {
		// 		gallery.slick(this.getDefaultSettings());
		// 		galleryNav.slick(this.navSettings());
		// 	}
		// });

		var GallerySlider = function($scope) {
			var gallery = $scope.find('.gallery-slider');
			var galleryNav = $scope.find('.gallery-slider-nav');

			$(gallery[0]).slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false,
				fade: true,
				asNavFor: '.gallery-slider-nav'
			});

			$(galleryNav[0]).slick({
				slidesToShow: 4,
				slidesToScroll: 1,
				asNavFor: '.gallery-slider',
				dots: false,
				focusOnSelect: true
			});
		}

		elementorFrontend.hooks.addAction(
			'frontend/element_ready/crowdfundly-organization.default',
			function ($scope) {
				elementorFrontend.elementsHandler.addHandler(HeaderSlider, {
					$element: $scope
				});
			}
		);

		elementorFrontend.hooks.addAction(
			'frontend/element_ready/crowdfundly-single-campaign.default',
			GallerySlider
		);

	});

} (jQuery));
