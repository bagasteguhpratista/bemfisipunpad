<?php

    class artikel extends controller
    {
        private $db;
        public static $table = "artikel";

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
                $row['title'] = admin::limit_text($row['title'],6);
                $row['publish_date'] = admin::format_date($row['publish_date'],"id","A");
                $row['kategori'] = db::data_where("name","kategori_artikel","id",$row['category']);
                $results[] = $row;
            }
            $pagination = ($nr['sql'] > 0) ? $nr['sql'] : 0;

            $status = true;
            $vocab = ['title','kategori','publish_date'];
            // $results = db::all_data("self::$table");
            include_once $var['path'] . "/app/views/template/dsp_list.php";
        }
        ##ADD##
        function add(){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            admin::checkRole("CRT");
            if($_to == "001"){
                valid::getData($data);
                $rs['category'] = db::data_record_select("id, name", "kategori_artikel");
                include_once $var['v_display_path'] . '/' .route::controller(). '/dsp_form.php';
                exit;
            }
            if($_to == "002"){
                valid::unsetValidate();
                valid::setData();
                valid::setValidate([
                    'title'  => 'required'
                ]);
                // echo json_encode($_POST);exit;
                if(valid::checkError()){
                    header("location: ". admin::link_() . '/add');
                    exit;
                }
                $id = rand(1, 100).date("dmYHis");
                $alias  = admin::alias($title);
                if($p_image_cover_size > 0){
                    $data['image_cover'] = file::compressImage('p_image_cover',$var['v_images_path']."/artikel/",50,'ic');
                }
                if($file_size > 0){
                    $data['file'] = file::save_file('file', $var['v_pdf_path']."/artikel/",$alias);
                }
                $writer = ($writer_n == 'show') ? $writer : '';
//                $passwordhash = md5(serialize($password));
                $urut = db::data_where("max(reorder)",self::$table,"1=1");
                // $content = htmlspecialchars($content);
                $urut = ($urut==0) ? 1 : $urut+1;
                db::insert(self::$table,
                [
                    'id'                => $id,
                    'title'             => $title,
                    'alias'             => $alias,
                    'content'           => $content,
                    'reference'         => $reference,
                    'category'          => $category,
                    'image_cover'       => $data['image_cover'],
                    'publish_date'      => $publish_date,
                    'writer'            => $writer,
                    'writer_n'          => $writer_n,
                    'tagline'           => $tagline,
                    'min_read'          => $min_read,
                    'file_pdf'          => $data['file'],
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
                $rs['category'] = db::data_record_select("id, name", "kategori_artikel");
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
                if(isset($p_image_cover_del)){
                    @unlink($var['v_images_path']."/artikel/". $data['image_cover']);
                    $data['image_cover'] = "";
                }
                if($p_image_cover_size > 0){
                    @unlink($var['v_images_path']."/artikel/". $data['image_cover']);
                    $data['image_cover'] = file::compressImage('p_image_cover',$var['v_images_path']."/artikel/",50,'ic');
                }
                $alias  = admin::alias($title);
                if(isset($file_del)){
                    @unlink($var['v_pdf_path']."/artikel/". $data['file_pdf']);
                    $data['file'] = "";
                }
                if($file_size > 0){
                    // @unlink($var['v_pdf_path']."/majalah/". $data['file_pdf']);
                    $data['file'] = file::save_file('file', $var['v_pdf_path']."/artikel/",$alias);
                }
                $writer = ($writer_n == 'show') ? $writer : '';
                // $content = htmlspecialchars($content);
                db::update(self::$table,
                [
                    'title'             => $title,
                    'alias'             => $alias,
                    'content'           => $content,
                    'category'          => $category,
                    'reference'         => $reference,
                    'image_cover'       => $data['image_cover'],
                    'publish_date'      => $publish_date,
                    'writer'            => $writer,
                    'writer_n'          => $writer_n,
                    'tagline'           => $tagline,
                    'min_read'          => $min_read,
                    'file_pdf'          => $data['file'],
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
                $sql = "SELECT image_cover,file_pdf FROM ". $var['table'][self::$table] ." WHERE id IN ('". $delid ."')";
                db::query($sql, $rs['row'], $nr['row']);
                while($row=db::fetch($rs['row'])){
                    @unlink($var['v_images_path']."/artikel/". $row['image_cover']);
                    @unlink($var['v_pdf_path']."/artikel/". $row['file_pdf']);
                }

                
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
        ##GET LIST ARTIKEL##
        function getListArtikel($alias)
        {
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v; //harus ada di fungsi apapun
            if($alias != 'all'){
                $category       = db::data_where("id","kategori_artikel","alias",$alias);
                $rs['data']     = db::data_record_select("*","artikel","category",$category);
            }else{
                $rs['data']     = db::data_record_select("*","artikel","1=1");
            }
            // $items = '';
            while($row=db::fetch($rs['data'])){
                $row['url'] = $var['http'].'/artikel/detail/'.$row['alias'];
                $row['image_cover'] = $var['v_images_url']."/artikel/". $row['image_cover'];
                // $row['publish_date'] = admin::format_date($item['publish_date'],'id','A');
                $row['category_alias'] = db::data_where("alias","kategori_artikel","id",$row['category']);
                $row['category_name'] = db::data_where("name","kategori_artikel","id",$row['category']);
                $items[] = $row;
            }
            $html = '';
            if(isset($items)){
                foreach($items as $item){
                    $html .= '<div class="mix card col-lg-3 col-md-4 col-sm-8 '. $item['category_alias'] .'" id="box-'.$item['category_alias'].'" data-i="'.$item['category_alias'].'">';
                    $html .= '<a href="'. $item['url'].'">';
                    $html .= '<div class="artikel-img-box"><img class="card-img-top" src="'. $item['image_cover'].'" alt="Card image cap"></div>';
                    $html .= '<div class="card-body">';
                    $html .= '<div class="cat-det">';
                    $html .= '<p class="category-article">'.strtoupper($item['category_name']).'</p>';
                    $html .= '<p class="read-article">'. $item['min_read'].' Min Read</p>';
                    $html .= '</div>';
                    $html .= '<h5 class="card-title judul">'. admin::limit_text($item['title'],10).'</h5>';
                    $html .= '</div></a></div>';
                }
            }
            echo $html;
            exit;
        }
    }