<?php

namespace CollinsHarper\ThunderaLogger\Model\Source;

use Magento\Framework\Option\ArrayInterface;
use Monolog\Logger;

class LogLevel implements ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => (string) Logger::DEBUG,
                'label' => __('DEBUG'),
            ],

            [
                'value' => (string) Logger::INFO,
                'label' => __('INFO'),
            ],

            [
                'value' => (string) Logger::NOTICE,
                'label' => __('NOTICE'),
            ],

            [
                'value' => (string) Logger::WARNING,
                'label' => __('WARNING'),
            ],

            [
                'value' => (string) Logger::ERROR,
                'label' => __('ERROR'),
            ],

            [
                'value' => (string) Logger::CRITICAL,
                'label' => __('CRITICAL'),
            ],

            [
                'value' => (string) Logger::ALERT,
                'label' => __('ALERT'),
            ],

            [
                'value' => (string) Logger::EMERGENCY,
                'label' => __('EMERGENCY'),
            ]
        ];
    }
}
