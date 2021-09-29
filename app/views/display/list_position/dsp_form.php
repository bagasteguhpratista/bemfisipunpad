<?php 
    view::get_views_template("dsp_header");
        view::get_component("form_up");

        view::get_component('inputtext',
            array(
                "name"=>"title",
                "value"=>isset($data['title']) ? $data['title'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('radiobutton',
            array(
                "name"=>"position",
                "value"=>isset($data['position']) ? $data['position'] : '',
                "validate"=>"required",
                "choice" => array("pimkab","dept_biro")
            )
        );

        view::get_component('submit',
            array(
                "id"=>(isset($id))?$id:""
            )
        );
        view::get_component("form_down");
    view::get_views_template("dsp_footer");
