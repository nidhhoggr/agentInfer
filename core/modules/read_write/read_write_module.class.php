<?php

class Read_write_module Extends Ai_core_module
{
    protected $module_name = 'language::core::read_write';

    protected $processed;

    public function init($settings)
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
        $action_method = "__" . $action_name;

        return $this->{$action_method}($input); 
    }

    public function evaluate($input)
    {
        $this->evaluate_input($input);
    }

    public function evaluate_input($input)
    {
        $this->processed = $this->parent_module->evaluate($input);
    }

    public function evaluate_question($content) {

        $object_memory = ModuleRegistry::getModule('memory_object::core::memory_object');
        
        $result = $object_memory->models["Memory_object_question_model"]->findOneBy(array(
            "content" => "name like '$content'"
        ));

        return $result;
    }

    public function getProcessed() {

        return $this->processed;
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

    private function __read($msg)
    {
        $this->evaluate_input($msg);

        $result = "I read " . $msg;
    
        return $result;
    }

    private function __write() {

        $thought = $this->processed;

        $statement_types = $thought["statement_types"];

        foreach($thought["words_meta"] as $k=>$word) {
            $words[] = key($word);
        }

        $content = implode(" ", $words);

        if(in_array("question", $statement_types)) {

            $this->evaluate_question($content);
        }
    }
}
