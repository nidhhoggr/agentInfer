<?php

class IO_Processor 
{

    private $processing = FALSE;

    public function init()
    {
        $this->State = ObjectRegistry::getByRegistryKey('State');
        $default_processor_val = $this->State->getStateByKey('default_processor');
        $this->processor = ModuleRegistry::load($default_processor_val);
        $logger = new Logger(__CLASS__);
    }

    public function isProcessing()
    {
        return $this->processing;
    }

    public function processInput($input)
    {
        $this->processing = TRUE;

        try
        {
            $response = $this->processor->process($input);
        }
        catch(Exception $e)
        {
            $this->logger->logError($e);
        }

        $this->processing = FALSE;
    }
}
