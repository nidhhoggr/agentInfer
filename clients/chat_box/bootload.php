<?php
require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(__FILE__) . '/../../core/vendors/SupraModel/SupraModel.class.php');
require_once(dirname(__FILE__) . '/../../core/models/Ai_io_buffer_model.class.php');
$buffer_model = new Ai_io_buffer_model($connection_args);
