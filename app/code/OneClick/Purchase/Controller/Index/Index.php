<?php
namespace OneClick\Purchase\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action {

    /** @var \Magento\Framework\Controller\Result\JsonFactory  */
    protected $resultJsonFactory;

    /** @var \Magento\Framework\Message\ManagerInterface  */
    protected $messageManager;

    /** @var \OneClick\Purchase\Model\OneClick  */
    protected $order;

    /**
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \OneClick\Purchase\Model\OneClick $order
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \OneClick\Purchase\Model\OneClick $order
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->order = $order;
        $this->messageManager = $messageManager;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute() {
        $order = $this->order->createOrder();
        $result = $this->resultJsonFactory->create();
        if($order['order_id']) {
            $this->messageManager->addSuccess(__('Вітаємо! Ваше замовлення №' . $order['order_id'] . ' оформлено'));
            return $result->setData(['order_id' => $order['order_id']]);
        }
        else{
            $this->messageManager->addError(__('Ooops! Щось пішло не так!'));
            return $result->setData(['error' => 'Something wrong!']);
        }
    }
}