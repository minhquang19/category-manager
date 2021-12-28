<?php

namespace VCComponent\Laravel\Category\Repositories;

use VCComponent\Laravel\Category\Entities\Category;
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
    public function getListRelatedCategories(Category $category,$number = null);
    public function getListPaginatedRelatedCategories(Category $category,$per_page);
    public function getListChildCategories(Category $category,$number = null);
    public function getListPaginatedChildCategories(Category $category,$per_page);
    public function getListHotCategories($type,$number = null);
    public function getListPaginatedHotCategories($type,$per_page);

    public function getListTraslatebleCategories($type = null,$number = null);
    public function getListTraslateblePaginatedCategories($type = null,$per_page);
    public function getListTraslatebleRelatedCategories(Category $category,$number = null);
    public function getListTraslateblePaginatedRelatedCategories(Category $category,$per_page);
    public function getListTraslatebleChildCategories(Category $category,$number = null);
    public function getListTraslateblePaginatedChildCategories(Category $category,$per_page);
    public function getListTraslatebleHotCategories($type,$number = null);
    public function getListTraslateblePaginatedHotCategories($type,$per_page);


}
