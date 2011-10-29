<?php

namespace Ftassi\Bundle\MemorySpoolBundle\Spool;

/**
 * MemorySpool
 *
 * @author ftassi
 */
class Memory implements \Swift_Spool
{

    /**
     *
     * @var array
     */
    protected $messageQueue;

    /**
     *
     * @var Memory
     */
    protected static $spoolInstance = null;
    
    public static function factory()
    {
        if (!self::$spoolInstance)
        {
            self::$spoolInstance = new Memory();
        }
        
        return self::$spoolInstance;
    }
    
    public function __construct()
    {
        $this->clearQueue();
    }
    

    public function queueMessage(\Swift_Mime_Message $message)
    {
        $this->messageQueue[] = $message->toString();
    }

    public function getMessage($messageId)
    {
        return @$this->messageQueue[$messageId];
    }

    public function getQueue()
    {
        return $this->messageQueue;
    }

    public function clearQueue()
    { 
        $this->messageQueue = array();
    }

    public function flushQueue(Swift_Transport $transport, &$failedRecipients = null)
    {
        
    }

    public function start()
    {
        return false;
    }

    public function stop()
    {
        return false;
    }

    public function getStream()
    {
        return $this->stream;
    }

    public function setStream($stream)
    {
        $this->stream = $stream;
    }

    public function isStarted()
    {
        return false;
    }

}

?>
