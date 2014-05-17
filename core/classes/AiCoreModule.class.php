<?php

class Ai_core_module {

    //store all of the associated models in an array
    protected $models;

    //perform initialization 
    abstract public function init() {}

    //perform an action on a set of input data
    abstract public function perform($action_name, $input) {}

    //evaulate input data 
    abstract public function evaluate($input) {}

    abstract public function explore() {}

    
    abstract public function save_state() {
        
    }
}
