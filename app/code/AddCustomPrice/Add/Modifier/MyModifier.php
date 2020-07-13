<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AddCustomPrice\Add\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\GiftMessage\Helper\Message;
use Magento\Store\Model\ScopeInterface;
use Magento\Ui\Component\Form\Element\Checkbox;
use Magento\Ui\Component\Form\Field;
use Magento\Catalog\Model\Product\Attribute\Source\Boolean;
use AddCustomPrice\Add\Helper\Data;

/**
 * Class GiftMessageDataProvider
 */
class MyModifier extends AbstractModifier
{
    const CUSTOM_PRICE_FIELD = 'custom_price';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var LocatorInterface
     */
    protected $locator;

    /**
     * @var ArrayManager
     */
    protected $arrayManager;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @param LocatorInterface $locator
     * @param ArrayManager $arrayManager
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        LocatorInterface $locator,
        ArrayManager $arrayManager,
        ScopeConfigInterface $scopeConfig,
        Data $helper
    ) {
        $this->locator = $locator;
        $this->arrayManager = $arrayManager;
        $this->scopeConfig = $scopeConfig;
        $this->helper = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        $modelId = $this->locator->getProduct()->getId();
        $customPrice = $this->helper->getCustomPrice();
        if(!isset($data[$modelId]['product']['custom_price'])){
            $data[$modelId]['product']['custom_price'] = $customPrice;
        }
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta)
    {
        return $this->addCheckboxAtCustomPrice($meta);
    }

    /**
     * Customization of allow gift message field
     *
     * @param array $meta
     * @return array
     */
    protected function addCheckboxAtCustomPrice(array $meta)
    {
        $groupCode = $this->getGroupCodeByField($meta, 'container_' . static::CUSTOM_PRICE_FIELD);

        if (!$groupCode) {
            return $meta;
        }

        $containerPath = $this->arrayManager->findPath(
            'container_' . static::CUSTOM_PRICE_FIELD,
            $meta,
            null,
            'children'
        );
        $fieldPath = $this->arrayManager->findPath(static::CUSTOM_PRICE_FIELD, $meta, null, 'children');
        $groupConfig = $this->arrayManager->get($containerPath, $meta);
        $fieldConfig = $this->arrayManager->get($fieldPath, $meta);

        $meta = $this->arrayManager->merge($containerPath, $meta, [
            'arguments' => [
                'data' => [
                    'config' => [
                        'formElement' => 'container',
                        'componentType' => 'container',
                        'component' => 'Magento_Ui/js/form/components/group',
                        'label' => $groupConfig['arguments']['data']['config']['label'],
                        'breakLine' => false,
                        'sortOrder' => $fieldConfig['arguments']['data']['config']['sortOrder'],
                        'dataScope' => '',
                    ],
                ],
            ],
        ]);
        $meta = $this->arrayManager->merge($containerPath, $meta, [
            'children' =>[
                'custom_price' => [
                    'arguments' => [
                        'data' =>[
                            'config' => [
                                'disabled' => 'true',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        $meta = $this->arrayManager->merge(
            $containerPath,
            $meta,
            [
                'children' => [
                    'use_config_' . static::CUSTOM_PRICE_FIELD => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'dataType' => 'number',
                                    'formElement' => Checkbox::NAME,
                                    'componentType' => Field::NAME,
                                    'description' => __('Allow Modify'),
                                    'dataScope' => 'use_config_' . static::CUSTOM_PRICE_FIELD,
                                    'valueMap' => [
                                        'false' => '0',
                                        'true' => '1',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        );

        return $meta;
    }
}