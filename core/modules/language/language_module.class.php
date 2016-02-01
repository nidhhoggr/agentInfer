<?php

class Language_module extends Ai_core_module
{
    protected $module_name = 'language::core::language';

    protected $dependency_manager = array();

    protected $dependencies = array(
        'php-nlp-tools::NlpTools_Tokenizers_WhitespaceTokenizer::WhitespaceTokenizer',
    );

    public function init($settings)
    {
        $this->State = ObjectRegistry::getByRegistryKey('State');

        $fingerprint = $this->State->getStateByKey('fingerprint');

        $default_language_row = $fingerprint['default_language'];

        $model_dir = $default_language_row->value . '/models';

        $this->_register_models(dirname(__FILE__) . '/' . $model_dir . '/', $settings);
    }

    public function perform($action_name, $input)
    {

    }

    public function evaluate($input)
    {
        $whitespace_tokenizer = new \NlpTools\Tokenizers\WhitespaceTokenizer();

        $punctuation = array("?","!",",",".");

        preg_match_all('/[?!.,]/u', $input, $tokenized["punc"]);

        $tokenized["words"] = $whitespace_tokenizer->tokenize($input);

        foreach($tokenized["words"] as $k=>$token)
        {
            foreach($punctuation as $punc_char) {
                $token = str_replace($punc_char, "", $token);
            }

            $parsed["words_meta"][$k] = $this->_define_word($token);

            $object_info = $this->_get_object($token);

            if($object_info) {

                $parsed["object_meta"][$token] = $object_info["meta"];

                $parsed["objects"][$token] = $object_info["items"];
            }
        }

        $parsed["statement_types_meta"] = $this->_get_statement_type($tokenized["punc"][0]);

        foreach($parsed["statement_types_meta"] as $statement_types) {
  
            foreach($statement_types as $st) {
                $parsed["statement_types"][] = $st->type;
            }
        }

        $parsed["statement_types_meta"] = $this->_get_statement_type($tokenized["punc"][0]);
        
        return $parsed;
    }

    protected function _define_word($word)
    {
        return $this->_get_definition($word);
    }

    protected function _get_definition($word)
    {
        $result = $this->models["Language_en_dictionary_model"]->findOneBy(array(
            "conditions" => "word like '$word'"
        ));

        return array($word=>$result);
    }

    protected function _get_object($word) {

        $objects = array();

        $result = $this->models["Language_en_objects_model"]->findOneBy(array(
          "conditions" => "name like '$word'"
        ));

        if(!$result) return false;

        $objects['meta'] = $result;

        foreach($result as $trait_name=>$val) {
          if(strstr($trait_name, "is_")) {  
            if(!empty($val))
              $objects['items'][] = $trait_name; 
          }
        }

        return $objects;
    }

    protected function _get_statement_type($punc_tokens) {

        $statement_types = array();

        foreach($punc_tokens as $token) {

          $token = $token[0];

          $result = $this->models["Language_en_statement_types_model"]->findBy(array(
            "conditions" => "designator like '%$token%'"
          ));

          $statement_types[$token] = $result;
        }

        return $statement_types;
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
