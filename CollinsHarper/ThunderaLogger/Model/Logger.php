<?php

namespace CollinsHarper\ThunderaLogger\Model;

use CollinsHarper\ThunderaLogger\Helper\Data;
use Gelf\Publisher;
use Gelf\Transport\UdpTransport;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Logger\Monolog;
use Magento\Framework\ObjectManagerInterface;
use Monolog\Handler\GelfHandler;

class Logger extends Monolog
{
    /**
     * @param string             $name       The logging channel
     * @param HandlerInterface[] $handlers   Optional stack of handlers, the first one in the array is called first, etc.
     * @param callable[]         $processors Optional array of processors
     */
    public function __construct(
        $name,
        $handlers = array(),
        $processors = array()
    ) {
        parent::__construct($name, $handlers, $processors);
    }
}
