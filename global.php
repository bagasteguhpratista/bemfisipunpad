<?php 

//***** SET INIT PHP *****//
//header("Cache-Control: no-cache, must-revalidate");
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
error_reporting(E_ALL);
ini_set('allow_url_fopen', 1);
ini_set("display_errors",1);
ini_set('memory_limit', '-1');
date_default_timezone_set('Asia/Jakarta');
// HTTP
// define('HTTP_SERVER','http://domain.com/');
// HTTPS
// define('HTTPS_SERVER','http://bemfisipunpad.com/');

ob_start();
if(!session_id())session_start();

//***** SET DEFAULT *****//
$_to = "001";
$now = date('Y-m-d H:i:s');

//***** SET LIBRARY SYSTEM *****//
include 'library/config.php';
include 'library/path.php';
include 'library/table.php';
include 'library/db.php';
include 'library/admin.php';
//set library include
db::connect();
admin::get_library('view','privilege','file','split','flasher','valid');
include $var['core_path'] . '/route.php';
admin::_global();

//***** SET ROUTE CMS *****//
$GLOBALS['title'] = route::title();
$url = (!isset($_GET)) ? 'dashboard' : '';
$url_2 = $url;

$method_ = route::method();
$method_ = (isset($method_)) ? '/' . route::method() : '';
$GLOBALS['link_'] = $var['app_url'] . '/' . $title;
// $route = new Route;
// $contoroller = new Controller;
