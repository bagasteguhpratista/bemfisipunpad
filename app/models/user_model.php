<?php

    class user_model
    {
        // private $nama = "BagasTeguh";
        // private $db;
        public function __construct()
        {
            // $this->db = db::getInstance();
            db::connect();
        }
        public function getNama()
        {
            $user = db::all_data("user");
            return $user;
        }
    }