<?php

class	login extends	control

{

	function	index()
	{
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");

		$sql = "SELECT cid,cname FROM selling LIMIT 8";
		$category = array();
		$navigation_bar = '<li><a class="color" href="index.php?a=home&c=home&m=index">主页</a></li>';
		if ($result = $mysqli->query($sql)) {
			   while ($row = $result->fetch_assoc()) {
				     if (!in_array($row['cname'], $category))
					 {
				       $id = $row['cid'];
					   $sql = "SELECT id FROM category WHERE fid=0  AND id='$id'";
					   $results = $mysqli->query($sql);
					   if($rows = $results->fetch_assoc())
					   {
						  $navigation_bar  .='<li><a class="color" href="index.php?a=home&c=home&m=category&id='. $row['cid'] .'" >'. $row['cname'] .'</span></a></li>';
					   }
					   $category[] = $row['cname'];
					 }
				   }
			$result->close();
		}
		$this->assign('navigation_bar',$navigation_bar);
		$this->display('login');
	}

	//用户登录
	function  login_check()
	{
		$user =$_POST['user'];
		$password = $_POST['password'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT id,state FROM user WHERE name='$user' AND password='$password'  LIMIT 1" ;
		if ($result = $mysqli->query($sql))
		   {
            $row = $result->fetch_assoc();
			$count = $result->num_rows;
			if($count)
			{
				if($row['state'] == '已冻结')
				{
					echo 2;
					exit;
				}
				else
				{
					$_SESSION['uid'] = $row['id'];
					$_SESSION['name'] = $user;
					echo 0;
					exit();
				}
			}
			else
			{
				echo 1;
			    exit();				
			}
			$result->close();
		   }
	   else
	   {
		    echo 1;
			exit();
	   }
	}

	//用户注册
	function  register()
	{
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);		
		$mysqli->set_charset("utf8");
		
		$sql = "SELECT cid,cname FROM selling LIMIT 8";
		$category = array();
		$navigation_bar = '<li><a class="color" href="index.php?a=home&c=home&m=index">主页</a></li>';
		if ($result = $mysqli->query($sql)) {
			   while ($row = $result->fetch_assoc()) {
				     if (!in_array($row['cname'], $category))
					 {
				       $id = $row['cid'];
					   $sql = "SELECT id FROM category WHERE fid=0  AND id='$id'";
					   $results = $mysqli->query($sql);
					   if($rows = $results->fetch_assoc())
					   {
						  $navigation_bar  .='<li><a class="color" href="index.php?a=home&c=home&m=category&id='. $row['cid'] .'" >'. $row['cname'] .'</span></a></li>';
					   }
					   $category[] = $row['cname'];
					 }
				   }   
			$result->close();
		}
		$this->assign('navigation_bar',$navigation_bar);
		$this->display('register');
	}
	
	function	register_check()
	{
		$user = $_POST['user'];
		$phone_number = $_POST['phone_number'];
		$mail = $_POST['mail'];
	    $password = $_POST['password'];
		$repassword = $_POST['repassword'];
		$address = $_POST['address'];
		if($user =='')
		{
			echo 0;
			exit();
		}
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);		
		$mysqli->set_charset("utf8");
		$sql = "SELECT name FROM user WHERE name='$user'" ;
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$count = $result->num_rows;
		if($count)
		{			
			echo 1;
			exit();
		}
		if($phone_number =='')
		{
			echo 2;
			exit();
		}
		if($mail =='')
		{
			echo 3;
			exit();
		}
		if($password =='')
		{
			echo 4;
			exit();
		}
		if($password =='')
		{
			echo 4;
			exit();
		}
		if($password != $repassword)
		{
			echo 5;
			exit();
		}
		if($address =='')
		{
			echo 6;
			exit();
		}
		$date = time();
		$sql = "INSERT INTO user (id,name,password,phone_number,mail,address,date) VALUES (0,'$user','$password','$phone_number','$mail','$address','$date')";
		if($mysqli->query($sql))
		{						
		   echo 7;
		}
		else
		{
			echo 8; 
		}
		$sql = "SELECT id FROM  user WHERE name = '$user'";
		if($result = $mysqli->query($sql))
		{
			$row = $result->fetch_assoc();
			$_SESSION['uid'] = $row['id'];
			$_SESSION['name'] = $user;
		}		
				
	}
	
	function login_out()
	{
		session_destroy();
		header('location:index.php?a=home&c=login&m=index');
	}
}
?>