<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\UserBundle\DependencyInjection\Compiler;

use Evrinoma\UserBundle\EvrinomaUserBundle;
use Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ServicePass extends AbstractRecursivePass
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $serviceRole = $container->hasParameter('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.services.role.mediator');
        if ($serviceRole) {
            $serviceRole = $container->getParameter('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.services.role.mediator');
            $serviceRoleMediator = $container->getDefinition($serviceRole);
            $commandMediator = $container->getDefinition('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.command.mediator');
            $commandMediator->setArgument(1, $serviceRoleMediator);
        }

        $servicePreValidator = $container->hasParameter('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.services.pre.validator');
        if ($servicePreValidator) {
            $servicePreValidator = $container->getParameter('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.services.pre.validator');
            $preValidator = $container->getDefinition($servicePreValidator);
            $apiController = $container->getDefinition('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.api.controller');
            $apiController->setArgument(5, $preValidator);
            $bridgeCreate = $container->getDefinition('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.bridge.create');
            $bridgeCreate->setArgument(3, $preValidator);
        }

        $servicePreCheckerPassword = $container->hasParameter('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.services.pre.checker.password');
        if ($servicePreCheckerPassword) {
            $servicePreCheckerPassword = $container->getParameter('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.services.pre.checker.password');
            $preCheckerPost = $container->getDefinition($servicePreCheckerPassword);
            if ($container->hasDefinition('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.services.pre.validator')) {
                $preValidator = $container->getDefinition('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.services.pre.validator');
            } else {
                $preValidator = $container->getDefinition('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.pre.validator');
            }
            $preValidator->setArgument(0, $preCheckerPost);
        }

        $serviceBridgeCreate = $container->hasParameter('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.services.bridge.create');
        if ($serviceBridgeCreate) {
            $serviceBridgeCreate = $container->getParameter('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.services.bridge.create');
            $bridgeCreate = $container->getDefinition($serviceBridgeCreate);
            $commandCreate = $container->getDefinition('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.command.create');
            $commandCreate->setArgument(1, $bridgeCreate);
        }

        $serviceBridgeRole = $container->hasParameter('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.services.bridge.role');
        if ($serviceBridgeRole) {
            $serviceBridgeRole = $container->getParameter('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.services.bridge.role');
            $bridgeRole = $container->getDefinition($serviceBridgeRole);
            $commandRole = $container->getDefinition('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.command.role');
            $commandRole->setArgument(1, $bridgeRole);
        }
    }
}
