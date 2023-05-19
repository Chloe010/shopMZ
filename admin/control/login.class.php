<?php
class	login  extends	control
{
	function index()
	{
	  $this->display('login');
	}
	
	
	function  login_check()
	{
		$user =$_POST['user'];
		$password = $_POST['password'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT id FROM admin WHERE name='$user' AND password='$password' LIMIT 1" ;
		if ($result = $mysqli->query($sql))
		   {
            $row = $result->fetch_assoc();
			$count = $result->num_rows;
			if($count)
			{
				$_SESSION['admin'] = $user;
			    echo 0;
			    exit();
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
	
	
	function login_out()
	{
		session_destroy();
		header('location:index.php?a=admin&c=login&m=index');
	}
	
}
?>