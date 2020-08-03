<?php
namespace Declarative\Schema\Api\Data;

/**
 * Interface PostInterface
 * @api
 */
interface PostInterface
{
    /**#@+
     * Constants
     * @var string
     */
    const ID = 'entity_id';
    const NAME = 'name';
    const POST = 'post';
    const PRICE = 'price';
    const STATUS = 'status';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    /**#@-*/

    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param int $id
     * @return $this
     */
    public function setEntityId($id);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param $name
     * @return $this
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getPost();

    /**
     * @param $post
     * @return $this
     */
    public function setPost($post);

    /**
     * @return float|integer
     */
    public function getPrice();

    /**
     * @param float|integer
     * @return $this
     */
    public function setPrice($prise);

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);
}