$(document).ready(function(){
   $("#phone_number").click(function(){
        $('#call_phone_number').modal('show');	  
   });
   $("#exit_phone_number").click(function(){
	    var phone_number = $(" input[ name='phone_number' ] ").val();
        $.ajax({
					type : 'POST',
					url : 'index.php?a=home&c=person&m=exit_phone_number',
					data :  {	
								phone_number:phone_number,
							},
					success : function (data) {
								if (data == 0) {									
									alert('电话号码不能为空');
								}
								else if(data == 1)
								{
									alert('修改成功');
									window.location.reload();
								}
								else
								{
									alert('发生了错误');
								}
							},
				}); 
   });
   $("#mail").click(function(){
       $('#call_mail').modal('show');
   });
   $("#exit_mail").click(function(){
	    var mail = $(" input[ name='mail' ] ").val();
        $.ajax({
					type : 'POST',
					url : 'index.php?a=home&c=person&m=exit_mail',
					data :  {	
								mail:mail,
							},
					success : function (data) {
								if (data == 0) {									
									alert('邮箱不能为空');
								}
								else if(data == 1)
								{
									alert('修改成功');
									window.location.reload();
								}
								else
								{
									alert('发生了错误');
								}
							},
				}); 
   });
   $("#password").click(function(){
      $('#call_password').modal('show');
   });
   $("#exit_password").click(function(){
	    var password = $(" input[ name='password' ] ").val();
		var new_password = $(" input[ name='new_password' ] ").val();
		var new_repassword = $(" input[ name='new_repassword' ] ").val();
        $.ajax({
					type : 'POST',
					url : 'index.php?a=home&c=person&m=exit_password',
					data :  {
						        password:password,
         						new_password:new_password,
								new_repassword:new_repassword
							},
					success : function (data) {
								if (data == 0) {									
									alert('密码不能为空');
								}
								else if(data == 1)
								{
									alert('两次密码不同');								
								}
								else if(data == 2)
								{
									alert('旧密码输入错误');								
								}
								else if(data == 3)
								{
									alert('修改成功');
									window.location.reload();
								}
								else
								{
									alert('发生了错误');
								}
							},
				}); 
   });
   $("#address").click(function(){
      $('#call_address').modal('show');
   });
   
   $("#exit_address").click(function(){
	    var address = $(" input[ name='address' ] ").val();
        $.ajax({
					type : 'POST',
					url : 'index.php?a=home&c=person&m=exit_address',
					data :  {	
								address:address,
							},
					success : function (data) {
								if (data == 0) {									
									alert('地址不能为空');
								}
								else if(data == 1)
								{
									alert('修改成功');
									window.location.reload();
								}
								else
								{
									alert('发生了错误');
								}
							},
				}); 
   });
   
});


addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } 
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
					
					