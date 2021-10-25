<?php
	include '../../../global.php';
	global $var;foreach($GLOBALS as $k=> $v) $$k=$v; //harus ada di fungsi apapun
  	include $var['library']. "/mailer/function.php";
	if ($_POST['question_box'] == 'setuju') {
		$input_data = array('nama_lengkap', 'program_studi','angkatan','no_telp','id_line','kasus_terjadi','pelaku_kekerasan','korban_kekerasan','lingkungan_kekerasan','jenis_kekerasan');
		if (check_input($_POST, $input_data) == false) {
				$msg_content = "<b>Gagal:</b> Isi form dengan benar";
				echo $msg_content;	
		} else {
			$input_post = array(
				'nama_lengkap' 		=> trim(htmlspecialchars(htmlentities($_POST['nama_lengkap']))),
				'program_studi' 	=> trim(htmlspecialchars(htmlentities($_POST['program_studi']))),
				'angkatan' 			=> trim(htmlspecialchars(htmlentities($_POST['angkatan']))),
				'no_telp' 			=> trim(htmlspecialchars(htmlentities($_POST['no_telp']))),
				'id_line' 			=> trim(htmlspecialchars(htmlentities($_POST['id_line']))),
				'kasus_terjadi' 	=> trim(htmlspecialchars(htmlentities($_POST['kasus_terjadi']))),
				'pelaku_kekerasan' 	=> trim(htmlspecialchars(htmlentities($_POST['pelaku_kekerasan']))),
				'korban_kekerasan' 	=> trim(htmlspecialchars(htmlentities($_POST['korban_kekerasan']))),
				'lingkungan_kekerasan' 	=> trim(htmlspecialchars(htmlentities($_POST['lingkungan_kekerasan']))),
				'jenis_kekerasan' 	=> trim(htmlspecialchars(htmlentities($_POST['jenis_kekerasan']))),
				// 'question05' 	=> trim(htmlspecialchars(htmlentities($_POST['question05']))),
				// 'addontext' 	=> trim(htmlspecialchars(htmlentities($_POST['addontext']))),
				// 'verifikasi'	=> trim(htmlspecialchars(htmlentities($_POST['verifikasi']))),		
			);
			$date = date("Y/m/d");
			$idrandom = rand(10,1000);
			// if (check_empty($input_post) == true) {
			// 		$msg_content = "<b>Gagal:</b> Isi form dengan benar";
			// } else {
				// body email
				$email_body = [
				    	'Messages' => [
				        [
				        'From' => [
				            'Email' => "web@bemfisipunpad.com",
				            'Name' => "FCC REPORT"
				        ],
				        'To' => [
				            [
				                'Email' => "lijeuki@gmail.com", // tujuan email
				                'Name' => "ADKESMA"
				            ]
				        ],
				        'Subject' => "LAPORAN FCC. #".$idrandom." ",
				        'HTMLPart' => "Laporan FCC<br><br>
								___________________________________________________________________<br>
								Nama: ".$input_post['nama_lengkap']."<br>
								Program Studi: ".$input_post['program_studi']."<br>
								Angkatan: ".$input_post['angkatan']."<br>
								Kontak: ".$input_post['no_telp']." <br>
								Id Line:".$input_post['id_line']."<br>
								<br>
								Kasus terjadi pada: ".$input_post['kasus_terjadi']."<br>
								Apakah pelaku kekerasan seksual dalam kasus ini merupakan civitas FISIP Unpad?: ".$input_post['pelaku_kekerasan']."<br>
								Apakah korban kekerasan seksual dalam kasus ini merupakan civitas FISIP Unpad ?: ".$input_post['korban_kekerasan']."<br>
								Apakah kasus kekerasan seksual ini terjadi di sekitar lingkungan FISIP Unpad?: ".$input_post['lingkungan_kekerasan']."<br>
								Jenis kekerasan seksual apa yang terjadi?: ".$input_post['jenis_kekerasan']."<br>
								<br>
								Date: ".$date."<br>
								<br>_________________________________________________________<br>"
				        ]
				    ]
				];
  
$ch = curl_init();
  
curl_setopt($ch, CURLOPT_URL, "https://api.mailjet.com/v3.1/send");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($email_body));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json')
);
curl_setopt($ch, CURLOPT_USERPWD, "7e56915b4f26c23049cc3d7966425f53:a218c01ece5a0b6a39dabe80a13dfe8c"); //Mailjet credentials
$server_output = curl_exec($ch);
curl_close ($ch);
  
$response = json_decode($server_output);
                if($response->Messages[0]->Status == 'success'){
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

			header("location: " . $var['http'] . '/' . 'fisipcrisiscenter');
		// }
	}
	
?>