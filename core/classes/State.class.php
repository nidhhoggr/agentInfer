<?php

class State
{
    public function init()
    {
        $this->_registerDependencies();
        $this->_reviveFromSnapshot();
        $this->_registerFingerprint();
    }

    private function _registerDependencies()
    {
        $this->logger = new Logger(get_class());
        $this->models = ModelRegistry::getModels(
            array(
                'Ai_fingerprints',
                'Ai_state_snapshots'
            )
        );
    }
  
    private function _registerFingerprint()
    {
        $fingerprints = $this->models['Ai_fingerprints']->find();
        
        $fingerprintArr = array(); 
        
        foreach($fingerprints as $key => $fingerprint)
        {
            $fingerprintArr[$key] = $fingerprint;
        }
   
        $this->state['fingerprint'] = $fingerprintArr;
    }

    public function setStateByKey($state_key, $state_val)
    {
        $this->state[$state_key] = $state_val;
    }

    public function getStateByKey($state_key)
    {
        return $this->state[$state_key];
    }

    private function _reviveFromSnapshot()
    {
        $snapshot = $this->models['Ai_state_snapshots']->getLatest(); 

        $this->state = $snapshot->snapshot;
    }

    public function takeSnapshot()
    {

        unset($this->state['fingerprint']);

        try
        {
            $result = $this->models['Ai_state_snapshots']->takeSnapshot($this->state);
        }
        catch(Database $e)
        {
            $this->logger->logError($e);

            $result = false;
        }

        return $result;
    }
}
