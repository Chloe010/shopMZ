$(document).ready(function(){
	
    $('#user').datagrid({
		url:'index.php?a=admin&c=admin&m=user_data',
		columns:[[
			{field:'id',title:'自身ID'},
			{field:'name',title:'用户名称'},
			{field:'phone_number',title:'电话号码'},
			{field:'mail',title:'电子邮箱'},
			{field:'address',title:'送货地址'},
			{field:'state',title:'冻结状态'},
			{field:'date',title:'创建日期',width:200},			
		]]
	});
	$('#new').click(function(){
		var row = $('#user').datagrid('getSelected');
		if(row)
		{
			$('#new_dialog').dialog('open');
		}
		else
		{
			$.messager.show({msg:'请选择用户'});
		}
		$('#new_name').text('用户名：' + row.name);
		
	});
	$('#new_confirm').click(function(){
		var row = $('#user').datagrid('getSelected');
		if(row)
		{
			$('#new_dialog').dialog('open');
		}
		else
		{
			$.messager.show({msg:'请选择用户'});
		}
        $.ajax({		
			type : 'POST',
			data :  {	
						id:row.id,
					},
			url : 'index.php?a=admin&c=admin&m=frozen_user',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'用户不存在'});
							}
							else if (data == 1)
							{
							 $('#new_dialog').dialog('close');
							 $.messager.show({msg:'冻结成功'});	
							$('#user').datagrid('load');						 
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
		var row = $('#user').datagrid('getSelected');
		if(row)
		{
			$('#edit_dialog').dialog('open');
		}
		else
		{
			$.messager.show({msg:'请选择用户'});
		}
		$('#edit_name').text('用户名：' + row.name);
	});
	$('#edit_confirm').click(function(){
		var row = $('#user').datagrid('getSelected');
		if(row)
		{
			$('#edit_dialog').dialog('open');
		}
		else
		{
			$.messager.show({msg:'请选择用户'});
		}
        $.ajax({		
			type : 'POST',
			data :  {
						id:row.id,
					},
			url : 'index.php?a=admin&c=admin&m=unfreeze_user',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'用户不存在'});
							}
							else if (data == 1)
							{
							 $.messager.show({msg:'用户未被冻结'});
							}
							else if (data == 2)
							{
							 $('#edit_dialog').dialog('close');
							 $.messager.show({msg:'解冻成功'});	
							$('#user').datagrid('load');						 
							}							
							else
							{
							  $.messager.show({msg:'发生了错误'});
							}
						 
										
					}
		});
	});
	$('#edit_cancel').click(function(){
		var row = $('#user').datagrid('getSelected');
		if(row)
		{
			$('#delelte_dialog').dialog('open');
		}
		else
		{
			$.messager.show({msg:'请选择要删除的行'});
		};
	});
	$('#delete').click(function(){
		$('#delete_dialog').dialog('open');
	});
	$('#delete_confirm').click(function(){
		var row = $('#user').datagrid('getSelected');
		if(row)
		{
			$('#delelte_dialog').dialog('open');
		}
		else
		{
			$.messager.show({msg:'请选择要删除的用户'});
		}
        $.ajax({		
			type : 'POST',
			data :  {
						id:row.id,
					},
			url : 'index.php?a=admin&c=admin&m=delete_user',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'用户不存在'});
							}
							else if (data == 1)
							{
							  $.messager.show({msg:'删除用户失败'});						 
							}
							else if (data == 2)
							{
							  $.messager.show({msg:'删除账户失败'});						 
							}
							else if (data == 3)
							{
							  $.messager.show({msg:'删除订单失败'});						 
							}		
							else if (data == 4)
							{
							 $('#delete_dialog').dialog('close');
							 $.messager.show({msg:'用户成功'});	
							 $('#user').datagrid('load');						 
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
