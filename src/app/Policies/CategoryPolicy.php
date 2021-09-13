<?php

namespace VCComponent\Laravel\Category\Policies;

use VCComponent\Laravel\Category\Contracts\CategoryPolicyInterface;

class CategoryPolicy implements CategoryPolicyInterface
{
    public function ableToShow($user, $model)
    {
        return true;
    }

    public function ableToCreate($user)
    {
        return true;
    }

    public function ableToUpdate($user)
    {
        return true;
    }

    public function ableToDelete($user, $model)
    {
        return true;
    }
}