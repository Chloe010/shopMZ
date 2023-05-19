$(document).ready(function(){
  $("#login").click(function(){
	    var user = $(" input[ name='name' ] ").val();
		var password = $(" input[ name='password' ] ").val();
        $.ajax({		
			type : 'POST',
			data :  {	
						user:user,
						password:password,
					},
			url : 'index.php?a=admin&c=login&m=login_check',
			success : function (data) {
				
				        if (data == 0)
							{
							  window.location.href = "index.php?a=admin&c=admin&m=index";
							}
							else if (data == 1)
							{
							 alert('用户名或者密码不对');
							}						
							else
							{
							  alert('提示发生了错误');
							}
						 
										
					}
		});	
   });
});