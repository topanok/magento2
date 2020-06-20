<?php

namespace Home\Posts\Block;

class Posts extends \Magento\Framework\View\Element\Template
{
    /** @var \Home\Posts\Api\PostRepositoryInterface */
    protected $_postRepository;

    public function __construct(
        \Home\Posts\Api\PostRepositoryInterface $postRepository,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data=[]){
        $this->_postRepository = $postRepository;
        parent::__construct($context, $data);
    }
    /**
     * Get post by category via repository
     *
     * @param string $category
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getPostsByCategory($category){
        if (is_null($category)){
            return null;
        }
        $postCollection=$this->_postRepository->getListByParam('category', 'answers');
        return $postCollection;
    }
}