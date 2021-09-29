<?php

    class link_dokumentasi extends controller
    {
        private $db;
        public static $table = "link_dokumentasi";

        public function __construct()
        {
            global $var, $GLOBALS;
            db::connect();
            admin::_global();
            db::execute("SET sql_mode = ''");
        }

        function index(){
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
//            admin::checkRole("UPDT");
            if($_to == "001"){
                $data = db::data_record("configuration","id","1");
                include_once $var['v_display_path'] . '/' .route::controller(). '/dsp_form.php';
                exit;
            }
            if($_to == "002"){
                
                $data = db::data_record("configuration","id",$id);
                $link_dokumentasi = empty($link_dokumentasi) ? "#" : $link_dokumentasi;
                db::update('configuration',
                    [
                        'link_dokumentasi'=>$link_dokumentasi
                    ],'id',"1");

                flasher::setFlash('success', admin::lang('update'));
                header("location: " . admin::link_());
            }
        }
    }