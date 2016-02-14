<?php
require_once(dirname(__FILE__) . '/../bootload.php');

class AgentTestAnswerQuestionJob extends PHPUnit_Framework_TestCase
{
    function setUp() {
      $this->agent = ObjectRegistry::getByRegistryKey('AgentInfer'); 
    }

    function testSubmitMsgToAgent() {
        $message = "What is your job?";
        $msg = $this->agent->submitMsg($message,'agent');
        $this->assertTrue($message === $msg->msg);
    }

    function testAgentProcessedStatementTypes() {
        $this->agent->doProcessing();
        $this->processed = $this->agent->getProcessed();
        $this->assertTrue($this->processed["statement_types"] === array("question"));
        $this->assertTrue(array_keys($this->processed["statement_types_meta"]) === array("?"));
    }

    function testAgentProccessedWords() {
        $this->processed = $this->agent->getProcessed();
        $words = $this->processed["words_meta"];
        $this->assertEquals(key($words[0]), "What");
        $this->assertEquals(key($words[1]), "is");
        $this->assertEquals(key($words[2]), "your");
        $this->assertEquals(key($words[3]), "job");
    }

    function testfetchMsgFromAgent() {
        $response = $this->agent->getResponse();
        $this->assertEquals($response->msg, "My job is a analyst");
    }
}


