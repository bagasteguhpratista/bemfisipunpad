<style type="text/css">
    .metismenu li{padding: 10px;}
</style>
<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>    
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu metismenu">
                <?php    
                // global $url;
                    $url = route::controller();
                    $module = $url;
                    // $privilege = privilege::init();
                    $privilege = "SELECT * FROM ".$var['table']['privileges'] . " ORDER BY reorder";
                    db::query($privilege,$rs['privilege'],$nr['privilege']);
                ?>
                <li class="app-sidebar__heading">&nbsp;</li>
                <li class="mm-active">
                    <a href="<?= $var['app_url'] ?>/dashboard" class="<?= $module == '' || $module == 'dashboard' ? 'mm-active' : null ?>">
                        <i class="metismenu-icon fa fa-home"></i>
                        Dashboard
                    </a>
                </li>
        <?php 
        if ($nr['privilege'] > 0){
            while($privilege=db::fetch($rs['privilege'])){
                $privilege_item = "SELECT * FROM ".$var['table']['privileges_item'] . " WHERE id_priv='".$privilege['id']."' AND status='active' ORDER BY name ASC";
                // echo $privilege_item;
                    db::query($privilege_item,$rs['md_item'],$nr['md_item']);
                    db::query($privilege_item,$rs['privilege_item'],$nr['privilege_item']);
                    while($md_item=db::fetch($rs['md_item'])) $mod[] = $md_item['alias'];
                    $item_count = db::data_where("count(id)","privileges_item","id_priv",$privilege['id'],"status='active'");
                    // echo json_encode($item_count);
            if(admin::checkRoleSidebar($privilege['id'],'priv') OR $var['auth']['id'] == 'a1'){
        ?>
                    <li class="<?php echo in_array($module, $mod) ? 'mm-active' : null ?>">
                        <a href="#">
                            <i class="metismenu-icon fa <?= $privilege['icon'] ?>"></i>
                            <?= $privilege['name'] ?>
                            <?php if($item_count >0 ) { ?>
                                <i class="metismenu-state-icon fa fa-chevron-down caret-left"></i>
                            <?php } ?>
                        </a>
        <?php
                if($privilege['status'] == 'active'){
                    if ($item_count >0){ ?>
                            <ul class="mm-collapse <?php echo in_array($module, $mod) ? 'mm-active mm-show' : null ?>">
                                <?php
                                    while($privilege_item=db::fetch($rs['privilege_item'])){
                                        if(admin::checkRoleSidebar($privilege_item['alias']) OR $var['auth']['id'] == 'a1'){
                                ?>
                                <li>
                                    <a class="<?= $privilege_item['alias'] == $module ? 'mm-active' : null ?>" href="<?= $var['app_url'] .'/'. $privilege_item['alias'] . (($privilege_item['defaults'] == 'yes') ? '.dev' : ''); ?>">
                                        <i class="metismenu-icon"></i>
                                        <?= $privilege_item['name'] ?>
                                    </a>
                                </li>
                                <?php
                                        }
                                    }
                                ?>
                            </ul>
                <?php
                    }
                ?>
            <?php
                }
                    $mod = [];
            }
            }
        }   ?>
            </ul>
        </div>
    </div>
</div>