<?php
    global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
    db::connect();
    if(admin::isset($page)){
        function setJson($data,$file){
            global $var;
            $data = json_encode($data);
            if(admin::isset($data))
            {
                $files = $var['json_path'] ."/". $file .".json";
                file::createJson($files,$data);
            }
        }
        switch ($page){
            case 'page':
                $sql  = "SELECT * FROM ". $var['table']['page'] . " where tobe='parent' AND publish='show' AND status='active' order by created_at asc";
                db::query($sql, $rs['data'], $nr['data']);
                while($row  = db::fetch($rs['data']))
                {
                    
                    $row['link_internal'] = $var['http'] .'/'. $row['alias'];
                    $sql1 = "SELECT * FROM " . $var['table']['page'] . " where tobe='child' AND publish='show' AND category=". $row['id']. " Order By created_at ASC";
                    db::query($sql1, $rs['data1'], $nr['data1']);
                    while ($row1 = db::fetch($rs['data1'])) {
                        $row1['link_internal'] = $var['http'] .'/'. $row1['alias'];
                        $row['categories'][] = $row1;
                    }
                    $data[] = $row;
                }
                echo json_encode($data);
                setJson($data, "menuheader");
                setJson($data, "menufooter");
            break;
            case 'akun_media_sosial':
                $sql  = "SELECT * FROM ". $var['table']['akun_media_sosial'] . " WHERE status ='active' ORDER BY created_at ASC";
                db::query($sql, $rs['data'], $nr['data']);
                while($row  = db::fetch($rs['data']))
                {
                    $data[] = $row;
                }
                echo json_encode($data);
                setJson($data, "mediasosial");
            break;
            case 'configuration':
                $sql  = "SELECT * FROM ". $var['table']['configuration'] . " WHERE status ='active'";
                db::query($sql, $rs['data'], $nr['data']);
                while($row  = db::fetch($rs['data']))
                {
                    $data[] = $row;
                }
                echo json_encode($data);
                setJson($data, "jumlahbem");
            break;
            case 'akun_pendukung':
                $sql  = "SELECT * FROM ". $var['table']['akun_pendukung'] . " WHERE status ='active'";
                db::query($sql, $rs['data'], $nr['data']);
                while($row  = db::fetch($rs['data']))
                {
                    $sosmed =  "SELECT * FROM ". $var['table']['sosmed_pendukung'] . " WHERE id_akun_pendukung='".$row['id']."'";
                    db::query($sosmed, $rs['sosmed'], $nr['sosmed']);
                    while($ls_sosmed  = db::fetch($rs['sosmed']))
                    {
                        $row['sosmed'][] = $ls_sosmed;
                    }
                    $data[] = $row;
                }
                echo json_encode($data);
                setJson($data, "akunpendukunghome");
                setJson($data, "akunpendukung");
            break;
            case 'himpunan_huria_mahasiswa_dan_ukm':
                $sql  = "SELECT * FROM ". $var['table']['himpunan_huria_mahasiswa_dan_ukm'] . " WHERE status ='active'";
                db::query($sql, $rs['data'], $nr['data']);
                while($row  = db::fetch($rs['data']))
                {
                    $data[] = $row;
                }

                echo json_encode($data);
                setJson($data, "organisasipendukunghome");
                setJson($data, "ukmhome");
                setJson($data, "himpunan");
                setJson($data, "huria");
                setJson($data, "ukm");
            break;
            case 'pimpinan_kabinet':
                $sql  = "SELECT * FROM ". $var['table']['pimpinan_kabinet'] . " WHERE status ='active'";
                db::query($sql, $rs['data'], $nr['data']);
                while($row  = db::fetch($rs['data']))
                {
                    $data[] = $row;
                }
                echo json_encode($data);
                setJson($data, "pimkab");
            break;
            case 'biro_department':
                $sql  = "SELECT * FROM ". $var['table']['biro_department'] . " WHERE status ='active' ORDER BY reorder ASC";
                db::query($sql, $rs['data'], $nr['data']);
                while($row  = db::fetch($rs['data']))
                {
                    $data[] = $row;
                }
                echo json_encode($data);
                setJson($data, "birodept");
            break;
            case 'list_dokumentasi':
                $sql  = "SELECT * FROM ". $var['table']['list_dokumentasi'] . " WHERE status ='active'";
                db::query($sql, $rs['data'], $nr['data']);
                while($row  = db::fetch($rs['data']))
                {
                    $row['photo'] = $var['v_images_url']."/dokumentasi/". $row['photo'];
                    $row['category_name'] = db::data_where("alias","kategori_dokumentasi","id",$row['category']);
                    $data[] = $row;
                }
                echo json_encode($data);
                setJson($data, "dokumentasi");
            break;
            case 'kategori_dokumentasi':
                $sql  = "SELECT * FROM ". $var['table']['kategori_dokumentasi'] ." WHERE status='active' ORDER BY created_at";
                db::query($sql, $rs['data'], $nr['data']);
                $cat = array(
                    "id"=>"all",
                    "title"=>"Semua",
                    "alias"=>"all",
                    "status"=>"active",
                    "reorder"=>"-",
                    "created_at" => "2020-07-04 09:12:35",
                    "created_by" => "1",
                    "updated_at" => "0000-00-00 00:00:00",
                    "updated_by" => ""
                );
                $data[] = $cat;
                while($row  = db::fetch($rs['data']))
                {
                    $data[] = $row;
                }
                echo json_encode($data);
                setJson($data, "kategoridokumentasi");
            break;
            case 'faq':
                $sql  = "SELECT * FROM ". $var['table']['faq'] . " WHERE status ='active' ORDER BY reorder ASC";
                db::query($sql, $rs['data'], $nr['data']);
                while($row  = db::fetch($rs['data']))
                {
                    $data[] = $row;
                }
                echo json_encode($data);
                setJson($data, "faq");
            break;
            case 'artikel':
                $sql  = "SELECT * FROM ". $var['table']['artikel'] . " WHERE status ='active'";
                db::query($sql, $rs['data'], $nr['data']);
                while($row  = db::fetch($rs['data']))
                {
                    $row['url'] = $var['http'].'/artikel/detail/'.$row['alias'];
                    $row['image_cover'] = $var['v_images_url']."/artikel/". $row['image_cover'];
                    // $row['publish_date'] = admin::format_date($item['publish_date'],'id','A');
                    $row['category_alias'] = db::data_where("alias","kategori_artikel","id",$row['category']);
                    $row['category_name'] = db::data_where("name","kategori_artikel","id",$row['category']);
                    $data[] = $row;
                }
                echo json_encode($data);
                setJson($data, "artikel");
                setJson($data, "detailartikel");
            break;
            case 'kategori_artikel':
                $sql  = "SELECT * FROM ". $var['table']['kategori_artikel'] ." WHERE status='active' ORDER BY created_at";
                db::query($sql, $rs['data'], $nr['data']);
                $cat = array(
                    "id"=>"all",
                    "name"=>"Semua",
                    "alias"=>"all",
                    "status"=>"active",
                    "reorder"=>"-",
                    "created_at" => "2020-07-04 09:12:35",
                    "created_by" => "1",
                    "updated_at" => "0000-00-00 00:00:00",
                    "updated_by" => ""
                );
                $data[] = $cat;
                while($row  = db::fetch($rs['data']))
                {
                    $data[] = $row;
                }
                echo json_encode($data);
                setJson($data, "kategoriartikel");
            break;
        }
    }