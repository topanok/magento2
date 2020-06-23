<?php

namespace Topanok\Topanok\Controller\Entity;

use Magento\Framework\Controller\ResultFactory;

class Product extends \Magento\Framework\App\Action\Action
{
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage=$this->resultFactory->create(ResultFactory::TYPE_PAGE);
        return $resultPage;
    }
}