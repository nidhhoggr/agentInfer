<?php
/**
* @author: joseph persie
*
* this is the base model class to configure and extend
* the configuration method must be implemented to set the 
* identifier and the table name. Basic crud operations can be performed
* by this model specified by the driver
*/

abstract class SupraModel {

    private
        $dbhost = "",
        $dbuser = "",
        $dbpassword = "",
        $dbname = "";

    function __construct($args) {
        $this->_setConnection($args);
        $this->setDriver($args['driver']);
        $this->_instantiateDriverModel();
        $this->configure();
    }

    abstract public function configure();

    private function _instantiateDriverModel() {

        $driverModelName = ucfirst($this->driver) . 'Model';

        require_once(dirname(__FILE__) . '/drivers/' . $this->driver . "/$driverModelName.class.php");

        $this->driverModel = new $driverModelName($this->dbname,$this->dbhost,$this->dbuser,$this->dbpassword,$this);

    }

    private function _setConnection($args) {

	$array_vars = array('dbname','dbhost','dbuser','dbpassword');

	foreach($array_vars as $av) {
	    if(!isset($args[$av]))
	        die("Must provide all 4 paramaters for a db connection");

            $this->$av = $args[$av];
	}
    }

    public function __call($method,$args = array()) {

        $this->driverModel->reinitialize($this);

        $callResult = null;

        $methodFound = false;

        $interfaces = array('Selection','Modification');

        foreach($interfaces as $interface) {
            
            $methods = $this->getInterfaceMethods($interface);

            if(in_array($method,$methods)) {
                $methodFound = true;
                $handler = strtolower($interface) . 'Handler';
                $callResult = $this->_makeCall($this->driverModel->$handler, $method, $args);
                break;
            }
        }

        if(!$methodFound)
            $callResult = $this->_makeCall($this->driverModel, $method, $args);

        return $callResult;
    }

    private function _makeCall($obj, $method, $args) { 

      if(count($args) == 0)
        $callResult = $obj->$method();
      else if(count($args) == 1)
        $callResult = $obj->$method($args[0]);
      else if(count($args) == 2)
        $callResult = $obj->$method($args[0], $args[1]);
      else 
        Throw new Exception("callable proxy methods can obtain no more than 2 args");

      return $callResult;
    }


    public function __set($name,$value) {

        $driver_vars = array(
            'dbname',
            'dbhost',
            'dbuser',
            'dbpassword',
            'driver',
            'driverModel'
        );

        if(!in_array($name,$driver_vars)) {
            $this->driverModel->$name = $value;
        }
        else {
            $this->$name = $value;
        }
    }

    private function getInterfaceMethods($interfaceName) {

        $methods = array(
            'Modification'=>array(
                'save',
                'delete',
                'update',
                'insert'
            ),
            'Selection'=>array(
                'find',
                'findBy',
                'findOneBy',
                'getQuery',
                'getLatest'
            ),
            'DriverModel'=>array(
                'setDebugMode',
                'getDebugMode',
                'setTable',
                'getTable',
                'setTableIndentifier',
                'getTableIndentifier',
                'bindObject'
            )
        );

        return $methods[$interfaceName];
    }

    public function setDriver($driver) {
        
        $this->driver = $driver;
    }
 
    public function getDatabase() {
      $this->driverModel->getDatabase(); 
    }
}
