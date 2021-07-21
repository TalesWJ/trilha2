<?php

declare(strict_types=1);

namespace Webjump\HelloWorld\Console\Command;

use \Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class CommandExample extends Command
{
    public const NAME_ARGUMENT = 'name';

    /**
     * @inheritDoc
     */
    protected function configure() : void
    {
        $this->setName('exemplo:comando');
        $this->setDescription('Comando CLI.');
        $this->addOption(
            self::NAME_ARGUMENT,
            null,
            InputOption::VALUE_REQUIRED,
            'Name'
        );

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getOption(self::NAME_ARGUMENT);
        $output->writeln('<info>Hello World! ' . $name . '</info>');
    }
}
