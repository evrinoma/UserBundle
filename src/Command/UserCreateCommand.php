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

namespace Evrinoma\UserBundle\Command;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Exception\UserCannotBeSavedException;
use Evrinoma\UserBundle\Exception\UserInvalidException;
use Evrinoma\UtilsBundle\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserCreateCommand extends AbstractCommand
{
    protected static $defaultName = 'evrinoma:user:create';
    protected static $defaultDescription = 'Create a user.';

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            /** @var UserApiDtoInterface $dto */
            $dto = $this->bridge->argumentToDto($input);
            $this->bridge->action($dto);
            $output->writeln(sprintf('Created user <comment>%s</comment>', $dto->getUsername()));
        } catch (\Exception $e) {
            switch (true) {
                case $e instanceof UserCannotBeSavedException:
                    $output->writeln(sprintf('User <comment>%s</comment> cannot be save', $dto->getUsername()));
                    break;
                case $e instanceof UniqueConstraintViolationException:
                    $output->writeln(sprintf('User <comment>%s</comment> already exists', $dto->getUsername()));
                    break;
                case $e instanceof UserInvalidException:
                    $output->writeln(sprintf('User does\'t have required params User <comment>%s</comment>', $e->getMessage()));
                    break;
                default:
                    $output->writeln('Something went wrong with user');
            }

            return 1;
        }

        return 0;
    }
}
