<?php
     class privilege{
        public static function init(){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            $sql = "SELECT * FROM ".$var['table']['privileges']." ORDER BY created_at";
            db::query($sql,$rs['sql'],$nr['sql']);
            while($priv = db::fetch($rs['sql'])){
                $sql_item = "SELECT * FROM ".$var['table']['privileges_item']." WHERE id_priv='".$priv['id']."' ORDER BY name ASC";
                db::query($sql_item,$rs['sql_item'],$nr['sql_item']);
                while($priv_item=db::fetch($rs['sql_item'])){
                    $acc = explode(',',$priv_item['id_priv_acc']);
                    foreach($acc as $accs){
                        $priv_item['acc'][] = $accs;
                    }
                    $priv['items'][] = $priv_item;
                }
                $privs[] = $priv;
            }
            $json =  json_encode($privs);
//            echo $json;exit;
            if($json){
                $file = $var['json_path'] ."/privilege.json";
                $fh   = fopen($file, 'w') or die("can't open file");
                fwrite($fh, $json);
                fclose($fh);
            }
            $datameta       = json_decode($json, true);
            $privilege      = $datameta;

            return $json;
            exit;
//            return array(
//                array(
//                    "ico"		=>"fa-user",
//                    "title"		=>"User",
//                    "items"=>array(
//                        array(
//                            "status"	=>true,
//                            "module"	=>"user",
//                            "title"		=>"User",
//                            "acc" 		=> array('View'=>'DSPL', 'Create'=>'CRT', 'Update'=>'UPDT', 'Delete'=>'DEL')
//                        ),
//                        array(
//                            "status"	=>true,
//                            "module"	=>"role",
//                            "title"		=>"Role",
//                            "acc" 		=> array('View'=>'DSPL', 'Create'=>'CRT', 'Update'=>'UPDT', 'Change Password'=>'CP')
//                        )
//                    )
//                ),
//                array(
//                    "ico"	=>"fa-list-alt",
//                    "title"	=>"dinamis",
//                    "items"=>array(
//                        array(
//                            "status"	=>true,
//                            "module"	=>"page",
//                            "title"		=>"Page",
//                            "acc" 		=> array('View'=>'DSPL', 'Create'=>'CRT', 'Update'=>'UPDT', 'Delete'=>'DEL')
//                        ),
//                    )
//                ),
//                array(
//                    "ico"	=>"fa fa-database",
//                    "title"	=>"Master Data",
//                    "items"=>array(
//                        array(
//                            "status" => true,
//                            "module" => "slider",
//                            "title" => "Slider",
//                            "acc" => array(
//                                "View" => "DSPL",
//                                "Create" => "CRT",
//                                "Update" => "UPDT",
//                                "Delete" => "DEL"
//                            )
//                        )
//                    )
//                ),
//                array(
//                    "ico"	=>"fa-cog",
//                    "title"	=>"System",
//                    "system" => "system",
//                    "items"=>array(
//                        array(
//                            "status" => true,
//                            "module" => "preference",
//                            "title" => "Preference",
//                            "acc" => array(
//                                "View" => "DSPL",
//                                "Update" => "UPDT",
//                            )
//                        ),array(
//                            "status"	=>true,
//                            "module"	=>"lang",
//                            "title"		=>"Language",
//                            "acc" 		=> array('View'=>'DSPL', 'Create'=>'CRT', 'Update'=>'UPDT', 'Delete'=>'DEL')
//                        ),array(
//                            "status"	=>true,
//                            "module"	=>"vocab",
//                            "title"		=>"Vocabulary",
//                            "acc" 		=> array('View'=>'DSPL', 'Create'=>'CRT', 'Update'=>'UPDT', 'Delete'=>'DEL')
//                        ),
//                        array(
//                            "status"	=>true,
//                            "module"	=>"media",
//                            "title"		=>"Media",
//                            "acc" 		=> array('View'=>'DSPL')
//                        ),
//                    )
//                ),
//            );
        }
        function check(){
            $prev = array();
            $previlege = self::init();
            foreach($previlege as $itemprev){
                    $prev[] = $itemprev['items'];
            }
            $_prev = array();
            foreach($prev as $_itemprev){
                    if(count($_itemprev)>0)
                    {
                            foreach($_itemprev as $_itemprev2){
                                    if($_itemprev2['module']) $_prev[$_itemprev2['module']] = $_itemprev2['acc'];
                            }
                    }
            }
            return $_prev;
        }
    }