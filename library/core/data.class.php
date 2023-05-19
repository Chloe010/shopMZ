<?php

/**
* 这个类用于辅助存储数据
*/


class data
{
	var $key = 0 ;
	var $data = array();
	function save_data($key , $value)
	{
		$this->data[$key]= $value;		
	}
}




?>