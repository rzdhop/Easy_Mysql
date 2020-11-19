<?php
require_once "res/core_var.php";

class conn_Mysql {
    private $conn_ServerName = SERVERNAME;
    private $conn_username = USERNAME;
    private $conn_password = PASSWORD;

    public $_RETURN = array();
    public $conn = NULL;
    public $error = NULL;

    function __destruct()
    {
        $this->_del_();
    }
    
    public function sendQuery(string $sql_query)
    {
        $this->_RETURN = array();
        $result = $this->conn->query($sql_query);
        if(gettype($result) == "boolean"){
            if (!$result){throw new Exception($this->conn->error);}
            return $result;
        }
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($this->_RETURN, $row);
            }
        array_push($this->_RETURN, NULL);
        }
        return $this->_RETURN;
    }
    public function _init_()
    {
        $this->conn = new mysqli($this->conn_ServerName, $this->conn_username, $this->conn_password);
        if ($this->conn->connect_error)
        {
            $this->error = $this->conn->connect_error;
            return FALSE;
        }
        else 
        {
            return TRUE;
        }
    }

    public function _del_()
    {
        $this->conn->close();
    }
}