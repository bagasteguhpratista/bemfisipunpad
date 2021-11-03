<?php
	include '../../../global.php';
		global $var;foreach($GLOBALS as $k=> $v) $$k=$v; //harus ada di fungsi apapun
    $table = "build_list_donasi";
	$date = date('Y-m-d');
	$tgl = date('Y-m-d 23:59:00'); 
	$tgl1 = date('Y-m-d 00:00:01', strtotime('-1 day', strtotime($tgl)));
	  $query = "SELECT * FROM " .  $table . " WHERE status ='Pending' AND metode_bayar = '2147483647' AND created_at BETWEEN '$tgl1' AND '$tgl' ";
           db::query($query,$rs['sql'],$nr['sql']);
            while($rows = db::fetch($rs['sql'])) {
            	$id = $rows['id'];
            	$jumlahdb =  $rows['jumlah'];

if(time() - strtotime($rows['created_at']) > (60 * 60 * 24)) { //Ubah status 1x24
            echo "Proses check dihentikan dan status diubah menjadi Error karena sudah 1 hari tidak melakukan pembayaran.";
            	$update_deposit = db::update($table,
                [ 
                	'status'             => 'Cancel', 
				],'id',$id);
        } else {

            	$padded = sprintf('%0.2f', $jumlahdb);
			$data = array(
			            "search"  => array(
			                    "date"            => array(
			                            "from"    => date("Y-m-d")." 00:00:00",
			                            "to"      => date("Y-m-d")." 23:59:59"
			                            ),
			                    "service_code"    => "bca",
			                    "account_number"  => "2831926173",//Norek
			                    "amount"          => "$jumlahdb.00"
			            )
			);
			$ch = curl_init();
			curl_setopt_array($ch, array(
			    CURLOPT_URL             => "https://api.cekmutasi.co.id/v1/bank/search",
			    CURLOPT_POST            => true,
			    CURLOPT_POSTFIELDS      => http_build_query($data),
			    CURLOPT_HTTPHEADER      => ["Api-Key: d5b1640b7be20e487a41b57a8f3a6e105eb0499c08e44", "Accept: application/json"],
			    CURLOPT_RETURNTRANSFER  => true,
			    CURLOPT_HEADER          => false,
			    CURLOPT_IPRESOLVE       => CURL_IPRESOLVE_V4,
			));
				$result = curl_exec($ch);
           		$response_curl = json_decode($result, true);
            	$cek = $response_curl['response']['0']['amount'];
	if ($padded !== $cek) {
            echo "Pesan tidak ditemukan pada database, ID: ".$id.".<br />";
    } else {

    	$update_deposit = db::update($table,
                [ 
                	'status'             => 'Sukses',
				],'id',$id);
	                    echo "$jumlahdb => Mutasi ditemukan, deposit sukses.<br />";                
   	}
}}
?>