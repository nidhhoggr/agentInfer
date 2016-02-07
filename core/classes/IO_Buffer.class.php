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

            $messages = $this->models['Ai_io_buffer']->fetchLatest($from);

            foreach($messages as $msg)
            {
                if($msg->msg == "SHUTDOWN")
                {
                    return FALSE;
                }

                $response = $this->IO_Processor->processInput($msg->msg);

                $this->writeTo($response, "client");
            }

            return TRUE;

        }
        else if($from === "agent") {

            return $this->models['Ai_io_buffer']->fetchLatest($from);
        }
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
