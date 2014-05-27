<?php

class Language_module extends Ai_core_module
{
    protected $module_name = 'language::core::language';

    protected $dependency_manager = array();

    protected $dependencies = array(
        'php-nlp-tools::NlpTools_Tokenizers_WhitespaceTokenizer::WhitespaceTokenizer',
    );

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
        $whitespace_tokenizer = new WhitespaceTokenizer();

        $tokenized = $whitespace_tokenizer->tokenize($input);

        foreach($tokenized as $k=>$token)
        {
            $parsed[$k] = $this->_define_word($token);
        }
    }

    protected function _define_word($word)
    {
        $part_of_speech = $this->_get_part_of_speech($word);

        return compact('part_of_speech');
    }

    protected function _get_part_of_speech()
    {
        return 'noun';
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
