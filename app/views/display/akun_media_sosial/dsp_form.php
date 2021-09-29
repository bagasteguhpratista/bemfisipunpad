<?php 
    view::get_views_template("dsp_header");
        view::get_component("form_up");

        view::get_component("uploadlib");

        view::get_component('inputupload',
            array(
                "name"=>"image",
                // "value"=> ((!empty($data['image']) AND file_exists($var['v_images_path'] ."/akun_medsos/". $data['image']))? $var['v_images_url']."/akun_medsos/". $data['image']:''),
                "value"=> isset($data['image']) ? $data['image'] : '',
                "category"=>"image",
                "accept"=>"jpg+jpeg+png+gif",
                "filemedia"=>true
            )
        );

        view::get_component('inputtext',
            array(
                "name"=>"name",
                "value"=>isset($data['name']) ? $data['name'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('inputtext',
            array(
                "name"=>"id_name",
                "value"=>isset($data['id_name']) ? $data['id_name'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('inputtext',
            array(
                "name"=>"link",
                "value"=>isset($data['link']) ? $data['link'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('submit',
            array(
                "id"=>(isset($id))?$id:""
            )
        );
        view::get_component("form_down");
    view::get_views_template("dsp_footer");
