<?php

namespace Evrinoma\UserBundle\DependencyInjection\Compiler;


use Evrinoma\UserBundle\EvrinomaUserBundle;
use Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DecoratorPass extends AbstractRecursivePass
{
//region SECTION: Public
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
        $decoratorPreValidator = $container->getParameter('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.decorates.pre.validator');
        if ($decoratorPreValidator) {
            $preValidator  = $container->getDefinition($decoratorPreValidator);
            $apiController = $container->getDefinition('evrinoma.'.EvrinomaUserBundle::USER_BUNDLE.'.api.controller');
            $apiController->setArgument(5, $preValidator);
        }
    }
}