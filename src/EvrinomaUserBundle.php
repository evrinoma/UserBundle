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

namespace Evrinoma\UserBundle;

use Evrinoma\UserBundle\DependencyInjection\Compiler\Constraint\Property\UserPass;
use Evrinoma\UserBundle\DependencyInjection\Compiler\DecoratorPass;
use Evrinoma\UserBundle\DependencyInjection\Compiler\MapEntityPass;
use Evrinoma\UserBundle\DependencyInjection\Compiler\ServicePass;
use Evrinoma\UserBundle\DependencyInjection\EvrinomaUserExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EvrinomaUserBundle extends Bundle
{
    public const USER_BUNDLE = 'user';

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new MapEntityPass($this->getNamespace(), $this->getPath()))
            ->addCompilerPass(new DecoratorPass())
            ->addCompilerPass(new ServicePass())
            ->addCompilerPass(new UserPass());
    }

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaUserExtension();
        }

        return $this->extension;
    }
}
