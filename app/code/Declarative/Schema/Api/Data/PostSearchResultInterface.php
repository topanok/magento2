<?php
namespace Declarative\Schema\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface PostSearchResultInterface
 * @package Declarative\Schema\Api\Data
 */
interface PostSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Declarative\Schema\Api\Data\PostInterface[]
     */
    public function getItems();

    /**
     * @param \Declarative\Schema\Api\Data\PostInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}