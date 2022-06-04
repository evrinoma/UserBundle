<?php

namespace Evrinoma\UserBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateUserCommand extends Command
{
//region SECTION: Fields
    protected static $defaultName = 'evrinoma:user:create';
//endregion Fields

//region SECTION: Protected
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName(static::$defaultName)
            ->setDescription('Create a user.')
            ->setDefinition([
                new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                new InputArgument('email', InputArgument::REQUIRED, 'The email'),
                new InputArgument('password', InputArgument::REQUIRED, 'The password'),
                new InputOption('inactive', null, InputOption::VALUE_NONE, 'Set the user as inactive'),
            ])
            ->setHelp(
                <<<'EOT'
The <info>evrinoma:user:create</info> command creates a user:
  <info>php %command.full_name% evrinoma</info>
This interactive shell will ask you for an email and then a password.
You can alternatively specify the email and password as the second and third arguments:
  <info>php %command.full_name% evrinoma evrinoma@example.com mypassword</info>
You can create an inactive user (will not be able to log in):
  <info>php %command.full_name% thibault --inactive</info>
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $email    = $input->getArgument('email');
        $password = $input->getArgument('password');
        $inactive = $input->getOption('inactive');

        $output->writeln(sprintf('Created user <comment>%s</comment>', $username));

        return 0;
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
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

        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }
//endregion Protected
}
