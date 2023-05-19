$(document).ready(function(){
  $("#login").click(function(){
	    var user = $(" input[ name='user' ] ").val();
		var password = $(" input[ name='password' ] ").val();
        $.ajax({		
			type : 'POST',
			data :  {	
						user:user,
						password:password,
					},
			url : 'index.php?a=home&c=login&m=login_check',
			success : function (data) {
				
				        if (data == 0)
							{
							  window.location.href = "index.php?a=home&c=person&m=index";
							}
							else if (data == 1)
							{
							 alert('用户名或者密码不对');
							}
							else if (data == 2)
							{
							 alert('已经被冻结');
							}								
							else
							{
							  alert('提示发生了错误');
							}
						 
										
					}
		});	
   });
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
 addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } 