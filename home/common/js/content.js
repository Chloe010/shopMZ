$(document).ready(function(){
  $("#buy").click(function(){
		var id = $(".good_name").attr("id");
	    var name = $(".good_name").text();
		var number = $(".entry.value").text();
        $.ajax({		
			type : 'POST',
			data :  {	
						id:id,
						name:name,
						number:number						
					},
			url : 'index.php?a=home&c=person&m=buy',
			success : function (data) {
				
				        if (data == 0)
							{
							  alert('已加入购物车，稍后请去付款');
							}
							else if (data == 1)
							{
							 alert('发生了错误');
							}						
							else
							{
							  alert('请先登录');
							}
						 
										
					}
		});	
   });
});


$(window).load(function() {
  $('.flexslider').flexslider({
    animation: "slide",
    controlNav: "thumbnails"
  });
});


$('.value-plus').on('click', function(){
	var divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.text(), 10)+1;
	divUpd.text(newVal);
});

$('.value-minus').on('click', function(){
	var divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.text(), 10)-1;
	if(newVal>=1) divUpd.text(newVal);
});
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
			var menu_ul = $('.menu-drop > li > ul'),
				   menu_a  = $('.menu-drop > li > a');
			menu_ul.hide();
			menu_a.click(function(e) {
				e.preventDefault();
				if(!$(this).hasClass('active')) {
					menu_a.removeClass('active');
					menu_ul.filter(':visible').slideUp('normal');
					$(this).addClass('active').next().stop(true,true).slideDown('normal');
				} else {
					$(this).removeClass('active');
					$(this).next().stop(true,true).slideUp('normal');
				}
			});
		
		});