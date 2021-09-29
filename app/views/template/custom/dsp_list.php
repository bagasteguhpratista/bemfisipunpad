<?php view::get_views_template("dsp_header"); ?>
			<div class="app-main__outer">
                    <div class="app-main__inner">
                        <h5 class="card-title"><?= ucwords(str_replace('_', ' ', $title)) ?></h5>
                        <div class="notif-msg">
                        <?php flasher::flash() ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" id="listTable">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <div class="app-header__content">
                                            <div class="app-header-left">
                                                <ul class="header-menu nav">
                                                    <?php if(admin::checkRole("CRT","b")){?>
                                                    <li class="nav-item">
                                                        <a href="<?= admin::link_() . $add ?>" class="nav-link">
                                                            <i class="nav-link-icon fa fa-plus"> </i>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                    <li class="btn-group nav-item">
                                                        <a href="<?= admin::link_() . $refresh ?>" class="nav-link">
                                                            <i class="nav-link-icon fa fa-sync"></i>
                                                        </a>
                                                    </li>
                                                    <?php if(admin::checkRole("DEL","b")){?>
                                                    <li class="dropdown nav-item">
                                                        <a id="delete" action="<?= admin::link_() . $delete_id; ?>" class="nav-link">
                                                            <i class="nav-link-icon fa fa-trash"></i>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
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
                                                    <?php }
                                                        foreach ($vocab as $vocabs){
                                                    ?>
                                                    <th><?php echo admin::lang($vocabs) ?></th>
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
                                                <tbody id="sortable">
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
                                                        <td align="center"><a title="Edit" href="<?= admin::link_().$edit.$row['id'] ; ?>" ><i class="pe-7s-pen" aria-hidden="true"></i></a></td>
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
                                                        <td align="center"><a title="Delete" href="<?= admin::link_() . $delete .'&_to=002&delid='. $row['id'].'&id='.$id ?>" onclick="return confirm('Apakah Anda Yakin menghapus Data <?= $row['name']?> ?');" ><i class="pe-7s-trash" aria-hidden="true"></i></a></td>
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
        