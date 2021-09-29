<?php

    class akun_pendukung extends controller
    {
        private $db;
        public static $table = "akun_pendukung";

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
            while($row = db::fetch($rs['sql'])) {
                $row['media_sosial'] = '<center><a title="edit media sosial" href="'.admin::getLink().'/akun_pendukung/sosmed/'.$row['id'].'"><i class="pe-7s-keypad" aria-hidden="true"></i></a></center>';
                $results[] = $row;
            }
            $pagination = ($nr['sql'] > 0) ? $nr['sql'] : 0;

            $status = true;
            $vocab = ['media_sosial','name'];
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
                    'name'  => 'required'
                ]);
                if(valid::checkError()){
                    header("location: ". admin::link_() . '/add');
                    exit;
                }
                $id = rand(1, 100).date("dmYHis");
                $alias  = admin::alias($name);
                $urut = db::data_where("max(reorder)",self::$table,"1=1");
                $urut = ($urut==0) ? 1 : $urut+1;
                for($i=0;$i<count($form_table);$i++){
                    $ids = rand(1, 100).date("dmYHis").'-ids';
                    $link[$i] = empty($link[$i]) ? '#' : $link[$i];
                    db::insert("sosmed_pendukung",
                    [
                        'id'                => $ids,
                        'id_akun_pendukung' => $id,
                        'id_sosmed'         => $form_table[$i],
                        'link'              => $link[$i],
                        'created_by'        => $var['auth']['id'],
                        'created_at'        => $now
                    ]);
                }
                db::insert(self::$table,
                [
                    'id'                => $id,
                    'image'             => $p_image,
                    'name'              => $name,
                    'content'           => $content,
                    'alias'             => $alias,
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
                    'name'  => 'required'
                ]);
                if(valid::checkError()){
                    header("location: ". admin::link_() . '/edit/'.$id);
                    exit;
                }
                $alias  = admin::alias($name);
                db::update(self::$table,
                [
                    'image'             => $p_image,
                    'name'              => $name,
                    'alias'             => $alias,
                    'content'           => $content,
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
                $sql    = "SELECT id, name as title FROM ".$var['table'][self::$table]." WHERE id IN ('". $items ."')";
                db::query($sql, $rs['row'], $nr['row']);
            
                include_once $var['path'] . "/app/views/template/dsp_delete.php";
            }
            if($_to == "002"){
                if($p_id)$delid  = implode("','", $p_id);

                $del = "DELETE FROM ". $var['table']['sosmed_pendukung'] ." WHERE `id_akun_pendukung` IN ('". $delid ."')";
                 db::execute($del);

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
        ##MEDIA SOSIAL##
        function sosmed($id){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            valid::unsetValidate();
            admin::checkRole("DSPL");
            $url = route::controller();
            $limit = "";
            $results = [];
            $refresh    = '/sosmed/'.$id;
            $add        = '/sosmed_add/'.$id;
            $edit       = '/sosmed_edit/';
            $delete     = '/sosmed_delete';
            $delete_id  = '/sosmed_delete&id='.$id;
            $show_all = isset($show_all) ? $show_all : 0;
            // view::pagination();
            $pagination = isset($pagination) ? $pagination : 10;
            
            $halamanaktif = (isset($halamanaktif)) ? $halamanaktif : 1;
            $sql = "SELECT a.*, b.*, c.title as media_sosial FROM " . $var['table'][self::$table] . " a
                LEFT JOIN ".$var['table']['sosmed_pendukung']." b ON (b.id_akun_pendukung=a.id) 
                LEFT JOIN ".$var['table']['list_sosial_media']." c ON (c.id=b.id_sosmed) 
                WHERE b.id_akun_pendukung = '".$id."' ORDER BY b.id_sosmed DESC";
            // echo $sql;exit;

            list($query,$limit,$jumlahdatasql,$awalData,$halamanaktif) = admin::pagination($sql,$pagination,$show_all,$halamanaktif);
            db::query($query,$rs['sql'],$nr['sql']);
            while($row = db::fetch($rs['sql'])) {
                $results[] = $row;
            }
            $pagination = ($nr['sql'] > 0) ? $nr['sql'] : 0;

            $status = true;
            $vocab = ['media_sosial','link'];
            $title = "media_sosial".' : '.db::data_where("name","akun_pendukung","id",$id);
            // $results = db::all_data("self::$table");
            include_once $var['path'] . "/app/views/template/custom/dsp_list.php";
        }
        ##ADD MEDIA SOSIAL##
        function sosmed_add($id){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            admin::checkRole("CRT");
            if($_to == "001"){
                valid::getData($data);
                $rs['id_medsos'] = db::data_record_select("id,title as name","list_sosial_media","1=1 ORDER BY created_at ASC");
                include_once $var['v_display_path'] . '/' .route::controller(). '/dsp_form_list_medsos.php';
                exit;
            }
            if($_to == "002"){
                valid::unsetValidate();
                valid::setData();
                // valid::setValidate([
                //     'name'  => 'required'
                // ]);
                // if(valid::checkError()){
                //     header("location: ". admin::link_() . '/add');
                //     exit;
                // }
                $ids = rand(1, 100).date("dmYHis").'-ids';
                $link = empty($link) ? '#' : $link;
                db::insert("sosmed_pendukung",
                [
                    'id'                => $ids,
                    'id_akun_pendukung' => $id,
                    'id_sosmed'         => $social_media,
                    'link'              => $link,
                    'created_by'        => $var['auth']['id'],
                    'created_at'        => $now
                ]);
                flasher::setFlash('success', admin::lang('create'));
                $id_akunpendukung = db::data_where("id_akun_pendukung","sosmed_pendukung","id",$ids);
                header("location: " . $var['app_url'] . '/' . route::controller().'/sosmed/'.$id_akunpendukung);
            }
        }
        ##EDIT MEDIA SOSIAL##
        function sosmed_edit($id){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            admin::checkRole("UPDT");
            if($_to == "001"){
                // $id_pendukung = db::data_where("id_akun_pendukung","sosmed_pendukung","id",$id);
                $data = db::data_record("sosmed_pendukung","id",$id);
                $rs['id_medsos'] = db::data_record_select("id,title as name","list_sosial_media","1=1 ORDER BY created_at ASC");
                include_once $var['v_display_path'] . '/' .route::controller(). '/dsp_form_list_medsos.php';
                exit;
            }
            if($_to == "002"){
                valid::unsetValidate();
                valid::setData();
                // valid::setValidate([
                //     'name'  => 'required'
                // ]);
                if(valid::checkError()){
                    header("location: ". admin::link_() . '/edit/'.$id);
                    exit;
                }
                $link = empty($link) ? '#' : $link;
                db::update("sosmed_pendukung",
                [
                    'id_sosmed'         => $social_media,
                    'link'              => $link,
                    'updated_by'        => $var['auth']['id'],
                    'updated_at'        => $now
                ],'id',$id);
                $id_akunpendukung = db::data_where("id_akun_pendukung","sosmed_pendukung","id",$id);
                flasher::setFlash('success', admin::lang('update'));
                header("location: " . $var['app_url'] . '/' . route::controller().'/sosmed/'.$id_akunpendukung);
            }
        }
        ##DELETE MEDIA SOSIAL##
        function sosmed_delete($idd=null,$id=null){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v; //harus ada di fungsi apapun
            admin::checkRole("DEL");
            $_to = $idd == null ? $_to : $idd;
            if($_to == "001"){
                $items  = implode("','", $p_del);
                $sql    = "SELECT id, id as title FROM ".$var['table']["sosmed_pendukung"]." WHERE id IN ('". $items ."')";
                db::query($sql, $rs['row'], $nr['row']);
            
                include_once $var['path'] . "/app/views/template/custom/dsp_delete.php";
            }
            if($_to == "002"){
                if($p_id)$delid  = implode("','", $p_id);
                
                db::delete("sosmed_pendukung",'id',$delid);
                flasher::setFlash('success', admin::lang('delete'));
                header("location: " . $var['app_url'] . '/' . route::controller().'/sosmed/'.$id);
            }
        }
    }