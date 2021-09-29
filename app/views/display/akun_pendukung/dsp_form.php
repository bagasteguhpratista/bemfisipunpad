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

        view::get_component("texteditorlib");

        view::get_component("uploadlib");

        view::get_component("select2lib");

        view::get_component('inputupload',
            array(
                "name"=>"image",
                "value"=> (!empty($data['image']) ? $data['image'] : ''),
                "category"=>"image",
                "accept"=>"jpg+jpeg+png+gif",
                "filemedia"=>true
            )
        );

        view::get_component('inputtext',
            array(
                "name"=>"name",
                "value"=>isset($data['name']) ? $data['name'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('texteditor',
            array(
                "name"=>"content",
                "value"=>isset($data['content']) ? $data['content'] : '',
                "validate"=>"required"
            )
        );
    if(!isset($id)){
        ?> </br><p style="font-size: 14px; font-weight: 700; text-align: center;">Akun Sosial Media</p><?php
        include 'dsp_form_medsos.php';
    }else{
        ?>
            </br><p style="font-size: 14px; font-weight: 700; text-align: center;">Jika ingin edit akun media sosial, Silahkan kembali ke list utama dan klik logo sosmed</p>
        <?php
    }
        view::get_component('submit',
            array(
                "id"=>(isset($id))?$id:""
            )
        );
        view::get_component("form_down");
    view::get_views_template("dsp_footer");
