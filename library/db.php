<?php
    class db
    {
        private static $_instance = null;
        private $mysqli; 

        public function __construct()
        {
            global $var;
            $this->mysqli = new mysqli($var['db']['server'], $var['db']['username'], $var['db']['password'], $var['db']['name']) or die("koneksi tidak jalan");
        }

        public static function connect()
        {
            global $var;
            $var['db']['connection'] = @mysqli_connect($var['db']['server'], $var['db']['username'], $var['db']['password']);
            if (!$var['db']['connection']):
                return FALSE;
            endif;
            if (!@mysqli_select_db($var['db']['connection'], $var['db']['name'])):
                return FALSE;
            endif;
            return TRUE;
        }
        public static function injection($string)
        {
            global $var;

            // $connect = @mysqli_connect("localhost", "user1", "datasoft123", "hr");
            return @mysqli_real_escape_string($var['db']['connection'],$string);
        }
        public static function getInstance()
        {
            if(!isset(self::$_instance)){
                self::$_instance = new db();
            }

            return self::$_instance;
        }

        public static function query($sql, &$result, &$nr)
        {
            global $var;
            //if (!stristr($sql,"union")):
            // echo $sql;

                $result = @mysqli_query($var['db']['connection'], $sql);
                if (stristr($sql,"select")):
                    $nr = @mysqli_num_rows($result);
                endif;
                if (mysqli_connect_error()):
                    if ($var['debug']):
                        $err[] = "SQL : $sql";
                        $err[] = "ERROR : " . mysqli_connect_error();
                        admin::debug($err);
                        exit;
                    endif;
                endif;
            //endif;
        }
        public static function execute($sql)
        {
            global $var;
            $rs = @mysqli_query($var['db']['connection'], $sql);
			if (mysqli_error($var['db']['connection'])):
				if ($var['debug']):
					$err[] = "SQL : $sql";
					$err[] = "ERROR : " . mysqli_error($var['db']['connection']);
					admin::debug($err);
					exit;
				endif;
			endif;
        }
        ################################################
        ################# INSERT DATA ##################
        ################################################
        public static function insert($table_name, $fields = [])
        {
            global $var;
            $keys = implode('`, `', array_keys($fields));
            $values = '';
            $x=1;
            foreach ($fields as $field => $value) {
                // echo $field;
                $value = addslashes($value);
                $values .= $value;
                // $this->bindValues[] =  $value;
                if ($x < count($fields)) {
                    $values .= "', '";
                }
                $x++;
            }
    
            $sql = "INSERT INTO `{$var['table'][$table_name]}` (`{$keys}`) VALUES ('{$values}')";
            // echo $sql;exit;
            db::execute($sql);
        }
        ################################################
        ################# UPDATE DATA ##################
        ################################################
        public static function update($table_name, $fields = [], $id=null, $value_id=null)
        {
            global $var;
            $set ='';
            $x = 1;
            foreach ($fields as $column => $field) {
                $field = addslashes($field);
                $set .= "`$column` = '".$field."'";
                // $this->bindValues[] = $field;
                if ( $x < count($fields) ) {
                    $set .= ", ";
                }
                $x++;
            }

            $sql = "UPDATE `{$var['table'][$table_name]}` SET $set where $id = '$value_id'";
            // echo $sql;
            // exit;
            db::execute($sql);
        }
        ################################################
        ################# DELETE DATA ##################
        ################################################
        public static function delete($table_name,$id,$value_id)
        {
            global $var;

            $sql = "DELETE FROM `{$var['table'][$table_name]}` WHERE $id IN ('".$value_id."')";
            db::execute($sql);
        }
        public static function all_data($table)
        {
            global $var;
            $reply=[];
            // db::connect();
            $query = "SELECT * FROM " . $var['table'][$table];
            // echo $query;exit;
            $result = @mysqli_query($var['db']['connection'], $query);
            while($row = $result->fetch_assoc()){
                $reply[] = $row;
            }
            // echo json_encode($reply);
            return $reply;
        }
        public static function fetch($result)
        {
            global $var;
            return @mysqli_fetch_assoc($result);
        }
        public static function data_where()
        {
            global $var;
            $args = func_get_args();
            switch (func_num_args()):
                case 3:
                    $sql = "select $args[0] from ".$var['table'][$args[1]]." where $args[2] limit 1";
                    break;
                case 4:
                    $sql = "select $args[0] from ".$var['table'][$args[1]]." where $args[2] = '$args[3]' limit 1";
                    break;
                case 5:
                    $sql = "select $args[0] from ".$var['table'][$args[1]]." where $args[2] = '$args[3]' AND $args[4] limit 1";
                    break;
            endswitch;
            // echo $sql;
            // exit;
            db::query($sql, $rs, $nr);
            // echo $sql;exit;
            $record="";
            if ($nr):
                $record = db::fetch($rs);
                $record = $record[$args[0]];
            endif;
            return $record;
        }
        public static function data_record(){
            global $var;
            $args = func_get_args();
            switch (func_num_args()):
                case 2:
                    $sql = "select * from ".$var['table'][$args[0]]." where $args[1] limit 1";
                    break;
                case 3:
                    $sql = "select * from ".$var['table'][$args[0]]." where $args[1] = '$args[2]' limit 1";
                    break;
                case 4:
                    $sql = "select * from ".$var['table'][$args[0]]." where $args[1] = '$args[2]' AND $args[3] limit 1";
                    break;
            endswitch;
            // echo $sql;
            // exit;
            if (!stristr($sql,"union")):
                db::query($sql, $rs, $nr);
            endif;
            if ($nr):
                $record = db::fetch($rs);
            else:
                $record[0] = "";
            endif;
            //unset($rs);
            return $record;
        }
        public static function data_record_select()
        {
            global $var;
            $args = func_get_args();
            switch (func_num_args()):
                case 2:
                    @$sql = "select $args[0] from ".$var['table'][$args[1]];
                    break;
                case 3:
                    @$sql = "select $args[0] from ".$var['table'][$args[1]]." where $args[2]";
                    break;
                case 4:
                    @$sql = "select $args[0] from ".$var['table'][$args[1]]." where $args[2] = '$args[3]'";
                    break;
                case 5:
                    @$sql = "select $args[0] from ".$var['table'][$args[1]]." where $args[2] = '$args[3]' $args[4]";
                    break;
            endswitch;
                    // echo $sql;
                    // exit;
            if (!stristr($sql,"union")):
                self::query($sql, $rs, $nr);
            endif;
            return $rs;
        }
    }
