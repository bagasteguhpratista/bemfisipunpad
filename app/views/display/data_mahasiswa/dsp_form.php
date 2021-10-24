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

        view::get_component('inputtext',
            array(
                "name"=>"angkatan",
                "value"=>isset($data['angkatan']) ? $data['angkatan'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('inputtext',
            array(
                "name"=>"jurusan",
                "value"=>isset($data['jurusan']) ? $data['jurusan'] : '',
                "validate"=>"required"
            )
        );

          view::get_component('dragfile',
            array(
                "name" => "file",
                "value" => isset($data['file_pdf']) ? $data['file_pdf'] : '',
                "validate" => "required",
                "accept" => "pdf+docx",
            )
        );

        view::get_component('submit',
            array(
                "id"=>(isset($id))?$id:""
            )
        );
        view::get_component("form_down");
    view::get_views_template("dsp_footer");
