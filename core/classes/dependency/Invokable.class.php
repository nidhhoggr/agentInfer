<?php

class Invokable
{

    public function __construct(DependencyManager $dm)
    {

        $this->dependency_manager = $dm;

    }

    public function init()
    {
        $this->dependencies = $this->dependency_manager->getDependencies(get_called_class());

        var_dump(get_called_class() . ": I have these ". var_dump(array_keys($this->dependencies),true));

    }

}
