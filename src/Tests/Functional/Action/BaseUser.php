<?php

namespace Evrinoma\UserBundle\Tests\Functional\Action;

use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\UserBundle\Dto\UserApiDto;

class BaseUser extends AbstractServiceTest implements BaseUserTestInterface
{
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
            "id"          => '1',
            "class"       => static::getDtoClass(),
        ];
    }
//endregion Protected

//region SECTION: Public
    public function actionPost(): void
    {

    }

    public function actionCriteriaNotFound(): void
    {

    }

    public function actionCriteria(): void
    {

    }

    public function actionDelete(): void
    {

    }

    public function actionPut(): void
    {

    }

    public function actionGet(): void
    {

    }

    public function actionGetNotFound(): void
    {

    }

    public function actionDeleteNotFound(): void
    {

    }

    public function actionDeleteUnprocessable(): void
    {

    }

    public function actionPutNotFound(): void
    {

    }

    public function actionPutUnprocessable(): void
    {

    }

    public function actionPostDuplicate(): void
    {

    }

    public function actionPostUnprocessable(): void
    {
    }
//endregion Public
}