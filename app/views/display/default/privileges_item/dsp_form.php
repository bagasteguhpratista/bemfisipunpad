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
$items = admin::getComponentList();


view::get_views_template("dsp_header");
    view::get_component("select2lib");
    view::get_component("form_up");
        view::get_component('select2',
            array(
                "name"=>"privileges",
                "value"=>isset($data['id_priv']) ? $data['id_priv'] : '',
                "validate"=>"required",
                "items"=>$rs['privileges'],
            )
        );
        view::get_component('inputtext',
            array(
                "name"=>"name",
                "value"=>isset($data['name']) ? $data['name'] : '',
                "validate"=>"required"
            )
        );
        view::get_component('select2',
            array(
                "name"=>"acc",
                "value"=>isset($data['id_priv_acc']) ? $data['id_priv_acc'] : '',
                "validate"=>"required",
                "multiple"=>true,
                "items"=>$rs['acc'],

            )
        );
        view::get_component('checkbox',
            array(
                "name"=>"default",
                "value"=>isset($data['checkbox']) ? $data['checkbox'] : '',
                "datas"=>array("defaults")
            )
        );
        if(!isset($id)){
?>
<div class="position-relative row form-group">
    <label for="dynamic_input" class="col-sm-3 col-form-label">Select Form</label>
    <div class="col-sm-7" id="dynamicinput">
        <div class="col-sm-9">
            <select name="form[]" id="formDynamic" class="select2 form-control">
                <option value="" disabled="disabled"  selected=""><?php echo admin::lang('select');  ?></option>
                <?php
                foreach($items as $row){ ?>
                    <option value="<?php echo $row['id']; ?>" ><?php echo $row['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-sm-3">
            <a class="btn btn-success" id="add_form"><i class="fa fa-plus"></i></a>
        </div>
    </div>
</div>
<div id="dynamicContainer">
</div>
<?php
        include 'dsp_form_table.php';
            view::get_component('checkbox',
                array(
                    "name"=>"default_table",
                    "value"=>isset($data['default_table']) ? $data['default_table'] : '',
                    "datas"=>array("default_table")
                )
            );
        }
        ?>
<?php
        view::get_component('submit',
            array(
                "id"=>(isset($id))?$id:""
            )
        );
    view::get_component("form_down");
    view::get_views_template("dsp_footer");
?>
<script>
    $(document).ready(function(){
        var i = 1;
        $('#add_form').click(function(){
           i++;
           var addTable;
           addTable = '<div class="row'+i+' col-sm-12 position-relative row form-group"><label for="dynamic_input" class="col-sm-3 col-form-label"></label><div class="col-sm-7" id="dynamicinput"><div class="col-sm-9" ><select name="form[]" class="select2 form-control "><option value="" disabled="disabled" selected=""><?php echo admin::lang('select');  ?></option>';
           <?php foreach($items as $row){ ?>
               addTable += '<option value="<?php echo $row['id']; ?>" ><?php echo $row['name']; ?></option>';
            <?php } ?>
            addTable += '</select></div><div class="col-sm-3"><a class="btn btn-danger btn_remove" id="add_form" btn-id="'+i+'"><i class="fa fa-trash"></i></a></div></div></div>';
           $('#dynamicContainer').append(addTable);
           $('.select2').select2();
        });
        $(document).on('click','.btn_remove',function(){
            var button_id = $(this).attr('btn-id');
            $(".row"+button_id).remove();
        });
    });
</script>