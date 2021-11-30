<?php 
    class admin
    {
        public static $lang = 'id';
        public static $page;
        public static $ref1;
        public static $detail;

        public static function checkRole($roles,$kode="p")
        {
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            $url    = route::parseURL();
            $v      = ($url[0] == 'default') ? $url[1] : $url[0];
            if(!strlen(@$_SESSION[$var['session']]))
            {
                header("location: " . $var['app_url']);
                exit;
            }
            $id     = $var['auth']['id'];
            $me     = unserialize(base64_decode($_SESSION[$var['session']]));
            
            $id_role = db::data_where("id_role","user","id",$id);
            $sql    = "SELECT * FROM ".$var['table']['role_detail']." WHERE role='".$roles."' AND page='".$v."' AND id_role='".$id_role."' LIMIT 1";
//            echo $sql;exit;
            db::query($sql, $rs['sql'],$nr['sql']);
            if($nr['sql'] > 0 OR $var['auth']['id'] == 'a1'){
                return true;
            }else{
                if($kode == "p") header("location: ". $var['app_url'] . '/denied');ob_flush();
                if($kode == "b") return false;
            }
            exit;
        }
        public static function checkRoleSidebar($mod,$type='item')
        {
            global $var;foreach ($GLOBALS as $k=>$v) $$k=$v;
            $rs['getRoleDetPage'] = db::data_record_select("page", "role_detail", "id_role", $var['auth']['id_role'], " AND role='DSPL'");
            while ($row = db::fetch($rs['getRoleDetPage'])) $role_det_page[] = $row['page'];
            if($type == 'item') {
                if (isset($role_det_page)) {
                    if (in_array($mod, $role_det_page)) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
            if($type == 'priv'){
                if(isset($mod)) {
                    $rs['priv_item'] = db::data_record_select("alias", "privileges_item", "id_priv", $mod);
                    while ($row = db::fetch($rs['priv_item']))
                    {
                        $priv_item[] = $row['alias'];
                        if(isset($role_det_page)) {
                            if (in_array($row['alias'], $role_det_page)) {
                                return true;
                            }
                            else{
                                return false;
                            }
                        }
                    }
                }
            }
        }
        public static function getSession()
        {
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            return $var['auth'] = unserialize(base64_decode($_SESSION[$var['session']]));
        } 
        public static function get_lib(){
            global $var;
            $numargs = func_num_args();
            $args = func_get_args();
            for ($i = 0; $i < $numargs; $i++) {
                $libfile = "$args[$i].php";
                include_once $var['path'] ."/library/$libfile";
            }
        }
        public static function link_()
        {
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            $url = route::parseURL();
            $v = ($url[0] == 'default') ? $url[1] . '.dev' : $url[0];
            $link_ = $var['app_url'] . '/' . $v;
            return $link_;
        }
        public static function getLink()
        {
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            $link = $var['app_url'];
            return $link;
        }
        public static function debug($param, $exit = 0)
        {
            global $var;
            if ($var['debug']):
                echo "<pre>";
                print_r($param);
                echo "</pre>";
            endif;
            if ($exit):
                exit;
            endif;
        }
        
        public static function global()
        {
            global $var;
            return $var;
        }
        
        public static function limit_text($text, $limit)
        {
            if (str_word_count($text, 0) > $limit) {
                $words = str_word_count($text, 2);
                $pos = array_keys($words);
                $text = substr($text, 0, $pos[$limit]) . '...';
            }
            return $text;
        }
        
        public static function lang($param)
        {
            $vocab = db::data_where('name','vocab',"status='active' AND alias='$param'");
            // $vocab = "a";
            // echo $param . ' ' . $vocab;exit;
            return $vocab;
        }
        
        public static function set_default(&$var, $default = '')
        {
            if (!isset($var) || $var == ''):
                $var = $default;
            endif;
        }
        
        public static function _global(){
            global $var;
            if (!ini_get('register_globals')) {
                foreach($_FILES as $key => $value){$GLOBALS[$key]=$value;}
                foreach($_ENV as $key => $value){$GLOBALS[$key]=$value;}
                foreach($_GET as $key => $value){$GLOBALS[$key]=$value;}
                foreach($_POST as $key => $value){$GLOBALS[$key]=$value;}
                foreach($_COOKIE as $key => $value){$GLOBALS[$key]=$value;}
                foreach($_SERVER as $key => $value){$GLOBALS[$key]=$value;}
                // while(list($key,$value)=each($_ENV)) $GLOBALS[$key]=$value;
                // while(list($key,$value)=each($_GET)) 
                // {
                //     $GLOBALS[$key]=$value;
                // }
                // while(list($key,$value)=each($_POST))
                // {
                //     $GLOBALS[$key]=$value;     
                // }
                // while(list($key,$value)=each($_COOKIE)) $GLOBALS[$key]=$value;
                // while(list($key,$value)=each($_SERVER)) $GLOBALS[$key]=$value;
                // while(list($key,$value)=@each($_SESSION)) $GLOBALS[$key]=$value;
                foreach($_FILES as $key => $value){
                    $GLOBALS[$key]=$_FILES[$key]['tmp_name'];
                    foreach($value as $ext => $value2){
                        $key2 = $key . '_' . $ext;
                        $GLOBALS[$key2] = $value2;
                    }
                }
            }
        }
        
        public static function _post()
        {
            global $var,$GLOBALS;
            foreach($GLOBALS as $k=> $v) $$k=$v;
            // echo $var[''];
            // include $link_;
        }
        public static function pagination($query,$pagination,$show_all,$halamanaktif='')
        {
            global $var,$GLOBALS;
            // $halamanaktif = (isset($halamanaktif)) ? $halamanaktif : 1 ;
            $awalData = ($pagination * $halamanaktif) - $pagination;
            db::query($query,$rs['query'],$nr['query']);
            $jumlahdatasql = $nr['query'];
            $limit = ($pagination <= $jumlahdatasql) ? " LIMIT $awalData, $pagination" : "" ;
            if($show_all == 1){$sql=$query;}else{$sql = $query . $limit;}
            
            return array($sql,$limit,$jumlahdatasql,$awalData,$halamanaktif);
        }
        public static function get_pagination($jumlahdatasql,$pagination,$halamanaktif,$show_all)
        {
            $total_records = $jumlahdatasql;
            $limit = $pagination;
            $page = $halamanaktif;
            if($total_records){
                echo '<nav id="setPagination" aria-label="Page navigation example">';
                $jumlah_page    = ceil($total_records / $pagination);
                $jumlah_number  = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
                $start_number   = ($page > $jumlah_number)? $page - $jumlah_number : 1;
                $end_number     = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
                if($page == $end_number){
                    $jumlahlisttable = $limit - ($jumlah_page * $limit - $jumlahdatasql);
                }else{
                    $jumlahlisttable = $limit;
                }
                echo '<ul class="pagination">';
                echo '<div class="col-sm-12 row">';
                echo '<div class="col-sm-9 right">';
                if($jumlahdatasql > $pagination && $show_all == 0){
                    if($page == 1){
                        echo '<li class="page-item disabled"><a class="page-link" href="#">First</a></li>';
                        echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
                    } else {
                        $link_prev = ($page > 1)? $page - 1 : 1;
                        echo '<li class="page-item halaman" id="1"><a class="page-link" href="#">First</a></li>';
                        echo '<li class="page-item halaman" id="'.$link_prev.'"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
                    }

                    for($i = $start_number; $i <= $end_number; $i++){
                        $link_active = ($page == $i)? ' active' : '';
                        echo '<li class="page-item halaman '.$link_active.'" id="'.$i.'"><a class="page-link" href="#">'.$i.'</a></li>';
                    }

                    if($page == $jumlah_page){
                        echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
                        echo '<li class="page-item disabled"><a class="page-link" href="#">Last</a></li>';
                    }else {
                        $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
                        echo '<li class="page-item halaman" id="'.$link_next.'"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
                        echo '<li class="page-item halaman" id="'.$jumlah_page.'"><a class="page-link" href="#">Last</a></li>';
                    }
                    echo '<a class="btn btn-primary mt-0" id="show_all" style="height: 35px;padding: 6px 10px;border-radius: 2px;background: #fff;color: #3f6ad8;/* border: 1px; */font-weight: 500;">Show All</a>';
                }
                echo '</div>';
                if($show_all == 1){$jumlahlisttable = $jumlahdatasql;}
                echo '<input type="hidden" class="showAll" data-show="'.$show_all.'">';
                echo '<div class="col-sm-3 datatable mb-0">'.(($jumlahdatasql == 0) ? 0 : $jumlahlisttable).' From '.$jumlahdatasql.'</div>';
                echo '</ul></nav>';
            }
        }
        public static function alias($string)
        {
            return strtolower(str_replace(' ', '-', str_replace('&', '', $string)));
        }
        public static function isset($string)
        {
            $isset = (isset($string)) ? $string : '';
            return $isset;
        }
        public static function redirect($uri){
            // echo $uri;exit;
            header("location: " . $uri);
            // print("<script>window.location.href='{$uri}'</script>");
            // exit();
        }
        public static function specialchars($v)
        {
            return isset($v) ? htmlspecialchars(stripslashes($v)) : "";
        }

        public static function setFILES()
        {
            global $var;
            // while(list($key,$value)=each($_FILES)) $GLOBALS[$key]=$value;
            foreach($_FILES as $key => $value){
                $GLOBALS[$key]=$_FILES[$key]['tmp_name'];
                foreach($value as $ext => $value2){
                    $key2 = $key . '_' . $ext;
                    $GLOBALS[$key2] = $value2;
                }
            }
        }

        public static function get_library()
        {
            global $var;
            $numargs    = func_num_args();
            $args       = func_get_args();
            for ($i = 0; $i < $numargs; $i++) {
                include_once $var['library'] ."/".$args[$i].".php";
            }
        }

        public static function get_data_type_table()
        {
            $data = [
                ['id'=>'bigint','name'=>'bigint'],
                ['id'=>'binary','name'=>'binary'],
                ['id'=>'bit','name'=>'bit'],
                ['id'=>'blob','name'=>'blob'],
                ['id'=>'bool','name'=>'bool'],
                ['id'=>'boolean','name'=>'boolean'],
                ['id'=>'char','name'=>'char'],
                ['id'=>'date','name'=>'date'],
                ['id'=>'datetime','name'=>'datetime'],
                ['id'=>'decimal','name'=>'decimal'],
                ['id'=>'double','name'=>'double'],
                ['id'=>'enum','name'=>'enum'],
                ['id'=>'float','name'=>'float'],
                ['id'=>'int','name'=>'int'],
                ['id'=>'longblob','name'=>'longblob'],
                ['id'=>'longtext','name'=>'longtext'],
                ['id'=>'mediumblob','name'=>'mediumblob'],
                ['id'=>'mediumint','name'=>'mediumint'],
                ['id'=>'mediumtext','name'=>'mediumtext'],
                ['id'=>'numeric','name'=>'numeric'],
                ['id'=>'real','name'=>'real'],
                ['id'=>'set','name'=>'set'],
                ['id'=>'smallint','name'=>'smallint'],
                ['id'=>'text','name'=>'text'],
                ['id'=>'time','name'=>'time'],
                ['id'=>'timestamp','name'=>'timestamp'],
                ['id'=>'tinyblob','name'=>'tinyblob'],
                ['id'=>'tinyint','name'=>'tinyint'],
                ['id'=>'tinytext','name'=>'tinytext'],
                ['id'=>'varbinary','name'=>'varbinary'],
                ['id'=>'varchar','name'=>'varchar'],
                ['id'=>'year','name'=>'year'],
            ];
            return $data;
        }
        /*===== SETTING COMPONENT LIST =====*/
        public static function getComponentList()
        {
            $items = [
                ['id'=>'inputtext','name'=>'Input text'],
                ['id'=>'radiobutton','name'=>'Radio Button'],
                ['id'=>'select2','name'=>'Select 2'],
                ['id'=>'texteditor','name'=>'Text Editor'],
                ['id'=>'textarea','name'=>'Textarea'],
                ['id'=>'inputupload','name'=>'Input Upload'],
                ['id'=>'inputuploadfilemedia','name'=>'Input Upload [Filemedia]']
            ];
            return $items;
        }
        /*===== SET DATA DUMMY CATEGORY PAGE . DEV =====*/
        public static function getCategoryPage()
        {
            $items = [
                ['id'=>'C-001','name'=>'Alone'],
                ['id'=>'C-002','name'=>'Tentang Kami'],
                ['id'=>'C-003','name'=>'Program Studi'],
                ['id'=>'C-004','name'=>'Publikasi'],
            ];
            return $items;
        }

        public static function get_json_record($ct)
        {
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            while($row = db::fetch($ct)) $results[] = $row;
            return $results;
        }
        public static function add_table_default()
        {
            $sql = "CREATE TABLE '".$table."' (  
                  `id` VARCHAR(65) NOT NULL,
                  `judul` TEXT,
                  `alias` TEXT,
                  `reorder` INT(11),
                  `status` ENUM('active','inactive'),
                  `created_at` DATETIME,
                  `created_by` VARCHAR(65),
                  `updated_at` DATETIME,
                  `updated_by` VARCHAR(65),
                  PRIMARY KEY (`id`)
                );";
        }

        public static function pengutipan($param)
        {
            $fields = "\$" . str_replace(",", ",\$", $param);
            eval("global $fields;");
            $arr = explode(",", $fields);
            while (list($k, $v) = each($arr)){
                eval("$v = addslashes($v);");
            }
        }
        /*===== FORMAT DATE =====*/
        public static function format_date($date, $country, $long = 'N')
        {
            if ($long == 'N'):
                $format = "l, F d Y";
            elseif ($long == 'A'):
                $format = "d F Y";
            elseif ($long == 'B'):
                $format = "F d ,Y";
            elseif ($long == 'C'):
                $format = "F d";
            elseif ($long == 'D'):
                $format = "Y-m-d";
            elseif ($long == 'E'):
                $format = "d/m/Y";
            elseif ($long == 'F'):
                $format = "Y-m";
            elseif ($long == 'G'):
                $format = "d";
            else:
                $format = "l, d F Y";
            endif;
            $out = date($format, strtotime($date));
            if ($country == 'id'):
                $eng = array("/January/", "/February/", "/March/", "/April/", "/May/", "/June/", "/July/", "/August/", "/September/", "/October/", "/November/", "/December/");
                $ina = array("Januari", "Pebruari", "Maret", "April", "Mei","Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember");
                $out = preg_replace($eng, $ina, $out);
                if ($long != 'N'):
                    $eng = array("/Monday/", "/Tuesday/", "/Wednesday/", "/Thursday/", "/Friday/", "/Saturday/", "/Sunday/");
                    $ina = array("Senin", "Selasa", "Rabu", "Kamis", "Jum'at","Sabtu", "Minggu");
                    $out = preg_replace($eng, $ina, $out);
                endif;
            endif;
            return $out;
        }
        public static function tgl_indo($tanggal){
            // $ret = date_format($tanggal, "Y-m-d");
            $date =  date("Y-m-d", strtotime($tanggal));
            $bulan = array(1 => 'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
            $split = explode('-', $date);
            return $split[2] . ' ' . $bulan[ (int)$split[1]] . ' ' . $split[0];
        }

        public static function removeElementsByTagName($tagName, $document) {
            $nodeList = $document->getElementsByTagName($tagName);
            for ($nodeIdx = $nodeList->length; --$nodeIdx >= 0; ) {
                $node = $nodeList->item($nodeIdx);
                $node->parentNode->removeChild($node);
            }
        }

        // array search indexValue
        public static function array_filter_by_value($my_array, $index, $value)
        {
            if(is_array($my_array) && count($my_array)>0)
            {
                foreach(array_keys($my_array) as $key){
                    $temp[$key] = $my_array[$key][$index];

                    if ($temp[$key] == $value){
                        $new_array[] = $my_array[$key];
                    }
                }
            }else{
                $new_array = null;
            }
            return $new_array;
        }

        // array search indexValue
        public static function array_filter_by_value_not_same($my_array, $index, $value)
        {
            if(is_array($my_array) && count($my_array)>0)
            {
                foreach(array_keys($my_array) as $key){
                    $temp[$key] = $my_array[$key][$index];

                    if ($temp[$key] != $value){
                        $new_array[] = $my_array[$key];
                    }
                }
            }

            return $new_array;
        }

        // Shuffle Array
        function shuffleThis($list) {
            if (!is_array($list)) return $list;

            $keys = array_keys($list);
            shuffle($keys);
            $random = array();
            foreach ($keys as $key) {
                $random[$key] = $list[$key]; // CHANGE HERE that preserves the keys
            }
            return $random;
        }
        public static function strlimited($limit, $banyakdata)
        {
            $jumlah = strlen($limit) > $banyakdata ? ' ...' : '' ;
            $isi    = substr($limit, 0, $banyakdata) . $jumlah;
            return $isi;
        }
        public static function nullisslug($text){
            $result = $text ? $text : '-';
            return $result;
        }
        public static function changestar($text){
            $nama = explode(" ", $text);
            foreach($nama as $name){
                $namas[] = substr($name, 0, 1) . preg_replace('/[^@]/', '*', substr($name, 1));
            }
            return implode(" ", $namas);
        }
        
        public static function slugify($text)
        {
          // replace non letter or digits by -
          $text = preg_replace('~[^\pL\d]+~u', '-', $text);

          // transliterate
          $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

          // remove unwanted characters
          $text = preg_replace('~[^-\w]+~', '', $text);

          // trim
          $text = trim($text, '-');

          // remove duplicate -
          $text = preg_replace('~-+~', '-', $text);

          // lowercase
          $text = strtolower($text);

          if (empty($text)) {
            return 'n-a';
          }

          return $text;
        }
    }