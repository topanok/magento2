<?php
namespace Declarative\Schema\Model\ResourceModel;

use Declarative\Schema\Api\Data\PostInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Post
 * @package AlexPoletaev\Blog\Model\ResourceModel
 */
class Post extends AbstractDb
{
    /**
     * @var string
     */
    const TABLE_NAME = 'declarative_schema_sc_table';

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct() //@codingStandardsIgnoreLine
    {
        $this->_init(self::TABLE_NAME, PostInterface::ID);
    }
}