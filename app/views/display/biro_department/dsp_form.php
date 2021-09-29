<style>
    #depart{
        display:none;
    }
</style>
<?php 
    view::get_views_template("dsp_header");
        view::get_component("form_up");

        view::get_component("uploadlib");

        view::get_component('inputtext',
            array(
                "name"=>"name_dept_biro",
                "value"=>isset($data['name_dept_biro']) ? $data['name_dept_biro'] : '',
                "validate"=>"required"
            )
        );
        view::get_component('radiobutton',
            array(
                "name"=>"type",
                "value"=>isset($data['type']) ? $data['type'] : '',
                "validate"=>"required",
                "choice" => array("department","biro")
            )
        );
        ?>
        <div id="depart">
        <?php
        view::get_component('radiobutton',
            array(
                "name"=>"department",
                "value"=>isset($data['department']) ? $data['department'] : '',
                "validate"=>"required",
                "choice" => array("relasi_kemasyarakatan","sosial_politik","kemahasiswaan")
            )
        );
        ?>
        </div>
        <?php
        ?> </br><p style="font-size: 14px; font-weight: 700; text-align: center;">Ketua</p><?php
        view::get_component('inputupload',
            array(
                "name"=>"photo_chairman",
                "value"=> (!empty($data['photo_chairman']) ? $data['photo_chairman'] : ''),
                "category"=>"image",
                "accept"=>"jpg+jpeg+png+gif",
                "filemedia"=>true
            )
        );

        view::get_component('inputtext',
            array(
                "name"=>"name_chairman",
                "value"=>isset($data['name_chairman']) ? $data['name_chairman'] : '',
                "validate"=>"required"
            )
        );

        ?> </br><p style="font-size: 14px; font-weight: 700; text-align: center;">Wakil Ketua</p><?php

        view::get_component('inputupload',
            array(
                "name"=>"photo_vice",
                "value"=> (!empty($data['photo_vice']) ? $data['photo_vice'] : ''),
                "category"=>"image",
                "accept"=>"jpg+jpeg+png+gif",
                "filemedia"=>true
            )
        );

        view::get_component('inputtext',
            array(
                "name"=>"name_vice",
                "value"=>isset($data['name_vice']) ? $data['name_vice'] : '',
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

<script type="text/javascript">
    $( document ).ready(function() {
        var depart = $('input[name=type]:checked').val();
        if(depart == 'department')
        {
            $('#depart').show();
        }else
        {
            $('#depart').hide();
        }

        function getDept(val){
            if(val == 'department'){
                $('#depart').show();
            }else{
                $('#depart').hide();
            }
        }
        $('input[name=type]').change(function(){getDept($(this).val());});
        $('input[name=type]').click(function(){getDept($(this).val());});
    });
</script>