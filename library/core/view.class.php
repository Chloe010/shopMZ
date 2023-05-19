<?php



/**
* 模版类
*/



class view
{
	var $source_string = '';    //保存载入模版字符
	var $default_template_path = '';   //默认模版路径
	var $tvar = array();    //保存传递给模版变量的值
	var $result_string = '';  //解析后的字符

    function __construct()
	{
	}
	
	

	/**
	* 载入模版
	*/
	public function load_template($filename = '')
	{
        if($filename == '')
		{
			$filename  = alpha::$config[alpha::$app]['template_path'] . alpha::$method .  '.html';
		}
		else
		{
			$filename  = alpha::$config[alpha::$app]['template_path'] . $filename .  '.html';
		}
		
		if(!file_exists($filename))
		{
			$this->source_string = "$filename Not Found!";
		}	
		else
		{
			$this->source_string =  file_get_contents($filename);   
		}	
		
		return $this->source_string;
	}


	
	/**
	*模版解析
	*只能匹配两个大括号
	*如果要使用其他符号
	*则需要修改函数
	*两个大括号必须成对
	*解析的模版版中javascript和css尽量写在外部文件
	*避免冲突
	*空格换行等也算字符，在标签里有这些字符就是不同的字符，请注意
	*/
	public function parse_template()
	{
		$this->result_string = isset($this->source_string) ? $this->source_string : '';
		$str = str_split($this->source_string);
		$start = new data();
		$count = count($str);
		for($i = 0 ; $i < $count ; $i++)
		{
			if($str[$i] == '{')
			{
				$key = (string)$start->key ;
				$start->save_data($key , $i);
				$start->key = $start->key + 1;
			}
		}
		$end = new data();
		$count = count($str);
		for($i = 0 ; $i < $count ; $i++)
		{
			if($str[$i] == '}')
			{
				$key = (string)$end->key;
				$end->save_data($key , $i);
				$end->key = $end->key + 1;
			}
		}
		$tag = new data();
        $count = count($start->data);
		for($i = 0 ; $i <$count ; $i++)
		{
			$str_start = $start->data[$i];
			$str_end = $end->data[$i];
			$length = $end->data[$i] - $start->data[$i];	
			$tag_full_one = "";
			for($j = 1 ;$j < $length ; $j++)
			{
				$tag_full_one .=  $str[$str_start+$j];	
			}
			$key = (string)$tag->key;
			$tag->save_data($key , $tag_full_one);
			$tag->key = $tag->key + 1 ;
		}
		$tag_full = new data();
		$count = count($start->data);
		for($i = 0 ; $i <$count ; $i++)
		{
			$str_start = $start->data[$i];
			$str_end = $end->data[$i];
			$length = $end->data[$i] - $start->data[$i];
			$tag_full_one = "";
			for($j = 0 ;$j <= $length ; $j++)
			{
				$tag_full_one .=  $str[$str_start+$j];
			}
			$key = (string)$tag_full->key;	
			$tag_full->save_data($key , $tag_full_one);
			$tag_full->key = $tag_full->key + 1 ;
		}
		$count = count($tag->data);
		for($i = 0; $i <$count; $i++)
		{
			$match_pattern_middle = "/(?:\[)(.*)(?:\])/i";
			$result_middle = array();
			$match_count = preg_match_all($match_pattern_middle , $tag->data[$i] , $result_middle);			
			if($match_count>0)
			{
				$pos = strpos($tag->data[$i], '[', 1);	
				$array_name = substr($tag->data[$i] , 0 ,$pos);	
				$array_valude = $result_middle[1][0];
				$tag->data[$i] = isset($this->tvar[$array_name][$array_valude]) ? $this->tvar[$array_name][$array_valude] : $tag->data[$i];
			    $this->result_string = $result_string = str_replace($tag_full->data[$i] ,$tag->data[$i] , $this->result_string);							
			}
			else{
			    $value = substr($tag->data[$i] , 0 ,strlen($tag->data[$i]));
			    $tag->data[$i] = isset($this->tvar[$value]) ? $this->tvar[$value] : $tag->data[$i];
				$tag->data[$i] = is_array($tag->data[$i]) ? $tag->data[$i]:  $tag->data[$i];
			    $this->result_string = str_replace($tag_full->data[$i] ,$tag->data[$i] , $this->result_string);
			}
		}
		return $this->result_string;			
	}


	
	/**
	*显示模版
	*/
	
	public function display($filename = '')
	{
		$this->load_template($filename);
		$content = $this->parse_template();
		echo($content);
	}
	
	
	/**
	*给模版传递变量
	*/
	public function assign($key, $value = null)
	{
		if ($key !=  "")
		{
			$this->tvar[$key] = $value;
		}
		return $this->tvar;	
	}


	
	/***
	*把数据流保存到html
	*转为静态网页
	*/
	public function save_to_html($filename = '' ,$path =  '')
	{
		$this->result_string = $this->load_template($filename);
		if($path == '')
		{
			$path =  alpha::$config[alpha::$app]['html_path'] . alpha::$control . '_' .alpha::$method .'.html';
		}
		else
		{
			$path =  alpha::$config[alpha::$app]['html_path'] . $filename .'.html';
		}
        if($this->result_string != '')
		{
			$contents = $this->parse_template();
		}
		else
		{
			$contents = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
                        <body><div style="text-align:center; color:#F00;font-size:36px; margin-top:200px">产生了错误</div></body></html>'; 
		}
        file_put_contents($path,$contents);
	}


}




?>