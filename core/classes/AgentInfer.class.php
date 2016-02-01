<?php

class AgentInfer
{
    public function init()
    {
        $this->state = ObjectRegistry::getByRegistryKey('State');
        $this->buffer = ObjectRegistry::getByRegistryKey('IO_Buffer'); 
        $this->shutdownSignal = FALSE;
    }

    public function getState()
    {
        return $this->state; 
    } 

    public function getProcessed()
    {
        return $this->processed;
    }

    public function doProcessing()
    {
        $continue = $this->buffer->readFrom(); 

        $this->processed = $this->buffer->getProcessed();

        if(!$continue) 
        {
            $this->shutdown();
        }
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
