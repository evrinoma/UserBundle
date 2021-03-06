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

namespace Evrinoma\UserBundle\DependencyInjection;

use Evrinoma\UserBundle\Command\Bridge\UserCreateBridge;
use Evrinoma\UserBundle\Command\Bridge\UserRoleBridge;
use Evrinoma\UserBundle\DependencyInjection\Compiler\Constraint\Property\UserPass;
use Evrinoma\UserBundle\Dto\Preserve\UserApiDto as PreserveUserApiDto;
use Evrinoma\UserBundle\Dto\UserApiDto;
use Evrinoma\UserBundle\EvrinomaUserBundle;
use Evrinoma\UserBundle\Repository\UserCommandRepositoryInterface;
use Evrinoma\UserBundle\Repository\UserQueryRepositoryInterface;
use Evrinoma\UtilsBundle\DependencyInjection\HelperTrait;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class EvrinomaUserExtension extends Extension
{
    use HelperTrait;

    public const ENTITY = 'Evrinoma\UserBundle\Entity';
    public const ENTITY_FACTORY_USER = 'Evrinoma\UserBundle\Factory\UserFactory';
    public const ENTITY_BASE_USER = self::ENTITY.'\User\BaseUser';
    public const DTO_BASE_USER = UserApiDto::class;
    public const DTO_PRESERVE_BASE_USER = PreserveUserApiDto::class;
    public const BRIDGE_CREATE_USER = UserCreateBridge::class;
    public const BRIDGE_ROLES_USER = UserRoleBridge::class;
    /**
     * @var array
     */
    private static array $doctrineDrivers = [
        'orm' => [
            'registry' => 'doctrine',
            'tag' => 'doctrine.event_subscriber',
        ],
    ];

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if ('prod' !== $container->getParameter('kernel.environment')) {
            $loader->load('fixtures.yml');
        }

        if ('test' === $container->getParameter('kernel.environment')) {
            $loader->load('tests.yml');
        }

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        if (self::ENTITY_FACTORY_USER !== $config['factory']) {
            $this->wireFactory($container, $config['factory'], $config['entity']);
        } else {
            $definitionFactory = $container->getDefinition('evrinoma.'.$this->getAlias().'.factory');
            $definitionFactory->setArgument(0, $config['entity']);
        }

        $doctrineRegistry = null;

        if (isset(self::$doctrineDrivers[$config['db_driver']])) {
            $loader->load('doctrine.yml');
            $container->setAlias('evrinoma.'.$this->getAlias().'.doctrine_registry', new Alias(self::$doctrineDrivers[$config['db_driver']]['registry'], false));
            $doctrineRegistry = new Reference('evrinoma.'.$this->getAlias().'.doctrine_registry');
            $container->setParameter('evrinoma.'.$this->getAlias().'.backend_type_'.$config['db_driver'], true);
            $objectManager = $container->getDefinition('evrinoma.'.$this->getAlias().'.object_manager');
            $objectManager->setFactory([$doctrineRegistry, 'getManager']);
        }

        $this->remapParametersNamespaces(
            $container,
            $config,
            [
                '' => [
                    'db_driver' => 'evrinoma.'.$this->getAlias().'.storage',
                    'entity' => 'evrinoma.'.$this->getAlias().'.entity',
                ],
            ]
        );

        if ($doctrineRegistry) {
            $this->wireRepository($container, $doctrineRegistry, $config['entity']);
        }

        $this->wireController($container, $config['dto']);

        $this->wireValidator($container, $config['entity']);

        if ($config['constraints']) {
            $loader->load('validation.yml');
        }

        $this->wireConstraintTag($container);

        $this->wireBridge($container, $config['preserve_dto']);

        if ($config['decorates']) {
            $remap = [];
            foreach ($config['decorates'] as $key => $service) {
                if (null !== $service) {
                    switch ($key) {
                        case 'command':
                            $remap['command'] = 'evrinoma.'.$this->getAlias().'.decorates.command';
                            break;
                        case 'query':
                            $remap['query'] = 'evrinoma.'.$this->getAlias().'.decorates.query';
                            break;
                    }
                }
            }

            $this->remapParametersNamespaces(
                $container,
                $config['decorates'],
                ['' => $remap]
            );
        }

        if ($config['services']) {
            $remap = [];
            foreach ($config['services'] as $key => $service) {
                if (null !== $service) {
                    switch ($key) {
                        case 'pre_validator':
                            $remap['pre_validator'] = 'evrinoma.'.$this->getAlias().'.services.pre.validator';
                            break;
                        case 'password_pre_checker':
                            $remap['password_pre_checker'] = 'evrinoma.'.$this->getAlias().'.services.pre.checker.password';
                            break;
                        case 'role_mediator':
                            $remap['role_mediator'] = 'evrinoma.'.$this->getAlias().'.services.role.mediator';
                            break;
                        case 'create_bridge':
                            $remap['create_bridge'] = 'evrinoma.'.$this->getAlias().'.services.bridge.create';
                            break;
                        case 'role_bridge':
                            $remap['role_bridge'] = 'evrinoma.'.$this->getAlias().'.services.bridge.role';
                            break;
                    }
                }
            }

            $this->remapParametersNamespaces(
                $container,
                $config['services'],
                ['' => $remap]
            );
        }
    }

    private function wireBridge(ContainerBuilder $container, string $class): void
    {
        $definitionBridgeCreate = $container->getDefinition('evrinoma.'.$this->getAlias().'.bridge.create');
        $definitionBridgeCreate->setArgument(3, $class);
        $definitionBridgeRoles = $container->getDefinition('evrinoma.'.$this->getAlias().'.bridge.role');
        $definitionBridgeRoles->setArgument(4, $class);
    }

    private function wireConstraintTag(ContainerBuilder $container): void
    {
        foreach ($container->getDefinitions() as $key => $definition) {
            switch (true) {
                case str_contains($key, UserPass::USER_CONSTRAINT)   :
                    $definition->addTag(UserPass::USER_CONSTRAINT);
                    break;
                default:
            }
        }
    }

    private function wireRepository(ContainerBuilder $container, Reference $doctrineRegistry, string $class): void
    {
        $definitionRepository = $container->getDefinition('evrinoma.'.$this->getAlias().'.repository');
        $definitionQueryMediator = $container->getDefinition('evrinoma.'.$this->getAlias().'.query.mediator');
        $definitionRepository->setArgument(0, $doctrineRegistry);
        $definitionRepository->setArgument(1, $class);
        $definitionRepository->setArgument(2, $definitionQueryMediator);
        $container->addAliases([UserCommandRepositoryInterface::class => 'evrinoma.'.$this->getAlias().'.repository']);
        $container->addAliases([UserQueryRepositoryInterface::class => 'evrinoma.'.$this->getAlias().'.repository']);
    }

    private function wireFactory(ContainerBuilder $container, string $class, string $paramClass): void
    {
        $container->removeDefinition('evrinoma.'.$this->getAlias().'.factory');
        $definitionFactory = new Definition($class);
        $definitionFactory->addArgument($paramClass);
        $alias = new Alias('evrinoma.'.$this->getAlias().'.factory');
        $container->addDefinitions(['evrinoma.'.$this->getAlias().'.factory' => $definitionFactory]);
        $container->addAliases([$class => $alias]);
    }

    private function wireController(ContainerBuilder $container, string $class): void
    {
        $definitionApiController = $container->getDefinition('evrinoma.'.$this->getAlias().'.api.controller');
        $definitionApiController->setArgument(6, $class);
    }

    private function wireValidator(ContainerBuilder $container, string $class): void
    {
        $definitionApiController = $container->getDefinition('evrinoma.'.$this->getAlias().'.validator');
        $definitionApiController->setArgument(0, new Reference('validator'));
        $definitionApiController->setArgument(1, $class);
    }

    public function getAlias()
    {
        return EvrinomaUserBundle::BUNDLE;
    }
}
