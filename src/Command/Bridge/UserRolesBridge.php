<?php

namespace Evrinoma\UserBundle\Command\Bridge;

use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\Command\Dto\Preserve\PreserveUserApiDtoInterface;
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
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserRolesBridge implements BridgeInterface
{

    private const ADMIN_USERNAME = 'admin_username';
    private const ADMIN_PASSWORD = 'admin_password';
    private static string $dtoClass;
    protected string      $username = '';
    protected string      $email    = '';
    protected string      $password = '';
    protected string      $inactive = '';
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
     * @var TokenStorageInterface
     */
    private TokenStorageInterface $tokenStorage;


    /**
     * @param ManagerRegistry         $managerRegistry
     * @param TokenStorageInterface   $tokenStorage
     * @param CommandManagerInterface $commandManager
     * @param QueryManagerInterface   $queryManager
     * @param DtoPreValidator         $preValidator
     * @param string                  $dtoClass
     */
    public function __construct(ManagerRegistry $managerRegistry, TokenStorageInterface $tokenStorage, CommandManagerInterface $commandManager, QueryManagerInterface $queryManager, DtoPreValidator $preValidator, string $dtoClass)
    {
        $this->managerRegistry = $managerRegistry;
        $this->tokenStorage    = $tokenStorage;
        $this->commandManager  = $commandManager;
        $this->queryManager    = $queryManager;
        $this->preValidator    = $preValidator;
        static::$dtoClass      = $dtoClass;
    }


    public function argumentDefinition(): array
    {
        return [
            new InputArgument(self::ADMIN_USERNAME, InputArgument::REQUIRED, 'The admin username'),
            new InputArgument(self::ADMIN_PASSWORD, InputArgument::REQUIRED, 'The admin username'),
            new InputArgument(UserApiDtoInterface::USERNAME, InputArgument::REQUIRED, 'The username'),
            new InputArgument(UserApiDtoInterface::ROLES, InputArgument::IS_ARRAY, 'The roles'),
            new InputOption(UserApiDtoInterface::GRANT_ROLES, null, InputOption::VALUE_NEGATABLE, 'Set or Unset roles'),
        ];
    }

    public function helpMessage(): string
    {
        return <<<'EOT'
The <info>evrinoma:user:role</info> command demotes or promotes a user by removing or adding a role
  <info>php %command.full_name% nikolns ROLE_CUSTOM</info>
  <info>php %command.full_name% --demote</info>
  <info>php %command.full_name% --promote</info>
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
        if (!$input->getArgument(self::ADMIN_USERNAME)) {
            $question = new Question('Please choose admin username:');
            $question->setValidator(function ($adminUsername) {
                if (empty($adminUsername)) {
                    throw new \Exception('Admin username can not be empty');
                }

                return $adminUsername;
            });
            $questions[self::ADMIN_USERNAME] = $question;
        }

        if (!$input->getArgument(self::ADMIN_PASSWORD)) {
            $question = new Question('Please choose admin password:');
            $question->setHidden(true);
            $question->setValidator(function ($adminPassword) {
                if (empty($adminPassword)) {
                    throw new \Exception('Admin password can not be empty');
                }

                return $adminPassword;
            });
            $questions[self::ADMIN_PASSWORD] = $question;
        }

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
                $roles  = explode(" ", $roles);
                $result = array_filter($roles, function ($v) {
                    return trim($v);
                });
                $roles  = array_slice($result, 0);
                if (count($roles) === 0) {
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
            $question = new ConfirmationQuestion('Would you like to set grand?[y]', false);
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

        $dto->setUsername($input->getArgument(self::ADMIN_USERNAME));

        $users = $this->queryManager->criteria($dto);
        if (count($users) != 1) {
            throw  new UserNotFoundException();
        }
        foreach ($users as $user) {
            $this->login($user, $input->getArgument(self::ADMIN_PASSWORD));
        }

        $dto->setUsername($input->getArgument(UserApiDtoInterface::USERNAME));

        $users = $this->queryManager->criteria($dto);
        if (count($users) != 1) {
            throw  new UserNotFoundException();
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
        if (count($roles) > 0) {
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

    private function login($user, $secret): void
    {
        $token = new UsernamePasswordToken(
            $user,
            new AnonymousToken($secret, $user),
            'main'
        );

        $this->tokenStorage->setToken($token);
    }

}