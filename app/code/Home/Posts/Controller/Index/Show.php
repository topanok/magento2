<?php

namespace Home\Posts\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class Show extends \Magento\Framework\App\Action\Action
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
