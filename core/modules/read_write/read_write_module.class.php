<?php

class Read_write_module Extends Ai_core_module
{
    protected $module_name = 'language::core::read_write';

    public function init()
    {
        //set the core language module as the parent module
        $this->parent_module = ModuleRegistry::getModule('language::core::language');

        //declare the observers here
        $object_memory = ModuleRegistry::getModule('memory_object::core::memory_object');

        //attach the observer
        $this->attach_observer($object_memory);
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
