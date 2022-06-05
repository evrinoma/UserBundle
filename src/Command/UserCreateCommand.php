<?php

namespace Evrinoma\UserBundle\Command;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Exception\UserCannotBeSavedException;
use Evrinoma\UserBundle\Exception\UserInvalidException;
use Evrinoma\UtilsBundle\Command\BridgeInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserCreateCommand extends Command
{
//region SECTION: Fields
    protected static $defaultName = 'evrinoma:user:create';

    private BridgeInterface $bridge;
//endregion Fields

//region SECTION: Constructor
    public function __construct(BridgeInterface $bridge)
    {
        $this->bridge = $bridge;
        parent::__construct(static::$defaultName);
    }
//endregion Constructor

//region SECTION: Protected
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName(static::$defaultName)
            ->setDescription('Create a user.')
            ->setDefinition($this->bridge->argumentDefinition())
            ->setHelp($this->bridge->helpMessage());
    }

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
                    $output->writeln(sprintf('User doesn\'t have required params'));
                    break;
                default:
                    $output->writeln(sprintf('Something went wrong with user'));
            }

            return 1;
        }

        return 0;
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->bridge->questioners($input) as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }
//endregion Protected
}
