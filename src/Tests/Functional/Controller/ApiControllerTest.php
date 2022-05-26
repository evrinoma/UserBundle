<?php

namespace Evrinoma\UserBundle\Tests\Functional\Controller;

use Evrinoma\TestUtilsBundle\Action\ActionTestInterface;
use Evrinoma\TestUtilsBundle\Functional\AbstractFunctionalTest;
use Evrinoma\UserBundle\Fixtures\FixtureInterface;
use Psr\Container\ContainerInterface;

/**
 * @group functional
 */
final class ApiControllerTest extends AbstractFunctionalTest
{
//region SECTION: Fields
    protected string $actionServiceName = 'evrinoma.user.test.functional.action.user';
//endregion Fields

//region SECTION: Protected
    protected function getActionService(ContainerInterface $container): ActionTestInterface
    {
        return $container->get($this->actionServiceName);
    }
//endregion Protected

//region SECTION: Getters/Setters
    public static function getFixtures(): array
    {
        return [FixtureInterface::USER_FIXTURES];
    }
//endregion Getters/Setters
}