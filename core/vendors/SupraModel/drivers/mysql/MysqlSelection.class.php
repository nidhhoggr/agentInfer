<?php 

class MysqlSelection implements Selection {

    private 
        $querySql,
        $sqlFields,
        $sqlConditions;

    public function __construct(MysqlModel $model) {

        $this->model = $model;
    }

    private function _sqlizeFields($fields) {

        $this->sqlFields = (is_array($fields)) ? implode(', ',$fields) : $fields;
    }

    private function _sqlizeConditions($conditions=null) {

        if(!empty($conditions)) {

            if(is_array($conditions))
                $conditions = implode(" AND ", $conditions);

            $this->sqlConditions = " WHERE $conditions";
        }
    }

    public function getQuery() {
 
        return $this->querySql;
    }

    public function find($args = array()) {

        $args = array_merge(array('fields'=>'*','fetchArray'=>true),(array)$args);

        extract($args);

        return $this->findBy(compact('fields','order','fetchArray'));
    }

    public function findBy($args) {

        $args = array_merge(array('fields'=>'*','fetchArray'=>true),(array)$args);

        extract($args);

        if(isset($fields))
            $this->_sqlizeFields($fields);
        
        if(isset($conditions))
            $this->_sqlizeConditions($conditions);        

        $this->querySql = "SELECT ". $this->sqlFields . " FROM " . $this->model->getTable() 
                           . ' ' . $this->sqlConditions;

        if(isset($order))
            $this->querySql .= " $order";

        if($fetchArray) return $this->_fetchObjectFromQuery();
    }

    public function findOneBy($args) {
                    
        $args = array_merge((array)$args,array('fetchArray'=>false));

     
        if(isset($args['order']))
            if(!stristr($args['order'],'limit')) $args['order'] .= " LIMIT 1";
 
        $this->findBy($args);

        $result = $this->_fetchObjectFromQuery();

        if(count($result))
          return $result[0];
        else
          return false;
    }

    public function getLatest()
    {
        return $this->findOneBy(array(
            'order' => 'ORDER BY ' . $this->model->getTableIdentifier() . ' DESC '
        ));
    }

    private function _getResultFromQuery() {

        return $this->model->query($this->querySql, $this->model->getDebugMode());
    }

    private function _fetchObjectFromQuery() {

       $result = $this->_getResultFromQuery();

       $all = array();

       $fields = $this->sqlFields;


        while($row = mysql_fetch_object($result)) {

            $sm = new stdClass();
 
            if($fields == "*") {
              foreach($row as $k=>$col) {

                try {
                  $col = $this->model->unserializeArray($col);
                } catch(Exception $e) {
                  $col = false;
                  $this->_catchException($e, $row);
                }

                $sm->$k = $col;
              }

              $all[] = $sm;
            }
            else if(is_array($fields)) {
                foreach($fields as $field) {

                  $val = $row->$field;

                  try {
                    $val = $this->model->unserializeArray($val);
                  } catch(Exception $e) {
                    $val = false;
                    $this->_catchException($e, $row);
                  }

                  $sm->$field = $val;
                }

                $all[] = $sm;
            }
            else {

                $val = $row->$fields;
 
                try { 
                  $val = $this->model->unserializeArray($val);
                } catch(Exception $e) { 
                  $val = false;
                  $this->_catchException($e, $row);
                }

                $sm->$fields = $val;

                $all[] = $sm;
            }
        }

        return $all;
    }

    private function _catchException($e, $values) {
              
      $err = "Problem unpacking object of id: " . $values->{$this->model->getTableIdentifier()};

      $this->errors[] = $err . " " .$e->getMessage();
    }

    public function getErrors() {
        return $this->errors;
    }
}
