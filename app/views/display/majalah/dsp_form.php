<?php 
    view::get_views_template("dsp_header");
        view::get_component("select2lib");
        view::get_component('datepickerbootstraplib');
        view::get_component("form_up");

        view::get_component('inputtext',
            array(
                "name"=>"title",
                "value"=>isset($data['title']) ? $data['title'] : '',
                "validate"=>"required"
            )
        );
        view::get_component('dragfile',
            array(
                "name" => "file",
                "value" => isset($data['file_pdf']) ? $data['file_pdf'] : '',
                "validate" => "required",
                "accept" => "pdf",
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
        
        view::get_component('submit',
            array(
                "id"=>(isset($id))?$id:""
            )
        );
        view::get_component("form_down");
    view::get_views_template("dsp_footer");
?>
<script type="text/javascript">
    $(document).ready(function(){
        var nowDate = new Date();
        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
        $(function() {
            $('.publish_date, #datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD',
                minDate: today,
            });
        });
    });
</script>
