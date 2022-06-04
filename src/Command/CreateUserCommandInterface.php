<?php

namespace Evrinoma\UserBundle\Command;

use Symfony\Component\Console\Input\InputInterface;

interface CreateUserCommandInterface
{

//region SECTION: Public
    public function configureInputArguments(): array;

    public function configureHelp(): string;

    public function action();

    public function initQuestinarium(InputInterface $input): void;
//endregion Public

//region SECTION: Getters/Setters
    public function getArguments(InputInterface $input);
//endregion Getters/Setters

}
