addEventListener("load", function() {
	 setTimeout(hideURLbar, 0); 
	 }, false);
function hideURLbar(){
	window.scrollTo(0,1); 
	}
jQuery(function() {
	jQuery('.starbox').each(function() {
		var starbox = jQuery(this);
			starbox.starbox({
			average: starbox.attr('data-start-value'),
			changeable: starbox.hasClass('unchangeable') ? false : starbox.hasClass('clickonce') ? 'once' : true,
			ghosting: starbox.hasClass('ghosting'),
			autoUpdateAverage: starbox.hasClass('autoupdate'),
			buttons: starbox.hasClass('smooth') ? false : starbox.attr('data-button-count') || 5,
			stars: starbox.attr('data-star-count') || 5
			}).bind('starbox-value-changed', function(event, value) {
			if(starbox.hasClass('random')) {
			var val = Math.random();
			starbox.next().text(' '+val);
			return val;
			} 
		})
	});
});
$(document).ready(function() {
	$('.popup-with-zoom-anim').magnificPopup({
	type: 'inline',
	fixedContentPos: false,
	fixedBgPos: true,
	overflowY: 'auto',
	closeBtnInside: true,
	preloader: false,
	midClick: true,
	removalDelay: 300,
	mainClass: 'my-mfp-zoom-in'
	});
																				
	});
	
$(document).ready(function(c) {
	$('.close1').on('click', function(c){
		$('.cart-header').fadeOut('slow', function(c){
			$('.cart-header').remove();
		});
		});	  
	});

$(document).ready(function(c) {
	$('.close2').on('click', function(c){
		$('.cart-header1').fadeOut('slow', function(c){
			$('.cart-header1').remove();
		});
		});	  
	});

$(document).ready(function(c) {
	$('.close3').on('click', function(c){
		$('.cart-header2').fadeOut('slow', function(c){
			$('.cart-header2').remove();
		});
		});	  
	});

	
	
$(function() {
	$('a.picture').Chocolat();
});