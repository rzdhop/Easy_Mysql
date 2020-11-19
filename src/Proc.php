<?php
require_once "Mysql_Handler/Handler.php";

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
        $this->proc_conn = &$this->conn;
        $this->SwitchDB($DB);
        
    }
    /////////////////////////////////////// Set /////////////////////////////////
    function SwitchDB(string $DBname)
    {
        $this->proc_DB = $DBname;
        mysqli_select_db($this->proc_conn, $this->proc_DB);
    }
    function InjectIntable(string $tableName, array $values)
    {
        $QueryPartvalues = '';
        $QueryPartcolumns = '';
        $columns = $this->describeTable($tableName, $returnlist = TRUE);
        for ($x = 0; $x <= count($columns)-1; $x++){
            if($x == count($columns)-1){
                $QueryPartcolumns .= (string)$columns[$x];
                break;
            }
            $QueryPartcolumns .= (string)$columns[$x] . ', ';
        }
        for ($x = 0; $x <= count($values)-1; $x++){
            if($x == count($values)-1){
                $QueryPartvalues .= $values[$x];
                break;
            }
            if (gettype($values[$x]) == "int"){
                $QueryPartvalues .= (int)$values[$x] . ', ';
            }else{
                $QueryPartvalues .= '"'.(string)$values[$x] . '", ';
            }
            
        }
        $Query = "Insert into $tableName($QueryPartcolumns) VALUES ($QueryPartvalues);";
        $rep = $this->sendQuery($Query);
    }
    /////////////////////////////////////// Show ////////////////////////////////
    function ShowDB(bool $returnlist = FALSE)
    {
        $rep = $this->sendQuery("SHOW DATABASES;");
        $tmp = $rep[0];
        $this->proc_sqliAws = array();
        for($i = 0; $rep[$i] != NULL; $i++){
            array_push($this->proc_sqliAws, $tmp);
            $tmp = $rep[$i]['Database'];
            if(!$returnlist){echo $tmp."<br>";}
            else {array_push($this->proc_sqliAws, $tmp);}
        }
        if($returnlist){return $this->proc_sqliAws;}
    }
    function ShowTables(bool $returnlist = FALSE)
    {
        $rep = $this->sendQuery("SHOW TABLES;");
        $tmp = $rep[0];
        $this->proc_sqliAws = array();
        for($i = 0; $rep[$i] != NULL; $i++){
            $tmp = $rep[$i]["Tables_in_$this->proc_DB"];
            if(!$returnlist){echo $tmp."<br>";}
            else {array_push($this->proc_sqliAws, $tmp);}
        }
        if($returnlist){return $this->proc_sqliAws;}
    }
    function describeTable(string $table, bool $returnlist = FALSE)
    {
        $rep = $this->sendQuery("DESCRIBE $table;");
        $this->proc_sqliAws = array();
        for($i = 0; $i < count($rep) and $rep[$i] != NULL; $i++){
            $tmp = $rep[$i]["Field"];
            if(!$returnlist){echo $tmp."<br>";}
            else {array_push($this->proc_sqliAws, $tmp);}
        }
        if($returnlist){return $this->proc_sqliAws;}
    }
    function selectfromTable(string $table, array $which, bool $returnlist = FALSE)
    {
        $Querypart = '';
        $columns = $this->describeTable($table, TRUE);
        for ($x = 0; $x <= count($which)-1; $x++){
            if($x == count($which)-1){
                $Querypart .= $which[$x];
                break;
            }
            $Querypart .= (string)$which[$x] . ', ';
        }
        $rep = $this->sendQuery("SELECT $Querypart FROM $table;");
        $this->proc_sqliAws = array();
        $tmp = array();
        for($i = 0; $i < count($rep) and $rep[$i] != NULL; $i++){
            for($x = 0; $x < count($columns); $x++){
                if(!$returnlist){echo $rep[$i][$columns[$x]]. ' ';}
                array_push($tmp, $rep[$i][$columns[$x]]);
            }
            array_push($this->proc_sqliAws, $tmp);
            $tmp = [];
            if(!$returnlist){echo "<br>";}
        }
        if($returnlist){return $this->proc_sqliAws;}
    } 
    /////////////////////////////////////// Count ///////////////////////////////
    function getHowManyColumns(string $table)
    {
        $columns = $this->describeTable($table, TRUE);
        return count($columns);
    }
    function getHowManyTables()
    {
        $tables = $this->ShowTables(TRUE);
        return count($tables);
    }
    function getHowManyDB()
    {
        $DBs = $this->ShowDB(TRUE);
        return count($DBs);
    }
}