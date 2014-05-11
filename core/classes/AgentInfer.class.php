<?php

class AgentInfer
{
    public function init()
    {
        $this->state = ObjectRegistry::getByRegistryKey('State');
        $this->processor = ObjectRegistry::getByRegistryKey('IO_Processor'); 
        $this->shutdownSignal = FALSE;
    }

    public function getState()
    {
        return $this->state; 
    } 

    public function process($input)
    {
        $response = $this->processor->processInput($input);
   
        return $response;
    }

    public function shutdown()
    {
        $this->shutdownSignal = TRUE;
    }

    public function hasShutdownSignal()
    {
        return $this->shutdownSignal;
    }

    public function beRandom()
    {
        Throw new Exception('Implement me'); 
    }
}
