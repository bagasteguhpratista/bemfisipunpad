<?php

    class configuration extends controller
    {
        private $db;
        public static $table = "configuration";

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
                $id = "1";
                $data = db::data_record(self::$table,"id",$id);
                include_once $var['v_display_path'] . '/default/' .route::controller(). '/dsp_form.php';
                exit;
            }
            if($_to == "002"){
                $id = "1";
                $urut = db::data_where("max(reorder)",self::$table,"1=1");
                $urut = ($urut==0) ? 1 : $urut+1;
                $data = db::data_record(self::$table,"id",$id);
                $link_instagram = empty($link_instagram) ? '#' : $link_instagram;
                $link_line      = empty($link_line) ? '#' : $link_line;
                $link_twitter   = empty($link_twitter) ? '#' : $link_twitter;
                $link_youtube   = empty($link_youtube) ? '#' : $link_youtube;

                db::update(self::$table,
                    [
                        'title_website'     => $title_website,
                        'title_cms'         => $title_cms,
                        'jumlah_departementbiro'    => $jumlah_departementbiro,
                        'jumlah_staff'              => $jumlah_staff,
                        'jumlah_programkerja'       => $jumlah_programkerja,
                        'jumlah_aksi'               => $jumlah_aksi,
                        'jumlah_kajian'             => $jumlah_kajian,
                        'jumlah_postinstagram'      => $jumlah_postinstagram,
                        'link_instagram'            => $link_instagram,
                        'link_line'                 => $link_line,
                        'link_twitter'              => $link_twitter,
                        'link_youtube'              => $link_youtube,
                        'status'            => 'active',
                        'updated_by'        => $var['auth']['id'],
                        'updated_at'        => $now
                    ],'id',$id);

                flasher::setFlash('success', admin::lang('update'));
                header("location: " . admin::link_());
            }
        }
    }