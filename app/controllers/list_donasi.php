<?php

    class list_donasi extends controller
    {
        private $db;
        public static $table = "list_donasi";

        public function __construct()
        {
            global $var, $GLOBALS;
            db::connect();
            admin::_global();
            db::execute("SET sql_mode = ''");
        }

        function index(){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            valid::unsetValidate();
            admin::checkRole("DSPL");
            $url = route::controller();
            $v = "WHERE 1=1";
            $limit = "";
            $results = [];
            $show_all = isset($show_all) ? $show_all : 0;
            // view::pagination();
            $pagination = isset($pagination) ? $pagination : 10;
            
            if(isset($search))$v .= " AND title LIKE '%".$search."%'";
            $halamanaktif = (isset($halamanaktif)) ? $halamanaktif : 1;
            $sql = "SELECT * FROM " . $var['table'][self::$table] . " $v ORDER BY created_at DESC";

            list($query,$limit,$jumlahdatasql,$awalData,$halamanaktif) = admin::pagination($sql,$pagination,$show_all,$halamanaktif);
            db::query($query,$rs['sql'],$nr['sql']);
            while($row = db::fetch($rs['sql'])){
                // if($row['is_private'] == 'yes'){
                //     $row['nama'] = admin::changestar($row['nama']);
                // }
                $row['jumlah_kode_unik'] = $row['jumlah'] + $row['kode_unik'];
                $row['bank'] = db::data_where("bank","metode_pembayaran","id",$row['metode_bayar']);
                $results[] = $row;
            }
            $pagination = ($nr['sql'] > 0) ? $nr['sql'] : 0;

            $status = true;
            $vocab = ['nama','email','bank','jumlah','kode_unik','jumlah_kode_unik'];
            // $results = db::all_data("self::$table");
            include_once $var['path'] . "/app/views/template/dsp_list.php";
        }
        ##ADD##
        function add(){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            admin::checkRole("CRT");
            if($_to == "001"){
                valid::getData($data);
                 $rs['metode_bayar'] = db::data_record_select("id,bank as name","metode_pembayaran","1=1 ORDER BY created_at ASC");
                include_once $var['v_display_path'] . '/' .route::controller(). '/dsp_form.php';
                exit;
            }
            if($_to == "002"){
                valid::unsetValidate();
                valid::setData();
                valid::setValidate([
                    'name'              => 'required',
                    'metode_bayar'      => 'required',
                    'jumlah'            => 'required',
                    'catatan'           => 'required',
                    'privasi'           => 'required',
                    'status_pembayaran' => 'required'

                ]);
                if(valid::checkError()){
                    header("location: ". admin::link_() . '/add');
                    exit;
                }
                $id = rand(1, 100).date("dmYHis");
//                $passwordhash = md5(serialize($password));
                $alias  = admin::alias($title);
                $urut = db::data_where("max(reorder)",self::$table,"1=1");
                $urut = ($urut==0) ? 1 : $urut+1;
                $status_pembayaran = ($status_pembayaran == 'Sukses') ? 'active' : 'inactive';
                db::insert(self::$table,
                [
                    'id'              => $id,
                    'nama'            => $name,
                    'metode_bayar'    => $metode_bayar,
                    'email'           => $email,
                    'jumlah'          => $jumlah,
                    'catatan'         => $catatan,
                    'is_private'      => $privasi,
                    'status'          => $status_pembayaran,
                    'created_by'      => $var['auth']['id'],
                    'created_at'      => $now
                ]);
                flasher::setFlash('success', admin::lang('create'));
                header("location: " . $var['app_url'] . '/' . route::controller());
            }
        }
        ##EDIT##
        function edit($id){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            admin::checkRole("UPDT");
            if($_to == "001"){
                $rs['metode_bayar'] = db::data_record_select("id,bank as name","metode_pembayaran","1=1 ORDER BY created_at ASC");
                $data = db::data_record(self::$table,"id",$id);
                $data['status'] = ($data['status'] == 'active') ? 'Sukses' : 'Pending';
                include_once $var['v_display_path'] . '/' .route::controller(). '/dsp_form.php';
                exit;
            }
            if($_to == "002"){
                valid::unsetValidate();
                valid::setData();
                valid::setValidate([
                    'name'              => 'required',
                    'metode_bayar'      => 'required',
                    'jumlah'            => 'required',
                    'catatan'           => 'required',
                    'privasi'           => 'required',
                    'status_pembayaran' => 'required'
                ]);
                if(valid::checkError()){
                    header("location: ". admin::link_() . '/edit/'.$id);
                    exit;
                }

                $status_pembayaran = ($status_pembayaran == 'Sukses') ? 'active' : 'inactive';
                $alias  = admin::alias($title);
                db::update(self::$table,
                [
                    'nama'                  => $name,
                    'metode_bayar'          => $metode_bayar,
                    'jumlah'                => $jumlah,
                    'email'                 => $email,
                    'catatan'               => $catatan,
                    'is_private'            => $privasi,
                    'status'                => $status_pembayaran,
                    'updated_by'            => $var['auth']['id'],
                    'updated_at'            => $now
                ],'id',$id);

                flasher::setFlash('success', admin::lang('update'));
                header("location: " . $var['app_url'] . '/' . route::controller());
            }
        }
        ##DELETE##
        function delete($idd=null){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v; //harus ada di fungsi apapun
            admin::checkRole("DEL");
            $_to = $idd == null ? $_to : $idd;
            if($_to == "001"){
                $items  = implode("','", $p_del);
                $sql    = "SELECT id, nama as title FROM ".$var['table'][self::$table]." WHERE id IN ('". $items ."')";
                db::query($sql, $rs['row'], $nr['row']);
            
                include_once $var['path'] . "/app/views/template/dsp_delete.php";
            }
            if($_to == "002"){
                if($p_id)$delid  = implode("','", $p_id);
                
                db::delete(self::$table,'id',$delid);
                flasher::setFlash('success', admin::lang('delete'));
                header("location: " . $var['app_url'] . '/' . route::controller());
            }
        }
        ##STATUS##
        function status($id,$status){
            global $var;
            admin::checkRole("UPDT");
            // admin::cek_validasi();
            $url = route::controller();
            if($status == 'active'){
                $statusnya = 'inactive';
            }
            elseif($status == 'inactive'){
                $statusnya = 'active';
            }
            $sql = "UPDATE ".$var['table'][self::$table]."
			SET status = '$statusnya'
            WHERE id = '$id'";
            db::execute($sql);
            header("location: " . $var['app_url'] . '/' . route::controller());
            // return redirect()->route('slider')->with('create', 'Status berhasil diubah');
        }
    }