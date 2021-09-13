<?php

namespace VCComponent\Laravel\Category\Contracts;

interface CategoryPolicyInterface 
{
    public function ableToShow($user, $model);
    public function ableToCreate($user);
    public function ableToUpdate($user);
    public function ableToDelete($user, $model);
}