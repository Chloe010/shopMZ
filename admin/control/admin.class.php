<?php

class	admin	extends	control

{
	
	function __construct()
	{
		if(!isset($_SESSION['admin']))
		{
             header("Location:index.php?a=admin&c=login&m=index");
			 exit();
		}
		parent::__construct();

	}

	function index()
	{
	   $this->display('index');
	}
	
	
	function tabs()
	{
		$show = array('category' => '分类管理','goods'=>'商品管理','picture' =>'图片管理',
		'stock' => '库存管理','selling' =>'上架管理','buys'=>'订单管理','account' =>'账户管理','user' =>'用户管理');
		$title = $_GET['title'];
		$myshow = array_search($title,$show);
		$this->display($myshow);
	}

	//分类管理
	function category_data()
	{
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT * FROM  category";
		$data = '{"rows":[';		
		if ($result = $mysqli->query($sql)) {
			   while ($row = $result->fetch_assoc()) {
					  $date = strtotime($row["date"]);
					  $date = date("Y-m-d H:i:s",$row["date"]);
					  $data .= '{"id":"' . $row["id"] . '","fid":"' . $row["fid"] . '","name":"' . $row["name"] . '","date":"' . $date . '"},';				   
				   	} 
			 $count = $mysqli->affected_rows;
				if($count > 0)
				{
					$data  = substr($data, 0, -1);	
				}		
			$result->close();
		}
		$data .= ']}';
			
		echo $data;
	}
	
	
	function new_category()
	{
		$fid = $_POST['fid'];
		$name = $_POST['name'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT id FROM category WHERE id = '$fid'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		if($fid != 0 && empty($row))
		{
			echo 0;
			exit;
		}
		$sql = "SELECT name FROM category WHERE name = '$name'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		if($row)
		{
			echo 1;
			exit;
		}
		$date = time();
		$sql = "INSERT INTO category (fid, name, date)VALUES ('$fid','$name','$date')";
		if($mysqli->query($sql))
		{
			echo 2;
			exit;
		}
		else
		{
			echo 3;
			exit;
		}
	}
	
	function edit_category()
	{
		$id = $_POST['id'];
		$fid = $_POST['fid'];
		$name = $_POST['name'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT id FROM category WHERE id = '$fid'";
		$result = $mysqli->query($sql);
		$count = $mysqli->affected_rows;
		$row = $result->fetch_assoc();
		if($fid != 0 && empty($row))
		{
			echo 0;
			exit;
		}
		$sql = "SELECT name FROM category WHERE name = '$name'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$count = $mysqli->affected_rows;
		if($count >1)
		{
			echo 1;
			exit;
		}
		$date = time();
		$sql = "UPDATE category SET fid='$fid', name='$name' ,date = '$date' WHERE id='$id'";
		if($mysqli->query($sql))
		{
			$sql = "UPDATE goods SET cid='$id', cname='$name' ,date = '$date' WHERE cid='$id'";
			$mysqli->query($sql);
			$sql = "UPDATE selling SET cid='$id', cname='$name' ,date = '$date' WHERE cid='$id'";
			$mysqli->query($sql);
			echo 2;
			exit;
		}
		else
		{
			echo 3;
			exit;
		}
	}
	
	function delete_category()
	{
	
		$id = $_POST['id'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT id FROM goods WHERE  cid= '$id'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$count = $mysqli->affected_rows;
		if($count >0)
		{
			echo 2;
			exit;
		}
		$sql = "DELETE FROM category WHERE id='$id'";
		if($mysqli->query($sql))
		{
			echo 1;
			exit;
		}
		else
		{
			echo 0;
			exit;
		}
		
	}
	
	//商品管理
	function goods_data()
	{
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT * FROM  goods";
		$data = '{"rows":[';		
		if ($result = $mysqli->query($sql)) {
			   while ($row = $result->fetch_assoc()) {
					  $date = strtotime($row["date"]);
					  $date = date("Y-m-d H:i:s",$row["date"]);
					  $data .= '{"id":"' . $row["id"] . '","cid":"' . $row["cid"] . '","cname":"' . $row["cname"] . '",
					  "description":"' . $row["description"] . '","name":"' . $row["name"]  . '","original_price":"' . $row["original_price"]  . '",
					  "present_price":"' . $row["present_price"]  . '","size":"' . $row["size"]  . '","colour":"' . $row["colour"]  . '",
					  "model":"' . $row["model"] . '","pic_path":"' . $row["pic_path"] . '","mygood_picture":"' . $row["mygood_picture"] . '","date":"' . $date . '"},';				   
				   	} 
			$count = $mysqli->affected_rows;
				if($count > 0)
				{
					$data  = substr($data, 0, -1);	
				}		
			$result->close();
		}
		$data .= ']}';
			
		echo $data;
	}
	
	
	function new_goods()
	{
		$cid = $_POST['cid'];
		$cname = $_POST['cname'];
		$description = $_POST['description'];
		$name = $_POST['name'];
		$original_price = $_POST['original_price'];
		$present_price = $_POST['present_price'];
		$size = $_POST['size'];
		$colour = $_POST['colour'];
		$model = $_POST['model'];
		$pic_path = $_POST['pic_path'];
		$mygood_picture = $_POST['mygood_picture'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT id,name FROM category WHERE id = '$cid'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		if(empty($row))
		{
			echo 0;
			exit;
		}
		else
		{
			$cname = $row['name'];
		}
		if($original_price == ''  || $present_price == '')
		{
			echo 2;
			exit;
		}
		if($size == '' || $colour == '' || $model  == '')
		{
			echo 3;
			exit;
		}
		$date = time();
		$sql = "INSERT INTO goods (cid,cname,description,name,original_price,present_price,size,colour,model,pic_path,mygood_picture,date) VALUES ('$cid','$cname','$description','$name','$original_price','$present_price','$size','$colour','$model','$pic_path','$mygood_picture','$date')";			
		if($mysqli->query($sql))
		{
			echo 4;
			exit;
		}
		else
		{
			echo 5;
			exit;
		}
			
	}
	
	function edit_goods()
	{
		$id = $_POST['id'];
		$cid = $_POST['cid'];
		$cname = $_POST['cname'];
		$description = $_POST['description'];
		$name = $_POST['name'];
		$original_price = $_POST['original_price'];
		$present_price = $_POST['present_price'];
		$size = $_POST['size'];
		$colour = $_POST['colour'];
		$model = $_POST['model'];
		$pic_path = $_POST['pic_path'];
		$mygood_picture = $_POST['mygood_picture'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT id,name FROM category WHERE id = '$cid'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		if(empty($row))
		{
			echo 0;
			exit;
		}
		else
		{
			$cname = $row['name'];
		}
		if($original_price == ''  || $present_price == '')
		{
			echo 2;
			exit;
		}
		if($size == '' || $colour == '' || $model  == '')
		{
			echo 3;
			exit;
		}
		$date = time();
		$sql = "UPDATE goods SET cid = '$cid', cname = '$cname',description = '$description', name = '$name',original_price = '$original_price', present_price = '$present_price',
			size = '$size', colour = '$colour',model = '$model', pic_path = '$pic_path',mygood_picture = '$mygood_picture', date = '$date' WHERE id = '$id'";
		if($mysqli->query($sql))
		{
			$sql = "UPDATE selling SET cid = '$cid', cname = '$cname',date = '$date' WHERE gid = '$id'";
			if($mysqli->query($sql))
			{
				echo 4;
				exit;
			}				
			else
			{
				echo 6;
				exit;
			}
		}
		else
		{
			echo 5;
			exit;
		}
			
	}
	
	function delete_goods()
	{
		$id = $_POST['id'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT total FROM stock WHERE gid='$id' order by id desc LIMIT 1";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		if($row && $row['total'] > 0)
		{
			echo 2;
			exit;
		}
		$sql = "SELECT id FROM buys WHERE gid = '$id'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		if($row)
		{
			echo 3;
			exit;
		}
		$row = $result->fetch_assoc();
		$sql = "DELETE FROM goods WHERE id='$id'";
		if($mysqli->query($sql))
		{
			echo 1;
			exit;
		}
		else
		{
			echo 0;
			exit;
		}
		
	}

	//图片管理
	function picture_data()
	{
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT * FROM  good_picture";
		$data = '{"rows":[';		
		if ($result = $mysqli->query($sql)) {
			   while ($row = $result->fetch_assoc()) {
					  $date = strtotime($row["date"]);
					  $date = date("Y-m-d H:i:s",$row["date"]);
					  $data .= '{"id":"' . $row["id"] . '","gid":"' . $row["gid"] . '","floorplan":"' . $row["floorplan"] . '"
					  ,"big_floorplan":"' . $row["big_floorplan"] . '","mygood_picture":"' . $row["mygood_picture"] . '","detail_one":"' . $row["detail_one"] . '"
					  ,"detail_two":"' . $row["detail_two"] . '","detail_three":"' . $row["detail_three"] . '","date":"' . $date . '"},';				   
				   	} 
			 $count = $mysqli->affected_rows;
				if($count > 0)
				{
					$data  = substr($data, 0, -1);	
				}		
			$result->close();
		}
		$data .= ']}';
			
		echo $data;
	}
	
	function new_picture()
	{
		$gid = $_POST['gid'];
		$floorplan = $_POST['floorplan'];
		$big_floorplan = $_POST['big_floorplan'];
		$mygood_picture = $_POST['mygood_picture'];
		$detail_one = $_POST['detail_one'];
		$detail_two = $_POST['detail_two'];
		$detail_three = $_POST['detail_three'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT id FROM goods WHERE id = '$gid'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$rowcount = $mysqli->affected_rows;
		if($rowcount == 0)
		{
			echo 0;
			exit;
		}
		$sql = "SELECT gid FROM good_picture WHERE gid = '$gid'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$rowcount = $mysqli->affected_rows;
		if($rowcount >= 1)
		{
			echo 1;
			exit;
		}
		$date = time();
		$sql = "INSERT INTO good_picture (gid, floorplan, big_floorplan, mygood_picture ,detail_one,detail_two,detail_three,date)
				VALUES ('$gid','$floorplan','$big_floorplan','$mygood_picture','$detail_one','$detail_two','$detail_three','$date')";
		if($mysqli->query($sql))
		{
			$sql = "UPDATE goods SET pic_path= '$floorplan', mygood_picture='$mygood_picture' ,date = '$date' WHERE id='$gid'";
			if($mysqli->query($sql))
			{
				echo 2;
				exit;
			}
			else
			{
				echo 4;
				exit;
			}
		}
		else
		{
			echo 3;
			exit;
		}
		
	}
	
	function edit_picture()
	{
		$id = $_POST['id'];
		$gid = $_POST['gid'];
		$floorplan = $_POST['floorplan'];
		$big_floorplan = $_POST['big_floorplan'];
		$mygood_picture = $_POST['mygood_picture'];
		$detail_one = $_POST['detail_one'];
		$detail_two = $_POST['detail_two'];
		$detail_three = $_POST['detail_three'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT id FROM goods WHERE id = '$gid'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$rowcount = $mysqli->affected_rows;
		if($rowcount == 0)
		{
			echo 0;
			exit;
		}
		$date = time();
		$sql = "UPDATE good_picture SET gid= '$gid', floorplan='$floorplan' ,big_floorplan= '$big_floorplan',mygood_picture= '$mygood_picture',
			detail_one= '$detail_one',detail_two= '$detail_two',detail_three= '$detail_three',date = '$date' WHERE id='$id'";
		if($mysqli->query($sql))
		{
			$sql = "UPDATE goods SET pic_path= '$floorplan', mygood_picture='$mygood_picture' ,date = '$date' WHERE id='$gid'";
			if($mysqli->query($sql))
			{
				echo 2;
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
			echo 4;
			exit;
		}
	}
	function delete_picture()
	{
		$id = $_POST['id'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "DELETE FROM good_picture WHERE id='$id'";
		if($mysqli->query($sql))
		{
			echo 1;
			exit;
		}
		else
		{
			echo 0;
			exit;
		}
		
	}
	
	//库存管理
	function stock_data()
	{
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT * FROM  stock";
		if(isset($_POST['value']))
		{
			$value = $_POST['value'];
			$sql = $sql .  "  WHERE gname='$value'";
		}
		$data = '{"rows":[';		
		if ($result = $mysqli->query($sql)) {
			   while ($row = $result->fetch_assoc()) {
					  $date = strtotime($row["date"]);
					  $date = date("Y-m-d H:i:s",$row["date"]);
					  $data .= '{"id":"' . $row["id"] . '","gid":"' . $row["gid"] . '","gname":"' . $row["gname"] . '","number":"' . $row["number"] . '"
					  ,"type":"' . $row["type"] . '","total":"' . $row["total"] . '","date":"' . $date . '"},';				   
				   	}
				$count = $mysqli->affected_rows;
				if($count > 0)
				{
					$data  = substr($data, 0, -1);	
				}			 		
			$result->close();
		}
		$data .= ']}';
			
		echo $data;
	}
	
	function in_stock()
	{
		$id = $_POST['id'];
		$number  = $_POST['number'];
		$name = '';
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT name FROM goods WHERE id = '$id'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$rowcount = $mysqli->affected_rows;
		if($rowcount == 0)
		{
			echo 0;
			exit;
		}
		else
		{
			$name = $row['name'];
		}
		if($number == 0)
		{
			echo 1;
			exit;
		}
		$sql = "SELECT total FROM stock WHERE gid='$id' order by id desc LIMIT 1";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		if($row)
		{
			$total = $row['total'] + $number;
			$type = '进货';
			$date = time();
			$sql = "INSERT INTO stock (gid,gname,number,type,total,date)VALUES ('$id','$name','$number','$type','$total','$date')";
			if($mysqli->query($sql))
			{
				echo 2;
				exit;
			}
			else
			{
				echo 4;
				exit;
			}
		}
		else
		{
			$total = $number;
			$type = '进货';
			$date = time();
			$sql = "INSERT INTO stock (gid,gname,number,type,total,date)VALUES ('$id','$name','$number','$type','$total','$date')";
			if($mysqli->query($sql))
			{
				echo 2;
				exit;
			}
			else
			{
				echo 4;
				exit;
			}
		}
		
	}
	
	function out_stock()
	{
		$id = $_POST['id'];
		$number  = $_POST['number'];
		$name = '';
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT name FROM goods WHERE id = '$id'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$rowcount = $mysqli->affected_rows;
		if($rowcount == 0)
		{
			echo 0;
			exit;
		}
		else
		{
			$name = $row['name'];
		}
		if($number == 0)
		{
			echo 1;
			exit;
		}
		$sql = "SELECT total FROM stock WHERE gid='$id' order by id desc LIMIT 1";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		if($row)
		{
			$total = $row['total'] - $number;
			$type = '出货';
			if($total < 0)
			{
				echo 3;
				exit;
			}
			if($total == 0)
			{
				$sql = "DELETE FROM selling WHERE gid='$id'";
				$mysqli->query($sql);
			}
			$date = time();
			$sql = "INSERT INTO stock (gid,gname,number,type,total,date)VALUES ('$id','$name','$number','$type','$total','$date')";
			if($mysqli->query($sql))
			{
				echo 2;
				exit;
			}
			else
			{
				echo 4;
				exit;
			}
		}
		else
		{
			echo 3;
			exit;
		}
	}
	
	function delete_stock()
	{
		$id = $_POST['id'];
		$gid = $_POST['gid'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT id FROM stock WHERE gid='$gid' order by id desc LIMIT 1";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		if($row['id'] != $id)
		{
			echo 2;
			exit;
		}
		$sql = "DELETE FROM stock WHERE id='$id'";
		if($mysqli->query($sql))
		{
			echo 1;
			exit;
		}
		else
		{
			echo 0;
			exit;
		}		
	}
	
	//上架管理
	function selling_data()
	{
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT * FROM  selling";
		$data = '{"rows":[';		
		if ($result = $mysqli->query($sql)) {
			   while ($row = $result->fetch_assoc()) {
					  $date = strtotime($row["date"]);
					  $date = date("Y-m-d H:i:s",$row["date"]);
					  $data .= '{"id":"' . $row["id"] . '","cname":"' . $row["cname"] . '","gid":"' . $row["gid"] . '","gname":"' . $row["gname"] . '","date":"' . $date . '"},';				   
				   	} 
			 $count = $mysqli->affected_rows;
				if($count > 0)
				{
					$data  = substr($data, 0, -1);	
				}		
			$result->close();
		}
		$data .= ']}';
			
		echo $data;
	}
	
	
	function up_selling()
	{
		$gid = $_POST['gid'];
		$cid = '';
		$cname = '';
		$gname ='';
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");		
		$sql = "SELECT total FROM stock WHERE gid='$gid' order by id desc LIMIT 1";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		if($row)
		{
			$total = $row['total'];
			if($total <= 0)
			{
				echo 0;
				exit;
			}
			else
			{
				$sql = "SELECT id FROM selling WHERE gid='$gid'";
				$result = $mysqli->query($sql);
				$row = $result->fetch_assoc();
				if($row)
				{
					echo 3;
					exit;
				}
				$sql = "SELECT cid,cname,name FROM goods WHERE id='$gid'";
				$result = $mysqli->query($sql);
				$row = $result->fetch_assoc();
				if($row)
				{
					$cid = $row['cid'];
					$cname = $row['cname'];
					$gname = $row['name'];
				}
				else
				{
					echo 2;
					exit;
				}		
				$date = time();
				$sql = "INSERT INTO selling (cid,cname,gid,gname,date)VALUES ('$cid','$cname','$gid','$gname','$date')";
				if($mysqli->query($sql))
				{
					echo 1;
					exit;
				}
				else
				{
					echo $mysqli->error;
					exit;
				}
			}
		}
		else
		{
			echo 0;
			exit;
		}
		
	}
	
	function down_selling()
	{
		$id = $_POST['id'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "DELETE FROM selling WHERE id='$id'";
		if($mysqli->query($sql))
		{
			echo 1;
			exit;
		}
		else
		{
			echo 0;
			exit;
		}
		
	}

	//订单管理
	function buys_data()
	{
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT * FROM buys";
		if(isset($_POST['value']))
		{
			$value = $_POST['value'];
			$sql = $sql .  "  WHERE uid='$value'";
		}		
		$data = '{"rows":[';		
		if ($result = $mysqli->query($sql)) {
			   while ($row = $result->fetch_assoc()) {
					  $uid = $row['uid'];
					  $sql = "SELECT name,address FROM user WHERE id ='$uid'";
					  $results = $mysqli->query($sql);
					  $rows = $results->fetch_assoc();
					  $date = strtotime($row["date"]);
					  $date = date("Y-m-d H:i:s",$row["date"]);
					  $data .= '{"id":"' . $row["id"] . '","uid":"' . $row["uid"] . '","uname":"' . $rows["name"] . '"
					  ,"address":"' . $rows["address"] . '","gid":"' . $row["gid"] . '","gname":"' . $row["gname"] . '"
					  ,"number":"' . $row["number"] . '","state":"' . $row["state"] . '","date":"' . $date . '"},';				   
				   	} 
			 $count = $mysqli->affected_rows;
				if($count > 0)
				{
					$data  = substr($data, 0, -1);	
				}		
			$result->close();
		}
		$data .= ']}';
			
		echo $data;
	}
	
	function deliver_goods()
	{
		$id = $_POST['id'];
		$gid = $_POST['gid'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT number,state,gname FROM buys WHERE id = '$id'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		if($row['state'] != '已付款')
		{
			echo 0;
			exit;
		}
		$number = $row['number'];
		$gname = $row['gname'];
		$sql = "SELECT total FROM stock WHERE gid='$gid' order by id desc LIMIT 1";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		if($row  && $row['total'] < $number)
		{
			echo 1;
			exit;
		}
		$date = time();
		$type = '出货';
		$total = $row['total'] - $number;
		$sql = "INSERT INTO stock (gid,gname,number,type,total,date)VALUES ('$gid','$gname','$number','$type','$total','$date')";
		if($mysqli->query($sql))
		{
			$state = '已发货';
			$sql = "UPDATE buys SET  state='$state' ,date = '$date' WHERE id='$id'";
			if($mysqli->query($sql))
			{
				echo 2;
				exit;
			}
			else
			{
				echo 4;
				exit;
			}
			
		}
		else
		{
			echo 3;
			exit;
		}
		
		
	}
	
	function tuikuan()
	{
		$id = $_POST['id'];
		$gid = $_POST['gid'];
		$uid = $_POST['uid'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT number,state,gname FROM buys WHERE id = '$id'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		if($row['state'] != '已付款')
		{
			echo 0;
			exit;
		}
		$number = $row['number'];
		$sql = "SELECT present_price FROM goods WHERE id = '$gid'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$price =  $row['present_price'];
		$total = $price * $number;
		$sql = "SELECT total FROM account WHERE uid='$uid' order by id desc LIMIT 1";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$new_total = $total + $row['total'];
		$type = '退款';
		$date = time();
		$sql = "INSERT INTO account (uid,type,amount,total,date)VALUES ('$uid','$type','$total','$new_total','$date')";
		if($mysqli->query($sql))
		{
			$state = '已退款';
			$sql = "UPDATE buys SET  state='$state' ,date = '$date' WHERE id='$id'";
			if($mysqli->query($sql))
			{
				echo 2;
				exit;
			}
			else
			{
				echo 4;
				exit;
			}
		}
		else
		{
			echo $mysqli->error;
			exit;
		}
	}

	//账户管理
	function account_data()
	{
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT * FROM  account";
		if(isset($_POST['value']))
		{
			$value = $_POST['value'];
			$sql = $sql .  "  WHERE uid='$value'";
		}
		$data = '{"rows":[';		
		if ($result = $mysqli->query($sql)) {
			   while ($row = $result->fetch_assoc()) {
					  $uid = $row['uid'];
					  $sql = "SELECT name,address FROM user WHERE id ='$uid'";
					  $results = $mysqli->query($sql);
					  $rows = $results->fetch_assoc();
					  $date = strtotime($row["date"]);
					  $date = date("Y-m-d H:i:s",$row["date"]);
					  $data .= '{"id":"' . $row["id"] . '","uid":"' . $row["uid"] . '","uname":"' . $rows["name"] . '","amount":"' . $row["amount"] . '"
					  ,"type":"' . $row["type"] . '","total":"' . $row["total"] . '","date":"' . $date . '"},';				   
				   	}
				$count = $mysqli->affected_rows;
				if($count > 0)
				{
					$data  = substr($data, 0, -1);	
				}			 		
			$result->close();
		}
		$data .= ']}';
			
		echo $data;
	}
	
	
	function in_account()
	{
		$id = $_POST['id'];
		$number  = $_POST['number'];
		$name = '';
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT name FROM user WHERE id = '$id'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$rowcount = $mysqli->affected_rows;
		if($rowcount == 0)
		{
			echo 0;
			exit;
		}
		else
		{
			$name = $row['name'];
		}
		if($number == 0)
		{
			echo 1;
			exit;
		}
		$sql = "SELECT total FROM account WHERE uid='$id' order by id desc LIMIT 1";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		if($row)
		{
			$total = $row['total'] + $number;
			$type = '充值';
			$date = time();
			$sql = "INSERT INTO account (uid,amount,type,total,date)VALUES ('$id','$number','$type','$total','$date')";
			if($mysqli->query($sql))
			{
				echo 2;
				exit;
			}
			else
			{
				echo $mysqli->error;
				exit;
			}
		}
		else
		{
			$total = $number;
			$type = '充值';
			$date = time();
			$sql = "INSERT INTO account (uid,amount,type,total,date)VALUES ('$id','$number','$type','$total','$date')";
			if($mysqli->query($sql))
			{
				echo 2;
				exit;
			}
			else
			{
				echo 4;
				exit;
			}
		}
	}
	
	
	function out_account()
	{
		$id = $_POST['id'];
		$number  = $_POST['number'];
		$name = '';
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT name FROM user WHERE id = '$id'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$rowcount = $mysqli->affected_rows;
		if($rowcount == 0)
		{
			echo 0;
			exit;
		}
		else
		{
			$name = $row['name'];
		}
		if($number == 0)
		{
			echo 1;
			exit;
		}
		$sql = "SELECT total FROM account WHERE uid='$id' order by id desc LIMIT 1";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		if($row)
		{
			$total = $row['total'] - $number;
			$type = '提现';
			if($total < 0)
			{
				echo 3;
				exit;
			}
			$date = time();
			$sql = "INSERT INTO account (uid,amount,type,total,date)VALUES ('$id','$number','$type','$total','$date')";
			if($mysqli->query($sql))
			{
				echo 2;
				exit;
			}
			else
			{
				echo 4;
				exit;
			}
		}
		else
		{
			echo 3;
			exit;
		}
	}
	
	function delete_account()
	{
		$id = $_POST['id'];
		$uid = $_POST['uid'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT id FROM account WHERE uid='$uid' order by id desc LIMIT 1";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		if($row['id'] != $id)
		{
			echo 2;
			exit;
		}
		$sql = "DELETE FROM account WHERE id='$id'";
		if($mysqli->query($sql))
		{
			echo 1;
			exit;
		}
		else
		{
			echo 0;
			exit;
		}		
	}

	//用户管理
	function user_data()
	{
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT * FROM  user";
		if(isset($_POST['value']))
		{
			$value = $_POST['value'];
			$sql = $sql .  "  WHERE uid='$value'";
		}
		$data = '{"rows":[';		
		if ($result = $mysqli->query($sql)) {
			   while ($row = $result->fetch_assoc()) {
					  $date = strtotime($row["date"]);
					  $date = date("Y-m-d H:i:s",$row["date"]);
					  $data .= '{"id":"' . $row["id"] . '","name":"' . $row["name"] . '","phone_number":"' . $row["phone_number"] . '","mail":"' . $row["mail"] . '"
					  ,"address":"' . $row["address"] . '","state":"' . $row["state"] . '","date":"' . $date . '"},';				   
				   	}
				$count = $mysqli->affected_rows;
				if($count > 0)
				{
					$data  = substr($data, 0, -1);	
				}			 		
			$result->close();
		}
		$data .= ']}';
			
		echo $data;
	}
	
	function frozen_user()
	{
		$id = $_POST['id'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT name FROM user WHERE id = '$id'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		if(empty($row))
		{
			echo 0;
			exit;
		}
		$date = time();
		$state = "已冻结";
		$sql = "UPDATE user SET state='$state' ,date = '$date' WHERE id='$id'";
		if($mysqli->query($sql))
		{
			echo 1;
			exit;
		}
		else
		{
			echo 2;
			exit;
		}					
	}
	
	function unfreeze_user()
	{
		$id = $_POST['id'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT state FROM user WHERE id = '$id'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		if(empty($row))
		{
			echo 0;
			exit;
		}
		if($row['state'] != '已冻结')
		{
			echo 1;
			exit;
		}		
		$date = time();
		$state = "正常";
		$sql = "UPDATE user SET state='$state' ,date = '$date' WHERE id='$id'";
		if($mysqli->query($sql))
		{
			echo 2;
			exit;
		}
		else
		{
			echo 3;
			exit;
		}
	}
	
	function delete_user()
	{
		$id = $_POST['id'];
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT state FROM user WHERE id = '$id'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		if(empty($row))
		{
			echo 0;
			exit;
		}
		$sql = "DELETE FROM user WHERE id='$id'";
		if(!$mysqli->query($sql))
		{
			echo 1;
			exit;
		}
		$sql = "DELETE FROM account WHERE uid='$id'";
		if(!$mysqli->query($sql))
		{
			echo 2;
			exit;
		}
		$sql = "DELETE FROM buys WHERE uid='$id'";
		if(!$mysqli->query($sql))
		{
			echo 3;
			exit;
		}
		else
		{
			echo 4;
			exit;
		}
	}
	
	
}
?>