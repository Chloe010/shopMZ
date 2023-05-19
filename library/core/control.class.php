<?php



/**
* 模版类
*/



abstract class control
{
	
	function __construct()
	{
		$this->view = new view();		
	}
	
	/**
	* 显示模版
	*/
	public function display($filename = '')
	{
		$this->view->display($filename);
	}
	
	/**
	* 传递变量
	*/
	public function assign($key, $value = null)
	{
		$this->view->assign($key, $value);
	}


	
	/**
	* 保存为html，静态化
	*/
	public function save_to_html($filename = '' ,$path = '')
	{
		$this->view->save_to_html($filename , $path);
	}

	


	
	
	
}



?>