<?php
namespace Declarative\Schema\Model;

use Declarative\Schema\Api\Data\PostInterface;
use Declarative\Schema\Api\Data\PostSearchResultInterface;
use Declarative\Schema\Api\Data\PostSearchResultInterfaceFactory;
use Declarative\Schema\Api\PostRepositoryInterface;
use Declarative\Schema\Model\ResourceModel\Post as PostResource;
use Declarative\Schema\Model\ResourceModel\Post\Collection as PostCollection;
use Declarative\Schema\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Declarative\Schema\Model\PostFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

/**
 * Class PostRepository
 * @package AlexPoletaev\Blog\Model
 */
class PostRepository implements PostRepositoryInterface
{
    /**
     * @var array
     */
    private $registry = [];

    /**
     * @var PostResource
     */
    private $postResource;

    /**
     * @var PostFactory
     */
    private $postFactory;

    /**
     * @var PostCollectionFactory
     */
    private $postCollectionFactory;

    /**
     * @var PostSearchResultInterfaceFactory
     */
    private $postSearchResultFactory;

    /**
     * @param PostResource $postResource
     * @param PostFactory $postFactory
     * @param PostCollectionFactory $postCollectionFactory
     * @param PostSearchResultInterfaceFactory $postSearchResultFactory
     */
    public function __construct(
        PostResource $postResource,
        PostFactory $postFactory,
        PostCollectionFactory $postCollectionFactory,
        PostSearchResultInterfaceFactory $postSearchResultFactory
    ) {
        $this->postResource = $postResource;
        $this->postFactory = $postFactory;
        $this->postCollectionFactory = $postCollectionFactory;
        $this->postSearchResultFactory = $postSearchResultFactory;
    }

    /**
     * @param int $id
     * @return PostInterface
     * @throws NoSuchEntityException
     */
    public function get($id)
    {
        if (!array_key_exists($id, $this->registry)) {
            $post = $this->postFactory->create();
            $this->postResource->load($post, $id);
            if (!$post->getId()) {
                throw new NoSuchEntityException(__('Requested post does not exist'));
            }
            $this->registry[$id] = $post;
        }

        return $this->registry[$id];
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Declarative\Schema\Api\Data\PostSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var PostCollection $collection */
        $collection = $this->postCollectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

        /** @var PostSearchResultInterface $searchResult */
        $searchResult = $this->postSearchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        return $searchResult;
    }

    /**
     * @param \Declarative\Schema\Api\Data\PostInterface $post
     * @return PostInterface
     * @throws StateException
     */
    public function save(PostInterface $post)
    {
        try {
            /** @var Post $post */
            $this->postResource->save($post);
            $this->registry[$post->getId()] = $this->get($post->getId());
        } catch (\Exception $exception) {
            throw new StateException(__('Unable to save post #%1', $post->getId()));
        }
        return $this->registry[$post->getId()];
    }

    /**
     * @param \Declarative\Schema\Api\Data\PostInterface $post
     * @return bool
     * @throws StateException
     */
    public function delete(PostInterface $post)
    {
        try {
            /** @var Post $post */
            $this->postResource->delete($post);
            unset($this->registry[$post->getId()]);
        } catch (\Exception $e) {
            throw new StateException(__('Unable to remove post #%1', $post->getId()));
        }

        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById($id)
    {
        return $this->delete($this->get($id));
    }
}