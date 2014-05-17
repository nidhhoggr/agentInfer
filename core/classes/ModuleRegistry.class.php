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

    public static function load($module_name)
    {
        $module_composition = explode('::',$module_name);

        if(count($module_composition) !== 3)
        {
            Throw new Exception('Invalid module composition: '.$module_name);
        }
 
        $brain_segment = $module_composition[0];

        $system_level = $module_composition[1];

        $module_name = $module_composition[2];

        if ( ! self::isLoaded($brain_segment, $system_level, $module_name))
        {
            self::invokeModule($brain_segment, $system_level, $module_name);
        }

        self::getModule($brain_segment, $system_level, $module_name);
    }

    public static function isLoaded($brain_segment, $system_level, $module_name)
    {
        $isLoaded = ( array_key_exists($system_level, self::$modules[$brain_segment])

        && (array_key_exists($module_name,self::$modules[$brain_segment][$system_level]) ));

        return $isLoaded;
    }

    public static function getModuleDir($system_level)
    {
        $dir = null;

        switch($system_level)
        {
            case 'core':
                $dir = dirname(__FILE__) . '/modules/';
                break;
            case 'extend':
                $dir = dirname(__FILE__) . '/../../modules/';
                break;
        }
        
        return $dir;
    }

    public static function invokeModule($brain_segment, $system_level, $module_name)
    {
        require_once(self::getModuleDir($system_level) . $module_name . '/' . $module_name . '.class.php');

        self::$modules[$brain_segment][$system_level][$module_name] = new $module_name();
    }

    public static function getModule($brain_segment, $system_level, $module_name)
    {
        $module = self::$modules[$brain_segment][$system_level][$module_name];

        return $module;
    }
}
