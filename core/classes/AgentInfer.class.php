<?php

class AgentInfer
{
    public function init()
    {
        $this->state = ObjectRegistry::getByRegistryKey('State');
        $this->buffer = ObjectRegistry::getByRegistryKey('IO_Buffer'); 
        $this->shutdownSignal = FALSE;
    }

    public function submitMsg($msg, $to) {
        return $this->buffer->writeTo($msg, $to);
    } 

    public function getResponse($from) {
        return $this->buffer->readFrom($from);
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
        $continue = $this->buffer->readFrom("client"); 

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
