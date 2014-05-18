<?php

class ModuleRegistry
{
    private static $modules = array();

    private static $brainSegments = array(
        'language',
        'movement',
        'emotion',
        'sensory',
        'intellect',
        'ego',
        'context',
        'object_memory',
        'knowledge',
        'base_memory'
    );

    public static function init()
    {
        //load the core module segments
        foreach(self::$brainSegments as $brainSegment)
        {
            self::$modules[$brainSegment]['core'] = array();
        }
    }

    public static function get_module_composition($module_name)
    {
        $module_composition = explode('::',$module_name);

        if(count($module_composition) !== 3)
        {
            Throw new Exception('Invalid module composition: '.$module_name);
        }
 
        $brain_segment = $module_composition[0];

        $system_level = $module_composition[1];

        $module_name = $module_composition[2];

        return compact('brain_segment','system_level','module_name');
    }

    public static function isRegistered($module_name)
    {
        extract(self::get_module_compposition($module_name));

        $isLoaded = ( array_key_exists($system_level, self::$modules[$brain_segment])

        && (array_key_exists($module_name,self::$modules[$brain_segment][$system_level]) ));

        return $isLoaded;
    }

    public static function register(Ai_core_module $module_obj)
    {
        $module_name = $module_obj->getName();

        $composition = self::get_module_composition($module_name);

        extract($composition);

        self::$modules[$brain_segment][$system_level][$module_name] = $module_obj;
    }

    public static function getRegistered()
    {
        return self::$modules;
    }

    public static function getModule($module_name)
    {
        extract(self::get_module_composition($module_name));

        $module = self::$modules[$brain_segment][$system_level][$module_name];

        return $module;
    }
}
