<?php
require_once(dirname(__FILE__) . '/../bootload.php');

$agent = ObjectRegistry::getByRegistryKey('AgentInfer'); 
$message = "Are you married?";
$msg = $agent->submitMsg($message,'agent');
assert($message === $msg->msg);
$agent->doProcessing();
$processed = $agent->getProcessed();
assert($processed["statement_types"] === array("question"));
assert(array_keys($processed["statement_types_meta"]) === array("?"));
$processed = $agent->getProcessed();
$words = $processed["words_meta"];
assert(key($words[0]) === "Are");
assert(key($words[1]) === "you");
assert(key($words[2]) === "married");
$response = $agent->getResponse();
assert($response->msg ===  "I am single and happy");

