<?php

namespace Evrinoma\UserBundle\Tests\Functional\Helper;


trait BaseUserTestTrait
{
//region SECTION: Protected
    protected function createUser(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }
//endregion Protected
}