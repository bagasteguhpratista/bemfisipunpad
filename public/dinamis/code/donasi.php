<?php
	include '../../../global.php';
	global $var;foreach($GLOBALS as $k=> $v) $$k=$v; //harus ada di fungsi apapun
	 	include $var['library']. "/donasi/function.php";
	 	$table = "list_donasi";
	if ($_POST['question_box'] == 'setuju') {
		$input_data = array('nama', 'metode_pembayaran','jumlah','catatan','is_private');
		if (check_input($_POST, $input_data) == false) {
				$msg_content = "<b>Gagal:</b> Isi form dengan benar";
				echo $msg_content;	
		} else {
			$input_post = array(
				'nama' 		=> trim(htmlspecialchars(htmlentities($_POST['nama']))),
				'metode_pembayaran' 	=> trim(htmlspecialchars(htmlentities($_POST['metode_pembayaran']))),
				'jumlah' 			=> trim(htmlspecialchars(htmlentities($_POST['jumlah']))),
				'catatan' 			=> trim(htmlspecialchars(htmlentities($_POST['catatan']))),		
				'is_private' 			=> trim(htmlspecialchars(htmlentities($_POST['is_private']))),			
			);
			$date = date("Y/m/d");
			$id = rand(10,100);
			$kodetf = rand(10,100);
			$harustf = $input_post['jumlah']+$kodetf;

$insert_db =  db::insert(self::$table,
                [
                    'id'                => $id,
                    'nama'             => $input_post['nama'],
					'metode_bayar'             => $input_post['metode_pembayaran'],
					'jumlah'             => $harustf,
					'catatan'             => $input_post['catatan'],				
					'is_private'             => $input_post['is_private'],
					'status'             => 'Pending',
                    'created_by'        => 'FRONT',
                    'created_at'        => $now
                ]);
               	if ($insert_db == TRUE) {
				$msg_content = "Laporan anda telah kami terima";
				$status = "success";
				$status_msg = "Sukses";
				} else {
				$msg_content = "Terjadi kesalahan server silakan ulangi atau hubungi contact person kami.";
				$status = "error";
				$status_msg = "Gagal";
				}	
			}
			// echo $msg_content;
			session_start();
			$_SESSION['msg_content']   	= $msg_content;
			$_SESSION['status_msg']  	= $status_msg;
			$_SESSION['status']  		= $status;

			header("location: " . $var['http'] . '/' . 'donasi');
		// }
	}
	
?>