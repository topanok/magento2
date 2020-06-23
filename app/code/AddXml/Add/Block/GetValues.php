<?php

namespace AddXml\Add\Block;

class GetValues extends \Magento\Framework\View\Element\Template
{
    /** @var \AddXml\Add\Helper\Data  */
    protected $helper;

    /**
     * @param \AddXml\Add\Helper\Data $helper
     * @param \Magento\Framework\View\Element\Template\Context $context.
     * @param array $data
     */
    public function __construct(\AddXml\Add\Helper\Data $helper,
                                \Magento\Framework\View\Element\Template\Context $context,
                                array $data=[])
    {
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * Get fields Values
     * @return array
     */
    public function getValues(){
        $data = $this->helper->getAllConfigValues();
        return $data;
    }
}