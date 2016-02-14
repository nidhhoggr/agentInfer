<?php
require_once(dirname(__FILE__) . '/../bootload.php');

$agent = ObjectRegistry::getByRegistryKey('AgentInfer'); 
$message = "What is your job?";
$msg = $agent->submitMsg($message,'agent');
assert($message === $msg->msg);
$agent->doProcessing();
$processed = $agent->getProcessed();
assert($processed["statement_types"] === array("question"));
assert(array_keys($processed["statement_types_meta"]) === array("?"));
$processed = $agent->getProcessed();
$words = $processed["words_meta"];
assert(key($words[0]) === "What");
assert(key($words[1]) === "is");
assert(key($words[2]) === "your");
assert(key($words[3]) === "job");

$response = $agent->getResponse();
assert($response->msg ===  "My job is a analyst");

