<?php 
    view::get_views_template("dsp_header");
        view::get_component("form_up");

        view::get_component('inputtext',
            array(
                "name"=>"name",
                "value"=>isset($data['name']) ? $data['name'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('inputtext',
            array(
                "name"=>"jurusan_angkatan",
                "value"=>isset($data['jurusan_angkatan']) ? $data['jurusan_angkatan'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('inputtext',
            array(
                "name"=>"prestasi",
                "value"=>isset($data['prestasi']) ? $data['prestasi'] : '',
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
