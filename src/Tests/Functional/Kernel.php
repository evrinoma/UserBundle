<?php

namespace Evrinoma\UserBundle\Tests\Functional;

use Evrinoma\TestUtilsBundle\Kernel\AbstractApiKernel;

/**
 * Kernel
 */
class Kernel extends AbstractApiKernel
{

    protected string $bundlePrefix = 'UserBundle';
    protected string $rootDir      = __DIR__;


    protected function getBundleConfig(): array
    {
        return ['framework.yaml', 'jms_serializer.yaml'];
    }


    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        return array_merge(parent::registerBundles(), [new \Evrinoma\DtoBundle\EvrinomaDtoBundle(), new \Evrinoma\UserBundle\EvrinomaUserBundle(), new \Symfony\Bundle\SecurityBundle\SecurityBundle()]);
    }

}
