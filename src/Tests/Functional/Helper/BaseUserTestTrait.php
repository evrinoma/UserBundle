<?php

namespace Evrinoma\UserBundle\Tests\Functional\Helper;


use PHPUnit\Framework\Assert;

trait BaseUserTestTrait
{
//region SECTION: Protected
    protected function assertGet(int $id): array
    {
        $find = $this->get($id);
        $this->testResponseStatusOK();

        $this->checkResult($find);

        return $find;
    }

    protected function createUser(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    protected function checkResult($entity): void
    {
        Assert::assertArrayHasKey('data', $entity);
        Assert::assertArrayHasKey('id', $entity['data']);
        Assert::assertArrayHasKey('username', $entity['data']);
        Assert::assertArrayHasKey('email', $entity['data']);
        Assert::assertArrayHasKey('surname', $entity['data']);
        Assert::assertArrayHasKey('patronymic', $entity['data']);
        Assert::assertArrayHasKey('password', $entity['data']);
        Assert::assertArrayHasKey('roles', $entity['data']);
        Assert::assertArrayHasKey('name', $entity['data']);
        Assert::assertArrayHasKey('active', $entity['data']);
    }
//endregion Protected
}