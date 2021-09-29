<?php

include '../global.php';

if(!isset($_SESSION[$var['session']])){
	admin::redirect($var['app_url'] . '/auth');	
}

require_once $var['core_path'] . '/controller.php'; $controller = new controller; //balikin nilai
require_once $var['core_path'] . '/route.php'; $route = new route; //balikin nilai


