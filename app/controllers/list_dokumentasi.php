<?php

    class list_dokumentasi extends controller
    {
        private $db;
        public static $table = "list_dokumentasi";

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
            while($row = db::fetch($rs['sql'])) $results[] = $row;
            $pagination = ($nr['sql'] > 0) ? $nr['sql'] : 0;

            $status = true;
            $vocab = ['title'];
            // $results = db::all_data("self::$table");
            include_once $var['path'] . "/app/views/template/dsp_list.php";
        }
        ##ADD##
        function add(){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            admin::checkRole("CRT");
            if($_to == "001"){
                valid::getData($data);
                $rs['category'] = db::data_record_select("id,title as name","kategori_dokumentasi","1=1 ORDER BY created_at ASC");
                include_once $var['v_display_path'] . '/' .route::controller(). '/dsp_form.php';
                exit;
            }
            if($_to == "002"){
                valid::unsetValidate();
                valid::setData();
                valid::setValidate([
                    'title'  => 'required',
                    'p_photo' => 'size'
                ]);
                if(valid::checkError()){
                    header("location: ". admin::link_() . '/add');
                    exit;
                }
                $id = rand(1, 100).date("dmYHis");
                // compress size
                if($p_photo_size > 0){
                    $data['photo'] = file::compressImage('p_photo',$var['v_images_path']."/dokumentasi/",50,'d');
                }
                $alias  = admin::alias($title);
                $urut = db::data_where("max(reorder)",self::$table,"1=1");
                $urut = ($urut==0) ? 1 : $urut+1;
                db::insert(self::$table,
                [
                    'id'                => $id,
                    'title'             => $title,
                    'alias'             => $alias,
                    'category'          => $category,
                    'photo'             => $data['photo'],
                    'status'            => 'active',
                    'reorder'           => $urut,
                    'created_by'        => $var['auth']['id'],
                    'created_at'        => $now
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
                $data = db::data_record(self::$table,"id",$id);
                $rs['category'] = db::data_record_select("id,title as name","kategori_dokumentasi","1=1 ORDER BY created_at ASC");
                include_once $var['v_display_path'] . '/' .route::controller(). '/dsp_form.php';
                exit;
            }
            if($_to == "002"){
                valid::unsetValidate();
                valid::setData();
                valid::setValidate([
                    'title'  => 'required'
                ]);
                if(valid::checkError()){
                    header("location: ". admin::link_() . '/edit/'.$id);
                    exit;
                }
                $data = db::data_record(self::$table,"id",$id);
                if(isset($p_photo_del)){
                    @unlink($var['v_images_path']."/dokumentasi/". $data['photo']);
                    $data['photo'] = "";
                }
                if($p_photo_size > 0){
                    @unlink($var['v_images_path']."/dokumentasi/". $data['photo']);
                    $data['photo'] = file::compressImage('p_photo',$var['v_images_path']."/dokumentasi/",50,'d');
                } 
                $alias  = admin::alias($title);
                db::update(self::$table,
                [
                    'title'             => $title,
                    'alias'             => $alias,
                    'category'          => $category,
                    'photo'             => $data['photo'],
                    'updated_by'        => $var['auth']['id'],
                    'updated_at'        => $now
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
                $sql    = "SELECT id, title as title FROM ".$var['table'][self::$table]." WHERE id IN ('". $items ."')";
                db::query($sql, $rs['row'], $nr['row']);
                include_once $var['path'] . "/app/views/template/dsp_delete.php";
            }
            if($_to == "002"){
                if($p_id)$delid  = implode("','", $p_id);
                
                $sql = "SELECT photo FROM ". $var['table'][self::$table] ." WHERE id IN ('". $delid ."')";
                db::query($sql, $rs['row'], $nr['row']);
                while($row=db::fetch($rs['row'])) @unlink($var['v_images_path']."/dokumentasi/". $row['photo']);
                
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