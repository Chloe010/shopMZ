<?php

/**
* 默认入口
*/




require_once('./library/start.php');
alpha::$app_list[] = 'common'; //模块注册范例，必须注册common模块，因为这个模块处理默认请求
alpha::$app_list[] = 'home';  //必须给先给数组赋值再start，注意顺序
alpha::$app_list[] = 'admin';
alpha::start();

?>