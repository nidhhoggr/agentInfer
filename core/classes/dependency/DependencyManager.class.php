<?php 

class DependencyManager
{

    function init(DependencyMap $dependency_map)
    {
    
        $this->dependency_map = $dependency_map;

        $this->invokables = $this->dependency_map->getInvokable(); 

        $mapping = $this->dependency_map->getMapping();

        $mapping_iterator = $mapping->getIterator();
 
        while($mapping_iterator->valid())
        {
            $mapping = $mapping_iterator->current();
           
            extract($mapping);

            foreach( $dependencies as $dependency )
            {
                if($this->isInvokable($dependency))
                {
                    $object = new $dependency();
                }
                else
                {
                    $object = $dependency;
                }

                $this->dependents[$name][$dependency] = $object;
            }

            $mapping_iterator->next();
        }
    }
   
    public function loadAll()
    {

        var_dump($this->dependents);
         
        foreach($this->dependents as $name => $depedencies)
        {
            $dependent = new $name($this);
            $dependent->init();
        }
    }

    public function isInvokable($dependency_name)
    {
        $is_invokable = in_array($dependency_name, $this->invokables);

        return $is_invokable;
    }

    /**
     *  @return an array of dependencies for the calling class
     */
    public function getDependencies($className)
    {
        $my_dependencies = $this->dependents[$className];

        return $my_dependencies;
    }

}
