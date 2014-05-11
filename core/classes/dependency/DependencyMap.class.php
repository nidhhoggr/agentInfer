<?php

/**
 *
  Mapping = array(
     'dependent_name' => (String registered above)
     'dependcies' => array(
        //an array of class names
     )
  )
  Invokable = array(
    //an array of class names that must be invoked
  )
     *
 */

class DependencyMap
{

    public function init()
    {
        $this->mapping = new ArrayObject(); 
        $this->invokable = array();
    }

    public function getMapping()
    {
        return $this->mapping;
    }

        
    public function getInvokable()
    {
        return $this->invokable;
    }

    public function setDependentName($name)
    {
        $this->dependentName = $name;
    }

    public function setDependencies($dependencies)
    {
        $this->dependencies = $dependencies;
    }

    public function setIsInvokable($isInvokable)
    {
        $this->isInvokable = $isInvokable;
    }

    public function register()
    {

        $this->mapping[] = array(
            'name' => $this->dependentName,
            'dependencies' => $this->dependencies
        );

        if($this->isInvokable)
        {
            $this->invokable[] = $this->dependentName;
        }
    }
}
