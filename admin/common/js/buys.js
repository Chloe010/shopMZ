$(document).ready(function(){
   $('#search').searchbox({
			searcher:function(value,name){
				 $.ajax({		
					type : 'POST',
					data :  {	
								value:value,
							},
					url : 'index.php?a=admin&c=admin&m=buys_data',
					success : function (data) {
						
								if (data)																	
									{
									  var datagrid = JSON.parse(data);
									  $('#buys').datagrid('loadData', datagrid);					 
									}							
									else
									{
									  $.messager.show({msg:'发生了错误'});
									}
								 
												
							}
				});
			},
			prompt:'请输入用户名称'
		});
	$('#buys').datagrid({
		url:'index.php?a=admin&c=admin&m=buys_data',
		columns:[[
			{field:'id',title:'自身ID'},
			{field:'uid',title:'用户ID'},
			{field:'uname',title:'用户名称',width:100},
			{field:'address',title:'用户地址',width:100},
			{field:'gid',title:'商品ID'},
			{field:'gname',title:'商品名称'},
			{field:'number',title:'商品数量'},
			{field:'state',title:'商品名称',width:100},
			{field:'date',title:'创建日期',width:200},			
		]]
	});
	$('#edit').click(function(){		
		var row = $('#buys').datagrid('getSelected');
		if(row)
		{
			$('#edit_dialog').dialog('open');
		}
		else
		{
			$.messager.show({msg:'请选择要发货的商品'});
		}
		$("#name").text('用户： ' + row.uname);
		$("#address").text('地址： ' + row.address);
		$("#number").text('数量： ' + row.number);	
	});
	$('#edit_confirm').click(function(){
		var row = $('#buys').datagrid('getSelected');
		if(row)
		{
			$('#edit_dialog').dialog('open');
		}
		else
		{
			$.messager.show({msg:'请选择要修改的行'});
		}
        $.ajax({		
			type : 'POST',
			data :  {
						id:row.id,
						gid:row.gid,
						gname:row.gname
					},
			url : 'index.php?a=admin&c=admin&m=deliver_goods',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'商品只有已付款才能发货'});
							}
							else if (data == 1)
							{
							 $.messager.show({msg:'库存不足'});
							}
							else if (data == 2)
							{
							 $('#edit_dialog').dialog('close');
							 $.messager.show({msg:'发货成功'});	
							$('#buys').datagrid('load');						 
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
		var row = $('#buys').datagrid('getSelected');
		if(row)
		{
			$('#delelte_dialog').dialog('open');
		}
		else
		{
			$.messager.show({msg:'请选择要删除的行'});
		}
		$("#tuikuan").text('退款商品： ' + row.gname);
		$('#delete_dialog').dialog('open');
	});
	$('#delete_confirm').click(function(){
		var row = $('#buys').datagrid('getSelected');
		if(row)
		{
			$('#delelte_dialog').dialog('open');
		}
		else
		{
			$.messager.show({msg:'请选择要退款商品'});
		}
        $.ajax({		
			type : 'POST',
			data :  {
						id:row.id,
						uid:row.uid,
						gid:row.gid,
						gname:row.gname
					},
			url : 'index.php?a=admin&c=admin&m=tuikuan',
			success : function (data) {
				
				        if (data == 0)
							{
							 $.messager.show({msg:'只有已付款才能退款'});
							}

							else if (data == 2)
							{
							 $('#delete_dialog').dialog('close');
							 $.messager.show({msg:'退款成功'});	
							 $('#buys').datagrid('load');						 
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