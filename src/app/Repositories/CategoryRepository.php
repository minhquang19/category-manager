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
    public function getAllCategoriesByType( $type);
    public function getCategoryBySlug( $slug);
    public function findCategoriesByWhere(array $where, $type, $number = 10, $order_by = 'order', $order = 'asc');
    public function findCategoriesByField($field, $value, $type);
    public function getCategoryByID($cate_id);
    public function getCategoriesUrl($cate_id);
    public function getAllCategoriesWithout($type,array $where);

}
