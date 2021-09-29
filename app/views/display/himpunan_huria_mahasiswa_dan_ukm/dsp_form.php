<?php 
    view::get_views_template("dsp_header");
        view::get_component("form_up");
        view::get_component("select2lib");
        view::get_component("texteditorlib");

        view::get_component("uploadlib");

        view::get_component('inputupload',
            array(
                "name"=>"image",
                // "value"=> ((!empty($data['image']) AND file_exists($var['v_images_path'] ."/hhu/". $data['image']))? $var['v_images_url']."/hhu/". $data['image']:''),
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

        view::get_component('texteditor',
            array(
                "name"=>"content",
                "value"=>isset($data['content']) ? $data['content'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('inputtext',
            array(
                "name"=>"link_instagram",
                "value"=>isset($data['link_instagram']) ? $data['link_instagram'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('select2',
            array(
                "name"=>"category",
                "value"=>isset($data['category']) ? $data['category'] : '',
                "validate"=>"required",
                "items"=>$rs['category'],
            )
        );

        view::get_component('submit',
            array(
                "id"=>(isset($id))?$id:""
            )
        );
        view::get_component("form_down");
    view::get_views_template("dsp_footer");
