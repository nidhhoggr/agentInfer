<?php

class Ai_state_snapshots_model extends Ai_core_model
{
    public function takeSnapshot($snapshot)
    {
        $this->snapshot = $snapshot;
        $result = $this->save();
        return is_int($result);
    }
}
