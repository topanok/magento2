<?php
namespace Declarative\Schema\Model\ResourceModel\Post;

use Declarative\Schema\Model\Post;
use Declarative\Schema\Model\ResourceModel\Post as PostResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package AlexPoletaev\Blog\Model\ResourceModel\Post
 */
class Collection extends AbstractCollection
{
    /**
     * @inheritdoc
     */
    protected function _construct() //@codingStandardsIgnoreLine
    {
        $this->_init(Post::class, PostResource::class);
    }
}