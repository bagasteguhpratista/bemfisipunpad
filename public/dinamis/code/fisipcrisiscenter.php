<?php
	include '../../../global.php';
	global $var;foreach($GLOBALS as $k=> $v) $$k=$v; //harus ada di fungsi apapun
  	include $var['library']. "/mailer/class.phpmailer.php";
  	include $var['library']. "/mailer/function.php";
  
	// echo json_encode($_POST);exit;
// if (isset($_POST['submit'])) {
		$input_data = array('nama_lengkap', 'program_studi','angkatan','no_telp','id_line','kasus_terjadi','pelaku_kekerasan','korban_kekerasan','lingkungan_kekerasan','jenis_kekerasan');
		if (check_input($_POST, $input_data) == false) {
				$msg_content = "<b>Gagal:</b> Isi form dengan benar";
				echo $msg_content;	
		} else {
		// echo check_input($_POST, $input_data);
		// exit;
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
			// if (check_empty($input_post) == true) {
			// 		$msg_content = "<b>Gagal:</b> Isi form dengan benar";
			// } else {
// body email
$body_email = '
<html>
<body>
Laporan FCC<br><br>
___________________________________________________________________<br>
Nama: '.$input_post['nama_lengkap'].'<br>
Program Studi: '.$input_post['program_studi'].'<br>
Angkatan: '.$input_post['angkatan'].'<br>
Kontak: '.$input_post['no_telp'].' <br>
Id Line:'.$input_post['id_line'].'<br>
<br>
Kasus terjadi pada: '.$input_post['kasus_terjadi'].'<br>
Apakah pelaku kekerasan seksual dalam kasus ini merupakan civitas FISIP Unpad?: '.$input_post['pelaku_kekerasan'].'<br>
Apakah korban kekerasan seksual dalam kasus ini merupakan civitas FISIP Unpad ?: '.$input_post['korban_kekerasan'].'<br>
Apakah kasus kekerasan seksual ini terjadi di sekitar lingkungan FISIP Unpad?: '.$input_post['lingkungan_kekerasan'].'<br>
Jenis kekerasan seksual apa yang terjadi?: '.$input_post['jenis_kekerasan'].'<br>
<br>
Date: '.$date.'<br>
<br>_________________________________________________________<br>
</body>
</html>
';
                    $mail = new PHPMailer; 
                    $mail->IsSMTP();
                    $mail->SMTPSecure 	= 'ssl'; 
                    $mail->Host 		= 'smtp.gmail.com'; //host masing2 provider email
                    $mail->SMTPDebug 	= 0;
                    $mail->Port 		= 465;
                    $mail->SMTPAuth 	= true;
                    $mail->Username 	= 'webbemfisipunpad@gmail.com'; //user email
                    $mail->Password 	= 'webwebweb123'; //password email 
                    $mail->SetFrom('admin@bemfisipunpad.com','BEM FISIP UNPAD'); //set email pengirim
                    $mail->Subject 		= "LAPORAN FISIP CRISIS CENTER"; //subyek email
                    $mail->AddAddress('bagaskawan@gmail.com','bagass Teguh');  //tujuan email
                    $mail->MsgHTML($body_email);
                    if($mail->Send()){
					$msg_content = "<b>Sukses:</b> Laporan anda telah kami terima";
					} else {
					$msg_content = "<b>Gagal:</b> Terjadi kesalahan server silakan ulangi atau hubungi contact person kami.";
					}	
				
			}
			echo $msg_content;	
		// }
	// }
	
?>