<?php

class Language_module extends Ai_core_module
{

    protected $module_name = 'language::core::language';

    public function init()
    {
        $this->State = ObjectRegistry::getByRegistryKey('State');

        $fingerprint = $this->State->getStateByKey('fingerprint');

        $default_language_row = $fingerprint['default_language'];

        $model_dir = $default_language_row->value . '/';

        $this->_register_models(dirname(__FILE__) . '/models/' . $model_dir);
    }

    public function perform($action_name, $input)
    {

    }

    public function evaluate($input)
    {

    }

    public function explore()
    {

    }

    public function save_state()
    {

    }

    //notify the subject
    public function notify()
    {

    }

    public function install()
    {

    }

}
