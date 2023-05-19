<?php
class	common	extends	control
{
	function	index()
	{
	    header("Location:index.php?a=home&c=home&m=index");
		exit();	
	}
}
?>