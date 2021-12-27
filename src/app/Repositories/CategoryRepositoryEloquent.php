<?php

namespace VCComponent\Laravel\Category\Repositories;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\App;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use VCComponent\Laravel\Category\Entities\Category;
use VCComponent\Laravel\Category\Repositories\CategoryRepository;
use Illuminate\Support\Facades\DB;
use VCComponent\Laravel\Vicoders\Core\Exceptions\NotFoundException;

/**
 * Class CategoryRepositoryEloquent.
 *
 * @package namespace VCComponent\Laravel\Category\Repositories;
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        if (isset(config('category.models')['category'])) {
            return config('category.models.category');
        } else {
            return Category::class;
        }
    }

    public function getEntity()
    {
        return $this->model;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getWithPagination($filters)
    {
        $request = App::make(Request::class);
        $query   = $this->getEntity();

        $items = App::make(Pipeline::class)
            ->send($query)
            ->through($filters)
            ->then(function ($content) use ($request) {
                $per_page   = $request->has('per_page') ? (int) $request->get('per_page') : 15;
                $categories = $content->paginate($per_page);
                return $categories;
            });

        return $items;
    }

    public function getCategoriesQuery(array $where, $number = 10, $order_by ='order', $order = 'asc',$columns = ['*']) {
        $query =  $this->getEntity()->where($where)
            ->orderBy($order_by,$order);
        if ($number > 0) {
            return  $query->limit($number)->get($columns);
        }
        return $query->get($columns);
    }

    public function getCategoriesQueryPaginate(array $where, $number = 10, $order_by ='order', $order = 'asc', $columns = ['*']) {
        $query =  $this->getEntity()->select($columns)
            ->where($where)
            ->orderBy($order_by,$order)
            ->paginate($number);
        return $query;
    }

    public function getPostCategoriesQuery($post_id, array $where, $post_type = 'posts', $number = 10, $order_by = 'order', $order = 'asc') {
        $query = DB::table('categoryables')->where('categoryable_id',$post_id)
        ->where('categoryable_type',$post_type)
        ->join('categories', 'category_id', '=', 'categories.id')->select("categories.*")
            ->orderBy($order_by,$order)
            ->where($where);
        if ($number > 0) {
            return  $query->limit($number)->get();
        }
        return $query->get();
    }

    public function getPostCategoriesQueryPaginate($post_id, array $where, $post_type = 'posts', $number = 10, $order_by = 'order', $order = 'asc') {
        $query = DB::table('categoryables')->where('categoryable_id',$post_id)
        ->where('categoryable_type',$post_type)
        ->join('categories', 'category_id', '=', 'categories.id')->select('categories.*')
            ->orderBy($order_by,$order)
            ->where($where)
            ->paginate($number);
        return $query;
    }

    public function getAllCategoriesByType($type)
    {
        try {
            return $this->model->where('status', 1)->ofType($type)->get();
        } catch (Exception $e) {
            throw new NotFoundException($e);
        }
    }

    public function getCategoryBySlug($slug)
    {
        try {
            return $this->model->where(['status' => '1', 'slug' => $slug])->first();
        } catch (Exception $e) {
            throw new NotFoundException($e);
        }
    }

    public function findCategoriesByWhere(array $where, $type, $number = 10, $order_by = 'order', $order = 'asc')
    {
        try {
            $query = $this->model->ofType($type)
                ->where('status', 1)
                ->where($where)
                ->orderBy($order_by, $order);
            if ($number > 0) {
                return $query->limit($number)->get();
            }
            return $query->get();
        } catch (Exception $e) {
            throw new NotFoundException($e);
        }
    }

    public function findCategoriesByField($field, $value = null, $type)
    {
        try {
            return $this->model->ofType($type)->where([$field => $value, 'status' => 1])->get();
        } catch (Exception $e) {
            throw new NotFoundException('categories not found');
        }
    }

    public function getCategoryByID($cate_id)
    {
        return $this->model->where(['id' => $cate_id, 'status' => 1])->first();
    }

    public function getCategoriesUrl($cate_id)
    {
        $cate = $this->model->where('id', $cate_id)->first();
        return '/' . $cate->type . '/' . $cate->slug;
    }

    public function getAllCategoriesWithout($type, array $where)
    {
        return $this->model->where('status', 1)->ofType($type)->whereNotIn('slug', $where)->orderBy('order', 'asc');
    }


}
