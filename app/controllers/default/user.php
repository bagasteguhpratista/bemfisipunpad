<?php

    class user extends controller
    {
        private $db;
        // public $table = "aa";

        public static $table = "user";

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
            while($row = db::fetch($rs['sql']))
            {
                if(admin::checkRole("CP","b")){
                    $row['role'] = db::data_where("name","role","id",$row['id_role']);
                    $row['change_password'] = '<center><a title="Change Password" href="'.admin::getLink().'/user.dev/change_password/'.$row['id'].'"><i class="pe-7s-key" ></i></a></center>';
                }
                $results[] = $row;
            }
            $pagination = ($nr['sql'] > 0) ? $nr['sql'] : $pagination;

            $status = true;
            $cp = null;
            if(admin::checkRole("CP","b")){$cp='change_password';$vocab=[$cp,'name','role'];}
            else{$vocab = ['name'];}
            
            // $results = db::all_data("self::$table");
            include_once $var['path'] . "/app/views/template/dsp_list.php";
        }
        ##ADD##
        function add(){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            admin::checkRole("CRT","p");
            if($_to == "001"){
                // $var['v_display_path'] . '/' .route::controller(). '/dsp_form.php'
                $rs['privileges'] = db::data_record_select("id,name","privileges");
                include_once $var['v_display_path'] . '/default/' .route::controller(). '/dsp_form.php';
                exit;
            }
            if($_to == "002"){
                valid::unsetValidate();
                valid::setData();
                valid::setValidate([
                    'name'  => 'required'
                ]);
                if(valid::checkError()){
                    header("location: ". admin::link_() . '/add');
                    exit;
                }
                $id = rand(1, 100).date("dmYHis");
                $urut = db::data_where("max(reorder)","user","1=1");
                $urut = ($urut==0) ? 1 : $urut+1;
                $alias  = admin::alias($name);
                $password = md5(serialize($password));
                if($p_image_size > 0){
                    $data['photo'] = file::save_image('p_image', $var['v_images_path']."/user/", 'u');
                }      
                db::insert('user',
                [
                    'id'                => $id,
                    'name'              => $name,
                    'username'          => $username,
                    'password'          => $password,
                    'email'             => $email,
                    'photo'             => $data['photo'],
                    'id_role'           => $p_role,
                    'status'            => 'active',
                    'reorder'           => $urut,
                    'created_by'        => $var['auth']['id'],
                    'created_at'        => $now
                ]);

                flasher::setFlash('success', admin::lang('create'));
                header("location: " . admin::link_());
            }
        }
        ##EDIT##
        function edit($id){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            admin::checkRole("UPDT");
            if($_to == "001"){
                $rs['privileges'] = db::data_record_select("id,name","privileges");
                $data = db::data_record("user","id",$id);
                include_once $var['v_display_path'] . '/default/' .route::controller(). '/dsp_form.php';
                exit;
            }
            if($_to == "002"){
                $urut = db::data_where("max(reorder)","user","1=1");
                $urut = ($urut==0) ? 1 : $urut+1;
                $alias  = admin::alias($name);
                $data = db::data_record("user","id",$id);
                if(isset($p_image_del)){
                    @unlink($var['v_images_path']."/user/". $data['photo']);
                    $data['photo'] = "";
                }
                if($p_image_size > 0){
                    @unlink($var['v_images_path']."/user/". $data['photo']);
                    $data['photo'] = file::save_image('p_image', $var['v_images_path']."/user/", 'u');
                }     

                db::update('user',
                [
                    'name'              => $name,
                    'username'          => $username,
                    'email'             => $email,
                    'photo'             => $data['photo'],
                    'id_role'           => $p_role,
                    'status'            => 'active',
                    'reorder'           => $urut,
                    'updated_by'        => $var['auth']['id'],
                    'updated_at'        => $now
                ],'id',$id);

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
                $sql    = "SELECT id, name as title FROM ".$var['table']['user']." WHERE id IN ('". $items ."')";
                db::query($sql, $rs['row'], $nr['row']);
            
                include_once $var['path'] . "/app/views/template/dsp_delete.php";
            }
            if($_to == "002"){
                 if($p_id)$delid  = implode("','", $p_id);
                // delete image
                $sql = "SELECT photo FROM ". $var['table']['user'] ." WHERE id IN ('". $delid ."')";
                db::query($sql, $rs['row'], $nr['row']);
                while($row=db::fetch($rs['row'])) @unlink($var['v_images_path']."/user/". $row['photo']);
                
                db::delete('user','id',$delid);
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
            $sql = "UPDATE ".$var['table']['user']."
            SET status = '$statusnya'
            WHERE id = '$id'";
            db::execute($sql);
            header("location: " . admin::link_());
            // return redirect()->route('slider')->with('create', 'Status berhasil diubah');
        }
        ##CHANGE PASSWORD##
        function change_password($id){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            admin::checkRole("CP","p");
            if($_to == "001"){
                // $var['v_display_path'] . '/' .route::controller(). '/dsp_form.php'
                $data = db::data_record(self::$table,"id",$id);
                include_once $var['v_display_path'] . '/default/' .route::controller(). '/dsp_form_cp.php';
                exit;
            }
            if($_to == "002"){
                valid::unsetValidate();
                valid::setData();
                // valid::setValidate([
                //     'name'  => 'required'
                // ]);
                if ($new_password != $re_password)
                {
                     valid::setValidate([
                        'new_password'  => 'not_same',
                        're_password'   => 'not_same'
                    ]);
                }
                if(valid::checkError()){
                    header("location: ". admin::link_() . '/change_password/'.$id);
                    exit;
                }
                if($new_password)
                {
                    $passwordhash = md5(serialize($new_password));
                    db::update('user',
                    [
                        'password'          => $passwordhash,
                    ],'id',$id);
                }
                flasher::setFlash('success', admin::lang('update'));
                header("location: " . admin::link_());
            }
        }
    }