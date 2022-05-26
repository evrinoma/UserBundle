<?php

namespace Evrinoma\UserBundle;

use Evrinoma\UserBundle\DependencyInjection\Compiler\Constraint\Property\UserPass;
use Evrinoma\UserBundle\DependencyInjection\Compiler\MapEntityPass;
use Evrinoma\UserBundle\DependencyInjection\EvrinomaUserExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EvrinomaUserBundle extends Bundle
{
//region SECTION: Fields
    public const USER_BUNDLE = 'user';
//endregion Fields
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new MapEntityPass($this->getNamespace(), $this->getPath()))
            ->addCompilerPass(new UserPass());
    }
//region SECTION: Getters/Setters
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaUserExtension();
        }

        return $this->extension;
    }
//endregion Getters/Setters
}