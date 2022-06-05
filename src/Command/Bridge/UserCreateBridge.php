<?php

namespace Evrinoma\UserBundle\Command\Bridge;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\Dto\UserApiDto;
use Evrinoma\UtilsBundle\Command\BridgeInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;

class UserCreateBridge implements BridgeInterface
{
//region SECTION: Fields
    protected string $username = '';
    protected string $email    = '';
    protected string $password = '';
    protected string $inactive = '';
//endregion Fields

//region SECTION: Public
    public function argumentDefinition(): array
    {
        return [
            new InputArgument('username', InputArgument::REQUIRED, 'The username'),
            new InputArgument('email', InputArgument::REQUIRED, 'The email'),
            new InputArgument('password', InputArgument::REQUIRED, 'The password'),
            new InputOption('inactive', null, InputOption::VALUE_NONE, 'Set the user as inactive'),
        ];
    }

    public function helpMessage(): string
    {
        return <<<'EOT'
The <info>evrinoma:user:create</info> command creates a user:
  <info>php %command.full_name% evrinoma</info>
This interactive shell will ask you for an email and then a password.
You can alternatively specify the email and password as the second and third arguments:
  <info>php %command.full_name% evrinoma evrinoma@example.com mypassword</info>
You can create an inactive user (will not be able to log in):
  <info>php %command.full_name% thibault --inactive</info>
EOT;
    }

    public function action(DtoInterface $dto): void
    {
    }

    public function questioners(InputInterface $input): array
    {
        $questions = [];
        if (!$input->getArgument('username')) {
            $question = new Question('Please choose a username:');
            $question->setValidator(function ($username) {
                if (empty($username)) {
                    throw new \Exception('Username can not be empty');
                }

                return $username;
            });
            $questions['username'] = $question;
        }

        if (!$input->getArgument('email')) {
            $question = new Question('Please choose an email:');
            $question->setValidator(function ($email) {
                if (empty($email)) {
                    throw new \Exception('Email can not be empty');
                }

                return $email;
            });
            $questions['email'] = $question;
        }

        if (!$input->getArgument('password')) {
            $question = new Question('Please choose a password:');
            $question->setValidator(function ($password) {
                if (empty($password)) {
                    throw new \Exception('Password can not be empty');
                }

                return $password;
            });
            $question->setHidden(true);
            $questions['password'] = $question;
        }

        return $questions;
    }
//endregion Public

//region SECTION: Dto
    public function argumentToDto(InputInterface $input): DtoInterface
    {
        $this->username = $input->getArgument('username');
        $this->email    = $input->getArgument('email');
        $this->password = $input->getArgument('password');
        $this->inactive = $input->getOption('inactive');

        return new UserApiDto();
    }
//endregion SECTION: Dto
}