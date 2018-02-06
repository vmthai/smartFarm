<?php

class AppService {
    public $connectDB;
    
    public function openDb() {
        $this->connectDB = new mysqli(_DB_HOST_, _DB_USERNAME_, _DB_PASSWORD_, _DB_DATABASE_);

        /* check connection */
        if ($this->connectDB->connect_errno) {
            //printf("Connect failed: %s\n", $mysqli->connect_error);
            throw new Exception("Connection to the database server failed!");
        }
        if (!$this->connectDB->set_charset("utf8")) {
            throw new Exception("Error loading character set utf8!");
        }
    }
    
    public function closeDb() {
        $this->connectDB->close();
    }

    public function freeResultDb($result) {
        $result->free_result();
    }

    public function queryDB($query){
        $result = $this->connectDB->query($query);
        return $result;
    }

    public function realEscapeString($escapestring){
        $result = $this->connectDB->real_escape_string($escapestring);
        return $result;
    }

    public function insertID(){
        $result = $this->connectDB->insert_id;
        return $result;
    }

    public function fetchObjectAll($query) {
        $rows = array();
        $result = $this->queryDB($query);
        // If query failed, return `false`
        if($result === false) {
            return false;
        }
        // If query was successful, retrieve all the rows into an array
        while ($row = $result->fetch_object()) {
            $rows[] = $row;
        }
        $this->freeResultDb($result);
        return $rows;
    }

    public function fetchObject($query) {
        $rows = array();
        $result = $this->queryDB($query);
        // If query failed, return `false`
        if($result === false) {
            return false;
        }
        // If query was successful, retrieve all the rows into an array
        $rows = $result->fetch_object();
        $this->freeResultDb($result);
        return $rows;
    }

    public function fetchAssocAll($query) {
        $rows = array();
        $result = $this->queryDB($query);
        // If query failed, return `false`
        if($result === false) {
            return false;
        }
        // If query was successful, retrieve all the rows into an array
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $this->freeResultDb($result);
        return $rows;
    }

    public function fetchAssoc($query) {
        $rows = array();
        $result = $this->queryDB($query);
        // If query failed, return `false`
        if($result === false) {
            return false;
        }
        // If query was successful, retrieve all the rows into an array
        $rows = $result->fetch_assoc();
        $this->freeResultDb($result);
        return $rows;
    }

    public function fetchRowAll($query) {
        $rows = array();
        $result = $this->queryDB($query);
        // If query failed, return `false`
        if($result === false) {
            return false;
        }
        // If query was successful, retrieve all the rows into an array
        while ($row = $result->fetch_row()) {
            $rows[] = $row;
        }
        $this->freeResultDb($result);
        return $rows;
    }

    public function fetchRow($query) {
        $rows = array();
        $result = $this->queryDB($query);
        // If query failed, return `false`
        if($result === false) {
            return false;
        }
        // If query was successful, retrieve all the rows into an array
        $rows = $result->fetch_row();
        $this->freeResultDb($result);
        return $rows;
    }

    public function fetchSelectOption($query) {
        $rows = array();
        $result = $this->queryDB($query);
        // If query failed, return `false`
        if($result === false) {
            return false;
        }
        // If query was successful, retrieve all the rows into an array
        while ($row = $result->fetch_row()) {
            $rows[$row[0]] = $row[1];
        }
        $this->freeResultDb($result);
        return $rows;
    }
    public function setDataInsert($arr) {
        unset($arr['id']);
        $fields = ''; $values = '';
        foreach($arr as $x=>$v)
        {
            if($v==''){
                $fields .= ",`$x`";
                $values .= ",NULL"; 
            } else {
                $fields .= ",`$x`";
                $values .= ",'$v'";              
            }
        }
          $data['fields'] = substr($fields, 1);
          $data['values'] = substr($values, 1);

        return $data;
    }

    public function setDataUpdate($arr) {
        unset($arr['id']);
        $fields = ''; $values = '';
        foreach($arr as $x=>$v)
            {
                if($v==''){
                    $fields .= ",`$x`=NULL";  
                } else {
                    $fields .= ",`$x`='$v'";                
                }
            }
          $data = substr($fields, 1);
        return $data;
    }

    public function fncConvertDateFormat($val) {
        if($val==''){
            $return = '';
        } else {
            list($st_yy,$st_mm,$st_dd) = explode('-', $val);
            $return = $st_dd.'/'.$st_mm.'/'.(intval($st_yy)+543);
        }

        return $return;
    }  

    public function fncConvertPassword($val) {
        $return = md5($val);
        return $return;
    }


}
?>
