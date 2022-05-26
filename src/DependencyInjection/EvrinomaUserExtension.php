<?php

namespace Evrinoma\UserBundle\DependencyInjection;


use Evrinoma\UserBundle\DependencyInjection\Compiler\Constraint\Property\UserPass;
use Evrinoma\UserBundle\Dto\UserApiDto;
use Evrinoma\UserBundle\EvrinomaUserBundle;
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

//region SECTION: Fields
    public const ENTITY              = 'Evrinoma\UserBundle\Entity';
    public const ENTITY_FACTORY_USER = 'Evrinoma\UserBundle\Factory\UserFactory';
    public const ENTITY_BASE_USER    = self::ENTITY.'\User\BaseUser';
    public const DTO_BASE_USER       = UserApiDto::class;
    /**
     * @var array
     */
    private static array $doctrineDrivers = array(
        'orm' => array(
            'registry' => 'doctrine',
            'tag'      => 'doctrine.event_subscriber',
        ),
    );
//endregion Fields

//region SECTION: Public
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if ($container->getParameter('kernel.environment') !== 'prod') {
            $loader->load('fixtures.yml');
        }

        if ($container->getParameter('kernel.environment') === 'test') {
            $loader->load('tests.yml');
        }

        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);

        if ($config['factory'] !== self::ENTITY_FACTORY_USER) {
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
                    'entity'    => 'evrinoma.'.$this->getAlias().'.entity',
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

        if ($config['decorates']) {
            $this->remapParametersNamespaces(
                $container,
                $config['decorates'],
                [
                    '' => [
                        'command' => 'evrinoma.'.$this->getAlias().'.decorates.command',
                        'query'   => 'evrinoma.'.$this->getAlias().'.decorates.query',
                    ],
                ]
            );
        }
    }

//endregion Public
//region SECTION: Private
    private function wireConstraintTag(ContainerBuilder $container): void
    {
        foreach ($container->getDefinitions() as $key => $definition) {
            switch (true) {
                case strpos($key, UserPass::USER_CONSTRAINT) !== false :
                    $definition->addTag(UserPass::USER_CONSTRAINT);
                    break;
                default:
            }
        }
    }

    private function wireRepository(ContainerBuilder $container, Reference $doctrineRegistry, string $class): void
    {
        $definitionRepository    = $container->getDefinition('evrinoma.'.$this->getAlias().'.repository');
        $definitionQueryMediator = $container->getDefinition('evrinoma.'.$this->getAlias().'.query.mediator');
        $definitionRepository->setArgument(0, $doctrineRegistry);
        $definitionRepository->setArgument(1, $class);
        $definitionRepository->setArgument(2, $definitionQueryMediator);
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
        $definitionApiController->setArgument(5, $class);
    }

    private function wireValidator(ContainerBuilder $container, string $class): void
    {
        $definitionApiController = $container->getDefinition('evrinoma.'.$this->getAlias().'.validator');
        $definitionApiController->setArgument(0, new Reference('validator'));
        $definitionApiController->setArgument(1, $class);
    }
//endregion Private

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return EvrinomaUserBundle::USER_BUNDLE;
    }
//endregion Getters/Setters
}