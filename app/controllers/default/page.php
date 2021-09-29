<?php

    class page extends controller
    {
        private $db;
        // public $table = "aa";
        public static $table = "page";

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
            $sql = "SELECT * FROM " . $var['table'][self::$table] . " $v ORDER BY reorder ASC";

            list($query,$limit,$jumlahdatasql,$awalData,$halamanaktif) = admin::pagination($sql,$pagination,$show_all,$halamanaktif);
            db::query($query,$rs['sql'],$nr['sql']);
            while($row = db::fetch($rs['sql'])){
                $row['tobe'] = ucwords($row['tobe']);
                $results[] = $row;
            }
            $pagination = ($nr['sql'] > 0) ? $nr['sql'] : $pagination;

            $status = true;
            $vocab = ['name','tobe'];
            $sorted = 1;
            // $results = db::all_data("self::$table");
            include_once $var['path'] . "/app/views/template/dsp_list.php";
        }
        ##ADD##
        function add(){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            admin::setFILES();
            admin::checkRole("CRT");
            if($_to == "001"){
                valid::getData($data);
                $rs['category'] = db::data_record_select("id,name","page","tobe","parent","Order By created_at");
                include_once $var['v_display_path'] . '/default/' .route::controller(). '/dsp_form.php';
                exit;
            }
            if($_to == "002"){
                valid::unsetValidate();
                valid::setData();
                if($setup == 'internal') {
                    valid::setValidate([
                        'name'      => 'required',
                        'target'    => 'required',
                        'publish'   => 'required',
                        'setup'     => 'required'
                    ]);
                    if($tobe == 'child'){
                        valid::setValidate([
                            'file'  => 'required',
                            'category'  => 'required'
                        ]);
                    }
                }else{
                    if($tobe == 'child'){
                        valid::setValidate([
                            'category'  => 'required',
                            'name'      => 'required',
                            'setup'     => 'required',
                            'link'      => 'required',
                        ]);
                    }
                    else{
                       valid::setValidate([
                            'name'      => 'required'
                        ]); 
                    }
                }
                if(valid::checkError()){
                    header("location: ". admin::link_() . '/add');
                    exit;
                }
                $id     = rand(1, 100).date("dmYHis");
                $urut   = db::data_where("max(reorder)","page","1=1");
                $urut   = ($urut==0) ? 1 : $urut+1;
                $det    = implode(" ",$name);
                $alias  = strtolower(str_replace(" ", "",$name));
                if(isset($det[2])){if(strtolower($det[1]) == 'detail'){$alias=admin::alias($name);}}

                if($setup == "internal") {
                    $link = '';
                }else if($setup == "eksternal"){
                    $target = '';
                    $publish = '';
                    $file_name = '';
                }
                if($file_size > 0){
                    $data['file'] = file::save_file('file', $var['html_path']."/",$alias);
                }
                db::insert('page',
                [
                    'id'                => $id,
                    'name'              => $name,
                    'category'          => $category,
                    'tobe'              => $tobe,
                    'alias'             => $alias,
                    'status'            => 'active',
                    'setup'             => $setup,
                    'target'            => $target,
                    'publish'           => $publish,
                    'file_name'         => $file_name,
                    'link'              => $link,
                    'reorder'           => $urut,
                    'created_by'        => $var['auth']['id'],
                    'created_at'        => $now
                ]);
                self::split($alias.'.html');
                flasher::setFlash('success', admin::lang('create'));
                header("location: " . admin::link_());
            }
        }
        ##EDIT##
        function edit($id){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            admin::checkRole("UPDT");
            if($_to == "001"){
                $data = db::data_record("page","id",$id);
                $rs['category'] = db::data_record_select("id,name","page","tobe","parent","Order By created_at");
                include_once $var['v_display_path'] . '/default/' .route::controller(). '/dsp_form.php';
                exit;
            }
            if($_to == "002"){
                valid::unsetValidate();
                valid::setData();
                if($setup == 'internal') {
                    valid::setValidate([
                        'name' => 'required',
                        'tobe'  => 'required',
                        'target' => 'required',
                        'publish' => 'required',
                        'setup' => 'required',
                    ]);
                    if($tobe == 'child'){
                        valid::setValidate([
                            'category'  => 'required'
                        ]);
                    }
                }else{
                    valid::setValidate([
                        'name' => 'required',
                        'tobe' => 'required',
                        'setup' => 'required',
                        'link' => 'required',
                    ]);
                }
                if(valid::checkError()){
                    header("location: ". admin::link_() . '/edit/'.$id);
                    exit;
                }
                $urut   = db::data_where("max(reorder)","page","1=1");
                $urut   = ($urut==0) ? 1 : $urut+1;
                $alias  = admin::alias($name);
                if($setup == "internal") {
                    $link = '';
                }
//                else if($setup == "eksternal"){
//                    $target = '';
//                    $publish = '';
//                }
                db::update('page',
                [
                    'name'              => $name,
                    'alias'             => $alias,
                    'tobe'              => $tobe,
                    'category'          => $category,
                    'status'            => 'active',
                    'setup'             => $setup,
                    'target'            => $target,
                    'publish'           => $publish,
                    'link'              => $link,
                    'reorder'           => $urut,
                    'updated_by'        => $var['auth']['id'],
                    'updated_at'        => $now
                ],'id',$id);

                flasher::setFlash('success', admin::lang('update'));
                header("location: " . admin::link_());            }
        }
        ##DELETE##
        function delete($idd=null){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v; //harus ada di fungsi apapun
            admin::checkRole("DEL");
            $_to = $idd == null ? $_to : $idd;
            if($_to == "001"){
                $items  = implode("','", $p_del);
                $sql    = "SELECT id, name as title FROM ".$var['table']['page']." WHERE id IN ('". $items ."')";
                db::query($sql, $rs['row'], $nr['row']);
            
                include_once $var['path'] . "/app/views/template/dsp_delete.php";
            }
            if($_to == "002"){
                if($p_id)$delid  = implode("','", $p_id);
                
                db::delete('page','id',$delid);
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
            $sql = "UPDATE ".$var['table']['page']."
			SET status = '$statusnya'
            WHERE id = '$id'";
            db::execute($sql);
            header("location: " . admin::link_());
            // return redirect()->route('slider')->with('create', 'Status berhasil diubah');
        }
        function split($file){
            global $var;
            if(!file_exists($var['html_path']))
            {
                file::create_dir($var['html_path']);
            }
            file::create_dir($var['public_path']);
            file::create_dir($var['public_path'].'/assets');
            file::create_dir($var['public_path'].'/dinamis');
            file::create_dir($var['public_path'].'/dinamis/code');
            file::create_dir($var['public_path'].'/dinamis/loop');
            file::create_dir($var['public_path'].'/dinamis/nav');
            file::create_dir($var['public_path'].'/statis');
            file::create_dir($var['public_path'].'/statis/main');
            file::create_dir($var['public_path'].'/statis/page');
//            file::create_file($var['public_path'].'/.htaccess');
            $file_path = $var['html_path'] . '/' . $file;

            split::parsingStatis($file_path,$file);
//            split::parsingDinamis($file_path,$file,'code');
            split::parsingDinamis($file_path,$file,'loop');
            split::parsingDinamis($file_path,$file,'nav');
        }
        ##REORDER##
        function reorder(){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            $count = 0;
            if(count($reorder) > 0)
            {
                foreach ($reorder as $idval) { $count ++;
                    $sql = "UPDATE ".$var['table']['page']." SET reorder = " . $count . " WHERE id = '" . $idval ."'";
                    echo $sql;
                    db::execute($sql);
                }
                exit;
                echo true;
                exit;
            }
            echo false;
            exit;
        }
    }