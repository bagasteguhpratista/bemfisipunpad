<?php
view::get_views_template("dsp_header");
view::get_component("form_up");
view::get_component('uploadlib');
view::get_component('inputtext',
    array(
        "name"=>"username",
        "value"=>isset($data['username']) ? $data['username'] : '',
        "validate"=>"required"
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
view::get_component('inputupload',
    array(
        "name"=>"image",
        "value"=> ((!empty($data['photo']) AND file_exists($var['v_images_path'] ."/user/". $data['photo']))? $var['v_images_url']."/user/". $data['photo']:''),
        "category"=>"image",
        "accept"=>"jpg+png+gif"
    )
);
?>
    <style>
        .th_user{
            background: #595a5a;
            text-align: center;
            color: #fff;
        }
        .table-bordered th, .table-bordered td{
            border: 1px solid #7a7c7d!important;
        }
    </style>
    <div class="row">
        <table class="mb-0 table table-bordered">
            <thead>
            <tr>
                <th class="th_user">&nbsp;</th>
                <th class="th_user">Role</th>
                <th class="th_user">Module</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $roless = db::all_data('role');
            $role_s = json_decode(json_encode($roless),true);
            foreach ($role_s as $row){
                $count_module = db::data_where("count(distinct(page))","role_detail", "id_role", $row['id']);

                ?>
                <tr>
                    <td rowspan="<?= $count_module + 1 ?>">
                        <div class="custom-radio custom-control" style="text-align:center;">
                            <input value="<?= $row['id'] ?>" type="radio" id="roleRadio-<?= $row['id'] ?>" name="p_role" class="custom-control-input" <?= isset($data['id_role']) ? (($data['id_role'] == $row['id']) ? 'checked' : '') : '' ?>>
                            <label class="custom-control-label" for="roleRadio-<?=$row['id'] ?>"></label>
                        </div>
                    </td>
                    <td style="text-align: center;font-weight:bold;font-size:14px;" rowspan="<?= $count_module + 1 ?>"><?= ucwords($row['name']) ?></td>
                    <?php
                    //$modules = DB::table('edu_role_detail')->where('id_role',$row['id'])->groupBy('page');
                    $modules_ = [];
                    $modules = "select * from ". $var['table']['role_detail']. " where id_role='".$row['id']."' GROUP BY page";
                    db::query($modules, $rs['modules'], $nr['modules']);
                    while($rows = db::fetch($rs['modules'])){
                        $modules_[] = $rows;
                    }
                    ?>
                </tr>
                <?php
                foreach ($modules_ as $mods){
                    //$act = DB::table('edu_role_detail')->where('page',$mods['page'])->get();
                    $act_ = [];
                    $act = "select * from ". $var['table']['role_detail']. " where page='".$mods['page']."' AND id_role='".$row['id']."'";
                    db::query($act, $rs['act'], $nr['act']);
                    while($rowss = db::fetch($rs['act'])){
                        $act_[] = $rowss;
                    }
                    //echo json_encode($act_);
                    ?>
                    <tr>
                        <td >
                            <span style="text-align:center;font-weight:bold;"><?= ucwords($mods['page']) ?></span>
                            <br>
                            <?php
                            foreach($act_ as $acts){
                                echo "[ " . $acts['role'] . " ]";
                                $acts['role'] = '';
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
            </tbody>
        </table>
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