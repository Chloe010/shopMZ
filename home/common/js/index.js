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
$(function() {
	$('a.picture').Chocolat();
});