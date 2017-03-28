<?php

namespace CollinsHarper\ThunderaLogger\Controller\Adminhtml;

use Magento\Backend\App\Action;

/**
 * Redirect controller
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class Redirect extends \Magento\Backend\App\Action
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);

        $this->_redirect("http://google.com.br");
    }
}
