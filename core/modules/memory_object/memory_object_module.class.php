<?php

class Memory_object_module extends Ai_core_module
{
    protected $module_name = 'memory_object::core::memory_object';

    public function init($settings)
    {
        $this->_register_models(dirname(__FILE__) . '/models/', $settings);
    }

    public function perform($action_name, $input)
    {

    }

    public function evaluate($input)
    {

    }

    public function explore()
    {

    }

    public function save_state()
    {

    }

    //notify the subject
    public function notify()
    {

    }

    public function install()
    {

    }

}
