<?php
//--FORM-UP--//
    view::get_views_template("dsp_header");
        view::get_component("form_up");
//--/FORM-UP--//
//--FORM-DOWN--//
        view::get_component('submit',
            array(
                "id"=>(isset($id))?$id:""
            )
        );
        view::get_component("form_down");
    view::get_views_template("dsp_footer");
//--/FORM-DOWN--//
//--FORM-INPUTTEXT--//
        view::get_component('inputtext',
            array(
                "name"=>"name",
                "value"=>isset($data['name']) ? $data['name'] : '',
                "validate"=>"required"
            )
        );
//--/FORM-INPUTTEXT--//
//--FORM-RADIOBUTTON--//
        view::get_component('radiobutton',
            array(
                "name"=>"radiobutton",
                "value"=>isset($data['radiobutton']) ? $data['radiobutton'] : '',
                "validate"=>"required",
                "choice" => array("internal","eksternal")
            )
        );
//--/FORM-RADIOBUTTON--//
//--FORM-SELECT2--//
        view::get_component('select2',
            array(
                "name"=>"select2",
                "value"=>isset($data['select2']) ? $data['select2'] : '',
                "validate"=>"required",
                "items"=>$rs['select2'],
            )
        );
//--/FORM-SELECT2--//
//--FORM-SELECT2LIB--//
        view::get_component("select2lib");
//--/FORM-SELECT2LIB--//
//--FORM-TEXTAREA--//
        view::get_component('textarea',
            array(
                "name"=>"textarea",
                "value"=>isset($data['textarea']) ? $data['textarea'] : '',
                "validate"=>"required"
            )
        );
//--/FORM-TEXTAREA--//
//--FORM-TEXTEDITOR--//
        view::get_component('texteditor',
            array(
                "name"=>"texteditor",
                "value"=>isset($data['texteditor']) ? $data['texteditor'] : '',
                "validate"=>"required"
            )
        );
//--/FORM-TEXTEDITOR--//
//--FORM-TEXTEDITORLIB--//
        view::get_component("texteditorlib");
//--/FORM-TEXTEDITORLIB--//
//--FORM-INPUTUPLOAD--//
        view::get_component('inputupload',
            array(
                "name"=>"image",
                "value"=> ((!empty($data['image']) AND file_exists($var['v_images_path'] ."/user/". $data['image']))? $var['v_images_url']."/user/". $data['image']:''),
                "category"=>"image",
                "accept"=>"jpg+jpeg+png+gif"
            )
        );
//--/FORM-INPUTUPLOAD--//
//--FORM-UPLOADLIB--//
        view::get_component("uploadlib");
//--/FORM-UPLOADLIB--//
//--FORM-INPUTUPLOADFILEMEDIA--//
        view::get_component('inputupload',
            array(
                "name"=>"image",
                "value"=> (!empty($data['image']) ? $data['image'] : ''),
                "category"=>"image",
                "accept"=>"jpg+jpeg+png+gif",
                "filemedia"=>true
            )
        );
//--/FORM-INPUTUPLOADFILEMEDIA--//
//--FORM-INPUTPRICE--//
        view::get_component('inputprice',
            array(
                "name"=>"harga",
                "value"=>isset($data['harga']) ? number_format($data['harga']) : '',
                "validate"=>"required"
            )
        );
//--/FORM-INPUTPRICE--//
//--FORM-INPUTPHONE--//
        view::get_component('inputphone',
            array(
                "name"=>"nomor_hp",
                "value"=>isset($data['nomor_hp']) ? $data['nomor_hp'] : '',
                "validate"=>"required",
                "phone"=>false
            )
        );
//--/FORM-INPUTPHONE--//

