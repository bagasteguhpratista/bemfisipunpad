<?php

    class biro_department extends controller
    {
        private $db;
        public static $table = "biro_department";

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
            
            if(isset($search))$v .= " AND name_dept_biro LIKE '%".$search."%'";
            $halamanaktif = (isset($halamanaktif)) ? $halamanaktif : 1;
            $sql = "SELECT * FROM " . $var['table'][self::$table] . " $v ORDER BY created_at DESC";

            list($query,$limit,$jumlahdatasql,$awalData,$halamanaktif) = admin::pagination($sql,$pagination,$show_all,$halamanaktif);
            db::query($query,$rs['sql'],$nr['sql']);
            while($row = db::fetch($rs['sql']))
            {
                $row['department'] = admin::lang($row['department']);
                $results[] = $row;
            }
            $pagination = ($nr['sql'] > 0) ? $nr['sql'] : 0;
            $status = true;
            $vocab = ['name_dept_biro','department'];
            // $results = db::all_data("self::$table");
            include_once $var['path'] . "/app/views/template/dsp_list.php";
        }
        ##ADD##
        function add(){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            admin::checkRole("CRT");
            if($_to == "001"){
                valid::getData($data);
                include_once $var['v_display_path'] . '/' .route::controller(). '/dsp_form.php';
                exit;
            }
            if($_to == "002"){
                valid::unsetValidate();
                valid::setData();
                valid::setValidate([
                    'name_dept_biro'  => 'required'
                ]);
                if(valid::checkError()){
                    header("location: ". admin::link_() . '/add');
                    exit;
                }
                $id = rand(1, 100).date("dmYHis");
                if($type == "biro") {
                    $department = '';
                }
//                $passwordhash = md5(serialize($password));
                $alias  = admin::alias($name_dept_biro);
                $urut = db::data_where("max(reorder)",self::$table,"1=1");
                $urut = ($urut==0) ? 1 : $urut+1;
                db::insert(self::$table,
                [
                    'id'                => $id,
                    'name_dept_biro'    => $name_dept_biro,
                    'department'        => $department,
                    'name_chairman'     => $name_chairman,
                    'photo_chairman'    => $p_photo_chairman,
                    'name_vice'         => $name_vice,
                    'photo_vice'        => $p_photo_vice,
                    'alias'             => $alias,
                    'type'              => $type,
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
                include_once $var['v_display_path'] . '/' .route::controller(). '/dsp_form.php';
                exit;
            }
            if($_to == "002"){
                valid::unsetValidate();
                valid::setData();
                valid::setValidate([
                    'name_dept_biro'  => 'required'
                ]);
                if(valid::checkError()){
                    header("location: ". admin::link_() . '/edit/'.$id);
                    exit;
                }
                if($type == "biro") {
                    $department = '';
                }
                $alias  = admin::alias($name_dept_biro);
                db::update(self::$table,
                [
                    'name_dept_biro'    => $name_dept_biro,
                    'department'        => $department,
                    'name_chairman'     => $name_chairman,
                    'photo_chairman'    => $p_photo_chairman,
                    'name_vice'         => $name_vice,
                    'photo_vice'        => $p_photo_vice,
                    'type'              => $type,
                    'alias'             => $alias,
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
                $sql    = "SELECT id, name_dept_biro as title FROM ".$var['table'][self::$table]." WHERE id IN ('". $items ."')";
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