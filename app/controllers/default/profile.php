<?php

    class profile extends controller
    {
        private $db;

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
                $id = $var['auth']['id'];
                $rs['privileges'] = db::data_record_select("id,name","privileges");
                $data = db::data_record("user","id",$id);
                include_once $var['v_display_path'] . '/default/' .route::controller(). '/dsp_form.php';
                exit;
            }
            if($_to == "002"){
                $id = $var['auth']['id'];
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
                if($id='a1'){
                    $p_role='a1';
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
    }