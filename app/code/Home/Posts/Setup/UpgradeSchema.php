<?php
namespace Home\Posts\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;
class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface{

    public function upgrade(SchemaSetupInterface $setup,ModuleContextInterface $context){
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.5', '<')) {
            $this->addStatus($setup);
            $this->changeRow($setup);
            $this->insert($setup);
        }
        $setup->endSetup();
    }

    /**
     * @param SchemaSetupInterface $setup
     * @return void
     */
    private function addStatus(SchemaSetupInterface $setup)
    {
        $setup->getConnection()->addColumn(
            $setup->getTable('mageplaza_helloworld_post'),
            'category',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'size' => 255,
                'nullable' => true,
                'default' => null,
                'comment' => 'Category name'
            ]
        );
    }

    /**
     * @param SchemaSetupInterface $setup
     * @return void
     */
    private function changeRow(SchemaSetupInterface $setup){
        for ($i=1; $i<2; $i++) {
            $setup->getConnection()->update(
                $setup->getTable('mageplaza_helloworld_post'),
                ['category' => 'super'],
                ['post_id' => $i]
            );
        }
    }

    /**
     * @param SchemaSetupInterface $setup
     * @return void
     */
    private function insert(SchemaSetupInterface $setup){
        $categories = ['answers', 'questions'];
        for ($i=0; $i<8; $i++) {
            $status = rand(0, 1);
            $category = $categories[rand(0,1)];
            $data=[
                "name" => "Post $i",
                "url_key" => "post-$i",
                "post_content" => 'Agreeable promotion eagerness as we resources household to distrusts. 
                                    An concluded sportsman offending so provision mr education. 
                                    Now summer who day looked our behind moment c',
                "status" => $status,
                "category" => $category
            ];
            $setup->getConnection()->insert(
                $setup->getTable('mageplaza_helloworld_post'), $data
            );
        }
    }
}