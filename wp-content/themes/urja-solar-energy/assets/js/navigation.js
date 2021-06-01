/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */

jQuery(function($){
 	"use strict";
   	jQuery('.main-menu-navigation > ul').superfish({
		delay:       500,
		animation:   {opacity:'show',height:'show'},  
		speed:       'fast'
   });
});

function urja_solar_energy_open() {
	jQuery(".sidenav").addClass("open");
}
function urja_solar_energy_close() {
  	jQuery(".sidenav").removeClass("open");
}

function urja_solar_energy_menuAccessibility() {
	var links, i, len,
	    urja_solar_energy_menu = document.querySelector( '.nav-menu' ),
	    urja_solar_energy_iconToggle = document.querySelector( '.nav-menu ul li:first-child a' );
    
	let urja_solar_energy_focusableElements = 'button, a, input';
	let urja_solar_energy_firstFocusableElement = urja_solar_energy_iconToggle; // get first element to be focused inside menu
	let urja_solar_energy_focusableContent = urja_solar_energy_menu.querySelectorAll(urja_solar_energy_focusableElements);
	let urja_solar_energy_lastFocusableElement = urja_solar_energy_focusableContent[urja_solar_energy_focusableContent.length - 1]; // get last element to be focused inside menu

	if ( ! urja_solar_energy_menu ) {
    	return false;
	}

	links = urja_solar_energy_menu.getElementsByTagName( 'a' );

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
	    links[i].addEventListener( 'focus', toggleFocus, true );
	    links[i].addEventListener( 'blur', toggleFocus, true );
	}

	// Sets or removes the .focus class on an element.
	function toggleFocus() {
      	var self = this;

      	// Move up through the ancestors of the current link until we hit .mobile-menu.
      	while (-1 === self.className.indexOf( 'nav-menu' ) ) {
	      	// On li elements toggle the class .focus.
	      	if ( 'li' === self.tagName.toLowerCase() ) {
	          	if ( -1 !== self.className.indexOf( 'focus' ) ) {
	          		self.className = self.className.replace( ' focus', '' );
	          	} else {
	          		self.className += ' focus';
	          	}
	      	}
	      	self = self.parentElement;
      	}
	}
    
	// Trap focus inside modal to make it ADA compliant
	document.addEventListener('keydown', function (e) {
	    let isTabPressed = e.key === 'Tab' || e.keyCode === 9;

	    if ( ! isTabPressed ) {
	    	return;
	    }

	    if ( e.shiftKey ) { // if shift key pressed for shift + tab combination
	      	if (document.activeElement === urja_solar_energy_firstFocusableElement) {
		        urja_solar_energy_lastFocusableElement.focus(); // add focus for the last focusable element
		        e.preventDefault();
	      	}
	    } else { // if tab key is pressed
	    	if (document.activeElement === urja_solar_energy_lastFocusableElement) { // if focused has reached to last focusable element then focus first focusable element after pressing tab
		      	urja_solar_energy_firstFocusableElement.focus(); // add focus for the first focusable element
		      	e.preventDefault();
	    	}
	    }
	});   
}

jQuery(function($){
	$('.mobile-menu').click(function () {
	    urja_solar_energy_menuAccessibility();
	});
	$('.search-toggle').click(function () {
	    suraksha_security_guard_search_focus();
  	});
});

function suraksha_security_guard_search_open() {
	jQuery(".search-outer").addClass('show');
}
function suraksha_security_guard_search_close() {
	jQuery(".search-outer").removeClass('show');
}

function suraksha_security_guard_search_focus() {
	var links, i, len,
	    suraksha_security_guard_search = document.querySelector( '.search-outer' ),
	    suraksha_security_guard_iconToggle = document.querySelector( '.search-outer input[type="search"]' );
	    
	let suraksha_security_guard_focusableElements = 'button, a, input';
	let suraksha_security_guard_firstFocusableElement = suraksha_security_guard_iconToggle; // get first element to be focused inside menu
	let suraksha_security_guard_focusableContent = suraksha_security_guard_search.querySelectorAll(suraksha_security_guard_focusableElements);
	let suraksha_security_guard_lastFocusableElement = suraksha_security_guard_focusableContent[suraksha_security_guard_focusableContent.length - 1]; // get last element to be focused inside menu

	if ( ! suraksha_security_guard_search ) {
    	return false;
	}

	links = suraksha_security_guard_search.getElementsByTagName( 'a' );

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
	    links[i].addEventListener( 'focus', toggleFocus, true );
	    links[i].addEventListener( 'blur', toggleFocus, true );
	}

	// Sets or removes the .focus class on an element.
	function toggleFocus() {
      	var self = this;

      	// Move up through the ancestors of the current link until we hit .mobile-menu.
      	while (-1 === self.className.indexOf( 'search-outer' ) ) {
	      	// On li elements toggle the class .focus.
	      	if ( 'li' === self.tagName.toLowerCase() ) {
	          	if ( -1 !== self.className.indexOf( 'focus' ) ) {
	          		self.className = self.className.replace( ' focus', '' );
	          	} else {
	          		self.className += ' focus';
	          	}
	      	}
	      	self = self.parentElement;
      	}
	}
    
	// Trap focus inside modal to make it ADA compliant
	document.addEventListener('keydown', function (e) {
	    let isTabPressed = e.key === 'Tab' || e.keyCode === 9;

	    if ( ! isTabPressed ) {
	    	return;
	    }

	    if ( e.shiftKey ) { // if shift key pressed for shift + tab combination
	      	if (document.activeElement === suraksha_security_guard_firstFocusableElement) {
		        suraksha_security_guard_lastFocusableElement.focus(); // add focus for the last focusable element
		        e.preventDefault();
	      	}
	    } else { // if tab key is pressed
	    	if (document.activeElement === suraksha_security_guard_lastFocusableElement) { // if focused has reached to last focusable element then focus first focusable element after pressing tab
		      	suraksha_security_guard_firstFocusableElement.focus(); // add focus for the first focusable element
		      	e.preventDefault();
	    	}
	    }
	});   
}