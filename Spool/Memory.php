<?php

namespace Ftassi\Bundle\MemorySpoolBundle\Spool;

/**
 * MemorySpool
 *
 * @author ftassi
 */
class Memory implements \Swift_Spool
{

    protected $stream;
    
    protected $messages = array();

    function __construct()
    {
        $this->stream = fopen('php://memory', 'r+', false);
    }
    
    public function __destruct()
    {
        fclose($this->stream);
    }

    public function queueMessage(\Swift_Mime_Message $message)
    {
        $this->messages[] = $message;

        if ($this->stream) {
            fputs($this->stream, serialize($this->messages));
            rewind($this->stream);
        }
    }

    public function getMessage($messageId)
    {
        $queue = $this->getQueue();
        return $queue[0];
    }

    public function getQueue()
    {
        $serMessages = fgets($this->stream);
        $this->messages = unserialize($serMessages);
        return $this->messages;
    }

    public function clearQueue()
    {
        fclose($this->stream);
        $this->stream = fopen('php://memory', 'r+', false);
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
