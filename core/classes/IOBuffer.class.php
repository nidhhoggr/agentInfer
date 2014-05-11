<?php

class IO_Buffer 
{

    public function init()
    {

        $this->models = ModelRegistry::getModels(array(
            'Ai_io_buffer'
        ));

        $this->IO_Processor = ObjectRegistry::getObject['IO_Processor'];
    }

    public function readFrom()
    {
        $readable = $this->models['Ai_io_buffer']->readNext();
        $this->IO_Processor->processInput($readable);
    }

    public function writeTo($writeable)
    {
        $this->models['Ai_io_buffer']->write($writable);
    }
}
