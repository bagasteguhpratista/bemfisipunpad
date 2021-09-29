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
                                                        <a href="<?= admin::link_() . '/add' ?>" class="nav-link">
                                                            <i class="nav-link-icon fa fa-plus"> </i>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                    <li class="btn-group nav-item">
                                                        <a href="<?= admin::link_() ?>" class="nav-link">
                                                            <i class="nav-link-icon fa fa-sync"></i>
                                                        </a>
                                                    </li>
                                                    <?php if(admin::checkRole("DEL","b")){?>
                                                    <li class="dropdown nav-item">
                                                        <a id="delete" action="<?= admin::link_() . '/delete'; ?>" class="nav-link">
                                                            <i class="nav-link-icon fa fa-trash"></i>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                                <div class="search-wrapper active">
                                                    <div class="input-holder">
                                                        <input type="text" id="search" class="search-input" placeholder="Type to search">
                                                        <button class="search-icon"><span></span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
