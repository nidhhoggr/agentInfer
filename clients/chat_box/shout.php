<?php
require_once(dirname(__FILE__) . '/../../bootload.php');

$fetch = $_POST['fetch'];

$message = $_POST['message'];

$agent = ObjectRegistry::getByRegistryKey('AgentInfer');

exec("pgrep agentinferd", $pids);

if(empty($pids)) {
    exec('./../../agentinferd > /dev/null 2>&1 & echo $!');
}

if(!is_null($fetch))
{
    $response = $agent->getResponse();

    echo json_encode(array("msg"=>$response)); 
}
elseif(!is_null($message))
{
    $msg = $agent->submitMsg($message,'agent');

    echo json_encode($msg); 
}
