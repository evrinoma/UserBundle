<?php

namespace Evrinoma\UserBundle\DependencyInjection\Compiler;


use Evrinoma\UserBundle\EvrinomaUserBundle;
use Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DecoratorPass extends AbstractRecursivePass
{

    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $decoratorQuery = $container->getParameter('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.decorates.query');
        if ($decoratorQuery) {
            $queryMediator = $container->getDefinition($decoratorQuery);
            $repository    = $container->getDefinition('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.repository');
            $repository->setArgument(2, $queryMediator);
        }
        $decoratorCommand = $container->getParameter('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.decorates.command');
        if ($decoratorCommand) {
            $commandMediator = $container->getDefinition($decoratorCommand);
            $commandManager  = $container->getDefinition('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.command.manager');
            $commandManager->setArgument(3, $commandMediator);
        }

        $decoratorRole = $container->hasParameter('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.role.mediator');
        if ($decoratorRole) {
            $decoratorRole = $container->getParameter('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.role.mediator');
            $decoratorRoleMediator = $container->getDefinition($decoratorRole);
            $apiController         = $container->getDefinition('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.command.mediator');
            $apiController->setArgument(1, $decoratorRoleMediator);
        }

        $decoratorPreValidator = $container->getParameter('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.decorates.pre.validator');
        if ($decoratorPreValidator) {
            $preValidator  = $container->getDefinition($decoratorPreValidator);
            $apiController = $container->getDefinition('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.api.controller');
            $apiController->setArgument(5, $preValidator);

            $command = $container->getDefinition('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.bridge.create');
            $command->setArgument(3, $preValidator);
        }
        $decoratorPreCheckerPassword = $container->getParameter('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.decorates.pre.checker.password');
        if ($decoratorPreCheckerPassword) {
            $preCheckerPost = $container->getDefinition($decoratorPreCheckerPassword);
            if ($container->hasDefinition('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.decorates.pre.validator')) {
                $preValidator = $container->getDefinition('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.decorates.pre.validator');
            } else {
                $preValidator = $container->getDefinition('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.pre.validator');
            }
            $preValidator->setArgument(0, $preCheckerPost);
        }
    }
}