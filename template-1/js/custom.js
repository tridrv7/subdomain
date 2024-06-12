AOS.init({
	duration: 800,
	easing: 'slide',
	once: true
});

$(function(){

	'use strict';

	$(".loader").delay(200).fadeOut("slow");
	$("#overlayer").delay(200).fadeOut("slow");	

	var siteMenuClone = function() {

		$('.js-clone-nav').each(function() {
			var $this = $(this);
			$this.clone().attr('class', 'site-nav-wrap').appendTo('.site-mobile-menu-body');
		});


		setTimeout(function() {
			
			var counter = 0;
      $('.site-mobile-menu .has-children').each(function(){
        var $this = $(this);
        
        $this.prepend('<span class="arrow-collapse collapsed">');

        $this.find('.arrow-collapse').attr({
          'data-toggle' : 'collapse',
          'data-target' : '#collapseItem' + counter,
        });

        $this.find('> ul').attr({
          'class' : 'collapse',
          'id' : 'collapseItem' + counter,
        });

        counter++;

      });

    }, 1000);

		$('body').on('click', '.arrow-collapse', function(e) {
      var $this = $(this);
      if ( $this.closest('li').find('.collapse').hasClass('show') ) {
        $this.removeClass('active');
      } else {
        $this.addClass('active');
      }
      e.preventDefault();  
      
    });

		$(window).resize(function() {
			var $this = $(this),
				w = $this.width();

			if ( w > 768 ) {
				if ( $('body').hasClass('offcanvas-menu') ) {
					$('body').removeClass('offcanvas-menu');
				}
			}
		})

		$('body').on('click', '.js-menu-toggle', function(e) {
			var $this = $(this);
			e.preventDefault();

			if ( $('body').hasClass('offcanvas-menu') ) {
				$('body').removeClass('offcanvas-menu');
				$('body').find('.js-menu-toggle').removeClass('active');
			} else {
				$('body').addClass('offcanvas-menu');
				$('body').find('.js-menu-toggle').addClass('active');
			}
		}) 

		// click outisde offcanvas
		$(document).mouseup(function(e) {
	   	var container = $(".site-mobile-menu");
	   	if (!container.is(e.target) && container.has(e.target).length === 0) {
	      	if ( $('body').hasClass('offcanvas-menu') ) {
					$('body').removeClass('offcanvas-menu');
					$('body').find('.js-menu-toggle').removeClass('active');
				}
	   	}
		});
	};
	

	siteMenuClone();

	var owlPlugin = function() {

		if ( $('.announcement-slide').length > 0 ) {
			$('.announcement-slide').owlCarousel({
				items: 1,
				loop: true,
				margin: 0,
				autoplay: true,
				autoplayTimeout:3000,
				autoplayHoverPause:true,
				nav: true,
				dots: false,
				navText: ['<span class="icon-arrow_back">', '<span class="icon-arrow_forward">'],
				smartSpeed: 400
			});
		}
		
		if ( $('.banner-slide').length > 0 ) {
			$('.banner-slide').owlCarousel({
				center: true,
				animateOut: 'fadeOut',
				items:1,
				loop:true,
				margin:0,
				autoplay:true,
				autoplayHoverPause:false,
				autoplayTimeout: 5000,
				nav:false,
				dots:false
			});
		}



		if ( $('.news-slider').length > 0 ) {
			$('.news-slider').owlCarousel({
				loop: false,
				margin: 20,
				autoplay: true,
				smartSpeed: 700,
				nav: true,
				dots: false,
				navText: ['<span class="icon-arrow_back">', '<span class="icon-arrow_forward">'],
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
		}
		
		if ( $('.event-slider').length > 3 ) {
			$('.event-slider').owlCarousel({
				loop: false,
				margin: 20,
				autoplay: true,
				smartSpeed: 700,
				nav: true,
				dots: false,
				navText: ['<span class="icon-arrow_back">', '<span class="icon-arrow_forward">'],
				items: 1
			});
		}


		if ( $('.link-slider').length > 0 ) {
			$('.link-slider').owlCarousel({
				loop: false,
				autoHeight: true,
				margin: 10,
				autoplay: true,
				smartSpeed: 700,
				stagePadding: 0,
				nav: false,
				dots: true,
				responsive:{
					0:{
						items:2
					},
					600:{
						items:3
					},
					800: {
						items:4
					},
					1000:{
						items:6
					}
				}
			});
		}


		if ( $('.services-slider').length > 0 ) {
			$('.services-slider').owlCarousel({
				loop: true,
				margin: 20,
				autoplay: true,
				smartSpeed: 700,
				stagePadding: 0,
				nav: true,
				dots: true,
				navText: ['<span class="icon-arrow_back">', '<span class="icon-arrow_forward">'],
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
					1000:{
						items:3
					}
				}
			});
		}

	}

	owlPlugin();


  var scrollWindow = function() {
    $(window).scroll(function(){
      var $w = $(this),
          st = $w.scrollTop(),
          navbar = $('.js-site-navbar'),
          sd = $('.js-scroll-wrap'), 
          toggle = $('.site-menu-toggle');

      // if ( toggle.hasClass('open') ) {
      //   $('.site-menu-toggle').trigger('click');
      // }
      

      if (st > 150) {
        if ( !navbar.hasClass('scrolled') ) {
          navbar.addClass('scrolled');  
        }
      } 
      if (st < 150) {
        if ( navbar.hasClass('scrolled') ) {
          navbar.removeClass('scrolled sleep');
        }
      } 
      if ( st > 350 ) {
        if ( !navbar.hasClass('awake') ) {
          navbar.addClass('awake'); 
        }
        
        if(sd.length > 0) {
          sd.addClass('sleep');
        }
      }
      if ( st < 350 ) {
        if ( navbar.hasClass('awake') ) {
          navbar.removeClass('awake');
          navbar.addClass('sleep');
        }
        if(sd.length > 0) {
          sd.removeClass('sleep');
        }
      }
    });
  };
  scrollWindow();

	var counter = function() {
		
		$('.count-numbers').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('ut-animated') ) {

				var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(',')
				$('.counter > span').each(function(){
					var $this = $(this),
						num = $this.data('number');
					$this.animateNumber(
					  {
					    number: num,
					    numberStep: comma_separator_number_step
					  }, 5000
					);
				});
				
			}

		} , { offset: '95%' } );

	}
	counter();

	// jarallax
	var jarallaxPlugin = function() {
		if ( $('.jarallax').length > 0 ) {
			$('.jarallax').jarallax({
		    speed: 0.2
			});
		}
	};
	jarallaxPlugin();

	

	var accordion = function() {
		$('.btn-link[aria-expanded="true"]').closest('.accordion-item').addClass('active');
	  $('.collapse').on('show.bs.collapse', function () {
		  $(this).closest('.accordion-item').addClass('active');
		});

	  $('.collapse').on('hidden.bs.collapse', function () {
		  $(this).closest('.accordion-item').removeClass('active');
		});
	}
	accordion();

	var links = $('.js-hover-focus-one .service-sm')
		.mouseenter(function(){
			links.addClass('unfocus');
			$(this).removeClass('unfocus');
		}).mouseleave(function(){
			$(this).removeClass('unfocus');
			links.removeClass('unfocus');
		})






	$('[data-fancybox="images"]').fancybox({
		caption : function( instance, item ) {
		var caption = $(this).data('caption') || '';
		if ( item.type === 'image' ) {
			caption = (caption.length ? caption + '<br />' : '') + '<a href="' + item.src + '">Download image</a>' ;
			}
			return caption;
		}
	});

	
	


})