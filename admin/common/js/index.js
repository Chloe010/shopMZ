$(document).ready(function(){
   $('#dg').datagrid();   
   $("#dg").datagrid({  
        onClickRow: function (index, row) { 		  		   
		   var title = row.name;
		   var url = 'index.php?a=admin&c=admin&m=tabs&title=' + title;
		    if ($("#tabs").tabs('exists', title))
				{
				  $('#tabs').tabs('select', title);			
				 } 
			 else 
			 {
				  $('#tabs').tabs('add',{
				   title:row.name,
				   closable:true,
				   content: '<iframe scrolling="no" frameborder="0"  src="'+url+'" style="width:100%;height:100%;"></iframe>',
				   cache:true 
				  });
			 }
                 
        }  
     }); 
   
});
