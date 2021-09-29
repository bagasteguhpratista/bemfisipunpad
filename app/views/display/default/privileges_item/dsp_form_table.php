<style>
    .table-form span.select2 span.select2-selection{
        height: 100% !important;
    }
    .table-form span.select2 span.select2-selection .select2-selection__rendered{
        line-height: 31px !important;
    }
    .table-form span.select2 span.select2-selection .select2-selection__arrow{
        top: 4px;
    }
    .col-form{
        margin: auto 0;
    }
    .col-form h6{
        font-size: 12px;
        font-weight: bold;
        margin: 0;
    }
    #dynamictable .form-control{
        font-size: 12px !important;
    }
</style>
<div class="position-relative row form-group">
    <label for="dynamic_input" class="col-sm-3 col-form-label">Add Table</label>
    <div class="col-sm-9" id="dynamictable">
        <div class="col-sm-3">
            <input type="text" placeholder="Column Name" id="columnname" name="columnname[]" class="form-control">
        </div>
        <div class="col-sm-3 table-form">
            <select name="form_table[]" id="formDynamic" class="select2 form-control">
                <option value="" disabled="disabled"  selected=""><?php echo admin::lang('select');  ?></option>
                <?php
                $table = admin::get_data_type_table();
                foreach($table as $row){ ?>
                    <option value="<?php echo $row['id']; ?>" ><?php echo $row['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-sm-3">
            <input type="text" placeholder="Length" id="length" name="length[]" class="form-control">
        </div>
        <div class="col-sm-1 col-form">
            <a class="btn btn-success" id="add_table"><i class="fa fa-plus"></i></a>
        </div>
        <div class="col-sm-2 col-form">
            <h6>Primary Key</h6>
        </div>
    </div>
</div>
<div id="dynamicContainerTable">
</div>
<script>
    $(document).ready(function(){
        var i = 1;
        $('#add_table').click(function(){
            i++;
            var addTable;
            addTable = '<div class="row-table-'+i+' col-sm-12 position-relative row form-group"><label for="dynamic_input" class="col-sm-3 col-form-label"></label><div class="col-sm-9" id="dynamictable"><div class="col-sm-3"><input type="text" placeholder="Column Name" id="columnname" name="columnname[]" class="form-control"></div><div class="col-sm-3" ><select name="form_table[]" class="select2 form-control "><option value="" disabled="disabled" selected=""><?php echo admin::lang('select');  ?></option>';
            <?php
                $item = admin::get_data_type_table();
                foreach($item as $row){
                    ?>
            addTable += '<option value="<?php echo $row['id']; ?>" ><?php echo $row['name']; ?></option>';
            <?php } ?>
            addTable += '</select></div><div class="col-sm-3"><input type="text" placeholder="Length" id="length" name="length[]" class="form-control"></div><div class="col-sm-1 col-form"><a class="btn btn-danger btn_form_remove" id="remove_form" btn-id-table="'+i+'"><i class="fa fa-trash"></i></a></div></div></div>';
            $('#dynamicContainerTable').append(addTable);
            $('.select2').select2();
        });
        $(document).on('click','.btn_form_remove',function(){
            var button_id = $(this).attr('btn-id-table');
            $(".row-table-"+button_id).remove();
        });
    });
</script>