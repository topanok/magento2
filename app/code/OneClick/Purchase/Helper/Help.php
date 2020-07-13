<?php

namespace OneClick\Purchase\Helper;

use Magento\Store\Model\ScopeInterface;

class Help extends \Magento\Framework\App\Helper\AbstractHelper
{
    /** @var array  */
    const FIELDS = ['customer_name', 'customer_last_name', 'customer_middle_name', 'customer_telephone', 'customer_email'];

    /** @var string  */
    const XML_PATH_POPUP_FIELDS = 'one_click_order/';

    /** @var string  */
    const XML_PATH_METHODS = 'methods/';

    /** @var array  */
    const PAYMENT_FIELD = 'payment_method';

    /** @var array  */
    const SHIPPING_FIELD = 'shipping_method';

    /** @var array  */
    protected $data = [];

    /** @var \Magento\Store\Model\StoreManagerInterface  */
    protected $storeManager;

    /** @var \Magento\Catalog\Model\Product  */
    protected $product;

    /** @var \Magento\Catalog\Api\ProductRepositoryInterface  */
    protected $productRepo;

    /** @var \Magento\Shipping\Model\Config  */
    protected $shipConfig;

    /** @var \Magento\Payment\Model\MethodList  */
    protected $payment;

    /** @var \Magento\Quote\Api\Data\CartInterface  */
    protected $quote;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Model\Product $product
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepo
     * @param \Magento\Shipping\Model\Config $shipconfig
     * @param \Magento\Payment\Model\MethodList $payment
     * @param \Magento\Quote\Api\Data\CartInterface $quote
     */
    public function __construct(\Magento\Framework\App\Helper\Context $context,
                                \Magento\Store\Model\StoreManagerInterface $storeManager,
                                \Magento\Catalog\Model\Product $product,
                                \Magento\Catalog\Api\ProductRepositoryInterface $productRepo,
                                \Magento\Shipping\Model\Config $shipconfig,
                                \Magento\Payment\Model\MethodList $payment,
                                \Magento\Quote\Api\Data\CartInterface $quote
    ){
        $this->storeManager = $storeManager;
        $this->product = $product;
        $this->productRepo = $productRepo;
        $this->shipConfig = $shipconfig;
        $this->payment = $payment;
        $this->quote = $quote;
        parent::__construct($context);
    }

    /**
     * @param string $field
     * @param null $storeId
     * @return string
     */
    private function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    /**
     * @return array
     */
    public function getConfigValues(){
        $values = [];
        foreach (self::FIELDS as $field) {
            $values[] = $this->getConfigValue(self::XML_PATH_POPUP_FIELDS .'general/'. $field);
        }
        $keyValue = array_combine(self::FIELDS, $values);
        return $keyValue;
    }

    /** @return string */
    public function getConfigShippingMethod(){
        $configShippingMethod = $this->getConfigValue(self::XML_PATH_METHODS.'general/'.self::SHIPPING_FIELD);
        return $configShippingMethod;
    }

    /** @return string */
    public function getConfigPaymentMethod(){
        $configPaymentMethod = $this->getConfigValue(self::XML_PATH_METHODS.'general/'.self::PAYMENT_FIELD);
        return $configPaymentMethod;
    }

    /** @return array */
    public function getShippingMethods(){
        $activeCarriers = $this->shipConfig->getActiveCarriers();
        foreach($activeCarriers as $carrierCode => $carrierModel)
        {
            $options = array();
            if( $carrierMethods = $carrierModel->getAllowedMethods() )
            {
                foreach ($carrierMethods as $methodCode => $method)
                {
                    $code= $carrierCode.'_'.$methodCode;
                    $options[]=array('value'=>$code,'label'=>$method);
                }
                $carrierTitle =$this->scopeConfig->getValue('carriers/'.$carrierCode.'/title');
            }
            $methods[]=array('value'=>$options,'label'=>$carrierTitle);
        }
        return $methods;
    }

    /** @return array */
    public function getAvailablePaymentMethods(){
        $methods = $this->payment->getAvailableMethods($this->quote);
        $array = [];
        foreach ($methods as $method) {
            $array[$code = $method->getCode()] = $method->getTitle();
        }
        return $array;
    }

    /**
     * Get data for customer
     * @return array
     */
    public function getData(){
        $data = $this->validateParams();
        $dataToOrder = [
            'currency_id' => 'USD',
            'email' => $data['email'],
            'shipping_address' => [
                'firstname' => $data['name'],
                'lastname' => $data['last_name'],
                'middlename' => $data['middle_name'],
                'street' => 'Митрака 6а',
                'city' => 'Ужгород',
                'country_id' => 'UA',
                'region' => 'Закарпатська обл.',
                'postcode' => '99342',
                'telephone' => $data['telephone'],
                'save_in_address_book' => 1
            ]
        ];
        return $dataToOrder;
    }

    /**
     * Get Request params
     */
    private function getParams()
    {
        return parent::_getRequest()->getParams();
    }

    /**
     * Validate Request and add values if need
     */
    private function validateParams(){
        $data = $this->getParams();
        if(empty($data['name'])){
            $data['name'] = 'First Name';
        }
        if(empty($data['last_name'])){
            $data['last_name'] = 'Last Name';
        }
        if(empty($data['middle_name'])){
            $data['middle_name'] = 'Middle Name';
        }
        if(empty($data['email'])){
            $data['email'] = $this->generateEmailAddress();
        }

        return $data;
    }

    /**
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    public function getProduct(){
        $data = $this->getParams();
        $sku = $data['sku'];
        $this->product = $this->productRepo->get($sku);
        return $this->product;
    }

    /**
     * @return \Magento\Store\Api\Data\StoreInterface
     */
    public function getStore(){
        return $this->storeManager->getStore();
    }

    /** @return string */
    public function generateEmailAddress(){
        $alphabetic     = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $alphabeticSmall = 'abcdefghijklmnopqrstuvwxyz';
        $randomString   = '';

        for ($i = 0; $i < 7; $i++) {
            $randomString .= $alphabetic[rand(0, strlen($alphabetic) - 1)];
        }
        for ($i = 0; $i < 2; $i++) {
            $randomString .= rand(0, 9);
        }
        $randomString .= "@";
        for ($i = 0; $i < 5; $i++) {
            $randomString .= $alphabeticSmall[rand(0, strlen($alphabeticSmall) - 1)];
        }
        $randomString .= ".";
        for ($i = 0; $i < 3; $i++) {
            $randomString .= $alphabeticSmall[rand(0, strlen($alphabeticSmall) - 1)];
        }

        return $randomString;
    }
}