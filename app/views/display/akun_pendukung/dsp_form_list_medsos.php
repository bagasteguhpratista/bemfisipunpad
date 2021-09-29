<style>
    #dynamicinput,.dysn, #dynamictable{
        display: flex;
    }
    .select2{
        width: 100% !important;
    }
    .col-sm-9{
        padding-left: 0px !important;
    }
    .col-sm-9 .checkbox{
        padding-left: 15px !important;
    }
</style>
<?php 
    view::get_views_template("dsp_header");
        view::get_component("form_up");

        view::get_component("select2lib");

        view::get_component('select2',
            array(
                "name"=>"social_media",
                "value"=>isset($data['id_sosmed']) ? $data['id_sosmed'] : '',
                "validate"=>"required",
                "items"=>$rs['id_medsos'],
            )
        );

        view::get_component('inputtext',
            array(
                "name"=>"link",
                "value"=>isset($data['link']) ? $data['link'] : '',
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
