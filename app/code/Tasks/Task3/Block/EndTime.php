<?php

namespace Tasks\Task3\Block;

class EndTime extends \Magento\Framework\View\Element\Template
{
    /** @var \Tasks\Task3\Helper\Data  */
    protected $helper;

    /** @var \Magento\Framework\Registry */
    protected $registry;

    /**
     * @param \Tasks\Task3\Helper\Data $helper
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(\Tasks\Task3\Helper\Data $helper,
                                \Magento\Framework\View\Element\Template\Context $context,
                                \Magento\Framework\Registry $registry,
                                array $data=[])
    {
        $this->registry = $registry;
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Catalog\Model\Product
     */
    private function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    /**
     * @return array|null
     */
    public function getCurrentTimeToEnd(){
        if($this->getSpecialPriceEndTime()){
            return $this->getSpecialPriceEndTime();
        }
        else{
            return $this->getRuleFirstEndTime();
        }
    }

    /**
     * @return array|null
     */
    public function getSpecialPriceEndTime(){
        $sku = $this->getCurrentProduct()->getSku();
        $price = $this->helper->getSpecialPrices($sku);
        if(!empty($price) && $price[0]['price_to']){
            $dateTo = $price[0]['price_to'];
            $timeStamp = strtotime($dateTo);
            $endTime = $this->getTimeToEnd($timeStamp);
            return $endTime;
        }
        return null;
    }

    /**
     * @return array|null
     */
    public function getRuleFirstEndTime(){
        $currProduct = $this->getCurrentProduct();
        $rules = $this->helper->getRules($currProduct);
        if(!empty($rules) && $rules[0]['to_time']) {
            $timeStamp = $this->getFirstEndingTimestamp($rules);
            $endTime = $this->getTimeToEnd($timeStamp);
            return $endTime;
        }
        return null;
    }

    /**
     * @param integer
     * @return array
     */
    private function getTimeToEnd($timeStamp){
        $secondsToEnd = $timeStamp - time();

        $time['days'] = $secondsToEnd / 60 / 60 / 24;
        if ($time['days'] >= 1) {
            $time['days'] = (int)floor($time['days']);
        } else {
            $time['days'] = 0;
        }
        $latestSeconds = $secondsToEnd - $time['days'] * 60 * 60 * 24;
        $time['hours'] = $latestSeconds / 60 / 60;
        if ($time['hours'] >= 1) {
            $time['hours'] = (int)floor($time['hours']);
        } else {
            $time['hours'] = 0;
        }
        $latestSeconds2 = $latestSeconds - $time['hours'] * 60 * 60;
        $time['minutes'] = $latestSeconds2 / 60;
        if ($time['minutes'] >= 1) {
            $time['minutes'] = (int)floor($time['minutes']);
        } else {
            $time['minutes'] = 0;
        }
        $time['seconds'] = (int)$latestSeconds2 - $time['minutes'] * 60;
        return $time;
    }

    /**
     * @param array
     * @return integer
     */
    private function getFirstEndingTimestamp($rules){
        $timeStamps = [];
        foreach ($rules as $rule) {
            $timeStamps[] = $rule['to_time'];
        }
        sort($timeStamps);
        return $timeStamps[0];
    }
}