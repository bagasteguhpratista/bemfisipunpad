<style>
    #eksternal_content,#internal_content,#category_page{
        display:none;
    }
</style>
<?php
view::get_views_template("dsp_header");
view::get_component("select2lib");
view::get_component("form_up");
        view::get_component('radiobutton',
            array(
                "name"=>"tobe",
                "value"=>isset($data['tobe']) ? $data['tobe'] : '',
                "validate"=>"required",
                "choice" => array("parent","child")
            )
        );
?>
    <div id="category_page">
<?php
        view::get_component('select2',
            array(
                "name"=>"category",
                "value"=>isset($data['category']) ? $data['category'] : '',
                "validate"=>"required",
                "items"=>$rs['category'],
            )
        );
?>
    </div>
<?php
    	view::get_component('inputtext',
            array(
                "name"=>"name",
                "value"=>isset($data['name']) ? $data['name'] : '',
				"validate"=>"required"
			)
        );
        view::get_component('radiobutton',
            array(
                "name"=>"target",
                "value"=>isset($data['target']) ? $data['target'] : '',
                "validate"=>"required",
                "choice" => array("blank","self")
            )
        );
        view::get_component('radiobutton',
            array(
                "name"=>"publish",
                "value"=>isset($data['publish']) ? $data['publish'] : '',
                "validate"=>"required",
                "choice" => array("show","hide")
            )
        );
        view::get_component('radiobutton',
            array(
                "name"=>"setup",
                "value"=>isset($data['setup']) ? $data['setup'] : '',
                "validate"=>"required",
                "choice" => array("internal","eksternal")
            )
        );
?>
        <div id="internal_content">
        <?php
        if(!isset($id)) {
            view::get_component('dragfile',
                array(
                    "name" => "file",
                    "value" => isset($data['file']) ? $data['file'] : '',
                    "validate" => "required",
                    "accept" => "html",
                )
            );
        }
        ?>
        </div>
        <div id="eksternal_content">
<?php
        view::get_component('inputtext',
            array(
                "name"=>"link",
                "value"=>isset($data['link']) ? $data['link'] : '',
                "validate"=>"required"
            )
        );
?>
        </div>
<?php
        view::get_component('submit',
            array(
                "id"=>(isset($id))?$id:""
            )
        );
?>
<script>
    $( document ).ready(function(){
        $('#internal_content').hide();
        $('#eksternal_content').hide();
        $('#category_page').hide();
        function getVal(val){
            if(val == 'internal'){
                $('#internal_content').show();
                $('#eksternal_content').hide();
            }else{
                $('#eksternal_content').show();
                $('#internal_content').hide();
            }
        }

        function getCat(val){
            if(val == 'child'){
                $('#category_page').show();
            }else{
                $('#category_page').hide();
            }
        }
        $('input[name=setup]').change(function(){getVal($(this).val());});
        $('input[name=tobe]').change(function(){getCat($(this).val());});
        var type = $('input[name=setup]:checked').val();
        if(type){$("#"+type+"_content").show();}
    });
</script>
<?php
    view::get_component("form_down");
    view::get_views_template("dsp_footer");
?>