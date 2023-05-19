$(document).ready(function(){
	 $('#selling').datagrid({
		url:'index.php?a=admin&c=admin&m=selling_data',
		columns:[[
			{field:'id',title:'自身ID',width:150},
			{field:'cname',title:'分类名称',width:150},
			{field:'gid',title:'商品ID',width:150},
			{field:'gname',title:'商品名称',width:150},
			{field:'date',title:'创建日期',width:200},			
		]]
	});
	
	$('#new').click(function(){
		$('#new_dialog').dialog('open');
	});
	$('#new_confirm').click(function(){
		var gid = $(" input[ name='new_gid' ] ").val();
        $.ajax({		
			type : 'POST',
			data :  {	
						gid:gid,
					},
			url : 'index.php?a=admin&c=admin&m=up_selling',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'库存不足不能上架'});
							}
							else if (data == 1)
							{
							 $('#new_dialog').dialog('close');
							 $.messager.show({msg:'上架成功'});	
							$('#selling').datagrid('load');						 
							}
							else if (data == 2)
							{
							 $.messager.show({msg:'商品不存在'});					 
							}
							else if (data == 3)
							{
							 $.messager.show({msg:'已经上架'});					 
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
	$('#delete').click(function(){
		$('#delete_dialog').dialog('open');
	});
	$('#delete_confirm').click(function(){
		var row = $('#selling').datagrid('getSelected');
		if(row)
		{
			$('#delelte_dialog').dialog('open');
		}
		else
		{
			$.messager.show({msg:'请选择要下架的商品'});
		}
        $.ajax({		
			type : 'POST',
			data :  {
						id:row.id,
					},
			url : 'index.php?a=admin&c=admin&m=down_selling',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'分类删除失败'});
							}

							else if (data == 1)
							{
							 $('#delete_dialog').dialog('close');
							 $.messager.show({msg:'下架成功'});	
							 $('#selling').datagrid('load');						 
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