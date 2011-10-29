<?php

namespace Ftassi\Bundle\MemorySpoolBundle\Spool;

use Ftassi\Bundle\MemorySpoolBundle\Spool\Memory;

/**
 * MemoryTest
 *
 * @author ftassi
 */
class MemoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Memory
     */
    protected $spool;
    
    public function setUp()
    {
        $this->spool = Memory::factory();
        $this->spool->clearQueue();
        
        $mailer = new \Swift_Mailer(new \Swift_NullTransport());
        $this->queueMessage = $mailer->createMessage();
        
        /*@var $this->queueMessage \Swift_Mime_Message */
        $this->queueMessage->setFrom('foofrom@foodomain.com', 'Real Name');
        
    }
    
    public function testQueueMessage()
    {
        $this->spool->queueMessage($this->queueMessage);
        $message = $this->spool->getMessage(0);
        
        $this->assertInternalType('string', $message);
        $this->assertEquals($this->queueMessage->toString(), $message);
    }
    
    public function testGetQueue()
    {
        $this->spool->queueMessage($this->queueMessage);
        $queue = $this->spool->getQueue();
        $this->assertEquals(array($this->queueMessage->toString()), $queue);
    }
    
    public function testClearQueue()
    {
        $this->spool->queueMessage($this->queueMessage);
        $messageQueue = $this->spool->getQueue();   
        $this->assertEquals(1, count($messageQueue));
         
        $this->spool->clearQueue();
        $messageQueue = $this->spool->getQueue();   
        $this->assertEquals(0, count($messageQueue));
    }
    
    
    
    
}

?>
