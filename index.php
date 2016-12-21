<?php
require 'common.php';
spl_autoload_register('autoload');
date_default_timezone_set('PRC');
header('Content-type','text/html;charset=UTF-8');
//$app = \Lib\App::getInstance();
$action = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : 'Index';
$method = isset($_REQUEST['method']) ? trim($_REQUEST['method']) : 'index';
$args = array_diff_assoc($_REQUEST,['action' => $action,'method' => $method]);
$actionname = '\Action\\'.ucfirst(str_replace('\\','/',$action)).'Action';
call_user_func_array([(new $actionname),$method],[$args]);



//test
//echo 'asfdjldasf';

