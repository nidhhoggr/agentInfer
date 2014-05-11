<?php

abstract class Registry
{
    protected static $registry;

    public abstract static function register($registry_key, $registry_val);

    public static function getByRegistryKey($registry_key)
    {
        $registration = null;

        if (array_key_exists($registry_key, self::$registry))
        {
            $registration = self::$registry[$registry_key];
        } 
        else
        {
            Throw new Exception("Registry key $registry_key does not exist, called by " . get_called_class());
        }

        return $registration;
    }

    public static function fetchByRegistryKeys($registry_keys)
    {
        $registrations = array(); 

        foreach($registry_keys as $registry_key)
        {
            $registrations[$registry_key] = self::getByRegistryKey($registry_key);
        }

        return $registrations;
    }
}
