<?php

class Ai_io_buffer_model extends SupraModel
{
    public function configure()
    {
        $this->setTable('ai_io_buffer');
    }

    //for the client
    public function fetchLatest()
    {

        $latest = $this->findBy(array(
            'conditions'=>array(
                "msg_from = 'agent'",
                "msg_to = 'client'",
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
    public function submitMsg($msg)
    {
        $this->msg = $msg;
        $this->msg_from = 'client';
        $this->msg_to = 'agent';
        $id = $this->save(); 

        return $this->findOneBy(array('conditions'=>array('id = '.$id)));
    }
}
