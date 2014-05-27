<?php

require_once(dirname(__FILE__) . '/../../../vendors/php-nlp-tools/autoloader.php');

// include the autoloader
// include '../autoloader.php';
//
use NlpTools\Tokenizers\WhitespaceTokenizer;
// use NlpTools\FeatureFactories\FunctionFeatures;
// use NlpTools\Documents\Document;
// use NlpTools\Documents\TokensDocument;
// use NlpTools\Documents\TrainingSet;
// use NlpTools\Optimizers\ExternalMaxentOptimizer;
// use NlpTools\Models\Maxent;
// use NlpTools\Classifiers\FeatureBasedLinearClassifier;
//

$whitespace_tokenizer = new WhitespaceTokenizer();

$testA = "I am funny";

$tokenized = $whitespace_tokenizer->tokenize($testA);

var_dump($tokenized);
