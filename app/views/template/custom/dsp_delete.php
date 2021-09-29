<?php 
	view::get_views_template("dsp_header");
    view::get_component("form_up");
?>
	<div class="row">
        <div class="col-md-10">
            <blockquote>
                <?= admin::lang('confirm_delete') ?>
            </blockquote>
            <ul class="collection">
            	<?php
                	while($row=db::fetch($rs['row'])){
                ?>
                    <li class="collection-item">
                        <?= $row['title'] ?>
                        <input type="hidden" name="p_id[]" value="<?= $row['id'] ?>" />
                        <input type="hidden" name="id" value="<?= $id ?>" />
                    </li>
                <?php } ?>
            </ul>
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