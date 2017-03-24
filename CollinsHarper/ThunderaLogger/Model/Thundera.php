<?php

namespace CollinsHarper\ThunderaLogger\Model;

use Gelf\Publisher;
use Gelf\Transport\UdpTransport;
use Magento\Framework\Logger\Monolog;
use Monolog\Handler\GelfHandler;
use Monolog\Logger;

class Thundera extends Monolog
{
    /**
     * @param string             $name       The logging channel
     * @param HandlerInterface[] $handlers   Optional stack of handlers, the first one in the array is called first, etc.
     * @param callable[]         $processors Optional array of processors
     */
    public function __construct($name, $handlers = array(), $processors = array())
    {
//        if (!array_key_exists('graylog', $handlers)) {
//            $transport = new UdpTransport("127.0.0.1", "12201");
//            $publisher = new Publisher($transport);
//            $gelfHandler = new GelfHandler($publisher);
//            $handlers = ['graylog' => $gelfHandler];
//        }
        parent::__construct($name, $handlers, $processors);
    }

    /**
     * Adds a log record.
     *
     * @param  integer $level   The logging level
     * @param  string  $message The log message
     * @param  array   $context The log context
     * @return Boolean Whether the record has been processed
     */
    public function addRecord($level, $message, array $context = [])
    {
        $context['is_exception'] = $message instanceof \Exception;

        if ($level > Logger::NOTICE) {
            return parent::addRecord($level, $message, $context);
        }
    }
}
