<?php
require_once(dirname(__FILE__) . '/../config.php');

require_once(dirname(__FILE__) . '/vendors/SupraModel/SupraModel.class.php');

spl_autoload_register(function ($class) {

    $dirs = array(
        'models',
        'classes',
        'modules'
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

    ModelRegistry::register($model_key, $model_obj);
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
