<?php 
view::get_views_template("dsp_header");
    view::get_component("form_up");

        view::get_component('inputtext',
            array(
                "name"=>"name",
                "value"=>isset($data['name']) ? $data['name'] : '',
                "validate"=>"required"
            )
        );
?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.var-checkall').change(function(){
                var checkitem   = $('.' + $(this).attr('var'));
                if(this.checked)
                {
                    checkitem.prop('checked', true);
                }
                else
                {
                    checkitem.prop('checked', false);
                }
            });
        });
        function checkChecked(aa){
            var checkItem = $('.var-'+aa+':checked').length;
            var allItemm = $('.var-'+aa).length;
            var checkAll = $('.checkall-'+aa);
            if (checkItem == allItemm)
            {
                checkAll.prop('checked', true);
            }
            else
            {
                checkAll.prop('checked', false);
            }
        }
    </script>
<?php 
    $privilege      = privilege::init();
    $datameta       = json_decode($privilege, true);
    $privilege      = $datameta;

?>
<style>
    .card .card-checkbox, hr.hr-list{
        border: 1px solid #ced4da;
    }
</style>
    <div class="row mt-5">
        <?php $no=1; 
        foreach ($privilege as $priv){
            if(isset($priv['items'])){
                foreach($priv['items'] as $items){
                        $roleAlias = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(" ","",$items['name']));
        ?>
                <div class="col-sm-2 col-md-4 ">
                    <div class="card card-checkbox">
                        <div class="list">
                            <div class="forcheckall">
                            <label>
                                <input class="checkbox-span var-checkall checkall-<?=$roleAlias?> checkLoop-<?=$no++?>" type="checkbox" id="chk-demo-<?=$roleAlias?>" var="var-<?=$roleAlias?>" vars="<?=$roleAlias?>" />
                                <span style="font-size: 16px;font-weight:bold;"><?= $items["name"] ?></span>
                            </label>
                            <hr class="hr-list">
                            </div>
                            <div class="list-item-checkbox">
                                <?php
                                if(isset($items['acc'])){
                                    foreach ($items['acc'] as $accs){
                                        $acc    = db::data_where("name","privileges_acc","id",$accs);
                                        $_acc   = db::data_where("alias","privileges_acc","id",$accs);
                                        $chk = null;
                                        if(isset($id))
                                        {
                                            $chk = db::data_where('role', 'role_detail', 'id_role="'. $id .'" AND page="'. $items['alias'] .'" AND role="'. $_acc .'"');
                                        }
                                ?>
                                    <p>
                                        <label for="chk-demo<?= $roleAlias.'-'.$acc ?>">
                                        <input name="p_acc[<?= $items['alias'] ?>][]" value="<?= $_acc ?>" <?= ($chk == $_acc AND $chk != null) ? 'checked' : '' ?> onchange="checkChecked('<?=$roleAlias?>')" class="checkitem checkbox-span var-<?=$roleAlias?>" type="checkbox" item_var="<?=$roleAlias?>" id="chk-demo<?= $roleAlias.'-'.$acc ?>"/>
                                        <span><?=$acc?></span>
                                        </label>
                                    </p>
                                <?php
                                    }
                                    } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php  
                }
            }
        }
            ?>
    </div>
    <script>
       $(document).ready(function(){
            var count_check = $('.var-checkall').length;
            console.log(count_check);
            for (var i=1; i<=count_check;i++)
            {
                var aa = $('.checkLoop-'+i).attr('vars');
                var checkItem = $('.var-'+aa+':checked').length;
                var allItemm = $('.var-'+aa).length;
                var checkAll = $('.checkall-'+aa);
                if (checkItem == allItemm)
                {
                    checkAll.prop('checked', true);
                }
                else
                {
                    checkAll.prop('checked', false);
                }
            }
       });
   </script>
<?php
        view::get_component('submit',
            array(
                "id"=>(isset($id))?$id:""
            )
        );
    view::get_component("form_down");
    view::get_views_template("dsp_footer");
?>

