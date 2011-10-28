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
        $this->spool = new Memory();
        $mailer = new \Swift_Mailer(new \Swift_NullTransport());
        $this->queueMessage = $mailer->createMessage();
        
        /*@var $this->queueMessage \Swift_Mime_Message */
        $this->queueMessage->setFrom('foofrom@foodomain.com', 'Real Name');
        
    }
    
    public function testQueueMessage()
    {
        $this->spool->queueMessage($this->queueMessage);
        $message = $this->spool->getMessage(0);
        
        $this->assertEquals($this->queueMessage, $message);
    }
    
    public function testGetQueue()
    {
        $this->spool->queueMessage($this->queueMessage);
        $queue = $this->spool->getQueue();
        
        $this->assertEquals(array($this->queueMessage), $queue);
    }
    
    public function testFlushQueue()
    {
        $this->spool->queueMessage($this->queueMessage);
        $this->spool->clearQueue();
        
        $this->assertEmpty($this->spool->getQueue());
    }
    
}

?>
