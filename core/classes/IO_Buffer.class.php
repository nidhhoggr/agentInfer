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

    public function readFrom($from)
    {
        if($from === "client") {

            $msg = $this->models['Ai_io_buffer']->fetchLatest($from);

            if(!$msg || empty($msg->msg)) return TRUE;

            if($msg->msg == "SHUTDOWN")
            {
                return FALSE;
            }

            $this->IO_Processor->processInput($msg->msg);

            $response = $this->IO_Processor->getResponse();

            $this->writeTo($response, "client");

            return TRUE;

        }
        else if($from === "agent") {

            return $this->models['Ai_io_buffer']->fetchLatest($from);
        }
    }

    public function getResponse()
    {
        return $this->readFrom("agent");
    }

    public function getProcessed()
    {
        return $this->IO_Processor->getProcessed();
    }

    public function writeTo($msg, $to)
    {
        $result = $this->models['Ai_io_buffer']->submitMsg($msg, $to);

        return $result;
    }
}
