<?php 
view::get_views_template("dsp_header");
    view::get_component("form_up");
        view::get_component('inputtext',
            array(
                "name"=>"name",
                "value"=>isset($data['name']) ? admin::specialchars($data['name']) : null,
                "validate"=>"required"
            )
        );
        view::get_component('inputtext',
            array(
                "name"=>"alias",
                "value"=>isset($data['alias']) ? admin::specialchars($data['alias']) : '',
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
?>

