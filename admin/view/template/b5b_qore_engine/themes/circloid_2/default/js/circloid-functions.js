/////////////////////////////////
// Required Circloid Functions //
/////////////////////////////////

"use strict";

/**
 * GLOBAL VARIABLES
 * endTime handles the reveal countdown
 * @type Integer
 *
 * badgeRevealTime handles when the badges on the menu will be revealed
 * @type Integer
 */
window.endTime = 0;
window.badgeRevealTime = 0;

var dynamicDuration = 300; 
var dynamicDelay = 0;

/**
 * circloidRFResponsiveness handles Circloid's responsiveness for menus
 * RF = Required Function
 */
function circloidRFResponsiveness(){
	/* Show/Hide Notifications Area on mobile devices */
	$("#header > .nav > li.dropdown.notifications-alert-mobile").on("click", function(){
		$(".header-profile").toggleClass("fade-out-item", 500).promise().done(function(){
			$(this).toggleClass("hide-item");
		});
		$(".navbar-toggle").toggleClass("fade-out-item", 500).promise().done(function(){
			$(this).toggleClass("hide-item");
		});
		$(".header-search").toggleClass("fade-out-item", 500).promise().done(function(){
			$(this).toggleClass("hide-item");
		});
		$(".header-language").toggleClass("fade-out-item", 500).promise().done(function(){
			$(this).toggleClass("hide-item");
		});
		$("#header-container .header-bar .logo").toggleClass("fade-out-item", 500).promise().done(function(){
			$(this).toggleClass("hide-item");
			$(".header-info").toggleClass("list-open");
			$("#header > .nav > li.dropdown.notifications-alert-mobile").siblings("li.dropdown").toggleClass("show-item");
		});
	});

	/* Toggle Horizontal & Left/Main Menu */
	$(".navbar-toggle").on("click", function(){
		var navButton = $(this);

		if($("#column-left").height() > 0){
			if($("#column-left").hasClass("menu-open")){
				navButton.removeClass('is-active');
				$("#column-left").animate({"left":"-110px"}, 200, "easeInQuart",function(){
					$(this).removeClass("menu-open");
					$(this).removeAttr("style");
				});
			}else{
				navButton.addClass('is-active');
				navButton.addClass('isactive');
				$("#column-left").animate({"left":"0"}, 500, "easeOutQuart",function(){
					$(this).addClass("menu-open");
				});
			}
		}
		if($("#menu-horizontal-inner").height() > 0){
			if($("#menu-horizontal-inner").hasClass("menu-open")){
				$("#menu-horizontal-inner").slideUp(500, 'easeInOutQuart', function(){
					$(this).removeClass("menu-open");
					$(this).removeAttr("style");
				});
			}else{
				$("#menu-horizontal-inner").slideDown(500, 'easeInOutQuart', function(){
					$(this).addClass("menu-open");
				});
			}
		}
	});

	/* Close opened Menus If User CLicks Outside the Menu (Works on both Left and Horizontal Menus) */
	$(document).on('click', function(event) {
		// Close the header notifications alerts
		if(!$(event.target).closest(".header-notifications").length){
			$(".header-info").removeClass("list-open");
			$(".header-profile").removeClass("fade-out-item").removeClass("hide-item");
			$(".navbar-toggle").removeClass("fade-out-item").removeClass("hide-item");
			$(".header-search").removeClass("fade-out-item").removeClass("hide-item");
			$(".header-language").removeClass("fade-out-item").removeClass("hide-item");
			$("#header-container .header-bar .logo").removeClass("fade-out-item").removeClass("hide-item");
			$("#header > .nav > li.dropdown.notifications-alert-mobile").siblings("li.dropdown").removeClass("show-item");
		}

		// Close Left Menu
		if(!$(event.target).closest("#column-left, .navbar-toggle").length){
			// Hide the menus if visible on smaller devices
			if($(window).width() <= "750"){
				$(".navbar-toggle").removeClass('is-active');
				$("#column-left").animate({"left":"-110px"}, 200, "easeInQuart",function(){
					$(this).removeClass("menu-open");
					$(this).removeAttr("style");
				});
			}
		}

		// Close Horizontal Menu
		if (!$(event.target).closest("#menu-horizontal-inner, .navbar-toggle").length){
			// Hide the menus if visible on smaller devices
			if($(window).width() <= "750"){
				$("#menu-horizontal-inner").slideUp(500, 'easeInOutQuart', function(){
					$(this).removeClass("menu-open");
					$(this).removeAttr("style");
				});
			}
		}
	});
}

/**
 * circloidRFMisc is a combination of miscellaneous fixes required for Circloid or Plugins to work
 */
function circloidRFMisc(){

	/* Adjust body if header is fixed */
	if($(".header-bar").hasClass("navbar-fixed-top")){
		var headerHeight = $(".header-bar").height();
		$("body").css({"padding-top":headerHeight + "px"});
	}

	if($("#menu-horizontal-inner").length && $("#menu-horizontal-inner").hasClass("fixed")){
		$(".right-column-content").css({"padding-top":"58px"});
	}

	/* Make Left Menu scroll if menu is fixed */
	if($("#column-left").hasClass("fixed")){
		var windowHeight = $(window).height();
		var headerHeight = $(".header-bar").height();

		// Set Height of the Left Column
		$("#menu").height(windowHeight - headerHeight);

		// Destroy old scrollbar if present
		$("#menu").mCustomScrollbar("destroy");

		// Create new scrollbar
		$("#menu").mCustomScrollbar({
			autoHideScrollbar:true,
			scrollbarPosition: "outside",
			theme:"dark"
		});
	}

	/* Dropcaps */
    $(".dropcap p:eq(0)").each(function() {
        var text = $(this).html();
        var first = $('<span>'+text.charAt(0)+'</span>').addClass('dropcap-item');
        $(this).html(text.substring(1)).prepend(first);
    });

	/* Add Multi-Colored Border Where Needed */
	var coloredBorder = '<div class="top-border"><span class="border-block bg-color-green"></span><span class="border-block bg-color-orange"></span><span class="border-block bg-color-yellow"></span><span class="border-block bg-color-blue"></span><span class="border-block bg-color-red"></span><span class="border-block bg-color-lime"></span><span class="border-block bg-color-purple"></span></div>';

	$('*[data-border-top="multi"]').prepend(coloredBorder).css({"border-top":"0"});	
	$('.modal-content').prepend(coloredBorder).css({"border-top":"0"});	

	/* Call Tooltips */
	$("[data-toggle='tooltip']").tooltip();

	/* Call Popovers */
	$("[data-toggle='popover']").popover();

	/* Call Function: circloidResizeItems() */
	circloidResizeItems();

	/* Make CKEditor compatible in all browsers except IE7 and below */
	// See URL for more details: http://docs.ckeditor.com/#!/guide/dev_unsupported_environments
	if(window.CKEDITOR && (!CKEDITOR.env.ie || CKEDITOR.env.version > 7)){
		CKEDITOR.env.isCompatible = true;
	}

	/**
	 * circloidContentMobileMenu handles the mobile menu that exists within the main RIght Content area.
	 * Eg: Like the one on the Mailbox page
	 */
	function circloidContentMobileMenu(){
		$(".within-content-navbar-toggle").each(function(){
			var target = $(this).data("c-target");

			$(this).on("click", function(){
				$(target).slideToggle(300);
			});

			// Display target menu when window is above 750px (desktop view)
			$(window).resize(function(){
				if($(window).width() > "750"){
					$(target).removeAttr("style");
				}
			});
		});
	}

	/* Call Function: circloidContentMobileMenu() */
	circloidContentMobileMenu();
}

/**
 * circloidResizeItems handles the resizing all necessary items to the appropriate size on window resize
 */
function circloidResizeItems(){
	$(window).resize(function() {
		if(this.resizeTO) clearTimeout(this.resizeTO);
		this.resizeTO = setTimeout(function() {
			$(this).trigger('resizeEnd');
		}, 500);
	});

	$(window).bind('resizeEnd', function() {
		/* Make Left Menu scroll if menu is fixed */
		if($("#column-left").hasClass("fixed")){
			// Destroy old scrollbar
			$("#menu").mCustomScrollbar("destroy");

			// Reset height of the Left Column
			var windowHeight = $(window).height();
			var headerHeight = $(".header-bar").height();

			// Set Height of the Left Column
			$("#menu").height(windowHeight - headerHeight);

			// Create new scrollbar
			$("#menu").mCustomScrollbar({
				autoHideScrollbar:true,
				scrollbarPosition: "outside",
				theme:"dark"
			});
		}


		/* Adjust body if header is fixed */
		if($(".header-bar").hasClass("navbar-fixed-top")){
			var headerHeight = $(".header-bar").height();
			$("body").css({"padding-top":headerHeight + "px"});
		}

		/* Return Notification alert area back to default state. */
		$(".header-info").removeClass("list-open");
		$(".header-profile").removeClass("fade-out-item").removeClass("hide-item");
		$(".navbar-toggle").removeClass("fade-out-item").removeClass("hide-item");
		$(".header-search").removeClass("fade-out-item").removeClass("hide-item");
		$(".header-language").removeClass("fade-out-item").removeClass("hide-item");
		$("#header-container .header-bar .logo").removeClass("fade-out-item").removeClass("hide-item");
		$("#header > .nav > li.dropdown.notifications-alert-mobile").siblings("li.dropdown").removeClass("show-item");
	});
}


/* ---- Menu Functions ---- */

/**
 * circloidMenuNav handles the navigation, both Left Menu and Horizontal Menu
 * @param  {object} options: Contains the options set by the user
 * - @param {string} options.container:		accepts [{menu class}, {menu id}]
 * - @param {string} options.eventtype:		accepts [click, hover]
 * - @param {string} options.menuposition:	accepts [top, bottom, left, right]
 * - @param {string} options.slideout:		accepts [left, right, down]
 */
function circloidMenuNav(options){

	/* options presets */
	if(options){
		if(!options.container){
			options.container = ".menu";
		}
		if(!options.eventtype){
			options.eventtype = "click";
		}
		if(!options.menuposition){
			options.menuposition = "left";
		}
		if(!options.slideout){
			options.slideout = "down";
		}
	}else{
		options = {container: ".menu", eventtype: "click", menuposition: "left", slideout: "down"};
	}

	/* Add "parent" class to appropriate dropdown */
	$(options.container).find("li li > a").siblings("ul").prev().addClass("parent");

	/* Add Dropdown arrow to parents of dropdowns */
	$("<i class='icon icon-arrow-down-bold-round icon-size-small'></i>").appendTo($(options.container).find("li li > a").siblings("ul").prev());

	if(options.menuposition == "top"){
		$(options.container).find("span.main-menu-icon").each(function(){
			$(this).parent().siblings("ul").siblings("a").children("span.main-menu-icon").after("<i class='icon icon-arrow-down-bold-round icon-size-small'></i>");
		});
	}

	/* Animate Menu */
	if($(options.container).hasClass("animate")){

		// Sequenced Reveal of menu icons, text and badge
		var count = $(options.container).children("li.menu-item-top").length;
		var duration = 200;
		var finalDelay = (count * duration) + 300;

		$(options.container).find(".main-menu-icon .icon").each(function(index){
			$(this).delay(duration * index).animate({"bottom":"0", "opacity":1}, duration, "easeOutQuart", function(){
				$(this).parent().siblings(".main-menu-text").delay(200).animate({"left":"0", "opacity":1}, 200, "easeOutQuart");
			});
		});

		if(finalDelay > badgeRevealTime){
			badgeRevealTime = finalDelay;
		}
	}

	/* Set style for menu */
	$(options.container).css("position","relative");
	$(options.container).children("li").children("ul").css("position","absolute");

	if(options.eventtype == "click"){
		/* Call Function: menuNavClick() */
		menuNavClick(options.container, options.menuposition);
	}else if(options.eventtype == "hover"){
		/* Call Function: menuNavHover() */
		menuNavHover(options.container, options.menuposition);
	}

	$(options.container).find("a.top, a.parent").click(function(e){
		if($(this).siblings("ul").length){
			e.preventDefault();
		}
	});

	/* Close Open Menus If User CLicks Outside the Menu (Works on both Left and Secondary Menus) */
	$(document).on('click', function(event) {
		if (!$(event.target).closest(options.container).length){
			// Hide the menus if visible
			$(options.container).children("li").children("ul").animate({"top": "50px", "opacity":"hide"},200, "easeInQuart",function(){
				$(options.container).find("li ul").removeAttr("style").removeClass("sub-menu-open");
				$(options.container).children("li").removeAttr("style").removeClass("menu-open");
			});
		}
	});



	/**
	 * menuNavClick handles the menu open/close when menu is set to open on click
	 * @param  {string} menuBlock:		the parent class/id (options.container) which is set in parent function circloidMenuNav()
	 * @param  {string} menuposition:	where the sub-menu will slideout from set in parent function circloidMenuNav()
	 */
	function menuNavClick(menuBlock, menuposition){
		/* Display Top Menu */
		$(menuBlock).children("li").children("a").on("click", function(){
			if($(this).parent().hasClass("menu-open")){
				/* Call Function: menuNavClickClose() */
				menuNavClickClose($(this), menuposition);
			}else{
				if(menuposition == "left"){
					$($(this).parents().eq(3)).css("overflow","visible");
					$($(this).parents().eq(2)).css("overflow","visible");
				}
				/* Call Function: menuNavClickOpen() */
				menuNavClickOpen($(this), menuposition);
			}
		});

		/* Display Submenus */
		$(menuBlock).children("li").children("ul").find("li a").on("click", function(){
			if($(this).next("ul").hasClass("sub-menu-open")){
				/* Call Function: menuNavSubClickClose() */
				menuNavSubClickClose($(this), menuposition);
			}else{
				/* Call Function: menuNavSubClickOpen() */
				menuNavSubClickOpen($(this), menuposition);
			}
		});
	}

	/**
	 * menuNavClickOpen handles the opening of the menu on click
	 * @param  {object} thisObj      the object sent from the parent
	 * @param  {string} menuposition slideout menu position sent from parent
	 */
	function menuNavClickOpen(thisObj, menuposition){
		if(menuposition == "left"){
			thisObj.parent().parent().find("li.menu-open > ul").animate({"top": "50px", "opacity":"hide"},200, "easeInQuart",function(){
				$(this).removeAttr("style");
				$(this).find("ul").removeAttr("style").removeClass("sub-menu-open");
				$(this).parent().removeClass("menu-open");
			});
			thisObj.next("ul").animate({"top": "0", "opacity":"show"},500, "easeOutQuart",function(){
				thisObj.parent().addClass("menu-open");
			});
		}else if(menuposition == "top"){
			thisObj.parent().parent().find("li.menu-open > ul").animate({"top": "62px", "opacity":"hide"},200, "easeInQuart",function(){
				$(this).removeAttr("style");
				$(this).find("ul").removeAttr("style").removeClass("sub-menu-open");
				$(this).parent().removeClass("menu-open");
			});
			thisObj.next("ul").animate({"top": "42px", "opacity":"show"},500, "easeOutQuart",function(){
				thisObj.parent().addClass("menu-open");
			});
		}else if(menuposition == "right"){

		}
	}

	/**
	 * menuNavClickClose handles the closing of the menu on click
	 * @param  {object} thisObj      the object sent from the parent
	 * @param  {string} menuposition slideout menu position sent from parent
	 */
	function menuNavClickClose(thisObj, menuposition){
		if(menuposition == "left"){
			thisObj.next("ul").animate({"top": "50px", "opacity":"hide"},200, "easeInQuart",function(){
				$(this).removeAttr("style");
				$(this).parent().removeClass("menu-open");
				$(this).find("ul").removeAttr("style").removeClass("sub-menu-open");
			});
		}else if(menuposition == "top"){
			thisObj.next("ul").animate({"top": "62px", "opacity":"hide"},200, "easeInQuart",function(){
				$(this).removeAttr("style");
				$(this).parent().removeClass("menu-open");
				$(this).find("ul").removeAttr("style").removeClass("sub-menu-open");
			});
		}else if(menuposition == "right"){
			// TODO
		}
	}

	/**
	 * menuNavSubClickOpen handles the opening of the sub-menu on click
	 * @param  {object} thisObj      the object sent from the parent
	 * @param  {string} menuposition slideout menu position sent from parent
	 */
	function menuNavSubClickOpen(thisObj, menuposition){
		if(menuposition == "left"){
			thisObj.parent().siblings("li").find("ul").slideUp(500, 'easeInOutQuart', function(){
				$(this).removeAttr("style").removeClass("sub-menu-open");
			});
			thisObj.next("ul").addClass("sub-menu-open").slideDown({
				duration: 500,
				easing: 'easeInOutQuart'
			});
		}else if(menuposition == "top"){
			thisObj.parent().siblings().removeAttr("style");
			thisObj.parent().siblings().find("ul").removeAttr("style").removeClass("sub-menu-open");
			thisObj.parent().siblings().find("a.parent ~ ul.sub-menu-open").animate({"top": "33px", "opacity":"hide"},200, "easeInQuart");
			if(thisObj.siblings("ul").length > 0){
				thisObj.parent().css("position","relative");
				thisObj.next("ul").animate({"top": "29px", "left": "20px", "opacity":"show"},500, "easeOutQuart",function(){
					$(this).addClass("sub-menu-open");
				});
			}
		}
	}

	/**
	 * menuNavSubClickClose handles the closing of the sub-menu on click
	 * @param  {object} thisObj      the object sent from the parent
	 * @param  {string} menuposition slideout menu position sent from parent
	 */
	function menuNavSubClickClose(thisObj, menuposition){
		if(menuposition == "left"){
			thisObj.next("ul").removeClass("sub-menu-open").slideUp({
				duration: 500,
				easing: 'easeInOutQuart'
			});
			thisObj.next("ul").find("ul").slideUp(500, 'easeInOutQuart', function(){
				$(this).removeAttr("style").removeClass("sub-menu-open");
			});
		}else if(menuposition == "top"){
			thisObj.next("ul").animate({"top": "33px", "opacity":"hide"},200, "easeInQuart",function(){
				$(this).removeAttr("style").removeClass("sub-menu-open");
				$(this).find("ul").removeAttr("style").removeClass("sub-menu-open");
			});
		}
	}

	/**
	 * menuNavHover handles the open/close of the menu on hover
	 * @param  {object} thisObj      the object sent from the parent
	 * @param  {string} menuposition slideout menu position sent from parent
	 */
	function menuNavHover(menuBlock, menuposition){
		/* Display Top Menu */
		$(menuBlock).find(".menu-item-top").mouseenter(function(){
			if(menuposition == "left"){
				$($(this).parents().eq(3)).css("overflow","visible");
				$($(this).parents().eq(2)).css("overflow","visible");
				$($(this).parents().eq(1)).css("overflow","visible");
			}
			/* Call Function: menuNavMouseEnter() */
			menuNavMouseEnter($(this), menuposition);
		}).mouseleave(function(){
			if(menuposition == "left"){
				$($(this).parents().eq(3)).css("overflow","hidden");
				$($(this).parents().eq(2)).css("overflow","hidden");
			}
			/* Call Function: menuNavMouseLeave() */
			menuNavMouseLeave($(this), menuposition);
		});


		/* Display Submenus */
		$(menuBlock).children("li").children("ul").find("li a").on("click", function(){
			if($(this).next("ul").hasClass("sub-menu-open")){
				/* Call Function: menuNavSubClickClose() */
				menuNavSubClickClose($(this), menuposition);
			}else{
				/* Call Function: menuNavSubClickOpen() */
				menuNavSubClickOpen($(this), menuposition);
			}
		});

		/* TODO: If parent event type is hover and the submenu is click to open as it is, then add a feature that will hide the submenus when you hover out of the main parent li */
	}

	/**
	 * menuNavMouseEnter handles the open of the menu on hover
	 * @param  {object} thisObj      the object sent from the parent
	 * @param  {string} menuposition slideout menu position sent from parent
	 */
	function  menuNavMouseEnter(thisObj, menuposition){
		if(menuposition == "left"){
			thisObj.children("ul").animate({"top": "0", "opacity":"show"},500, "easeOutQuart",function(){
				thisObj.parent("li").addClass("menu-open");
			});
		}else if(menuposition == "top"){
			thisObj.children("ul").animate({"top": "42px", "opacity":"show"},500, "easeOutQuart",function(){
				thisObj.parent("li").addClass("menu-open");
			});
		}
	}

	/**
	 * menuNavMouseLeave handles the open of the menu on leave
	 * @param  {object} thisObj      the object sent from the parent
	 * @param  {string} menuposition slideout menu position sent from parent
	 */
	function  menuNavMouseLeave(thisObj, menuposition){
		if(menuposition == "left"){
			thisObj.children("ul").animate({"top": "50px", "opacity":"hide"},200, "easeInQuart",function(){
				$(this).removeClass("menu-open");
				$(this).removeAttr("style");
				$(this).find("ul").removeAttr("style").removeClass("sub-menu-open");
			});
		}else if(menuposition == "top"){
			thisObj.children("ul").animate({"top": "62px", "opacity":"hide"},200, "easeInQuart",function(){
				$(this).removeClass("menu-open");
				$(this).removeAttr("style");
				$(this).find("ul").removeAttr("style").removeClass("sub-menu-open");
			});
		}
	}

	// Menu - Active 
 	$('nav .menu > li').each(function(){
 		var topParentListItem = $(this);
 		var topParentListItemID = topParentListItem.attr('id');

 		topParentListItem.find('a').each(function(){
 			if(typeof $(this).attr('href') != 'undefined'){
 				var itemLink = $(this).attr('href');
 				var itemLinkSplit1 = itemLink.split('?');

 				if(typeof itemLinkSplit1[1] != 'undefined'){
 					var itemLinkSplit2 = itemLinkSplit1[1].split('&');

 					var itemLinkRoute = itemLinkSplit2[0].substring(6);

 					if(route == itemLinkRoute){
 						topParentListItem.addClass('active_2');
 					}
 				}
 			}
 		});
 	});
}

/**
 * circloidNotificationAlert handles the header notifications alert
 * @param  {object} options: Contains the options set by the user
 * - @param {string} options.eventtype:		accepts [click, hover]
 */
function circloidNotificationAlert(options){
	if(options){
		if(!options.eventtype){
			options.eventtype = "click";
		}
	}else{
		options = {eventtype: "click"};
	}

	if($(".header-notifications").hasClass("animate")){

		var count = $('#header > .nav > li.dropdown').length;
		var duration = 200;
		var finalDelay = (count * duration) + 300;

		setTimeout(function(){
			// Sequenced Reveal
			setTimeout(function(){
				$(".header-notifications").css({"overflow":"visible"});
			}, finalDelay);

			$('#header > .nav > li.dropdown').each(function(index){
				$(this).delay(duration * index).animate({"bottom":"0", "opacity":1}, duration, "easeOutQuart");
			});

		}, endTime);

		endTime = endTime + finalDelay;

		if(endTime > badgeRevealTime){
			badgeRevealTime = endTime;
		}
	}

	if(options.eventtype == "click"){
		/* Display Notifications Alert on click */
		$("#header > .nav > li.dropdown").on("click", function(){
			if($(this).hasClass("menu-open")){
				$(this).children("ul").animate({"top":"53px", "opacity":"hide"}, 200, "easeInQuart",function(){
					$(this).removeAttr("style");
					$(this).parent("li").removeClass("menu-open");
				});
			}else{
				$(this).siblings().children("ul").animate({"top":"53px", "opacity":"hide"}, 200, "easeInQuart",function(){
					$(this).removeAttr("style");
					$(this).parent("li").removeClass("menu-open");
				});
				$(this).children("ul").animate({"top":"33px", "opacity":"show"}, 500, "easeOutQuart",function(){
					$(this).parent("li").addClass("menu-open");
							
					// Destroy old scrollbar if present
					$(this).children("li.notifications-alert-block").mCustomScrollbar("destroy");

					// Create new scrollbar
					$(this).children("li.notifications-alert-block").mCustomScrollbar({
						autoHideScrollbar:true,
						scrollbarPosition: "outside",
						theme:"dark"
					});
				});
			}
		});
	}else if(options.eventtype == "hover"){
		/* Display Notifications Alert on hover */
		$("#header > .nav > li.dropdown").mouseenter(function(){
			$(this).children("ul").animate({"top":"33px", "opacity":"show"}, 500, "easeOutQuart",function(){
				$(this).parent("li").addClass("menu-open");	
				// Destroy old scrollbar if present
				$(this).children("li.notifications-alert-block").mCustomScrollbar("destroy");

				// Create new scrollbar
				$(this).children("li.notifications-alert-block").mCustomScrollbar({
					autoHideScrollbar:true,
					scrollbarPosition: "outside",
					theme:"dark"
				});
			});
		}).mouseleave(function(){
			$(this).children("ul").animate({"top":"53px", "opacity":"hide"}, 200, "easeInQuart",function(){
				$(this).removeAttr("style");
				$(this).parent("li").removeClass("menu-open");
			});
		});
	}

	/* Close Open Menus If User Clicks Outside the Menu (Works on both Left and Secondary Menus) */
	$(document).on('click', function(event) {
		if (!$(event.target).closest('#header > .nav > li.dropdown').length) {
			$("#header > .nav > li.dropdown").children("ul").animate({"top":"53px", "opacity":"hide"}, 200, "easeInQuart",function(){
				$(this).removeAttr("style");
				$(this).parent("li").removeClass("menu-open");
			});
		}
	});
}

/**
 * circloidProfileMenu handles the profile menu in the header
 * @param  {object} options: Contains the options set by the user
 * - @param {string} options.eventtype:		accepts [click, hover]
 */
function circloidProfileMenu(options){
	if($(".header-profile").hasClass("animate")){

		// Sequenced Reveal
		var duration = 200;
		var delay = 200;

		setTimeout(function(){
			$(".header-profile > ul.header-profile-menu > li").animate({"bottom":"0", "opacity":1}, duration, "easeOutQuart",function(){
				$(this).find(".main-menu-text").delay(delay).animate({"left":"0", "opacity":1}, 200, "easeOutQuart", function(){
					$(".header-profile").css({"overflow":"visible"});
				});
			});
		}, endTime);

		endTime = endTime + duration + delay;

		if(endTime > badgeRevealTime){
			badgeRevealTime = endTime + 400;
		}
	}

	/* Set default options */
	if(options){
		if(!options.eventtype){
			options.eventtype = "click";
		}
	}else{
		options = {eventtype: "click"};
	}

	if(options.eventtype == "click"){
		$(".header-profile a.top").on("click", function(e){
			if($(this).parent().hasClass("menu-open")){
				$(this).siblings("ul").animate({"top":"53px", "opacity":"hide"}, 200, "easeInQuart",function(){
					$(this).removeAttr("style");
					$(this).parent("li").removeClass("menu-open");
				});
			}else{
				$(this).siblings("ul").animate({"top": "33px", "opacity":"show"},500, "easeOutQuart",function(){
					$(this).parent("li").addClass("menu-open");
				});
			}
			e.preventDefault();
		});
	}
	
	/* Close Open Menus If User Clicks Outside the Menu */
	$(document).on('click', function(event) {
		if (!$(event.target).closest('.header-profile').length) {
			$(".header-profile a.top").siblings("ul").animate({"top":"53px", "opacity":"hide"}, 200, "easeInQuart",function(){
				$(this).removeAttr("style");
				$(this).parent("li").removeClass("menu-open");
			});
		}
	});
}

/**
 * circloidSearchBar handles the header search bar
 */
function circloidSearchBar(){
	if($(".header-search").hasClass("animate")){
		
		// Sequenced Reveal
		var duration = 200;
		var delay = 200;

		setTimeout(function(){
			$(".header-search.animate > form > ul > li").animate({"bottom":"0", "opacity":1}, duration, "easeOutQuart",function(){
				$(this).find(".search-closed .main-text").delay(delay).animate({"left":"0", "opacity":1}, 200, "easeOutQuart");
				$(".header-search").css({"overflow":"visible"});
			});
		}, endTime);

		endTime = endTime + duration + delay;

		if(endTime > badgeRevealTime){
			badgeRevealTime = endTime;
		}
	}

	// Add iCheck to Radio and Checkbox	
	$(".header-search .icheck-square").iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue'
	});

	// Open/Close Advanced options if Checked/Unchecked
	$("#input-advanced-search").on('ifChecked', function(event){
		$(".advanced-search").slideDown({
			duration: 500,
			easing: 'easeInOutQuart'
		});
	});
	$("#input-advanced-search").on('ifUnchecked', function(event){
		$(".advanced-search").slideUp({
			duration: 500,
			easing: 'easeInOutQuart'
		});
	});

	$(".search-closed").on("click", function(e){
		$(this).css({"display":"none"});
		$(".search-opened").css({"display":"block"});
		$(this).siblings("ul").animate({"top": "24px", "opacity":"show"},500, "easeOutQuart",function(){
		});
		e.preventDefault();
	});

	$(".search-opened").on("click", function(e){
		$(this).css({"display":"none"});
		$(".search-closed").css({"display":"block"});
		$(this).siblings("ul").animate({"top": "56px", "opacity":"hide"},200, "easeInQuart",function(){
			$(this).removeAttr("style");
		});
		e.preventDefault();
	});

	// Close Open Menus If User Clicks Outside the Menu
	$(document).on('click', function(event) {
		if (!$(event.target).closest('.header-search').length) {
			$(".search-opened").css({"display":"none"});
			$(".search-closed").css({"display":"block"});
			$(".search-opened").siblings("ul").animate({"top": "56px", "opacity":"hide"},200, "easeInQuart",function(){
				$(this).removeAttr("style");
			});
		}
	});
}

/**
 * circloidLanguageMenu handles the language menu in header bar
 */
function circloidLanguageMenu(){
	if($(".header-language").hasClass("animate")){

		// Sequenced Reveal
		var duration = 200;
		var delay = 200;

		setTimeout(function(){
			$(".header-language.animate > ul > li").animate({"bottom":"0", "opacity":1}, duration, "easeOutQuart",function(){
				$(this).find(".language-closed .main-text").delay(delay).animate({"left":"0", "opacity":1}, 500, "easeOutQuart");
				$(".header-language").css({"overflow":"visible"});
			});
		}, endTime);

		endTime = endTime + duration + delay;

		if(endTime > badgeRevealTime){
			badgeRevealTime = endTime;
		}
	}

	$(".language-closed").on("click", function(e){
		$(this).css({"display":"none"});
		$(".language-opened").css({"display":"block"});
		$(this).siblings("ul").animate({"top": "24px", "opacity":"show"},500, "easeOutQuart",function(){
		});
		e.preventDefault();
	});

	$(".language-opened").on("click", function(e){
		$(this).css({"display":"none"});
		$(".language-closed").css({"display":"block"});
		$(this).siblings("ul").animate({"top": "56px", "opacity":"hide"},200, "easeInQuart",function(){
			$(this).removeAttr("style");
		});
		e.preventDefault();
	});

	// Close Open Menus If User Clicks Outside the Menu
	$(document).on('click', function(event) {
		if (!$(event.target).closest('.header-language').length) {
			$(".language-opened").css({"display":"none"});
			$(".language-closed").css({"display":"block"});
			$(".language-opened").siblings("ul").animate({"top": "56px", "opacity":"hide"},200, "easeInQuart",function(){
				$(this).removeAttr("style");
			});
		}
	});
}

/**
 * circloidRevealBugFix fixes bugs caused during animation of the left menu and horizontal menu
 */
function circloidRevealBugFix(){
	// Reveal Badges
	setTimeout(function(){
		$("#header > .nav > li.dropdown .label").animate({"opacity":"show"}, 500, "easeOutQuart");
		$(".menu-item-top > a.top > .badge").animate({"opacity":1}, 500, "easeOutQuart");
	}, badgeRevealTime);
}


/* ---- Blocks Functions ---- */

/**
 * circloidBlocks handles all blocks functions
 * @param  {object} options: Contains the options set by the user
 * - @param {string}options.colorcollapsed:		the color of the block border when collapsed. accepts [green, orange, yellow, blue, red, lime, pink]
 */
function circloidBlocks(options){
	// Create new scrollbar
	$(".block.block-size-medium .block-content-inner, .block.block-size-normal .block-content-inner, .block.block-size-large .block-content-inner, .panel.block-size-medium .panel-heading + .panel-body, .panel.block-size-normal .panel-heading + .panel-body, .panel.block-size-large .panel-heading + .panel-body, .panel.block-size-medium .panel-heading + .list-group, .panel.block-size-normal .panel-heading + .list-group, .panel.block-size-large .panel-heading + .list-group").mCustomScrollbar({
		autoHideScrollbar:true,
		scrollbarPosition: "outside",
		theme:"dark"
	});

	circloidBlockControls(options);

	/**
	 * circloidBlockControls handles the controls attached to each block
	 * @param  {object} options: Contains the options set by the user. All options are taken from the parent circloidBlocks()
	 */
	function circloidBlockControls(options){
		
		var colorClass = "";

		if(options){
			switch(options.colorcollapsed){
				case "green":
				colorClass = "highlight-color-green";
				break;
				case "orange":
				colorClass = "highlight-color-orange";
				break;
				case "yellow":
				colorClass = "highlight-color-yellow";
				break;
				case "blue":
				colorClass = "highlight-color-blue";
				break;
				case "red":
				colorClass = "highlight-color-red";
				break;
				case "lime":
				colorClass = "highlight-color-lime";
				break;
				case "pink":
				colorClass = "highlight-color-purple";
				break;
				default:
				colorClass = "highlight-color-red";
			}
		}else{
			colorClass = "highlight-color-red";
		}

		/* Remove Block */
		$(".block-control-remove").on("click", function(){
			$(this).parents().eq(2).fadeOut(500, function(){
				$(this).remove();
			});
		});

		/* Block Settings - This is controlled by Bootstrap Modal Alert - Check documentation */

		/* Collapse Block */
		$(".block.collapsed .block-heading").addClass(colorClass);
		$(".block-control-collapse").on("click", function(){
			if($(this).parents().eq(2).hasClass("collapsed")){
				$(this).parent().parent().removeClass(colorClass);
				$(this).parent().parent().next().slideDown(500, 'easeInOutQuart', function(){
					$(this).parent().removeClass("collapsed");
				});
			}else{
				$(this).parent().parent().next().slideUp(500, 'easeInOutQuart', function(){
					$(this).prev().addClass(colorClass);
					$(this).parent().addClass("collapsed");
				});
			}
		});

		/*  Refresh Block Data */
		// SAMPLE DATA: Contains Sample Code. Please make changes based on your own needs. See documentation.
		$(".block-control-refresh").on("click", function(e){
			var url = $(this).parents().eq(2).data("url");
			var thisObj = $(this);
			var blockContainer = $(this).parent().parent().siblings(".block-content-outer").find(".block-content-inner");
			$.ajax({
				type: 'GET',
				url: url,
				beforeSend: function(){
					thisObj.siblings(".icon-success").remove();
					thisObj.siblings(".icon-error").remove();
					thisObj.parent().append("<span class='icon loading' style='opacity:1;'></span>");
				},
				complete: function(){
					thisObj.siblings(".loading").remove();
				},
				error: function(){
					thisObj.parent().append("<span class='icon icon-exclamation icon-size-medium icon-error' style='opacity:1;'></span>");
					thisObj.siblings(".icon-error").delay(3500).fadeOut(1000);
				},
				success: function(data){
					// Destroy old scrollbar if present
					$(blockContainer).mCustomScrollbar("destroy");

					thisObj.parent().append("<span class='icon icon-check icon-size-medium icon-success' style='opacity:1;'></span>");
					thisObj.siblings(".icon-success").delay(3000).fadeOut(1000);
					blockContainer.html(data);

					// Create new scrollbar
					$(blockContainer).mCustomScrollbar({
						autoHideScrollbar:true,
						scrollbarPosition: "outside",
						theme:"dark"
					});
				}
			});
			e.preventDefault();
		});
	}
}

/**
 * circloidQuickWidgets handles the click even of the Quick Widgets
 */
function circloidQuickWidgets(){
	$('.c-widget-quick-info').each(function(){
		var targetLink = $(this).data('url');

		$(this).on('click', function(){
			window.location.replace(targetLink);
		});
	});
}

/* circloidMap - handles the map chart */
function circloidMap(){
	
	if($('#vmap').length){

		var mapElement = $('#vmap');
		var panelHeading = mapElement.closest('.panel').find('.panel-heading');
		var panelBody = mapElement.closest('.panel-body');

		var panelBodyHeight = panelBody.height();

		// Set the height of the map
		mapElement.css({'height': panelBodyHeight});

		$.ajax({
			url: 'index.php?route=b5b_qore_engine/dash_map_medium/map&user_token=' + userToken,
			dataType: 'json',
			beforeSend: function() {
				panelHeading.find(".icon-success").remove();
				panelHeading.find(".icon-error").remove();
				panelHeading.prepend("<span class='icon loading' style='opacity:1;'></span>");
			},
			complete: function() {
				panelHeading.find(".icon.loading").remove();
			},
			error: function() {
				panelHeading.prepend("<span class='icon icon-exclamation icon-size-medium icon-error' style='opacity:1;'></span>");
				panelHeading.find(".icon-error").delay(3500).fadeOut(1000);
			},
			success: function(json) {
				panelHeading.prepend("<span class='icon icon-check icon-size-medium icon-success' style='opacity:1;'></span>");
				panelHeading.find(".icon-success").delay(3500).fadeOut(1000);

				var data = [];
				var i = '';

				for (i in json) {
					data[i] = json[i]['total'];
				}

				var labelOrders = panelBody.data('label-orders');
				var labelSales = panelBody.data('label-sales');

				var highestColor = panelBody.data('highest-color');
				var lowestColor = panelBody.data('lowest-color');
				var bgColor = panelBody.data('bg-color');

				$('#vmap').vectorMap({
					map: 'world_en',
					backgroundColor: '#FFFFFF',
					borderColor: '#FFFFFF',
					color: circloid_hexToRgbA(bgColor),
					hoverOpacity: 0.7,
					selectedColor: '#37BC9B',
					enableZoom: true,
					showTooltip: true,
					scaleColors: [lowestColor, highestColor],
					values: data,
					normalizeFunction: 'polynomial',
					onLabelShow: function(event, label, code) {

						if (json[code]) {
							label.html('<strong>' + label.text() + '</strong><br />' + labelOrders + ': ' + json[code]['total'] + '<br />' + labelSales + ': '+ json[code]['amount']);
						}else{
							label.html('<strong>' + label.text() + '</strong>');
						}
					}
				});

			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}

/**
 * circloidDateRangeChart Charts with Date Range Selector
 * @param  {string} placeholder:		id or class of parent block
 * @param  {string} graphPlaceholder:	id of graph
 * @param  {string} graphType:			enter graph type [bar, line, pie, donut]
 */
function circloidDateRangeChart(placeholder, graphPlaceholder, graphType){
	
	if($(placeholder).length){

		var controllerPath = $(placeholder).data('controller-path');
		var dateRange = $(placeholder).find(".range-selector .dropdown-menu .active a").attr('href');
		var currentStatus = $(placeholder).find('.status-selector .dropdown-menu .active a').attr('href');

		if(graphType === undefined || graphType == null){
			graphType = "line";
		}
		
		if(dateRange == "custom"){
			$(placeholder).find(".date-picker-connected").show();
		}

		/* Call Function: graphTypeSwitch() */
		graphTypeSwitch(graphType);

		/* Handle the changing of the dropdown menu */
		$(placeholder).find(".range-selector .dropdown-menu a").on("click", function(e){

			e.preventDefault();

			var selectedOption = $(this);

			// Get the current status if it exists
			// TODO: Attach status to the ajax call
			currentStatus = selectedOption.closest('.panel-heading').find('.status-selector .dropdown-menu .active a').attr('href');

			// Set its parent list item to active then get its attribute
			selectedOption.closest('li').siblings().removeClass('active');
			selectedOption.closest('li').addClass('active');

			dateRange = $(placeholder).find(".range-selector .dropdown-menu .active a").attr('href');
			var dateRangeText = $(placeholder).find(".range-selector .dropdown-menu .active a").text();

			$(placeholder).find(".range-selector .range-text").text(dateRangeText);

			if(dateRange == "custom"){
				$(this).closest("form").find(".date-picker-connected").fadeIn(300);
			}else{
				$(this).closest("form").find(".date-picker-connected").fadeOut(300);
			}

			/* Call Function: graphTypeSwitch() */
			graphTypeSwitch(graphType);
		});

		//When Order Status is selected
		$(placeholder).find('.status-selector .dropdown-menu a').on('click', function(e){

			e.preventDefault();

			$(this).closest('li').siblings().removeClass('active');
			$(this).closest('li').addClass('active');

			var statusText = $(placeholder).find(".status-selector .dropdown-menu .active a").text();

			$(placeholder).find(".status-selector .status-text").text(statusText);

			$(placeholder).find('.range-selector .dropdown-menu .active a').trigger('click');
		});

		

		/* Connects the two date fields (start and end) */
		// B5B NOTE: This currently has no use
		$(placeholder).find(".date-picker-connected").each(function(){
			var eventStartDate = $(this).find('.date-picker-start');
			var eventEndDate = $(this).find('.date-picker-end');

			eventStartDate.datetimepicker({
				format: 'dd/MM/YYYY'
			});
			eventEndDate.datetimepicker({
				format: 'dd/MM/YYYY'
			});
			eventStartDate.on("dp.change",function(e) {
				eventEndDate.data("DateTimePicker").minDate(e.date);
			});
			eventEndDate.on("dp.change",function(e) {
				eventStartDate.data("DateTimePicker").maxDate(e.date);
			});
		});

		/**
		 * graphTypeSwitch gets current date range and calls the appropriate chart
		 * @param  {string} graphType:	as stated in parent function
		 */
		function graphTypeSwitch(graphType){
			switch(graphType){
				case "bar":
					barChartFlot(graphPlaceholder, dateRange, controllerPath);
				break;

				default:
				case "line":
					lineChartFlot(graphPlaceholder, dateRange, controllerPath, currentStatus);
				break;

				case "pie":
					donutPieChartFlot(graphPlaceholder, false, "pie", dateRange, controllerPath);
				break;

				case "donut":
					donutPieChartFlot(graphPlaceholder, false, "donut", dateRange, controllerPath);
				break;
			}
		}

		/**
		 * lineChartFlot creates the line chart
		 * @param {string} placeholder:	as stated in parent function
		 */
		function lineChartFlot(placeholder, dateRange, controllerPath, currentStatus){

			var thisBlock = $(placeholder).closest(".panel");

			if(currentStatus === undefined){
				var statusID = 'all';
			}else{
				var statusID = currentStatus;
			}

			var url = 'index.php?route=b5b_qore_engine/' + controllerPath + '/chart&user_token=' + userToken + '&range=' + dateRange + '&status_id=' + statusID;

			$.ajax({
				type: 'GET',
				url: url,
				beforeSend: function(){
					/* Display loading icon */
					thisBlock.find(".panel-title .icon-success").remove();
					thisBlock.find(".panel-title .icon-error").remove();
					thisBlock.find('.panel-title').prepend("<span class='icon loading' style='opacity:1;'></span>");
				},
				complete: function(){
					/* Display loading icon */
					thisBlock.find(".panel-title .icon.loading").remove();
				},
				error: function(){
					thisBlock.find('.panel-title').prepend("<span class='icon icon-exclamation icon-size-medium icon-error' style='opacity:1;'></span>");
					thisBlock.find(".panel-title .icon-error").delay(5000).fadeOut(1000);
				},
				success: function(json){
					thisBlock.find('.panel-title').prepend("<span class='icon icon-check icon-size-medium icon-success' style='opacity:1;'></span>");
					thisBlock.find(".panel-title .icon-success").delay(5000).fadeOut(1000);

					/* Get parameters set in in placeholder */
					var colors = $(placeholder).data("graph-colors").split(',');

					var options = {
						series: {
							lines: { 
								show: true,
								fill: true,
								lineWidth: 1.5
							},
							points: {
								show: true,
								radius: 6
							}
						},
						shadowSize: 0,
						grid: {
							backgroundColor: '#FFFFFF',
							borderColor: '#D6D6D9',
							borderWidth: 1,
							hoverable: true
						},
						legend: {
							show: true,
							position: "nw"
						},
						xaxis: {
							ticks: json.xaxis
						},
						tooltip: true,
						tooltipOpts: {
							content: function(label, xval, yval, flotItem){
								return label + ": <b>" + yval + "</b>";
							},
							shifts: {
								x: -40,
								y: 25
							},
							defaultTheme : false
						},
						colors: colors
					}

					var plotChart = $.plot(placeholder, [json.order, json.customer], options);

					if(plotChart){
						$(placeholder).closest(".block").find(".block-controls .icon-success").remove();
						$(placeholder).closest(".block").find(".block-controls .icon-error").remove();
						$(placeholder).closest(".block").find(".block-controls").append("<span class='icon icon-check icon-size-medium icon-success' style='opacity:1;'></span>");
						$(placeholder).closest(".block").find(".block-controls .icon-success").delay(3000).fadeOut(1000, function(){
							$(this).remove();
						});
						$(placeholder).closest(".block").find(".block-controls .icon.loading").remove();
						return true;
					}

					return false;
				}
			});
		}

		/**
		 * barChartFlot creates the bar chart
		 * @param {string} placeholder:	as stated in parent function
		 */
		function barChartFlot(placeholder, dateRange, controllerPath){

			/* Get parameters set in in placeholder */
			var colors = $(placeholder).data("graph-colors").split(',');
			// var dateRange = $(placeholder).closest(".block").find(".date-range-select").val();

			/* SAMPLE DATA: This "data" variable contains SAMPLE DATA just to show you the format of the data that you need to pass into the chart */
			switch(dateRange){
				case "day":
					// SAMPLE DATA: This "data" variable contains SAMPLE DATA just to show you the format of the data that you need to pass into the chart
					var data = {
						"label1":{
							"label":"Total Orders",
							"data":[[0,0],[1,0],[2,0],[3,0],[4,0],[5,0],[6,0],[7,0],[8,3],[9,9],[10,2],[11,20],[12,0],[13,10],[14,17],[15,10],[16,9],[17,0],[18,0],[19,0],[20,0],[21,0],[22,0],[23,0]]
						},
						"label2":{
							"label":"Total Customers",
							"data":[[0,0],[1,0],[2,0],[3,1],[4,2],[5,3],[6,4],[7,0],[8,7],[9,2],[10,5],[11,3],[12,0],[13,0],[14,0],[15,0],[16,4],[17,0],[18,0],[19,0],[20,0],[21,0],[22,0],[23,0]]
						},
						"xaxis":[[0,"00:00"],[1,"01:00"],[2,"02:00"],[3,"03:00"],[4,"04:00"],[5,"05:00"],[6,"06:00"],[7,"07:00"],[8,"08:00"],[9,"09:00"],[10,"10:00"],[11,"11:00"],[12,"12:00"],[13,"13:00"],[14,"14:00"],[15,"15:00"],[16,"16:00"],[17,"17:00"],[18,"18:00"],[19,"19:00"],[20,"20:00"],[21,"21:00"],[22,"22:00"],[23,"23:00"]]
					}
				break;

				case "yesterday":
					// SAMPLE DATA: This "data" variable contains SAMPLE DATA just to show you the format of the data that you need to pass into the chart
					var data = {
						"label1":{
							"label":"Total Orders",
							"data":[[0,0],[1,0],[2,0],[3,0],[4,0],[5,0],[6,0],[7,6],[8,3],[9,19],[10,41],[11,20],[12,10],[13,10],[14,17],[15,10],[16,9],[17,0],[18,0],[19,0],[20,0],[21,0],[22,0],[23,0]]
						},
						"label2":{
							"label":"Total Customers",
							"data":[[0,0],[1,0],[2,0],[3,1],[4,2],[5,3],[6,4],[7,0],[8,4],[9,12],[10,9],[11,4],[12,7],[13,5],[14,0],[15,0],[16,4],[17,0],[18,0],[19,0],[20,0],[21,0],[22,0],[23,0]]
						},
						"xaxis":[[0,"00:00"],[1,"01:00"],[2,"02:00"],[3,"03:00"],[4,"04:00"],[5,"05:00"],[6,"06:00"],[7,"07:00"],[8,"08:00"],[9,"09:00"],[10,"10:00"],[11,"11:00"],[12,"12:00"],[13,"13:00"],[14,"14:00"],[15,"15:00"],[16,"16:00"],[17,"17:00"],[18,"18:00"],[19,"19:00"],[20,"20:00"],[21,"21:00"],[22,"22:00"],[23,"23:00"]]
					}
				break;
				
				case "week":
					// SAMPLE DATA: This "data" variable contains SAMPLE DATA just to show you the format of the data that you need to pass into the chart
					var data = {
						"label1":{
							"label":"Total Orders",
							"data":[[0,4],[1,5],[2,3],[3,9],[4,8],[5,6],[6,8]]
						},
						"label2":{
							"label":"Total Customer","data":[[0,1],[1,1],[2,3],[3,2],[4,3],[5,0],[6,0]]
						},
						"xaxis":[[0,"Sun"],[1,"Mon"],[2,"Tue"],[3,"Wed"],[4,"Thu"],[5,"Fri"],[6,"Sat"]]
					};
				
				break;

				case "last_week":
					// SAMPLE DATA: This "data" variable contains SAMPLE DATA just to show you the format of the data that you need to pass into the chart
					var data = {
						"label1":{
							"label":"Total Orders",
							"data":[[0,14],[1,15],[2,30],[3,49],[4,98],[5,36],[6,18]]
						},
						"label2":{
							"label":"Total Customer","data":[[0,11],[1,19],[2,30],[3,23],[4,39],[5,39],[6,10]]
						},
						"xaxis":[[0,"Sun"],[1,"Mon"],[2,"Tue"],[3,"Wed"],[4,"Thu"],[5,"Fri"],[6,"Sat"]]
					};
				
				break;

				case "month":
					// SAMPLE DATA: This "data" variable contains SAMPLE DATA just to show you the format of the data that you need to pass into the chart
					var	data = {
						"label1":{
							"label":"Total Orders",
							"data":[[1,2],[2,1],[3,3],[4,3],[5,4],[6,0],[7,0],[8,0],[9,3],[10,5],[11,0],[12,0],[13,0],[14,0],[15,0],[16,1],[17,3],[18,2],[19,1],[20,2],[21,0],[22,0],[23,0],[24,0],[25,0],[26,0],[27,0],[28,0],[29,0],[30,0],[31,0]]
						},
						"label2":{
							"label":"Total Customers",
							"data":[[1,0],[2,0],[3,0],[4,0],[5,2],[6,1],[7,3],[8,0],[9,1],[10,2],[11,1],[12,2],[13,4],[14,3],[15,2],[16,0],[17,0],[18,0],[19,0],[20,0],[21,0],[22,0],[23,0],[24,0],[25,0],[26,0],[27,0],[28,0],[29,0],[30,0],[31,0]]
						},
						"xaxis":[[1,"1"],[2,"2"],[3,"3"],[4,"4"],[5,"5"],[6,"6"],[7,"7"],[8,"8"],[9,"9"],[10,"10"],[11,"11"],[12,"12"],[13,"13"],[14,"14"],[15,"15"],[16,"16"],[17,"17"],[18,"18"],[19,"19"],[20,"20"],[21,"21"],[22,"22"],[23,"23"],[24,"24"],[25,"25"],[26,"26"],[27,"27"],[28,"28"],[29,"29"],[30,"30"],[31,"31"]]
					}

				break;

				default:
				case "year":
					// SAMPLE DATA: This "data" variable contains SAMPLE DATA just to show you the format of the data that you need to pass into the chart
					var	data = {
						"label1":{
							"label":"Total Orders",
							"data":[[1,2052],[2,1460],[3,1492],[4,1794],[5,1384],[6,2122],[7,2880],[8,2545],[9,3908],[10,4935],[11,3907],[12,4937]]
						},
						"label2":{
							"label":"Total Customer","data":[[1,821],[2,730],[3,622],[4,897],[5,923],[6,999],[7,1400],[8,1212],[9,1534],[10,2100],[11,1503],[12,1899]]
						},
						"xaxis":[[1,"Jan"],[2,"Feb"],[3,"Mar"],[4,"Apr"],[5,"May"],[6,"Jun"],[7,"Jul"],[8,"Aug"],[9,"Sept"],[10,"Oct"],[11,"Nov"],[12,"Dec"]]
					};
				
				break;

				case "last_year":
					// SAMPLE DATA: This "data" variable contains SAMPLE DATA just to show you the format of the data that you need to pass into the chart
					var	data = {
						"label1":{
							"label":"Total Orders",
							"data":[[1,252],[2,160],[3,192],[4,194],[5,184],[6,222],[7,280],[8,245],[9,308],[10,435],[11,307],[12,437]]
						},
						"label2":{
							"label":"Total Customer","data":[[1,21],[2,30],[3,22],[4,97],[5,23],[6,99],[7,100],[8,212],[9,134],[10,100],[11,103],[12,199]]
						},
						"xaxis":[[1,"Jan"],[2,"Feb"],[3,"Mar"],[4,"Apr"],[5,"May"],[6,"Jun"],[7,"Jul"],[8,"Aug"],[9,"Sept"],[10,"Oct"],[11,"Nov"],[12,"Dec"]]
					};
				
				break;
			}

			var options = {	
				series: {
					bars: {
						show: true,
						fill: true,
						lineWidth: 1,
						barWidth: 0.34,
						order: 1
					}
				},
				shadowSize: 0,
				grid: {
					backgroundColor: '#FFFFFF',
					borderColor: '#D6D6D9',
					borderWidth: 1,
					hoverable: true
				},
				legend: {
					show: true
				},
				xaxis: {
					ticks: data.xaxis
				},
				tooltip: true,
				tooltipOpts: {
					content: function(label, xval, yval, flotItem){
						return label + ": <b>" + yval.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + "</b>";
					},
					shifts: {
						x: -40,
						y: 25
					},
					defaultTheme : false
				},
				colors: colors
			}

			var plotChart = $.plot(placeholder, [data.label1, data.label2], options);

			if(plotChart){
				$(placeholder).closest(".block").find(".block-controls .icon-success").remove();
				$(placeholder).closest(".block").find(".block-controls .icon-error").remove();
				$(placeholder).closest(".block").find(".block-controls").append("<span class='icon icon-check icon-size-medium icon-success' style='opacity:1;'></span>");
				$(placeholder).closest(".block").find(".block-controls .icon-success").delay(3000).fadeOut(1000, function(){
					$(this).remove();
				});
				$(placeholder).closest(".block").find(".block-controls .icon.loading").remove();
				return true;
			}

			return false;
		}

		/* Donut Chart: Called from dateRangeChart function */
		/**
		 * donutPieChartFlot creates the Donut and Pie Chars
		 * @param  {string} placeholder:	as stated in parent function
		 * @param  {[type]} legend:			whether or not to show chart legend. accepts [true or false]
		 * @param  {[type]} graphType:	as stated in parent function
		 */
		function donutPieChartFlot(placeholder, legend, graphType, dateRange, controllerPath){

			/* Get parameters set in in placeholder */
			var graphSizeWidth = $(placeholder).width();
			var graphSizeHeight = $(placeholder).height();
			var graphSizeMin;
			var graphSize = 0.88;

			if(graphSizeHeight <= graphSizeWidth){
				graphSizeMin = graphSizeHeight;
			}else{
				graphSizeMin = graphSizeWidth;
			}

			if((graphType == "donut") || (graphType === null) || (graphType === undefined) || (graphType == "")){
				if((graphSizeMin === undefined) || (graphSizeMin === null)){
					graphSize = 0.88;
				}else if(graphSizeMin <= 32){
					graphSize = 0.75;
				}else if((graphSizeMin > 32) && (graphSizeMin <= 90)){
					graphSize = 0.85;
				}else if((graphSizeMin > 90) && (graphSizeMin <= 130)){
					graphSize = 0.87;
				}else if(graphSizeMin > 130){
					graphSize = 0.88;
				}
			}else{
				graphSize = 0;
			}

			var thisBlock = $(placeholder).closest(".panel");
			var url = 'index.php?route=b5b_qore_engine/' + controllerPath + '/chart&user_token=' + userToken + '&range=' + dateRange;

			$.ajax({
				type: 'GET',
				url: url,
				beforeSend: function(){
					/* Display loading icon */
					thisBlock.find(".panel-title .icon-success").remove();
					thisBlock.find(".panel-title .icon-error").remove();
					thisBlock.find('.panel-title').prepend("<span class='icon loading' style='opacity:1;'></span>");
				},
				complete: function(){
					/* Display loading icon */
					thisBlock.find(".panel-title .icon.loading").remove();
				},
				error: function(){
					thisBlock.find('.panel-title').prepend("<span class='icon icon-exclamation icon-size-medium icon-error' style='opacity:1;'></span>");
					thisBlock.find(".panel-title .icon-error").delay(5000).fadeOut(1000);
				},
				success: function(json){
					thisBlock.find('.panel-title').prepend("<span class='icon icon-check icon-size-medium icon-success' style='opacity:1;'></span>");
					thisBlock.find(".panel-title .icon-success").delay(5000).fadeOut(1000);

					var data = [];
					var dataObj = {};
					var colorGraph = [];
					var colorGraphTemp = $(placeholder).data("graph-colors").split(',');

					var legendItems = thisBlock.find(".top-ranking-item");

					var dataRange = json['id'].length;

					for (var n = 0; n < 5; n++){

						var valueGraph = parseInt(json.total[n]);
						var colorGraph = colorGraphTemp[n];
						var itemName = json.name[n];
						var totalFormated = json.total_formated[n];

						if(isNaN(valueGraph)){
							
							// Set the Background color of the legend box
							legendItems.eq(n).find(".top-ranking-item-legend-color-box").css({"background-color":colorGraph});

							// Set the "data-raw-value" for each item
							legendItems.eq(n).find(".top-ranking-item-legend-text").attr("data-raw-value","--");

							// Set Sold Count
							legendItems.eq(n).find(".top-ranking-item-legend-text .count").text("--");

							// Set Item Name
							legendItems.eq(n).find(".top-ranking-item-legend-text .item-name").text("--");

							// Set Item Link
							var itemLink = 'index.php?route=common/dashboard&user_token=' + userToken;
							legendItems.eq(n).find(".top-ranking-item-legend-text a").attr('href', itemLink);

							// Populate Flot data array
							dataObj = {data: '', color: '', label: ''};
						}else{

							// Set the Background color of the legend box
							legendItems.eq(n).find(".top-ranking-item-legend-color-box").css({"background-color":colorGraph});

							// Set the "data-raw-value" for each item
							legendItems.eq(n).find(".top-ranking-item-legend-text").attr("data-raw-value",valueGraph);

							// Set Sold Count
							if(totalFormated == ""){
								legendItems.eq(n).find(".top-ranking-item-legend-text .count").text(valueGraph.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
							}else{
								legendItems.eq(n).find(".top-ranking-item-legend-text .count").text(totalFormated);
							}
							

							// Set Item Name
							legendItems.eq(n).find(".top-ranking-item-legend-text .item-name").text(itemName);

							// Set Item Link
							var itemLink = 'index.php?route=catalog/product&user_token=' + userToken + '&filter_name=' + encodeURI(itemName);
							legendItems.eq(n).find(".top-ranking-item-legend-text a").attr('href', itemLink);

							var textGraph = legendItems.eq(n).find(".top-ranking-item-legend-text").text();

							// Populate Flot data array
							dataObj = {data: valueGraph, color: colorGraph, label: textGraph};
						}

						data.push(dataObj);
					}

					if(legend === undefined){
						legend = true;
					}

					var options = {
						series: {
							pie: { 
								show: true,
								radius:  1,
								innerRadius: graphSize,
								label: false
							}
						},
						legend: {
							show: legend
						},
						grid: {
							hoverable: true
						},
						tooltip: true,
						tooltipOpts: {
							content: function(label, xval, yval, flotItem){
								return label;
							},
							shifts: {
								x: -60,
								y: 25
							},
							defaultTheme : false
						}
					};

					// Plot the chart and set options
					var plotChart = $.plot(placeholder, data, options);

					if(isNaN(plotChart.getData()[0].percent)){
						var canvas = plotChart.getCanvas();
						var ctx = canvas.getContext("2d");
						var x = canvas.width / 2;
						var y = canvas.height / 2;
						ctx.textAlign = 'center';
						ctx.fillText(json.language['error_no_data'], x, y);
					}

					if(plotChart){
						return true;
					}
				}
			});
		}
	}
}



/* Switchery - Color Presets */
function circloid_switchery_color_presets(){

	// Current Color Preset
	var colorPresetGlobal = $('body').data('color-preset');

	// For Color Presets that are OFF
	var currentTheme = encodeURIComponent(getUrlParameter('theme'));

	if($('.js-switch-color-preset').length){
		var elemsEnabled = Array.prototype.slice.call(document.querySelectorAll('.js-switch-color-preset.js-switch-enabled'));

		elemsEnabled.forEach(function(html) {
			var colorPresetParent = $(html).closest('tr');
			var colorPreset = encodeURIComponent(colorPresetParent.data('color-preset'));

			var switchery = new Switchery(html, {
				size: 'small'
			});

			// Get current state of checkbox
			html.onchange = function() {

				var checkboxStatus = encodeURIComponent(html.checked);

				$.ajax({
					type: 'get',
					url: 'index.php?route=b5b_qore_engine/theme_settings/change_color_profile&user_token=' + userToken + '&theme=' + currentTheme + '&color_preset=' + colorPreset + '&status=' + checkboxStatus,
					dataType: 'json',
					beforeSend: function() {
						colorPresetParent.closest('table').find('th.actions .loader').remove();

						switchery.disable();

						colorPresetParent.closest('table').find('th.actions').prepend('<img class="loader" src="view/template/b5b_qore_engine/themes/circloid_2/default/images/loading_mixed.svg" width="17">');
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert('An error occurred. Refreshing page now.');

						location.reload();

						dynamicDuration = 150;

						colorPresetParent.closest('table').find('th.actions img.loader').velocity({
							opacity: 0
						},
						{
							easing: 'easeOutCubic',
							duration: dynamicDuration,
							delay: dynamicDelay,
							complete:
							function(elements){
								$(this).remove();
							}
						});
					},
					success: function(json) {
						dynamicDuration = 150;

						colorPresetParent.closest('table').find('th.actions img.loader').velocity({
							opacity: 0
						},
						{
							easing: 'easeOutCubic',
							duration: dynamicDuration,
							delay: dynamicDelay,
							complete:
							function(elements){
								$(this).remove();
								colorPresetParent.closest('table').find('th.actions').prepend(json.language['success_message']);
							}
						});

						if(json.success){
							location.reload();
							// switchery.enable();

							// Add the css to the header (don't forget to add the necesary code to header.tpl and header.php controller to pull the color theme)
							// ALso make sure to use the first color in the presets as the default when installing the theme
						}else{
							alert(json.language['error_message']);

							location.reload();
						}
					}
				});
			};
		});

		// For Color Presets that are ON (should only be 1)
		var elemDisabled = document.querySelector('.js-switch-color-preset.js-switch-disabled');

		var switcheryDisabled = new Switchery(elemDisabled, {
			size: 'small'
		});
		switcheryDisabled.disable();
	}
}

/* Switchery - Extension Switches */
function circloid_switchery_extension_control(){

	// Current Color Preset
	var colorPresetGlobal = $('body').data('color-preset');

	if($('.js-switch-extension-fix.js-switch-enabled').length){
		var elemsEnabled = Array.prototype.slice.call(document.querySelectorAll('.js-switch-extension-fix.js-switch-enabled'));

		elemsEnabled.forEach(function(html) {
			var extensionParent = $(html).closest('tr');

			var switchery = new Switchery(html, {
				size: 'small'
			});

			// Get current state of checkbox
			html.onchange = function() {

				var checkboxStatus = encodeURIComponent(html.checked);
				var extensionFileName = encodeURIComponent(extensionParent.data('file-name'));

				if(checkboxStatus == 'true'){
					var enableDisable = "enable_extension";
				}else{
					var enableDisable = "disable_extension";
				}

				$.ajax({
					type: 'get',
					url: 'index.php?route=b5b_qore_engine/theme_settings/' + enableDisable + '&user_token=' + userToken + '&filename=' + extensionFileName,
					dataType: 'json',
					beforeSend: function() {
						extensionParent.closest('table').find('th.actions .loader').remove();

						switchery.disable();

						extensionParent.closest('table').find('th.actions').prepend('<img class="loader" src="view/template/b5b_qore_engine/themes/circloid_2/default/images/loading_' + colorPresetGlobal + '.svg" width="17">');
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert('An error occurred. Refreshing page now.');

						location.reload();

						dynamicDuration = 150;

						extensionParent.closest('table').find('th.actions img.loader').velocity({
							opacity: 0
						},
						{
							easing: 'easeOutCubic',
							duration: dynamicDuration,
							delay: dynamicDelay,
							complete:
							function(elements){
								$(this).remove();
							}
						});
					},
					success: function(json) {
						dynamicDuration = 150;

						extensionParent.closest('table').find('th.actions img.loader').velocity({
							opacity: 0
						},
						{
							easing: 'easeOutCubic',
							duration: dynamicDuration,
							delay: dynamicDelay,
							complete:
							function(elements){
								$(this).remove();
								extensionParent.closest('table').find('th.actions').prepend(json.language['success_message']);
							}
						});

						if(json.success){

							var extensionFileNameNew = '';

							if(checkboxStatus === 'true'){
								extensionFileNameNew = extensionFileName.substring(0, extensionFileName.length - 1);
							}else{
								extensionFileNameNew = extensionFileName + "_";
							}

							extensionParent.data('file-name', extensionFileNameNew);

							switchery.enable();
						}else{
							alert('An error occurred. Refreshing page now.');

							location.reload();
						}
					}
				});
			};
		});
	}
}

/* Switchery - Extension Switches */
function circloid_switchery_white_label_control(){

	// Current Color Preset
	var colorPresetGlobal = $('body').data('color-preset');

	if($('.js-switch-white-label.js-switch-enabled').length){

		// First change the placeholder images to the current ones used on the site
		var lightBgLogo = $('img.default-logo').attr('src');
		var darkBgLogo = $('img.default-logo').attr('src');

		$('.sample-image-light-bg').attr('src', lightBgLogo);
		$('.sample-image-dark-bg').attr('src', darkBgLogo);

		// Upload logo
		//////////////////////
		// This is handled by an external js file
		// called form-file-upload.js within the 'plugins' folder
		//////////////////////

		// Handle the Text Input Fields
		$('.white-label-text-input-button').each(function(){

			$(this).on('click', function(){
			
				var thisButton = $(this);

				var textField = thisButton.closest('.form-group').find('.white-label-text-input');
				var textFieldValue = encodeURIComponent(textField.val());
				var whiteLabelSettingName = encodeURIComponent(textField.closest('tr').data('white-label-name'));

				/* Theme Name */
				var theme_name = getUrlParameter('theme');

				$.ajax({
					type: 'get',
					url: 'index.php?route=b5b_qore_engine/theme_settings/white_label_settings&white_label_setting_value=' + textFieldValue + '&user_token=' + userToken + '&white_label_setting_name=' + whiteLabelSettingName + '&theme_name=' + theme_name,
					dataType: 'json',
					beforeSend: function() {
						textField.closest('table').find('th.actions .loader').remove();

						textField.closest('table').find('th.actions').prepend('<img class="loader" src="view/template/b5b_qore_engine/themes/circloid_2/default/images/loading_' + colorPresetGlobal + '.svg" width="17">');
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert('An error occurred. Refreshing page now.');

						location.reload();

						dynamicDuration = 150;

						textField.closest('table').find('th.actions img.loader').velocity({
							opacity: 0
						},
						{
							easing: 'easeOutCubic',
							duration: dynamicDuration,
							delay: dynamicDelay,
							complete:
							function(elements){
								$(this).remove();
							}
						});
					},
					success: function(json) {
						dynamicDuration = 150;

						textField.closest('table').find('th.actions img.loader').velocity({
							opacity: 0
						},
						{
							easing: 'easeOutCubic',
							duration: dynamicDuration,
							delay: dynamicDelay,
							complete:
							function(elements){
								$(this).remove();
								textField.closest('table').find('th.actions').prepend(json.language['success_message']);
							}
						});

						if(json.success){
							location.reload();
						}else{
							alert(json.error);

							location.reload();
						}
					}
				});
			});
		});

		// Handle the switches
		var elemsEnabled = Array.prototype.slice.call(document.querySelectorAll('.js-switch-white-label.js-switch-enabled'));

		elemsEnabled.forEach(function(html) {
			var whiteLabelParent = $(html).closest('tr');

			var switchery = new Switchery(html, {
				size: 'small'
			});

			// Get current state of checkbox
			html.onchange = function() {

				var checkboxStatus = encodeURIComponent(html.checked);
				var whiteLabelSettingName = encodeURIComponent(whiteLabelParent.data('white-label-name'));

				if(checkboxStatus == 'true'){
					var enableDisable = 1;
				}else{
					var enableDisable = 0;
				}

				/* Theme Name */
				var theme_name = getUrlParameter('theme');

				$.ajax({
					type: 'get',
					url: 'index.php?route=b5b_qore_engine/theme_settings/white_label_settings&white_label_setting_value=' + enableDisable + '&user_token=' + userToken + '&white_label_setting_name=' + whiteLabelSettingName + '&theme_name=' + theme_name,
					dataType: 'json',
					beforeSend: function() {
						whiteLabelParent.closest('table').find('th.actions .loader').remove();

						switchery.disable();

						whiteLabelParent.closest('table').find('th.actions').prepend('<img class="loader" src="view/template/b5b_qore_engine/themes/circloid_2/default/images/loading_' + colorPresetGlobal + '.svg" width="17">');
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert('An error occurred. Refreshing page now.');

						location.reload();

						dynamicDuration = 150;

						whiteLabelParent.closest('table').find('th.actions img.loader').velocity({
							opacity: 0
						},
						{
							easing: 'easeOutCubic',
							duration: dynamicDuration,
							delay: dynamicDelay,
							complete:
							function(elements){
								$(this).remove();
							}
						});
					},
					success: function(json) {
						dynamicDuration = 150;

						whiteLabelParent.closest('table').find('th.actions img.loader').velocity({
							opacity: 0
						},
						{
							easing: 'easeOutCubic',
							duration: dynamicDuration,
							delay: dynamicDelay,
							complete:
							function(elements){
								$(this).remove();
								whiteLabelParent.closest('table').find('th.actions').prepend(json.language['success_message']);
							}
						});

						if(json.success){
							switchery.enable();

							location.reload();
						}else{
							alert(json.error);

							location.reload();
						}
					}
				});
			};
		});
	}
}

/* Hex to RGBA */
function circloid_hexToRgbA(hex, alpha){
	var r = parseInt(hex.slice(1, 3), 16),
	g = parseInt(hex.slice(3, 5), 16),
	b = parseInt(hex.slice(5, 7), 16);

	if(alpha){
		return "rgba(" + r + ", " + g + ", " + b + ", " + alpha + ")";
	}else{
		return "rgb(" + r + ", " + g + ", " + b + ")";
	}
}

/* Create Unique String */
var uniqueString = (function (){
	var text = "";
	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

	for( var i=0; i < 8; i++ )
		text += possible.charAt(Math.floor(Math.random() * possible.length));

	return text;
})();

/* Window Resize Timer Function */
var uniqueTimeStamp = new Date().getTime();

var waitForFinalEvent = (function () {
	var timers = {};
	return function (callback, ms, uniqueId) {
		if (!uniqueId) {
			uniqueId = 'unique id';
		}
		if (timers[uniqueId]) {
			clearTimeout (timers[uniqueId]);
		}
		timers[uniqueId] = setTimeout(callback, ms);
	};
})();

/* Get URL Parameters */
var getUrlParameter = function getUrlParameter(sParam){
	var sPageURL = decodeURIComponent(window.location.search.substring(1)),
	sURLVariables = sPageURL.split('&'),
	sParameterName,
	i;

	for (i = 0; i < sURLVariables.length; i++) {
		sParameterName = sURLVariables[i].split('=');

		if (sParameterName[0] === sParam) {
			return sParameterName[1] === undefined ? true : sParameterName[1];
		}
	}
};

/* Token */
var userToken = getUrlParameter('user_token');

/* Route */
var route = getUrlParameter('route');

/**
 * Copied from default OpenCart js file
 */

function b5b_qore_engine_default_oc_functions(){
	//Form Submit for IE Browser
	$('button[type=\'submit\']').on('click', function() {
		$("form[id*='form-']").submit();
	});

	// Highlight any found errors
	$('.text-danger').each(function() {
		var element = $(this).parent().parent();

		if (element.hasClass('form-group')) {
			element.addClass('has-error');
		}
	});
	
	// Tooltip remove fixed
	$(document).on('click', '[data-toggle=\'tooltip\']', function(e) {
		$('body > .tooltip').remove();
	});

	// $(document).on('click', function(e) {

	// 	var imageBtn = $(this);

	// 	imageBtn.popover();
		
	// 	e.preventDefault();
	// });

	// Image Manager
	$(document).on('click', 'a[data-toggle=\'image\']', function(e) {
		var $element = $(this);
		var $popover = $element.data('bs.popover'); // element has bs popover?
		
		e.preventDefault();

		// destroy all image popovers
		$('a[data-toggle="image"]').popover('destroy');

		// remove flickering (do not re-add popover when clicking for removal)
		if ($popover) {
			return;
		}

		$element.popover({
			html: true,
			placement: 'right',
			trigger: 'manual',
			content: function() {
				return '<button type="button" id="button-image" class="btn btn-primary"><i class="fa fa-pencil"></i></button> <button type="button" id="button-clear" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>';
			}
		});

		$element.popover('show');

		$('#button-image').on('click', function() {
			var $button = $(this);
			var $icon   = $button.find('> i');
			
			$('#modal-image').remove();

			$.ajax({
				url: 'index.php?route=common/filemanager&user_token=' + userToken + '&target=' + $element.parent().find('input').attr('id') + '&thumb=' + $element.attr('id'),
				dataType: 'html',
				beforeSend: function() {
					$button.prop('disabled', true);
					if ($icon.length) {
						$icon.attr('class', 'fa fa-circle-o-notch fa-spin');
					}
				},
				complete: function() {
					$button.prop('disabled', false);
					if ($icon.length) {
						$icon.attr('class', 'fa fa-pencil');
					}
				},
				success: function(html) {
					$('body').append('<div id="modal-image" class="modal">' + html + '</div>');

					$('#modal-image').modal('show');
				}
			});

			$element.popover('destroy');
		});

		$('#button-clear').on('click', function() {
			$element.find('img').attr('src', $element.find('img').attr('data-placeholder'));

			$element.parent().find('input').val('');

			$element.popover('destroy');
		});
	});

	// tooltips on hover
	$('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});

	// Makes tooltips work on ajax generated content
	$(document).ajaxStop(function() {
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
	});

	// https://github.com/opencart/opencart/issues/2595
	$.event.special.remove = {
		remove: function(o) {
			if (o.handler) {
				o.handler.apply(this, arguments);
			}
		}
	}

	$('[data-toggle=\'tooltip\']').on('remove', function() {
		$(this).tooltip('destroy');
	});
}

// Autocomplete
(function($) {
	$.fn.autocomplete = function(option) {
		return this.each(function() {
			var $this = $(this);
			var $dropdown = $('<ul class="dropdown-menu" />');
			
			this.timer = null;
			this.items = [];

			$.extend(this, option);

			$this.attr('autocomplete', 'off');

			// Focus
			$this.on('focus', function() {
				this.request();
			});

			// Blur
			$this.on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);
			});

			// Keydown
			$this.on('keydown', function(event) {
				switch(event.keyCode) {
					case 27: // escape
						this.hide();
						break;
					default:
						this.request();
						break;
				}
			});

			// Click
			this.click = function(event) {
				event.preventDefault();

				var value = $(event.target).parent().attr('data-value');

				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}

			// Show
			this.show = function() {
				var pos = $this.position();

				$dropdown.css({
					top: pos.top + $this.outerHeight(),
					left: pos.left
				});

				$dropdown.show();
			}

			// Hide
			this.hide = function() {
				$dropdown.hide();
			}

			// Request
			this.request = function() {
				clearTimeout(this.timer);

				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}

			// Response
			this.response = function(json) {
				var html = '';
				var category = {};
				var name;
				var i = 0, j = 0;

				if (json.length) {
					for (i = 0; i < json.length; i++) {
						// update element items
						this.items[json[i]['value']] = json[i];

						if (!json[i]['category']) {
							// ungrouped items
							html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
						} else {
							// grouped items
							name = json[i]['category'];
							if (!category[name]) {
								category[name] = [];
							}

							category[name].push(json[i]);
						}
					}

					for (name in category) {
						html += '<li class="dropdown-header">' + name + '</li>';

						for (j = 0; j < category[name].length; j++) {
							html += '<li data-value="' + category[name][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[name][j]['label'] + '</a></li>';
						}
					}
				}

				if (html) {
					this.show();
				} else {
					this.hide();
				}

				$dropdown.html(html);
			}

			$dropdown.on('click', '> li > a', $.proxy(this.click, this));
			$this.after($dropdown);
		});
	}
})(window.jQuery);