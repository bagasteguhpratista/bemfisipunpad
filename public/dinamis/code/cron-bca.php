<?php
include '../../../global.php';
	global $var;foreach($GLOBALS as $k=> $v) $$k=$v; //harus ada di fungsi apapun
	//tanggal hari ini
	$date = date('Y-m-d');
	$tgl = date('Y-m-d 23:59:00');
	$tgl1 = date('Y-m-d 00:00:01', strtotime('-1 day', strtotime($tgl)));
	  $category       = db::data_where("id","metode_bayar",$bca,"alias",$alias); // cant fix
	  /// nyusul yes
?>