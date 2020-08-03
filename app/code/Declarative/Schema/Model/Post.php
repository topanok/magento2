<?php
namespace Declarative\Schema\Model;

use Declarative\Schema\Api\Data\PostInterface;
use Declarative\Schema\Model\ResourceModel\Post as PostResource;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Post
 * @package AlexPoletaev\Blog\Model
 */
class Post extends AbstractModel implements PostInterface
{
    /**
     * @var string
     */
    protected $_idFieldName = PostInterface::ID; //@codingStandardsIgnoreLine

    /**
     * @inheritdoc
     */
    protected function _construct() //@codingStandardsIgnoreLine
    {
        $this->_init(PostResource::class);
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->getData(PostInterface::NAME);
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name){
        $this->setData(PostInterface::NAME, $name);
        return $this;
    }

    /**
     * @return string
     */
    public function getPost(){
        return $this->getData(PostInterface::POST);
    }

    /**
     * @param $post
     * @return $this
     */
    public function setPost($post){
        $this->setData(PostInterface::POST, $post);
        return $this;
    }

    /**
     * @return float|integer
     */
    public function getPrice(){
        return $this->getData(PostInterface::PRICE);
    }

    /**
     * @param float|integer
     * @return $this
     */
    public function setPrice($prise){
        $this->setData(PostInterface::PRICE, $prise);
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(){
        return $this->getData(PostInterface::STATUS);
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status){
        $this->setData(PostInterface::STATUS, $status);
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(PostInterface::CREATED_AT);
    }

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->setData(PostInterface::CREATED_AT, $createdAt);
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(PostInterface::UPDATED_AT);
    }

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->setData(PostInterface::UPDATED_AT, $updatedAt);
        return $this;
    }
}