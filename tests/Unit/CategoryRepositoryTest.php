<?php

namespace VCComponent\Laravel\Categpry\Test\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use VCComponent\Laravel\Category\Repositories\CategoryRepositoryEloquent;
use VCComponent\Laravel\Category\Entities\Category;
use VCComponent\Laravel\Category\Test\TestCase;
use Illuminate\Pagination\LengthAwarePaginator;

class CategpryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_get_list_categories_by_reposotory_function()
    {
        $cate_repository = app(CategoryRepositoryEloquent::class);

        $data_cate = factory(Category::class, 3)->create()->sortByDesc('created_at')->sortBy('order');

        $cate = $cate_repository->getListCategories('products');
        $cate_number = $cate_repository->getListCategories('products',3);


        $this->assertCategoriesEqualDatas($cate, $data_cate);
        $this->assertCategoriesEqualDatas($cate_number, $data_cate);

    }

    /**
     * @test
     */
    public function can_get_list_paginated_categories_by_reposotory_function()
    {
        $cate_repository = app(CategoryRepositoryEloquent::class);

        $data_cate = factory(Category::class, 3)->create()->sortByDesc('created_at')->sortBy('order');

        $cate_paginated = $cate_repository->getListPaginatedCategories('products',3);

        $this->assertTrue($cate_paginated instanceof LengthAwarePaginator);

        $this->assertCategoriesEqualDatas($cate_paginated, $data_cate);

    }

     /**
     * @test
     */
    public function can_get_list_related_categories_by_reposotory_function()
    {
        $cate_repository = app(CategoryRepositoryEloquent::class);

        $cate = factory(Category::class)->create();
        $related_cate = factory(Category::class, 3)->create()->sortByDesc('created_at')->sortBy('order');


        $categories = $cate_repository->getListRelatedCategories($cate);
        $categories_number = $cate_repository->getListRelatedCategories($cate,3);


        $this->assertCategoriesEqualDatas($categories, $related_cate);
        $this->assertCategoriesEqualDatas($categories_number, $related_cate);

    }

     /**
     * @test
     */
    public function can_get_list_paginated_related_categories_by_reposotory_function()
    {
        $cate_repository = app(CategoryRepositoryEloquent::class);

        $cate = factory(Category::class)->create();
        $related_cate = factory(Category::class, 3)->create()->sortByDesc('created_at')->sortBy('order');

        $cate_paginated = $cate_repository->getListPaginatedRelatedCategories($cate,3);


        $this->assertTrue($cate_paginated instanceof LengthAwarePaginator);
        $this->assertCategoriesEqualDatas($cate_paginated, $related_cate);

    }

     /**
     * @test
     */
    public function can_get_list_child_categories_by_reposotory_function()
    {
        $cate_repository = app(CategoryRepositoryEloquent::class);

        $cate = factory(Category::class)->create();
        $child_cate = factory(Category::class, 3)->create(['parent_id'=>$cate->id])->sortByDesc('created_at')->sortBy('order');


        $categories = $cate_repository->getListChildCategories($cate);
        $categories_number = $cate_repository->getListChildCategories($cate,3);


        $this->assertCategoriesEqualDatas($categories, $child_cate);
        $this->assertCategoriesEqualDatas($categories_number, $child_cate);

    }

     /**
     * @test
     */
    public function can_get_list_paginated_child_categories_by_reposotory_function()
    {
        $cate_repository = app(CategoryRepositoryEloquent::class);

        $cate = factory(Category::class)->create();
        $child_cate = factory(Category::class, 3)->create(['parent_id'=>$cate->id])->sortByDesc('created_at')->sortBy('order');


        $categories_paginated = $cate_repository->getListPaginatedChildCategories($cate,3);

        $this->assertTrue($categories_paginated instanceof LengthAwarePaginator);
        $this->assertCategoriesEqualDatas($categories_paginated, $child_cate);

    }

     /**
     * @test
     */
    public function can_get_list_hot_categories_by_reposotory_function()
    {
        $cate_repository = app(CategoryRepositoryEloquent::class);

        $hot_cate = factory(Category::class, 3)->create(['is_hot'=>1])->sortByDesc('created_at')->sortBy('order');
        $unhot_cate = factory(Category::class, 3)->create(['is_hot'=>2])->sortByDesc('created_at')->sortBy('order');


        $categories = $cate_repository->getListHotCategories($hot_cate[0]->type);
        $categories_number = $cate_repository->getListHotCategories($hot_cate[0]->type,3);


        $this->assertCategoriesEqualDatas($categories, $hot_cate);
        $this->assertCategoriesEqualDatas($categories_number, $hot_cate);

    }

     /**
     * @test
     */
    public function can_get_list_paginated_hot_categories_by_reposotory_function()
    {
        $cate_repository = app(CategoryRepositoryEloquent::class);

        $hot_cate = factory(Category::class, 3)->create(['is_hot'=>1])->sortByDesc('created_at')->sortBy('order');
        $unhot_cate = factory(Category::class, 3)->create(['is_hot'=>2])->sortByDesc('created_at')->sortBy('order');

        $categories_paginated = $cate_repository->getListPaginatedHotCategories($hot_cate[0]->type,3);

        $this->assertTrue($categories_paginated instanceof LengthAwarePaginator);
        $this->assertCategoriesEqualDatas($categories_paginated, $hot_cate);

    }

    protected function assertCategoriesEqualDatas($cate, $datas) {
        $this->assertEquals($cate->pluck('name'), $datas->pluck('name'));
        $this->assertEquals($cate->pluck('type'), $datas->pluck('type'));
        $this->assertEquals($cate->pluck('description'), $datas->pluck('description'));
        $this->assertEquals($cate->pluck('order'), $datas->pluck('order'));
    }


}
