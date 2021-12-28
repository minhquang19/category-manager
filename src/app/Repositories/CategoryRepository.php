<?php

namespace VCComponent\Laravel\Category\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;
use VCComponent\Laravel\Category\Entities\Category;

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
    public function getListRelatedCategories(Category $category,$number = null);
    public function getListPaginatedRelatedCategories(Category $category,$per_page);
    public function getListChildCategories(Category $category,$number = null);
    public function getListPaginatedChildCategories(Category $category,$per_page);
    public function getListHotCategories($type,$number = null);
    public function getListPaginatedHotCategories($type,$per_page);

}
