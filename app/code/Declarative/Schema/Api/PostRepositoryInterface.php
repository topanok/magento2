<?php
namespace Declarative\Schema\Api;

use Declarative\Schema\Api\Data\PostInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface PostRepositoryInterface
 * @api
 */
interface PostRepositoryInterface
{
    /**
     * @param int $id
     * @return \Declarative\Schema\Api\Data\PostInterface
     */
    public function get($id);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Declarative\Schema\Api\Data\PostSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param \Declarative\Schema\Api\Data\PostInterface $post
     * @return \Declarative\Schema\Api\Data\PostInterface
     */
    public function save(PostInterface $post);

    /**
     * @param \Declarative\Schema\Api\Data\PostInterface $post
     * @return bool
     */
    public function delete(PostInterface $post);

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById($id);
}