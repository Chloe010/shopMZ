$(document).ready(function(){
	$('#search').searchbox({
			searcher:function(value,name){
				 $.ajax({		
					type : 'POST',
					data :  {	
								value:value,
							},
					url : 'index.php?a=admin&c=admin&m=stock_data',
					success : function (data) {
						
								if (data)																	
									{
									  var datagrid = JSON.parse(data);
									  $('#stock').datagrid('loadData', datagrid);					 
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
	 $('#stock').datagrid({
		url:'index.php?a=admin&c=admin&m=stock_data',
		columns:[[
			{field:'id',title:'自身ID',width:100},
			{field:'gid',title:'商品ID',width:100},
			{field:'gname',title:'商品名称',width:100},
			{field:'number',title:'单次数量',width:100},
			{field:'type',title:'操作类型',width:100},
			{field:'total',title:'剩余总数',width:100},	
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
			url : 'index.php?a=admin&c=admin&m=in_stock',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'商品不存在，先去商品管理添加'});
							}
							else if (data == 1)
							{
							 $.messager.show({msg:'数量不能为零'});
							}
							else if (data == 2)
							{
							 $('#new_dialog').dialog('close');
							 $.messager.show({msg:'库存添加成功'});	
							$('#stock').datagrid('load');						 
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
			url : 'index.php?a=admin&c=admin&m=out_stock',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'商品不存在，请到商品列表添加'});
							}
							else if (data == 1)
							{
							 $.messager.show({msg:'数量不能为零'});
							}
							else if (data == 2)
							{
							 $('#edit_dialog').dialog('close');
							 $.messager.show({msg:'已经出货'});	
							$('#stock').datagrid('load');						 
							}
							else if (data == 3)
							{
							 $.messager.show({msg:'库存不足'});
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
		var row = $('#stock').datagrid('getSelected');
		if(row)
		{
			$('#delelte_dialog').dialog('open');
		}
		else
		{
			$.messager.show({msg:'请选择要删除的商品库存'});
		}
        $.ajax({		
			type : 'POST',
			data :  {
						gid:row.gid,	
						id:row.id,
					},
			url : 'index.php?a=admin&c=admin&m=delete_stock',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'删除失败'});
							}

							else if (data == 1)
							{
							 $('#delete_dialog').dialog('close');
							 $.messager.show({msg:'删除成功'});	
							 $('#stock').datagrid('load');						 
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