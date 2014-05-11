<?php

require_once(dirname(__FILE__) . "/../../interfaces/DriverModel.class.php");
require_once(dirname(__FILE__) . "/MysqlDB.class.php");

class MysqlModel extends MysqlDB implements DriverModel {

    private 
        $debugMode = false,
        $table_identifier = "id";

    public function __construct($base, $server, $user, $pass) {
        $this->dbArgs = compact('base','server','user','pass');
        parent::__construct($base, $server, $user, $pass);
        $this->_generateHandlers();
    }

    public function reinitialize($supraModelChild) {

      $this->setDatabase($this->dbArgs['base']);
    } 

    private function _generateHandlers() {

        $interfaces = array('Selection','Modification');

        foreach($interfaces as $interface) {

            $handlerVar = strtolower($interface) . 'Handler';
            $handlerClass = 'Mysql' . $interface;
            require_once(dirname(__FILE__) . "/../../interfaces/$interface.class.php");
            require_once(dirname(__FILE__) . "/$handlerClass.class.php");
            $this->$handlerVar = new $handlerClass($this);
        }
    }

    public function getDatabase() {
      return $this->dbArgs['base'];
    }

    public function setDebugMode($mode) {

        $this->debugMode = $mode;
    }

    public function getDebugMode() {

        return $this->debugMode;
    }

    public function setTable($table) {

        $this->table = $table;
    }

    public function getTable() {
    
        return $this->table;
    }

    public function setTableIdentifier($id) {

        $this->table_identifier = $id;
    }
  
    public function getTableIdentifier() {

        return $this->table_identifier;
    }

    public function serializeArray($val) {
      if(is_array($val))
        return base64_encode(serialize($val));
      else
        return $val;
    }

    public function unserializeArray($val) {
      if($this->isSerialized($val)) { 
        $nval = @unserialize(base64_decode($val));
        if(!$nval) {
          Throw new Exception("Problem serializing: " . $val);
        }
        $val = $nval;
      }
      return $val;
    }

    public function bindObject(SupraModel &$cobj, stdClass $obj) {

      foreach((array) $obj as $k=>$v) {
        $cobj->$k = $v;
      }
    }

    public function isSerialized($val) {
      $val = base64_decode($val);
      return (substr($val,0,2) == "a:") && (substr($val,-1) == "}");
    }
}
