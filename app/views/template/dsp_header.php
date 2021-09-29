    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Language" content="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>CMS | <?= db::data_where("title_cms","configuration","id","1") ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
        <meta name="description" content="This is an example dashboard created using build-in elements and components.">
        <meta name="msapplication-tap-highlight" content="no">
        <link rel="stylesheet" href="<?= $var['app_assets']?>/_css/materialize.min.css">
        <link href="<?= $var['app_assets']?>/_css/main.css" rel="stylesheet">
        <link href="<?= $var['app_assets']?>/_css/style.css" rel="stylesheet">
        <link rel="icon" type="text/css" href="<?= $var['app_assets'] . '/_images/bemfisip.png' ?>">
        <link rel="stylesheet" href="<?= $var['app_assets'] .'/_css/font-awesome.min.css?'. rand(1,1000); ?>">
        <link rel="stylesheet" href="<?= $var['app_assets'] .'/_css/font-awesome.animated.css?'. rand(1,1000); ?>">
        <script src="<?= $var['app_assets']?>/_js/jquery.min.js"></script>
        <!-- <script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js?ver=2.1.3'></script> -->
        
    <body>
        <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
            <div class="app-header header-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <a type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <a type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <a type="button" class="btn-icon btn-icon-only btn btn-burger-mobile btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </a>
                    </span>
                </div>    
                <div class="app-header__content">
                    <div class="app-header-right">
                    <?php if($var['auth']['id'] == 'a1'){ ?>
                        <div class="header-btn-lg pr-0 page mr-2">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="btn-group">
                                            <a href="<?= $var['app_url'] . '/page.dev'?>"  class="p-2 btn">
                                                <i class="fa fa-list-alt" aria-hidden="true" title="Page"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="header-btn-lg pr-0 privilege">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="btn-group">
                                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-2 btn">
                                                <i class="fa fa-fw" aria-hidden="true" title="Copy to use laptop"></i><i class="fa fa-angle-down ml-2 opacity-8"></i>
                                            </a>
                                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                                <a href="<?= $var['app_url'] . '/privileges.dev'?>" type="button" tabindex="0" class="dropdown-item">Privileges</a>
                                                <a href="<?= $var['app_url'] . '/privileges_item.dev'?>" type="button" tabindex="0" class="dropdown-item">Privileges Item</a>
                                                <a href="<?= $var['app_url'] . '/privileges_acc.dev'?>" type="button" tabindex="0" class="dropdown-item">Privileges Acc</a>
                                            </div>
                                            <?php //href="<?= $var['app_url'] ?> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                        <!-- <div class="header-btn-lg pr-0 notification">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="btn-group">
                                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                                <i class="fa fa-bell badge-notification"></i>
                                                (10)<i class="fa fa-angle-down ml-2 opacity-8"></i>
                                            </a>
                                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                                <button type="button" tabindex="0" class="dropdown-item">User Account</button>
                                                <button type="button" tabindex="0" class="dropdown-item">Settings</button>
                                                <h6 tabindex="-1" class="dropdown-header">Header</h6>
                                                <button type="button" tabindex="0" class="dropdown-item">Actions</button>
                                                <div tabindex="-1" class="dropdown-divider"></div>
                                                <button type="button" tabindex="0" class="dropdown-item">Dividers</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   --> 
                        <div class="header-btn-lg pr-0" style="padding: 10px !important;">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="btn-group">
                                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn username_header">
                                                <img width="30" class="rounded-circle" src="<?= $var['v_assets_url']. '/images/user/' . db::data_where("photo","user","id",$var['auth']['id'])?>" alt="">
                                                &nbsp; <?= db::data_where("name","user","id",$var['auth']['id'])?>
                                                <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                            </a>
                                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                                <a type="button" href="<?= $var['app_url'] . '/profile.dev'?>" tabindex="0" class="dropdown-item">Profile</a>
                                                <a type="button" href="<?= $var['app_url'] . '/configuration.dev'?>" tabindex="0" class="dropdown-item">Configuration</a>
                                                <a type="button" target="_blank" href="<?= $var['http'] ?>" tabindex="0" class="dropdown-item">Get Public</a>
                                                <a type="button" href="<?= $var['app_url'] . '/auth/logout'?>" tabindex="0" class="dropdown-item">Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>        
                    </div>
                </div>
            </div>
            
    <?php //include_once $var['v_template_path'] . '/dsp_settings.php' ?>
    
    <div class="app-main">
    <?php view::get_views_template("dsp_sidebar"); ?>
    