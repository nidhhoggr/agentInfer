<?php

class Ai_io_buffer_model extends Ai_core_model
{
    function getReciprocal($who)
    {
        if($who == "agent") return "client";
        elseif($who == "client") return "agent";
    }

    //for the client
    public function fetchLatest($msg_from)
    {
        $msg_to = $this->getReciprocal($msg_from);

        $msg = $this->findOneBy(array(
            'conditions'=>array(
                "msg_from = '{$msg_from}'",
                "msg_to = '{$msg_to}'",
                "is_processed = 0"
            )
        ));

        if($msg) {

            $this->id = $msg->id;
            $this->msg = $msg->msg;
            $this->msg_from = $msg->msg_from;
            $this->msg_to = $msg->msg_to;
            $this->is_processed = TRUE;
            $this->save(); 
        }

        return $msg;
    }

    //for the client
    public function submitMsg($msg, $msg_to)
    {
        $this->id = NULL;
        $this->is_processed = FALSE;
        $this->msg = $msg;
        $this->msg_from = $this->getReciprocal($msg_to);
        $this->msg_to = $msg_to;
        $id = $this->save(); 

        return $this->findOneBy(array('conditions'=>array('id = '.$id)));
    }
}
