<?php
namespace Cart\Ajax\Controller\Cart;

class Delete extends \Magento\Framework\App\Action\Action
{
    /** @var \Magento\Checkout\Model\Session */
    protected $_checkoutSession;

    /** @var \Magento\Checkout\Model\Cart */
    protected $_cart;

    /** @var \Magento\Framework\Controller\Result\JsonFactory  */
    protected $_jsonFactory;

    /** @var \Cart\Ajax\Helper\Helper */
    protected $_helper;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Magento\Checkout\Model\Cart $cart
     * @param \Cart\Ajax\Helper\Helper $helper
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Magento\Checkout\Model\Cart $cart,
        \Cart\Ajax\Helper\Helper $helper
    ) {
        $this->_checkoutSession = $checkoutSession;
        $this->_jsonFactory = $jsonFactory;
        $this->_cart = $cart;
        $this->_helper = $helper;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->_helper->getProductId();
        $this->_cart->removeItem($id);
        $this->_cart->getQuote()->setTotalsCollectedFlag(false);
        $this->_cart->save();
        $result = $this->_jsonFactory->create();
        //$grandTotal = $this->_cart->getQuote()->getGrandTotal();
        return $result->setData(['success' => 'true']);
    }
}