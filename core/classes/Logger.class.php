<?php

class Logger
{

    public function init($logged_by)
    {
        $this->logged_by = $logged_by;

        $this->models = ModelRegistry::getModels(array(
            'Ai_logs'
        ));
    }

    private function _baseLog($type,$msg, $obj)
    {
        $model = $this->models['Ai_logs'];
        $model->logged_by = $logged_by; 
        $model->log_msg = $msg;
        $model->log_type = $type;
        $model->log_obj = $obj;   
        $model->save(); 
    }

    public function logError(Exception $e)
    {
        $this->_baseLog('error',$e->getMessage(),serialize($e));
    }
}
