<?php

class Ai_state_snapshots_model extends SupraModel
{
    public function configure()
    {
        $this->setTable('ai_state_snapshots');
    }

    public function takeSnapshot($snapshot)
    {
        $this->snapshot = $snapshot;
        $result = $this->save();
        return is_int($result);
    }
}
