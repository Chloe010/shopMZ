<?php

class	home  extends	control
{

   function index()
	{
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT cid,cname FROM selling LIMIT 8";
		$category = array();
		$navigation_bar = '<li><a class="color" href="index.php?a=home&c=home&m=index">主页</a></li>';
		//导航栏
		if ($result = $mysqli->query($sql)) {
			   while ($row = $result->fetch_assoc()) {
				   //解决导航栏标签重复问题
				     if (!in_array($row['cname'], $category))
					 {	
					   $id = $row['cid'];
					   $sql = "SELECT id FROM category WHERE fid=0  AND id='$id'";
					   $results = $mysqli->query($sql);
						 //使用一个占位符做标签，然后assgin（占位符，数据），这样我们就把在卖的分类做成了导航栏
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

		//主页爆款商品
		/*
		 * 一个格子的标签，不同的地方
			1，两个图片链接
			2，商品链接
			3，分类
			4，商品名称
			5，原价
			6，价格

		mysql存字符串还更好，因为这个字符串不管你小数点，用的时候再注意类型转换就行
		 */
		$sql = "SELECT gid FROM selling LIMIT 20";
		$goods_list = '<div class="mid-popular">';
		$i = 1;
		if ($result = $mysqli->query($sql)) {
			   while ($row = $result->fetch_assoc()) {
				      $id = $row['gid'];
				      $sql = "SELECT pic_path,cname,name,original_price,present_price FROM goods WHERE id='$id'";
					  $results = $mysqli->query($sql);
					  $rows = $results->fetch_assoc();
					  if(isset($rows))
					  {
						  $goods_list .= '<div class="col-md-3 item-grid simpleCart_shelfItem"><div class=" mid-pop"><div class="pro-img"><img src="'. $rows['pic_path'] .'" class="img-responsive" alt="">';
						  $goods_list .= '<div class="zoom-icon "><a class="picture" href="'. $rows['pic_path'] .'" rel="title" class="b-link-stripe b-animate-go  thickbox"><i class="glyphicon glyphicon-search icon "></i></a>';
						  $goods_list .= '<a href="index.php?a=home&c=home&m=content&id='. $id .'"><i class="glyphicon glyphicon-menu-right icon"></i></a>';
						  $goods_list .= '</div></div><div class="mid-1"><div class="women"><div class="women-top"><span>' . $rows['cname'] .'</span>';
						  $goods_list .= '<h6><a href="index.php?a=home&c=home&m=content&id='. $id .'">' . $rows['name'] .'</a></h6>';
						  $goods_list .= '</div><div class="img item_add"><a href="#"><img src="home/common/images/ca.png" alt=""></a>';
						  $goods_list .= '</div><div class="clearfix"></div></div><div class="mid-2"><p ><label>' . $rows['original_price'] .'</label><em class="item_price">' . $rows['present_price'] .'</em></p>';
						  $goods_list .= '<div class="block"><div class="starbox small ghosting"> </div></div><div class="clearfix"></div>';
						  $goods_list .= '</div></div></div></div>';
						  if($i % 4 == 0)
							  {
								  $goods_list .= '<div class="clearfix"></div></div><div class="mid-popular">';
							  }
						  $i = $i + 1;
					  }
					 }  
			$goods_list .= '<div class="clearfix"></div></div>';		 
			$result->close();
		}
		
		$this->assign('goods_list',$goods_list);
		$this->display("index");
	}
	
	//导航栏下的单页商品
	/**
	 * 导航栏的链接，是标签里形成，
	 * 提嫁给了一个category方法，并且有个id来识别自己，
	 * 那么我们要显示他，就先做个函数category
	 * 首先是导航栏，跟主页是一样的，
	 * 其次是列表内容，也跟主页差不多，这里只有四个个而已，
	 * 其次是侧边的分类栏，这个要做，而且这个跟导航栏不同，他是有层级的，
	 * 最后是三个筛选，这个不用做标签，但是需要弄一些js
	 */
	function category()
	{
		$mysqli = new mysqli(alpha::$config['host'], alpha::$config['user'] ,alpha::$config['password'], alpha::$config['dbname']);
		$mysqli->set_charset("utf8");
		$sql = "SELECT cid,cname FROM selling LIMIT 8";
		$category = array();
		$navigation_bar = '<li><a class="color" href="index.php?a=home&c=home&m=index">主页</a></li>';
		//导航栏的链接
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
		
		$id = $_GET['id'];
		
		$sql = "SELECT name FROM category WHERE id='$id'";
		$resultn = $mysqli->query($sql);
		$rown = $resultn->fetch_assoc();
		$this->assign('name',$rown['name']);
		
		//列表
		$goods_list = '<div class="mid-popular">';
		$sql = "SELECT id FROM category  WHERE  fid='$id'";
		if ($resultp = $mysqli->query($sql)) {
			   while ($rowp = $resultp->fetch_assoc()) {
				   $idid = $rowp['id'];
				   $sql = "SELECT  cid,cname FROM selling  WHERE  cid='$idid'";
				   $resultps = $mysqli->query($sql);
				   if($rowps = $resultps->fetch_assoc())
				   {
					  $goods_list .= '<div class="col-md-4 item-grid1 simpleCart_shelfItem"><div class=" mid-pop"><div class="pro-img">
						<img src="home/common/images/pc1.jpg" class="img-responsive" alt=""><div class="zoom-icon ">
						<a class="picture" href="home/common/images/pc.jpg" rel="title" class="b-link-stripe b-animate-go  thickbox"><i class="glyphicon glyphicon-search icon "></i></a>
						<a href="index.php?a=home&c=home&m=category&id='. $rowps['cid'] .'"><i class="glyphicon glyphicon-menu-right icon"></i></a></div></div><div class="mid-1">
						<div class="women"><div class="women-top"><span>分类</span><h6><a href="index.php?a=home&c=home&m=category&id='. $rowps['cid'] .'">' . $rowps['cname'] .'</a></h6>
						</div><div class="img item_add"><a href="#"><img src="home/common/images/ca.png" alt=""></a>
						</div><div class="clearfix"></div></div><div class="mid-2"><p ><label></label><em class="item_price"></em></p>
						<div class="block"><div class="starbox small ghosting"> </div></div><div class="clearfix"></div></div></div></div></div>';
				   }
			   }
		}
		//列表
		$sql = "SELECT gid FROM selling WHERE cid='$id' LIMIT 24";
		if ($result = $mysqli->query($sql)) {
			   while ($row = $result->fetch_assoc()) {
						$gid = $row['gid'];
						$sql = "SELECT pic_path,cname,name,original_price,present_price FROM goods WHERE id='$gid'";
						$results = $mysqli->query($sql);
						$rows = $results->fetch_assoc();
						if(isset($rows))
						{
							$goods_list .= '<div class="col-md-4 item-grid1 simpleCart_shelfItem"><div class=" mid-pop"><div class="pro-img">
							<img src="'. $rows['pic_path'] .'" class="img-responsive" alt=""><div class="zoom-icon ">
							<a class="picture" href="'. $rows['pic_path'] .'" rel="title" class="b-link-stripe b-animate-go  thickbox"><i class="glyphicon glyphicon-search icon "></i></a>
							<a href="index.php?a=home&c=home&m=content&id='. $gid .'"><i class="glyphicon glyphicon-menu-right icon"></i></a></div></div><div class="mid-1">
							<div class="women"><div class="women-top"><span>' . $rows['cname'] .'</span><h6><a href="index.php?a=home&c=home&m=content&id='. $gid .'">' . $rows['name'] .'</a></h6>
							</div><div class="img item_add"><a href="#"><img src="home/common/images/ca.png" alt=""></a>
							</div><div class="clearfix"></div></div><div class="mid-2"><p ><label>' . $rows['original_price'] .'</label><em class="item_price">' . $rows['present_price'] .'</em></p>
							<div class="block"><div class="starbox small ghosting"> </div></div><div class="clearfix"></div></div></div></div></div>';
						}
				   } 
			$goods_list .= '<div class="clearfix"></div></div>';	   
			$result->close();
		}
		$this->assign('goods_list',$goods_list);

		//侧边的分类栏
		$sql = "SELECT cid,cname FROM selling";
		$real_category = '';
		$category = array();
		if ($result = $mysqli->query($sql)) {
			   while ($row = $result->fetch_assoc()) {
				     if (!in_array($row['cname'], $category))
						 {
						   $id = $row['cid'];
						   $sql = "SELECT id FROM category WHERE fid=0  AND id='$id'";
						   $results = $mysqli->query($sql);
						   if($rows = $results->fetch_assoc())
						   { 
							   $real_category  .= '<li class="item1"><a href="index.php?a=home&c=home&m=category&id='. $row['cid'] .'">'. $row['cname'] .'</a></li>';
							   $real_category  .= '<ul class="cute">';
							   $sql = "SELECT id FROM category  WHERE  fid='$id'";
							   if ($resultss = $mysqli->query($sql)){
								   while($rowss = $resultss->fetch_assoc())
									   {
										   $id = $rowss['id'];
								           $sql = "SELECT  cid,cname FROM selling  WHERE  cid='$id'";
										   $resultsss = $mysqli->query($sql);
										   if($rowsss = $resultsss->fetch_assoc())
										   {
										      $real_category  .= '<li class="subitem1"><a href="index.php?a=home&c=home&m=category&id='. $rowsss['cid'] .'">'. $rowsss['cname'] .'</a></li>';
										   } 
									   }
							   }
							   $real_category  .= '</ul>';
						   }
						   $category[] = $row['cname'];
						 }
				   }   
			$result->close();
		}
		$this->assign('real_category',$real_category);
				
		$this->display("category");
	}
	
	//内容页标签
	/**
	 * 跟列表页一样，在做标签的时候，把链接已经指向了一个方法content，
	 * 并且传了一个属于那个商品的ID
	 * 那么显示内容页模版的方法则是content，
	 * 我们把模版复制到template，改名，并且修改一些css和js路径，其他没问题，
	 * 但是图片显示不对，这个是个js插件，flexslider
	 * 错的问题是：我们使用这个模版引擎，会不知道哪里输出个符号，导致所有在html文档内的js都会错
	 * 解决的方法是，把所有js都移到html文档外，这样他就不会报错
	 */
	function content()
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
		
		
		$sql = "SELECT cid,cname FROM selling";
		$real_category = '';
		$category = array();
		if ($result = $mysqli->query($sql)) {
			   while ($row = $result->fetch_assoc()) {
				     if (!in_array($row['cname'], $category))
						 {
						   $id = $row['cid'];
						   $sql = "SELECT id FROM category WHERE fid=0  AND id='$id'";
						   $results = $mysqli->query($sql);
						   if($rows = $results->fetch_assoc())
						   { 
							   $real_category  .= '<li class="item1"><a href="index.php?a=home&c=home&m=category&id='. $row['cid'] .'">'. $row['cname'] .'</a></li>';
							   $real_category  .= '<ul class="cute">';
							   $sql = "SELECT id FROM category  WHERE  fid='$id'";
							   if ($resultss = $mysqli->query($sql)){
								   while($rowss = $resultss->fetch_assoc())
									   {
										   $id = $rowss['id'];
								           $sql = "SELECT  cid,cname FROM selling  WHERE  cid='$id'";
										   $resultsss = $mysqli->query($sql);
										   if($rowsss = $resultsss->fetch_assoc())
										   {
										      $real_category  .= '<li class="subitem1"><a href="index.php?a=home&c=home&m=category&id='. $rowsss['cid'] .'">'. $rowsss['cname'] .'</a></li>';
										   } 
									   }
							   }
							   $real_category  .= '</ul>';
						   }
						   $category[] = $row['cname'];
						 }
				   }   
			$result->close();
		}
		$this->assign('real_category',$real_category);
		

		//图片显示处理
		$goods_picture = '<li data-thumb="home/common/images/si.jpg">
			        <div class="thumb-image"> <img src="home/common/images/si.jpg" data-imagezoom="true" class="img-responsive"> </div>
			    </li>';
		$id = $_GET['id'];
		$sql = "SELECT detail_one,detail_two,detail_three FROM good_picture WHERE gid='$id'";
		if ($result = $mysqli->query($sql)) {
			while ($row = $result->fetch_assoc()) {
				$goods_picture = '<li data-thumb="'. $row['detail_one']  .'">
								<div class="thumb-image"> <img src="'. $row['detail_one']  .'" data-imagezoom="true" class="img-responsive"> </div>
								</li>
								<li data-thumb="'. $row['detail_three']  .'">
									<div class="thumb-image"> <img src="'. $row['detail_two']  .'" data-imagezoom="true" class="img-responsive"> </div>
								</li>
								<li data-thumb="'. $row['detail_two']  .'">
									<div class="thumb-image"> <img src="'. $row['detail_three']  .'" data-imagezoom="true" class="img-responsive"> </div>
								</li>';
				
			}
			$result->close();
		}
		
		$this->assign('goods_picture',$goods_picture);
		
		$sql = "SELECT name,description,present_price,size,colour,model FROM goods  WHERE id='$id'";
		$result = $mysqli->query($sql);
		$row = $result->fetch_assoc();
		$goods_information = '<h3 class="good_name" id="'. $id .'">'. $row['name'] .'</h3>
				<p class="in-para"> '. $row['description'] .'</p>
			    <div class="price_single">
				  <span class="reducedfrom item_price">'. $row['present_price'] .'</span>
				 <div class="clearfix"></div>
				</div>
				<div class="price_single">
				  <span class="reducedfrom item_price">适合肤质：'. $row['size'] .'</span>
				 <div class="clearfix"></div>
				</div>
				<div class="price_single">
				  <span class="reducedfrom item_price">保质期：'. $row['colour'] .'</span>
				 <div class="clearfix"></div>
				</div>
				<div class="price_single">
				  <span class="reducedfrom item_price">商品质地：'. $row['model'] .'</span>
				 <div class="clearfix"></div>
				</div>';
		$this->assign('goods_information',$goods_information);				
		
		$this->display("content");
	}
	
	
	
	
}
?>