<?php
namespace Cart\Ajax\Controller\Cart;

class Qty extends \Magento\Framework\App\Action\Action
{
    /** @var \Magento\Framework\Controller\Result\JsonFactory  */
    protected $_resultJsonFactory;

    /** @var \Magento\Checkout\Model\Cart  */
    protected $_cart;

    /** @var \Cart\Ajax\Helper\Helper  */
    protected $_helper;

    /** @var \Magento\Quote\Api\CartRepositoryInterface  */
    protected $_quoteRepo;

    /**
     * Index constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Magento\Checkout\Model\Cart $cart
     * @param \Cart\Ajax\Helper\Helper $helper
     */
    public function __construct(\Magento\Framework\App\Action\Context $context,
                                \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
                                \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
                                \Magento\Checkout\Model\Cart $cart,
                                \Cart\Ajax\Helper\Helper $helper
    ){
        $this->_resultJsonFactory = $jsonFactory;
        $this->_cart = $cart;
        $this->_helper = $helper;
        $this->_quoteRepo = $quoteRepository;
        parent::__construct($context);
    }
    public function execute()
    {
        $cartId=$this->_cart->getQuote()->getId();
        $productId = $this->_helper->getProductId();
        $itemQty = 3;

        $quote = $this->_quoteRepo->getActive($cartId);
        $cartitems = $this->_cart->getQuote()->getAllItems();
        $cartitems->setquoteId($cartId);
        $cartitems->setitemId($productId);
        $cartitems->setqty($itemQty);

        $quoteItems[] = $cartitems;
        $quote->setItems($quoteItems);
        $this->_quoteRepo->save($quote);
        $quote->collectTotals();


        $result = $this->_resultJsonFactory->create();
        /*$result = $this->_resultJsonFactory->create();
        $productId = $this->_helper->getProductId();
        //$qty = $this->_helper->getQty();
        $params = array(
            'qty'   => '3'
        );
        //echo $productId;
        $ids = $this->_cart->getProductIds();
        //$this->_cart->save();*/
        return $result->setData(['success' => 'Its okey !']);
    }
}