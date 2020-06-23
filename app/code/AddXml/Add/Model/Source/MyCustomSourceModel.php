<?php


namespace AddXml\Add\Model\Source;


class MyCustomSourceModel implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('Enable')],
            ['value' => 2, 'label' => __('Disable')],
            ['value' => 6, 'label' => __('Create')],
            ['value' => 4, 'label' => __('Edit')],
            ['value' => 3, 'label' => __('Delete')],
            ['value' => 5, 'label' => __('Register')]
        ];
    }
}