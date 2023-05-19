<?php


/**
* 程序启动
*/

class alpha

{
	static $app = '';
	static $control = '';
	static $method = '';
	static $config = array();
	static $app_list = array();
	
	
	static function start()
	{
		
		self::init(); //定义常量
		self::load_class();  //自动加载类
		self::register();//注册模块		
	    self::listen();  //监听请求
		self::run(); // 执行请求
	}
	
	static function init()
	{
		//本程序使用的路径，如果要修改文件夹名，则要修改这里的路径名		
		defined('START_PATH')   or define('START_PATH'  , str_replace("\\"  , '/' ,dirname(__FILE__)));//定义起始路径，所有路径都是以此路径为相对路径        
		defined('ROOT_PATH')   or define('ROOT_PATH'  , str_replace("library" , '' , START_PATH)); //根目录
		defined('WEB_PATH')  or define('WEB_PATH'  , str_replace($_SERVER['DOCUMENT_ROOT'] , '' , ROOT_PATH));
		defined('CORE_CLASS_PATH')   or define('CORE_CLASS_PATH' , START_PATH . '/core/');// 定义核心类路径
		defined('EXTENDS_CLASS_PATH')   or define('EXTENDS_CLASS_PATH' , START_PATH . '/extends/') ;//定义扩展类路径，把类放于此目录
			
	}
	
	
	
	static function load_class()
	{	
	    //如果类是目录，则修改这里	
		$core_class_name = glob(CORE_CLASS_PATH . '*.php'); 
		if(is_array($core_class_name))
		{
		foreach($core_class_name as  $value)
		   {
			   require_once($value);
		   }
		}
		else
		{
			require_once($core_class_name);
		}
		
	}
	
	static function register()
	{
		$count = count(self::$app_list);
	    for($i = 0 ; $i < $count ; $i++)
		{
			$app_name = self::$app_list[$i];
			$app_path =  ROOT_PATH . $app_name. '/';
			if(!is_dir($app_path)) 
			{
				mkdir($app_path,0755,true);
			}
			else
			{
				continue;
			}
		    $app_control_path = ROOT_PATH . $app_name. '/control/' ; //控制器路径
	        $app_html_path = ROOT_PATH . $app_name. '/html/';  //生成html路径
		    $app_template_path = ROOT_PATH . $app_name. '/template/';//模版路径
			$app_config_path = ROOT_PATH . $app_name. '/config/';//配置路径，例如数据库信息
			$app_commom_path = ROOT_PATH . $app_name. '/common/'; //用于存放模版图片,js,css等
			$app_cache_path = ROOT_PATH . $app_name. '/cache/'; //用于保存日志
			if(is_writeable($app_path))
			{
				$dirs  = array(
				$app_control_path,
				$app_html_path,
				$app_template_path,
				$app_config_path,
				$app_commom_path,
				$app_cache_path
				);
				foreach ($dirs as $dir)
				{
					if(!is_dir($dir))
					{
						mkdir($dir,0755,true);
					}
				}
			}
		  if(!is_file( ROOT_PATH . $app_name. '/control/'  . $app_name . '.class.php'))
		  {
			 $file =  $app_control_path . $app_name . '.class.php';
			 $content = "<?php\n\rclass\t" . $app_name ."\textends\tcontrol\n\r{\n\rfunction\tindex()\r\n{\r\n\$this->display();\r\n}\r\n}\r\n?>";
			 file_put_contents($file,$content);
		  }
		  if(!is_file($app_template_path . 'index.html'))
		  {
			 $file = $app_template_path . 'index.html';
			 $content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
                        <body><div style="text-align:center; color:#F00;font-size:36px; margin-top:200px">alpha框架欢迎你</div></body></html>';
			 file_put_contents($file,$content);
		  }
		}					
	}
	
	static function listen()
	{
	
		self::$app = !empty($_POST['a']) ? $_POST['a'] : 'common';		
		self::$control = !empty($_POST['c']) ? $_POST['c'] : 'common';
		self::$method = !empty($_POST['m']) ? $_POST['m'] : 'index';
		self::$app = !empty($_GET['a']) ? $_GET['a'] : self::$app;
		self::$control = !empty($_GET['c']) ? $_GET['c'] : self::$control;
		self::$method = !empty($_GET['m']) ? $_GET['m'] : self::$method;
		self::$config[self::$app]['path'] =  ROOT_PATH . self::$app. '/';
		self::$config[self::$app]['control_path'] = ROOT_PATH . self::$app. '/control/' ;
	    self::$config[self::$app]['html_path'] = ROOT_PATH . self::$app. '/html/';
		self::$config[self::$app]['template_path'] = ROOT_PATH . self::$app. '/template/';
		self::$config[self::$app]['config_path'] = ROOT_PATH . self::$app. '/config/';
        self::$config[self::$app]['cache_path'] = ROOT_PATH . self::$app. '/cache/';
		self::$config[self::$app]['common_path'] = ROOT_PATH . self::$app. '/common/';	
		if(is_file(self::$config[self::$app]['config_path'] . 'config.php'))
		{
			require_once(self::$config[self::$app]['config_path'] . 'config.php');
		}
		 
		$check = new check_char(); //检查get/post输入，这个过滤类如果觉得有缺陷，可以自行替换过
				
	}
	
    static function run()
	{
		$app = self::$app;
		$control = self::$control;
		$method = self::$method;
		session_start();
		if(is_file(self::$config[self::$app]['control_path'] . $control . '.class.php') && $control !=  $method)
		{   	
		    require_once(self::$config[self::$app]['control_path'] . $control . '.class.php');      			
			if(class_exists($control) && method_exists($control , $method))
			{ 
				$run = new $control();		
		        $run->$method();

			}
			else
			{
				 self::$app  = 'common';
				 self::$control = 'common';
				 self::$method = 'index';
				 self::$config[self::$app]['template_path'] = ROOT_PATH . self::$app. '/template/';
				 require_once(ROOT_PATH . "common/control/common.class.php");
			     $run = new common();
			     $run->index();
			}
		}
		else
		{
			self::$app  = 'common';
			self::$control = 'common';
			self::$method = 'index';
			self::$config[self::$app]['template_path'] = ROOT_PATH . self::$app. '/template/';
			require_once(ROOT_PATH . "common/control/common.class.php");
			$run = new common();
			$run->index();
			
		}
									
	}
	

	
}







?>