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

    protected string $actionServiceName = 'evrinoma.user.test.functional.action.user';


    protected function getActionService(ContainerInterface $container): ActionTestInterface
    {
        return $container->get($this->actionServiceName);
    }


    public static function getFixtures(): array
    {
        return [FixtureInterface::USER_FIXTURES];
    }

}