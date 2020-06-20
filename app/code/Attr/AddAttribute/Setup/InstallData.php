<?php

namespace Attr\AddAttribute\Setup;

use Magento\Framework\Setup\InstallDataInterface;

class InstallData implements InstallDataInterface
{
    /**
     * Eav setup factory
     */
    private $eavSetupFactory;

    /**
     * Eav setup factory
     * @var \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     */
    public function __construct(\Magento\Eav\Setup\EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * Eav setup factory
     * @var \Magento\Framework\Setup\ModuleContextInterface $context
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     */
    public function install(\Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,
                            \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create();
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'clothing_material',
            [
                'group' => 'General',
                'type' => 'varchar',
                'label' => 'Clothing Material',
                'input' => 'select',
                'source' => 'Attr\AddAttribute\Model\Attribute\Source\Material',
                'frontend' => 'Attr\AddAttribute\Model\Attribute\Frontend\Material',
                'backend' => 'Attr\AddAttribute\Model\Attribute\Backend\Material',
                'required' => false,
                'sort_order' => 50,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'visible' => true,
                'is_html_allowed_on_front' => true,
                'visible_on_front' => true
            ]
        );
    }
}