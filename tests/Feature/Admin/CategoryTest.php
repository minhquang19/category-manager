<?php

namespace VCComponent\Laravel\Category\Test\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use VCComponent\Laravel\Category\Entities\Category;
use VCComponent\Laravel\Category\Test\TestCase;
use VCComponent\Laravel\User\Entities\User;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_create_category_admin()
    {
        $token = $this->loginToken();
        factory(Category::class)->create(['name' => 'category test']);
        $data = factory(Category::class)->make(['name' => 'category test'])->toArray();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('POST', 'api/category-management/admin/categories', $data);
        $response->assertStatus(500);
        $response->assertJson([
            'message' => 'Tên danh mục không được để trùng nhau',
        ]);

        $data = factory(Category::class)->make(['name' => 'category test', 'type' => 'posts'])->toArray();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('POST', 'api/category-management/admin/categories', $data);
        $response->assertStatus(200);
        $response->assertJsonMissing(['slug' => 'category-test']);

        $data = factory(Category::class)->make(['name' => ''])->toArray();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('POST', 'api/category-management/admin/categories', $data);
        $this->assertValidation($response, 'name', "The name field is required.");

        $data = factory(Category::class)->make()->toArray();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('POST', 'api/category-management/admin/categories', $data);
        $response->assertStatus(200);
        $response->assertJson($data);

        $this->assertDatabaseHas('categories', $data);
    }
    /**
     * @test
     */
    public function should_update_category_admin()
    {
        $token = $this->loginToken();
        factory(Category::class)->create(['name' => 'category test']);
        $category = factory(Category::class)->make();
        $category->save();
        unset($category['updated_at']);
        unset($category['created_at']);

        $id = $category->id;
        $category->name = 'category test';
        $data = $category->toArray();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('PUT', 'api/category-management/admin/categories/' . $id, $data);

        $response->assertStatus(500);
        $response->assertJson([
            'message' => 'Tên danh mục không được để trùng nhau',
        ]);
        $category->name = "update name";
        $data = $category->toArray();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('PUT', 'api/category-management/admin/categories/' . $id, $data);
        $response->assertStatus(200);
        $response->assertJson([
            'name' => $data['name'],
        ]);

        $this->assertDatabaseHas('categories', $data);
    }
    /**
     * @test
     */
    public function should_soft_delete_category_admin()
    {
        $token = $this->loginToken();
        $category = factory(Category::class)->create()->toArray();
        unset($category['updated_at']);
        unset($category['created_at']);
        $this->assertDatabaseHas('categories', $category);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('DELETE', 'api/category-management/admin/categories/' . $category['id']);
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDeleted('categories', $category);

    }

    /**
     * @test
     */
    public function should_get_category_list_paginate_admin()
    {
        $token = $this->loginToken();
        $category = factory(Category::class, 5)->create();
        $category = $category->map(function ($e) {
            unset($e['updated_at']);
            unset($e['created_at']);
            return $e;
        })->toArray();

        $listIds = array_column($category, 'id');
        array_multisort($listIds, SORT_DESC, $category);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('GET', 'api/category-management/admin/categories');
        $response->assertStatus(200);
        $response->assertJson(['data' => $category]);
        $response->assertJson(['per_page' => 15]);

    }

    /**
     * @test
     */
    public function should_get_category_item_admin()
    {
        $token = $this->loginToken();

        $category = factory(Category::class)->create();
        unset($category['updated_at']);
        unset($category['created_at']);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('GET', 'api/category-management/admin/categories/' . $category->id);

        $response->assertStatus(200);
        $response->assertJson([
            'name' => $category->name,
            'description' => $category->description,
        ]);
    }
    /**
     * @test
     */
    public function should_get_category_list_admin()
    {
        $category = factory(Category::class, 5)->create();
        $token = $this->loginToken();
        $category = $category->map(function ($e) {
            unset($e['updated_at']);
            unset($e['created_at']);
            return $e;
        })->toArray();
        $listIds = array_column($category, 'id');
        array_multisort($listIds, SORT_DESC, $category);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('GET', 'api/category-management/admin/categories/all');

        $response->assertStatus(200);
        $response->assertJson($category);
    }
    /**
     * @test
     */
    public function should_update_status_category_admin()
    {
        $token = $this->loginToken();
        $category = factory(Category::class)->create()->toArray();
        unset($category['updated_at']);
        unset($category['created_at']);

        $this->assertDatabaseHas('categories', $category);

        $data = ['status' => 2];
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('PUT', 'api/category-management/admin/categories/status/' . $category['id'], $data);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('GET', 'api/category-management/admin/categories/' . $category['id']);
        $response->assertJson($data);

    }
    /**
     * @test
     */

    public function should_bulk_update_status_category_by_admin()
    {
        $categories = factory(Category::class, 5)->create();
        $token = $this->loginToken();
        $categories = $categories->map(function ($e) {
            unset($e['updated_at']);
            unset($e['created_at']);
            return $e;
        })->toArray();

        $listIds = array_column($categories, 'id');

        $data = ['item_ids' => $listIds, 'status' => 2];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('GET', 'api/category-management/admin/categories/all');
        $response->assertJsonFragment(['status' => '1']);

        $response = $this->json('PUT', 'api/category-management/admin/categories/status/bulk', $data);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('GET', 'api/category-management/admin/categories');
        $response->assertJsonFragment(['status' => '2']);
        $this->assertDatabaseMissing('categories', ['status' => 1]);

    }
    /**
     * @test
     */
    public function should_bulk_move_category_admin()
    {
        $token = $this->loginToken();
        $listCategories = [];
        for ($i = 0; $i < 5; $i++) {
            $categories = factory(Category::class)->create()->toArray();
            unset($categories['updated_at']);
            unset($categories['created_at']);
            array_push($listCategories, $categories);
        }

        $listIds = array_column($listCategories, 'id');
        $data = ["ids" => $listIds];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('DELETE', 'api/category-management/admin/categories/bulk-delete', $data);
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        foreach ($listCategories as $item) {
            $this->assertDeleted('categories', $item);
        }
    }

    protected function loginToken()
    {

        $dataLogin = ['username' => 'admin', 'password' => '123456789', 'email' => 'admin@test.com'];

        $user = factory(User::class)->make($dataLogin);
        $user->save();
        $login = $this->json('POST', 'api/user-management/login', $dataLogin);
        $token = $login->Json()['token'];
        $this->withoutMiddleware();
        return $token;
    }

}
