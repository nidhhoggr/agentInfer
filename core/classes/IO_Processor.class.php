<?php

class IO_Processor 
{

    private $processing = FALSE;

    public function init()
    {
        $this->State = ObjectRegistry::getByRegistryKey('State');

        $fingerprint = $this->State->getStateByKey('fingerprint');

        $default_io_processor_row = $fingerprint['default_io_processor'];

        $this->processor = ModuleRegistry::getModule($default_io_processor_row->value);

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
