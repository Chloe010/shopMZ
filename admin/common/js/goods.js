$(document).ready(function(){	
	   $('#goods').datagrid({
		url:'index.php?a=admin&c=admin&m=goods_data',
		columns:[[
			{field:'id',title:'自身ID'},
			{field:'cid',title:'分类ID'},
			{field:'cname',title:'分类名称'},
			{field:'description',title:'简单介绍'},
			{field:'name',title:'商品名称'},
			{field:'original_price',title:'原始价格'},
			{field:'present_price',title:'现在价格'},
			{field:'size',title:'大小尺码'},
			{field:'colour',title:'商品颜色'},
			{field:'model',title:'商品型号'},
			{field:'pic_path',title:'展位图路径'},
			{field:'mygood_picture',title:'列表图路径'},
			{field:'date',title:'创建日期'},
		]]
	});
	$('#new').click(function(){
		$('#new_dialog').dialog('open');
	});
	$('#new_confirm').click(function(){
		var cid = $(" input[ name='new_cid' ] ").val();
		var cname = $(" input[ name='new_cname' ] ").val();
		var description = $(" input[ name='new_description' ] ").val();
		var name = $(" input[ name='new_name' ] ").val();
		var original_price = $(" input[ name='new_original_price' ] ").val();
		var present_price = $(" input[ name='new_present_price' ] ").val();
		var size = $(" input[ name='new_size' ] ").val();
		var colour = $(" input[ name='new_colour' ] ").val();
		var model = $(" input[ name='new_model' ] ").val();
		var pic_path = $(" input[ name='new_pic_path' ] ").val();
		var mygood_picture = $(" input[ name='new_mygood_picture' ] ").val();
        $.ajax({		
			type : 'POST',
			data :  {	
						cid:cid,
						cname:cname,
						description:description,
						name:name,
						original_price:original_price,
						present_price:present_price,
						size:size,
						colour:colour,
						model:model,
						pic_path:pic_path,
						mygood_picture:mygood_picture
					},
			url : 'index.php?a=admin&c=admin&m=new_goods',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'分类不存在'});
							}					
							else if (data == 2)
							{
							 $.messager.show({msg:'价格不能为空'});
							}
							else if (data == 3)
							{
							 $.messager.show({msg:'商品参数不能为空'});
							}
							else if (data == 4)
							{
							 $('#new_dialog').dialog('close');
							 $.messager.show({msg:'商品添加成功'});	
							$('#goods').datagrid('load');						 
							}							
							else
							{
							  $.messager.show({msg:'发生了错误'});
							}
						 
										
					}
		});	
	});
	$('#new_cancel').click(function(){
		$('#new_dialog').dialog('close');
	});
	
	$('#edit').click(function(){		
		var row = $('#goods').datagrid('getSelected');
		if(row)
		{
			$('#edit_dialog').dialog('open');
		}
		else
		{
			$.messager.show({msg:'请选择要修改的行'});
		}
		$("#edit_cid").textbox({
			prompt:row.cid			
		});
		$("#edit_cname").textbox({
			prompt:row.cname			
		});
		$("#edit_description").textbox({
			prompt:row.description			
		});
		$("#edit_name").textbox({
			prompt:row.name			
		});
		$("#edit_original_price").textbox({
			prompt:row.original_price			
		});
		$("#edit_present_price").textbox({
			prompt:row.present_price			
		});
		$("#edit_size").textbox({
			prompt:row.size			
		});
		$("#edit_colour").textbox({
			prompt:row.colour			
		});
		$("#edit_model").textbox({
			prompt:row.model			
		});
		$("#edit_pic_path").textbox({
			prompt:row.pic_path			
		});
		$("#edit_mygood_picture").textbox({
			prompt:row.mygood_picture			
		});
	});
	$('#edit_confirm').click(function(){
		var row = $('#goods').datagrid('getSelected');
		var cid = $(" input[ name='edit_cid' ] ").val();
		var cname = $(" input[ name='edit_cname' ] ").val();
		var description = $(" input[ name='edit_description' ] ").val();
		var name = $(" input[ name='edit_name' ] ").val();
		var original_price = $(" input[ name='edit_original_price' ] ").val();
		var present_price = $(" input[ name='edit_present_price' ] ").val();
		var size = $(" input[ name='edit_size' ] ").val();
		var colour = $(" input[ name='edit_colour' ] ").val();
		var model = $(" input[ name='edit_model' ] ").val();
		var pic_path = $(" input[ name='edit_pic_path' ] ").val();
		var mygood_picture = $(" input[ name='edit_mygood_picture' ] ").val();
        $.ajax({		
			type : 'POST',
			data :  {
						id:row.id,
						cid:cid,
						cname:cname,
						description:description,
						name:name,
						original_price:original_price,
						present_price:present_price,
						size:size,
						colour:colour,
						model:model,
						pic_path:pic_path,
						mygood_picture:mygood_picture
					},
			url : 'index.php?a=admin&c=admin&m=edit_goods',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'分类不存在'});
							}					
							else if (data == 2)
							{
							 $.messager.show({msg:'价格不能为空'});
							}
							else if (data == 3)
							{
							 $.messager.show({msg:'商品参数不能为空'});
							}
							else if (data == 4)
							{
							 $('#edit_dialog').dialog('close');
							 $.messager.show({msg:'商品修改成功'});	
							$('#goods').datagrid('load');						 
							}							
							else
							{
							  $.messager.show({msg:'发生了错误'});
							}
						 
										
					}
		});	
	});
	$('#edit_cancel').click(function(){
		$('#edit_dialog').dialog('close');
	});
	$('#delete').click(function(){
		$('#delete_dialog').dialog('open');
	});

	$('#delete_confirm').click(function(){
		var row = $('#goods').datagrid('getSelected');
		if(row)
		{
			$('#delelte_dialog').dialog('open');
		}
		else
		{
			$.messager.show({msg:'请选择要删除的行'});
		}
        $.ajax({		
			type : 'POST',
			data :  {
						id:row.id,
					},
			url : 'index.php?a=admin&c=admin&m=delete_goods',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'商品删除失败'});
							}

							else if (data == 1)
							{
							 $('#delete_dialog').dialog('close');
							 $.messager.show({msg:'商品删除成功'});	
							 $('#goods').datagrid('load');						 
							}
							else if (data == 2)
							{
							 $.messager.show({msg:'商品还在上架或者库存不能删除'});						 
							}
							else if (data == 3)
							{
							 $.messager.show({msg:'商品还在订单中不能删除'});						 
							}								
							else
							{
							  $.messager.show({msg:'发生了错误'});
							}
						 
										
					}
		});
	});
	$('#delete_cancel').click(function(){
		$('#delete_dialog').dialog('close');
	});
	
	
});