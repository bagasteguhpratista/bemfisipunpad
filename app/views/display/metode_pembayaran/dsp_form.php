<?php 
    view::get_views_template("dsp_header");
        view::get_component("form_up");

        view::get_component('inputtext',
            array(
                "name"=>"bank",
                "value"=>isset($data['bank']) ? $data['bank'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('inputtext',
            array(
                "name"=>"nama_bank",
                "value"=>isset($data['nama_bank']) ? $data['nama_bank'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('inputtext',
            array(
                "name"=>"atas_nama",
                "value"=>isset($data['atas_nama']) ? $data['atas_nama'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('inputtext',
            array(
                "name"=>"rekening",
                "value"=>isset($data['rekening']) ? $data['rekening'] : '',
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
