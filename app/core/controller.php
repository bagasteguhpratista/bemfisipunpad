<?php

    class controller
    {
        public function model($model)
        {
            global $var;
            require_once $var['model_path'] . '/' . $model . '.php';
            return new $model;
        }
    }