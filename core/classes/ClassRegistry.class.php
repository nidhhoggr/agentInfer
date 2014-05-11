<?php

class ObjectRegistry
{
    private static $objects = array();

    public static function register($object_index, Object $object)
    {
        self::$objects[$object_index] = $object;
    }

    public static function getObject($object_index)
    {
        $object = self::$objects[$object_index];

        return $object;
    }
}
