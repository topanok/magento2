<?php


namespace Topanok\Topanok\Block;


use Magento\Catalog\Api\ProductRepositoryInterface;

class CustomBlock extends \Magento\Catalog\Block\Product\View
{   /** @var \Topanok\Topanok\Helper\Validator */
    protected $_validator;
    /** @var \Topanok\Topanok\Helper\Validator $validator*/
    public function __construct(\Magento\Catalog\Block\Product\Context $context,
                                \Magento\Framework\Url\EncoderInterface $urlEncoder,
                                \Magento\Framework\Json\EncoderInterface $jsonEncoder,
                                \Magento\Framework\Stdlib\StringUtils $string,
                                \Magento\Catalog\Helper\Product $productHelper,
                                \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
                                \Magento\Framework\Locale\FormatInterface $localeFormat,
                                \Magento\Customer\Model\Session $customerSession,
                                ProductRepositoryInterface $productRepository,
                                \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
                                \Topanok\Topanok\Helper\Validator $validator,
                                array $data = []){
        $this->_validator = $validator;
        parent::__construct($context, $urlEncoder, $jsonEncoder, $string, $productHelper, $productTypeConfig, $localeFormat, $customerSession, $productRepository, $priceCurrency, $data);
    }
    /** @return bool */
    public function isAvailable(){
        $currentProduct = $this->getProduct();
        return $this->_validator->validateProductBySku($currentProduct->getSku());
    }

    /**
     * Check it work
     *
     * @return string
     */
    public function helloMyBlock(){
        return 'Its okey!';
    }
    /**
     * Get any value
     *
     * @return string
     */
    public function getFinalPrice(){
        $currentProduct = $this->getProduct();
        $customValue = 'Final price is- $';
        return $customValue.$currentProduct->getFinalPrice();
    }
}