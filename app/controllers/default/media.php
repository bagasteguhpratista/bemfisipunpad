<?php

    class media extends controller
    {
        private $db;
        // public $table = "aa";

        public function __construct()
        {
            global $var, $GLOBALS;
            db::connect();
            admin::_global();
            db::execute("SET sql_mode = ''");
        }

        function index()
        {
            global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
            include_once $var['v_display_path'] . '/default/' .route::controller(). '/index.php';
        }
    }