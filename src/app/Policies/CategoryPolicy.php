<?php

namespace VCComponent\Laravel\Category\Policies;

use VCComponent\Laravel\Category\Contracts\CategoryPolicyInterface;

class CategoryPolicy implements CategoryPolicyInterface
{
    public function before($user, $ability)
    {
        if ($user->isAdministrator()) {
            return true;
        }
    }

    public function view($user, $model)
    {
        return $user->hasPermission('view-category');
    }

    public function create($user)
    {
        return $user->hasPermission('create-category');
    }

    public function update($user)
    {
        return $user->hasPermission('update-category');
    }

    public function delete($user, $model)
    {
        return $user->hasPermission('delete-category');
    }
}