<?php
require_once(dirname(__FILE__) . '/bootload.php');

$fetch = $_POST['fetch'];

$message = $_POST['message'];

if(!is_null($fetch))
{
    $fetch_result = $buffer_model->fetchLatest('agent');

    echo json_encode($fetch_result); 
}
elseif(!is_null($message))
{
    $msg = $buffer_model->submitMsg($message,'agent');

    echo json_encode($msg); 
}
