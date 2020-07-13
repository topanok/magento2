<?php

namespace OneClick\Purchase\Block;

use Magento\Framework\View\Element\Template;

class GetFields extends \Magento\Framework\View\Element\Template
{
    /** @var \OneClick\Purchase\Helper\Help  */
    protected $helper;

    /**
     * @param \OneClick\Purchase\Helper\Help $helper
     */
    public function __construct(Template\Context $context,
                                \OneClick\Purchase\Helper\Help $helper,
                                array $data = []
    ){
        parent::__construct($context, $data);
        $this->helper = $helper;
    }

    /**
     * Get array with inputs data
     * @return array
     */
    public function getFields(){
        $fields = $this->getArray();
        return $fields;
    }

    /** @return array */
    private function getArray(){
        $values = $this->helper->getConfigValues();
        $data = [];
        if($values['customer_name'] == 1){
            $data[] = [
                'label' => 'Ім\'я',
                'type' => 'text',
                'id' => 'name',
                'value' => '',
                'required' => 'false'
            ];
        }
        if($values['customer_last_name'] == 1){
            $data[] = [
                'label' => 'Фамілія',
                'type' => 'text',
                'id' => 'lastname',
                'value' => '',
                'required' => 'false'
            ];
        }
        if($values['customer_middle_name'] == 1){
            $data[] = [
                'label' => 'По батькові',
                'type' => 'text',
                'id' => 'middlename',
                'value' => '',
                'required' => 'false'
            ];
        }
        if($values['customer_telephone'] == 1){
            $data[] = [
                'label' => 'Телефон',
                'type' => 'text',
                'id' => 'telephone',
                'value' => '+380',
                'required' => 'true'
            ];
        }
        if($values['customer_email'] == 1){
            $data[] = [
                'label' => 'Email',
                'type' => 'text',
                'id' => 'email',
                'value' => '',
                'required' => 'false'
            ];
        }
        return $data;
    }
}