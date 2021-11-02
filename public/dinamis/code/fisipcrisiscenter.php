<?php
	include '../../../global.php';
	global $var;foreach($GLOBALS as $k=> $v) $$k=$v; //harus ada di fungsi apapun
  	include $var['library']. "/mailer/class.phpmailer.php";
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
			// if (check_empty($input_post) == true) {
			// 		$msg_content = "<b>Gagal:</b> Isi form dengan benar";
			// } else {
				// body email
				//send data to database
				$id = rand(1, 100).date("dmYHis");
				$urut = db::data_where("max(reorder)","fisipcrisiscenter","1=1");
                $urut = ($urut==0) ? 1 : $urut+1;
				db::insert("fisipcrisiscenter",
                [
                    'id'                => $id,
                    'nama_lengkap'		=> $nama_lengkap,
                    'program_studi'		=> $program_studi,
                    'angkatan'			=> $angkatan,
                    'no_telp'			=> $no_telp,
                    'id_line'			=> $id_line,
                    'status'            => 'active',
                    'reorder'           => $urut,
                    'created_by'        => "a1",
                    'created_at'        => $now
                ]);
				// exit;
				$body_email = '
				<!DOCTYPE html>
					<html>

					<head>
					    <title></title>
					    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					    <meta name="viewport" content="width=device-width, initial-scale=1">
					    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
					    <style type="text/css">
					       /* CLIENT-SPECIFIC STYLES */
					      
					        img {
					            -ms-interpolation-mode: bicubic;
					        }

					        /* RESET STYLES */
					        img {
					            border: 0;
					            height: auto;
					            line-height: 100%;
					            outline: none;
					            text-decoration: none;
					        }

					        table {
					            border-collapse: collapse !important;
					        }

					        .data-data{
					        	text-align: left;
					        	padding: 20px 30px 25px; 
					        	color: #1a1a1a; 
					        	font-size: 16px; 
					        	font-weight: 600;
					        	width: 150px;
					        }

					        .title{
					        	color: #5a5a5a;
					        }

					        .box-td{
					        	background-color: #fff;
					        	display: flex;
					        	margin: 0 50px;
					        }

					        .box-q{
					        	background-color: #fff;
					        	display: flex;
					        	margin: 0 10px;
					        }

					        .box-q .data-data{
					        	width: 100px;
					        }

					        .box-q .data-data.title{
					        	width: 350px;
					        }

					        body {
					            height: 100% !important;
					            margin: 0 !important;
					            padding: 0 !important;
					            width: 100% !important;
					            font-family: "Aganè";
					        }

					        /* iOS BLUE LINKS */
					        a[x-apple-data-detectors] {
					            color: inherit !important;
					            text-decoration: none !important;
					            font-size: inherit !important;
					            font-family: inherit !important;
					            font-weight: inherit !important;
					            line-height: inherit !important;
					        }

					        /* MOBILE STYLES */
					        @media screen and (max-width:600px) {
					            h1 {
					                font-size: 32px !important;
					                line-height: 32px !important;
					            }
					        }

					        /* ANDROID CENTER FIX */
					        div[style*="margin: 16px 0;"] {
					            margin: 0 !important;
					        }
					    </style>
					</head>

					<body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
					    <table border="0" cellpadding="0" cellspacing="0" width="100%">
					        <!-- LOGO -->
					        <tr>
					            <td bgcolor="#FFA73B" align="center">
					                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
					                    <tr>
					                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
					                    </tr>
					                </table>
					            </td>
					        </tr>
					        <tr>
					            <td bgcolor="#FFA73B" align="center" style="padding: 0px 10px 0px 10px;">
					                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
					                    <tr>
					                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #1a1a1a; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
					                            <h1 style="font-size: 32px; font-weight: 900; margin: 2;">Laporan FISIP Crisis Center!</h1> 
					                            <hr style="width:80%;">
					                        </td>
					                    </tr>
					                </table>
					            </td>
					        </tr>
					        <tr>
					            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
					                <table border="0" width="100%" style="max-width: 600px;background: #fff;">
					                    <tr class="box-td">
					                        <td class="data-data title">Nama Lengkap</td>
					                        <td class="data-data">'.$input_post['nama_lengkap'].'</td>
					                    </tr>
					                    <tr class="box-td">
					                        <td class="data-data title">Program Studi</td>
					                        <td class="data-data">'.$input_post['program_studi'].'</td>
					                    </tr>
					                    <tr class="box-td">
					                        <td class="data-data title">Angkatan</td>
					                        <td class="data-data">'.$input_post['angkatan'].'</td>
					                    </tr>
					                    <tr class="box-td">
					                        <td class="data-data title">Kontak</td>
					                        <td class="data-data">'.$input_post['no_telp'].'</td>
					                    </tr>
					                    <tr class="box-td">
					                        <td class="data-data title">Id Line</td>
					                        <td class="data-data">'.$input_post['id_line'].'</td>
					                    </tr>
					                    <tr><td><hr style="width:80%;margin: 30px auto;"></td></tr>
					                </table>
					            </td>
					        </tr>
					        <tr>
					            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
					                <table border="0" width="100%" style="max-width: 600px;background: #fff;">
					                    <tr class="box-q">
					                        <td class="data-data title">Kasus terjadi pada	</td>
					                        <td class="data-data">'.$input_post['kasus_terjadi'].'</td>
					                    </tr>
					                    <tr class="box-q">
					                        <td class="data-data title">Apakah pelaku kekerasan seksual dalam kasus ini merupakan civitas FISIP Unpad?</td>
					                        <td class="data-data">'.$input_post['pelaku_kekerasan'].'</td>
					                    </tr>
					                    <tr class="box-q">
					                        <td class="data-data title">Apakah korban kekerasan seksual dalam kasus ini merupakan civitas FISIP Unpad ?</td>
					                        <td class="data-data">'.$input_post['korban_kekerasan'].'</td>
					                    </tr>
					                    <tr class="box-q">
					                        <td class="data-data title">Apakah kasus kekerasan seksual ini terjadi di sekitar lingkungan FISIP Unpad?</td>
					                        <td class="data-data">'.$input_post['lingkungan_kekerasan'].'</td>
					                    </tr>
					                    <tr class="box-q">
					                        <td class="data-data title">Jenis kekerasan seksual apa yang terjadi?</td>
					                        <td class="data-data">'.$input_post['jenis_kekerasan'].'</td>
					                    </tr>
					                </table>
					            </td>
					        </tr>
					        <tr>
					            <td bgcolor="#f4f4f4" align="center">
					                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
					                    <tr>
					                        <td bgcolor="#FFECD1" align="center" style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-size: 18px; font-weight: 400; line-height: 25px;">
					                            <h2 style="font-size: 20px; font-weight: 600; color: #706969; margin: 0;">Dibuat pada '.$date.'</h2>
					                            <!-- <p style="margin: 0;"><a href="#" target="_blank" style="color: #FFA73B;">We&rsquo;re here to help you out</a></p> -->
					                        </td>
					                    </tr>
					                </table>
					            </td>
					        </tr>
					    </table>
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
                $mail->SetFrom('setiawan@bemfisipunpad.com','BEM FISIP UNPAD'); //set email pengirim
                $mail->Subject 		= "LAPORAN FISIP CRISIS CENTER"; //subyek email
                $mail->AddAddress('bagaskawan@gmail.com','Adkesma BEM FISIP Unpad');  //tujuan email
                // adkesmabemfisipunpad@gmail.com -> email adkesma
                $mail->MsgHTML($body_email);
                if($mail->Send()){
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