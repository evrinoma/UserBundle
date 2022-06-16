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

use Evrinoma\UserBundle\EvrinomaUserBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(EvrinomaUserBundle::USER_BUNDLE);
        $rootNode = $treeBuilder->getRootNode();
        $supportedDrivers = ['orm'];

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('db_driver')
            ->validate()
            ->ifNotInArray($supportedDrivers)
            ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
            ->end()
            ->cannotBeOverwritten()
            ->defaultValue('orm')
            ->end()
            ->scalarNode('factory')->cannotBeEmpty()->defaultValue(EvrinomaUserExtension::ENTITY_FACTORY_USER)->end()
            ->scalarNode('entity')->cannotBeEmpty()->defaultValue(EvrinomaUserExtension::ENTITY_BASE_USER)->end()
            ->scalarNode('constraints')->defaultTrue()->info('This option is used for enable/disable basic user constraints')->end()
            ->scalarNode('dto')->cannotBeEmpty()->defaultValue(EvrinomaUserExtension::DTO_BASE_USER)->info('This option is used for dto class override')->end()
            ->scalarNode('preserve_dto')->cannotBeEmpty()->defaultValue(EvrinomaUserExtension::DTO_PRESERVE_BASE_USER)->info('This option is used for preserve_dto class override')->end()
            ->arrayNode('decorates')->addDefaultsIfNotSet()->children()
            ->scalarNode('command')->defaultNull()->info('This option is used for command user decoration')->end()
            ->scalarNode('query')->defaultNull()->info('This option is used for query user decoration')->end()
            ->end()->end()
            ->arrayNode('services')->addDefaultsIfNotSet()->children()
            ->scalarNode('pre_validator')->defaultNull()->info('This option is used for pre_validator overriding')->end()
            ->scalarNode('password_pre_checker')->defaultNull()->info('This option is used for password_pre_checker overriding')->end()
            ->scalarNode('role_mediator')->defaultNull()->info('This option is used for role_mediator overriding')->end()
            ->scalarNode('create_bridge')->defaultNull()->info('This option is used for create_bridge overriding')->end()
            ->scalarNode('role_bridge')->defaultNull()->info('This option is used for role_bridge overriding')->end()
            ->end()->end()
            ->end();

        return $treeBuilder;
    }
}
