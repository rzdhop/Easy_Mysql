<?php
require "Mysql_Handler/Handler.php";

class Mysql extends conn_Mysql{
    public $proc_conn = NULL;
    public $proc_DB = NULL;
    public $proc_sqliAws = array();
    
    function __construct(string $DB)
    {
        if(!$this->_init_()) 
        {
            echo "Fatal error :" . $this->error;
            die();
        }
        $this->SwitchDB($DB);
        $this->proc_conn = $this->conn;
    }

    function SwitchDB(string $DBname)
    {
        $this->proc_DB = $DBname;
        $this->proc_conn->select_db($this->proc_DB);
    }

    function ShowDB(bool $returnlist = FALSE)
    {
        $rep = $this->sendQuery("SHOW DATABASES;");
        $tmp = $rep[0];
        $this->proc_sqliAws = array();
        for($i = 0; true; $i++){
            array_push($this->proc_sqliAws, $tmp);
            if($rep[$i] == NULL){break;}
            $tmp = $rep[$i]['Database'];
            if(!$returnlist){echo $tmp."<br>";}
            else {array_push($this->proc_sqliAws, $tmp);}
        }
        if($returnlist){return $this->proc_sqliAws;}
        return NULL;
    }

    function ShowTables(bool $returnlist = FALSE)
    {
        $rep = $this->sendQuery("SHOW TABLES;");
        $tmp = $rep[0];
        $this->proc_sqliAws = array();
        for($i = 0; true; $i++){
            array_push($this->proc_sqliAws, $tmp);
            if($rep[$i] == NULL){break;}
            $tmp = $rep[$i]['Table'];
            if(!$returnlist){echo $tmp."<br>";}
            else {array_push($this->proc_sqliAws, $tmp);}
        }
        if($returnlist){return $this->proc_sqliAws;}
        return NULL;
    }

    function CreateTable(string $tableName, array $tables)
    {
        $tables = func_num_args();
        $rep = $this->sendQuery("CREATE TABLE $tableName ()");
    }

    function sendQuery(string $sql_query)
    {
        $result = $this->proc_conn->query($sql_query);
        try{if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  array_push($this->proc_sqliAws, $row);
                }
            array_push($this->proc_sqliAws, NULL);
            }
        }catch (Exception $e){
            return TRUE;
        }
        return $this->proc_sqliAws;
    }
}