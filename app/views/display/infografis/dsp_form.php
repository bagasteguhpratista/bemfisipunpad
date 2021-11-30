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

        view::get_component('inputfilemulti',
            array(                              
                "name"=>"image",
                "value"=> (isset($data['imageinfo'])?$data['imageinfo']:null),
                "path"=>$var['v_images_url']."/infografis/",
                // "size"=>" MAX Width : 99 PX | Height : 168 PX",
                "accept"=>"jpg+png+jpeg+gif"
            )
        );

        view::get_component('submit',
            array(
                "id"=>(isset($id))?$id:""
            )
        );
        view::get_component("form_down");
    view::get_views_template("dsp_footer");
