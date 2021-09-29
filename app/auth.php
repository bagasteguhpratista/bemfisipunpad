<?php 
	global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
	include '../global.php';
	db::connect();
	// echo json_encode($_GET);exit;
	if(isset($_SESSION[$var['session']])){
		admin::redirect($var['app_url'] . '/dashboard');
	}
	if($_to == '001'){
		if(!isset($_SESSION['token_login'])){
			$_SESSION['token_login'] = base64_encode(openssl_random_pseudo_bytes(32));
		}
		include $var['app_path'] . '/auth/auth.html';
	}
	if($_to == '002'){
		if (isset($_SESSION['token_login']) == isset($tkn)) {	
			unset($_SESSION['token_login']);
			if(isset($p_username) AND isset($p_password)){
				$p_username = db::injection($p_username);
				$p_password = db::injection($p_password);
				$passwordhash = md5(serialize($p_password));
				$sql = "SELECT * FROM " .$var['table']['user'] ." WHERE username = '$p_username' AND password = '$passwordhash' AND status = 'active' LIMIT 1";
				db::query($sql,$rs['sql'],$nr['sql']);
				if($nr['sql'] > 0){
					$_SESSION[$var['session']] = base64_encode(serialize(db::fetch($rs['sql'])));
					header("location: " . $var['app_url'] . '/dashboard');
					exit;
				}
				else{
					$notactive = "SELECT * FROM " .$var['table']['user'] ." WHERE username = '$p_username' AND password = '$passwordhash' AND status = 'inactive' LIMIT 1";
					db::query($notactive,$rs['notactive'],$nr['notactive']);
					if($nr['notactive'] > 0)
					{
						flasher::setFlash('danger', admin::lang('login-disabled'));
					}
					else
					{
						flasher::setFlash('danger', admin::lang('login-failed'));
					}
						header("location: " . $var['app_url'] . '/auth');
						exit;
				}
			}
		}
		else{
			echo "token tidak ada";
			exit;
		}
	}

	if(isset($ret) == 'logout'){
		// session_destroy();
		unset($_SESSION[$var['session']]);
		flasher::setFlash('success', admin::lang('logout-succesfully'));
		header('location: ' . $var['app_url'] . '/auth');
		// session_destroy();
		exit;
	}