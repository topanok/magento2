<?php

namespace Home\Posts\Api;

interface PostRepositoryInterface
{
    /**
     * Get post list by param
     *
     * @param string $column
     * @param string $param
     * @return array
     */
    public function getListByParam($column, $param);
}