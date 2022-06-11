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

namespace Evrinoma\UserBundle\DependencyInjection\Compiler;

use Evrinoma\UserBundle\DependencyInjection\EvrinomaUserExtension;
use Evrinoma\UserBundle\Model\User\UserInterface;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractMapEntity;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MapEntityPass extends AbstractMapEntity implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $this->setContainer($container);

        $driver = $container->findDefinition('doctrine.orm.default_metadata_driver');
        $referenceAnnotationReader = new Reference('annotations.reader');

        $this->cleanMetadata($driver, [EvrinomaUserExtension::ENTITY]);

        $entityUser = $container->getParameter('evrinoma.user.entity');
        if ((str_contains($entityUser, EvrinomaUserExtension::ENTITY))) {
            $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/User', '%s/Entity/User');
        }
        $this->addResolveTargetEntity([$entityUser => [UserInterface::class => []]], false);
    }
}
