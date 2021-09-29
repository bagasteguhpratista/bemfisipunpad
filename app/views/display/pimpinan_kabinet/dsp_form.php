<?php 
    view::get_views_template("dsp_header");
        view::get_component("form_up");

        view::get_component("select2lib");

        view::get_component("uploadlib");

        view::get_component('inputupload',
            array(
                "name"=>"photo",
                "value"=> (!empty($data['photo']) ? $data['photo'] : ''),
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

        view::get_component('select2',
            array(
                "name"=>"position",
                "value"=>isset($data['position']) ? $data['position'] : '',
                "validate"=>"required",
                "items"=>$rs['position'],
            )
        );

        view::get_component('submit',
            array(
                "id"=>(isset($id))?$id:""
            )
        );
        view::get_component("form_down");
    view::get_views_template("dsp_footer");
