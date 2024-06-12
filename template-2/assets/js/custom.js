(function ($) {
	
	"use strict";

	$(".loader").delay(300).fadeOut("slow");
	$("#overlayer").delay(300).fadeOut("slow");	

	$(function() {
		$(window).on("scroll", function() {
			if($(window).scrollTop() > 50) {
				$("#header").addClass("header-active");
				$("#header").addClass("header-text-active");
			} else {
				//remove the background property so it comes transparent again (defined in your css)
				$("#header").removeClass("header-active");
			}
		});
	});


	var width = $(window).width();
		$(window).resize(function() {
		if (width > 767 && $(window).width() < 767) {
			location.reload();
		}
		else if (width < 767 && $(window).width() > 767) {
			location.reload();
		}
	})

	const elem = document.querySelector('.event_box');
	const filtersElem = document.querySelector('.event_filter');
	if (elem) {
		const rdn_events_list = new Isotope(elem, {
			itemSelector: '.event_outer',
			layoutMode: 'masonry'
		});
		if (filtersElem) {
			filtersElem.addEventListener('click', function(event) {
				if (!matchesSelector(event.target, 'a')) {
					return;
				}
				const filterValue = event.target.getAttribute('data-filter');
				rdn_events_list.arrange({
					filter: filterValue
				});
				filtersElem.querySelector('.is_active').classList.remove('is_active');
				event.target.classList.add('is_active');
				event.preventDefault();
			});
		}
	}

		/**
	 * Mobile nav toggle
	 */
	document.querySelector('.mobile-nav-toggle').addEventListener('click', function(e) {
		document.querySelector('#navbar').classList.toggle('navbar-mobile');
		this.classList.toggle('fa-bars');
		this.classList.toggle('fa-xmark');
	});
	
	/**
	 * Mobile nav dropdowns activate
	 */
	document.querySelectorAll('.navbar .dropdown > a').forEach(function(element) {
		element.addEventListener('click', function(e) {
		if (document.querySelector('#navbar').classList.contains('navbar-mobile')) {
			e.preventDefault();
			this.nextElementSibling.classList.toggle('dropdown-active');
		}
		});
	});


	$('.owl-banner').owlCarousel({
		center: true,
      items:1,
      loop:true,
		autoplay: true,
		autoplayTimeout:4000,
		smartSpeed: 1000,
      nav: true,
		navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
      margin:30,
      responsive:{
			992:{
					items:1
			},
			1200:{
				items:1
			}
      }
	});

	$('.owl-3-slider').owlCarousel({
		loop: true,
		autoHeight: true,
		margin: 10,
		autoplay: true,
		smartSpeed: 700,
		items: 1,
		nav: true,
		dots: true,
		navText: ['<span class="icon-keyboard_backspace"></span>','<span class="icon-keyboard_backspace"></span>'],
		responsive:{
			0:{
				items:1
			},
			600:{
				items:1
			},
			800: {
				items:2
			},
			1000:{
				items:2
			},
			1100:{
				items:3
			}
		}
	});

	$('.announcement-slide').owlCarousel({
		items: 1,
		loop: true,
		margin: 0,
		autoplay: true,
		autoplayTimeout:3000,
		autoplayHoverPause:true,
		nav: true,
		dots: false,
		navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
		smartSpeed: 400
	});

	$('.owl-media').owlCarousel({
		center: true,
      items:1,
      loop:true,
      nav: true,
		navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
      margin:30,
      responsive:{
			992:{
					items:1
			},
			1200:{
				items:1
			}
      }
	});

	$('.owl-services').owlCarousel({
      loop:false,
      nav: true,
      margin:10,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:2
			},
			800: {
				items:2
			},
			900: {
				items:3
			},
			1000:{
				items:3
			}
		}
	});

	$('.gallery-slider').owlCarousel({
		loop: false,
		items: 3,
		margin: 20,
		autoplay: true,
		smartSpeed: 700,
		nav: true,
		dots: false,
		navText: ['<span class="icon-arrow_back">', '<span class="icon-arrow_forward">']
	});


	// Menu Dropdown Toggle
	if($('.menu-trigger').length){
		$(".menu-trigger").on('click', function() {	
			$(this).toggleClass('active');
			$('.header-area .nav').slideToggle(200);
		});
	}





	// Menu elevator animation
	$('.scroll-to-section a[href*=\\#]:not([href=\\#])').on('click', function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			if (target.length) {
				var width = $(window).width();
				if(width < 767) {
					$('.menu-trigger').removeClass('active');
					$('.header-area .nav').slideUp(200);	
				}				
				$('html,body').animate({
					scrollTop: (target.offset().top) - 80
				}, 700);
				return false;
			}
		}
	});

	$(document).ready(function () {
		$(document).on("scroll", onScroll);
		
		//smoothscroll
		$('.scroll-to-section a[href^="#"]').on('click', function (e) {
			e.preventDefault();
			$(document).off("scroll");
			
			$('.scroll-to-section a').each(function () {
				$(this).removeClass('active');
			})
			$(this).addClass('active');
		
			var target = this.hash,
			menu = target;
			var target = $(this.hash);
			$('html, body').stop().animate({
				scrollTop: (target.offset().top) - 79
			}, 500, 'swing', function () {
				window.location.hash = target;
				$(document).on("scroll", onScroll);
			});
		});
	});

	function onScroll(event){
		var scrollPos = $(document).scrollTop();
		$('.nav a').each(function () {
			var currLink = $(this);
			var refElement = $(currLink.attr("href"));
			if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
				$('.nav ul li a').removeClass("active");
				currLink.addClass("active");
			}
			else{
				currLink.removeClass("active");
			}
		});
	}


	// Page loading animation
	$(window).on('load', function() {
		if($('.cover').length){
			$('.cover').parallax({
				imageSrc: $('.cover').data('image'),
				zIndex: '1'
			});
		}

		$("#preloader").animate({
			'opacity': '0'
		}, 600, function(){
			setTimeout(function(){
				$("#preloader").css("visibility", "hidden").fadeOut();
			}, 300);
		});
	});

	const dropdownOpener = $('.main-nav ul.nav .has-sub > a');

	// Open/Close Submenus
	if (dropdownOpener.length) {
		dropdownOpener.each(function () {
			var _this = $(this);

			_this.on('tap click', function (e) {
					var thisItemParent = _this.parent('li'),
						thisItemParentSiblingsWithDrop = thisItemParent.siblings('.has-sub');

					if (thisItemParent.hasClass('has-sub')) {
						var submenu = thisItemParent.find('> ul.sub-menu');

						if (submenu.is(':visible')) {
							submenu.slideUp(450, 'easeInOutQuad');
							thisItemParent.removeClass('is-open-sub');
						} else {
							thisItemParent.addClass('is-open-sub');

							if (thisItemParentSiblingsWithDrop.length === 0) {
									thisItemParent.find('.sub-menu').slideUp(400, 'easeInOutQuad', function () {
										submenu.slideDown(250, 'easeInOutQuad');
									});
							} else {
									thisItemParent.siblings().removeClass('is-open-sub').find('.sub-menu').slideUp(250, 'easeInOutQuad', function () {
										submenu.slideDown(250, 'easeInOutQuad');
									});
							}
						}
					}

					e.preventDefault();
			});
		});
	}

})(window.jQuery);