<?php

class ObjectRegistry extends Registry
{
    public static function register($object_index, $object)
    {
        self::$registry[$object_index] = $object;
    }
}
