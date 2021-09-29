<?php

    class privileges_item extends controller
    {
        private $db;
        // public $table = "aa";
        public static $table = "privileges_item";

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
            // $pagination = ($nr['sql'] > 0) ? $nr['sql'] : $pagination;

            $status = true;
            $vocab = ['name'];
            // $results = db::all_data("self::$table");
            include_once $var['path'] . "/app/views/template/dsp_list.php";
        }
        ##ADD##
        function add()
        {
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            admin::checkRole("CRT");
            if($_to == "001"){
                // $var['v_display_path'] . '/' .route::controller(). '/dsp_form.php'
                $rs['privileges'] = db::data_record_select("id,name","privileges");
                $rs['acc'] = db::data_record_select("id,name","privileges_acc", " 1=1 ORDER BY created_at");
                include_once $var['v_display_path'] . '/default/' .route::controller(). '/dsp_form.php';
                exit;
            }
            if($_to == "002"){
                $id = rand(1, 100).date("dmYHis");
                $checkbox = (isset($default)?"yes":"no");
                $alias  = admin::alias($name);
                $alias  = str_replace("-","_",$alias);
                $form_table = isset($form_table) ? $form_table : '';
                //create table to database
                self::create_tablename_in_tablefolder($alias);
                self::create_table_database($alias,$columnname,$form_table,$length,$default_table);

                // membuat file di controller
                privileges_item::createFile($alias,$checkbox,$form);
                $urut = db::data_where("max(reorder)","privileges_item","1=1");
                $urut = ($urut==0) ? 1 : $urut+1;
                $priv_acc = implode(",",$acc);

                db::insert('privileges_item',
                [
                    'id'                => $id,
                    'id_priv'           => $privileges,
                    'id_priv_acc'       => $priv_acc,
                    'name'              => $name,
                    'alias'             => $alias,
                    'status'            => 'active',
                    'reorder'           => $urut,
                    'defaults'           => $checkbox,
                    'created_by'        => $var['auth']['id'],
                    'created_at'        => $now
                ]);
                flasher::setFlash('success', admin::lang('create'));
                header("location: " . admin::link_());
            }
        }
        ##EDIT##
        function edit($id)
        {
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            admin::checkRole("UPDT");
            if($_to == "001"){
                $rs['privileges'] = db::data_record_select("id,name","privileges");
                $rs['acc'] = db::data_record_select("id,name","privileges_acc");
                $data = db::data_record("privileges_item","id",$id);
                $acc = db::data_record("privileges_item","id_priv_item",$id);
                $data['checkbox']   = ($data['defaults'] == "yes"?"defaults":null);
                include_once $var['v_display_path'] . '/default/' .route::controller(). '/dsp_form.php';
                exit;
            }
            if($_to == "002"){
                // edit
                $checkbox = (isset($default)?"yes":"no");
                $priv_acc = implode(",",$acc);
                $alias  = admin::alias($name);
                $alias  = str_replace("-","_",$alias);
                $data = db::data_record("privileges_item","id",$id);
                privileges_item::updateFile($data['alias'],$data['defaults'],$alias,$checkbox);
                // jika 
                db::update('privileges_item',
                [
                    'id_priv'           => $privileges,
                    'id_priv_acc'       => $priv_acc,
                    'name'              => $name,
                    'alias'             => $alias,
                    'defaults'           => $checkbox,
                    'updated_by'        => $var['auth']['id'],
                    'updated_at'        => $now
                ],'id',$id);

                flasher::setFlash('success', admin::lang('update'));
                header("location: " . admin::link_());            
            }
        }
        ##DELETE##
        function delete($idd=null)
        {
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v; //harus ada di fungsi apapun
            admin::checkRole("DEL");
            $_to = $idd == null ? $_to : $idd;
            if($_to == "001"){
                $items  = implode("','", $p_del);
                $sql    = "SELECT id, name as title FROM ".$var['table']['privileges_item']." WHERE id IN ('". $items ."')";
                db::query($sql, $rs['row'], $nr['row']);
                include_once $var['path'] . "/app/views/template/dsp_delete.php";
            }
            if($_to == "002"){
                if($p_id)$delid  = implode("','", $p_id);
                
                // delete folder and file
                $file = "SELECT alias, defaults as checkbox FROM ".$var['table']['privileges_item']." WHERE id IN ('". $delid ."')";
                db::query($file,$rs['row'],$nr['row']);
                while($row=db::fetch($rs['row'])) privileges_item::deleteFile($row['alias'],$row['checkbox']);

                db::delete('privileges_item','id',$delid);
                flasher::setFlash('success', admin::lang('delete'));
                header("location: " . admin::link_());
            }
        }
        ##STATUS##
        function status($id,$status)
        {
            global $var;
            // admin::cek_validasi();
            admin::checkRole("UPDT");
            $url = route::controller();
            if($status == 'active'){
                $statusnya = 'inactive';
            }
            elseif($status == 'inactive'){
                $statusnya = 'active';
            }
            $sql = "UPDATE ".$var['table']['privileges_item']."
            SET status = '$statusnya'
            WHERE id = '$id'";
            db::execute($sql);
            header("location: " . admin::link_());
            // return redirect()->route('slider')->with('create', 'Status berhasil diubah');
        }
        public static function createFile($alias, $checkbox,$form="")
        {
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v; //harus ada di fungsi apapun
            if($checkbox == 'yes'){
                $content = 'system';
                $cf = $var['controller_path'] ."/default/". $alias . ".php";
                $folderPath = $var['v_display_path'] . "/default/$alias/";
            }
            if($checkbox == 'no'){
                $content = 'master_data';
                $cf = $var['controller_path'] ."/". $alias . ".php";
                $folderPath = $var['v_display_path'] . "/$alias/";
            }

            // membuat file di controller
            if(!file_exists($cf))
            {
                $fp = fopen($cf,"wb");
                $contents = file_get_contents($var['app_path'] . '/privilege/'.$content.'.php');
                $contents = str_replace($content,$alias,$contents);
                fwrite($fp,$contents);
                fclose($fp);
            }

            // membuat folder untuk views
            if(!file_exists($folderPath)) {
                mkdir("$folderPath");
                chmod("$folderPath", 0755);
            }
            // membuat file dsp_form
            $file_dsp   = fopen($folderPath . 'dsp_form.php','wb');
            $cnt_dsp    = file_get_contents($var['app_path'] . '/privilege/dsp_template_form.php');
            fwrite($file_dsp, $cnt_dsp);
            fclose($file_dsp);

            if(count($form) > 0) {
                $file_path = $folderPath . 'dsp_form.php';
                self::form($form,$file_path);
            }
        }
        public static function deleteFile($alias,$checkbox)
        {
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            if($checkbox == 'yes'){
                $folderPath = $var['v_display_path'] . "/default/$alias/";
                $fp = $var['controller_path'] ."/default/". $alias . ".php";
            }
            if($checkbox == 'no'){
                $folderPath = $var['v_display_path'] . "/$alias/";
                $fp = $var['controller_path'] ."/". $alias . ".php";
            }

            // delete file in controller
            // echo $fp;exit;
            if(file_exists($fp)){
                unlink($fp);
            }

            // delete in views
            privileges_item::remove_dir($folderPath);
        }
        public static function updateFile($data_alias,$data_checkbox,$alias,$checkbox)
        {
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;

            if($checkbox == 'yes'){
                $folderPath = $var['v_display_path'] . "/default/";
                $filepath = $var['controller_path'] ."/default/";
            }
            if($checkbox == 'no'){
                $folderPath = $var['v_display_path'] . "/" ;
                $filepath = $var['controller_path'] ."/";
            }

            // -
            // LOGIC //
            // -
            if($data_alias != $alias AND $data_checkbox == $checkbox){
                // rename
                $filenew = $filepath . $alias . '.php';
                $fileold = $filepath . $data_alias . '.php';
                rename($fileold, $filenew);

                $foldernew = $folderPath . $alias . "/";
                $folderold = $folderPath . $data_alias . "/";
                // echo $folderold;exit;
                rename($folderold, $foldernew);
            }
            // exit;
            if($data_checkbox != $checkbox AND $data_alias == $alias){
                // cut file
                $filepathdest = ($data_checkbox == 'yes') ? $var['controller_path'] . "/default/" : $var['controller_path'] ."/";
                $filesource     = $filepathdest . $alias . ".php";
                $filedest       = $filepath . $alias . ".php";
                copy($filesource, $filedest);
                unlink($filesource);

                // cut folder
                $folderpathdest = ($data_checkbox == 'yes') ? $var['v_display_path'] . "/default/" : $var['v_display_path'] ."/";
                $foldersource   = $folderpathdest . $alias . "/";
                $folderdest     = $folderPath . $alias . "/";
                // echo $foldersource . "</br>" . $folderdest;exit;
                // recurse_copy
                privileges_item::dir_copy($foldersource, $folderdest);
                privileges_item::remove_dir($foldersource);
                // echo $foldersource;exit;
            }
            if($data_checkbox != $checkbox AND $data_alias != $alias){
                // cut file and rename
                $filepathdest = ($data_checkbox == 'yes') ? $var['controller_path'] . "/default/" : $var['controller_path'] ."/";
                $filesource     = $filepathdest . $data_alias . ".php";
                $filedest       = $filepath . $alias . ".php";
                copy($filesource, $filedest);
                unlink($filesource);

                 // cut folder
                $folderpathdest = ($data_checkbox == 'yes') ? $var['v_display_path'] . "/default/" : $var['v_display_path'] ."/";
                $foldersource   = $folderpathdest . $data_alias . "/";
                $folderdest     = $folderPath . $alias . "/";
                // echo $foldersource . "</br>" . $folderdest;exit;
                // recurse_copy
                privileges_item::dir_copy($foldersource, $folderdest);
                privileges_item::remove_dir($foldersource);

            }
        }
        public static function dir_copy($src, $dst)
        {  
  
            // open the source directory 
            $dir = opendir($src);  
          
            // Make the destination directory if not exist 
            @mkdir($dst);  
          
            // Loop through the files in source directory 
            while( $file = readdir($dir) ) {  
          
                if (( $file != '.' ) && ( $file != '..' )) {  
                    if ( is_dir($src . '/' . $file) )  
                    {  
          
                        // Recursively calling custom copy function 
                        // for sub directory  
                        custom_copy($src . '/' . $file, $dst . '/' . $file);  
          
                    }  
                    else {  
                        copy($src . '/' . $file, $dst . '/' . $file);  
                    }  
                }  
            }  
          
            closedir($dir); 
        }
        public static function remove_dir($folderPath)
        {
            $dirPath = $folderPath;
            if (! file_exists($dirPath)) {
                echo $dirPath . " not found";
                // exit;
            }
            if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
                $dirPath .= '/';
            }
            $files = glob($dirPath . '*', GLOB_MARK);
            foreach ($files as $file) {
                if (is_dir($file)) {
                    self::deleteDir($file);
                } else {
                    unlink($file);
                }
            }
            rmdir($dirPath);
        }
        public static function form($form,$filePath)
        {
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            $file = $var['core_path'] . '/form.php';
            $file = file_get_contents($file);
            $arr2[] = "<?php ";
            $arr2[] = self::pregMatchForm("UP",$file); // UP
            // library component
            if(in_array("select2",$form)) $arr2[] = self::pregMatchForm("SELECT2LIB",$file);
            if(in_array("texteditor",$form)) $arr2[] = self::pregMatchForm("TEXTEDITORLIB",$file);
            if(in_array("inputupload",$form) || in_array("inputuploadfilemedia",$form)) $arr2[] = self::pregMatchForm("UPLOADLIB",$file);

            foreach($form as $forms) {
                //list component
//                if($forms == 'inputtext') $match = "INPUTTEXT";
//                if($forms == 'radiobutton') $match = "RADIOBUTTON";
//                if($forms == 'select2') $match = "SELECT2";
                $match = strtoupper($forms);
                preg_match_all("'//--FORM-".$match."--//(.*?)//--/FORM-".$match."--//'si", $file, $content);
                if (count($content[1]) > 0){
                    foreach ($content[1] as $key => $value) {
                        $arr = $value;
                    }
                }
                $arr2[] = $arr;
            }
            $arr2[] = self::pregMatchForm("DOWN",$file); // DOWN

            $arrtostr = implode("|",$arr2);
            $arrtostr = str_replace("|","",$arrtostr);
            //
            $file_dsp   = fopen($filePath,'wb');
            fwrite($file_dsp, $arrtostr);
            fclose($file_dsp);
        }
        public static function pregMatchForm($comp,$file)
        {
            preg_match_all("'//--FORM-".$comp."--//(.*?)//--/FORM-".$comp."--//'si", $file, $fm);

            if (count($fm[1]) > 0){
                foreach ($fm[1] as $key => $value) {
                    $arrForm = $value;
                }
            }
            return $arrForm;
        }
        public static function create_table_database($alias,$columnname,$form_table,$length,$default)
        {
            global $var,$table_name;foreach($GLOBALS as $k=> $v) $$k=$v;
            $sql = '';

//            self::create_tablename_in_tablefolder($alias);
            if($form_table){
                for($i=0;$i < count($columnname);$i++){
                    if($form_table[$i] == 'text' || $form_table[$i] == 'datetime'){
                        $sql .= $columnname[$i] . ' '.strtoupper($form_table[$i]) . ($i+1 == count($columnname) ? '' : ',');
                    }else{
                        $sql .= $columnname[$i] . ' '.strtoupper($form_table[$i]) . '('.$length[$i].')' . ($i+1 == count($columnname) ? '' : ',');
                    }
                }
            }
            if($default == true){
                $up     = "id VARCHAR(100) NOT NULL,
                            title VARCHAR(100),
                            alias VARCHAR(100),
                            content TEXT,";
                $down   = "status ENUM('active','inactive'),
                            reorder INT(11),
                            created_at DATETIME,
                            created_by VARCHAR(65),
                            updated_at DATETIME,
                            updated_by VARCHAR(65),
                            PRIMARY KEY (`id`)";
                $sql = "CREATE TABLE ".$table_name.$alias."(".$up.$sql.($form_table ? ',' : '').$down.")";
            }else{
                $sql = "CREATE TABLE ".$table_name.$alias."(".$sql.")";
            }
            db::execute($sql);
        }
        public static function create_tablename_in_tablefolder($alias){
            global $var,$table_name;foreach($GLOBALS as $k=> $v) $$k=$v;
            $library = $var['library'] . '/table.php';
            // add table to database
            $file = file_get_contents($library,true);
            $add_table = '$var["table"]["'.$alias.'"]' .   ' = $table_name . "' . $alias . '";'."\r\n";
            $add_table .= '//add-table//';
            $files = str_replace('//add-table//',$add_table,$file);
            $file_dsp   = fopen($library,'wb');
            fwrite($file_dsp, $files);
            fclose($file_dsp);
            //end add table to database
        }
    }