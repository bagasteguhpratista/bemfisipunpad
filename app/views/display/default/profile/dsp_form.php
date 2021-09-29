<style>
    .profileBox{
        display: -webkit-box;
    }
    .imageProfile{
        position: absolute;
        left: 50%;
        top: 50%;
        /* width: 200px; */
        transform: translate(-50%, -50%);
        -webkit-transform: translate(-50%,-50%);
        -ms-transform: translate(-50%,-50%);
        min-height: 100%;
        min-width: 100%;
    }
    .btn-profile{
        border: 0px;
        background: transparent;
        border-radius: 100%;
    }
    .btn-profile:hover{
        background: transparent;
    }
    .div-profile{
        position: relative;
        /* width: 200px; */
        overflow: hidden;
        margin: 5px;
        height: 200px;
        width: 200px;
        background-position: center center;
        background-repeat: no-repeat;
        border-radius: 100%;
    }
</style>
<?php
view::get_views_template("dsp_header");
view::get_component("form_up");
view::get_component('uploadlib');
?>
<script>
    $(function(){
        $('#btn-file-image').click(function(){
            $('#file_image').trigger('click');
        });
    });
</script>
<div class="profileBox">
    <div class="col-md-3 mr-1 ml-1">
        <div class="position-relative form-group div-profile">
            <a type="button" id="btn-file-image" class="btn-profile" >
                <img class="imageProfile" id="p_image" src="<?php echo ((!empty($data['photo']) AND file_exists($var['v_images_path'] ."/user/". $data['photo']))? $var['v_images_url']."/user/". $data['photo']:''); ?>" width="256"/>
            </a>
            <input name="p_image" style="display:none;" id="file_image" category="image" type="file" accept="jpg+png+gif">
            <br/>
            <br/>
        </div>
    </div>
    <div class="col-md-7" style="margin:auto 0;">
        <?php
        view::get_component('inputtext',
            array(
                "name"=>"username",
                "value"=>isset($data['username']) ? $data['username'] : '',
                "validate"=>"required",
                "readonly"=>!isset($id) ? false : true
            )
        );
        if(!isset($id)){
            view::get_component('inputtext',
                array(
                    "name"=>"password",
                    "value"=>isset($data['password']) ? $data['password'] : '',
                    "validate"=>"required",
                    "type"=>"password"
                )
            );
        }
        view::get_component('inputtext',
            array(
                "name"=>"name",
                "value"=>isset($data['name']) ? $data['name'] : '',
                "validate"=>"required"
            )
        );
        view::get_component('inputtext',
            array(
                "name"=>"email",
                "value"=>isset($data['email']) ? $data['email'] : '',
                "type"=>"email",
                "validate"=>"required"
            )
        );
        ?>
    </div>
</div>
<?php
view::get_component('submit',
    array(
        "id"=>(isset($id))?$id:""
    )
);
view::get_component("form_down");
view::get_views_template("dsp_footer");
?>

