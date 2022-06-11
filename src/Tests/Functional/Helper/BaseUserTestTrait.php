<?php

namespace Evrinoma\UserBundle\Tests\Functional\Helper;


use PHPUnit\Framework\Assert;

trait BaseUserTestTrait
{

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
        $this->checkUser($entity['data']);
    }

    protected function checkUser($entity): void
    {
        Assert::assertArrayHasKey('id', $entity);
        Assert::assertArrayHasKey('username', $entity);
        Assert::assertArrayHasKey('email', $entity);
        Assert::assertArrayHasKey('surname', $entity);
        Assert::assertArrayHasKey('patronymic', $entity);
        Assert::assertArrayHasKey('password', $entity);
        Assert::assertArrayHasKey('roles', $entity);
        Assert::assertArrayHasKey('name', $entity);
        Assert::assertArrayHasKey('active', $entity);
    }

}