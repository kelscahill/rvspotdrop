function rvspotdrop_menu_open_nav() {
	window.rvspotdrop_responsiveMenu=true;
	jQuery(".sidenav").addClass('show');
}
function rvspotdrop_menu_close_nav() {
	window.rvspotdrop_responsiveMenu=false;
 	jQuery(".sidenav").removeClass('show');
}

jQuery(function($){
 	"use strict";
   	jQuery('.main-menu > ul').superfish({
		delay:       500,
		animation:   {opacity:'show',height:'show'},  
		speed:       'fast'
   	});
});

jQuery(document).ready(function () {
	window.rvspotdrop_currentfocus=null;
  	rvspotdrop_checkfocusdElement();
	var rvspotdrop_body = document.querySelector('body');
	rvspotdrop_body.addEventListener('keyup', rvspotdrop_check_tab_press);
	var rvspotdrop_gotoHome = false;
	var rvspotdrop_gotoClose = false;
	window.rvspotdrop_responsiveMenu=false;
 	function rvspotdrop_checkfocusdElement(){
	 	if(window.rvspotdrop_currentfocus=document.activeElement.className){
		 	window.rvspotdrop_currentfocus=document.activeElement.className;
	 	}
 	}
 	function rvspotdrop_check_tab_press(e) {
		"use strict";
		// pick passed event or global event object if passed one is empty
		e = e || event;
		var activeElement;

		if(window.innerWidth < 999){
		if (e.keyCode == 9) {
			if(window.rvspotdrop_responsiveMenu){
			if (!e.shiftKey) {
				if(rvspotdrop_gotoHome) {
					jQuery( ".main-menu ul:first li:first a:first-child" ).focus();
				}
			}
			if (jQuery("a.closebtn.mobile-menu").is(":focus")) {
				rvspotdrop_gotoHome = true;
			} else {
				rvspotdrop_gotoHome = false;
			}

		}else{

			if(window.rvspotdrop_currentfocus=="responsivetoggle"){
				jQuery( "" ).focus();
			}}}
		}
		if (e.shiftKey && e.keyCode == 9) {
		if(window.innerWidth < 999){
			if(window.rvspotdrop_currentfocus=="header-search"){
				jQuery(".responsivetoggle").focus();
			}else{
				if(window.rvspotdrop_responsiveMenu){
				if(rvspotdrop_gotoClose){
					jQuery("a.closebtn.mobile-menu").focus();
				}
				if (jQuery( ".main-menu ul:first li:first a:first-child" ).is(":focus")) {
					rvspotdrop_gotoClose = true;
				} else {
					rvspotdrop_gotoClose = false;
				}
			
			}else{

			if(window.rvspotdrop_responsiveMenu){
			}}}}
		}
	 	rvspotdrop_checkfocusdElement();
	}
});

jQuery('document').ready(function($){
	jQuery(window).load(function() {
	    jQuery("#status").fadeOut();
	    jQuery("#preloader").delay(1000).fadeOut("slow");
	})
	$(window).scroll(function(){
		var sticky = $('.header-sticky'),
			scroll = $(window).scrollTop();

		if (scroll >= 100) sticky.addClass('header-fixed');
		else sticky.removeClass('header-fixed');
	});
});

jQuery(document).ready(function () {
	jQuery(window).scroll(function () {
	    if (jQuery(this).scrollTop() > 100) {
	        jQuery('.scrollup i').fadeIn();
	    } else {
	        jQuery('.scrollup i').fadeOut();
	    }
	});
	jQuery('.scrollup').click(function () {
	    jQuery("html, body").animate({
	        scrollTop: 0
	    }, 600);
	    return false;
	});
});
