<?php
namespace Home\Posts\Model;

use Home\Posts\Api\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    /** @var \Home\Posts\Model\PostFactory */
    private $postFactory;

    /** @var \Home\Posts\Model\ResourceModel\Post\CollectionFactory */
    private $postCollectionFactory;

    /**
     * @param \Home\Posts\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory ,
     * @param \Home\Posts\Model\PostFactory $postFactory ,
     */
    public function __construct(
        \Home\Posts\Model\PostFactory $postFactory,
        \Home\Posts\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory
    )
    {
        $this->postFactory = $postFactory;
        $this->postCollectionFactory = $postCollectionFactory;
    }

    /**
     * Get post list
     *
     * @param string $column
     * @param string $param
     */
    public function getListByParam($column, $param)
    {
        $post = $this->postFactory->create();
        $collection = $post->getCollection();
        $collection->addFieldToSelect(['category',
                                                'name',
                                                'post_content',
                                                'url_key',
                                                'tags',
                                                'category',
                                                'created_at']);
        $fields = $collection->addFieldToFilter($column, ['eq' => $param])
        ->load();
        $items = [];
        foreach($fields as $item){
            $items[] = $item->getData();
        }
        return $fields->getData();
    }
}