<?php 
    view::get_views_template("dsp_header");
        view::get_component("form_up");

        view::get_component("texteditorlib");

        view::get_component('texteditor',
            array(
                "name"=>"questions",
                "value"=>isset($data['questions']) ? $data['questions'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('texteditor',
            array(
                "name"=>"answer",
                "value"=>isset($data['answer']) ? $data['answer'] : '',
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
