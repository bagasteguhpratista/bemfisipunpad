<?php 
    view::get_views_template("dsp_header");
        view::get_component("form_up");

        view::get_component("select2lib");

        view::get_component("uploadlib");

        view::get_component('inputupload',
            array(
                "name"=>"photo",
                "value"=> ((!empty($data['photo']) AND file_exists($var['v_images_path'] ."/dokumentasi/". $data['photo']))? $var['v_images_url']."/dokumentasi/". $data['photo']:''),
                "category"=>"image",
                "accept"=>"jpg+jpeg+png+gif",
                "size"=>"Catatan </br> <b>1. tinggi foto minimal 200px</b></br><b>2. diusahan agar ukuran foto tidak lebih dari 10mb</b></br><b>3. foto akan dikompress oleh sistem</b>"
            )
        );

        view::get_component('inputtext',
            array(
                "name"=>"title",
                "value"=>isset($data['title']) ? $data['title'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('select2',
            array(
                "name"=>"category",
                "value"=>isset($data['category']) ? $data['category'] : '',
                "validate"=>"required",
                "items"=>$rs['category'],
            )
        );


        view::get_component('submit',
            array(
                "id"=>(isset($id))?$id:""
            )
        );
        view::get_component("form_down");
    view::get_views_template("dsp_footer");
