<?php

namespace VCComponent\Laravel\Category\Test\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
// use VCComponent\Laravel\Category\Categories\Facades\Category;
use VCComponent\Laravel\Category\Entities\Category as BaseCate;
use VCComponent\Laravel\Category\Repositories\CategoryRepository;
use VCComponent\Laravel\Category\Test\Stubs\Models\Category;
use VCComponent\Laravel\Category\Test\Unit\CategoryQueryTraitTestCase;
use VCComponent\Laravel\Vicoders\Core\Exceptions\NotFoundException;
use VCComponent\Laravel\Category\Repositories\CategoryRepositoryEloquent;
// use VCComponent\Laravel\Post\Repositories\PostRepository;


class CategoryQueryTraitTest extends CategoryQueryTraitTestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_get_category_all()
    {
        $repository = App::make(CategoryRepository::class);
        $cate  = factory(BaseCate::class)->create();
        $about = factory(BaseCate::class)->create(['type' => 'about']);
        $this->assertSame($cate->id, $repository->getListCategories()[0]->id);
        $this->assertSame($about->id, $repository->getListCategories('about',null)[0]->id);
    }

    /**
     * @test
     */
    public function can_get_category_all_paginate()
    {
        $repository = App::make(CategoryRepository::class);
        $cate  = factory(BaseCate::class)->create();
        $about = factory(BaseCate::class)->create(['type' => 'about']);
        $this->assertSame($cate->id, $repository->getListPaginatedCategories(null,8)[0]->id);
        $this->assertSame($about->id, $repository->getListPaginatedCategories('about',null)[0]->id);
    }


    /**
     * @test
     */
    public function can_get_list_related_categories()
    {
        $repository = App::make(CategoryRepository::class);
        $cate_a  = factory(BaseCate::class)->create(['name'=>'catea','type'=>'cate']);
        $cate_b  = factory(BaseCate::class)->create(['name'=>'cateb','type'=>'cate'],);
        $cate_c  = factory(BaseCate::class)->create(['name'=>'catec','type'=>'about']);
        $this->assertSame($cate_a->name, $repository->getListRelatedCategories($cate_b)[0]->name);
    }

    /**
     * @test
     */
    public function can_get_list_related_categories_paginate()
    {
        $repository = App::make(CategoryRepository::class);
        $cate_a  = factory(BaseCate::class)->create(['name'=>'catea','type'=>'cate']);
        $cate_b  = factory(BaseCate::class)->create(['name'=>'cateb','type'=>'cate'],);
        $cate_c  = factory(BaseCate::class)->create(['name'=>'catec','type'=>'about']);
        $this->assertSame($cate_a->name, $repository->getListRelatedCategories($cate_b)[0]->name);
    }

    /**
     * @test
     */
    public function can_get_list_child_categories()
    {
        $repository = App::make(CategoryRepository::class);
        $cate_a  = factory(BaseCate::class)->create(['name'=>'catea','type'=>'cate']);
        $cate_b  = factory(BaseCate::class)->create(['name'=>'cateb','type'=>'cate','parent_id'=>$cate_a->id],);
        $cate_c  = factory(BaseCate::class)->create(['name'=>'catec','type'=>'cate']);
        $this->assertSame($cate_b->name, $repository->getListChildCategories($cate_a)[0]->name);
    }

    /**
     * @test
     */
    public function can_get_list_child_categories_paginate()
    {
        $repository = App::make(CategoryRepository::class);
        $cate_a  = factory(BaseCate::class)->create(['name'=>'catea','type'=>'cate']);
        $cate_b  = factory(BaseCate::class)->create(['name'=>'cateb','type'=>'cate','parent_id'=>$cate_a->id],);
        $cate_c  = factory(BaseCate::class)->create(['name'=>'catec','type'=>'cate']);
        $this->assertSame($cate_b->name, $repository->getListChildCategories($cate_a)[0]->name);
    }

    /**
     * @test
     */
    public function can_get_list_hot_categories()
    {
        $repository = App::make(CategoryRepository::class);
        $cate_a  = factory(BaseCate::class)->create(['name'=>'catea','type'=>'cate','is_hot'=>1]);
        $cate_b  = factory(BaseCate::class)->create(['name'=>'cateb','type'=>'cate','is_hot'=>1],);
        $cate_c  = factory(BaseCate::class)->create(['name'=>'catec','type'=>'cate','is_hot'=>0]);
        $this->assertSame($cate_a->name, $repository->getListHotCategories(['type'=>'cate'])[0]->name);
    }

    /**
     * @test
     */
    public function can_get_list_hot_categories_paginate()
    {
        $repository = App::make(CategoryRepository::class);
        $cate_a  = factory(BaseCate::class)->create(['name'=>'catea','type'=>'cate','is_hot'=>1]);
        $cate_b  = factory(BaseCate::class)->create(['name'=>'cateb','type'=>'cate','is_hot'=>1],);
        $cate_c  = factory(BaseCate::class)->create(['name'=>'catec','type'=>'cate','is_hot'=>0]);
        $this->assertSame($cate_a->name, $repository->getListHotCategories(['type'=>'cate'])[0]->name);
    }







}
