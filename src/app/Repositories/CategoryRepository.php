<?php

namespace VCComponent\Laravel\Category\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CategoryRepository.
 *
 * @package namespace VCComponent\Laravel\Category\Repositories;
 */
interface CategoryRepository extends RepositoryInterface
{
    public function getWithPagination($filters);
    public function getCategoriesQuery(array $where, $number = 10, $order_by ='order', $order = 'asc', $columns = ['*']);
    public function getCategoriesQueryPaginate(array $where, $number = 10, $order_by ='order', $order = 'asc', $columns = ['*']);
    public function getPostCategoriesQuery($post_id, array $where, $post_type = 'posts', $number = 10, $order_by = 'order', $order = 'asc');
    public function getPostCategoriesQueryPaginate($post_id, array $where, $post_type = 'posts', $number = 10, $order_by = 'order', $order = 'asc');
    public function getListCategories($type = null,$number = null);
    public function getListPaginatedCategories($type = null,$per_page);
    public function getRelatedCategories($cate_id,$number = null);
    public function getPaginatedRelatedCategories($cate_id,$per_page);
    public function getListChildCategories($parent_id,$number = null);
    public function getListHotCategories($type,$number = null);
    public function getPaginatedListHotCategories($type,$per_page);

}
