<?php

namespace Tasks\Task1\Block;

class ModifyProduct extends \Magento\Framework\View\Element\Template
{
    /** @var \Tasks\Task1\Helper\Data  */
    protected $helper;

    /**
     * @param \Tasks\Task1\Helper\Data $helper
     * @param \Magento\Framework\View\Element\Template\Context $context.
     * @param array $data
     */
    public function __construct(\Tasks\Task1\Helper\Data $helper,
                                \Magento\Framework\View\Element\Template\Context $context,
                                array $data=[])
    {
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * Get fields Values
     * @return boolean
     */
    public function verify(){
        return $this->helper->isInCategory();
    }
}