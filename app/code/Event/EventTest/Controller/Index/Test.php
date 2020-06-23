<?php
namespace Event\EventTest\Controller\Index;

use Magento\Framework\App\Action\Action;

class Test extends Action
{
    public function execute()
    {
        $this->_eventManager->dispatch('event_eventtest_index_test');
        die('test');
    }
}