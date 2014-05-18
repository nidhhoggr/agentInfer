<?php

class Ai_io_buffer_model extends SupraModel
{
    public function configure()
    {
        $this->setTable('ai_io_buffer');
    }

    function getReciprocal($who)
    {
        if($who == "agent") return "client";
        elseif($who == "client") return "agent";
    }

    //for the client
    public function fetchLatest($msg_from)
    {
        $msg_to = $this->getReciprocal($msg_from);

        $latest = $this->findBy(array(
            'conditions'=>array(
                "msg_from = '{$msg_from}'",
                "msg_to = '{$msg_to}'",
                "is_processed = 0"
            )
        ));

        foreach($latest as $msg)
        {
            $this->id = $msg->id;
            $this->is_processed = TRUE;
            $this->save(); 
        }

        return $latest;
    }

    //for the client
    public function submitMsg($msg, $msg_to)
    {
        $this->id = null;
        $this->is_processed = FALSE;
        $this->msg = $msg;
        $this->msg_from = $this->getReciprocal($msg_to);
        $this->msg_to = $msg_to;
        $id = $this->save(); 

        return $this->findOneBy(array('conditions'=>array('id = '.$id)));
    }
}
