<?php

require_once(dirname(__FILE__) . '/../../bootload.php');

$fetch = $_POST['fetch'];

$message = $_POST['message'];

$model = ModelRegistry::getByRegistryKey('Ai_io_buffer');

if(!is_null($fetch))
{
    $fetch_result = $model->fetchLatest();

    echo json_encode($fetch_result); 
}
elseif(!is_null($message))
{
    $msg = $model->submitMsg($message);

    echo json_encode($msg); 
}
