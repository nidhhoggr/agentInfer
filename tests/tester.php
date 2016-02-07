<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../bootload.php');
require_once(dirname(__FILE__) . '/../core/classes/Ai_core_model.class.php');
require_once(dirname(__FILE__) . '/../core/models/Ai_io_buffer_model.class.php');

global $connection_args;

$agent = ObjectRegistry::getByRegistryKey('AgentInfer'); 
$message = "This, is a test?";
$msg = $agent->submitMsg($message,'agent');
assert($message === $msg->msg);
$agent->doProcessing();
$processed = $agent->getProcessed();
assert($processed["statement_types"] === array("command","question"));
assert(array_keys($processed["statement_types_meta"]) === array(",","?"));
$processed = $agent->getProcessed();
$words = $processed["words_meta"];
assert(key($words[0]) === "This");
assert(key($words[1]) === "is");
assert(key($words[2]) === "a");
assert(key($words[3]) === "test");
$fetch_result = $agent->getResponse('agent');
assert("I read This, is a test?" === $fetch_result[0]->msg);

