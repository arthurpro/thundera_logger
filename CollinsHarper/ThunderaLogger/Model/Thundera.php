<?php

namespace CollinsHarper\ThunderaLogger\Model;

use Gelf\Publisher;
use Gelf\Transport\UdpTransport;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Logger\Monolog;
use Monolog\Handler\GelfHandler;
use Magento\Store\Model\ScopeInterface;

class Thundera extends Monolog
{
    const XML_PATH_THUNDERA = 'thundera/';

    /**
     * @var ScopeConfigInterface
     */
    public $scopeConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    public $storeManager;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param string             $name       The logging channel
     * @param HandlerInterface[] $handlers   Optional stack of handlers, the first one in the array is called first, etc.
     * @param callable[]         $processors Optional array of processors
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        $name,
        $handlers = array(),
        $processors = array()
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->createGelfHandler();
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

        if ($this->getConfig('enable')) {
            $graylogLevel = $this->getConfig('graylog_level');
            if ($level >= $graylogLevel) {
                return parent::addRecord($level, $message, $context);
            }
        }

        return parent::addRecord($level, $message, $context);
    }

    private function createGelfHandler()
    {
        if ($this->getConfig('enable')) {
            if (!array_key_exists('graylog', $this->getHandlers())) {
                $transport = new UdpTransport(
                    $this->getConfig('graylog_host'),
                    $this->getConfig('graylog_port')
                );
                $publisher = new Publisher($transport);
                $gelfHandler = new GelfHandler($publisher);
                $this->setHandlers(['graylog' => $gelfHandler]);
            }
        }
    }

    private function getConfig($code)
    {
        $storeId = $this->storeManager->getStore()->getId();
        return $this->getConfigValue(self::XML_PATH_THUNDERA . $code, $storeId);
    }

    private function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }
}
