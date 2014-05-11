<?php

class ModelRegistry
{

    private static $models = array();

    public static function registerModel(SupraModel $model)
    {
        $model_index = str_replace('_model','',get_class($model));
        self::$models[$model_index] = $model;
    }

    public static function getModels($model_names)
    {
        $models = array(); 

        foreach($model_names as $model_name)
        {
            $models[$model_name] = self::$models[$model_name];
        }

        return $models;
    }
}
