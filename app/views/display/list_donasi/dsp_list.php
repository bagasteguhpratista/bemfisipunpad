<?php view::get_views_template("dsp_header"); ?>
<?php 
    // view::get_views_template("dsp_btn_action"); 
    global $var,$GLOBALS;
    // $view = "dsp_btn_action";
    // file_get_contents($var['app_url'].'/json/'.route::controller());
    foreach($GLOBALS as $k=> $v){
        $$k=$v;
    }
    include $var['v_display_path'] . '/' .route::controller(). '/dsp_btn_action.php';
?>
<style type="text/css">
	/*.tablesorter-default td{
		word-break: break-all;
	}*/
    .data-pendapatan{
        display: flex;
        padding: 5px 0;
    }
</style>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-sm-6 data-pendapatan">     
            <div class="col-sm-2">BRI</div>
            <div class="col-sm-1">:</div>
            <div class="col-sm-3">Rp. 100.000,-</div>
        </div>
        <div class="col-sm-6 data-pendapatan">     
            <div class="col-sm-2">BCA</div>
            <div class="col-sm-1">:</div>
            <div class="col-sm-3">Rp. 100.000,-</div>
        </div>
        <div class="col-sm-6 data-pendapatan">     
            <div class="col-sm-2">GOPAY</div>
            <div class="col-sm-1">:</div>
            <div class="col-sm-3">Rp. 100.000,-</div>
        </div>
        <div class="col-sm-6 data-pendapatan">     
            <div class="col-sm-2">OVO</div>
            <div class="col-sm-1">:</div>
            <div class="col-sm-3">Rp. 100.000,-</div>
        </div>
        <div class="col-sm-6 data-pendapatan">     
            <div class="col-sm-2">DANA</div>
            <div class="col-sm-1">:</div>
            <div class="col-sm-3">Rp. 100.000,-</div>
        </div>
        <div class="col-sm-6 data-pendapatan">     
            <div class="col-sm-2">TOTAL</div>
            <div class="col-sm-1">:</div>
            <div class="col-sm-3">Rp. 100.000,-</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
                                        <input id="token" type="hidden" name="csrf-token" content="<?php //"" ?>">
                                        <form method="post" id="listForm" action="<?= $url ?>">
                                            <?php //"csrf" ?>
                                            <table class="mb-0 table table-bordered tablesorter" id="tableList">
                                                <thead>
                                                <tr>
                                                    <?php if(admin::checkRole("DEL","b")){ ?>
                                                    <th style="text-align:center;" data-sorter="false"><input type="checkbox" id="checkall" /></th>
                                                    <?php }else{ ?>
                                                    <th style="text-align:center;" data-sorter="false">No</th>
                                                    <?php } ?>
                                                    <?php if(admin::checkRole("UPDT","b")){?>
                                                    <th data-sorter="false">&nbsp;</th>
                                                    <?php } ?>
                                                    <?php if ($status and admin::checkRole("UPDT","b")) { ?>
                                                        <th style="text-align:center;" data-sorter="false">Status Pembayaran</th>
                                                    <?php }
                                                        foreach ($vocab as $vocabs){
                                                    ?>
                                                    <th style="text-align:center;"><?php echo admin::lang($vocabs) ?></th>
                                                    <?php } ?>
                                                    <th><?php echo admin::lang('created_by') ?></th>
                                                    <th><?php echo admin::lang('created_at') ?></th>
                                                    <th><?php echo admin::lang('updated_by') ?></th>
                                                    <th><?php echo admin::lang('updated_at') ?></th>
                                                    <?php if(admin::checkRole("DEL","b")){ ?>
                                                    <th data-sorter="false">&nbsp;</th>
                                                    <?php } ?>
                                                </tr>
                                                </thead>
                                                <tbody id="<?= isset($sorted) ? 'sortable' : '' ?>">
                                                <?php 
                                                    if(count($results) > 0){
                                                        $no = ($halamanaktif == 1) ? 1 : ($halamanaktif*$pagination)+1;
                                                        foreach ($results as $row){
                                                ?>
                                                    <tr id="reorder_<?php echo stripslashes($row['id']) ?>">
                                                        <?php if(admin::checkRole("DEL","b")) { ?>
                                                        <td align="center"><input class="checkitem" type="checkbox" name="p_del[]" value="<?= $row['id'] ?>" /></td>
                                                        <?php }else{?>
                                                            <td align="center"><?= $no++; ?></td>
                                                        <?php } ?>
                                                        <?php if(admin::checkRole("UPDT","b")){?>
                                                        <td align="center"><a title="Edit" href="<?= admin::link_() .'/edit/'.$row['id'] ; ?>" ><i class="pe-7s-pen" aria-hidden="true"></i></a></td>
                                                        <?php } ?>
                                                        <?php if ($status and admin::checkRole("UPDT","b")){ ?>
                                                            <td style="text-align:center"><a title="Status" class="btn btn-<?php echo $row['status'] == 'active' ?  'success' : 'warning' ?>" href="<?= admin::link_() . '/status/' . $row['id'] . '/' . $row['status']; ?>"><?php echo $row['status'] == 'active' ?  'Sukses' : 'Pending' ?></a></td>
                                                        <?php }
                                                            foreach ($vocab as $vocabs){
                                                        ?>
                                                            <td><?php echo admin::limit_text($row[$vocabs],20) ?></td>
                                                        <?php } ?>
                                                        <td> <?php echo db::data_where('name','user','id', $row['created_by']) ?> </td>
                                                        <td> <?php echo $row['created_at'] != null ? date_format(date_create($row['created_at']), 'd/m/Y H:i:s') : '' ?> </td>
                                                        <td> <?php echo db::data_where('name','user','id', $row['updated_by']) ?> </td>
                                                        <td> <?php echo ($row['updated_at'] != null AND $row['updated_at'] != '0000-00-00 00:00:00') ? date_format(date_create($row['updated_at']), 'd/m/Y H:i:s') : '' ?> </td>
                                                        <?php if(admin::checkRole("DEL","b")){ ?>
                                                        <td align="center"><a title="Delete" href="<?= admin::link_() . '/delete&_to=002&delid='. $row['id'] ?>" onclick="return confirm('Apakah Anda Yakin menghapus Data <?= $row['name']?> ?');" ><i class="pe-7s-trash" aria-hidden="true"></i></a></td>
                                                        <?php } ?>
                                                    </tr>
                                                
                                                <?php
                                                    }
                                                }else{
                                                ?>
                                                    <tr>
                                                        <td style="text-align:center;" colspan="<?= count($vocab) + 8 ?>"> <?php echo admin::lang('nodata') ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                                    <?php 
                                        admin::get_pagination($jumlahdatasql,$pagination,$halamanaktif,$show_all);
                                    ?>
                            </div>
                        </div>
                    </div>
<?php view::get_views_template("dsp_footer"); ?>
        