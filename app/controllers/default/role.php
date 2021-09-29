<?php

    class role extends controller
    {
        private $db;
        // public $table = 
        public static $table = "role";

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
            
            if(isset($search))$v .= " AND name LIKE '%".$search."%'";
            $halamanaktif = (isset($halamanaktif)) ? $halamanaktif : 1;
            $sql = "SELECT * FROM " . $var['table'][self::$table] . " $v ORDER BY created_at DESC";

            list($query,$limit,$jumlahdatasql,$awalData,$halamanaktif) = admin::pagination($sql,$pagination,$show_all,$halamanaktif);
            db::query($query,$rs['sql'],$nr['sql']);
            while($row = db::fetch($rs['sql'])) $results[] = $row;
            $pagination = ($nr['sql'] > 0) ? $nr['sql'] : $pagination;

            $status = false;
            $vocab = ['name'];
            // $results = db::all_data("self::$table");
            include_once $var['path'] . "/app/views/template/dsp_list.php";
        }
        ##ADD##
        function add(){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            admin::checkRole("CRT");
            if($_to == "001"){
                include_once $var['v_display_path'] . '/default/' .route::controller(). '/dsp_form.php';
                exit;
            }
            if($_to == "002"){
                
                $id = rand(1, 100).date("dmYHis");
                db::insert('role',
                [
                    'id'                => $id,
                    'name'              => $name,
                    'created_by'        => $var['auth']['id'],
                    'created_at'        => $now
                ]);
                if(isset($p_acc) AND count($p_acc) > 0)
                {
                    foreach ($p_acc as $kacc => $vacc)
                    {
                        if( count($vacc) > 0 )
                        {
                            foreach ($vacc as $krole => $vrole)
                            {
                                $_id = $krole.rand(50, 1000).date("dmYHis");
                                db::insert('role_detail',[
                                    'id'                => $_id,
                                    'id_role'           => $id,
                                    'page'              => $kacc,
                                    'role'              => $vrole
                                ]);
                            }
                        }
                    }
                }
                flasher::setFlash('success', admin::lang('create'));
                header("location: " . admin::link_());
            }
        }
        ##EDIT##
        function edit($id){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            admin::checkRole("UPDT");
            if($_to == "001"){
                $data = db::data_record("role","id",$id);
                include_once $var['v_display_path'] . '/default/' .route::controller(). '/dsp_form.php';
                exit;
            }
            if($_to == "002"){

                // edit
                db::update('role',
                [
                    'name'              => $name,
                    'updated_by'        => $var['auth']['id'],
                    'updated_at'        => $now
                ],'id',$id);

                if( isset($p_acc) AND count($p_acc) > 0 )
                {
                    db::delete('role_detail','id_role',$id);
                    foreach ($p_acc as $kacc => $vacc)
                    {
                        if( count($vacc) > 0 )
                        {
                            foreach ($vacc as $krole => $vrole)
                            {
                                $_id = $krole.rand(50, 1000).date("dmYHis");
                                db::insert('role_detail',
                                    [
                                    'id'                => $_id,
                                    'id_role'           => $id,
                                    'page'              => $kacc,
                                    'role'              => $vrole
                                ]);
                            }
                        }
                    }
                }

                flasher::setFlash('success', admin::lang('update'));
                header("location: " . admin::link_());
            }
        }
        ##DELETE##
        function delete($idd=null){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v; //harus ada di fungsi apapun
            admin::checkRole("DEL");
            $_to = $idd == null ? $_to : $idd;
            if($_to == "001"){
                $items  = implode("','", $p_del);
                $sql    = "SELECT id, name as title FROM ".$var['table']['role']." WHERE id IN ('". $items ."')";
                db::query($sql, $rs['row'], $nr['row']);
            
                include_once $var['path'] . "/app/views/template/dsp_delete.php";
            }
            if($_to == "002"){
                if($p_id)$delid  = implode("','", $p_id);
                db::delete('role','id',$id);
                db::delete('role_detail','id_role',$id);

                flasher::setFlash('success', admin::lang('delete'));
                header("location: " . admin::link_());
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
            $sql = "UPDATE ".$var['table']['role']."
            SET status = '$statusnya'
            WHERE id = '$id'";
            db::execute($sql);
            header("location: " . admin::link_());
            // return redirect()->route('slider')->with('create', 'Status berhasil diubah');
        }
    }