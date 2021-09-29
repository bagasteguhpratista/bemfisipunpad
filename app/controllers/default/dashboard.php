<?php
    class dashboard extends controller
    {
        private $db;

        public function __construct()
        {
            // admin::checkLogin();
            db::connect();
        }

        function index(){
//            admin::checkRole("DSPL");
            privilege::init();
            global $var;
            // admin::checkLogin();
            include_once $var['path'] . "/app/views/template/dsp_dashboard.php";
            exit;
        }
    }