<?php
	include '../../../global.php';
	global $var;foreach($GLOBALS as $k=> $v) $$k=$v; //harus ada di fungsi apapun
	include $var['library']. "/mailer/class.phpmailer.php";
  	include $var['library']. "/mailer/function.php";
	// include $var['library']. "/donasi/function.php";
	$table = "list_donasi";
	// echo json_encode($_POST);exit;
	// if ($_POST['question_box'] == 'setuju') {
		$input_data = array('nama', 'email', 'metode_pembayaran','jumlah','catatan');
		if(str_replace(',','',$_POST['jumlah']) <= 10000){
			$msg_content = "<b>Gagal:</b> Minimal jumlah donasi sebesar Rp 10.000,-";
			$status 		= "danger";
			valid::setData();
		}
		else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$msg_content 	= "<b>Gagal:</b> Email tidak valid.";
			$status 		= "danger";
			valid::setData();
		}
		else if (check_input($_POST, $input_data) == false) {
			$msg_content = "<b>Gagal:</b> Isi form dengan benar";
			$status 		= "danger";
			valid::setData();
			// echo $msg_content;	
		}else {
			$input_post = array(
				'nama' 					=> trim(htmlspecialchars(htmlentities($_POST['nama']))),
				'email' 				=> trim(htmlspecialchars(htmlentities($_POST['email']))),
				'metode_pembayaran' 	=> trim(htmlspecialchars(htmlentities($_POST['metode_pembayaran']))),
				'jumlah' 				=> trim(htmlspecialchars(htmlentities(str_replace(',','',$_POST['jumlah'])))),
				'catatan' 				=> trim(htmlspecialchars(htmlentities($_POST['catatan']))),		
				'is_private' 			=> trim(htmlspecialchars(htmlentities($_POST['is_private']))),			
			);
			echo $_POST['email'];
			exit;
			$input_post['is_private'] = !isset($input_post) ? 'yes' : 'no';
			// echo $input_post['is_private'];exit;
			// $id 		= rand(10,100);
			$kodetf 	= rand(10,100);
			$harustf 	= $input_post['jumlah']+$kodetf;
			$id 		= rand(1, 100).date("dmYHis");
			$urut 		= db::data_where("max(reorder)",$table,"1=1");
            $urut 		= ($urut==0) ? 1 : $urut+1;

			db::insert($table,
            [
                'id'         	=> $id,
                'nama'          => $input_post['nama'],
                'email'         => $input_post['email'],
				'metode_bayar'  => $input_post['metode_pembayaran'],
				'jumlah'        => $input_post['jumlah'],
				'kode_unik'		=> $kodetf,
				'catatan'       => $input_post['catatan'],				
				'is_private'    => $input_post['is_private'],
				'status'        => 'inactive',
				'reorder'		=> $urut,
                'created_by'    => 'a1',
                'created_at'    => $now
            ]);
            $date = date("Y/m/d");
			$cek_data = db::data_where("id","list_donasi","id='".$id."'");
            $pembayaran = db::data_record("metode_pembayaran","id",$input_post['metode_pembayaran']);
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

					        p{
					        	color: #1a1a1a !important;
					        }

					        .data-data{
					        	text-align: left;
					        	color: #1a1a1a; 
					        	font-size: 16px;
					        	width: 100%;
					        	line-height: 1.8;
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

					        .verif{
					        	font-size: 12px;
					        	font-style: italic;
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
					                            <h1 style="font-size: 32px; font-weight: 900; margin: 2;">Terima kasih orang baik</h1> 
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
					                        <td class="data-data title">
					                        	<p>Halo <b>'.$input_post['nama'].'</b>, terima kasih atas donasi Anda untuk campaign "Bantu Low vision Support group".</p>
					                        	<p>Lakukan Transfer sebesar: <b>'.$harustf.'</b> tepat hingga 3 digit terakhir (Cantumkan kode unik pada nominal transfer, supaya donasi terverifikasi tanpa perlu konfirmasi)
					                        	</p>
					                        	<p>Ke: <b>'.$pembayaran['nama_bank'].'</b> No Rek. <b>'.$pembayaran['rekening'].'</b> a.n <b> '.$pembayaran['atas_nama'].' </b></p> 
					                        	<p>Proses transfer dapat dilakukan via channel (ATM/mobile banking/sms banking/Applikasi E-wallet)</p>
					                        	<p>Donasi Anda akan terverifikasi oleh sistem maksimal dalam 1 hari kerja*.
					                        	</p>
					                        	<p class="verif">*Verifikasi donasi akan mengalami keterlambatan, apabila transfer di luar jam kerja bank atau pada hari libur.</p>
					                        	<br>
					                        </td>
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
                $mail->SetFrom('fms@bemfisipunpad.com','Donasi FMS Unpad'); //set email pengirim
                $mail->Subject 		= "Donasi FMS"; //subyek email
                $mail->AddAddress($input_post['email'],'Donasi FMS Unpad');  //tujuan email
                // adkesmabemfisipunpad@gmail.com -> email adkesma
                $mail->MsgHTML($body_email);
               	if ($mail->Send()) {
					$msg_content 	= "Permintaan anda telah kami terima, Silakan cek email anda untuk informasi lebih lanjut.";
					$status 		= "success";
					$status_msg 	= "Sukses";
				}else {
					$msg_content 	= "Terjadi kesalahan server silakan ulangi atau hubungi contact person kami.";
					$status 		= "danger";
					$status_msg 	= "Gagal";
				}	
			}
			$_SESSION['msg_content']   	= $msg_content;
			$_SESSION['status_msg']  	= $status_msg;
			$_SESSION['status']  		= $status;

			header("location: " . $var['http'] . '/' . 'donasi#donate-now');
		// }
	// }
	
?>