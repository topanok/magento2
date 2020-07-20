<?php

namespace Cart\Ajax\Plugins;

class GetAttr
{
    /** @var \Magento\ConfigurableProduct\Model\Product\Type\Configurable  */
    private $configurable;

    /** @var \Magento\Framework\Serialize\Serializer\Json  */
    private $jsonSerializer;

    public function __construct(\Magento\Framework\Serialize\Serializer\Json $json,
                                \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurable)
    {

        $this->configurable = $configurable;

        $this->jsonSerializer = $json;
    }

    /** Add super attributes to option list */
    public function aftergetOptionList(\Magento\Checkout\Block\Cart\Item\Renderer $renderer , $result){
        if ($superAttributes = $this->configurable->getConfigurableAttributesAsArray($renderer->getProduct())) {
            $selectedAttributes = $this->jsonSerializer->unserialize($renderer->getProduct()->getCustomOptions()['attributes']->getValue());

            foreach ($superAttributes as $superKey => $superAttribute) {
                foreach ($selectedAttributes as $selectedKey => $selectedAttribute) {
                    if ((int)$superKey === (int)$selectedKey) {
                        foreach ($superAttribute['values'] as $key =>  $value) {
                            if ((int)$value['value_index'] === (int)$selectedAttribute) {
                                $superAttributes[$superKey]['values'][$key]['selected'] = true;
                            } else {
                                $superAttributes[$superKey]['values'][$key]['selected'] = false;
                            }
                        }
                    }
                }
            }
            return $superAttributes;
        }
        return $result;
    }
}