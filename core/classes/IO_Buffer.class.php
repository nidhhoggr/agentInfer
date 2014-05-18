<?php

class IO_Buffer 
{

    public function init()
    {
        $this->models = ModelRegistry::fetchByRegistryKeys(array(
            'Ai_io_buffer'
        ));

        $this->IO_Processor = ObjectRegistry::getByRegistryKey('IO_Processor');
    }

    public function readFrom()
    {
        $messages = $this->models['Ai_io_buffer']->fetchLatest('client');

        foreach($messages as $msg)
        {
            if($msg->msg == "SHUTDOWN")
            {
                return FALSE;
            }

            $response = $this->IO_Processor->processInput($msg->msg);

            $this->writeTo($response);
        }
        
        return TRUE;
    }

    public function writeTo($msg)
    {
        $this->models['Ai_io_buffer']->submitMsg($msg, 'client');
    }
}
