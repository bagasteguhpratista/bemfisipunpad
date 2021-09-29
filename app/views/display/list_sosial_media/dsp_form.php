<?php 
    view::get_views_template("dsp_header");
        view::get_component("form_up");
        view::get_component("uploadlib");

        view::get_component('inputtext',
            array(
                "name"=>"title",
                "value"=>isset($data['title']) ? $data['title'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('inputupload',
            array(
                "name"=>"icon",
                "value"=> (!empty($data['icon']) ? $data['icon'] : ''),
                "category"=>"image",
                "accept"=>"jpg+jpeg+png+gif",
                "filemedia"=>true
            )
        );

        view::get_component('submit',
            array(
                "id"=>(isset($id))?$id:""
            )
        );
        view::get_component("form_down");
    view::get_views_template("dsp_footer");
