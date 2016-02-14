<?php
require_once(dirname(__FILE__) . '/../config.php');

require_once(dirname(__FILE__) . '/vendors/SupraModel/SupraModel.class.php');

spl_autoload_register(function ($class) {

    $dirs = array(
        'models',
        'classes'
    );

    foreach($dirs as $dir)
    {
        $file = dirname(__FILE__) . '/' . $dir . '/' . $class . '.class.php';

        if(file_exists($file))
        {
            require_once($file);
            break;
        }
    }
});

$models_dir = dirname(__FILE__) . '/models/';

foreach(glob($models_dir . '*_model.class.php') as $filename)
{
    $model_filename = str_replace($models_dir,'',$filename);

    $model_name = str_replace('.class.php','',$model_filename);

    $model_obj = new $model_name($connection_args);

    $model_key = str_replace('_model','',$model_name);

    if($debugMode) {
        echo "Registering Model By Key: $model_key -> $model_name \r\n";
    }
    
    ModelRegistry::register($model_key, $model_obj);
}

//load all of the modules now
$modules_dir = dirname(__FILE__) . '/modules/';

$module_dirs = array_filter(glob($modules_dir . '*'), 'is_dir');

foreach($module_dirs as $module_dir)
{
    $module_class_name = str_replace($modules_dir,'',$module_dir) . '_module';

    require_once($module_dir . '/' . $module_class_name . '.class.php');

    $module_obj = new $module_class_name();

    ModuleRegistry::register($module_obj);
}

$classesToRegister = array(
    'State',
    'IO_Buffer',
    'IO_Processor',
    'AgentInfer',
);

foreach($classesToRegister as $class)
{
    $obj = new $class();

    ObjectRegistry::register($class, $obj);
}

//lets not care about what was registered first
foreach($classesToRegister as $class)
{
    $object = ObjectRegistry::getByRegistryKey($class);

    $object->init();
}


foreach(ModuleRegistry::getRegistered() as $brain_segment => $module)
{
    foreach($module['core'] as $core_module)
    {
        $core_module->init(compact('connection_args'));

        $dependencies = $core_module->get_dependencies();

        foreach($dependencies as $dependency)
        {
            $dep_arr = explode('::', $dependency);

            if(count($dep_arr) !== 3)
            {
                Throw new exception('module dependecnies must contain a name, namespace and class as three sepaerate arguments');
            }

            $core_module->load_dependency($core_module, $dep_arr[0], $dep_arr[1], $dep_arr[2]);
        }
    }
}

