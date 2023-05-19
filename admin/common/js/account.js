$(document).ready(function(){
	$('#search').searchbox({
			searcher:function(value,name){
				 $.ajax({		
					type : 'POST',
					data :  {	
								value:value,
							},
					url : 'index.php?a=admin&c=admin&m=account_data',
					success : function (data) {
						
								if (data)																	
									{
									  var datagrid = JSON.parse(data);
									  $('#account').datagrid('loadData', datagrid);					 
									}							
									else
									{
									  $.messager.show({msg:'发生了错误'});
									}
								 
												
							}
				});
			},
			prompt:'请输入用户ID'
		});
	 $('#account').datagrid({
		url:'index.php?a=admin&c=admin&m=account_data',
		columns:[[
			{field:'id',title:'自身ID',width:100},
			{field:'uid',title:'用户ID',width:100},
			{field:'uname',title:'用户名称',width:100},
			{field:'amount',title:'单笔金额',width:100},
			{field:'type',title:'操作类型',width:100},
			{field:'total',title:'剩余总额',width:100},	
			{field:'date',title:'修改日期',width:200},	
		]]
	});
	
	$('#new').click(function(){
		$('#new_dialog').dialog('open');
	});
	$('#new_confirm').click(function(){
		var id = $(" input[ name='new_id' ] ").val();
		var number = $(" input[ name='new_number' ] ").val();
        $.ajax({		
			type : 'POST',
			data :  {	
						id:id,
						number:number,
					},
			url : 'index.php?a=admin&c=admin&m=in_account',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'用户不存在'});
							}
							else if (data == 1)
							{
							 $.messager.show({msg:'数量不能为零'});
							}
							else if (data == 2)
							{
							 $('#new_dialog').dialog('close');
							 $.messager.show({msg:'加钱成功'});	
							$('#account').datagrid('load');						 
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
		$('#edit_dialog').dialog('open');		
	});
	$('#edit_confirm').click(function(){		
		var id = $(" input[ name='edit_id' ] ").val();
		var number = $(" input[ name='edit_number' ] ").val();
        $.ajax({		
			type : 'POST',
			data :  {
						id:id,
						number:number,
					},
			url : 'index.php?a=admin&c=admin&m=out_account',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'用户不存在'});
							}
							else if (data == 1)
							{
							 $.messager.show({msg:'数量不能为零'});
							}
							else if (data == 2)
							{
							 $('#edit_dialog').dialog('close');
							 $.messager.show({msg:'扣除了相应的钱'});	
							$('#account').datagrid('load');						 
							}
							else if (data == 3)
							{
							 $.messager.show({msg:'余额不足'});
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
		var row = $('#account').datagrid('getSelected');
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
						uid:row.uid,	
						id:row.id,
					},
			url : 'index.php?a=admin&c=admin&m=delete_account',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'删除失败'});
							}

							else if (data == 1)
							{
							 $('#delete_dialog').dialog('close');
							 $.messager.show({msg:'删除成功'});	
							 $('#account').datagrid('load');						 
							}
							else if (data == 2)
							{
							 $.messager.show({msg:'只能删除最后一行'});						 
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