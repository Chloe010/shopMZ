$(document).ready(function(){
   
    $('#category').datagrid({
		url:'index.php?a=admin&c=admin&m=category_data',
		columns:[[
			{field:'id',title:'自身ID',width:200},
			{field:'fid',title:'父级ID',width:200},
			{field:'name',title:'分类名称',width:200},
			{field:'date',title:'创建日期',width:200},			
		]]
	});
	$('#new').click(function(){
		$('#new_dialog').dialog('open');
	});
	$('#new_confirm').click(function(){
		var fid = $(" input[ name='new_fid' ] ").val();
		var name = $(" input[ name='new_name' ] ").val();
        $.ajax({		
			type : 'POST',
			data :  {	
						fid:fid,
						name:name,
					},
			url : 'index.php?a=admin&c=admin&m=new_category',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'父级ID不存在'});
							}
							else if (data == 1)
							{
							 $.messager.show({msg:'分类名已存在'});
							}
							else if (data == 2)
							{
							 $('#new_dialog').dialog('close');
							 $.messager.show({msg:'分类添加成功'});	
							$('#category').datagrid('load');						 
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
		var row = $('#category').datagrid('getSelected');
		if(row)
		{
			$('#edit_dialog').dialog('open');
		}
		else
		{
			$.messager.show({msg:'请选择要修改的行'});
		}
		$("#edit_fid").textbox({
			prompt:row.fid			
		});
		$("#edit_name").textbox({
			prompt:row.name			
		});
	});
	$('#edit_confirm').click(function(){
		var row = $('#category').datagrid('getSelected');
		if(row)
		{
			$('#edit_dialog').dialog('open');
		}
		else
		{
			$.messager.show({msg:'请选择要修改的行'});
		}
		var fid = $(" input[ name='edit_fid' ] ").val();
		var name = $(" input[ name='edit_name' ] ").val();
        $.ajax({		
			type : 'POST',
			data :  {
						id:row.id,
						fid:fid,
						name:name,
					},
			url : 'index.php?a=admin&c=admin&m=edit_category',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'父级ID不存在'});
							}
							else if (data == 1)
							{
							 $.messager.show({msg:'分类名已存在'});
							}
							else if (data == 2)
							{
							 $('#edit_dialog').dialog('close');
							 $.messager.show({msg:'分类修改成功'});	
							$('#category').datagrid('load');						 
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
		var row = $('#category').datagrid('getSelected');
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
			url : 'index.php?a=admin&c=admin&m=delete_category',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'要已付款商品才能退款'});
							}

							else if (data == 1)
							{
							 $('#delete_dialog').dialog('close');
							 $.messager.show({msg:'分类删除成功'});	
							 $('#category').datagrid('load');						 
							}
							else if (data == 2)
							{
							  $.messager.show({msg:'分类下还有商品不能删除'});						 
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
