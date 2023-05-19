<?php

class	person	extends	control

{
	
	function __construct()
	{
		if(!isset($_SESSION['uid']))
		{
             header("Location:index.php?a=home&c=login&m=index");
			 exit();
		}
		parent::__construct();

	}

	function index()
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
		
		$id = $_SESSION['uid'];
		$sql = "SELECT name,phone_number,mail,password,address  FROM user WHERE id = '$id'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$person_information = '<tr class="cart-header">
			<td>名称</td>
			<td class="item_price">'. $row['name'] .'</td>
			<td class="add-check"></td>
		  </tr>
		  <tr class="cart-header1">
			<td>电话号码</td>
			<td class="item_price">'. $row['phone_number'] .'</td>
			<td class="add-check"><p class="item_add hvr-skew-backward" id = "phone_number">修改</a></td>
		  </tr>
		  <tr class="cart-header2">
			<td>邮箱</td>
			<td class="item_price">'. $row['mail'] .'</td>
			<td class="add-check"><p class="item_add hvr-skew-backward" id = "mail">修改</a></td>
		  </tr>
		  <tr class="cart-header2">
			<td>密码</td>
			<td class="item_price">**********</td>
			<td class="add-check"><p class="item_add hvr-skew-backward" id = "password">修改</a></td>
		  </tr>
		  <tr class="cart-header2">
			<td>收货地址</td>
			<td class="item_price">'. $row['address'] .'</td>
			<td class="add-check"><p class="item_add hvr-skew-backward" id = "address">修改</a></td>
		  </tr>';
		
		$this->assign('person_information',$person_information);
		$this->display('person_information');
	}
	
	
	function exit_phone_number()
	{
		$phone_number = $_POST['phone_number'];
		if($phone_number =='')
		{
			echo 0;
			exit;
		}
		
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$id = $_SESSION['uid'];
		$sql = "UPDATE user SET phone_number='$phone_number' WHERE id='$id'";
        if($mysqli->query($sql))
		{
			echo 1;
            exit;			
		}			
		
	}
	
	function exit_mail()
	{
		$mail = $_POST['mail'];
		if($mail =='')
		{
			echo 0;
			exit;
		}
		
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$id = $_SESSION['uid'];
		$sql = "UPDATE user SET mail='$mail' WHERE id='$id'";
        if($mysqli->query($sql))
		{
			echo 1;
            exit;			
		}			
		
	}
	
	function exit_password()
	{
		$password = $_POST['password'];
		$new_password = $_POST['new_password'];
		$new_repassword = $_POST['new_repassword'];
		if($new_password == '')
		{
			echo 0;
			exit;
		}
		if($new_password != $new_repassword)
		{
			echo 1;
			exit;
		}
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$id = $_SESSION['uid'];
		$sql = "SELECT password FROM user WHERE id='$id'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$count = $result->num_rows;
		if($count)
		{
			$sql = "UPDATE user SET password='$new_password' WHERE id='$id'";
			if($mysqli->query($sql))
			{
				echo 3;
				exit;			
			}
		}
		else
		{
			echo 2;
			exit;
		}
		
	}
	
	
	function exit_address()
	{
		$address = $_POST['address'];
		if($address =='')
		{
			echo 0;
			exit;
		}
		
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$id = $_SESSION['uid'];
		$sql = "UPDATE user SET address='$address' WHERE id='$id'";
        if($mysqli->query($sql))
		{
			echo 1;
            exit;			
		}			
		
	}
	
	
	function goodlist()
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
		
		$uid = $_SESSION['uid'];
		$my_goodlist = '';
		$sql = "SELECT id,gid,gname,number,state FROM buys WHERE uid='$uid'";    
		if ($result = $mysqli->query($sql)) {
			   while ($row = $result->fetch_assoc()) {
				   $gid = $row['gid'];
				   $sqls = "SELECT description,present_price,mygood_picture FROM goods WHERE id='$gid'";
				   $results = $mysqli->query($sqls);
				   $rows = $results->fetch_assoc();
				   if($rows){
					   $my_goodlist .= '<tr class="cart-header">
						  <td class="ring-in"><a href="index.php?a=home&c=home&m=content&id='.$row['gid'] .'" class="at-in"><img src="'.$rows['mygood_picture'] .'" class="img-responsive" alt=""></a>
							<div class="sed">
								<h5><a href="index.php?a=home&c=home&m=content&id='.$row['gid'] .'">'.$row['gname'] .'</a></h5>
								<p>'.$rows['description'] .'</p>
							</div>
							<div class="clearfix"></div>
							</td>
							<td>'.$rows['present_price'] .'</td>
							<td>'.$row['number'] .'</td>
							<td>'.$row['state'] .'</td>
							<td class="add-check"><p  id="'.$row['id'] .'" class="item_add hvr-skew-backward delete">删除</p></td>
							<td class="add-check"><p  id="'.$row['id'] .'" class="item_add hvr-skew-backward pay">付款</p></td></tr>';
				   }
				}
		}
		$this->assign('my_goodlist',$my_goodlist);
		
		$this->display('person_goodlist');
	}
	
	function buy()
	{
		$id = $_POST['id'];
		$gname = $_POST['name'];
		$number = $_POST['number'];
		$uid = $_SESSION['uid'];
		$state = "未付款";
		$date = time();
		$sql = "INSERT INTO buys (uid,gid,gname,number,state,date) VALUES ('$uid','$id','$gname','$number','$state','$date')";
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");	
		if($mysqli->query($sql))
		{
			echo 0;
		}
		else
		{
			echo 1;
		}
	}
	
	function delete_mygood()
	{
		$id = $_POST['id'];
		$state = '未付款';
		$uid =$_SESSION['uid'];
		$sql = "DELETE FROM buys WHERE id = '$id' AND uid = '$uid' AND state = '$state'";
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);	
		$mysqli->set_charset("utf8");
		if($mysqli->query($sql))
		{
			if($mysqli->affected_rows)
			{
				echo 0;
			}
			else
			{
				echo 2;
			}
		}
		else
		{
			echo 1;
		}
	}
	
	function total()
	{
		$id = $_POST['id'];
		$uid = $_SESSION['uid'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$state = '未付款';
		$sql = "SELECT gid,number FROM buys WHERE id = '$id' AND uid = '$uid' AND state = '$state'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$number = $row['number'];
		$gid = $row['gid'];
		$sql = "SELECT present_price FROM goods WHERE id='$gid'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$price = (float)$row['present_price'];
		if($number == 0)
		{
			$total = '商品已付款';
			echo $total;
			exit;
		}
		$total = $number * $price;
		echo '一共'.$total;
	}
	
	function pay()
	{
		$id = $_POST['id'];
		$uid = $_SESSION['uid'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$state = '未付款';
		$sql = "SELECT gid,number FROM buys WHERE id = '$id' AND uid = '$uid' AND state = '$state'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$number = $row['number'];
		$gid = $row['gid'];
		if($gid == '')
		{
			echo 4;
			exit;
		}
		$sql = "SELECT present_price FROM goods WHERE id='$gid'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$price = (float)$row['present_price'];
		$total = $number * $price;
		
		$sql = "SELECT total FROM account WHERE uid='$uid' order by id desc LIMIT 1";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$old_total = (float)$row['total'];
		$new_total = $old_total - $total;
		if($new_total <= 0)
		{
			echo 0;
			exit;
		}
		
		$type = "消费";
		$amount = $total;
		$date = time();
		$sql = "INSERT INTO account (uid,type,amount,total,date) VALUES ('$uid','$type','$amount','$new_total','$date')";	
        if($mysqli->query($sql))
		{
			$state = '已付款';
			$sql = "UPDATE buys SET state='$state' WHERE id = '$id' AND uid = '$uid'";
			if($mysqli->query($sql))
			{
				echo 1;
				exit;
			}
			else
			{
				echo 3;
				exit;
			}
        			
		}
		else
		{
			echo 2;
			exit;
		}
					
	}
	
	function person_account()
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
		
		
		$account_list='';
        $uid = $_SESSION['uid'];
		$sql = "SELECT type,amount,total FROM account WHERE uid = '$uid'";
		if ($result = $mysqli->query($sql)) {
			   while ($row = $result->fetch_assoc()) {
				       $account_list .=' <tr class="cart-header">
						<td>'.$row['amount'].'</td>
						<td>'.$row['type'].'</td>
						<td class="item_price">'.$row['total'].'</td>
					  </tr>';
				   }   
			$result->close();
		}
		

		$this->assign('account_list',$account_list);
		
		$this->display('person_account');
	}
	
	
	function recharge()
	{
	
	}
	
}
?>