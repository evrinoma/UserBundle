<?php

namespace Evrinoma\UserBundle\Command\Bridge;

use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\Command\Dto\Preserve\PreserveUserApiDtoInterface;
use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Manager\CommandManagerInterface;
use Evrinoma\UserBundle\PreValidator\DtoPreValidator;
use Evrinoma\UtilsBundle\Command\BridgeInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;

class UserCreateBridge implements BridgeInterface
{
//region SECTION: Fields
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
     * @var ManagerRegistry
     */
    private ManagerRegistry $managerRegistry;
//endregion Fields

//region SECTION: Constructor
    /**
     * @param ManagerRegistry $managerRegistry
     * @param CommandManagerInterface $commandManager
     * @param DtoPreValidator $preValidator
     * @param string $dtoClass
     */
    public function __construct(ManagerRegistry $managerRegistry, CommandManagerInterface $commandManager, DtoPreValidator $preValidator, string $dtoClass)
    {
        $this->managerRegistry = $managerRegistry;
        $this->commandManager  = $commandManager;
        $this->preValidator    = $preValidator;
        static::$dtoClass      = $dtoClass;
    }
//endregion Constructor

//region SECTION: Public
    public function argumentDefinition(): array
    {
        return [
            new InputArgument(UserApiDtoInterface::USERNAME, InputArgument::REQUIRED, 'The username'),
            new InputArgument(UserApiDtoInterface::EMAIL, InputArgument::REQUIRED, 'The email'),
            new InputArgument(UserApiDtoInterface::PASSWORD, InputArgument::REQUIRED, 'The password'),
            new InputArgument(UserApiDtoInterface::NAME, InputArgument::REQUIRED, 'The name'),
            new InputArgument(UserApiDtoInterface::SURNAME, InputArgument::REQUIRED, 'The surname'),
            new InputArgument(UserApiDtoInterface::PATRONYMIC, InputArgument::REQUIRED, 'The patronymic'),
        ];
    }

    public function helpMessage(): string
    {
        return <<<'EOT'
The <info>evrinoma:user:create</info> command creates a user:
  <info>php %command.full_name% evrinoma</info>
This interactive shell will ask you for an email and then a password.
You can alternatively specify the email and password as the second and third arguments:
  <info>php %command.full_name% evrinoma example@example.example mypassword name surname patronymic</info>
EOT;
    }

    public function action(DtoInterface $dto): void
    {
        $this->preValidator->onPost($dto);

        $commandManager = $this->commandManager;

        $em = $this->managerRegistry->getManager();

        $em->transactional(
            function () use ($dto, $commandManager, &$json) {
                $commandManager->post($dto);
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

        if (!$input->getArgument(UserApiDtoInterface::EMAIL)) {
            $question = new Question('Please choose an email:');
            $question->setValidator(function ($email) {
                if (empty($email)) {
                    throw new \Exception('Email can not be empty');
                }

                return $email;
            });
            $questions[UserApiDtoInterface::EMAIL] = $question;
        }

        if (!$input->getArgument(UserApiDtoInterface::PASSWORD)) {
            $question = new Question('Please choose a password:');
            $question->setValidator(function ($password) {
                if (empty($password)) {
                    throw new \Exception('Password can not be empty');
                }

                return $password;
            });
            $question->setHidden(true);
            $questions[UserApiDtoInterface::PASSWORD] = $question;
        }

        if (!$input->getArgument(UserApiDtoInterface::NAME)) {
            $question = new Question('Please choose an name:');
            $question->setValidator(function ($email) {
                if (empty($email)) {
                    throw new \Exception('Name can not be empty');
                }

                return $email;
            });
            $questions[UserApiDtoInterface::NAME] = $question;
        }

        if (!$input->getArgument(UserApiDtoInterface::SURNAME)) {
            $question = new Question('Please choose an surname:');
            $question->setValidator(function ($email) {
                if (empty($email)) {
                    throw new \Exception('Surname can not be empty');
                }

                return $email;
            });
            $questions[UserApiDtoInterface::SURNAME] = $question;
        }

        if (!$input->getArgument(UserApiDtoInterface::PATRONYMIC)) {
            $question = new Question('Please choose an patronymic:');
            $question->setValidator(function ($email) {
                if (empty($email)) {
                    throw new \Exception('Patronymic can not be empty');
                }

                return $email;
            });
            $questions[UserApiDtoInterface::PATRONYMIC] = $question;
        }

        return $questions;
    }

    public function optionQuestioners(InputInterface $input): array
    {
        return [];
    }
//endregion Public

//region SECTION: Dto
    public function argumentToDto(InputInterface $input): DtoInterface
    {
        /** @var PreserveUserApiDtoInterface $dto */
        $dto = new static::$dtoClass();

        $dto
            ->setExpiredAt('')
            ->setUsername($input->getArgument(UserApiDtoInterface::USERNAME))
            ->setEmail($input->getArgument(UserApiDtoInterface::EMAIL))
            ->setPassword($input->getArgument(UserApiDtoInterface::PASSWORD))
            ->setName($input->getArgument(UserApiDtoInterface::NAME))
            ->setSurname($input->getArgument(UserApiDtoInterface::SURNAME))
            ->setPatronymic($input->getArgument(UserApiDtoInterface::PATRONYMIC));

        return $dto;
    }
//endregion SECTION: Dto
}