<?php

namespace OneClick\Purchase\Model;

use Magento\Setup\Exception;

class OneClick
{
    /** @var \OneClick\Purchase\Helper\Helper */
    protected $helper;

    /** @var \Magento\Quote\Model\QuoteFactory  */
    protected $quote;

    /** @var \Magento\Store\Model\StoreManagerInterface  */
    protected $storeManager;

    /** @var \Magento\Quote\Model\QuoteManagement  */
    protected $quoteManagement;

    /** @var \Magento\Customer\Model\CustomerFactory  */
    protected $customerFactory;

    /** @var \Magento\Customer\Api\CustomerRepositoryInterface  */
    protected $customerRepository;

    /** @var \Magento\Sales\Model\Service\OrderService  */
    protected $orderService;

    /**
     * @param \OneClick\Purchase\Helper\Help $helper
     * @param \Magento\Quote\Model\QuoteFactory $quote
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory
     * @param \Magento\Quote\Model\QuoteManagement $quoteManagement
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Magento\Sales\Model\Service\OrderService $orderService
     */
    public function __construct(\OneClick\Purchase\Helper\Help $helper,
                                \Magento\Quote\Model\QuoteFactory $quote,
                                \Magento\Store\Model\StoreManagerInterface $storeManager,
                                \Magento\Customer\Model\CustomerFactory $customerFactory,
                                \Magento\Quote\Model\QuoteManagement $quoteManagement,
                                \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
                                \Magento\Sales\Model\Service\OrderService $orderService)
    {
        $this->storeManager = $storeManager;
        $this->quote = $quote;
        $this->quoteManagement = $quoteManagement;
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
        $this->orderService = $orderService;
        $this->helper = $helper;
    }

    /**
     * @return \Magento\Customer\Model\Customer
     */
    private function getsetCustomer(){
        $data = $this->helper->getData();
        $store = $this->helper->getStore();
        $websiteId = $this->storeManager->getStore()->getWebsiteId();
        $customer = $this->customerFactory->create();
        $collection = $customer->getAddressCollection();
        $adress = $collection->getItemByColumnValue('telephone', $data['shipping_address']['telephone']);
        if($adress) {
            $adressId = $adress->getData('entity_id');
            $customer = $customer->getResourceCollection()
                ->getItemByColumnValue('default_shipping', $adressId);
            return $customer;
        }
        else{
            //If not customer create customer
            $customer
                ->setWebsiteId($websiteId)
                ->setStore($store)
                ->setFirstname($data['shipping_address']['firstname'])
                ->setLastname($data['shipping_address']['lastname'])
                ->setMiddlename($data['shipping_address']['middlename'])
                ->setEmail($data['email']);
            $customer->save();
            return $customer;
        }
    }

    /**
     * Create oneClick Order
     * @return \Magento\Quote\Model\Quote
     */
    private function setQuote(){
        $data = $this->helper->getData();
        $store = $this->helper->getStore();
        $product = $this->helper->getProduct();
        $customerInfo = $this->getsetCustomer();
        $configShippingMethod = $this->helper->getConfigShippingMethod();
        $configPaymentMethod = $this->helper->getConfigPaymentMethod();

        $quote = $this->quote->create();
        $quote->setStore($store);
        $customer = $this->customerRepository->getById($customerInfo->getId());
        $quote->setCurrency();
        $quote->assignCustomer($customer);

        $quote->addProduct($product, 1);

        $quote->getBillingAddress()->addData($data['shipping_address']);
        $quote->getShippingAddress()->addData($data['shipping_address']);

        $shippingAddress=$quote->getShippingAddress();
        $shippingAddress
            ->setCollectShippingRates(true)
            ->collectShippingRates()
            ->setShippingMethod($configShippingMethod);
        $quote->setPaymentMethod($configPaymentMethod);
        $quote->setInventoryProcessed(false);
        $quote->save();
        $quote->getPayment()->importData(['method' => $configPaymentMethod]);
        $quote->collectTotals()->save();
        return $quote;
    }

    /**
     * @return array
     */
    public function createOrder(){
        $quote = $this->setQuote();
        $order = $this->quoteManagement->submit($quote);
        if ($order) {
            $result['order_id'] = $order->getRealOrderId();
        } else {
            $result = ['error' => 1, 'msg' => 'Ooops , something wrong!'];
        }
        return $result;
    }
}