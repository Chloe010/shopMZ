$(document).ready(function(){
  $(".item_add.hvr-skew-backward.delete").click(function(){		
        $('#delete').modal('show');
		var id = this.id;
		$("#delete_confirm").click(function(){
		$.ajax({
					type : 'POST',
					url : 'index.php?a=home&c=person&m=delete_mygood',
					data :  {	
								id:id,
							},
					success : function (data) {
								if (data == 0) {									
									alert('删除成功');
									window.location.reload();
								}
								else if(data == 1)
								{
									alert('删除失败');								
								}
								else if(data == 2)
								{
									alert('不能删除已付款商品');								
								}
								else
								{
									alert('发生了错误');
								}
							},
				}); 
	});
   });
   $(".item_add.hvr-skew-backward.pay").click(function(){      	   
        $('#pay').modal('show');
		var id = this.id;
		$.ajax({
					type : 'POST',
					url : 'index.php?a=home&c=person&m=total',
					data :  {	
								id:id,
							},
					success : function (data) {
								$('#total').text(data);								
							},
				});
		$("#pay_confirm").click(function(){
			$.ajax({
						type : 'POST',
						url : 'index.php?a=home&c=person&m=pay',
						data :  {	
									id:id,
								},
						success : function (data) {
									if (data == 0) {									
										alert('你的账户余额不足，请充值');
									}
									else if(data == 1)
									{
										alert('付款成功');
										window.location.reload();
									}
									else if(data == 2)
									{
										alert('付款失败');								
									}
									else if(data == 3)
									{
										alert('修改商品状态失败');								
									}
									else if(data == 4)
									{
										alert('商品已付款');
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
 addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } 