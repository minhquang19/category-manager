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

    public function getListTranslatableCategories($type = null,$number = null);
    public function getListPaginatedTranslatableCategories($type = null,$per_page);
    public function getListRelatedTranslatableCategories(Category $category,$number = null);
    public function getListPaginatedRelatedTranslatableCategories(Category $category,$per_page);
    public function getListChildTranslatableCategories(Category $category,$number = null);
    public function getListPaginatedChildTranslatableCategories(Category $category,$per_page);
    public function getListHotTranslatableCategories($type,$number = null);
    public function getListPaginatedHotTranslatableCategories($type,$per_page);


}
