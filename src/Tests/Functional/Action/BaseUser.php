<?php

namespace Evrinoma\UserBundle\Tests\Functional\Action;

use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\UserBundle\Dto\UserApiDto;
use Evrinoma\UserBundle\Tests\Functional\Helper\BaseUserTestTrait;
use Evrinoma\UserBundle\Tests\Functional\ValueObject\User\Active;
use Evrinoma\UserBundle\Tests\Functional\ValueObject\User\Email;
use Evrinoma\UserBundle\Tests\Functional\ValueObject\User\Id;
use Evrinoma\UserBundle\Tests\Functional\ValueObject\User\Name;
use Evrinoma\UserBundle\Tests\Functional\ValueObject\User\Password;
use Evrinoma\UserBundle\Tests\Functional\ValueObject\User\Username;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use PHPUnit\Framework\Assert;

class BaseUser extends AbstractServiceTest implements BaseUserTestInterface
{
    use BaseUserTestTrait;

//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/user';
    public const API_CRITERIA = 'evrinoma/api/user/criteria';
    public const API_DELETE   = 'evrinoma/api/user/delete';
    public const API_PUT      = 'evrinoma/api/user/save';
    public const API_POST     = 'evrinoma/api/user/create';
//endregion Fields

//region SECTION: Protected
    protected static function getDtoClass(): string
    {
        return UserApiDto::class;
    }

    protected static function defaultData(): array
    {
        return [
            "id"         => Id::value(),
            "class"      => static::getDtoClass(),
            "username"   => "IIvanov",
            "email"      => "IIvanov@ite-ng.ru",
            "password"   => Password::value(),
            "active"     => Active::block(),
            "name"       => Name::value(),
            "surname"    => "Ivanov",
            "patronymic" => "Ivanovich",
            "expired_at" => "2021-12-30",
            "roles"      => ["A", "B", "C"],
        ];
    }
//endregion Protected

//region SECTION: Public
    public function actionPost(): void
    {
        $this->createUser();
        $this->testResponseStatusCreated();
    }

    public function actionCriteriaNotFound(): void
    {
        $query    = static::getDefault(['id' => Id::value(), 'username' => Username::value(), 'email' => Email::value(), 'active' => Active::value()]);
        $response = $this->criteria($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(1, $response['data']);
        $entity = $response['data'][0];
        $this->checkUser($entity);
        Assert::assertEquals(Username::value(), $entity['username']);
        Assert::assertEquals(Email::value(), $entity['email']);
        Assert::assertEquals(Id::value(), $entity['id']);
        Assert::assertEquals(Active::value(), $entity['active']);

        $query    = static::getDefault(['id' => Id::value(), 'username' => Username::value(), 'email' => Email::value(), 'active' => Active::wrong()]);
        $response = $this->criteria($query);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey('data', $response);
    }

    public function actionCriteria(): void
    {
        $query    = static::getDefault(['id' => Id::empty(), 'username' => Username::value(), 'email' => Email::empty(), 'active' => Active::empty()]);
        $response = $this->criteria($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(1, $response['data']);
        $entity = $response['data'][0];
        $this->checkUser($entity);
        Assert::assertEquals(Username::value(), $entity['username']);

        $query    = static::getDefault(['id' => Id::empty(), 'username' => Username::value(), 'email' => Email::value(), 'active' => Active::empty()]);
        $response = $this->criteria($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(1, $response['data']);
        $entity = $response['data'][0];
        $this->checkUser($entity);
        Assert::assertEquals(Username::value(), $entity['username']);
        Assert::assertEquals(Email::value(), $entity['email']);


        $query    = static::getDefault(['id' => Id::value(), 'username' => Username::value(), 'email' => Email::value(), 'active' => Active::empty()]);
        $response = $this->criteria($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(1, $response['data']);
        $entity = $response['data'][0];
        $this->checkUser($entity);
        Assert::assertEquals(Username::value(), $entity['username']);
        Assert::assertEquals(Email::value(), $entity['email']);
        Assert::assertEquals(Id::value(), $entity['id']);

        $query    = static::getDefault(['id' => Id::value(), 'username' => Username::value(), 'email' => Email::value(), 'active' => Active::value()]);
        $response = $this->criteria($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(1, $response['data']);
        $entity = $response['data'][0];
        $this->checkUser($entity);
        Assert::assertEquals(Username::value(), $entity['username']);
        Assert::assertEquals(Email::value(), $entity['email']);
        Assert::assertEquals(Id::value(), $entity['id']);
        Assert::assertEquals(Active::value(), $entity['active']);
    }

    public function actionDelete(): void
    {
        $find = $this->assertGet(Id::value());

        Assert::assertEquals(ActiveModel::ACTIVE, $find['data']['active']);

        $this->delete(Id::value());
        $this->testResponseStatusAccepted();

        $delete = $this->assertGet(Id::value());

        Assert::assertEquals(ActiveModel::DELETED, $delete['data']['active']);
    }

    public function actionPut(): void
    {
        $find = $this->assertGet(Id::value());

        $updated = $this->put(static::getDefault());
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $updated);
        Assert::assertNotEquals($updated['data'], $find['data']);

        $criteria = $this->get(Id::value());
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $criteria);
        Assert::assertEquals($updated['data'], $criteria['data']);
    }

    public function actionGet(): void
    {
        $find = $this->assertGet(Id::value());
    }

    public function actionGetNotFound(): void
    {
        $response = $this->get(Id::wrong());
        Assert::assertArrayHasKey('data', $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteNotFound(): void
    {
        $response = $this->delete(Id::wrong());
        Assert::assertArrayHasKey('data', $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteUnprocessable(): void
    {
        $this->delete(Id::empty());
        $this->testResponseStatusUnprocessable();
    }

    public function actionPutNotFound(): void
    {
        $updated = $this->put(static::getDefault(['id' => Id::wrong()]));
        $this->testResponseStatusNotFound();
    }

    public function actionPutUnprocessable(): void
    {
        $updated = $this->put(static::getDefault(['id' => Id::empty()]));
        $this->testResponseStatusUnprocessable();
    }

    public function actionPostDuplicate(): void
    {
        $this->createUser();
        $this->testResponseStatusCreated();

        $this->createUser();
        $this->testResponseStatusConflict();
    }

    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $this->post(static::getDefault(['password' => Password::wrong()]));
        $this->testResponseStatusUnprocessable();
    }
//endregion Public
}