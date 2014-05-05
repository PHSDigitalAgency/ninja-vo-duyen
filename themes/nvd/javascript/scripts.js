jQuery.noConflict();
(function($){
	$(document).ready(function(){
		/*
		 * Dropdown Top Menu
		 */
		function setDropDownMenu(){
			$('#menu .dropdown-menu').each(function(i){
				$(this).css({'width':$('#menu .container').outerWidth(), 'marginLeft': - $(this).parent('.dropdown').offset().left + $('#menu .container').offset().left});
			});
		}
		/*
		 * Scroll top button
		 */
		$('.scrollTop').click(function(){
			$('body,html').animate({scrollTop: 0}, 500);
			return false;
		});

		/*
		 * Scroll
		 */
		$(window).scroll(function(){
			$('#social-toolbox').css({'marginBottom': Math.max($(document).scrollTop() + window.innerHeight - $('#footer').position().top - parseInt($('#footer').css('marginTop')), 0)});

			setDropDownMenu();

			setTimeout(setDropDownMenu, 200);
		});

		/*
		 * Resize
		 */
		$(window).resize(function(){
			$(window).scroll();

			$('#social-toolbox').css({'left': $('#layout').offset().left + ($('#innerLayout').width() - $('#social-toolbox').width()) * .5});

			setTimeout(function(){ $(window).scroll(); }, 200);
		});

		/*
		 * Section links
		 */
		$('#menu .container .navbar:first-child .navbar-inner .nav-collapse > ul > li > a').hammer().on('tap doubletap', function(event){
			event.preventDefault();
			if ((Modernizr.touch && event.type == 'doubletap') || (!Modernizr.touch && event.type == 'tap')){
				window.location = this.href;
			} 
		});
				
		/*
		 * Tooltips with links (top menu thumbnails and tag links article)
		 */
		$('#menu .container .navbar:first-child .navbar-inner .nav-collapse .dropdown-menu li a:not(.sub-section), .tags a').hammer().on('tap doubletap mouseenter mouseleave', function(event){
			event.preventDefault();
			if ((Modernizr.touch && event.type == 'doubletap') || (!Modernizr.touch && event.type == 'tap')){
				window.location = this.href;
			}else if((Modernizr.touch && event.type == 'tap') || event.type == 'mouseenter' || event.type == 'mouseleave'){
				$(this).tooltip('toggle');
			}
		});

		/*
		 * Videos fitVids
		 */
		$("#layout .video").fitVids();

		/*
		 * Carousel Homepage
		 */
		$('#myCarousel').carousel()

		/*
		 * Initialization
		 */
		$(window).resize();
	});
}(jQuery));