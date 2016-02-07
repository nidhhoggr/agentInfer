<?php

class ModelRegistry extends Registry
{
    public static function register($model_key, $model_val)
    {
        self::$registry[$model_key] = $model_val;
    }

    public static function get($model_key) {

        return self::$registry[$model_key];
    }    
}
