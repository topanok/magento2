<?php


namespace Tasks\Task2\Model\Config\Source;


class Checkbox
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'base_price', 'label'=>__('Use base price')],
            ['value' => 'final_price', 'label'=>__('Use final price')],
            ['value' => 'special_price', 'label'=>__('Use special price')],
            ['value' => 'tier_price', 'label'=>__('Use tier price')],
            ['value' => 'catalog_rule_price', 'label'=>__('Use catalog rule price')]
        ];
    }
}