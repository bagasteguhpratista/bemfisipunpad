<style>
    #nm_penulis{
        display:none;
    }
    #datetimepicker .input-group-addon{
        padding: 9.8px !important;
    }
</style>
<?php 
view::get_views_template("dsp_header");
    view::get_component("form_up");
    view::get_component("uploadlib");
    view::get_component("select2lib");
    view::get_component("datepickerbootstraplib");
    view::get_component("tagslib");
    view::get_component("texteditorlib");
        view::get_component('inputupload',
            array(
                "name"=>"image_cover",
                "value"=> ((!empty($data['image_cover']) AND file_exists($var['v_images_path'] ."/artikel/". $data['image_cover']))? $var['v_images_url']."/artikel/". $data['image_cover']:''),
                "category"=>"image",
                "accept"=>"jpg+jpeg+png+gif"
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

        view::get_component('ckeditor',
            array(
                "name"=>"content",
                "value"=>isset($data['content']) ? $data['content'] : '',
				"validate"=>"required"
			)
        );

        view::get_component('texteditor',
            array(
                "name"=>"reference",
                "value"=>isset($data['reference']) ? $data['reference'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('datepickerbootstrap',
            array(
                "name"=>"publish_date",
                "value"=>isset($data['publish_date']) ? $data['publish_date'] : '',
                "validate"=>"required",
                "noname"=>true
            )
        );

        view::get_component('radiobutton',
            array(
                "name"=>"writer_n",
                "value"=>isset($data['writer_n']) ? $data['writer_n'] : '',
                "validate"=>"required",
                "choice" => array("show","hide")
            )
        );
?>
<div id="nm_penulis">
<?php
        view::get_component('inputtext',
            array(
                "name"=>"writer",
                "value"=>isset($data['writer']) ? $data['writer'] : '',
                "validate"=>"required"
            )
        );
?>
</div>
<?php
        view::get_component('inputtext', 
            array(
                "type"=>"text", 
                "class"=>"tags", 
                "name"=>"tagline", 
                "value"=>isset($data['tagline']) ? $data['tagline'] : '',
                "validate"=>"required",
                "detail"=>"Notes: Tags dipisahkan oleh ',' [ koma ] ",
                "placeholder"=>"Add Tags"
            )
        );
        view::get_component('inputnumber',
            array(
                "name"=>"min_read",
                "value"=>isset($data['min_read']) ? $data['min_read'] : 0,
                "validate"=>"required",
                "note"=> "dalam satuan menit"
            )
        );
        view::get_component('dragfile',
            array(
                "name" => "file",
                "value" => isset($data['file_pdf']) ? $data['file_pdf'] : '',
                "validate" => "required",
                "accept" => "pdf+docx",
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
        $('#nm_penulis').hide();
        function getPenulis(val){
            if(val == 'show'){
                $('#nm_penulis').show();
            }else{
                $('#nm_penulis').hide();
            }
        }
        $('input[name=writer_n]').change(function(){getPenulis($(this).val());});
        var type = $('input[name=writer_n]:checked').val();
        if(type=='show'){$("#nm_penulis").show();}


        var nowDate = new Date();
        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
        $(function() {
            $('.publish_date, #datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD',
                minDate: today,
            });
        });
        $('.input-group-addon').off("click");
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#submit-btn').on("click",function(){
            var ckeditor = $('#p_content').html();
            $('#i_content').val(ckeditor);
        });
    });
</script>