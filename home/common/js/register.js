$(document).ready(function(){
  $("#register").click(function(){
	    var user = $(" input[ name='user' ] ").val();
		var phone_number = $(" input[ name='phone_number' ] ").val();
		var mail = $(" input[ name='mail' ] ").val();
		var password = $(" input[ name='password' ] ").val();
		var repassword = $(" input[ name='repassword' ] ").val();
		var address = $(" input[ name='address' ] ").val();
        $.ajax({		
			type : 'POST',
			data :  {	
						user:user,
						phone_number:phone_number,
						mail:mail,
						password:password,
						repassword:repassword,
						address:address
					},
			url : 'index.php?a=home&c=login&m=register_check',
			success : function (data) {
				
				        if (data == 0)
							{
							  alert('用户名不能为空');
							}
							else if (data == 1)
							{
							 alert('用户名已经存在');
							}
							else if (data == 2)
							{
							 alert('电话号码不能为空');
							}
							else if (data == 3)
							{
							 alert('邮箱不能为空');
							}
							else if (data == 4)
							{
							 alert('密码不能为空');
							}
							else if (data == 5)
							{
							 alert('两次输入的密码不同');
							}
							else if (data == 6)
							{
							 alert('收获地址不能为空');
							}
							else if (data == 7)
							{
							 window.location.href = "index.php?a=home&c=person&m=index";
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
 addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } 
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