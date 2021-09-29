<?php 
    view::get_views_template("dsp_header");
        view::get_component("form_up");

        view::get_component("uploadlib");

        view::get_component('inputtext',
            array(
                "name"=>"name",
                "value"=>isset($data['name']) ? $data['name'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('inputupload',
            array(
                "name"=>"image",
                "value"=> ((!empty($data['image']) AND file_exists($var['v_images_path'] ."/user/". $data['image']))? $var['v_images_url']."/user/". $data['image']:''),
                "category"=>"image",
                "accept"=>"jpg+jpeg+png+gif"
            )
        );

        view::get_component('submit',
            array(
                "id"=>(isset($id))?$id:""
            )
        );
        view::get_component("form_down");
    view::get_views_template("dsp_footer");
