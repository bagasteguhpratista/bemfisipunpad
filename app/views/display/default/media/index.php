<?php 
view::get_views_template("dsp_header");
//view::get_component("form_up");
?>
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <?= ucwords(str_replace('_', ' ', $title)); ?>
                </div>
            </div>
            <hr>
            <div role="main">
                <iframe width="100%" height="500" frameborder="0" src="<?php echo $var['http']; ?>/import/responsive_filemanager/filemanager/dialog.php?type=2&popup=1&relative_url=1"></iframe>
            </div>
        </div>
    </div>
<?php
//    view::get_component("form_down");
    view::get_views_template("dsp_footer");
?>

