<?php

namespace Evrinoma\UserBundle\DependencyInjection;

use Evrinoma\UserBundle\EvrinomaUserBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;


class Configuration implements ConfigurationInterface
{
//region SECTION: Getters/Setters
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder      = new TreeBuilder(EvrinomaUserBundle::USER_BUNDLE);
        $rootNode         = $treeBuilder->getRootNode();
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
            //           ->scalarNode('entity')->cannotBeEmpty()->defaultValue(EvrinomaUserExtension::ENTITY_BASE_USER)->end()
            //           ->scalarNode('constraints')->defaultTrue()->info('This option is used for enable/disable basic user constraints')->end()
            ->scalarNode('dto')->cannotBeEmpty()->defaultValue(EvrinomaUserExtension::DTO_BASE_USER)->info('This option is used for dto class override')->end()
            //           ->arrayNode('decorates')->addDefaultsIfNotSet()->children()
            //           ->scalarNode('command')->defaultNull()->info('This option is used for command user decoration')->end()f
            //           ->scalarNode('query')->defaultNull()->info('This option is used for query user decoration')->end()
            ->end()->end()->end();

        return $treeBuilder;
    }
//endregion Getters/Setters
}
