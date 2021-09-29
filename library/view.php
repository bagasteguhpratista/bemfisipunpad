<?php


    class view
    {
        public static function get_views($view, $data = []){
            global $var;
            include_once $var['path'] . "/app/views/".$view.".php";
        }
        public static function get_views_template($view, $data=[])
        {
            global $var,$GLOBALS;
            file_get_contents($var['app_url'].'/json/'.route::controller());
            foreach($GLOBALS as $k=> $v){
                $$k=$v;
            }
            // $config = db::get_record("configuration", "id", 1);
            include $var['path'] . "/app/views/template/".$view.".php";
        }
        public static function get_union($data = [])
        {
            global $var;
            // view::get_views_template("dsp_header");
            view::get_views_template("dsp_list", $data);
            // view::get_views_template("dsp_footer");
        }
        public static function get_component($component, $param = [])
        {
            global $var,$GLOBALS;
            foreach($GLOBALS as $k=> $v){
                $$k=$v;
            }
            include $var['view_path'] ."/component/". $component .".html";
        }

        public static function validation($pName,$validate_name)
        {
            if($validate_name){
                valid::getValidate($pName);
            }
        }
    }