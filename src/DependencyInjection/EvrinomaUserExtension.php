<?php

namespace Evrinoma\UserBundle\DependencyInjection;


use Evrinoma\FcrBundle\DependencyInjection\Compiler\Constraint\Property\FcrPass;
use Evrinoma\FcrBundle\Dto\FcrApiDto;
use Evrinoma\FcrBundle\EvrinomaFcrBundle;
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
    public const ENTITY             = 'Evrinoma\UserBundle\Entity';
    public const ENTITY_FACTORY_USER = 'Evrinoma\UserBundle\Factory\UserFactory';
    public const ENTITY_BASE_USER    = self::ENTITY.'\User';
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
//
//        if ($container->getParameter('kernel.environment') !== 'prod') {
//            $loader->load('fixtures.yml');
//        }

        if ($container->getParameter('kernel.environment') === 'test') {
            $loader->load('tests.yml');
        }

        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return EvrinomaUserBundle::USER_BUNDLE;
    }
//endregion Getters/Setters
}