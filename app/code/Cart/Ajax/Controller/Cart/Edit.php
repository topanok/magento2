<?php
namespace Cart\Ajax\Controller\Cart;

class Edit extends \Magento\Framework\App\Action\Action {

    /** @var \Magento\Framework\Controller\Result\JsonFactory  */
    protected $resultJsonFactory;

    /** @var \Cart\Ajax\Helper\Helper  */
    protected $helper;

    /**
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Cart\Ajax\Helper\Helper $helper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Cart\Ajax\Helper\Helper $helper
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->helper = $helper;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute() {
        $result = $this->resultJsonFactory->create();
            return $result->setData(['Message' => 'Its Works!']);
    }
}