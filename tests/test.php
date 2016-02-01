<?php
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../bootload.php');
require_once(dirname(__FILE__) . '/../core/classes/Ai_core_model.class.php');
require_once(dirname(__FILE__) . '/../core/models/Ai_io_buffer_model.class.php');

class AgentTest extends PHPUnit_Framework_TestCase
{
    function setUp() {
      global $connection_args;
      $this->buffer_model = new Ai_io_buffer_model($connection_args);
      $this->agent = ObjectRegistry::getByRegistryKey('AgentInfer'); 
    }

    function testSubmitMsgToAgent() {
        $message = "This, is a test?";
        $msg = $this->buffer_model->submitMsg($message,'agent');
        $this->assertTrue($message === $msg->msg);
    }

    function testAgentProcessedStatementTypes() {
        $this->agent->doProcessing();
        $this->processed = $this->agent->getProcessed();
        $this->assertTrue($this->processed["statement_types"] === array("command","question"));
        $this->assertTrue(array_keys($this->processed["statement_types_meta"]) === array(",","?"));
    }

    function testAgentProccessedWords() {
        $this->processed = $this->agent->getProcessed();
        $words = $this->processed["words_meta"];
        $this->assertEquals(key($words[0]), "This");
        $this->assertEquals(key($words[1]), "is");
        $this->assertEquals(key($words[2]), "a");
        $this->assertEquals(key($words[3]), "test");
    }

    function testfetchMsgFromAgent() {
        $fetch_result = $this->buffer_model->fetchLatest('agent');
        $this->assertTrue("I read This, is a test?" === $fetch_result[0]->msg);
    }
}


