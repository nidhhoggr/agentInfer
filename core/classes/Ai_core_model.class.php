<?php

class Ai_core_model extends SupraModel
{
    public function configure()
    {
        $table_name = str_replace("_model", "", strtolower(get_called_class()));

        $this->setTable($table_name);
    }
}
