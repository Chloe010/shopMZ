$(document).ready(function(){
   $('#picture').datagrid({
		url:'index.php?a=admin&c=admin&m=picture_data',
		columns:[[
			{field:'id',title:'自身ID'},
			{field:'gid',title:'商品ID'},
			{field:'floorplan',title:'展位图'},
			{field:'big_floorplan',title:'大展位图'},	
			{field:'mygood_picture',title:'购物列表图'},
			{field:'detail_one',title:'第一详情图'},
			{field:'detail_two',title:'第二详情图'},
			{field:'detail_three',title:'第三详情图'},
			{field:'date',title:'修改日期'}			
		]]
	});
	
	$('#new').click(function(){
		$('#new_dialog').dialog('open');
	});
	$('#new_confirm').click(function(){
		var gid = $(" input[ name='new_gid' ] ").val();
		var floorplan = $(" input[ name='new_floorplan' ] ").val();
		var big_floorplan = $(" input[ name='new_big_floorplan' ] ").val();
		var mygood_picture = $(" input[ name='new_mygood_picture' ] ").val();
		var detail_one = $(" input[ name='new_detail_one' ] ").val();
		var detail_two = $(" input[ name='new_detail_two' ] ").val();
		var detail_three = $(" input[ name='new_detail_three' ] ").val();
        $.ajax({		
			type : 'POST',
			data :  {	
						gid:gid,
						floorplan:floorplan,
						big_floorplan:big_floorplan,
						mygood_picture:mygood_picture,
						detail_one:detail_one,
						detail_two:detail_two,
						detail_three:detail_three,
					},
			url : 'index.php?a=admin&c=admin&m=new_picture',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'商品ID不存在'});
							}
							else if (data == 1)
							{
							 $.messager.show({msg:'商品已经有图片'});
							}
							else if (data == 2)
							{
							 $('#new_dialog').dialog('close');
							 $.messager.show({msg:'商品图片添加成功'});	
							$('#picture').datagrid('load');						 
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
		var row = $('#picture').datagrid('getSelected');
		if(row)
		{
			$('#edit_dialog').dialog('open');
		}
		else
		{
			$.messager.show({msg:'请选择要修改的行'});
		}
		$("#edit_gid").textbox({
			prompt:row.gid			
		});
		$("#edit_floorplan").textbox({
			prompt:row.floorplan			
		});
		$("#edit_big_floorplan").textbox({
			prompt:row.big_floorplan			
		});
		$("#edit_mygood_picture").textbox({
			prompt:row.mygood_picture			
		});
		$("#edit_detail_one").textbox({
			prompt:row.detail_one			
		});
		$("#edit_detail_two").textbox({
			prompt:row.detail_two			
		});
		$("#edit_detail_three").textbox({
			prompt:row.detail_three			
		});
	});
	$('#edit_confirm').click(function(){
		var row = $('#picture').datagrid('getSelected');
		if(row)
		{
			$('#edit_dialog').dialog('open');
		}
		else
		{
			$.messager.show({msg:'请选择要修改的行'});
		}
		var gid = $(" input[ name='edit_gid' ] ").val();
		var floorplan = $(" input[ name='edit_floorplan' ] ").val();
		var big_floorplan = $(" input[ name='edit_big_floorplan' ] ").val();
		var mygood_picture = $(" input[ name='edit_mygood_picture' ] ").val();
		var detail_one = $(" input[ name='edit_detail_one' ] ").val();
		var detail_two = $(" input[ name='edit_detail_two' ] ").val();
		var detail_three = $(" input[ name='edit_detail_three' ] ").val();
        $.ajax({		
			type : 'POST',
			data :  {
						id:row.id,
						gid:gid,
						floorplan:floorplan,
						big_floorplan:big_floorplan,
						mygood_picture:mygood_picture,
						detail_one:detail_one,
						detail_one:detail_one,
						detail_two:detail_two,
						detail_three:detail_three,
					},
			url : 'index.php?a=admin&c=admin&m=edit_picture',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'商品ID不存在'});
							}
							else if (data == 1)
							{
							 $.messager.show({msg:'商品已经有图片'});
							}
							else if (data == 2)
							{
							 $('#edit_dialog').dialog('close');
							 $.messager.show({msg:'修改图片成功'});	
							$('#picture').datagrid('load');						 
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
		var row = $('#picture').datagrid('getSelected');
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
			url : 'index.php?a=admin&c=admin&m=delete_picture',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'图片删除失败'});
							}

							else if (data == 1)
							{
							 $('#delete_dialog').dialog('close');
							 $.messager.show({msg:'图片删除成功'});	
							 $('#picture').datagrid('load');						 
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