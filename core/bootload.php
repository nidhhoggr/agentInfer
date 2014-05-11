<?php
require_once(dirname(__FILE__) . '/../config.php');

require_once('vendors/SupraModel/SupraModel.class.php');

spl_autoload_register(function ($class) {

    $dirs = array(
        'models',
        'classes',
        'modules'
    );

    foreach($dirs as $dir)
    {
        $file = $dir . '/' . $class . '.class.php';

        if(file_exists($file))
        {
            require_once($file);
            break;
        }
    }
});

foreach(glob('./models/*_model.class.php') as $filename)
{
    $model_filename = str_replace('./models/','',$filename);
    $model_name = str_replace('.class.php','',$model_filename);
    $model_obj = new $model_name($connection_args);
    ModelRegistry::registerModel($model_obj);
}

$state = new State();

$state->init();

$fingerPrint = $state->getStateByKey('fingerprint');

//$state->setStateByKey('randomness',array('this','is','random'));

$randomness = $state->getStateByKey('randomness'); 
var_dump($state);

$state->takeSnapshot(); 
