<?php 
    view::get_views_template("dsp_header");
        view::get_component("form_up");

        view::get_component('inputtext',
            array(
                "name"=>"username",
                "value"=>isset($data['username']) ? $data['username'] : '',
                "validate"=>"required",
                "readonly"=>true
            )
        );

        view::get_component('inputtext',
            array(
                "name"=>"new_password",
                "value"=>isset($data['new_password']) ? $data['new_password'] : '',
                "validate"=>"required",
                "type" => "password"
            )
        );

        view::get_component('inputtext',
            array(
                "name"=>"re_password",
                "value"=>isset($data['re_password']) ? $data['re_password'] : '',
                "validate"=>"required",
                "type"=>"password"
            )
        );

        view::get_component('submit',
            array(
                "id"=>(isset($id))?$id:""
            )
        );
        view::get_component("form_down");
    view::get_views_template("dsp_footer");
