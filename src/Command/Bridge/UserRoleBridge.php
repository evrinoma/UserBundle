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

namespace Evrinoma\UserBundle\Command\Bridge;

use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\Dto\Preserve\UserApiDtoInterface as PreserveUserApiDtoInterface;
use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Exception\UserNotFoundException;
use Evrinoma\UserBundle\Manager\CommandManagerInterface;
use Evrinoma\UserBundle\Manager\QueryManagerInterface;
use Evrinoma\UserBundle\PreValidator\DtoPreValidator;
use Evrinoma\UtilsBundle\Command\BridgeInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class UserRoleBridge implements BridgeInterface
{
    protected static string $dtoClass;
    /**
     * @var DtoPreValidator
     */
    private DtoPreValidator $preValidator;
    /**
     * @var CommandManagerInterface
     */
    private CommandManagerInterface $commandManager;
    /**
     * @var QueryManagerInterface
     */
    private QueryManagerInterface $queryManager;
    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $managerRegistry;

    /**
     * @param ManagerRegistry         $managerRegistry
     * @param CommandManagerInterface $commandManager
     * @param QueryManagerInterface   $queryManager
     * @param DtoPreValidator         $preValidator
     * @param string                  $dtoClass
     */
    public function __construct(ManagerRegistry $managerRegistry, CommandManagerInterface $commandManager, QueryManagerInterface $queryManager, DtoPreValidator $preValidator, string $dtoClass)
    {
        $this->managerRegistry = $managerRegistry;
        $this->commandManager = $commandManager;
        $this->queryManager = $queryManager;
        $this->preValidator = $preValidator;
        static::$dtoClass = $dtoClass;
    }

    public function argumentDefinition(): array
    {
        return [
            new InputArgument(UserApiDtoInterface::USERNAME, InputArgument::REQUIRED, 'The username'),
            new InputArgument(UserApiDtoInterface::ROLES, InputArgument::IS_ARRAY, 'The roles'),
            new InputOption(UserApiDtoInterface::GRANT_ROLES, null, InputOption::VALUE_NEGATABLE, 'Set or Unset roles'),
        ];
    }

    public function helpMessage(): string
    {
        return <<<'EOT'
The <info>evrinoma:user:role</info> command demotes or promotes a user by removing or adding a role
  <info>php %command.full_name% nikolns ROLE_CUSTOM_A ROLE_CUSTOM_B  --no-grand (--grand)</info>
EOT;
    }

    public function action(DtoInterface $dto): void
    {
        $this->preValidator->onPut($dto);

        $commandManager = $this->commandManager;

        $em = $this->managerRegistry->getManager();

        $em->transactional(
            function () use ($dto, $commandManager, &$json) {
                $commandManager->put($dto);
            }
        );
    }

    public function argumentQuestioners(InputInterface $input): array
    {
        $questions = [];

        if (!$input->getArgument(UserApiDtoInterface::USERNAME)) {
            $question = new Question('Please choose a username:');
            $question->setValidator(function ($username) {
                if (empty($username)) {
                    throw new \Exception('Username can not be empty');
                }

                return $username;
            });
            $questions[UserApiDtoInterface::USERNAME] = $question;
        }

        if (!$input->getArgument(UserApiDtoInterface::ROLES)) {
            $question = new Question('Please add an role:');
            $question->setValidator(function ($roles) {
                $roles = explode(' ', $roles);
                $result = array_filter($roles, function ($v) {
                    return trim($v);
                });
                $roles = \array_slice($result, 0);
                if (0 === \count($roles)) {
                    throw new \Exception('Role can not be empty');
                }

                return $roles;
            });
            $questions[UserApiDtoInterface::ROLES] = $question;
        }

        return $questions;
    }

    public function optionQuestioners(InputInterface $input): array
    {
        $questions = [];

        if (!$input->getOption(UserApiDtoInterface::GRANT_ROLES)) {
            $question = new ConfirmationQuestion('Would you like to set grand?[y/n]', false);
            $question->setValidator(function ($grand) {
                return '--'.($grand ? '' : 'no-').UserApiDtoInterface::GRANT_ROLES;
            });
            $questions[UserApiDtoInterface::GRANT_ROLES] = $question;
        }

        return $questions;
    }

    public function argumentToDto(InputInterface $input): DtoInterface
    {
        /** @var PreserveUserApiDtoInterface $dto */
        $dto = new static::$dtoClass();

        $dto->setUsername($input->getArgument(UserApiDtoInterface::USERNAME));

        $users = $this->queryManager->criteria($dto);
        if (1 != \count($users)) {
            throw new UserNotFoundException();
        }
        foreach ($users as $user) {
            $dto->setId($user->getId())
                ->setSurname($user->getUsername())
                ->setEmail($user->getEmail())
                ->setName($user->getName())
                ->setSurname($user->getSurname())
                ->setPatronymic($user->getPatronymic())
                ->setActive($user->getActive())
                ->setExpiredAt($user->hasExpiredAt() ? $user->getExpiredAt() : '');
        }

        $roles = $input->getArgument(UserApiDtoInterface::ROLES);
        if (\count($roles) > 0) {
            $dto->setRoles($roles);
        }
        $grandRoles = $input->getOption(UserApiDtoInterface::GRANT_ROLES);

        if ($grandRoles === '--'.UserApiDtoInterface::GRANT_ROLES) {
            $dto->setGrant();
        } else {
            $dto->resetGrant();
        }

        return $dto;
    }
}
