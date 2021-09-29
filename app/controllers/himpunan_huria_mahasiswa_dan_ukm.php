<?php

    class himpunan_huria_mahasiswa_dan_ukm extends controller
    {
        private $db;
        public static $table = "himpunan_huria_mahasiswa_dan_ukm";

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
                $row['category'] = ($row['category'] == 'himpunan') ? 'Himpunan'  : 'UKM' ;
                $results[] = $row;
            }
            $pagination = ($nr['sql'] > 0) ? $nr['sql'] : 0;

            $status = true;
            $vocab = ['name','category'];
            // $results = db::all_data("self::$table");
            include_once $var['path'] . "/app/views/template/dsp_list.php";
        }
        ##ADD##
        function add(){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            admin::checkRole("CRT");
            if($_to == "001"){
                valid::getData($data);
                $rs['category'] = [['id'=>'himpunan','name'=>'Himpunan'],['id'=>'ukm','name'=>'UKM']];
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
//                $passwordhash = md5(serialize($password));
                // if($p_image_size > 0){
                //     $data['image'] = file::save_image('p_image', $var['v_images_path']."/hhu/", 'hu');
                // }  
                $alias  = admin::alias($name);
                $urut = db::data_where("max(reorder)",self::$table,"1=1");
                $urut = ($urut==0) ? 1 : $urut+1;
                $link_instagram = empty($link_instagram) ? '#' : $link_instagram;
                db::insert(self::$table,
                [
                    'id'                => $id,
                    'name'             => $name,
                    'content'           => $content,
                    'image'             => $p_image,
                    'link_instagram'    => $link_instagram,
                    'category'          => $category,
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
                $rs['category'] = [['id'=>'himpunan','name'=>'Himpunan'],['id'=>'ukm','name'=>'UKM']];
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
                $data = db::data_record(self::$table,"id",$id);
                // if(isset($p_image_del)){
                //     @unlink($var['v_images_path']."/hhu/". $data['image']);
                //     $data['image'] = "";
                // }
                // if($p_image_size > 0){
                //     @unlink($var['v_images_path']."/hhu/". $data['image']);
                //     $data['image'] = file::save_image('p_image', $var['v_images_path']."/hhu/", 'hu');
                // } 
                $link_instagram = empty($link_instagram) ? '#' : $link_instagram;
                db::update(self::$table,
                [
                    'name'             => $name,
                    'content'           => $content,
                    'image'             => $p_image,
                    'link_instagram'    => $link_instagram,
                    'category'          => $category,
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
                $sql    = "SELECT id, name as title FROM ".$var['table'][self::$table]." WHERE id IN ('". $items ."')";
                db::query($sql, $rs['row'], $nr['row']);
            
                include_once $var['path'] . "/app/views/template/dsp_delete.php";
            }
            if($_to == "002"){
                if($p_id)$delid  = implode("','", $p_id);
                
                // $sql = "SELECT image FROM ". $var['table'][self::$table] ." WHERE id IN ('". $delid ."')";
                // db::query($sql, $rs['row'], $nr['row']);
                // while($row=db::fetch($rs['row'])) @unlink($var['v_images_path']."/hhu/". $row['image']);
                
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